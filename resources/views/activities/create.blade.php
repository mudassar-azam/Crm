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

    [data-select2-id="1"] {
        width: 100%!important;
    }
</style>
<form id="activityForm" method="post" action="{{ route('activity.store') }}" enctype="multipart/form-data">
    @csrf
    <div id="alert-danger" class="alert alert-danger" style="display: none;">
        <ul id="error-list"></ul>
    </div>
    <div id="alert-success" class="alert alert-success" style="display: none;"></div>
    <div class="container">
        <div class="planned">
            <div class="activity-detail-name">
                <h2>Activity Details</h2>
                <p>Start New Activities</p>
            </div>
            <div class="data">

                <label for="ticket_detail">Ticket Detail</label>
                <input type="text" id="ticket_detail" name="ticket_detail">

                <label for="email_screenshot">Email Screenshot</label>
                <input type="file" id="email_screenshot" name="email_screenshot">

                <label for="activity_start_date">Activity Start Date</label>
                <input type="datetime-local" id="activity_start_date" name="activity_start_date">

                <label for="location">Location</label>
                <input type="text" id="location" name="location">

                <label for="activity_description">Activity Description</label>
                <input type="text" id="activity_description" name="activity_description">
            </div>
        </div>

        <div class="planned">
            <div class="activity-detail-name">
                <h2>Tech Details</h2>
                <p>Add Payment mwthod for paying</p>
            </div>
            <div class="data">

                <label for="countrySelect">Tech Country</label>
                <select name="tech_country_id" id="country_id">
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>

                <label for="tech_city">Tech City</label>
                <select id="city" name="tech_city" required>
                    <option>Select City</option>
                </select>

                <label for="resourceSelect">Tech Name</label>
                <select name="resource_id" id="resourceSelect">
                    <option >Select Tech</option>
                </select>

                <label for="tech_service_type">Tech Service Type</label>
                <select name="tech_service_type" >
                    <option selected disabled>Select Service Type</option>
                    <option value="Hourly">Hourly rate</option>
                    <option value="Half Day">Half Day rate</option>
                    <option value="Full Day">Full Day rate</option>
                    <option value="Weekly">Weekly rate</option>
                    <option value="Monthly">Monthly rate</option>
                </select>

                <label for="techRates">Tech Rates</label>
                <input name="tech_rates" type="text" id="techRates" placeholder="rates">
                
                <label for="tech_currency">Currency</label>
                <select name="tech_currency_id" id="tech_currency">
                    <option>Select Currency</option>
                    @foreach($currencies as $currency)
                    <option value="{{$currency->id}}">{{$currency->code}}-{{$currency->symbol}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="planned">
            <div class="activity-detail-name">
                <h2>Customer Details</h2>
                <p>Start New Activities</p>
            </div>

            <div class="data">
                <label for="clientSelect">Customer Name</label>
                <select name="client_id" id="clientSelect">
                    <option value="">Select Customer</option>
                    @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->company_name }}</option>
                    @endforeach
                </select>

                <div id="projectContainer" style="display:none;">
                    <label for="projectSelect">Project Name</label>
                    <select name="project_id" id="projectSelect">
                        <option value="">Select Project</option>
                    </select>
                    <label for="projectSdm">Project SDM</label>
                    <input name="project_sdm" type="text" id="projectSdm" value="">
                    <label for="po_number">Project PO</label>
                    <input type="text" name="po_number" id="po_number">
                </div>
                <label for="customer_service_type">Costomer Service Type</label>
                <select name="customer_service_type" id="customer_service_type">
                    <option selected disabled>Select Service Type</option>
                    <option value="Hourly">Hourly rate</option>
                    <option value="Half Day">Half Day rate</option>
                    <option value="Full Day">Full Day rate</option>
                    <option value="Weekly">Weekly rate</option>
                    <option value="Monthly">Monthly rate</option>
                </select>

                <label for="customer_rates">Customer Rates</label>
                <input id="customer_rates" name="customer_rates" type="text" placeholder="rates">

                <label for="client_currency">Currency</label>

                <select name="customer_currency_id" id="client_currency">
                    <option>Select Currency</option>
                    @foreach($currencies as $currency)
                    <option value="{{$currency->id}}">{{$currency->code}}-{{$currency->symbol}}</option>
                    @endforeach
                </select>

            </div>
        </div>
    </div>
    </div>
    <div class="available-resource-form-btns" style="justify-content: end !important;">
        <button type="reset" class="restore-btn">
            Restore
        </button>

        <button type="submit" class="request-btn">
            Create Activity
        </button>
    </div>
