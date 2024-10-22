<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Client;
use App\Models\User;
use App\Models\Lead;
use App\Models\Member;
use App\Models\Leave;
use App\Models\Notification;
use App\Models\Rooster;
use App\Models\RoosterOverride;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;


class AttendanceController extends Controller
{
    public function createNotification($user1_id, $user2_id = null, $message)
    {
        $notification = Notification::create([
            'user1_id' => $user1_id,
            'user2_id' => $user2_id,
            'message'  => $message,
        ]);
        return $notification;
    }

    public function dashboard(Request $request){
        $user = Auth::user();
        if (AdminOrHrManager()) {
            $totalOntime = 0;
            $totalLateArrival = 0;
            $totalLeftEarly = 0;
            $totalAbsent = 0;
        
            $today = Carbon::today()->format('Y-m-d'); 
            $attendances = Attendance::whereDate('date', '=', $today)->get();
        
            $users = User::whereNull('role_type')->orWhere('role_type', '!=', 'engineer')->get();
        
            foreach ($users as $user) {
                $ontime = Attendance::where('user_id', $user->id)
                    ->whereNull('arrived_early')
                    ->whereNull('arrived_late')
                    ->whereDate('created_at', now()->toDateString())
                    ->count();
                $totalOntime += $ontime;
        
                $lateArrival = Attendance::where('user_id', $user->id)
                    ->whereNotNull('arrived_late')
                    ->whereDate('created_at', now()->toDateString())
                    ->count();
                $totalLateArrival += $lateArrival;
        
                $leftEarly = Attendance::where('user_id', $user->id)
                    ->whereNotNull('left_early')
                    ->whereDate('created_at', now()->toDateString())
                    ->count();
                $totalLeftEarly += $leftEarly;
        
                $leaves = Leave::where('user_id', $user->id)->where('status', 'Approved')->get();
                $firstAttendance = Attendance::where('user_id', $user->id)->orderBy('date', 'asc')->first();
                $lastAttendance = Attendance::where('user_id', $user->id)->orderBy('date', 'desc')->first();
        
                if ($firstAttendance && $lastAttendance) {
                    $startDate = Carbon::parse($firstAttendance->date);
                    $endDate = Carbon::parse($lastAttendance->date);
                    $rooster = Rooster::where('user_id', $user->id)
                        ->where('start_date', '<=', $endDate)
                        ->where('end_date', '>=', $startDate)
                        ->first();
                    $mattendances = Attendance::where('user_id', $user->id)
                        ->whereBetween('date', [$startDate, $endDate])
                        ->pluck('date')
                        ->map(function($date) {
                            return Carbon::parse($date)->toDateString();
                        });
        
                    $allDates = new Collection();
                    $currentDate = $startDate->copy();
        
                    while ($currentDate->lte($endDate)) {
                        $override = null;
                        if ($rooster) {
                            $override = RoosterOverride::where('rooster_id', $rooster->id)
                                ->where('override_date', $currentDate->toDateString())
                                ->first();
                        }
        
                        $isOverridePresent = $override && $override->type === 'present';
                        $isOverrideAbsent = $override && $override->type === 'absent';
                        $isRoosterPresent = !$override && $rooster && $rooster->type === 'present';
                        $isRoosterAbsent = !$override && $rooster && $rooster->type === 'absent';
        
                        if ($isOverridePresent || $isRoosterPresent) {
                            $allDates->push($currentDate->copy()->toDateString());
                        } else if (!$isOverrideAbsent && !$isRoosterAbsent && 
                                   $currentDate->dayOfWeek !== Carbon::SUNDAY && 
                                   !$this->isDateInLeave($currentDate, $leaves) && 
                                   !$mattendances->contains($currentDate->toDateString())) {
                            $allDates->push($currentDate->copy()->toDateString());
                        }
        
                        $currentDate->addDay();
                    }
        
                    $absentDates = $allDates->diff($mattendances);
                    $absent = $absentDates->count();
                } else {
                    $absent = 0; 
                }
        
                $totalAbsent += $absent; 
            }
        
            $totalEmployees = $users;
        
            return view('attendance.dashboard', compact('attendances', 'totalEmployees', 'totalOntime', 'totalAbsent', 'totalLateArrival', 'totalLeftEarly'));
        }elseif(Managers()){

            $today = Carbon::today()->format('Y-m-d'); 
            $leads = Lead::where('manager_id', $user->id)->get();

            $leadUsers = $leads->map(function($lead) {
                return $lead->user; 
            });

            $leadIds = $leads->pluck('id');

            $members = Member::whereIn('lead_id', $leadIds)->get();

            $memberUsers = $members->map(function($member) {
                return $member->user; 
            });

            $totalEmployees = $leadUsers->merge($memberUsers)->merge(collect([$user]));

            $userIds = $totalEmployees->map(function($totalEmployee) {
                return $totalEmployee->id; 
            });


            $attendances = Attendance::where(function($query) use ($today, $userIds, $user) {
                $query->whereDate('date', '=', $today)
                      ->whereIn('user_id', $userIds);
            })->orWhere('user_id', $user->id)->get();

            return view('attendance.dashboard',compact('attendances','totalEmployees'));

        }elseif(BdManager()){
            $today = Carbon::today()->format('Y-m-d');
            $attendances = Attendance::whereDate('date', '=', $today)->where('user_id', $user->id)->get();
            $totalEmployees = collect([Auth::user()]);

            return view('attendance.dashboard',compact('attendances','totalEmployees'));

        }elseif(hasLeadRole()){
            $today = Carbon::today()->format('Y-m-d'); 
            $lead = Lead::where('user_id' , $user->id)->first();
            if($lead){
                $members = $lead->members;

                $totalEmployees = $members->map(function($member) {
                    return $member->user; 
                });
    
                $userIds = $totalEmployees->map(function($totalEmployee) {
                    return $totalEmployee->id; 
                });

                $totalEmployees = $totalEmployees->merge(collect([$user]));
    
                $attendances = Attendance::where(function($query) use ($today, $userIds, $user) {
                    $query->whereDate('date', '=', $today)
                          ->whereIn('user_id', $userIds);
                })->orWhere('user_id', $user->id)->get();

            }else{
                $totalEmployees = collect([Auth::user()]);
                $attendances = Attendance::whereDate('date', '=', $today)->whereIn('user_id', $user->id)->get();
            }

            return view('attendance.dashboard',compact('attendances','totalEmployees'));

        }elseif(hasMemberRole()){
            $today = Carbon::today()->format('Y-m-d'); 
            $attendances = Attendance::whereDate('date', '=', $today)->where('user_id', $user->id)->get();
            $totalEmployees = collect([Auth::user()]);
            return view('attendance.dashboard',compact('attendances','totalEmployees'));
        }
    }

