<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    /**
     * 獲取所有比賽
     */
    public function index(Request $request)
    {
        $query = Tournament::where('is_active', true);

        // 排序
        $sortBy = $request->input('sort_by', 'start_date');
        $sortOrder = $request->input('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $tournaments = $query->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $tournaments
        ]);
    }

    /**
     * 獲取單一比賽詳情
     */
    public function show($id)
    {
        $tournament = Tournament::where('is_active', true)
            ->find($id);

        if (!$tournament) {
            return response()->json([
                'success' => false,
                'message' => '找不到此比賽'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $tournament
        ]);
    }

    /**
     * 獲取即將開始的比賽
     */
    public function upcoming()
    {
        $tournaments = Tournament::where('is_active', true)
            ->where('start_date', '>', now())
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tournaments
        ]);
    }
} 