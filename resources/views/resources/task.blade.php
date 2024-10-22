@extends("layouts.app")
@section('content')
<style>
body {
    grid-auto-rows: 0.0fr 1fr;
}

.modal {
    display: none;
}

.modal.proof {
    display: block;
}

#tasks {
    table-layout: fixed;
    width: 100%;
}

#tasks thead tr th,
#tasks tbody tr td {
    width: 5em !important;
    white-space: nowrap;
    overflow: hidden;
    font-size: 12px;
    border-bottom: 1px solid lightgray;
}

#tasks tbody tr td {
    overflow-x: auto;
    max-width: 5em !important;
}

#tasks tbody tr td::-webkit-scrollbar {
    width: 3px;
    height: 0px;
}

#tasks tbody tr td::-webkit-scrollbar-track {
    background: none;
}

#tasks tbody tr td::-webkit-scrollbar-thumb {
    background: #e94d65;
}

#tasks tbody tr td::-webkit-scrollbar-thumb:hover {
    background: #2d6d8b;
    width: 7px;
}

#myTasks {
    table-layout: fixed;
    width: 100%;
}

#myTasks thead tr th,
#myTasks tbody tr td {
    width: 5em !important;
    white-space: nowrap;
    overflow: hidden;
    font-size: 12px;
    border-bottom: 1px solid lightgray;
}

#myTasks tbody tr td {
    overflow-x: auto;
    max-width: 5em !important;
}

#myTasks tbody tr td::-webkit-scrollbar {
    width: 3px;
    height: 0px;
}

#myTasks tbody tr td::-webkit-scrollbar-track {
    background: none;
}

#myTasks tbody tr td::-webkit-scrollbar-thumb {
    background: #e94d65;
}

#myTasks tbody tr td::-webkit-scrollbar-thumb:hover {
    background: #2d6d8b;
    width: 7px;
}

.table-header {
    background-color: #206D88;
    color: white;
    font-weight: 600;
    font-size: 13px;
}

.modal-open {
    overflow: hidden;
}

.hidden {
    display: none;
}

.show-container {
    display: block !important;
}

.update-button {
    background-color: #2D6D8B;
    color: white;
    padding: 5px;
    border-radius: 10px;
    border-color: #2D6D8B;
}
</style>
<div id="alert-danger" class="alert alert-danger" style="display: none;">
    <ul id="error-list"></ul>
