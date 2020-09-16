<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


use App\State;
use App\Country;
$s = 'public.';
Route::group(['middleware' => 'CheckSubscriptionAndSetupStatus'], function(){
Route::get('/', 'PageController@Dashboard')->name('dashboard');
Route::get('/dashboard', 'PageController@Dashboard')->name('dashboard');
});
$s = 'social.';
Route::get('/social/redirect/{provider}', ['as' => $s . 'redirect', 'uses' => 'Auth\SocialController@getSocialRedirect']);
Route::get('/social/handle/{provider}', ['as' => $s . 'handle', 'uses' => 'Auth\SocialController@getSocialHandle']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth:administrator'], function () {
    $a = 'admin.';
    Route::get('/', ['as' => $a . 'home', 'uses' => 'AdminController@getHome']);
});

Route::group(['prefix' => 'user', 'middleware' => 'auth:user'], function () {
    $a = 'user.';
    Route::get('/', ['as' => $a . 'dashboard', 'uses' => 'UserController@Dashboard']);

    Route::group(['middleware' => 'activated'], function () {
        $m = 'activated.';
        Route::get('protected', ['as' => $m . 'protected', 'uses' => 'UserController@getProtected']);
    });
});

Route::group(['middleware' => 'auth:web'], function () {
    $a = 'authenticated.';
    Route::get('/logout', ['as' => $a . 'logout', 'uses' => 'Auth\LoginController@logout']);
    Route::get('not-activated', ['as' => 'not-activated', 'uses' => function () {
        return view('errors.not-activated');
    }]);
});

/**
 * General Routes
 */

//404 error
Route::get('/404', array('uses' => 'PageController@error_404'));


// User profile
Route::get('/profile', array('uses' => 'PageController@profile'));
Route::post('profile/general', array('uses' => 'PageController@general_update'));
Route::post('profile/password', array('uses' => 'PageController@password_update'));
Route::post('profile/picture', array('uses' => 'PageController@picture_update'));
// End user profile

// delete
Route::get('del/{page}/{id}', array('uses' => 'PageController@del'));
//End general delete


//Add minor users
Route::get('view_users', array('uses' => 'PageController@view_users'));
Route::get('new_user', array('uses' => 'PageController@new_user'));
Route::post('new_user', array('uses' => 'PageController@post_new_user'));
// End add minor users

Route::post('/validate/login', array('uses' => 'Auth\LoginController@login'));
Auth::routes('/login', 'PageController@Login');
Route::post('/new/register', array('uses' => 'Auth\RegisterController@Register'));
Route::get('/subscription', array('uses' => 'SubscriptionController@Subscription'));
Route::get('/subscription/history', array('uses' => 'SubscriptionController@Active_Subscription'));
Route::get('setup', array('uses' => 'SubscriptionController@setup_company'))->name('setup');
Route::post('setup', array('uses' => 'SubscriptionController@post_setup'))->name('setup');
Route::get('subscription/pay', array('uses' => 'SubscriptionController@make_payment'));
Route::post('subscription/paynow', array('uses' => 'SubscriptionController@post_payment'));
Route::get('/complete_registration/{token}', array('uses' => 'Auth\RegisterController@Complete_registration'));
Route::get('cancel_plan/{id}', array('uses' => 'SubscriptionController@cancel_plan'));


Route::post('subscription/complete',  'SubscriptionController@Complete_transaction')->name('subscription.complete');


//end get states

