@extends("layouts.app")
@section('content')
<style>
    #recources {
        table-layout: fixed;
        width: 100%;
    }

    #recources thead tr th,
    #recources tbody tr td {
        width: 10em !important;
        white-space: nowrap;
        overflow: hidden;
        font-size: 12px;
        border: none;
        border-bottom: 1px solid lightgray;
    }

    #recources tbody tr td {
        overflow-x: auto;
        max-width: 10em !important;
    }

    #recources tbody tr td::-webkit-scrollbar {
        width: 0px;
        height: 0px;
    }

    #recources tbody tr td::-webkit-scrollbar-track {
        background: none;
    }

    #recources tbody tr td::-webkit-scrollbar-thumb {
        background: #e94d65;
    }

    #recources tbody tr td::-webkit-scrollbar-thumb:hover {
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
    }
</style>
<form method="get" action="{{route('clientPayableInvoices')}}">
    <div class="approved-activities">
        <div id="alert-danger" class="alert alert-danger" style="display: none;">
            <ul id="error-list"></ul>
        </div>
        <div id="alert-success" class="alert alert-success" style="display: none;"></div>
        <div class="select status">
            <h5>From Date</h5>
            <input type="date" name="from_date">
        </div>
        <div class="select work">
            <h5>To Date</h5>
            <input type="date" name="to_date">
        </div>
        <div class="select BGV">
            <h5>Customer Name</h5>
            <select name="id">
                <option value="">ALL</option>
                @foreach($customers as $customer)
                <option value="{{$customer->id}}">{{$customer->company_name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-btns">
        <p></p>
        <button class="request-btn">
            Filter Request
        </button>
    </div>
</form>

<div class="datatable-container">
    <div class="datatable-container-header">
        <div class="left-side-header">
            <div class="record">
                <h3>Customer Receivable Invoices</h3>
            </div>
        </div>
        <div class="right-side-header">
            <button style="background-color: #206d88;">
                <img src="{{asset('Asserts/logo/completed.png')}}">
                Export CSV
            </button>
        </div>
    </div>

    <div class="data-table-container scrollable-table">
        <table id="recources" class="table table-sm  table-hover table-bordered" style="width: 79vw;">
            <thead>
                <tr class="table-header">
                    <th>Sre</th>
                    <th>Print</th>
                    <th>Invoice No</th>
                    <th>Customer Name</th>
                    <th>Invoice Date</th>
                    <th>Customer Amount</th>
                    <th>Total Activities</th>
                    <th>Status</th>
                    <th>Pay</th>
                    <th>Generated At</th>
                    <th>Generated By</th>
                    <th>Activity Details</th>
                    <th>Delete</th>

                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                @if($client->invoices->count() > 0)
                @php
                $latestInvoice = $client->invoices->sortByDesc('created_at')->first();
                $totalCustomerRates = $client->invoices->sum(function($invoice) {
                return $invoice->activity->total_customer_payments;
                });
                @endphp
                <tr id="row_{{ $latestInvoice->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td class="space-between" style="border:none">
                        <button class="rounded-circle btn btn-danger btn-sm delete-btn delete-table"
                            onclick="openPrintPage({{ $latestInvoice->id }})" type="button">
                            <img src="{{asset('Asserts/logo/export-pdf.png')}}" />
                        </button>
                    </td>
                    <td>{{$latestInvoice->invoice_no}}</td>
                    <td>{{$latestInvoice->client->company_name}}</td>
                    <td>{{$latestInvoice->created_at->format('d M Y')}}</td>
                    <td>{{$totalCustomerRates}}{{$latestInvoice->currency->symbol}}</td>
                    <td>{{$client->activities->where('customer_invoice', true)->count()}}</td>
                    <td>{{$latestInvoice->status}}</td>
                    <td>
                        <button class="btn btn-sm btn-primaryy conform-table"
                            onclick="openConfirmationModal({{ $latestInvoice->id }})" type="button">
                            Confirm
                        </button>
                        <form id="confirmationform_{{ $latestInvoice->id }}"
                            action="{{route('customerPaymentConfirmation' , $latestInvoice->id)}}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal setting" id="confirmation_modal_{{ $latestInvoice->id }}" tabindex="-1"
                                role="dialog">
                                <div class="modal-dialog modal-xl shadow-lg" role="document"
                                    style="background-color: rgba(0, 0, 0, 0.03) !important; margin: 0 !important; max-width: 100%;">
                                    <div class="modal-content modal-xl shadow-lg model-center" style="max-width: 80% !important;">
                                        <div class="form-wrapper"> </div>
                                        <input type="hidden" name="client_id" value="{{$client->id}}">
                                        <div class="form"
                                            style="width: 65%; top: 5em; right: 5em; padding-bottom: 1em;">
                                            <div class="form-header">
                                                <div class="heading">
                                                    <h4>Confirm Customer Payment</h4>
                                                </div>
                                            </div>
                                            <div class="data" style="padding: 0;">
                                                <div class="datetime-wrapper">
                                                    <div class="date-time">
                                                        <label for="paid_time">Paid Time</label>
                                                        <input style="margin-bottom: 3%;" type="date"
                                                            value="{{old('paid_time')}}" name="paid_time" class="input">
                                                    </div>
                                                    <div class="date-time">
                                                        <label for="payment_status" style="margin-top: -13px;">Select
                                                            Payment Status</label>
                                                        <select name="payment_status" id="payment_status"
                                                            style="width: 100%; border: 1px solid lightgray;font-size: 13px;
                                                                        height: 2em; margin-bottom: 3%;border-radius: 5px;font-style: italic;font-weight: 400;">
                                                            <option selected disabled>Select</option>
                                                            <option value="confirm">confirm</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button"
                                                    onclick="addConformation({{ $latestInvoice->id }})">Confirm</button>
                                                <button type="button" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </td>
                    <td>{{$latestInvoice->created_at->format('d M Y h:i A')}}</td>
                    <td>{{$latestInvoice->user->user_name ?? 'N/A'}}</td>
                    <td>
                        <button class="btn btn-sm btn-primaryy conform-table btn-activities" type="button"
                            onclick="openActivityModal({{ $client->id }})">
                            Activities
                        </button>
                    </td>
                    <div class="modal" id="client_activities_modal_{{ $client->id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl shadow-lg" role="document"
                            style="background-color: rgba(0, 0, 0, 0.03) !important;">
                            <div class="modal-content modal-xl shadow-lg" style="border-radius: 10px;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modelHeading">Activity Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="data"
                                        style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px;">
                                        <!-- Headings -->
                                        <div class="heading font-weight-bold">Service Type</div>
                                        <div class="heading font-weight-bold">Date </div>
                                        <div class="heading font-weight-bold">Customer Duration</div>
                                        <div class="heading font-weight-bold">Customer Rate</div>
                                        <div class="heading font-weight-bold">Total Customer Payment</div>
                                        <div class="heading font-weight-bold">Ticket Detail</div>


                                        @foreach($client->activities->where('customer_invoice', true)->sortBy('activity_start_date') as $activity)
                                        <div class="cell">{{$activity->customer_service_type}}</div>
                                        <div class="cell">
                                            {{\Carbon\Carbon::parse($activity->activity_start_date)->format('d M Y')}}
                                        </div>
                                        <div class="cell">{{$activity->duration_cust}}</div>
                                        <div class="cell">{{$activity->customer_rates}}</div>
                                        <div class="cell">{{$activity->total_customer_payments}}</div>
                                        <div class="cell">{{$activity->ticket_detail}}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <td>
                        <button style=" border: #E94D65 !important;  background-color: #E94D65 !important;"
                            data-id="{{ $latestInvoice->id }}"
                            class="rounded-circle btn btn-primary btn-sm delete-customer-invoice" type="button">
                            <img src="{{asset('Asserts/logo/delete.png')}}" />
                        </button>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<!-- to make table datatable  -->
<script>
    $(document).ready(function() {
        var table = $('#recources').DataTable({
            "searching": true,
            "dom": 'lfrtip',
            "buttons": [],
        });
    });
</script>
<!-- to open print page  -->
<script>
    function openPrintPage(id) {
        let url = "{{ route('customerUnPaidInvoice', ':id') }}";
        url = url.replace(':id', id);
        window.location.href = url;
    }
</script>
<!-- for deletion  -->
<script>
    $(document).ready(function() {
        $('.delete-customer-invoice').click(function() {
            var invoiceId = $(this).data('id');
            if (confirm('Are you sure you want to delete this invoice?')) {
                $.ajax({
                    url: '/deleteCustomerInvoice/' + invoiceId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#row_' + invoiceId).remove();
                        alert('Invoice deleted  successfully');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
<!-- to open activity model  -->
<script>
    function openActivityModal(clientId) {
        var modalId = "client_activities_modal_" + clientId;
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
<!-- for opening confirmation model  -->
<script>
    function openConfirmationModal(clientId) {
        var modalId = "confirmation_modal_" + clientId;
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
<!-- for adding confirmation  -->
<script>
    function addConformation(invoiceId) {
        var formData = new FormData(document.getElementById('confirmationform_' + invoiceId));
        axios.post('{{ route("customerPaymentConfirmation", ["id" => ":invoiceId"]) }}'.replace(':invoiceId', invoiceId),
                formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
            .then(function(response) {
                var data = response.data;
                showSuccessAlert('Confirmed successfully!');
                var modalId = 'confirmation_modal_' + data.invoiceId;
                var modal = document.getElementById(modalId);
                if (modal) {
                    modal.style.display = 'none';
                    modal.classList.remove('show');
                }
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                var row = document.getElementById('row_' + data.invoiceId);
                if (row) {
                    row.parentNode.removeChild(row);
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
@endpush