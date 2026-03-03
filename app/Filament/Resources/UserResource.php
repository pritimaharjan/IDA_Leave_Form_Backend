<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                // Forms\Components\TextInput::make('password')
                //     ->password()
                //     ->readOnly()
                //     ->default(fn ($context) => $context === 'create' ? null : '********')
                //     ->required(fn ($context) => $context === 'create')
                //     ->dehydrated(fn ($state) => filled($state)),
                Forms\Components\TextInput::make('user_id')
                    ->label('Employee ID')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->maxLength(20),
                Forms\Components\TextInput::make('designation')
                    ->maxLength(100),
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('line_manager_id')
                    ->label('Line Manager')
                    ->relationship('lineManager', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->default('active')
                    ->required(),

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('user_id')->label('Employee ID')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('phone_number')->sortable(),
                Tables\Columns\TextColumn::make('designation')->sortable(),
                Tables\Columns\TextColumn::make('department.name')->label('Department')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('status')->sortable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