</form>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    $(document).ready(function() {
        $('#country_id').select2({
            placeholder: 'Select Country',
            allowClear: true
        });
    });
</script>
<!-- aqibs script  -->
<script>
    document.getElementById('resourceSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var hourlyRate = selectedOption.getAttribute('data-hourly-rate');
        var halfDayRate = selectedOption.getAttribute('data-half-day-rate');
        var dailyRate = selectedOption.getAttribute('data-daily-rate');
        var techRatesInput = document.getElementById('techRates');
        var serviceTypeSelect = document.getElementById('serviceTypeSelect');
        serviceTypeSelect.innerHTML = ''; // Clear existing options

        if (hourlyRate) {
            var hourlyOption = document.createElement('option');
            hourlyOption.value = 'Hourly';
            hourlyOption.text = 'Hourly rate';
            serviceTypeSelect.add(hourlyOption);
            techRatesInput.value = hourlyRate;
        }
        if (halfDayRate) {
            var halfDayOption = document.createElement('option');
            halfDayOption.value = 'Half-day';
            halfDayOption.text = 'Half-day rate';
            serviceTypeSelect.add(halfDayOption);
            techRatesInput.value = halfDayRate;
        }
        if (dailyRate) {
            var dailyOption = document.createElement('option');
            dailyOption.value = 'Daily';
            dailyOption.text = 'Daily rate';
            serviceTypeSelect.add(dailyOption);
            techRatesInput.value = dailyRate;
        }
    });
    var clients = @json($clients);
    $(document).ready(function() {
        $('#clientSelect').on('change', function() {
        var clientId = $(this).val();
        var projectContainer = $('#projectContainer');
        var projectSelect = $('#projectSelect');
        var projectSdmInput = $('#projectSdm');

        projectSelect.empty(); 
        projectSelect.append('<option value="">Select Project</option>'); 
        projectSdmInput.val('');

        if (clientId) {
            var selectedClient = clients.find(client => client.id == clientId);
            if (selectedClient && selectedClient.projects.length > 0) {
                selectedClient.projects.forEach(project => {
                    projectSelect.append('<option value="' + project.id + '" data-sdm="' +
                        project.project_sdm + '">' + project.project_name + '</option>');
                });
            }
            projectSelect.append('<option value="other">Other Project</option>'); // Always append "Other Project"
            projectContainer.show(); 
        } else {
            projectContainer.hide();
        }
    });


        $('#projectSelect').on('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var projectSdm = selectedOption.getAttribute('data-sdm');

            if (selectedOption.value === "other") {
                var clientId = $('#clientSelect').val();
                var selectedClient = clients.find(client => client.id == clientId);
                projectSdm = selectedClient ? selectedClient.company_name : '';
            }

            $('#projectSdm').val(projectSdm || ''); // Set project_sdm input value
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myForm = document.getElementById('activityForm');
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
                        window.location.href = '{{ route("activities.planed") }}';
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
<script>
    $(document).ready(function() {
        $('#country_id').change(function() {
            var country_id = $(this).val();
            if (country_id) {
                axios.get('/getCities/' + country_id)
                    .then(function(response) {
                        $('#city').empty();
                        $('#city').append('<option>Select City</option>');
                        $.each(response.data, function(key, value) {
                            $('#city').append('<option value="' + value.name + '">' + value.name + '</option>');
                        });
                    })
                    .catch(function(error) {
                        console.error('Error fetching cities: ' + error);
                    });
            } else {
                $('#city').empty();
                $('#city').append('<option>Select City</option>'); 
            }
        });

        $('#city').change(function() {
            var city = $(this).val();
            if (city) {
                axios.get('/getResources/' + city)
                    .then(function(response) {
                        $('#resourceSelect').empty(); 
                        $('#resourceSelect').append('<option>Select Tech </option>');
                        $.each(response.data, function(key, value) {
                            $('#resourceSelect').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    })
                    .catch(function(error) {
                        console.error('Error fetching resources:', error);
                    });
            } else {
                $('#resourceSelect').empty();
                $('#resourceSelect').append('<option>Select Tech </option>'); 
            }
        });
    });
</script>
@endpush