//application form
Route::get('jobs/application-form/{refrence_id}','CorpHRM\CorpHRMController@Job_Application_form')->name('corphrm.job_application_form');
Route::get('jobs/application-form/{refrence_id}/{id}','CorpHRM\CorpHRMController@View_Job_Application_form');
Route::post('jobs/application-form','CorpHRM\CorpHRMController@post_application_form')->name('corphrm.postapplicationform');
// CorpHRM Routes
Route::group(['prefix' => '/corphrm', 'middleware' => ['auth', 'CorpHRMSub']], function () {
    
    Route::group(['middleware' => 'CheckSubscriptionAndSetupStatus'], function(){
    //get routes for recruitment

    Route::get('/delete/{type}/{id}','CorpHRM\CorpHRMController@DeleteFunction');

    Route::get('/','CorpHRM\CorpHRMController@getDashboard')->name('corphrm.dashboard')->middleware(['LogUserAction:CorpHRM,Viewed CorpHRM Dashboard','CorpHRMSettings']);
    Route::get('/logged_user_actions','CorpHRM\CorpHRMController@user_actions')->name('corphrm.logged_user_actions')->middleware(['LogUserAction:CorpHRM,Viewed CorpHRM logged users actions','CorpHRMAccessRoles:view_logs','CorpHRMSettings']);
    Route::get('/mark_attendance','CorpHRM\CorpHRMController@mark_attendance')->name('corphrm.mark_attendance')->middleware(['LogUserAction:CorpHRM,Marked Attendance','CorpHRMSettings']);
    Route::get('/rec_process/new','CorpHRM\CorpHRMController@getRecruitmentProcess')->middleware(['LogUserAction:CorpHRM,Viewed Add New Recruitment Process','CorpHRMAccessRoles:add_rprocess','CorpHRMSettings']);
    Route::get('/rec_process','CorpHRM\CorpHRMController@viewRecruitmentProcess')->middleware(['LogUserAction:CorpHRM,Viewed Recruitment Processes','CorpHRMAccessRoles:view_rprocess','CorpHRMSettings']);
    Route::get('/job_profile','CorpHRM\CorpHRMController@listJobProfile');
    Route::get('/job_profile/new','CorpHRM\CorpHRMController@getJobProfile');
    Route::get('/job_profile/edit/{id}','CorpHRM\CorpHRMController@EditJobProfile');
    Route::get('/rec_application/{id?}','CorpHRM\CorpHRMController@getRecruitmentApplication')->middleware(['LogUserAction:CorpHRM,Viewed Add Recruitment Applications','CorpHRMAccessRoles:view_rapplication', 'CorpHRMSettings']);
    Route::get('/rec_application/applications/pdf/{rec_id}/{process}','CorpHRM\CorpHRMController@Applicants_pdf')->middleware(['LogUserAction:CorpHRM,Viewed Pdf of Applicants Recruitments','CorpHRMAccessRoles:edit_slisting','CorpHRMSettings']);
    Route::get('/rec_application/applications/excel/{rec_id}/{process}','CorpHRM\CorpHRMController@Applicants_Excel')->middleware(['LogUserAction:CorpHRM,Viewed Excel sheet of Recruitments','CorpHRMAccessRoles:edit_slisting','CorpHRMSettings']);
    Route::post('/rec_application/applications/upload_scores','CorpHRM\CorpHRMController@upload_applicants_scores')->middleware(['LogUserAction:CorpHRM,Uploaded Scores for applicants via excel sheet','CorpHRMAccessRoles:edit_slisting','CorpHRMSettings']);
    Route::post('/rec_application/applications/upload_scores_manually','CorpHRM\CorpHRMController@upload_applicants_scores_manually')->middleware(['LogUserAction:CorpHRM,Uploaded Score for an applicant manually','CorpHRMAccessRoles:edit_slisting','CorpHRMSettings']);
    Route::get('/rec_application/applications/lock_scores','CorpHRM\CorpHRMController@lock_application_scores')->middleware(['LogUserAction:CorpHRM,Locked Application Scores','CorpHRMAccessRoles:edit_slisting','CorpHRMSettings']);
    Route::get('/rec_application/applications/unlock_scores','CorpHRM\CorpHRMController@unlock_application_scores')->middleware(['LogUserAction:CorpHRM,Unlocked Application Scores','CorpHRMAccessRoles:edit_slisting','CorpHRMSettings']);
    Route::get('/rec_application/applications/email_applicants/{stage}/{process_id}/{rec_app_id}','CorpHRM\CorpHRMController@email_shortlisted_candidates')->middleware(['LogUserAction:CorpHRM,Triggered automatic emails to shortlisted Candidates','CorpHRMAccessRoles:edit_slisting','CorpHRMSettings']);
    Route::get('/rec_application/applications/email_interviewers/{stage}/{process_id}/{rec_app_id}','CorpHRM\CorpHRMController@interviewer_notification_email')->middleware(['LogUserAction:CorpHRM,Triggered automatic emails to selected Interviewers','CorpHRMAccessRoles:edit_slisting','CorpHRMSettings']);
    Route::get('/rec_application/applications/{rec_id}/{id?}','CorpHRM\CorpHRMController@Applicants')->middleware(['LogUserAction:CorpHRM,Viewed Interview Application Applicants','CorpHRMAccessRoles:view_slisting','CorpHRMSettings']);
    Route::get('/rec_application/shortlist/{id}','CorpHRM\CorpHRMController@ShortlistApplicant')->middleware(['LogUserAction:CorpHRM,Shortlisted Applicants for new interview stage','CorpHRMAccessRoles:view_slisting','CorpHRMSettings']);
    Route::get('/rec_application/approve/{id}','CorpHRM\CorpHRMController@ApproveRecruitmentApplication')->middleware(['LogUserAction:CorpHRM,Approved recruitment application','CorpHRMAccessRoles:edit_rapplication','CorpHRMSettings']);
    Route::get('/rec_application/cancel/{id}','CorpHRM\CorpHRMController@CancelRecruitmentApplication')->middleware(['LogUserAction:CorpHRM,Cancelled recruitment application','CorpHRMAccessRoles:edit_rapplication','CorpHRMSettings']);
    Route::get('/rec_applications','CorpHRM\CorpHRMController@getRecruitmentApplications')->middleware(['LogUserAction:CorpHRM,Viewed recruitment applications','CorpHRMAccessRoles:view_rapplication','CorpHRMSettings']);
    Route::get('/rec_posting','CorpHRM\CorpHRMController@viewRecruitmentPostings')->middleware(['LogUserAction:CorpHRM,Viewed recruitment postings','CorpHRMAccessRoles:vieW_rposting','CorpHRMSettings']);
    Route::get('/rec_posting/new','CorpHRM\CorpHRMController@getRecruitmentPosting')->middleware(['LogUserAction:CorpHRM,Viewed Add New recruitment posting','CorpHRMAccessRoles:vieW_rposting','CorpHRMSettings']);
    Route::get('/interview_process','CorpHRM\CorpHRMController@viewInterviewProcess')->middleware(['LogUserAction:CorpHRM,Viewed all Interview processes','CorpHRMAccessRoles:view_rprocess','CorpHRMSettings']);
    Route::get('/interview_process/details/{id}','CorpHRM\CorpHRMController@InterviewProcessDetails')->middleware(['LogUserAction:CorpHRM,Viewed an Interview process','CorpHRMAccessRoles:view_rprocess','CorpHRMSettings']);
    Route::get('/interview_process/new','CorpHRM\CorpHRMController@getInterviewProcess')->middleware(['LogUserAction:CorpHRM,Viewed add new Interview processes','CorpHRMAccessRoles:view_rprocess','CorpHRMSettings']);
    Route::get('/interview_rating/new','CorpHRM\CorpHRMController@getInterviewRating')->middleware(['LogUserAction:CorpHRM,Viewed add new Interview rating','CorpHRMAccessRoles:view_irating','CorpHRMSettings']);
    Route::get('/interview_rating','CorpHRM\CorpHRMController@viewInterviewRating')->middleware(['LogUserAction:CorpHRM,Viewed all Interview ratings','CorpHRMAccessRoles:view_irating','CorpHRMSettings']);

    //CorpHRM Reports 
    
    //Excel
    Route::get('/reports/claims','CorpHRM\ReportsController@Claims')->name('corphrm.reports.claims');
    Route::get('/reports/loans','CorpHRM\ReportsController@loans')->name('corphrm.reports.loans');
    Route::get('/reports/leaves','CorpHRM\ReportsController@leaves')->name('corphrm.reports.leaves');
    Route::get('/reports/cashadvances','CorpHRM\ReportsController@CashAdvance')->name('corphrm.reports.CashAdvance');
    Route::get('/reports/activeemployees','CorpHRM\ReportsController@ActiveEmployees')->name('corphrm.reports.ActiveEmployees');
    Route::get('/reports/paye','CorpHRM\ReportsController@PAYE')->name('corphrm.reports.PAYE');
    Route::get('/reports/loans/repayments','CorpHRM\ReportsController@LoanRepayment');


    // rec update and edit

    Route::get('/rec_process/edit/{id}','CorpHRM\CorpHRMController@EditRecruitmentProcess')->middleware(['LogUserAction:CorpHRM,Viewed edit recruitment process','CorpHRMAccessRoles:edit_rprocess','CorpHRMSettings']);
    Route::post('/rec_process/edit','CorpHRM\CorpHRMController@UpdateRecruitmentProcess')->middleware(['LogUserAction:CorpHRM,Updated a recruitment process','CorpHRMAccessRoles:view_rprocess','CorpHRMSettings']);
    Route::post('/rec_posting/edit','CorpHRM\CorpHRMController@UpdateRecruitmentPostings')->middleware(['LogUserAction:CorpHRM,Updated a recruitment posting','CorpHRMAccessRoles:vieW_rposting','CorpHRMSettings']);
    Route::get('/rec_posting/edit/{id}','CorpHRM\CorpHRMController@EditRecruitmentPosting')->middleware(['LogUserAction:CorpHRM,Viewed edit recruitment posting','CorpHRMAccessRoles:vieW_rposting','CorpHRMSettings']);
    Route::post('/interview_process/edit','CorpHRM\CorpHRMController@UpdateInterviewProcess')->middleware(['LogUserAction:CorpHRM,Updated an Interview process','CorpHRMAccessRoles:view_rprocess','CorpHRMSettings']);
    Route::get('/interview_process/edit/{id}','CorpHRM\CorpHRMController@EditInterviewProcess')->middleware(['LogUserAction:CorpHRM,Viewed edit Interview process','CorpHRMAccessRoles:view_rprocess','CorpHRMSettings']);
    Route::get('/interview_rating/edit/{id}','CorpHRM\CorpHRMController@EditInterviewRating')->middleware(['LogUserAction:CorpHRM,Viewed edit Interview rating','CorpHRMAccessRoles:view_irating','CorpHRMSettings']);
    Route::post('/interview_rating/edit','CorpHRM\CorpHRMController@UpdateInterviewRating')->middleware(['LogUserAction:CorpHRM,Updated an Interview rating','CorpHRMAccessRoles:view_irating','CorpHRMSettings']);

    // End
    Route::get('/update/{sub_module}/{id}/{status}','CorpHRM\CorpHRMController@Update_CorpHRM');

        //post route for recruitment
    Route::post('/rec_process','CorpHRM\CorpHRMController@addRecruitmentProcess')->name('corphrm.rec_process')->middleware(['LogUserAction:CorpHRM,Added recruitment process','CorpHRMAccessRoles:add_rprocess','CorpHRMSettings']);
    Route::post('/job_profileform','CorpHRM\CorpHRMController@addJobProfile')->name('corphrm.job_profile')->middleware(['LogUserAction:CorpHRM,Added Job profile','CorpHRMSettings']);
    Route::post('/edit_job_profile','CorpHRM\CorpHRMController@edit_JobProfile')->name('corphrm.edit_job_profile')->middleware(['LogUserAction:CorpHRM,Edited Job profile','CorpHRMSettings']);
    Route::post('/rec_application','CorpHRM\CorpHRMController@addRecruitmentApplication')->name('corphrm.rec_application')->middleware(['LogUserAction:CorpHRM,Added recruitment application','CorpHRMAccessRoles:add_rapplication','CorpHRMSettings']);
    Route::post('/rec_posting','CorpHRM\CorpHRMController@addRecruitmentPosting')->name('corphrm.rec_posting')->middleware(['LogUserAction:CorpHRM,Added recruitment posting','CorpHRMAccessRoles:add_rposting','CorpHRMSettings']);
    Route::post('/interview_process','CorpHRM\CorpHRMController@addInterviewProcess')->name('corphrm.interview_process')->middleware(['LogUserAction:CorpHRM,Added interview process','CorpHRMAccessRoles:add_iprocess','CorpHRMSettings']);
    Route::post('/interview_rating','CorpHRM\CorpHRMController@addInterviewRating')->name('corphrm.interview_rating')->middleware(['LogUserAction:CorpHRM,Added interview rating','CorpHRMAccessRoles:add_irating','CorpHRMSettings']);

    //get route for claims
    Route::get('/claim_masters', 'CorpHRM\ClaimController@getAllClaimsMaster')->middleware(['LogUserAction:CorpHRM,Viewed all claims master','CorpHRMAccessRoles:view_cmaster','CorpHRMSettings']);
    Route::get('/claim_master', 'CorpHRM\ClaimController@getClaimMaster')->middleware(['LogUserAction:CorpHRM,Viewed add new claims master','CorpHRMAccessRoles:add_cmaster','CorpHRMSettings']);
    Route::get('/claim_applications', 'CorpHRM\ClaimController@getAllClaims')->middleware(['LogUserAction:CorpHRM,Viewed all claims application','CorpHRMAccessRoles:view_capplication','CorpHRMSettings']);
    Route::get('/my/claim_applications', 'CorpHRM\ClaimController@getMyClaims')->middleware(['LogUserAction:CorpHRM,Viewed his/her claims application','CorpHRMSettings']);
    Route::get('/claim_application/update', 'CorpHRM\ClaimController@UpdateClaim')->middleware(['LogUserAction:CorpHRM,Viewed edit claims application','CorpHRMAccessRoles:edit_capplication','CorpHRMSettings']);
    Route::get('/claim_application', 'CorpHRM\ClaimController@getClaimApplication')->middleware(['LogUserAction:CorpHRM,Viewed add claim application','CorpHRMAccessRoles:add_capplication','CorpHRMSettings']);
    Route::get('/claims/delete', 'CorpHRM\ClaimController@delete')->middleware(['LogUserAction:CorpHRM,Delete action carried out on a claim','CorpHRMSettings']);
    //post route for claims
    Route::post('/claims/edit', 'CorpHRM\ClaimController@edit')->middleware(['LogUserAction:CorpHRM,Edit Action carried out on a claim','CorpHRMSettings']);
    Route::post('/claim_master', 'CorpHRM\ClaimController@addClaimMaster')->name('corphrm.claim_master')->middleware(['LogUserAction:CorpHRM,Added claim master','CorpHRMSettings']);
    Route::post('/claim_application/{id}', 'CorpHRM\ClaimController@addClaimApplication')->name('corphrm.claim_application')->middleware(['LogUserAction:CorpHRM,Added claim application','CorpHRMSettings']);

        //get route for cash advance
    Route::get('/cashadvance/disbursment', 'CorpHRM\CashAdvanceController@list_cash_advance_disbursments')->middleware(['LogUserAction:CorpHRM,Viewed all cash advance disbursement','CorpHRMAccessRoles:view_cadisbursment','CorpHRMSettings']);
    Route::get('/my/cashadvance/disbursment', 'CorpHRM\CashAdvanceController@list_my_cash_advance_disbursments')->middleware(['LogUserAction:CorpHRM,Viewed his/her cash advance disbursement','CorpHRMSettings']);
    Route::get('/cashadvance/disbursment/new', 'CorpHRM\CashAdvanceController@get_cash_advance_disbursment')->middleware(['LogUserAction:CorpHRM,Viewed add new cash advance disbursement','CorpHRMAccessRoles:add_cadisbursment','CorpHRMSettings']);

    Route::get('/cashadvance/retirement', 'CorpHRM\CashAdvanceController@list_cash_advance_retirements')->middleware(['LogUserAction:CorpHRM,Viewed all cash advance retirements','CorpHRMAccessRoles:view_caretirement','CorpHRMSettings']);
    Route::get('/my/cashadvance/retirement', 'CorpHRM\CashAdvanceController@list_my_cash_advance_retirements')->middleware(['LogUserAction:CorpHRM,Viewed his/her cash advance retirements','CorpHRMSettings']);
    Route::get('/cashadvance/retirement/new', 'CorpHRM\CashAdvanceController@get_cash_advance_retirement')->middleware(['LogUserAction:CorpHRM,Viewed add new cash advance retirement','CorpHRMAccessRoles:add_caretirement','CorpHRMSettings']);

    Route::get('/cashadvance/advance', 'CorpHRM\CashAdvanceController@list_cash_advance_advances')->middleware(['LogUserAction:CorpHRM,Viewed all cash advance advance','CorpHRMAccessRoles:view_caadvance','CorpHRMSettings']);
    Route::get('/my/cashadvance/advance', 'CorpHRM\CashAdvanceController@list_my_cash_advance_advances')->middleware(['LogUserAction:CorpHRM,Viewed my cash advance advance','CorpHRMSettings']);
    Route::get('/cashadvance/advance/new', 'CorpHRM\CashAdvanceController@get_cash_advance_advance')->middleware(['LogUserAction:CorpHRM,Viewed add new cash advance advance','CorpHRMAccessRoles:add_caadvance','CorpHRMSettings']);

    Route::get('/cashadvance/retirement_approval', 'CorpHRM\CashAdvanceController@list_cash_retirement_approvals')->middleware(['LogUserAction:CorpHRM,Viewed cash advance retirement approval','CorpHRMAccessRoles:view_caapproval','CorpHRMSettings']);
    Route::get('/cashadvance/retirement_approval/new', 'CorpHRM\CashAdvanceController@get_cash_retirement_approval')->middleware(['CorpHRMSettings']);

    //post route for cash advance
    Route::post('/cashadvance/disbursment/new', 'CorpHRM\CashAdvanceController@post_cash_advance_disbursment')->middleware(['LogUserAction:CorpHRM,Added new cash advance disbursement','CorpHRMSettings']);
    Route::post('/cashadvance/retirement/new', 'CorpHRM\CashAdvanceController@post_cash_advance_retirement')->middleware(['LogUserAction:CorpHRM,Added new cash advance retirement','CorpHRMSettings']);
    Route::post('/cashadvance/advance/new', 'CorpHRM\CashAdvanceController@post_cash_advance_advance')->middleware(['LogUserAction:CorpHRM,Added new cash advance advance','CorpHRMSettings']);
    Route::post('/cashadvance/retirement_approval/new', 'CorpHRM\CashAdvanceController@post_cash_retirement_approval')->middleware(['CorpHRMSettings']);

    //loan routes
    Route::get('/loanmaster', 'CorpHRM\LoanController@listLoanMaster')->middleware(['LogUserAction:CorpHRM,Viewed all loans master','CorpHRMAccessRoles:view_lmaster','CorpHRMSettings']);
    Route::get('/loanmaster/new', 'CorpHRM\LoanController@getLoanMaster')->middleware(['LogUserAction:CorpHRM,Vuewed add new loan master','CorpHRMAccessRoles:view_lmaster','CorpHRMSettings']);
    Route::get('/loanmaster/edit/{id}', 'CorpHRM\LoanController@EditLoanMaster')->middleware(['LogUserAction:CorpHRM,Viewed an edit loan master page','CorpHRMAccessRoles:edit_lmaster','CorpHRMSettings']);
    Route::get('/loanapp', 'CorpHRM\LoanController@listLoanApplication')->middleware(['LogUserAction:CorpHRM,Viewed all loans application','CorpHRMAccessRoles:view_lapplication','CorpHRMSettings']);
    Route::get('/my/loanapp', 'CorpHRM\LoanController@listMyLoanApplication')->middleware(['LogUserAction:CorpHRM,Viewed his/her loans application','CorpHRMSettings']);
    Route::get('/loanapp/new', 'CorpHRM\LoanController@getLoanApplication')->middleware(['LogUserAction:CorpHRM,Viewed add new leave application','CorpHRMAccessRoles:view_lapplication','CorpHRMSettings']);
    Route::get('/loanapp/update', 'CorpHRM\LoanController@UpdateLoan')->middleware(['LogUserAction:CorpHRM,Viewed edit leave application','CorpHRMAccessRoles:edit_lapplication','CorpHRMSettings']);
    Route::get('/get/{parameter}/{id}', 'CorpHRM\LoanController@getParameters');
    Route::get('/loandisbursement/new', 'CorpHRM\LoanController@getLoanDisbursement')->middleware(['LogUserAction:CorpHRM,Viewed add new loan disbursment','CorpHRMSettings','CorpHRMAccessRoles:add_ldisbursment']);
    Route::get('/loandisbursement', 'CorpHRM\LoanController@listLoanDisbursement')->middleware(['LogUserAction:CorpHRM,Viewed all loans disbursments','CorpHRMSettings','CorpHRMAccessRoles:view_ldisbursment']);
    Route::get('/my/loandisbursement', 'CorpHRM\LoanController@listMyLoanDisbursement')->middleware(['LogUserAction:CorpHRM,Viewed his/her loans disbursments','CorpHRMSettings']);
    Route::get('/loanpayment/new', 'CorpHRM\LoanController@getLoanPayment')->middleware(['LogUserAction:CorpHRM,Viewed add new loans payment','CorpHRMAccessRoles:view_lpayment','CorpHRMSettings']);
    Route::get('/loanpayment', 'CorpHRM\LoanController@ListLoanPayment')->middleware(['LogUserAction:CorpHRM,Viewed all loans payment','CorpHRMAccessRoles:view_lpayment','CorpHRMSettings']);
    Route::get('/my/loanpayment', 'CorpHRM\LoanController@ListMyLoanPayment')->middleware(['LogUserAction:CorpHRM,Viewed his/her loans payment','CorpHRMSettings']);
    // TRAINING
    Route::get('/trainingmaster/new', 'CorpHRM\TrainingController@getTrainingMaster');
    Route::get('/trainingmaster', 'CorpHRM\TrainingController@list_training_master');
    Route::get('/trainingfacilitator/new', 'CorpHRM\TrainingController@getTrainingFacilitator');
    Route::get('/trainingfacilitator', 'CorpHRM\TrainingController@listTrainingFacilitator');
    Route::get('/trainingplan/new', 'CorpHRM\TrainingController@getTrainingPlan');
    Route::get('/trainingplan', 'CorpHRM\TrainingController@listTrainingPlan');
    
    Route::post('/loanmaster/edit', 'CorpHRM\LoanController@UpdateLoanMaster')->name('corphrm.loanmastereditform')->middleware(['LogUserAction:CorpHRM,Updated a loans master',]);
    Route::post('/loanmaster/new', 'CorpHRM\LoanController@postLoanMaster')->name('corphrm.loanmasterform')->middleware(['LogUserAction:CorpHRM,Added a loans master',]);
    Route::post('/loanappform', 'CorpHRM\LoanController@postLoanApplication')->name('corphrm.loanappform')->middleware(['LogUserAction:CorpHRM,Added a Loan application',]);
    Route::post('/loandisbursementform', 'CorpHRM\LoanController@postLoanDisbursement')->name('corphrm.loandisbursementform')->middleware(['LogUserAction:CorpHRM,Added a loan disbursment',]);
    Route::post('/loanpaymentform', 'CorpHRM\LoanController@postLoanPayment')->name('corphrm.loanpaymentform')->middleware(['LogUserAction:CorpHRM,added a loan payment',]);
    Route::post('/trainingmasterform', 'CorpHRM\TrainingController@postTrainingMaster')->name('corphrm.trainingmasterform')->middleware(['LogUserAction:CorpHRM,Viewed all loans master',]);
    Route::post('/trainingfacilitatorform', 'CorpHRM\TrainingController@postTrainingFacilitator')->name('corphrm.trainingfacilitatorform')->middleware(['LogUserAction:CorpHRM,Viewed all loans master',]);
    Route::post('/trainingplanform', 'CorpHRM\TrainingController@postTrainingPlan')->name('corphrm.trainingplanform')->middleware(['LogUserAction:CorpHRM,Viewed all loans master',]);
    //loan routes end

    //leave routes
    Route::get('/leavemaster', 'CorpHRM\LeaveController@listLeaveMaster')->middleware(['LogUserAction:CorpHRM,Viewed all leaves master','CorpHRMSettings','CorpHRMAccessRoles:view_lemaster']);
    Route::get('/leavemaster/new', 'CorpHRM\LeaveController@getLeaveMaster')->middleware(['LogUserAction:CorpHRM,Viewed add new leaves master','CorpHRMSettings','CorpHRMAccessRoles:add_lemaster']);
    Route::get('/leavemaster/edit/{id}', 'CorpHRM\LeaveController@EditLeaveMaster')->middleware(['LogUserAction:CorpHRM,Viewed edit leaves master ','CorpHRMSettings','CorpHRMAccessRoles:edit_lemaster']);
    Route::get('/leaveapp', 'CorpHRM\LeaveController@listLeaveApplication')->middleware(['LogUserAction:CorpHRM,Viewed all leaves applications','CorpHRMSettings']);//,'CorpHRMAccessRoles:list_leapplication'
    Route::get('/my/leaveapp', 'CorpHRM\LeaveController@listMyLeaveApplication')->middleware(['LogUserAction:CorpHRM,Viewed his/her leaves applications','CorpHRMSettings']);
    Route::get('/leaveapp/new', 'CorpHRM\LeaveController@getLeaveApplication')->middleware(['LogUserAction:CorpHRM,Viewed add new leaves application','CorpHRMSettings','CorpHRMAccessRoles:add_leapplication']);
    Route::get('/leaveapp/edit/{id}', 'CorpHRM\LeaveController@EditLeaveApplication')->middleware(['LogUserAction:CorpHRM,Viewed edit leaves application','CorpHRMSettings','CorpHRMAccessRoles:edit_leapplication']);
    Route::get('/leaveapp/update', 'CorpHRM\LeaveController@UpdateLeave')->middleware(['LogUserAction:CorpHRM,Updated some leaves parameters','CorpHRMSettings']);
    Route::get('/get/{parameter}/{id}', 'CorpHRM\LeaveController@getParameters')->middleware(['CorpHRMSettings']);
    Route::get('/leavecredit/new', 'CorpHRM\LeaveController@getLeaveCredit')->middleware(['LogUserAction:CorpHRM,Viewed add new leaves credit','CorpHRMSettings','CorpHRMAccessRoles:add_lecredit']);
    Route::get('/leavecredit/edit/{id}', 'CorpHRM\LeaveController@EditLeaveCredit')->middleware(['LogUserAction:CorpHRM,Viewed edit leave credit','CorpHRMSettings','CorpHRMAccessRoles:edit_lecredit']);
    Route::get('/leavecredit', 'CorpHRM\LeaveController@listLeaveCredit')->middleware(['LogUserAction:CorpHRM,Viewed all leaves credit','CorpHRMSettings','CorpHRMAccessRoles:view_lecredit']);
    Route::get('/my/leavecredit', 'CorpHRM\LeaveController@listMyLeaveCredit')->middleware(['LogUserAction:CorpHRM,Viewed my leaves credit','CorpHRMSettings']);
    Route::get('/leaveallowance/new', 'CorpHRM\LeaveController@getLeaveAllowance')->middleware(['LogUserAction:CorpHRM,Viewed add new leave allowance','CorpHRMSettings','CorpHRMAccessRoles:add_leallowance']);
    Route::get('/leaveallowance/edit/{id}', 'CorpHRM\LeaveController@EditLeaveAllowance')->middleware(['LogUserAction:CorpHRM,Viewed edit leave allowance','CorpHRMSettings','CorpHRMAccessRoles:edit_leallowance']);
    Route::get('/leaveallowance', 'CorpHRM\LeaveController@ListLeaveAllowance')->middleware(['LogUserAction:CorpHRM,Viewed all leave allowance','CorpHRMSettings','CorpHRMAccessRoles:view_leallowance']);
    Route::get('/my/leaveallowance', 'CorpHRM\LeaveController@ListMyLeaveAllowance')->middleware(['LogUserAction:CorpHRM,Viewed all leave allowance','CorpHRMSettings']);
    Route::get('/leavecalendar', 'CorpHRM\LeaveController@LeaveCalendar')->middleware(['LogUserAction:CorpHRM,Viewed leave calendar','CorpHRMSettings','CorpHRMAccessRoles:view_lecalendar']);

    Route::post('/leavemaster/new', 'CorpHRM\LeaveController@postLeaveMaster')->name('corphrm.leavemasterform')->middleware(['LogUserAction:CorpHRM,Added new leave master']);
    Route::post('/leavemaster/edit', 'CorpHRM\LeaveController@UpdateLeaveMaster')->name('corphrm.editleavemasterform')->middleware(['LogUserAction:CorpHRM,Updated a leave master']);
    Route::post('/leaveappform', 'CorpHRM\LeaveController@postLoanApplication')->name('corphrm.leaveappform')->middleware(['LogUserAction:CorpHRM,Added new leave application']);
    Route::post('/leaveappform/edit', 'CorpHRM\LeaveController@UpdateLoanApplication')->name('corphrm.editleaveappform')->middleware(['LogUserAction:CorpHRM,Updated a leave application']);
    Route::post('/leavecreditform', 'CorpHRM\LeaveController@postLeaveCredit')->name('corphrm.leavecreditform')->middleware(['LogUserAction:CorpHRM,Added new leave credit']);
    Route::post('/leavecredit/edit', 'CorpHRM\LeaveController@UpdateLeaveCredit')->name('corphrm.editleavecreditform')->middleware(['LogUserAction:CorpHRM,Updated a leave credit']);
    Route::post('/leaveallowanceform', 'CorpHRM\LeaveController@postLeaveAllowance')->name('corphrm.leaveallowanceform')->middleware(['LogUserAction:CorpHRM,Added new leave allowance']);
    Route::post('/leaveallowanceform/edit', 'CorpHRM\LeaveController@UpdateLeaveAllowance')->name('corphrm.editleaveallowanceform')->middleware(['LogUserAction:CorpHRM,Updated a leave allowance']);
    //end leave routes

    //Payments ROUTES
    Route::get('/payments', 'CorpHRM\PaymentsController@view_payments')->middleware(['LogUserAction:CorpHRM,Viewed all payments','CorpHRMAccessRoles:view_payment','CorpHRMSettings']);
    Route::get('/payments/{category}/{id}', 'CorpHRM\PaymentsController@make_payment')->middleware(['LogUserAction:CorpHRM,Added a new payment','CorpHRMAccessRoles:add_payment','CorpHRMSettings']);
    //POST ROUTES

    //Payroll ROUTES
    Route::get('/payroll/staffs', 'CorpHRM\PayrollController@staffs_payroll')->middleware(['LogUserAction:CorpHRM,Viewed staff payroll','CorpHRMAccessRoles:view_payroll','CorpHRMSettings']);
    Route::get('/payroll/staff', 'CorpHRM\PayrollController@staff_payroll')->middleware(['LogUserAction:CorpHRM,Viewed payslip','CorpHRMSettings']);
    Route::get('/payroll/staff_fees', 'CorpHRM\PayrollController@staff_fees')->middleware(['LogUserAction:CorpHRM,Payroll staff fees Page','CorpHRMAccessRoles:view_payroll','CorpHRMSettings']);
    Route::get('/payroll/settings', 'CorpHRM\PayrollController@settings')->middleware(['LogUserAction:CorpHRM,Viewed payroll settings','CorpHRMSettings']);
    Route::get('/payroll/settings/payee', 'CorpHRM\PayrollController@post_payee_settings')->middleware(['LogUserAction:CorpHRM,Added payee settings','CorpHRMSettings']);
    Route::post('/payroll/settings/runday', 'CorpHRM\PayrollController@post_runday_settings')->middleware(['LogUserAction:CorpHRM,Added Payroll Run day settings','CorpHRMSettings']);
    Route::get('/payroll/generate/{id?}', 'CorpHRM\PayrollController@GeneratePayroll')->middleware(['LogUserAction:CorpHRM,Generated payroll / payslip','CorpHRMSettings']);
    //POST ROUTES
    Route::post('/payroll/staff_fees', 'CorpHRM\PayrollController@post_staff_fees')->middleware(['LogUserAction:CorpHRM,Added Payroll staff fees','CorpHRMAccessRoles:view_payroll','CorpHRMSettings']);
    Route::post('/payroll/post_addition_subtraction', 'CorpHRM\PayrollController@post_addition_subtraction')->middleware(['LogUserAction:CorpHRM,Added a payroll addition / subtraction','CorpHRMSettings']);
    
    
    
    Route::get('/payroll/salary', 'CorpHRM\PayrollController@showSalary')->middleware(['LogUserAction:CorpHRM,Added a payroll addition / subtraction','CorpHRMSettings']);
    Route::post('/payroll/salary/find', 'CorpHRM\PayrollController@findSalary')->middleware(['LogUserAction:CorpHRM,Added a payroll addition / subtraction','CorpHRMSettings'])->name('payroll.salary');
    Route::post('/payroll/salary/save', 'CorpHRM\PayrollController@saveSalary')->middleware(['LogUserAction:CorpHRM,Added a payroll addition / subtraction','CorpHRMSettings'])->name('salary.save');
});
});

