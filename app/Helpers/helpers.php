<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('hasAdminRole')) {
    function hasAdminRole() {
        $user = Auth::user();
        $roles = ['Admin'];
        return in_array($user->role->name, $roles);
    }
}

if (!function_exists('hasRecruitmentRole')) {
    function hasRecruitmentRole() {
        $user = Auth::user();
        $roles = ['Admin', 'Recruitment Manager'];
        $roleTypes = ['RecmLead', 'RecmMember'];
        return in_array($user->role->name, $roles) || in_array($user->role_type, $roleTypes);
    }
}


if (!function_exists('hasOperationRole')) {
    function hasOperationRole() {
        $user = Auth::user();
        $roles = ['Admin', 'Service Delivery Manager'];
        $roleTypes = ['SdmLead', 'SdmMember'];
        return in_array($user->role->name, $roles) || in_array($user->role_type, $roleTypes);
    }
}

if (!function_exists('OperationRole')) {
    function OperationRole() {
        $user = Auth::user();
        $roles = ['Service Delivery Manager'];
        $roleTypes = ['SdmLead', 'SdmMember'];
        return in_array($user->role->name, $roles) || in_array($user->role_type, $roleTypes);
    }
}

if (!function_exists('HrRole')) {
    function HrRole() {
        $user = Auth::user();
        $roles = ['HR Manager'];
        $roleTypes = ['HrmLead', 'HrmMember'];
        return in_array($user->role->name, $roles) || in_array($user->role_type, $roleTypes);
    }
}

if (!function_exists('AdminOrManagers')) {
    function AdminOrManagers() {
        $user = Auth::user();
        $roles = ['Admin', 'Service Delivery Manager', 'Recruitment Manager','HR Manager','Accounts Manager'];
        return in_array($user->role->name, $roles);
    }
}


if (!function_exists('Managers')) {
    function Managers() {
        $user = Auth::user();
        $roles = ['Service Delivery Manager', 'Recruitment Manager','Accounts Manager'];
        return in_array($user->role->name, $roles);
    }
}

if (!function_exists('ManagersExceptAdminAndBd')) {
    function ManagersExceptAdminAndBd() {
        $user = Auth::user();
        $roles = ['Service Delivery Manager', 'Recruitment Manager','Accounts Manager','HR Manager'];
        return in_array($user->role->name, $roles);
    }
}

if (!function_exists('AdminOrHrManager')) {
    function AdminOrHrManager() {
        $user = Auth::user();
        $roles = ['Admin','HR Manager'];
        return in_array($user->role->name, $roles);
    }
}

if (!function_exists('AdminOrSdmManager')) {
    function AdminOrSdmManager() {
        $user = Auth::user();
        $roles = ['Admin','Service Delivery Manager'];
        return in_array($user->role->name, $roles);
    }
}

if (!function_exists('AdminOrSdmManagerOrLead')) {
    function AdminOrSdmManagerOrLead() {
        $user = Auth::user();
        $roles = ['Admin','Service Delivery Manager'];
        $roleTypes = ['SdmLead'];
        return in_array($user->role->name, $roles) || in_array($user->role_type, $roleTypes);
    }
}

if (!function_exists('SdmManager')) {
    function SdmManager() {
        $user = Auth::user();
        $roles = ['Service Delivery Manager'];
        return in_array($user->role->name, $roles);
    }
}

if (!function_exists('RecManager')) {
    function RecManager() {
        $user = Auth::user();
        $roles = ['Recruitment Manager'];
        return in_array($user->role->name, $roles);
    }
}

if (!function_exists('SdmLead')) {
    function SdmLead() {
        $user = Auth::user();
        $roleTypes = ['SdmLead'];
        return in_array($user->role_type, $roleTypes);
    }
}

if (!function_exists('SdmMember')) {
    function SdmMember() {
        $user = Auth::user();
        $roleTypes = ['SdmMember'];
        return in_array($user->role_type, $roleTypes);
    }
}

