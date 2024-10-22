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
<form id="myformupdate" method="post" action="{{ route('resource.update', ['id' => $resource->id]) }}"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="account_payment_details_id" value="{{$resource->account_payment_details_id}}">
    <div id="alert-danger" class="alert alert-danger" style="display: none;">
        <ul id="error-list"></ul>
    </div>
    <div id="alert-success" class="alert alert-success" style="display: none;"></div>
    <div class="container" style="flex-direction: column; box-shadow: none;">
        <div class="planned" style="width: 50%;padding: 1em; width: 100% !important;">
            <div class="available-resource-form-btns" style="justify-content: end !important;">

                <div class="activity-detail-name" style="border: none;">
                    <h2>Update Resources Form</h2>
                    <p>Update Record in Resource</p>

                </div>
                <button type="button" onclick="updateResource()" class="request-btn">Update Resource</button>

            </div>
            <div class="data-wrapper" style="align-items: start;">
                <div class="data" style=" width: 50% !important; padding-right: 0.2em;">

                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{$resource->name}}">

                    <label for="contact_no">Contact No</label>
                    <input id="contact_no" name="contact_no" value="{{$resource->contact_no}}" type="text">


                    <label for="email">Email</label>
                    <input id="email" name="email" value="{{$resource->email}}" type="email">


                    <label for="country_id">Country</label>
                    <select name="country_id" id="country_id">
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ $resource->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                    <label for="city_id">City</label>
                    <input id="city" name="city_name" value="{{$resource->city_name}}" type="text">
                    <label for="region">Region</label>
                    <select name="region" id="region">
                        <option value="EMEA" {{ $resource->region == 'EMEA' ? 'selected' : '' }}>EMEA</option>
                        <option value="APAC" {{ $resource->region == 'APAC' ? 'selected' : '' }}>APAC</option>
                        <option value="LATAM" {{ $resource->region == 'LATAM' ? 'selected' : '' }}>LATAM</option>
                        <option value="USA" {{ $resource->region == 'USA' ? 'selected' : '' }}>USA</option>
                        <option value="CANADA" {{ $resource->region == 'CANADA' ? 'selected' : '' }}>CANADA</option>
                    </select>

                    <label for="address">Address</label>
                    <input id="address" value="{{ $resource->address ?? old('address') }}" name="address" type="text">

                    <label for="latitude">Coordinates (latitude)</label>
                    <input name="latitude" value="{{ $resource->latitude ?? old('latitude') }}" id="latitude"
                        type="number">

                    <label for="longitude">Coordinates (longitude)</label>
                    <input name="longitude" value="{{ $resource->longitude ?? old('longitude') }}" id="longitude"
                        type="number">

                    <label for="nationality">Nationality</label>
                    <div class="select-wrapper select" style="width: 100%;">
                        <div class="container" style="padding: 0;border-bottom: none !important;">
                            <div class="form-group" style="width: 100% !important; margin: auto !important;">
                                <select name="nationality_id[]" multiple placeholder="Select nationalities"
                                    data-allow-clear="1" id="nationality" style="width: 100% !important;">
                                    @foreach($nationalities as $nationality)
                                    <option value="{{ $nationality->id }}"
                                        {{ in_array($nationality->id, $resource->resourceNationalities->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $nationality->nationality }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="about-language">

                        <div class="lang-wraper">
                            <label for="language">Language</label>
                            <input id="language" value="{{ $resource->language}}" name="language" type="text">
                        </div>
                    </div>
                    <label for="whatsapp">WhatsApp</label>
                    <select name="whatsapp" id="whatsapp">
                        <option value="yes" {{ $resource->whatsapp == 'yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ $resource->whatsapp == 'no' ? 'selected' : '' }}>No</option>
                    </select>

                    <label for="whatsapp_link">Whatapp Group Link</label>
                    <input name="whatsapp_link" value="{{$resource->whatsapp_link}}" id="whatsapp_link" type="text">

                    <label for="certification">Certification</label>
                    <input id="certification" name="certification" value="{{ $resource->certification }}" type="text">
                    <label for="worked_with_us">Worked With Us</label>
                    <select name="worked_with_us" id="worked_with_us">
                        <option value="1" {{ $resource->worked_with_us == '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ $resource->worked_with_us == '0' ? 'selected' : '' }}>No</option>
                    </select>
                    <label for="linked_in">LinkedIn Profile</label>
                    <input name="linked_in" value="{{ $resource->linked_in }}" id="linked_in" type="text">

                    <label for="rate-snap">Rate Snap</label>
                    <input name="rate_snap" value="{{old('rate_snap')}}" id="rate-snap" type="file">

                </div>
                <div class="data" style=" width: 50% !important; padding-left: 0.2em;">
                    <label for="tools">Engineer Tools</label>
                    <div style="width: 100%; display: flex; align-items: center; justify-content: space-between;">
                        <div class="select-wrapper select" style="width: 100%;">
                            <div class="container" style="padding: 0; border-bottom: none !important;">
                                <div class="form-group" style="width: 100% !important; margin: auto !important;">
                                    <select name="engineer_tools[]" multiple placeholder="Select tools"
                                        data-allow-clear="1" id="engineer_tools" style="width: 100% !important;">
                                        @foreach($engineerTools as $entool)
                                        <option value="{{ $entool->id }}"
                                            {{ in_array($entool->id, $resource->engineerTools->pluck('id')->toArray()) ? 'selected' : '' }}>
                                            {{ $entool->name }}</option>
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
                            <div class="container" style="padding: 0; border-bottom: none !important;">
                                <div class="form-group" style="width: 100% !important; margin: auto !important;">
                                    <select name="company_tools[]" multiple placeholder="Select tools"
                                        data-allow-clear="1" id="tools" style="width: 100% !important;">
                                        @foreach($tools as $tool)
                                        <option value="{{ $tool->id }}"
                                            {{ in_array($tool->id, $resource->tools->pluck('id')->toArray()) ? 'selected' : '' }}>
                                            {{ $tool->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button id="toolModal"
                            style="cursor: pointer; margin-left: 5px;border: none;height: 4em;border-radius: 5px; font-size: 10px;width: 8em;">ADD</button>
                    </div>

                    {{--                      tools modal--}}
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
                                                <td class="editabletool" onclick="makeEditableTool(this)">
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

                    <label for="BGV">BGV</label>
                    <input type="file" id="files" name="BGV[]" multiple="multiple">

                    <label for="avaibility_id">Availability</label>
                    <div style="width: 100%; display: flex; align-items: center; justify-content: space-between;">
                        <div class="select-wrapper select" style="width: 100%;">
                            <div class="container" style="padding: 0; border-bottom: none !important;">
                                <div class="form-group" style="width: 100% !important; margin: auto !important;">
                                    <select name="avability_id[]" multiple placeholder="Select availability"
                                        data-allow-clear="1" id="avaibility_id" style="width: 100% !important;">
                                        @foreach($availabilities as $availability)
                                        <option value="{{$availability->id}}"
                                            {{ $resource->availabilities->contains($availability->id) ? 'selected' : '' }}>
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
                                        @foreach($skills as $skill)
                                        <option value="{{ $skill->id }}"
                                            {{ $resource->skills->contains($skill->id) ? 'selected' : '' }}>
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
                    <input id="work_status" name="work_status"
                        value="{{ $resource->work_status ?? old('work_status') }}" type="text"
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
                    <input name="daily_rate" value="{{ $resource->daily_rate}}" id="daily_rate" type="number">

                    <label for="half_day_rates">Half Day Rates</label>
                    <input name="half_day_rates" value="{{ $resource->half_day_rates}}" type="text">

                    <label for="hourly_rate">Hourly / Rates</label>
                    <input name="hourly_rate" value="{{ $resource->hourly_rate }}" id="hourly_rate" type="number">

                    
                    <div class="about-language">
                        <div class="lang-wraper">
                            <label for="weekly_rates">Weekly Rates</label>
                            <input name="weekly_rates"  id="weekly_rates" value="{{$resource->weekly_rates}}"
                                type="number">
                        </div>
                    </div>

                    <div class="about-language">
                        <div class="lang-wraper">
                            <label for="monthly_rates">Monthly Rates</label>
                            <input name="monthly_rates"  id="monthly_rates" value="{{$resource->monthly_rates}}"
                                type="number">
                        </div>
                    </div>

                    <label for="rate_currency">Rate Currency</label>
                    <input id="rate_currency" name="rate_currency" value="{{ $resource->rate_currency  }}" type="text">



                </div>
            </div>
        </div>
        @if(hasOperationRole())
        <div class="planned" style="width: 50%;padding: 1em; width: 100% !important;">
            <div class="activity-detail-name" style="border: none;">
                <h2>Account Detail For Payment</h2>
                <p>Add payment method for paying</p>
            </div>
            <div class="data-wrapper" style="align-items: start; border-bottom: none;">

                <div class="data" style="width: 50% !important; padding-right: 0.2em;">
                    <label for="bank_name">Bank Name</label>
                    <input name="bank_name" value="{{ $resource->paymentDetails->bank_name ?? old('bank_name') }}"
                        id="bank_name" type="text">

                    <label for="branch_name">Bank Branch Name</label>
                    <input id="branch_name" name="bank_branch_name"
                        value="{{ $resource->paymentDetails->bank_branch_name ?? old('bank_branch_name') }}"
                        type="text">

                    <label for="branch_code">Bank Branch Code</label>
                    <input id="branch_code" name="bank_branch_code"
                        value="{{ $resource->paymentDetails->bank_branch_code ?? old('bank_branch_code') }}"
                        type="number">

                    <label for="city_name">Bank City Name</label>
                    <input name="bank_city_name" id="bank_city_name"
                        value="{{ $resource->paymentDetails->bank_city_name ?? old('bank_city_name') }}" type="text">

                    <label for="holder_name">Account Holder Name</label>
                    <input name="account_holder_name" id="holder_name"
                        value="{{ $resource->paymentDetails->account_holder_name ?? old('account_holder_name') }}"
                        type="text">

                    <label for="account_number">Account Number</label>
                    <input name="account_number"
                        value="{{ $resource->paymentDetails->account_number ?? old('account_number') }}"
                        id="account_number" type="text">
                </div>

                <div class="data" style="width: 50% !important; padding-left: 0.2em;">
                    <label for="iban">IBAN</label>
                    <input name="IBAN" id="iban" value="{{ $resource->paymentDetails->IBAN ?? old('IBAN') }}"
                        type="text">

                    <label for="swit_code">BIC / Swit Code</label>
                    <input name="BIC_or_Swift_code"
                        value="{{ $resource->paymentDetails->BIC_or_Swift_code ?? old('BIC_or_Swift_code') }}"
                        id="swit_code" type="text">

                    <label for="set_code">Set Code (UK ONLY)</label>
                    <input name="sort_code" value="{{ $resource->paymentDetails->sort_code ?? old('sort_code') }}"
                        id="set_code" type="text">

                    <label for="country">Country</label>
                    <input name="country" value="{{ $resource->paymentDetails->country ?? old('country') }}"
                        id="country" type="text">

                    <label for="transfer_id">Transferwise ID</label>
                    <input name="transferwise_id"
                        value="{{ $resource->paymentDetails->transferwise_id ?? old('transferwise_id') }}"
                        id="transfer_id" type="text">
                </div>

            </div>
        </div>
        @endif
    </div>

</form>
@endsection
@push('scripts')

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- aqibs script  -->
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
{{--    engineer tools--}}
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
    if (event.keyCode === 13) {
        const toolValue = event.target.value;

        axios.post('/engineertoool', {
                name: toolValue
            })
            .then(response => {
                console.log('Tools stored successfully:', response.data);
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.data.message,
                });
                event.target.value = '';
                location.reload();

            })
            .catch(error => {
                console.error('Error storing tool:', error);
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
        event.preventDefault();
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
                setTimeout(function() {
                    location.reload();
                }, 1500);
            })
            .catch(error => {
                // Handle error response
                console.error('Error deleting Tool:', error);
            });
    });
});

function saveToolName(cell) {
    // Extract the skill ID and updated name from the cell
    var toolId = cell.parentNode.querySelector('th').innerText;
    var updatedName = cell.innerText;

    // Make an AJAX request to update the skill name using Axios
    axios.put('/engineer-toolUpdate/' + toolId, {
            name: updatedName
        })
        .then(response => {
            // Handle success response
            console.log('Tool name updated successfully');
        })
        .catch(error => {
            // Handle error
            console.error('Error updating tool name:', error);
        });
}

function makeEditableEngineerTool(cell) {
    // Toggle the contenteditable attribute of the cell
    cell.contentEditable = true;
    // Focus the cursor on the cell
    cell.focus();
    cell.style.backgroundColor = 'rgba(0, 0, 0, 0.03)';


    // Add blur event listener to save changes when user clicks outside the cell
    cell.addEventListener('blur', function() {
        // Save the edited skill name
        saveToolName(cell);

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

{{--   company tools--}}
<script>
// JavaScript to open the modal when the button is clicked
document.getElementById("toolModal").addEventListener("click", function(e) {
    e.preventDefault();
    var modal = document.getElementById("openModaltool");
    modal.classList.add("show");
    modal.style.display = "block";
    document.body.classList.add("modal-open");
});
// Close modal when close button is clicked
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
const inputField = document.querySelector('.create-tool');
inputField.addEventListener('keyup', function(event) {
    // Check if the pressed key is Enter (key code 13)
    if (event.keyCode === 13) {
        // Get the value of the input field
        const skillValue = event.target.value;

        axios.post('/tool', {
                name: skillValue
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

document.querySelectorAll('.deleteTool').forEach(button => {

    button.addEventListener('click', function(event) {
        // Prevent the default behavior of the button (e.g., form submission)
        event.preventDefault();

        // Get the skill ID from the data attribute
        const toolId = button.getAttribute('data-tool-id');


        // Send AJAX request to delete the skill
        axios.delete(`/tool/${toolId}`)
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
    // Extract the skill ID and updated name from the cell
    var toolId = cell.parentNode.querySelector('th').innerText;
    var updatedName = cell.innerText;

    // Make an AJAX request to update the skill name using Axios
    axios.put('/toolUpdate/' + toolId, {
            name: updatedName
        })
        .then(response => {
            // Handle success response
            console.log('Tool name updated successfully');
        })
        .catch(error => {
            // Handle error
            console.error('Error updating tool name:', error);
        });
}

function makeEditableTool(cell) {
    // Toggle the contenteditable attribute of the cell
    cell.contentEditable = true;
    // Focus the cursor on the cell
    cell.focus();
    cell.style.backgroundColor = 'rgba(0, 0, 0, 0.03)';


    // Add blur event listener to save changes when user clicks outside the cell
    cell.addEventListener('blur', function() {
        // Save the edited skill name
        saveToolName(cell);

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
{{--     skils--}}
<script>
// JavaScript to open the modal when the button is clicked
document.getElementById("openModalBtn").addEventListener("click", function(e) {
    e.preventDefault();
    var modal = document.getElementById("skills");
    modal.classList.add("show");
    modal.style.display = "block";
    document.body.classList.add("modal-open");
});

// Close modal when close button is clicked
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
        // Get the value of the input field

        const skillValue = event.target.value;

        axios.post('/skill', {
                name: skillValue
            })
            .then(response => {
                // Handle successful response
                console.log('Skill stored successfully:', response.data);

                // Show SweetAlert2 success message
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

    cell.contentEditable = true;
    cell.focus();
    cell.style.backgroundColor = 'rgba(0, 0, 0, 0.03)';
    cell.addEventListener('blur', function() {
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
    axios.post('{{ route("resource.update", ["id" => $resource->id]) }}', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(function(response) {
            showSuccessAlert('Resource updated successfully!');
            window.location.href = '{{ route("resources.index") }}';
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