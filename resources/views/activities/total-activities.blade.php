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
        #approvedActivities {
            table-layout: fixed;
            width: 100%;
        }

        #approvedActivities thead tr th,
        #approvedActivities tbody tr td {
            width: 11em !important;
            white-space: nowrap;
            overflow: hidden;
            font-size: 12px;
            border-bottom: 1px solid lightgray;
        }

        #approvedActivities tbody tr td {
            overflow-x: auto;
            max-width: 11em !important;
        }

        #approvedActivities tbody tr td::-webkit-scrollbar {
            width: 3px;
            height: 0px;
        }

        #approvedActivities tbody tr td::-webkit-scrollbar-track {
            background: none;
        }

        #approvedActivities tbody tr td::-webkit-scrollbar-thumb {
            background: #e94d65;
        }

        #approvedActivities tbody tr td::-webkit-scrollbar-thumb:hover {
            background: #2d6d8b;
            width: 7px;
        }
        .table-header{
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
        .conform-table{
            font-size: 10px !important;
        }
</style>
<form mehtod="get" action="{{route('total.activities')}}">
    <div class="approved-activities">
        <div id="alert-danger" class="alert alert-danger" style="display: none;">
            <ul id="error-list"></ul>
        </div>
        <div id="alert-success" class="alert alert-success" style="display: none;"></div>
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
<div class="data-container datatable datatable-container" style="overflow-x: scroll;">
    <div class="data-table-container datatable-container-header">
        <div class="left-side-header">
            <div class="record">
                <h3>Total Activities</h3>
            </div>
        </div>
    </div>
    <div class="data-table-container scrollable-table">
        <table id="approvedActivities" class="table table-sm  table-hover table-bordered" style="width: 88vw;">
            <thead>
                <tr class="table-header">
                    <td>Sr#</td>
                    <th>Edit</th>
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
                    <th>Total Tech Payments</th>
                    <th>Client Service Type</th>
                    <th>Client Rates </th>
                    <th>Client Duration </th>
                    <th>Total Client Payments</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Sign Of Sheet</th>
                    <th>Remarks</th>
                    <th>Tech Payment Status</th>
                    <th>Tracking</th>
                    <th>Uploades By</th>
                    <th>Confirmed By</th>
                    <th>Completed By</th>
                    <th>Approved By</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                <tr id="row_{{ $activity->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <button class="rounded-circle btn btn-primary btn-sm edit-table" type="button"
                            onclick="openEditPage({{ $activity->id }})">
                            <img src="{{asset('Asserts/logo/edit-table.png')}}" />
                        </button>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($activity->activity_start_date)->format('d M Y')}}</td>
                    <td>{{ $activity->ticket_detail }}</td>
                    <td>{{ $activity->client->company_name ?? 'N/A' }}</td>
                    <td>{{ $activity->project->project_name ?? 'N/A' }}</td>
                    <td>{{ $activity->project->project_sdm  ?? 'N/A' }}</td>
                    <td>{{$activity->po_number}}</td>
                    <td>{{ $activity->customer_service_type }}</td>
                    <td>{{ $activity->location }}</td>
                    <td>{{ $activity->resource->name ?? 'N/A' }}</td>
                    <td>{{ $activity->resource->country->name ?? 'N/A' }}</td>
                    <td>{{ $activity->tech_rates}}{{$activity->techCurrency->symbol  }}</td>
                    <td>{{  $activity->duration }}</td>
                    <td>{{  $activity->total_tech_payments }}</td>
                    <td>{{  $activity->customer_service_type }}</td>
                    <td>{{ $activity->customer_rates }}{{$activity->customerCurrency->symbol  }}</td>
                    <td>{{ $activity->duration_cust }}</td>
                    <td>{{  $activity->total_customer_payments }}</td>
                    <td>{{ $activity->start_date_time }}</td>
                    <td>{{ $activity->end_date_time }}</td>
                    <td>
                        @if($activity->sign_of_sheet)
                        <a href="{{ route('activity.download', $activity->sign_of_sheet) }}">Download</a>
                        @else
                        N/A
                        @endif
                    </td>
                    <td>{{ $activity->remark ?? 'N/A'}}</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>{{ $activity->user->user_name ?? 'N/A'}}</td>
                    <td>{{$activity->confirmed_by ?? 'N/A'}}</td>
                    <td>{{$activity->completed_by ?? 'N/A'}}</td>
                    <td>{{ $activity->approved_by ?? 'N/A'}}</td>
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
            var table = $('#approvedActivities').DataTable({
                "searching": true,
                "dom": 'lfrtip',
                "pageLength": 50, 
                "lengthMenu": [ [10, 25, 50, 75, 100], [10, 25, 50, 75, 100] ], 
                "buttons": [],
            });
    });
</script>
<!-- to open edit page  -->
<script>
    function openEditPage(id) {
        window.location.href = `/total-activity/edit/${id}`;
    }
</script>
@endpush