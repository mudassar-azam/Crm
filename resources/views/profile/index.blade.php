@extends("layouts.app")
@section('content')
<style>
main {
    margin-top: 2em !important;
}

.popup-custom {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    align-items: center;
    justify-content: center;
    z-index: 9999 !important;
}


.popup-content-custom {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    width: 25em;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.calender-card-header-custom {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-around;
    padding: 1em 1em 0.7em 1em;
    border-bottom: 1px solid lightgray;
}

.calender-card-header-custom h3 {
    flex: 1;
    font-size: 1em;
    font-weight: 600;
}

.calender-card-header-custom button {
    font-size: 1.2em;
    font-weight: 500;
    background-color: transparent;
    border: none;
}

.request-type-custom {
    margin-top: 1em;
    margin-bottom: 0.5em;
    width: 100%;
}

.label-custom {
    color: #0A1629;
    font-size: 14px;
    font-weight: 500;
    padding: 0 1.4em;
}

.form-group-custom {
    display: flex;
    gap: 1em;
    padding: 0.5em 2em;
}

.radio-input-custom {
    display: none;
}

form {
    box-shadow: none !important;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.radio-label-custom {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    font-size: 12px;
    cursor: pointer;
    border: 1px solid #e4e1e1;
    padding: 0.5em;
    border-radius: 5px;
    font-weight: 500;
}

.radio-button-custom {
    height: 1rem;
    width: 1rem;
    border: 2px solid #206d88;
    border-radius: 50%;
    display: inline-block;
    position: relative;
    transform: translateY(-2px);
    margin-top: 3px;
}

.radio-button-custom::after {
    content: "";
    display: block;
    height: 0.5rem;
    width: 0.5rem;
    position: absolute;
    border-radius: 50%;
    top: 50%;
    left: 50%;
    transition: opacity 0.1s;
    transform: translate(-50%, -50%);
    background-color: #206d88;
    opacity: 0;
}

.radio-input-custom:checked+.radio-label-custom .radio-button-custom::after {
    opacity: 1;
}

.input-container-custom {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 1em 0 1.5em;
    position: relative;
}

.textarea-custom {
    width: 100%;
    height: 5em;
    border: 1px solid lightgray;
    border-radius: 0.7em;
    font-size: 10px;
}

.buttons-custom {
    padding: 0 2em;
}

.cancel-btn-custom {
    width: 9em;
    height: 3em;
    border-radius: 20px;
    font-size: 10px;
    color: red;
    font-weight: 500;
    border: none;
    background-color: white;
    text-align: center;
    transition: 0.2s ease-in-out;
    padding: 0.7em;
    margin-left: 10px;
}

.cancel-btn-custom:hover {
    background-color: #206d88;
    color: white;
}

.submit-btn-custom {
    width: 8em;
    height: 3em;
    border-radius: 20px;
    font-size: 10px;
    color: white;
    font-weight: 500;
    border: none;
    background-color: #206d88;
    text-align: center;
    transition: 0.2s ease-in-out;
    margin-left: 10px;
}

.submit-btn-custom:hover {
    background-color: #e94d65;
}

input[type="time"] {
    border: 1px solid #ccc;
    padding: 0.5em;
    padding-left: 2.4em;
    font-size: 0.7em;
    color: white;
    position: relative;
    width: 2em;
    background-color: #206d88;
    border-radius: 5px;
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
}

input[type="time"]::-webkit-calendar-picker-indicator {
    background: url('../../Asserts/logo/time-clock.png') no-repeat center;
    background-size: contain;
    cursor: pointer;
    position: absolute;
    left: 0;
    top: 0.5em;
}

input[type="time"]::placeholder {
    visibility: hidden;
    position: absolute;
}

input[type="time"]:focus {
    outline: none;
    border: none;
}

.calendar-popup-custom {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.calendar-container-custom {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 1em;
    padding: 20px;
    width: 60em;
    max-width: 90%;
    max-height: 90%;
    overflow: auto;
    position: relative;
    margin-bottom: 1em;
}

.calendar-header-custom {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.calendar-current-date-custom {
    font-size: 1.2em;
    font-weight: 600;
    color: black;
    margin: 0;
    flex: 1;
}

.calendar-navigation-custom {
    width: 25%;
}

.calendar-navigation-custom {
    display: flex;
    gap: 0.5em;
}

.calendar-body-custom {
    margin-top: 1em;
}

.calendar-weekdays-custom,
.calendar-dates-custom {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 0.5em;
    list-style: none;
    padding: 0;
    margin: 0;
    background-color: white;
}

.calendar-weekdays-custom {
    border-radius: 5px;
    margin-bottom: 10px;
}

.calendar-weekdays-custom li {
    text-align: center;
    font-weight: 600;
    color: #7D8592;
    background-color: #F4F9FD !important;

}

.calendar-dates-custom li {
    text-align: center;
    padding: 0.3em;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.calendar-dates-custom li:hover {
    background-color: #206d88;
    color: white;
}



.has-event-custom {
    position: relative;
}

.active-custom {
    background-color: #e94d65;
    color: white;
}

.has-event-custom::after {
    content: '';
    position: absolute;
    bottom: 2px;
    left: 50%;
    transform: translateX(-50%);
    width: 5px;
    height: 5px;
    background-color: red;
    border-radius: 50%;
}

.right-custom,
.left-custom {
    width: 4em;
    height: 1.4em;
    transition: 0.3s ease;
    border-radius: 1em;
    padding: 0.2em;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
}

.left-custom {
    background-color: white;
    border: 1px solid #206d88;
}

.left-custom:hover {
    background-color: #206d88;
    ;
}

.right-custom {
    background-color: #e94d65;
}

.right-custom:hover {
    border: 1px solid #e94d65;
    background-color: white;
}

#leaves {
    table-layout: fixed;
    width: 100%;
}

#leaves thead tr th,
#leaves tbody tr td {
    width: 10em;
    white-space: nowrap;
    overflow: hidden;
    font-size: 12px;
    border-bottom: 1px solid lightgray;
    text-align: center;
}

#leaves tbody tr td {
    overflow-x: auto;
    max-width: 10em;
}

#leaves tbody tr td::-webkit-scrollbar {
    width: 3px;
    height: 0px;
}

#leaves tbody tr td::-webkit-scrollbar-track {
    background: none;
}

