<header class="main-header">
    <button id="menu-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path fill="#e94d65"
                d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z" />
        </svg>
    </button>
    <img src="{{asset('Asserts/logo/white-logo.png')}}" class="site-logo" />

    <div class="left-side-header">
        <div class="header-logo">
            <button class="menu-button" id="menu-toggle-button">
                <svg xmlns="http://www.w3.org/2000/svg" class="bar-icon" viewBox="0 0 448 512">
                    <path fill="#3b768c"
                        d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" />
                </svg>
            </button>
            <img src="{{asset('Asserts/General/site-logo.png')}}">
        </div>

        <div class="header-page-name">
            <b><h6 style="color:white;font-size: 1em;">{{ \Carbon\Carbon::now()->format('l, F jS Y') }}</h6></b>
        </div>

    </div>

    <div class="right-side-header">
        <button class="header-button">
            <img src="{{asset('Asserts/logo/message.png')}}" />
        </button>

        <button class="header-button" id="notification-toggle-button"
            style="display: flex; flex-direction: column; justify-content: center;">
            <img src="{{asset('Asserts/logo/notification.png')}}" />
            <img src="{{asset('Asserts/logo/bell.png')}}" />
            <img src="{{asset('Asserts/logo/dot.png')}}" class="notification-dot" />
        </button>

        <div class="login-profile">
            <div>
                <img style="height:100%;width:100%;object-fit:contain" src="{{asset('Asserts/logo/small-logo.png')}}" />
            </div>
            <div class="profile-detail">
                <span>
                    <b>{{Auth::user()->user_name}}</b>
                </span>
                <span>
                    {{Auth::user()->role->name}}
                </span>
                <a href="{{route('profile.index')}}">Profile</a>
            </div>
        </div>
    </div>
    <style>
        .right-side-header .login-profile .profile-detail {
            display: none;
            width: 15%;
            position: absolute;
            top: 3.5em;
            right: 2em;
            background-color: #206d88;
            border-radius: 5px;
            flex-direction: column;
            align-items: start;
            justify-content: space-evenly;
            padding: 0.7em 1em;
        }

        .right-side-header .login-profile:hover .profile-detail {
            display: flex;
        }

        .right-side-header .login-profile:hover .profile-detail:hover {
            display: flex;
        }

        .right-side-header .login-profile .profile-detail span,
        .right-side-header .login-profile .profile-detail a {
            width: 100%;
            text-decoration: none;
            color: #e94d65;
            border-bottom: 1px solid white;
            transition: 0.5s ease;
        }

        .right-side-header .login-profile .profile-detail span:hover,
        .profile-detail a:hover {
            padding-left: 1em;
            color: white !important;
        }

        .right-side-header .login-profile .profile-detail {
            box-shadow: none;
        }

        .right-side-header .login-profile .profile-detail form {
            width: 100%;
            box-shadow: none;
            background-color: transparent;
            margin: 0;
            border-bottom: 1px solid white;
            border-radius: 0;
            transition: 0.5s ease;
        }

        .right-side-header .login-profile .profile-detail form a {
            border-bottom: none;
        }

        .right-side-header .login-profile .profile-detail form:hover a {
            padding-left: 1em;
            color: white !important;

        }
    </style>
    <div class="footer-text">
        <div class="header-page-name">
            <h5>{{ \Carbon\Carbon::now()->format('l, F jS Y') }}</h5>
        </div>
    </div>
