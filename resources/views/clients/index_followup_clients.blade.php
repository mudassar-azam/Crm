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

    #followupclients {
        table-layout: fixed;
        width: 100%;
    }

    #followupclients thead tr th,
    #followupclients tbody tr td {
        width: 10em;
        white-space: nowrap;
        overflow: hidden;
        font-size: 12px;
        border-bottom: 1px solid lightgray;
    }

    #followupclients tbody tr td {
        overflow-x: auto;
        max-width: 10em;
    }

    #followupclients tbody tr td::-webkit-scrollbar {
        width: 3px;
        height: 0px;
    }

    #followupclients tbody tr td::-webkit-scrollbar-track {
        background: none;
    }

    #followupclients tbody tr td::-webkit-scrollbar-thumb {
        background: #e94d65;
    }

    #followupclients tbody tr td::-webkit-scrollbar-thumb:hover {
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

    .btn-activities {
        background-color: #00ADEA !important;
        color: white !important;
        border: 1px solid #00ADEA;
        padding: 0.5em;
        border-radius: 10px
    }
    .modal-dialog{
        width: 30%;
    }
    .modal-body label{
        font-size: 14px;
        font-weight: 600;
    }
    .modal-body select{
        width: 100%;
        border: 1px solid lightgray;
        border-radius: 5px;
    }
</style>

<form mehtod="get" action="{{route('client.follow.index')}}">
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
                <h3>Follow-up Clients</h3>
            </div>
        </div>
    </div>
    <div class="data-table-container scrollable-table">
        <table id="followupclients" class="table table-sm  table-hover table-bordered" style="width: 79vw;">
            <thead>
                <tr class="table-header">
                    <th>Sr#</th>
                    <th>Action</th>
                    <th>Delete</th>
                    <th>Add</th>
                    <th>Company Name</th>
                    <th>Worth</th>
                    <th>Comapny HQ</th>
                    <th>Sports Area</th>
                    <th>Status</th>
                    <th>Time Of Change</th>
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
                            data-id="{{ $client->id }}"
                            class="rounded-circle btn btn-primary btn-sm delete-follow-up-client" type="button">
                            <img src="{{asset('Asserts/logo/delete.png')}}" />
                        </button>
                    </td>
                    <td>
                        <button type="button" data-id="{{ $client->id }}" class="btn-activities add-to-normal">
                            Client Upload
                        </button>
                    </td>
                    <td>{{ $client->company_name ?? 'N/A' }}</td>
                    <td>{{ $client->worth ?? 'N/A' }}</td>
                    <td>{{ $client->company_hq ?? 'N/A' }}</td>
                    <td>{{ $client->sport_areas ?? 'N/A' }}</td>
                    <td>
                        <button type="button" class="btn-activities" onclick="openModal({{ $client->id }})">
                            {{ $client->status ?? 'N/A' }}
                        </button>
                        <form id="change_status_{{ $client->id }}" action="{{route('client.followup.change.status')}}" method="post">
                            @csrf
                            <div class="modal" id="client_modal_{{ $client->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-xl shadow-lg" role="document"
                                    style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                    <input type="hidden" name="clientId" value="{{$client->id}}">
                                    <div class="modal-content modal-xl shadow-lg" style="border-radius: 10px;">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modelHeading">Change Status
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="data">
                                                <div class="data">
                                                    <label for="description">Status</label><br>
                                                    <select name="status">
                                                        <option value="chase 1" {{ $client->status === 'chase 1' ? 'selected' : '' }}>Chase 1</option>
                                                        <option value="chase 2" {{ $client->status === 'chase 2' ? 'selected' : '' }}>Chase 2</option>
                                                        <option value="chase 3" {{ $client->status === 'chase 3' ? 'selected' : '' }}>Chase 3</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="model-footer-button" type="button"
                                                onclick="changeStatus({{ $client->id }})">Cange</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </td>
                    <td>{{$client->time ?? 'N/A'}}</td>
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

<script src="https://code.query.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#followupclients').DataTable({
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
        $('.delete-follow-up-client').click(function() {
            var clientId = $(this).data('id');
            if (confirm('Are you sure you want to delete this client?')) {
                $.ajax({
                    url: '/deleteFollowUpClient/' + clientId,
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
        window.location.href = `/follow-up-client/edit/${id}`;
    }
</script>
<!-- for add to normal  -->
<script>
    $(document).ready(function() {
        $('.add-to-normal').click(function() {
            var clientId = $(this).data('id');
            if (confirm('Are you sure you want to upload this client?')) {
                $.ajax({
                    url: '/add-to-normal/' + clientId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#row_' + clientId).remove();
                        alert('Client uploaded  successfully');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
<!-- to open mode  -->
<script>
    function openModal(clientId) {
        var modalId = "client_modal_" + clientId;
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
<!-- to change status  -->
<script>
    function changeStatus(clientId) {
        var formData = new FormData(document.getElementById('change_status_' + clientId));
        axios.post('{{ route("client.followup.change.status") }}', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                var data = response.data;
                var modalId = 'client_modal_' + data.clientId;
                var modal = document.getElementById(modalId);
                if (modal) {
                    modal.style.display = 'none';
                }
                document.body.style.overflow = 'auto';
                var rowId = 'row_' + data.clientId;
                var tableRow = document.getElementById(rowId);
                if (tableRow) {
                    tableRow.cells[8].textContent = data.client.status;
                    tableRow.cells[9].textContent = data.client.time;
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
</script>
@endpush