#leaves tbody tr td::-webkit-scrollbar-thumb {
    background: #e94d65;
}

#leaves tbody tr td::-webkit-scrollbar-thumb:hover {
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

.calendar-dates-custom li.selected {
    background-color: #2D6D8B;
    color: white;
    border-radius: 50%;
    cursor: pointer;
}

input[type='number']::-webkit-outer-spin-button,
input[type='number']::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type='number'] {
    -moz-appearance: textfield;
}
</style>
<main>
    <div class="profile-container">
        <div id="alert-danger" class="alert alert-danger" style="display: none;">
            <ul id="error-list"></ul>
        </div>
        <div id="alert-success" class="alert alert-success" style="display: none;"></div>
        <sidebar>
            <div class="profile-header">
                <div class="image">
                    <div class="percent">
                        <div class="num">
                            <img src="{{asset('Asserts/General/user.png')}}" id="percentage-display-1">
                        </div>
                    </div>

                    <button>
                        <img src="{{asset('Asserts/General/filter.png')}}">
                    </button>

                </div>
                <div class="name">
                    <h5>
                        {{$user->user_name}}
                    </h5>
                    <h6>
                        {{$user->role->name}}
                    </h6>
                </div>
            </div>
            <form style="box-shadow: none;">
                <h5 class="main-heading">Main Info</h5>

                <div class="approved-activities" style="border-bottom: none; padding: 0;">

                    <div class="position">
                        <label class="label">Position</label>
                        <input style="cursor: pointer;" class="input" type="text" value="{{$user->role->name}}"
                            readonly>
                    </div>
                    <div class="company">
                        <label class="label">Company</label>
                        <input style="cursor: pointer;" class="input" type="text" placeholder="Chase IT Global"
                            readonly>
                    </div>
                    <div class="Location">
                        <label class="label">Location</label>
                        <div class="row input-logo">
                            <input style="cursor: pointer;" type="text" class="input" placeholder="N/A" type="text"
                                readonly>
                        </div>
                    </div>
                    <div class="dob">
                        <label class="label">Birthday Date</label>
                        <div class="row input-logo">
                            <input style="cursor: pointer;" type="text" class="input" type="text" placeholder="N/A"
                                readonly>
                        </div>
                    </div>
                </div>

            </form>

            <form style="box-shadow: none;">

                <h5 class="main-heading" style="margin: 0.5em 0;">Contact Info</h5>

                <div class="approved-activities" style="border-bottom: none; padding: 0;">

                    <div class="Email">
                        <label class="label">E-mail</label>
                        <input style="cursor: pointer;" class="input" type="email" value="{{$user->email}}" readonly>
                    </div>
                    <div class="Number">
                        <label class="label">Mobile Number</label>
                        <input style="cursor: pointer;" class="input" type="number" placeholder="N/A" readonly>
                    </div>
                    <div class="Skype">
                        <label class="label">Skype</label>
                        <input style="cursor: pointer;" type="text" class="input" placeholder="N/A" type="text"
                            readonly>
                    </div>

                </div>

            </form>
        </sidebar>
        <main>
            @if(Auth::user()->role->name != 'Member' && Auth::user()->role->name != 'BD Manager')
                <div class="container-header">
                    <div class="heading">
                        <h3>My Team</h3>
                        <p>Member Working With Me</p>
                    </div>
                </div>

                <div class="team-container">
                    @foreach ($team as $member)
                    <div class="emplyee">
                        <div class="percent">
                            <div class="num">
                                <img src="{{ asset('Asserts/General/user.png') }}" id="percentage-display-2">
                            </div>
                        </div>
                        <h4>
                            {{$member->user_name}}
                        </h4>
                        <h6>
                            {{$member->role->name ?? 'N/A'}}
                        </h6>
                        @if($member->role->name == 'Recruitment Manager' || $member->role_type == 'RecmLead' || $member->role_type == 'RecmMember')
                            @php
                                $userId = $member->id;
                                $totalResourceCount = \App\Models\Resource::where('user_id', $userId)->count();
                                $currentYear = date('Y');
                                $currentMonth = date('m');
                                $currentMonthResourceCount = \App\Models\Resource::where('user_id', $userId)->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->count();
                                $completeTaskCount = \App\Models\Task::where('assign_to', $userId)->where('task_completion_status', 'complete')->count();
                            @endphp
                            <div>
                                @if(hasAdminRole() || OperationRole() || OnlyRecruitmentRole() )
                                    <div>
                                        <h4>Total Resources:{{ $totalResourceCount }}</h4>
                                    </div>
                                    <div>
                                        <h4>Resources This Month:{{ $currentMonthResourceCount }}</h4>
                                    </div>
                                @endif
                                <div>
                                    <h4>Task Done:{{ $completeTaskCount }}</h4>
                                </div>
                            </div>
                        @endif    
                    </div>
                    @endforeach
                </div>
            @elseif(Auth::user()->role_type == 'RecmMember')
                <div class="team-container">
                    <div class="emplyee">
                        <div class="percent">
                            <div class="num">
                                <img src="{{ asset('Asserts/General/user.png') }}" id="percentage-display-2">
                            </div>
                        </div>
                        <h4>
                            {{Auth::user()->user_name}}
                        </h4>
                        <h6>
                            {{Auth::user()->role_type ?? 'N/A'}}
                        </h6>
                        @php
                            $userId = Auth::user()->id;
                            $totalResourceCount = \App\Models\Resource::where('user_id', $userId)->count();
                            $currentYear = date('Y');
                            $currentMonth = date('m');
                            $currentMonthResourceCount = \App\Models\Resource::where('user_id', $userId)->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->count();
                            $completeTaskCount = \App\Models\Task::where('assign_to', $userId)->where('task_completion_status', 'complete')->count();
                        @endphp
                        <div>
                            @if(hasAdminRole() || OperationRole() || OnlyRecruitmentRole() )
                                <div>
                                    <h4>Total Resources:{{ $totalResourceCount }}</h4>
                                </div>
                                <div>
                                    <h4>Resources This Month:{{ $currentMonthResourceCount }}</h4>
                                </div>
                            @endif
                            <div>
                                <h4>Task Done:{{ $completeTaskCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="container-header">
                <div class="heading">
                    <h3>My Leaves</h3>
                    <p>Request for leave and tracker</p>
                </div>
                <button class="request" id="open-popup-custom">
                    <img src="{{asset('Asserts/logo/add-request.png')}}">
                    Add Leave
                </button>
            </div>

            <div class="team-container">
                <div class="emplyee leaves">
                    <div class="emploee-name">
                        <h4 style="line-height: 1.5em;">
                            Vacation
                        </h4>
                        <h6 style="color: #91929E;">
                            <b><span style="font-size: 0.9rem;">{{$vacation}} - Available</span></b>
                        </h6>

                    </div>
                </div>
                <div class="emplyee leaves">
                    <div class="emploee-name">
                        <h4 style="line-height: 1.5em;">
                            Sick leave
                        </h4>
                        <h6 style="color: #91929E;">
                            <b><span style="font-size: 0.9rem;">{{$sick_leave}} - Available</span></b>
                        </h6>
                    </div>
                </div>
            </div>
            @php
                $totalLeadAndMemberIdsArray = $totalLeadAndMemberIds->toArray();
            @endphp
            <div class="leave-container">
                <div class="data-table-container scrollable-table" style="padding-left: 0; border-radius: 0;">
                    <table id="leaves" class="table table-sm  table-hover table-bordered" style="width: 79vw;">
                        <thead>
                            <tr class="table-header">
                                <th>Delete</th>
                                @if(Auth::user()->role->name != 'Member' && Auth::user()->role->name != 'BD Manager')
                                    <th>Leave Of</th>

                                @endif    
                                <th>Type</th>
                                <th>Duration</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                @if(AdminOrManagers())
                                <th>Approve</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaves as $leave)
                            <tr id="row_{{ $leave->id }}">
                                @if(hasAdminRole())
                                    <td>
                                        <button style=" border: #E94D65 !important;  background-color: #E94D65 !important;"
                                            data-id="{{ $leave->id }}"
                                            class="rounded-circle btn btn-primary btn-sm delete-leave" type="button">
                                            <img src="{{asset('Asserts/logo/delete.png')}}" />
                                        </button>
                                    </td>
                                @elseif(ManagersExceptAdminAndBd())
                                    @if(in_array($leave->user_id, $totalLeadAndMemberIdsArray))    
                                        <td>
                                            <button style=" border: #E94D65 !important;  background-color: #E94D65 !important;"
                                                data-id="{{ $leave->id }}"
                                                class="rounded-circle btn btn-primary btn-sm delete-leave" type="button">
                                                <img src="{{asset('Asserts/logo/delete.png')}}" />
                                            </button>
                                        </td>
                                    @else 
                                        <td>-</td>   
                                    @endif
                                @else
                                    <td>-</td>
                                @endif    
                                @if(Auth::user()->role->name != 'Member' && Auth::user()->role->name != 'BD Manager')
                                    <td>{{ $leave->user->user_name ?? 'N/A' }}</td>
                                @endif  
                                <td>{{ $leave->type ?? 'N/A' }}</td>
                                <td>{{ $leave->duration ?? 'N/A' }}</td>
                                <td>{{ $leave->start_date ?? 'N/A' }}</td>
                                <td>{{ $leave->end_date ?? 'N/A' }}</td>
                                <td>{{ $leave->status ?? 'N/A' }}</td>
                                @if(AdminOrManagers())
                                    @if($leave->status == 'Pending')
                                    <td>
                                        <button data-id="{{ $leave->id }}" type="button"
                                            class="btn btn-sm approve conform-table" style="margin-bottom: 1px;">
                                            Approve
                                        </button>
                                    </td>
                                    @else
                                    <td>
                                        <button type="button" class="btn btn-sm  conform-table" style="margin-bottom: 1px;"
                                            disabled>
                                            Approved
                                        </button>
                                    </td>
                                    @endif
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="popup-custom" class="popup-custom">
                <div class="popup-content-custom">
                    <header class="calender-card-header-custom">
                        <h3>Add Leave</h3>
                        <button class="close-btn-custom">x</button>
                    </header>
                    <form class="addLeaveForm" action="{{route('leave.store')}}" method="post">
                        @csrf
                        <div class="request-type-custom">
                            <label class="label-custom" style="margin-left: 1em;">Leave Type</label>

                            <div class="form-group-custom">
                                <div class="radio-group-custom">
                                    <input id="vacation-custom" type="radio" class="radio-input-custom" name="type"
                                        value="Vacation" />
                                    <label for="vacation-custom" class="radio-label-custom">
                                        <span class="radio-button-custom"></span>
                                        <span class="radio-label-text-custom">Vacation</span>
                                    </label>
                                </div>

                                <div class="radio-group-custom">
                                    <input id="sick-custom" type="radio" class="radio-input-custom" name="type"
                                        value="Sick Leave" />
                                    <label for="sick-custom" class="radio-label-custom">
                                        <span class="radio-button-custom"></span>
                                        Sick Leave
                                    </label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="start_date" id="start-date-custom">
                        <input type="hidden" name="end_date" id="end-date-custom">
                        <div class="calendar-container-custom">
                            <header class="calendar-header-custom">
                                <p class="calendar-current-date-custom"></p>
                                <div class="calendar-navigation-custom">
                                    <span id="calendar-prev-custom" class="left-custom">
                                        <img src="{{asset('Asserts/logo/left-arrow-main.png')}}" alt="Previous">
                                    </span>
                                    <span id="calendar-next-custom" class="right-custom">
                                        <img src="{{asset('Asserts/logo/right-arrow-main.png')}}" alt="Next">
                                    </span>
                                </div>
                            </header>
                            <div class="calendar-body-custom">
                                <ul class="calendar-weekdays-custom">
                                    <li>Sun</li>
                                    <li>Mon</li>
                                    <li>Tue</li>
                                    <li>Wed</li>
                                    <li>Thu</li>
                                    <li>Fri</li>
                                    <li>Sat</li>
                                </ul>
                                <ul class="calendar-dates-custom"></ul>
                            </div>
                        </div>
                        <div class="input-container-custom">
                            <div class="box-custom">
                                <label for="from-custom" class="label-custom">Add Comment</label>
                                <textarea class="textarea-custom" name="comment"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="submit-btn-custom">Submit</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</main>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- kashan script  -->
<script>
    let dateCustom = new Date();
    let yearCustom = dateCustom.getFullYear();
    let monthCustom = dateCustom.getMonth();

    let startDateCustom = null;
    let endDateCustom = null;

    const startDateInputCustom = document.getElementById("start-date-custom");
    const endDateInputCustom = document.getElementById("end-date-custom");

    const openPopupButtonCustom = document.getElementById("open-popup-custom");
    const popupCustom = document.getElementById("popup-custom");

    openPopupButtonCustom.addEventListener("click", () => {
        popupCustom.style.display = "flex";
    });

    const closeBtnCustom = document.querySelector(".close-btn-custom");
    closeBtnCustom.addEventListener("click", () => {
        popupCustom.style.display = "none";
    });

    const dayCustom = document.querySelector(".calendar-dates-custom");
    const currdateCustom = document.querySelector(".calendar-current-date-custom");
    const prenexIconsCustom = document.querySelectorAll(".calendar-navigation-custom span");

    const monthsCustom = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    const manipulateCustom = () => {
        let dayoneCustom = new Date(yearCustom, monthCustom, 1).getDay();
        let lastdateCustom = new Date(yearCustom, monthCustom + 1, 0).getDate();
        let dayendCustom = new Date(yearCustom, monthCustom, lastdateCustom).getDay();
        let monthlastdateCustom = new Date(yearCustom, monthCustom, 0).getDate();

        let litCustom = "";

        for (let i = dayoneCustom; i > 0; i--) {
            litCustom += `<li class="inactive-custom">${monthlastdateCustom - i + 1}</li>`;
        }

        for (let i = 1; i <= lastdateCustom; i++) {
            let isTodayCustom = i === dateCustom.getDate() && monthCustom === new Date().getMonth() && yearCustom ===
                new Date().getFullYear() ? "active-custom" : "";

            let isSelectedStartCustom = startDateCustom && i === startDateCustom.getDate() && monthCustom ===
                startDateCustom.getMonth() && yearCustom === startDateCustom.getFullYear() ? "selected" : "";
            let isSelectedEndCustom = endDateCustom && i === endDateCustom.getDate() && monthCustom === endDateCustom
                .getMonth() && yearCustom === endDateCustom.getFullYear() ? "selected" : "";

            // Only highlight start and end dates
            litCustom += `<li class="${isTodayCustom} ${isSelectedStartCustom} ${isSelectedEndCustom}" data-day="${i}">${i}</li>`;
        }

        for (let i = dayendCustom; i < 6; i++) {
            litCustom += `<li class="inactive-custom">${i - dayendCustom + 1}</li>`;
        }

        currdateCustom.innerText = `${monthsCustom[monthCustom]} ${yearCustom}`;
        dayCustom.innerHTML = litCustom;

        document.querySelectorAll('.calendar-dates-custom li').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.calendar-dates-custom li').forEach(li => li.classList
                    .remove('selected'));
                this.classList.add('selected');

                let selectedDay = parseInt(this.getAttribute('data-day'));
                let selectedDate = new Date(yearCustom, monthCustom, selectedDay, 12, 0, 0);

                if (!startDateCustom || (startDateCustom && endDateCustom)) {
                    startDateCustom = selectedDate;
                    endDateCustom = null;
                } else if (startDateCustom && !endDateCustom) {
                    if (selectedDate >= startDateCustom) {
                        endDateCustom = selectedDate;
                    } else {
                        endDateCustom = startDateCustom;
                        startDateCustom = selectedDate;
                    }
                }

                document.getElementById('start-date-custom').value = startDateCustom ? startDateCustom.toISOString().split('T')[0] : '';
                document.getElementById('end-date-custom').value = endDateCustom ? endDateCustom.toISOString().split('T')[0] : '';

                manipulateCustom();
            });
        });
    };

    manipulateCustom();

    prenexIconsCustom.forEach(icon => {
        icon.addEventListener("click", () => {
            monthCustom = icon.id === "calendar-prev-custom" ? monthCustom - 1 : monthCustom + 1;

            if (monthCustom < 0 || monthCustom > 11) {
                dateCustom = new Date(yearCustom, monthCustom, new Date().getDate());
                yearCustom = dateCustom.getFullYear();
                monthCustom = dateCustom.getMonth();
            } else {
                dateCustom = new Date();
            }

            manipulateCustom();
        });
    });

