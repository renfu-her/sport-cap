@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>新增學習記錄</span>
                        <a href="{{ route('learning-records.index') }}" class="btn btn-secondary btn-sm">返回列表</a>
                    </div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('learning-records.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="member_id" class="form-label">會員</label>
                                <select class="form-select @error('member_id') is-invalid @enderror" id="member_id"
                                    name="member_id" required>
                                    <option value="">請選擇會員</option>
                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}"
                                            {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }} ({{ $member->membership_type }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="teaching_method_id" class="form-label">教學方式</label>
                                <select class="form-select @error('teaching_method_id') is-invalid @enderror"
                                    id="teaching_method_id" name="teaching_method_id" required>
                                    <option value="">請選擇教學方式</option>
                                    <optgroup label="個人課程">
                                        @foreach ($teachingMethods->where('type', 'individual') as $method)
                                            <option value="{{ $method->id }}"
                                                {{ old('teaching_method_id') == $method->id ? 'selected' : '' }}>
                                                {{ $method->title }} (個人課程)
                                            </option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="團體班">
                                        @foreach ($teachingMethods->where('type', 'group') as $method)
                                            <option value="{{ $method->id }}"
                                                {{ old('teaching_method_id') == $method->id ? 'selected' : '' }}>
                                                {{ $method->title }} (團體班 -
                                                {{ $method->current_participants }}/{{ $method->max_participants ?? '不限' }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('teaching_method_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="attendance_date" class="form-label">出席日期</label>
                                <input type="date" class="form-control @error('attendance_date') is-invalid @enderror"
                                    id="attendance_date" name="attendance_date"
                                    value="{{ old('attendance_date', date('Y-m-d')) }}" required>
                                @error('attendance_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">出席狀態</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="attended" {{ old('status') == 'attended' ? 'selected' : '' }}>出席
                                    </option>
                                    <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>缺席</option>
                                    <option value="late" {{ old('status') == 'late' ? 'selected' : '' }}>遲到</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="duration_minutes" class="form-label">學習時長（分鐘）</label>
                                <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror"
                                    id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes') }}"
                                    min="1">
                                @error('duration_minutes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="progress_notes" class="form-label">學習進度備註</label>
                                <textarea class="form-control @error('progress_notes') is-invalid @enderror" id="progress_notes" name="progress_notes"
                                    rows="3">{{ old('progress_notes') }}</textarea>
                                @error('progress_notes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="teacher_feedback" class="form-label">教師反饋</label>
                                <textarea class="form-control @error('teacher_feedback') is-invalid @enderror" id="teacher_feedback"
                                    name="teacher_feedback" rows="3">{{ old('teacher_feedback') }}</textarea>
                                @error('teacher_feedback')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="member_feedback" class="form-label">會員反饋</label>
                                <textarea class="form-control @error('member_feedback') is-invalid @enderror" id="member_feedback"
                                    name="member_feedback" rows="3">{{ old('member_feedback') }}</textarea>
                                @error('member_feedback')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input @error('is_completed') is-invalid @enderror"
                                    id="is_completed" name="is_completed" value="1"
                                    {{ old('is_completed') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_completed">已完成</label>
                                @error('is_completed')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">保存</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
