@extends("layouts.app")
@section('content')
<style>
        #resources {
            table-layout: fixed;
            width: 100%;
        }

        #resources thead tr th,
        #resources tbody tr td {
            width: 10em !important;
            white-space: nowrap;
            overflow: hidden;
            font-size: 12px;
            border-bottom: 1px solid lightgray;
        }

        #resources tbody tr td {
            overflow-x: auto;
            max-width: 10em !important;
        }

        #resources tbody tr td::-webkit-scrollbar {
            width: 3px;
            height: 0px;
        }

        #resources tbody tr td::-webkit-scrollbar-track {
            background: none;
        }

        #resources tbody tr td::-webkit-scrollbar-thumb {
            background: #e94d65;
        }

        #resources tbody tr td::-webkit-scrollbar-thumb:hover {
            background: #2d6d8b;
            width: 7px;
        }
        .table-header{
            background-color: #206D88;
            color: white;
            font-weight: 600;
            font-size: 13px;
        }
</style>
<form method="get" action="{{ route('resources.index') }}">
    <div class="avaiable-resource">
        <div class="select country">
            <h5>Tech Country</h5>
            <select name="country" id="country_id">
                <option>All</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ request('country') === (string) $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="select city">
            <h5>Tech City</h5>
            <select id="city" name="tech_city">
                <option value="" selected>Select City</option>
                @foreach($cities as $city)
                    <option value="{{ $city->name }}" {{ $city->name == $searchedCity ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="select availability">
            <h5>Availability</h5>
            <select name="availability" id="availability">
                <option value="" selected>All</option>
                @foreach($availabilities as $availability)
                    <option value="{{ $availability->id }}" {{ request('availability') === (string) $availability->id ? 'selected' : '' }}>{{ $availability->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="select tool">
            <h5>Tools</h5>
            <select name="tools" id="tools">
                <option value="" selected>All</option>
                @foreach($tools as $tool)
                    <option value="{{ $tool->id }}" {{ request('tools') === (string) $tool->id ? 'selected' : '' }}>{{ $tool->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="select status">
            <h5>Status</h5>
            <select name="status" id="status">
                <option value="" selected>All</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="select work">
            <h5>Worked</h5>
            <select name="worked_with_us" id="worked_with_us">
                <option value="" selected>All</option>
                <option value="1" {{ request('worked_with_us') === '1' ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ request('worked_with_us') === '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>
        <div class="select BGV">
            <h5>BGV</h5>
            <select name="BGV" id="BGV">
                <option value="" selected>All</option>
                <option value="1" {{ request('BGV') === '1' ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ request('BGV') === '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>
    </div>

    <div class="available-resource-form-btns">
        <p></p>
        <button type="submit" class="request-btn">
            Filter Request
        </button>
    </div>
</form>

<div class="data-container datatable">
    <div class="available-data-container-header" style="padding-bottom: 0;">
        <div class="record">
            <h3>Total Resources Record</h3>
            <p>All resources that we have</p>
        </div>
    </div>
    <div class="data-table-container scrollable-table">
        <table id="resources" class="table table-sm  table-hover table-bordered" style="width: 361vw;">
            <thead>
                <tr class="table-header">
                    <th>Action</th>
                    <th>Name</th>
                    <th>Contact No</th>
                    <th>Email</th>
                    <th>Availability</th>
                    <th>Company Tools</th>
                    <th>Engineer Tools</th>
                    <th>Whatsapp Group</th>
                    <th>Linked-in Profile</th>
                    <th>Resume</th>
                    <th>Region</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Nationality</th>
                    <th>Language</th>
                    <th>Certification</th>
                    <th>Worked with Us</th>
                    <th>Whatsapp</th>
                    <th>BGV</th>
                    <th>Coordinates</th>
                    <th>Address</th>
                    <th>Work Status</th>
                    <th>Visa</th>
                    <th>License</th>
                    <th>Passport</th>
                    <th>Weekly Rates</th>
                    <th>Monthly Rates</th>
                    <th>Daily Rate</th>
                    <th>Half Day Rates</th>
                    <th>Hourly Rate</th>
                    <th>Rate Currency</th>
                    <th>Rate Snap</th>
                    <th>Created By</th>
                    <th>Date Of Creation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resources as $resource)
                <tr id="row_{{ $resource->id }}">
                    <td>
                        <button class="rounded-circle btn btn-primary btn-sm" type="button"
                            onclick="openEditPage({{ $resource->id }})">
                            <i class="fa fa-pencil"></i>
                        </button>
                        @if(hasRecruitmentRole())
                            <button class="rounded-circle btn btn-danger btn-sm delete-btn" data-id="{{ $resource->id }}"
                                type="button">
                                <i class="fa fa-trash"></i>
                            </button>
                        @endif
                    </td>
                    <td>{{ $resource->name ?? 'N/A' }}</td>
                    <td>{{ $resource->contact_no ?? 'N/A' }}</td>
                    <td>{{ $resource->email ?? 'N/A' }}</td>
                    <td>
                        <div>
                            {{ $resource->availabilities->pluck('name')->implode(', ') }}
                        </div>
                    </td>
                    <td>
                        <div>
                            {{ $resource->tools->pluck('name')->implode(', ') }}
                        </div>
                    </td>

                    <td>
                        <div>
                            {{ $resource->engineerTools->pluck('name')->implode(', ') }}
                        </div>
                    </td>
                    <td>
                        <a href="{{ $resource->whatsapp_link }}" target="_blank">open</a>
                    </td>
                    <td>
                        <a >open</a>
                    </td>

                    <td>
                        @if ($resource->resume)
                        <a href="{{ route('resume.download', $resource->resume) }}">Download resume</a>
                        @else
                        N/A
                        @endif
                    </td>
                    <td>{{ $resource->region ?? 'N/A' }}</td>
                    <td>{{ $resource->country->name ?? 'N/A' }}</td>
                    <td>{{ $resource->city_name }}</td>
                    <td class="nationality">
                        <div>
                            {{ $resource->resourceNationalities->pluck('nationality')->implode(', ') }}
                        </div>
                    </td>
                    @php
                    $languages = explode(',', trim($resource->language));
                    @endphp
                    <td>
                        <div>
                            @foreach($languages as $key => $language)
                            <span>{{ trim($language) }}</span>
                            @if($key < count($languages) - 1) <span>, </span>
                                @endif
                                @endforeach
                        </div>
                    </td>
                    <td>
                        <div>
                            <span>{{ $resource->certification }} </span>
                        </div>
                    </td>
                    <td>{{ $resource->worked_with_us == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $resource->whatsapp }}</td>
                    <td>
                        @if ($resource->bgvs->isNotEmpty())
                        <a class="bgv-modal-link" href="#" data-resource-id="{{ $resource->id }}">View BGVs</a>
                        @else
                        N/A
                        @endif
                        <div class="modal" id="bgvModal_{{$resource->id}}" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-xl shadow-lg" role="document"
                                style="background-color: rgba(0, 0, 0, 0.03) !important;">
                                <div class="modal-content modal-xl shadow-lg" style="border-radius: 10px;">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modelHeading">View BGVs</h5>
                                        <button type="button" class="close" data-dismiss="bgvModal"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            @foreach ($resource->bgvs as $bgv)
                                            <div class="col-md-4 pointer"
                                                onclick="submitForm('{{ route('bgvs.download', $bgv->file_name) }}')">
                                                <form>
                                                    <img id="{{$bgv->file_name}}" src="/resources/{{$bgv->file_name}}"
                                                    style="max-width: 100%; height: 200px;border-top-left-radius: 15px;border-top-right-radius: 15px;">
                                                </form>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="bgvModal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        ({{ $resource->latitude ?? 'N/A'  }})
                        ({{ $resource->longitude ?? 'N/A' }})
                    </td>
                    <td>{{ $resource->address ?? 'N/A' }}</td>
                    <td>{{ $resource->work_status ?? 'N/A' }}</td>
                    <td>
                        @if ($resource->visa)
                        <a href="{{ route('visa.download', $resource->visa) }}">Download Visa</a>
                        @else
                        N/A
                        @endif
                    </td>
                    <td>
                        @if ($resource->license)
                        <a href="{{ route('license.download', $resource->license) }}">Download License</a>
                        @else
                        N/A
                        @endif
                    </td>
                    <td>
                        @if ($resource->passport)
                        <a href="{{ route('passport.download', $resource->passport) }}">Download Passport</a>
                        @else
                        N/A
                        @endif
                    </td>
                    <td>{{ $resource->weekly_rates  }}</td>
                    <td>{{ $resource->monthly_rates }}</td>
                    <td>{{ $resource->daily_rate }}</td>
                    <td>{{ $resource->half_day_rates }}</td>
                    <td>{{ $resource->hourly_rate }}</td>
                    <td>{{ $resource->rate_currency }}</td>

                    <td>
                        @if ($resource->rate_snap)
                        <a href="{{ route('ratesnap.download', $resource->rate_snap) }}">Download Rate Snap</a>
                        @else
                        N/A
                        @endif
                    </td>
                    <td>{{$resource->user->user_name ?? 'N/A'}}</td>
                    <td>{{$resource->created_at->format('d M Y')}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#country_id').select2({
            placeholder: 'Select Country',
            allowClear: true
        });
    });
</script>
<script>
    $(document).ready(function() {
        var table = $('#resources').DataTable({
            "searching": true,
            "dom": 'lfrtip',
            "pageLength": 50,
            "lengthMenu": [
                [10, 25, 50, 75, 100],
                [10, 25, 50, 75, 100]
            ],
            "buttons": [],
        });

        // Use event delegation for dynamically added rows
        $('#resources tbody').on('click', '.delete-btn', function() {
            var resourceId = $(this).data('id');
            if (confirm('Are you sure you want to delete this resource?')) {
                $.ajax({
                    url: '/resource/' + resourceId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#row_' + resourceId).remove();
                        alert('Resource deleted successfully');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
    $(document).ready(function() {
        var table = $('#resources').DataTable({
            "searching": true,
            "dom": 'lfrtip',
            "pageLength": 50,
            "lengthMenu": [
                [10, 25, 50, 75, 100],
                [10, 25, 50, 75, 100]
            ],
            "buttons": [],
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var bgvModalLinks = document.querySelectorAll(".bgv-modal-link");

        bgvModalLinks.forEach(function(link) {
            link.addEventListener("click", function(e) {
                e.preventDefault();
                var resourceId = this.getAttribute("data-resource-id");
                var modal = document.getElementById("bgvModal_" + resourceId);
                modal.classList.add("show");
                modal.style.display = "block";
                document.body.classList.add("modal-open");
            });
        });

        // Close modal when close button is clicked
        var closeButtons = document.querySelectorAll("[data-dismiss='bgvModal']");
        closeButtons.forEach(function(btn) {
            btn.addEventListener("click", function() {
                var modal = btn.closest(".modal");
                modal.classList.remove("show");
                modal.style.display = "none";
                document.body.classList.remove("modal-open");
            });
        });
    });
</script>
<script>
    function submitForm(route) {
        var form = document.createElement('form');
        form.method = 'get';
        form.action = route;
        document.body.appendChild(form);
        form.submit();
    }
</script>
<script>
    function openEditPage(id) {
        window.location.href = `/resource/${id}`;
    }
</script>
<!-- to get cities  -->
<script>
    $(document).ready(function() {
        $('#country_id').change(function() {
            var country_id = $(this).val();
            if (country_id) {
                axios.get('/getResourceCities/' + country_id)
                    .then(function(response) {
                        $('#city').empty();
                        $('#city').append('<option>Select City</option>');
                        $.each(response.data, function(key, value) {
                            $('#city').append('<option value="' + value.name + '">' + value
                                .name + '</option>');
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
    });
</script>
@endpush