//external route for corp-hrm Job Application
Route::get('/job_application', 'CorpHRM\CorpHRMController@getJobApplication');


/* ------Routes for CorpHrm -----*/

Route::group(['prefix' => '/corphrm', 'middleware' => ['auth', 'CorpHRMSub']], function () {

       Route::get('/settings', [
       'uses' => 'CorpHRM\GeneralController@ViewSettings',
        'as' => 'settings'
    ])->middleware(['LogUserAction:CorpHRM,Viewed settings page','CorpHRMAccessRoles:view_settings']);
    
    Route::get('/action/delete', [
       'uses' => 'CorpHRM\GeneralController@Delete',
        'as' => 'delete'
    ])->middleware(['LogUserAction:CorpHRM,Delete action carried out']);
    Route::get('/action/edit', [
        'uses' => 'CorpHRM\GeneralController@Edit',
         'as' => 'delete'
     ])->middleware(['LogUserAction:CorpHRM,Edit action carried out']);

    Route::get('/employee/new', [
        'uses' => 'CorpHRM\EmployeeController@getEmployeeIndex',
        'as' => 'employee'
    ])->middleware(['LogUserAction:CorpHRM,Viewed add new employee','CorpHRMSettings']);
    Route::get('employee', [
        'uses' => 'CorpHRM\EmployeeController@getEmployee'
    ])->middleware(['LogUserAction:CorpHRM,Viewed employee listings','CorpHRMSettings']);
    Route::get('/employees', [
        'uses' => 'CorpHRM\EmployeeController@getEmployees',
        'as' => 'employees'
    ])->middleware(['LogUserAction:CorpHRM,Viewed employee listings','CorpHRMSettings']);
    Route::post('/bulk_staff_upload', [
        'uses' => 'CorpHRM\EmployeeController@bulk_staff_upload',
        'as' => 'corphrm_bulk_staff_upload'
    ])->middleware(['LogUserAction:CorpHRM,Bulk staff upload!']);
    
    //    Route Post for
    Route::post('/Allowances', [
        'uses' => 'CorpHRM\GeneralController@postAllowances',
        'as' => 'post_allowance'
    ])->middleware(['LogUserAction:CorpHRM,Added new allowance settings']);
    Route::post('/Health', [
        'uses' => 'CorpHRM\GeneralController@postHealth',
        'as' => 'post_health'
    ])->middleware(['LogUserAction:CorpHRM,Added new health settings']);
    Route::post('/Branches', [
        'uses' => 'CorpHRM\GeneralController@postBranches',
        'as' => 'post_branches'
    ])->middleware(['LogUserAction:CorpHRM,Added new branch settings']);

    //    Pension

    Route::post('/Pension', [
        'uses' => 'CorpHRM\GeneralController@postPension',
        'as' => 'pension'
    ])->middleware(['LogUserAction:CorpHRM,Added new pension settings']);

    Route::post('/Holiday', [
        'uses' => 'CorpHRM\GeneralController@postHolidays',
        'as' => 'holidays'
    ]);

    Route::post('/Internal', [
        'uses' => 'CorpHRM\GeneralController@postInternal',
        'as' => 'internal'
    ])->middleware(['LogUserAction:CorpHRM,Added new Internel revenue settings']);

    Route::post('/Departments', [
        'uses' => 'CorpHRM\GeneralController@postDepartments',
        'as' => 'post_departments'
    ])->middleware(['LogUserAction:CorpHRM,Added new department settings']);

    Route::post('/Currencies', [
        'uses' => 'CorpHRM\GeneralController@postCurrencies',
        'as' => 'post_currencies'
    ])->middleware(['LogUserAction:CorpHRM,Added new pension settings']);

    Route::post('/Qualification', [
        'uses' => 'CorpHRM\GeneralController@postQualification',
        'as' => 'post_qualification'
    ])->middleware(['LogUserAction:CorpHRM,Added new currency settings']);

        Route::post('/Document', [
        'uses' => 'CorpHRM\GeneralController@postDocument',
        'as' => 'post_document'
    ])->middleware(['LogUserAction:CorpHRM,Added new document settings']);

    Route::post('/access_roles', [
        'uses' => 'CorpHRM\GeneralController@postAccess_roles',
        'as' => 'post_access_roles'
    ])->middleware(['LogUserAction:CorpHRM,Added new access role settings']);

    Route::post('/Weekoff', [
        'uses' => 'CorpHRM\GeneralController@postWeekoff',
        'as' => 'post_weekoff'
    ])->middleware(['LogUserAction:CorpHRM,Added new weekend settings']);

    Route::post('/email_templates', [
        'uses' => 'CorpHRM\GeneralController@post_email_template',
        'as' => 'post_email_template'
    ])->middleware(['LogUserAction:CorpHRM,Updated Email Template']);

    Route::post('/Category', [
        'uses' => 'CorpHRM\GeneralController@postCategory',
        'as' => 'post_category'
    ])->middleware(['LogUserAction:CorpHRM,Added new category settings']);

    Route::post('/Grades', [
        'uses' => 'CorpHRM\GeneralController@postGrades',
        'as' => 'post_grades'
    ])->middleware(['LogUserAction:CorpHRM,Added new grade settings']);

    Route::post('/Designation', [
        'uses' => 'CorpHRM\GeneralController@postDesignation',
        'as' => 'post_designation'
    ])->middleware(['LogUserAction:CorpHRM,Added new designation settings']);

    Route::post('/Banks', [
        'uses' => 'CorpHRM\GeneralController@postBanks',
        'as' => 'post_banks'
    ])->middleware(['LogUserAction:CorpHRM,Added new bank settings']);

    //This is the route for Employee
    Route::post('/update_employee/{query}', [
        'uses' => 'CorpHRM\EmployeeController@update_employee',
        'as' => 'update_employee'
    ]);

    Route::post('/EmployeeProfile', [
        'uses' => 'CorpHRM\EmployeeController@postProfile',
        'as' => 'profile'
    ]);
    Route::post('/PersonalInfo', [
        'uses' => 'CorpHRM\EmployeeController@postPersonal',
        'as' => 'personal'
    ]);

    Route::post('/EmployeeDependent', [
        'uses' => 'CorpHRM\EmployeeController@postDependent',
        'as' => 'dependent'
    ]);

    Route::post('/EmployeeQualification', [
        'uses' => 'CorpHRM\EmployeeController@postQualification',
        'as' => 'qualification'
    ]);

    Route::post('/EmployeeEmergency', [
        'uses' => 'CorpHRM\EmployeeController@postEmergency',
        'as' => 'emergency'
    ]);

    Route::post('/EmployeeSkills', [
        'uses' => 'CorpHRM\EmployeeController@postSkills',
        'as' => 'skills'
    ]);

    Route::post('/EmployeeExperiences', [
        'uses' => 'CorpHRM\EmployeeController@postExperience',
        'as' => 'experience'
    ]);

    Route::post('/EmployeeLanguage', [
        'uses' => 'CorpHRM\EmployeeController@postLanguage',
        'as' => 'language'
    ]);

    Route::post('/EmployeeAssets', [
        'uses' => 'CorpHRM\EmployeeController@postAssetAssigned',
        'as' => 'assets'
    ]);

    Route::post('/EmployeeReferences', [
        'uses' => 'CorpHRM\EmployeeController@postReferences',
        'as' => 'refrences'
    ]);

    Route::post('/EmployeeDocument', [
        'uses' => 'CorpHRM\EmployeeController@postDocuments',
        'as' => 'document'
    ]);

    Route::post('/EmployeeSalaries', [
        'uses' => 'CorpHRM\EmployeeController@postSalary',
        'as' => 'salary'
    ]);

});

