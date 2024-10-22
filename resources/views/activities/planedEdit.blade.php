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
</style>

<form id="myformupdate" method="post" action="{{ route('activity.planed.update', ['id' => $activity->id]) }}"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
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
                <input type="text" id="ticket_detail" value="{{$activity->ticket_detail}}" name="ticket_detail">
                <label for="email_screenshot">Email Screenshot</label>
                <input type="file" id="email_screenshot" name="email_screenshot">
                <label for="activity_start_date">Activity Start Date</label>
                <input type="datetime-local" id="activity_start_date" value="{{$activity->activity_start_date}}"
                    name="activity_start_date">
                <label for="location">Location</label>
                <input type="text" id="location" value="{{$activity->location}}" name="location">
                <label for="activity_description">Activity Description</label>
                <input type="text" id="activity_description" value="{{$activity->activity_description}}"
                    name="activity_description">
                @if($activity->activity_status != 'pending')
                @if($activity->activity_status == 'confirmed')
                <label for="activity_status">Activity Status</label>
                <select name="activity_status" id="activity_status">
                    <option selected value="{{$activity->activity_status}}">{{$activity->activity_status}}</option>
                    <option value="pending">pending</option>
                </select>
                @elseif($activity->activity_status == 'closed')
                <label for="activity_status">Activity Status</label>
                <select name="activity_status" id="activity_status">
                    <option selected value="{{$activity->activity_status}}">{{$activity->activity_status}}</option>
                    <option value="pending">pending</option>
                    <option value="confirmed">confirmed</option>
                </select>
                @elseif($activity->activity_status == 'approved')
                <label for="activity_status">Activity Status</label>
                <select name="activity_status" id="activity_status">
                    <option selected value="{{$activity->activity_status}}">{{$activity->activity_status}}</option>
                    <option value="pending">pending</option>
                    <option value="confirmed">confirmed</option>
                    <option value="closed">closed</option>
                </select>
                @endif
                @endif

            </div>
        </div>

        <div class="planned">
            <div class="activity-detail-name">
                <h2>Tech Details</h2>
                <p>Add Payment mwthod for paying</p>
            </div>
            <div class="data">
                <label for="countrySelect">Tech Country</label>
                <select name="tech_country_id" id="country_id" class="form-control" {{ $activity->activity_status !== 'pending' ? 'disabled' : '' }}>
                    <option>
                        {{ $activity->country->name }}
                    </option>
                </select>

                <label for="tech_city">Tech City</label>
                <select name="tech_city" {{ $activity->activity_status !== 'pending' ? 'disabled' : '' }}>
                    <option value="{{ $activity->tech_city }}">{{ $activity->tech_city }}</option>
                </select>


                <label>Tech Name</label>
                <select name="resource_id" {{ $activity->activity_status !== 'pending' ? 'disabled' : '' }}>
                    <option selected value="{{$activity->resource->id }}">{{ $activity->resource->name }}</option>
                </select>


                <label for="serviceTypeSelect">Tech Service Type</label>
                <select name="tech_service_type" class="form-control">
                    <option value="Hourly" @if(isset($activity->tech_service_type) &&
                        $activity->tech_service_type == 'Hourly')
                        selected
                        @endif
                        >Hourly rate</option>
                    <option value="Half Day" @if(isset($activity->tech_service_type) &&
                        $activity->tech_service_type == 'Half Day')
                        selected
                        @endif
                        >Half Day rate</option>
                    <option value="Full Day" @if(isset($activity->tech_service_type) &&
                        $activity->tech_service_type == 'Full Day')
                        selected
                        @endif
                        >Full Day rate</option>
                    <option value="Weekly" @if(isset($activity->tech_service_type) &&
                        $activity->tech_service_type == 'Weekly')
                        selected
                        @endif
                        >Weekly rate</option>
                    <option value="Monthly" @if(isset($activity->tech_service_type) &&
                        $activity->tech_service_type == 'Monthly')
                        selected
                        @endif
                        >Monthly rate</option>
                </select>

                <label for="techRates">Tech Rates</label>
                <input name="tech_rates" type="text" id="techRates" value="{{$activity->tech_rates}}">

                <label for="tech_currency">Currency</label>


                <select name="tech_currency_id" id="tech_currency">
                    <option>Select Currency</option>
                    @foreach($currencies as $currency)
                    <option value="{{$currency->id}}" @if(isset($activity->tech_currency_id)
                        &&$activity->tech_currency_id == $currency->id)
                        selected
                        @endif
                        >{{$currency->code}}-{{$currency->symbol}}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="planned">
            <div class="activity-detail-name">
                <h2>Activity Details</h2>
                <p>Start New Activities</p>
            </div>
            <div class="data">
                <label for="clientSelect">Customer Name</label>
                <select name="client_id" id="clientSelect" {{ $activity->activity_status !== 'pending' ? 'disabled' : '' }}>
                    @foreach($clients as $client)
                    <option value="{{ $client->id }}" @if(isset($activity->client->id) && $activity->client->id ==
                        $client->id)
                        selected
                        @endif
                        >{{ $client->company_name }}
                    </option>
                    @endforeach
                </select>

                <div id="projectContainer" style="display:block;">
                    <label for="projectSelect">Project Name</label>
                    <select name="project_id" id="projectSelect" {{ $activity->activity_status !== 'pending' ? 'disabled' : '' }}>
                        @if($activity->client->projects)
                            @foreach($projects as $project)
                            <option value="{{$project->id}}" @if(isset($activity->project->id) && $activity->project->id ==
                                $project->id)
                                selected
                                @endif
                                >{{$project->project_name}}</option>
                            @endforeach
                        @endif
                        <option value="other" selected>other</option>
                    </select>

                    <label for="projectSdm">Project Sdm</label>
                    <input name="project_sdm" type="text" id="projectSdm" value="{{$activity->client->company_name}}" {{ $activity->activity_status !== 'pending' ? 'disabled' : '' }}>
                    <label for="po_number">Project PO</label>
                    <input type="text" name="po_number" id="po_number" value="{{$activity->po_number}}" {{ $activity->activity_status !== 'pending' ? 'disabled' : '' }}>
                </div>
                <label for="customer_service_type">Costomer Service Type</label>

                <select name="customer_service_type" id="serviceTypeSelect" class="form-control">
                    <option value="Hourly" @if(isset($activity->customer_service_type) &&
                        $activity->customer_service_type == 'Hourly')
                        selected
                        @endif
                        >Hourly rate</option>
                    <option value="Half Day" @if(isset($activity->customer_service_type) &&
                        $activity->customer_service_type == 'Half Day')
                        selected
                        @endif
                        >Half Day rate</option>
                    <option value="Full Day" @if(isset($activity->customer_service_type) &&
                        $activity->customer_service_type == 'Full Day')
                        selected
                        @endif
                        >Full Day rate</option>
                    <option value="Weekly" @if(isset($activity->customer_service_type) &&
                        $activity->customer_service_type == 'Weekly')
                        selected
                        @endif
                        >Weekly rate</option>
                    <option value="Monthly" @if(isset($activity->customer_service_type) &&
                        $activity->customer_service_type == 'Monthly')
                        selected
                        @endif
                        >Monthly rate</option>
                </select>


                <label for="customer_rates">Costomer Rates</label>
                <input id="customer_rates" name="customer_rates" type="text" value="{{$activity->customer_rates}}">

                <label for="client_currency">Currency</label>

                <select name="customer_currency_id" id="client_currency">
                    @foreach($currencies as $currency)
                    <option value="{{$currency->id}}" @if(isset($activity->customer_currency_id) &&
                        $activity->customer_currency_id == $currency->id)
                        selected
                        @endif
                        >{{$currency->code}}-{{$currency->symbol}}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>

    </div>

    <div class="available-resource-form-btns" style="justify-content: end !important;">
        <button type="button" onclick="updateResource()" class="request-btn">Update</button>
    </div>
