@extends('layouts.app')
@section('content')
<style>
    input[type='number']::-webkit-outer-spin-button,
    input[type='number']::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type='number'] {
        -moz-appearance: textfield;
    }
    .filled-input {
        border: 2px solid green !important;
    }

    .error-input {
        border: 2px solid red !important;
    }

    .tasks {
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .calender-tasks {
        padding: 0 !important;
        margin: 0 !important;
        background-color: transparent;
    }

    .event-item {
        margin-bottom: 5px;
        border: 1px solid #ccc;
        background-color: #F4F9FD;
    }

    .more-events {
        position: absolute;
        top: 5px;
        right: 5px;
        cursor: pointer;
        color: blue;
        background-color: #fff;
        padding: 2px 5px;
        border: 1px solid #ccc;
    }

    .container {
        box-shadow: none !important;
    }

    body {
        grid-auto-rows: 0.0fr 1fr;
    }

    #users {
        table-layout: fixed;
        width: 100%;
    }

    #users thead tr th,
    #users tbody tr td {
        width: 11.5em !important;
        white-space: nowrap;
        overflow: hidden;
        font-size: 12px;
        border-bottom: 1px solid lightgray;
    }

    #users tbody tr td {
        overflow-x: auto;
        max-width: 11.5em !important;
    }

    #users tbody tr td::-webkit-scrollbar {
        width: 3px;
        height: 0px;
    }

    #users tbody tr td::-webkit-scrollbar-track {
        background: none;
    }

    #users tbody tr td::-webkit-scrollbar-thumb {
        background: #e94d65;
    }

    #users tbody tr td::-webkit-scrollbar-thumb:hover {
        background: #2d6d8b;
        width: 7px;
    }

    #anounsements {
        table-layout: fixed;
        width: 100%;
    }

    #anounsements thead tr th,
    #anounsements tbody tr td {
        width: 11.5em !important;
        white-space: nowrap;
        overflow: hidden;
        font-size: 12px;
        border-bottom: 1px solid lightgray;
    }

    #anounsements tbody tr td {
        overflow-x: auto;
        max-width: 11.5em !important;
    }

    #anounsements tbody tr td::-webkit-scrollbar {
        width: 3px;
        height: 0px;
    }

    #anounsements tbody tr td::-webkit-scrollbar-track {
        background: none;
    }

    #anounsements tbody tr td::-webkit-scrollbar-thumb {
        background: #e94d65;
    }

    #anounsements tbody tr td::-webkit-scrollbar-thumb:hover {
        background: #2d6d8b;
        width: 7px;
    }

    #events {
        table-layout: fixed;
        width: 100%;
    }

    #events thead tr th,
    #events tbody tr td {
        width: 11.5em !important;
        white-space: nowrap;
        overflow: hidden;
        font-size: 12px;
        border-bottom: 1px solid lightgray;
    }

    #events tbody tr td {
        overflow-x: auto;
        max-width: 11.5em !important;
    }

    #events tbody tr td::-webkit-scrollbar {
        width: 3px;
        height: 0px;
    }

    #events tbody tr td::-webkit-scrollbar-track {
        background: none;
    }

    #events tbody tr td::-webkit-scrollbar-thumb {
        background: #e94d65;
    }

    #events tbody tr td::-webkit-scrollbar-thumb:hover {
        background: #2d6d8b;
        width: 7px;
    }

    .table-header {
        background-color: #206D88;
        color: white;
        font-weight: 600;
        font-size: 13px;
    }
    .additional-event {
        padding: 0 7px 0 0;
        border: none;
        width: 2em !important;
        border-radius: 50% !important;
        color: white !important;
        background-color: #3F8CFF;
        height: 2em;
        position: absolute;
        top: 3em;
        left: 9em;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s ease-in-out;
    }

    .additional-event:hover {
        background-color: #e94d65
    }
</style>
<div id="alert-danger" class="alert alert-danger" style="display: none;">
    <ul id="error-list"></ul>
</div>
<div id="alert-success" class="alert alert-success" style="display: none;"></div>
<div id="calendarPopup" class="calendar-popup hidden">
    <div class="calendar-container">
        <div class="header">
            <button id="prevBtn">&#10094;</button>
            <div id="monthYear"></div>
            <button id="nextBtn">&#10095;</button>
        </div>
        <div id="content">
            <div class="days">
                <div class="day">Sun</div>
                <div class="day">Mon</div>
                <div class="day">Tue</div>
                <div class="day">Wed</div>
                <div class="day">Thu</div>
                <div class="day">Fri</div>
                <div class="day">Sat</div>

            </div>
            <div id="dates" class="dates"></div>
        </div>
    </div>
