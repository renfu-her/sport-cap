<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LearningRecordResource\Pages;
use App\Filament\Resources\LearningRecordResource\RelationManagers;
use App\Models\LearningRecord;
use App\Models\Member;
use App\Models\TeachingMethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;

class LearningRecordResource extends Resource
{
    protected static ?string $model = LearningRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = '學習記錄';

    protected static ?string $modelLabel = '學習記錄';

    protected static ?string $pluralModelLabel = '學習記錄';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = '教學管理';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('基本信息')
                    ->schema([
                        Forms\Components\Select::make('member_id')
                            ->label('會員')
                            ->relationship('member', 'name')
                            ->options(
                                Member::where('is_active', true)
                                    ->get()
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('姓名')
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->label('電子郵件')
                                    ->email()
                                    ->unique(),
                                Forms\Components\TextInput::make('phone')
                                    ->label('電話'),
                                Forms\Components\Select::make('membership_type')
                                    ->label('會員類型')
                                    ->options([
                                        'basic' => '基本會員',
                                        'premium' => '高級會員',
                                        'vip' => 'VIP會員',
                                    ])
                                    ->default('basic')
                                    ->required(),
                            ]),

                        Forms\Components\Select::make('teaching_method_id')
                            ->label('教學方式')
                            ->relationship('teachingMethod', 'title')
                            ->options(function () {
                                $methods = TeachingMethod::where('is_active', true)->get();
                                $options = [];

                                foreach ($methods as $method) {
                                    $type = $method->type === 'individual' ? '個人課程' : '團體班';
                                    $capacity = '';

                                    if ($method->type === 'group' && $method->max_participants) {
                                        $capacity = " ({$method->current_participants}/{$method->max_participants})";
                                    }

                                    $options[$method->id] = "{$method->title} - {$type}{$capacity}";
                                }

                                return $options;
                            })
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\DatePicker::make('attendance_date')
                            ->label('出席日期')
                            ->default(now())
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('出席狀態')
                            ->options([
                                'attended' => '出席',
                                'absent' => '缺席',
                                'late' => '遲到',
                            ])
                            ->default('attended')
                            ->required(),

                        Forms\Components\TextInput::make('duration_minutes')
                            ->label('學習時長（分鐘）')
                            ->numeric()
                            ->minValue(1),

                        Forms\Components\Toggle::make('is_completed')
                            ->label('已完成')
                            ->default(false)
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('詳細記錄')
                    ->schema([
                        Forms\Components\Textarea::make('progress_notes')
                            ->label('學習進度備註')
                            ->rows(3),

                        Forms\Components\Textarea::make('teacher_feedback')
                            ->label('教師反饋')
                            ->rows(3),

                        Forms\Components\Textarea::make('member_feedback')
                            ->label('會員反饋')
                            ->rows(3),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('member.name')
                    ->label('會員')
                    ->searchable()
                    ->sortable()
                    ->url(fn($record) => route('filament.backend.resources.members.edit', ['record' => $record->member_id]))
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('teachingMethod.title')
                    ->label('課程名稱')
                    ->searchable()
                    ->sortable()
                    ->limit(20)
                    ->tooltip(fn($record) => $record->teachingMethod->title),

                Tables\Columns\TextColumn::make('teachingMethod.type')
                    ->label('課程類型')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'individual' => '個人課程',
                        'group' => '團體班',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('attendance_date')
                    ->label('出席日期')
                    ->date('Y-m-d')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('出席狀態')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'attended' => '出席',
                        'absent' => '缺席',
                        'late' => '遲到',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'attended' => 'success',
                        'absent' => 'danger',
                        'late' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('時長(分鐘)')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_completed')
                    ->label('已完成')
                    ->onColor('success')
                    ->offColor('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('創建時間')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新時間')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('出席狀態')
                    ->options([
                        'attended' => '出席',
                        'absent' => '缺席',
                        'late' => '遲到',
                    ]),

                Tables\Filters\SelectFilter::make('is_completed')
                    ->label('完成狀態')
                    ->options([
                        '1' => '已完成',
                        '0' => '未完成',
                    ]),

                Tables\Filters\SelectFilter::make('member')
                    ->label('會員')
                    ->relationship('member', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('teaching_method')
                    ->label('教學方式')
                    ->relationship('teachingMethod', 'title')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('attendance_date')
                    ->label('出席日期')
                    ->form([
                        Forms\Components\DatePicker::make('attendance_from')
                            ->label('從'),
                        Forms\Components\DatePicker::make('attendance_until')
                            ->label('至'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['attendance_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('attendance_date', '>=', $date),
                            )
                            ->when(
                                $data['attendance_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('attendance_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('查看')
                        ->icon('heroicon-o-eye'),

                    Tables\Actions\EditAction::make()
                        ->label('編輯')
                        ->icon('heroicon-o-pencil'),

                    Tables\Actions\DeleteAction::make()
                        ->label('刪除')
                        ->icon('heroicon-o-trash'),

                    Tables\Actions\Action::make('editStatus')
                        ->label('更改狀態')
                        ->icon('heroicon-o-pencil-square')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('出席狀態')
                                ->options([
                                    'attended' => '出席',
                                    'absent' => '缺席',
                                    'late' => '遲到',
                                ])
                                ->required(),
                        ])
                        ->action(function (LearningRecord $record, array $data): void {
                            $record->update(['status' => $data['status']]);

                            Notification::make()
                                ->title('狀態已更新')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\Action::make('markCompleted')
                        ->label('標記為已完成')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(function (LearningRecord $record) {
                            $record->update(['is_completed' => true]);

                            Notification::make()
                                ->title('學習記錄已標記為完成')
                                ->success()
                                ->send();
                        })
                        ->visible(fn(LearningRecord $record) => !$record->is_completed),

                    Tables\Actions\Action::make('markIncomplete')
                        ->label('標記為未完成')
                        ->icon('heroicon-o-x-mark')
                        ->color('danger')
                        ->action(function (LearningRecord $record) {
                            $record->update(['is_completed' => false]);

                            Notification::make()
                                ->title('學習記錄已標記為未完成')
                                ->success()
                                ->send();
                        })
                        ->visible(fn(LearningRecord $record) => $record->is_completed),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('批量刪除')
                        ->icon('heroicon-o-trash')
                        ->color('danger'),

                    Tables\Actions\BulkAction::make('markAsCompleted')
                        ->label('批量標記為已完成')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                $record->update(['is_completed' => true]);
                            });

                            Notification::make()
                                ->title('學習記錄已批量標記為完成')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('markAsIncomplete')
                        ->label('批量標記為未完成')
                        ->icon('heroicon-o-x-mark')
                        ->color('danger')
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                $record->update(['is_completed' => false]);
                            });

                            Notification::make()
                                ->title('學習記錄已批量標記為未完成')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('attendance_date', 'desc')
            ->paginated([10, 25, 50, 100])
            ->poll('60s'); // 每60秒自動刷新一次
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
            'index' => Pages\ListLearningRecords::route('/'),
            'create' => Pages\CreateLearningRecord::route('/create'),
            'edit' => Pages\EditLearningRecord::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['member', 'teachingMethod'])
            ->latest('attendance_date');
    }
}
