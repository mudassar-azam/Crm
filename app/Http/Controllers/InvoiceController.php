<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Resource;
use App\Models\Activity;
use App\Models\Client;
use App\Models\Notification;
use App\Models\EngineerNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
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
    public function generatTechInvoice($id)
    {
        $activity = Activity::find($id);
        $activity->tech_invoice = "true";
        $activity->save();

        $existingInvoice = Invoice::where('resource_id', $activity->resource_id)
        ->where('activity_id', $id)
        ->first();

        if ($existingInvoice) {
            return response()->json(['error' => 'Invoice already exists for this activity and resource'], 400);
        }

        $resource_id = $activity->resource_id;
        $currentYear = Carbon::now()->year;
        $lastInvoice = Invoice::orderBy('id', 'desc')->first();
        
        if ($lastInvoice) {
            $lastInvoiceNo = $lastInvoice->invoice_no;
            preg_match('/(\d+)$/', $lastInvoiceNo, $matches);
            $lastNumber = $matches[1];
            $newNumber = intval($lastNumber) + 3;
        } else {
            $newNumber = 3210;
        }
        $formattedNumber = str_pad($newNumber, 7, '0', STR_PAD_LEFT);
        $invoice = Invoice::create([
            'resource_id' => $resource_id,
            'currency_id' => $activity->tech_currency_id,
            'activity_id' => $id,
            'status' => 'inprocess', 
            'invoice_no' => "CIG-{$currentYear}-{$formattedNumber}",
            'user_id' => Auth::user()->id,
        ]);

        $tech_invoice =   $activity->tech_invoice;
        $customer_invoice =   $activity->customer_invoice;

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has generated tech invoice !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        return response()->json(['message' => 'Invoice generated successfully' , 'tech_invoice' => $tech_invoice , 'customer_invoice' => $customer_invoice , 'activityId' => $activity->id]);
    } 
    public function techPayableInvoices(Request $request){
        $invoiceQuery = Invoice::query()->where('status', 'inprocess'); 
        if ($request->filled('from_date')) {
            try {
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                $invoiceQuery->where('created_at', '>=', $fromDate);
            } catch (\Exception $e) {
                return back()->withErrors(['from_date' => 'Invalid from date format.']);
            }
        }
    
        if ($request->filled('to_date')) {
            try {
                $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();
                $invoiceQuery->where('created_at', '<=', $toDate);
            } catch (\Exception $e) {
                return back()->withErrors(['to_date' => 'Invalid to date format.']);
            }
        }
    
        if ($request->filled('id')) {
            $invoiceQuery->where('resource_id', $request->id);
        }
        $invoices = $invoiceQuery->get();
        $resourceIds = $invoices->pluck('resource_id')->unique();
        $resources = Resource::with(['invoices' => function ($query) use ($request) {
            $query->where('status', 'inprocess');
            if ($request->filled('from_date')) {
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                $query->where('created_at', '>=', $fromDate);
            }
            if ($request->filled('to_date')) {
                $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();
                $query->where('created_at', '<=', $toDate);
            }
        }])->whereIn('id', $resourceIds)->get();
        $techs = Resource::all();
        return view('accounts.tech-payable-invoices', compact('resources','techs'));
    }
    public function techActivityPayment(Request $request , $id){
        $rules = [
            'paid_time' => 'required|date',
            'payment_proof' => 'nullable|file|mimes:jpeg,png,pdf|max:10240',
            'account' => 'required|string',
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
        $invoices = Invoice::where('resource_id' , $request->input('resource_id'))->where('status','inprocess')->get();
        if ($request->file('payment_proof')) {
            $pdf = $request->payment_proof;
            $file_name = time() . '_' . uniqid() . '.' . $pdf->getClientOriginalExtension();
            $pdf->move(public_path('pdfs'), $file_name);
        }
        $activityIds = $invoices->pluck('activity_id')->unique();
        $activities = Activity::whereIn('id', $activityIds)->get();
        foreach($activities as $activity){
            $activity->tech_invoice_payment_status = "paid";
            $activity->save();
        }
        foreach ($invoices as $invoice) {
            $invoice->paid_time = $request->input('paid_time');
            $invoice->remarks = $request->input('remarks');
            $invoice->account = $request->input('account');
            $invoice->status = "received";
            $invoice->payment_proof = $file_name;
            $invoice->save();
        }

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has confirmed tech invoice payment !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        $resource_id = $request->input('resource_id');
        $e_message = " Your activity has paid !";
        $e_notification = $this->createEngineerNotification($resource_id, $e_message);

        return response()->json(['success' => true, 'message' => 'Payment added successfully!' , 'invoiceId' => $id]);
    }
    public function techPaidInvoices(Request $request){
        $invoiceQuery = Invoice::query()->where('status', 'received'); 
        if ($request->filled('from_date')) {
            try {
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                $invoiceQuery->where('created_at', '>=', $fromDate);
            } catch (\Exception $e) {
                return back()->withErrors(['from_date' => 'Invalid from date format.']);
            }
        }
        if ($request->filled('to_date')) {
            try {
                $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();
                $invoiceQuery->where('created_at', '<=', $toDate);
            } catch (\Exception $e) {
                return back()->withErrors(['to_date' => 'Invalid to date format.']);
            }
        }
    
        if ($request->filled('id')) {
            $invoiceQuery->where('resource_id', $request->id);
        }
    
        $invoices = $invoiceQuery->get();
        $resourceIds = $invoices->pluck('resource_id')->unique();
        $resources = Resource::with(['invoices' => function ($query) use ($request) {
            $query->where('status', 'received');
    
            if ($request->filled('from_date')) {
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                $query->where('created_at', '>=', $fromDate);
            }
    
            if ($request->filled('to_date')) {
                $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();
                $query->where('created_at', '<=', $toDate);
            }
        }])->whereIn('id', $resourceIds)->get();
    
        $techs = Resource::all();
        return view('accounts.tech-paid-invoices', compact('resources', 'techs'));
    }
    public function deleteTechInvoice($id){

        $invoice = Invoice::find($id);
        $invoices = Invoice::where('resource_id' , $invoice->resource_id)->get();
        foreach($invoices as $invoice){

            $activity = $invoice->activity;
            $activity->tech_invoice = null;
            $activity->tech_invoice_payment_status = null;
            $activity->save();

            $invoice->delete();
        }
        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has deleted tech invoice !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        return response()->json(['message' => 'Invoice deleted successfully']);
    }
    public function clientPayableInvoices(Request $request) {
        $invoiceQuery = Invoice::query()->where('status', 'inprocess'); 
        if ($request->filled('from_date')) {
            try {
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                $invoiceQuery->where('created_at', '>=', $fromDate);
            } catch (\Exception $e) {
                return back()->withErrors(['from_date' => 'Invalid from date format.']);
            }
        }
    
        if ($request->filled('to_date')) {
            try {
                $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();
                $invoiceQuery->where('created_at', '<=', $toDate);
            } catch (\Exception $e) {
                return back()->withErrors(['to_date' => 'Invalid to date format.']);
            }
        }
    
        if ($request->filled('id')) {
            $invoiceQuery->where('client_id', $request->id);
        }
        $invoices = $invoiceQuery->get();
        $clientIds = $invoices->pluck('client_id')->unique();
        $clients = Client::with(['invoices' => function ($query) use ($request) {
            $query->where('status', 'inprocess');
            if ($request->filled('from_date')) {
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                $query->where('created_at', '>=', $fromDate);
            }
            if ($request->filled('to_date')) {
                $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();
                $query->where('created_at', '<=', $toDate);
            }
        }])->whereIn('id', $clientIds)->get();
        $customers = Client::all();
        return view('accounts.client-payable-invoices', compact('clients','customers'));
    }
    public function generatCustomerInvoice(Request $request){
        $rules = [
            'account' => 'required',
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
        $activity = Activity::find($activity_id);
        $activity->customer_invoice = "true";
        $activity->save();

        $existingInvoice = Invoice::where('client_id', $activity->client_id)
        ->where('activity_id', $id)
        ->first();

        if ($existingInvoice) {
            return response()->json(['error' => 'Invoice already exists'], 400);
        }

        $client_id = $activity->client_id;

        $currentYear = Carbon::now()->year;
        $lastInvoice = Invoice::orderBy('id', 'desc')->first();
        if ($lastInvoice) {
            $lastInvoiceNo = $lastInvoice->invoice_no;
            preg_match('/(\d+)$/', $lastInvoiceNo, $matches);
            $lastNumber = $matches[1];
            $newNumber = intval($lastNumber) + 3;
        } else {
            $newNumber = 3210;
        }
        $formattedNumber = str_pad($newNumber, 7, '0', STR_PAD_LEFT);
        $invoice = Invoice::create([
            'client_id' => $client_id,
            'account' => $request->input('account'),
            'bank_name' => "Wise" ,
            'ach_wire_routing' => "123456789" ,
            'swift_bnic' => "CMFGUS33",
            'account_number' => "123456789",
            'iban' => "GB13TWRI123456789",
            'account_holder' => "Chase It Global Ltd",
            'address_associated' => "30 W. 26th Street, Sixth Floor New York NY 10010 United States",
            'currency_id' => $activity->customer_currency_id,
            'activity_id' => $activity_id,
            'status' => 'inprocess', 
            'invoice_no' => "CIG-{$currentYear}-{$formattedNumber}",
            'user_id' => Auth::user()->id,
        ]);

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has generated client invoice !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        $tech_invoice =   $activity->tech_invoice;
        $customer_invoice =   $activity->customer_invoice;

        return response()->json(['message' => 'Invoice generated successfully', 'tech_invoice' => $tech_invoice , 'customer_invoice' => $customer_invoice ,'activityId' => $activity_id]);
    }
    public function deleteCustomerInvoice($id){
        $invoice = Invoice::find($id);
        $invoices = Invoice::where('client_id' , $invoice->client_id)->get();
        foreach($invoices as $invoice){

            $activity = $invoice->activity;
            $activity->customer_invoice = null;
            $activity->customer_invoice_payment_status = null;
            $activity->save();

            $invoice->delete();
        }

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has deleted client invoice !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        return response()->json(['message' => 'Invoice deleted successfully']);
    }
    public function customerPaymentConfirmation(Request $request , $id){
        $rules = [
            'paid_time' => 'required|date',
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
        $invoices = Invoice::where('client_id' , $request->input('client_id'))->where('status','inprocess')->get();
        $activityIds = $invoices->pluck('activity_id')->unique();
        $activities = Activity::whereIn('id', $activityIds)->get();
        foreach($activities as $activity){
            $activity->customer_invoice_payment_status = "paid";
            $activity->save();
        }
        foreach ($invoices as $invoice) {
            $invoice->status = "received";
            $invoice->paid_time = $request->input('paid_time');
            $invoice->save();
        }

        $user1_id = Auth::user()->id;
        $user2_id = null;
        $message = " has confirmed client invoice payment !";
        $notification = $this->createNotification($user1_id, $user2_id, $message);

        return response()->json(['success' => true, 'message' => 'Confirmed successfully!' , 'invoiceId' => $id]);
    }
    public function clientPaidInvoices(Request $request){
        $invoiceQuery = Invoice::query()->where('status', 'received'); 
        if ($request->filled('from_date')) {
            try {
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                $invoiceQuery->where('created_at', '>=', $fromDate);
            } catch (\Exception $e) {
                return back()->withErrors(['from_date' => 'Invalid from date format.']);
            }
        }
        if ($request->filled('to_date')) {
            try {
                $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();
                $invoiceQuery->where('created_at', '<=', $toDate);
            } catch (\Exception $e) {
                return back()->withErrors(['to_date' => 'Invalid to date format.']);
            }
        }
    
        if ($request->filled('id')) {
            $invoiceQuery->where('client_id', $request->id);
        }
    
        $invoices = $invoiceQuery->get();
        $clientIds = $invoices->pluck('client_id')->unique();
        $clients = Client::with(['invoices' => function ($query) use ($request) {
            $query->where('status', 'received');
    
            if ($request->filled('from_date')) {
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                $query->where('created_at', '>=', $fromDate);
            }
    
            if ($request->filled('to_date')) {
                $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();
                $query->where('created_at', '<=', $toDate);
            }
        }])->whereIn('id', $clientIds)->get();
    
        $customers = Client::all();
        return view('accounts.client-paid-invoices', compact('clients', 'customers'));
    }
    public function techUnPaidInvoice($id){
        $baseInvoice = Invoice::find($id);
        $techId = $baseInvoice->resource_id;
        $invoices = Invoice::where('resource_id', $techId)->where('status','inprocess')->get();
        return view('printables.tech-unpaid-incoice-print',compact('baseInvoice','invoices'));
    }
    public function techPaidInvoice($id){

        $baseInvoice = Invoice::find($id);
        $techId = $baseInvoice->resource_id;
        // dd($id,$baseInvoice,$techId);
        $invoices = Invoice::where('resource_id', $techId)->where('status','received')->get();
        // dd($invoices);
        return view('printables.tech-paid-incoice-print',compact('baseInvoice','invoices'));

    }
    public function customerUnPaidInvoice($id){
        $baseInvoice = Invoice::find($id);
        $clientId = $baseInvoice->client_id;
        $invoices = Invoice::where('client_id', $clientId)->where('status','inprocess')->get();
        return view('printables.client-unpaid-incoice-print',compact('baseInvoice','invoices'));
    }
    public function customerPaidInvoice($id){
        $baseInvoice = Invoice::find($id);
        $clientId = $baseInvoice->client_id;
        $invoices = Invoice::where('client_id', $clientId)->where('status','received')->get();
        return view('printables.client-paid-incoice-print',compact('baseInvoice','invoices'));
    }
}
