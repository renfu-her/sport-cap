<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * 獲取所有教練資料
     */
    public function index()
    {
        $teachers = About::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $teachers
        ]);
    }

    /**
     * 獲取單一教練詳情
     */
    public function show($id)
    {
        $teacher = About::where('is_active', true)
            ->find($id);

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => '找不到此教練'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $teacher
        ]);
    }
} 