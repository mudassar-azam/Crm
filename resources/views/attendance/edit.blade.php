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

    .activity-detail-name {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .form-group {
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    width: 50%;
}
.editForm{
    box-shadow: none;
    padding: 1em;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 1.5em;
    background-color: transparent;
}
.member-selection {
    width: 50%;
    margin-bottom: 10px;
    text-align: center;
}
</style>
<form action="{{ route('leads.updateAssigned') }}" class="editForm" method="POST">
<h3>Edit Leads And Members</h3>
    @csrf
    @method('POST')
    <div id="alert-danger" class="alert alert-danger" style="display: none;">
        <ul id="error-list"></ul>
    </div>
    <div id="alert-success" class="alert alert-success" style="display: none;"></div>
    <input type="hidden" name="lead_id" value="{{ $lead->id }}" />
    <div class="form-group">
        <label for="manager">Manager</label>
        <select name="manager_id" id="manager" class="form-control" required>
            @foreach($managers as $manager)
            <option value="{{ $manager->id }}" {{ $lead->manager_id == $manager->id ? 'selected' : '' }}>
                {{ $manager->user_name }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="lead_user">Lead User</label>
        <select name="user_id" id="lead_user" class="form-control" required>
            @foreach($leads as $user)
            <option value="{{ $user->id }}" {{ $lead->user_id == $user->id ? 'selected' : '' }}>
                {{ $user->user_name }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="member-selection">
        <label for="members">Assign Members</label>
        <div style="width: 100%; display: flex; align-items: center; justify-content: space-between;">
            <div class="select-wrapper select" style="width: 100%;">
                <div class="container" style="padding: 0; border-bottom: none !important;">
                    <div class="form-group" style="width: 100% !important; margin: auto !important;">
                        {{--dd($assign_members[0]->user->id)--}}
                        <select name="members[]" multiple placeholder="Select member" data-allow-clear="1" id="members"
                            style="width: 100% !important;">
                            @foreach($assign_members as $amember)
                            <option value="{{ $amember->user_id }}" selected>
                                {{ $amember->user->user_name }}
                            </option>
                            @endforeach
                            @foreach($none_assign_members as $member)
                            <option value="{{ $member->id }}">
                                {{ $member->user_name }}
                            </option>
                            @endforeach
                        </select>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary" style="margin-top: 1em;">Update</button>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#members').forEach(function(selectElement) {
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
<!-- for edit  -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var myForm = document.querySelector('.editForm');
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
                    window.location.href = '{{ route("leadsMembers.index") }}';
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
                        }, 4000);
                        
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