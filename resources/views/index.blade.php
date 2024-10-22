@extends('layouts.app')
@section("content")

<style>
    .container1 .box2 .afternoon .task-table .btns button {
        width: 2.1em;
        height: 2em;
        border: 1px solid lightgray;
        margin: 0 0 0 0.2em;
        background-color: white;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s ease-in-out;
    }

    .container1 .box2 .afternoon .task-table .btns button:hover {
        background-color: #e94d65;
    }

    .container1 .box2 .afternoon .task-table .btns {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.7em;

    }

    .afternoon .task-wrapper {
        overflow: auto;
        width: 100%;
        flex: 1;
    }

    .afternoon .task-wrapper::-webkit-scrollbar {
        width: 0px;
        height: 0px;
    }

    .afternoon .task-wrapper::-webkit-scrollbar-track {
        background: none;
    }

    .afternoon .task-wrapper::-webkit-scrollbar-thumb {
        background: #e94d65;
    }

    .afternoon .task-wrapper::-webkit-scrollbar-thumb:hover {
        border: 1px solid white;
    }

    .afternoon-header {
        justify-content: space-between !important;
        border-bottom: 1px solid lightgray;
    }

    #year-picker {
        width: 100%;
        padding: 5px;
        border: 1px solid lightgray;
        border-radius: 5px;
        text-align: start;
        cursor: pointer;
        font-size: 11.5px;
    }

    .card-selectors #year-list {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        grid-template-rows: 1fr 1fr 1fr;
        row-gap: 0.5em;
        column-gap: 1em;
    }

    .calendar {
        display: none;
        position: absolute;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        margin: 17em 2em 0 0;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        background: #2d6d8b;
        border-bottom: 1px solid #2d6d8b;
        color: white;
        font-weight: 600;
    }

    .calendar-header button {
        font-size: 1em;
        transition: 0.2s ease;
        color: white;
    }

    .calendar-header button:hover {
        font-size: 1.3em;
    }

    .calendar-body {
        padding: 10px;
    }

    .year-item {
        display: inline-block;
        width: 100%;
        padding: 5px;
        text-align: center;
        cursor: pointer;
        border-radius: 5px;
    }

    .year-item:hover {
        background-color: #e94d65;
        color: white;
    }

    #prev-year,
    #next-year {
        background: none;
        border: none;
        cursor: pointer;
    }

    .date-picker {
        width: 100%;
        padding: 5px;
        border: 1px solid lightgray;
        border-radius: 5px;
        text-align: start;
        cursor: pointer;
        font-size: 11.5px;
    }
    .chart-data2{
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 1.5em;
        font-size: 15px;
        font-weight: bold;
    }
</style>
<div id="alert-danger" class="alert alert-danger" style="display: none;">
    <ul id="error-list"></ul>
