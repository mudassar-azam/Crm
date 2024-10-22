<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{asset('style/style.css')}}" />
    <title>Chase It Global</title>
</head>

<style type="text/css" media="print">
    #custom-heading {
        color: black !important;
    }
    .no-print {
        display: none !important;
    }

</style>
<body>
    <div class="customer-detail">
        <header>
            <img src="{{asset('Asserts/General/site-logo.png')}}">
            <div class="heading">
                <h3 id="custom-heading">Activity Detailed Information ({{$activity->created_at->format('d M Y') }})</h3>
                <h5>({{$activity->ticket_detail}})</h5>
            </div>
        </header>

        <table style="padding-top: 1em;">
            <tr>
                <td id="custom-heading" style=" border: none; border-top-left-radius: 5px;">
                    Tech Details
                </td>
                <td style="border: none;"></td>
                <td id="custom-heading" style="border-left: 1px solid lightgray !important; border: none;">
                    Customer Details
                </td>
                <td style="border: none; border-top-right-radius: 5px;"></td>
            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;">
                    Tech Name
                </td>
                <td>
                    {{$activity->resource->name}}
                </td>
                <td>
                    Customer
                </td>
                <td>
                    {{$activity->client->company_name}}
                </td>
            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;;">
                    Contact No
                </td>
                <td>
                    {{$activity->resource->contact_no ?? 'N/A'}}
                </td>
                <td>
                    Contact No
                </td>
                <td>
                    N/A
                </td>
            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;;">
                    Email
                </td>
                <td>
                    {{$activity->resource->email ?? 'N/A'}}
                </td>
                <td>
                    Email
                </td>
                <td>
                    N/A
                </td>

            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;;">
                    Address
                </td>
                <td>
                    {{$activity->resource->address ?? 'N/A'}}
                </td>
                <td>
                    Address
                </td>
                <td>
                    {{$activity->client->company_address ?? 'N/A'}}
                </td>

            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;;">
                    Skill Set
                </td>
                <td>
                    @if($resourceSkills->count() > 0)
                    <ul>
                        @foreach($resourceSkills as $resourceSkill)
                        <li style="list-style: none;padding: 0;"> {{ $resourceSkill->skill_name }}</li>
                        @endforeach
                    </ul>
                    @else
                    <p>No skills for this resource</p>
                    @endif
                </td>
                <td>
                    Vat No
                </td>
                <td>
                    N/A
                </td>

            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;;">
                    Project Done
                </td>
                <td>
                    N/A
                </td>
                <td>

                </td>
                <td>

                </td>

            </tr>
        </table>


        <table>
            <tr>
                <td id="custom-heading" style=" border: none; border-top-left-radius: 5px;">
                    Uploaded By
                </td>
                <td id="custom-heading" style="border-left: 1px solid lightgray !important; border: none;">
                    Uploaded At
                </td>
                <td id="custom-heading" style="border-left: 1px solid lightgray !important; border: none;">
                    Confirmd By
                </td>
                <td id="custom-heading" style="border-left: 1px solid lightgray !important; border: none; border-top-right-radius: 5px;">
                    Confirmed At
                </td>
            </tr>
            <tr>
                <td style="font-size: 10px;;">
                    {{$activity->uploaded_by}}
                </td>
                <td>
                    {{$activity->created_at}}
                </td>
                <td>
                    @if($activity->activity_status == 'pending')
                    N/A
                    @else
                    {{$activity->confirmed_by}}
                    @endif
                </td>
                <td>
                    {{$activity->confirmed_at}}
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td id="custom-heading" style=" border: none; border-top-left-radius: 5px;">
                    Activity Imformation
                </td>
                <td style="border: none;"></td>
                <td style="border: none;">
                </td>
                <td style="border: none; border-top-right-radius: 5px;"></td>
            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;">
                    Email Subject
                </td>
                <td style="border-right: none;">
                    N/A
                </td>
                <td style="border-right: none; border-left: none;">
                </td>
                <td style="border-left: none;">
                </td>
            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;">
                    Projects
                </td>
                <td style="border-right: none;">
                    {{$activity->project->project_name ?? 'N/A'}}
                </td>
                <td style="border-right: none; border-left: none;">
                </td>
                <td style="border-left: none;">
                </td>
            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;">
                    Projects SDM
                </td>
                <td style="border-right: none;">
                    {{$activity->project->project_sdm ?? 'N/A'}}
                </td>
                <td style="border-right: none; border-left: none;">
                </td>
                <td style="border-left: none;">
                </td>
            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;">
                    PO Number
                </td>
                <td style="border-right: none;">
                    {{$activity->po_number ?? 'N/A'}}
                </td>
                <td style="border-right: none; border-left: none;">
                </td>
                <td style="border-left: none;">
                </td>
            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;">
                    Location
                </td>
                <td style="border-right: none;">
                    {{$activity->location ?? 'N/A'}}
                </td>
                <td style="border-right: none; border-left: none;">
                </td>
                <td style="border-left: none;">
                </td>
            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;">
                    Activity Description
                </td>
                <td style="border-right: none;">
                    {{$activity->activity_description ?? 'N/A'}}
                </td>
                <td style="border-right: none; border-left: none;">
                </td>
                <td style="border-left: none;">
                </td>
            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;">
                    Remarks
                </td>
                <td style="border-right: none;">
                    {{$activity->remark ?? 'N/A'}}
                </td>
                <td style="border-right: none; border-left: none;">
                </td>
                <td style="border-left: none;">
                </td>
            </tr>
            <tr>

                <td style="font-weight: 500;font-size: 10px;">
                    Status
                </td>
                <td style="border-right: none;">
                    {{$activity->activity_status ?? 'N/A'}}
                </td>
                <td style="border-right: none; border-left: none;">
                </td>
                <td style="border-left: none;">
                </td>
            </tr>
            <tr>

                <td style="font-weight: 500;font-size: 10px;">
                    Month Of Creation
                </td>
                <td style="border-right: none;">
                    {{$activity->created_at->format('F')}}
                </td>
                <td style="border-right: none; border-left: none;">
                </td>
                <td style="border-left: none;">
                </td>
            </tr>
            <tr>

                <td style="font-weight: 500;font-size: 10px;">
                    Date Of Creation
                </td>
                <td style="border-right: none;">
                    {{$activity->created_at->format('d M Y') }}
                </td>
                <td style="border-right: none; border-left: none;">
                </td>
                <td style="border-left: none;">
                </td>
            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;">
                    Activity Start Data
                </td>
                <td style="border-right: none;">
                    {{$activity->default_time ?? 'N/A'}}
                </td>
                <td style="border-right: none; border-left: none;">
                </td>
                <td style="border-left: none;">
                </td>
            </tr>
            <tr>

                <td style="font-weight: 500;font-size: 10px;">
                    Activity Start Time
                </td>
                <td style="border-right: none;">
                    {{$activity->start_date_time ?? 'N/A'}}
                </td>
                <td style="border-right: none; border-left: none;">
                </td>
                <td style="border-left: none;">
                </td>
            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;">
                    Activity End Time
                </td>
                <td style="border-right: none;">
                    {{$activity->end_date_time ?? 'N/A'}}
                </td>
                <td style="border-right: none; border-left: none;">
                </td>
                <td style="border-left: none;">
                </td>
            </tr>
                <tr>
                <td style="font-weight: 500;font-size: 10px;">
                    Time Difference
                </td>
                <td style="border-right: none;">
                    {{$activity->time_difference ?? 'N/A'}}
                </td>
                <td style="border-right: none; border-left: none;">
                </td>
                <td style="border-left: none;">
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td id="custom-heading" style=" border: none; border-top-left-radius: 5px;">
                    Tech Charges Information
                </td>
                <td style="border: none;"></td>
                <td style="border: none;">

                </td>
                <td style="border: none; border-top-right-radius: 5px;"></td>
            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;">
                    Service Type
                </td>
                <td>
                    {{$activity->tech_service_type ?? 'N/A'}}
                </td>
                <td>
                    Duration(for tech)
                </td>
                <td>
                    {{$activity->duration ?? 'N/A'}}
                </td>
            </tr>

            <tr>
                <td style="font-weight: 500;font-size: 10px;">
                    Rates
                </td>
                <td>
                    @if($activity->tech_rates > 0)
                    {{$activity->tech_rates}}{{$activity->techCurrency->symbol}}
                    @else
                    N/A
                    @endif
                </td>
                <td>
                    Total Tech Payments
                </td>
                <td>
                    @if($activity->total_tech_payments > 0)
                    {{$activity->total_tech_payments}}{{$activity->techCurrency->symbol}}
                    @else
                    N/A
                    @endif
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td id="custom-heading" style=" border: none; border-top-left-radius: 5px;">
                    Customer Charges Information
                </td>
                <td style="border: none;"></td>
                <td style="border: none;">

                </td>
                <td style="border: none; border-top-right-radius: 5px;"></td>
            </tr>
            <tr>
                <td style="font-weight: 500;font-size: 10px;">
                    Service Type
                </td>
                <td>
                    {{$activity->customer_service_type ?? 'N/A'}}
                </td>
                <td>
                    Duration(for customer)
                </td>
                <td>
                    {{$activity->duration_cust ?? 'N/A'}}
                </td>
            </tr>

            <tr>
                <td style="font-weight: 500;font-size: 10px;">
                    Rates
                </td>
                <td>
                    @if($activity->customer_rates > 0)
                    {{$activity->customer_rates}}{{$activity->customerCurrency->symbol}}
                    @else
                    N/A
                    @endif
                </td>
                <td>
                    Total Customer Payments
                </td>
                <td>
                    @if($activity->customer_rates > 0)
                    {{$activity->total_customer_payment}}{{$activity->customerCurrency->symbol}}
                    @else
                    N/A
                    @endif
                </td>
            </tr>


        </table>
        <style>
        .images-div {
            gap: 0.3rem;
            width: 96%;
            border-radius: 8px;
            background-color: #ffffff;
            font-size: 14px;
            font-style: italic;
            font-weight: 400;
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        .images-div.small-height {
            height: 20vh;
        }

        .images-div .action .card1-confirmed img,
        .images-div .action .card2-confirmed img,
        .images-div .action .card3-confirmed img {
            width: 100%;
            height: 90%;
        }

        .print-pdf {
            width: 5em;
            height: 3em;
            background-color: #e94d65;
            border-radius: 7px;
            border: none;
            transition: all 0.3s ease-in-out;
            color: white;
            box-shadow: 0px 0px 10px 0px rgba(77, 77, 77, 0.4);
            position:fixed;
            bottom:10px;
            right:20px;
            
        }

        .print-pdf:hover {
            border:1px solid #e94d65;
            background-color:white;
            color:  #e94d65;
        }
        </style>

        @php
        if (!function_exists('getFileType')) {
        function getFileType($file) {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        return strtolower($extension);
        }
        }
        $emailFileType = getFileType($activity->email_screenshot);
        $signOfSheetFileType = getFileType($activity->sign_of_sheet);
        @endphp
        
        <div class="about">
            <div class="condition">
                <h4>Terms and Condition</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum quibusdam voluptatem saepe
                    reiciendis nesciunt odio molestiae officia delectus repellat esse at vitae exercitationem, quod
                    dolorem illo ipsa voluptatibus doloribus necessitatibus.</p>
            </div>
            <div class="website">
                <img src="{{asset('Asserts/logo/web-site.png')}}">
                <a style="color:black" href="https://crm.chaseitglobal.tech/">https://crm.chaseitglobal.tech/</a>
            </div>
            <div class="gmail">
                <img src="">
            </div>
        </div>
    
        
        <div class="images-div 
            @if($activity->activity_status == 'confirmed' || $activity->activity_status == 'closed' || $activity->activity_status == 'approved') 
                @if($emailFileType == 'pdf' && $signOfSheetFileType == 'pdf') small-height 
                @endif
            @elseif($activity->activity_status == 'pending' && $emailFileType == 'pdf')
                small-height 
            @endif">
        <style>
            .action1 {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                flex-wrap: wrap;
                gap: 20px;
            }

            .action1 img {
                max-width: 100%;
                height: auto;
                display: block;
            }

            @media print {
                .action1 {
                    display: block;
                }

                .card11-confirmed,
                .card22-confirmed,
                .card33-confirmed {
                    text-align: center;
                    page-break-inside: avoid;
                }

                .card11-confirmed img,
                .card22-confirmed img,
                .card33-confirmed img {
                    max-width: 100%;
                    height: auto;
                    page-break-before: always;
                }

                .card11-confirmed a,
                .card22-confirmed a,
                .card33-confirmed a {
                    display: inline-block;
                    page-break-inside: avoid;
                }
            }
            </style>



            <div class="action1">
                @if($activity->activity_status == 'pending')
                <div class="card11-confirmed">
                    <span>Email screenshot</span>
                    @if($emailFileType == 'pdf')
                    <br>
                    <a href="/email sc/{{$activity->email_screenshot}}" target="_blank">View PDF</a>
                    @else
                    <img src="/email sc/{{$activity->email_screenshot}}" />
                    @endif
                </div>
                @elseif($activity->activity_status == 'confirmed' || $activity->activity_status == 'closed' ||
                $activity->activity_status == 'approved')
                <div class="card22-confirmed">
                    <span>Email screenshot</span>
                    @if($emailFileType == 'pdf')
                    <br><a href="/email sc/{{$activity->email_screenshot}}" target="_blank">View PDF</a>
                    @else
                    <img src="/email sc/{{$activity->email_screenshot}}">
                    @endif
                </div>
                <div class="card33-confirmed">
                    <span>Sign of sheet</span>
                    @if($signOfSheetFileType == 'pdf')
                    <br><a href="/sign-of-sheet/{{$activity->sign_of_sheet}}" target="_blank">View PDF</a>
                    @else
                    <img src="/sign-of-sheet/{{$activity->sign_of_sheet}}">
                    @endif
                </div>
                @endif
            </div>
        </div>

        <button class="print-pdf no-print">Print</button>

</body>

@stack('scripts')

<script src="{{asset('js/index.js')}}"></script>
<script>
document.querySelector('.print-pdf').addEventListener('click', function() {
    window.print();
});
</script>

</html>