if (!function_exists('RecLead')) {
    function RecLead() {
        $user = Auth::user();
        $roleTypes = ['RecmLead'];
        return in_array($user->role_type, $roleTypes);
    }
}

if (!function_exists('RecMember')) {
    function RecMember() {
        $user = Auth::user();
        $roleTypes = ['RecmMember'];
        return in_array($user->role_type, $roleTypes);
    }
}

if (!function_exists('hasAccountRole')) {
    function hasAccountRole() {
        $user = Auth::user();
        $roles = ['Accounts Manager'];
        $roleTypes = ['AccmLead', 'AccmMember'];
        return in_array($user->role->name, $roles) || in_array($user->role_type, $roleTypes);
    }
}


if (!function_exists('BdManager')) {
    function BdManager() {
        $user = Auth::user();
        $roles = ['Admin','BD Manager'];
        return in_array($user->role->name, $roles);
    }
}

if (!function_exists('OnlyBdManager')) {
    function OnlyBdManager() {
        $user = Auth::user();
        $roles = ['BD Manager'];
        return in_array($user->role->name, $roles);
    }
}


if (!function_exists('hasLeadRole')) {
    function hasLeadRole() {
        $user = Auth::user();
        $roles = ['Lead'];
        return in_array($user->role->name, $roles);
    }
}

if (!function_exists('hasMemberRole')) {
    function hasMemberRole() {
        $user = Auth::user();
        $roles = ['Member'];
        return in_array($user->role->name, $roles);
    }
}

if (!function_exists('AdminOrRecManagerOrOpeManager')) {
    function AdminOrRecManagerOrOpeManager() {
        $user = Auth::user();
        $roles = ['Admin', 'Service Delivery Manager', 'Recruitment Manager'];
        return in_array($user->role->name, $roles);
    }
}

if (!function_exists('OnlyRecruitmentRole')) {
    function OnlyRecruitmentRole() {
        $user = Auth::user();
        $roles = ['Recruitment Manager'];
        $roleTypes = ['RecmLead', 'RecmMember'];
        return in_array($user->role->name, $roles) || in_array($user->role_type, $roleTypes);
    }
}

if (!function_exists('AdminOrAccountRole')) {
    function AdminOrAccountRole() {
        $user = Auth::user();
        $roles = ['Admin' , 'Accounts Manager'];
        $roleTypes = ['AccmLead', 'AccmMember'];
        return in_array($user->role->name, $roles) || in_array($user->role_type, $roleTypes);
    }
}

if (!function_exists('AdminRecManagerAndLead')) {
    function AdminRecManagerAndLead() {
        $user = Auth::user();
        $roles = ['Admin','Recruitment Manager'];
        $roleTypes = ['RecmLead'];
        return in_array($user->role->name, $roles) || in_array($user->role_type, $roleTypes);
    }
}

if (!function_exists('AdminAndRecruitmentAndOperation')) {
    function AdminAndRecruitmentAndOperation() {
        $user = Auth::user();
        $roles = ['Admin','Recruitment Manager','Service Delivery Manager'];
        $roleTypes = ['RecmLead', 'RecmMember','SdmLead', 'SdmMember'];
        return in_array($user->role->name, $roles) || in_array($user->role_type, $roleTypes);
    }
}


if (!function_exists('RecManagerOrOpeManager')) {
    function RecManagerOrOpeManager() {
        $user = Auth::user();
        $roles = ['Service Delivery Manager','Recruitment Manager'];
        return in_array($user->role->name, $roles);
    }
}

if (!function_exists('RecLeadOrOpeLead')) {
    function RecLeadOrOpeLead() {
        $user = Auth::user();
        $roleTypes = ['RecmLead','SdmLead'];
        return in_array($user->role_type, $roleTypes);
    }
}

if (!function_exists('RecMemberOrOpeMember')) {
    function RecMemberOrOpeMember() {
        $user = Auth::user();
        $roleTypes = ['RecmMember','SdmMember'];
        return in_array($user->role_type, $roleTypes);
    }
}