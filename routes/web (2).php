<?php
//
///*
//|--------------------------------------------------------------------------
//| Web Routes
//|--------------------------------------------------------------------------
//|
//| This file is where you may define all of the routes that are handled
//| by your application. Just tell Laravel the URIs it should respond
//| to using a Closure or controller method. Build something great!
//|
//*/
//
// Route::get('/', function () {
//    return view('login');
// });

// Route::get('/dashboard',function()
// {
//    return view('panel.Dashboard');
// });


// /**
// * CorpTax Routes
// */
// Route::group(['prefix' => '/dashboard/corp-tax'], function()
// {
//    Route::get('/index','CorpTax\CorpTaxController@getIndex')->name('corptax-index');

//    Route::get('/WHT/reports/accounts-movement','CorpTax\WHTController@getAccountsMovement')->name('accounts_movement');

//    Route::get('/WIT/view-transactions','CorpTax\WHTController@viewTransactions')->name('viewTransactions');

//    Route::get('/WIT/view-transactions/by-period','CorpTax\WHTController@filterTransactions');

//    Route::get('/WIT/reports/amount-payable','CorpTax\WHTController@getAmountPayableBy');

//    Route::get('/WIT/search-transactions','CorpTax\WHTController@searchTransactions');

//    Route::get('/WIT/print-schedule/{type}/f/{from?}/t/{to?}','CorpTax\WHTController@printRemittanceSchedule');

//    Route::get(' ','CorpTax\WHTController@preparePrintView');

//    Route::get('/overview','CorpTax\CorpTaxController@getDashboard')->name('corptax-overview');

//    Route::get('/WIT/log-transactions','CorpTax\WHTController@getLogTransactions')->name('logTransactions');

//    Route::get('/WIT/download/schedule-template','CorpTax\WHTController@downloadRemittanceScheduleTemplate')->name('WHTScheduleTemplate');

//    Route::post('/WIT/upload/transactions','CorpTax\WHTController@uploadTransactions');

//    Route::post('/WIT/save/transaction','CorpTax\WHTController@saveTransaction');

//    Route::get('/WIT/accountMovement/print','CorpTax\WHTController@printAccountMovement');

//    Route::post('WIT/accountMovement/save','CorpTax\WHTController@saveAccountMovement');


//    //CIT
//    Route::get('/CIT/income_edu_tax','CorpTax\CITController@getIncomeEduTax');
//    Route::get('/CIT/add_asset','CorpTax\CITController@getAddAsset');
//    Route::post('/CIT/add_asset','CorpTax\CITController@postAddAsset');
//    Route::post('/CIT/get_rate','CorpTax\CITController@getRate');

//    Route::get('/CIT/capital_allowance','CorpTax\CITController@getCapitalAllowance');
//    Route::get('/CIT/company_income_tax','CorpTax\CITController@getCompanyIncomeTax');
//    Route::get('/CIT/defer_tax_computation','CorpTax\CITController@getDeferTaxComputation');
//    Route::get('/CIT/effective_tax_rate','CorpTax\CITController@getEffectiveTaxRate');
//    Route::get('/CIT/income_edu_tax','CorpTax\CITController@getIncomeEduTax');

// 	//CIT routes end
//     Route::get('CIT/index','CorpTax\CITController@getIndex');
//     Route::post('CIT/upload_file','CorpTax\CITController@uploadFile');
//     Route::get('CIT/view_file','CorpTax\CITController@viewFile');
//    //CIT new Route


//    //end

// 	//VAT routes

//    Route::get('/monthlyvatreturn','CorpTax\VATController@getMonthlyVatReturn');

//    Route::post('/monthlyvatreturnform','CorpTax\VATController@postMonthlyVatReturn');

//    Route::get('/movementinvatpayable','CorpTax\VATController@getMovementInVatPayable');

//    Route::get('/logTransaction','CorpTax\VATController@getLogTransaction');

//    Route::post('/logSalesTransaction','CorpTax\VATController@postSalesLogTransaction');