</form>
@endsection
@push('scripts')
<!-- aqibs script  -->
<script>
    document.getElementById('citySelect').addEventListener('change', function() {
        var countryId = this.options[this.selectedIndex].getAttribute('data-country');
        document.getElementById('countrySelect').value = countryId;
    });

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
            hourlyOption.value = 'hourly';
            hourlyOption.text = 'Hourly rate';
            serviceTypeSelect.add(hourlyOption);
            techRatesInput.value = hourlyRate;
        }
        if (halfDayRate) {
            var halfDayOption = document.createElement('option');
            halfDayOption.value = 'half-day';
            halfDayOption.text = 'Half-day rate';
            serviceTypeSelect.add(halfDayOption);
            techRatesInput.value = halfDayRate;
        }
        if (dailyRate) {
            var dailyOption = document.createElement('option');
            dailyOption.value = 'daily';
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

            projectSelect.empty(); // Clear existing options
            projectSelect.append('<option value="">Select Project</option>'); // Add default option
            projectSdmInput.val(''); // Clear project_sdm field

            if (clientId) {
                var selectedClient = clients.find(client => client.id == clientId);
                if (selectedClient && selectedClient.projects.length > 0) {
                    alert("exist");
                    selectedClient.projects.forEach(project => {
                        projectSelect.append('<option value="' + project.id + '" data-sdm="' +
                            project.project_sdm + '">' + project.project_name + '</option>');
                    });
                    projectContainer.show(); // Show project dropdown and project_sdm input
                } else {

                    projectContainer.show(); // Show project dropdown and project_sdm input if no projects
                    projectSelect.append(
                        '<option value="other">Other Project</option>'); // Add "Other Project" option
                    projectSdmInput.val(''); // Clear project_sdm input field
                }
            } else {
                projectContainer
                    .hide(); // Hide project dropdown and project_sdm input if no client selected
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
    var myForm = document.getElementById('myformupdate');

    // Function to handle input events
    myForm.addEventListener('input', function(event) {
        if (event.target.tagName === 'INPUT' || event.target.tagName === 'TEXTAREA') {
            if (event.target.value.trim() !== '') {
                event.target.style.border = '';
                event.target.classList.remove('error-input'); // Remove red border
                if (event.target.type === 'file') {
                    event.target.classList.remove('file-not-valid');
                }
            }
        }
    });

    // Function to handle change events
    myForm.addEventListener('change', function(event) {
        if (event.target.tagName === 'SELECT') {
            if (event.target.value.trim() !== '') {
                event.target.style.border = '';
                event.target.classList.remove('error-input'); // Remove red border
                if (event.target.type === 'file') {
                    event.target.classList.remove('file-not-valid');
                }
            }
        }
    });

    function updateResource() {
        // Gather form data
        var formData = new FormData(document.getElementById('myformupdate'));

        // Make Axios request
        axios.post('{{ route("activity.planed.update", ["id" => $activity->id]) }}', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response.data);
                showSuccessAlert('Activity updated successfully!');
                window.location.href = '{{ route("activities.planed") }}';
            })
            .catch(function(error) {
                console.log(error);
                if (error.response.status === 422) {
                    var errors = error.response.data.errors;
                    if (errors.length > 0) {
                        var errorMessage = errors[0].message;
                        showAlert(errorMessage);

                        // Find the input fields that failed validation
                        var fieldsWithError = errors.map(function(error) {
                            return error.field;
                        });

                        // Make input borders red only for the fields that failed validation
                        fieldsWithError.forEach(function(fieldWithError, index) {
                            var input = document.querySelector('[name="' + fieldWithError + '"]');
                            if (input) {
                                // Check if input is empty
                                if (input.value.trim() === '') {
                                    input.classList.add('error-input');
                                    // Focus on the first input field with an error
                                    if (index === 0) {
                                        input.focus();
                                    }
                                    // Check if the input field is of type file and add 'file-not-valid' class
                                    if (input.type === 'file') {
                                        input.classList.add('file-not-valid');
                                    }
                                }
                            }
                        });
                    }
                }
                // Handle other errors, show error messages or log them
            });
    }

    function showAlert(message) {
        var errorList = document.getElementById('error-list');
        var errorItem = document.createElement('li');
        errorItem.textContent = message;
        errorList.appendChild(errorItem);
        var alertDiv = document.getElementById('alert-danger');
        alertDiv.style.display = 'block';
        // Scroll to the top of the page
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        setTimeout(function() {
            alertDiv.style.display = 'none';
            errorList.innerHTML = ''; // Clear error list after timeout
        }, 3000); // 3000 milliseconds = 3 seconds
    }

    function showSuccessAlert(message) {
        var successAlert = document.getElementById('alert-success');
        successAlert.textContent = message;
        successAlert.style.display = 'block';

        // Scroll to the top of the page
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        setTimeout(function() {
            successAlert.style.display = 'none';
        }, 3000); // 3000 milliseconds = 3 seconds
    }
</script>

@endpush