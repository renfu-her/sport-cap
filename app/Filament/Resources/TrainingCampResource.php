<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingCampResource\Pages;
use App\Filament\Resources\TrainingCampResource\RelationManagers;
use App\Models\TrainingCamp;
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

class TrainingCampResource extends Resource
{
    protected static ?string $model = TrainingCamp::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = '國外移地訓練團';

    protected static ?string $modelLabel = '訓練團';

    protected static ?string $pluralModelLabel = '國外移地訓練團';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = '全球高爾夫管家';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('訓練團資訊')
                    ->tabs([
                        Tab::make('基本資訊')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('訓練團名稱')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\DatePicker::make('start_date')
                                    ->label('開始日期')
                                    ->required(),

                                Forms\Components\DatePicker::make('end_date')
                                    ->label('結束日期')
                                    ->required()
                                    ->afterOrEqual('start_date'),

                                Forms\Components\TextInput::make('country')
                                    ->label('國家')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('city')
                                    ->label('城市')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('venue')
                                    ->label('訓練場地')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('coach')
                                    ->label('教練')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('fee')
                                    ->label('費用')
                                    ->required()
                                    ->numeric()
                                    ->prefix('$'),

                                Forms\Components\TextInput::make('max_participants')
                                    ->label('最大參與人數')
                                    ->numeric()
                                    ->minValue(1),

                                Forms\Components\TextInput::make('current_participants')
                                    ->label('當前參與人數')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0)
                                    ->disabled()
                                    ->dehydrated(),

                                Forms\Components\Textarea::make('description')
                                    ->label('訓練團描述')
                                    ->rows(5),

                                Forms\Components\Toggle::make('is_featured')
                                    ->label('精選訓練團')
                                    ->default(false),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('啟用')
                                    ->default(true),
                            ])
                            ->columns(2),

                        Tab::make('訓練詳情')
                            ->schema([
                                Forms\Components\Repeater::make('schedule')
                                    ->label('訓練安排')
                                    ->schema([
                                        Forms\Components\TextInput::make('day')
                                            ->label('日期/天數')
                                            ->required(),

                                        Forms\Components\Textarea::make('activities')
                                            ->label('活動內容')
                                            ->required(),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                                Forms\Components\Repeater::make('accommodation')
                                    ->label('住宿安排')
                                    ->schema([
                                        Forms\Components\TextInput::make('hotel')
                                            ->label('酒店名稱')
                                            ->required(),

                                        Forms\Components\Textarea::make('details')
                                            ->label('詳細信息')
                                            ->required(),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                                Forms\Components\Repeater::make('transportation')
                                    ->label('交通安排')
                                    ->schema([
                                        Forms\Components\TextInput::make('type')
                                            ->label('交通類型')
                                            ->required(),

                                        Forms\Components\Textarea::make('details')
                                            ->label('詳細信息')
                                            ->required(),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                                Forms\Components\Repeater::make('meals')
                                    ->label('餐飲安排')
                                    ->schema([
                                        Forms\Components\TextInput::make('meal')
                                            ->label('餐食類型')
                                            ->required(),

                                        Forms\Components\Textarea::make('details')
                                            ->label('詳細信息')
                                            ->required(),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                                Forms\Components\Repeater::make('equipment')
                                    ->label('裝備要求')
                                    ->schema([
                                        Forms\Components\TextInput::make('item')
                                            ->label('裝備項目')
                                            ->required(),

                                        Forms\Components\Textarea::make('description')
                                            ->label('描述')
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
                                    ->directory('training-camps')
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
                    ->label('訓練團名稱')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('開始日期')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('結束日期')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('country')
                    ->label('國家')
                    ->searchable(),

                Tables\Columns\TextColumn::make('city')
                    ->label('城市')
                    ->searchable(),

                Tables\Columns\TextColumn::make('venue')
                    ->label('訓練場地')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('coach')
                    ->label('教練')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('fee')
                    ->label('費用')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('current_participants')
                    ->label('參與人數')
                    ->formatStateUsing(
                        fn(TrainingCamp $record): string =>
                        $record->max_participants
                            ? "{$record->current_participants}/{$record->max_participants}"
                            : (string) $record->current_participants
                    ),

                Tables\Columns\TextColumn::make('duration_days')
                    ->label('持續天數')
                    ->getStateUsing(fn(TrainingCamp $record): int => $record->duration_days),

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
                Tables\Filters\Filter::make('date')
                    ->label('日期範圍')
                    ->form([
                        Forms\Components\DatePicker::make('start_from')
                            ->label('開始日期從'),
                        Forms\Components\DatePicker::make('start_until')
                            ->label('開始日期至'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('start_date', '>=', $date),
                            )
                            ->when(
                                $data['start_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('start_date', '<=', $date),
                            );
                    }),

                Tables\Filters\SelectFilter::make('country')
                    ->label('國家')
                    ->options(fn() => TrainingCamp::distinct()->pluck('country', 'country')->toArray()),

                Tables\Filters\SelectFilter::make('is_featured')
                    ->label('精選訓練團')
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
            ->defaultSort('start_date', 'desc');
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
            'index' => Pages\ListTrainingCamps::route('/'),
            'create' => Pages\CreateTrainingCamp::route('/create'),
            'edit' => Pages\EditTrainingCamp::route('/{record}/edit'),
        ];
    }
}
