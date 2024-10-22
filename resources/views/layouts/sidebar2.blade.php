<sidebar class="sidebar-container" id="sidebar-show">
    <div class="sidebar">
        <div class="sidebar-buttons">
            <!-- Dashboard Button -->
            <button class="sidebar-btn {{ request()->routeIs('engineer.dashboard') ? 'active' : '' }}"
                onclick="window.location='{{ route('dashboard') }}'">
                <img src="{{ asset('Asserts/logo/dashboard.png') }}" class="botton-icon" />
                Dashboard
            </button>

            <!-- Confirm activities button -->
                <button class="sidebar-btn {{ request()->routeIs('engineer.confirm.activities') ? 'active' : '' }}"
                onclick="window.location='{{ route('engineer.confirm.activities') }}'">
                <img src="{{ asset('Asserts/logo/oprations.png') }}" class="botton-icon" />
                Confirmed Activities
            </button>

            <!-- Approved activities button -->
            <button class="sidebar-btn {{ request()->routeIs('engineer.approve.activities') ? 'active' : '' }}"
                onclick="window.location='{{ route('engineer.approve.activities') }}'">
                <img src="{{ asset('Asserts/logo/oprations.png') }}" class="botton-icon" />
                Approved Activities
            </button>

            <!-- Paid activities button -->
            <button class="sidebar-btn {{ request()->routeIs('engineer.paid.activities') ? 'active' : '' }}"
                onclick="window.location='{{ route('engineer.paid.activities') }}'">
                <img src="{{ asset('Asserts/logo/oprations.png') }}" class="botton-icon" />
                Paid Activities
            </button>

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
</style>