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

    #clients {
        table-layout: fixed;
        width: 100%;
    }

    #clients thead tr th,
    #clients tbody tr td {
        width: 10em;
        white-space: nowrap;
        overflow: hidden;
        font-size: 12px;
        border-bottom: 1px solid lightgray;
    }

    #clients tbody tr td {
        overflow-x: auto;
        max-width: 10em;
    }

    #clients tbody tr td::-webkit-scrollbar {
        width: 3px;
        height: 0px;
    }

    #clients tbody tr td::-webkit-scrollbar-track {
        background: none;
    }

    #clients tbody tr td::-webkit-scrollbar-thumb {
        background: #e94d65;
    }

    #clients tbody tr td::-webkit-scrollbar-thumb:hover {
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

<form mehtod="get" action="{{route('client.index')}}">
    <div class="approved-activities">
        <div id="alert-danger" class="alert alert-danger" style="display: none;">
            <ul id="error-list"></ul>
        </div>
        <div id="alert-success" class="alert alert-success" style="display: none;"></div>

        <div class="select status">
            <h5>From Date</h5>
            <input type="date" name="from_date" value="{{ old('from_date', request('from_date')) }}">
        </div>
        <div class="select work">
            <h5>To Date</h5>
            <input type="date" name="to_date" value="{{ old('to_date', request('to_date')) }}">
        </div>
    </div>

    <div class="form-btns">
        <p></p>
        <button type="submit" class="request-btn">
            Filter Request
        </button>
    </div>
</form>
<div class="data-container datatable datatable-container">
    <div class="data-table-container datatable-container-header">
        <div class="left-side-header">
            <div class="record">
                <h3>Clients</h3>
                <p>Clients that are available</p>
            </div>
        </div>
    </div>
    <div class="data-table-container scrollable-table">
        <table id="clients" class="table table-sm  table-hover table-bordered" style="width: 79vw;">
            <thead>
                <tr class="table-header">
                    <th>Sr#</th>
                    <th>Action</th>
                    <th>Delete</th>
                    <th>Company Name</th>
                    <th>Registration No</th>
                    <th>Company Address</th>
                    <th>Comapny HQ</th>
                    <th>Form NDA</th>
                    <th>Uploaded By</th>
                    <th>Uploaded At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr id="row_{{ $client->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td class="space-between">
                        <button class="rounded-circle btn btn-primary btn-sm edit-table" type="button"
                            onclick="openEditPage({{ $client->id }})">
                            <img src="{{asset('Asserts/logo/edit-table.png')}}" />
                        </button>
                    </td>
                    <td>
                        <button style=" border: #E94D65 !important;  background-color: #E94D65 !important;"
                            data-id="{{ $client->id }}" class="rounded-circle btn btn-primary btn-sm delete-client"
                            type="button">
                            <img src="{{asset('Asserts/logo/delete.png')}}" />
                        </button>
                    </td>
                    <td>{{ $client->company_name ?? 'N/A' }}</td>
                    <td>{{ $client->registration_no ?? 'N/A' }}</td>
                    <td>{{ $client->company_address ?? 'N/A' }}</td>
                    <td>{{ $client->company_hq ?? 'N/A' }}</td>
                    <td>
                        @if($client->form_nda_coc_sow != null)
                        <a href="{{ route('formNdaDownload', $client->form_nda_coc_sow) }}">Download</a>
                        @else
                        N/A
                        @endif
                    </td>
                    <td>{{ $client->user->user_name ?? 'N/A' }}</td>
                    <td>{{ $client->created_at->format('d M Y') }}</td>
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
        var table = $('#clients').DataTable({
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
<!-- for deletion  -->
<script>
    $(document).ready(function() {
        $('.delete-client').click(function() {
            var clientId = $(this).data('id');
            if (confirm('Are you sure you want to delete this client?')) {
                $.ajax({
                    url: '/deleteClient/' + clientId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#row_' + clientId).remove();
                        alert('Client deleted  successfully');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
<!-- to open edit model  -->
<script>
    function openEditPage(id) {
        window.location.href = `/client/edit/${id}`;
    }
</script>
@endpush