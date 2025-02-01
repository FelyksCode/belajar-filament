<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductMeasurmentResource\Pages;
use App\Filament\Resources\ProductMeasurmentResource\RelationManagers;
use App\Models\Parameter;
use App\Models\ParameterValue;
use App\Models\Product;
use App\Models\ProductMeasurment;
use App\Models\Tool;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Exists;


class ProductMeasurmentResource extends Resource
{
    protected static ?string $model = ProductMeasurment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Measurements';

    protected static ?string $recordTitleAttribute = 'id_barcode';

    protected static ?string $breadcrumb = 'Measurements';


    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\TextInput::make('id_barcode')
                    ->label('Barcode Product')
                    ->required()
                    ->placeholder('Enter a Barcode ID')
                    ->suffixIcon(function ($state) {
                        if ($state && Product::where('id_barcode', $state)->exists()) {
                            return 'heroicon-o-check-circle';
                        }
                        return 'heroicon-o-x-circle';
                    })
                    ->suffixIconColor(function ($state) {
                        if ($state === null) {
                            return 'gray';
                        }

                        if ($state && Product::where('id_barcode', $state)->exists()) {
                            return 'success';
                        }
                        return 'danger';
                    })
                    ->hint(function ($state, $get) {
                        if ($state === null) {
                            return 'Enter a Barcode ID';
                        }

                        if ($state && Product::where('id_barcode', $state)->exists()) {
                            return 'Barcode is valid.';
                        }
                        return 'Barcode does not exist.';
                    })
                    ->hintColor(function ($state) {
                        if ($state === null) {
                            return 'gray';
                        }

                        if ($state && Product::where('id_barcode', $state)->exists()) {
                            return 'success';
                        }
                        return 'danger';
                    })
                    ->columnSpanFull(),

                Forms\Components\Actions::make([
                    Forms\Components\Actions\Action::make('Check Barcode')
                        ->action(function (Forms\Get $get, Forms\Set $set) {
                            $set('isLoading', true);

                            $barcodeExists = Product::where('id_barcode', $get('id_barcode'))->exists();

                            if ($barcodeExists) {

                                $product = Product::where('id_barcode', $get('id_barcode'))->first();

                                $parameters = Parameter::where('product_id', $product->id)->get();

                                $set('infoList', [
                                    'name' => $product->name,
                                    'id_barcode' => $product->id_barcode,
                                    'description' => $product->description,
                                    'type' => $product->type,
                                    'image' => [$product->image],
                                    'parameter_count' => $product->parameters->count(),
                                ]);

                                // Generate dynamic form fields for the parameters
                                $set('dynamicParameterFields', $parameters->map(function ($parameter, $index) {
                                    return [
                                        'id' => $parameter->id,
                                        'name' => 'Parameter ' . ($index + 1),
                                        'min_value' => $parameter->min_value,
                                        'max_value' => $parameter->max_value,
                                    ];
                                }));
                            } else {
                                $set('infoList', []);
                                $set('parameterForms', []);
                            }

                            $set('isLoading', false);
                        })
                        ->disabled(fn($get) => $get('isLoading'))
                        ->color('primary')
                ]),

                // Display the infoList and dynamic forms
                Forms\Components\Section::make('Product Information')
                    ->schema([
                        Forms\Components\TextInput::make('infoList.id_barcode')
                            ->label('Barcode ID')
                            ->disabled(),
                        Forms\Components\TextInput::make('infoList.name')
                            ->label('Product Name')
                            ->disabled(),
                        Forms\Components\TextInput::make('infoList.type')
                            ->label('Product Type')
                            ->disabled(),
                        Forms\Components\TextInput::make('infoList.parameter_count')
                            ->label('Total Parameters')
                            ->disabled(),
                        Forms\Components\FileUpload::make('infoList.image')
                            ->label('Product Image')
                            ->directory('products/images')
                            ->image()
                            ->disabled()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->columnSpanFull(),

                    ])
                    ->columns(4),


                Forms\Components\Section::make('Product Parameters')
                    ->schema(function (Forms\Get $get) {
                        // Retrieve the product based on the entered barcode.
                        $product = Product::where('id_barcode', $get('id_barcode'))->first();
                        // Ensure $parameters is a collection; if no product found, use an empty collection.
                        $parameters = $product ? $product->parameters : collect([]);

                        return [
                            Forms\Components\Repeater::make('parameter_values')
                                ->label('Parameter Values')
                                ->schema(fn() => $parameters->map(
                                    fn($parameter) =>
                                    Forms\Components\TextInput::make("parameter_{$parameter->id}")
                                        ->label($parameter->name)
                                        ->numeric()
                                        ->minValue($parameter->min_value)
                                        ->maxValue($parameter->max_value)
                                )->toArray())
                                ->columns(2)
                                ->defaultItems(1)
                                ->addable(false)
                                ->deletable(false)
                                ->reorderable(false),
                        ];
                    }),

                Forms\Components\Actions::make([
                    Forms\Components\Actions\Action::make('Save Measurements')
                        ->action(function (Forms\Get $get, Forms\Set $set) {
                            $barcode = $get('id_barcode');
                            $product = Product::where('id_barcode', $barcode)->first();

                            if (!$product) {
                                return;
                            }

                            $parameterValues = $get('parameter_values') ?? [];

                            foreach ($parameterValues as $paramId => $value) {
                                // Insert into product_measurements table
                                ProductMeasurement::create([
                                    'product_id' => $product->id,
                                    'parameter_id' => $paramId,
                                ]);

                                // Insert into parameter_values table
                                ParameterValue::create([
                                    'parameter_id' => $paramId,
                                    'value' => $value,
                                ]);
                            }

                            $set('infoList', []);
                            $set('parameter_values', []);
                        })
                        ->disabled(fn($get) => empty($get('parameter_values')))
                        ->color('success'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListProductMeasurments::route('/'),
            'create' => Pages\CreateProductMeasurment::route('/create'),
            'edit' => Pages\EditProductMeasurment::route('/{record}/edit'),
        ];
    }
}
