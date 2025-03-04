@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>學習記錄列表</span>
                        <a href="{{ route('learning-records.create') }}" class="btn btn-primary btn-sm">新增學習記錄</a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>會員</th>
                                        <th>課程類型</th>
                                        <th>課程名稱</th>
                                        <th>出席日期</th>
                                        <th>狀態</th>
                                        <th>時長(分鐘)</th>
                                        <th>是否完成</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($learningRecords as $record)
                                        <tr>
                                            <td>{{ $record->id }}</td>
                                            <td>
                                                <a href="{{ route('members.learning-records', $record->member_id) }}">
                                                    {{ $record->member->name }}
                                                </a>
                                            </td>
                                            <td>
                                                @if ($record->teachingMethod->type == 'individual')
                                                    個人課程
                                                @elseif ($record->teachingMethod->type == 'group')
                                                    團體班
                                                @else
                                                    其他
                                                @endif
                                            </td>
                                            <td>{{ $record->teachingMethod->title }}</td>
                                            <td>{{ $record->attendance_date->format('Y-m-d') }}</td>
                                            <td>
                                                @if ($record->status == 'attended')
                                                    <span class="badge bg-success">出席</span>
                                                @elseif ($record->status == 'absent')
                                                    <span class="badge bg-danger">缺席</span>
                                                @elseif ($record->status == 'late')
                                                    <span class="badge bg-warning">遲到</span>
                                                @endif
                                            </td>
                                            <td>{{ $record->duration_minutes ?? '-' }}</td>
                                            <td>
                                                @if ($record->is_completed)
                                                    <span class="badge bg-success">已完成</span>
                                                @else
                                                    <span class="badge bg-secondary">未完成</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('learning-records.show', $record->id) }}"
                                                        class="btn btn-info btn-sm">查看</a>
                                                    <a href="{{ route('learning-records.edit', $record->id) }}"
                                                        class="btn btn-primary btn-sm">編輯</a>
                                                    <form action="{{ route('learning-records.destroy', $record->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('確定要刪除此學習記錄嗎？');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">刪除</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">暫無學習記錄</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $learningRecords->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
