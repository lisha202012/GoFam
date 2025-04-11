<?php

// app/Http/Controllers/MoodController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mood;
use Illuminate\Support\Facades\Auth;

class MoodController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'mood' => 'required|string',
        ]);

        $user = Auth::user();

        $mood = Mood::updateOrCreate(
            ['user_id' => $user->id, 'mood_date' => now()->toDateString()],
            ['mood' => $request->mood]
        );

        return response()->json(['message' => 'Mood saved successfully!']);
    }
    public function fetch()
    {
        $user = Auth::user();

        $moods = Mood::where('user_id', $user->id)->get();

        $mapped = $moods->map(function ($mood) {
            return [
                'date' => $mood->mood_date, 
                'emoji' => match ($mood->mood) {
                    'calm' => '🧘',
                    'excited' => '😍',
                    'sad' => '😔',
                    default => '',
                },
            ];
        });

        return response()->json($mapped);
    }

}

