@extends("layouts.app")
@section('content')

<style>
    body {
        grid-auto-rows: 0.13fr 1fr;
    }

    input[type='number']::-webkit-outer-spin-button,
    input[type='number']::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type='number'] {
        -moz-appearance: textfield;
    }

    tr td .me-2 {
        font-size: 10.5px;
        width: 100%;
        height: 2.5em;
        font-weight: 500;
        color: white;
        background-color: #e94d65;
        padding: 4px;
        border-radius: 5px;
        text-wrap: nowrap;
    }

    tr td::-webkit-scrollbar {
        width: 0;
        height: 0;
    }

    tr td::-webkit-scrollbar-track {
        background: none;
    }

    tr td::-webkit-scrollbar-thumb {
        background: #e94d65;
    }

    tr td::-webkit-scrollbar-thumb:hover {
        background: #2d6d8b;
        width: 0px;
    }
    main{
        margin-top: 0px !important;
    }
</style>

<form method="get" action="{{ route('resources.track') }}">
    <div class="resource-tracking-form">
        <div class="form-header">
            <h3>Resource Tracking</h3>
            <p>Search For Records</p>
        </div>
    </div>

    <div class="resources-tracking-footer">
        <div class="searching">
            <div class="search-cartogary">
                <h3>Search Resource By Name</h3>
                <input type="text" name="name" placeholder="Enter name" value="{{ old('name', $searchName ?? '') }}">
            </div>
            <div class="search-cartogary">
                <h3>Search Resource By ID</h3>
                <input type="number" name="id" placeholder="Enter ID" value="{{ old('id', $searchId ?? '') }}">
            </div>
        </div>
        <div class="resources-btns">
            <button type="submit" class="upload-btn">
                Search
            </button>
        </div>
    </div>
</form>

