<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
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
    public function create(){
         $clients = Client::all();
         return view('projects.create',compact('clients'));
    }
    public function store(Request $request)
    {
        $rules = [
            'client_id' => 'nullable|exists:clients,id',
            'project_name' => 'required|string|max:255',
            'project_sdm' => 'required|string|max:255',

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
        $project = Project::create([
            'client_id' => $request->input('client_id'),
            'project_name' => $request->input('project_name'),
            'project_sdm' => $request->input('project_sdm'),
            'po' => $request->input('po'),
            'customer_service_type' => $request->input('customer_service_type'),
            'customer_rates' => $request->input('customer_rates'),
        ]);

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has created project !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        return response()->json(['success' => true, 'message' => 'Project created successfully!']);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'nullable|exists:clients,id',
            'project_name' => 'required|string|max:255',
            'project_sdm' => 'required|string|max:255',
            'po' => 'required|string|max:255',
            'customer_service_type' => 'required|string|max:255',
            'customer_rates' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->getMessages() as $field => $messages) {
                $errors[] = [
                    'field' => $field,
                    'message' => $messages[0] 
                ];
            }

            return response()->json([
                'success' => false,
                'errors' => $errors
            ], 422);
        }

        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found',
            ], 404);
        }

        $project->update([
            'client_id' => $request->input('client_id'),
            'project_name' => $request->input('project_name'),
            'project_sdm' => $request->input('project_sdm'),
            'po' => $request->input('po'),
            'customer_service_type' => $request->input('customer_service_type'),
            'customer_rates' => $request->input('customer_rates'),
        ]);

        return response()->json([
            'success' => true,
            'data' => $project,
        ], 200);
    }
    public function destroy($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found',
            ], 404);
        }

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully',
        ], 200);
    }
}
