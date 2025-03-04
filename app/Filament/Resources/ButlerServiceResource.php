<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ButlerServiceResource\Pages;
use App\Filament\Resources\ButlerServiceResource\RelationManagers;
use App\Models\ButlerService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Collection;

class ButlerServiceResource extends Resource
{
    protected static ?string $model = ButlerService::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = '管家服務';

    protected static ?string $modelLabel = '管家服務';

    protected static ?string $pluralModelLabel = '管家服務';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = '全球高爾夫管家';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('管家服務資訊')
                    ->tabs([
                        Tab::make('基本資訊')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('服務名稱')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\Select::make('type')
                                    ->label('服務類型')
                                    ->options([
                                        'shipping' => '裝備運送',
                                        'ecommerce' => '電商代購',
                                        'itinerary' => '行程規劃',
                                    ])
                                    ->required(),

                                Forms\Components\TextInput::make('price')
                                    ->label('服務價格')
                                    ->numeric()
                                    ->prefix('$'),

                                Forms\Components\Textarea::make('description')
                                    ->label('服務描述')
                                    ->rows(5),

                                Forms\Components\Toggle::make('is_featured')
                                    ->label('精選服務')
                                    ->default(false),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('啟用')
                                    ->default(true),
                            ])
                            ->columns(2),

                        Tab::make('服務詳情')
                            ->schema([
                                Forms\Components\Repeater::make('details')
                                    ->label('服務細節')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('標題')
                                            ->required(),

                                        Forms\Components\Textarea::make('content')
                                            ->label('內容')
                                            ->required(),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                                Forms\Components\Repeater::make('features')
                                    ->label('服務特點')
                                    ->schema([
                                        Forms\Components\TextInput::make('feature')
                                            ->label('特點')
                                            ->required(),

                                        Forms\Components\Textarea::make('description')
                                            ->label('描述')
                                            ->required(),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                                Forms\Components\Repeater::make('process')
                                    ->label('服務流程')
                                    ->schema([
                                        Forms\Components\TextInput::make('step')
                                            ->label('步驟')
                                            ->required(),

                                        Forms\Components\Textarea::make('description')
                                            ->label('描述')
                                            ->required(),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                                Forms\Components\Repeater::make('faqs')
                                    ->label('常見問題')
                                    ->schema([
                                        Forms\Components\TextInput::make('question')
                                            ->label('問題')
                                            ->required(),

                                        Forms\Components\Textarea::make('answer')
                                            ->label('回答')
                                            ->required(),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),
                            ]),

                        Tab::make('圖片')
                            ->schema([
                                FileUpload::make('images')
                                    ->label('相關圖片')
                                    ->multiple()
                                    ->image()
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('1920')
                                    ->imageResizeTargetHeight('1080')
                                    ->directory('butler-services')
                                    ->maxFiles(10),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('服務名稱')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('服務類型')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'shipping' => '裝備運送',
                        'ecommerce' => '電商代購',
                        'itinerary' => '行程規劃',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('服務價格')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('服務描述')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('精選')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('啟用')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('創建時間')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新時間')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('服務類型')
                    ->options([
                        'shipping' => '裝備運送',
                        'ecommerce' => '電商代購',
                        'itinerary' => '行程規劃',
                    ]),

                Tables\Filters\SelectFilter::make('is_featured')
                    ->label('精選服務')
                    ->options([
                        '1' => '是',
                        '0' => '否',
                    ]),

                Tables\Filters\SelectFilter::make('is_active')
                    ->label('啟用狀態')
                    ->options([
                        '1' => '啟用',
                        '0' => '停用',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('查看'),

                    Tables\Actions\EditAction::make()
                        ->label('編輯'),

                    Tables\Actions\DeleteAction::make()
                        ->label('刪除'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('批量刪除'),

                    Tables\Actions\BulkAction::make('toggleFeatured')
                        ->label('切換精選狀態')
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $record->update(['is_featured' => !$record->is_featured]);
                            }
                        }),

                    Tables\Actions\BulkAction::make('toggleActive')
                        ->label('切換啟用狀態')
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $record->update(['is_active' => !$record->is_active]);
                            }
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListButlerServices::route('/'),
            'create' => Pages\CreateButlerService::route('/create'),
            'edit' => Pages\EditButlerService::route('/{record}/edit'),
        ];
    }
}
