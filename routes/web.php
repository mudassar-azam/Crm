<?php

use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\EngineerToolController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CrmUserController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeadAndMemberController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EngineerDashboardController;
use App\Http\Controllers\RoosterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



// authentication 
Auth::routes();
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['mobile_detector'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['mobile_detector'])->group(function () {
    Route::middleware(['auth'])->group(function () {

        // engineer routes 
        Route::middleware(['engineer'])->group(function () {
            Route::get('/engineer-dashboard', [EngineerDashboardController::class, 'index'])->name('engineer.dashboard');
            Route::get('/engineer/confirmed/activities', [EngineerDashboardController::class, 'confirmActivities'])->name('engineer.confirm.activities');
            Route::get('/engineer/approved/activities', [EngineerDashboardController::class, 'approveActivities'])->name('engineer.approve.activities');
            Route::get('/engineer/paid/activities', [EngineerDashboardController::class, 'paidActivities'])->name('engineer.paid.activities');
            Route::get('/engineer/settings', [EngineerDashboardController::class, 'settings'])->name('engineer.settings');
            Route::post('/engineer/verify-email', [EngineerDashboardController::class, 'verifyEmail'])->name('engineer.email.verify');
            Route::post('/engineer/verify-otp', [EngineerDashboardController::class, 'verifyOtp'])->name('engineer.otp.verify');
            Route::post('/engineer/password', [EngineerDashboardController::class, 'engineerPassword'])->name('engineer.password');
        });

        // dashboard 
        Route::post('/note', [NoteController::class, 'store'])->name('note.store');
        Route::post('/note-update', [NoteController::class, 'update'])->name('note.update');
        Route::post('/destroyNote/{id}', [NoteController::class, 'destroy'])->name('note.destroy');
        Route::get('/data-for-year/{year}', [ActivityController::class, 'getDataForYear']);
        Route::get('/clients/activities', [ClientController::class, 'getActivitiesByDateRange']);


        // Skills
        Route::post('/skill', [SkillController::class, 'store'])->name('skill.store');
        Route::delete('/skill/{id}', [SkillController::class, 'destroy'])->name('skill.destroy');
        Route::put('/skillUpdate/{id}', [SkillController::class, 'update'])->name('skill.update');
        Route::get('skills/', [SkillController::class, 'index'])->name('skills.index');

        // Tools
        Route::get('tools/', [ToolController::class, 'index'])->name('tools.index');
        Route::put('/toolUpdate/{id}', [ToolController::class, 'update'])->name('tool.update');
        Route::prefix('tool')->group(function () {
            Route::post('/', [ToolController::class, 'store'])->name('tool.store');
            Route::delete('/{id}', [ToolController::class, 'destroy'])->name('tool.destroy');
        });

        // Engineer Tools
        Route::get('engineer-tools/', [EngineerToolController::class, 'index'])->name('engineer-tools.index');
        Route::put('/engineer-toolUpdate/{id}', [EngineerToolController::class, 'update'])->name('engineer-tool.update');
        Route::prefix('engineertoool')->group(function () {
            Route::post('/', [EngineerToolController::class, 'store'])->name('engineer-tool.store');
            Route::delete('/{id}', [EngineerToolController::class, 'destroy'])->name('engineer-tool.destroy');
        });

        // Availabilities
        Route::get('availabilities/', [AvailabilityController::class, 'index'])->name('availabilities.index');
        Route::prefix('availability')->group(function () {
            Route::post('/', [AvailabilityController::class, 'store'])->name('availability.store');
            Route::put('/{id}', [AvailabilityController::class, 'update'])->name('availability.update');
            Route::delete('/{id}', [AvailabilityController::class, 'destroy'])->name('availability.destroy');
        });

        // Resources

        Route::middleware(['recruitment'])->group(function () {
            Route::get('/all-resources', [ResourceController::class, 'index'])->name('resources.index');
            Route::get('/resource/create', [ResourceController::class, 'create'])->name('resources.create');
            Route::post('/resource/store', [ResourceController::class, 'store'])->name('resource.store');
            Route::get('/resource/{id}', [ResourceController::class, 'edit'])->name('resource.edit');
            Route::put('/resource/{id}', [ResourceController::class, 'update'])->name('resource.update');
            Route::delete('/resource/{id}', [ResourceController::class, 'destroy'])->name('resource.destroy');
            Route::get('resources/track', [ResourceController::class, 'track'])->name('resources.track');
            Route::get('/graph', [ResourceController::class, 'graph'])->middleware('resmaplocation')->name('resources.graph');
            Route::get('/getResourceCities/{id}', [ResourceController::class, 'getResourceCities'])->name('getResourceCities');
            Route::post('/check-contact', [ResourceController::class, 'checkContact'])->name('check.contact');
            Route::post('/check-email', [ResourceController::class, 'checkEmail'])->name('check.email');
        });

        Route::middleware(['admin'])->group(function () {
            Route::get('resources/active', [ResourceController::class, 'active'])->name('resources.active');
            Route::get('resources/worked', [ResourceController::class, 'worked'])->name('resources.worked');
            Route::post('import-resources', [ResourceController::class, 'import'])->name('resources.import');
        });

        //task
        Route::middleware(['recruitment'])->group(function () {
            Route::get('resources/task-to-do', [TaskController::class, 'index'])->name('tasks.index');
            Route::post('resources/tasks', [TaskController::class, 'store'])->name('tasks.store');
            Route::post('resources/task', [TaskController::class, 'update'])->name('task.edit');
            Route::post('/destroyTask/{id}', [TaskController::class, 'destroy'])->name('task.destroy');
            Route::post('/taskDone', [TaskController::class, 'taskDone'])->name('task.done');
            Route::post('/taskUpdateStatus', [TaskController::class, 'UpdateStatus'])->name('task.update.status');
        });


        // Download
        Route::get('/rate-snap/{filename}', [FileDownloadController::class, 'downloadRateSnap'])->name('ratesnap.download');
        Route::get('/resume/{filename}', [FileDownloadController::class, 'downloadResume'])->name('resume.download');
        Route::get('/bgvs/download/{fileName}', [FileDownloadController::class, 'downloadBgvs'])->name('bgvs.download');
        Route::get('/license/{filename}', [FileDownloadController::class, 'downloadLicense'])->name('license.download');
        Route::get('/visa/{filename}', [FileDownloadController::class, 'downloadVisa'])->name('visa.download');
        Route::get('/passport/{filename}', [FileDownloadController::class, 'downloadPassport'])->name('passport.download');
        Route::get('/activity.download/{fileName}', [FileDownloadController::class, 'downloadActivity'])->name('activity.download');
        Route::get('/proofDownload/{filename}', [FileDownloadController::class, 'proofDownload'])->name('proofDownload');
        Route::get('/formNdaDownload/{filename}', [FileDownloadController::class, 'formNdaDownload'])->name('formNdaDownload');


        // Client
        Route::middleware(['business'])->group(function () {
            Route::get('/all-clients', [ClientController::class, 'index'])->name('client.index');
            Route::get('/client/create', [ClientController::class, 'create'])->name('client.create');
            Route::post('/client/store', [ClientController::class, 'store'])->name('client.store');
            Route::get('/client/edit/{edit}', [ClientController::class, 'edit'])->name('client.edit');
            Route::post('/client/update/{id}', [ClientController::class, 'update'])->name('client.update');
            Route::post('/deleteClient/{id}', [ClientController::class, 'destroy']);
            Route::get('/clients/work-with-us', [ClientController::class, 'workingWithClients'])->name('client.work');
            Route::get('all-follow-up-clients', [ClientController::class, 'indexFollowUpClient'])->name('client.follow.index');
            Route::get('clients/follow-up', [ClientController::class, 'createFollowUpClient'])->name('client.follow.create');
            Route::post('/follow-up-client/store', [ClientController::class, 'storeFollowUpClient'])->name('client.follow.store');
            Route::get('/follow-up-client/edit/{edit}', [ClientController::class, 'editFollowUpClient'])->name('client.follow.edit');
            Route::post('/follow-up-client/update/{id}', [ClientController::class, 'updateFollowUpClient'])->name('client.follow.update');
            Route::post('/change-status', [ClientController::class, 'changeStatus'])->name('client.followup.change.status');
            Route::post('/deleteFollowUpClient/{id}', [ClientController::class, 'destroyFollowUpClient']);
            Route::post('/add-to-normal/{id}', [ClientController::class, 'addToNormal']);
        });


        // Activities
        Route::middleware(['operation'])->group(function () {
            Route::get('/activity/create', [ActivityController::class, 'create'])->name('activity.create');
            Route::post('/activity/store', [ActivityController::class, 'store'])->name('activity.store');
            Route::get('/completed-activities', [ActivityController::class, 'completedActivity'])->name('activity.completed');
            Route::post('/activity/complete', [ActivityController::class, 'complete'])->name('activity.complete');
            Route::get('/activities/planed', [ActivityController::class, 'planed'])->name('activities.planed');
            Route::get('/activity/edit/{edit}', [ActivityController::class, 'planedEdit'])->name('activity.planed.edit');
            Route::put('/activity/planed/{id}', [ActivityController::class, 'planedupdate'])->name('activity.planed.update');
            Route::post('/confirmActivity', [ActivityController::class, 'confirmActivity'])->name('activity.confirmActivity');
            Route::get('/activities/confirmed', [ActivityController::class, 'confirmedActivities'])->name('activities.confirmed');
            Route::post('/activity/closed/{id}', [ActivityController::class, 'activityClosed'])->name('close.activity');
            Route::post('/approveActivity/{id}', [ActivityController::class, 'approveActivity'])->name('approveActivity');
            Route::delete('/destroyActivity/{id}', [ActivityController::class, 'destroyActivity'])->name('activity.destroy');
            Route::get('/getCities/{id}', [ActivityController::class, 'getCities'])->name('getCities');
            Route::get('/getResources/{city}', [ActivityController::class, 'getResources'])->name('getResources');
            Route::post('/activity/assign', [ActivityController::class, 'assignActivity'])->name('activity.assign');
            Route::post('/activity/assign/task', [ActivityController::class, 'assignTaskActivity'])->name('activity.assign.task');
            Route::get('/activities/display-mode', [ActivityController::class, 'displayMode'])->name('activities.display.mode');
            Route::get('/total/activities', [ActivityController::class, 'totalActivities'])->name('total.activities');
            Route::get('/total-activity/edit/{id}', [ActivityController::class, 'editTotalActivity']);
            Route::put('/total-activity/update/{id}', [ActivityController::class, 'UpdateTotalActivity'])->name('totalactivity.update');
            
            // Project
            Route::get('/project/create', [ProjectController::class, 'create'])->name('project.create');
            Route::post('/project/store', [ProjectController::class, 'store'])->name('project.store');

            //prints
            Route::get('/activity-print/{id}', [PrintController::class, 'activityPrint']);

            //emails
            Route::post('/activity/send/email', [EmailController::class, 'sendMail'])->name('activity.send.email');
        });

        Route::get('/activities/approved', [ActivityController::class, 'approved'])->middleware('operationOraccount')->name('activities.approved');

        // Account/Tech Invoices + Client Invoices
        Route::middleware(['accounts'])->group(function () {
            Route::get('/accounts/tech-payable-invoices', [InvoiceController::class, 'techPayableInvoices'])->name('techPayableInvoices');
            Route::get('/accounts/tech-paid-invoices', [InvoiceController::class, 'techPaidInvoices'])->name('techPaidInvoices');
            Route::post('/accounts/generatTechInvoice/{id}', [InvoiceController::class, 'generatTechInvoice'])->name('generatTechInvoice');
            Route::post('/deleteTechInvoice/{id}', [InvoiceController::class, 'deleteTechInvoice'])->name('deleteTechInvoice');
            Route::post('/techActivityPayment/{id}', [InvoiceController::class, 'techActivityPayment'])->name('techActivityPayment');
            Route::get('/accounts/tech-unpaid-invoice/{id}', [InvoiceController::class, 'techUnPaidInvoice'])->name('techUnPaidInvoice');
            Route::get('/accounts/tech-paid-invoice/{id}', [InvoiceController::class, 'techPaidInvoice'])->name('techPaidInvoice');

            Route::post('/accounts/clientinvoices/addaccount', [InvoiceController::class, 'generatCustomerInvoice'])->name('customer.invoice.add.account');
            Route::get('/accounts/client-payable-invoices', [InvoiceController::class, 'clientPayableInvoices'])->name('clientPayableInvoices');
            Route::post('/deleteCustomerInvoice/{id}', [InvoiceController::class, 'deleteCustomerInvoice'])->name('deleteCustomerInvoice');
            Route::get('/accounts/client-paid-invoices', [InvoiceController::class, 'clientPaidInvoices'])->name('clientPaidInvoices');
            Route::post('/customerPaymentConfirmation/{id}', [InvoiceController::class, 'customerPaymentConfirmation'])->name('customerPaymentConfirmation');
            Route::get('/accounts/customer-unpaid-invoice/{id}', [InvoiceController::class, 'customerUnPaidInvoice'])->name('customerUnPaidInvoice');
            Route::get('/accounts/customer-paid-invoice/{id}', [InvoiceController::class, 'customerPaidInvoice'])->name('customerPaidInvoice');
        });    

        // Attendance + leads and members
        Route::get('/attendance-dashboard', [AttendanceController::class, 'dashboard'])->name('attendance.dashboard');
        Route::post('/check-in', [AttendanceController::class, 'storeCheckIn']);
        Route::post('/check-out', [AttendanceController::class, 'storeCheckOut']);
        Route::get('/all/{id}', [AttendanceController::class, 'allAttendance'])->name('allAttendance');
        Route::post('/deleteAttendance/{id}', [AttendanceController::class, 'deleteAttendance'])->name('deleteAttendance');
        Route::get('/attendance-leave-status', [AttendanceController::class, 'leaveStatus'])->name('attendance.leavestatus');
         Route::post('/update-attendance', [AttendanceController::class, 'updateAttendance'])->name('attendance.update');
        Route::get('/students', [AttendanceController::class, 'getStudents']);
        Route::get('/leaves', [AttendanceController::class, 'getLeaves']);
        Route::get('/users', [AttendanceController::class, 'users'])->name('users');

        Route::middleware(['admin'])->group(function () {
            Route::post('/assign', [LeadAndMemberController::class, 'assign'])->name('assign');
            Route::get('/leads-members', [LeadAndMemberController::class, 'index'])->name('leadsMembers.index');
            Route::get('/edit-assigned/{id}', [LeadAndMemberController::class, 'edit'])->name('leads.editAssigned');
            Route::post('/update-assigned', [LeadAndMemberController::class, 'update'])->name('leads.updateAssigned');
            Route::post('/destroyLead&Member/{id}', [LeadAndMemberController::class, 'destroy'])->name('leads.destroyLead&Member');

            // Admin Settings/User
            Route::get('/admin-settings', [AdminSettingsController::class, 'index'])->name('adminsettings.index');
            Route::post('/store-user', [AdminSettingsController::class, 'store'])->name('user.store');
            Route::post('/destroyUser/{id}', [AdminSettingsController::class, 'destroy'])->name('user.destroy');
            Route::post('/edit-user', [AdminSettingsController::class, 'edit'])->name('user.edit');

            // Admin Settings/Anouncement
            Route::post('/anounsement.store', [AdminSettingsController::class, 'storeAnounsement'])->name('anounsement.store');
            Route::post('/destroyAnounsement/{id}', [AdminSettingsController::class, 'destroyAnounsement'])->name('anounsement.destroy');
            Route::post('/edit-anounsement', [AdminSettingsController::class, 'editAnounsement'])->name('anounsement.edit');

            // Admin Settings/Event
            Route::post('/event.store', [AdminSettingsController::class, 'storeEvent'])->name('event.store');
            Route::post('/destroyEvent/{id}', [AdminSettingsController::class, 'destroyEvent'])->name('event.destroy');
            Route::post('/edit-event', [AdminSettingsController::class, 'editEvent'])->name('event.edit');
            Route::get('/events', [AdminSettingsController::class, 'fetchEvents'])->name('events.fetch');

        });    

        // rooster
        Route::middleware(['admOrhrm'])->group(function () {
            Route::get('/all-roosters', [RoosterController::class, 'index'])->name('rooster.index');
            Route::get('/rooster/create', [RoosterController::class, 'create'])->name('rooster.create');
            Route::post('/rooster/store', [RoosterController::class, 'store'])->name('rooster.store');
            Route::get('/rooster/edit/{id}', [RoosterController::class, 'edit'])->name('rooster.edit');
            Route::post('/rooster/update/{id}', [RoosterController::class, 'update'])->name('rooster.update');
            Route::post('/rooster/destroy/{id}', [RoosterController::class, 'destroy'])->name('rooster.destroy');
            Route::get('/rooster/calendar-view', [RoosterController::class, 'cview'])->name('rooster.calendar.view');
            Route::get('/rusers', [RoosterController::class, 'users'])->name('rooster.calendar.view.users');
            Route::get('/allRoosters', [RoosterController::class, 'roosters'])->name('rooster.calendar.view.roosters');
            Route::get('/overrided-dates', [RoosterController::class, 'overrided'])->name('rooster.override');
            Route::post('/override/rooster/destroy/{id}', [RoosterController::class, 'odestroy'])->name('orooster.destroy');
        });
        
        //profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/add-leave', [ProfileController::class, 'store'])->name('leave.store');
        Route::post('/destroyLeave/{id}', [ProfileController::class, 'destroy']);
        Route::post('/approveLeave/{id}', [ProfileController::class, 'approveLeave'])->name('approveLeave');
    });
});    