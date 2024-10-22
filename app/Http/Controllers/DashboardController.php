<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Note;
use App\Models\Anounsement;
use App\Models\Activity;
use App\Models\Client;
use App\Models\Resource;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Lead;
use App\Models\Member;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $user = Auth::user();
            if ($user->role_type === 'engineer') {
                return redirect()->route('engineer.dashboard');
            }
            $today = Carbon::today()->format('Y-m-d'); 
            $notes = Note::where('user_id', Auth::user()->id)->get();
            $anounsements = Anounsement::all();
            $activities = Activity::whereIn('activity_status', ['closed', 'approved'])->get();
            // $clients = Client::with('activities')->get();
            $clients = Client::with('activities')->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->get();
            $invoices = Invoice::whereNull('resource_id')->where('status', 'received')->with('activity')->get();
            $techInvoices = Invoice::whereNull('client_id')->where('status', 'received')->with('activity')->get();
    

            $monthlyRevenue = $invoices->filter(function($invoice) {
                return $invoice->account === 'euro'; 
            })->groupBy(function($invoice) {
                return Carbon::parse($invoice->paid_time)->format('Y-m'); 
            })->map(function ($group) {
                return $group->sum(function($invoice) {
                    return $invoice->activity ? (float) $invoice->activity->total_customer_payments : 0;
                });
            });

            $monthlyRevenueInDollars = $invoices->filter(function($invoice) {
                return $invoice->account === 'usd'; 
            })->groupBy(function($invoice) {
                return Carbon::parse($invoice->paid_time)->format('Y-m'); 
            })->map(function ($group) {
                return $group->sum(function($invoice) {
                    return $invoice->activity ? (float) $invoice->activity->total_customer_payments : 0;
                });
            });


            $techRevenueInDollars = $techInvoices->filter(function($techInvoice) {
                return $techInvoice->account === 'usd'; 
            })->groupBy(function($techInvoice) {
                return Carbon::parse($techInvoice->paid_time)->format('Y-m'); 
            })->map(function ($group) {
                return $group->sum(function($techInvoice) {
                    return $techInvoice->activity ? (float) $techInvoice->activity->total_tech_payments : 0;
                });
            });


            
            $techRevenueInEuros = $techInvoices->filter(function($techInvoice) {
                return $techInvoice->account === 'euro'; 
            })->groupBy(function($techInvoice) {
                return Carbon::parse($techInvoice->paid_time)->format('Y-m'); 
            })->map(function ($group) {
                return $group->sum(function($techInvoice) {
                    return $techInvoice->activity ? (float) $techInvoice->activity->total_tech_payments : 0;
                });
            });


            $labels = $monthlyRevenue->keys()->toArray();
            $data = $monthlyRevenue->values()->toArray();

            $labels2 = $monthlyRevenueInDollars->keys()->toArray();
            $data2 = $monthlyRevenueInDollars->values()->toArray();

            $labels4 = $techRevenueInDollars->keys()->toArray();
            $data4 = $techRevenueInDollars->values()->toArray();

            $labels5 = $techRevenueInEuros->keys()->toArray();
            $data5 = $techRevenueInEuros->values()->toArray();

            $sumInEuro = array_sum($data);
            $sumInDollars = array_sum($data2);
            $techsumInDollars = array_sum($data4);
            $techsumInEuros = array_sum($data5);


            $netRevenueInDollars = $monthlyRevenueInDollars->map(function($value, $key) use ($techRevenueInDollars) {
                return $value - ($techRevenueInDollars->get($key, 0));
            });

            
            $netRevenueInEuros = $monthlyRevenue->map(function($value, $key) use ($techRevenueInEuros) {
                return $value - ($techRevenueInEuros->get($key, 0)); 
            });
            
            
            $allMonths = $monthlyRevenueInDollars->keys()->merge($techRevenueInDollars->keys())->merge($monthlyRevenue->keys())->merge($techRevenueInEuros->keys())->unique()->sort();

            $graphData = [];
            foreach ($allMonths as $month) {
                $revenueInDollars = $monthlyRevenueInDollars->get($month, 0) - $techRevenueInDollars->get($month, 0);
                $revenueInEuros = $monthlyRevenue->get($month, 0) - $techRevenueInEuros->get($month, 0);
                $graphData[] = [$month, $revenueInDollars, $revenueInEuros];
            }

            if (empty($graphData)) {
                $graphData = [['No Data', 0, 0]]; 
            }
            
            $total_resources = Resource::all();
            $worked_resources = Resource::where('worked_with_us', 1)->get();
            $approved_activities = Activity::where('activity_status', 'approved')->get();
            $confirmed_activities = Activity::where('activity_status', 'confirmed')->get();
            $tech_unpaid = Invoice::select('resource_id', 'client_id', 'status')
                ->whereNull('client_id')
                ->where('status', 'inprocess')
                ->distinct('resource_id')
                ->get();
            $tech_paid = Invoice::select('resource_id', 'client_id', 'status')
                ->whereNull('client_id')
                ->where('status', 'received')
                ->distinct('resource_id')
                ->get();
            $client_unpaid = Invoice::select('resource_id', 'client_id', 'status')
                ->whereNull('resource_id')
                ->where('status', 'inprocess')
                ->distinct('client_id')
                ->get();
            $client_paid = Invoice::select('resource_id', 'client_id', 'status')
                ->whereNull('resource_id')
                ->where('status', 'received')
                ->distinct('client_id')
                ->get();
            $bdmanagers = User::where('role_id' , 8)->get();
            $attendances = Attendance::whereDate('date', '=', $today)->get();
            if(hasAdminRole()){
                return view('index', compact(
                    'tech_unpaid',
                    'tech_paid',
                    'client_unpaid',
                    'client_paid',
                    'notes',
                    'anounsements',
                    'activities',
                    'clients',
                    'approved_activities',
                    'confirmed_activities',
                    'total_resources',
                    'worked_resources',
                    'bdmanagers',
                    'attendances',
                    'data',
                    'labels',
                    'labels2',
                    'data2',
                    'labels4',
                    'data4',
                    'techsumInEuros',
                    'labels5',
                    'data5',
                    'techsumInDollars',
                    'sumInDollars',
                    'sumInEuro',
                    'graphData'
                ));
            }elseif(hasAccountRole()){
                if(Auth::user()->role->name == 'Accounts Manager'){
                    $users = User::where('role_id', 5)->orWhere('role_type', 'AccmLead')->orWhere('role_type', 'AccmMember')->get();
                    $usersId = $users->pluck('id');
                    $attendances = Attendance::whereDate('date', '=', $today)->whereIn('user_id', $usersId)->get();
                }elseif(hasLeadRole()){
                    $lead = Lead::where('user_id' , $user->id)->first();
                    if($lead){
                        $members = $lead->members;
                        if(!$members->isEmpty()){
                            $totalMembers = $members->map(function($member) {
                                return $member->user; 
                            });
                            $usersId = $totalMembers->pluck('id');
                            $attendances = Attendance::whereDate('date', '=', $today)->whereIn('user_id', $usersId)->orwhere('user_id', $user->id)->get();
                        }else{
                            $attendances = Attendance::where('user_id', $user->id)->get();
                        }

                    }else{
                        $attendances = Attendance::where('user_id', $user->id)->get();
                    }
                }else{
                    $attendances = Attendance::where('user_id', $user->id)->get();
                }
                return view('account-index', compact(
                    'tech_unpaid',
                    'tech_paid',
                    'client_unpaid',
                    'client_paid',
                    'notes',
                    'anounsements',
                    'activities',
                    'clients',
                    'approved_activities',
                    'confirmed_activities',
                    'total_resources',
                    'worked_resources',
                    'attendances',
                    'data',
                    'labels',
                    'labels2',
                    'data2',
                    'labels4',
                    'data4',
                    'techsumInEuros',
                    'labels5',
                    'data5',
                    'techsumInDollars',
                    'sumInDollars',
                    'sumInEuro',
                    'graphData'
                ));
            }elseif(OnlyRecruitmentRole()){
                if(Auth::user()->role->name == 'Recruitment Manager'){
                    $users = User::where('role_id', 3)->orWhere('role_type', 'RecmLead')->orWhere('role_type', 'RecmMember')->get();
                    $usersId = $users->pluck('id');
                    $allusers = User::where('role_type', 'RecmLead')->orWhere('role_type', 'RecmMember')->get();
                    $total_resources = Resource::whereIn('user_id', $usersId)->orWhere('user_id', $user->id)->get();
                    $attendances = Attendance::whereDate('date', '=', $today)->whereIn('user_id', $usersId)->get();
                }elseif(hasLeadRole()){
                    $lead = Lead::where('user_id' , $user->id)->first();
                    if($lead){
                        $members = $lead->members;
                        if(!$members->isEmpty()){
                            $totalMembers = $members->map(function($member) {
                                return $member->user; 
                            });
                            $usersId = $totalMembers->pluck('id');
                            $attendances = Attendance::whereDate('date', '=', $today)->whereIn('user_id', $usersId)->orwhere('user_id', $user->id)->get();
                            $total_resources = Resource::whereIn('user_id', $usersId)->orWhere('user_id', $user->id)->get();
                        }else{
                            $attendances = Attendance::where('user_id', $user->id)->get();
                            $total_resources = Resource::where('user_id', $user->id)->get();
                        }

                    }else{
                        $attendances = Attendance::where('user_id', $user->id)->get();
                        $total_resources = Resource::where('user_id', $user->id)->get();
                    }
                }else{
                    $attendances = Attendance::where('user_id', $user->id)->get();
                    $total_resources = Resource::where('user_id', $user->id)->get();
                }
                return view('recruitment-index', compact(
                    'tech_unpaid',
                    'tech_paid',
                    'client_unpaid',
                    'client_paid',
                    'notes',
                    'anounsements',
                    'activities',
                    'clients',
                    'approved_activities',
                    'confirmed_activities',
                    'total_resources',
                    'worked_resources',
                    'attendances'
                ));
            }elseif(OperationRole()){
                if(Auth::user()->role->name == 'Service Delivery Manager'){
                    $users = User::where('role_id', 4)->orWhere('role_type', 'SdmLead')->orWhere('role_type', 'SdmMember')->get();
                    $usersId = $users->pluck('id');
                    $confirmed_activities = Activity::where('activity_status', 'confirmed')->whereIn('user_id', $usersId)->get();
                    $attendances = Attendance::whereDate('date', '=', $today)->whereIn('user_id', $usersId)->get();
                }elseif(hasLeadRole()){
                    $lead = Lead::where('user_id' , $user->id)->first();
                    if($lead){
                        $members = $lead->members;
                        if(!$members->isEmpty()){
                            $totalMembers = $members->map(function($member) {
                                return $member->user; 
                            });
                            $usersId = $totalMembers->pluck('id');
                            $confirmed_activities = Activity::where('activity_status', 'confirmed')->whereIn('user_id', $usersId)->get();
                            $approved_activities = Activity::where('activity_status', 'approved')->whereIn('user_id', $usersId)->get();
                            $attendances = Attendance::whereDate('date', '=', $today)->whereIn('user_id', $usersId)->orwhere('user_id', $user->id)->get();
                        }else{
                            $attendances = Attendance::where('user_id', $user->id)->get();
                            $confirmed_activities = Activity::where('activity_status', 'confirmed')->where('user_id', $user->id)->get();
                            $approved_activities = Activity::where('activity_status', 'approved')->where('user_id', $user->id)->get();
                        }

                    }else{
                        $attendances = Attendance::where('user_id', $user->id)->get();
                        $confirmed_activities = Activity::where('activity_status', 'confirmed')->where('user_id', $user->id)->get();
                        $approved_activities = Activity::where('activity_status', 'approved')->where('user_id', $user->id)->get();
                    }
                }else{
                    $attendances = Attendance::where('user_id', $user->id)->get();
                    $confirmed_activities = Activity::where('activity_status', 'confirmed')->where('user_id', $user->id)->get();
                    $approved_activities = Activity::where('activity_status', 'approved')->where('user_id', $user->id)->get();
                }
                return view('operation-index', compact(
                    'tech_unpaid',
                    'tech_paid',
                    'client_unpaid',
                    'client_paid',
                    'notes',
                    'anounsements',
                    'activities',
                    'clients',
                    'approved_activities',
                    'confirmed_activities',
                    'total_resources',
                    'worked_resources',
                    'attendances'
                ));
            }elseif(HrRole()){
                return view('hr-index', compact(
                    'tech_unpaid',
                    'tech_paid',
                    'client_unpaid',
                    'client_paid',
                    'notes',
                    'anounsements',
                    'activities',
                    'clients',
                    'approved_activities',
                    'confirmed_activities',
                    'total_resources',
                    'worked_resources',
                    'attendances'
                ));
            }elseif(OnlyBdManager()){
                $attendances = Attendance::where('user_id', $user->id)->get();
                return view('bd-index', compact(
                    'tech_unpaid',
                    'tech_paid',
                    'client_unpaid',
                    'client_paid',
                    'notes',
                    'anounsements',
                    'activities',
                    'clients',
                    'approved_activities',
                    'confirmed_activities',
                    'total_resources',
                    'worked_resources',
                    'bdmanagers',
                    'attendances'
                ));
            }
        } else {
            return view('auth.login');
        }
    }
}