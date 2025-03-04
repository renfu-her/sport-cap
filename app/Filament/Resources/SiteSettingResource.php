<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Filament\Resources\SiteSettingResource\RelationManagers;
use App\Models\SiteSetting;
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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationLabel = '網站設定';

    protected static ?string $modelLabel = '網站設定';

    protected static ?string $pluralModelLabel = '網站設定';

    protected static ?int $navigationSort = 100;

    protected static ?string $navigationGroup = '系統管理';

    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('網站設定')
                    ->tabs([
                        Tab::make('基本設定')
                            ->schema([
                                Forms\Components\TextInput::make('site_name')
                                    ->label('網站名稱')
                                    ->required()
                                    ->maxLength(255)
                                    ->default('全球高爾夫管家'),

                                Forms\Components\TextInput::make('site_title')
                                    ->label('網站標題')
                                    ->required()
                                    ->maxLength(255)
                                    ->default('全球高爾夫管家 - 專業高爾夫服務'),

                                Forms\Components\Textarea::make('site_description')
                                    ->label('網站描述')
                                    ->rows(3)
                                    ->default('全球高爾夫管家提供專業的賽事團、國外移地訓練團和管家服務，為高爾夫愛好者提供全方位的支持。'),

                                Forms\Components\Textarea::make('site_keywords')
                                    ->label('網站關鍵詞')
                                    ->rows(2)
                                    ->helperText('多個關鍵詞請用逗號分隔')
                                    ->default('高爾夫,賽事,訓練,管家服務,球袋運送,電商,行程規劃'),
                            ])
                            ->columns(2),

                        Tab::make('Logo 和圖標')
                            ->schema([
                                FileUpload::make('site_logo')
                                    ->label('網站 Logo')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('site-settings')
                                    ->columnSpanFull()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->downloadable()
                                    ->openable()
                                    ->getUploadedFileNameForStorageUsing(
                                        fn($file): string => (string) str(Str::uuid7() . '.webp')
                                    )
                                    ->saveUploadedFileUsing(function ($file) {
                                        $manager = new ImageManager(new Driver());
                                        $image = $manager->read($file);

                                        $image->scale(width: 300);

                                        $filename = Str::uuid7()->toString() . '.webp';

                                        if (!file_exists(storage_path('app/public/site-settings'))) {
                                            mkdir(storage_path('app/public/site-settings'), 0755, true);
                                        }

                                        $image->toWebp(90)->save(storage_path('app/public/site-settings/' . $filename));
                                        return 'site-settings/' . $filename;
                                    })
                                    ->deleteUploadedFileUsing(function ($file) {
                                        if ($file) {
                                            Storage::disk('public')->delete($file);
                                        }
                                    })
                                    ->helperText('建議尺寸：300x100 像素'),

                                FileUpload::make('site_logo_dark')
                                    ->label('深色模式 Logo')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('site-settings')
                                    ->columnSpanFull()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->downloadable()
                                    ->openable()
                                    ->getUploadedFileNameForStorageUsing(
                                        fn($file): string => (string) str(Str::uuid7() . '.webp')
                                    )
                                    ->saveUploadedFileUsing(function ($file) {
                                        $manager = new ImageManager(new Driver());
                                        $image = $manager->read($file);

                                        $image->scale(width: 300);

                                        $filename = Str::uuid7()->toString() . '.webp';

                                        if (!file_exists(storage_path('app/public/site-settings'))) {
                                            mkdir(storage_path('app/public/site-settings'), 0755, true);
                                        }

                                        $image->toWebp(90)->save(storage_path('app/public/site-settings/' . $filename));
                                        return 'site-settings/' . $filename;
                                    })
                                    ->deleteUploadedFileUsing(function ($file) {
                                        if ($file) {
                                            Storage::disk('public')->delete($file);
                                        }
                                    })
                                    ->helperText('建議尺寸：300x100 像素'),

                                FileUpload::make('site_favicon')
                                    ->label('網站 Favicon')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('site-settings')
                                    ->columnSpanFull()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/x-icon'])
                                    ->downloadable()
                                    ->openable()
                                    ->getUploadedFileNameForStorageUsing(
                                        fn($file): string => (string) str(Str::uuid7() . '.webp')
                                    )
                                    ->saveUploadedFileUsing(function ($file) {
                                        $manager = new ImageManager(new Driver());
                                        $image = $manager->read($file);

                                        $image->resize(32, 32);

                                        $filename = Str::uuid7()->toString() . '.webp';

                                        if (!file_exists(storage_path('app/public/site-settings'))) {
                                            mkdir(storage_path('app/public/site-settings'), 0755, true);
                                        }

                                        $image->toWebp(90)->save(storage_path('app/public/site-settings/' . $filename));
                                        return 'site-settings/' . $filename;
                                    })
                                    ->deleteUploadedFileUsing(function ($file) {
                                        if ($file) {
                                            Storage::disk('public')->delete($file);
                                        }
                                    })
                                    ->helperText('建議尺寸：32x32 像素'),

                                FileUpload::make('site_og_image')
                                    ->label('Open Graph 圖片')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('site-settings')
                                    ->columnSpanFull()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->downloadable()
                                    ->openable()
                                    ->getUploadedFileNameForStorageUsing(
                                        fn($file): string => (string) str(Str::uuid7() . '.webp')
                                    )
                                    ->saveUploadedFileUsing(function ($file) {
                                        $manager = new ImageManager(new Driver());
                                        $image = $manager->read($file);

                                        $image->resize(1200, 630);

                                        $filename = Str::uuid7()->toString() . '.webp';

                                        if (!file_exists(storage_path('app/public/site-settings'))) {
                                            mkdir(storage_path('app/public/site-settings'), 0755, true);
                                        }

                                        $image->toWebp(90)->save(storage_path('app/public/site-settings/' . $filename));
                                        return 'site-settings/' . $filename;
                                    })
                                    ->deleteUploadedFileUsing(function ($file) {
                                        if ($file) {
                                            Storage::disk('public')->delete($file);
                                        }
                                    })
                                    ->helperText('建議尺寸：1200x630 像素'),

                                FileUpload::make('site_twitter_image')
                                    ->label('Twitter 圖片')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('site-settings')
                                    ->columnSpanFull()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->downloadable()
                                    ->openable()
                                    ->getUploadedFileNameForStorageUsing(
                                        fn($file): string => (string) str(Str::uuid7() . '.webp')
                                    )
                                    ->saveUploadedFileUsing(function ($file) {
                                        $manager = new ImageManager(new Driver());
                                        $image = $manager->read($file);

                                        $image->resize(1200, 630);

                                        $filename = Str::uuid7()->toString() . '.webp';

                                        if (!file_exists(storage_path('app/public/site-settings'))) {
                                            mkdir(storage_path('app/public/site-settings'), 0755, true);
                                        }

                                        $image->toWebp(90)->save(storage_path('app/public/site-settings/' . $filename));
                                        return 'site-settings/' . $filename;
                                    })
                                    ->deleteUploadedFileUsing(function ($file) {
                                        if ($file) {
                                            Storage::disk('public')->delete($file);
                                        }
                                    })
                                    ->helperText('建議尺寸：1200x630 像素'),
                            ])
                            ->columns(2),

                        Tab::make('聯繫信息')
                            ->schema([
                                Forms\Components\TextInput::make('contact_email')
                                    ->label('聯繫郵箱')
                                    ->email()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('contact_phone')
                                    ->label('聯繫電話')
                                    ->tel()
                                    ->maxLength(255),

                                Forms\Components\Textarea::make('contact_address')
                                    ->label('聯繫地址')
                                    ->rows(3),
                            ])
                            ->columns(2),

                        Tab::make('社交媒體')
                            ->schema([
                                Forms\Components\TextInput::make('facebook_url')
                                    ->label('Facebook 鏈接')
                                    ->url()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('instagram_url')
                                    ->label('Instagram 鏈接')
                                    ->url()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('twitter_url')
                                    ->label('Twitter 鏈接')
                                    ->url()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('youtube_url')
                                    ->label('YouTube 鏈接')
                                    ->url()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('line_url')
                                    ->label('Line 鏈接')
                                    ->url()
                                    ->maxLength(255),
                            ])
                            ->columns(2),

                        Tab::make('頁腳設定')
                            ->schema([
                                Forms\Components\Textarea::make('footer_text')
                                    ->label('頁腳文字')
                                    ->rows(3),

                                Forms\Components\Textarea::make('footer_copyright')
                                    ->label('頁腳版權信息')
                                    ->rows(3)
                                    ->default('© ' . date('Y') . ' 全球高爾夫管家. 版權所有.'),
                            ])
                            ->columns(2),

                        Tab::make('分析和追蹤')
                            ->schema([
                                Forms\Components\Textarea::make('google_analytics_code')
                                    ->label('Google Analytics 代碼')
                                    ->rows(5),

                                Forms\Components\Textarea::make('facebook_pixel_code')
                                    ->label('Facebook Pixel 代碼')
                                    ->rows(5),
                            ])
                            ->columns(2),

                        Tab::make('自定義代碼')
                            ->schema([
                                Forms\Components\Textarea::make('custom_css')
                                    ->label('自定義 CSS')
                                    ->rows(10),

                                Forms\Components\Textarea::make('custom_js')
                                    ->label('自定義 JavaScript')
                                    ->rows(10),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site_name')
                    ->label('網站名稱')
                    ->searchable(),

                Tables\Columns\TextColumn::make('contact_email')
                    ->label('聯繫郵箱')
                    ->searchable(),

                Tables\Columns\TextColumn::make('contact_phone')
                    ->label('聯繫電話')
                    ->searchable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新時間')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
