<?php

namespace App\Http\Controllers;

use App\Models\LearningRecord;
use App\Models\Member;
use App\Models\TeachingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LearningRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $learningRecords = LearningRecord::with(['member', 'teachingMethod'])
            ->orderBy('attendance_date', 'desc')
            ->paginate(10);

        return view('learning_records.index', compact('learningRecords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = Member::where('is_active', true)->get();
        $teachingMethods = TeachingMethod::where('is_active', true)->get();

        return view('learning_records.create', compact('members', 'teachingMethods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|exists:members,id',
            'teaching_method_id' => 'required|exists:teaching_methods,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:attended,absent,late',
            'duration_minutes' => 'nullable|integer|min:1',
            'progress_notes' => 'nullable|string',
            'teacher_feedback' => 'nullable|string',
            'member_feedback' => 'nullable|string',
            'is_completed' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 檢查教學方式是否為團體班，如果是，檢查是否已滿
        $teachingMethod = TeachingMethod::findOrFail($request->teaching_method_id);
        if (
            $teachingMethod->isGroup() &&
            $teachingMethod->max_participants !== null &&
            $teachingMethod->current_participants >= $teachingMethod->max_participants
        ) {
            return redirect()->back()
                ->with('error', '此團體班已滿，無法添加更多學習記錄')
                ->withInput();
        }

        // 創建學習記錄
        $learningRecord = LearningRecord::create($request->all());

        // 如果是團體班，增加當前參與人數
        if ($teachingMethod->isGroup()) {
            $teachingMethod->increment('current_participants');
        }

        return redirect()->route('learning_records.index')
            ->with('success', '學習記錄創建成功');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $learningRecord = LearningRecord::with(['member', 'teachingMethod'])->findOrFail($id);

        return view('learning_records.show', compact('learningRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $learningRecord = LearningRecord::findOrFail($id);
        $members = Member::where('is_active', true)->get();
        $teachingMethods = TeachingMethod::where('is_active', true)->get();

        return view('learning_records.edit', compact('learningRecord', 'members', 'teachingMethods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|exists:members,id',
            'teaching_method_id' => 'required|exists:teaching_methods,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:attended,absent,late',
            'duration_minutes' => 'nullable|integer|min:1',
            'progress_notes' => 'nullable|string',
            'teacher_feedback' => 'nullable|string',
            'member_feedback' => 'nullable|string',
            'is_completed' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $learningRecord = LearningRecord::findOrFail($id);

        // 檢查是否更改了教學方式
        $oldTeachingMethodId = $learningRecord->teaching_method_id;
        $newTeachingMethodId = $request->teaching_method_id;

        if ($oldTeachingMethodId != $newTeachingMethodId) {
            // 檢查新的教學方式是否為團體班，如果是，檢查是否已滿
            $newTeachingMethod = TeachingMethod::findOrFail($newTeachingMethodId);
            if (
                $newTeachingMethod->isGroup() &&
                $newTeachingMethod->max_participants !== null &&
                $newTeachingMethod->current_participants >= $newTeachingMethod->max_participants
            ) {
                return redirect()->back()
                    ->with('error', '此團體班已滿，無法更改為此教學方式')
                    ->withInput();
            }

            // 更新舊教學方式的參與人數
            $oldTeachingMethod = TeachingMethod::findOrFail($oldTeachingMethodId);
            if ($oldTeachingMethod->isGroup()) {
                $oldTeachingMethod->decrement('current_participants');
            }

            // 更新新教學方式的參與人數
            if ($newTeachingMethod->isGroup()) {
                $newTeachingMethod->increment('current_participants');
            }
        }

        $learningRecord->update($request->all());

        return redirect()->route('learning_records.index')
            ->with('success', '學習記錄更新成功');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $learningRecord = LearningRecord::findOrFail($id);

        // 如果是團體班，減少當前參與人數
        $teachingMethod = TeachingMethod::findOrFail($learningRecord->teaching_method_id);
        if ($teachingMethod->isGroup()) {
            $teachingMethod->decrement('current_participants');
        }

        $learningRecord->delete();

        return redirect()->route('learning_records.index')
            ->with('success', '學習記錄刪除成功');
    }

    /**
     * 顯示會員的學習記錄
     */
    public function memberRecords(string $memberId)
    {
        $member = Member::findOrFail($memberId);
        $learningRecords = LearningRecord::with('teachingMethod')
            ->where('member_id', $memberId)
            ->orderBy('attendance_date', 'desc')
            ->paginate(10);

        return view('learning_records.member_records', compact('member', 'learningRecords'));
    }
}
