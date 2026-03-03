<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveApplicationResource\Pages;
use App\Models\LeaveApplication;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeaveApplicationResource extends Resource
{
    protected static ?string $model = LeaveApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Leave Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)
                ->schema([

                    /** --------------------------
                     * LEFT COLUMN — EMPLOYEE DETAILS
                     * -------------------------- */
                    Forms\Components\Group::make([
                        Forms\Components\Section::make('Employee Information')
                            ->description('Employee, department, and reporting details')
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->label('Employee')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        $user = User::find($state);
                                        if ($user) {
                                            $set('department_id', $user->department_id);
                                            $set('line_manager_id', $user->line_manager_id);
                                        }
                                    }),

                                Forms\Components\Placeholder::make('phone_number')
                                    ->label('Phone Number')
                                    ->content(fn ($get) => optional(User::find($get('user_id')))->phone_number ?? 'N/A'),

                                Forms\Components\Select::make('department_id')
                                    ->label('Department')
                                    ->relationship('department', 'name')
                                    ->disabled()
                                    ->preload(),

                                Forms\Components\Select::make('line_manager_id')
                                    ->label('Line Manager')
                                    ->relationship('lineManager', 'name')
                                    ->disabled()
                                    ->preload(),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make('Leave Details')
                            ->description('Leave type, duration, and reason')
                            ->schema([
                                Forms\Components\Select::make('leave_id')
                                    ->label('Leave Type')
                                    ->relationship('leave', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),

                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\DatePicker::make('start_date')
                                            ->required()
                                            ->reactive(),

                                        Forms\Components\DatePicker::make('end_date')
                                            ->required()
                                            ->reactive()
                                            ->afterStateUpdated(function (callable $set, callable $get, $state) {
                                                $start = $get('start_date');
                                                if ($start && $state) {
                                                    $days = Carbon::parse($start)->diffInDays(Carbon::parse($state)) + 1;
                                                    $set('total_days', $days);
                                                }
                                            }),

                                        Forms\Components\TextInput::make('total_days')
                                            ->label('Total Days')
                                            ->numeric()
                                            ->required()
                                            ->readOnly(),
                                    ]),

                                Forms\Components\Textarea::make('reason')
                                    ->label('Reason for Leave')
                                    ->rows(3),

                                Forms\Components\FileUpload::make('documents')
                                    ->label('Supporting Documents')
                                    ->disk('public')
                                    ->multiple(),
                                // ->maxFiles(5)
                                // ->accept('pdf,jpg,jpeg,png')
                                // ->required(),

                            ])
                            ->columns(2),
                    ]),

                    /** --------------------------
                     * RIGHT COLUMN — APPROVAL SECTION
                     * -------------------------- */
                    Forms\Components\Group::make([
                        Forms\Components\Section::make('Approval Details')
                            ->description('Approval and managerial information')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->default('pending')
                                    ->required(),

                                Forms\Components\Select::make('approved_by')
                                    ->label('Approved By')
                                    ->relationship('approver', 'name')
                                    ->searchable()
                                    ->preload(),

                                Forms\Components\Textarea::make('manager_remark')
                                    ->label('Manager Remark')
                                    ->rows(3),

                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\DateTimePicker::make('applied_at')
                                            ->label('Applied At')
                                            ->disabled(),

                                        Forms\Components\DateTimePicker::make('approved_timestamp')
                                            ->label('Approved At')
                                            ->disabled(),
                                    ]),
                            ]),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Employee')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('department.name')->label('Department')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('leave.name')->label('Leave Type')->sortable(),
                Tables\Columns\TextColumn::make('lineManager.name')->label('Line Manager')->sortable(),
                Tables\Columns\TextColumn::make('start_date')->date(),
                Tables\Columns\TextColumn::make('end_date')->date(),
                Tables\Columns\TextColumn::make('total_days'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'gray' => 'cancelled',
                    ])
                    ->label('Status'),
                Tables\Columns\TextColumn::make('approver.name')->label('Approved By')->sortable(),
            ])
            ->defaultSort('applied_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeaveApplications::route('/'),
            'create' => Pages\CreateLeaveApplication::route('/create'),
            'edit' => Pages\EditLeaveApplication::route('/{record}/edit'),
        ];
    }
}
