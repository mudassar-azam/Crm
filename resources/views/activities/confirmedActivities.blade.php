@extends("layouts.app")
@section('content')
<style>
.filled-input {
    border: 2px solid green !important;
}

.error-input {
    border: 2px solid red !important;
}

input[type='number']::-webkit-outer-spin-button,
input[type='number']::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type='number'] {
    -moz-appearance: textfield;
}

#confirmActivities {
    table-layout: fixed;
    width: 100%;
}

#confirmActivities thead tr th,
#confirmActivities tbody tr td {
    width: 10em !important;
    white-space: nowrap;
    overflow: hidden;
    font-size: 12px;
    border-bottom: 1px solid lightgray;
}

#confirmActivities tbody tr td {
    overflow-x: auto;
    max-width: 15em !important;
}

#confirmActivities tbody tr td::-webkit-scrollbar {
    width: 3px;
    height: 0px;
}

#confirmActivities tbody tr td::-webkit-scrollbar-track {
    background: none;
}

#confirmActivities tbody tr td::-webkit-scrollbar-thumb {
    background: #e94d65;
}

#confirmActivities tbody tr td::-webkit-scrollbar-thumb:hover {
    background: #2d6d8b;
    width: 7px;
}

.table-header {
    background-color: #206D88;
    color: white;
    font-weight: 600;
    font-size: 13px;
}

.datatable-row {
    display: flex;
    align-items: center;
}

.btn-primaryy {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
}

#email-body {
    font-size: 10px;
    font-style: italic;
    font-weight: 400;
    border: 1px solid lightgray;
    border-radius: 5px;
    width: 200% !important;
}

.user-dropdown {
    font-size: 10px;
    font-style: italic;
    font-weight: 400;
    border: 1px solid lightgray;
    border-radius: 5px;
    height: 4em;
}

.datatable-row {
    display: flex;
    align-items: center;
}

.btn-primaryy {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    background-color: #E94D65 !important;
}

.btn-assignit {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    background-color: #206D88 !important;
}

.btn-email {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    background-color: #00b0f4 !important;
}
</style>
<div id="alert-danger" class="alert alert-danger" style="display: none;">
    <ul id="error-list"></ul>
