<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveApplicationResource\Pages;
use App\Models\LeaveApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeaveApplicationResource extends Resource
{
    protected static ?string $model = LeaveApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Employee')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('leave_type_id')
                    ->relationship('leaveType', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('line_manager_id')
                    ->label('Line Manager')
                    ->relationship('lineManager', 'name')
                    ->searchable(),

                Forms\Components\DatePicker::make('start_date')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->required(),

                Forms\Components\TextInput::make('total_days')
                    ->numeric()
                    ->required(),

                Forms\Components\Textarea::make('reason'),

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
                    ->searchable(),

                Forms\Components\Textarea::make('manager_remark'),

                Forms\Components\DateTimePicker::make('applied_at')->disabled(),
                Forms\Components\DateTimePicker::make('approved_timestamp')->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Employee')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('department.name')->label('Department')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('leaveType.name')->label('Leave Type')->sortable(),
                Tables\Columns\TextColumn::make('lineManager.name')->label('Line Manager')->sortable(),
                Tables\Columns\TextColumn::make('start_date')->date(),
                Tables\Columns\TextColumn::make('end_date')->date(),
                Tables\Columns\TextColumn::make('total_days'),
                Tables\Columns\TextColumn::make('status')->sortable(),
                Tables\Columns\TextColumn::make('approved_by')->label('Approved By')->sortable(),
            ])
            ->filters([
                //
            ])
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
        return [
            //
        ];
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
