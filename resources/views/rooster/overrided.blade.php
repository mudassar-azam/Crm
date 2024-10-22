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

    #roosters {
        table-layout: fixed;
        width: 100%;
    }

    #roosters thead tr th,
    #roosters tbody tr td {
        width: 10em;
        white-space: nowrap;
        overflow: hidden;
        font-size: 12px;
        border-bottom: 1px solid lightgray;
    }

    #roosters tbody tr td {
        overflow-x: auto;
        max-width: 10em;
    }

    #roosters tbody tr td::-webkit-scrollbar {
        width: 3px;
        height: 0px;
    }

    #roosters tbody tr td::-webkit-scrollbar-track {
        background: none;
    }

    #roosters tbody tr td::-webkit-scrollbar-thumb {
        background: #e94d65;
    }

    #roosters tbody tr td::-webkit-scrollbar-thumb:hover {
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
    .rooster{
        display:flex;
        align-items:center;
        justify-content:center;
    }
    .cview-button{
        background-color: #2D6D8B;
        color: white;
        padding: 5px;
        border-radius: 10px;
        border-color: #2D6D8B;
    }
</style>
<div class="rooster">
    <h3>Overrided Dates</h3>
</div>
<div class="data-container datatable datatable-container">
    <div class="data-table-container scrollable-table">
        <table id="roosters" class="table table-sm table-hover table-bordered" style="width: 79vw;">
            <thead>
                <tr class="table-header">
                    <th>User</th>
                    <th>Type</th>
                    <th>Overriden Date</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roosters as $rooster)
                    <tr id="row_{{ $rooster->id }}">
                        <td>{{ $rooster->rooster->user->user_name ?? '-' }}</td>
                        <td>{{ $rooster->type }}</td>
                        <td>{{ \Carbon\Carbon::parse($rooster->override_date)->format('d M Y')}}</td>
                        <td>
                            <button style="border: #E94D65 !important; background-color: #E94D65 !important;"
                                data-id="{{ $rooster->id }}" class="rounded-circle btn btn-primary btn-sm delete-rooster"
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
        var table = $('#roosters').DataTable({
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

    $(document).on('click', '.delete-rooster', function() {
        var roosterId = $(this).data('id');
        if (confirm('Are you sure you want to delete this?')) {
            $.ajax({
                url: '/override/rooster/destroy/' + roosterId,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#row_' + roosterId).remove();
                    alert('Deleted successfully');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });

    function openEditPage(id) {
        window.location.href = `/rooster/edit/${id}`;
    }
</script>
@endpush