@if($resources->isNotEmpty())
    @foreach($resources as $resource)
        <div class="data-container">
            <div class="detail-resource-tracking-header">
                <div class="record">
                    <h3>Resource Details</h3>
                </div>
                <div class="resource-tracking-detail">

                    <table>
                        <tr>
                            <th style="width: 30%; border-left: none; border-top: none;">
                                Resource Id
                            </th>
                            <th style="border-top: none;">
                                Resource Name
                            </th>
                            <th style="border-top: none;">
                                Contact No
                            </th>
                            <th style="border-right: none; border-top: none;">
                                Email Address
                            </th>
                        </tr>
                        <tr>
                            <td style="border-left: none; border-top: none;">
                                @if($resource)

                                {{$resource->id}}

                                @endif
                            </td>
                            <td>
                                @if($resource)
                                {{$resource->name}}
                                @endif
                            </td>
                            <td>
                                @if($resource)
                                {{$resource->contact_no}}
                                @endif
                                <img src="">
                            </td>
                            <td style="border-right: none;">
                                @if($resource)
                                {{$resource->email}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="border-left: none;">
                                Region
                            </th>

                            <td style="border-right: none;">
                                {{$resource->region ?? 'N/A'}}
                            </td>
                            <td style="border-left: none;">

                            </td>
                            <td style="border-right: none;">

                            </td>
                        </tr>
                        <tr>
                            <th style="border-left: none;">
                                Country
                            </th>
                            <td>
                                @if($resource)
                                {{$resource->country->name ?? 'N/A'}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="border-left: none;">
                                City
                            </th>
                            <td>
                                @if($resource)
                                {{$resource->city_name ?? 'N/A'}}
                                @endif
                            </td>
                            <th>
                                Skill Set
                            </th>
                            <td style="border-right: none;">
                                @if($resource)
                                @if($resource->skills->count()>0)
                                @foreach($resource->skills as $skill)
                                {{ $skill->name }}
                                @endforeach
                                @else
                                N/A
                                @endif
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="border-left: none;">
                                Uploaded By
                            </th>
                            <th>
                                Branch
                            </th>
                            <th style="border-right: none;">
                                Certification
                            </th>
                            <th>

                            </th>
                        </tr>
                        <tr>
                            <td style="border-left: none;">
                                {{$resource->uploaded_by ?? 'N/A'}}
                            </td>
                            <td>
                                Chase It Global
                            </td>
                            <td>
                                {{$resource->certification ?? 'N/A'}}
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th style="border-left: none;border-right: none;">
                                Linked-IN-Profile
                            </th>
                            <th style="border-left: none;">

                            </th>
                            <th>
                                Daily/Rate
                            </th>
                            <th>
                                Hourly/Rate
                            </th>
                        </tr>
                        <tr>
                            <td style="border-left: none; border-right: none;">
                                @if($resource->linked_in != null)
                                <a href="{{$resource->linked_in }}" target="_blank">Open</a>
                                @else
                                N/A
                                @endif
                            </td>
                            <td style="border-right: none; border-left: none;">

                            </td>
                            <td style="border-right: none; border-left: none;">
                                {{round($resource->daily_rate)}}
                            </td>
                            <td style="border-right: none;">
                                {{round($resource->hourly_rate)}}
                            </td>
                        </tr>
                        <tr>
                            <th style="border-left: none;">
                                Uploading Date:
                            </th>
                            <td style="border-right: none;">
                                @if($resource)
                                {{ \Carbon\Carbon::parse($resource->created_at)->format('m/d/Y h:i A')}}
                                @endif
                            </td>
                            <td style="border: none; border-left: 1px solid lightgray;">

                            </td>
                            <td style="border: none;">

                            </td>

                        </tr>
                        <tr>
                            <th style="border-left: none;">
                                Avalabilty:
                            </th>
                            <td style="width: 38em; overflow: auto; border: none; border-bottom: 1px solid lightgray; border-right: 1px solid lightgray;"
                                class="d-flex">

                                @if($resource)
                                @if($resource->availabilities->count() > 0)
                                @foreach($resource->availabilities as $availability)
                                <span class="me-2 text-center"> {{ $availability->name }}</span>
                                @endforeach
                                @else
                                N/A
                                @endif
                                @endif
                            </td>
                            <td style="border: none;">

                            </td>
                            <td style="border: none;">

                            </td>

                        </tr>

                        <tr>
                            <th style="border-left: none;">
                                Company Tools:
                            </th>
                            <td
                                style="width: 38em; overflow: auto; border: none; border-bottom: 1px solid lightgray; border-right: 1px solid lightgray;">
                                @if($resource)
                                @if($resource->tools->count() > 0)
                                @foreach($resource->tools as $tool)
                                <span class="me-2 text-center">{{ $tool->name }}</span>
                                @endforeach
                                @else
                                N/A
                                @endif
                                @endif
                            </td>
                            <td style="border: none; border-left: 1px solid lightgray;">
                            </td>
                            <td style="border: none;">
                            </td>

                        </tr>
                        <tr>
                            <th style="border-left: none;">
                                Address:
                            </th>
                            <td style="border-right: none;">
                                @if($resource)
                                {{$resource->address}}
                                @endif
                            </td>
                            <td style="border: none; border-left: 1px solid lightgray;">
                            </td>
                            <td style="border: none;">
                            </td>

                        </tr>
                        <tr>
                            <th style="border-left: none;">
                                Address Coordinated <span style="font-style: italic; color: lightgray;">(lat, log)</span>
                            </th>
                            <td style="border-right: none;">
                                @if($resource)
                                @foreach($resources as $resource->first)
                                {{$resource->latitude}},{{$resource->longitude}}
                                @endforeach
                                @endif
                            </td>
                            <td style="border: none; border-left: 1px solid lightgray;">

                            </td>
                            <td style="border: none;">
                            </td>

                        </tr>
                        <tr>
                            <th style="border-left: none;">
                                Group ID:
                            </th>
                            <td style="border-right: none;">
                                N/A
                            </td>
                            <td style="border: none; border-left: 1px solid lightgray;">
                            </td>
                            <td style="border: none;">
                            </td>

                        </tr>
                    </table>

                </div>

            </div>

        </div>
    @endforeach
@endif

@if($noResults)
    <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'No Results Found',
                    text: 'There is no resource matching your search criteria.',
                    icon: 'info',
                    confirmButtonText: 'OK'
                });
            });
    </script>
@endif

@endsection