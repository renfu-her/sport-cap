<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LearningRecord;
use Illuminate\Http\Request;

class LearningRecordController extends Controller
{
    /**
     * 獲取會員的所有學習記錄
     */
    public function index(Request $request)
    {
        // 檢查 session 中是否有會員資料
        if (!session('member_id')) {
            return response()->json([
                'success' => false,
                'message' => '未登入'
            ], 401);
        }

        $records = LearningRecord::with('teachingMethod')
            ->where('member_id', session('member_id'))
            ->orderBy('date', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $records
        ]);
    }

    /**
     * 獲取單一學習記錄詳情
     */
    public function show($id)
    {
        // 檢查 session 中是否有會員資料
        if (!session('member_id')) {
            return response()->json([
                'success' => false,
                'message' => '未登入'
            ], 401);
        }

        $record = LearningRecord::with('teachingMethod')
            ->where('member_id', session('member_id'))
            ->find($id);

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => '找不到此學習記錄'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $record
        ]);
    }
} 