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
<form id="myForm" method="post" action="{{ route('resource.store') }}" enctype="multipart/form-data">
    @csrf
    <div id="alert-danger" class="alert alert-danger" style="display: none;">
        <ul id="error-list"></ul>
    </div>
    <div id="alert-success" class="alert alert-success" style="display: none;"></div>
    <div class="container" style="flex-direction: column; box-shadow: none;">
        <div class="planned" style="width: 50%;padding: 1em; width: 100% !important;">
            <div class="available-resource-form-btns" style="justify-content: end !important;">

                <div class="activity-detail-name" style="border: none;">
                    <h2>Add Resources Form</h2>
                    <p>Adding New Record in Resource</p>
                </div>
                <button type="submit" class="request-btn">Add Resource</button>
            </div>
            <div class="data-wrapper" style="align-items: start;">
                <div class="data" style=" width: 50% !important; padding-right: 0.2em;">

                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}">

                    <label for="contact_no">Contact No</label>
                    <input id="contact_no" name="contact_no" value="{{ old('contact_no') }}" type="text">


                    <label for="email">Email</label>
                    <input id="email" name="email" value="{{old('email')}}" type="email">

                    <label for="country_id">Country</label>
                    <select name="country_id" id="country_id" required>
                        <option>Select Country</option>
                        @foreach($countries as $countrie)
                        <option value="{{$countrie->id}}" {{ old('country_id') == $countrie->id ? 'selected' : '' }}>
                            {{$countrie->name}}</option>
                        @endforeach
                    </select>
                    <label for="city_name">City</label>
                    <input id="city" name="city_name" value="{{old('city_name')}}" type="text">
                    <label for="region">Region</label>

                    <select name="region" id="region">
                        <option>Select Region</option>
                        <option value="EMEA" {{ old('nationality') == 'EMEA' ? 'selected' : '' }}>EMEA</option>
                        <option value="APAC" {{ old('nationality') == 'APAC' ? 'selected' : '' }}>APAC</option>
                        <option value="LATAM" {{ old('nationality') == 'LATAM' ? 'selected' : '' }}>LATAM</option>
                        <option value="USA" {{ old('nationality') == 'USA' ? 'selected' : '' }}>USA</option>
                        <option value="CANADA" {{ old('nationality') == 'CANADA' ? 'selected' : '' }}>CANADA</option>
                    </select>
                    <label for="address">Address</label>
                    <input id="address" value="{{old('address')}}" name="address" type="text">

                    <label for="latitude">Cordinates(latitude)</label>
                    <input name="latitude" value="{{old('latitude')}}" id="latitude" type="text">

                    <label for="longitude">Cordinates(longitude)</label>
                    <input name="longitude" value="{{old('longitude')}}" id="longitude" type="text">
                    
                    <label for="nationality_id">Nationality</label>
                    <div class="select-wrapper select" style="width: 100%;">
                        <div class="container" style="padding: 0;border-bottom: none !important;">
                            <div class="form-group" style="width: 100% !important; margin: auto !important;">
                                <select name="nationality_id[]" multiple placeholder="Select nationalities"
                                    data-allow-clear="1" id="nationality" style="width: 100% !important;">
                                    @foreach($nationalities as $nationality)
                                    <option value="{{$nationality->id}}">{{$nationality->nationality}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="about-language">

                        <div class="lang-wraper">
                            <label for="language">Language</label>
                            <input id="language" name="language" type="text">
                        </div>
                    </div>

                    <label for="whatsapp">Whatsapp</label>
                    <select name="whatsapp" id="whatsapp">
                        <option>Select</option>
                        <option value="yes" {{ old('whatsapp') == 'yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ old('whatsapp') == 'no' ? 'selected' : '' }}>No</option>
                    </select>

                    <label for="whatsapp_link">Whatapp Group Link</label>
                    <input name="whatsapp_link" value="{{old('whatsapp_link')}}" id="whatsapp_link" type="text">

                    <label for="certification">Certification</label>
                    <input id="certification" value="{{old('certification')}}" name="certification" type="text">

                    <label for="worked_with_us">Worked With Us</label>

                    <select name="worked_with_us" id="worked_with_us">
                        <option selected disabled>Worked with us?</option>
                        <option value="1" {{ old('worked_with_us') == '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('worked_with_us') == '0' ? 'selected' : '' }}>No</option>
                    </select>

                    <label for="linked_in">Linked-In- Profile</label>
                    <input name="linked_in" value="{{old('linked_in')}}" id="linked_in" type="text">

                    <label for="rate-snap">Rate Snap</label>
                    <input name="rate_snap" value="{{old('rate_snap')}}" id="rate-snap" type="file">
                </div>
                <div class="data" style=" width: 50% !important; padding-left: 0.2em;">
                    <label for="tools">Engineer Tools</label>
                    <div style="width: 100%; display: flex; align-items: center; justify-content: space-between;">
                        <div class="select-wrapper select" style="width: 100%;">
                            <div class="container" style="padding: 0;border-bottom: none !important;">
                                <div class="form-group" style="width: 100% !important; margin: auto !important;">
                                    <select name="engineer_tools[]" multiple placeholder="Select tools"
                                        data-allow-clear="1" id="engineer_tools" style="width: 100% !important;">
                                        @foreach($engineerTools as $entool)
                                        <option value="{{$entool->id}}"
                                            {{ in_array($entool->id, old('tool_id', [])) ? 'selected' : '' }}>
                                            {{$entool->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button id="engineerToolModal"
                            style="cursor: pointer; margin-left: 5px;border: none;height: 4em;border-radius: 5px; font-size: 10px;width: 8em;">ADD</button>
                    </div>
                    <div class="modal" id="openModalEngineerTool" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl shadow-lg" role="document"
                            style="background-color: rgba(0, 0, 0, 0.03) !important;">
                            <div class="modal-content modal-xl shadow-lg" style="border-radius: 10px;">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="modelHeading">Add Tools </h5>
                                    <button type="button" class="close" data-dismiss="engineerToolModal"
                                        aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table w-100 ">

                                        <tr style="text-align: center;">
                                            <th scope="col" style="border: 0 !important;">#</th>
                                            <th scope="col" style="border: 0 !important;">Tools</th>
                                            <th scope="col" style="border: 0 !important;">Action</th>
                                        </tr>


                                        <tbody class="border border-secondary text-center"
                                            style="border: none !important;">
                                            @forelse($engineerTools as $engineerTool)
                                            <tr>
                                                <th scope="row">{{$engineerTool->id}}</th>
                                                <td class="editableengineertool"
                                                    onclick="makeEditableEngineerTool(this)">{{$engineerTool->name}}
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger deleteEngineerTool"
                                                        data-engineer-tool-id="{{$engineerTool->id}}"
                                                        style="background-color: #1b4962 !important; border: none;">Delete</button>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3">No record found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="row border-top-grey ">
                                        <div class="col-sm-12">
                                            <input type="text" value="" class="create-engineer-tool"
                                                placeholder="Add tools"
                                                style="background-color: rgba(0, 0, 0, 0.03) !important; height: 3em !important; color:black;padding-left: 1em !important;">

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="engineerToolModal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <label for="tools">Company Tools</label>
                    <div style="width: 100%; display: flex; align-items: center; justify-content: space-between;">
                        <div class="select-wrapper select" style="width: 100%;">
                            <div class="container" style="padding: 0;border-bottom: none !important;">
                                <div class="form-group" style="width: 100% !important; margin: auto !important;">
                                    <select name="company_tools[]" multiple placeholder="Select tools"
                                        data-allow-clear="1" id="tools" style="width: 100% !important;">
                                        <option>Select Company Tools</option>
                                        @foreach($tools as $tool)
                                        <option value="{{$tool->id}}"
                                            {{ in_array($tool->id, old('tool_id', [])) ? 'selected' : '' }}>
                                            {{$tool->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button id="toolModal"
                            style="cursor: pointer; margin-left: 5px;border: none;height: 4em;border-radius: 5px; font-size: 10px;width: 8em;">ADD</button>
                    </div>

                    <div class="modal" id="openModaltool" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl shadow-lg" role="document"
                            style="background-color: rgba(0, 0, 0, 0.03) !important;">
                            <div class="modal-content modal-xl shadow-lg" style="border-radius: 10px;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modelHeading">Add Tools </h5>
                                    <button type="button" class="close" data-dismiss="toolmodal"
                                        aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table w-100 ">

                                        <tr style="text-align: center;">
                                            <th scope="col" style="border: 0 !important;">#</th>
                                            <th scope="col" style="border: 0 !important;">Tools</th>
                                            <th scope="col" style="border: 0 !important;">Action</th>
                                        </tr>


                                        <tbody class="border border-secondary text-center"
                                            style="border: none !important;">
                                            @forelse($tools as $tool)
                                            <tr>
                                                <th scope="row">{{$tool->id}}</th>
                                                <td class="editableengineertool"
                                                    onclick="makeEditableCompanyTool(this)">
                                                    {{$tool->name}}</td>
                                                <td>
                                                    <button class="btn btn-danger deleteTool"
                                                        data-tool-id="{{$tool->id}}"
                                                        style="background-color: #1b4962 !important; border: none;">Delete</button>

                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3">No record found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>


                                    </table>

                                    <div class="row border-top-grey ">
                                        <div class="col-sm-12">
                                            <input type="text" value="" class="create-tool " placeholder="Add tools"
                                                style="background-color: rgba(0, 0, 0, 0.03) !important; height: 3em !important; color:black;padding-left: 1em !important;">

                                        </div>
                                    </div>



                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="toolmodal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <label for="files">BGV</label>
                    <input type="file" id="files" name="BGV[]" multiple="multiple">
                    <label for="avaibility_id">Availability</label>
                    <div style="width: 100%; display: flex; align-items: center; justify-content: space-between;">
                        <div class="select-wrapper select" style="width: 100%;">
                            <div class="container" style="padding: 0; border-bottom: none !important;">
                                <div class="form-group" style="width: 100% !important; margin: auto !important;">
                                    <select name="avability_id[]" multiple placeholder="Select availability"
                                        data-allow-clear="1" id="avaibility_id" style="width: 100% !important;">
                                        <option>Availability</option>
                                        @foreach($availabilities as $availability)
                                        <option value="{{$availability->id}}"
                                            {{ in_array($availability->id, old('avability_id', [])) ? 'selected' : '' }}>
                                            {{$availability->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                    <label for="skillselect">Skills</label>
                    <div style="width: 100%; display: flex; align-items: center; justify-content: space-between;">
                        <div class="select-wrapper select" style="width: 100%;">
                            <div class="container" style="padding: 0;border-bottom: none !important;">
                                <div class="form-group" style="width: 100% !important; margin: auto !important;">
                                    <select name="skill_id[]" multiple placeholder="Select Skills" data-allow-clear="1"
                                        id="skillselect" style="width: 100% !important;">
                                        <option>Select Skills</option>
                                        @foreach($skills as $skill)
                                        <option value="{{ $skill->id }}"
                                            {{ in_array($skill->id, old('skill_id', [])) ? 'selected' : '' }}>
                                            {{ $skill->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button id="openModalBtn"
                            style="cursor: pointer; margin-left: 5px;border: none;height: 4em;border-radius: 5px; font-size: 10px;width: 8em;">ADD</button>
                    </div>
                    <div class="modal " id="skills" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl shadow-lg" role="document"
                            style="background-color: rgba(0, 0, 0, 0.03) !important;">
                            <div class="modal-content modal-xl" style="border-radius: 10px">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modelHeading">Add Skills </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body" id="skill-table">
                                    <style>
                                    table th,
                                    td {
                                        border-top: 1px solid #dee2e6;
                                        border-bottom: 1px solid #dee2e6;
                                    }
                                    </style>
                                    <table class="table w-100 ">
                                        <thead class="text-center">
                                            <tr>
                                                <th scope="col" style="border: 0;">#</th>
                                                <th scope="col" style="border: 0;">skills</th>
                                                <th scope="col" style="border: 0;">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody class="border border-secondary text-center"
                                            style="border: none !important;">
                                            @forelse($skills as $skill)
                                            <tr>
                                                <th scope="row">{{$skill->id}}</th>
                                                <td class="editable" onclick="makeEditable(this)">{{$skill->name}}</td>
                                                <td>
                                                    <button class="btn btn-danger deleteSkill"
                                                        data-skill-id="{{$skill->id}}"
                                                        style="background-color: #1b4962 !important; border: none;">Delete</button>

                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3">No record found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>

                                    </table>
                                    <div class="row border-top-grey ">
                                        <div class="col-sm-12">

                                            <input type="text" value="" class="create-skill" placeholder="Add Skills">

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <label for="work_status">Work Status</label>
                    <input id="work_status" name="work_status" value="{{old('work_status')}}" type="text"
                        placeholder='Student Visa'>


                    <label for="resumee" class="resume">Resume</label>
                    <input name="resume" id="resumee" type="file">

                    <label class="visa">Work Visa</label>
                    <input name="visa" value="{{old('visa')}}" id="visa" type="file">

                    <label class="license">Local Id / Driving license</label>
                    <input name="license" value="{{old('license')}}" id="license" type="file">

                    <label class="passport">Passport</label>
                    <input name="passport" value="{{old('passport')}}" id="passport" type="file">



                    <label for="daily_rate">Day / Rates</label>
                    <input name="daily_rate" value="{{old('daily_rate')}}" id="daily_rate" type="number">

                    <label for="half_day_rates">Half Day Rates</label>
                    <input name="half_day_rates" value="{{old('half_day_rates')}}" type="text">

                    <label for="hourly_rate">Hourly / Rates</label>
                    <input name="hourly_rate" value="{{old('hourly_rate')}}" id="hourly_rate" type="number">

                    <div class="about-language">
                        <div class="lang-wraper">
                            <label for="weekly_rates">Weekly Rates</label>
                            <input name="weekly_rates" value="{{ old('weekly_rates') }}" id="weekly_rates"
                                type="number">
                        </div>
                    </div>

                    <div class="about-language">
                        <div class="lang-wraper">
                            <label for="monthly_rates">Monthly Rates</label>
                            <input name="monthly_rates" value="{{ old('monthly_rates') }}" id="monthly_rates"
                                type="number">
                        </div>
                    </div>


                    <label for="rate_currency">Rate Currency</label>
                    <input id="rate_currency" name="rate_currency" value="{{old('rate_currency')}}" type="text">


                </div>
            </div>
        </div>
        @if(hasAdminRole())
            <div class="planned" style="width: 50%;padding: 1em; width: 100% !important;">
                <div class="activity-detail-name" style="border: none;">
                    <h2>Account Detail For Payment</h2>
                    <p>Add payment method for paying</p>
                </div>
                <div class="data-wrapper" style="align-items: start; border-bottom: none;">
                    <div class="data" style=" width: 50% !important; padding-right: 0.2em;">

                        <label for="bank_name">Bank Name</label>
                        <input name="bank_name" value="{{old('bank_name')}}" id="bank_name" type="text">

                        <label for="branch_name">Bank Branch Name</label>
                        <input id="branch_name" name="bank_branch_name" value="{{old('bank_branch_name')}}" type="text">

                        <label for="branch_code">Bank Branch Code</label>
                        <input id="branch_code" name="bank_branch_code" value="{{old('bank_branch_code')}}" type="number">

                        <label for="city_name">Bank City Name</label>
                        <input name="bank_city_name" id="bank_city_name" value="{{old('bank_city_name')}}" type="text">

                        <label for="holder_name">Account Holder Name</label>
                        <input name="account_holder_name" id="holder_name" value="{{old('account_holder_name')}}"
                            type="text">

                        <label for="account_number">Account Number</label>
                        <input name="account_number" value="{{old('account_number')}}" id="account_number" type="text">
                    </div>
                    <div class="data" style=" width: 50% !important; padding-left: 0.2em;">
                        <label for="iban">IBAN</label>
                        <input name="IBAN" id="iban" value="{{old('IBAN')}}" type="text">
                        <label for="swit_code">BIC / Swit Code</label>
                        <input name="BIC_or_Swift_code" value="{{old('BIC_or_Swift_code')}}" id="swit_code" type="number">
                        <label for="set_code">Set Code(UK ONLY)</label>
                        <input name="sort_code" value="{{old('sort_code')}}" id="set_code" type="number">
                        <label for="country">Country</label>
                        <input name="country" value="{{old('country')}}" id="country" type="text">
                        <label for="transfer_id">Tranferwise ID</label>
                        <input name="transferwise_id" value="{{old('transferwise_id')}}" id="transfer_id" type="text">
                    </div>
                </div>
            </div>
        @endif
    </div>
</form>
@endsection
@push('scripts')

</script>

<!-- mudassar script to disable contact and email field if already exist  -->
<script>
    function enableAllFields() {
        var form = document.getElementById('myForm');
        var elements = form.querySelectorAll('input, select, textarea');

        elements.forEach(function(element) {
            element.disabled = false;
        });
    }

    function disableFieldsExceptContactNo() {
        var form = document.getElementById('myForm');
        var elements = form.querySelectorAll('input, select, textarea');

        elements.forEach(function(element) {
            if (element.id !== 'contact_no') {
                element.disabled = true;
            } else {
                element.disabled = false;
            }
        });
    }

    function disableFieldsExceptEmail() {
        var form = document.getElementById('myForm');
        var elements = form.querySelectorAll('input, select, textarea');

        elements.forEach(function(element) {
            if (element.id !== 'email') {
                element.disabled = true;
            } else {
                element.disabled = false;
            }
        });
    }

    document.getElementById('contact_no').addEventListener('blur', function() {
        var contactNo = this.value;
        var url = "{{ route('check.contact') }}";

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ contact_no: contactNo })
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                alert('Contact number already exists!');
                disableFieldsExceptContactNo();
            } else {
                enableAllFields();
            }
        })
        .catch(error => console.error('Error:', error));
    });

    document.getElementById('email').addEventListener('blur', function() {
        var email = this.value;
        var url = "{{ route('check.email') }}";

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                alert('Email already exists!');
                disableFieldsExceptEmail();
            } else {
                enableAllFields();
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>


<!-- aqibs scripts  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('#tools').forEach(function(selectElement) {
            var options = {
                theme: 'bootstrap4',
                width: 'style',
                placeholder: selectElement.getAttribute('placeholder'),
                allowClear: Boolean(selectElement.dataset.allowClear),
            };
            $(selectElement).select2(options);
        });
        document.querySelectorAll('#avaibility_id').forEach(function(selectElement) {
            var options = {
                theme: 'bootstrap4',
                width: 'style',
                placeholder: selectElement.getAttribute('placeholder'),
                allowClear: Boolean(selectElement.dataset.allowClear),
            };
            $(selectElement).select2(options);
        });

        document.querySelectorAll('#skillselect').forEach(function(selectElement) {
            var options = {
                theme: 'bootstrap4',
                width: 'style',
                placeholder: selectElement.getAttribute('placeholder'),
                allowClear: Boolean(selectElement.dataset.allowClear),
            };
            $(selectElement).select2(options);
        });

        document.querySelectorAll('#engineer_tools').forEach(function(selectElement) {
            var options = {
                theme: 'bootstrap4',
                width: 'style',
                placeholder: selectElement.getAttribute('placeholder'),
                allowClear: Boolean(selectElement.dataset.allowClear),
            };
            $(selectElement).select2(options);
        });
        document.querySelectorAll('#nationality').forEach(function(selectElement) {
            var options = {
                theme: 'bootstrap4',
                width: 'style',
                placeholder: selectElement.getAttribute('placeholder'),
                allowClear: Boolean(selectElement.dataset.allowClear),
            };
            $(selectElement).select2(options);
        });
    });
</script>
<script>
    document.getElementById("engineerToolModal").addEventListener("click", function(e) {
        e.preventDefault();
        var modal = document.getElementById("openModalEngineerTool");
        modal.classList.add("show");
        modal.style.display = "block";
        document.body.classList.add("modal-open");
    });

    var closeButtons = document.querySelectorAll("[data-dismiss='engineerToolModal']");
    closeButtons.forEach(function(btn) {
        btn.addEventListener("click", function() {
            var modal = document.getElementById("openModalEngineerTool");
            modal.classList.remove("show");
            modal.style.display = "none";
            document.body.classList.remove("modal-open");
        });
    });
</script>
<script>
    const inputField = document.querySelector('.create-engineer-tool');

    inputField.addEventListener('keyup', function(event) {

        // Check if the pressed key is Enter (key code 13)
        if (event.keyCode === 13) {
            // Get the value of the input field
            const toolValue = event.target.value;

            axios.post('/engineertoool', {
                    name: toolValue
                })
                .then(response => {
                    // Handle successful response
                    console.log('Tools stored successfully:', response.data);

                    // Show SweetAlert2 success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.message,
                    });

                    // Clear the input field after processing
                    // Reload the page or update the skills list

                    // Alternatively, you can update the skills list without reloading the page
                    event.target.value = '';
                    location.reload();

                })
                .catch(error => {
                    // Handle error response
                    console.error('Error storing tool:', error);

                    // Show SweetAlert2 error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while storing the skill.',
                    });
                });



        }
    });

    document.querySelectorAll('.deleteEngineerTool').forEach(button => {

        button.addEventListener('click', function(event) {
            // Prevent the default behavior of the button (e.g., form submission)
            event.preventDefault();

            // Get the skill ID from the data attribute
            const toolId = button.getAttribute('data-engineer-tool-id');

            // Send AJAX request to delete the skill
            axios.delete(`/engineertoool/${toolId}`)
                .then(response => {
                    // Handle successful response
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.message,
                    });

                    // Reload the page or update the skills list
                    setTimeout(function() {
                        location.reload();
                    }, 1500); // Reload the page
                    // Alternatively, you can update the skills list without reloading the page
                })
                .catch(error => {
                    // Handle error response
                    console.error('Error deleting Tool:', error);
                });
        });
    });

    function saveToolName(cell) {
        var toolId = cell.parentNode.querySelector('th').innerText;
        var updatedName = cell.innerText;

        axios.put('/engineer-toolUpdate/' + toolId, {
                name: updatedName
            })
            .then(response => {
                location.reload();
            })
            .catch(error => {
                console.error('Error updating tool name:', error);
            });
    }

    function makeEditableEngineerTool(cell) {
        cell.contentEditable = true;
        cell.focus();
        cell.style.backgroundColor = 'rgba(0, 0, 0, 0.03)';

        cell.addEventListener('blur', function() {
            saveToolName(cell);
            cell.style.backgroundColor = 'white';
            cell.contentEditable = false;
        });

        document.body.addEventListener('click', function(event) {
            if (event.target !== cell) {
                cell.blur();
            }
        }, {
            once: true
        });
    }
</script>
{{--   company tools--}}
<script>
    document.getElementById("toolModal").addEventListener("click", function(e) {
        e.preventDefault();
        var modal = document.getElementById("openModaltool");
        modal.classList.add("show");
        modal.style.display = "block";
        document.body.classList.add("modal-open");
    });
    var closeButtons = document.querySelectorAll("[data-dismiss='toolmodal']");
    closeButtons.forEach(function(btn) {
        btn.addEventListener("click", function() {
            var modal = document.getElementById("openModaltool");
            modal.classList.remove("show");
            modal.style.display = "none";
            document.body.classList.remove("modal-open");
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputField = document.querySelector('.create-tool');
        inputField.addEventListener('keyup', function(event) {
            if (event.keyCode === 13) {
                const skillValue = event.target.value;

                axios.post('/tool', {
                        name: skillValue
                    })
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.data.message,
                        });
                        event.target.value = '';
                        location.reload();
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while storing the skill.',
                        });
                    });
            }
        });

        document.querySelectorAll('.deleteTool').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const toolId = button.getAttribute('data-tool-id');

                axios.delete(`/tool/${toolId}`)
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.data.message,
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    })
                    .catch(error => {
                        console.error('Error deleting Tool:', error);
                    });
            });
        });

        function saveCompanyToolName(cell) {
            var toolId = cell.parentNode.querySelector('th').innerText;
            var updatedName = cell.innerText;


            axios.put('/toolUpdate/' + toolId, {
                    name: updatedName
                })
                .then(response => {
                    location.reload();
                })
                .catch(error => {
                    console.error('Error updating tool name:', error);
                });
        }

        function makeEditableCompanyTool(cell) {
            cell.contentEditable = true;
            cell.focus();
            cell.style.backgroundColor = 'rgba(0, 0, 0, 0.03)';

            cell.addEventListener('blur', function() {
                saveCompanyToolName(cell);
                cell.style.backgroundColor = 'white';
                cell.contentEditable = false;
            });

            document.body.addEventListener('click', function(event) {
                if (event.target !== cell) {
                    cell.blur();
                }
            }, {
                once: true
            });
        }

        document.querySelectorAll('.editableengineertool').forEach(cell => {
            cell.addEventListener('click', function() {
                makeEditableCompanyTool(cell);
            });
        });
    });
