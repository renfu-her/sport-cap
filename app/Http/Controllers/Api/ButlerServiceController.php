<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ButlerService;
use Illuminate\Http\Request;

class ButlerServiceController extends Controller
{
    /**
     * 獲取所有管家服務
     */
    public function index(Request $request)
    {
        $query = ButlerService::where('is_active', true);

        // 排序
        $sortBy = $request->input('sort_by', 'sort_order');
        $sortOrder = $request->input('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $services = $query->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $services
        ]);
    }

    /**
     * 獲取單一管家服務詳情
     */
    public function show($id)
    {
        $service = ButlerService::where('is_active', true)
            ->find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => '找不到此管家服務'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $service
        ]);
    }
} 