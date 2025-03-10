<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeachingMethod;
use Illuminate\Http\Request;

class TeachingMethodController extends Controller
{
    /**
     * 獲取所有教學方式
     */
    public function index(Request $request)
    {
        $query = TeachingMethod::with('teacher')
            ->where('is_active', true);

        // 篩選類型
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // 排序
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $teachingMethods = $query->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $teachingMethods
        ]);
    }

    /**
     * 獲取單一教學方式詳情
     */
    public function show($id)
    {
        $teachingMethod = TeachingMethod::with('teacher')
            ->where('is_active', true)
            ->find($id);

        if (!$teachingMethod) {
            return response()->json([
                'success' => false,
                'message' => '找不到此教學方式'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $teachingMethod
        ]);
    }

    /**
     * 獲取熱門教學方式
     */
    public function popular()
    {
        $teachingMethods = TeachingMethod::with('teacher')
            ->where('is_active', true)
            ->orderBy('current_participants', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $teachingMethods
        ]);
    }
} 