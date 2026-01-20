<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderHistory;
class OrderHistoryController extends Controller
{
     public function index()
    {
         $histories = OrderHistory::where('user_id', Auth::id())
        ->latest()
        ->get();

        return view('user.history', compact('histories'));

    }
public function historyshow($id)
{
          $histories = OrderHistory::where('order_id', $id)
        ->where('user_id', Auth::id())
        ->orderBy('created_at', 'asc')
        ->get();

    return view('user.history_show', compact('histories'));
}

    
}