</div>
<div id="alert-success" class="alert alert-success" style="display: none;"></div>
<div class="container1">
    <div class="box1">
        <div class="main-card">
            <div class="main-card-header">
                <div class="name">
                    <h3>Main Cards</h3>
                    <h6>Important Information here</h6>
                </div>

                <div class="card-btns">
                    <button class="arrow left">
                        <img src="./Asserts/logo/left-arrow-main.png">
                    </button>
                    <button class="arrow right">
                        <img src="./Asserts/logo/right-arrow-main.png">
                    </button>
                </div>

            </div>
            <div class="card-slider-container">
                <div class="frame">
                    <div class="card-slider">
                        <div class="cards-pair 1">
                            <div class="card-wrapper">
                                <div class="pair1">
                                    <div class="pair1-card">
                                        <div class="card-header">
                                            <img src="{{asset('Asserts/logo/card1-img.png')}}">
                                            <div class="card-name">
                                                <h4 style="cursor:pointer" id="total-resources">Total Resources</h4>
                                            </div>
                                        </div>
                                        <h5>{{$total_resources->count()}}</h5>
                                        <div class="bar-outside">
                                            <div class="bar-inside1"></div>
                                        </div>
                                    </div>
                                    <div class="pair1-card">
                                        <div class="card-header">
                                            <img src="{{asset('Asserts/logo/card2-img.png')}}">
                                            <div class="card-name">
                                                <h4 style="cursor:pointer" id="worked-resources">Worked Resources</h4>
                                            </div>
                                        </div>
                                        <h5>{{$worked_resources->count()}}</h5>
                                        <div class="bar-outside">
                                            <div class="bar-inside2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pair2">
                                    <div class="pair2-card">
                                        <div class="card-header">
                                            <img src="{{asset('Asserts/logo/card3-img.png')}}">
                                            <div class="card-name">
                                                <h4 style="cursor:pointer" id="approved-activities">Approved Activities</h4>
                                            </div>
                                        </div>
                                        <h5>{{$approved_activities->count()}}</h5>
                                        <div class="bar-outside">
                                            <div class="bar-inside1"></div>
                                        </div>
                                    </div>
                                    <div class="pair2-card">
                                        <div class="card-header">
                                            <img src="{{asset('Asserts/logo/card4-img.png')}}">
                                            <div class="card-name">
                                                <h4 style="cursor:pointer" id="confirmed-activities">Confirmed Activies</h4>
                                            </div>
                                        </div>
                                        <h5>{{$confirmed_activities->count()}}</h5>
                                        <div class="bar-outside">
                                            <div class="bar-inside2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cards-pair 2">
                            <div class="card-wrapper">
                                <div class="pair1">
                                    <div class="pair1-card">
                                        <div class="card-header">
                                            <img src="{{asset('Asserts/logo/card1-img.png')}}">
                                            <div class="card-name">
                                                <h4 id="tech-paid" style="cursor:pointer">Tech paid invoices</h4>
                                                <h6>CIG paid invoices</h6>
                                            </div>
                                        </div>
                                        <h5>{{$tech_paid->count()}}</h5>
                                        <div class="bar-outside">
                                            <div class="bar-inside1"></div>
                                        </div>
                                    </div>
                                    <div class="pair1-card">
                                        <div class="card-header">
                                            <img src="{{asset('Asserts/logo/card2-img.png')}}">
                                            <div class="card-name">
                                                <h4 id="tech-unpaid" style="cursor:pointer">Tech payable invoices</h4>
                                                <h6>CIG unpaid invoices</h6>
                                            </div>
                                        </div>
                                        <h5>{{$tech_unpaid->count()}}</h5>
                                        <div class="bar-outside">
                                            <div class="bar-inside2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pair2">
                                    <div class="pair2-card">
                                        <div class="card-header">
                                            <img src="{{asset('Asserts/logo/card3-img.png')}}">
                                            <div class="card-name">
                                                <h4 id="client-paid" style="cursor:pointer">Client received invoices</h4>
                                                <h6>CIG paid Invoices</h6>
                                            </div>
                                        </div>
                                        <h5>{{$client_paid->count()}}</h5>
                                        <div class="bar-outside">
                                            <div class="bar-inside1"></div>
                                        </div>
                                    </div>
                                    <div class="pair2-card">
                                        <div class="card-header">
                                            <img src="{{asset('Asserts/logo/card4-img.png')}}">
                                            <div class="card-name">
                                                <h4 id="client-unpaid" style="cursor:pointer">Client receivable Invoices</h4>
                                                <h6>CIG unpaid Invoices</h6>
                                            </div>
                                        </div>
                                        <h5>{{$client_unpaid->count()}}</h5>
                                        <div class="bar-outside">
                                            <div class="bar-inside2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="overveiw">
            <div class="overveiw-header">
                <div class="name">
                    <h2>Overveiw</h2>
                    <h3>Profit In Dollars and Euros</h3>
                </div>
            </div>

            <div id="chart_div" style="width: 100%; display: flex; align-item: center;height: 20em;"></div>
        </div>
    </div>
    <div class="box2">
        <div class="announcement">
            <div class="card-header">
                <div class="card-name">
                    <img src="{{asset('Asserts/logo/announcement-img.png')}}" />
                    <div class="heading">
                        <h4>Announcements</h4>
                        <h6>Your Daily Reminders</h6>
                    </div>
                </div>
            </div>
            <div class="announcement-footer">
                <div class="announcement-content">
                    @foreach($anounsements as $anounsement)
                    <h4 class="announcement-item">
                        {{$anounsement->anounsement}}
                    </h4>
                    @endforeach
                </div>
                <div class="card-btns">
                    <button id="prev-btn" disabled>
                        <img src="{{asset('Asserts/logo/left-arrow-main.png')}}">
                    </button>
                    <button id="next-btn" class="right-btn">
                        <img src="{{asset('Asserts/logo/right-arrow-main.png')}}">
                    </button>
                </div>
            </div>

        </div>

        <div class="afternoon">
            <div class="afternoon-header">
                <div class="name">
                    <h3>Hello - {{ Auth::user()->user_name }}</h3>
                    <h6>Here Is your Daily Task report</h6>
                </div>
            </div>
            <div class="task-wrapper">
                <table id="notes" class="task-table">
                    <tbody>
                        @foreach($notes as $note)
                        <tr id="row_{{ $note->id }}" class="task">
                            <td>{{ $note->note }}</td>
                            <td>
                                <form id="editNoteForm_{{ $note->id }}" method="post" action="{{route('note.update')}}">
                                    @csrf
                                    <div class="modal" id="note_edit_modal_{{ $note->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-xl shadow-lg" role="document"
                                            style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                            <div class="modal-content modal-xl shadow-lg" style="border-radius: 10px;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modelHeading">Edit Note</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <input type="hidden" name="noteId" value="{{$note->id}}">
                                                <div class="modal-body">
                                                    <div class="data">
                                                        <div class="datetime-wrapper" style="margin-top:0">
                                                            <div class="date-time"
                                                                style="width:100%;margin-bottom: 1em;">
                                                                <label for="note" class="label"
                                                                    style="padding-top: 0">Note</label>
                                                                <input style="height:4em" type="text" id="note"
                                                                    name="note" value="{{$note->note}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button onclick="noteEdit({{$note->id}})" id="confirm"
                                                        class="confirm" type="button">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="btns">
                                    <button class="delete-note" data-id="{{$note->id}}">
                                        <img src="{{ asset('Asserts/logo/delete.png') }}" alt="Delete">
                                    </button>
                                    <button class="edit-note-table" data-id="{{ $note->id }}">
                                        <img src="{{ asset('Asserts/logo/rewrite.png') }}" alt="Rewrite">
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="afternoon-footer">
                <button onclick="openModal()">
                    + Add Task
                </button>
                <img src="{{asset('Asserts/logo/attend-meeting-img.png')}}">
            </div>
        </div>
    </div>
