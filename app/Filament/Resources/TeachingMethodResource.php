<?php

namespace App\Filament\Resources;

use App\Models\TeachingMethod;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Filament\Resources\TeachingMethodResource\Pages;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;

class TeachingMethodResource extends Resource
{
    protected static ?string $model = TeachingMethod::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = '教學方式';
    protected static ?string $navigationGroup = '課程管理';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('講師')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('type')
                    ->label('類型')
                    ->options([
                        'individual' => '個人課程',
                        'group' => '團體課程',
                        'learning_record' => '學習記錄',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->label('標題')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description')
                    ->label('描述')
                    ->required()
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsDirectory('teaching-method-uploads'),
                Forms\Components\FileUpload::make('images')
                    ->label('圖片')
                    ->image()
                    ->multiple()
                    ->disk('public')
                    ->directory('teaching-method-images'),
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('開始日期'),
                Forms\Components\DateTimePicker::make('end_date')
                    ->label('結束日期')
                    ->after('start_date'),
                Forms\Components\TextInput::make('price')
                    ->label('價格')
                    ->numeric()
                    ->prefix('NT$'),
                Forms\Components\TextInput::make('location')
                    ->label('地點')
                    ->maxLength(255),
                Forms\Components\Toggle::make('members_only')
                    ->label('僅會員')
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
                Tables\Columns\TextColumn::make('user.name')
                    ->label('講師')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('類型')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'individual' => '個人課程',
                        'group' => '團體課程',
                        'learning_record' => '學習記錄',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('title')
                    ->label('標題')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('價格')
                    ->money('TWD'),
                Tables\Columns\TextColumn::make('location')
                    ->label('地點'),
                Tables\Columns\IconColumn::make('members_only')
                    ->label('僅會員')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('啟用')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('建立時間')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('類型')
                    ->options([
                        'individual' => '個人課程',
                        'group' => '團體課程',
                        'learning_record' => '學習記錄',
                    ]),
                Tables\Filters\TernaryFilter::make('members_only')
                    ->label('僅會員'),
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
            'index' => Pages\ListTeachingMethods::route('/'),
            'create' => Pages\CreateTeachingMethod::route('/create'),
            'edit' => Pages\EditTeachingMethod::route('/{record}/edit'),
        ];
    }
}
