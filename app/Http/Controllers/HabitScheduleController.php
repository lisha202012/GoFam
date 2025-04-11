<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HabitSchedule;
use App\Models\Habit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class HabitScheduleController extends Controller
{
    public function store(Request $request)
    {
        $habit = Habit::where('name', $request->habit_id)->first();
    
        if (!$habit) {
            return response()->json(['error' => 'Invalid habit selected.'], 422);
        }
    
        $rules = [
            'dates' => 'required|array|min:1',
            'start_time' => 'required|string',
        ];
    
        // Only require end_time if timeType is "duration"
        if ($request->input('time_type') === 'duration') {
            $rules['end_time'] = 'required|string|after:start_time';
        }
    
        $messages = [
            'dates.required' => 'Please select at least one day.',
            'start_time.required' => 'Start time is required.',
            'end_time.required' => 'End time is required.',
            'end_time.after' => 'End time must be after the start time.',
        ];
    
        $validated = $request->validate($rules, $messages);
    
        foreach ($request->dates as $day) {
            HabitSchedule::create([
                'habit_id' => $habit->id,
                'date' => $day,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time, // can be null if reminder
            ]);
        }
    
        return response()->json(['success' => true]);
    }
    
    public function showActivityTracker()
    {
        return view('activityTracker');
    }

    public function getHabits(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
    
        $habits = Habit::where('user_id', Auth::id()) 
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get(['id', 'name', 'created_at']);
    
        return response()->json(['habits' => $habits]);
    }
    public function getHabitsByMonth(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        $userId = Auth::id();
            
        $habits = HabitSchedule::selectRaw('habit_schedules.date as day_name, COUNT(*) as count')
            ->join('habits', 'habit_schedules.habit_id', '=', 'habits.id')
            ->where('habits.user_id', $userId)
            ->whereIn('habit_schedules.date', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']) // Match valid days
            ->groupBy('habit_schedules.date')
            ->get();
        
        return response()->json(['habits' => $habits]);
    }
    public function showHabits(Request $request)
    {
        $dayName = $request->query('day');
    
        // Log::info('User ID: ' . Auth::id());
        // Log::info('Day name: ' . $dayName);
    
        $habits = Habit::join('habit_schedules', 'habits.id', '=', 'habit_schedules.habit_id')
            ->where('habit_schedules.date', $dayName) 
            ->where('habits.user_id', Auth::id())
            ->select('habits.name', 'habits.category', 'habit_schedules.start_time', 'habit_schedules.end_time')
            ->get();
    
        // Log::info("Retrieved Habits: ", $habits->toArray());
    
        return view('habit-tracker', compact('habits', 'dayName'));
    }
    

}
