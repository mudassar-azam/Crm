<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rooster;
use App\Models\RoosterOverride;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RoosterController extends Controller
{
    public function index(){
        $roosters =  Rooster::all();
        return view('rooster.index',compact('roosters'));
    }

    public function create(){
        $users = User::whereNull('role_type')->orWhere('role_type', '!=', 'engineer')->get();
        return view('rooster.create',compact('users'));
    }

    public function store(Request $request){
        $rules = [
            'user_id' => 'required',
            'type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->getMessages() as $field => $messages) {
                $errors[] = [
                    'field' => $field,
                    'message' => $messages[0]
                ];
            }
            return response()->json(['success' => false, 'errors' => $errors], 422);
        }

        // to check that rooster must not have overlapping date
        $userId = $request->input('user_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $existingRooster = Rooster::where('user_id', $userId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();
    
        if ($existingRooster) {
            return response()->json([
                'success' => false,
                'errors' => [['message' => 'A rooster already exists for this user within the given date range !']]
            ], 422);
        }

        $data = $request->all();
        $rooster = Rooster::create($data);

        return response()->json(['success' => true, 'message' => 'Rooster created successfully!']);
    }

    public function edit($id){
        $rooster = Rooster::find($id);

        $overrideDates = RoosterOverride::where('rooster_id', $rooster->id)->pluck('override_date')->toArray();
        $overrideDatesString = implode(',', $overrideDates);

        $users = User::whereNull('role_type')->orWhere('role_type', '!=', 'engineer')->get();
        return view('rooster.edit' , compact('rooster','users','overrideDatesString'));
    }

    public function overrided(){
        $roosters =  RoosterOverride::all();
        return view('rooster.overrided',compact('roosters'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'user_id' => 'required',
            'type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'override_dates' => 'nullable|string',
            'override_type' => 'nullable|in:present,absent',
        ];
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->getMessages() as $field => $messages) {
                $errors[] = [
                    'field' => $field,
                    'message' => $messages[0]
                ];
            }
            return response()->json(['success' => false, 'errors' => $errors], 422);
        }
    
        $rooster = Rooster::find($id);
        $userId = $request->input('user_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $existingRooster = Rooster::where('user_id', $userId)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();
    
        if ($existingRooster) {
            return response()->json([
                'success' => false,
                'errors' => [['message' => 'A rooster already exists for this user within the given date range!']]
            ], 422);
        }
    
        $data = $request->only(['user_id', 'type', 'start_date', 'end_date']);
        $rooster->update($data);
    
        $overrideDates = $request->input('override_dates');
        $overrideType = $request->input('override_type');
    
        if ($overrideDates && $overrideType) {
            $overrideDatesArray = array_map('trim', explode(',', $overrideDates));
    
            foreach ($overrideDatesArray as $date) {
                if ($date >= $startDate && $date <= $endDate) {
                    RoosterOverride::updateOrCreate(
                        [
                            'rooster_id' => $rooster->id,
                            'override_date' => $date,
                        ],
                        [
                            'type' => $overrideType
                        ]
                    );
                }
            }
        }
    
        return response()->json(['success' => true, 'message' => 'Rooster updated successfully!']);
    }
    
    public function destroy($id){
        $rooster = Rooster::find($id);
        $rooster->delete();
        return response()->json(['message' => 'Rooster deleted successfully']);
    }

    public function odestroy($id){
        $rooster = RoosterOverride::find($id);
        $rooster->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function cview(){
        return view('rooster.cview');
    }

    public function users(){
        $user = Auth::user();
        $students = User::where('role_id', '!=', 1)->orWhere('id', $user->id)->select('id as rollNo', 'user_name as name')->get();
        return response()->json($students);
    }

    public function roosters(Request $request){

        $user = Auth::user();

        $month = $request->input('month');
        $year = $request->input('year');
    
        $month = intval($month);
        $year = intval($year);
    

        $leaves = Rooster::whereYear('start_date', $year)->whereMonth('start_date', $month)->get();
        return response()->json($leaves);
    }
}