</div>
<div id="alert-success" class="alert alert-success" style="display: none;"></div>
<form mehtod="get" action="{{route('activities.confirmed')}}">
    <div class="approved-activities">

        <div class="select status">
            <h5>From Date</h5>
            <input type="date" name="from_date" value="{{ isset($from_date) ? $from_date : '' }}">
        </div>
        <div class="select work">
            <h5>To Date</h5>
            <input type="date" name="to_date" value="{{ isset($to_date) ? $to_date : '' }}">
        </div>
        <div class="select BGV">
            <h5>Costomer Name</h5>
            <select name="company_id" id="">
                <option value="">ALL</option>
                @foreach($clients as $client)
                <option value="{{$client->id}}" {{ request('company_id') === (string) $client->id ? 'selected' : '' }}>
                    {{$client->company_name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-btns">
        <p></p>
        <button type="submit" class="request-btn">
            Filter Request
        </button>
    </div>
</form>
@php
$totalLeadAndMemberIdsArray = $totalLeadAndMemberIds->toArray();
$totalMemberIdsArray = $totalMemberIds->toArray();
$myIdArray = $myId->toArray();
@endphp
<div class="data-container datatable datatable-container">
    <div class="data-table-container datatable-container-header">
        <div class="left-side-header">
            <div class="record">
                <h3>Confirmed-activities</h3>
                <p>Resources that are available</p>
            </div>
        </div>
        <div class="right-side-header">
            <button type="button" onclick="window.location='{{ route('activities.planed') }}'" id="plannedbtn">
                <img src="{{asset('./Asserts/logo/planned.png')}}" />
                Planned
            </button>
            <button type="button" onclick="window.location='{{ route('activities.confirmed') }}'" id="Confirmbtn">
                <img src="{{asset('./Asserts/logo/tickmark.png')}}" />
                Confirm
            </button>
            <button type="button" onclick="window.location='{{ route('activity.completed') }}'">
                <img src="{{asset('./Asserts/logo/completed.png')}}">
                Completed
            </button>
        </div>
    </div>
    <div class="data-table-container scrollable-table">
        <table id="confirmActivities" class="table table-sm  table-hover table-bordered" style="width:88vw;">
            <thead>
                <tr class="table-header">
                    <td>Sr#</td>
                    <td>Assign</td>
                    <th>Action</th>
                    <th>Close</th>
                    <th>Email</th>
                    <th>Task</th>
                    <th>Activity Date</th>
                    <th>Ticket Details</th>
                    <th>Customer</th>
                    <th>Project</th>
                    <th>Project SDM</th>
                    <th>PO Number</th>
                    <th>Service Type</th>
                    <th>Location</th>
                    <th>Tech Details</th>
                    <th>Country</th>
                    <th>Tech Rates</th>
                    <th>Customer Rates </th>
                    <th>Remrks</th>
                    <th>Status</th>
                    <th>Uploaded By</th>
                    <th>Follow Up</th>
                    <th>Confirm By</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                <tr id="row_{{ $activity->id }}">
                    <td>{{ $loop->iteration }}</td>
                    @if($activity->assign_to_user_id != NULL)
                        <td>
                            <button id="assign_activity_{{ $activity->id }}" class="btn btn-sm btn-assignit conform-table">
                                Assigned
                            </button>
                        </td>
                    @else
                        @if(hasAdminRole())
                            <td>
                                <button id="assign_activity_{{ $activity->id }}" class="btn btn-sm btn-assignit conform-table"
                                    data-id="{{ $activity->id }}" type="button" onclick="openAssignModal({{ $activity->id }})">
                                    Assign it
                                </button>
                            </td>
                        @elseif(SdmManager())
                            @if(in_array($activity->user_id, $totalLeadAndMemberIdsArray))
                                <td>
                                    <button id="assign_activity_{{ $activity->id }}" class="btn btn-sm btn-assignit conform-table"
                                        data-id="{{ $activity->id }}" type="button" onclick="openAssignModal({{ $activity->id }})">
                                        Assign it
                                    </button>
                                </td>
                            @else
                                <td>-</td>
                            @endif
                        @elseif(SdmLead())
                            @if(in_array($activity->user_id, $totalMemberIdsArray))
                                <td>
                                    <button id="assign_activity_{{ $activity->id }}" class="btn btn-sm btn-assignit conform-table"
                                        data-id="{{ $activity->id }}" type="button" onclick="openAssignModal({{ $activity->id }})">
                                        Assign it
                                    </button>
                                </td>
                            @else
                                <td>-</td>
                            @endif
                        @else
                            @if(in_array($activity->user_id, $myIdArray))
                                <td>
                                    <button id="assign_activity_{{ $activity->id }}" class="btn btn-sm btn-assignit conform-table"
                                        data-id="{{ $activity->id }}" type="button" onclick="openAssignModal({{ $activity->id }})">
                                        Assign it
                                    </button>
                                </td>
                            @else
                                <td>-</td>
                            @endif
                        @endif
                    @endif
                    <td class="space-between">

                        @if(hasAdminRole())
                        <button class="rounded-circle btn btn-primary btn-sm edit-table" type="button"
                            onclick="openEditPage({{ $activity->id }})">
                            <img src="{{asset('Asserts/logo/edit-table.png')}}" />
                        </button>
                        @elseif(SdmManager())
                        @if(in_array($activity->user_id, $totalLeadAndMemberIdsArray))
                        <button class="rounded-circle btn btn-primary btn-sm edit-table" type="button"
                            onclick="openEditPage({{ $activity->id }})">
                            <img src="{{asset('Asserts/logo/edit-table.png')}}" />
                        </button>
                        @endif
                        @elseif(SdmLead())
                        @if(in_array($activity->user_id, $totalMemberIdsArray))
                        <button class="rounded-circle btn btn-primary btn-sm edit-table" type="button"
                            onclick="openEditPage({{ $activity->id }})">
                            <img src="{{asset('Asserts/logo/edit-table.png')}}" />
                        </button>
                        @endif
                        @else
                        @if(in_array($activity->user_id, $myIdArray))
                        <button class="rounded-circle btn btn-primary btn-sm edit-table" type="button"
                            onclick="openEditPage({{ $activity->id }})">
                            <img src="{{asset('Asserts/logo/edit-table.png')}}" />
                        </button>
                        @endif
                        @endif

                        <button class="rounded-circle btn btn-danger btn-sm delete-table"
                            onclick="openPrintPage({{ $activity->id }})" type="button">
                            <img src="{{asset('Asserts/logo/export-pdf.png')}}" />
                        </button>

                        @if($activity)
                        <!-- Email model  -->
                        <form id="sendemail_{{ $activity->id }}" action="{{route('activity.send.email')}}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="modal" id="send_email_modal_{{ $activity->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-xl shadow-lg" role="document"
                                    style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                    <div class="modal-content modal-xl shadow-lg" style="border-radius: 10px;">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modelHeading">Email Format</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="data">

                                                <div id="alert-danger" class="alert alert-danger"
                                                    style="display: none;">
                                                    <ul id="error-list"></ul>
                                                </div>
                                                <div id="alert-success" class="alert alert-success"
                                                    style="display: none;"></div>
                                                <input type="hidden" name="activity_id" value="{{$activity->id}}">
                                                <div class="container">
                                                    <div class="planned" style="width : 50%">
                                                        <div class="data">

                                                            <label>Sent To</label>
                                                            <input type="email" name="email" placeholder="email">

                                                            <label for="location">Location</label>
                                                            <input type="text" name="location" placeholder="location">
                                                            <label for="email_body">Email Body</label>
                                                            <textarea name="email_body" id="email_body"
                                                                style="font-size: 10px;font-style: italic;font-weight: 400;border: 1px solid lightgray;border-radius: 5px; width:200% !important;"
                                                                placeholder="body" rows="10" cols="40"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="planned" style="width : 50%">
                                                        <div class="data">

                                                            <label for="subject">Subject</label>
                                                            <input type="text" id="subject" name="subject"
                                                                placeholder="subject">

                                                            <label for="express">Travel Express</label>
                                                            <input type="text" id="express" name="express"
                                                                placeholder="express">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="remarks-box"> <label>Note</label>
                                                    <br>
                                                    <input type="text" name="email_note">
                                                </div>

                                                <div class="available-resource-form-btns"
                                                    style="justify-content: end !important;">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" onclick="sendEmail({{ $activity->id }})"
                                                class="request-btn">Send Email</button>
                                            <button type="button" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- complete activity model  -->
                        <form id="confirmActivity_{{ $activity->id }}"
                            action="{{route('close.activity' , $activity->id)}}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="modal" id="confirm_activity_modal_{{ $activity->id }}" tabindex="-1"
                                role="dialog">
                                <div class="modal-dialog modal-xl shadow-lg" role="document"
                                    style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                    <div class="modal-content modal-xl shadow-lg" style="border-radius: 10px;">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modelHeading">Complete Activity</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <input type="hidden" name="activity_id" value="{{$activity->id}}">
                                        <div class="modal-body">
                                            <div class="data">

                                                <div id="alert-danger" class="alert alert-danger"
                                                    style="display: none;">
                                                    <ul id="error-list"></ul>
                                                </div>
                                                <div id="alert-success" class="alert alert-success"
                                                    style="display: none;"></div>
                                                <div class="container">
                                                    <div class="planned">
                                                        <div class="activity-detail-name">
                                                            <h2>Activity Details</h2>
                                                            <p>Start New Activities</p>
                                                        </div>
                                                        <div class="data">
                                                            <label for="start_date_time_{{ $activity->id }}">Start
                                                                Date/Time</label>
                                                            <input type="datetime-local"
                                                                id="start_date_time_{{ $activity->id }}"
                                                                name="start_date_time"
                                                                value="{{ $activity->start_date_time }}">
                                                            <label for="end_date_time_{{ $activity->id }}">End
                                                                Date/Time</label>
                                                            <input type="datetime-local"
                                                                id="end_date_time_{{ $activity->id }}"
                                                                name="end_date_time"
                                                                value="{{ $activity->end_date_time }}">
                                                            <label for="time_difference_{{ $activity->id }}">Time
                                                                Difference</label>
                                                            <input type="text" id="time_difference_{{ $activity->id }}"
                                                                name="time_difference" readonly
                                                                value="{{ $activity->time_difference }}">
                                                            <label for="sign_of_sheet">Sign Of Sheet (SOS)</label>
                                                            <input type="file" id="sign_of_sheet" name="sign_of_sheet"
                                                                style="padding: 0.3em;">
                                                        </div>
                                                    </div>
                                                    <div class="planned">
                                                        <div class="activity-detail-name">
                                                            <h2>Tech Details</h2>
                                                            <p>Add Payment mwthod for paying</p>
                                                        </div>
                                                        <div class="data">

                                                            <label for="duration_{{ $activity->id }}">Duration</label>
                                                            <input type="text" id="duration_{{ $activity->id }}"
                                                                name="duration" placeholder="add duration"
                                                                value="{{$activity->duration}}">

                                                            <label for="tech_service_type">Tech Service Type</label>
                                                            <select name="tech_service_type" id="serviceTypeSelect">
                                                                <option value="Hourly"
                                                                    {{ $activity->customer_service_type === 'Hourly' ? 'selected' : '' }}>
                                                                    Hourly rate</option>
                                                                <option value="Half Day"
                                                                    {{ $activity->customer_service_type === 'Half Day' ? 'selected' : '' }}>
                                                                    Half Day rate</option>
                                                                <option value="Full Day"
                                                                    {{ $activity->customer_service_type === 'Full Day' ? 'selected' : '' }}>
                                                                    Full Day rate</option>
                                                                <option value="Weekly"
                                                                    {{ $activity->customer_service_type === 'Weekly' ? 'selected' : '' }}>
                                                                    Weekly rate</option>
                                                                <option value="Monthly"
                                                                    {{ $activity->customer_service_type === 'Monthly' ? 'selected' : '' }}>
                                                                    Monthly rate</option>
                                                            </select>

                                                            <label for="tech_rates">Tech Rates</label>
                                                            <input type="text" id="tech_rates" name="tech_rates"
                                                                value="{{$activity->tech_rates}}">

                                                            <label for="total_tech_payments">Tech Payments</label>
                                                            <input type="text" id="total_tech_payments"
                                                                name="total_tech_payments" placeholder="add payment"
                                                                value="{{$activity->total_tech_payments}}">

                                                            <label for="tech_currency_id">Tech Currency</label>
                                                            <select name="tech_currency_id" id="tech_currency">
                                                                <option selected
                                                                    value="{{$activity->tech_currency_id}}">
                                                                    {{$activity->techCurrency->code}}-{{$activity->techCurrency->symbol}}
                                                                </option>
                                                                @foreach($currencies as $currency)
                                                                <option value="{{$currency->id}}">
                                                                    {{$currency->code}}-{{$currency->symbol}}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="planned">
                                                        <div class="activity-detail-name">
                                                            <h2>Activity Details</h2>
                                                            <p>Start New Activities</p>
                                                        </div>
                                                        <div class="data">

                                                            <label for="duration_cust_{{ $activity->id }}">Duration
                                                                <span style="color: gray; font-style: italic;">(for
                                                                    Cust)</span></label>
                                                            <input type="text" id="duration_cust_{{ $activity->id }}"
                                                                name="duration_cust" placeholder="add duration"
                                                                value="{{$activity->duration_cust}}">

                                                            <label for="customer_service_type">Costomer Service
                                                                Type</label>
                                                            <select name="customer_service_type"
                                                                id="customer_service_type">
                                                                <option value="Hourly"
                                                                    {{ $activity->customer_service_type === 'Hourly' ? 'selected' : '' }}>
                                                                    Hourly rate</option>
                                                                <option value="Half Day"
                                                                    {{ $activity->customer_service_type === 'Half Day' ? 'selected' : '' }}>
                                                                    Half Day rate</option>
                                                                <option value="Full Day"
                                                                    {{ $activity->customer_service_type === 'Full Day' ? 'selected' : '' }}>
                                                                    Full Day rate</option>
                                                                <option value="Weekly"
                                                                    {{ $activity->customer_service_type === 'Weekly' ? 'selected' : '' }}>
                                                                    Weekly rate</option>
                                                                <option value="Monthly"
                                                                    {{ $activity->customer_service_type === 'Monthly' ? 'selected' : '' }}>
                                                                    Monthly rate</option>
                                                            </select>

                                                            <label for="customer_rates">Customer Rates</label>
                                                            <input type="text" id="customer_rates" name="customer_rates"
                                                                placeholder="add rates"
                                                                value="{{$activity->customer_rates}}">


                                                            <label for="total_customer_payments">Customer
                                                                Payment</label>
                                                            <input type="text" id="total_customer_payments"
                                                                name="total_customer_payments" placeholder="add payment"
                                                                value="{{$activity->total_customer_payments}}">

                                                            <label for="customer_currency_id">Customer Currency</label>
                                                            <select name="customer_currency_id" id="client_currency">
                                                                <option selected
                                                                    value="{{$activity->customer_currency_id}}">
                                                                    {{$activity->customerCurrency->code}}-{{$activity->customerCurrency->symbol}}
                                                                </option>
                                                                @foreach($currencies as $currency)
                                                                <option value="{{$currency->id}}">
                                                                    {{$currency->code}}-{{$currency->symbol}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="remarks-box">
                                                    <div class="name">
                                                        <h4>Extra Details</h4>
                                                        <p>Start New Activity</p>
                                                    </div>

                                                    <label>Remarks</label>
                                                    <br>
                                                    <input type="text" name="remark" value="{{$activity->remark}}">
                                                </div>

                                                <div class="available-resource-form-btns"
                                                    style="justify-content: end !important;">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" onclick="closeActivity({{ $activity->id }})"
                                                class="request-btn">Close Activity</button>
                                            <button type="button" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- assign model  -->
                        <form id="assignActivityForm_{{ $activity->id }}" method="post"
                            action="{{route('activity.assign')}}">
                            @csrf
                            <div class="modal" id="assign_modal_{{ $activity->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-xl shadow-lg" role="document"
                                    style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                    <div class="modal-content modal-xl shadow-lg" style="border-radius: 10px;">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modelHeading">Assign This Activity</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <input type="hidden" name="activity_id" value="{{$activity->id}}">
                                        <div class="modal-body">
                                            <div class="data">
                                                <div class="datetime-wrapper">
                                                    <div class="date-time" style="width:100%">
                                                        <label for="assign_to" style="padding-top: 0">Assign To
                                                        </label>
                                                        @if(hasAdminRole())
                                                        @php
                                                        $users = DB::table('users')->where('role_id', 4)
                                                        ->orWhere(function($query) {
                                                        $query->where('role_type', 'sdmMember')
                                                        ->orWhere('role_type', 'SdmLead');
                                                        })->get();
                                                        @endphp
                                                        <select class="user-dropdown" name="user" id="user">
                                                            <option selected disabled>Select user</option>
                                                            @foreach($users as $user)
                                                            <option value="{{$user->id}}">
                                                                {{$user->user_name}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @else
                                                        @php
                                                        $leads = \App\Models\Lead::where('manager_id',
                                                        Auth::id())->get();
                                                        @endphp
                                                        <select class="user-dropdown" name="user" id="user">
                                                            <option selected disabled>Select user</option>
                                                            @foreach($leads as $lead)
                                                            @if ($lead->user)
                                                            <option value="{{$lead->user->id}}">
                                                                {{$lead->user->user_name}}
                                                            </option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                        @endif
                                                    </div>
                                                </div>

                                                <label for="assign_remarks">Remark (If any) </label><br>
                                                <textarea name="assign_remarks" class="remarks"
                                                    <?php echo $activity->assign_remarks; ?>></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button onclick="assignActivity({{ $activity->id }})"
                                                type="button">Assign</button>
                                            <button type="button" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- task model  -->
                        <form id="taskForm_{{ $activity->id }}" action="{{route('activity.assign.task')}}"
                            method="post">
                            @csrf
                            <div class="modal setting" id="task_modal_{{ $activity->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-xl shadow-lg" role="document"
                                    style="background-color: rgba(0, 0, 0, 0.03) !important; margin: 0 !important; max-width: 100%;">
                                    <div class="model-center modal-content modal-xl shadow-lg"
                                        style="width: 80%; border-radius: 10px; border: none;">
                                        <div class="form-wrapper"> </div>
                                        <div class="form"
                                            style="width: 65%; top: 5em; right: 5em; padding-bottom: 1em;">
                                            <div class="form-header">
                                                <div class="heading">
                                                    <h4>Activity Task Information</h4>
                                                    <p>Additional information for task</p>
                                                </div>
                                            </div>
                                            <input type="hidden" name="activity_id" value="{{$activity->id}}">
                                            <div class="data" style="padding: 0;">
                                                <div class="datetime-wrapper">

                                                    <div class="date-time">
                                                        <label for="">FE is on the Way</label>
                                                        <div class="tooglebtn">
                                                            <label class="switch">
                                                                <input type="checkbox" name="ff"
                                                                    {{ $activity->ff ? 'checked' : '' }}>
                                                                <span class="slider red"></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                    <div class="date-time">

                                                        <label>Job Completed</label>
                                                        <div class="tooglebtn">
                                                            <label class="switch">
                                                                <input type="checkbox" name="job"
                                                                    {{ $activity->job ? 'checked' : '' }}>
                                                                <span class="slider red"></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="datetime-wrapper">

                                                    <div class="date-time">
                                                        <label for="" style="margin-top: -13px;">FE has reached on
                                                            site</label>
                                                        <div class="tooglebtn">
                                                            <label class="switch">
                                                                <input type="checkbox" name="reached"
                                                                    {{ $activity->reached ? 'checked' : '' }}>
                                                                <span class="slider red"></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                    <div class="date-time">

                                                        <label style="margin-top: -13px;">Need to Update the
                                                            client</label>
                                                        <div class="tooglebtn">
                                                            <label class="switch">
                                                                <input type="checkbox" name="update_client"
                                                                    {{ $activity->update_client ? 'checked' : '' }}>
                                                                <span class="slider red"></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="datetime-wrapper">

                                                    <div class="date-time">
                                                        <label for="" style="margin-top: -13px;">Informed client about
                                                            FE arrival on site</label>
                                                        <div class="tooglebtn">
                                                            <label class="switch">
                                                                <input type="checkbox" name="inform_client"
                                                                    {{ $activity->inform_client ? 'checked' : '' }}>
                                                                <span class="slider red"></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                    <div class="date-time">

                                                        <label style="margin-top: -13px;">Sign off (Time sheet)received
                                                            & shared</label>
                                                        <div class="tooglebtn">
                                                            <label class="switch">
                                                                <input type="checkbox" name="sign_of_sheet_received"
                                                                    {{ $activity->sign_of_sheet_received ? 'checked' : '' }}>
                                                                <span class="slider red"></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="datetime-wrapper">

                                                    <div class="date-time">
                                                        <label for="" style="margin-top: -13px;">FE is Working</label>
                                                        <div class="tooglebtn">
                                                            <label class="switch">
                                                                <input type="checkbox" name="ff_working"
                                                                    {{ $activity->ff_working ? 'checked' : '' }}>
                                                                <span class="slider red"></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                    <div class="date-time">

                                                        <label style="margin-top: -13px;">Activity has Completed</label>
                                                        <div class="tooglebtn">
                                                            <label class="switch">
                                                                <input type="checkbox" name="activity_completed"
                                                                    {{ $activity->activity_completed ? 'checked' : '' }}>
                                                                <span class="slider red"></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="datetime-wrapper">

                                                    <div class="date-time">
                                                        <label for="" style="margin-top: -13px;">FE Need's Over
                                                            Time</label>
                                                        <div class="tooglebtn">
                                                            <label class="switch">
                                                                <input type="checkbox" name="ff_need_time"
                                                                    {{ $activity->ff_need_time ? 'checked' : '' }}>
                                                                <span class="slider red"></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                    <div class="date-time">

                                                        <label style="margin-top: -13px;">SVR (Time Sheet) has been
                                                            shared with client</label>
                                                        <div class="tooglebtn">
                                                            <label class="switch">
                                                                <input type="checkbox" name="svr_shared"
                                                                    {{ $activity->svr_shared ? 'checked' : '' }}>
                                                                <span class="slider red"></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button id="confirm" class="confirm" onclick="assignTask({{ $activity->id }})"
                                                    type="button">Assign</button>
                                                <button type="button" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                        @endif
                    </td>
                    @if(hasAdminRole())
                        <td>
                            <button  class="btn btn-sm btn-primaryy conform-table"
                                data-id="{{ $activity->id }}" type="button"
                                onclick="openActivityConfirmModal({{ $activity->id }})">
                                <img src="{{asset('Asserts/logo/confirm-btn.png')}}" alt="Confirm" />
                                Close
                            </button>
                        </td>
                    @elseif(SdmManager())
                        @if(in_array($activity->user_id, $totalLeadAndMemberIdsArray))
                            <td>
                                <button  class="btn btn-sm btn-primaryy conform-table"
                                    data-id="{{ $activity->id }}" type="button"
                                    onclick="openActivityConfirmModal({{ $activity->id }})">
                                    <img src="{{asset('Asserts/logo/confirm-btn.png')}}" alt="Confirm" />
                                    Close
                                </button>
                            </td>
                        @else
                            <td>-</td>
                        @endif
                    @elseif(SdmLead())
                        @if(in_array($activity->user_id, $totalMemberIdsArray))
                            <td>
                                <button  class="btn btn-sm btn-primaryy conform-table"
                                    data-id="{{ $activity->id }}" type="button"
                                    onclick="openActivityConfirmModal({{ $activity->id }})">
                                    <img src="{{asset('Asserts/logo/confirm-btn.png')}}" alt="Confirm" />
                                    Close
                                </button>
                            </td>
                        @else
                            <td>-</td>
                        @endif
                    @else
                        @if(in_array($activity->user_id, $myIdArray))
                            <td>
                                <button  class="btn btn-sm btn-primaryy conform-table"
                                    data-id="{{ $activity->id }}" type="button"
                                    onclick="openActivityConfirmModal({{ $activity->id }})">
                                    <img src="{{asset('Asserts/logo/confirm-btn.png')}}" alt="Confirm" />
                                    Close
                                </button>
                            </td>
                        @else
                            <td>-</td>
                        @endif
                    @endif

                    @if(hasAdminRole())
                        <td>
                            <button id="send_email_{{ $activity->id }}" class="btn btn-sm btn-email conform-table"
                                data-id="{{ $activity->id }}" type="button" onclick="openEmailModal({{ $activity->id }})">
                                <img src="{{asset('Asserts/logo/email.png')}}" alt="Confirm" />
                                Email
                            </button>
                        </td>
                    @elseif(SdmManager())
                        @if(in_array($activity->user_id, $totalLeadAndMemberIdsArray))
                            <td>
                                <button id="send_email_{{ $activity->id }}" class="btn btn-sm btn-email conform-table"
                                    data-id="{{ $activity->id }}" type="button" onclick="openEmailModal({{ $activity->id }})">
                                    <img src="{{asset('Asserts/logo/email.png')}}" alt="Confirm" />
                                    Email
                                </button>
                            </td>
                        @else
                            <td>-</td>
                        @endif
                    @elseif(SdmLead())
                        @if(in_array($activity->user_id, $totalMemberIdsArray))
                            <td>
                                <button id="send_email_{{ $activity->id }}" class="btn btn-sm btn-email conform-table"
                                    data-id="{{ $activity->id }}" type="button" onclick="openEmailModal({{ $activity->id }})">
                                    <img src="{{asset('Asserts/logo/email.png')}}" alt="Confirm" />
                                    Email
                                </button>
                            </td>
                        @else
                            <td>-</td>
                        @endif
                    @else
                        @if(in_array($activity->user_id, $myIdArray))
                            <td>
                                <button id="send_email_{{ $activity->id }}" class="btn btn-sm btn-email conform-table"
                                    data-id="{{ $activity->id }}" type="button" onclick="openEmailModal({{ $activity->id }})">
                                    <img src="{{asset('Asserts/logo/email.png')}}" alt="Confirm" />
                                    Email
                                </button>
                            </td>
                        @else
                            <td>-</td>
                        @endif
                    @endif

                    @if(hasAdminRole())
                        <td>
                            <button  class="btn btn-sm btn-assignit conform-table"
                                data-id="{{ $activity->id }}" type="button" onclick="openTaskModal({{ $activity->id }})">
                                <img src="{{asset('Asserts/logo/task.png')}}" alt="Confirm" />
                                Task
                            </button>
                        </td>
                    @elseif(SdmManager())
                        @if(in_array($activity->user_id, $totalLeadAndMemberIdsArray))
                            <td>
                                <button  class="btn btn-sm btn-assignit conform-table"
                                    data-id="{{ $activity->id }}" type="button" onclick="openTaskModal({{ $activity->id }})">
                                    <img src="{{asset('Asserts/logo/task.png')}}" alt="Confirm" />
                                    Task
                                </button>
                            </td>
                        @else
                            <td>-</td>
                        @endif
                    @elseif(SdmLead())
                        @if(in_array($activity->user_id, $totalMemberIdsArray))
                            <td>
                                <button  class="btn btn-sm btn-assignit conform-table"
                                    data-id="{{ $activity->id }}" type="button" onclick="openTaskModal({{ $activity->id }})">
                                    <img src="{{asset('Asserts/logo/task.png')}}" alt="Confirm" />
                                    Task
                                </button>
                            </td>
                        @else
                            <td>-</td>
                        @endif
                    @else
                        @if(in_array($activity->user_id, $myIdArray))
                            <td>
                                <button  class="btn btn-sm btn-assignit conform-table"
                                    data-id="{{ $activity->id }}" type="button" onclick="openTaskModal({{ $activity->id }})">
                                    <img src="{{asset('Asserts/logo/task.png')}}" alt="Confirm" />
                                    Task
                                </button>
                            </td>
                        @else
                            <td>-</td>
                        @endif
                    @endif
                    <td>{{ \Carbon\Carbon::parse($activity->activity_start_date)->format('d M Y')}}</td>
                    <td>{{ $activity->ticket_detail }}</td>
                    <td>{{ $activity->client->company_name ?? 'N/A' }}</td>
                    <td>{{ $activity->project->project_name ?? 'N/A' }}</td>
                    <td>{{ $activity->project->project_sdm  ?? 'N/A' }}</td>
                    <td>{{$activity->po_number ?? 'N/A'}}</td>
                    <td>{{ $activity->customer_service_type }}</td>
                    <td>{{ $activity->location  }}</td>
                    <td>{{ $activity->resource->name ?? 'N/A' }}</td>
                    <td>{{ $activity->resource->country->name ?? 'N/A' }}</td>
                    <td>{{ $activity->tech_rates }}{{$activity->techCurrency->symbol}}</td>
                    <td>{{ $activity->customer_rates }}{{$activity->customerCurrency->symbol  }}</td>
                    <td>{{ $activity->remark ?? 'N/A' }}</td>
                    <td>{{ $activity->activity_status }}</td>
                    <td>{{ $activity->user->user_name ?? 'N/A' }}</td>
                    <td>N/A</td>
                    <td>{{ $activity->confirmed_by ?? 'N/A' }}</td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<!-- to make table datatable  -->
<script>
    $(document).ready(function() {
        var table = $('#confirmActivities').DataTable({
            "searching": true,
            "dom": 'lfrtip',
            "pageLength": 50,
            "lengthMenu": [
                [10, 25, 50, 75, 100],
                [10, 25, 50, 75, 100]
            ],
            "buttons": [],
        });
    });
</script>
<!-- to open print page  -->
<script>
    function openPrintPage(id) {
        window.location.href = `/activity-print/${id}`;
    }
</script>
<!-- to open assign model  -->
<script>
    function openAssignModal(activityId) {
        var modalId = "assign_modal_" + activityId;
        var modal = document.getElementById(modalId);
        modal.classList.add("show");
        modal.style.display = "block";
        document.body.classList.add("modal-open");
    }

    document.querySelectorAll("[data-dismiss='modal']").forEach(function(btn) {
        btn.addEventListener("click", function() {
            var modal = btn.closest(".modal");
            modal.classList.remove("show");
            modal.style.display = "none";
            document.body.classList.remove("modal-open");
        });
    });
</script>
<!-- to assign activity  -->
<script>
    function assignActivity(activityId) {
        var formData = new FormData(document.getElementById('assignActivityForm_' + activityId));
        axios.post('{{ route("activity.assign") }}', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                var data = response.data;
                showSuccessAlert('Activity assigned successfully!');
                var modalId = 'assign_modal_' + data.activityId;
                var modal = document.getElementById(modalId);
                if (modal) {
                    modal.style.display = 'none';
                    modal.classList.remove('show');
                }
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                var assignButton = document.querySelector('#assign_activity_' + data.activityId);
                if (assignButton) {
                    assignButton.textContent = 'Assigned';
                }
            })
            .catch(function(error) {
                console.log('Error:', error);
                if (error.response.status === 422) {
                    var errors = error.response.data.errors;
                    if (errors.length > 0) {
                        var errorMessage = errors[0].message;
                        showAlert(errorMessage);
                        var fieldsWithError = errors.map(function(error) {
                            return error.field;
                        });
                        fieldsWithError.forEach(function(fieldWithError, index) {
                            var input = document.querySelector('[name="' + fieldWithError + '"]');
                            if (input) {
                                if (input.value.trim() === '') {
                                    input.classList.add('error-input');
                                    if (index === 0) {
                                        input.focus();
                                    }
                                    if (input.type === 'file') {
                                        input.classList.add('file-not-valid');
                                    }
                                }
                            }
                        });
                    }
                }
            });
    }

    function showAlert(message) {
        var errorList = document.getElementById('error-list');
        var errorItem = document.createElement('li');
        errorItem.textContent = message;
        errorList.appendChild(errorItem);
        var alertDiv = document.getElementById('alert-danger');
        alertDiv.style.display = 'block';
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        setTimeout(function() {
            alertDiv.style.display = 'none';
            errorList.innerHTML = '';
        }, 3000);
    }

    function showSuccessAlert(message) {
        var successAlert = document.getElementById('alert-success');
        successAlert.textContent = message;
        successAlert.style.display = 'block';
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
        setTimeout(function() {
            successAlert.style.display = 'none';
        }, 3000);
    }
</script>
<!-- to open edit page  -->
<script>
    function openEditPage(id) {
        window.location.href = `/activity/edit/${id}`;
    }
</script>
<!-- to open task model  -->
<script>
    function openTaskModal(activityId) {
        var modalId = "task_modal_" + activityId;
        var modal = document.getElementById(modalId);
        modal.classList.add("show");
        modal.style.display = "block";
        document.body.classList.add("modal-open");
    }

    document.querySelectorAll("[data-dismiss='modal']").forEach(function(btn) {
        btn.addEventListener("click", function() {
            var modal = btn.closest(".modal");
            modal.classList.remove("show");
            modal.style.display = "none";
            document.body.classList.remove("modal-open");
        });
    });
</script>
<!-- to assign tsk  -->
<script>
    function assignTask(activityId) {
        var formData = new FormData(document.getElementById('taskForm_' + activityId));
        axios.post('{{ route("activity.assign.task") }}', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                var data = response.data;
                showSuccessAlert('Task assigned successfully!');
                var modalId = 'task_modal_' + data.activityId;
                var modal = document.getElementById(modalId);
                if (modal) {
                    modal.style.display = 'none';
                    modal.classList.remove('show');
                }
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
            })
            .catch(function(error) {
                console.log('Error:', error);
                if (error.response.status === 422) {
                    var errors = error.response.data.errors;
                    if (errors.length > 0) {
                        var errorMessage = errors[0].message;
                        showAlert(errorMessage);
                        var fieldsWithError = errors.map(function(error) {
                            return error.field;
                        });
                        fieldsWithError.forEach(function(fieldWithError, index) {
                            var input = document.querySelector('[name="' + fieldWithError + '"]');
                            if (input) {
                                if (input.value.trim() === '') {
                                    input.classList.add('error-input');
                                    if (index === 0) {
                                        input.focus();
                                    }
                                    if (input.type === 'file') {
                                        input.classList.add('file-not-valid');
                                    }
                                }
                            }
                        });
                    }
                }
            });
    }

    function showAlert(message) {
        var errorList = document.getElementById('error-list');
        var errorItem = document.createElement('li');
        errorItem.textContent = message;
        errorList.appendChild(errorItem);
        var alertDiv = document.getElementById('alert-danger');
        alertDiv.style.display = 'block';
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        setTimeout(function() {
            alertDiv.style.display = 'none';
            errorList.innerHTML = '';
        }, 3000);
    }

    function showSuccessAlert(message) {
        var successAlert = document.getElementById('alert-success');
        successAlert.textContent = message;
        successAlert.style.display = 'block';
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
        setTimeout(function() {
            successAlert.style.display = 'none';
        }, 3000);
    }
</script>
<!-- to calculate time difference  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($activities as $activity)
        const startInput_{{ $activity->id }} = document.getElementById('start_date_time_{{ $activity->id }}');
        const endInput_{{ $activity->id }} = document.getElementById('end_date_time_{{ $activity->id }}');

        if (startInput_{{ $activity->id }} && endInput_{{ $activity->id }}) {
            startInput_{{ $activity->id }}.addEventListener('change', function() {
                calculateDifference({{ $activity->id }});
            });

            endInput_{{ $activity->id }}.addEventListener('change', function() {
                calculateDifference({{ $activity->id }});
            });
        }
        @endforeach
    });

    function calculateDifference(activityId) {
        const startDate = new Date(document.getElementById(`start_date_time_${activityId}`).value);
        const endDate = new Date(document.getElementById(`end_date_time_${activityId}`).value);

        if (startDate && endDate) {
            const differenceInTime = endDate - startDate;
            const differenceInDays = Math.floor(differenceInTime / (1000 * 60 * 60 * 24));
            const differenceInHours = Math.floor((differenceInTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const differenceInMinutes = Math.floor((differenceInTime % (1000 * 60 * 60)) / (1000 * 60));

            let timeDifferenceString = '';
            if (differenceInDays > 0) {
                timeDifferenceString += `${differenceInDays} days `;
            }
            if (differenceInHours > 0) {
                timeDifferenceString += `${differenceInHours} hours `;
            }
            if (differenceInMinutes > 0) {
                timeDifferenceString += `${differenceInMinutes} minutes`;
            }

            if (timeDifferenceString === '') {
                timeDifferenceString = '0 minutes';
            }

            document.getElementById(`time_difference_${activityId}`).value = timeDifferenceString;
            document.getElementById(`duration_${activityId}`).value = timeDifferenceString;
            document.getElementById(`duration_cust_${activityId}`).value = timeDifferenceString;
        
        } else {
            document.getElementById(`time_difference_${activityId}`).value = '';
        }
    }
</script>

<!-- to open confirm activity model  -->
<script>
    function openActivityConfirmModal(activityId) {
        var modalId = "confirm_activity_modal_" + activityId;
        var modal = document.getElementById(modalId);
        modal.classList.add("show");
        modal.style.display = "block";
        document.body.classList.add("modal-open");
    }

    document.querySelectorAll("[data-dismiss='modal']").forEach(function(btn) {
        btn.addEventListener("click", function() {
            var modal = btn.closest(".modal");
            modal.classList.remove("show");
            modal.style.display = "none";
            document.body.classList.remove("modal-open");
        });
    });
</script>
<!-- to confirm activity  -->
<script>
    function closeActivity(activityId) {
        var formData = new FormData(document.getElementById('confirmActivity_' + activityId));
        axios.post('{{ route("close.activity", ["id" => ":activityId"]) }}'.replace(':activityId', activityId), formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log('Response:', response.data);
                var data = response.data;
                showSuccessAlert('Activity closed successfully!');

                var row = document.getElementById('row_' + data.activityId);
                if (row) {
                    row.parentNode.removeChild(row);
                } else {
                    console.warn('Row with id row_' + data.activityId + ' not found.');
                }

                var modalId = 'confirm_activity_modal_' + data.activityId;
                var modal = document.getElementById(modalId);
                if (modal) {
                    modal.style.display = 'none';
                    modal.classList.remove('show');
                }
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
            })
            .catch(function(error) {
                console.log('Error:', error);
                if (error.response.status === 422) {
                    var errors = error.response.data.errors;
                    if (errors.length > 0) {
                        var errorMessage = errors[0].message;
                        showAlert(errorMessage);
                        var fieldsWithError = errors.map(function(error) {
                            return error.field;
                        });
                        fieldsWithError.forEach(function(fieldWithError, index) {
                            var input = document.querySelector('[name="' + fieldWithError + '"]');
                            if (input) {
                                if (input.value.trim() === '') {
                                    input.classList.add('error-input');
                                    if (index === 0) {
                                        input.focus();
                                    }
                                    if (input.type === 'file') {
                                        input.classList.add('file-not-valid');
                                    }
                                }
                            }
                        });
                    }
                }
            });
    }

    function showAlert(message) {
        var errorList = document.getElementById('error-list');
        var errorItem = document.createElement('li');
        errorItem.textContent = message;
        errorList.appendChild(errorItem);
        var alertDiv = document.getElementById('alert-danger');
        alertDiv.style.display = 'block';
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        setTimeout(function() {
            alertDiv.style.display = 'none';
            errorList.innerHTML = '';
        }, 3000);
    }

    function showSuccessAlert(message) {
        var successAlert = document.getElementById('alert-success');
        successAlert.textContent = message;
        successAlert.style.display = 'block';
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
        setTimeout(function() {
            successAlert.style.display = 'none';
        }, 3000);
    }
</script>
<!-- to open send mail model  -->
<script>
    function openEmailModal(activityId) {
        var modalId = "send_email_modal_" + activityId;
        var modal = document.getElementById(modalId);
        modal.classList.add("show");
        modal.style.display = "block";
        document.body.classList.add("modal-open");
    }

    document.querySelectorAll("[data-dismiss='modal']").forEach(function(btn) {
        btn.addEventListener("click", function() {
            var modal = btn.closest(".modal");
            modal.classList.remove("show");
            modal.style.display = "none";
            document.body.classList.remove("modal-open");
        });
    });
</script>
<!-- to send mail  -->
<script>
    function sendEmail(activityId) {
        var formData = new FormData(document.getElementById('sendemail_' + activityId));
        axios.post('{{ route("activity.send.email") }}', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                var data = response.data;
                showSuccessAlert('Mail sent successfully!');
                var modalId = 'send_email_modal_' + data.activityId;
                var modal = document.getElementById(modalId);
                if (modal) {
                    modal.style.display = 'none';
                    modal.classList.remove('show');
                }
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
            })
            .catch(function(error) {
                console.log('Error:', error);
                if (error.response.status === 422) {
                    var errors = error.response.data.errors;
                    if (errors.length > 0) {
                        var errorMessage = errors[0].message;
                        showAlert(errorMessage);
                        var fieldsWithError = errors.map(function(error) {
                            return error.field;
                        });
                        fieldsWithError.forEach(function(fieldWithError, index) {
                            var input = document.querySelector('[name="' + fieldWithError + '"]');
                            if (input) {
                                if (input.value.trim() === '') {
                                    input.classList.add('error-input');
                                    if (index === 0) {
                                        input.focus();
                                    }
                                    if (input.type === 'file') {
                                        input.classList.add('file-not-valid');
                                    }
                                }
                            }
                        });
                    }
                }
            });
    }

    function showAlert(message) {
        var errorList = document.getElementById('error-list');
        var errorItem = document.createElement('li');
        errorItem.textContent = message;
        errorList.appendChild(errorItem);
        var alertDiv = document.getElementById('alert-danger');
        alertDiv.style.display = 'block';
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        setTimeout(function() {
            alertDiv.style.display = 'none';
            errorList.innerHTML = '';
        }, 3000);
    }

    function showSuccessAlert(message) {
        var successAlert = document.getElementById('alert-success');
        successAlert.textContent = message;
        successAlert.style.display = 'block';
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
        setTimeout(function() {
            successAlert.style.display = 'none';
        }, 3000);
    }
</script>

@endpush