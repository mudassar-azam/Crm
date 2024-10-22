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
        #plannedActivities {
            table-layout: fixed;
            width: 100%;
        }

        #plannedActivities thead tr th,
        #plannedActivities tbody tr td {
            width: 10em;
            white-space: nowrap;
            overflow: hidden;
            font-size: 12px;
            border-bottom: 1px solid lightgray;
        }

        #plannedActivities tbody tr td {
            overflow-x: auto;
            max-width: 10em;
        }

        #plannedActivities tbody tr td::-webkit-scrollbar {
            width: 3px;
            height: 0px;
        }

        #plannedActivities tbody tr td::-webkit-scrollbar-track {
            background: none;
        }

        #plannedActivities tbody tr td::-webkit-scrollbar-thumb {
            background: #e94d65;
        }

        #plannedActivities tbody tr td::-webkit-scrollbar-thumb:hover {
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
</style>

<form mehtod="get" action="{{route('activities.planed')}}">
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
            <select name="company_id">
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
<div class="data-container datatable datatable-container">
    <div class="data-table-container datatable-container-header">
        <div class="left-side-header">
            <div class="record">
                <h3>Planned-activities</h3>
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
    @php
        $totalLeadAndMemberIdsArray = $totalLeadAndMemberIds->toArray();
        $totalMemberIdsArray = $totalMemberIds->toArray();
        $myIdArray = $myId->toArray();
    @endphp
    <div class="data-table-container scrollable-table">
        <table id="plannedActivities" class="table table-sm  table-hover table-bordered" style="width: 79vw;">
            <thead>
                <tr class="table-header">
                    <th>Sr#</th>
                    <th>Action</th>
                    <th>Delete</th>
                    <th>Confirm</th>
                    <th>Activity Date</th>
                    <th>Ticket Details</th>
                    <th>Customer</th>
                    <th>Project</th>
                    <th>Project SDM</th>
                    <th>PO Number</th>
                    <th>Location </th>
                    <th>Tech Details </th>
                    <th>Country</th>
                    <th>Tech Rates</th>
                    <th>Tech Service Type</th>
                    <th>Client Rates </th>
                    <th>Client Service Type</th>
                    <th>Uploaded By</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                <tr id="row_{{ $activity->id }}">
                    <td>{{ $loop->iteration }}</td>
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
                        @else()    
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
                        {{--comfirm modal--}}
                        <form  method="post" action="{{route('activity.confirmActivity')}}" id="confirmActivityForm_{{ $activity->id }}">
                            @csrf
                            <div class="modal" id="confirm_activity_modal_{{ $activity->id }}" tabindex="-1"
                                role="dialog">
                                <div class="modal-dialog modal-xl shadow-lg" role="document"
                                    style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                    <div class="modal-content modal-xl shadow-lg" style="border-radius: 10px;">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modelHeading">Confirm Activity</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <input type="hidden" name="activity_id" value="{{$activity->id}}">
                                        <div class="modal-body">
                                            <div class="data">
                                                <div class="datetime-wrapper">
                                                    <div class="date-time">
                                                        <label for="pakistani_time" class="label"
                                                            style="padding-top: 0">Pakistani's Time</label>
                                                        <input type="datetime-local" id="pakistani_time"
                                                            name="pakistani_time" value="{{$activity->pakistani_time}}">
                                                    </div>
                                                    <div class="date-time">
                                                        <label for="default_time" style="padding-top: 0">Activity Start
                                                            Date</label>
                                                        <input type="datetime-local" id="default_time"
                                                            name="default_time" value="{{$activity->default_time}}">
                                                    </div>
                                                </div>

                                                <label for="remark">Remark</label><br>
                                                <textarea name="remark"
                                                    class="remarks"><?php echo $activity->remark;  ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button onclick="confirmThisActivity({{ $activity->id }})" type="button">Confirm</button>
                                            <button type="button" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </td>
                    <td>
                        <button style=" border: #E94D65 !important;  background-color: #E94D65 !important;"
                            data-id="{{ $activity->id }}" class="rounded-circle btn btn-primary btn-sm delete-activity"
                            type="button">
                            <img src="{{asset('Asserts/logo/delete.png')}}" />
                        </button>
                    </td>
                    <td>
                        <button  class="btn btn-sm btn-primaryy conform-table"
                            data-id="{{ $activity->id }}" type="button" onclick="openModal({{ $activity->id }})">
                            <img src="{{asset('Asserts/logo/confirm-btn.png')}}" alt="Confirm" />
                            Confirm
                        </button>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($activity->activity_start_date)->format('d M Y')}}</td>
                    <td>{{ $activity->ticket_detail ?? 'N/A' }}</td>
                    <td>{{ $activity->client->company_name ?? 'N/A' }}</td>
                    <td>{{ $activity->project->project_name ?? 'N/A' }}</td>
                    <td>{{ $activity->project->project_sdm  ?? 'N/A' }}</td>
                    <td>{{$activity->po_number ?? 'N/A'}}</td>
                    <td>{{ $activity->location ?? 'N/A' }}</td>
                    <td>{{ $activity->resource->name ?? 'N/A' }}</td>
                    <td>{{ $activity->country->name ?? 'N/A' }}</td>
                    <td>{{ $activity->tech_rates }}{{$activity->techCurrency->symbol}}</td>
                    <td>{{ $activity->tech_service_type }}</td>
                    <td>{{ $activity->customer_rates }}{{$activity->customerCurrency->symbol  }}</td>
                    <td>{{ $activity->customer_service_type }}</td>
                    <td>{{ $activity->user->user_name ?? 'N/A'}}</td>
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
            var table = $('#plannedActivities').DataTable({
                "searching": true,
                "dom": 'lfrtip',
                "pageLength": 50, 
                "lengthMenu": [ [10, 25, 50, 75, 100], [10, 25, 50, 75, 100] ], 
                "buttons": [],
            });
    });
</script>
<!-- to open edit & print page  -->
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
<!-- to open confirm activity mode  -->
<script>
    function openModal(activityId) {
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
<script>
    function confirmThisActivity(activityId) {
        var formData = new FormData(document.getElementById('confirmActivityForm_' + activityId));
        var errorAlert = document.getElementById('alert-danger');
        var errorList = document.getElementById('error-list');
        var successAlert = document.getElementById('alert-success');
        axios.post('{{ route("activity.confirmActivity") }}', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                var data = response.data;
                if (data.success) {
                    console.log(data);
                        errorAlert.style.display = 'none';
                        successAlert.textContent = data.message;
                        successAlert.style.display = 'block';
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                        var row = document.getElementById('row_' + data.activityId);
                        if (row) {
                            row.parentNode.removeChild(row);
                        }
                        setTimeout(function() {
                            successAlert.style.display = 'none';
                        }, 3000);
                        var modalId = 'confirm_activity_modal_' + data.activityId;
                        var modal = document.getElementById(modalId);
                        if (modal) {
                            modal.style.display = 'none';
                            modal.classList.remove('show');
                        }
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
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
<!-- to delete activity  -->
<script>
    $(document).ready(function() {
        $('.delete-activity').click(function() {
            var activityId = $(this).data('id');
            if (confirm('Are you sure you want to delete this activity?')) {
                $.ajax({
                    url: '/destroyActivity/' + activityId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#row_' + activityId).remove();
                        alert('Activity deleted successfully');
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