<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\TeachingMethod;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * 獲取會員的所有訂單
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

        $orders = Order::with('teachingMethod')
            ->where('member_id', session('member_id'))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * 獲取單一訂單詳情
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

        $order = Order::with('teachingMethod')
            ->where('member_id', session('member_id'))
            ->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => '找不到此訂單'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    /**
     * 創建新訂單
     */
    public function store(Request $request)
    {
        // 檢查 session 中是否有會員資料
        if (!session('member_id')) {
            return response()->json([
                'success' => false,
                'message' => '未登入'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'teaching_method_id' => 'required|exists:teaching_methods,id',
            'payment_method' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => '驗證失敗',
                'errors' => $validator->errors()
            ], 422);
        }

        // 獲取教學方式
        $teachingMethod = TeachingMethod::find($request->teaching_method_id);
        
        if (!$teachingMethod || !$teachingMethod->is_active) {
            return response()->json([
                'success' => false,
                'message' => '此教學方式不存在或已停用'
            ], 404);
        }

        // 使用 SiteSetting 計算價格和稅金
        $priceData = SiteSetting::calculateTax($teachingMethod->price);

        // 創建訂單
        $order = Order::create([
            'member_id' => session('member_id'),
            'teaching_method_id' => $request->teaching_method_id,
            'order_number' => Order::generateOrderNumber(),
            'price' => $priceData['price'],
            'tax' => $priceData['tax'],
            'sub_total' => $priceData['sub_total'],
            'total' => $priceData['total'],
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'notes' => $request->notes,
        ]);

        // 如果是團體班，增加當前參與人數
        if ($teachingMethod->isGroup()) {
            $teachingMethod->increment('current_participants');
        }

        return response()->json([
            'success' => true,
            'message' => '訂單創建成功',
            'data' => $order
        ], 201);
    }

    /**
     * 取消訂單
     */
    public function cancel($id)
    {
        // 檢查 session 中是否有會員資料
        if (!session('member_id')) {
            return response()->json([
                'success' => false,
                'message' => '未登入'
            ], 401);
        }

        $order = Order::where('member_id', session('member_id'))
            ->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => '找不到此訂單'
            ], 404);
        }

        // 只有待處理或處理中的訂單可以取消
        if (!in_array($order->status, ['pending', 'processing'])) {
            return response()->json([
                'success' => false,
                'message' => '此訂單狀態無法取消'
            ], 400);
        }

        // 更新訂單狀態
        $order->status = 'cancelled';
        $order->save();

        // 如果是團體班，減少當前參與人數
        $teachingMethod = $order->teachingMethod;
        if ($teachingMethod && $teachingMethod->isGroup()) {
            $teachingMethod->decrement('current_participants');
        }

        return response()->json([
            'success' => true,
            'message' => '訂單已取消',
            'data' => $order
        ]);
    }
} 