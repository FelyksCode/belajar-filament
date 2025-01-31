<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OperatorResource\Pages;
use App\Filament\Resources\OperatorResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Gate;

class OperatorResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Operators';

    protected static ?string $recordTitleAttribute = 'username';

    protected static ?string $breadcrumb = 'Operators';

    public static function form(Form $form): Form
    {
        $isCreate = $form->getOperation() === "create";

        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('username')->required(),
                Forms\Components\TextInput::make('id_employee')->label("ID Employee")->required(),
                Forms\Components\TextInput::make('password')
                    ->password()  // This ensures the input is treated as a password field
                    ->helperText($isCreate
                        ? false
                        : 'Leave empty to keep the current password.')
                    ->required($isCreate),
                Forms\Components\Hidden::make('role')->default('operator')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(User::where('role', '=', 'operator'))
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('role'),
                Tables\Columns\TextColumn::make('password'),

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
            'index' => Pages\ListOperators::route('/'),
            'create' => Pages\CreateOperator::route('/create'),
            'edit' => Pages\EditOperator::route('/{record}/edit'),
        ];
    }
}
