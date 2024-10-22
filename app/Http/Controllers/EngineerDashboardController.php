<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EngineerOtp;

class EngineerDashboardController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        
        $userEmail = $user->email;

        $resource = Resource::where('email', $userEmail)->first();
    
        if ($resource) {
            $resourceId = $resource->id;
            $relatedActivities = Activity::where('resource_id', $resourceId)->get();
        } else {
            $relatedActivities = collect(); 
        }

        $paidActivities = Activity::where('resource_id', $resourceId)->whereNotNull('tech_invoice')->whereNotNull('tech_invoice_payment_status')->get();
    
        return view('engineer.dashboard', compact('relatedActivities','paidActivities'));
    }

    public function confirmActivities()
    {
        $user = auth()->user();
        
        $userEmail = $user->email;

        $resource = Resource::where('email', $userEmail)->first();
    
        if ($resource) {
            $resourceId = $resource->id;
            $confirmedActivities = Activity::where('resource_id', $resourceId)->where('activity_status' , 'confirmed')->get();
        } else {
            $confirmedActivities = collect(); 
        }

        $name = $resource->name;
    
        return view('engineer.confirm-activities', compact('confirmedActivities','name'));
    }

    public function approveActivities()
    {
        $user = auth()->user();
        
        $userEmail = $user->email;

        $resource = Resource::where('email', $userEmail)->first();
    
        if ($resource) {
            $resourceId = $resource->id;
            $approvedActivities = Activity::where('resource_id', $resourceId)->where('activity_status' , 'closed')->get();
        } else {
            $approvedActivities = collect(); 
        }

        $name = $resource->name;
    
        return view('engineer.approved-activities', compact('approvedActivities','name'));
    }
    
    public function paidActivities()
    {
        $user = auth()->user();
        
        $userEmail = $user->email;

        $resource = Resource::where('email', $userEmail)->first();
    
        if ($resource) {
            $resourceId = $resource->id;
            $paidActivities = Activity::where('resource_id', $resourceId)->whereNotNull('tech_invoice')->whereNotNull('tech_invoice_payment_status')->get();
        } else {
            $paidActivities = collect(); 
        }

        $name = $resource->name;
    
        return view('engineer.paid-activities', compact('paidActivities','name'));
    }

    public function settings()
    {
        $user = auth()->user();
        return view('engineer.settings', compact('user'));
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $loginUserEmail = Auth::user()->email;
        $email = $request->input('email');

        if ($loginUserEmail !== $email) {
            return response()->json(['error' => 'Email is incorrect. Please enter your correct email !'], 422);
        }else{
            $otp = mt_rand(100000, 999999);
            session(['otp' => $otp]);
            Mail::to($email)->send(new EngineerOtp($otp));
            return response()->json(['message' => 'OTP sent successfully,Pleas Enter Otp !']);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        $emailOtp = session('otp');
        $enteredOtp = $request->input('otp');

        $emailOtp = (string) $emailOtp;
        $enteredOtp = (string) $enteredOtp;

        if ($emailOtp !== $enteredOtp) {
            return response()->json(['error' => 'Oto is incorrect. Please enter valid otp !'], 422);
        }else{
            session()->forget('otp');
            return response()->json(['message' => 'OTP matched successfully,Pleas Enter your new password !']);
        }
    }

    public function engineerPassword(Request $request)
    {
        $request->validate([
           'password' => 'required|min:6',
        ]);

        $user = User::find(Auth::user()->id);
        $newPass = Hash::make($request->input('password')); 
        $user->password = $newPass;
        $user->save();

        return response()->json(['message' => 'Password updated successfully !']);
    }
}
