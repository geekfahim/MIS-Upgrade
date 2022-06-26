<?php

use App\Http\Controllers\Jeebika\Approve\AccountApproveController;
use App\Http\Controllers\Jeebika\Approve\BPFeedbackApproveController;
use App\Http\Controllers\Jeebika\Family\FamilyAssetController;
use App\Http\Controllers\Jeebika\Family\FamilyConflictResolveController;
use App\Http\Controllers\Jeebika\Family\FamilyController;
use App\Http\Controllers\Jeebika\Family\FamilyDisasterController;
use App\Http\Controllers\Jeebika\Family\FamilyExpenseController;
use App\Http\Controllers\Jeebika\Family\FamilyIncomeController;
use App\Http\Controllers\Jeebika\Family\FamilyLoanController;
use App\Http\Controllers\Jeebika\Family\FamilyNeighbourHelpController;
use App\Http\Controllers\Jeebika\Family\FamilyOtherNgoController;
use App\Http\Controllers\Jeebika\Family\FamilyRichHelpController;
use App\Http\Controllers\Jeebika\Family\FamilySafetyController;
use App\Http\Controllers\Jeebika\Family\FamilySavingController;
use App\Http\Controllers\Jeebika\Family\IGA\BPFeedbackFinalController;
use App\Http\Controllers\Jeebika\Family\IGA\BPFeedbackVerificationController;
use App\Http\Controllers\Jeebika\Family\IGA\BPFeedbackVisitController;
use App\Http\Controllers\Jeebika\Family\IGA\BusinessPlanApproveController;
use App\Http\Controllers\Jeebika\Family\IGA\BusinessPlanController;
use App\Http\Controllers\Jeebika\Family\IGA\BusinessPlanJointController;
use App\Http\Controllers\Jeebika\Family\IGA\JBankChargeController;
use App\Http\Controllers\Jeebika\Family\IGA\JEquityController;
use App\Http\Controllers\Jeebika\Family\IGA\JInvestmentController;
use App\Http\Controllers\Jeebika\Family\IGA\JInvestmentReturnController;
use App\Http\Controllers\Jeebika\Family\IGA\JMiscellaneousController;
use App\Http\Controllers\Jeebika\Family\IGA\JSavingController;
use App\Http\Controllers\Jeebika\Family\IGA\JSettlementController;
use App\Http\Controllers\Jeebika\Family\IGA\JWithdrawalController;
use App\Http\Controllers\Jeebika\FamilyValidation\FamilyValidationController;
use App\Http\Controllers\Jeebika\Gro\JGroController;
use App\Http\Controllers\Jeebika\HealthSession\JHealthSessionController;
use App\Http\Controllers\Jeebika\HealthSession\JHealthSessionFeedbackController;
use App\Http\Controllers\Jeebika\HealthSession\JHealthSessionImplementationController;
use App\Http\Controllers\Jeebika\HealthSession\JHealthSessionParticipantController;
use App\Http\Controllers\Jeebika\JNeedController;
use App\Http\Controllers\Jeebika\Mustahiq\MustahiqFamilyCreateController;
use App\Http\Controllers\Jeebika\Mustahiq\MustahiqFamilyEditController;
use App\Http\Controllers\Jeebika\Mustahiq\MustahiqFamilyInfoController;
use App\Http\Controllers\Jeebika\Mustahiq\MustahiqViewController;
use App\Http\Controllers\Jeebika\Project\FundTransferController;
use App\Http\Controllers\Jeebika\Project\ImplementationPlanCreateController as IPCreateC;
use App\Http\Controllers\Jeebika\Project\ImplementationPlanFeedbackController as IPFeedbackC;
use App\Http\Controllers\Jeebika\Project\JProjectController;
use App\Http\Controllers\Jeebika\Training\JTrainingController;
use App\Http\Controllers\Jeebika\Training\JTrainingFeedbackController;
use App\Http\Controllers\Jeebika\Training\JTrainingImplementationController;
use App\Http\Controllers\Jeebika\Training\JTrainingParticipantController;
use App\Models\Jeebika\HealthSession\JHealthSessionImplementation;
use App\Models\Jeebika\HealthSession\JHealthSessionParticipant;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'jeebika', 'as' => 'jeebika.'], function () {
    /* Health Session */
    Route::prefix('health-session')->group(function () {
        Route::get('/', [JHealthSessionController::class, 'index'])->name('health_session.view');
        Route::post('/', [JHealthSessionController::class, 'create'])->name('health_session.create');
        Route::patch('/{id}', [JHealthSessionController::class, 'getElementById'])->name('health_session.view__one');
        Route::put('/{id}', [JHealthSessionController::class, 'update'])->name('health_session.edit');
        Route::delete('/{id}', [JHealthSessionController::class, 'delete'])->name('health_session.delete');
        Route::post('list', [JHealthSessionController::class, 'getList'])->name('health_session.view__list');
        Route::prefix('{hsid}')->group(function () {
            /* Participants */
            Route::get('view', [JHealthSessionParticipantController::class, 'viewById'])->name('health_session.view__details');
            Route::get('participant', [JHealthSessionParticipantController::class, 'index'])->name('health_session_participant.view');
            Route::post('participant', [JHealthSessionParticipantController::class, 'create'])->name('health_session_participant.create');
            Route::delete('participant/{id}', [JHealthSessionParticipantController::class, 'delete'])->name('health_session_participant.delete');
            Route::post('health-session-participant-list', [JHealthSessionParticipantController::class, 'getList'])->name('health_session_participant.view__participant_list');
            Route::post('health-session-participant-list-all', [JHealthSessionParticipantController::class, 'allParticipantList'])->name('health_session_participant.view__all_participant_list');
            /* Implementation */
            Route::get('implementation', [JHealthSessionImplementationController::class, 'index'])->name('health_session_implementation.view');
            Route::put('implementation', [JHealthSessionImplementationController::class, 'update'])->name('health_session_implementation.update');
            Route::delete('implementation/{id}', [JHealthSessionImplementationController::class, 'delete'])->name('health_session_implementation.delete');
            Route::post('implementation-list', [JHealthSessionImplementationController::class, 'getList'])->name('health_session_implementation.view__list');
            /* Feedback */
            Route::get('feedback', [JHealthSessionFeedbackController::class, 'index'])->name('health_session_feedback.view');
            Route::post('feedback', [JHealthSessionFeedbackController::class, 'create'])->name('health_session_feedback.create');
            Route::post('feedback-list', [JHealthSessionFeedbackController::class, 'getList'])->name('health_session_feedback.view__list');
            Route::post('feedback-participant-list', [JHealthSessionFeedbackController::class, 'allParticipantList'])->name('health_session_feedback.view__all_participant_list');
        });
    });
    /* Training */
    Route::get('training', [JTrainingController::class, 'index'])->name('training.view');
    Route::post('training', [JTrainingController::class, 'create'])->name('training.create');
    Route::patch('training/{id}', [JTrainingController::class, 'getElementById'])->name('training.view__one');
    Route::put('training/{id}', [JTrainingController::class, 'update'])->name('training.edit');
    Route::delete('training/{id}', [JTrainingController::class, 'delete'])->name('training.delete');
    Route::post('training-list', [JTrainingController::class, 'getList'])->name('training.view__list');
    Route::group(['prefix'=>'training/{tid}'],function () {
        /* Participants */
        Route::get('view', [JTrainingParticipantController::class, 'viewById'])->name('training_participant_details');
        Route::get('participant', [JTrainingParticipantController::class, 'index'])->name('training_participant.view');
        Route::post('participant', [JTrainingParticipantController::class, 'create'])->name('training_participant.create');
        Route::delete('participant/{id}', [JTrainingParticipantController::class, 'delete'])->name('training_participant.delete');
        Route::post('training-participant-list', [JTrainingParticipantController::class, 'getList'])->name('training_participant.view__participant_list');
        Route::post('training-participant-list-all', [JTrainingParticipantController::class, 'allParticipantList'])->name('training_participant.view__all_participant_list');
        /* Implementation */
        Route::get('implementation', [JTrainingImplementationController::class, 'index'])->name('training_implementation.view');
        Route::put('implementation', [JTrainingImplementationController::class, 'update'])->name('training_implementation.update');
        Route::delete('implementation/{id}', [JTrainingImplementationController::class, 'delete'])->name('training_implementation.delete');
        Route::post('implementation-list', [JTrainingImplementationController::class, 'getList'])->name('training_implementation.view__list');
        /* Feedback */
        Route::get('feedback', [JTrainingFeedbackController::class, 'index'])->name('training_feedback.view');
        Route::post('feedback', [JTrainingFeedbackController::class, 'create'])->name('training_feedback.create');
        Route::post('feedback-list', [JTrainingFeedbackController::class, 'getList'])->name('training_feedback.view__list');
        Route::post('training-feedback-participant-list', [JTrainingFeedbackController::class, 'allParticipantList'])->name('training_feedback.view__all_participant_list');
    });
    /* Family Validation */
    Route::get('family-validation', [FamilyValidationController::class, 'index'])->name('family_validation.view');
    Route::post('family-validation', [FamilyValidationController::class, 'create'])->name('family_validation.create');
    Route::get('family-validation/{id}/view', [FamilyValidationController::class, 'viewById'])->name('family_validation.view__one');
    Route::post('family-validation-list', [FamilyValidationController::class, 'getList'])->name('family_validation.view__list');
    /* Project */
    Route::get('project', [JProjectController::class, 'index'])->name('project.view');
    Route::post('project', [JProjectController::class, 'create'])->name('project.create');
    Route::patch('project/{id}', [JProjectController::class, 'getElementById'])->name('project.view__one');
    Route::post('project/{id}', [JProjectController::class, 'update'])->name('project.edit');
    Route::delete('project/{id}', [JProjectController::class, 'delete'])->name('project.delete');
    Route::post('project-list', [JProjectController::class, 'getList'])->name('project.view__list');
    Route::get('project/{id}/view', [JProjectController::class, 'viewById'])->name('project.view__details');
    Route::prefix('project/{pid}')->group(function () {
        /* Implementation Plan Create */
        Route::get('ip-create', [IPCreateC::class, 'index'])->name('implementation_create.view');
        Route::post('ip-create-list', [IPCreateC::class, 'getNeedListByIndicatorId'])->name('implementation_create.view__list');
        Route::post('ip-create', [IPCreateC::class, 'create'])->name('implementation_create.create');
        /* Implementation Plan Feedback */
        Route::get('ip-feedback', [IPFeedbackC::class, 'index'])->name('implementation_feedback.view');
        Route::post('ip-feedback-list', [IPFeedbackC::class, 'getList'])->name('implementation_feedback.view__list');
        Route::put('ip-feedback/{id}', [IPFeedbackC::class, 'update'])->name('implementation_feedback.edit');
        /* Project Fund Transfer */
        Route::get('fund-transfer', [FundTransferController::class, 'index'])->name('fund_transfer.view');
        Route::post('fund-transfer-list', [FundTransferController::class, 'getList'])->name('fund_transfer.view__list');
        Route::post('fund-transfer', [FundTransferController::class, 'create'])->name('fund_transfer.create');
        Route::patch('fund-transfer/{id}', [FundTransferController::class, 'getElementById'])->name('fund_transfer.view__one');
        Route::put('fund-transfer/{id}', [FundTransferController::class, 'update'])->name('fund_transfer.edit__one');
        Route::delete('fund-transfer/{id}', [FundTransferController::class, 'delete'])->name('fund_transfer.delete');
        /* Savings Approve */
        Route::get('savings', [AccountApproveController::class, 'indexSavings'])->name('savings_approve.view');
        Route::put('savings/{id}', [AccountApproveController::class, 'editSavings'])->name('savings_approve.edit');
        Route::post('savings', [AccountApproveController::class, 'getSavingsList'])->name('savings_approve.view__list');
        /* Equity Approve*/
        Route::get('equity', [AccountApproveController::class, 'indexEquity'])->name('equity_approve.view');
        Route::put('equity/{id}', [AccountApproveController::class, 'editEquity'])->name('equity_approve.edit');
        Route::post('equity', [AccountApproveController::class, 'getEquityList'])->name('equity_approve.view__list');
        /* Investment Approve*/
        Route::get('investment', [AccountApproveController::class, 'indexInvestment'])->name('investment_approve.view');
        Route::put('investment/{id}', [AccountApproveController::class, 'editInvestment'])->name('investment_approve.edit');
        Route::post('investment', [AccountApproveController::class, 'getInvestmentList'])->name('investment_approve.view__list');
        /* Investment Return Approve*/
        Route::get('investment-return', [AccountApproveController::class, 'indexInvestmentReturn'])->name('investment_return_approve.view');
        Route::put('investment-return/{id}', [AccountApproveController::class, 'editInvestmentReturn'])->name('investment_return_approve.edit');
        Route::post('investment-return', [AccountApproveController::class, 'getInvestmentReturnList'])->name('investment_return_approve.view__list');
        /* Bank Charge Approve*/
        Route::get('bank-charge', [AccountApproveController::class, 'indexBankCharge'])->name('bank_charge_approve.view');
        Route::put('bank-charge/{id}', [AccountApproveController::class, 'editBankCharge'])->name('bank_charge_approve.edit');
        Route::post('bank-charge', [AccountApproveController::class, 'getBankChargeList'])->name('bank_charge_approve.view__list');
        /* Miscellaneous Approve*/
        Route::get('miscellaneous', [AccountApproveController::class, 'indexMiscellaneous'])->name('miscellaneous_approve.view');
        Route::put('miscellaneous/{id}', [AccountApproveController::class, 'editMiscellaneous'])->name('miscellaneous_approve.edit');
        Route::post('miscellaneous', [AccountApproveController::class, 'getMiscellaneousList'])->name('miscellaneous_approve.view__list');
        /* Withdrawal Approve*/
        Route::get('withdrawal', [AccountApproveController::class, 'indexWithdrawal'])->name('withdrawal_approve.view');
        Route::put('withdrawal/{id}', [AccountApproveController::class, 'editWithdrawal'])->name('withdrawal_approve.edit');
        Route::post('withdrawal', [AccountApproveController::class, 'getWithdrawalList'])->name('withdrawal_approve.view__list');
        /* Settlement Approve*/
        Route::get('settlement', [AccountApproveController::class, 'indexSettlement'])->name('settlement_approve.view');
        Route::put('settlement/{id}', [AccountApproveController::class, 'editSettlement'])->name('settlement_approve.edit');
        Route::post('settlement', [AccountApproveController::class, 'getSettlementList'])->name('settlement_approve.view__list');
        /* Verification Approve*/
        Route::get('verification', [BPFeedbackApproveController::class, 'indexVerification'])->name('verification_approve.view');
        Route::patch('verification/{id}', [BPFeedbackApproveController::class, 'getElementById'])->name('verification_approve.view__one');
        Route::put('verification/{id}', [BPFeedbackApproveController::class, 'updateVerification'])->name('verification_approve.update');
        Route::post('verification', [BPFeedbackApproveController::class, 'getVerificationList'])->name('verification_approve.view__list');
        /* Visit Approve*/
        Route::get('visit', [BPFeedbackApproveController::class, 'indexVisit'])->name('visit_approve.view');
        Route::patch('visit/{id}', [BPFeedbackApproveController::class, 'getElementById'])->name('visit_approve.view__one');
        Route::put('visit/{id}', [BPFeedbackApproveController::class, 'updateVisit'])->name('visit_approve.update');
        Route::post('visit', [BPFeedbackApproveController::class, 'getVisitList'])->name('visit_approve.view__list');
        /* Final Approve*/
        Route::get('final', [BPFeedbackApproveController::class, 'indexFinal'])->name('final_approve.view');
        Route::patch('final/{id}', [BPFeedbackApproveController::class, 'getElementById'])->name('final_approve.view__one');
        Route::put('final/{id}', [BPFeedbackApproveController::class, 'updateFinal'])->name('final_approve.update');
        Route::post('final', [BPFeedbackApproveController::class, 'getFinalList'])->name('final_approve.view__list');
    });
    /* Mustahiq Family Create */
    Route::get('mustahiq-family-create', [MustahiqFamilyCreateController::class, 'index'])->name('mustahiq_family_create.view');
    Route::post('mustahiq-family-create', [MustahiqFamilyCreateController::class, 'create'])->name('mustahiq_family_create.create');
    /* Mustahiq Family Edit */
    Route::get('mustahiq-family-edit', [MustahiqFamilyEditController::class, 'index'])->name('mustahiq_family_edit.view');
    Route::post('mustahiq-family-edit/{id}', [MustahiqFamilyEditController::class, 'createAMember'])->name('mustahiq_family_edit.create');
    Route::put('mustahiq-family-edit/{id}', [MustahiqFamilyEditController::class, 'updateAMember'])->name('mustahiq_family_edit.update');
    Route::prefix('mustahiq-family-edit/{fid}')->group(function () {
        /* Family Info */
        Route::put('info', [MustahiqFamilyInfoController::class, 'update'])->name('mustahiq_family_info_edit.update');
         /* Family Asset */
        Route::get('asset', [FamilyAssetController::class, 'getList'])->name('mustahiq_family_asset_edit.view');
        Route::patch('asset/{id}', [FamilyAssetController::class, 'getElementById'])->name('mustahiq_family_asset_edit.view__one');
        Route::post('asset', [FamilyAssetController::class, 'create'])->name('mustahiq_family_asset_edit.create');
        Route::put('asset/{id}', [FamilyAssetController::class, 'update'])->name('mustahiq_family_asset_edit.edit');
        Route::delete('asset/{id}', [FamilyAssetController::class, 'delete'])->name('mustahiq_family_asset_edit.delete');
        /* Family Loan */
        Route::get('loan', [FamilyLoanController::class, 'getList'])->name('mustahiq_family_loan_edit.view');
        Route::patch('loan/{id}', [FamilyLoanController::class, 'getElementById'])->name('mustahiq_family_loan_edit.view__one');
        Route::post('loan', [FamilyLoanController::class, 'create'])->name('mustahiq_family_loan_edit.create');
        Route::put('loan/{id}', [FamilyLoanController::class, 'update'])->name('mustahiq_family_loan_edit.edit');
        Route::delete('loan/{id}', [FamilyLoanController::class, 'delete'])->name('mustahiq_family_loan_edit.delete');
        /* Family Saving */
        Route::get('saving', [FamilySavingController::class, 'getList'])->name('mustahiq_family_saving_edit.view');
        Route::patch('saving/{id}', [FamilySavingController::class, 'getElementById'])->name('mustahiq_family_saving_edit.view__one');
        Route::post('saving', [FamilySavingController::class, 'create'])->name('mustahiq_family_saving_edit.create');
        Route::put('saving/{id}', [FamilySavingController::class, 'update'])->name('mustahiq_family_saving_edit.edit');
        Route::delete('saving/{id}', [FamilySavingController::class, 'delete'])->name('mustahiq_family_saving_edit.delete');
        /* Family Expense */
        Route::get('expense', [FamilyExpenseController::class, 'getList'])->name('mustahiq_family_expense_edit.view');
        Route::patch('expense/{id}', [FamilyExpenseController::class, 'getElementById'])->name('mustahiq_family_expense_edit.view__one');
        Route::post('expense', [FamilyExpenseController::class, 'create'])->name('mustahiq_family_expense_edit.create');
        Route::put('expense/{id}', [FamilyExpenseController::class, 'update'])->name('mustahiq_family_expense_edit.edit');
        Route::delete('expense/{id}', [FamilyExpenseController::class, 'delete'])->name('mustahiq_family_expense_edit.delete');
        /* Family Income */
        Route::get('income', [FamilyIncomeController::class, 'getList'])->name('mustahiq_family_income_edit.view');
        Route::patch('income/{id}', [FamilyIncomeController::class, 'getElementById'])->name('mustahiq_family_income_edit.view__one');
        Route::post('income', [FamilyIncomeController::class, 'create'])->name('mustahiq_family_income_edit.create');
        Route::put('income/{id}', [FamilyIncomeController::class, 'update'])->name('mustahiq_family_income_edit.edit');
        Route::delete('income/{id}', [FamilyIncomeController::class, 'delete'])->name('mustahiq_family_income_edit.delete');
        /* Family Other Ngo */
        Route::get('ngo', [FamilyOtherNgoController::class, 'getList'])->name('mustahiq_family_ngo_edit.view');
        Route::patch('ngo/{id}', [FamilyOtherNgoController::class, 'getElementById'])->name('mustahiq_family_ngo_edit.view__one');
        Route::post('ngo', [FamilyOtherNgoController::class, 'create'])->name('mustahiq_family_ngo_edit.create');
        Route::put('ngo/{id}', [FamilyOtherNgoController::class, 'update'])->name('mustahiq_family_ngo_edit.edit');
        Route::delete('ngo/{id}', [FamilyOtherNgoController::class, 'delete'])->name('mustahiq_family_ngo_edit.delete');
        /* Family Disaster */
        Route::get('disaster', array(FamilyDisasterController::class, 'getList'))->name('mustahiq_family_disaster_edit.view');
        Route::patch('disaster/{id}', [FamilyDisasterController::class, 'getElementById'])->name('mustahiq_family_disaster_edit.view__one');
        Route::post('disaster', [FamilyDisasterController::class, 'create'])->name('mustahiq_family_disaster_edit.create');
        Route::put('disaster/{id}', [FamilyDisasterController::class, 'update'])->name('mustahiq_family_disaster_edit.edit');
        Route::delete('disaster/{id}', [FamilyDisasterController::class, 'delete'])->name('mustahiq_family_disaster_edit.delete');
        /* Family Safety */
        Route::get('safety', array(FamilySafetyController::class, 'getList'))->name('mustahiq_family_safety_edit.view');
        Route::patch('safety/{id}', [FamilySafetyController::class, 'getElementById'])->name('mustahiq_family_safety_edit.view__one');
        Route::post('safety', [FamilySafetyController::class, 'create'])->name('mustahiq_family_safety_edit.create');
        Route::put('safety/{id}', [FamilySafetyController::class, 'update'])->name('mustahiq_family_safety_edit.edit');
        Route::delete('safety/{id}', [FamilySafetyController::class, 'delete'])->name('mustahiq_family_safety_edit.delete');
        /* Family Help From Neighbour */
        Route::get('neighbour', array(FamilyNeighbourHelpController::class, 'getList'))->name('mustahiq_family_neighbour_edit.view');
        Route::patch('neighbour/{id}', [FamilyNeighbourHelpController::class, 'getElementById'])->name('mustahiq_family_neighbour_edit.view__one');
        Route::post('neighbour', [FamilyNeighbourHelpController::class, 'create'])->name('mustahiq_family_neighbour_edit.create');
        Route::put('neighbour/{id}', [FamilyNeighbourHelpController::class, 'update'])->name('mustahiq_family_neighbour_edit.edit');
        Route::delete('neighbour/{id}', [FamilyNeighbourHelpController::class, 'delete'])->name('mustahiq_family_neighbour_edit.delete');
        /* Family Help From Rich */
        Route::get('rich', array(FamilyRichHelpController::class, 'getList'))->name('mustahiq_family_rich_edit.view');
        Route::patch('rich/{id}', [FamilyRichHelpController::class, 'getElementById'])->name('mustahiq_family_rich_edit.view__one');
        Route::post('rich', [FamilyRichHelpController::class, 'create'])->name('mustahiq_family_rich_edit.create');
        Route::put('rich/{id}', [FamilyRichHelpController::class, 'update'])->name('mustahiq_family_rich_edit.edit');
        Route::delete('rich/{id}', [FamilyRichHelpController::class, 'delete'])->name('mustahiq_family_rich_edit.delete');
        /* Family Conflict Resolver */
        Route::get('conflict', array(FamilyConflictResolveController::class, 'getList'))->name('mustahiq_family_conflict_edit.view');
        Route::patch('conflict/{id}', [FamilyConflictResolveController::class, 'getElementById'])->name('mustahiq_family_conflict_edit.view__one');
        Route::post('conflict', [FamilyConflictResolveController::class, 'create'])->name('mustahiq_family_conflict_edit.create');
        Route::put('conflict/{id}', [FamilyConflictResolveController::class, 'update'])->name('mustahiq_family_conflict_edit.edit');
        Route::delete('conflict/{id}', [FamilyConflictResolveController::class, 'delete'])->name('mustahiq_family_conflict_edit.delete');
    });
    /* View Mustahiqs */
    Route::get('mustahiq-view', [MustahiqViewController::class, 'index'])->name('mustahiq_view.view');
    Route::post('mustahiq-view', [MustahiqViewController::class, 'getList'])->name('mustahiq_view.view__list');
    /* GRO */
    Route::get('gro', [JGroController::class, 'index'])->name('gro.view');
    Route::post('gro', [JGroController::class, 'create'])->name('gro.create');
    Route::patch('gro/{id}', [JGroController::class, 'getElementById'])->name('gro.view__one');
    Route::put('gro/{id}', [JGroController::class, 'update'])->name('gro.edit');
    Route::delete('gro/{id}', [JGroController::class, 'delete'])->name('gro.delete');
    Route::post('gro-list', [JGroController::class, 'getList'])->name('gro.view__list');
    Route::get('gro/{id}/view', [JGroController::class, 'viewById'])->name('gro.view__details');
    /*  Business plan Approve */
    Route::prefix('gro/{gid}')->group(function () {
        Route::get('business-plan-approve/', [BusinessPlanApproveController::class, 'index'])->name('business_plan_approve.view');
        Route::post('business-plan-approve/', [BusinessPlanApproveController::class, 'update'])->name('business_plan_approve.edit');
        Route::patch('business-plan-approve/{id}', [BusinessPlanApproveController::class, 'getElementById'])->name('business_plan_approve.view__one');
        Route::post('business-plan-approve-list/', [BusinessPlanApproveController::class, 'getList'])->name('business_plan_approve.view__list');
        Route::get('business-plan-approve/{id}/view', [BusinessPlanApproveController::class, 'viewById'])->name('business_plan_approve.view__details');
        Route::prefix('business-plan-approve/{bpid}/feedback')->group(function () {
            /*  Feedback Verification */
            Route::get('verification', [BPFeedbackVerificationController::class, 'index'])->name('feedback_verification.view');
            Route::post('verification', [BPFeedbackVerificationController::class, 'create'])->name('feedback_verification.create');
            Route::patch('verification/{id}', [BPFeedbackVerificationController::class, 'getElementById'])->name('feedback_verification.view__one');
            Route::put('verification/{id}', [BPFeedbackVerificationController::class, 'update'])->name('feedback_verification.edit');
            Route::post('verification-list', [BPFeedbackVerificationController::class, 'getList'])->name('feedback_verification.view__list');
            /*  Feedback Visit */
            Route::get('visit', [BPFeedbackVisitController::class, 'index'])->name('feedback_visit.view');
            Route::post('visit', [BPFeedbackVisitController::class, 'create'])->name('feedback_visit.create');
            Route::patch('visit/{id}', [BPFeedbackVisitController::class, 'getElementById'])->name('feedback_visit.view__one');
            Route::put('visit/{id}', [BPFeedbackVisitController::class, 'update'])->name('feedback_visit.edit');
            Route::post('visit-list', [BPFeedbackVisitController::class, 'getList'])->name('feedback_visit.view__list');
            /*  Feedback Final */
            Route::get('final', [BPFeedbackFinalController::class, 'index'])->name('feedback_final.view');
            Route::post('final', [BPFeedbackFinalController::class, 'create'])->name('feedback_final.create');
            Route::patch('final/{id}', [BPFeedbackFinalController::class, 'getElementById'])->name('feedback_final.view__one');
            Route::put('final/{id}', [BPFeedbackFinalController::class, 'update'])->name('feedback_final.edit');
            Route::post('final-list', [BPFeedbackFinalController::class, 'getList'])->name('feedback_final.view__list');
        });
    });
    /* Family */
    Route::get('family', [FamilyController::class, 'index'])->name('family.view');
    Route::post('family-list', [FamilyController::class, 'getList'])->name('family.view__list');
    Route::get('family/{id}/view', [FamilyController::class, 'viewById'])->name('family.view__details');
    Route::prefix('family/{fid}')->group(function () {
        /* Single Business plan */
        Route::get('business-plan', [BusinessPlanController::class, 'index'])->name('business_plan.view');
        Route::post('business-plan', [BusinessPlanController::class, 'create'])->name('business_plan.create');
        Route::patch('business-plan/{id}', [BusinessPlanController::class, 'getElementById'])->name('business_plan.view__one');
        Route::put('business-plan/{id}', [BusinessPlanController::class, 'update'])->name('business_plan.edit');
        Route::delete('business-plan/{id}', [BusinessPlanController::class, 'delete'])->name('business_plan.delete');
        Route::post('business-plan-list', [BusinessPlanController::class, 'getList'])->name('business_plan.view__list');
        /* Joint Business plan */
        Route::get('business-plan-joint', [BusinessPlanJointController::class, 'index'])->name('business_plan_joint.view');
        Route::post('business-plan-joint', [BusinessPlanJointController::class, 'create'])->name('business_plan_joint.create');
        Route::patch('business-plan-joint/{id}', [BusinessPlanJointController::class, 'getElementById'])->name('business_plan_joint.view__one');
        Route::put('business-plan-joint/{id}', [BusinessPlanJointController::class, 'update'])->name('business_plan_joint.edit');
        Route::delete('business-plan-joint/{id}', [BusinessPlanJointController::class, 'delete'])->name('business_plan_joint.delete');
        Route::post('business-plan-joint-list', [BusinessPlanJointController::class, 'getList'])->name('business_plan_joint.view__list');
        /* Savings */
        Route::get('savings', [JSavingController::class, 'index'])->name('savings.view');
        Route::post('savings-list', [JSavingController::class, 'getList'])->name('savings.view__list');
        Route::post('savings', [JSavingController::class, 'create'])->name('savings.create');
        Route::patch('savings/{id}', [JSavingController::class, 'getElementById'])->name('savings.view__one');
        Route::put('savings/{id}', [JSavingController::class, 'update'])->name('savings.create__one');
        /* Equity */
        Route::get('equity', [JEquityController::class, 'index'])->name('equity.view');
        Route::post('equity-list', [JEquityController::class, 'getList'])->name('equity.view__list');
        Route::post('equity', [JEquityController::class, 'create'])->name('equity.create');
        Route::patch('equity/{id}', [JEquityController::class, 'getElementById'])->name('equity.view__one');
        Route::put('equity/{id}', [JEquityController::class, 'update'])->name('equity.create__one');
        /* Bank Charges */
        Route::get('bank-charge', [JBankChargeController::class, 'index'])->name('bank_charge.view');
        Route::post('bank-charge-list', [JBankChargeController::class, 'getList'])->name('bank_charge.view__list');
        Route::post('bank-charge', [JBankChargeController::class, 'create'])->name('bank_charge.create');
        Route::patch('bank-charge/{id}', [JBankChargeController::class, 'getElementById'])->name('bank_charge.view__one');
        Route::put('bank-charge/{id}', [JBankChargeController::class, 'update'])->name('bank_charge.create__one');
        /* Miscellaneous */
        Route::get('miscellaneous', [JMiscellaneousController::class, 'index'])->name('miscellaneous.view');
        Route::post('miscellaneous-list', [JMiscellaneousController::class, 'getList'])->name('miscellaneous.view__list');
        Route::post('miscellaneous', [JMiscellaneousController::class, 'create'])->name('miscellaneous.create');
        Route::patch('miscellaneous/{id}', [JMiscellaneousController::class, 'getElementById'])->name('miscellaneous.view__one');
        Route::put('miscellaneous/{id}', [JMiscellaneousController::class, 'update'])->name('miscellaneous.create__one');
        /* Withdrawal */
        Route::get('withdrawal', [JWithdrawalController::class, 'index'])->name('withdrawal.view');
        Route::post('withdrawal-list', [JWithdrawalController::class, 'getList'])->name('withdrawal.view__list');
        Route::post('withdrawal', [JWithdrawalController::class, 'create'])->name('withdrawal.create');
        Route::patch('withdrawal/{id}', [JWithdrawalController::class, 'getElementById'])->name('withdrawal.view__one');
        Route::put('withdrawal/{id}', [JWithdrawalController::class, 'update'])->name('withdrawal.create__one');
        /* Settlement */
        Route::get('settlement', [JSettlementController::class, 'index'])->name('settlement.view');
        Route::post('settlement-list', [JSettlementController::class, 'getList'])->name('settlement.view__list');
        Route::post('settlement', [JSettlementController::class, 'create'])->name('settlement.create');
        Route::patch('settlement/{id}', [JSettlementController::class, 'getElementById'])->name('settlement.view__one');
        Route::put('settlement/{id}', [JSettlementController::class, 'update'])->name('settlement.create__one');
        /* Investment */
        Route::get('investment', [JInvestmentController::class, 'index'])->name('investment.view');
        Route::post('investment-list', [JInvestmentController::class, 'getList'])->name('investment.view__list');
        Route::post('investment', [JInvestmentController::class, 'create'])->name('investment.create');
        Route::patch('investment/{id}', [JInvestmentController::class, 'getElementById'])->name('investment.view__one');
        Route::put('investment/{id}', [JInvestmentController::class, 'update'])->name('investment.create__one');
        /* Investment Return */
        Route::get('investment-return', [JInvestmentReturnController::class, 'index'])->name('investment_return.view');
        Route::post('investment-return-list', [JInvestmentReturnController::class, 'getList'])->name('investment_return.view__list');
        Route::post('investment-return', [JInvestmentReturnController::class, 'create'])->name('investment_return.create');
        Route::patch('investment-return/{id}', [JInvestmentReturnController::class, 'getElementById'])->name('investment_return.view__one');
        Route::put('investment-return/{id}', [JInvestmentReturnController::class, 'update'])->name('investment_return.create__one');
        /* Need */
        Route::get('need', [JNeedController::class, 'index'])->name('need.view');
        Route::post('need-list', [JNeedController::class, 'getList'])->name('need.view__list');
        Route::post('need', [JNeedController::class, 'create'])->name('need.create');
        Route::post('need-single', [JNeedController::class, 'createSingle'])->name('need.create__one');
        Route::put('need/{id}', [JNeedController::class, 'update'])->name('need.edit');
        Route::delete('need/{id}', [JNeedController::class, 'delete'])->name('need.delete');
    });
});