//    Route::post('/logPurchaseTransaction','CorpTax\VATController@postPurchaseLogTransaction');

//    Route::post('/postSalesTotalVatOutput','CorpTax\VATController@postSalesTotalVatOutput');

//    Route::post('/postPurchaseTotalVatOutput','CorpTax\VATController@postPurchaseTotalVatOutput');

//    Route::post('/postMovementInVatPayable','CorpTax\VATController@postMovementInVatPayable');

// 	//VAT routes end

// });

// /**
// * CorpPay Routes
// */
// Route::get('/vendor/{id}','CorpPay\CorpPayController@viewVendorBidRequest');
// Route::post('/add_vendor','CorpPay\CorpPayController@addVendor');
// Route::group(['prefix' => '/corp-pay'], function()
// {
//    Route::get('/','CorpPay\CorpPayController@viewDashboard')-> name('corp-pay');
//    Route::get('/create_bid','CorpPay\CorpPayController@viewCreateBid');
//    Route::post('/get_bid','CorpPay\CorpPayController@getBidInfo');
//    Route::post('/add_bid_item','CorpPay\CorpPayController@addBidItem');


//    Route::get('/manage_bid','CorpPay\CorpPayController@getBids');
//    Route::post('/manage_bid/get_items','CorpPay\CorpPayController@getBidItems');
//    Route::get('/update_bid/{id}','CorpPay\CorpPayController@updateBids');
//    Route::post('/delete/bid_item','CorpPay\CorpPayController@deleteBidItem');
//    Route::get('/pending_vendors/{id}','CorpPay\VendorsController@getPendingVendors');
//    Route::post('/add_vendor','CorpPay\VendorsController@addVendor');
//    Route::get('/add_new_vendor','CorpPay\VendorsController@getNewVendor');
//    Route::post('/add_new_vendor','CorpPay\VendorsController@addNewVendor');



//    Route::get('/list_vendors/{action}','CorpPay\VendorsController@listVendors');
//    Route::get('/manage_price_quote','CorpPay\VendorsController@managePriceQuote');
//    Route::post('/update_status','CorpPay\VendorsController@priceQuoteStatus');
//    Route::get('/view_doc','CorpPay\VendorsController@viewDoc');




// //Email routes for CorpPay
//   // Route::post('/send','EmailController@sendMail');

//    Route::get('/email','EmailController@seeMail');
//    Route::post('/send_mail','CorpPay\VendorsController@sendMail');
//    Route::get('/set_email','EmailController@getEmailSettings');
//    Route::post('/set_email','EmailController@addEmailSettings');

// });

// /**
// * CorpHRM Routes
// */

// Route::group(['prefix' => '/corp-hrm'], function()
// {
//    //get routes for recruitment
//    Route::get('/','CorpHRM\CorpHRMController@getDashboard');
//    Route::get('/rec_process','CorpHRM\CorpHRMController@getRecruitmentProcess');
//    Route::get('/job_profile','CorpHRM\CorpHRMController@getJobProfile');
//    Route::get('/rec_application','CorpHRM\CorpHRMController@getRecruitmentApplication');
//    Route::get('/rec_posting','CorpHRM\CorpHRMController@getRecruitmentPosting');


//    //post route for recruitment
//    Route::post('/rec_process','CorpHRM\CorpHRMController@addRecruitmentProcess');
//    Route::post('/job_profile','CorpHRM\CorpHRMController@addJobProfile');

//    //get route for claims
//     Route::get('/claim_master','CorpHRM\ClaimController@getClaimMaster');
//     Route::get('/claim_application','CorpHRM\ClaimController@getClaimApplication');

//     //post route for claims
//     Route::post('/claim_master','CorpHRM\ClaimController@addClaimMaster');
//     Route::post('/claim_application/{id}','CorpHRM\ClaimController@addClaimApplication');