</div>
<div id="alert-success" class="alert alert-success" style="display: none;"></div>
<main style="margin-top: 0 !important;">
    <div class="addtask-container-overveiw">
        @if(AdminRecManagerAndLead())
        <div class="container-header">
            <div class="left-side-header">

                <div class="record">
                    <h3>Add Task</h3>
                    <p>Check your own task / Assign task</p>
                </div>

            </div>
            <div class="right-side-header">

                <img src="{{asset('Asserts/logo/add-resources.png')}}" id="click-to-add">

            </div>
        </div>
        <form class="container createTaskForm" id="task-container" action="{{ route('tasks.store') }}"
            enctype="multipart/form-data" method="post">
            @csrf
            <div>
                <div class="information" style="padding-top: 0.7em;">
                    <div class="row" style="flex-direction: column;">
                        <label for="assign_to">Assigned To</label>
                        <select name="assign_to">
                            <option selected disabled>select user</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->user_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row" style="flex-direction: row;">
                        <div class="child" style="width: 49% !important;">
                            <label for="start_date">Start date</label>
                            <input type="date" placeholder="start date" name="start_date">
                        </div>
                        <div class="child" style="margin-left: 0.2em; width: 49%;">
                            <label for="due_date">Due Date</label>
                            <input type="date" placeholder="due date" name="due_date">
                        </div>
                    </div>
                </div>
                <div class="information">
                    <div class="row">
                        <label for="assign">Bucket</label>
                        <input type="text" placeholder="bucket" name="bucket">
                    </div>
                    <div class="row">
                        <label for="description">Description</label>
                        <input type="text" placeholder="add description" name="description">
                    </div>
                </div>
                <div class="information">
                    <div class="row">
                        <label for="priority">Priority</label>
                        <select name="priority">
                            <option value="high">high</option>
                            <option value="medium">medium</option>
                            <option value="low">low</option>
                        </select>
                    </div>
                    <div class="row">
                        <label for="remarks">Remarks</label>
                        <input type="text" placeholder="remarks" name="remarks">
                    </div>
                </div>
                <div class="information" style="justify-content: start; margin-left: 2em;}">
                    <div class="row" style="flex-direction: column;">
                        <label for="attachment">Attancement <span style="font-weight: 400;"></span></label>
                        <input type="file" name="attachment">
                    </div>
                    <div style="margin-left:2%" class="row" style="flex-direction: column;">
                        <label for="location">Location <span style="font-weight: 400;"></span></label>
                        <input type="text" name="location" placeholder="location">
                    </div>
                </div>
                <div class="information" style="justify-content: start; margin-left: 2em;}">
                    <div class="row">
                        <label for="status">Progress</label>
                        <select name="status">
                            <option selected disabled>select</option>
                            <option value="Not started">Not started</option>
                            <option value="In progress">In progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>

                <div class="add-task-form-btns" style="justify-content: end !important;">
                    <button type="reset" class="restore-btn">
                        Reset
                    </button>

                    <button class="request-btn" type="submit"
                        style="width: 9em !important;display: flex; align-items: center; justify-content: space-evenly;padding: 0.2em;">
                        <img src="{{asset('Asserts/logo/save-record.png')}}">
                        <span style="padding-top: 2px;">Add Task</span>
                    </button>
                </div>

            </div>
        </form>
        <div class="container-header" style="border-top: 1px solid lightgray;">
            <div class="left-side-header">
                <div class="record">
                    <h3>Assigned Tasks</h3>
                    <p>Check task that you have assigned team</p>
                </div>
            </div>
            <div class="right-side-header">
                <img src="{{asset('Asserts/logo/add-resources.png')}}" id="click-to-assign">
            </div>
        </div>
        <div class="container" id="assign-container">
            <div class="information" style="width: 100%; padding: 0;">
                <div class="row" style="width: 100%;">
                    <div class="datetable">
                        <div class="data-container datatable datatable-container"
                            style="box-shadow: none !important; overflow: hidden;">
                            <div class="data-table-container">
                                <table id="tasks" class="table table-sm  table-hover table-bordered"
                                    style="width: 79vw;">
                                    <thead>
                                        <tr class="table-header">
                                            <th>Task No</th>
                                            <th>Assign To</th>
                                            <th>Start Date</th>
                                            <th>Due Date</th>
                                            <th>Priority</th>
                                            <th>Progress</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tasks as $task)
                                        <tr id="row_{{ $task->id }}">
                                            <td>{{ $task->id }}</td>
                                            <td>{{ $task->assignedUser->user_name ?? 'N/A'}}</td>
                                            <td>{{ \Carbon\Carbon::parse($task->start_date)->format('m/d/Y')}}</td>
                                            <td>{{ \Carbon\Carbon::parse($task->due_date)->format('m/d/Y')}}</td>
                                            <td>{{ $task->priority ?? 'N/A' }}</td>
                                            <td>{{ $task->status ?? 'N/A' }}</td>
                                            <td>
                                                <button class="rounded-circle btn btn-primary btn-sm edit-task-table"
                                                    type="button" data-id="{{ $task->id }}">
                                                    <img src="{{ asset('Asserts/logo/edit-table.png') }}" />
                                                </button>
                                                <!-- edit task model  -->
                                                <form id="editTaskForm_{{ $task->id }}"
                                                    action="{{ route('task.edit') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div style="z-index: 9999 !important;" class="modal"
                                                        id="edit_task_modal_{{ $task->id }}" tabindex="-1"
                                                        role="dialog">
                                                        <div class="modal-dialog modal-xl shadow-lg" role="document"
                                                            style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                                            <div class="modal-content modal-xl shadow-lg"
                                                                style="border-radius: 10px;">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="modelHeading">Edit Task
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close"><span
                                                                            aria-hidden="true">×</span></button>
                                                                </div>
                                                                <input type="hidden" name="taskId"
                                                                    value="{{ $task->id }}">
                                                                <div class="modal-body">
                                                                    <div class="data">

                                                                        <div id="f-danger" class="alert alert-danger"
                                                                            style="display: none;">
                                                                            <ul id="error-list"></ul>
                                                                        </div>
                                                                        <div id="alert-success"
                                                                            class="alert alert-success"
                                                                            style="display: none;"></div>
                                                                        <div class="container">
                                                                            <div class="planned">
                                                                                <div class="data">
                                                                                    <label for="start_date">Start
                                                                                        date</label>
                                                                                    <input type="date"
                                                                                        value="{{$task->start_date}}"
                                                                                        name="start_date" >
                                                                                    <label for="assign_to">Assigned
                                                                                        To</label>
                                                                                    <select name="assign_to">
                                                                                        <option selected
                                                                                            value="{{ $task->assign_to }}">
                                                                                            {{ $task->assignedUser->user_name }}
                                                                                        </option>
                                                                                        @foreach($users as $user)
                                                                                        <option value="{{ $user->id }}">
                                                                                            {{$user->user_name}}
                                                                                        </option>
                                                                                        @endforeach
                                                                                    </select>

                                                                                    <label for="description">Description</label>
                                                                                    <input type="text"  name="description" value="{{$task->description}}">

                                                                                </div>
                                                                            </div>
                                                                            <div class="planned">
                                                                                <div class="data">
                                                                                    <label for="due_date">Due
                                                                                        date</label>
                                                                                    <input type="date"
                                                                                        value="{{$task->due_date}}"
                                                                                        name="due_date" >
                                                                                </div>
                                                                                <label for="status">
                                                                                    Status</label>
                                                                                <select name="status">
                                                                                    <option value="Not started"
                                                                                        {{ $task->status === 'Not started' ? 'selected' : '' }}>
                                                                                        Not started</option>
                                                                                    <option value="In progress"
                                                                                        {{ $task->status === 'In progress' ? 'selected' : '' }}>
                                                                                        In progress</option>
                                                                                    <option value="Completed"
                                                                                        {{ $task->status === 'Completed' ? 'selected' : '' }}>
                                                                                        Completed</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="planned">
                                                                                <div class="data">
                                                                                    <label
                                                                                        for="priority">Priority</label>
                                                                                    <select name="priority">
                                                                                        <option value="high"
                                                                                            {{ $task->priority === 'high' ? 'selected' : '' }}>
                                                                                            high</option>
                                                                                        <option value="medium"
                                                                                            {{ $task->priority === 'medium' ? 'selected' : '' }}>
                                                                                            medium</option>
                                                                                        <option value="low"
                                                                                            {{ $task->priority === 'low' ? 'selected' : '' }}>
                                                                                            low</option>
                                                                                    </select>

                                                                                    <label
                                                                                        for="location">Location</label>
                                                                                    <input type="text"
                                                                                        value="{{$task->location}}"
                                                                                        name="location">

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        onclick="taskEdit({{ $task->id }})"
                                                                        class="request-btn">Save</button>
                                                                    <button type="button"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <button
                                                    style=" border: #E94D65 !important;  background-color: #E94D65 !important;"
                                                    data-id="{{$task->id }}"
                                                    class="rounded-circle btn btn-primary btn-sm delete-task"
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
            </div>
        </div>
        @endif
        @if(OnlyRecruitmentRole())
        <div class="container-header"
            style="border-top: 1px solid lightgray;border-bottom-left-radius: 0.7em;border-bottom-right-radius: 0.7em;"
            id="your-tasks-header">
            <div class="left-side-header">

                <div class="record">
                    <h3>Your Tasks</h3>
                    <p>Check task that you have assigned team</p>
                </div>

            </div>
            <div class="right-side-header">

                <img src="{{asset('Asserts/logo/add-resources.png')}}" id="your-tasks">

            </div>
        </div>
        <div class="container" id="your-tasks-container">
            <div class="information">
                <div class="row" style="width:105%">
                    <div class="datetable">
                        <div class="data-container datatable datatable-container"
                            style="box-shadow: none !important; overflow: hidden;">
                            <div class="data-table-container">
                                <table id="myTasks" class="table table-sm  table-hover table-bordered"
                                    style="width: 79vw;">
                                    <thead>
                                        <tr class="table-header">
                                            <th>Task No</th>
                                            <th>Assign To</th>
                                            <th>Start Date</th>
                                            <th>Due Date</th>
                                            <th>Priority</th>
                                            <th>Locatio</th>
                                            <th>Details</th>
                                            <th>Update Status</th>
                                            <th>Mark As Done</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mtasks as $mtask)
                                        <tr id="myTaskTableRow_{{ $mtask->id }}">
                                            <td>{{ $mtask->id }}</td>
                                            <td>{{ $mtask->assignedUser->user_name ?? 'N/A'}}</td>
                                            <td>{{ \Carbon\Carbon::parse($mtask->start_date)->format('m/d/Y')}}</td>
                                            <td>{{ \Carbon\Carbon::parse($mtask->due_date)->format('m/d/Y')}}</td>
                                            <td>{{ $mtask->priority ?? 'N/A' }}</td>
                                            <td>{{ $mtask->location ?? 'N/A' }}</td>
                                            <td>
                                                <button style="background: none !important; border:none !important;"
                                                    onclick="openDetailsModal({{ $mtask->id }})" type="button">
                                                    <img src="{{ asset('Asserts/logo/info.png') }}" />
                                                </button>
                                                <div class="modal" id="task_details_modal_{{ $mtask->id }}"
                                                    tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-xl shadow-lg" role="document"
                                                        style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                                        <div class="modal-content modal-xl shadow-lg"
                                                            style="border-radius: 10px;">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modelHeading">Task Details
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close"><span
                                                                        aria-hidden="true">×</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="data">
                                                                    <div class="data">
                                                                        <label for="description">Details</label><br>
                                                                        <textarea cols="177"
                                                                            rows="7">{{$mtask->description }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="model-footer-button" type="button"
                                                                    data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <button onclick="openUpdateStatusModal({{ $mtask->id }})" type="button"
                                                    class="update-button">
                                                    Update Status
                                                </button>
                                                <form id="update_status_form_{{ $mtask->id }}"
                                                    action="{{route('task.update.status')}}" method="post">
                                                    @csrf
                                                    <div class="modal" id="update_status_model_{{ $mtask->id }}"
                                                        tabindex="-1" role="dialog">
                                                        <div class="modal-dialog modal-xl shadow-lg" role="document"
                                                            style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                                            <div class="modal-content modal-xl shadow-lg"
                                                                style="border-radius: 10px;">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="modelHeading">Task
                                                                        Details
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close"><span
                                                                            aria-hidden="true">×</span></button>
                                                                </div>
                                                                <input type="hidden" name="taskId"
                                                                    value="{{$mtask->id}}">
                                                                <div class="modal-body">
                                                                    <div class="data">
                                                                        <div class="data">
                                                                            <label for="status">Update
                                                                                Status</label><br>
                                                                            <select name="status">
                                                                                <option selected disabled>select
                                                                                </option>
                                                                                <option value="In progress">In progress
                                                                                </option>
                                                                                <option value="completed">Completed
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="model-footer-button" type="button"
                                                                        onclick="statusUpdated({{ $mtask->id }})">Update</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                            <style>
                                            textarea {
                                                border-radius: 5px;
                                                border: 1px solid lightgray;
                                            }

                                            .container {
                                                box-shadow: none !important;
                                            }

                                            main form {
                                                box-shadow: none !important;
                                            }

                                            tr:hover form {
                                                background-color: transparent;
                                            }

                                            #task_done_modal_ {
                                                    {
                                                    $mtask->id
                                                }
                                            }

                                                {
                                                display: none;
                                                position: fixed;
                                                top: 0;
                                                left: 0;
                                                width: 100%;
                                                height: 100%;
                                                background: rgba(0, 0, 0, 0.5);
                                                align-items: center;
                                                justify-content: center;
                                                z-index: 9999;
                                            }

                                            .task-done-popup {
                                                background-color: #fff;
                                                width: 40%;
                                                border-radius: 10px;
                                                padding: 0.5em;
                                            }

                                            .task-done-popup .form-header {
                                                display: flex;
                                                align-items: center;
                                                justify-content: space-evenly;
                                                padding: 0.5em;
                                                border-bottom: 1px solid lightgray;
                                            }

                                            .task-done-popup .data {
                                                width: 100%;
                                                padding: 0.5em;
                                                border-bottom: 1px solid lightgray;
                                            }

                                            .task-done-popup .data .task-attachment {
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                            }

                                            .task-done-popup .data .task-attachment img {
                                                width: 15em !important;
                                                height: 12em !important;
                                                border-radius: 5px;
                                            }

                                            .task-done-popup .form-header #tasknameclose {
                                                padding: 0 1em 0.7em 0;
                                            }

                                            .task-done-popup .form-header .heading {
                                                flex: 1;
                                            }

                                            .task-done-popup .buttons {
                                                width: 100%;
                                                margin: 0;
                                                padding: 1em 0;
                                            }
                                            </style>
                                            <td>
                                                <button class="check" type="button"
                                                    onclick="taskDoneModel({{ $mtask->id }})">
                                                    <img src="{{ asset('Asserts/logo/blue-tick.png') }}">
                                                </button>
                                            </td>
                                            <!-- task done model  -->
                                            <form id="taskDone_{{ $mtask->id }}" action="{{route('task.done')}}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="taskId" value="{{$mtask->id}}">
                                                <div id="task_done_modal_{{ $mtask->id }}">
                                                    <div class="form-wrapper"> </div>
                                                    <div class="form task-done-popup">
                                                        <div class="form-header">
                                                            <div class="heading">
                                                                <p>{{ \Carbon\Carbon::parse($mtask->start_date)->format('d M Y') }}
                                                                </p>
                                                            </div>
                                                            <button style="border: none; background: none;"
                                                                onclick="closeModal({{ $mtask->id }})">
                                                                <img style="padding:none;"
                                                                    src="{{asset('Asserts/logo/cross.png')}}"
                                                                    class="planned-img" id="tasknameclose">
                                                            </button>
                                                        </div>
                                                        <div class="data">
                                                            <div class="datetime-wrapper">

                                                                <div class="activites-heading">
                                                                    <h5 style="margin-top: 0;">Details</h5>
                                                                    <p>{{$mtask->description}}</p>
                                                                </div>
                                                            </div>
                                                            <h5 style="text-align: center;">Task Attancement</h5>
                                                            <div class="task-attachment">
                                                                <img src="{{ asset('/attachment/' . $mtask->attachment) }}"
                                                                    alt="attachment">
                                                            </div>
                                                            <div class="file-container">

                                                            </div>
                                                            <div class="row" style="width: 100%; margin-left: 0.2em;">
                                                                <label for="assign">Remarks <span
                                                                        style="color: lightgray;font-size: 12px;font-style: italic;"></span></label>
                                                                <input type="text" style="height: 7em;"
                                                                    value="{{$mtask->remarks}}">
                                                            </div>
                                                        </div>
                                                        <div class="buttons">
                                                            <button class="restore-btn"
                                                                onclick="closeModal({{ $mtask->id }})">Cancel</button>
                                                            <button type="button" onclick="taskDone({{ $mtask->id }})"
                                                                class="request-btn">
                                                                Mark as Done
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
</main>

