<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Models\AccountPaymentDetail;
use App\Models\Availability;
use App\Models\BGV;
use App\Models\City;
use App\Models\Country;
use App\Models\EngineerTool;
use App\Models\Resource;
use App\Models\Skill;
use App\Models\Tool;
use App\Models\Lead;
use App\Models\Member;
use App\Models\Notification;
use App\Models\Nationality;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EngineerCredentials;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ResourcesImport;

class ResourceController extends Controller
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
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Resource::query();

        if(hasAdminRole()){
            $query = Resource::query();

        }elseif(RecManager()){

            $leads = Lead::where('manager_id', $user->id)->get();

            $allMemberIds = collect();
            foreach ($leads as $lead) {
                $members = $lead->members; 
                $allMemberIds = $allMemberIds->merge($members->pluck('user_id'));
            }
            $leadIds = $leads->pluck('user_id');
            $allAdmins = User::where('role_id', 1)->get();
            $allAdminsIds = $allAdmins->pluck('id');
            $combineIds = $leadIds->merge($allAdminsIds);
            $query->whereIn('user_id', $combineIds)->orWhereIn('user_id', $allMemberIds)->orWhere('user_id', $user->id);

        }elseif(SdmManager()){
            $query = Resource::query();
        }elseif(RecLead()){

            $lead = Lead::where('user_id', $user->id)->first();
            $members = Member::where('lead_id', $lead->id)->get();

            $membersIds = $members->pluck('user_id');
            $allAdmins = User::where('role_id', 1)->get();
            $allAdminsIds = $allAdmins->pluck('id');
            $combineIds = $membersIds->merge($allAdminsIds);
            $query->whereIn('user_id', $combineIds)->orWhere('user_id', $user->id);

        }elseif(SdmLead()){
            $query = Resource::query();
        }elseif(SdmMember()){
            $query = Resource::query();
        }else{
            $allAdmins = User::where('role_id', 1)->get();
            $allAdminsIds = $allAdmins->pluck('id');
            $query->where('user_id', $user->id)->orWhereIn('user_id', $allAdminsIds);
        }
    
        if ($request->filled('country') && $request->country !== 'All') {
            $query->filterByCountry($request->country);
        }
    
        if ($request->filled('tech_city') && $request->tech_city !== '' && $request->tech_city !== 'Select City') {
            $query->filterByCity($request->tech_city);
        }
    
        if ($request->filled('availability') && $request->availability !== '') {
            $query->whereHas('availabilities', function ($query) use ($request) {
                $query->where('availabilities.id', $request->availability);
            });
        }

        if ($request->filled('status') && $request->status !== '') {
            $query->whereHas('availabilities', function ($query) use ($request) {
                if ($request->status === 'inactive') {
                    $query->where('availabilities.id', 1);
                } elseif ($request->status === 'active') {
                    $query->where('availabilities.id', '!=', 1);
                }
            });
        }
    
        if ($request->filled('tools') && $request->tools !== '') {
            $tools = explode(',', $request->tools); 
            $query->whereHas('engineerTools', function ($query) use ($tools) {
                $query->whereIn('engineer_tools.id', $tools);
            });
        }
    
        if ($request->filled('worked_with_us') && $request->worked_with_us !== '') {
            $query->filterByWorked($request->worked_with_us);
        }
    
        if ($request->filled('BGV') && $request->BGV !== '') {
            $BGV = $request->BGV;
            if ($BGV == 1) {
                $query->has('bgvs');
            } elseif ($BGV == 0) {
                $query->doesntHave('bgvs');
            }
        }
    
        $resources = $query->with('nationality', 'engineerTools', 'country', 'availabilities', 'tools', 'city', 'paymentDetails')->get();
    
        $countries = Country::all();
        $cities = City::all();
        $availabilities = Availability::all();
        $tools = EngineerTool::all();
    
        return view('resources.index', [
            'resources' => $resources,
            'countries' => $countries,
            'cities' => $cities,
            'availabilities' => $availabilities,
            'tools' => $tools,
            'searchedCity' => $request->tech_city,
        ]);
    }
    
    public function create(){
          $skills=Skill::all();
          $tools=Tool::all();
          $engineerTools=EngineerTool::all();
          $availabilities=Availability::all();
          $countries = Country ::all();
          $nationalities = Nationality::all();
        return view("resources.create",compact('skills','tools','availabilities','countries','engineerTools','nationalities'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'nationality_id' => 'nullable|array',
            'nationality_id.*' => 'exists:nationalities,id',
            'email' => 'required|string|email|max:255|unique:resources,email',
            'region' => 'nullable|string|max:255',
            'language' => [
                'required',
                'regex:/^\s*[a-zA-Z]+\s*(?:\s*:\s*[a-zA-Z0-9]+)?\s*(?:,\s*[a-zA-Z]+\s*(?:\s*:\s*[a-zA-Z0-9]+)?\s*)*$/'
            ],
            'whatsapp_link' => 'nullable|string',
            'certification' => 'nullable|string|max:255',
            'whatsapp' => 'required',
            'linked_in' => 'nullable',
            'contact_no' => 'required|string|unique:resources,contact_no',
            'personal_details' => 'nullable|string',
            'last_degree' => 'nullable|string|max:255',
            'country_id' => 'required|integer',
            'city_name' => 'required|string|max:255',
            'skill_id' => 'nullable|array',
            'skill_id.*' => 'exists:skills,id',
            'company_tools' => 'nullable|array',
            'company_tools.*' => 'exists:tools,id',
            'engineer_tools' => 'nullable|array',
            'engineer_tools.*' => 'exists:engineer_tools,id',
            'avability_id' => 'required|array',
            'avability_id.*' => 'required|exists:availabilities,id',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'address' => 'required|string',
            'work_status' => 'required|string|max:255',
            'worked_with_us' => 'required|boolean',
            'resume' => 'required',
            'visa' => 'nullable',
            'license' => 'nullable',
            'passport' => 'nullable',
            'daily_rate' => 'nullable',
            'hourly_rate' => 'required|numeric',
            'weekly_rates' => 'nullable',
            'monthly_rates' => 'nullable',
            'rate_currency' => 'required|string|max:255',
            'half_day_rates' => 'nullable',
            'rate_snap' => 'required',
            'account_payment_details_id' => 'nullable|exists:account_payment_details,id',
            'bank_name' => 'nullable',
            'bank_branch_name' => 'nullable',
            'account_holder_name' => 'nullable',
            'bank_branch_code' => 'nullable',
            'bank_city_name' => 'nullable',
            'account_number' => 'nullable',
            'IBAN' => 'nullable',
            'BIC_or_Swift_code' => 'nullable',
            'sort_code' => 'nullable',
            'country' => 'nullable',
            'transferwise_id' => 'nullable'
        ];
        $messages = [
            'contact_no.unique' => 'Resource  already exists !',
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

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has added a resource !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);
        
        DB::beginTransaction();

        try {
            $validatedData = $validator->validated();
            $cityNames = array_map('trim', explode(',', $validatedData['city_name']));
            foreach ($cityNames as $cityName) {
                $city = City::where('name', $cityName)
                            ->where('country_id', $validatedData['country_id'])
                            ->first();
                if (!$city) {
                    $city = City::create([
                        'name' => $cityName,
                        'country_id' => $validatedData['country_id']
                    ]);
                }
            }
            $validatedData['user_id'] = Auth::user()->id;
            $filesToProcess = ['resume', 'visa', 'license', 'passport', 'rate_snap'];

            foreach ($filesToProcess as $file) {
                if ($request->hasFile($file)) {
                    $uploadedFile = $request->file($file);
                    $fileName = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                    $uploadedFile->move(public_path('resources'), $fileName);
                    $validatedData[$file] = $fileName;
                }
            }
            $paymentDetails = [
                'bank_name' => $validatedData['bank_name'] ?? null,
                'bank_branch_name' => $validatedData['bank_branch_name'] ?? null,
                'bank_branch_code' => $validatedData['bank_branch_code'] ?? null,
                'bank_city_name' => $validatedData['bank_city_name'] ?? null,
                'account_holder_name' => $validatedData['account_holder_name'] ?? null,
                'account_number' => $validatedData['account_number'] ?? null,
                'IBAN' => $validatedData['IBAN'] ?? null,
                'BIC_or_Swift_code' => $validatedData['BIC_or_Swift_code'] ?? null,
                'sort_code' => $validatedData['sort_code'] ?? null,
                'country' => $validatedData['country'] ?? null,
                'transferwise_id' => $validatedData['transferwise_id'] ?? null,
            ];
            $payment = AccountPaymentDetail::create($paymentDetails);
            $validatedData['account_payment_details_id'] = $payment->id;
            $resource = Resource::create($validatedData);

            $password = Str::random(10); 
            $newUserId = mt_rand(100000, 999999);
            
            $user = User::create([
                'email' => $validatedData['email'], 
                'user_name' => $validatedData['name'], 
                'password' => Hash::make($password), 
                'role_type' => 'engineer',
                'role_id' => null, 
                'check_in' => null,
                'check_out' => null,
                'user_id' => $newUserId, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            try {
                Mail::to($validatedData['email'])->send(new EngineerCredentials($validatedData['email'], $password));
                Log::info('Email sent to: ' . $validatedData['email']);
            } catch (\Exception $e) {
                Log::error('Failed to send email: ' . $e->getMessage());
            }
           

            if (isset($validatedData['skill_id'])) {
                $resource->skills()->sync($validatedData['skill_id']);
            }
            if (isset($validatedData['tool_id'])) {

                $resource->tools()->sync($validatedData['tool_id']);
            }
            if (isset($validatedData['engineer_tools'])) {

                $resource->engineerTools()->sync($validatedData['engineer_tools']);
            }
            if (isset($validatedData['avability_id'])) {
                $resource->availabilities()->sync($validatedData['avability_id']);
            }

            if (isset($validatedData['nationality_id'])) {
                $resource->resourceNationalities()->sync($validatedData['nationality_id']);
            }

            if ($request->hasFile('BGV')) {

                foreach ($request->file('BGV') as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('resources'), $filename); 

                    BGV::create([
                        'file_name' => $filename,
                        'resource_id' => $resource->id,
                    ]);
                }
            }
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Resource created successfully!']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'An error occurred during the creation process.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id){
        $skills=Skill::all();
        $tools=Tool::all();
        $engineerTools=EngineerTool::all();
        $availabilities=Availability::all();
        $cities= City ::all();
        $countries= Country ::all();
        $resource=Resource::find($id);
        $nationalities = Nationality::all();
        return view('resources.edit',compact('skills','tools','availabilities','cities','engineerTools','countries','resource','nationalities'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'nationality_id' => 'nullable|array',
            'nationality_id.*' => 'exists:nationalities,id',
            'email' => 'required',
            'region' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'language' => [
                'required',
                'regex:/^\s*[a-zA-Z]+\s*(?:\s*:\s*[a-zA-Z0-9]+)?\s*(?:,\s*[a-zA-Z]+\s*(?:\s*:\s*[a-zA-Z0-9]+)?\s*)*$/'
            ],
            'whatsapp_link' => 'nullable|string',
            'certification' => 'nullable|string|max:255',
            'whatsapp' => 'required',
            'linked_in' => 'nullable',
            'contact_no' => 'required|string',
            'personal_details' => 'nullable|string',
            'last_degree' => 'nullable|string|max:255',
            'country_id' => 'required|integer',
            'city_name' => 'required|string|max:255',
            'skill_id' => 'nullable|array',
            'skill_id.*' => 'exists:skills,id',
            'company_tools' => 'nullable|array',
            'company_tools.*' => 'exists:tools,id',
            'engineer_tools' => 'nullable|array',
            'engineer_tools.*' => 'exists:engineer_tools,id',
            'avability_id' => 'required|array',
            'avability_id.*' => 'required|exists:availabilities,id',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'address' => 'required|string',
            'work_status' => 'required|string|max:255',
            'worked_with_us' => 'required|boolean',
            'resume' => 'nullable',
            'visa' => 'nullable',
            'license' => 'nullable',
            'passport' => 'nullable',
            'daily_rate' => 'nullable',
            'hourly_rate' => 'required|numeric',
            'weekly_rates' => 'nullable',
            'monthly_rates' => 'nullable',
            'rate_currency' => 'required|string|max:255',
            'half_day_rates' => 'nullable',
            'rate_snap' => 'nullable',
            'account_payment_details_id' => 'nullable|exists:account_payment_details,id',
            'bank_name' => 'nullable',
            'bank_branch_name' => 'nullable',
            'account_holder_name' => 'nullable',
            'bank_branch_code' => 'nullable',
            'bank_city_name' => 'nullable',
            'account_number' => 'nullable',
            'IBAN' => 'nullable',
            'BIC_or_Swift_code' => 'nullable',
            'sort_code' => 'nullable',
            'country' => 'nullable',
            'transferwise_id' => 'nullable'
            
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
        $message = " has updated a resource !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);
        DB::beginTransaction();

        try {
            $validatedData = $validator->validated();
            $filesToProcess = ['resume', 'visa', 'license', 'passport', 'rate_snap'];

            foreach ($filesToProcess as $file) {
                if ($request->hasFile($file)) {
                    $uploadedFile = $request->file($file);
                    $fileName = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                    $uploadedFile->move(public_path('resources'), $fileName); 
                    $validatedData[$file] = $fileName;
                }
            }
            if ($request->has('account_payment_details_id')) {
                $paymentDetails = [
                    'bank_name' => $validatedData['bank_name'] ?? null,
                    'bank_branch_name' => $validatedData['bank_branch_name'] ?? null,
                    'bank_branch_code' => $validatedData['bank_branch_code'] ?? null,
                    'bank_city_name' => $validatedData['bank_city_name'] ?? null,
                    'account_holder_name' => $validatedData['account_holder_name'] ?? null,
                    'account_number' => $validatedData['account_number'] ?? null,
                    'IBAN' => $validatedData['IBAN'] ?? null,
                    'BIC_or_Swift_code' => $validatedData['BIC_or_Swift_code'] ?? null,
                    'sort_code' => $validatedData['sort_code'] ?? null,
                    'country' => $validatedData['country'] ?? null,
                    'transferwise_id' => $validatedData['transferwise_id'] ?? null,
                ];

                AccountPaymentDetail::findOrFail($validatedData['account_payment_details_id'])->update($paymentDetails);
            }

            $resource = Resource::findOrFail($id);
            $resource->update($validatedData);

            if (isset($validatedData['skill_id'])) {
                Resource::findOrFail($id)->skills()->sync($validatedData['skill_id']);
            }

            if (isset($validatedData['company_tools'])) {

                Resource::findOrFail($id)->tools()->sync($validatedData['company_tools']);
            }
            if (isset($validatedData['engineer_tools'])) {

                Resource::findOrFail($id)->engineerTools()->sync($validatedData['engineer_tools']);
            }

            if (isset($validatedData['avability_id'])) {
                Resource::findOrFail($id)->availabilities()->sync($validatedData['avability_id']);
            }

            if (isset($validatedData['nationality_id'])) {
                Resource::findOrFail($id)->resourceNationalities()->sync($validatedData['nationality_id']);
            }

            if ($request->hasFile('BGV')) {
                Bgv::where('resource_id', $id)->delete();
                foreach ($request->file('BGV') as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('resources'), $filename); 

                    Bgv::create([
                        'file_name' => $filename,
                        'resource_id' => $resource->id,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Resource update successfully!']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'An error occurred during the update process.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has deleted a resource !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);
        $resource = Resource::find($id);
        if (!$resource) {
            return response()->json(['message' => 'Resource not found'], 404);
        }
        try {

            $user = User::where('email' , $resource->email)->first();
            $user->delete();
            $resource->delete();

            return response()->json(['message' => 'Resource deleted successfully']);
        } catch (\Exception $e) {
            // Return error response if deletion fails
            return response()->json(['message' => 'Failed to delete resource', 'error' => $e->getMessage()], 500);
        }
    }

    public  function active(){
        $resources = Resource::whereHas('availabilities', function ($query) {
            $query->where('availability_id', '!=', 1);
        })->get();
        return view('resources.active', ['resources' => $resources]);
    }

    public  function worked(){
        $resources = Resource::where('worked_with_us', 1)
        ->orWhereHas('activities', function ($query) {
            $query->where('activity_status', '!=', 'pending');
        })->get();
        return view('resources.worked_with_us', compact('resources'));
    }
    

    public function track(Request $request)
    {
        $query = Resource::query()->with('city', 'country', 'availabilities', 'tools', 'skills');
        $resources = collect();

        $hasSearchCriteria = $request->filled('id') || $request->filled('name');

        if ($request->filled('id') || $request->filled('name')) {
            if ($request->filled('id')) {
                $query->filterById($request->id);
            }
            if ($request->filled('name')) {
                $query->filterByName($request->name);
            }
            $resources = $query->get();
        }

        $user = Auth::user();
        $roleName = $user->role->name;
        $roleType = $user->role_type;
        $shouldReturnEmpty = false;

        if (RecManager()) {
            $leads = Lead::where('manager_id', $user->id)->get();

            $allMemberIds = collect();
            foreach ($leads as $lead) {
                $members = $lead->members;
                $allMemberIds = $allMemberIds->merge($members->pluck('user_id'));
            }
            $leadIds = $leads->pluck('user_id')->push($user->id);

            $shouldReturnEmpty = $resources->every(function ($resource) use ($allMemberIds, $leadIds) {
                return !$allMemberIds->contains($resource->user_id) && !$leadIds->contains($resource->user_id);
            });
        } elseif (RecLead()) {
            $lead = Lead::where('user_id', $user->id)->first();
            $members = Member::where('lead_id', $lead->id)->get();
            $membersIds = $members->pluck('user_id')->push($user->id);

            $shouldReturnEmpty = $resources->every(function ($resource) use ($membersIds) {
                return !$membersIds->contains($resource->user_id);
            });
        } elseif (RecMember()) {
            $shouldReturnEmpty = $resources->every(function ($resource) use ($user) {
                return $resource->user_id != $user->id;
            });
        }

        if ($hasSearchCriteria && $shouldReturnEmpty) {
            $resources = collect();
            $noResults = true;
        } else {
            $noResults = $hasSearchCriteria && $resources->isEmpty();
        }

        return view('resources.track_resources', [
            'resources' => $resources,
            'searchName' => $request->name,
            'searchId' => $request->id,
            'noResults' => $noResults,
        ]);
    }


    public function graph()
    {
        if(RecManager()){

            $user = Auth::user();

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

            $userIds = $users->pluck('id');

            $resources = Resource::select('name', 'latitude', 'longitude', 'email', 'whatsapp_link', 'address')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->whereIn('user_id', $userIds)
            ->get();
            return view('resources.graphicalRepresentation', compact('resources'));

        }else{

            $resources = Resource::select('name', 'latitude', 'longitude','email','whatsapp_link','address')
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get();
            return view('resources.graphicalRepresentation', compact('resources'));
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $userName = Auth::user()->user_name; 
        Excel::import(new ResourcesImport($userName), $request->file('file'));

        return redirect()->back();
    }

    public function getResourceCities($id){
        $cities = City::where('country_id', $id)->get();
        return response()->json($cities);
    }

    public function checkContact(Request $request)
    {
        $exists = Resource::where('contact_no', $request->contact_no)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function checkEmail(Request $request)
    {
        $exists = Resource::where('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }
}