    protected function isDateInLeave(Carbon $date, $leaves)
    {
        foreach ($leaves as $leave) {
            $leaveStart = Carbon::parse($leave->start_date);
            $leaveEnd = Carbon::parse($leave->end_date);
            if ($date->between($leaveStart, $leaveEnd)) {
                return true;
            }
        }
        return false;
    }
    
    public function storeCheckIn(Request $request)
    {
        $today = Carbon::today();

        $user = Auth::user();

        $absentRoster = Rooster::where('user_id', Auth::user()->id)
            ->where('type', 'absent')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->first();
        
        if ($absentRoster) {

            $attendance = new Attendance();
            $attendance->in = $user->check_in;
            $attendance->out = null;

            $checkInTime = Carbon::createFromFormat('h:i a', $user->check_in);
            $checkOutTime = Carbon::createFromFormat('h:i a', $user->check_out);

            $workedDuration = $checkInTime->diff($checkOutTime);

            $hours = $workedDuration->format('%h');
            $minutes = $workedDuration->format('%i');

            if ($minutes == 0) {
                $workedHours = $hours . ' hours';
            } else {
                $workedHours = $hours . ' hours ' . $minutes . ' minutes';
            }

            $attendance->worked_hours = $workedHours;

            $attendance->arrived_early = null;  
            $attendance->arrived_late = null;
            $attendance->left_early = null;  
            $attendance->left_late = null;

            $attendance->date = today();
            $attendance->user_id = Auth::user()->id;
    
            $attendance->save();
    
            $user1_id = Auth::user()->id;
            $user2_id = null;
            $message = " has checked In !";
            $notification = $this->createNotification($user1_id, $user2_id, $message);
    
            $userRole = Auth::user()->role->name;
            $userName = Auth::user()->name;
    
            return response()->json([
                'success' => true,
                'userRole' => $userRole,
                'userName' => $userName,
                'attendance' => $attendance
            ]);
        }


        $previousAttendance = Attendance::where('user_id', Auth::user()->id)->whereDate('date', Carbon::today())->whereNotNull('in')->whereNotNull('out')->first();
        if($previousAttendance != null){

            $previousIn = Carbon::parse($previousAttendance->in); 
            $checkInTime = Carbon::parse($request->check_in_time); 

            $differenceInMinutes = $previousIn->diffInMinutes($checkInTime); 

            if ($differenceInMinutes < 60) {
                $previousAttendance->break = $differenceInMinutes . ' minutes';
            } else {
                $differenceInHours = $differenceInMinutes / 60;
                $previousAttendance->break = number_format($differenceInHours, 2) . ' hours';
            }

            $previousAttendance->in2 = $request->check_in_time;
            $previousAttendance->save();

            $user1_id = Auth::user()->id;
            $user2_id = null;
            $message = " has checked In !";
            $notification = $this->createNotification($user1_id, $user2_id, $message);

            return response()->json(['success' => true]);
        }
        $attendance = new Attendance();

        $fixedArrivalTime = Carbon::parse($user->check_in);
        $checkInTime = Carbon::parse($request->check_in_time);

        $marginTime = $fixedArrivalTime->copy()->addMinutes(30);

        if ($checkInTime < $fixedArrivalTime) {
            $differenceInMinutes = $fixedArrivalTime->diffInMinutes($checkInTime);
            
            if ($differenceInMinutes < 60) {
                $attendance->arrived_early = $differenceInMinutes . ' minutes';
            } else {
                $differenceInHours = $checkInTime->diff($fixedArrivalTime)->format('%h');
                $additionalMinutes = $checkInTime->diff($fixedArrivalTime)->format('%i');
                $attendance->arrived_early = $differenceInHours . ' hours ' . $additionalMinutes . ' minutes';
            }

            $attendance->arrived_late = null;

        }elseif($checkInTime > $marginTime) {

            $differenceInMinutes = $fixedArrivalTime->diffInMinutes($checkInTime);

            if ($differenceInMinutes < 60) {
                $attendance->arrived_late = $differenceInMinutes . ' minutes';
            } else {
                $differenceInHours = $fixedArrivalTime->diff($checkInTime)->format('%h');
                $additionalMinutes = $fixedArrivalTime->diff($checkInTime)->format('%i');
                $attendance->arrived_late = $differenceInHours . ' hours ' . $additionalMinutes . ' minutes';
            }

            $attendance->arrived_early = null;
        }else{
            $attendance->arrived_late = null;
            $attendance->arrived_early = null;
        }

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has checked In !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        $attendance->in = $request->check_in_time;
        $attendance->date = today();
        $attendance->user_id = Auth::user()->id;
        $attendance->save();

        return response()->json(['success' => true]);
    }

