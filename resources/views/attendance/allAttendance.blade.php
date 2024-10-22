@extends("layouts.app")

@section('content')
<style>
.filled-input {
    border: 2px solid green !important;
}

.error-input {
    border: 2px solid red !important;
}

input[type='number']::-webkit-outer-spin-button,
input[type='number']::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type='number'] {
    -moz-appearance: textfield;
}

#records {
    table-layout: fixed;
    width: 100%;
}

#records thead tr th,
#records tbody tr td {
    width: 10em;
    white-space: nowrap;
    overflow: hidden;
    font-size: 12px;
    border-bottom: 1px solid lightgray;
}

#records tbody tr td {
    overflow-x: auto;
    max-width: 10em;
}

#records tbody tr td::-webkit-scrollbar {
    width: 3px;
    height: 0px;
}

#records tbody tr td::-webkit-scrollbar-track {
    background: none;
}

#records tbody tr td::-webkit-scrollbar-thumb {
    background: #e94d65;
}

#records tbody tr td::-webkit-scrollbar-thumb:hover {
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

#searchForm {
    text-align: center;
    background-color: #2d6d8b;
    color: white;
    padding: 4px 7px;
    border-radius: 5px;
    transition: 0.4s ease;
    border: none;
    text-wrap: nowrap;
}

#searchForm:hover {
    letter-spacing: 1px;
}

.label {
    padding-top: 0 !important;
    margin-bottom: 0 !important;
}
.conform-table {
  background-color: #2D6D8B !important;
  border: #2D6D8B;
  border-radius: 5px;
  color: white !important;
  display: flex;
  align-items: center;
  justify-content: space-around;
}
</style>
<div id="alert-danger" class="alert alert-danger" style="display: none;">
            <ul id="error-list"></ul>
        </div>
        <div id="alert-success" class="alert alert-success" style="display: none;"></div>
<div style="display:flex;align-items:center;justify-content:center;">
    <h3>{{$username}}, Attendance</h3>
</div>
<form action="{{route('allAttendance' , $id)}}" method="get"
    style="display:flex;align-items:end;justify-content:start; padding: 1em; gap: 0.5em; background-color: transparent; box-shadow: none;">
    <div>
        <label for="from_date" class="label">Start Date</label>
        <input type="date" class="input" name="from_date">
    </div>
    <div>
        <label for="to_date" class="label">End Date</label>
        <input type="date" class="input" name="to_date">
    </div>
    <div>
        <button type="submit" id="searchForm">Filter</button>
    </div>
</form>
<div class="data-container datatable datatable-container">
    <div class="data-table-container scrollable-table">
        <table id="records" class="table table-sm table-hover table-bordered" style="width: 79vw;">
            <thead>
                <tr class="table-header">
                    <th>User ID</th>
                    @if(AdminOrHrManager())
                        <th>Edit</th>
                    @endif    
                    <th>Name</th>
                    <th>Role</th>
                    <th>Date</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Break</th>
                    <th>Worked Hours</th>
                    @if(AdminOrHrManager())
                        <th>Delete</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $attendance)
                <tr id="row_{{ $attendance->id }}">
                    <td>{{ $attendance->user->user_id ?? 'N/A' }}</td>
                    @if(AdminOrHrManager())
                        <td>
                            <button  class="btn btn-sm btn-primaryy conform-table" type="button" onclick="openModal({{ $attendance->id }})">
                                Edit
                            </button>
                            <form  method="post" action="{{route('attendance.update')}}" id="updateAttendanceForm_{{ $attendance->id }}">
                                @csrf
                                <div class="modal" id="attendance_modal_{{ $attendance->id }}" tabindex="-1"
                                    role="dialog">
                                    <div class="modal-dialog modal-xl shadow-lg" role="document"
                                        style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                        <div class="modal-content modal-xl shadow-lg" style="border-radius: 10px;">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modelHeading">Update Attendace</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <input type="hidden" name="attendance_id" value="{{$attendance->id}}">
                                            <div class="modal-body">
                                                <div class="data">
                                                    <div class="datetime-wrapper">
                                                        <div class="date-time">
                                                            <label for="in" class="label"
                                                                style="padding-top: 0">Check In</label>
                                                            <input type="string" id="in"
                                                                name="in" value="{{$attendance->in}}">
                                                        </div>
                                                        <div class="date-time">
                                                            <label for="out" style="padding-top: 0">Check Out</label>
                                                            <input type="string" id="out"
                                                                name="out" value="{{$attendance->out}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button onclick="updateAttendance({{ $attendance->id }})" type="button">Update</button>
                                                <button type="button" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </td>
                    @endif
                    <td>{{ $attendance->user->user_name ?? 'N/A' }}</td>
                    <td>{{ $attendance->user->role->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y')}}</td>
                    <td>{{ $attendance->in ?? 'N/A' }}
                        @if($attendance->in2)
                        <span>, {{ $attendance->in2 }}</span>
                        @endif
                    </td>
                    <td>{{ $attendance->out ?? 'N/A' }}
                        @if($attendance->out2)
                        <span>, {{ $attendance->out2 }}</span>
                        @endif
                    </td>
                    <td>{{ $attendance->break ?? '-' }}</td>
                    <td>{{ $attendance->worked_hours ?? 'N/A' }}</td>
                    @if(AdminOrHrManager())
                        <td>
                            <button style="border: #E94D65 !important; background-color: #E94D65 !important;"
                                data-id="{{ $attendance->id }}" class="rounded-circle btn btn-primary btn-sm delete-attendance"
                                type="button">
                                <img src="{{ asset('Asserts/logo/delete.png') }}" />
                            </button>
                        </td>
                    @endif    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).on('click', '.delete-attendance', function() {
    var attendanceId = $(this).data('id');
    if (confirm('Are you sure you want to delete this?')) {
        $.ajax({
            url: '/deleteAttendance/' + attendanceId,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#row_' + attendanceId).remove();
                alert(' Deleted successfully');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
});
</script>
<script>
    function openModal(attendanceId) {
        var modalId = "attendance_modal_" + attendanceId;
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
<script>
    function updateAttendance(attendanceId) {
        var formData = new FormData(document.getElementById('updateAttendanceForm_' + attendanceId));
        var errorAlert = document.getElementById('alert-danger');
        var errorList = document.getElementById('error-list');
        var successAlert = document.getElementById('alert-success');
        axios.post('{{ route("attendance.update") }}', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                var data = response.data;
                if (data.success) {
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
                        var modalId = 'attendance_modal_' + data.attendanceId;
                        var modal = document.getElementById(modalId);
                        if (modal) {
                            modal.style.display = 'none';
                            modal.classList.remove('show');
                        }
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        window.location.reload();
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
@endpush