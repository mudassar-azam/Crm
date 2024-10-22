<sidebar class="sidebar-container" id="sidebar-show">
    <div class="sidebar">
        <div class="sidebar-buttons">
            <!-- Dashboard Button -->
            <button class="sidebar-btn {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                onclick="window.location='{{ route('dashboard') }}'">
                <img src="{{ asset('Asserts/logo/dashboard.png') }}" class="botton-icon" />
                Dashboard
            </button>

            <!-- Resource Section -->
            @if(AdminAndRecruitmentAndOperation())
            @php
            $resourceActive = request()->routeIs('resources.index') ||
            request()->routeIs('resources.graph') ||
            request()->routeIs('resources.active') ||
            request()->routeIs('resources.worked') ||
            request()->routeIs('resources.track');
            @endphp
            <button class="sidebar-btn {{ $resourceActive ? 'active' : '' }}" id="resource-user">
                <img src="{{ asset('Asserts/logo/resource.png') }}" class="botton-icon" />
                Resource
                <img src="{{ asset('Asserts/logo/left-arrow.png') }}" width="4px" id="arrow-rotate-user" />
            </button>
            <div class="btn-detail {{ $resourceActive ? 'show-user' : '' }}" id="res-detail-user">
                <ul>
                    <li><a href="{{ route('resources.index') }}"
                            class="sub-btn-link {{ request()->routeIs('resources.index') ? 'sub-active' : '' }}">Total
                            Resource</a></li>
                    @if(AdminOrRecManagerOrOpeManager())
                    <li><a href="{{ route('resources.graph') }}"
                            class="sub-btn-link {{ request()->routeIs('resources.graph') ? 'sub-active' : '' }}">Resources
                            Map Location</a></li>
                    @endif
                    @if(hasOperationRole())
                    <li><a href="{{ route('resources.active') }}"
                            class="sub-btn-link {{ request()->routeIs('resources.active') ? 'sub-active' : '' }}">Active
                            Resources</a></li>
                    <li><a href="{{ route('resources.worked') }}"
                            class="sub-btn-link {{ request()->routeIs('resources.worked') ? 'sub-active' : '' }}">Worked
                            Resources</a></li>
                    @endif
                    <li><a href="{{ route('resources.track') }}"
                            class="sub-btn-link {{ request()->routeIs('resources.track') ? 'sub-active' : '' }}">Track
                            Resources</a></li>
                </ul>
            </div>
            @endif
            @if(hasOperationRole())
            <!-- Operations Section -->
            @php
            $operationActive = request()->routeIs('activity.create') ||
            request()->routeIs('activities.planed') ||
            request()->routeIs('activities.confirmed') ||
            request()->routeIs('activity.completed') ||
            request()->routeIs('activities.approved') ||
            request()->routeIs('total.activities') ||
            request()->routeIs('project.create');
            $displayMode = request()->routeIs('activities.display.mode');
            @endphp
            <button class="sidebar-btn {{ $operationActive ? 'active' : '' }}" id="opration-user">
                <img src="{{ asset('Asserts/logo/oprations.png') }}" class="botton-icon" />
                Operations
                <img src="{{ asset('Asserts/logo/left-arrow.png') }}" width="4px" id="opration-rotate-arrow-user" />
            </button>
            <div class="btn-detail {{ $operationActive ? 'show-user' : '' }}" id="op-detail-user">
                <ul>
                    <li><a href="{{ route('activity.create') }}"
                            class="sub-btn-link {{ request()->routeIs('activity.create') ? 'sub-active' : '' }}">Create
                            Activity</a></li>
                    <li><a href="{{ route('activities.planed') }}"
                            class="sub-btn-link {{ request()->routeIs('activities.planed') ? 'sub-active' : '' }}">Planned
                            Activities</a></li>
                    <li><a href="{{ route('activities.confirmed') }}"
                            class="sub-btn-link {{ request()->routeIs('activities.confirmed') ? 'sub-active' : '' }}">Confirm
                            Activities</a></li>
                    <li><a href="{{ route('activity.completed') }}"
                            class="sub-btn-link {{ request()->routeIs('activity.completed') ? 'sub-active' : '' }}">Complete
                            Activities</a></li>
                    @if(AdminOrSdmManager())
                    <li><a href="{{ route('activities.approved') }}"
                            class="sub-btn-link {{ request()->routeIs('activities.approved') ? 'sub-active' : '' }}">Approved
                            Activities</a></li>
                    @endif
                    @if(AdminOrSdmManager())
                    <li><a href="{{ route('total.activities') }}"
                            class="sub-btn-link {{ request()->routeIs('total.activities') ? 'sub-active' : '' }}">Total
                            Activities</a></li>
                    @endif
                    <li><a href="{{ route('project.create') }}"
                            class="sub-btn-link {{ request()->routeIs('project.create') ? 'sub-active' : '' }}">Projects</a>
                    </li>
                </ul>
            </div>
            <button class="sidebar-btn {{ request()->routeIs('activities.display.mode') ? 'active' : '' }}"
                onclick="window.location='{{ route('activities.display.mode') }}'" id="opration-user">
                <img src="{{ asset('Asserts/logo/oprations.png') }}" class="botton-icon" />
                Display Mode
            </button>
            @endif
            @if(hasAccountRole())
            <!-- Operations Section -->
            @php
            $operationActive = request()->routeIs('activity.create') ||
            request()->routeIs('activities.approved');
            @endphp
            <button class="sidebar-btn {{ $operationActive ? 'active' : '' }}" id="opration-user">
                <img src="{{ asset('Asserts/logo/oprations.png') }}" class="botton-icon" />
                Operations
                <img src="{{ asset('Asserts/logo/left-arrow.png') }}" width="4px" id="opration-rotate-arrow-user" />
            </button>
            <div class="btn-detail {{ $operationActive ? 'show-user' : '' }}" id="op-detail-user">
                <ul>
                    <li><a href="{{ route('activities.approved') }}"
                            class="sub-btn-link {{ request()->routeIs('activities.approved') ? 'sub-active' : '' }}">Approved
                            Activities</a></li>

                </ul>
            </div>
            @endif
            @if(AdminOrAccountRole())
            <!-- Accounts Section -->
            @php
            $accountActive = request()->routeIs('techPayableInvoices') ||
            request()->routeIs('techPaidInvoices') ||
            request()->routeIs('clientPayableInvoices') ||
            request()->routeIs('clientPaidInvoices');
            @endphp
            <button class="sidebar-btn {{ $accountActive ? 'active' : '' }}" id="account-user">
                <img src="{{ asset('Asserts/logo/accounts.png') }}" class="botton-icon" />
                Accounts
                <img src="{{ asset('Asserts/logo/left-arrow.png') }}" width="4px" id="acount-arrow-rotate-user" />
            </button>
            <div class="btn-detail {{ $accountActive ? 'show-user' : '' }}" id="acc-detail-user">
                <ul>
                    <li><a href="{{ route('techPayableInvoices') }}"
                            class="sub-btn-link {{ request()->routeIs('techPayableInvoices') ? 'sub-active' : '' }}">Tech
                            Payable Activities</a></li>
                    <li><a href="{{ route('techPaidInvoices') }}"
                            class="sub-btn-link {{ request()->routeIs('techPaidInvoices') ? 'sub-active' : '' }}">Tech
                            Paid Activities</a></li>
                    <li><a href="{{ route('clientPayableInvoices') }}"
                            class="sub-btn-link {{ request()->routeIs('clientPayableInvoices') ? 'sub-active' : '' }}">Client
                            Receivable Activities</a></li>
                    <li><a href="{{ route('clientPaidInvoices') }}"
                            class="sub-btn-link {{ request()->routeIs('clientPaidInvoices') ? 'sub-active' : '' }}">Client
                            Received Activities</a></li>
                </ul>
            </div>
            @endif
            @if(BdManager())
                <!-- Business Development Section -->
                @php
                    $businessActive = request()->routeIs('client.create') ||
                    request()->routeIs('client.index') ||
                    request()->routeIs('client.follow.create') ||
                    request()->routeIs('client.follow.index') ||
                    request()->routeIs('client.work');
                @endphp
                <button class="sidebar-btn {{ $businessActive ? 'active' : '' }}" id="business-user"><img
                        src="{{ asset('Asserts/logo/business-development.png') }}" class="botton-icon" />Business
                    Development <img src="{{ asset('Asserts/logo/left-arrow.png') }}" width="4px"
                        id="business-arrow-rotate-user" /></button>
                <div class="btn-detail {{ $businessActive ? 'show-user' : '' }}" id="bus-detail-user">
                    <ul>
                        <li><a href="{{ route('client.create') }}"
                                class="sub-btn-link {{ request()->routeIs('client.create') ? 'sub-active' : '' }}">Add
                                Client</a></li>
                        <li><a href="{{ route('client.index') }}"
                                class="sub-btn-link {{ request()->routeIs('client.index') ? 'sub-active' : '' }}">Total
                                Clients</a></li>
                        <li><a href="{{ route('client.follow.create') }}"
                                class="sub-btn-link {{ request()->routeIs('client.follow.create') ? 'sub-active' : '' }}">Add
                                Follow Up Client</a></li>
                        <li><a href="{{ route('client.follow.index') }}"
                                class="sub-btn-link {{ request()->routeIs('client.follow.index') ? 'sub-active' : '' }}">Follow
                                Up Clients</a></li>
                        <li><a href="{{route('client.work')}}"
                                class="sub-btn-link {{ request()->routeIs('client.work') ? 'sub-active' : '' }}">Working
                                With Clients</a></li>
                    </ul>
                </div>
            @endif

            <!-- Attendance Section -->
            @php
            $attendanceActive = request()->routeIs('attendance.dashboard') ||
            request()->routeIs('leadsMembers.index') ||
            request()->routeIs('attendance.leavestatus');
            @endphp
            <button class="sidebar-btn {{ $attendanceActive ? 'active' : '' }}" id="attendence-btn-user"><img
                    src="{{ asset('Asserts/logo/attendence.png') }}" class="botton-icon" />Attendance<img
                    src="{{ asset('Asserts/logo/left-arrow.png') }}" width="4px"
                    id="attendence-rotate-arrow-user" /></button>
            <div class="btn-detail {{ $attendanceActive ? 'show-user' : '' }}" id="attendence-user">
                <ul>
                    <li><a href="{{route('attendance.dashboard')}}"
                            class="sub-btn-link {{ request()->routeIs('attendance.dashboard') ? 'sub-active' : '' }}">Dashboard</a>
                    </li>
                    <li><a href="{{route('attendance.leavestatus')}}"
                            class="sub-btn-link {{ request()->routeIs('attendance.leavestatus') ? 'sub-active' : '' }}">Employee
                            Leave Status</a></li>
                    @if(hasAdminRole())
                    <li><a href="{{route('leadsMembers.index')}}"
                            class="sub-btn-link {{ request()->routeIs('leadsMembers.index') ? 'sub-active' : '' }}">Total
                            Employees</a></li>
                    @endif
                </ul>
            </div>

            @if(hasRecruitmentRole())
            <!-- Recruitment Section -->
            @php
            $recruitmentActive = request()->routeIs('resources.create') ||
            request()->routeIs('tasks.index');
            @endphp
            <button class="sidebar-btn {{ $recruitmentActive ? 'active' : '' }}" id="recruitment-btn-user"><img
                    src="{{ asset('Asserts/logo/requirment.png') }}" class="botton-icon" />Recruitment<img
                    src="{{ asset('Asserts/logo/left-arrow.png') }}" width="4px"
                    id="recruitment-rotate-arrow-user" /></button>
            <div class="btn-detail {{ $recruitmentActive ? 'show-user' : '' }}" id="recruitment-user">
                <ul>
                    <li><a href="{{ route('resources.create') }}"
                            class="sub-btn-link {{ request()->routeIs('resources.create') ? 'sub-active' : '' }}">Add
                            Resources</a></li>
                    <li><a href="{{ route('tasks.index') }}"
                            class="sub-btn-link  {{ request()->routeIs('tasks.index') ? 'sub-active' : '' }}">Task To
                            Do</a></li>
                </ul>
            </div>
            @endif

            @php
                $rooster = request()->routeIs('rooster.create') || request()->routeIs('rooster.index') || request()->routeIs('rooster.override');
            @endphp
            @if(AdminOrHrManager())
                <button class="sidebar-btn {{ $rooster ? 'active' : '' }}" id="rooster-btn-user"><img src="{{ asset('Asserts/logo/requirment.png') }}" class="botton-icon" />Rooster<img src="{{ asset('Asserts/logo/left-arrow.png') }}" width="4px" id="rooster-rotate-arrow-user" /></button>
                <div class="btn-detail {{ $rooster ? 'show-user' : '' }}" id="rooster-user">
                    <ul>
                        <li><a href="{{ route('rooster.create') }}" class="sub-btn-link {{ request()->routeIs('rooster.create') ? 'sub-active' : '' }}">Add Rooster</a></li>
                        <li><a href="{{ route('rooster.index') }}" class="sub-btn-link  {{ request()->routeIs('rooster.index') ? 'sub-active' : '' }}">View Roosters</a></li>
                        <li><a href="{{ route('rooster.override') }}" class="sub-btn-link  {{ request()->routeIs('rooster.override') ? 'sub-active' : '' }}">View Overrides Dates</a></li>
                    </ul>
                </div>
            @endif    
            @php
                $adminSettingsActive = request()->routeIs('adminsettings.index');
            @endphp
            @if(hasAdminRole())
            <button class="sidebar-btn {{ $adminSettingsActive ? 'active' : '' }}" id="recruitment-btn-user"
                onclick="window.location='{{ route('adminsettings.index') }}'">
                <img src="{{ asset('Asserts/logo/admin-setting.png') }}" class="botton-icon" />
                Admin Settings
            </button>
            @endif
            <!-- Logout Button -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        <button class="sidebar-last-btn"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <img src="{{ asset('Asserts/logo/log-in.png') }}" alt="Log-out" />
            Log-out
        </button>
    </div>