// 	 //loan routes
//    Route::get('/loanmaster','CorpHRM\LoanController@getLoanMaster');
//    Route::get('/loanapp','CorpHRM\LoanController@getLoanApplication');
//    Route::get('/loandisbursement','CorpHRM\LoanController@getLoanDisbursement');
//    Route::get('/loanpayment','CorpHRM\LoanController@getLoanPayment');
//    Route::get('/trainingmaster','CorpHRM\TrainingController@getTrainingMaster');
//    Route::get('/trainingfacilitator','CorpHRM\TrainingController@getTrainingFacilitator');
//    Route::get('/trainingplan','CorpHRM\TrainingController@getTrainingPlan');
//    Route::post('/loanmasterform','CorpHRM\LoanController@postLoanMaster');
//    Route::post('/loanappform','CorpHRM\LoanController@postLoanApplication');
//    Route::post('/loandisbursementform','CorpHRM\LoanController@postLoanDisbursement');
//    Route::post('/loanpaymentform','CorpHRM\LoanController@postLoanPayment');
//    Route::post('/trainingmasterform','CorpHRM\TrainingController@postTrainingMaster');
//    Route::post('/trainingfacilitatorform','CorpHRM\TrainingController@postTrainingFacilitator');

// 	//loan routes end
// });

// //external route for corp-hrm Job Application
// Route::get('/job_application','CorpHRM\CorpHRMController@getJobApplication');

// /* ------Routes for CorpHrm -----*/

// Route::group(['prefix' => '/corpHrm'], function()
// {
//    Route::get('/dashboard',function(){
//        return view('CorpHRM.dashboard');
//    });
//    Route::get('/Employee',function(){
//        return view('CorpHRM.employeepf');
//    });
// //    Route Post for
//    Route::post('/Allowances',[
//    'uses' => 'GeneralController@postAllowances',
//        'as' => 'post_allowance'
//    ]);
//    Route::post('/Health',[
//        'uses' => 'GeneralController@postHealth',
//        'as' => 'post_health'
//    ]);
//    Route::post('/Branches',[
//        'uses' => 'GeneralController@postBranches',
//        'as' => 'post_branches'
//    ]);

// //    Pension

//    Route::post('/Pension',[
//        'uses' => 'GeneralController@postPension',
//        'as' => 'pension'
//    ]);

//    Route::post('/Holiday',[
//        'uses' => 'GeneralController@postHolidays',
//        'as' => 'holidays'
//    ]);

//    Route::post('/Internal',[
//        'uses' => 'GeneralController@postInternal',
//        'as' => 'internal'
//    ]);

//    Route::post('/Departments',[
//        'uses' => 'GeneralController@postDepartments',
//        'as' => 'post_departments'
//    ]);

//    Route::post('/Currencies',[
//        'uses' => 'GeneralController@postCurrencies',
//        'as' => 'post_currencies'
//    ]);

//    Route::post('/Qualification',[
//        'uses' => 'GeneralController@postQualification',
//        'as' => 'post_qualification'
//    ]);

//    Route::post('/Document',[
//        'uses' => 'GeneralController@postDocument',
//        'as' => 'post_document'
//    ]);

//    Route::post('/Weekoff',[
//        'uses' => 'GeneralController@postWeekoff',
//        'as' => 'post_weekoff'
//    ]);

//    Route::post('/Category',[
//        'uses' => 'GeneralController@postCategory',
//        'as' => 'post_category'
//    ]);

//    Route::post('/Grades',[
//        'uses' => 'GeneralController@postGrades',
//        'as' => 'post_grades'
//    ]);

//    Route::post('/Designation',[
//        'uses' => 'GeneralController@postDesignation',
//        'as' => 'post_designation'
//    ]);

//    Route::post('/Banks',[
//        'uses' => 'GeneralController@postBanks',
//        'as' => 'post_banks'
//    ]);

// //This is the route for Employee
//    Route::post('/PersonalInfo',[
//        'uses' => 'EmployeeController@postPersonal',
//        'as' => 'personal'
//    ]);

// });
