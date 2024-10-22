@extends('layouts.app')
@section('content')
<style>
    /* vacation pending */
    .attendance-green-label:before {
        background-color: #f5b0b9 !important;
        border: 2.5px solid #f28a97 !important;
    }

    /* vacation approved */
    .attendance-lightcoral-label:before {
        background-color: #e94d65 !important;
    }

    /* sick leave approved */
    .attendance-blue-label:before {
        background-color: #15c0e6 !important;
    }

    /* sick leave pending */
    .attendance-lightblue-label:before {
        background-color: #b5e6f4 !important;
        border: 2.5px solid #8cdcf0 !important;
    }

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

    .attendence-calender-container {
        background-color: white;
        border-radius: 1em;
        overflow: auto;
        padding-right: 0.5em;
    }

    .attendence-calender-header {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2em;
    }

    .nav-button {
        width: 2em;
        height: 2em;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background-color: transparent;
        padding: 0;
    }

    .attendence-info {
        font-size: 12px;
        color: #206d88;
        font-weight: 600;
    }

    .attendence-calender-container table {
        margin: 0;
        width: 100%;
    }

    .attendence-calender-container table thead tr {
        height: 3em;
        border-bottom: 1px solid lightgray;
    }

    .attendence-calender-dates,
    .attendence-calender-checkboxes {
        color: #7d8593;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none !important;
        font-size: 11px;
        font-weight: 500;
    }

    table.dataTable thead th,
    table.dataTable thead td {
        padding: 0 !important;
        text-align: center;
    }

    tr :nth-child(1) {
        padding: 0 !important;
    }

    tr :nth-child(2) {
        text-wrap: nowrap;
    }

    td {
        text-align: center;
        border-bottom: 1px solid lightgray;
    }

    .attendence-calender-container table tbody tr td input[type="checkbox"] {
        display: none;
    }

    .attendence-calender-container table tbody tr td input[type="checkbox"]+label {
        display: inline-block;
        width: 1.7em;
        height: 2.6em;
        border-radius: 4px;
        background-color: #f4f9fd;
        cursor: pointer;
        background-color: transparent;
        position: relative;
        padding: 0;
        margin: 0;
    }

    .attendence-calender-container table tbody tr td input[type="checkbox"]+label:before {
        content: "";
        display: block;
        width: 100%;
        height: 100%;
        border-radius: 4px;
        transform: scale(0);
        transition: transform 0.2s ease-in-out;
        margin: 0;
    }

    .attendence-calender-container table tbody tr td input[type="checkbox"]:checked+label:before {
        transform: scale(1);
    }

    .user-information {
        padding: 10px 4px;
        font-size: 12px;
    }

    .attendence-calender-container table thead :nth-child(1),
    .attendence-calender-container table thead :nth-child(2) {
        border: none;
        border-right: 1px solid lightgray;
        border-bottom: 1px solid lightgray;
    }

    .attendence-calender-container table tbody tr :nth-child(1),
    .attendence-calender-container table tbody tr :nth-child(2) {
        border: none;
        border-right: 1px solid lightgray;
        border-bottom: 1px solid lightgray;
    }

    .attendence-calender-header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        height: 4em;
        border-bottom: 1px solid lightgray;
        padding: 0.3em 0.5em;
    }

    .attendence-calender-header-container .main-header h3 {
        font-weight: 600;
        font-size: 18px;
    }

    .attendence-footer .sick-leave {
        width: 22%;
    }

    .attendence-footer .sick-leave h6 {
        font-size: 11px;
        font-weight: 500;
        color: #7D8592;
    }

    .attendence-footer {
        display: flex;
        gap: 1em;
        padding: 0.7em;
    }

    .condition {
        display: flex;
        align-items: center;
        justify-content: start;
    }

    .condition .aproved {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: start;
        font-size: 12px;
    }

    .attendence-calender-container::-webkit-scrollbar {
        width: 0px !important;
        height: 3px;
    }

    .attendence-calender-container::-webkit-scrollbar-track {
        background: none !important;
    }

    .attendence-calender-container::-webkit-scrollbar-thumb {
        background: #e94d65 !important;
    }

    .attendence-calender-container::-webkit-scrollbar-thumb:hover {
        background: #2d6d8b !important;
        width: 7px !important;
    }

    #attendance-table_length,
    #attendance-table_info {
        display: none;
    }


    main {
        margin: 0 !important;
    }

    @media (max-width: 500px) {
        main {
            width: 55%;
        }
    }
