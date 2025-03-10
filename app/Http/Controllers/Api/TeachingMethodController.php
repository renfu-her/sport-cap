<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeachingMethod;
use App\Models\SiteSetting;
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
        
        // 為每個教學方式添加價格和稅金信息
        $items = [];
        foreach ($teachingMethods->items() as $teachingMethod) {
            $item = $teachingMethod->toArray();
            $priceData = SiteSetting::calculateTax($teachingMethod->price);
            $item['price_details'] = [
                'price' => $priceData['price'],
                'tax' => $priceData['tax'],
                'sub_total' => $priceData['sub_total'],
                'total' => $priceData['total'],
                'tax_included' => SiteSetting::get('tax_type') === 'included',
            ];
            $items[] = $item;
        }

        $result = [
            'current_page' => $teachingMethods->currentPage(),
            'data' => $items,
            'first_page_url' => $teachingMethods->url(1),
            'from' => $teachingMethods->firstItem(),
            'last_page' => $teachingMethods->lastPage(),
            'last_page_url' => $teachingMethods->url($teachingMethods->lastPage()),
            'next_page_url' => $teachingMethods->nextPageUrl(),
            'path' => $teachingMethods->path(),
            'per_page' => $teachingMethods->perPage(),
            'prev_page_url' => $teachingMethods->previousPageUrl(),
            'to' => $teachingMethods->lastItem(),
            'total' => $teachingMethods->total(),
        ];

        return response()->json([
            'success' => true,
            'data' => $result
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

        // 計算價格和稅金
        $priceData = SiteSetting::calculateTax($teachingMethod->price);

        // 添加價格和稅金信息到響應中
        $result = $teachingMethod->toArray();
        $result['price_details'] = [
            'price' => $priceData['price'],
            'tax' => $priceData['tax'],
            'sub_total' => $priceData['sub_total'],
            'total' => $priceData['total'],
            'tax_included' => SiteSetting::get('tax_type') === 'included',
        ];

        return response()->json([
            'success' => true,
            'data' => $result
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

        // 為每個教學方式添加價格和稅金信息
        $result = [];
        foreach ($teachingMethods as $teachingMethod) {
            $item = $teachingMethod->toArray();
            $priceData = SiteSetting::calculateTax($teachingMethod->price);
            $item['price_details'] = [
                'price' => $priceData['price'],
                'tax' => $priceData['tax'],
                'sub_total' => $priceData['sub_total'],
                'total' => $priceData['total'],
                'tax_included' => SiteSetting::get('tax_type') === 'included',
            ];
            $result[] = $item;
        }

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
} 