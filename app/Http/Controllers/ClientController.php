<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\FollowUpClient;
use App\Models\Project;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ClientController extends Controller
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
    public  function index(Request $request){
        $query = Client::query();
        if ($request->filled('from_date')) {
            $query->filterByFromDate($request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->filterByToDate($request->to_date);
        }
        $clients = $query->orderBy('created_at', 'asc')->get();
        return view('clients.index', [
            'clients' => $clients,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
        ]);
    }
    public  function create(){
        return view('clients.create');
    }
    public function store(Request $request)
    {
        $rules = [
            'company_name' => 'required|string',
            'registration_no' => 'required|string',
            'company_address' => 'required|string',
            'company_hq' => 'required|string',
            'form_nda_coc_sow' => 'nullable|file', 
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
        $client = $request->all();
        if ($request->hasFile('form_nda_coc_sow')) {
            $file = $request->file('form_nda_coc_sow');
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->move(public_path('client-nda'), $fileName); 
            $client['form_nda_coc_sow'] = $fileName;
        }
        $client['type'] = 'normal';
        $client['user_id'] = Auth::user()->id;
        Client::create($client);

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has uploaded client !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        return response()->json(['success' => true, 'message' => 'Client created successfully!']);
    }
    public function edit($id){
        $client = Client::find($id);
        return view('clients.edit',compact('client'));
    }
    public function update(Request $request, $id)
    {
        $rules = [
            'company_name' => 'required|string',
            'registration_no' => 'required|string',
            'company_address' => 'required|string',
            'company_hq' => 'required|string',
            'form_nda_coc_sow' => 'nullable|file', 
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
    
        $client = Client::findOrFail($id);
    
        $data = $request->only([
            'company_name',
            'registration_no',
            'company_address',
            'company_hq'
        ]);
    
        if ($request->hasFile('form_nda_coc_sow')) {
            $oldFilePath = public_path('client-nda/' . $client->form_nda_coc_sow);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            
            $file = $request->file('form_nda_coc_sow');
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->move(public_path('client-nda'), $fileName); 
            $data['form_nda_coc_sow'] = $fileName;
        }
    
        $client->update($data);

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has edited client !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);
    
        return response()->json(['success' => true, 'message' => 'Client updated successfully!']);
    }    

    public function destroy($id)
    {
        $client = Client::find($id);
    
        if ($client && !empty($client->form_nda_coc_sow)) {
            $file = public_path('client-nda/' . $client->form_nda_coc_sow);
    
            if (file_exists($file) && !is_dir($file)) {
                unlink($file);
            }
        }
    
        $client->delete();

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has deleted client !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);
    
        return response()->json(['message' => 'Client deleted successfully']);
    }

    public function workingWithClients(Request $request)
    {
        $query = Client::whereHas('activities');

        if ($request->filled('from_date')) {
            $query->filterByFromDate($request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->filterByToDate($request->to_date);
        }
        $clients = $query->orderBy('created_at', 'asc')->get();

        return view('clients.workwithus_clients', compact('clients'));
    }

    public function indexFollowUpClient(Request $request){
        $query = FollowUpClient::query();
        if ($request->filled('from_date')) {
            $query->filterByFromDate($request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->filterByToDate($request->to_date);
        }
        $clients = $query->orderBy('created_at', 'asc')->get();
        return view('clients.index_followup_clients',compact('clients'));
    }
    public function createFollowUpClient(){
        return view('clients.followup_clients');
    }
    public function storeFollowUpClient(Request $request)
    {
        $rules = [
            'company_name' => 'required',
            'worth' => 'required',
            'sport_areas' => 'required',
            'company_hq' => 'required',
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
        $client = $request->all();
        $client['type'] = 'followup';
        $client['user_id'] = Auth::user()->id;
        FollowUpClient::create($client);

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has uploaded follow-up client !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        return response()->json(['success' => true, 'message' => 'Follow-up Client created successfully!']);
    }
    public function destroyFollowUpClient($id){
        $client = FollowUpClient::find($id);
        $client->delete();

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has deleted follow-up client !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        return response()->json(['message' => 'Client deleted successfully']);
    }
    public function editFollowUpClient($id){
        $client = FollowUpClient::find($id);
        return view('clients.followup_client_edit',compact('client'));
    }
    public function updateFollowUpClient(Request $request, $id)
    {
        $rules = [
            'company_name' => 'required',
            'worth' => 'required',
            'sport_areas' => 'required',
            'company_hq' => 'required',
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
    
        $client = FollowUpClient::findOrFail($id);
         
        $data = $request->all();
    
        $client->update($data);

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has updated follow-up client !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);
    
        return response()->json(['success' => true, 'message' => 'Client updated successfully!']);
    } 
    public function addToNormal($id)
    {
        $client = FollowUpClient::find($id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }
        $client->type = 'followup';
        $normal_client = $client->toArray();
    
        $client->delete();
        Client::create($normal_client);

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has changed follow-up client to normal client !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);
    
        return response()->json(['message' => 'Client uploaded successfully']);
    }
    public function changeStatus(Request $request)
    {
        $client = FollowUpClient::find($request->input('clientId'));
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }
        $client->status =  $request->input('status');
        $client->time = Carbon::now()->format('Y-m-d H:i:s');
        $client->save();

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has changed the state of follow-up client !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);


        return response()->json(['message' => 'Status changed successfully' , 'clientId' => $request->input('clientId') , 'client' => $client]);
    } 
}
