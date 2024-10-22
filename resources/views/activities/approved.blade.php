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
<form mehtod="get" action="{{route('activities.approved')}}">
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
@php
    $totalLeadAndMemberIdsArray = $totalLeadAndMemberIds->toArray();
@endphp
<div class="data-container datatable datatable-container" style="overflow-x: scroll;">
    <div class="data-table-container datatable-container-header">
        <div class="left-side-header">
            <div class="record">
                <h3>Approved-activities</h3>
                <p>Resources that are available</p>
            </div>
        </div>
    </div>
    <div class="data-table-container scrollable-table">
        <table id="approvedActivities" class="table table-sm  table-hover table-bordered" style="width: 88vw;">
            <thead>
                <tr class="table-header">
                    <td>Sr#</td>
                    <th>Action</th>
                    @if(AdminOrAccountRole())
                        <th>Generate Invoices</th>
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
                    <td class="space-between" style="border:none">

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
                        @endif 

                            <button class="rounded-circle btn btn-danger btn-sm delete-table"
                            onclick="openPrintPage({{ $activity->id }})" type="button">
                            <img src="{{asset('Asserts/logo/export-pdf.png')}}" />
                        </button>
                    </td>
                    @if(AdminOrAccountRole())
                        <td>
                            @if($activity->tech_invoice == NULL && $activity->customer_invoice == NULL)
                                <button data-id="{{ $activity->id }}" type="button"
                                    class="btn btn-sm generate-tech-invoice btn-primaryy conform-table" style="margin-bottom: 1px;">
                                    Generate Tech Invoice
                                </button>
                                <br>
                                <button id="confirm_activity_{{ $activity->id }}" class="btn btn-sm btn-primaryy conform-table"
                                    data-id="{{ $activity->id }}" type="button" onclick="selectAccount({{ $activity->id }})">
                                    Generate Client Invoice
                                </button>
                                @elseif($activity->tech_invoice != NULL && $activity->customer_invoice == NULL)
                                <button id="confirm_activity_{{ $activity->id }}" class="btn btn-sm btn-primaryy conform-table"
                                    data-id="{{ $activity->id }}" type="button" onclick="selectAccount({{ $activity->id }})">
                                    Generate Client Invoice
                                </button>
                                @elseif($activity->tech_invoice == NULL && $activity->customer_invoice != NULL)
                                <button data-id="{{ $activity->id }}" type="button"
                                    class="btn btn-sm generate-tech-invoice btn-primaryy conform-table">
                                    Generate Tech Invoice
                                </button>
                                @else
                                <button type="button" class="btn btn-sm  btn-primaryy conform-table">
                                    Already Generated
                                </button>
                            @endif  
                            <form id="accountform_{{ $activity->id }}"
                                action="{{route('customer.invoice.add.account')}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal setting" id="account_modal_{{ $activity->id }}" tabindex="-1"
                                    role="dialog">
                                    <div class="modal-dialog modal-xl shadow-lg" role="document"
                                        style="background-color: rgba(0, 0, 0, 0.03) !important; margin: 0 !important; max-width: 100%;">
                                        <div class="modal-content modal-xl shadow-lg model-center" style="width: 84% !important;">
                                            <div class="form-wrapper"> </div>
                                            <input type="hidden" name="activity_id" value="{{$activity->id}}">
                                            <div class="form"
                                                style="width: 65%; top: 5em; right: 5em; padding-bottom: 1em;">
                                                <div class="form-header">
                                                    <div class="heading">
                                                        <h4>Select Account</h4>
                                                    </div>
                                                </div>
                                                <div class="data" style="padding: 0;">
                                                    <div class="datetime-wrapper">
                                                        <div class="date-time">
                                                            <label for="account" style="margin-top: -13px;">Select
                                                                Account</label>
                                                            <select name="account" id="account"
                                                                style="width: 200%; border: 1px solid lightgray;font-size: 13px;
                                                                height: 2em; margin-bottom: 3%;border-radius: 5px; font-size: 10px;
                                                                font-style: italic;font-weight: 400;">
                                                                <option selected disabled>Select Account</option>
                                                                <option value="usd">USD Bank</option>
                                                                <option value="euro">EURO Bank</option>
                                                                <option value="gbp">GBP Bank</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                        onclick="addAccount({{ $activity->id }})">Add</button>
                                                    <button type="button" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
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
<!-- for selectiong account model  -->
<script>
    function selectAccount(activityId) {
        var modalId = "account_modal_" + activityId;
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
<!-- for adding account  -->
<script>
    function addAccount(activityId) {
        var formData = new FormData(document.getElementById('accountform_' + activityId));
        axios.post('{{ route("customer.invoice.add.account") }}',
                formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
            .then(function(response) {
                var data = response.data;
                showSuccessAlert('Account added successfully!');
                var modalId = 'account_modal_' + data.activityId;
                var modal = document.getElementById(modalId);
                if (modal) {
                    modal.style.display = 'none';
                    modal.classList.remove('show');
                }
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                var button = document.getElementById('confirm_activity_' + data.activityId);
                if (button) {
                    button.disabled = true;
                }
                if (data.tech_invoice === 'true' && data.customer_invoice === 'true') {
                    var row = document.getElementById('row_' + data.activityId);
                    if (row) {
                        row.parentNode.removeChild(row);
                    } else {
                        console.warn('Row with id row_' + data.activityId + ' not found.');
                    }
                }
            })
            .catch(function(error) {
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
<!-- to open edit page  -->
<script>
    function openEditPage(id) {
        window.location.href = `/activity/edit/${id}`;
    }
</script>
<!-- for print view  -->
<script>
    function openPrintPage(id) {
        window.location.href = `/activity-print/${id}`;
    }
</script>
<!-- for generating tech invoice  -->
<script>
    $(document).ready(function() {
        $('.generate-tech-invoice').click(function() {
            var activityId = $(this).data('id');
            var button = $(this);
            if (confirm('Are you sure you want to generate invoice?')) {
                $.ajax({
                    url: '/accounts/generatTechInvoice/' + activityId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('Invoice genrated  successfully');
                        if (response.tech_invoice === 'true' && response.customer_invoice === 'true') {
                            $('#row_' + activityId).remove();
                        }
                        button.prop('disabled', true);
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON && xhr.responseJSON.error === 'Invoice already exists !') {
                            alert('Invoice already exists');
                        } else {
                            alert('An error occurred while generating the invoice');
                        }
                    }
                });
            }
        });
    });
</script>
@endpush