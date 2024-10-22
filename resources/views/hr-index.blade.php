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
</style>
<div id="alert-danger" class="alert alert-danger" style="display: none;">
    <ul id="error-list"></ul>
</div>
<div id="alert-success" class="alert alert-success" style="display: none;"></div>
<div class="container1">
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


    <div class="section2" style="width: 54%;margin-top: 0;">
        <div class="Cards" style="width: 100%;">
            <div class="Cards-header">
                <div class="name">
                    <h3>Attendence</h3>
                </div>
            </div>

            <div class="card-detail" style="height: 45em; overflow: auto;">
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
                            <a style="color: black !important;"
                                href="{{route('allAttendance' , $attendance->user->id )}}">
                                <h6>{{$attendance->user->user_name}}</h6>
                            </a>
                            <a style="color: black !important;"
                                href="{{route('allAttendance' , $attendance->user->id )}}">
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

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
@endpush