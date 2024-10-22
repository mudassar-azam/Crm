<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\User;
use App\Models\Member;
use App\Models\Lead;
use App\Models\Notification;

class TaskController extends Controller
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
        $user = Auth::user();
        if(Auth::user()->role->name == 'Admin'){
            
            $users = User::where('role_id', 3)->orWhere('role_type', 'RecmLead')->orWhere('role_type', 'RecmMember')->get();
            $tasks = Task::all();
            $mtasks = null;
            return view('resources.task',compact('users','tasks','mtasks'));

        }elseif(Auth::user()->role->name == 'Recruitment Manager'  ){
            $leads = Lead::where('manager_id', $user->id)->get();

            $leadUsers = $leads->map(function($lead) {
                return $lead->user; 
            });

            $leadIds = $leads->pluck('id');

            $members = Member::whereIn('lead_id', $leadIds)->get();

            $memberUsers = $members->map(function($member) {
                return $member->user; 
            });

            $users = $leadUsers->merge($memberUsers);

            $userIds = $users->map(function($user) {
                return $user->id; 
            });

            $tasks = Task::whereIn('assign_to', $userIds)->get();

            $mtasks = Task::where('assign_to', $user->id)->get();

            return view('resources.task',compact('users','tasks','mtasks'));

        }elseif(Auth::user()->role_type == 'RecmLead'){
            $lead = Lead::where('user_id' , $user->id)->first();

            $members = $lead->members;

            $users = $members->map(function($member) {
                return $member->user; 
            });

            $userIds = $users->map(function($user) {
                return $user->id; 
            });

            $tasks = Task::whereIn('assign_to', $userIds)->get();
            $mtasks = Task::where('assign_to', $user->id)->get();

            return view('resources.task',compact('users','tasks','mtasks'));
            
        }else{
            $users = null;
            $tasks = null;
            $mtasks = Task::where('assign_to', $user->id)->get();
            return view('resources.task',compact('users','tasks','mtasks'));
        }
    }
    public function store(Request $request)
    {
        $rules = [
            'assign_to' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'priority' => 'required|in:high,medium,low',
            'bucket' => 'nullable|string|max:255',
            'description' => 'required|string',
            'remarks' => 'nullable|string',
            'status' => 'required',
            'location' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
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
        $data = $request->all();
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $destinationPath = public_path('attachment');
            $imagePath = $file->move($destinationPath, $file->getClientOriginalName());
            $data['attachment'] = $file->getClientOriginalName();
        } else {
            $data['attachment'] = null;
        }
        $data['task_completion_status'] = 'incomplete';
        $data['assign_by'] = Auth::user()->id;
        $task = Task::create($data);
        $user_id = $task->assign_to;
        $user = User::find($user_id);
        $userName = $user->user_name;
        $users = User::where('role_id', 3)->orWhere('role_type', 'RecmLead')->orWhere('role_type', 'RecmMember')->get();

        $user1_id = Auth::user()->id;
        $user2_id = $task->assign_to;
        $message = " has created task and assigned to ";
        $notification = $this->createNotification($user1_id, $user2_id, $message);


        return response()->json(['success' => true, 'message' => 'Task created successfully!', 'task' => $task ,'userName'=>  $userName, 'users'=>$users]);
    }
    public function update(Request $request)
    {
        $rules =[
            'assign_to' => 'sometimes|required|exists:users,id',
            'start_date' => 'sometimes|required|date',
            'due_date' => 'sometimes|required|date|after_or_equal:start_date',
            'priority' => 'sometimes|required|in:high,medium,low',
            'bucket' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'status' => 'required',
            'location' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
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

        $task = Task::findOrFail($request->taskId);
        $data = $request->all();
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $destinationPath = public_path('attachment');
            $imagePath = $file->move($destinationPath, $file->getClientOriginalName());
            $data['attachment'] = $file->getClientOriginalName();
        } else {
            $data['attachment'] = null;
        }
        $task->update($data); 
        $updatedTask = $task->fresh();
        $user = User::find($task->assign_to);
        $userName = $user->user_name;
        $users = User::where('role_id', 3)->orWhere('role_type', 'RecmLead')->orWhere('role_type', 'RecmMember')->get();

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has updated task !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        return response()->json(['success' => true, 'message' => 'Task updated successfully!', 'task' => $updatedTask ,'userName'=>  $userName, 'users'=>$users , 'taskId'=> $request->taskId]);
    }
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has deleted task !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        return response()->json(['message' => 'Task deleted successfully']);
    }
    public function taskDone(Request $request)
    {
        $task = Task::findOrFail($request->input('taskId'));
        $task->task_completion_status = 'complete';
        $task->save();

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has completed task !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        return response()->json(['message' => 'Task completed successfully' , 'taskId'=> $request->input('taskId')]);
    }

    public function UpdateStatus(Request $request){
        $rules =[
            'status' => 'required',
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

        $task = Task::find($request->input('taskId'));
        $task->status = $request->input('status');
        $task->save();

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has updated task status !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        return response()->json(['success' => true, 'message' => 'Status updated successfully!' , 'taskId'=> $request->taskId]);
    }
}
