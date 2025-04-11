<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'dob' => 'required|date',
            'password' => 'required|string|min:6',
            'profile_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);
    
        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->withErrors(['email' => 'This email is already registered. Please log in.']);
        }

        $tempProfileImagePath = null;
    
        if ($request->hasFile('profile_image')) {
            if ($request->file('profile_image')->isValid()) {
                $emailBasedFilename = str_replace(['@', '.'], '_', $request->email) . '.' . $request->file('profile_image')->extension();
                $tempProfileImagePath = $request->file('profile_image')->storeAs('profiles/temp', $emailBasedFilename, 'public');
            } else {
                \Log::error('Uploaded file is not valid.');
            }
        }
        
    
        $otp = rand(100000, 999999);
    
        session([
            'otp' => $otp,
            'user_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'dob' => $request->dob,
                'password' => $request->password, 
                'profile_image' => $tempProfileImagePath, 
            ]
        ]);
    
        Mail::to($request->email)->send(new OtpMail($otp));
    
        return redirect()->route('otp-verification')->with('message', 'OTP has been sent to your email.');
    }
    
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);
    
        if (session('otp') == $request->otp) {
            $userData = session('user_data');
    
            $finalProfileImagePath = null;
            if (!empty($userData['profile_image'])) {
                $oldPath = $userData['profile_image']; 
                $newPath = 'profiles/' . basename($oldPath); 
            
                if (!Storage::disk('public')->exists('profiles')) {
                    Storage::disk('public')->makeDirectory('profiles');
                }
            
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->move($oldPath, $newPath);
                    $finalProfileImagePath = $newPath;
                } else {
                }
            }
            
            
    
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'dob' => $userData['dob'],
                'password' => Hash::make($userData['password']),
                'profile_image' => $finalProfileImagePath,
            ]);

            session()->forget(['otp', 'user_data']);
    
            return response()->json(['redirect' => url('/dashboard')]); 
        } else {
            return response()->json(['error' => 'Invalid OTP.'], 422);
        }
    }
    
    
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        $otp = rand(100000, 999999);

        if ($request->hasFile('profile_image')) {
            if ($request->file('profile_image')->isValid()) {
                $emailBasedFilename = str_replace(['@', '.'], '_', $request->email) . '.' . $request->file('profile_image')->extension();
        
                $tempProfileImagePath = $request->file('profile_image')->storeAs('profiles/temp', $emailBasedFilename, 'public');
        
            } else {
                \Log::error('Uploaded file is not valid.');
            }
        }
        
        
        session([
            'otp' => $otp,
            'user_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'dob' => $request->dob,
                'password' => $request->password, 
                'profile_image' => $tempProfileImagePath, 
            ]
        ]);
                
        Mail::to($request->email)->send(new OtpMail($otp));

        return response()->json(['message' => 'OTP sent successfully.']);
    }
  
    public function showOtpVerification()
    {
        return view('otp-verification');
    }
    public function showLogin()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            return redirect()->route('opening')->with('success', 'Logged in successfully');
        } else {
            return back()->with('error', 'Invalid email or password'); 
        }
    }
    

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('message', 'You have been logged out.');
    }

}