</div>
<main style="margin: 0 !important;">
    <div class="addtask-container-overveiw">
        <div class="adminsetting-header" style="padding: 1.5em 1em 1em 1em; border-bottom: 1px solid lightgray;">
            <div class="record">
                <h3>Admin Setting</h3>
                <p>Control your dashboard</p>
            </div>
        </div>
        <div class="container-header">
            <div class="left-side-header">

                <div class="record">
                    <h3>Create User</h3>
                    <p>Add multiple users to your domain</p>
                </div>

            </div>
            <div class="right-side-header">

                <img src="{{ asset('Asserts/logo/add-resources.png') }}" id="click-to-add">

            </div>
        </div>
        <form action="{{ route('user.store') }}" method="post" class="container createUserForm" id="task-container">
            @csrf
            <div class="information" style="padding-top: 0.7em;">
                <div class="row">
                    <label for="user_name">User name</label>
                    <input type="text" name="user_name" placeholder="username">
                </div>
                <div class="row">
                    <label for="role">Role</label>
                    <select name="role_id">
                        <option selected disabled>Select user role</option>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="information">
                <div class="row">
                    <label for="email">Email</label>
                    <input type="text" name="email" placeholder="email">
                </div>
                <div class="row">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="password">
                </div>
            </div>
            <div class="information">
                <div class="row">
                    <label for="checkInTime">Check-in Time</label>
                    <input type="time" name="check_in" placeholder="check-in time">
                </div>
                <div class="row">
                    <label for="checkOutTime">Check-Out Time</label>
                    <input type="time" name="check_out" placeholder="check-out time">
                </div>
            </div>
            <div class="information" id="id-container">
                <label for="assign" style="margin-left: 2.3em;">Assign User ID</label>

                <div class="row" id="id-box">
                    <button type="button" id="generate">Auto Assign</button>
                    <p id="output"></p>
                    <input type="hidden" name="user_id" id="user_id">
                </div>
            </div>

            <div class="add-task-form-btns" style="justify-content: end !important;">
                <button type="reset" class="restore-btn">
                    Reset
                </button>

                <button type="submit" class="footer-btn" style="width: 9em; padding: 0.7em; font-size: 10px;">
                    <span style="padding-top: 2px;">Add User</span>
                </button>
            </div>
        </form>

        <div class="container-header" style="border-top: 1px solid lightgray;">
            <div class="left-side-header">
                <div class="record">
                    <h3>Edit Users</h3>
                    <p>Edit or Deleter Users</p>
                </div>
            </div>
            <div class="right-side-header">
                <img src="./Asserts/logo/add-resources.png" id="click-to-assign">
            </div>
        </div>
        <div class="container" id="assign-container">
            <div class="datetable">
                <div class="data-container datatable datatable-container" style="box-shadow: none; overflow: hidden;">
                    <div class="data-table-container">
                        <table id="users" class="table table-sm  table-hover table-bordered" style="width: 79vw;">
                            <thead>
                                <tr class="table-header">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Check-in Time</th>
                                    <th>Check-out Time</th>
                                    <th>Role</th>
                                    <th>Edit User</th>
                                    <th>Delete User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr id="row_{{ $user->id }}">
                                    <td>{{ $user->user_id ?? 'N/A' }}</td>
                                    <td>{{ $user->user_name ?? 'N/A' }}</td>
                                    <td>{{ $user->email ?? 'N/A' }}</td>
                                    <td>{{ $user->check_in ?? 'N/A' }}</td>
                                    <td>{{ $user->check_out ?? 'N/A' }}</td>
                                    <td>{{ $user->role->name ?? 'N/A' }}</td>
                                    <td>
                                        <button class="rounded-circle btn btn-primary btn-sm edit-user-table"
                                            type="button" data-id="{{ $user->id }}">
                                            <img src="{{ asset('Asserts/logo/edit-table.png') }}" />
                                        </button>
                                        <!-- edit user model  -->
                                        <form id="editUserForm_{{ $user->id }}" action="{{ route('user.edit') }}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="modal" id="edit_user_modal_{{ $user->id }}" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog modal-xl shadow-lg" role="document"
                                                    style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                                    <div class="modal-content modal-xl shadow-lg"
                                                        style="border-radius: 10px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modelHeading">Edit User
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">×</span></button>
                                                        </div>
                                                        <input type="hidden" name="userid" value="{{ $user->id }}">
                                                        <div class="modal-body">
                                                            <div class="data">

                                                                <div id="f-danger" class="alert alert-danger"
                                                                    style="display: none;">
                                                                    <ul id="error-list"></ul>
                                                                </div>
                                                                <div id="alert-success" class="alert alert-success"
                                                                    style="display: none;"></div>
                                                                <div class="container"style="border:none;flex-direction: column;">
                                                                    <div class="planned" style="flex-direction: row;width: 100%;gap: 0.7em;">
                                                                        <div class="data">
                                                                            <label for="user_name">User name
                                                                            </label>
                                                                            <input type="text" id="user_name"
                                                                                name="user_name"
                                                                                value="{{ $user->user_name }}">
                                                                        </div>
                                                                        <div class="data">

                                                                            <label for="email">Email
                                                                            </label>
                                                                            <input type="email" id="email" name="email"
                                                                                value="{{ $user->email }}">
                                                                        </div>
                                                                        <div class="data">
                                                                            <label for="role">Role</label>
                                                                            <select name="role_id">
                                                                                @foreach($roles as $role)
                                                                                    <option value="{{$role->id}}" @if($role->id == $user->role_id) selected @endif>{{$role->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="planned" style="flex-direction: row;width: 100%;gap: 0.7em;">
                                                                        <div class="data">
                                                                            <label for="checkInTime">Check-in Time</label>
                                                                         <input type="time" name="check_in" value="{{ $user->check_in ? \Carbon\Carbon::createFromFormat('h:i A', $user->check_in)->format('H:i') : '' }}">
                                                                        </div>
                                                                        <div class="data">
                                                                            <label for="checkOutTime">Check-Out Time</label>
                                                                             <input type="time" name="check_out" value="{{ $user->check_out ? \Carbon\Carbon::createFromFormat('h:i A', $user->check_out)->format('H:i') : '' }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" onclick="userEdit({{ $user->id }})"
                                                                class="request-btn">Update</button>
                                                            <button type="button" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <button
                                            style=" border: #E94D65 !important;  background-color: #E94D65 !important;"
                                            data-id="{{ $user->id }}"
                                            class="rounded-circle btn btn-primary btn-sm delete-user" type="button">
                                            <img src="{{ asset('Asserts/logo/delete.png') }}" />
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-header" style="border-top: 1px solid lightgray;" id="your-tasks-header">
            <div class="left-side-header">

                <div class="record">
                    <h3>Make Annoucements</h3>
                    <p>Create Annoucements</p>
                </div>

            </div>
            <div class="right-side-header">

                <img src="./Asserts/logo/add-resources.png" id="your-tasks">

            </div>
        </div>

        <div class="container" id="your-tasks-container">
            <form class="createAnounsementForm" action="{{ route('anounsement.store') }}" method="post"
                style="box-shadow: none !important;">
                @csrf
                <div class="information" style="width: 100%; justify-content: space-evenly;gap: 10px;">
                    <div class="row emoji">
                        <input placeholder="Keep it short here" type="text" name="anounsement">
                        <img draggable="false" src="{{ asset('Asserts/logo/mdi_emoji.png') }}">
                    </div>
                    <button class="footer-btn" style="background-color: #e94d65;">
                        <span style="padding-top: 2px;">Announce</span>
                    </button>
                </div>
            </form>

            <h6 style="margin-top: 0.7em;">Previous Anounsements</h6>

            <div class="datetable">
                <div class="data-container datatable datatable-container" style="box-shadow: none; overflow: hidden;">
                    <div class="data-table-container">
                        <table id="anounsements" class="table table-sm  table-hover table-bordered"
                            style="width: 79vw;">
                            <thead>
                                <tr class="table-header">
                                    <th>Anounsement</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($anounsements as $anounsement)
                                <tr id="anounsement_row_{{ $anounsement->id }}">
                                    <td>{{ $anounsement->anounsement }}</td>
                                    <td>
                                        <button class="rounded-circle btn btn-primary btn-sm edit-table" type="button"
                                            data-id="{{ $anounsement->id }}">
                                            <img src="{{ asset('Asserts/logo/edit-table.png') }}" />
                                        </button>
                                        <!-- edit anounsement model  -->
                                        <form id="editAnounsementForm_{{ $anounsement->id }}"
                                            action="{{ route('anounsement.edit') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="modal" id="edit_anounsement_modal_{{ $anounsement->id }}"
                                                tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-xl shadow-lg" role="document"
                                                    style="background-color: rgba(0, 0, 0, 0.03) !important;width: 40em;">
                                                    <div class="modal-content modal-xl shadow-lg"
                                                        style="border-radius: 10px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modelHeading">Edit
                                                                Anounsement
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">×</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="data">

                                                                <div id="alert-danger" class="alert alert-danger"
                                                                    style="display: none;">
                                                                    <ul id="error-list"></ul>
                                                                </div>
                                                                <div id="alert-success" class="alert alert-success"
                                                                    style="display: none;"></div>
                                                                <input type="hidden" name="anounsement_id"
                                                                    value="{{ $anounsement->id }}">
                                                                <div class="container"
                                                                    style="box-shadow:none;padding: 0; border: none;">
                                                                    <div class="planned"
                                                                        style=" width: 100%;padding: 0;">
                                                                        <div class="data" style=" margin: 0;">
                                                                            <label for="anounsement">Anounsement
                                                                            </label>
                                                                            <input type="text" id="anounsement"
                                                                                name="anounsement"
                                                                                value="{{ $anounsement->anounsement }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer"
                                                            style="justify-content: center;gap: 2em; padding: 0.5em !important;">
                                                            <button type="button"
                                                                onclick="anounsementEdit({{ $anounsement->id }})"
                                                                class="request-btn">Save</button>
                                                            <button type="button" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <button
                                            style=" border: #E94D65 !important;  background-color: #E94D65 !important;"
                                            data-id="{{ $anounsement->id }}"
                                            class="rounded-circle btn btn-primary btn-sm delete-anounsement"
                                            type="button">
                                            <img src="{{ asset('Asserts/logo/delete.png') }}" />
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-header" style="border-top: 1px solid lightgray;">
            <div class="left-side-header">

                <div class="record">
                    <h3>Add Events</h3>
                    <p>Events are remender that are shown in notification</p>
                </div>

            </div>
            <div class="right-side-header">

                <img src="{{asset('Asserts/logo/add-resources.png')}}" id="click-to-event">

            </div>
        </div>

        <div class="container" id="event-container">
            <form class="createEventForm" id="createEventForm" action="{{ 'event.store' }}" method="post">
                @csrf
                <div class="information" style="padding-top: 0.7em;">
                    <div class="row">
                        <label for="event_name">Event Name</label>
                        <input type="text" placeholder="Event Name to display" name="event_name" id="event_name">
                    </div>
                    <div class="row">
                        <label for="priority">Priority</label>
                        <select name="priority" id="priority">
                            <option selected disabled>Select Priority</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                            <option value="Low">Low</option>
                        </select>
                    </div>
                </div>
                <div class="information">
                    <div class="row">
                        <label for="category">Event Category</label>
                        <select name="category" id="category">
                            <option selected disabled>Select Category Type</option>
                            <option value="category1">category1</option>
                            <option value="category2">category2</option>
                        </select>
                    </div>
                    <div class="row" style="flex-direction: row; justify-content: space-between;">
                        <div class="row" style="width: 49%;">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date">
                        </div>
                        <div class="row" style="width: 49%;">
                            <label for="time">Time</label>
                            <input type="time" name="time" id="time">
                        </div>
                    </div>
                </div>
                <div class="information" style="justify-content: start;">
                    <div class="row" style="margin-left: 0.5em;">
                        <label for="remark">Remarks</label>
                        <input type="text" placeholder="Add Remarks here" style="margin-left: 0.85em;" name="remark"
                            id="remark">
                    </div>
                </div>
                <div class="add-task-form-btns" style="justify-content: center !important;">
                    <button type="reset" class="restore-btn">
                        Reset
                    </button>
                    <button type="submit" class="footer-btn" style="width: 9em; padding: 0.7em; font-size: 10px;">
                        <span style="padding-top: 2px;">Add Event</span>
                    </button>
                </div>
            </form>
            <div class="add-task-form-btns" style="justify-content: center;">
                <button class="restore-btn" id="openCalendarBtn">
                    <img src="./Asserts/logo/calender.png" alt="Calendar Icon"> Calendar
                </button>
            </div>
            <div class="datetable">
                <div class="data-container datatable datatable-container" style="box-shadow: none; overflow: hidden;">
                    <div class="data-table-container">
                        <table id="events" class="table table-sm table-hover table-bordered" style="width: 79vw;">
                            <thead>
                                <tr class="table-header">
                                    <th>Event</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                <tr id="event_row_{{ $event->id }}">
                                    <td>{{ $event->event_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</td>
                                    <td>
                                        <button class="rounded-circle btn my-btn-primary btn-sm edit-event-table"
                                            type="button" data-id="{{ $event->id }}">
                                            <img src="{{ asset('Asserts/logo/edit-table.png') }}" />
                                        </button>
                                        <!-- edit event model  -->
                                        <form id="editEventForm_{{ $event->id }}" action="{{ route('event.edit') }}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal" id="edit_event_modal_{{ $event->id }}" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog modal-xl shadow-lg" role="document"
                                                    style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                                    <div class="modal-content modal-xl shadow-lg"
                                                        style="border-radius: 10px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modelHeading">Edit Event
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">×</span></button>
                                                        </div>
                                                        <input type="hidden" name="eventid" value="{{ $event->id }}">
                                                        <div class="modal-body">
                                                            <div class="data">
                                                                <div id="alert-danger" class="alert alert-danger"
                                                                    style="display: none;">
                                                                    <ul id="error-list"></ul>
                                                                </div>
                                                                <div id="alert-success" class="alert alert-success"
                                                                    style="display: none;"></div>
                                                                <div class="container">
                                                                    <div class="planned">
                                                                        <div class="data">
                                                                            <label for="event_name1">Event
                                                                                Name</label>
                                                                            <input type="text"
                                                                                value="{{ $event->event_name }}"
                                                                                name="event_name1">
                                                                            <label for="priority1">Priority</label>
                                                                            <select name="priority1">
                                                                                <option selected
                                                                                    value="{{ $event->priority }}">
                                                                                    {{ $event->priority }}</option>
                                                                                <option value="Medium">Medium
                                                                                </option>
                                                                                <option value="High">High
                                                                                </option>
                                                                                <option value="Low">Low</option>
                                                                            </select>
                                                                            <label for="category1">Event
                                                                                Category</label>
                                                                            <select name="category1">
                                                                                <option selected
                                                                                    value="{{ $event->category }}">
                                                                                    {{ $event->category }}</option>
                                                                                <option value="category1">category1
                                                                                </option>
                                                                                <option value="category2">category2
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="planned">
                                                                        <div class="data">
                                                                            <label for="date1">Date</label>
                                                                            <input type="date" name="date1"
                                                                                value="{{ $event->date }}">
                                                                            <label for="time1">Time</label>
                                                                            <input type="time" name="time1"
                                                                                value="{{ $event->time }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="planned">
                                                                        <div class="data">
                                                                            <label for="remark1">Remarks</label>
                                                                            <input type="text"
                                                                                placeholder="Add Remarks here"
                                                                                style="margin-left: 0.85em;"
                                                                                name="remark1"
                                                                                value="{{ $event->remark }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" onclick="editevent({{ $event->id }})"
                                                                class="request-btn">Save</button>
                                                            <button type="button" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <button
                                            style="border: #E94D65 !important; background-color: #E94D65 !important;"
                                            data-id="{{ $event->id }}"
                                            class="rounded-circle btn btn-primary btn-sm delete-event" type="button">
                                            <img src="{{ asset('Asserts/logo/delete.png') }}" />
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-header"
            style="border-top: 1px solid lightgray;border-bottom-left-radius: 0.7em;border-bottom-right-radius: 0.7em;">
            <div class="left-side-header">
                <div class="record">
                    <h3>Leads & Members</h3>
                </div>
            </div>
            <div class="right-side-header">

                <img src="./Asserts/logo/add-resources.png" id="click-to-setting">

            </div>
        </div>
        <div class="container" id="setting-container">
            <form class="assignForm" action="{{route('assign')}}" method="post" style="box-shadow: none;">
                @csrf
                <div class="information" style="padding-top: 0.7em; flex-direction: column;">
                    <div class="row">
                        <div style="display:flex;align-items:center;justify-content:center;">
                            <label for="assign">Select Manager</label>
                        </div>
                        <select name="manager" id="manager">
                            <option selected disabled>select manager</option>
                            @foreach($managers as $manager)
                                <option value="{{$manager->id}}">{{$manager->user_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div style="display:flex;align-items:center;justify-content:center;">
                            <label for="assign">Select Lead</label>
                        </div>
                        <select name="lead" id="lead">
                        <option selected disabled>select lead</option>
                            @foreach($leads as $lead)
                                <option value="{{$lead->id}}">{{$lead->user_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div style="display:flex;align-items:center;justify-content:center;">
                            <label for="assign">Select Member</label>
                        </div>
                        <select name="member" id="member">
                        <option selected disabled>select member</option>
                            @foreach($members as $member)
                                <option value="{{$member->id}}">{{$member->user_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="add-task-form-btns" style="justify-content: center;">
                    <button type="submit" class="footer-btn" style="width: 9em; padding: 0.7em; font-size: 10px; margin-left: 10px;">
                        <span style="padding-top: 2px;">Assign</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<!-- for making table datatable  -->
<script>
    $(document).ready(function() {
        var table = $('#recources').DataTable({
            "searching": true,
            "dom": 'lfrtip',
            "buttons": [],
            "language": {
                "emptyTable": "",
                "zeroRecords": ""
            },
            "processing": true,
            "serverSide": false
        });
    });
</script>
<script>
    $(document).ready(function() {
        var table = $('#anounsements').DataTable({
            "searching": true,
            "dom": 'lfrtip',
            "buttons": [],
            "language": {
                "emptyTable": "",
                "zeroRecords": ""
            },
            "processing": true,
            "serverSide": false
        });
    });
</script>
<script>
    $(document).ready(function() {
        var table = $('#events').DataTable({
            "searching": true,
            "dom": 'lfrtip',
            "buttons": [],
            "language": {
                "emptyTable": "",
                "zeroRecords": ""
            },
            "processing": true,
            "serverSide": false
        });
    });
</script>
<!-- end for making table datatable  -->
<script>
    // Replace with your actual events data from backend
    let events = {!! json_encode(
        $events->map(function($event) {
            return [
                'event_name' => $event->event_name,
                'date' => \Carbon\Carbon::parse($event->date)->format('Y-m-d'),
            ];
        })->toArray()
    ) !!};

    const currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    const monthYearElement = document.getElementById('monthYear');
    const datesElement = document.getElementById('dates');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const calendarPopup = document.getElementById('calendarPopup');
    const openCalendarBtn = document.getElementById('openCalendarBtn');

    function generateCalendar(month, year) {
        monthYearElement.textContent = new Date(year, month).toLocaleString('default', { month: 'long' }) + ' ' + year;
        datesElement.innerHTML = '';

        const firstDayOfMonth = new Date(Date.UTC(year, month, 1));
        const lastDayOfMonth = new Date(Date.UTC(year, month + 1, 0));
        const startDay = firstDayOfMonth.getUTCDay();
        const endDay = lastDayOfMonth.getUTCDate();

        for (let i = 0; i < startDay; i++) {
            const emptyDateElement = document.createElement('div');
            emptyDateElement.classList.add('date', 'empty');
            datesElement.appendChild(emptyDateElement);
        }

        for (let day = 1; day <= endDay; day++) {
            const dateElement = document.createElement('div');
            dateElement.textContent = day;
            dateElement.classList.add('date');
            if (month === currentDate.getMonth() && year === currentDate.getFullYear() && day === currentDate.getDate()) {
                dateElement.classList.add('current-month');
            }

            const eventsForDay = events.filter(event => {
                const eventDate = new Date(Date.UTC(...event.date.split('-').map((d, i) => i === 1 ? parseInt(d) - 1 : parseInt(d))));
                return eventDate.getUTCFullYear() === year && eventDate.getUTCMonth() === month && eventDate.getUTCDate() === day;
            });

            if (eventsForDay.length > 0) {
                const tasksElement = document.createElement('div');
                tasksElement.classList.add('tasks', 'calendar-tasks');

                eventsForDay.slice(0, 3).forEach(event => {
                    const eventItem = document.createElement('div');
                    eventItem.classList.add('event-item');
                    eventItem.textContent = event.event_name;
                    tasksElement.appendChild(eventItem);
                });

                if (eventsForDay.length > 3) {
                    const moreEventsElement = document.createElement('div');
                    moreEventsElement.textContent = `+${eventsForDay.length - 3}`;
                    moreEventsElement.classList.add('additional-event');
                    moreEventsElement.addEventListener('click', () => {
                        showPopup(eventsForDay);
                    });
                    tasksElement.appendChild(moreEventsElement);
                }

                dateElement.appendChild(tasksElement);
            }
            dateElement.addEventListener('click', () => openEventModal(year, month, day));
            datesElement.appendChild(dateElement);
        }
    }

    prevBtn.addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar(currentMonth, currentYear);
    });

    nextBtn.addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar(currentMonth, currentYear);
    });

    function openEventModal(year, month, day) {
        const date = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const eventsForDay = events.filter(event => event.date === date);

        if (eventsForDay.length > 0) {
            let eventDetails = '';
            eventsForDay.forEach(event => {
                eventDetails += `${event.event_name}\n`;
            });

            alert(`Events On : ${date}\n${eventDetails}`);
        }
    }

    function updateEvents(newEvents) {
        events = newEvents;
        generateCalendar(currentMonth, currentYear);
    }

    async function fetchEvents() {
        try {
            const response = await fetch('/events');
            const data = await response.json();
            updateEvents(data);
        } catch (error) {
            console.error('Error fetching events:', error);
        }
    }

    generateCalendar(currentMonth, currentYear);

    openCalendarBtn.addEventListener('click', async (event) => {
        event.preventDefault();
        calendarPopup.classList.toggle('hidden');
        await fetchEvents(); // Fetch events when opening the calendar
    });

    window.addEventListener('click', (event) => {
        if (event.target === calendarPopup) {
            calendarPopup.classList.add('hidden');
        }
    });
</script>
<script>
    let tasksbutton = document.getElementById('click-to-add');
    let taskcontainer = document.getElementById('task-container');

    tasksbutton.addEventListener('click', function() {

        taskcontainer.classList.toggle('show-container')

        if (taskcontainer.classList.contains('show-container')) {
            tasksbutton.style.transform = 'rotate(180deg)'
        } else {
            tasksbutton.style.transform = 'rotate(360deg)'

        }
    });

    let additionalsetting = document.getElementById('click-to-setting');
    let settingcontainer = document.getElementById('setting-container');

    additionalsetting.addEventListener('click', function() {

        settingcontainer.classList.toggle('show-container')

        if (settingcontainer.classList.contains('show-container')) {
            additionalsetting.style.transform = 'rotate(180deg)'
        } else {
            additionalsetting.style.transform = 'rotate(360deg)'

        }
    });


    let eventbtn = document.getElementById('click-to-event');
    let eventcontainer = document.getElementById('event-container');

    eventbtn.addEventListener('click', function() {

        eventcontainer.classList.toggle('show-container')

        if (eventcontainer.classList.contains('show-container')) {
            eventbtn.style.transform = 'rotate(180deg)'
        } else {
            eventbtn.style.transform = 'rotate(360deg)'
        }
    });


    let assignbutton = document.getElementById('click-to-assign');
    let assigncontainer = document.getElementById('assign-container');

    assignbutton.addEventListener('click', function() {

        assigncontainer.classList.toggle('show-container')

        if (assigncontainer.classList.contains('show-container')) {
            assignbutton.style.transform = 'rotate(180deg)'
        } else {
            assignbutton.style.transform = 'rotate(360deg)'
        }
    });

    let yourtaskbutton = document.getElementById('your-tasks');
    let yourtaskcontainer = document.getElementById('your-tasks-container');
    let yourtaskheader = document.getElementById('your-tasks-header');

    yourtaskbutton.addEventListener('click', function() {

        yourtaskcontainer.classList.toggle('show-container')

        if (yourtaskcontainer.classList.contains('show-container')) {
            yourtaskheader.style.borderRadius = '0em';
            yourtaskbutton.style.transform = 'rotate(180deg)'
        } else if (yourtaskheader.classList.contains('container-header')) {
            yourtaskheader.style.borderBottomLeftRadius = '0.7em';
            yourtaskheader.style.borderBottomRightRadius = '0.7em';
            yourtaskbutton.style.transform = 'rotate(360deg)'

        }
    });
</script>
<script>
    (function() {
        function IDGenerator() {
            this.length = 6;
            this.timestamp = +new Date;

            var _getRandomInt = function(min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }

            this.generate = function() {
                var ts = this.timestamp.toString();
                var parts = ts.split("").reverse();
                var id = "";

                for (var i = 0; i < this.length; ++i) {
                    var index = _getRandomInt(0, parts.length - 1);
                    id += parts[index];
                }

                return id;
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            var btn = document.querySelector("#generate"),
                output = document.querySelector("#output");
            userIdInput = document.querySelector("#user_id");

            btn.addEventListener("click", function() {
                var generator = new IDGenerator();
                var generatedId = generator.generate();
                output.innerHTML = generatedId;
                userIdInput.value = generatedId;
            }, false);
        });
    })();
</script>
<script>
    var checkboxes = document.querySelectorAll('.iconCheckbox');
    var iconElements = document.querySelectorAll('.icon');
    checkboxes.forEach(function(checkbox, index) {
        var iconElement = iconElements[index];
        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
                iconElement.classList.add('checked');
            } else {
                iconElement.classList.remove('checked');
            }
        });
    });
</script>
<!--end  kashan script  -->
<!-- user scripts  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myForm = document.querySelector('.createUserForm');
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
                        let RoleId = data.user.role_id;
                        let dropdowns = {
                            2: document.getElementById('manager'),
                            3: document.getElementById('manager'),
                            4: document.getElementById('manager'),
                            5: document.getElementById('manager'),
                            6: document.getElementById('lead'),
                            7: document.getElementById('member')
                        };

                        if (dropdowns[RoleId]) {
                            let option = document.createElement('option');
                            option.value = data.user.id;
                            option.textContent = data.user.user_name;
                            dropdowns[RoleId].appendChild(option);
                        }
                        let user = data.user;
                        let userRole = data.userRole;
                        let checkInTime = moment(user.check_in, 'h:mm A').format('HH:mm');
                        let checkOutTime = moment(user.check_out, 'h:mm A').format('HH:mm');
                        let newRow = `
                                    <tr id="row_${user.id}">
                                        <td>${user.user_id}</td>
                                        <td>${user.user_name}</td>
                                        <td>${user.email}</td>
                                        <td>${user.check_in}</td>
                                        <td>${user.check_out}</td>
                                        <td>${userRole}</td>
                                        <td>
                                            <button class="rounded-circle btn btn-primary btn-sm edit-user-table" type="button" data-id="${user.id}">
                                                <img src="{{ asset('Asserts/logo/edit-table.png') }}" />
                                            </button>
                                            <!-- edit user modal  -->
                                            <form id="editUserForm_${user.id}" action="{{ route('user.edit') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal" id="edit_user_modal_${user.id}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-xl shadow-lg" role="document" style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                                        <div class="modal-content modal-xl shadow-lg" style="border-radius: 10px;">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modelHeading">Edit User</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <input type="hidden" name="userid" value="${user.id}">
                                                            <div class="modal-body">
                                                                <div class="data">
                                                                    <div id="alert-danger" class="alert alert-danger" style="display: none;">
                                                                        <ul id="error-list"></ul>
                                                                    </div>
                                                                    <div id="alert-success" class="alert alert-success" style="display: none;"></div>
                                                                    <div class="container" style="border:none;flex-direction: column;">
                                                                        <div class="planned" style="flex-direction: row;width: 100%;gap: 0.7em;">
                                                                            <div class="data">
                                                                                <label for="user_name">User name</label>
                                                                                <input type="text" id="user_name" name="user_name" value="${user.user_name}">
                                                                            </div>
                                                                            <div class="data">
                                                                                <label for="email">Email</label>
                                                                                <input type="email" id="email" name="email" value="${user.email}">
                                                                            </div>
                                                                            <div class="data">
                                                                                <label for="user_id">User Id</label>
                                                                                <input type="number" id="user_id" name="user_id" value="${user.user_id}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="planned" style="flex-direction: row;width: 100%;gap: 0.7em;">
                                                                                <div class="data">
                                                                                    <label for="checkInTime">Check-in Time</label>
                                                                                    <input type="time" name="check_in" value="${checkInTime}">
                                                                                </div>
                                                                                <div class="data">
                                                                                    <label for="checkOutTime">Check-Out Time</label>
                                                                                    <input type="time" name="check_out" value="${checkOutTime}">
                                                                                </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" onclick="userEdit(${user.id})" class="request-btn">Update</button>
                                                                <button type="button" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <button style="border: #E94D65 !important; background-color: #E94D65 !important;" data-id="${user.id}" class="rounded-circle btn btn-primary btn-sm delete-user" type="button">
                                                <img src="{{ asset('Asserts/logo/delete.png') }}" />
                                            </button>
                                        </td>
                                    </tr>
                                `;
                        document.querySelector('#users tbody').insertAdjacentHTML('beforeend',
                            newRow);
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
            document.querySelectorAll('.edit-user-table').forEach(function(button) {
                button.addEventListener('click', function() {
                    var userId = button.getAttribute('data-id');
                    openEditUserModal(userId);
                });
            });
        }
        registerEditTableButtons();

        $(document).on('click', '.delete-user', function() {
            var userId = $(this).data('id');
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: '/destroyUser/' + userId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#row_' + userId).remove();
                        alert('User deleted successfully');
                    },
                    error: function(xhr, status, error) {
                        var response = xhr.responseJSON;
                        if (response && response.message) {
                            alert(response.message);
                        } else {
                            alert('An error occurred while trying to delete the user.');
                        }
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

    function openEditUserModal(userId) {
        var modalId = "edit_user_modal_" + userId;
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
<script>
    function userEdit(userId) {
        var formData = new FormData(document.getElementById('editUserForm_' + userId));
        axios.post('{{ route('user.edit') }}',
                formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
            .then(function(response) {
                var data = response.data;
                showSuccessAlert('User edit successfully!');
                var rowId = 'row_' + data.userId;
                var tableRow = document.getElementById(rowId);
                if (tableRow) {
                    tableRow.cells[0].textContent = data.user.user_id;
                    tableRow.cells[1].textContent = data.user.user_name;
                    tableRow.cells[2].textContent = data.user.email;
                    tableRow.cells[3].textContent = data.user.check_in;
                    tableRow.cells[4].textContent = data.user.check_out;
                    tableRow.cells[5].textContent = data.userRole;
                }
                var modalId = 'editUserForm_' + data.userId;
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
<!-- anounsement scripts  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myForm = document.querySelector('.createAnounsementForm');
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
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute(
                                'content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        myForm.reset();
                        let anounsement = data.anounsement;
                        let newRow = `
                                        <tr id="anounsement_row_${anounsement.id}">
                                            <td>${anounsement.anounsement}</td>
                                            <td>
                                                <button class="rounded-circle btn btn-primary btn-sm edit-table" type="button"
                                                    data-id="${anounsement.id}">
                                                    <img src="{{ asset('Asserts/logo/edit-table.png') }}" />
                                                </button>
                                                <!-- edit anounsement modal -->
                                                <form id="editAnounsementForm_${anounsement.id}"
                                                    action="{{ route('anounsement.edit') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="modal" id="edit_anounsement_modal_${anounsement.id}" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog modal-xl shadow-lg" role="document"
                                                            style="background-color: rgba(0, 0, 0, 0.03) !important;width: 40em;">
                                                            <div class="modal-content modal-xl shadow-lg" style="border-radius: 10px;">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="modelHeading">Edit Anounsement</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                </div>
                                                                <input type="hidden" name="anounsement_id" value="${anounsement.id}">
                                                                <div class="modal-body">
                                                                    <div class="data">
                                                                        <div id="alert-danger" class="alert alert-danger" style="display: none;">
                                                                            <ul id="error-list"></ul>
                                                                        </div>
                                                                        <div id="alert-success" class="alert alert-success" style="display: none;"></div>
                                                                        <div class="container" style="box-shadow:none;padding: 0; border: none;">
                                                                            <div class="planned" style=" width: 100%;padding: 0;">
                                                                                <div class="data" style=" margin: 0;">
                                                                                    <label for="anounsement">Anounsement</label>
                                                                                    <input type="text" id="anounsement"
                                                                                        name="anounsement"
                                                                                        value="${anounsement.anounsement}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer" style="justify-content: center;gap: 2em; padding: 0.5em !important;">
                                                                    <style>
                                                                    .modal-footer button {
                                                                        width: 8em;
                                                                        height: 3em;
                                                                        background-color: #1b4962 !important;
                                                                        border-radius: 5px;
                                                                        font-weight: 400;
                                                                        font-style: normal;
                                                                        font-size: 11px;
                                                                        transition: 0.3s ease-in-out !important;
                                                                        text-decoration: none;
                                                                        color: white;
                                                                        border: none;
                                                                    }
                                                                    </style>
                                                                    <button type="button" onclick="anounsementEdit(${anounsement.id})" class="request-btn">Save</button>
                                                                    <button type="button" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <button style="border: #E94D65 !important; background-color: #E94D65 !important;"
                                                    data-id="${anounsement.id}" class="rounded-circle btn btn-primary btn-sm delete-anounsement"
                                                    type="button">
                                                    <img src="{{ asset('Asserts/logo/delete.png') }}" />
                                                </button>
                                            </td>
                                        </tr>
                                    `;
                        document.querySelector('#anounsements tbody').insertAdjacentHTML(
                            'beforeend',
                            newRow);

                        // Reinitialize the event listeners for the new row
                        reinitializeEventListeners();

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

        // Initialize event listeners for existing rows
        reinitializeEventListeners();
    });

    function reinitializeEventListeners() {
        document.querySelectorAll('.delete-anounsement').forEach(function(button) {
            button.removeEventListener('click', handleDelete);
            button.addEventListener('click', handleDelete);
        });

        document.querySelectorAll('.edit-table').forEach(function(button) {
            button.removeEventListener('click', handleEdit);
            button.addEventListener('click', handleEdit);
        });
    }

    function handleDelete(event) {
        var anounsementId = event.currentTarget.dataset.id;
        if (confirm('Are you sure you want to delete this anounsement?')) {
            $.ajax({
                url: '/destroyAnounsement/' + anounsementId,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#anounsements tbody #anounsement_row_' + anounsementId).remove();
                    alert('Anounsement deleted successfully');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    }

    function handleEdit(event) {
        var anounsementId = event.currentTarget.dataset.id;
        openEditAnouncementModal(anounsementId);
    }

    function openEditAnouncementModal(anounsementId) {
        var modalId = "edit_anounsement_modal_" + anounsementId;
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add("show");
            modal.style.display = "block";
            document.body.classList.add("modal-open");
        }
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
<script>
    function anounsementEdit(anounsementId) {
        var formData = new FormData(document.getElementById('editAnounsementForm_' + anounsementId));
        axios.post('{{ route('anounsement.edit') }}',
                formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
            .then(function(response) {
                var data = response.data;
                showSuccessAlert('Anounsement edit successfully!');
                var rowId = 'anounsement_row_' + data.anounsementId;
                var tableRow = document.getElementById(rowId);
                if (tableRow) {
                    tableRow.cells[0].textContent = data.anounsement.anounsement;
                }
                var modalId = 'editAnounsementForm_' + data.anounsementId;
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
<!-- event scriot  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myForm = document.querySelector('.createEventForm');
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
                        let event = data.event;
                        // alert(JSON.stringify(event, null, 2));
                        // return;
                        var formattedDate = moment(event.date).format('DD MMMM YYYY');
                        var formattedTime = moment(event.time, 'HH:mm:ss').format('h:mm A');
                        var newRow = `
                                <tr id="event_row_${event.id}">
                                    <td>${event.event_name}</td>
                                    <td>${formattedDate}</td>
                                    <td>${formattedTime}</td>
                                    <td>
                                        <button class="rounded-circle btn my-btn-primary btn-sm edit-event-table" type="button" data-id="${event.id}">
                                            <img src="{{ asset('Asserts/logo/edit-table.png') }}" />
                                        </button>
                                        <form id="editEventForm_${event.id}" action="{{ route('event.edit') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal" id="edit_event_modal_${event.id}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-xl shadow-lg" role="document" style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                                    <div class="modal-content modal-xl shadow-lg" style="border-radius: 10px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modelHeading">Edit Event</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <input type="hidden" name="eventid" value="${event.id}">
                                                        <div class="modal-body">
                                                            <div class="data">
                                                                <div id="alert-danger" class="alert alert-danger" style="display: none;">
                                                                    <ul id="error-list"></ul>
                                                                </div>
                                                                <div id="alert-success" class="alert alert-success" style="display: none;"></div>
                                                                <div class="container">
                                                                    <div class="planned">
                                                                        <div class="data">
                                                                            <label for="event_name1">Event Name</label>
                                                                            <input type="text" value="${event.event_name}" name="event_name1">
                                                                            <label for="priority1">Priority</label>
                                                                            <select name="priority1">
                                                                                <option selected value="${event.priority}">${event.priority}</option>
                                                                                <option value="Medium">Medium</option>
                                                                                <option value="High">High</option>
                                                                                <option value="Low">Low</option>
                                                                            </select>
                                                                            <label for="category1">Event Category</label>
                                                                            <select name="category1">
                                                                                <option selected value="${event.category}">${event.category}</option>
                                                                                <option value="category1">category1</option>
                                                                                <option value="category2">category2</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="planned">
                                                                        <div class="data">
                                                                            <label for="date1">Date</label>
                                                                            <input type="date" name="date1" value="${event.date}">
                                                                            <label for="time1">Time</label>
                                                                            <input type="time" name="time1" value="${event.time}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="planned">
                                                                        <div class="data">
                                                                            <label for="remark1">Remarks</label>
                                                                            <input type="text" placeholder="Add Remarks here" style="margin-left: 0.85em;" name="remark1" value="${event.remark}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" onclick="editevent(${event.id})" class="request-btn">Save</button>
                                                            <button type="button" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <button style="border: #E94D65 !important; background-color: #E94D65 !important;" data-id="${event.id}" class="rounded-circle btn btn-primary btn-sm delete-event" type="button">
                                            <img src="{{ asset('Asserts/logo/delete.png') }}" />
                                        </button>
                                    </td>
                                </tr>
                            `;

                        document.querySelector('#events tbody').insertAdjacentHTML('beforeend',
                            newRow);

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
                        registerEditEventTableButtons();
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

        // Function to register event listener for edit table buttons
        function registerEditEventTableButtons() {
            document.querySelectorAll('.edit-event-table').forEach(function(button) {
                button.addEventListener('click', function() {
                    var eventId = button.getAttribute('data-id');
                    EditEventModal(eventId);
                });
            });
        }

        // Initial registration of edit table buttons event listener
        registerEditEventTableButtons();

        $(document).on('click', '.delete-event', function() {
            var eventId = $(this).data('id');
            if (confirm('Are you sure you want to delete this event?')) {
                $.ajax({
                    url: '/destroyEvent/' + eventId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#events tbody #event_row_' + eventId).remove();
                        alert('Event deleted  successfully');
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

    function EditEventModal(eventId) {
        var modalId = "edit_event_modal_" + eventId;
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
<script>
    function editevent(eventId) {
        var formData = new FormData(document.getElementById('editEventForm_' + eventId));
        axios.post('{{ route('event.edit') }}',
                formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
            .then(function(response) {
                var data = response.data;
                showSuccessAlert('Event updated successfully!');
                var rowId = 'event_row_' + data.eventId;
                var tableRow = document.getElementById(rowId);
                if (tableRow) {
                    var formattedDate = moment(data.event.date).format('DD MMMM YYYY');
                    var formattedTime = moment(data.event.time, 'HH:mm:ss').format('h:mm A');

                    tableRow.cells[0].textContent = data.event.event_name;
                    tableRow.cells[1].textContent = formattedDate;
                    tableRow.cells[2].textContent = formattedTime;
                }
                var modalId = 'edit_event_modal_' + data.eventId;
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
<!-- assign script  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myForm = document.querySelector('.assignForm');
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


                        var selectedMember = document.getElementById('member').value;
                        var memberDropdown = document.getElementById('member');
                        var optionToRemove = memberDropdown.querySelector(`option[value="${selectedMember}"]`);
                        if (optionToRemove) {
                            optionToRemove.remove();
                        }

                        setTimeout(function() {
                            successAlert.style.display = 'none';
                        }, 3000);
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
</script>
@endpush