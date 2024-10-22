<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Leave;
use App\Models\User;
use App\Models\Lead;
use App\Models\Member;
use App\Models\Notification;

class ProfileController extends Controller
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
    public function index(){
        $user = User::find(Auth::user()->id);
        if(hasAdminRole()){
            $totalLeadAndMemberIds = collect();
            $leaves = Leave::all();
            $team = User::whereNull('role_type')->orWhere('role_type', '!=', 'engineer')->get();

            $vacation = $user->vacation;
            $sick_leave = $user->sick_leave;


            return view ('profile.index',compact('leaves','user','team','totalLeadAndMemberIds','vacation','sick_leave'));

        }elseif(ManagersExceptAdminAndBd()){
            $leads = Lead::where('manager_id', $user->id)->get();

            $leadUsers = $leads->map(function($lead) {
                return $lead->user; 
            });

            $leadIds = $leads->pluck('id');

            $members = Member::whereIn('lead_id', $leadIds)->get();

            $memberUsers = $members->map(function($member) {
                return $member->user; 
            });

            $team = $leadUsers->merge($memberUsers);

            $userIds = $team->map(function($member) {
                return $member->id; 
            });

            $totalLeadAndMemberIds = $userIds;

            $leaves = Leave::whereIn('user_id', $userIds)->orWhere('user_id', $user->id)->get();

            $vacation = $user->vacation;
            $sick_leave = $user->sick_leave;

            $team = $team->merge(collect([$user]));
            
            return view ('profile.index',compact('leaves','user','team','totalLeadAndMemberIds','vacation','sick_leave'));

        }elseif(BdManager()){
            $team = [];
            $totalLeadAndMemberIds = collect();
            $leaves = Leave::where('user_id', $user->id)->get();
            
            $vacation = $user->vacation;
            $sick_leave = $user->sick_leave;
            return view ('profile.index',compact('leaves','user','team','totalLeadAndMemberIds','vacation','sick_leave'));

        }elseif(hasLeadRole()){

            $lead = Lead::where('user_id' , $user->id)->first();

            $members = $lead->members;

            $team = $members->map(function($member) {
                return $member->user; 
            });

            $team = $team->merge(collect([$user]));

            $userIds = $members->map(function($member) {
                return $member->user->id; 
            });

            $leaves = Leave::whereIn('user_id', $userIds)->orWhere('user_id', $user->id)->get();
            $totalLeadAndMemberIds = collect();

            $vacation = $user->vacation;
            $sick_leave = $user->sick_leave;
            return view ('profile.index',compact('leaves','user','team','totalLeadAndMemberIds','vacation','sick_leave'));
        }else{
            $team = null;
            $leaves = Leave::where('user_id', $user->id)->get();
            $totalLeadAndMemberIds = collect();

            $vacation = $user->vacation;
            $sick_leave = $user->sick_leave;
            return view ('profile.index',compact('leaves','user','team','totalLeadAndMemberIds','vacation','sick_leave'));
        }
    }
    public function store(Request $request){

        $rules = [
            'type' => 'required',
            'start_date' => 'required',
            'comment' => 'required',
        ];
        
        $messages = [
            'type.required' => 'Leave type is required',
            'start_date.required' => 'Start date is required',
            'comment.required' => 'Comment/Description is required',
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


        if($request->input('end_date') == null){

            $leave = $request->all();
    
            $leave['user_id'] = Auth::user()->id;
            $leave['status'] = 'Pending';
            $leave['duration'] = '1 day';
            $leave['end_date'] = $request->input('start_date');
    
            $data =  Leave::create($leave);

            $userName = Auth::user()->user_name;
            $userRole = Auth::user()->role->name;
    
            $user1_id = Auth::user()->id;
            $user2_id = null;
            $message = " has applied for leave !";
            $notification = $this->createNotification($user1_id, $user2_id, $message);
    
            return response()->json(['success' => true, 'message' => 'Leave added successfully!' , 'leave' => $data , 'userName' => $userName , 'userRole' => $userRole]);
        }

        $leave = $request->all();

        $startDate = \Carbon\Carbon::parse($request->input('start_date'));
        $endDate = \Carbon\Carbon::parse($request->input('end_date'));
        $durationInDays = $endDate->diffInDays($startDate) + 1; 
        $duration = $durationInDays . ' ' . Str::plural('day', $durationInDays);

        $leave['user_id'] = Auth::user()->id;
        $leave['status'] = 'Pending';
        $leave['duration'] = $duration;

        $data =  Leave::create($leave);

        $userName = Auth::user()->user_name;
        $userRole = Auth::user()->role->name;

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has applied for leave !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        return response()->json(['success' => true, 'message' => 'Leave added successfully!' , 'leave' => $data , 'userName' => $userName , 'userRole' => $userRole]);
    }

    public function destroy($id){
        $leave = Leave::find($id);
        $leave->delete();

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has deleted leave !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);


        return response()->json(['message' => 'Deleted successfully']);
    }

    public function approveLeave($id){
        $leave = Leave::find($id);


        $duration = intval($leave->duration);
        $user = User::find($leave->user_id);
        if($leave->type == 'Vacation'){
            $remainingVacation = $user->vacation - $duration;
            $user->vacation = $remainingVacation;
        }else{
            $remainingSickLeaves = $user->sick_leave - $duration;
            $user->sick_leave = $remainingSickLeaves;
        }
        $user->save();

        $leave->status = "Approved";
        $leave->approved_by = Auth::user()->id;
        $leave->save();

        $user1_id = Auth::user()->id;
        $user2_id = $leave->user_id;
        $message = " has approved leave !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        $leaveId = $leave->id;
        return response()->json(['message' => 'Leave approved successfully', 'leaveId' => $leaveId]);
    }
}