///////Setup/////
//
////setup page 1//
//Route::get('setup', array('uses' => 'SetupController@account_setup'))->name('setup');
//
////end setup page 1//
////setup page 2//
//Route::post('setup2', array('uses' => 'CorpFIN\CorpFINController@setup2'));
////end setup page 2//
//
////////END Setup//////

// CorpFIN Routes
Route::group(['prefix' => 'corpfin', 'middleware' => ['auth', 'CorpFINSub']], function () {

/////Setup/////

    //setup page 1//
    Route::get('setup', array('uses' => 'CorpFIN\CorpFINController@setup'));

    //end setup page 1//
    //setup page 2//
    Route::post('setup2', array('uses' => 'CorpFIN\CorpFINController@setup2'));
    //end setup page 2//

    //////END Setup//////


    //Dashboard
    Route::get('/', 'CorpFIN\CorpFINController@Dashboard')->name('corpfin.dashboard');
    Route::get('dashboard', 'CorpFIN\CorpFINController@Dashboard')->name('corpfin.dashboard');

    //traditional view 
    Route::get('/traditional/general_ledger', array('uses' => 'CorpFIN\CorpfinEntryController@trad_general_ledger') );
    Route::get('/traditional/get_accounts', array('uses' => 'CorpFIN\CorpfinEntryController@get_accounts'));
    Route::get('/traditional/get_subaccounts', array('uses' => 'CorpFIN\CorpfinEntryController@get_subaccounts'));
    Route::post('/traditional/store_diary', array('uses' => 'CorpFIN\CorpfinEntryController@store_diary'));
    ///Get states///
    Route::get('getstates/{country_id}', array('uses' => 'CorpFIN\CorpFINController@Get_states'));
    ////end get states///


    Route::get('reports/balance_sheet/date_range', array('uses' => 'CorpFIN\ReportsController@view_bs'));
    Route::get('reports/balance_sheet', array('uses' => 'CorpFIN\ReportsController@view_bs'));
    Route::get('reports/generate', array('uses' => 'CorpFIN\ReportsController@generate_reports'));
    Route::get('reports/trial_balance', array('uses' => 'CorpFIN\ReportsController@view_trial_balance'));
    Route::get('reports/profit_loss', array('uses' => 'CorpFIN\ReportsController@view_profit_loss'));
    Route::get('reports', array('uses' => 'CorpFIN\ReportsController@reports'));

    Route::get('menu_view/{view}', array('uses' => 'CorpFIN\CorpFINController@Change_view'));
    Route::get('list_tt/{fs_id}/{at_id}', array('uses' => 'CorpFIN\CorpFINController@list_tt'));
    Route::get('list_wt', 'CorpFIN\CorpFINController@list_wt')->name('list_wht');
    Route::get('get_ttn/{id}', array('uses' => 'CorpFIN\CorpFINController@get_ttn'));
    Route::get('get_products', array('uses' => 'CorpFIN\CorpfinEntryController@get_products'));
    Route::get('get_product/{product}', array('uses' => 'CorpFIN\CorpfinEntryController@get_product'));
    Route::get('get_asset_sub_acct', array('uses' => 'CorpFIN\CorpfinEntryController@get_asset_sub_acct'));
    Route::get('get_opex_sub_acct', array('uses' => 'CorpFIN\CorpfinEntryController@get_opex_sub_acct'));
    Route::get('get_depreciation_exp_sub_acct', array('uses' => 'CorpFIN\CorpfinEntryController@get_depreciation_exp_sub_acct'));
    Route::get('get_asset_type', array('uses' => 'CorpFIN\CorpfinEntryController@get_asset_type'));
    Route::get('list_product_details/{id}', array('uses' => 'CorpFIN\CorpFINController@list_product_details'));
    # corpfin data CIT computation
    Route::get('/cit/compute-cit', 'CorpFIN\CorpFinCITController@compute_corpfin_cit');
    Route::post('/cit/save-computed-cit', 'CorpFIN\FinancialYearReportController@create');
    Route::get('/cit/account-ledger/{account_no}', 'CorpFIN\CorpFinCITController@get_account_ledgers');

    /**
     * Corp Products
     */
    Route::get('product', 'CorpFinProductController@index')->name("corpfin.product.view");
    Route::get('product/add', 'CorpFinProductController@create')->name('corpfin.product.add');
    Route::post('product/add', 'CorpFinProductController@store')->name('corpfin.product.add');
    Route::get('product/edit', 'CorpFinProductController@edit')->name('corpfin.product.edit');
    Route::post('product/edit', 'CorpFinProductController@update')->name('corpfin.product.edit');
    Route::get('product/delete', 'CorpFinProductController@destroy')->name('corpfin.product.delete');
    Route::get('api/product/', 'CorpFinProductController@getProducts')->name('corpfin.api.get.product');
    Route::post('api/product/filter', 'CorpFinProductController@filterProducts')->name('corpfin.api.filter.product');
    Route::get('/api/product/name', 'CorpFinProductController@get_product_by_name');
    Route::get('/api/product/query/{query?}', 'CorpFinProductController@query_product');

    /**
     * Corp Services
     */
    Route::get('service', 'CorpFinServiceController@index')->name("corpfin.service.view");
    Route::get('service/add', 'CorpFinServiceController@create')->name('corpfin.service.add');
    Route::post('service/add', 'CorpFinServiceController@store')->name('corpfin.service.add');
    Route::get('service/edit', 'CorpFinServiceController@edit')->name('corpfin.service.edit');
    Route::post('service/edit', 'CorpFinServiceController@update')->name('corpfin.service.edit');
    Route::get('service/delete', 'CorpFinServiceController@destroy')->name('corpfin.service.delete');
    Route::get('api/service/', 'CorpFinServiceController@getServices')->name('corpfin.api.get.service');
    Route::post('api/service/filter', 'CorpFinServiceController@filter')->name('corpfin.api.filter.service');
    Route::get('/api/service/name', 'CorpFinServiceController@get_service_by_name');
    Route::get('/api/service/query/{query?}', 'CorpFinServiceController@query_service');

    Route::post('post_tt', array('uses' => 'CorpFIN\CorpFINController@post_tt'));
    Route::post('post_tp', array('uses' => 'CorpFIN\CorpFINController@post_tp'));
    Route::post('addentry' , array('uses' => 'CorpFIN\CorpfinEntryController@add_entry'));
    Route::get('filter_ledger' , array('uses' => 'CorpFIN\CorpfinEntryController@filter_ledger'));
    Route::get('filter_trad_ledger' , array('uses' => 'CorpFIN\CorpfinEntryController@filter_trad_ledger'));
    Route::get('view_ledgers' , array('uses' => 'CorpFIN\CorpfinEntryController@view_ledgers'));
    Route::get('add_services', array('uses' => 'CorpFIN\CorpFINController@Add_service'));
    Route::get('view', array('uses' => 'CorpFIN\CorpFINController@View_sales'));

    /**
     * Transaction Partners
     */
    Route::get('transaction', 'CorpFIN\CorpFinTransactionCtrl@index')->name('corpfin.transaction.view');
    Route::get('transaction/add', 'CorpFIN\CorpFinTransactionCtrl@create')->name("corpfin.transaction.add");
    Route::post('transaction/add', 'CorpFIN\CorpFinTransactionCtrl@store')->name("corpfin.transaction.add");
    Route::get('transaction/{id}/edit', 'CorpFIN\CorpFinTransactionCtrl@edit')->name("corpfin.transaction.edit");
    Route::post('transaction/{id}/edit', 'CorpFIN\CorpFinTransactionCtrl@update')->name("corpfin.transaction.edit");
    Route::get('api/transaction', 'CorpFIN\CorpFinTransactionCtrl@create')->name("corpfin.api.transaction.get");
    Route::get('api/transaction/delete', 'CorpFIN\CorpFinTransactionCtrl@destroy')->name("corpfin.api.transaction.delete");
    Route::get('api/transaction/{id}', 'CorpFIN\CorpFinTransactionCtrl@getTransactionType')->name("corpfin.api.transaction.type");
    // Route::get('api/transaction/{id}', 'CorpFIN\CorpFinTransactionCtrl@getTransactionType')->name("corpfin.api.transaction.type");
Route::get('trans-generic', 'CorpFIN\CorpFinTtypeGenericController@migrate_old_to_new');//->name("corpfin.api.transaction.type");
    
    //Todo: move aout of this group
    Route::get('api/state', function (Request $request) {
        $states = [];
        try {
            $states = State::whereCountryId(Request::input('id'))->get();
        } catch (\Exception $e) {

        }
        return response($states);
    })->name("corpfin.api.state.get");

    Route::get('api/state/name', function (Request $request) {
        $country = Country::whereName(Request::input('name'))->select('id')->first();
        $states = [];
        try {
            $states = State::whereCountryId($country->id)->get();
        } catch (\Exception $e) {

        }
        return response($states);
    })->name("corpfin.api.state.name.get");


    /**
     * Transaction Types
     */
    Route::get('trans/types', 'CorpFinTransTypeCtrl@index')->name('corpfin.trans.types.view');
    Route::get('trans/types/add', 'CorpFinTransTypeCtrl@create')->name('corpfin.trans.types.add');


    Route::get('view_services', array('uses' => 'CorpFIN\CorpFINController@View_service'));
    Route::get('add_transaction_types', array('uses' => 'CorpFIN\CorpFINController@Add_tt'));
    Route::get('calendar_event_get/{type}', array('uses' => 'CorpFIN\CorpFINController@calendar_event_get'));
    Route::get('calendar_event/{type}/{title}/{id}', array('uses' => 'CorpFIN\CorpFINController@calendar_event_post'));
//    Route::get('view_transaction_types',array('uses'=>'CorpFIN\CorpFINController@View_tt'));
    Route::get('add_entries', 'CorpFIN\EntryController@create');
    Route::get('view_entries', array('uses' => 'CorpFIN\CorpFINController@view_entries'));


    Route::get('vat', 'CorpFIN\CorpFINController@getVat')->name('vat.get');
    Route::get('wht', 'CorpFIN\CorpFINController@getWht')->name('wht.get');
    Route::post('edit/{page}/', 'CorpFIN\CorpFINController@edit');

    ////////////////////////invoice routes//////////////////////////////////
    Route::get('invoice/quotes/add', array('uses' => 'Invoice\InvoiceController@Create_quote'));
    Route::post('invoice/quotes/add', array('uses' => 'Invoice\InvoiceController@post_quotes'));
    Route::post('invoice/quote/email', array('uses' => 'Invoice\InvoiceController@email_invoices'));
    Route::get('invoice/quote/view', array('uses' => 'Invoice\InvoiceController@View_quotes'));
    Route::get('invoice/quotes/pdf/{id}', array('uses' => 'Invoice\InvoiceController@View_pdf'));
    Route::get('invoice/email/{id}', array('uses' => 'Invoice\InvoiceController@send_quote'));

    Route::get('invoice/add', array('uses' => 'Invoice\InvoiceController@Create_invoice'));
    Route::get('invoice/send-invoice/{invoice_id}', array('uses' => 'Invoice\InvoiceController@send_invoice'));
    Route::post('invoice/add', array('uses' => 'Invoice\InvoiceController@post_invoice'));
    Route::post('invoice/email', array('uses' => 'Invoice\InvoiceController@email_invoices'));
    Route::get('invoice/view/{id}', array('uses' => 'Invoice\InvoiceController@View_invoice'));
     Route::get('invoice/view', array('uses' => 'Invoice\InvoiceController@View_invoices'));
    Route::get('invoice/pdf/{id}', array('uses' => 'Invoice\InvoiceController@View_invoice_pdf'));

    Route::post('invoice/product/add', 'Invoice\InvoiceController@add_product');
    Route::get('invoice/product/remove/{id}', 'Invoice\InvoiceController@remove_product');
    Route::post('invoice/edit/{id}', 'Invoice\InvoiceController@edit_invoice');
    Route::post('invoice/discount/edit', 'Invoice\InvoiceController@edit_invoice_discount');
    Route::post('invoice/payment/add', 'Invoice\InvoiceController@add_payment');
    Route::get('invoice/convert/{id}', 'Invoice\InvoiceController@convert_quote');
    //invoice  qoutes items
    Route::post('invoice/quote-items/add', 'CorpFIN\CorpFinInvoiceItemController@create');
    Route::post('invoice/product/edit', 'CorpFIN\CorpFinInvoiceItemController@edit_item');
    
    ///////////////////////End Invoice Routes///////////////////////////////

    //////////////////////////Settings///////////////////////////////////////
    Route::get('settings/invoice_groups', array('uses' => 'Invoice\InvoiceController@Invoicegroups'));
    Route::post('settings/invoice_group', array('uses' => 'Invoice\InvoiceController@add_Invoicegroup'));
    Route::post('settings/edit/invoice_group', array('uses' => 'Invoice\InvoiceController@edit_Invoicegroup'));
    Route::get('settings/delete/invoice_group/{id}', array('uses' => 'Invoice\InvoiceController@delete_Invoicegroup'));
    Route::get('settings/tax_vat', 'TaxVATController@index')->name('vatrates');
    Route::post('settings/tax_vat', 'TaxVATController@store')->name('vatrates');
    Route::post('settings/edit/tax_vat', 'TaxVATController@update')->name('settings.vat');
    Route::get('settings/delete/tax_vat', 'TaxVATController@destroy')->name('delete.vat');
    Route::get('settings/tax_wht', 'TaxWHTController@index')->name('whtrates');
    Route::post('settings/tax_wht', 'TaxWHTController@store')->name('whtrates');
    Route::post('settings/edit/tax_wht', 'TaxWHTController@update')->name('settings.wht');
    Route::get('settings/delete/wht', 'TaxWHTController@destroy')->name('delete.wht');


    Route::get('settings/payment_method', array('uses' => 'CorpFIN\CorpFINController@paymentmethod'));
    Route::post('invoice/get_inv_products', array('uses' => 'CorpFIN\CorpFINController@get_inv_products'));
    Route::get('settings/markup', array('uses' => 'CorpFIN\CorpFINController@set_markup'));
    Route::post('settings/markup', array('uses' => 'CorpFIN\CorpFINController@store_markup'));
    /////////////////////////End Settings/////////////////////////////////////

    ///////////////////////Start Sample Entry Routes///////////////////////////////
    Route::resource('sample-entry', 'CorpFIN\SampleEntryController@store');


});


