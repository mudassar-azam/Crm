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
        width: 5px;
        height: 3px;
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
<form method="get" action="{{route('techPayableInvoices')}}">
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
            <h5>Tech Name</h5>
            <select name="id">
                <option value="">ALL</option>
                @foreach($techs as $tech)
                <option value="{{$tech->id}}">{{$tech->name}}</option>
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
<div class="datatable-container">
    <div class="datatable-container-header">
        <div class="left-side-header">
            <div class="record">
                <h3>Tech Payable Invoices</h3>
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
                    <th>Sr#</th>
                    <th>Print</th>
                    <th>Invoice No</th>
                    <th>Tech Name</th>
                    <th>Invoice Date</th>
                    <th>Tech Amount</th>
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

                @foreach($resources as $resource)
                @if($resource->invoices->count() > 0)
                @php
                $latestInvoice = $resource->invoices->sortByDesc('created_at')->first();
                $totalTechRates = $resource->invoices->sum(function($invoice) {
                return $invoice->activity->total_tech_payments;
                });
                @endphp
                <tr id="row_{{ $latestInvoice->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td class="space-between" style="border:none;">

                        <button class="rounded-circle btn btn-danger btn-sm delete-btn delete-table"
                            onclick="openPrintPage({{ $latestInvoice->id }})" type="button">
                            <img src="{{asset('Asserts/logo/export-pdf.png')}}" />
                        </button>
                    </td>
                    <td>{{ $latestInvoice->invoice_no }}</td>
                    <td>{{ $resource->name }}</td>
                    <td>{{ $latestInvoice->created_at->format('d M Y') }}</td>
                    <td>{{ $totalTechRates }}{{ $latestInvoice->currency->symbol }}</td>
                    <td>{{ $resource->activities->where('tech_invoice', true)->where('tech_invoice_payment_status' , null)->count() }}</td>
                    <td>{{ $latestInvoice->status }}</td>
                    <td>
                        <button class="btn btn-sm btn-primaryy conform-table" data-id="{{ $latestInvoice->id }}"
                            type="button" onclick="openPaymentModal({{ $latestInvoice->id }})">
                            Pay Now
                        </button>
                        <form id="paymentform_{{ $latestInvoice->id }}"
                            action="{{route('techActivityPayment' , $latestInvoice->id)}}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal setting" id="payment_modal_{{ $latestInvoice->id }}" tabindex="-1"
                                role="dialog">
                                <div class="modal-dialog modal-xl shadow-lg" role="document"
                                    style="background-color: rgba(0, 0, 0, 0.03) !important; margin: 0 !important; max-width: 100%;">
                                    <div class="model-center modal-content modal-xl shadow-lg" style="width:80%; border-radius: 10px; border: none;">
                                        <div class="form-wrapper"> </div>
                                        <input type="hidden" name="resource_id" value="{{$resource->id}}">
                                        <div class="form"
                                            style="width: 65%; top: 5em; right: 5em; padding-bottom: 1em;">
                                            <div class="form-header">
                                                <div class="heading">
                                                    <h4>Proceed Tech Payment</h4>
                                                    <p>Pay Now</p>
                                                </div>
                                            </div>
                                            <div class="data" style="padding: 0;">
                                                <div class="datetime-wrapper">

                                                    <div class="date-time">
                                                        <label for="paid_time">Paid Time</label>
                                                        <input type="date" value="{{old('paid_time')}}" name="paid_time"
                                                            class="input">
                                                    </div>
                                                    <div class="date-time">
                                                        <label for="remarks">Remarks</label>
                                                        <input type="text" name="remarks">
                                                    </div>
                                                </div>
                                                <div class="datetime-wrapper">
                                                    <div class="date-time" style="width: 100%;">
                                                        <label for="payment_proof" style="margin-top: -13px;">Payment
                                                            Proof</label>
                                                        <input type="file" name="payment_proof">

                                                    </div>
                                                </div>
                                                <div class="datetime-wrapper">

                                                    <div class="date-time">
                                                        <label for="account" style="margin-top: -13px;">Select
                                                            Account</label>
                                                        <select name="account" id="account"
                                                            style="width: 100%; border: 1px solid lightgray;font-size: 13px;
                                                                    height: 2em; margin-bottom: 3%;border-radius: 5px;font-style: italic;font-weight: 400;">
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
                                                    onclick="addPayment({{ $latestInvoice->id }})">Confirm</button>
                                                <button type="button" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </td>
                    <td>{{ $latestInvoice->created_at->format('d M Y h:i A') }}</td>
                    <td>{{$latestInvoice->user->user_name ?? 'N/A'}}</td>
                    <td>
                        <button id="resource_activities_modal_{{ $resource->id }}"
                            class="btn btn-sm btn-primaryy conform-table btn-activities" type="button"
                            data-id="{{ $resource->id }}" onclick="openModal({{ $resource->id }})">
                            Activities
                        </button>
                    </td>
                    <div class="modal" id="resource_activities_modal_{{ $resource->id }}" tabindex="-1" role="dialog">
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
                                        style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 10px;">
                                        <!-- Headings -->
                                        <div class="heading font-weight-bold">Service Type</div>
                                        <div class="heading font-weight-bold">Date </div>
                                        <div class="heading font-weight-bold">Tech Duration</div>
                                        <div class="heading font-weight-bold">Tech Rates</div>
                                        <div class="heading font-weight-bold">Total Tech Payment</div>
                                        <div class="heading font-weight-bold">Customer</div>
                                        <div class="heading font-weight-bold">Ticket Detail</div>


                                        @foreach($resource->activities->where('tech_invoice', true)->where('tech_invoice_payment_status' , null)->sortBy('activity_start_date') as $activity)
                                            <div class="cell">{{$activity->tech_service_type}}</div>
                                            <div class="cell">
                                                {{\Carbon\Carbon::parse($activity->activity_start_date)->format('d M Y')}}
                                            </div>
                                            <div class="cell">{{$activity->duration}}</div>
                                            <div class="cell">{{$activity->tech_rates}}</div>
                                            <div class="cell">{{$activity->total_tech_payments}}</div>
                                            <div class="cell">{{$activity->client->company_name ?? 'N/A'}}</div>
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
                            class="rounded-circle btn btn-primary btn-sm delete-tech-invoice" type="button">
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
<!-- open print page  -->
<script>
    function openPrintPage(id) {
        let url = "{{ route('techUnPaidInvoice', ':id') }}";
        url = url.replace(':id', id);
        window.location.href = url;
    }
</script>
<!-- for activity details  -->
<script>
    function openModal(resourceId) {
        var modalId = "resource_activities_modal_" + resourceId;
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
<!-- for deletion  -->
<script>
    $(document).ready(function() {
        $('.delete-tech-invoice').click(function() {
            var invoiceId = $(this).data('id');
            if (confirm('Are you sure you want to delete this invoice?')) {
                $.ajax({
                    url: '/deleteTechInvoice/' + invoiceId,
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
<!-- for payment model  -->
<script>
    function openPaymentModal(invoiceId) {
        var modalId = "payment_modal_" + invoiceId;
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
<!-- for adding payment  -->
<script>
    function addPayment(invoiceId) {
        var formData = new FormData(document.getElementById('paymentform_' + invoiceId));
        axios.post('{{ route("techActivityPayment", ["id" => ":invoiceId"]) }}'.replace(':invoiceId', invoiceId),
                formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
            .then(function(response) {
                var data = response.data;
                showSuccessAlert('Payment added successfully!');
                var modalId = 'payment_modal_' + data.invoiceId;
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