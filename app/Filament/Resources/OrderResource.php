<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Member;
use App\Models\TeachingMethod;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = '訂單管理';

    protected static ?string $modelLabel = '訂單';

    protected static ?string $pluralModelLabel = '訂單';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('訂單資訊')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->label('訂單編號')
                            ->default(fn () => Order::generateOrderNumber())
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                        
                        Forms\Components\Select::make('member_id')
                            ->label('會員')
                            ->relationship('member', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        
                        Forms\Components\Select::make('teaching_method_id')
                            ->label('課程/教學方式')
                            ->relationship('teachingMethod', 'title')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                if ($state) {
                                    $teachingMethod = TeachingMethod::find($state);
                                    if ($teachingMethod) {
                                        // 使用 SiteSetting 計算價格和稅金
                                        $priceData = SiteSetting::calculateTax($teachingMethod->price);
                                        $set('price', $priceData['price']);
                                        $set('tax', $priceData['tax']);
                                        $set('sub_total', $priceData['sub_total']);
                                        $set('total', $priceData['total']);
                                    }
                                }
                            }),
                        
                        Forms\Components\TextInput::make('price')
                            ->label('價格')
                            ->numeric()
                            ->prefix('NT$')
                            ->required(),
                        
                        Forms\Components\TextInput::make('tax')
                            ->label('稅金')
                            ->numeric()
                            ->prefix('NT$')
                            ->default(0),
                        
                        Forms\Components\TextInput::make('sub_total')
                            ->label('小計')
                            ->numeric()
                            ->prefix('NT$')
                            ->required(),
                        
                        Forms\Components\TextInput::make('total')
                            ->label('總計')
                            ->numeric()
                            ->prefix('NT$')
                            ->required(),
                    ]),
                
                Forms\Components\Section::make('付款資訊')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('訂單狀態')
                            ->options([
                                'pending' => '待處理',
                                'processing' => '處理中',
                                'completed' => '已完成',
                                'cancelled' => '已取消',
                            ])
                            ->default('pending')
                            ->required(),
                        
                        Forms\Components\Select::make('payment_method')
                            ->label('付款方式')
                            ->options([
                                'credit_card' => '信用卡',
                                'bank_transfer' => '銀行轉帳',
                                'cash' => '現金',
                                'line_pay' => 'Line Pay',
                            ]),
                        
                        Forms\Components\Select::make('payment_status')
                            ->label('付款狀態')
                            ->options([
                                'pending' => '待付款',
                                'paid' => '已付款',
                                'failed' => '付款失敗',
                                'refunded' => '已退款',
                            ])
                            ->default('pending')
                            ->required(),
                        
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
                Tables\Columns\TextColumn::make('order_number')
                    ->label('訂單編號')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('member.name')
                    ->label('會員')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('teachingMethod.title')
                    ->label('課程/教學方式')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('total')
                    ->label('總計')
                    ->money('TWD')
                    ->sortable(),
                
                Tables\Columns\SelectColumn::make('status')
                    ->label('訂單狀態')
                    ->options([
                        'pending' => '待處理',
                        'processing' => '處理中',
                        'completed' => '已完成',
                        'cancelled' => '已取消',
                    ])
                    ->sortable(),
                
                Tables\Columns\SelectColumn::make('payment_status')
                    ->label('付款狀態')
                    ->options([
                        'pending' => '待付款',
                        'paid' => '已付款',
                        'failed' => '付款失敗',
                        'refunded' => '已退款',
                    ])
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('建立時間')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('訂單狀態')
                    ->options([
                        'pending' => '待處理',
                        'processing' => '處理中',
                        'completed' => '已完成',
                        'cancelled' => '已取消',
                    ]),
                
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('付款狀態')
                    ->options([
                        'pending' => '待付款',
                        'paid' => '已付款',
                        'failed' => '付款失敗',
                        'refunded' => '已退款',
                    ]),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
} 