/////////END CorpFIN Routes//////////

/**
 * CorpTax Routes
 */


Route::group(['prefix' => 'corptax'], function () {

    Route::get('/index', 'CorpTax\CorpTaxController@getIndex')->name('corptax-index');

    Route::get('/', 'CorpTax\CorpTaxController@getDashboard')->name('corptax-overview');

    Route::get('/dashboard', 'CorpTax\CorpTaxController@getDashboard')->name('corptax-overview');

    Route::get('/WHT/reports/accounts-movement', 'CorpTax\WHTController@getAccountsMovement')->name('accounts_movement');

    Route::get('/WIT/view-transactions', 'CorpTax\WHTController@viewTransactions')->name('viewTransactions');

    Route::get('/WIT/view-transactions/by-period', 'CorpTax\WHTController@filterTransactions');

    Route::get('/WIT/reports/amount-payable', 'CorpTax\WHTController@getAmountPayableBy');

    Route::get('/WIT/search-transactions', 'CorpTax\WHTController@searchTransactions');

    Route::get('/WIT/print-schedule/{type}/f/{from?}/t/{to?}', 'CorpTax\WHTController@printRemittanceSchedule');

    Route::get('/WIT/prepare-schedule/printView', 'CorpTax\WHTController@preparePrintView');

    Route::get('/overview', 'CorpTax\CorpTaxController@getDashboard')->name('corptax-overview');

    Route::get('/WIT/log-transactions', 'CorpTax\WHTController@getLogTransactions')->name('logTransactions');

    Route::get('/WIT/download/schedule-template', 'CorpTax\WHTController@downloadRemittanceScheduleTemplate')->name('WHTScheduleTemplate');

    Route::post('/WIT/upload/transactions', 'CorpTax\WHTController@uploadTransactions');

    Route::post('/WIT/save/transaction', 'CorpTax\WHTController@saveTransaction');

    Route::get('/WIT/accountMovement/print', 'CorpTax\WHTController@printAccountMovement');

    Route::post('WIT/accountMovement/save', 'CorpTax\WHTController@saveAccountMovement');
    /**
     * CIT Routes
     */
    // Route::get('CIT/cit-computation', 'CorpFIN\CorpFinCITController@index')->name('cit-computation');

    Route::get('CIT/cit-computation','CorpTax\CITController@getCITComputation')->name('cit-computation');

    Route::get('company-profile/update','CorpTax\CITController@getUpdateProfile')->name('profile-update');

    Route::get('CIT/TrialBalanceTemplate/download','CorpTax\CITController@downloadTrialBalanceTemplate')->name('downloadTrialBalanceTemplate');

    Route::post('CIT/trial-balance/upload','CorpTax\CITController@uploadTrialBalance')->name('uploadTrialBalance');

    Route::post('CIT/trial-balance/map','CorpTax\CITController@mapTrialBalance')->name('mapTrialBalance');
    //VAT routes

    Route::get('/monthlyvatreturn','CorpTax\VATController@getMonthlyVatReturn')->name('MonthlyVATReturn');

    Route::post('/monthlyvatreturnform','CorpTax\VATController@postMonthlyVatReturn');

    Route::get('/movementinvatpayable','CorpTax\VATController@getMovementInVatPayable')->name('VATMovementSchedule');

    Route::get('/logTransaction','CorpTax\VATController@getLogTransaction')->name('logTransaction');

    Route::post('/logSalesTransaction','CorpTax\VATController@postSalesLogTransaction')->name('logSalesTransaction');

    Route::post('/logPurchaseTransaction','CorpTax\VATController@postPurchaseLogTransaction')->name('logPurchaseTransaction');

    Route::post('/postSalesTotalVatOutput','CorpTax\VATController@postSalesTotalVatOutput');

    Route::post('/postPurchaseTotalVatOutput','CorpTax\VATController@postPurchaseTotalVatOutput');

    Route::post('/postMovementInVatPayable','CorpTax\VATController@postMovementInVatPayable');

    //VAT routes end
});