    public function storeCheckOut(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $today = Carbon::today();

        $absentRoster = Rooster::where('user_id', Auth::user()->id)
            ->where('type', 'absent')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->first();
        
        if ($absentRoster) {
            $attendance = Attendance::where('user_id', Auth::user()->id)
                ->whereDate('date', today())
                ->whereNull('out')
                ->first();  
            
            if ($attendance) {
                $attendance->out = $user->check_out;

                $checkInTime = Carbon::createFromFormat('h:i a', $user->check_in);
                $checkOutTime = Carbon::createFromFormat('h:i a', $user->check_out);
                $workedDuration = $checkInTime->diff($checkOutTime);

                $hours = $workedDuration->format('%h');
                $minutes = $workedDuration->format('%i');

                if ($minutes == 0) {
                    $workedHours = $hours . ' hours';
                } else {
                    $workedHours = $hours . ' hours ' . $minutes . ' minutes';
                }

                $attendance->worked_hours = $workedHours;

                $attendance->arrived_early = null;  
                $attendance->arrived_late = null;
                $attendance->left_early = null;  
                $attendance->left_late = null;
    
                $attendance->save();
            }
    
            $user1_id = Auth::user()->id;
            $user2_id = null;
            $message = " has checked Out!";
            $notification = $this->createNotification($user1_id, $user2_id, $message);
    
            $userRole = Auth::user()->role->name;
            $userName = Auth::user()->user_name;
    
            return response()->json([
                'success' => true,
                'userRole' => $userRole,
                'userName' => $userName,
                'attendance' => $attendance
            ]);
        }
        
        $previousAttendance = Attendance::where('user_id', Auth::user()->id)->whereDate('date', Carbon::today())->whereNotNull('in')->whereNotNull('out')->first();
        if($previousAttendance != null){ 
            $previousAttendance->out2 = $request->check_out_time;

            $secondCheckInTime = Carbon::createFromFormat('h:i a', $previousAttendance->in2);
            $secondCheckOutTime = Carbon::createFromFormat('h:i a', $request->check_out_time);

            $workedDuration = $secondCheckInTime->diff($secondCheckOutTime);
            $previousWorkedDuration = \DateInterval::createFromDateString($previousAttendance->worked_hours);
            $baseTime = new \DateTime('00:00');
            $baseTime->add($previousWorkedDuration);
            $baseTime->add($workedDuration);
            $totalDuration = $baseTime->diff(new \DateTime('00:00'));
            $totalWorkedDuration = $totalDuration->format('%h hours %i minutes');
            $previousAttendance->worked_hours = $totalWorkedDuration;

            $previousAttendance->save();
            $userRole = Auth::user()->role->name;
            $userName = Auth::user()->role->name;

            $user1_id = Auth::user()->id;
            $user2_id = null;
            $message = " has checked Out !";
            $notification = $this->createNotification($user1_id, $user2_id, $message);

            return response()->json([
                'success' => true,
                'userRole' => $userRole,
                'userName' => $userName,
                'attendance' => $previousAttendance
            ]);
        }

        $attendance = Attendance::where('user_id', Auth::user()->id)
            ->whereDate('date', today())
            ->whereNull('out')
            ->first();

        if ($attendance) {

            $fixedLeavingTime = Carbon::parse($user->check_out);
            $checkOutTime = Carbon::parse($request->check_out_time);
            
            if ($checkOutTime > $fixedLeavingTime) {
                $differenceInMinutes = $checkOutTime->diffInMinutes($fixedLeavingTime);
            
                if ($differenceInMinutes < 60) {
                    $attendance->left_late = $differenceInMinutes . ' minutes';
                } else {
                    $differenceInHours = $checkOutTime->diff($fixedLeavingTime)->format('%h');
                    $additionalMinutes = $checkOutTime->diff($fixedLeavingTime)->format('%i');
                    $attendance->left_late = $differenceInHours . ' hours ' . $additionalMinutes . ' minutes';
                }
                $attendance->left_early = null;
            
            } elseif ($checkOutTime < $fixedLeavingTime) {
                $differenceInMinutes = $fixedLeavingTime->diffInMinutes($checkOutTime);
            
                if ($differenceInMinutes < 60) {
                    $attendance->left_early = $differenceInMinutes . ' minutes';
                } else {
                    $differenceInHours = $fixedLeavingTime->diff($checkOutTime)->format('%h');
                    $additionalMinutes = $fixedLeavingTime->diff($checkOutTime)->format('%i');
                    $attendance->left_early = $differenceInHours . ' hours ' . $additionalMinutes . ' minutes';
                }
                $attendance->left_late = null;
            }else{
                $attendance->left_late = null;
                $attendance->left_early = null;
            }

            $user1_id = Auth::user()->id;
            $user2_id = null;
            $message = " has checked Out !";
            $notification = $this->createNotification($user1_id, $user2_id, $message);

            $attendance->out = $request->check_out_time;

            $checkInTime = Carbon::createFromFormat('h:i a', $attendance->in);
            $checkOutTime = Carbon::createFromFormat('h:i a', $attendance->out);
            

            if ($checkOutTime < $checkInTime) {
                $checkOutTime->addDay();
            }

            $workedDuration = $checkInTime->diff($checkOutTime);
    
            $workedHours = $workedDuration->format('%h hours %i minutes');
            
            $attendance->worked_hours = $workedHours;
            $attendance->save();
        }

        $userRole = Auth::user()->role->name;
        $userName = Auth::user()->user_name;

        return response()->json([
            'success' => true,
            'userRole' => $userRole,
            'userName' => $userName,
            'attendance' => $attendance
        ]);
    }

