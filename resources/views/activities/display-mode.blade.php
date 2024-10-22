@extends("layouts.displayMode")
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

    .right-side-header-datatable-container #popup-button-links {
        width: 3em;
        height: 3em;
        border-radius: 50%;
        border: none;
        background-color: transparent;
        padding: 0;
    }

    #popup-container.popup-overlay {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 9999;
        padding-bottom: 2em;
    }

    #popup-container .popup-box {
        padding: 20px;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    #popup-container .popup-box a {
        text-decoration: none;
        color: white;
        font-size: 14px;
        line-height: 4em;
        transition: 0.2s ease-out;
        font-size : 25px;
    }

    #popup-container .popup-box a:hover {
        text-decoration: none;
        color: #e94d65;

        font-size: 16px;
    }

    #popup-container .popup-box .popup-close {
        color: #aaa;
        position: absolute;
        top: 0em;
        right: 0.5em;
        font-size: 3em;
        transition: 0.2s ease-in;
    }

    #popup-container .popup-box .popup-close:hover,
    #popup-container .popup-box .popup-close:focus {
        color: #e94d65;
        text-decoration: none;
        cursor: pointer;
    }

    a:hover {
        cursor: pointer;
    }

    #displayMode {
        width: 100%;
        text-wrap: wrap;
    }
    #displayMode {
    width: 100% !important;
    table-layout: fixed;
    }

    #displayMode thead tr th,
    #displayMode tbody tr td {
        width: auto;
        white-space: normal; 
        overflow-wrap: break-word;
        font-size: 12px;
        border-bottom: 1px solid lightgray;
        text-align: left;
    }


    body {
        grid-auto-rows: 0.19fr 1fr;
    }

    .table-header {
        background-color: #206D88;
        color: white;
        font-weight: 600;
        font-size: 13px;
    }

    .highlight-today {
        background-color: #E94D65 !important;
        color: white !important;
    }

    .data-table-container {
        overflow: hidden;
        padding: 0;
        border-radius: 0;
        width: 100%;
    }
    .scrollable {
    overflow: auto; 
    white-space: nowrap !important;
    max-width: 100%;
    display: inline-block; 
    border: none !important;
    }

    .scrollable::-webkit-scrollbar {
        height: 0px; 
    }

    .scrollable::-webkit-scrollbar-thumb {
        background: #e94d65; 
    }

    .scrollable::-webkit-scrollbar-thumb:hover {
        background: #2d6d8b; 
    }
    #confirm{
        display : flex;
        align-items : center;
        justify-content : center;
    }
    .main-heading{
        font-size:30px;
        font-weight:bold;
    }
</style>

<div id="popup-container" class="popup-overlay">
    <div class="popup-box">
        <span class="popup-close">&times;</span>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    </div>
</div>
<div class="data-container datatable datatable-container">
    <div class="data-table-container datatable-container-header" style="width: 56%;margin-left: auto;">
        <div class="left-side-header" style="width: 100%;">
            <div id="confirm" class="record">
                <span class="main-heading">Confirmed Activities</span>
            </div>
            <div class="right-side-header-datatable-container">
                <button id="popup-button-links">
                    <img src="{{asset('Asserts/logo/threee-dots.png')}}">
                </button>
            </div>
        </div>
    </div>
    @php
        $today = \Carbon\Carbon::today()->format('m/d/Y');
    @endphp
    <div class="data-table-container scrollable-table" style="overflow: auto;">
        <table id="displayMode" class="table table-sm  table-hover table-bordered" style="width: 79vw;">
            <thead>
                <tr class="table-header">
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>Pakistan's Time </th>
                    <th>Assignment</th>
                    <th>Ticket Details</th>
                    <th>Customer</th>
                    <th>Tech Name</th>
                    <th>Country </th>
                    <th>On The Way</th>
                    <th>Reached</th>
                    <th>Client Updated</th>
                    <th>Working</th>
                    <th>Over Time</th>
                    <th>Job Done</th>
                    <th>Again Client Update</th>
                    <th>Time Sheet Recieved</th>
                    <th>Activity Completed</th>
                    <th>SVR Shared With Client</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                @php
                $activityDate = \Carbon\Carbon::parse($activity->activity_start_date)->startOfDay();
                $today = \Carbon\Carbon::today()->startOfDay();
                $isHighlight = $activityDate->lessThanOrEqualTo($today);
                @endphp
                <tr id="row_{{ $activity->id }}" class="{{ $isHighlight ? 'highlight-today' : '' }}">
                    <td>{{\Carbon\Carbon::parse($activity->activity_start_date)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($activity->activity_start_date)->format('h:i A') }}</td>
                    <td>{{ \Carbon\Carbon::parse($activity->pakistani_time)->format('h:i A')}}</td>
                    <td>{{ $activity->assignment ?? 'N/A' }}</td>
                    <td class="scrollable">{{ $activity->ticket_detail ?? 'N/A' }}</td>
                    <td>{{$activity->client->company_name ?? 'N/A'}}</td>
                    <td>{{$activity->resource->name ?? 'N/A'}}</td>
                    <td>{{ $activity->country->name ?? 'N/A' }}</td>
                    <td>{{ $activity->ff == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $activity->reached == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $activity->inform_client == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $activity->ff_working == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $activity->ff_need_time == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $activity->job == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $activity->update_client == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $activity->sign_of_sheet_received == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $activity->activity_completed == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $activity->svr_shared == 1 ? 'Yes' : 'No' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<!-- kashan script  -->
<script>
    var popup = document.getElementById("popup-container");
    var btn = document.getElementById("popup-button-links");

    var span = document.getElementsByClassName("popup-close")[0];

    btn.addEventListener('click', function() {
        popup.style.display = "block";
    });
    span.addEventListener('click', function() {
        popup.style.display = "none";
    });
    window.addEventListener('click', function(event) {
        if (event.target == popup) {
            popup.style.display = "none";
        }
    });
</script>
@endpush