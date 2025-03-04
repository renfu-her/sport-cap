<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TournamentResource\Pages;
use App\Filament\Resources\TournamentResource\RelationManagers;
use App\Models\Tournament;
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

class TournamentResource extends Resource
{
    protected static ?string $model = Tournament::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationLabel = '賽事團';

    protected static ?string $modelLabel = '賽事';

    protected static ?string $pluralModelLabel = '賽事團';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = '全球高爾夫管家';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('賽事資訊')
                    ->tabs([
                        Tab::make('基本資訊')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('賽事名稱')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\Select::make('type')
                                    ->label('賽事類型')
                                    ->options([
                                        'international' => '國際賽事',
                                        'domestic' => '國內賽事',
                                    ])
                                    ->required(),

                                Forms\Components\Select::make('category')
                                    ->label('賽事類別')
                                    ->options([
                                        'img' => 'IMG',
                                        'sdjga' => 'SDJGA',
                                        'scpga' => 'SCPGA',
                                        'cga' => '中華高協',
                                        'holiday' => '假日年度賽事',
                                    ])
                                    ->visible(fn(callable $get) => $get('type') !== null),

                                Forms\Components\DatePicker::make('start_date')
                                    ->label('開始日期')
                                    ->required(),

                                Forms\Components\DatePicker::make('end_date')
                                    ->label('結束日期')
                                    ->required()
                                    ->afterOrEqual('start_date'),

                                Forms\Components\TextInput::make('location')
                                    ->label('舉辦地點')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('organizer')
                                    ->label('主辦單位')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('entry_fee')
                                    ->label('報名費用')
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
                                    ->label('賽事描述')
                                    ->rows(5),

                                Forms\Components\Toggle::make('is_featured')
                                    ->label('精選賽事')
                                    ->default(false),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('啟用')
                                    ->default(true),
                            ])
                            ->columns(2),

                        Tab::make('賽事詳情')
                            ->schema([
                                Forms\Components\Repeater::make('schedule')
                                    ->label('賽程安排')
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

                                Forms\Components\Repeater::make('requirements')
                                    ->label('參賽要求')
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

                                Forms\Components\Repeater::make('prizes')
                                    ->label('獎項設置')
                                    ->schema([
                                        Forms\Components\TextInput::make('place')
                                            ->label('名次')
                                            ->required(),

                                        Forms\Components\TextInput::make('prize')
                                            ->label('獎品/獎金')
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
                                    ->directory('tournaments')
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
                    ->label('賽事名稱')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('賽事類型')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'international' => '國際賽事',
                        'domestic' => '國內賽事',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('賽事類別')
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'img' => 'IMG',
                        'sdjga' => 'SDJGA',
                        'scpga' => 'SCPGA',
                        'cga' => '中華高協',
                        'holiday' => '假日年度賽事',
                        default => $state ?? '',
                    }),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('開始日期')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('結束日期')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('舉辦地點')
                    ->searchable(),

                Tables\Columns\TextColumn::make('current_participants')
                    ->label('參與人數')
                    ->formatStateUsing(
                        fn(Tournament $record): string =>
                        $record->max_participants
                            ? "{$record->current_participants}/{$record->max_participants}"
                            : (string) $record->current_participants
                    ),

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
                    ->label('賽事類型')
                    ->options([
                        'international' => '國際賽事',
                        'domestic' => '國內賽事',
                    ]),

                Tables\Filters\SelectFilter::make('category')
                    ->label('賽事類別')
                    ->options([
                        'img' => 'IMG',
                        'sdjga' => 'SDJGA',
                        'scpga' => 'SCPGA',
                        'cga' => '中華高協',
                        'holiday' => '假日年度賽事',
                    ]),

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

                Tables\Filters\SelectFilter::make('is_featured')
                    ->label('精選賽事')
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
            'index' => Pages\ListTournaments::route('/'),
            'create' => Pages\CreateTournament::route('/create'),
            'edit' => Pages\EditTournament::route('/{record}/edit'),
        ];
    }
}
