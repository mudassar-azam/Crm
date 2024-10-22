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
                    <th>Manager</th>
                    <th>Lead</th>
                    <th>Member</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leads as $lead)
                    <tr id="row_{{ $lead->id }}">
                        <td>{{ $lead->manager->user_name ?? '-' }}</td>
                        <td>{{ $lead->user->user_name ?? '-' }}</td>
                        <td>
                            @if($lead->members->isEmpty())
                                -
                            @else
                                @foreach($lead->members as $member)
                                    {{ $member->user->user_name ?? '-' }}
                                    @if(!$loop->last)
                                        <br>
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <button class="rounded-circle btn my-btn-primary btn-sm" type="button"
                                onclick="openEditPage({{ $lead->id }})">
                                <img src="{{ asset('Asserts/logo/edit-table.png') }}" />
                            </button>
                        </td>
                        <td>
                            <button style="border: #E94D65 !important; background-color: #E94D65 !important;"
                                data-id="{{ $lead->id }}" class="rounded-circle btn btn-primary btn-sm delete-record"
                                type="button">
                                <img src="{{ asset('Asserts/logo/delete.png') }}" />
                            </button>
                        </td>
                    </tr>
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

$(document).on('click', '.delete-record', function() {
    var recordId = $(this).data('id');
    if (confirm('Are you sure you want to delete this?')) {
        $.ajax({
            url: '/destroyLead&Member/' + recordId,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#row_' + recordId).remove();
                alert('Lead and Members deleted successfully');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
});

function openEditPage(id) {
    window.location.href = `/edit-assigned/${id}`;
}
</script>
@endpush