</script>
{{--     skils--}}
<script>
    document.getElementById("openModalBtn").addEventListener("click", function(e) {
        e.preventDefault();
        var modal = document.getElementById("skills");
        modal.classList.add("show");
        modal.style.display = "block";
        document.body.classList.add("modal-open");
    });
    var closeButtons = document.querySelectorAll("[data-dismiss='modal']");
    closeButtons.forEach(function(btn) {
        btn.addEventListener("click", function() {
            var modal = document.getElementById("skills");
            modal.classList.remove("show");
            modal.style.display = "none";
            document.body.classList.remove("modal-open");
        });
    });
</script>
<script>
    const inputFieldSkill = document.querySelector('.create-skill');
    inputFieldSkill.addEventListener('keyup', function(event) {
        // Check if the pressed key is Enter (key code 13)
        if (event.keyCode === 13) {
            const skillValue = event.target.value;

            axios.post('/skill', {
                    name: skillValue
                })
                .then(response => {
                    console.log('Skill stored successfully:', response.data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.message,
                    });
                    event.target.value = '';
                    location.reload();

                })
                .catch(error => {
                    // Handle error response
                    console.error('Error storing skill:', error);

                    // Show SweetAlert2 error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while storing the skill.',
                    });
                });



        }
    });

    document.querySelectorAll('.deleteSkill').forEach(button => {
        button.addEventListener('click', function(event) {
            // Prevent the default behavior of the button (e.g., form submission)
            event.preventDefault();

            // Get the skill ID from the data attribute
            const skillId = button.getAttribute('data-skill-id');

            // Send AJAX request to delete the skill
            axios.delete(`/skill/${skillId}`)
                .then(response => {
                    // Handle successful response

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.message,
                    });

                    // Reload the page or update the skills list
                    setTimeout(function() {
                        location.reload();
                    }, 1500); // Reload the page
                    // Alternatively, you can update the skills list without reloading the page
                })
                .catch(error => {
                    // Handle error response
                    console.error('Error deleting skill:', error);
                });
        });
    });

    function saveSkillName(cell) {
        // Extract the skill ID and updated name from the cell
        var skillId = cell.parentNode.querySelector('th').innerText;
        var updatedName = cell.innerText;

        // Make an AJAX request to update the skill name using Axios
        axios.put('/skillUpdate/' + skillId, {
                name: updatedName
            })
            .then(response => {
                // Handle success response
                console.log('Skill deleted successfully');
            })
            .catch(error => {
                // Handle error
                console.error('Error updating skill name:', error);
            });
    }

    function makeEditable(cell) {
        // Toggle the contenteditable attribute of the cell
        cell.contentEditable = true;
        // Focus the cursor on the cell
        cell.focus();

        cell.style.backgroundColor = 'rgba(0, 0, 0, 0.03)';


        // Add blur event listener to save changes when user clicks outside the cell
        cell.addEventListener('blur', function() {
            // Save the edited skill name
            saveSkillName(cell);
            cell.style.backgroundColor = 'white';
            location.reload();

        });
        document.body.addEventListener('click', function(event) {
            if (event.target !== cell) {
                // Remove focus from cell
                cell.blur();
            }
        });
    }
