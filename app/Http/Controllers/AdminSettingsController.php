<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Event;
use App\Models\Anounsement;
use App\Models\Lead;
use App\Models\Member;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AdminSettingsController extends Controller
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
        $users = User::whereNull('role_type')->orWhere('role_type' , '!=' , 'engineer')->get();
        $roles = Role::all();
        $managers = User::whereIn('role_id', [2, 3, 4 ,5])->get();
        $leads = User::where('role_id', 6)->get();
        $members = User::where('role_id', 7)->whereNotIn('id', Member::pluck('user_id'))->get();
        $anounsements = Anounsement::all();
        $events = Event::all();
        return view('admin-settings.admin-setting',compact('users','anounsements','events','roles' , 'managers' , 'leads' , 'members'));
    }
    //user
    public function store(Request $request){
        $rules = [
            'user_name' => 'required|string',
            'email' => [
                'required',
                'email',
                function($attribute, $value, $fail) {
                    if (!preg_match('/@chaseitglobal\.com$/', $value)) {
                        $fail('The '.$attribute.' must be a valid email address ending with @chaseitglobal.com');
                    }
                },
            ],
            'role_id' => 'required',
            'password' => 'required|string',
            'user_id' => 'required|string',
            'check_in' => 'required',
            'check_out' => 'required',
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
        $user = $request->all();

        $user['check_in'] = (new \DateTime($user['check_in']))->format('h:i A');
        $user['check_out'] = (new \DateTime($user['check_out']))->format('h:i A');
        $user['password'] = Hash::make($user['password']);

        $crmuser = User::create($user);
        $userRole = $crmuser->role->name;
        return response()->json(['success' => true, 'message' => 'User created successfully!', 'user' => $crmuser , 'userRole' => $userRole]);
    }
    public function edit(Request $request){
        $id = $request->input('userid');
        $rules = [
            'user_name' => 'required|string',
            'email' => [
                'required',
                'email',
                function($attribute, $value, $fail) {
                    if (!preg_match('/@chaseitglobal\.com$/', $value)) {
                        $fail('The '.$attribute.' must be a valid email address ending with @chaseitglobal.com');
                    }
                },
            ],
            'role_id' => 'nullable',
            'check_in' => 'required',
            'check_out' => 'required',
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
        
        $validatedData['check_in'] = (new \DateTime($validatedData['check_in']))->format('h:i A');
        $validatedData['check_out'] = (new \DateTime($validatedData['check_out']))->format('h:i A');

        $crmuser = User::find($id);

        if (array_key_exists('role_id', $validatedData) && $validatedData['role_id'] !== null) {
            if ($crmuser->role_id != $validatedData['role_id']) {
                $leadsCount = Lead::where(function($query) use ($crmuser) {
                    $query->where('user_id', $crmuser->id)
                          ->orWhere('manager_id', $crmuser->id);
                })->count();
                $membersCount = Member::where('user_id', $crmuser->id)->count();
    
                if ($leadsCount > 0 || $membersCount > 0) {
                    $errors[] = [
                        'field' => 'role_id',
                        'message' => 'User is associated with leads or members, delete those first!'
                    ];
                    return response()->json(['success' => false, 'errors' => $errors], 422);
                }
            }
        }

        $crmuser->update($validatedData);
        $userRole = $crmuser->role->name;
        return response()->json(['success' => true, 'message' => 'Payment added successfully!' , 'userId' => $id , 'user' => $crmuser ,'userRole' => $userRole]);
    }
    public function destroy(Request $request , $id){
        $user = User::find($id);

        $leadsCount = Lead::where(function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhere('manager_id', $user->id);
        })->count();

        $membersCount = Member::where('user_id', $user->id)->count();


        if ($leadsCount > 0 || $membersCount > 0) {
            return response()->json(['success' => false, 'message' => 'User is associated with leads or members, delete those first!'], 422);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    //anounsement
    public function storeAnounsement(Request $request){
        $rules = [
            'anounsement' => 'required|string',
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
        $anounsement = new Anounsement();
        $anounsement->anounsement = $request->input('anounsement',);
        $anounsement->save();

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has made anounsement !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        return response()->json(['success' => true, 'message' => 'Anounsement created successfully!', 'anounsement' => $anounsement]);
    }
    public function destroyAnounsement(Request $request , $id){
        $anounsement = Anounsement::find($id);
        $anounsement->delete();
        return response()->json(['message' => 'Anounsement deleted successfully']);
    }
    public function editAnounsement(Request $request){
        $id = $request->input('anounsement_id');
        $rules = [
            'anounsement' => 'required|string',
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
        $anounsement = Anounsement::find($id);
        $anounsement->update($validatedData);

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has updated anounsement !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);
        return response()->json(['success' => true, 'message' => 'Payment added successfully!' , 'anounsementId' => $id , 'anounsement' => $anounsement]);
    }
    
    //event 
    public function storeEvent(Request $request){
        $rules = [
            'event_name' => 'required|string|max:255',
            'priority' => 'required', 
            'category' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
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
        $validatedData = $validator->validated();
        $event = new Event();
        $event->fill($validatedData);
        $event->save();
        return response()->json(['success' => true, 'message' => 'Event created successfully!', 'event' => $event]);
    }
    public function destroyEvent(Request $request , $id){
        $event = Event::find($id);
        $event->delete();
        return response()->json(['message' => 'Anounsement deleted successfully']);
    }
    public function editEvent(Request $request){
        $id = $request->input('eventid');
        $rules = [
            'event_name1' => 'required|string|max:255',
            'priority1' => 'required', 
            'category1' => 'required|string',
            'date1' => 'required|date',
            'time1' => 'required',
            'remark1' => 'nullable|string|max:255',
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
        $event = Event::find($id);
        $event->event_name = $request->input('event_name1'); 
        $event->priority = $request->input('priority1'); 
        $event->category = $request->input('category1'); 
        $event->date = $request->input('date1'); 
        $event->time = $request->input('time1'); 
        $event->remark = $request->input('remark1');
        $event->save(); 
        return response()->json(['success' => true, 'message' => 'Event updated successfully!' , 'eventId' => $id , 'event' => $event]);
    }
    
    public function fetchEvents() {
        $events = Event::all();
        return response()->json($events);
    }   

}
