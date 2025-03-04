@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>學習記錄詳情</span>
                        <div>
                            <a href="{{ route('learning-records.edit', $learningRecord->id) }}"
                                class="btn btn-primary btn-sm">編輯</a>
                            <a href="{{ route('learning-records.index') }}" class="btn btn-secondary btn-sm">返回列表</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>基本信息</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $learningRecord->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>會員</th>
                                        <td>
                                            <a href="{{ route('members.learning-records', $learningRecord->member_id) }}">
                                                {{ $learningRecord->member->name }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>會員類型</th>
                                        <td>{{ $learningRecord->member->membership_type }}</td>
                                    </tr>
                                    <tr>
                                        <th>課程類型</th>
                                        <td>
                                            @if ($learningRecord->teachingMethod->type == 'individual')
                                                個人課程
                                            @elseif ($learningRecord->teachingMethod->type == 'group')
                                                團體班
                                            @else
                                                其他
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>課程名稱</th>
                                        <td>{{ $learningRecord->teachingMethod->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>出席日期</th>
                                        <td>{{ $learningRecord->attendance_date->format('Y-m-d') }}</td>
                                    </tr>
                                    <tr>
                                        <th>出席狀態</th>
                                        <td>
                                            @if ($learningRecord->status == 'attended')
                                                <span class="badge bg-success">出席</span>
                                            @elseif ($learningRecord->status == 'absent')
                                                <span class="badge bg-danger">缺席</span>
                                            @elseif ($learningRecord->status == 'late')
                                                <span class="badge bg-warning">遲到</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>學習時長</th>
                                        <td>{{ $learningRecord->duration_minutes ?? '-' }} 分鐘</td>
                                    </tr>
                                    <tr>
                                        <th>是否完成</th>
                                        <td>
                                            @if ($learningRecord->is_completed)
                                                <span class="badge bg-success">已完成</span>
                                            @else
                                                <span class="badge bg-secondary">未完成</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>創建時間</th>
                                        <td>{{ $learningRecord->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>更新時間</th>
                                        <td>{{ $learningRecord->updated_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>課程信息</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>課程描述</th>
                                        <td>{{ $learningRecord->teachingMethod->description }}</td>
                                    </tr>
                                    <tr>
                                        <th>課程地點</th>
                                        <td>{{ $learningRecord->teachingMethod->location ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>課程價格</th>
                                        <td>{{ $learningRecord->teachingMethod->price ?? '-' }}</td>
                                    </tr>
                                    @if ($learningRecord->teachingMethod->type == 'group')
                                        <tr>
                                            <th>參與人數</th>
                                            <td>{{ $learningRecord->teachingMethod->current_participants }}/{{ $learningRecord->teachingMethod->max_participants ?? '不限' }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>課程開始日期</th>
                                        <td>{{ $learningRecord->teachingMethod->start_date ? $learningRecord->teachingMethod->start_date->format('Y-m-d') : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>課程結束日期</th>
                                        <td>{{ $learningRecord->teachingMethod->end_date ? $learningRecord->teachingMethod->end_date->format('Y-m-d') : '-' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h5>學習記錄詳情</h5>
                                <div class="card mb-3">
                                    <div class="card-header">學習進度備註</div>
                                    <div class="card-body">
                                        {{ $learningRecord->progress_notes ?? '無' }}
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header">教師反饋</div>
                                    <div class="card-body">
                                        {{ $learningRecord->teacher_feedback ?? '無' }}
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">會員反饋</div>
                                    <div class="card-body">
                                        {{ $learningRecord->member_feedback ?? '無' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