</sidebar>

<style>
    sidebar {
        grid-area: sidebar;
        width: 100%;
        height: 99vh;
        display: flex;
        align-items: start;
        justify-content: center;
    }

    .sidebar {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-direction: column;
    }

    .sidebar-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 17%;
        height: 100%;
        padding: 0 0.3em;
        background-color: #2d6d8b;
        box-shadow: 7px 8px 9px 0px rgba(77, 77, 77, 0.4);
        display: flex;
        align-items: flex-start;
        flex-direction: column;
        overflow-y: auto;
    }

    .sidebar .logo {
        width: 100%;
        min-height: 14vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sidebar .sidebar-buttons {
        width: 100%;
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: start;
        padding: 0 0.3em;
        background-color: #2d6d8b;
        overflow-y: auto;
        margin-top: 5em;
    }

    .sidebar .sidebar-buttons .sidebar-btn {
        width: 93%;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        border: none;
        border-radius: 20px;
        color: white;
        margin: 3% 0px 2.5px 0px;
        font-weight: 400;
        padding-left: 7px;
        gap: 20px;
        font-size: 9px;
        transition: 0.2s ease-in-out;
        text-decoration: none;
        background-color: #2d6d8b;
    }

    .sidebar .sidebar-buttons .sidebar-btn a {
        text-decoration: none;
        color: white;
    }

    .sidebar .sidebar-buttons .sidebar-btn a:hover {
        color: white;
    }

    .sidebar .sidebar-buttons .sidebar-btn:hover {
        background-color: #e94d65;
        color: white;
    }

    .sidebar .sidebar-buttons .sidebar-btn:hover img {
        filter: brightness(1000%) contrast(100%) grayscale(0%);
    }

    .sidebar .sidebar-buttons .sidebar-btn.active {
        background-color: #e94d65;
        color: white;
    }

    .sidebar .sidebar-buttons .sidebar-btn.active img {
        filter: brightness(1000%) contrast(100%) grayscale(0%);
    }

    .sidebar .sidebar-buttons .btn-detail {
        font-family: "Poppins";
        font-size: 11px;
        font-weight: 400;
        line-height: 30px;
        display: none;
    }


    .sidebar .sidebar-buttons .btn-detail ul {
        color: #e94d65;
    }

    .sidebar .sidebar-buttons .btn-detail ul li a {
        text-decoration: none;
        color: white;
        font-size: 9px;
    }

    .sidebar .sidebar-buttons .btn-detail ul li a:hover {
        color: #e94d65;
    }

    .sidebar .sidebar-buttons .btn-detail ul li .sub-btn-link.sub-active {
        color: #e94d65;
    }

    .sidebar .sidebar-buttons .show-user {
        display: block;
        width: 75%;
    }

    .sidebar .sidebar-last-btn {
        width: 95%;
        height: 35px;
        margin: 0em 0px 1em 0px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        border: none;
        background-color: #206D88;
        color: white;
        border-radius: 49px;
        font-weight: 400;
        font-size: 11px;
        transition: 0.15s ease-in-out;
    }

    .sidebar .sidebar-last-btn:hover {
        background-color: #e94d65;
    }

    .sidebar .sidebar-last-btn img {
        margin: 0px 10px 0px 35px;
    }

    sidebar::-webkit-scrollbar {
        width: 0px;
        height: 0px;
    }

    sidebar::-webkit-scrollbar-track {
        background: none;
    }

    sidebar::-webkit-scrollbar-thumb {
        background: #e94d65;
    }

    sidebar::-webkit-scrollbar-thumb:hover {
        border: 1px solid white;
    }

    .sidebar-buttons::-webkit-scrollbar {
        width: 0px;
        height: 0px;
    }

    .sidebar-buttons::-webkit-scrollbar-track {
        background: none;
    }

    .sidebar-buttons::-webkit-scrollbar-thumb {
        background: #e94d65;
    }

    .sidebar-buttons::-webkit-scrollbar-thumb:hover {
        border: 1px solid white;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const resourceUserToggle = document.getElementById("resource-user");
        const resDetailUser = document.getElementById("res-detail-user");
        const arrowRotateUser = document.getElementById("arrow-rotate-user");
        const menuBtnUser = document.getElementById("menu-btn-user");
        const mainSidebarUser = document.getElementById("main-sidebar-user");
        const notificationButtonUser = document.getElementById("notification-button-user");
        const showPageUser = document.getElementById("show-page-user");

        function removeShow() {
            const allDetails = document.querySelectorAll(".btn-detail");
            const allArrows = document.querySelectorAll(".sidebar-btn img[id$='arrow-rotate-user']");

            allDetails.forEach(item => item.classList.remove("show-user"));
            allArrows.forEach(item => item.style.transform = "rotate(0deg)");
        }

        if (resourceUserToggle) {
            resourceUserToggle.addEventListener("click", function() {
                removeShow();
                resDetailUser.classList.toggle("show-user");
                arrowRotateUser.style.transform = resDetailUser.classList.contains("show-user") ?
                    "rotate(90deg)" : "rotate(0deg)";
            });
        }

        if (menuBtnUser) {
            menuBtnUser.addEventListener('click', function() {
                mainSidebarUser.classList.toggle('show-sidebar-user');
            });
        }

        if (notificationButtonUser) {
            notificationButtonUser.addEventListener("click", function() {
                showPageUser.classList.toggle("show-user");
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const attendanceBtnUserToggle = document.getElementById("attendence-btn-user");
        const attendanceUser = document.getElementById("attendence-user");
        const attendanceRotateArrowUser = document.getElementById("attendence-rotate-arrow-user");

        const recruitmentBtnUserToggle = document.getElementById("recruitment-btn-user");
        const reqDetailUser = document.getElementById("recruitment-user");
        const reqArrowRotateUser = document.getElementById("recruitment-rotate-arrow-user");

        const roosterBtnUserToggle = document.getElementById("rooster-btn-user");
        const roosterDetailUser = document.getElementById("rooster-user");
        const roosterArrowRotateUser = document.getElementById("rooster-rotate-arrow-user");

        const operationUserToggle = document.getElementById("opration-user");
        const opDetailUser = document.getElementById("op-detail-user");
        const operationRotateArrowUser = document.getElementById("opration-rotate-arrow-user");

        const accountUserToggle = document.getElementById("account-user");
        const accDetailUser = document.getElementById("acc-detail-user");
        const accountArrowRotateUser = document.getElementById("acount-arrow-rotate-user");
        
        const businessUserToggle = document.getElementById("business-user");
        const busDetailUser = document.getElementById("bus-detail-user");
        const businessArrowRotateUser = document.getElementById("business-arrow-rotate-user");


        // Ensure elements exist before attaching event listeners
        if (attendanceBtnUserToggle) {
            attendanceBtnUserToggle.addEventListener("click", function() {
                removeShow();
                attendanceUser.classList.toggle("show-user");
                attendanceRotateArrowUser.style.transform = attendanceUser.classList.contains("show-user") ?
                    "rotate(90deg)" : "rotate(0deg)";
            });
        }

        if (recruitmentBtnUserToggle) {
            recruitmentBtnUserToggle.addEventListener("click", function() {
                removeShow();
                reqDetailUser.classList.toggle("show-user");
                reqArrowRotateUser.style.transform = reqDetailUser.classList.contains("show-user") ?
                    "rotate(90deg)" : "rotate(0deg)";
            });
        }

        if (roosterBtnUserToggle) {
            roosterBtnUserToggle.addEventListener("click", function() {
                removeShow();
                roosterDetailUser.classList.toggle("show-user");
                roosterArrowRotateUser.style.transform = roosterDetailUser.classList.contains("show-user") ?
                    "rotate(90deg)" : "rotate(0deg)";
            });
        }

        if (operationUserToggle) {
            operationUserToggle.addEventListener("click", function() {
                removeShow();
                opDetailUser.classList.toggle("show-user");
                operationRotateArrowUser.style.transform = opDetailUser.classList.contains("show-user") ?
                    "rotate(90deg)" : "rotate(0deg)";
            });
        }

        if (accountUserToggle) {
            accountUserToggle.addEventListener("click", function() {
                removeShow();
                accDetailUser.classList.toggle("show-user");
                accountArrowRotateUser.style.transform = accDetailUser.classList.contains("show-user") ?
                    "rotate(90deg)" : "rotate(0deg)";
            });
        }
        if (businessUserToggle) {
            businessUserToggle.addEventListener("click", function() {
                removeShow();
                busDetailUser.classList.toggle("show-user");
                businessArrowRotateUser.style.transform = busDetailUser.classList.contains("show-user") ?
                    "rotate(90deg)" : "rotate(0deg)";
            });
        }
    });

    function removeShow() {
        const allDetails = document.querySelectorAll(".btn-detail");
        const allArrows = document.querySelectorAll(".sidebar-btn img[id$='rotate-arrow-user']");

        allDetails.forEach(item => item.classList.remove("show-user"));
        allArrows.forEach(item => item.style.transform = "rotate(0deg)");
    }
</script>