<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{asset('style/style.css')}}" />
    <title>Chase It Global</title>
    <style type="text/css" media="print">
        .no-print {
            display: none !important;
        }

        #custom-heading {
            color: black !important;
        }
    </style>
    <style>
        .print-pdf {
            width: 5em;
            height: 3em;
            background-color: #e94d65;
            border-radius: 7px;
            border: none;
            transition: all 0.3s ease-in-out;
            color: white;
            box-shadow: 0px 0px 10px 0px rgba(77, 77, 77, 0.4);
            position: fixed;
            bottom: 10px;
            right: 20px;

        }

        .print-pdf:hover {
            border: 1px solid #e94d65;
            background-color: white;
            color: #e94d65;
        }
    </style>
</head>

<body>
    @php
    $total = 0;
    @endphp
    <div class="invoice-container">
        <table>
            <!-- header -->
            <tr>
                <td style="width:20%;padding-left: 1em;">
                    <img src="{{asset('Asserts/General/site-logo.png')}}">
                </td>
                <td class="profile-name">
                    {{$baseInvoice->client->company_name}}
                </td>
                <td id="custom-heading" style="background-color: #e94d65;
            text-align: center; color: white;">
                    Invoice
                </td>
            </tr>
            <!-- header end -->

            <tr>
                <td style="width:20%; border-top: none;">
                    <table>
                        <tr>
                            <td>Address:</td>
                            <td id="custom-heading" style="border-right: none;"> 605 B Leytonstone High Road, London, England, London , E11 4PA
                            </td>
                        </tr>
                        <tr>
                            <td>Phone:</td>
                            <td id="custom-heading" style="border-right: none;"> +44 7411 044799
                            </td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td id="custom-heading" style="border-right: none;">accounts@chaseitglobal.com</td>
                        </tr>
                    </table>
                </td>
                <td style="border:none; border-bottom: 1px solid lightgray;">
                </td>
                <td>
                    <table>
                        <tr>
                            <td>Date:</td>
                            <td id="custom-heading">{{ \Carbon\Carbon::now()->format('d M Y') }}</td>
                        </tr>
                        <tr style="border: none;">
                            <td>Invoice:</td>
                            <td id="custom-heading">{{$baseInvoice->invoice_no}}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr style="background-color: #e94d65; height: 0.5em;">
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
            </tr>

            <tr>
                <td>
                    <table>
                        <tr style="text-align: left;">
                            <td>
                                Bill To:
                            </td>
                        </tr>
                        <tr style="text-align: center;">
                            <td id="custom-heading" style="color: rgba(0, 0, 0, 0.5);">
                                {{$baseInvoice->client->company_name}}
                            </td>
                        </tr>
                        <tr style="text-align: center;">
                            <td id="custom-heading" style="color: rgba(0, 0, 0, 0.5);">
                                {{$baseInvoice->client->company_address}}
                            </td>
                        </tr>
                        <tr style="text-align: center;">
                            <td id="custom-heading" style="color: rgba(0, 0, 0, 0.5);">
                                N/A
                            </td>
                        </tr>
                        <tr style="text-align: center;">
                            <td id="custom-heading" style="color: rgba(0, 0, 0, 0.5);">
                                N/A
                            </td>
                        </tr>

                    </table>
                </td>
                <td style="border: none; border-bottom: 1px solid lightgray;"></td>
                <td style="border: none; border-bottom: 1px solid lightgray;"></td>
            </tr>
        </table>

        <table class="genral-info">
            <tr>
                <td id="custom-heading">
                    Data
                </td>
                <td id="custom-heading">
                    Ticket#
                </td>
                <td id="custom-heading">
                    Location
                </td>
                <td id="custom-heading" class="remove">
                    Service type
                </td>
                <td id="custom-heading" class="remove">
                    Rates
                </td>
                <td id="custom-heading" class="remove">
                    Duration
                </td>
                <td id="custom-heading" style="border-right: none;" class="remove">
                    Amount
                </td>
            </tr>
            @foreach($invoices->filter(function($invoice) {
                return $invoice->activity->activity_status === 'approved';
            })->sortBy('activity.activity_start_date') as $invoice)
            <tr>
                <td id="custom-heading">
                    {{ \Carbon\Carbon::parse($invoice->activity->activity_start_date)->format('d M Y') }}
                </td>
                <td id="custom-heading">
                    {{$invoice->activity->ticket_detail}}
                </td>
                <td id="custom-heading">
                    {{$invoice->activity->location}}
                </td>
                <td id="custom-heading" class="remove">
                    {{$invoice->activity->tech_service_type}}
                </td>
                <td id="custom-heading" class="remove">
                    {{$invoice->activity->customer_rates}}
                </td>
                <td id="custom-heading" class="remove">
                    {{$invoice->activity->duration}}
                </td>
                <td id="custom-heading" class="remove">
                    {{$invoice->activity->total_customer_payments}}
                </td>
            </tr>
            @php
                $total = $total + $invoice->activity->total_customer_payments;
            @endphp
            @endforeach
        </table>
        <table class="responsive">
            <tr>
                <td id="custom-heading" style="width: 20.4%;">
                    Service type
                </td>
                <td id="custom-heading">
                    Rates
                </td>
                <td id="custom-heading">
                    Duration
                </td>
                <td id="custom-heading" style="border-right: none;">
                    Amount
                </td>
            </tr>
            @foreach($invoices->filter(function($invoice) {
                return $invoice->activity->activity_status === 'approved';
            }) as $invoice)
            <tr>
                <td id="custom-heading">
                    {{$invoice->activity->tech_service_type}}
                </td>
                <td id="custom-heading">
                    {{$invoice->activity->customer_rates}}
                </td>
                <td id="custom-heading">
                    {{$invoice->activity->duration_cust}}
                </td>
                <td id="custom-heading">
                    {{$invoice->activity->total_customer_payments}}
                </td>
            </tr>
            @endforeach
        </table>
        <br>
        <div class="total-amount">
            <button id="custom-heading">
                Total
            </button>
            <div class="amount">
                {{$total}}
            </div>
        </div>
        <div class="conformation">
            <div class="bank-detail">
                <table>
                    <tr>
                        <td id="custom-heading" colspan="2">
                            Bank Detail for Payment
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Bank Name
                        </td>
                        <td>
                            {{$baseInvoice->bank_name ?? 'N/A'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            ACH/Wire routing
                        </td>
                        <td>
                            {{$baseInvoice->ach_wire_routing ?? 'N/A'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            SWIFT/BIC
                        </td>
                        <td>
                            {{$baseInvoice->swift_bnic ?? 'N/A'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Account Holder
                        </td>
                        <td>
                            {{$baseInvoice->account_holder ?? 'N/A'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Account Number
                        </td>
                        <td>
                            {{$baseInvoice->account_number ?? 'N/A'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            IBAN
                        </td>
                        <td>
                            {{$baseInvoice->iban ?? 'N/A'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Address Associted
                        </td>
                        <td>
                            {{$baseInvoice->address_associated ?? 'N/A'}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <button class="print-pdf no-print">Print</button>
    </div>
</body>

<script src="{{asset('js/index.js')}}"></script>
<script>
document.querySelector('.print-pdf').addEventListener('click', function() {
    window.print();
});
</script>

</html>