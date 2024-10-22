<style>
body {
    margin: 0 !important;
}

.signin-container {
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: "Montserrat", sans-serif;
}

.signin-container .left-portion {
    height: 100%;
    background: linear-gradient(180deg, #206D88 0%, #13455D 100%);
    padding: 3em 0 0 4em;
    flex: 1;
}

.signin-container .left-portion .left-portion-wrapper {
    height: 100%;
    overflow-y: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.signin-container .left-portion .left-portion-wrapper .title-logo {
    width: 35%;
    transform: translateX(-6px);
}

.signin-container .left-portion .left-portion-wrapper p {
    color: white;
    padding: 0;
    font-weight: 700;
    font-size: 2.6rem;
    line-height: 3.8rem;
}

.signin-container .left-portion .left-portion-wrapper .bottom-image {
    margin-top: 8px;
    width: -moz-fit-content;
    width: fit-content;
    transform: translateX(-5px);
}

.signin-container .right-portion {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.signin-container .right-portion .right-portion-wrapper {
    width: 60%;
}

.signin-container .right-portion .right-portion-wrapper p {
    font-size: 1.5rem;
    font-weight: 600;
    text-align: center;
    color: #13455D;
    text-wrap: nowrap;
}

.signin-container .right-portion .right-portion-wrapper .login-form {
    display: flex;
    flex-direction: column;
}

.signin-container .right-portion .right-portion-wrapper label {
    margin-bottom: 6px;
    margin-top: 1em;
    color: #7D8592;
}

.signin-container .right-portion .right-portion-wrapper input {
    padding: 10px;
    margin-bottom: 12px;
    border: 1px solid #D8E0F0;
    border-radius: 10px;
    transition: border-color 0.3s ease-in-out;
    outline: none;
    color: #7D8592;
    width: 100%;
}

.signin-container .right-portion .right-portion-wrapper input:focus {
    border-color: #206D88;
}

.signin-container .right-portion .right-portion-wrapper .password-container {
    position: relative;
}

.signin-container .right-portion .right-portion-wrapper .password-container .toggle-password {
    position: absolute;
    top: 40%;
    transform: translateY(-50%);
    right: 10px;
    cursor: pointer;
}

.signin-container .right-portion .right-portion-wrapper .password-container .toggle-password img {
    width: 1.4em;
}

.signin-container .right-portion .right-portion-wrapper .forgot-password {
    text-align: end;
}

.signin-container .right-portion .right-portion-wrapper .forgot-password a {
    text-decoration: none;
    color: #7D8592;
}

.signin-container .right-portion .right-portion-wrapper .signin-submit-button {
    width: -moz-fit-content;
    width: fit-content;
    margin: 0 auto;
    padding: 0.5em 2.5em;
    border-radius: 10px;
    border: none;
    background-color: #13455D;
    color: white;
    border: 1px solid white;
    margin-top: 2em;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: background-color 0.3s ease;
}

.signin-container .right-portion .right-portion-wrapper .signin-submit-button img {
    width: 1em;
    margin-left: 2px;
    transition: width 0.3s ease;
}

.signin-container .right-portion .right-portion-wrapper .signin-submit-button:hover {
    background-color: white;
    color: #13455D;
    border: 1px solid #13455D;
    font-weight: 900;
}

.signin-container .right-portion .right-portion-wrapper .signin-submit-button:hover img {
    width: 0;
}

@media screen and (max-width: 1000px) {
    .signin-container {
        flex-direction: column-reverse;
        height: 98vh;
    }

    .signin-container .left-portion {
        display: none;
    }

    .signin-container .right-portion {
        width: 70%;
    }

    .signin-container .right-portion .right-portion-wrapper {
        width: 100%;
    }

}

@media screen and (max-width: 600px) {
    .signin-container {
        font-size: 3em;
    }

    .signin-container .right-portion .right-portion-wrapper input {
        height: 6em;
    }

    .signin-container .right-portion .right-portion-wrapper p {
        font-size: 3.5rem;
    }
}
</style>

<div class="signin-container">
    <div class="left-portion">
        <div class="left-portion-wrapper">
            <img class="title-logo" src="{{asset('Asserts/General/chase-it global-03.png')}}" />
            <p>
                Your place to work
                <br />Plan. Create. Control.
            </p>
            <img class="bottom-image" src="{{asset('Asserts/General/Illustration.svg')}}" />
        </div>
    </div>
    <div class="right-portion">
        <div class="right-portion-wrapper">
            <p>Sign In to <br /> Chase IT Global.</p>
            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <label for="email">Email Address</label>
                <input type="email" class="@error('email') is-invalid @enderror" id="email" name="email"
                    value="{{ old('email') }}" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="password">Password</label>
                <div class="password-container">
                    <input id="password" type="password" class="@error('password') is-invalid @enderror"
                        name="password">
                    <span class="toggle-password" onclick="togglePasswordVisibility()" toggle="#password">
                        <img id="eyeIcon" src="{{asset('Asserts/General/viewpassword.svg')}}" alt="eyeIcon" />
                    </span>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <!-- <div class="forgot-password">
                    <a href="#"> Forgot Password?</a>
                </div> -->

                <button class="signin-submit-button" type="submit">
                    Login
                    <img src="{{asset('Asserts/General/white.png')}}" alt="arrow" />
                </button>
            </form>
        </div>

    </div>
</div>

<script>
function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var toggleIcon = document.querySelector(".toggle-password img");
    var eyeIcon = document.getElementById("eyeIcon");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.src = "{{asset('Asserts/General/hidepassword.svg')}}";
    } else {
        passwordInput.type = "password";
        eyeIcon.src = "{{asset('Asserts/General/viewpassword.svg')}}";
    }
}
</script>