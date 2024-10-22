@extends('layouts.app3')

@section('content')
<style>
#Activities {
    table-layout: fixed;
    width: 100%;

}

.data-table-container {
    border-radius: 0;
}

#Activities thead tr th,
#Activities tbody tr td {
    width: 15em !important;
    white-space: nowrap;
    overflow: hidden;
    font-size: 12px;
    border: none;
    border-bottom: 1px solid lightgray;
}

#Activities tbody tr td {
    overflow-x: auto;
    max-width: 10em !important;
}

#Activities tbody tr td::-webkit-scrollbar {
    width: 5px;
    height: 3px;
}

#Activities tbody tr td::-webkit-scrollbar-track {
    background: none;
}

#Activities tbody tr td::-webkit-scrollbar-thumb {
    background: #e94d65;
}

#Activities tbody tr td::-webkit-scrollbar-thumb:hover {
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
@if($paidActivities->isNotEmpty())
    <div class="data-container datatable datatable-container" style="width: 98%;">
        <div class="data-table-container datatable-container-header">
            <div class="left-side-header">
                <div class="record">
                    <h3>Activities</h3>
                    <p>Paid Activities Of Engineer</p>
                </div>
            </div>

            <div class="right-side-header">

            </div>
        </div>
        <div class="data-table-container scrollable-table">
            <table id="Activities" class="table table-sm  table-hover table-bordered" style="width: 80vw;">
                <thead>
                    <tr class="table-header">
                        <th>Engineer Name</th>
                        <th>Tech City</th>
                        <th>Tech Country</th>
                        <th>Activity Start Date</th>
                        <th>Ticket Detail</th>
                        <th>Activity Description</th>
                        <th>Location</th>
                        <th>Tech Rate</th>
                        <th>Service Type</th>
                        <th>Duration</th>
                        <th>Total Tech Payment</th>
                        <th>Payment Proof</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paidActivities as $activity)
                    <tr id="row_{{ $activity->id }}">
                        <td>{{$name}}</td>
                        <td>{{ $activity->tech_city ?? 'N/A' }}</td>
                        <td>{{ $activity->country->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($activity->activity_start_date)->format('d M Y')}}</td>
                        <td>{{ $activity->ticket_detail ?? 'N/A'}}</td>
                        <td>{{ $activity->activity_description ?? 'N/A'}}</td>
                        <td>{{ $activity->location ?? 'N/A'}}</td>
                        <td>{{ $activity->tech_rates ?? 'N/A'}}</td>
                        <td>{{ $activity->tech_service_type ?? 'N/A'}}</td>
                        <td>{{ $activity->duration ?? 'N/A'}}</td>
                        <td>{{ $activity->total_tech_payments ?? 'N/A'}}</td>
                        <td>
                            @if($activity->invoicesWithoutClient)
                                @foreach($activity->invoicesWithoutClient as $invoice)
                                    <a href="{{ route('proofDownload', $invoice->payment_proof) }}">Download</a>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <p>No Paid Activities Found !</p>
@endif
@endsection