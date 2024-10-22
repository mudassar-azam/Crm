@extends('layouts.app3')
@section('content')
<style>
    .update-password {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 30em;
    }

    .update-password-form {
        width: 35%;
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: #e8e8e8;
        padding: 1em;
        border-radius: 1em;
    }

    button {
        padding: 0.7em;
        border: none;
        background-color: #2d6d8b;
        transition: 0.2s ease;
        border-radius: 5px;
        color: white;
        margin-top: 1em;
    }

    button:hover {
        padding: 0.8em;
        letter-spacing: 1px;
    }

    .inputs {
        width: 100%;
    }

    .input {
        height: 3em;
    }

    form {
        background: none;
        gap: 2em;
    }

    .button {
        display: flex;
        width: 100%;
        align-items: center;
        justify-content: center;
    }
</style>
<div class="update-password">
    <div class="update-password-form">
        <form id="verify-email-form" method="POST">
            @csrf
            <div class="inputs">
                <label for="email">Enter Your Email</label>
                <input type="email" class="input" name="email">
            </div>
            <div class="button">
                <button class="send-otp" type="button">Send Otp</button>
            </div>
        </form>
        <form  id="otp-verification-form" style="display:none" method="POST">
            @csrf
            <div class="inputs">
                <label for="otp">Enter Otp</label>
                <input type="text" class="input" id="otp-input" name="otp">
            </div>
            <div class="button">
                <button class="verify-otp-btn" type="button">Verify</button>
            </div>
        </form>
        <form  id="new-password-form" style="display:none" method="post">
            @csrf
            <div class="inputs">
                <label for="password">Enter New Password</label>
                <input type="password" class="input" name="password" id="password-input">
            </div>
            <div class="button">
                <button type="button" class="password-button">Update Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('.send-otp').click(function() {
            var email = $('input[type="email"]').val();

            if (email === '') {
                alert('Email is required');
                return;
            }

            if (confirm('Are you sure the email is correct?')) {
                var formData = $('#verify-email-form').serialize();

                $.ajax({
                    url: "{{ route('engineer.email.verify') }}", 
                    type: 'POST',
                    data: formData, 
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        alert(response.message);
                        $('.send-otp').prop('disabled', true);
                        $('#otp-verification-form').css('display', 'block');
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.error || xhr.responseJSON.errors;
                            alert(errors);
                        } else {
                            console.error(xhr.responseText);
                        }
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.verify-otp-btn').click(function() {
            var otpInput = $('#otp-input').val();

            if (otpInput === '') {
                alert('Otp is required');
                return;
            }

            if (confirm('Are you sure otp is correct?')) {
                var formData = $('#otp-verification-form').serialize();

                $.ajax({
                    url: "{{ route('engineer.otp.verify') }}", 
                    type: 'POST',
                    data: formData, 
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        alert(response.message);
                        $('.send-otp').prop('disabled', true);
                        $('.verify-otp').prop('disabled', true);
                        $('#otp-verification-form').css('display', 'none');
                        $('#new-password-form').css('display', 'block');
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.error || xhr.responseJSON.errors;
                            alert(errors);
                        } else {
                            console.error(xhr.responseText);
                        }
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.password-button').click(function() {
            var passInput = $('#password-input').val();

            if (passInput === '') {
                alert('Password is required');
                return;
            }

            if (confirm('Are you sure you want to make this as new password ?')) {
                var formData = $('#new-password-form').serialize();

                $.ajax({
                    url: "{{ route('engineer.password') }}", 
                    type: 'POST',
                    data: formData, 
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        alert(response.message);
                        window.location.href = "{{ route('engineer.dashboard') }}";
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.error || xhr.responseJSON.errors;
                            alert(errors);
                        } else {
                            console.error(xhr.responseText);
                        }
                    }
                });
            }
        });
    });
</script>
@endpush