<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\City;
use App\Models\Client;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\Currency;
use App\Models\Project;
use App\Models\Resource;
use App\Models\User;
use App\Models\Lead;
use App\Models\Member;
use App\Models\Notification;
use App\Models\EngineerNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class ActivityController extends Controller
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
    public function createEngineerNotification($resource_id , $e_message)
    {
        $notification = EngineerNotification::create([
            'engineer_id' => $resource_id,
            'message'  => $e_message,
        ]);
        return $notification;
    }
    public function create(){
        $resources=Resource::all();
        $countries=Country::all();
        $clients = Client::with('projects')->get();
        $cities=City::all();
        $currencies=Currency::all();
        return view('activities.create',compact('resources','countries','cities','clients','currencies'));
    }
    public function store(Request $request)
    {
        $rules = [
            'ticket_detail' => 'required|string|max:255',
            'activity_start_date' => 'required|date|date_format:Y-m-d\TH:i',
            'location' => 'required|string|max:255',
            'activity_description' => 'required|string',
            'tech_country_id' => 'required|integer|exists:countries,id',
            'tech_city' => 'required',
            'resource_id' => 'required|integer|exists:resources,id',
            'tech_service_type' => 'required|string',
            'tech_rates' => 'required',
            'tech_currency_id'=>'required',
            'client_id' => 'required|integer|exists:clients,id',
            'project_id' => 'nullable',
            'project_sdm' => 'required|string|max:255',
            'po_number' => 'required|string|max:255',
            'customer_service_type' => 'required',
            'customer_rates' => 'required|string|max:255',
            'customer_currency_id'=>'required',
            'email_screenshot' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
        if ($request->hasFile('email_screenshot')) {
            $file = $request->file('email_screenshot');
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->move(public_path('email sc'), $fileName); 
        } else {
            return redirect()->back()
                ->withErrors(['email_screenshot' => 'Email screenshot is required.'])
                ->withInput();
        }

        $activityStartDate = Carbon::createFromFormat('Y-m-d\TH:i', $request->input('activity_start_date'));
        if($request->project_id =='other')
        {
            $request->project_id = null;
        }

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has created activity !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        $data = [
            'ticket_detail' => $request->ticket_detail,
            'email_screenshot' => $fileName,
            'activity_start_date' => $activityStartDate,
            'location' => $request->location,
            'activity_description' => $request->activity_description,
            'customer_service_type' => $request->customer_service_type,
            'customer_rates' => $request->customer_rates,
            'tech_country_id' => $request->tech_country_id,
            'tech_city' => $request->tech_city,
            'tech_service_type' => $request->tech_service_type,
            'tech_rates' => $request->tech_rates,
            'tech_currency_id' => $request->tech_currency_id,
            'client_id' => $request->client_id,
            'resource_id' => $request->resource_id,
            'project_id' => $request->project_id , 
            'project_sdm' => $request->project_sdm,
            'po_number' => $request->po_number,
            'customer_currency_id' => $request->customer_currency_id,
            'user_id' =>   Auth::user()->id,
        ];
        Activity::create($data);
        return response()->json(['success' => true, 'message' => 'Activity created successfully!']);
    }
    public function planed(Request $request){
        $user = Auth::user();
        $query = Activity::query();

        if(hasAdminRole()){
            $query = Activity::query();
            $totalLeadAndMemberIds = collect();
            $totalMemberIds = collect();
            $myId = collect();
        }elseif(SdmManager()){

            $totalMemberIds = collect();
            $myId = collect();
            $users = User::where('role_type', 'SdmMember')->orWhere('role_type', 'SdmLead')->orWhere('role_id', 4)->get();
            $UserIds = $users->pluck('id');
            $allAdmins = User::where('role_id', 1)->get();
            $allAdminsIds = $allAdmins->pluck('id');
            $combineIds = $UserIds->merge($allAdminsIds);
            $query->whereIn('user_id', $combineIds);

            //to edit only thoese lead and member related to you
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
            $totalLeadAndMemberIds = $totalEmployees->pluck('id');
            $totalLeadAndMemberIds = $totalLeadAndMemberIds->merge([$user->id])->merge($allAdminsIds)->unique();

        }elseif(SdmLead()){

            $totalLeadAndMemberIds = collect();
            $myId = collect();
            $users = User::where('role_type', 'SdmMember')->orWhere('id',$user->id)->get();
            $allAdmins = User::where('role_id', 1)->get();
            $allAdminsIds = $allAdmins->pluck('id');
            $memberUserIds = $users->pluck('id');
            $combineIds = $memberUserIds->merge($allAdminsIds);
            $query->whereIn('user_id', $combineIds);

            //to edit only thoese lead and member related to you
            $lead = Lead::where('user_id' , $user->id)->first();
            if($lead){
                $members = $lead->members;
                $totalmembers = $members->map(function($member) {
                    return $member->user; 
                });
                $totalMemberIds = $totalmembers->pluck('id');
                $totalMemberIds = $totalMemberIds->merge([$user->id])->merge($allAdminsIds)->unique();
            }

        }else{

            $totalLeadAndMemberIds = collect();
            $totalMemberIds = collect();
            
            $users = User::where('role_type', 'SdmMember')->get();
            $memberUserIds = $users->pluck('id');
            $allAdmins = User::where('role_id', 1)->get();
            $allAdminsIds = $allAdmins->pluck('id');
            $combineIds = $memberUserIds->merge($allAdminsIds);
            $query->whereIn('user_id', $combineIds);

            $myId = $allAdminsIds->merge([$user->id])->unique();
        }

        if ($request->filled('from_date')) {
            $query->filterByFromDate($request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->filterByToDate($request->to_date);
        }
        if ($request->filled('company_id')) {
            $query->filterByCompany($request->company_id);
        }

        $activities = $query->with(['resource', 'project', 'client'])->where('activity_status', 'pending')->orderBy('activity_start_date', 'asc')->get();
        $clients = Client::all();
        $currencies = Currency::all();
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        return view('activities.planed', compact('activities','clients','currencies' ,'from_date','to_date','totalLeadAndMemberIds','totalMemberIds','myId'));
    }
    public function planedEdit($id) {
        $activity = Activity::with(['resource', 'project', 'client'])->find($id);
        $resources=Resource::all();
        $countries=Country::all();
        $clients = Client::with('projects')->get();
        $cities=City::all();
        $projects=Project::all();
        $currencies=Currency::all();
        if (!$activity) {
            return redirect()->route('activities.index')->with('error', 'Activity not found');
        }
        return view('activities.planedEdit', compact('activity','resources','countries','clients','cities','projects','currencies'));
    }
    public function planedUpdate(Request $request, $id)
    {
        $rules = [
            'ticket_detail' => 'required|string|max:255',
            'activity_start_date' => 'required|date|date_format:Y-m-d\TH:i',
            'location' => 'required|string|max:255',
            'activity_description' => 'required|string',
            'tech_service_type' => 'required|string',
            'tech_rates' => 'required',
            'tech_currency_id' => 'required',
            'customer_service_type' => 'required|string',
            'customer_rates' => 'required|string|max:255',
            'customer_currency_id' => 'required',
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

        $validatedData = $validator->validated();

        if ($request->hasFile('email_screenshot')) {
            $file = $request->file('email_screenshot');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->move(public_path('email sc'), $fileName);
            $validatedData['email_screenshot'] = $fileName;
        }

        if ($request->filled('activity_status')) {
            $validatedData['activity_status'] = $request->input('activity_status');
        }

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has edited activity !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        $activityStartDate = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['activity_start_date']);
        $validatedData['activity_start_date'] = $activityStartDate;

        $activity = Activity::findOrFail($id);
        $activity->update($validatedData);

        return response()->json(['success' => true, 'message' => 'Activity updated successfully!']);
    }
    public function confirmActivity(Request $request) {
        $rules = [
            'pakistani_time' => 'required|date_format:Y-m-d\TH:i',
            'default_time' => 'required|date_format:Y-m-d\TH:i',
            'remark' => 'required|string|max:255',
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

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has confirmed activity !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);



        $id = $request->input('activity_id');
        $activity = Activity::find($id);

        $resource_id = $activity->resource_id;
        $e_message = " Your activity has confirmed !";
        $e_notification = $this->createEngineerNotification($resource_id, $e_message);

        $activity->pakistani_time = $request->input('pakistani_time');
        $activity->default_time = $request->input('default_time');
        $activity->remark = $request->input('remark');
        $activity->activity_status = "confirmed";
         $activity->confirmed_by = Auth::user()->user_name;
        $activity->confirmed_at = Carbon::now();
        $activity->save();
        return response()->json(['success' => true, 'message' => 'Activity confirmed successfully!' , 'activityId' => $id]);
    }
    public function confirmedActivities(Request $request){
        $user = Auth::user();
        $query = Activity::query();

        if(hasAdminRole()){
            $query = Activity::query();
            $totalLeadAndMemberIds = collect();
            $totalMemberIds = collect();
            $myId = collect();
        }elseif(SdmManager()){
            $totalMemberIds = collect();
            $myId = collect();
            $users = User::where('role_type', 'SdmMember')->orWhere('role_type', 'SdmLead')->orWhere('role_id', 4)->get();
            $UserIds = $users->pluck('id');
            $allAdmins = User::where('role_id', 1)->get();
            $allAdminsIds = $allAdmins->pluck('id');
            $combineIds = $UserIds->merge($allAdminsIds);
            $query->whereIn('user_id', $combineIds);

            //to edit only thoese lead and member related to you
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
            $totalLeadAndMemberIds = $totalEmployees->pluck('id');
            $totalLeadAndMemberIds =  $totalLeadAndMemberIds->merge([$user->id])->merge($allAdminsIds)->unique();

        }elseif(SdmLead()){

            $totalLeadAndMemberIds = collect();
            $myId = collect();
            $users = User::where('role_type', 'SdmMember')->orWhere('id',$user->id)->get();
            $memberUserIds = $users->pluck('id');
            $allAdmins = User::where('role_id', 1)->get();
            $allAdminsIds = $allAdmins->pluck('id');
            $combineIds = $memberUserIds->merge($allAdminsIds);
            $query->whereIn('user_id', $combineIds);

            //to edit only thoese lead and member related to you
            $lead = Lead::where('user_id' , $user->id)->first();
            if($lead){
                $members = $lead->members;
                $totalmembers = $members->map(function($member) {
                    return $member->user; 
                });
                $totalMemberIds = $totalmembers->pluck('id');
                $totalMemberIds = $totalMemberIds->merge([$user->id])->merge($allAdminsIds)->unique();
            }

        }else{

            $totalLeadAndMemberIds = collect();
            $totalMemberIds = collect();
            
            $users = User::where('role_type', 'SdmMember')->get();
            $memberUserIds = $users->pluck('id');
            $allAdmins = User::where('role_id', 1)->get();
            $allAdminsIds = $allAdmins->pluck('id');
            $combineIds = $memberUserIds->merge($allAdminsIds);
            $query->whereIn('user_id', $combineIds);

            $myId = $allAdminsIds->merge([$user->id])->unique();
        }

        if ($request->filled('from_date')) {
            $query->filterByFromDate($request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->filterByToDate($request->to_date);
        }
        if ($request->filled('company_id')) {
            $query->filterByCompany($request->company_id);
        }
        $activities = $query->with(['resource', 'project', 'client'])->where('activity_status', 'confirmed')->orderBy('activity_start_date', 'asc')->get();
        $clients = Client::all();
        $clients = Client::all();
        $currencies = Currency::all();
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        return view('activities.confirmedActivities', compact('activities','clients','currencies','from_date','to_date','totalLeadAndMemberIds','totalMemberIds','myId'));
    }
    public function displayMode()
    {
        $activities = Activity::where('activity_status', 'confirmed')
        ->orderBy('activity_start_date', 'asc')
        ->get();    
        return view('activities.display-mode',compact('activities'));
    }
    public function activityClosed(Request $request , $id){
        $rules = [
            'start_date_time' => 'required|date',
            'end_date_time' => 'required|date|after_or_equal:start_date_time',
            'sign_of_sheet' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'duration' => 'required',
            'tech_service_type' => 'required',
            'tech_rates' => 'required',
            'total_tech_payments' => 'required|numeric',
            'tech_currency_id' => 'required|exists:currencies,id',
            'duration_cust' => 'required',
            'customer_service_type' => 'required',
            'customer_rates' => 'required',
            'total_customer_payments' => 'required|numeric',
            'customer_currency_id' => 'required|exists:currencies,id',
            'remark' => 'nullable|string|max:255',
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
        $activity = Activity::find($id);
        $activity->start_date_time = $request->input('start_date_time');
        $activity->end_date_time = $request->input('end_date_time');
        $activity->time_difference = $request->input('time_difference');
        if ($request->hasFile('sign_of_sheet')) {
            $uploadedFile = $request->file('sign_of_sheet');
            $fileName = $uploadedFile->getClientOriginalName();
            $uploadedFile->move(public_path('sign-of-sheet'), $fileName);
        }else {
            return redirect()->back()
                ->withErrors(['sign_of_sheet' => 'Sign of sheet is required.'])
                ->withInput();
        }
        $activity->duration = $request->input('duration');
        $activity->tech_service_type = $request->input('tech_service_type');
        $activity->tech_rates = $request->input('tech_rates');
        $activity->total_tech_payments = $request->input('total_tech_payments');
        $activity->tech_currency_id  = $request->input('tech_currency_id');

        $activity->duration_cust  = $request->input('duration_cust');
        $activity->customer_service_type = $request->input('customer_service_type');
        $activity->customer_rates = $request->input('customer_rates');
        $activity->total_customer_payments = $request->input('total_customer_payments');
        $activity->customer_currency_id  = $request->input('customer_currency_id');
        $activity->sign_of_sheet  = $fileName;
        $activity->remark  = $request->input('remark');
        $activity->completed_by =   Auth::user()->user_name;
        $activity->activity_status  = "closed";
        $activity->save();

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has closed activity !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);


        $resource_id = $activity->resource_id;
        $e_message = " Your activity has approved !";
        $e_notification = $this->createEngineerNotification($resource_id, $e_message);

        return response()->json(['success' => true, 'message' => 'Activity closed successfully!' , 'activityId' => $id]);
    }
    public function completedActivity(Request $request) {
        $user = Auth::user();
        $query = Activity::query();

        if(hasAdminRole()){
            $query = Activity::query();
            $totalLeadAndMemberIds = collect();
            $totalMemberIds = collect();
        }elseif(SdmManager()){

            $totalMemberIds = collect();
            $users = User::where('role_type', 'SdmMember')->orWhere('role_type', 'SdmLead')->orWhere('role_id', 4)->get();
            $UserIds = $users->pluck('id');
            $allAdmins = User::where('role_id', 1)->get();
            $allAdminsIds = $allAdmins->pluck('id');
            $combineIds = $UserIds->merge($allAdminsIds);
            $query->whereIn('user_id', $combineIds);

            //to edit only thoese lead and member related to you
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
            $totalLeadAndMemberIds = $totalEmployees->pluck('id');
            $totalLeadAndMemberIds =  $totalLeadAndMemberIds->merge([$user->id])->merge($allAdminsIds)->unique();

        }elseif(SdmLead()){

            $totalLeadAndMemberIds = collect();
            $users = User::where('role_type', 'SdmMember')->orWhere('id',$user->id)->get();
            $memberUserIds = $users->pluck('id');
            $allAdmins = User::where('role_id', 1)->get();
            $allAdminsIds = $allAdmins->pluck('id');
            $combineIds = $memberUserIds->merge($allAdminsIds);
            $query->whereIn('user_id', $combineIds);

            //to edit only thoese lead and member related to you
            $lead = Lead::where('user_id' , $user->id)->first();
            if($lead){
                $members = $lead->members;
                $totalmembers = $members->map(function($member) {
                    return $member->user; 
                });
                $totalMemberIds = $totalmembers->pluck('id');
                $totalMemberIds = $totalMemberIds->merge([$user->id])->merge($allAdminsIds)->unique();
            }

        }else{
            $totalLeadAndMemberIds = collect();
            $totalMemberIds = collect();
            
            $users = User::where('role_type', 'SdmMember')->get();
            $memberUserIds = $users->pluck('id');
            $allAdmins = User::where('role_id', 1)->get();
            $allAdminsIds = $allAdmins->pluck('id');
            $combineIds = $memberUserIds->merge($allAdminsIds);
            $query->whereIn('user_id', $combineIds);
        }

        if ($request->filled('from_date')) {
            $query->filterByFromDate($request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->filterByToDate($request->to_date);
        }
        if ($request->filled('company_id')) {
            $query->filterByCompany($request->company_id);
        }
        $activities = $query->with(['resource', 'project', 'client'])->where('activity_status', 'closed')->orderBy('activity_start_date', 'asc')->get();
        $clients = Client::all();
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        return view('activities.closedactivities', compact('activities','clients','from_date','to_date','totalLeadAndMemberIds','totalMemberIds'));
    }
    public function approveActivity(Request $request, $id)
    {
        $activity = Activity::find($id);
        if (!$activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }
        try {
            $activity->activity_status = "approved";
            $activity->approved_by = Auth::user()->user_name;
            $activity->save();

            $user1_id = Auth::user()->id;
            $user2_id = null;
            $message = " has approved activity !";
            $notification = $this->createNotification($user1_id, $user2_id, $message);

            return response()->json(['message' => 'Activity approved successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to approve activity', 'error' => $e->getMessage()], 500);
        }
    }
    public function approved(Request $request){
        $user = Auth::user();
        $query = Activity::query();

        if(hasAdminRole()){
            $query = Activity::query();
            $totalLeadAndMemberIds = collect();
        }elseif(hasAccountRole()){
            $query = Activity::query();
            $totalLeadAndMemberIds = collect();
        }else{
            $users = User::where('role_type', 'SdmMember')->orWhere('role_type', 'SdmLead')->orWhere('role_id', 4)->get();
            $UserIds = $users->pluck('id');
            $allAdmins = User::where('role_id', 1)->get();
            $allAdminsIds = $allAdmins->pluck('id');
            $combineIds = $UserIds->merge($allAdminsIds);
            $query->whereIn('user_id', $combineIds);

            //to edit only thoese lead and member related to you
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
            $totalLeadAndMemberIds = $totalEmployees->pluck('id');
            $totalLeadAndMemberIds =  $totalLeadAndMemberIds->merge([$user->id])->merge($allAdminsIds)->unique();

        }

        if ($request->filled('from_date')) {
            $query->filterByFromDate($request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->filterByToDate($request->to_date);
        }
        if ($request->filled('company_id')) {
            $query->filterByCompany($request->company_id);
        }
        $activities = $query->with(['resource', 'project', 'client'])
        ->where('activity_status', 'approved')
        ->where(function ($query) {
            $query->whereNull('tech_invoice')->orWhereNull('customer_invoice');
        })
        ->orderBy('activity_start_date', 'asc')
        ->get();
        $clients = Client::all();
        $currencies = Currency::all();
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        return view('activities.approved', compact('activities','clients','currencies','from_date','to_date','totalLeadAndMemberIds'));
    }
    public function destroyActivity(Request $request , $id){
        $activity = Activity::find($id);
        $activity->delete();

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has deleted activity !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        return response()->json(['message' => 'Activity deleted successfully']);
    }
    public function totalActivities(Request $request){
        $query = Activity::query();
        if ($request->filled('from_date')) {
            $query->filterByFromDate($request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->filterByToDate($request->to_date);
        }
        if ($request->filled('company_id')) {
            $query->filterByCompany($request->company_id);
        }
        $activities = $query->with(['resource', 'project', 'client'])->where('tech_invoice', 'true')->where('customer_invoice', 'true')->orderBy('activity_start_date', 'asc')->get();
        $clients = Client::all();
        $currencies = Currency::all();
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        return view('activities.total-activities', compact('activities','clients','currencies','from_date','to_date'));
    }

    public function editTotalActivity($id){
        $activity = Activity::with(['resource', 'project', 'client'])->find($id);
        $resources=Resource::all();
        $countries=Country::all();
        $clients = Client::with('projects')->get();
        $cities=City::all();
        $projects=Project::all();
        $currencies=Currency::all();
        return view('activities.total-activity-edit', compact('activity','resources','countries','clients','cities','projects','currencies'));
    }
    public function UpdateTotalActivity(Request $request , $id){
        $rules = [
            'ticket_detail' => 'required|string|max:255',
            'activity_start_date' => 'required|date|date_format:Y-m-d\TH:i',
            'location' => 'required|string|max:255',
            'activity_description' => 'required|string',
            'tech_service_type' => 'required|string',
            'tech_rates' => 'required',
            'tech_currency_id' => 'required',
            'customer_service_type' => 'required|string',
            'customer_rates' => 'required|string|max:255',
            'customer_currency_id' => 'required',
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

        $validatedData = $validator->validated();

        if ($request->hasFile('email_screenshot')) {
            $file = $request->file('email_screenshot');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->move(public_path('email sc'), $fileName);
            $validatedData['email_screenshot'] = $fileName;
        }

        if ($request->filled('activity_status')) {
            $validatedData['activity_status'] = $request->input('activity_status');
             
            $invoices = Invoice::where('activity_id' , $id)->get();
            foreach($invoices as $invoice){
                $invoice->delete();
            }   

            $activity = Activity::findOrFail($id);
            $activity->tech_invoice = null;
            $activity->customer_invoice = null;
            $activity->tech_invoice_payment_status = null;
            $activity->customer_invoice_payment_status = null;
            $activity->save();
        }

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has edited activity !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        $activityStartDate = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['activity_start_date']);
        $validatedData['activity_start_date'] = $activityStartDate;

        $activity = Activity::findOrFail($id);
        $activity->update($validatedData);

        return response()->json(['success' => true, 'message' => 'Activity updated successfully!']);
    }
    public function assignActivity(Request $request){
        $rules = [
            'user' => 'required',
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
        $activity_id = $request->input('activity_id');
        $user_id = $request->input('user');
        $activity = Activity::find($activity_id);
        $activity->assign_to_user_id = $user_id;
        $activity->assign_remarks = $request->input('assign_remarks');
        $activity->save();

        $user1_id = Auth::user()->id;
        $user2_id = $user_id;
        $message = " has assigned activity !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        return response()->json(['success' => true, 'message' => 'Activity assigned successfully!' , 'activityId' => $activity_id]);
    }
    public function assignTaskActivity(Request $request){
        $activity_id = $request->input('activity_id');
        $activity = Activity::find($activity_id);
        $fields = [
            'ff',
            'job',
            'reached',
            'update_client',
            'inform_client',
            'sign_of_sheet_received',
            'ff_working',
            'activity_completed',
            'ff_need_time',
            'svr_shared'
        ];
    
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $activity->$field = $request->boolean($field);
            }
        }
        $activity->save();
        return response()->json(['success' => true, 'message' => 'Task assigned successfully!' , 'activityId' => $activity_id]);
    }
    public function getCities($id){
        $cities = City::where('country_id', $id)->get();
        return response()->json($cities);
    }
    public function getResources($name){
        $resources = Resource::where('city_name', $name)->get();
        return response()->json($resources);
    }
    public function getDataForYear($year){
        $startDate = $year . '-01-01 00:00:00';
        $endDate = $year . '-12-31 23:59:59';
        $activities = Activity::whereIn('activity_status', ['closed', 'approved'])
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->pluck('activity_start_date');   
        return response()->json($activities);
    }
}