</script>
<!-- to add and delete leave  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myForm = document.querySelector('.addLeaveForm');
        var errorAlert = document.getElementById('alert-danger');
        var errorList = document.getElementById('error-list');
        var successAlert = document.getElementById('alert-success');
        myForm.addEventListener('submit', function(event) {
            event.preventDefault();
            var formElements = myForm.querySelectorAll('input, select, textarea');
            formElements.forEach(function(element) {
                element.style.border = '';
                if (element.type === 'file') {
                    element.classList.remove('file-not-valid');
                }
            });
            var formData = new FormData(myForm);
            fetch(myForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                })
                .then(response => response.json())
                .then(data => {

                    if (data.success) {
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
                        let leave = data.leave;
                        let userName = data.userName;
                        let userRole = data.userRole;
                        let newRow = `
                            <tr id="row_${leave.id}">
                                <td>-</td>
                                <td>${userName ?? 'N/A'}</td>
                                <td>${leave.type ?? 'N/A'}</td>
                                <td>${leave.duration ?? 'N/A'}</td>
                                <td>${leave.start_date ?? 'N/A'}</td>
                                <td>${leave.end_date ?? 'N/A'}</td>
                                <td>${leave.status ?? 'N/A'}</td>
                                ${userRole === 'Admin' ? `
                                <td>
                                    <button data-id="${leave.id}" type="button" class="btn btn-sm approve conform-table" style="margin-bottom: 1px;">
                                        Approve
                                    </button>
                                </td>
                                ` : ''}
                            </tr>
                        `;

                        document.querySelector('#leaves tbody').insertAdjacentHTML('beforeend', newRow);
                        const popupCustom = document.getElementById("popup-custom");
                        popupCustom.style.display = "none";
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
    });
    
    $(document).on('click', '.delete-leave', function() {
            var leaveId = $(this).data('id');
            if (confirm('Are you sure you want to delete this?')) {
                $.ajax({
                    url: '/destroyLeave/' + leaveId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#row_' + leaveId).remove();
                        alert('Deleted successfully');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
</script>
<!-- to approve  -->
<script>
    $(document).ready(function() {
        $('.approve').click(function() {
            var leaveId = $(this).data('id');
            var button = $(this);
            if (confirm('Are you sure you want to approve this leave?')) {
                $.ajax({
                    url: '/approveLeave/' + leaveId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('Leave approved  successfully');
                        button.prop('disabled', true);
                        var approvedLeaveId = response.leaveId;
                        var rowId = 'row_' + approvedLeaveId;
                        var tableRow = document.getElementById(rowId);
                        if (tableRow) {
                            tableRow.cells[5].textContent = 'Approved';
                            tableRow.cells[6].textContent = 'Approved';
                        }
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