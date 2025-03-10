<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    /**
     * 會員登入
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => '驗證失敗',
                'errors' => $validator->errors()
            ], 422);
        }

        $member = Member::where('email', $request->email)->first();

        if (!$member || !Hash::check($request->password, $member->password)) {
            return response()->json([
                'success' => false,
                'message' => '電子郵件或密碼不正確'
            ], 401);
        }

        // 創建 token
        $token = $this->generateToken($member);

        // 儲存到 session
        session(['member_token' => $token]);
        session(['member_id' => $member->id]);
        session(['member_name' => $member->name]);
        session(['member_email' => $member->email]);

        return response()->json([
            'success' => true,
            'message' => '登入成功',
            'data' => [
                'token' => $token,
                'member' => [
                    'id' => $member->id,
                    'name' => $member->name,
                    'email' => $member->email,
                ]
            ]
        ]);
    }

    /**
     * 會員登出
     */
    public function logout(Request $request)
    {
        // 清除 session
        $request->session()->forget(['member_token', 'member_id', 'member_name', 'member_email']);

        return response()->json([
            'success' => true,
            'message' => '登出成功'
        ]);
    }

    /**
     * 獲取當前會員資料
     */
    public function profile(Request $request)
    {
        // 檢查 session 中是否有會員資料
        if (!session('member_id')) {
            return response()->json([
                'success' => false,
                'message' => '未登入'
            ], 401);
        }

        $member = Member::find(session('member_id'));

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => '會員不存在'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'member' => [
                    'id' => $member->id,
                    'name' => $member->name,
                    'email' => $member->email,
                    'phone' => $member->phone,
                    'birthday' => $member->birthday,
                    'address' => $member->address,
                    'membership_type' => $member->membership_type,
                    'membership_start_date' => $member->membership_start_date,
                    'membership_end_date' => $member->membership_end_date,
                    'is_active' => $member->is_active,
                ]
            ]
        ]);
    }

    /**
     * 更新會員資料
     */
    public function updateProfile(Request $request)
    {
        // 檢查 session 中是否有會員資料
        if (!session('member_id')) {
            return response()->json([
                'success' => false,
                'message' => '未登入'
            ], 401);
        }

        $member = Member::find(session('member_id'));

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => '會員不存在'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|nullable|string|max:20',
            'birthday' => 'sometimes|nullable|date',
            'address' => 'sometimes|nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => '驗證失敗',
                'errors' => $validator->errors()
            ], 422);
        }

        $member->update($request->only([
            'name', 'phone', 'birthday', 'address'
        ]));

        // 更新 session 中的會員名稱
        session(['member_name' => $member->name]);

        return response()->json([
            'success' => true,
            'message' => '會員資料更新成功',
            'data' => [
                'member' => [
                    'id' => $member->id,
                    'name' => $member->name,
                    'email' => $member->email,
                    'phone' => $member->phone,
                    'birthday' => $member->birthday,
                    'address' => $member->address,
                    'membership_type' => $member->membership_type,
                    'membership_start_date' => $member->membership_start_date,
                    'membership_end_date' => $member->membership_end_date,
                    'is_active' => $member->is_active,
                ]
            ]
        ]);
    }

    /**
     * 生成 token
     */
    private function generateToken(Member $member)
    {
        $payload = [
            'id' => $member->id,
            'name' => $member->name,
            'email' => $member->email,
            'timestamp' => now()->timestamp,
            'random' => Str::random(10)
        ];

        return base64_encode(json_encode($payload));
    }
} 