@extends("layouts.app")
@section('content')
<style>
body {
    grid-auto-rows: 0.13fr 1fr;
}

input[type='number']::-webkit-outer-spin-button,
input[type='number']::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type='number'] {
    -moz-appearance: textfield;
}

.header-container {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}

.header-container .left-side {
    width: 35%;
    margin: 0.6em;
    border-radius: 5px;
    background-color: rgb(255, 255, 255);
    box-shadow: 2px 2px 4px 1px rgba(0, 0, 0, 0.1);
}

.header-container .left-side:hover {
    box-shadow: 2px 2px 4px 1px rgba(0, 0, 0, 0.2);
}

.header-container .left-side .header {
    display: flex;
    align-items: center;
    justify-content: start;
    padding: 0.9em;
    border-bottom: 1px solid lightgray;
}

.header-container .left-side .header img {
    width: 2.2em;
    height: 2.2em;
}

.header-container .left-side .header .name {
    text-align: start;
    margin: 0 0 5px 8px;
}

.header-container .left-side .header .name h4 {
    color: rgb(21, 76, 100);
    font-weight: 500;
    font-size: 1.2em;
}

.header-container .left-side .header .name p {
    color: rgb(21, 76, 100);
    font-weight: 400;
    font-size: 9px;
    line-height: 0.7em;
}

