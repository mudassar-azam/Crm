@extends("layouts.app")
@section('content')
<style>
    input[type='number']::-webkit-outer-spin-button,
    input[type='number']::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type='number'] {
        -moz-appearance: textfield;
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

    #closedActivities {
        table-layout: fixed;
        width: 100%;
    }

    #closedActivities thead tr th,
    #closedActivities tbody tr td {
        width: 10.5em !important;
        white-space: nowrap;
        overflow: hidden;
        font-size: 12px;
        border-bottom: 1px solid lightgray;
    }

    #closedActivities tbody tr td {
        overflow-x: auto;
        max-width: 10.5em !important;
    }

    #closedActivities tbody tr td::-webkit-scrollbar {
        width: 3px;
        height: 0px;
    }

    #closedActivities tbody tr td::-webkit-scrollbar-track {
        background: none;
    }

    #closedActivities tbody tr td::-webkit-scrollbar-thumb {
        background: #e94d65;
    }

    #closedActivities tbody tr td::-webkit-scrollbar-thumb:hover {
        background: #2d6d8b;
        width: 7px;
    }

    .table-header {
        background-color: #206D88;
        color: white;
        font-weight: 600;
        font-size: 13px;
    }
</style>
<form mehtod="get" action="{{route('activity.completed')}}">
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
                <option value="{{$client->id}}" {{ request('company_id') === (string) $client->id ? 'selected' : '' }}>{{$client->company_name}}</option>
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
@endphp
<div class="data-container datatable datatable-container" style="overflow-x: scroll;">
    <div class="data-table-container datatable-container-header">
        <div class="left-side-header">
            <div class="record">
                <h3>Completed-activities</h3>
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
    <div class="data-table-container  scrollable-table">
        <table id="closedActivities" class="table table-sm  table-hover table-bordered" style="width: 88vw">
            <thead>
                <tr class="table-header">
                    <td>Sr#</td>
                    <th>Action</th>
                    @if(AdminOrSdmManager())
                        <th>Approve</th>
                    @endif
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
                    <th>Tech Duration</th>
                    <th>Total Tech Payment</th>
                    <th>Client Service Type</th>
                    <th>Client Rates </th>
                    <th>Client Duration </th>
                    <th>Total Client Payment</th>
                    <th>Remarks</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th>Sign Of Sheet</th>
                    <th>Tracking</th>
                    <th>Tech Payment Status</th>
                    <th>Uploaded</th>
                    <th>Confirmed By</th>
                    <th>Completed By</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                <tr id="row_{{ $activity->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td class="space-between" style="border: none;">

                    @if(AdminOrSdmManagerOrLead())
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
                        @endif 
                    @endif    
                        
                    <button class="rounded-circle btn btn-danger btn-sm delete-table"
                        onclick="openPrintPage({{ $activity->id }})" type="button">
                        <img src="{{asset('Asserts/logo/export-pdf.png')}}" />
                    </button>
                    </td>
                        @if(AdminOrSdmManager())
                            <td><button data-id="{{ $activity->id }}" type="button"
                                    class="btn btn-sm delete-btn btn-primaryy  conform-table">
                                    <img src="{{asset('Asserts/logo/confirm-btn.png')}}" />
                                    Approve
                                </button>
                            </td>
                        @endif
                        <td>{{ \Carbon\Carbon::parse($activity->activity_start_date)->format('d M Y')}}</td>
                        <td>{{ $activity->ticket_detail }}</td>
                    <td>{{ $activity->client->company_name ?? 'N/A' }}</td>
                    <td>{{ $activity->project->project_name ?? 'N/A' }}</td>
                    <td>{{ $activity->project->project_sdm  ?? 'N/A' }}</td>
                    <td>{{$activity->po_number}}</td>
                    <td>{{ $activity->tech_service_type }}</td>
                    <td>{{ $activity->location }}</td>
                    <td>{{ $activity->resource->name ?? 'N/A' }}</td>
                    <td>{{ $activity->resource->country->name  ?? 'N/A' }}</td>
                    <td>{{ $activity->tech_rates }}{{$activity->techCurrency->symbol  }}</td>
                    <td>{{  $activity->duration }}</td>
                    <td>{{  $activity->total_tech_payments }}</td>
                    <td>{{  $activity->customer_service_type }}</td>
                    <td>{{ $activity->customer_rates }}{{$activity->customerCurrency->symbol  }}</td>
                    <td>{{ $activity->duration_cust }}</td>
                    <td>{{  $activity->total_customer_payments }}</td>
                    <td>{{ $activity->remark }}</td>
                    <td>{{ $activity->start_date_time }}</td>
                    <td>{{ $activity->end_date_time }}</td>
                    <td>{{ $activity->activity_status }}</td>
                    <td>
                        @if($activity->sign_of_sheet)
                        <a href="{{ route('activity.download', $activity->sign_of_sheet) }}">Download</a>
                        @else
                        N/A
                        @endif
                    </td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>{{$activity->user->user_name ?? 'N/A'}}</td>
                    <td>{{$activity->confirmed_by ?? 'N/A'}}</td>
                    <td>{{$activity->completed_by ?? 'N/A'}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<!-- for making table datatable  -->
<script>
    $(document).ready(function() {
        var table = $('#closedActivities').DataTable({
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
<!-- to open model  -->
<script>
    function openModal(activityId) {
        var modalId = "confirmActivityForm" + activityId;
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
<!-- to open edit and print page  -->
<script>
    function openEditPage(id) {
        window.location.href = `/activity/edit/${id}`;
    }
</script>
<script>
    function openPrintPage(id) {
        window.location.href = `/activity-print/${id}`;
    }
</script>
<!-- to delete  -->
<script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            var activityId = $(this).data('id');
            if (confirm('Are you sure you want to approve this activity?')) {
                $.ajax({
                    url: '/approveActivity/' + activityId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#row_' + activityId).remove();
                        alert('Activity approved successfully');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
@endpush