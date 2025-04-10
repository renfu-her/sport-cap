<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Filament\Resources\MemberResource\RelationManagers;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = '使用者管理';

    protected static ?string $navigationLabel = '會員管理';

    protected static ?string $modelLabel = '會員';

    protected static ?string $pluralModelLabel = '會員';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('基本資料')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('姓名')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('電子郵件')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->validationMessages([
                                'unique' => '此電子郵件已經被註冊，請使用其他電子郵件。',
                            ])
                            ->live()
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                if (empty($state)) {
                                    return;
                                }

                                $existingMember = Member::where('email', $state)->first();
                                if ($existingMember && $get('id') !== $existingMember->id) {
                                    Notification::make()
                                        ->title('電子郵件已被註冊')
                                        ->body('此電子郵件已經被其他會員使用，請使用其他電子郵件。')
                                        ->danger()
                                        ->send();
                                }
                            }),
                        Forms\Components\TextInput::make('password')
                            ->label('密碼')
                            ->password()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->maxLength(255)
                            ->validationMessages([
                                'min' => '密碼長度至少為 8 個字符。',
                            ]),
                        Forms\Components\TextInput::make('phone')
                            ->label('電話')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\DatePicker::make('birthday')
                            ->label('生日')
                            ->displayFormat('Y/m/d'),
                        Forms\Components\Textarea::make('address')
                            ->label('地址')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('會員資料')
                    ->schema([
                        Forms\Components\Select::make('membership_type')
                            ->label('會員類型')
                            ->options([
                                'basic' => '基本會員',
                                'premium' => '高級會員',
                                'vip' => 'VIP會員',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('membership_start_date')
                            ->label('會員開始日期')
                            ->displayFormat('Y/m/d'),
                        Forms\Components\DatePicker::make('membership_end_date')
                            ->label('會員結束日期')
                            ->displayFormat('Y/m/d')
                            ->afterOrEqual('membership_start_date'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('啟用狀態')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('其他資訊')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('備註')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('姓名')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('電子郵件')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('電話')
                    ->searchable(),
                Tables\Columns\TextColumn::make('membership_type')
                    ->label('會員類型')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'basic' => '基本會員',
                        'premium' => '高級會員',
                        'vip' => 'VIP會員',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('membership_start_date')
                    ->label('開始日期')
                    ->date('Y/m/d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('membership_end_date')
                    ->label('結束日期')
                    ->date('Y/m/d')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('啟用')
                    ->boolean()
                    ->sortable()
                    ->color(fn(string $state): string => $state ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('建立時間')
                    ->dateTime('Y/m/d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('membership_type')
                    ->label('會員類型')
                    ->options([
                        'basic' => '基本會員',
                        'premium' => '高級會員',
                        'vip' => 'VIP會員',
                    ]),
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
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
