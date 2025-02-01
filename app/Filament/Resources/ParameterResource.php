<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParameterResource\Pages;
use App\Filament\Resources\ParameterResource\RelationManagers;
use App\Models\Product;
use App\Models\Parameter;
use App\Models\Tool;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Gate;

class ParameterResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Parameter';

    protected static ?string $recordTitleAttribute = 'id_barcode';

    protected static ?string $breadcrumb = 'Parameter';

    public static function canAccess(): bool
    {
        $user = auth()->user();
        return Gate::allows('isAdmin', $user) || Gate::allows('isDeveloper', $user);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Product Information')
                    ->columnSpan('full') // Expand the section to full width
                    ->schema([
                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\TextInput::make('id_barcode')
                                    ->label('Barcode ID')
                                    ->unique(ignoreRecord: true)
                                    ->required(),

                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->label('Product Name'),

                                Forms\Components\TextInput::make('type')
                                    ->required()
                                    ->label('Product Type'),

                                Forms\Components\Placeholder::make('parameters_count')
                                    ->label('Total Parameters')
                                    ->content(fn(callable $get) => count($get('parameters') ?? []))
                                    ->extraAttributes([
                                        'class' => 'block w-full px-3 py-2 border border-gray-300 bg-gray-100 text-gray-700 rounded-md shadow-sm'
                                    ]),

                                Forms\Components\Hidden::make('description')
                                    ->label('Product Description')
                                    ->default('')
                                    ->nullable(),
                            ]),

                        Forms\Components\FileUpload::make('image')
                            ->label('Product Image')
                            ->directory('products/images')
                            ->image()
                            ->required(),


                        // Parameters Section
                        Forms\Components\Repeater::make('parameters')
                            ->relationship('parameters')
                            ->schema([
                                Forms\Components\Select::make('tool_id')
                                    ->label('Tool')
                                    ->relationship('tool', 'name', fn(Builder $query) => $query->orderBy('name'))
                                    ->preload()
                                    ->searchable()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->label('Tool Name'),
                                    ])
                                    ->required()
                                    ->reactive(),

                                Forms\Components\TextInput::make('min_value')
                                    ->label('Min Value')
                                    ->numeric()
                                    ->required(),
                                Forms\Components\TextInput::make('max_value')
                                    ->label('Max Value')
                                    ->numeric()
                                    ->required(),
                                Forms\Components\TextInput::make('unit')
                                    ->label('Unit')
                                    ->default('mm')
                                    ->required(),


                            ])
                            ->label('Parameters')
                            ->minItems(1)
                            ->maxItems(20)
                            ->defaultItems(3)
                            ->collapsible()
                            ->addActionLabel('Add Another Parameter')
                            ->columns(4)
                            ->itemLabel(
                                fn(array $state): ?string =>
                                isset($state['tool_id'])
                                    ? 'Tool: ' . Tool::find($state['tool_id'])?->name . ' | Min: ' . rtrim(rtrim(number_format($state['min_value'] ?? 0, 5), '0'), '.') . " " . $state["unit"] . ' | Max: ' . rtrim(rtrim(number_format($state['max_value'] ?? 0, 5), '0'), '.') . " " . $state["unit"]
                                    : 'New Parameter'
                            )
                            ->reactive()
                    ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->query(Product::query()->withCount('parameters'))
            ->columns([
                // Display the product barcode (id_barcode)
                Tables\Columns\TextColumn::make('id_barcode')
                    ->label('Barcode ID')
                    ->searchable()
                    ->sortable(),

                // Display the product name
                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable(),

                // Display the product type
                Tables\Columns\TextColumn::make('type')
                    ->label('Product Type')
                    ->searchable()
                    ->sortable(),

                // Display the image with a thumbnail
                Tables\Columns\ImageColumn::make('image')
                    ->label('Product Image')
                    ->size(50),

                // Display the number of parameters for each product
                Tables\Columns\TextColumn::make('parameters_count')
                    ->label('Total Parameters')
                    ->sortable()
                    ->formatStateUsing(fn($record) => $record->parameters_count),

            ])
            ->filters([
                // Filter by type
                Tables\Filters\SelectFilter::make('type')
                    ->label('Type')
                    ->searchable()
                    ->multiple()
                    ->options(function () {
                        return Product::pluck('type', 'type')->unique()->toArray();
                    }),
            ])
            ->actions([
                // Define the edit action for each row
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                // Define a delete bulk action
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->poll('5s');
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
            'index' => Pages\ListParameters::route('/'),
            'create' => Pages\CreateParameter::route('/create'),
            'view' => Pages\ViewParameter::route('/{record}'),
            'edit' => Pages\EditParameter::route('/{record}/edit'),
        ];
    }
}
