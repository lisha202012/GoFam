<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HabitController extends Controller
{
    public function store(Request $request)
    {

        Log::info('Auth Check:', ['user_id' => Auth::id(), 'user' => Auth::user()]);

        $request->validate([
            'habit' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        Habit::create([
            'user_id' => Auth::id(), 
            'name' => $request->habit,
            'category' => $request->category,
        ]);

        return response()->json(['success' => true]);
    }
}

