<?php

namespace App\Filament\Resources;

use App\Models\About;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Filament\Resources\AboutResource\Pages;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationLabel = '關於';
    protected static ?string $navigationGroup = '網站內容';

    protected static ?string $modelLabel = '關於';

    protected static ?string $pluralModelLabel = '關於';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('section')
                    ->label('區塊')
                    ->options([
                        'team_mission' => '團隊宗旨',
                        'team_advisor' => '團隊顧問',
                        'team_teacher' => '團隊師資',
                        'teaching_location' => '教學據點',
                        'contact_us' => '與我們聯繫',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->label('標題')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('content')
                    ->label('內容')
                    ->required()
                    ->columnSpanFull()
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsDirectory('about-uploads'),
                Forms\Components\FileUpload::make('image')
                    ->label('圖片')
                    ->image()
                    ->imageEditor()
                    ->directory('about-images')
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

                        $image->scale(width: 1024);

                        $filename = Str::uuid7()->toString() . '.webp';

                        if (!file_exists(storage_path('app/public/about-images'))) {
                            mkdir(storage_path('app/public/about-images'), 0755, true);
                        }

                        $image->toWebp(90)->save(storage_path('app/public/about-images/' . $filename));
                        return 'about-images/' . $filename;
                    })
                    ->deleteUploadedFileUsing(function ($file) {
                        if ($file) {
                            Storage::disk('public')->delete($file);
                        }
                    }),
                Forms\Components\Toggle::make('is_active')
                    ->label('啟用')
                    ->inline(false)
                    ->default(true),
                Forms\Components\TextInput::make('sort_order')
                    ->label('排序')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('section')
                    ->label('區塊')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'team_mission' => '團隊宗旨',
                        'team_advisor' => '團隊顧問',
                        'team_teacher' => '團隊師資',
                        'teaching_location' => '教學據點',
                        'contact_us' => '與我們聯繫',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('title')
                    ->label('標題')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('圖片'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('啟用')
                    ->boolean()
                    ->color(fn(string $state): string => $state ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('排序'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('建立時間')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('section')
                    ->label('區塊')
                    ->options([
                        'team_mission' => '團隊宗旨',
                        'team_advisor' => '團隊顧問',
                        'team_teacher' => '團隊師資',
                        'teaching_location' => '教學據點',
                        'contact_us' => '與我們聯繫',
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
            'index' => Pages\ListAbouts::route('/'),
            'create' => Pages\CreateAbout::route('/create'),
            'edit' => Pages\EditAbout::route('/{record}/edit'),
        ];
    }
}
