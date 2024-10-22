@extends("layouts.app")
@section('content')

<style>
    body {
        grid-auto-rows: 0.19fr 1fr;
    }

    .filled-input {
        border: 2px solid green !important;
    }

    .error-input {
        border: 2px solid red !important;
    }
</style>
<form id="myProjectForm" action="{{route('project.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div id="alert-danger" class="alert alert-danger" style="display: none;">
        <ul id="error-list"></ul>
    </div>
    <div id="alert-success" class="alert alert-success" style="display: none;"></div>
    <div class="container" style="flex-direction: column;">

        <div class="planned" style="width: 50%;padding: 1em; width: 100% !important;">
            <div class="activity-detail-name" style="border: none;">
                <h2>Add Projects</h2>
                <p>Adding New Projects</p>
            </div>
            <div class="data-wrapper" style="padding-bottom: 0; align-items: start; border-bottom: none !important;">
                <div class="data" style="width: 50% !important; padding-right: 0.2em;">
                    <label for="customerName">Customer Name</label>
                    <select id="customerName" name="client_id">
                        <option>Select Customer</option>
                        @foreach($clients as $client)
                        <option value="{{$client->id}}">{{$client->company_name}}</option>
                        @endforeach
                    </select>

                    <label for="projectName">Project Name</label>
                    <input type="text" id="projectName" name="project_name">

                    <label for="projectSDM">Project SDM</label>
                    <input type="text" id="projectSDM" name="project_sdm">

                </div>

            </div>
        </div>
    </div>

    <div class="available-resource-form-btns" style="justify-content: end !important;">
        <button class="restore-btn" type="reset">
            Reset
        </button>
        <button class="request-btn" type="submit"
            style="width: 9em !important;display: flex; align-items: center; justify-content: space-evenly;padding: 0.2em;">
            <img src="{{asset('/Asserts/logo/save-record.png')}}">
            <span style="padding-top: 2px;">Save Record</span>
        </button>
    </div>
</form>

@endsection
@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {

        var myForm = document.getElementById('myProjectForm');

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

                            // Focus on the first invalid input field
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