@endsection
@push('scripts')

<!-- to make tables as datatables  -->
<script>
$(document).ready(function() {
    var table = $('#tasks').DataTable({
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
    var table = $('#myTasks').DataTable({
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
<!-- kashan script   -->
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

function closeModal(taskId) {
    const modal = document.getElementById(`task_done_modal_${taskId}`);
    if (modal) {
        modal.style.display = 'none';
    }
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let yourtaskbutton = document.getElementById('your-tasks');
    let yourtaskcontainer = document.getElementById('your-tasks-container');
    let yourtaskheader = document.getElementById('your-tasks-header');


    if (yourtaskbutton && yourtaskcontainer && yourtaskheader) {
        yourtaskbutton.addEventListener('click', function() {

            yourtaskcontainer.classList.toggle('show-container');

            if (yourtaskcontainer.classList.contains('show-container')) {
                yourtaskheader.style.borderRadius = '0em';
                yourtaskbutton.style.transform = 'rotate(180deg)';
            } else if (yourtaskheader.classList.contains('container-header')) {
                yourtaskheader.style.borderBottomLeftRadius = '0.7em';
                yourtaskheader.style.borderBottomRightRadius = '0.7em';
                yourtaskbutton.style.transform = 'rotate(360deg)';
            }
        });
    }
});
</script>
<script>
function taskDoneModel(taskId) {
    var modalId = "task_done_modal_" + taskId;
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = "flex";
        document.body.classList.add("modal-open");
    }
}

function closeModal(taskId) {
    var modalId = "task_done_modal_" + taskId;
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = "none";
        document.body.classList.remove("modal-open");
    }
}

window.addEventListener("click", function(event) {
    var modals = document.querySelectorAll("[id^='task_done_modal_']");
    modals.forEach(function(modal) {
        if (event.target === modal) {
            modal.style.display = "none";
            document.body.classList.remove("modal-open");
        }
    });
});
</script>
<!-- open details model  -->
<script>
function openDetailsModal(taskId) {
    var modalId = "task_details_modal_" + taskId;
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
<!-- open update status model  -->
<script>
function openUpdateStatusModal(taskId) {
    var modalId = "update_status_model_" + taskId;
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
<!-- add task script  -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var myForm = document.querySelector('.createTaskForm');
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

                    let task = data.task;
                    let users = data.users;
                    let userName = data.userName;
                    let newRow = `
                            <tr id="row_${task.id}">
                                    <td>${task.id}</td>
                                    <td>${userName}</td>
                                    <td>${moment(task.start_date).format('MM/DD/YYYY')}</td>
                                    <td>${moment(task.due_date).format('MM/DD/YYYY')}</td>
                                    <td>${task.priority}</td>
                                    <td>${task.status}</td>
                                    <td>
                                        <button class="rounded-circle btn btn-primary btn-sm edit-task-table" type="button" data-id="${task.id}">
                                            <img src="{{ asset('Asserts/logo/edit-table.png') }}" />
                                        </button>
                                        <!-- Edit task modal -->
                                        <form id="editTaskForm_${task.id}" action="{{ route('task.edit') }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal" id="edit_task_modal_${task.id}" tabindex="-1" role="dialog" style="z-index: 9999 !important;">
                                                            <div class="modal-dialog modal-xl shadow-lg" role="document" style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                                                <div class="modal-content modal-xl shadow-lg" style="border-radius: 10px;">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="modelHeading">Edit Task</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </button>
                                                                    </div>
                                                                    <input type="hidden" name="taskId" value="${task.id}">
                                                                    <div class="modal-body">
                                                                        <div class="data">
                                                                            <div id="f-danger" class="alert alert-danger" style="display: none;">
                                                                                <ul id="error-list"></ul>
                                                                            </div>
                                                                            <div id="alert-success" class="alert alert-success" style="display: none;"></div>
                                                                            <div class="container">
                                                                                <div class="planned">
                                                                                    <div class="data">
                                                                                        <label for="start_date">Start date</label>
                                                                                        <input type="date" value="${task.start_date}" name="start_date">
                                                                                        <label for="assign_to">Assigned To</label>
                                                                                        <select name="assign_to" >
                                                                                            <option selected value="${task.assign_to}">${userName}</option>
                                                                                            ${users.map(user => `<option value="${user.id}">${user.user_name}</option>`).join('')}
                                                                                        </select>

                                                                                        <label for="description">Description</label>
                                                                                        <input type="text"  name="description" value="${task.description}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="planned">
                                                                                    <div class="data">
                                                                                        <label for="due_date">Due date</label>
                                                                                        <input type="date" value="${task.due_date}" name="due_date">
                                                                                    </div>
                                                                                    <label for="status">Status</label>
                                                                                        <select name="status" >
                                                                                            <option value="Not started" ${task.status === 'Not started' ? 'selected' : ''}>Not started</option>
                                                                                            <option value="In progress" ${task.status === 'In progress' ? 'selected' : ''}>In progress</option>
                                                                                            <option value="Completed" ${task.status === 'Completed' ? 'selected' : ''}>Completed</option>
                                                                                        </select>
                                                                                </div>
                                                                                <div class="planned">
                                                                                    <div class="data">
                                                                                        <label for="priority">Priority</label>
                                                                                    <select name="priority" >
                                                                                        <option value="high" ${task.priority === 'high' ? 'selected' : ''}>high</option>
                                                                                        <option value="medium" ${task.priority === 'medium' ? 'selected' : ''}>medium</option>
                                                                                        <option value="low" ${task.priority === 'low' ? 'selected' : ''}>low</option>
                                                                                    </select>

                                                                                    </div>
                                                                                    <label for="location">Location</label>
                                                                                    <input type="text"  value="${task.location}" name="location">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" onclick="taskEdit(${task.id})" class="request-btn">Save</button>
                                                                        <button type="button" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                        </form>
                                    </td>
                                    <td>
                                        <button style="border: #E94D65 !important; background-color: #E94D65 !important;" data-id="${task.id}" class="rounded-circle btn btn-primary btn-sm delete-task" type="button">
                                            <img src="{{ asset('Asserts/logo/delete.png') }}" />
                                        </button>
                                    </td>
                            </tr>
                        `;
                    document.querySelector('#tasks tbody').insertAdjacentHTML('beforeend', newRow);

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

    // Function to register event listener for edit table buttons
    function registerEditTableButtons() {
        document.querySelectorAll('.edit-task-table').forEach(function(button) {
            button.addEventListener('click', function() {
                var userId = button.getAttribute('data-id');
                openEditTaskModal(userId);
            });
        });
    }

    // Initial registration of edit table buttons event listener
    registerEditTableButtons();

    $(document).on('click', '.delete-task', function() {
        var taskId = $(this).data('id');
        if (confirm('Are you sure you want to delete this task?')) {
            $.ajax({
                url: '/destroyTask/' + taskId,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#row_' + taskId).remove();
                    alert('Task deleted successfully');
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

function openEditTaskModal(userId) {
    var modalId = "edit_task_modal_" + userId;
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
<!-- edit task script  -->
<script>
function taskEdit(taskId) {
    var formData = new FormData(document.getElementById('editTaskForm_' + taskId));
    axios.post('{{ route('task.edit') }}',
            formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
        .then(function(response) {
            var data = response.data;
            showSuccessAlert('Task updated successfully!');
            var rowId = 'row_' + data.taskId;
            var tableRow = document.getElementById(rowId);
            if (tableRow) {
                tableRow.cells[0].textContent = data.task.id;
                tableRow.cells[1].textContent = data.userName;
                tableRow.cells[2].textContent = data.task.start_date;
                tableRow.cells[3].textContent = data.task.due_date;
                tableRow.cells[4].textContent = data.task.priority;
                tableRow.cells[5].textContent = data.task.status;
            }
            var modalId = 'edit_task_modal_' + data.taskId;
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
<!-- to mark as done  -->
<script>
function taskDone(taskId) {
    var formData = new FormData(document.getElementById('taskDone_' + taskId));
    axios.post('{{ route("task.done") }}', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(function(response) {
            var data = response.data;
            showSuccessAlert('Task done successfully!');
            var modalId = 'task_done_modal_' + data.taskId;
            var modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'none';
            }
            document.body.style.overflow = 'auto';
            var row = document.getElementById('myTaskTableRow_' + data.taskId);
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
<!-- to update status  -->
<script>
function statusUpdated(taskId) {
    var formData = new FormData(document.getElementById('update_status_form_' + taskId));
    axios.post('{{ route("task.update.status") }}', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(function(response) {
            var data = response.data;
            showSuccessAlert('Task done successfully!');
            var modalId = 'update_status_model_' + data.taskId;
            var modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'none';
            }
            document.body.style.overflow = 'auto';
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