Route::group(['prefix' => 'corpemt', 'middleware' => ['auth', 'CorpEMTSub']], function () {

    /* index page route */
    Route::get('dashboard', 'CorpEMT\DashboardController@index')->name('corpemt.dashboard');
    Route::get('/', 'CorpEMT\DashboardController@index')->name('corpemt.index');

    /*routing for users*/
    Route::get('users', 'CorpEMT\UsersController@index');
    Route::post('users', 'CorpEMT\UsersController@add_user');

    /*routing for company*/
    Route::get('company', 'CorpEMT\CompanyController@index');
    Route::post('company', 'CorpEMT\CompanyController@add_company');

    /*routing for client*/
    Route::get('client/new', 'CorpEMT\ClientController@new_client');
    Route::post('client/new', 'CorpEMT\ClientController@add_new_client');

    Route::get('client/manage', 'CorpEMT\ClientController@manage_client');
    Route::get('client/view/{unique_id}', 'CorpEMT\ClientController@details');
    // Route::get('client/edit/{unique_id}', 'ClientController@edit');
    Route::post('client/updatepersonaldetails', 'CorpEMT\ClientController@update_personal_details');
    Route::post('client/updatecompanydetails', 'CorpEMT\ClientController@update_company_details');
    Route::post('client/updateotherinformation', 'CorpEMT\ClientController@update_other_information');
    Route::post('client/addaction', 'CorpEMT\ClientController@add_action');
    Route::post('client/editaction', 'CorpEMT\CorpEMT\ClientController@update_action');
    Route::post('client/markasdone', 'CorpEMT\ClientController@action_completed');
    Route::post('client/deleteaction', 'CorpEMT\ClientController@delete_action');
    Route::post('client/addcall', 'CorpEMT\ClientController@add_call');
    Route::post('client/editcall', 'CorpEMT\ClientControlleconr@edit_call');
    Route::post('client/deletecall', 'CorpEMT\ClientController@delete_call');
    Route::post('client/adddeal', 'CorpEMT\ClientController@add_deal');
    Route::post('client/deletedeal', 'CorpEMT\ClientController@delete_deal');
    Route::post('client/editdeal', 'CorpEMT\ClientController@edit_deal');
    Route::post('client/addnote', 'CorpEMT\ClientController@add_note');
    Route::post('client/editnote', 'CorpEMT\ClientController@edit_note');
    Route::post('client/deletenote', 'CorpEMT\ClientController@delete_note');


    /* routing for deals */
    Route::get('deals', 'CorpEMT\DealsController@index')->name('emt.deal');
    Route::get('/pipeline', 'CorpEMT\DealsController@pipeline')->name('emt.pipeline');
    Route::get('/api/pipeline/get_deal_info/{month}/{year}/{stage}/{company_id}', 'CorpEMT\DealsController@pipeline_api_get_info')->name('api.pipeline.get.info');

    /* action stream route */
    Route::get('/action_stream', 'CorpEMT\ClientController@action_stream');

    /*routing for team*/
    // Route::get('team/manage', 'TeamController@manage_team');
    // Route::get('team/new', 'TeamController@new_team');
    // Route::get('team/assign', 'TeamController@assign_team');

    // /*routing for engagement*/
    // Route::get('engagement/manage', 'CorpEMT\EngagementController@manage_engagements');
    // Route::get('engagement/new', 'CorpEMT\EngagementController@new_engagement');

    // /*routing for project*/
    // Route::get('project/manage', 'CorpEMT\ProjectController@manage_porjects');
    // Route::get('project/new', 'CorpEMT\ProjectController@new_project');

    // /*routing for messages*/
    // Route::get('message/inbox', 'CorpEMT\MessageController@inbox');
    // Route::get('message/sent', 'CorpEMT\MessageController@sent');
    // Route::get('message/new', 'CorpEMT\MessageControllrr@compose_message');

    // /*routing for settings*/
    // Route::get('setting/source', 'CorpEMT\SettingsController@source');
    // Route::post('setting/source', 'CorpEMT\SettingsController@save_lead_source');
    // Route::post('setting/delete', 'CorpEMT\SettingsController@remove_source');

    // Route::get('setting/filter', 'CorpEMT\SettingsController@filter');
    /*routing for engagement*/
    Route::get('engagement/manage', 'CorpEMT\EngagementController@manage_engagements');
    Route::get('engagement/manage/{id}', 'CorpEMT\EngagementController@view_engagement');

    Route::post('engagement/add_discount', 'CorpEMT\EngagementController@add_discount');
    Route::post('engagement/add_expense', 'CorpEMT\EngagementController@add_expense');

    Route::post('engagement/savebasicdetails', 'CorpEMT\EngagementController@save_basic_details');
    Route::post('engagement/saveindustrydetails', 'CorpEMT\EngagementController@save_industry_details');
    Route::post('engagement/savefinancialdetails', 'CorpEMT\EngagementController@save_financial_details');
    Route::post('engagement/savecompanydetails', 'CorpEMT\EngagementController@save_company_details');
    Route::post('engagement/addmanagement', 'CorpEMT\EngagementController@save_management_details');
    Route::post('engagement/editmanagement', 'CorpEMT\EngagementController@edit_management_details');
    Route::post('engagement/addauditcommittee', 'CorpEMT\EngagementController@save_committee_details');
    Route::post('engagement/editauditcommittee', 'CorpEMT\EngagementController@edit_committee_details');
    Route::post('engagement/deletecommittee', 'CorpEMT\EngagementController@delete_committee');
    Route::post('engagement/deletemanagement', 'CorpEMT\EngagementController@delete_management');
    Route::post('engagement/saveproposal', 'CorpEMT\EngagementController@save_budget_proposal');
    Route::post('engagement/addengagementitem', 'CorpEMT\EngagementController@save_analysis_item');
    Route::post('engagement/deleteitem', 'CorpEMT\EngagementController@delete_item');

    /* filtering route */
    Route::get('/filter/pending_action', 'CorpEMT\ClientController@pending_action');
    Route::get('/filter/completed_action', 'CorpEMT\ClientController@completed_action');


    /*routing for project*/
    Route::get('project/manage', 'CorpEMT\ProjectController@manage_porjects');
    Route::get('project/new', 'CorpEMT\ProjectController@new_project');

    /*routing for messages*/
    // Route::get('message/inbox', 'CorpEMT\MessageController@inbox');
    // Route::get('message/sent', 'CorpEMT\MessageController@sent');
    // Route::get('message/new', 'CorpEMT\MessageControllrr@compose_message');

    /*routing for settings*/
    Route::get('setting/source', 'CorpEMT\SettingsController@source');
    Route::post('setting/source', 'CorpEMT\SettingsController@save_lead_source');
    Route::post('setting/delete', 'CorpEMT\SettingsController@remove_source');

    Route::get('setting/filter', 'CorpEMT\SettingsController@filter');

});