</header>
@php 
    use App\Models\Notification;
    use App\Models\User;
    use App\Models\Lead;
    use App\Models\Member;
    $user = Auth::user();
    if($user->role_id == 1){
        $notifications = Notification::with('doneby')->where('user1_id', '!=', $user->id)->orderBy('created_at', 'desc')->take(30)->get();
    }elseif($user->role_id == 2 || $user->role_type == 'HrmMember' || $user->role_type == 'HrmLead'){
        $messages = [
            " has checked Out !",
            " has checked In !",
            " has updated anounsement !",
            " has made anounsement !",
            " has approved leave !",
            " has deleted leave !",
            " has applied for leave !"
        ];
        $notifications = Notification::with('doneby')->whereIn('message', $messages)->orderBy('created_at', 'desc')->take(30)->get();
    }elseif($user->role_id == 8){
        $messages = [
            " has updated anounsement !",
            " has made anounsement !"
        ];
        $notifications = Notification::with('doneby')->whereIn('message', $messages)->orderBy('created_at', 'desc')->take(30)->get();
    }elseif($user->role_id == 5 || $user->role_type == 'AccmMember' || $user->role_type == 'AccmLead'){
        $messages = [
            " has updated anounsement !",
            " has made anounsement !",
            " has generated tech invoice !",
            " has confirmed tech invoice payment !",
            " has deleted tech invoice !",
            " has generated client invoice !",
            " has deleted client invoice !",
            " has confirmed client invoice payment !"
        ];
        $notifications = Notification::with('doneby')->whereIn('message', $messages)->orderBy('created_at', 'desc')->take(30)->get();
    }elseif($user->role_id == 4){

        $users = User::where('role_type', 'SdmMember')->orWhere('role_type', 'SdmLead')->get();
        $UserIds = $users->pluck('id');

        $messages = [
            " has created activity !",
            " has edited activity !",
            " has confirmed activity !",
            " has closed activity !",
            " has approved activity !",
            " has deleted activity !",
            " has assigned activity !"
        ];

        $notifications = Notification::with('doneby')
            ->whereIn('user1_id', $UserIds)
            ->whereIn('message', $messages)
            ->orderBy('created_at', 'desc')->take(30)
            ->get();

        $additionalMessages = [
            " has updated anounsement !",
            " has made anounsement !",
            " has added a resource !"
        ];

        $announcementNotifications = Notification::with('doneby')
            ->whereIn('message', $additionalMessages)
            ->orderBy('created_at', 'desc')->take(30)
            ->get();


        $notifications = $notifications->merge($announcementNotifications);
    }elseif($user->role_type == 'SdmLead'){

        $users = User::where('role_type', 'SdmMember')->get();
        $UserIds = $users->pluck('id');

        $messages = [
            " has created activity !",
            " has edited activity !",
            " has confirmed activity !",
            " has closed activity !",
            " has approved activity !",
            " has deleted activity !",
            " has assigned activity !"
        ];

        $notifications = Notification::with('doneby')
            ->whereIn('user1_id', $UserIds)
            ->whereIn('message', $messages)
            ->orderBy('created_at', 'desc')->take(30)
            ->get();

        $additionalMessages = [
            " has updated anounsement !",
            " has made anounsement !",
            " has added a resource !"
        ];

        $announcementNotifications = Notification::with('doneby')
            ->whereIn('message', $additionalMessages)
            ->orderBy('created_at', 'desc')->take(30)
            ->get();


        $notifications = $notifications->merge($announcementNotifications);
    }elseif($user->role_type == 'SdmMember'){

        $messages = [
            " has assigned activity !"
        ];

        $notifications = Notification::with('doneby')
            ->where('user2_id', $user->id)
            ->whereIn('message', $messages)
            ->orderBy('created_at', 'desc')->take(30)
            ->get();  

        $additionalMessages = [
            " has updated anounsement !",
            " has made anounsement !",
            " has added a resource !"
        ];

        $announcementNotifications = Notification::with('doneby')
            ->whereIn('message', $additionalMessages)
            ->orderBy('created_at', 'desc')->take(30)
            ->get();


        $notifications = $notifications->merge($announcementNotifications);
    }elseif($user->role_id == 3){

        $users = User::where('role_type', 'RecmMember')->orWhere('role_type', 'RecmLead')->get();
        $UserIds = $users->pluck('id');

        $messages = [
            " has added a resource !",
            " has updated a resource !",
            " has deleted a resource !"
        ];

        $notifications = Notification::with('doneby')
            ->whereIn('user1_id', $UserIds)
            ->whereIn('message', $messages)
            ->orderBy('created_at', 'desc')->take(30)
            ->get();

        $additionalMessages = [
            " has updated anounsement !",
            " has made anounsement !"
        ];

        $announcementNotifications = Notification::with('doneby')
            ->whereIn('message', $additionalMessages)
            ->orderBy('created_at', 'desc')->take(30)
            ->get();


        $notifications = $notifications->merge($announcementNotifications);

    }elseif($user->role_type == 'RecmLead'){

        $lead = Lead::where('user_id', Auth::user()->id)->first();
        $members = Member::where('lead_id' , $lead->id)->get();
        if(!$members->isEmpty()){
            $memberUsers = $members->map(function($member) {
                return $member->user; 
            });
            $UserIds = $memberUsers->pluck('id');
            $messages = [
                " has added a resource !",
                " has updated a resource !",
                " has deleted a resource !"
            ];
            $notifications = Notification::with('doneby')->whereIn('user1_id', $UserIds)->whereIn('message', $messages)->orderBy('created_at', 'desc')->take(30)->get();
            $additionalMessages = [
                " has updated anounsement !",
                " has made anounsement !"
            ];
            $announcementNotifications = Notification::with('doneby')->whereIn('message', $additionalMessages)->orderBy('created_at', 'desc')->take(30)->get();
            $notifications = $notifications->merge($announcementNotifications);
        }else{
            $messages = [
                " has updated anounsement !",
                " has made anounsement !"
            ];

            $notifications = Notification::with('doneby')->whereIn('message', $messages)->orderBy('created_at', 'desc')->take(30)->get();
        }
    }elseif($user->role_type == 'RecmMember'){
            $messages = [
                " has updated anounsement !",
                " has made anounsement !"
            ];

            $notifications = Notification::with('doneby')->whereIn('message', $messages)->orderBy('created_at', 'desc')->take(30)->get();
    }          

