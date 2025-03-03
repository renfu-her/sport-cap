<?php

namespace App\Filament\Resources;

use App\Models\TeachingMethod;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class TeachingMethodResource extends Resource
{
    protected static ?string $model = TeachingMethod::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = '教學方式';
    protected static ?string $navigationGroup = '網站內容';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('類型')
                    ->options([
                        'individual' => '個練課程',
                        'group' => '團體班',
                        'learning_record' => '學習紀錄',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->label('標題')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description')
                    ->label('描述')
                    ->required(),
                Forms\Components\FileUpload::make('images')
                    ->label('圖片')
                    ->image()
                    ->multiple()
                    ->disk('public')
                    ->directory('teaching-images'),
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('開始日期')
                    ->visible(fn(callable $get) => in_array($get('type'), ['individual', 'group'])),
                Forms\Components\DateTimePicker::make('end_date')
                    ->label('結束日期')
                    ->visible(fn(callable $get) => in_array($get('type'), ['individual', 'group'])),
                Forms\Components\TextInput::make('price')
                    ->label('價格')
                    ->numeric()
                    ->visible(fn(callable $get) => in_array($get('type'), ['individual', 'group'])),
                Forms\Components\TextInput::make('location')
                    ->label('地點')
                    ->visible(fn(callable $get) => in_array($get('type'), ['individual', 'group'])),
                Forms\Components\Toggle::make('members_only')
                    ->label('僅會員可見')
                    ->default(false),
                Forms\Components\Toggle::make('is_active')
                    ->label('啟用')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('類型')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'individual' => '個練課程',
                        'group' => '團體班',
                        'learning_record' => '學習紀錄',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('title')
                    ->label('標題')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('開始日期')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('結束日期')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('price')
                    ->label('價格')
                    ->money('TWD'),
                Tables\Columns\IconColumn::make('members_only')
                    ->label('僅會員可見')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('啟用')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('建立時間')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('類型')
                    ->options([
                        'individual' => '個練課程',
                        'group' => '團體班',
                        'learning_record' => '學習紀錄',
                    ]),
                Tables\Filters\TernaryFilter::make('members_only')
                    ->label('僅會員可見'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('啟用狀態'),
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
            'index' => ListRecords::route('/'),
            'create' => CreateRecord::route('/create'),
            'edit' => EditRecord::route('/{record}/edit'),
        ];
    }

    // 只有會員可以建立內容
    public static function canCreate(): bool
    {
        return auth()->check() && auth()->user()->hasRole('member');
    }

    // 只有內容建立者或管理員可以編輯
    public static function canEdit(Model $record): bool
    {
        return auth()->check() &&
            (auth()->user()->id === $record->user_id ||
                auth()->user()->hasRole('admin'));
    }
}