</div>
<form method="post" action="{{route('note.store')}}" class="addNoteForm">
    @csrf
    <div class="modal" id="note_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl shadow-lg" role="document"
            style="background-color: rgba(0, 0, 0, 0.03) !important;">
            <div class="modal-content modal-xl shadow-lg" style="border-radius: 10px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelHeading">Sticky Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="data">
                        <div class="datetime-wrapper" style="margin-top:0">
                            <div class="date-time" style="width:100%;margin-bottom: 1em;">
                                <label for="note" class="label" style="padding-top: 0">Note</label>
                                <input style="height:4em" type="text" id="note" name="note">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="confirm" class="confirm" type="submit">Add</button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
<div class="container2">
    <div class="section1">
        <div class="detail-cards">
            <div class="pair1">
            <div class="detail-card1" style="width: 49%;">
                    <h6>Total Revenue In Euro</h6>
                    <div class="card-detail">
                        <h4>{{$sumInEuro}}€</h4>
                    </div>
                    <canvas class="revenue" height="250"></canvas>
                </div>
                <div class="detail-card1" style="width: 49%;">
                    <h6>Total Revenue In Dollars</h6>
                    <div class="card-detail">
                        <h4>{{$sumInDollars}}$</h4>
                    </div>
                    <canvas class="revenue2" height="250"></canvas>
                </div>
            </div>
            <div class="pair2">
            <div class="detail-card1">
                    <h6>Engineer Cost In Dollars</h6>
                    <div class="card-detail">
                        <h4>{{$techsumInDollars}}$</h4>
                    </div>
                    <canvas class="revenue4" height="250"></canvas>
                </div>
                <div class="detail-card1"style="height:23.5em;">
                    <h6>Engineer Cost In Euros</h6>
                    <div class="card-detail">
                        <h4>{{$techsumInEuros}}€</h4>
                    </div>
                    <div style="display:flex; align-items: center; height: 85%;">
                        <canvas class="revenue5" style="height: 20em;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="operations" style="height: 48em;">
            <div class="operations-header">
                <div class="name" style=" flex: 1;">
                    <h3>Departmental Operations</h3>
                </div>
                <div class="card-selectors">
                    <input type="text" id="year-picker" placeholder="Select Year" readonly>
                    <div id="year-picker-calendar" class="calendar">
                        <div class="calendar-header">
                            <button id="prev-year">‹</button>
                            <span id="calendar-year"></span>
                            <button id="next-year">›</button>
                        </div>
                        <div class="calendar-body">
                            <div id="year-list"></div>
                        </div>
                    </div>
                    <p id="selected-year"></p>
                </div>
            </div>
            <canvas class="opration" height="200"></canvas>
            <canvas class="opration2" height="200" style="display: none;"></canvas>
        </div>
        @php
        $monthlyActivities = array_fill(0, 12, 0);

        foreach ($activities as $activity) {
        $date = \Carbon\Carbon::parse($activity->activity_start_date);
        $monthIndex = $date->month - 1;

        if ($monthIndex >= 0 && $monthIndex < 12) { $monthlyActivities[$monthIndex]++; } }
        @endphp 
        </div>
            <div class="section2">
                <div class="Cards">
                    <div class="Cards-header">
                        <div class="name">
                            <h3>Business Development</h3>
                        </div>
                    </div>
                    <div class="card-detail">
                        <div class="chart-heading">
                            <h6>Name</h6>
                            <h6>Client Uploaded</h6>
                        </div>
                        @if($bdmanagers->count() > 0)
                            @foreach($bdmanagers as $bdmanager)
                                <div class="chart-data">
                                    <h5>{{$bdmanager->user_name}}</h5>
                                    @php
                                        $clientUploaded = \App\Models\Client::where('user_id', $bdmanager->id)->count();
                                    @endphp
                                    <h6>{{$clientUploaded}}</h6>
                                </div>
                            @endforeach 
                        @else    
                            <div class="chart-data2">
                                <h5>No User with Role BD Exists</h5>
                            </div>
                        @endif
                    </div>

                </div>
                <div class="Cards">
                    <div class="Cards-header">
                        <div class="name">
                            <h3>Attendence</h3>
                        </div>
                    </div>

                    <div class="card-detail">
                        <div class="attendence-heading">
                            <div>
                                <h6>Name</h6>
                            </div>
                            <div style="margin-left: 4em;">
                                <h6>Check In</h6>
                            </div>
                            <div>
                                <h6>Check Out</h6>
                            </div>
                        </div>
                        @if($attendances->count() > 0)
                            @foreach($attendances as $attendance)
                                <div class="chart-data">
                                    <div class="profile">
                                        <a style="color: black !important;" href="{{route('allAttendance' , $attendance->user->id )}}">      
                                            <img style="height: 40px;width: 40px;" src="{{ asset('Asserts/General/user.png') }}">
                                        </a>
                                        <div class="name">
                                            <a style="color: black !important;" href="{{route('allAttendance' , $attendance->user->id )}}">
                                                <h6>{{$attendance->user->user_name}}</h6>
                                            </a>
                                            <a style="color: black !important;" href="{{route('allAttendance' , $attendance->user->id )}}">
                                                <h5>{{$attendance->user->role->name}}</h5>
                                            </a>
                                        </div>

                                    </div>
                                    <p>{{$attendance->in}}</p>
                                    <p>{{$attendance->out}}</p>
                                </div>
                            @endforeach     
                        @else    
                            <div class="chart-data2">
                                <h5>No Attendance Of Today Recorded Yet</h5>
                            </div>    
                        @endif
                    </div>

                </div>
                <div class="Cards">
                    <div class="Cards-header">
                        <div class="name">
                            <h3>Company Sales</h3>
                            <h6>Overall Company Performance</h6>
                        </div>
                        <!--<div class="card-selectors" style="flex-direction: column;gap: 0.5em;">-->
                        <!--    <div style="display:flex">-->
                        <!--        <label style="margin-right:1em">start:</label>-->
                        <!--        <input id="start-date" class="date-picker" type="date">-->
                        <!--    </div>-->
                        <!--    <div style="display:flex;gap: 0.5em;">-->
                        <!--        <label style="margin-right:1em;">end:</label>-->
                        <!--        <input id="end-date" class="date-picker" type="date">-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                    <div style="justify-content: center !important;" class="chart">
                        <canvas id="myPieChart"></canvas>
                        <canvas id="myPieChart2" style="display: none;"></canvas>
                    </div>
                </div>
            </div>
    </div>
    @php
    $clientsData = $clients->map(function ($client) {
        return [
            'name' => $client->company_name,
            'activitiesCount' => $client->activities->count()
            ];
        });
    @endphp

    @endsection
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        const leftArrow = document.querySelector('.left');
        const rightArrow = document.querySelector('.right');
        const cardSlider = document.querySelector('.card-slider');
        const cardsPair = document.querySelectorAll('.cards-pair');

        let currentSlide = 0;
        const totalSlides = cardsPair.length;

        const nextSlide = () => {
            if (currentSlide < totalSlides - 1) {
                currentSlide++;
                cardSlider.style.transform = `translateX(${-currentSlide * 100}%)`;
            } else {
                currentSlide = 0;
                cardSlider.style.transform = 'translateX(0px)';
            }
        };

        const prevSlide = () => {
            if (currentSlide > 0) {
                currentSlide--;
                cardSlider.style.transform = `translateX(${-currentSlide * 100}%)`;
            } else {
                currentSlide = totalSlides - 1;
                cardSlider.style.transform = `translateX(${-currentSlide * 100}%)`;
            }
        };

        rightArrow.addEventListener('click', nextSlide);
        leftArrow.addEventListener('click', prevSlide);
    </script>
    <!-- to open note model  -->
    <script>
        function openModal() {
            var modal = document.getElementById("note_modal");
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
    <!-- note script  -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myForm = document.querySelector('.addNoteForm');
            var errorAlert = document.getElementById('alert-danger');
            var errorList = document.getElementById('error-list');
            var successAlert = document.getElementById('alert-success');

            myForm.addEventListener('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(myForm);
                fetch(myForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute(
                                    'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            let note = data.note;
                            let newRow = `
                                    <tr id="row_${note.id}" class="task">
                                            <td>${note.note}</td>
                                            <td>
                                                <form id="editNoteForm_${note.id}" method="post" action="{{route('note.update')}}">
                                                    @csrf
                                                    <div class="modal" id="note_edit_modal_${note.id}" tabindex="-1"
                                                        role="dialog">
                                                        <div class="modal-dialog modal-xl shadow-lg" role="document"
                                                            style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                                            <div class="modal-content modal-xl shadow-lg"
                                                                style="border-radius: 10px;">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="modelHeading">Edit Note</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close"><span
                                                                            aria-hidden="true">×</span></button>
                                                                </div>
                                                                <input type="hidden" name="noteId" value="${note.id}">
                                                                <div class="modal-body">
                                                                    <div class="data">
                                                                        <div class="datetime-wrapper" style="margin-top:0">
                                                                            <div class="date-time"
                                                                                style="width:100%;margin-bottom: 1em;">
                                                                                <label for="note" class="label"
                                                                                    style="padding-top: 0">Note</label>
                                                                                <input style="height:4em" type="text" id="note"
                                                                                    name="note" value="${note.note}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button onclick="noteEdit(${note.id})" id="confirm" class="confirm"
                                                                        type="button">Update</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="btns">
                                                    <button class="delete-note" data-id="${note.id}">
                                                        <img src="{{ asset('Asserts/logo/delete.png') }}" alt="Delete">
                                                    </button>
                                                    <button class="edit-note-table" data-id="${note.id}">
                                                        <img src="{{ asset('Asserts/logo/rewrite.png') }}" alt="Rewrite">
                                                    </button>
                                                </div>
                                            </td>
                                    </tr>
                                `;
                            document.querySelector('#notes tbody').insertAdjacentHTML('beforeend',
                                newRow);
                            var modalId = 'note_modal';
                            var modal = document.getElementById(modalId);
                            if (modal) {
                                modal.style.display = 'none';
                                modal.classList.remove('show');
                            }
                            document.body.classList.remove('modal-open');
                            document.body.style.overflow = '';
                            // Reset form and alerts
                            myForm.reset();
                            errorAlert.style.display = 'none';
                            successAlert.textContent = data.message;
                            successAlert.style.display = 'block';
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });
                            setTimeout(function() {
                                successAlert.style.display = 'none';
                            }, 3000);

                            // Re-register edit table buttons event listener
                            registerEditTableButtons();
                        } else {
                            errorList.innerHTML = '';
                            if (data.errors.length > 0) {
                                var li = document.createElement('li');
                                li.textContent = data.errors[0].message;
                                errorList.appendChild(li);

                                errorAlert.style.display = 'block';
                                successAlert.style.display = 'none';

                                var firstErrorField;
                                data.errors.forEach(function(error, index) {
                                    var errorField = myForm.querySelector(
                                        `[name="${error.field}"]`);
                                    if (errorField) {
                                        errorField.style.border = '1px solid red';
                                        if (errorField.type === 'file') {
                                            errorField.classList.add('file-not-valid');
                                        }
                                        if (index === 0) {
                                            firstErrorField = errorField;
                                        }
                                    }
                                });

                                if (firstErrorField) {
                                    firstErrorField.focus();
                                }
                                setTimeout(function() {
                                    errorAlert.style.display = 'none';
                                }, 3000);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

            myForm.addEventListener('input', function(event) {
                if (event.target.tagName === 'INPUT' || event.target.tagName === 'TEXTAREA') {
                    if (event.target.value.trim() !== '') {
                        event.target.style.border = '';
                        if (event.target.type === 'file') {
                            event.target.classList.remove('file-not-valid');
                        }
                    }
                }
            });

            myForm.addEventListener('change', function(event) {
                if (event.target.tagName === 'SELECT') {
                    if (event.target.value.trim() !== '') {
                        event.target.style.border = '';
                        if (event.target.type === 'file') {
                            event.target.classList.remove('file-not-valid');
                        }
                    }
                }
            });

            myForm.addEventListener('reset', function() {
                errorAlert.style.display = 'none';
                successAlert.style.display = 'none';
                errorList.innerHTML = '';
            });

            function registerEditTableButtons() {
                document.querySelectorAll('.edit-note-table').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var noteId = button.getAttribute('data-id');
                        openEditModal(noteId);
                    });
                });
            }

            registerEditTableButtons();

            $(document).on('click', '.delete-note', function() {
                var noteId = $(this).data('id');
                if (confirm('Are you sure you want to delete this note?')) {
                    $.ajax({
                        url: '/destroyNote/' + noteId,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#row_' + noteId).remove();
                            alert('Note deleted successfully');
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            // Event delegation for modal close button and backdrop
            $(document).on('click', '[data-dismiss="modal"]', function() {
                var modal = $(this).closest('.modal');
                if (modal.length > 0) {
                    modal.removeClass('show');
                    modal.css('display', 'none');
                    document.body.classList.remove('modal-open');
                }
            });

        });

        function openEditModal(noteId) {
            var modalId = "note_edit_modal_" + noteId;
            var modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add("show");
                modal.style.display = "block";
                document.body.classList.add("modal-open");
            } else {
                console.error("Modal with ID " + modalId + " not found.");
            }
        }
    </script>
    <!-- edit note script  -->
    <script>
        function noteEdit(noteId) {
            var formData = new FormData(document.getElementById('editNoteForm_' + noteId));
            axios.post('{{ route('note.update') }}',
                    formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                .then(function(response) {
                    var data = response.data;
                    showSuccessAlert('Note updated successfully!');
                    var rowId = 'row_' + data.noteId;
                    var tableRow = document.getElementById(rowId);
                    if (tableRow) {
                        tableRow.cells[0].textContent = data.note.note;
                    }
                    var modalId = 'note_edit_modal_' + data.noteId;
                    var modal = document.getElementById(modalId);
                    if (modal) {
                        modal.style.display = 'none';
                        modal.classList.remove('show');
                    }
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
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
    <!-- for anounsement transition  -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const announcements = document.querySelectorAll('.announcement-item');
            let currentIndex = 0;

            function showAnnouncement(index) {
                announcements.forEach((announcement, i) => {
                    announcement.style.display = i === index ? 'block' : 'none';
                });
                updateButtonStates();
            }

            function updateButtonStates() {
                document.getElementById('prev-btn').disabled = currentIndex === 0;
                document.getElementById('next-btn').disabled = currentIndex === announcements.length - 1;
            }
            showAnnouncement(currentIndex);

            document.getElementById('prev-btn').addEventListener('click', function() {
                if (currentIndex > 0) {
                    currentIndex--;
                    showAnnouncement(currentIndex);
                }
            });
            document.getElementById('next-btn').addEventListener('click', function() {
                if (currentIndex < announcements.length - 1) {
                    currentIndex++;
                    showAnnouncement(currentIndex);
                }
            });
        });
    </script>
    <!-- variable passing into js for charts  -->
    <script>
        window.monthlyActivities = @json($monthlyActivities);
        window.clients = @json($clientsData);
        window.data = @json($data);
        window.labels = @json($labels);
    </script>
    <!-- to append years  -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const yearPickerInput = document.getElementById('year-picker');
            const calendarDiv = document.getElementById('year-picker-calendar');
            const yearListDiv = document.getElementById('year-list');
            const calendarYearSpan = document.getElementById('calendar-year');

            let currentYear = new Date().getFullYear();

            function renderYearList() {
                yearListDiv.innerHTML = '';
                const startYear = currentYear - 5;
                const endYear = currentYear + 5;

                for (let i = startYear; i <= endYear; i++) {
                    const yearItem = document.createElement('div');
                    yearItem.classList.add('year-item');
                    yearItem.textContent = i;
                    yearItem.onclick = () => selectYear(i);
                    yearListDiv.appendChild(yearItem);
                }
                calendarYearSpan.textContent = `${startYear} to ${endYear}`;
            }

            function selectYear(year) {
                const startDate = `${year}-01-01`;
                const endDate = `${year}-12-31`;
                yearPickerInput.value = `${startDate} to ${endDate}`;
                fetch(`/data-for-year/${year}`)
                    .then(response => response.json())
                    .then(data => {
                        const monthlyActivities = Array(12).fill(0);

                        data.forEach(activityStartDate => {
                            const date = new Date(activityStartDate);
                            const monthIndex = date.getMonth();

                            if (monthIndex >= 0 && monthIndex < 12) {
                                monthlyActivities[monthIndex]++;
                            }
                        });
                        const oprationCanvas1 = document.getElementsByClassName("opration")[0];
                        oprationCanvas1.style.display = 'none';
                        const oprationCanvas = document.getElementsByClassName("opration2")[0];
                        oprationCanvas.style.display = 'block';
                        new Chart(oprationCanvas, {
                            type: "bar",
                            data: {
                                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",
                                    "Oct", "Nov", "Dec"
                                ],
                                datasets: [{
                                    data: monthlyActivities,
                                    label: "Activities",
                                    backgroundColor: "#C7DEE5",
                                    hoverBackgroundColor: '#E94D65',
                                    borderWidth: 1,
                                    borderRadius: 5,
                                }, ],
                            },
                            options: {
                                scales: {
                                    x: {
                                        display: true,
                                        grid: {
                                            display: true,
                                        },

                                    },
                                    y: {
                                        grid: {
                                            display: false,
                                        },
                                    },
                                },
                                plugins: {
                                    legend: {
                                        display: false,
                                    },
                                },
                            },
                        });
                    })
                    .catch(error => console.error('Error fetching data:', error));
                calendarDiv.style.display = 'none';
            }

            document.getElementById('prev-year').onclick = () => {
                currentYear -= 11;
                renderYearList();
            };

            document.getElementById('next-year').onclick = () => {
                currentYear += 11;
                renderYearList();
            };

            yearPickerInput.onclick = () => {
                calendarDiv.style.display = calendarDiv.style.display === 'block' ? 'none' : 'block';
                renderYearList();
            };

            document.addEventListener('click', (event) => {
                if (!calendarDiv.contains(event.target) && event.target !== yearPickerInput) {
                    calendarDiv.style.display = 'none';
                }
            });
        });
    </script>
    <!-- for customer filter  -->
    <script>
        document.getElementById('end-date').addEventListener('change', function() {
            const startDate = document.getElementById('start-date').value;
            const endDate = this.value;

            if (!startDate || !endDate) {
                alert('Please select both start and end dates.');
                return;
            }

            fetch(`/clients/activities?start_date=${startDate}&end_date=${endDate}`)
                .then(response => response.json())
                .then(data => {

                    const pieChartCanvas1 = document.getElementById('myPieChart');
                    pieChartCanvas1.style.display = 'none';

                    const pieChartCanvas2 = document.getElementById('myPieChart2').getContext('2d');
                    document.getElementById('myPieChart2').style.display = 'block';

                    const clients = data;
                    const totalActivities = clients.reduce((sum, client) => sum + client.activitiesCount, 0);

                    const newData = clients.map(client => client.activitiesCount);

                    function getRandomColor() {
                        const letters = '0123456789ABCDEF';
                        let color = '#';
                        for (let i = 0; i < 6; i++) {
                            color += letters[Math.floor(Math.random() * 16)];
                        }
                        return color;
                    }

                    const backgroundColors = Array(clients.length).fill().map(() => getRandomColor());

                    const pieChartData = {
                        labels: clients.map(client => client.name),
                        datasets: [{
                            data: newData,
                            backgroundColor: backgroundColors,
                            hoverOffset: 20
                        }]
                    };

                    const myPieChart = new Chart(pieChartCanvas2, {
                        type: 'pie',
                        data: pieChartData,
                        options: {
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            tooltips: {
                                callbacks: {
                                    label: function(tooltipItem, newData) {
                                        const label = newData.labels[tooltipItem.index];
                                        const count = newData.datasets[0].data[tooltipItem.index];
                                        return `${label}: ${count} activities`;
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching data:', error));

        });
    </script>
    <!-- for routes  -->
    <script>
        document.getElementById('total-resources').addEventListener('click', function() {
            window.location.href = "{{ route('resources.index') }}";
        });
        document.getElementById('worked-resources').addEventListener('click', function() {
            window.location.href = "{{ route('resources.worked') }}";
        });
        document.getElementById('approved-activities').addEventListener('click', function() {
            window.location.href = "{{ route('activities.approved') }}";
        });
        document.getElementById('confirmed-activities').addEventListener('click', function() {
            window.location.href = "{{ route('activities.confirmed') }}";
        });
        document.getElementById('tech-unpaid').addEventListener('click', function() {
            window.location.href = "{{ route('techPayableInvoices') }}";
        });
        document.getElementById('tech-paid').addEventListener('click', function() {
            window.location.href = "{{ route('techPaidInvoices') }}";
        });
        document.getElementById('client-unpaid').addEventListener('click', function() {
            window.location.href = "{{ route('clientPayableInvoices') }}";
        });
        document.getElementById('client-paid').addEventListener('click', function() {
            window.location.href = "{{ route('clientPaidInvoices') }}";
        });
    </script>
    <script>
        const monthLabels = @json($labels);
        const revenueData = @json($data);

        const formattedLabels = monthLabels.map(date => {
            const [year, month] = date.split("-");
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            return `${monthNames[parseInt(month) - 1]} ${year}`;
        });

        const ctx = document.getElementsByClassName("revenue");

        new Chart(ctx, {
            type: "line",
            data: {
                labels: formattedLabels, 
                datasets: [{
                    data: revenueData, 
                    label: "Revenue",
                    backgroundColor: "#6FCF97",
                    borderColor: "#6FCF97",
                    borderWidth: 2,
                    fill: false,  
                }]
            },
            options: {
                scales: {
                    x: {
                        display: true,
                        grid: { display: false },
                        ticks: { autoSkip: false },
                    },
                    y: {
                        display: true,
                        grid: { display: false },
                        ticks: { beginAtZero: true },
                    },
                },
                plugins: {
                    legend: { display: false },
                },
                elements: {
                    point: { radius: 4 },
                },
                layout: {
                    padding: {
                        top: 20,
                        bottom: 20,
                        left: 10,
                        right: 10,
                    },
                },
            },
        });
    </script>
    <script>
        const monthLabels2 = @json($labels2);
        const revenueData2 = @json($data2);

        const formattedLabels2 = monthLabels2.map(date => {
            const [year2, month2] = date.split("-");
            const monthNames2 = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            return `${monthNames2[parseInt(month2) - 1]} ${year2}`;
        });

        const ctx2 = document.getElementsByClassName("revenue2");

        new Chart(ctx2, {
            type: "line",
            data: {
                labels: formattedLabels2, 
                datasets: [{
                    data: revenueData2, 
                    label: "Revenue",
                    backgroundColor: "#6FCF97",
                    borderColor: "#6FCF97",
                    borderWidth: 2,
                    fill: false,  
                }]
            },
            options: {
                scales: {
                    x: {
                        display: true,
                        grid: { display: false },
                        ticks: { autoSkip: false },
                    },
                    y: {
                        display: true,
                        grid: { display: false },
                        ticks: { beginAtZero: true },
                    },
                },
                plugins: {
                    legend: { display: false },
                },
                elements: {
                    point: { radius: 4 },
                },
                layout: {
                    padding: {
                        top: 20,
                        bottom: 20,
                        left: 10,
                        right: 10,
                    },
                },
            },
        });
    </script>
    <script>
        const monthLabels4 = @json($labels4);
        const revenueData4 = @json($data4);

        const formattedLabels4 = monthLabels4.map(date => {
            const [year4, month4] = date.split("-");
            const monthNames4 = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            return `${monthNames4[parseInt(month4) - 1]} ${year4}`;
        });

        const ctx4 = document.getElementsByClassName("revenue4");

        new Chart(ctx4, {
            type: "line",
            data: {
                labels: formattedLabels4, 
                datasets: [{
                    data: revenueData4, 
                    label: "Cost",
                    backgroundColor: "#6FCF97",
                    borderColor: "#6FCF97",
                    borderWidth: 2,
                    fill: false,  
                }]
            },
            options: {
                scales: {
                    x: {
                        display: true,
                        grid: { display: false },
                        ticks: { autoSkip: false },
                    },
                    y: {
                        display: true,
                        grid: { display: false },
                        ticks: { beginAtZero: true },
                    },
                },
                plugins: {
                    legend: { display: false },
                },
                elements: {
                    point: { radius: 4 },
                },
                layout: {
                    padding: {
                        top: 20,
                        bottom: 20,
                        left: 10,
                        right: 10,
                    },
                },
            },
        });
    </script>
    <script>
        const monthLabels5 = @json($labels5);
        const revenueData5 = @json($data5);

        const formattedLabels5 = monthLabels5.map(date => {
            const [year5, month5] = date.split("-");
            const monthNames5 = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            return `${monthNames5[parseInt(month5) - 1]} ${year5}`;
        });

        const ctx5 = document.getElementsByClassName("revenue5");

        new Chart(ctx5, {
            type: "line",
            data: {
                labels: formattedLabels5, 
                datasets: [{
                    data: revenueData5, 
                    label: "Cost",
                    backgroundColor: "#6FCF97",
                    borderColor: "#6FCF97",
                    borderWidth: 2,
                    fill: false,  
                }]
            },
            options: {
                scales: {
                    x: {
                        display: true,
                        grid: { display: false },
                        ticks: { autoSkip: false },
                    },
                    y: {
                        display: true,
                        grid: { display: false },
                        ticks: { beginAtZero: true },
                    },
                },
                plugins: {
                    legend: { display: false },
                },
                elements: {
                    point: { radius: 4 },
                },
                layout: {
                    padding: {
                        top: 10,
                        bottom: 10,
                        left: 10,
                        right: 10,
                    },
                },
            },
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            google.charts.load('current', { 'packages': ['corechart'] });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var graphData = @json($graphData);

                var data = google.visualization.arrayToDataTable([
                    ['Month', 'Dollars', 'Euros'],
                    ...graphData
                ]);

                var options = {
                    legend: { position: 'none' },
                    series: {
                        0: { color: '#1C617B' },
                        1: { color: '#E94D65' },
                    },
                    lineWidth: 2
                };
                var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        });
    </script>
    @endpush