</script>
<script>
    function hideAlerts() {
        setTimeout(function() {
            var alertDanger = document.getElementById('alert-danger');
            var alertSuccess = document.getElementById('alert-success');

            if (alertDanger) {
                alertDanger.style.display = 'none';
            }
            if (alertSuccess) {
                alertSuccess.style.display = 'none';
            }
        }, 3000); 
    }
    hideAlerts();
</script>
<script>
    const whatsappSelect = document.getElementById('whatsapp');
    const whatsappLinkInput = document.getElementById('whatsapp_link');
    function toggleInputReadOnly() {
        if (whatsappSelect.value === 'no') {
            whatsappLinkInput.readOnly = true;
        } else {
            whatsappLinkInput.readOnly = false;
        }
    }
    toggleInputReadOnly();
    whatsappSelect.addEventListener('change', toggleInputReadOnly);
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myForm = document.getElementById('myForm');
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
            function resetForm() {
                myForm.reset();
                var formElements = myForm.querySelectorAll('input, select, textarea');
                formElements.forEach(function(element) {
                    element.style.border = '';
                    if (element.type === 'file') {
                        element.classList.remove('file-not-valid');
                        element.value = '';
                    }
                });
                $('#myForm select').val(null).trigger('change');
            }
            var formData = new FormData(myForm);
            // Send form data to server using AJAX
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
                        resetForm();
                        errorAlert.style.display = 'none';
                        // Display success message
                        successAlert.textContent = data.message;
                        successAlert.style.display = 'block';
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                        setTimeout(function() {
                            successAlert.style.display = 'none';
                        }, 3000);
                         window.location.href = '{{ route("resources.index") }}';
                    } else {
                        // Display only the first error message in the notification
                        errorList.innerHTML = '';
                        if (data.errors.length > 0) {
                            var li = document.createElement('li');
                            li.textContent = data.errors[0].message; // Show only the first error
                            errorList.appendChild(li);

                            // Display the error alert
                            errorAlert.style.display = 'block';
                            successAlert.style.display = 'none';

                            // Highlight all fields with errors and focus on the first invalid input
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