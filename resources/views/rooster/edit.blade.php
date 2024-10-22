@extends("layouts.app")
@section('content')
<style>
    .filled-input {
        border: 2px solid green !important;
    }

    .error-input {
        border: 2px solid red !important;
    }

    body {
        grid-auto-rows: 0.0fr 1fr;
    }
</style>
<form class="roosterForm" action="{{ route('rooster.update', $rooster->id) }}" method="post">
    @csrf
    <div id="alert-danger" class="alert alert-danger" style="display: none;">
        <ul id="error-list"></ul>
    </div>
    <div id="alert-success" class="alert alert-success" style="display: none;"></div>

    <div class="container" style="flex-direction: column;">
        <div class="planned" style="width: 50%;padding: 1em; width: 100% !important;">
            <div class="activity-detail-name" style="border: none;">
                <h2>Update Rooster</h2>
            </div>
            <div class="data-wrapper" style="padding-bottom: 0; align-items: start; border-bottom: none !important;">
                <div class="data" style="width: 50% !important; padding-right: 0.2em;">

                    <label for="user_id">Select User</label>
                    <select name="user_id">
                        <option selected disabled>select user</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $rooster->user_id ? 'selected' : '' }}>
                                {{ $user->user_name }}
                            </option>
                        @endforeach
                    </select>

                    <label for="start_date">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $rooster->start_date }}">

                </div>
                <div class="data" style="width: 50% !important; padding-left: 0.2em;">

                    <label for="type">Select Type</label>
                    <select name="type">
                        <option selected disabled>select type</option>
                        <option value="present" {{ $rooster->type == 'present' ? 'selected' : '' }}>Present</option>
                        <option value="absent" {{ $rooster->type == 'absent' ? 'selected' : '' }}>Absent</option>
                    </select>

                    <label for="end_date">End Date</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $rooster->end_date }}">

                </div>
            </div>
        </div>
    </div>

    <!-- New Section for Override Dates -->
    <div class="container" style="flex-direction: column;">
        <div class="planned" style="width: 50%;padding: 1em; width: 100% !important;">
            <div class="activity-detail-name" style="border: none;">
                <h3>Override Specific Dates</h3>
            </div>
            <div class="data-wrapper" style="padding-bottom: 0; align-items: start; border-bottom: none !important;">
                <div class="data" style="width: 100% !important; padding-right: 0.2em;">

                    <label for="override_dates">Select Dates to Override</label>
                    <input type="text" id="override_dates" name="override_dates" placeholder="YYYY-MM-DD, YYYY-MM-DD" value="{{ $overrideDatesString ?? '' }}">

                    <label for="override_type">Override Type</label>
                    <select name="override_type">
                        <option selected disabled>select type</option>
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                    </select>

                </div>
            </div>
        </div>
    </div>

    <div class="available-resource-form-btns" style="justify-content: center !important;">
        <button class="restore-btn" id="resetButton" type="reset">
            Reset
        </button>

        <button class="request-btn" type="submit" style="width: 9em !important; display: flex; align-items: center; justify-content: space-evenly; padding: 0.2em;">
            <img src="{{ asset('/Asserts/logo/save-record.png') }}">
            <span style="padding-top: 2px;">Update</span>
        </button>
    </div>
</form>

@endsection
@push('scripts')

<!-- to store rooster  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myForm = document.querySelector('.roosterForm');
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
                        window.location.href = '{{ route("rooster.index") }}';
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

<!-- to reset form  -->
<script>
    document.getElementById('resetButton').addEventListener('click', function() {
        document.querySelector('.roosterForm').reset();
    });
</script>
@endpush