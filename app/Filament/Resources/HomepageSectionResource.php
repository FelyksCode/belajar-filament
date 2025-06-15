<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomepageSectionResource\Pages;
use App\Filament\Resources\HomepageSectionResource\RelationManagers;
use App\Models\Category;
use App\Models\HomepageSection;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class HomepageSectionResource extends Resource
{
    protected static ?string $model = HomepageSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Homepage Sections';

    protected static ?string $modelLabel = 'Homepage Section';

    protected static ?string $pluralModelLabel = 'Homepage Sections';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(string $context, $state, Forms\Set $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null),

                TextInput::make('slug')
                    ->required()
                    ->unique(HomepageSection::class, 'slug', ignoreRecord: true),

                Select::make('type')
                    ->required()
                    ->options([
                        'popular' => 'Popular Recipes',
                        'latest' => 'Latest Recipes',
                        'category' => 'Category Based',
                    ])
                    ->live()
                    ->afterStateUpdated(fn(Forms\Set $set) => $set('category_slug', null)),

                Select::make('category_slug')
                    ->label('Category')
                    ->options(fn() => Category::pluck('name', 'slug'))
                    ->visible(fn(Forms\Get $get) => $get('type') === 'category')
                    ->required(fn(Forms\Get $get) => $get('type') === 'category'),

                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(fn() => HomepageSection::max('order') + 1)
                    ->minValue(1),

                TextInput::make('limit')
                    ->required()
                    ->numeric()
                    ->default(4)
                    ->minValue(1)
                    ->maxValue(20)
                    ->helperText('Number of recipes to display in this section'),

                Toggle::make('visible')
                    ->label('Show on Homepage')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->width(60),

                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'popular' => 'success',
                        'latest' => 'info',
                        'category' => 'warning',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'popular' => 'Popular',
                        'latest' => 'Latest',
                        'category' => 'Category',
                    }),

                TextColumn::make('category_slug')
                    ->label('Category')
                    ->getStateUsing(function ($record) {
                        if ($record->type === 'category' && $record->category_slug) {
                            $category = Category::where('slug', $record->category_slug)->first();
                            return $category?->name ?? $record->category_slug;
                        }
                        return '-';
                    })
                    ->placeholder('-'),

                TextColumn::make('limit')
                    ->label('Limit')
                    ->alignCenter(),

                ToggleColumn::make('visible')
                    ->label('Visible')
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->reorderable('order')
            ->defaultSort('order')
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'popular' => 'Popular',
                        'latest' => 'Latest',
                        'category' => 'Category',
                    ]),
                TernaryFilter::make('visible')
                    ->label('Visibility')
                    ->placeholder('All sections')
                    ->trueLabel('Visible sections')
                    ->falseLabel('Hidden sections'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListHomepageSections::route('/'),
            'create' => Pages\CreateHomepageSection::route('/create'),
            'edit' => Pages\EditHomepageSection::route('/{record}/edit'),
        ];
    }
}