    public function allAttendance(Request $request , $id){
        $query = Attendance::query();

        if ($request->filled('from_date')) {
            $query->filterByFromDate($request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->filterByToDate($request->to_date);
        }

        $attendances = $query->where('user_id', $id)->get();
        $user = User::find($id);
        $username = $user->user_name;
        return view('attendance.allAttendance',compact('attendances','id','username'));
    }

    public function leaveStatus(){
        return view('attendance.leave-status');
    }


    public function getStudents()
    {
        $user = Auth::user();
        
        if(AdminOrHrManager()){
            $students = User::where('role_id', '!=', 1)->orWhere('id', $user->id)->select('id as rollNo', 'user_name as name')->get();
            return response()->json($students);

        }elseif(Managers()){
            $leads = Lead::where('manager_id', $user->id)->get();

            $leadUsers = $leads->map(function($lead) {
                return $lead->user; 
            });

            $leadIds = $leads->pluck('id');

            $members = Member::whereIn('lead_id', $leadIds)->get();

            $memberUsers = $members->map(function($member) {
                return $member->user; 
            });

            $totalEmployees = $leadUsers->merge($memberUsers);
            $totalEmployees = $totalEmployees->merge([$user])->unique();
            $students = $totalEmployees->map(function ($totalEmployee) {
                return [
                    'rollNo' => $totalEmployee->id,
                    'name' => $totalEmployee->user_name,
                ];
            });
            return response()->json($students);

        }elseif(BdManager()){
            $students = User::where('id' , $user->id)->select('id as rollNo', 'user_name as name')->get();
            return response()->json($students);

        }elseif(hasLeadRole()){
            $lead = Lead::where('id' , $user->id)->first();
            if($lead != null){
                $members = $lead->members;
                if(!$members->isEmpty()){

                    $totalEmployees = $members->map(function($member) {
                        return $member->user; 
                    });
    
                    $students = $totalEmployees->map(function ($totalEmployee) {
                        return [
                            'rollNo' => $totalEmployee->id,
                            'name' => $totalEmployee->user_name,
                        ];
                    });
    
                    return response()->json($students);
                }else{
                    $students = User::where('id' , $user->id)->select('id as rollNo', 'user_name as name')->get();
                    return response()->json($students);
                }

            }else{
                $students = User::where('id' , $user->id)->select('id as rollNo', 'user_name as name')->get();
                return response()->json($students);
            }
        }elseif(hasMemberRole()){
            $students = User::where('id' , $user->id)->select('id as rollNo', 'user_name as name')->get();
            return response()->json($students);
        }
    }
    
    public function getLeaves(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
    
        $month = intval($month);
        $year = intval($year);
    
        $user = Auth::user();

        if(AdminOrHrManager()){
            $leaves = Leave::whereYear('start_date', $year)->whereMonth('start_date', $month)->get();
            return response()->json($leaves);

        }elseif(Managers()){
            $leads = Lead::where('manager_id', $user->id)->get();

            $leadUsers = $leads->map(function($lead) {
                return $lead->user; 
            });

            $leadIds = $leads->pluck('id');

            $members = Member::whereIn('lead_id', $leadIds)->get();

            $memberUsers = $members->map(function($member) {
                return $member->user; 
            });

            $totalEmployees = $leadUsers->merge($memberUsers);

            $userIds = $totalEmployees->map(function($totalEmployee) {
                return $totalEmployee->id; 
            });

            $leaves = Leave::whereYear('start_date', $year)->whereMonth('start_date', $month)->whereIn('user_id', $userIds)->orWhere('user_id', $user->id)->get();
            return response()->json($leaves);

        }elseif(BdManager()){
            $leaves = Leave::whereYear('start_date', $year)->whereMonth('start_date', $month)->where('user_id', $user->id)->get();
            return response()->json($leaves);

        }elseif(hasLeadRole()){
            $lead = Lead::where('user_id' , $user->id)->first();
            if($lead){
                $members = $lead->members;
                if(!$members->isEmpty()){

                    $totalEmployees = $members->map(function($member) {
                        return $member->user; 
                    });
        
                    $userIds = $totalEmployees->map(function($totalEmployee) {
                        return $totalEmployee->id; 
                    });
    
                    $leaves = Leave::whereYear('start_date', $year)->whereMonth('start_date', $month)->whereIn('user_id', $userIds)->orWhere('user_id', $user->id)->get();
                    return response()->json($leaves);
                }else{
                    $leaves = Leave::whereYear('start_date', $year)->whereMonth('start_date', $month)->where('user_id', $user->id)->get();
                    return response()->json($leaves);
                }

            }else{
                $leaves = Leave::whereYear('start_date', $year)->whereMonth('start_date', $month)->where('user_id', $user->id)->get();
                return response()->json($leaves);
            }
        }elseif(hasMemberRole()){
            $leaves = Leave::whereYear('start_date', $year)->whereMonth('start_date', $month)->where('user_id', $user->id)->get();
            return response()->json($leaves);
        }
    }

    public function users(){
        $user = Auth::user();
        if(AdminOrHrManager()){
            $users = User::all();
            return view('attendance.related-employess',compact('users'));

        }elseif(Managers()){
            $leads = Lead::where('manager_id', $user->id)->get();

            $leadUsers = $leads->map(function($lead) {
                return $lead->user; 
            });

            $leadIds = $leads->pluck('id');

            $members = Member::whereIn('lead_id', $leadIds)->get();

            $memberUsers = $members->map(function($member) {
                return $member->user; 
            });

            $users = $leadUsers->merge($memberUsers)->merge(collect([$user]));

            return view('attendance.related-employess',compact('users'));

        }elseif(BdManager()){

            $users = collect([Auth::user()]);
            return view('attendance.related-employess',compact('users'));

        }elseif(hasLeadRole()){
            $lead = Lead::where('user_id' , $user->id)->first();
            if($lead){
                $members = $lead->members;

                $users = $members->map(function($member) {
                    return $member->user; 
                });

                $users = $users->merge(collect([$user]));

                return view('attendance.related-employess',compact('users'));

            }else{
                $users = collect([Auth::user()]);
                return view('attendance.related-employess',compact('users'));
            }

        }elseif(hasMemberRole()){
            $users = collect([Auth::user()]);
            return view('attendance.related-employess',compact('users'));
        }
    }

    public function deleteAttendance($id){
        $attendance = Attendance::find($id);
        $attendance->delete();
        return response()->json(['success' => true]);
    }

    public function updateAttendance(Request $request) {
        $rules = [
            'in' => ['required_without_all:out', 'regex:/^(0[1-9]|1[0-2]):[0-5][0-9] (AM|PM)$/i'],
            'out' => ['required_without_all:in', 'regex:/^(0[1-9]|1[0-2]):[0-5][0-9] (AM|PM)$/i'],
        ];
    
        $messages = [
            'in.required_without_all' => 'At least 1 field is required',
            'out.required_without_all' => 'At least 1 field is required',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
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
    
        $attendanceId = $request->input('attendance_id');
        $attendance = Attendance::find($attendanceId);
    
        $inTime = Carbon::parse($request->input('in'));
        $outTime = Carbon::parse($request->input('out'));
    
        // If both in and out times are provided
        if ($request->filled('in') && $request->filled('out')) {
            $outTime = Carbon::parse($request->input('out'));
    
            if ($outTime < $inTime) {
                $outTime->addDay();
            }
    
            $workedDuration = $inTime->diff($outTime);
            $workedHours = $workedDuration->format('%h hours %i minutes');
    
            $attendance->in = $inTime->format('h:i A');
            $attendance->out = $outTime->format('h:i A');
            $attendance->worked_hours = $workedHours;
            $attendance->save();
        }
    
        // If only in time is provided
        if ($request->filled('in') && !$request->filled('out')) {
            if ($attendance->worked_hours) {
                $outTime = Carbon::parse($attendance->out);
                $workedDuration = $inTime->diff($outTime);
                $workedHours = $workedDuration->format('%h hours %i minutes');
                $attendance->in = $inTime->format('h:i A');
                $attendance->worked_hours = $workedHours;
            } else {
                $attendance->in = $inTime->format('h:i A');
            }
    
            $attendance->save();
        }

        if ($request->filled('out') && !$request->filled('in')) {
            $inTime = Carbon::parse($attendance->in);
            $workedDuration = $inTime->diff($outTime);
            $workedHours = $workedDuration->format('%h hours %i minutes');
            $attendance->out = $outTime->format('h:i A');
            $attendance->worked_hours = $workedHours;
            $attendance->save();
        }

        return response()->json(['success' => true, 'message' => 'Attendance updated successfully!', 'attendanceId' => $attendance->id]);
    }
     
}