.header-container .left-side .body {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.header-container .left-side .body .detail {
    width: 85%;
    margin: 2em 0 0 0;
}

.header-container .left-side .body .detail h5 {
    color: rgb(21, 76, 100);
    font-weight: 400;
    font-size: 12px;
}

.header-container .left-side .body .detail p {
    color: rgb(21, 76, 100);
    font-weight: 400;
    font-size: 10px;
    line-height: 0.7em;
}

.header-container .left-side .body button {
    width: 85%;
    background-color: #e94d65;
    cursor: pointer;
    border-radius: 5px;
    border: none;
    padding: 0.4em;
    text-align: center;
    font-size: 12px;
    font-weight: 500;
    color: rgb(255, 255, 255);
    margin: 25px 0 15px 0;
    transition: 0.2s ease-in-out;
}

.header-container .left-side .body button:hover {
    box-shadow: 2px 2px 4px 1px rgba(0, 0, 0, 0.2);
}

.header-container .right-side {
    width: 65%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-direction: column;
    gap: 10px;
}

.header-container .right-side .row {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.header-container .right-side .row .cards {
    width: 30%;
    padding: 0.5em;
    border-radius: 7px;
    background-color: rgb(255, 255, 255);
    box-shadow: 2px 2px 4px 1px rgba(0, 0, 0, 0.1);
}

.header-container .right-side .row .cards:hover {
    box-shadow: 2px 2px 4px 1px rgba(0, 0, 0, 0.2);
}

.header-container .right-side .row .cards .card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header-container .right-side .row .cards .card-header h5 {
    font-size: 1.5em;
    font-weight: 400;
    color: rgb(21, 76, 100);
}

.header-container .right-side .row .cards .card-header .circle {
    width: 2em;
    height: 2em;
    border-radius: 50%;
    margin-bottom: 10px;
    background-color: rgb(21, 76, 100);
    display: flex;
    justify-content: center;
    align-items: center;
}

.header-container .right-side .row .cards .card-header .circle img {
    width: 50%;
}

.header-container .right-side .row .cards h5 {
    font-size: 12px;
    font-weight: 400;
    color: rgb(21, 76, 100);
}

.header-container .right-side .row .cards .description {
    display: flex;
    align-items: center;
    gap: 5px;
}

.header-container .right-side .row .cards .description .circle {
    width: 1em;
    height: 1em;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: rgb(151, 206, 113);
}

.header-container .right-side .row .cards .description h6 {
    font-size: 8px;
    font-weight: 400;
    color: rgb(21, 76, 100);
}

.datatable-container-overveiw {
    width: 100%;
    background-color: #ffffff;
    margin-top: 0.6em;
    border-radius: 1.1em;
    box-shadow: 2px 2px 4px 1px rgba(0, 0, 0, 0.1);
    position: relative;
}

.datatable-container-overveiw:hover {
    box-shadow: 2px 2px 4px 1px rgba(0, 0, 0, 0.2);
}

.datatable-container-overveiw .datatable-container-header {
    padding: 1em;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.datatable-container-overveiw .datatable-container-header .left-side-header {
    width: 70%;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.datatable-container-overveiw .datatable-container-header .left-side-header .record h3 {
    font-size: 17px;
    line-height: 14px;
    font-weight: 500;
}

.datatable-container-overveiw .datatable-container-header .left-side-header .record p {
    font-size: 10px;
    font-weight: 400;
}

main {
    margin: 0 !important;
}

#checkOutButton {
    &.disabled {
        cursor: not-allowed;
        opacity: 0.5;
    }

    &.enabled {
        cursor: pointer;
        opacity: 1;
    }
}

#checkInButton[disabled] {
    cursor: not-allowed;
    opacity: 0.5;
}
</style>
<main>
    @if(AdminOrHrManager())
    <div class="header-container">
        <div class="left-side" style="width: 32.5%;">
            <div class="header">
                <img src="{{asset('Asserts/logo/sun-logo.png')}}">
                <div class="name">
                    <h4>{{ \Carbon\Carbon::now()->format('l, F jS Y') }}</h4>
                </div>
            </div>
            @php
            $attendance = DB::table('attendances')->where('user_id', Auth::user()->id)->whereDate('date',
            Carbon\Carbon::today())->whereNotNull('in')->whereNotNull('out')->first();
            $attendance2 = DB::table('attendances')->where('user_id', Auth::user()->id)->whereDate('date',
            Carbon\Carbon::today())->whereNotNull('in')->whereNull('out')->exists();
            $user = Db::table('users')->where('id', Auth::user()->id)->first();

            if ($user && $user->check_in && $user->check_out) {
            $checkedIn = Carbon\Carbon::parse($user->check_in);
            $checkedOut = Carbon\Carbon::parse($user->check_out);

            $hours = $checkedIn->diffInHours($checkedOut);
            $minutes = $checkedIn->diffInMinutes($checkedOut) % 60;
            $timeDifference = "{$hours} hours {$minutes} minutes";

            $workedHours = $attendance ? $attendance->worked_hours : null;
            }
            @endphp
            <div class="body">
                @if($attendance == null || $workedHours < $timeDifference) <button id="checkInButton" @if($attendance2)
                    disabled @endif>
                    Check In
                    </button>
                    @else
                    <button id="checkInButton" disabled>
                        Check In
                    </button>
                    @endif
                    <div class="detail"
                        style="display: flex;align-items: center;justify-content: center;margin-top: 0px;">
                        <p style="font-size: 1.5em;" id="timeDisplay">

                        </p>
                    </div>
                    @if($attendance2)
                    <button id="checkOutButton" style="margin-top:7px">
                        Check Out
                    </button>
                    @else
                    <button id="checkOutButton" class="disabled" style="margin-top:7px" disabled>
                        Check Out
                    </button>
                    @endif
            </div>
        </div>
        <div class="right-side">
            <div class="row">
                <div class="cards">
                    <div class="card-header">
                        @if($totalEmployees != null)
                        <h5><a href="{{route('users')}}">{{$totalEmployees->count()}}</a></h5>
                        @else
                        <h5>0</h5>
                        @endif
                        <div class="circle">
                            <img src="{{asset('Asserts/logo/header-card-1.png')}}">
                        </div>
                    </div>
                    <h5>Total Employees</h5>
                </div>
                <div class="cards">
                    <div class="card-header">
                        @if($totalOntime != null)
                        <h5>{{$totalOntime}}</h5>
                        @else
                        <h5>0</h5>
                        @endif
                        <div class="circle" style="background-color: #e94d65 !important;">
                            <img src="{{asset('Asserts/logo/header-card2.png')}}">
                        </div>
                    </div>
                    <h5>On Time</h5>
                </div>
                <div class="cards">
                    <div class="card-header">
                        @if($totalAbsent != null)
                        <h5>{{$totalAbsent}}</h5>
                        @else
                        <h5>0</h5>
                        @endif
                        <div class="circle">
                            <img src="{{asset('Asserts/logo/header-card-3.png')}}">
                        </div>
                    </div>
                    <h5>Absent</h5>
                </div>
            </div>

            <div class="row">
                <div class="cards">
                    <div class="card-header">
                        @if($totalLateArrival != null)
                        <h5>{{$totalLateArrival}}</h5>
                        @else
                        <h5>0</h5>
                        @endif
                        <div class="circle" style="background-color: #e94d65 !important;">
                            <img src="{{asset('Asserts/logo/header-card-4.png')}}">
                        </div>
                    </div>
                    <h5>Late Arrival</h5>
                </div>
                <div class="cards">
                    <div class="card-header">
                        @if($totalLeftEarly != null)
                        <h5>{{$totalLeftEarly}}</h5>
                        @else
                        <h5>0</h5>
                        @endif
                        <div class="circle">
                            <img src="{{asset('Asserts/logo/header-card-5.png')}}">
                        </div>
                    </div>
                    <h5>Early Departures</h5>
                </div>
                <div class="cards">
                    <div class="card-header">
                        <h5>0</h5>
                        <div class="circle" style="background-color: #e94d65 !important;">
                            <img src="{{asset('Asserts/logo/header-card-6.png')}}">
                        </div>
                    </div>
                    <h5>Time-off</h5>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="header-container" style="justify-content: space-around;">
        <div class="left-side" style="width: 32.5%;">
            <div class="header">
                <img src="{{asset('Asserts/logo/sun-logo.png')}}">
                <div class="name">
                    <h4>{{ \Carbon\Carbon::now()->format('l, F jS Y') }}</h4>
                </div>
            </div>
            @php
                $attendance = DB::table('attendances')->where('user_id', Auth::user()->id)->whereDate('date',
                Carbon\Carbon::today())->whereNotNull('in')->whereNotNull('out')->first();
                $attendance2 = DB::table('attendances')->where('user_id', Auth::user()->id)->whereDate('date',
                Carbon\Carbon::today())->whereNotNull('in')->whereNull('out')->exists();
                $user = Db::table('users')->where('id', Auth::user()->id)->first();

                if ($user && $user->check_in && $user->check_out) {
                $checkedIn = Carbon\Carbon::parse($user->check_in);
                $checkedOut = Carbon\Carbon::parse($user->check_out);

                $hours = $checkedIn->diffInHours($checkedOut);
                $minutes = $checkedIn->diffInMinutes($checkedOut) % 60;
                $timeDifference = "{$hours} hours {$minutes} minutes";

                $workedHours = $attendance ? $attendance->worked_hours : null;
                }
            @endphp
            <div class="body">
                @if($attendance == null || $workedHours < $timeDifference) <button id="checkInButton" @if($attendance2)
                    disabled @endif>
                    Check In
                    </button>
                    @else
                    <button id="checkInButton" disabled>
                        Check In
                    </button>
                    @endif
                    <div class="detail"
                        style="display: flex;align-items: center;justify-content: center;margin-top: 0px;">
                        <p style="font-size: 1.5em;" id="timeDisplay">

                        </p>
                    </div>
                    @if($attendance2)
                    <button id="checkOutButton" style="margin-top:7px">
                        Check Out
                    </button>
                    @else
                    <button id="checkOutButton" class="disabled" style="margin-top:7px" disabled>
                        Check Out
                    </button>
                    @endif
            </div>
        </div>
        <div class="right-side" style="width: 32.5%;height: 13em;">
            <div class="row"style="height: 13em;">
                <div class="cards" style="width: 100%; height: 100%;">
                    <div class="card-header"style="padding: 3em 2em;">
                        @if($totalEmployees != null)
                        <h5><a href="{{route('users')}}">{{$totalEmployees->count()}}</a></h5>
                        @else
                        <h5>0</h5>
                        @endif
                        <div class="circle">
                            <img src="{{asset('Asserts/logo/header-card-1.png')}}">
                        </div>
                    </div>
                    <h5 style="text-align: center; padding-top: 2em;"><a href="{{route('users')}}">Total Employees</a></h5>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="datatable-container-overveiw">
        <div class="datatable-container-header">
            <div class="left-side-header">
                <div class="record">
                    <h3>Attendance Overveiw</h3>
                    <p>Resources that are available</p>
                </div>

            </div>
        </div>
        <div class="data-table-container scrollable-table">
            <table id="attendance" class="table table-sm  table-hover table-bordered" style="width: 79vw;">
                <thead>
                    <tr class="table-header">
                        <th>Sr#</th>
                        <th>Employee Name</th>
                        <th>Role</th>
                        <th>Date</th>
                        <th>Checked In</th>
                        <th>Checked Out</th>
                        <th>Worked Hours</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                    @if($attendance->in && $attendance->out)
                    <tr id="row_{{ $attendance->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a style="color: black !important;"
                                href="{{ route('allAttendance', $attendance->user->id ) }}">{{ $attendance->user->user_name ?? 'N/A' }}</a>
                        </td>
                        <td>{{ $attendance->user->role->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                        <td>{{ $attendance->in ?? 'N/A' }}</td>
                        <td>{{ $attendance->out ?? 'N/A' }}</td>
                        <td>{{ $attendance->worked_hours ?? 'N/A' }}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
@push('scripts')

<!-- to show live time and check in and check out  -->
<script>
    let timeInterval;
    let startTime = null;
    const storageKey = 'checkInStartTime';
    const checkInUrl = '/check-in';
    const checkOutUrl = '/check-out';

    function updateTime() {
        const now = new Date();
        let displayTime = '';

        if (startTime) {
            const elapsedSeconds = Math.floor((now - startTime) / 1000);
            const hours = String(Math.floor(elapsedSeconds / 3600)).padStart(2, '0');
            const minutes = String(Math.floor((elapsedSeconds % 3600) / 60)).padStart(2, '0');
            const seconds = String(elapsedSeconds % 60).padStart(2, '0');
            displayTime = `${hours}:${minutes}:${seconds}`;
        } else {
            const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
            displayTime = now.toLocaleTimeString([], options);
        }

        document.getElementById('timeDisplay').textContent = displayTime;
    }

    function recordTime() {
        const now = new Date();
        const options = { hour: '2-digit', minute: '2-digit', hour12: true };
        const formattedTime = now.toLocaleTimeString([], options);

        fetch('/check-in', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ check_in_time: formattedTime })
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Check-in time recorded successfully.');
                const checkInButton = document.getElementById('checkInButton');
                checkInButton.disabled = true;
                checkInButton.style.opacity = '0.5'; 
                checkInButton.style.cursor = 'not-allowed';

                const checkOutButton = document.getElementById('checkOutButton');
                checkOutButton.disabled = false;
                checkOutButton.classList.remove('disabled');
                checkOutButton.classList.add('enabled');

                clearInterval(timeInterval);
                startTime = new Date();
                localStorage.setItem(storageKey, startTime.toISOString());
                document.getElementById('timeDisplay').textContent = '00:00:00';
                timeInterval = setInterval(updateTime, 1000);
            } else {
                alert('Failed to record check-in time.');
            }
        }).catch(error => console.error('Error:', error));
    }

    function recordCheckOut() {
        const now = new Date();
        const options = { hour: '2-digit', minute: '2-digit', hour12: true };
        const formattedTime = now.toLocaleTimeString([], options);

        fetch('/check-out', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ check_out_time: formattedTime })
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                let attendance = data.attendance;
                let userName = data.userName;
                let userRole = data.userRole;
                let date = new Date(attendance.date);
                let formattedDate = date.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });

                let existingRow = document.querySelector(`#row_${attendance.id}`);
                
                if (existingRow) {
                    existingRow.innerHTML = `
                        <td>${attendance.id}</td>
                        <td>${userName}</td>
                        <td>${userRole}</td>
                        <td>${formattedDate}</td>
                        <td>${attendance.in2}</td>
                        <td>${attendance.out2}</td>
                        <td>${attendance.worked_hours}</td>
                    `;
                } else {
                    let newRow = `
                        <tr id="row_${attendance.id}">
                            <td>${attendance.id}</td>
                            <td>${userName}</td>
                            <td>${userRole}</td>
                            <td>${formattedDate}</td>
                            <td>${attendance.in}</td>
                            <td>${attendance.out}</td>
                            <td>${attendance.worked_hours}</td>
                        </tr>
                    `;
                    document.querySelector('#attendance tbody').insertAdjacentHTML('beforeend', newRow);
                }
                alert('Check-out time recorded successfully.');

                const checkInButton = document.getElementById('checkOutButton');
                checkInButton.disabled = true;
                checkInButton.style.opacity = '0.5'; 
                checkInButton.style.cursor = 'not-allowed';

                clearInterval(timeInterval);
                document.getElementById('timeDisplay').textContent = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
                localStorage.removeItem(storageKey); 
                startTime = null;
                timeInterval = setInterval(updateTime, 1000);
            } else {
                alert('Failed to record check-out time.');
            }
        }).catch(error => console.error('Error:', error));
    }

    function initializeTime() {
        const storedStartTime = localStorage.getItem(storageKey);
        if (storedStartTime) {
            startTime = new Date(storedStartTime);
        }
    }

    document.getElementById('checkInButton').addEventListener('click', recordTime);
    document.getElementById('checkOutButton').addEventListener('click', recordCheckOut);

    initializeTime();
    updateTime(); 
    timeInterval = setInterval(updateTime, 1000);
</script>

@endpush