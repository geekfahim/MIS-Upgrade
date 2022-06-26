const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

/*
mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', []);
*/
//mix.js('resources/js/dashboard/test-app.js', 'public/assets/js/test-app.js');

//source directory
let sd = "resources/js/dashboard/";
//destination directory
let dd = "public/assets/js/dashboard/";

/*Base*/
let bsd = sd + "base/";
let bdd = dd + "base/";
mix.js(bsd + "acl/user.js", bdd + "acl/user.js").vue();

//All Mustahiq
/*
mix.js(bsd + "all-mustahiq/view-mustahiq.js", bdd + "all-mustahiq/view-mustahiq.js");
mix.js(bsd + "all-mustahiq/report-mustahiq.js", bdd + "all-mustahiq/report-mustahiq.js");
//Settings
mix.js(bsd + "settings/bank.js", bdd + "settings/bank.js");
mix.js(bsd + "settings/district.js", bdd + "settings/district.js");
mix.js(bsd + "settings/upazila.js", bdd + "settings/upazila.js");
mix.js(bsd + "settings/union.js", bdd + "settings/union.js");
mix.js(bsd + "settings/sponsor.js", bdd + "settings/sponsor.js");
mix.js(bsd + "settings/disability.js", bdd + "settings/disability.js");
mix.js(bsd + "settings/occupation.js", bdd + "settings/occupation.js");
mix.js(bsd + "settings/disease.js", bdd + "settings/disease.js");
mix.js(bsd + "settings/asset.js", bdd + "settings/asset.js");
mix.js(bsd + "settings/income.js", bdd + "settings/income.js");
mix.js(bsd + "settings/disaster.js", bdd + "settings/disaster.js");
mix.js(bsd + "settings/recover.js", bdd + "settings/recover.js");
mix.js(bsd + "settings/vocational.js", bdd + "settings/vocational.js");
mix.js(bsd + "settings/skill.js", bdd + "settings/skill.js");

/!*Acl*!/
mix.js(bsd + "acl/user.js", bdd + "acl/user.js");
mix.js(bsd + "acl/user-role.js", bdd + "acl/user-role.js");
mix.js(bsd + "acl/user-role-assign.js", bdd + "acl/user-role-assign.js");
mix.js(bsd + "acl/profile.js", bdd + "acl/profile.js");

/!*Jeebika*!/
let jsd = sd + "jeebika/";
let jdd = dd + "jeebika/";

mix.js(jsd + "family-validation/family-validation.js", jdd + "family-validation.js");
//mustahiq
mix.js(jsd + "mustahiq/family-create/mustahiq-family-create.js", jdd + "mustahiq/family-create/mustahiq-family-create.js");
mix.js(jsd + "mustahiq/family-edit/mustahiq-family-edit.js", jdd + "mustahiq/mustahiq-family-edit.js");
mix.js(jsd + "mustahiq/view-mustahiqs.js", jdd + "mustahiq/view-mustahiqs.js");
//family
mix.js(jsd + "family/family-admin-view.js", jdd + "family/family-admin-view.js");
mix.js(jsd + "family/family-manager-view.js", jdd + "family/family-manager-view.js");
mix.js(jsd + "family/need.js", jdd + "family/need.js");
mix.js(jsd + "family/IGA/business-plan.js", jdd + "family/IGA/business-plan.js");
mix.js(jsd + "family/IGA/business-plan-joint.js", jdd + "family/IGA/business-plan-joint.js");
//gro
mix.js(jsd + "gro/gro-admin-view.js", jdd + "gro/gro-admin-view.js");
mix.js(jsd + "gro/gro-project-manager-view.js", jdd + "gro/gro-project-manager-view.js");
mix.js(jsd + "gro/business-plan/bp-approve-list.js", jdd + "gro/business-plan/bp-approve-list.js");
mix.js(jsd + "gro/business-plan/bp-approve-view.js", jdd + "gro/business-plan/bp-approve-view.js");
mix.js(jsd + "gro/business-plan/feedbacks/final.js", jdd + "gro/business-plan/feedbacks/final.js");
mix.js(jsd + "gro/business-plan/feedbacks/verification.js", jdd + "gro/business-plan/feedbacks/verification.js");
mix.js(jsd + "gro/business-plan/feedbacks/visit.js", jdd + "gro/business-plan/feedbacks/visit.js");
//Savings
mix.js(jsd + "family/IGA/savings.js", jdd + "family/IGA/savings.js");
//Equity
mix.js(jsd + "family/IGA/equity.js", jdd + "family/IGA/equity.js");
//Investment
mix.js(jsd + "family/IGA/investment.js", jdd + "family/IGA/investment.js");
//Investment Return
mix.js(jsd + "family/IGA/investment-return.js", jdd + "family/IGA/investment-return.js");
//Bank-Charge
mix.js(jsd + "family/IGA/bank-charge.js", jdd + "family/IGA/bank-charge.js");
//Miscellaneous
mix.js(jsd + "family/IGA/miscellaneous.js", jdd + "family/IGA/miscellaneous.js");
//Withdrawal
mix.js(jsd + "family/IGA/withdrawal.js", jdd + "family/IGA/withdrawal.js");
//Withdrawal
mix.js(jsd + "family/IGA/settlement.js", jdd + "family/IGA/settlement.js");
//project
mix.js(jsd + "project/project.js", jdd + "project/project.js");
mix.js(jsd + "project/project-manager-view.js", jdd + "project/project-manager-view.js");
mix.js(jsd + "project/implementation-plan-create.js", jdd + "project/implementation-plan-create.js");
mix.js(jsd + "project/implementation-plan-feedback.js", jdd + "project/implementation-plan-feedback.js");
mix.js(jsd + "project/fund-transfer.js", jdd + "project/fund-transfer.js");

//settings
mix.js(jsd + "settings/indicator.js", jdd + "settings/indicator.js");
mix.js(jsd + "settings/zone.js", jdd + "settings/zone.js");
mix.js(jsd + "settings/area.js", jdd + "settings/area.js");
mix.js(jsd + "settings/investment-area.js", jdd + "settings/investment-area.js");

//reports
mix.js(jsd + "reports/family-report.js", jdd + "reports/family-report.js");
mix.js(jsd + "reports/gro-report.js", jdd + "reports/gro-report.js");
mix.js(jsd + "reports/training-report.js", jdd + "reports/training-report.js");
mix.js(jsd + "reports/health-session-report.js", jdd + "reports/health-session-report.js");
mix.js(jsd + "reports/project-report.js", jdd + "reports/project-report.js");
mix.js(jsd + "reports/mustahiq-report.js", jdd + "reports/mustahiq-report.js");
mix.js(jsd + "reports/statistic-report.js", jdd + "reports/statistic-report.js");

//approve
mix.js(jsd + "approve/savings-approve.js", jdd + "approve/savings-approve.js");
mix.js(jsd + "approve/equity-approve.js", jdd + "approve/equity-approve.js");
mix.js(jsd + "approve/investment-approve.js", jdd + "approve/investment-approve.js");
mix.js(jsd + "approve/investment-return-approve.js", jdd + "approve/investment-return-approve.js");
mix.js(jsd + "approve/bank-charge-approve.js", jdd + "approve/bank-charge-approve.js");
mix.js(jsd + "approve/miscellaneous-approve.js", jdd + "approve/miscellaneous-approve.js");
mix.js(jsd + "approve/withdrawal-approve.js", jdd + "approve/withdrawal-approve.js");
mix.js(jsd + "approve/settlement-approve.js", jdd + "approve/settlement-approve.js");

/!* Business Feedback Approve *!/
mix.js(jsd + "approve/verification-approve.js", jdd + "approve/verification-approve.js");
mix.js(jsd + "approve/visit-approve.js", jdd + "approve/visit-approve.js");
mix.js(jsd + "approve/final-approve.js", jdd + "approve/final-approve.js");

/!*Training*!/
mix.js(jsd + "training/training.js", jdd + "training.js");
mix.js(jsd + "training/training-participant.js", jdd + "training-participant.js");
mix.js(jsd + "training/training-implementation.js", jdd + "training-implementation.js");
mix.js(jsd + "training/training-feedback.js", jdd + "training-feedback.js");

/!*Health Session*!/
mix.js(jsd + "health-session/health-session.js", jdd + "health-session.js");
mix.js(jsd + "health-session/health-session-participant.js", jdd + "health-session-participant.js");
mix.js(jsd + "health-session/health-session-feedback.js", jdd + "health-session-feedback.js");
mix.js(jsd + "health-session/health-session-implementation.js", jdd + "health-session-implementation.js");
*/
