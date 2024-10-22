@extends("layouts.app")
@section('content')
<style>
    #resources {
        table-layout: fixed;
        width: 100%;
    }

    #resources thead tr th,
    #resources tbody tr td {
        width: 10em;
        white-space: nowrap;
        overflow: hidden;
        font-size: 12px;
        border-bottom: 1px solid lightgray;
    }

    #resources tbody tr td {
        overflow-x: auto;
        max-width: 10em;
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

    .table-header {
        background-color: #206D88;
        color: white;
        font-weight: 600;
        font-size: 13px;
    }
</style>
<form action="{{ route('resources.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="uploaded-resource-form">
        <div class="form-header">
            <h3>Resources Uploading Form</h3>
            <p>Auto Uploading</p>
        </div>
    </div>
    <div class="uploaded-resources-footer">
        <h3>Select File for Upload</h3>
        <input type="file" name="file" required>
        <div class="resources-btns">
            <button type="submit" class="upload-btn">
                Upload
            </button>
        </div>
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
        <table id="resources" class="table table-sm table-striped table-hover table-bordered" style="width: 361vw;">
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
                    <th>Group Link</th>
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
                    <th>Rates</th>
                    <th>Day Rate</th>
                    <th>Daily Rate</th>
                    <th>Half Day Rates</th>
                    <th>Hourly Rate</th>
                    <th>Rate Currency</th>
                    <th>Weekly Rates</th>
                    <th>Monthly Rates</th>
                    <th>Rate Snap</th>
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
                        <button class="rounded-circle btn btn-danger btn-sm delete-btn" data-id="{{ $resource->id }}"
                            type="button">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                    <td>{{ $resource->name }}</td>
                    <td>{{ $resource->contact_no }}</td>
                    <td>{{ $resource->email }}</td>
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

                    <td>{{ $resource->whatsapp_group_link }}</td>
                    <td>{{ $resource->linked_in_profile }}</td>

                    <td>
                        @if ($resource->resume)
                        <a href="{{ route('resume.download', $resource->resume) }}">Download resume</a>
                        @else
                        Empty
                        @endif
                    </td>


                    <td>{{ $resource->region ?? 'N/A' }}</td>
                    <td>{{ $resource->country->name  ?? 'N/A' }}</td>
                    <td>{{ $resource->city->name  ?? 'N/A' }}</td>
                    <td>{{ $resource->group_link ?? 'N/A' }}</td>
                    <td class="nationality">
                        <div>
                            {{ $resource->resourceNationalities->pluck('nationality')->implode(', ') }}
                        </div>
                    </td>
                    @php
                    $languages = explode(',', trim($resource->language));
                    @endphp
                    <td>
                        @foreach($languages as $key => $language)
                        <span>{{ trim($language) }}</span>
                        @if($key < count($languages) - 1) <span>, </span>
                            @endif
                            @endforeach
                    </td>
                    <td>{{ $resource->certification  ?? 'N/A' }}</td>
                    <td>{{ $resource->worked_with_us == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $resource->whatsapp  ?? 'N/A' }}</td>


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
                                                        <img id="{{$bgv->file_name}}" src="{{ url($bgv->file_name) }}"
                                                            alt="BGV Image"
                                                            style="max-width: 100%; height: 200px;border-top-left-radius: 15px;border-top-right-radius: 15px;">
                                                        <label for="{{$bgv->file_name}}">{{$bgv->file_name}}</label>
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
                        ({{ $resource->latitude  }})
                        ({{ $resource->longitude }})
                    </td>
                    <td>{{ $resource->address }}</td>
                    <td>{{ $resource->work_status }}</td>
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
                    <td>{{ $resource->rates ?? 'N/A' }}</td>
                    <td>{{ $resource->rate_date  ?? 'N/A' }}</td>
                    <td>{{ $resource->daily_rate  ?? 'N/A' }}</td>
                    <td>{{ $resource->half_day_rates  ?? 'N/A' }}</td>
                    <td>{{ $resource->hourly_rate  ?? 'N/A' }}</td>
                    <td>{{ $resource->rate_currency ?? 'N/A' }}</td>
                    <td>{{ $resource->weekly_rates ?? 'N/A' }}</td>
                    <td>{{ $resource->monthly_rates ?? 'N/A' }}</td>
                    <td>
                        @if ($resource->rate_snap)
                        <a href="{{ route('ratesnap.download', $resource->rate_snap) }}">Download Rate Snap</a>
                        @else
                        N/A
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<!-- make table datatable  -->
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
    });
</script>
<!-- open model  -->
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
<!-- open edit page  -->
<script>
    function openEditPage(id) {
        window.location.href = `/resource/${id}`;
    }
</script>
<!-- delete  -->
<script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
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
@endpush