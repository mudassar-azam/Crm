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
                    {{$baseInvoice->resource->name ?? 'N/A'}}
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
                        <tr>
                            <td style="color: #ffffff;">f</td>
                            <td></td>
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
                                {{$baseInvoice->resource->name ?? 'N/A'}}
                            </td>
                        </tr>
                        <tr style="text-align: center;">
                            <td id="custom-heading" style="color: rgba(0, 0, 0, 0.5);">
                                {{$baseInvoice->resource->address ?? 'N/A'}}
                            </td>
                        </tr>
                        <tr style="text-align: center;">
                            <td id="custom-heading" style="color: rgba(0, 0, 0, 0.5);">
                                N/A
                            </td>
                        </tr>
                        <tr style="text-align: center;">
                            <td id="custom-heading" style="color: rgba(0, 0, 0, 0.5);">
                                {{$baseInvoice->resource->email ?? 'N/A'}}
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
                    Tech Rates
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
                    {{$invoice->activity->ticket_detail ?? 'N/A'}}
                </td>
                <td id="custom-heading">
                    {{$invoice->activity->location ?? 'N/A'}}
                </td>
                <td id="custom-heading" class="remove">
                    {{$invoice->activity->tech_service_type}}
                </td>
                <td id="custom-heading" class="remove">
                    {{$invoice->activity->tech_rates}}{{$invoice->activity->techCurrency->symbol}}
                </td>
                <td id="custom-heading" class="remove">
                    {{$invoice->activity->duration ?? 'N/A'}}
                </td>
                <td id="custom-heading" class="remove">
                    {{round($invoice->activity->total_tech_payments)}}
                </td>
            </tr>
            @php
                $total = $total + $invoice->activity->total_tech_payments;
            @endphp
            @endforeach
        </table>
        <table class="responsive">
            <tr>
                <td id="custom-heading" style="width: 20.4%;">
                    Service type
                </td>
                <td id="custom-heading">
                    Tech Rates
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
                    {{$invoice->activity->tech_service_type ?? 'N/A'}}
                </td>
                <td id="custom-heading">
                    {{$invoice->activity->tech_rates}}{{$invoice->activity->techCurrency->symbol}}
                </td>
                <td id="custom-heading">
                    {{$invoice->activity->duration ?? 'N/A'}}
                </td>
                <td id="custom-heading">
                    {{round($invoice->activity->total_tech_payments)}}
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
                            {{$baseInvoice->resource->paymentDetails->bank_name ?? 'N/A'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            BSB(AUS ONLY)
                        </td>
                        <td>
                            N/A
                        </td>
                    </tr>
                    <tr>
                        <td>
                            ADN
                        </td>
                        <td>
                            N/A
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Bank City Name
                        </td>
                        <td>
                            {{$baseInvoice->resource->paymentDetails->bank_city_name ?? 'N/A'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Bank Address
                        </td>
                        <td>
                            {{$baseInvoice->resource->paymentDetails->bank_address ?? 'N/A'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Account Holder Name
                        </td>
                        <td>
                            {{$baseInvoice->resource->paymentDetails->account_holder_name ?? 'N/A'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Account Number
                        </td>
                        <td>
                            {{$baseInvoice->resource->paymentDetails->account_number ?? 'N/A'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            IBAN
                        </td>
                        <td>
                            {{$baseInvoice->resource->paymentDetails->IBAN ?? 'N/A'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            BIC/Swift Code
                        </td>
                        <td>
                            {{$baseInvoice->resource->paymentDetails->BIC_or_Swift_code ?? 'N/A'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Set Code (UK ONLY)
                        </td>
                        <td>
                            {{$baseInvoice->resource->paymentDetails->sort_code ?? 'N/A'}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Country
                        </td>
                        <td>
                            {{$baseInvoice->resource->paymentDetails->country ?? 'N/A'}}
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid lightgray;">
                            Transferwise ID
                        </td>
                        <td style="border-bottom: 1px solid lightgray;">
                            {{$baseInvoice->resource->paymentDetails->transferwise_id ?? 'N/A'}}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="stemp">
                <img src="{{{asset('Asserts/General/stemp.png')}}}">
            </div>
        </div>
        <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;margin-top:1em;width:100%;">
            <div>
                <h2>Payment Proof</h2>
            </div>
            <div>
            @php
                $fileExtension = pathinfo($baseInvoice->payment_proof, PATHINFO_EXTENSION);
            @endphp

            @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                <img src="/pdfs/{{$baseInvoice->payment_proof}}" alt="Payment Proof" style="max-width: 100%;">
            @else
                <div style="width:100%;display:flex;align-items:center;jutify-content:center;">
                    <iframe src="/pdfs/{{$baseInvoice->payment_proof}}" style="width: 55em; height: 800px;" frameborder="0">
                        Your browser does not support iframes.
                    </iframe>
                </div>
            @endif
            </div>
        </div>
        <h4>Thank You For Your Support!</h4>
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