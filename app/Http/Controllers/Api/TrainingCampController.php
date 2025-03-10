<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrainingCamp;
use Illuminate\Http\Request;

class TrainingCampController extends Controller
{
    /**
     * 獲取所有訓練營
     */
    public function index(Request $request)
    {
        $query = TrainingCamp::where('is_active', true);

        // 排序
        $sortBy = $request->input('sort_by', 'start_date');
        $sortOrder = $request->input('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $trainingCamps = $query->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $trainingCamps
        ]);
    }

    /**
     * 獲取單一訓練營詳情
     */
    public function show($id)
    {
        $trainingCamp = TrainingCamp::where('is_active', true)
            ->find($id);

        if (!$trainingCamp) {
            return response()->json([
                'success' => false,
                'message' => '找不到此訓練營'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $trainingCamp
        ]);
    }

    /**
     * 獲取即將開始的訓練營
     */
    public function upcoming()
    {
        $trainingCamps = TrainingCamp::where('is_active', true)
            ->where('start_date', '>', now())
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $trainingCamps
        ]);
    }
} 