//inventory routes
Route::group(['middleware' => 'auth'], function(){

    Route::get('/inventory/dashboard', function(){
        return view('inventory.dashboard');
    });
    Route::post('/inventory/return', 'inventory\ProductController@return_product' );
    Route::post('/inventory/shop/confirm_movement/{sm}', 'inventory\ShopController@confirm_move');
    Route::post('/inventory/confirm_movement/{wm}', 'inventory\WarehouseController@confirm_move');
    Route::post('inventory/confirm_order/{order}' , 'inventory\OrderController@confirm_order');
    Route::get('/product/search', 'inventory\SearchController@productsearch');
    Route::post('/edit_product_line_item/{id}', 'inventory\ProductLineController@edit_product_line_item');
    Route::post('/store_product_line_item', 'inventory\ProductLineController@productline_item');
    Route::post('/shop_movement', 'inventory\ShopController@shop_movement');
    Route::post('/shop_shop', 'inventory\ShopController@shop_shop');
    Route::post('/store_warehouse_movement', 'inventory\WarehouseController@store_warehouse_movement');
    Route::get('/move/batch/{id}', 'inventory\WarehouseController@create_movement');
    Route::resource('/product', 'inventory\ProductController');
    Route::get('/create_batch/{id}', 'inventory\BatchController@create_batch');
    Route::resource('/batch', 'inventory\BatchController');
    Route::resource('/warehouse', 'inventory\WarehouseController');
    Route::resource('/productline', 'inventory\ProductLineController');
    Route::resource('/customer', 'inventory\CustomerController');
    Route::resource('/shop', 'inventory\ShopController');
    Route::get('/inventory/order/create', 'inventory\OrderController@create');
    Route::post('inventory/order/store', 'inventory\OrderController@store');
    Route::get('inventory/order/show/{id}', 'inventory\OrderController@show');
    Route::get('inventory/order/edit/{id}', 'inventory\OrderController@edit');
    Route::get('inventory/order/', 'inventory\OrderController@index');
    Route::post('inventory/order/destroy/{id}' , 'inventory\OrderController@destroy');
    Route::post('inventory/order/update/{id}', 'inventory\OrderController@update');

    Route::get('inventory/product/create/{order}', 'inventory\ProductController@create_product');
});

Auth::routes();

#client access
Route::group(['prefix' => 'client', 'middleware' => ['ClientAuthMiddleware']], function () {
Route::get('quote/accept/{qoute_crypt}', array('uses' => 'Invoice\InvoiceController@view_accept_user_quotes'))->name('accept-qoutes');
Route::get('invoice/quote/view/{qoute_crypt}', array('uses' => 'Invoice\InvoiceController@view_user_quotes'))->name('view-client-qoute');

});




Route::post('api/qoute-review/create', 'Invoice\QouteReviewController@create');
Route::post('api/invoice-reciept/create', 'Invoice\InvoiceRecieptController@create');

Route::resource('entries', 'EntriesController');


Route::group(['middleware' => 'auth'], function(){

    Route::get('messages','MessageController@getUsers')->name('messages');
    Route::get('message/{id}','MessageController@getMessage');
    Route::post('message ','MessageController@sendMessage');
    
});