@endphp
<div class="popup-wrapper" id="show-page">
    <div class="popup-bg-blur">
    </div>
    <div class="notification-popup-container">
        <div class="profile-notification">
            <h2>NOTIFICATION</h2>
            @if($notifications->count() > 0)
                @foreach($notifications as $notification)
                    <div class="notifications">
                        <img style="width: 50px;height: 50px;" src="{{ asset('Asserts/General/user.png') }}" class="profile-logo">
                        <div class="notification-detail">
                            <h5>{{$notification->doneby->user_name}}{{$notification->message}}</h5>
                            <h5>{{$notification->created_at->format('d M Y, h:i A')}}</h5>
                        </div>
                    </div>
                @endforeach
            @else    
                    <div class="notifications no-hover" style="height: 100%;">
                        <h5>No Notification</h5>
                    </div>
            @endif
        </div>
    </div>
</div>
<style>
    .main-header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: #2d6d8b;
        z-index: 1000;
        height: 4em;
        padding: 0.7em;
        box-shadow: 0px 7px 16px 0px rgba(77, 77, 77, 0.4);
        display: flex;
        align-items: start;
        justify-content: space-between;
        flex-wrap: wrap;
        box-sizing: border-box;
    }

    .main-header #menu-btn {
        display: none;
    }


    .main-header .left-side-header {
        width: 64%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: end;
    }

    .main-header .site-logo {
        width: 5em;
        height: 4em;
        margin-left: 1em;
        margin-top: -0.7em;
    }


    .main-header .left-side-header .header-logo {
        display: none;
    }

    .main-header .left-side-header .header-page-name {
        width: 38%;
        text-align: end;
    }

    .main-header .left-side-header .header-page-name h2 {
        font-weight: 600;
        font-size: 1.4em;
        line-height: 36px;
        margin: 0;
        color: white;
    }

    .main-header .left-side-header .header-page-name h6 {
        color: #acacac;
        font-weight: 300;
        font-size: 0.7em;
        margin: 0;
    }

    .main-header .right-side-header {
        width: 25%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.5em;
        padding-right: 1em;
        z-index: 999;
    }

    .main-header .right-side-header .header-button {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50px;
        background-color: white;
        border: none;
        width: 2.2em;
        height: 2.2em;
        position: relative;
    }

    .main-header .right-side-header .header-button:hover {
        border: 2px solid #206D88;
    }

    .main-header .right-side-header .header-button .notification-dot {
        border: 2px solid white;
        border-radius: 50%;
        position: absolute;
        top: 0.2em;
        left: 1em;
    }

    .main-header .right-side-header .login-profile {
        width: 3em;
        height: 3em;
        border-radius: 50%;
        background-color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 4px 9px 5px 10px;
    }

    .main-header .right-side-header .login-profile .profile-details {
        flex: 1;
    }

    .main-header .right-side-header .login-profile .profile-details h4 {
        font-size: 14px;
        font-weight: 500;
        font-family: "Montserrat", sans-serif;
        margin-bottom: 0 !important;
    }

    .main-header .right-side-header .login-profile .profile-details p {
        font-size: 10px;
        color: gray;
        margin-bottom: 0 !important;
    }

    .footer-text {
        display: none;
    }
    .profile-notification::-webkit-scrollbar {
    width: 0px !important;
    height: 0px;
}
.profile-notification::-webkit-scrollbar-track {
    background: none !important;
}
.profile-notification::-webkit-scrollbar-thumb  {
    background: #e94d65 !important;
}
.profile-notification::-webkit-scrollbar-thumb:hover {
    background: #2d6d8b !important;
    width: 7px !important;
}
</style>