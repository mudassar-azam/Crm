<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadAndMemberController extends Controller
{
    public function index(){
        $leads = Lead::all();
        return view('attendance.leads-members',compact('leads'));
    }

    public function assign(Request $request) {
        $rules = [
            'manager' => 'required',
            'lead' => 'required',
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
    
        $managerId = $request->input('manager');
        $leadId = $request->input('lead');
        $memberId = $request->input('member');
    
        if ($managerId && $leadId) {
            $existingLead = Lead::where('user_id', $leadId)
                ->where('manager_id', '<>', $managerId)
                ->exists();
    
            if ($existingLead) {
                $errors[] = [
                    'field' => 'lead',
                    'message' => 'Lead is already assigned to other manager !'
                ];
                return response()->json(['success' => false, 'errors' => $errors], 422);
            }
    
            $lead = Lead::firstOrCreate([
                'user_id' => $leadId,
                'manager_id' => $managerId,
            ]);

            $leadUser = User::find($leadId);
            $manager = User::find($managerId);
            if($manager->role->name == 'HR Manager'){
                $leadUser->role_type = 'HrmLead';
            }elseif($manager->role->name == 'Recruitment Manager'){
                $leadUser->role_type = 'RecmLead';
            }elseif($manager->role->name == 'Service Delivery Manager'){
                $leadUser->role_type = 'SdmLead';
            }else{
                $leadUser->role_type = 'AccmLead';
            }
            $leadUser->save();
            
            if($memberId == null){
                if (!$lead->wasRecentlyCreated) {
                    $errors[] = [
                        'field' => 'lead',
                        'message' => 'Lead already exists.'
                    ];
                    return response()->json(['success' => false, 'errors' => $errors], 422);
                }
            }
    
            if ($memberId) {
                $member = Member::firstOrCreate([
                    'user_id' => $memberId,
                    'lead_id' => $lead->id,
                ]);           
                 
                $memberUser = User::find($memberId);
                if($manager->role->name == 'HR Manager'){
                    $memberUser->role_type = 'HrmMember';
                }elseif($manager->role->name == 'Recruitment Manager'){
                    $memberUser->role_type = 'RecmMember';
                }elseif($manager->role->name == 'Service Delivery Manager'){
                    $memberUser->role_type = 'SdmMember';
                }else{
                    $memberUser->role_type = 'AccmMember';
                }
                $memberUser->save();

            }
            
        }
        return response()->json(['success' => true, 'message' => 'Assigned successfully!']);
    }

    public function edit($id){
        $lead = Lead::with('members', 'manager', 'user')->findOrFail($id);
        $managers = User::whereIn('role_id', [2, 3, 4 ,5])->get();
        $leads = User::where('role_id', 6)->get();
        $none_assign_members = User::where('role_id', 7)->whereDoesntHave('memberships', function($query) {$query->whereNotNull('lead_id');})->get();
        $assign_members = Member::where('lead_id', $id)->get();
        return view('attendance.edit', compact('lead','leads', 'managers', 'none_assign_members', 'assign_members'));
    }


    public function update(Request $request)
    {
        $leadId = $request->input('lead_id');
        $lead = Lead::findOrFail($leadId);
    
        $validatedData = $request->validate([
            'manager_id' => 'required|exists:users,id',
            'user_id' => 'required|exists:users,id',
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id',
        ]);
    
        if ($lead->user_id != $request->user_id) {
            $existingLead = Lead::where('user_id', $request->user_id)->first();
            if ($existingLead) {
                return response()->json([
                    'success' => false,
                    'errors' => [['field' => 'lead', 'message' => 'This lead is already assigned to a manager. Delete that first!']]
                ], 422);
            }
        }
    
        $lead->update($validatedData);
    
        $leadUser = User::find($lead->user_id);
        $managerUser = User::find($lead->manager_id);
    
        if ($managerUser->role->name == 'HR Manager') {
            $leadUser->role_type = 'HrmLead';
        } elseif ($managerUser->role->name == 'Recruitment Manager') {
            $leadUser->role_type = 'RecmLead';
        } elseif ($managerUser->role->name == 'Service Delivery Manager') {
            $leadUser->role_type = 'SdmLead';
        } else {
            $leadUser->role_type = 'AccmLead';
        }
        $leadUser->save();
    
        $currentMembers = Member::where('lead_id', $leadId)->pluck('user_id')->toArray();
        $newMembers = $request->input('members', []);
    
        $membersToRemove = array_diff($currentMembers, $newMembers);

        if (!empty($membersToRemove)) {
            foreach ($membersToRemove as $memberId) {
                $memberUser = User::find($memberId);
                if ($memberUser) {
                    $memberUser->role_type = null;
                    $memberUser->save();
                }
            }
    
            Member::where('lead_id', $leadId)->whereIn('user_id', $membersToRemove)->delete();
            $currentMembers = Member::where('lead_id', $leadId)->pluck('user_id')->toArray();
        }
    
        $membersToAdd = array_diff($newMembers, $currentMembers);
        foreach ($membersToAdd as $memberId) {
            Member::create([
                'lead_id' => $leadId,
                'user_id' => $memberId,
            ]);
        }

    
        $membersToUpdate = array_unique(array_merge($newMembers, $currentMembers));
        foreach ($membersToUpdate as $memberId) {
            $memberUser = User::find($memberId);
            if ($memberUser) {
                if ($managerUser->role->name == 'HR Manager') {
                    $memberUser->role_type = 'HrmMember';
                } elseif ($managerUser->role->name == 'Recruitment Manager') {
                    $memberUser->role_type = 'RecmMember';
                } elseif ($managerUser->role->name == 'Service Delivery Manager') {
                    $memberUser->role_type = 'SdmMember';
                } else {
                    $memberUser->role_type = 'AccmMember';
                }
                $memberUser->save();
            }
        }
    
        return response()->json(['success' => true, 'message' => 'Updated successfully!']);
    }
    

    

    public function destroy($id){
        $lead = Lead::findOrFail($id);
        foreach ($lead->members as $member) {

            $memberUser = User::find($member->user_id);
            $memberUser->role_type = null;
            $memberUser->save();
            $member->delete();

        }

        $user = User::find($lead->user_id);
        $user->role_type = null;
        $user->save();

        $lead->delete();
        return response()->json(['success' => true]);
    } 

}
