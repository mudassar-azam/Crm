@extends('layouts.app3')

@section('content')
    <style>
        #Activities {
            table-layout: fixed;
            width: 100%;

        }
        .data-table-container{
            border-radius: 0;    
        }

        #Activities thead tr th,
        #Activities tbody tr td {
            width: 15em !important;
            white-space: nowrap;
            overflow: hidden;
            font-size: 12px;
            border: none;
            border-bottom: 1px solid lightgray;
        }

        #Activities tbody tr td {
            overflow-x: auto;
            max-width: 10em !important;
        }

        #Activities tbody tr td::-webkit-scrollbar {
            width: 5px;
            height: 3px;
        }

        #Activities tbody tr td::-webkit-scrollbar-track {
            background: none;
        }

        #Activities tbody tr td::-webkit-scrollbar-thumb {
            background: #e94d65;
        }

        #Activities tbody tr td::-webkit-scrollbar-thumb:hover {
            background: #2d6d8b;
            width: 7px;
        }
        
        .table-header {
            background-color: #206D88;
            color: white;
            font-weight: 600;
            font-size: 13px;
        }
    </style>
    <div class="related-activities">

        @if ($relatedActivities->isNotEmpty())
            @php
                $statusCounts = [
                    'pending' => 0,
                    'confirmed' => 0,
                    'approved' => 0,
                    'closed' => 0,
                ];
            @endphp

            @foreach ($relatedActivities as $activity)
                @php
                    if (array_key_exists($activity->activity_status, $statusCounts)) {
                        $statusCounts[$activity->activity_status]++;
                    }
                @endphp
            @endforeach

            @php
                $confirmed_percentage = $relatedActivities->count() > 0 ? ($statusCounts['confirmed'] / $relatedActivities->count()) * 100 : 0;
                $closed_percentage = $relatedActivities->count() > 0 ? ($statusCounts['closed'] / $relatedActivities->count()) * 100 : 0;
            @endphp

            <div class="container1">
                <div class="box1" style="width: 100%">
                    <div class="main-card">
                        <div class="main-card-header">
                            <div class="name">
                                <h3>Related Activities</h3>
                                <h6>Important Information here</h6>
                            </div>
                        </div>
                        <div class="card-slider-container">
                            <div class="frame">
                                <div class="card-slider">
                                    <div class="cards-pair 1">
                                        <div class="card-wrapper">
                                            <div class="pair1">
                                                <div class="pair1-card" style="width: 23%">
                                                    <div class="card-header">
                                                        <img src="{{ asset('Asserts/logo/card2-img.png') }}"
                                                            alt="Confirmed Activities">
                                                        <div class="card-name">
                                                            <h4 style="cursor: pointer;" id="worked-resources">Confirmed
                                                                Activities</h4>
                                                        </div>
                                                    </div>
                                                    <h5>{{ $statusCounts['confirmed'] }}</h5>
                                                    <div class="bar-outside">
                                                        <div class="bar-inside2" style="width:{{ $confirmed_percentage }}%;">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="pair1-card" style="width: 23%">
                                                    <div class="card-header">
                                                        <img src="{{ asset('Asserts/logo/card3-img.png') }}"
                                                            alt="Approved Activities">
                                                        <div class="card-name">
                                                            <h4 style="cursor: pointer;" id="approved-activities">Approved
                                                                Activities</h4>
                                                        </div>
                                                    </div>
                                                    <h5>{{ $statusCounts['closed'] }}</h5>
                                                    <div class="bar-outside">
                                                        <div class="bar-inside1"
                                                            style="width: {{ $closed_percentage }}%;"></div>
                                                    </div>
                                                </div>

                                                <div class="pair1-card" style="width: 23%">
                                                    <div class="card-header">
                                                        <img src="{{ asset('Asserts/logo/card4-img.png') }}"
                                                            alt="Closed Activities">
                                                        <div class="card-name">
                                                            <h4 style="cursor: pointer;" id="confirmed-activities">Paid
                                                                Activities</h4>
                                                        </div>
                                                    </div>

                                                    <h5>{{ $paidActivities->count() }}</h5>
                                                    <div class="bar-outside">
                                                        <div class="bar-inside2" style="width:100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div> 
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div> 
        @else
            <p>No Related Activities Found !</p>
        @endif
    </div>  
@endsection