</style>
<main>
    <div class="addtask-container-overveiw">
        <div class="attendence-calender-header-container">
            <div class="record">
                <h3>Employee leave Status</h3>
                <p>Control your dashboard</p>
            </div>

            <div class="attendence-calender-header">
                <button class="nav-button" onclick="changeMonth(-1)">
                    <img src="{{ asset('Asserts/logo/back.png') }}">
                </button>
                <span id="monthYearDisplay"></span>


                <button class="nav-button" onclick="changeMonth(1)">
                    <img src="{{ asset('Asserts/logo/go.png') }}">
                </button>
            </div>

        </div>

        <div class="attendence-calender-container">
            <table id="attendance-table"></table>
        </div>
        <div class="attendence-footer">
            <div class="sick-leave">
                <h6>Sick Leave</h6>
                <div class="condition">
                    <div class="aproved">
                        <img src="{{ asset('Asserts/General/sickleave-Approved.png') }}">
                        Approved
                    </div>
                    <div class="aproved">
                        <img src="{{ asset('Asserts/General/sickleave-pending.png') }}">
                        Pending
                    </div>
                </div>
            </div>
            <div class="sick-leave">
                <h6>Vacation</h6>
                <div class="condition">
                    <div class="aproved">
                        <img src="{{ asset('Asserts/General/vacation-approved.png') }}">
                        Approved
                    </div>
                    <div class="aproved">
                        <img src="{{ asset('Asserts/General/vication-pending.png') }}">
                        Pending
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment-timezone@0.5.34/moment-timezone-with-data.min.js"></script>

    <script>
        let currentAttendanceMonth = new Date().getUTCMonth();
        let currentAttendanceYear = new Date().getUTCFullYear();
        let students = []; 

        $(document).ready(function() {
            const table = $('#attendance-table').DataTable({
                "searching": false,
                "dom": 'lfrtip',
                "pageLength": 50,
                "lengthMenu": false,
                "paging": false,
                "buttons": [],
                "columns": [{
                        "title": "ID"
                    },
                    {
                        "title": "Employee"
                    }
                ]
            });

            function fetchStudentsAndLeaves() {
                fetch('/students', {
                        method: 'GET',
                        headers: {
                            'Authorization': 'Bearer YOUR_TOKEN'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        students = data; 
                        table.clear();
                        students.forEach(student => {
                            table.row.add([student.rollNo, student.name]);
                        });
                        table.draw();

                        fetchLeavesAndGenerateTable();
                    })
                    .catch(error => console.error('Error fetching students:', error));
            }

            function fetchLeavesAndGenerateTable() {
                const url =
                    `/leaves?month=${currentAttendanceMonth + 1}&year=${currentAttendanceYear}`; 

                fetch(url, {
                        method: 'GET',
                        headers: {
                            'Authorization': 'Bearer YOUR_TOKEN'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text(); 
                    })
                    .then(text => {
                        try {
                            const data = JSON.parse(text); 
                            const leaves = data || [];
                            const startDate = new Date(Date.UTC(currentAttendanceYear, currentAttendanceMonth,
                                1));
                            const endDate = new Date(Date.UTC(currentAttendanceYear, currentAttendanceMonth + 1,
                                0));
                            generateTable(students, leaves, startDate, endDate); 
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                        }
                    })
                    .catch(error => console.error('Error fetching leave data:', error));
            }

           
            function getShortDayName(date) {
                return date.toLocaleDateString("en-US", {
                    weekday: "short"
                });
            }

            
            function generateTable(students, leaves, startDate, endDate) {
                const utcStartDate = moment.utc(startDate);
                const utcEndDate = moment.utc(endDate);

                const attendanceTable = document.getElementById('attendance-table');

                
                attendanceTable.querySelector("thead tr").innerHTML = `
                <th>ID</th>
                <th>Employee</th>
            `;
                attendanceTable.querySelector("tbody").innerHTML = ""; 

                const daysInMonth = utcEndDate.date();

                
                for (let day = 1; day <= daysInMonth; day++) {
                    const th = document.createElement("th");
                    th.classList.add("attendence-calender-dates-container");

                    let date = utcStartDate.clone().date(day);
                    let dateElement = document.createElement("div");
                    dateElement.classList.add("attendence-calender-dates");
                    dateElement.innerText = `${day}\n${getShortDayName(date.toDate())}`;

                    th.appendChild(dateElement);
                    attendanceTable.querySelector("thead tr").appendChild(th);
                }

                
                students.forEach((student) => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                    <td class="user-information">${student.rollNo}</td>
                    <td class="user-information">${student.name}</td>
                `;

                    for (let day = 1; day <= daysInMonth; day++) {
                        const td = document.createElement("td");

                        let dateElement = document.createElement("div");
                        dateElement.classList.add("attendence-calender-checkboxes");

                        const currentDayDate = utcStartDate.clone().date(day);
                        const checkboxId = `attendance-${student.rollNo}-${day}`;

                        const checkbox = document.createElement("input");
                        checkbox.type = "checkbox";
                        checkbox.id = checkboxId;
                        checkbox.name = checkboxId;
                        checkbox.classList.add("attendance-checkbox");
                        checkbox.disabled = true; 
                        const isLeaveDay = leaves.some(leave => {
                            const leaveStartDate = moment.utc(leave.start_date);
                            const leaveEndDate = moment.utc(leave.end_date);
                            return leave.user_id === student.rollNo &&
                                leaveStartDate.isSameOrBefore(currentDayDate) &&
                                leaveEndDate.isSameOrAfter(currentDayDate);
                        });

                        if (isLeaveDay) {
                            checkbox.checked = true; 
                        }

                        const label = document.createElement("label");
                        label.setAttribute("for", checkboxId);
                        label.classList.add("attendance-label");

                        dateElement.appendChild(checkbox);
                        dateElement.appendChild(label);
                        td.appendChild(dateElement);
                        tr.appendChild(td);
                    }

                    attendanceTable.querySelector("tbody").appendChild(tr);
                });

                leaves.forEach(leave => {
                    const leaveStartDate = moment.utc(leave.start_date);
                    const leaveEndDate = moment.utc(leave.end_date);
                    const userId = leave.user_id;
                    const leaveType = leave.type;
                    const leaveStatus = leave.status;

                    if (leaveStartDate.isSameOrBefore(utcEndDate) && leaveEndDate.isSameOrAfter(
                            utcStartDate)) {
                        const actualEndDate = leaveEndDate.isAfter(utcEndDate) ? utcEndDate : leaveEndDate;

                        for (let day = leaveStartDate.date(); day <= actualEndDate.date(); day++) {
                            const checkboxId = `attendance-${userId}-${day}`;
                            const checkbox = document.getElementById(checkboxId);
                            if (checkbox) {
                                const label = document.querySelector(`label[for="${checkboxId}"]`);

                                if (leaveType === 'Sick Leave') {
                                    
                                    if (leaveStatus === 'Pending') {    
                                        label.classList.add('attendance-green-label');
                                    } else if (leaveStatus === 'Approved') {
                                        label.classList.add('attendance-lightcoral-label');
                                    }
                                } else if (leaveType === 'Vacation') {
                                    if (leaveStatus === 'Pending') {
                                        label.classList.add('attendance-lightblue-label');
                                    } else if (leaveStatus === 'Approved') {
                                        label.classList.add('attendance-blue-label');
                                    }
                                }
                            }
                        }
                    }
                });

                document.getElementById('monthYearDisplay').innerText =
                    `${utcStartDate.format('MMMM YYYY')}`;
            }

            window.changeMonth = function(delta) {
                currentAttendanceMonth += delta;
                if (currentAttendanceMonth > 11) {
                    currentAttendanceMonth = 0;
                    currentAttendanceYear++;
                } else if (currentAttendanceMonth < 0) {
                    currentAttendanceMonth = 11;
                    currentAttendanceYear--;
                }
                fetchLeavesAndGenerateTable(); 
            };
            fetchStudentsAndLeaves();
        });
    </script>
@endpush