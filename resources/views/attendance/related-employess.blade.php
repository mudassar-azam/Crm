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

    #records {
        table-layout: fixed;
        width: 100%;
    }

    #records thead tr th,
    #records tbody tr td {
        width: 10em;
        white-space: nowrap;
        overflow: hidden;
        font-size: 12px;
        border-bottom: 1px solid lightgray;
    }

    #records tbody tr td {
        overflow-x: auto;
        max-width: 10em;
    }

    #records tbody tr td::-webkit-scrollbar {
        width: 3px;
        height: 0px;
    }

    #records tbody tr td::-webkit-scrollbar-track {
        background: none;
    }

    #records tbody tr td::-webkit-scrollbar-thumb {
        background: #e94d65;
    }

    #records tbody tr td::-webkit-scrollbar-thumb:hover {
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
</style>

<div class="data-container datatable datatable-container">
    <div class="data-table-container scrollable-table">
        <table id="records" class="table table-sm table-hover table-bordered" style="width: 79vw;">
            <thead>
                <tr class="table-header">
                    <th>Name</th>
                    <th>Role</th>
                    <th>Check In Time</th>
                    <th>Check Out Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    @if($user->role_type != 'engineer')
                        <tr id="row_{{ $user->id }}">
                            <td>
                                <a style="color: black !important;" href="{{ route('allAttendance', $user->id ) }}">{{ $user->user_name ?? '-' }}</a>
                            </td>
                            <td>{{ $user->role->name ?? '-' }}</td>
                            <td>{{ $user->check_in ?? '-' }}</td>
                            <td>{{ $user->check_out ?? '-' }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')

<script>
$(document).ready(function() {
    var table = $('#records').DataTable({
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
@endpush
