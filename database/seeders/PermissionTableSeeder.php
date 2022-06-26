<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $permissions = [
            /* Base Route Start*/
            /*Sponsor*/
            ['group_name' => 'base', 'name' => 'settings.sponsor.view'],
            ['group_name' => 'base', 'name' => 'settings.sponsor.create'],
            ['group_name' => 'base', 'name' => 'settings.sponsor.edit'],
            ['group_name' => 'base', 'name' => 'settings.sponsor.delete'],

            /*District*/
            ['group_name' => 'base', 'name' => 'settings.district.view'],
            ['group_name' => 'base', 'name' => 'settings.district.create'],
            ['group_name' => 'base', 'name' => 'settings.district.edit'],
            ['group_name' => 'base', 'name' => 'settings.district.delete'],

            /*Upazila*/
            ['group_name' => 'base', 'name' => 'settings.upazila.view'],
            ['group_name' => 'base', 'name' => 'settings.upazila.create'],
            ['group_name' => 'base', 'name' => 'settings.upazila.edit'],
            ['group_name' => 'base', 'name' => 'settings.upazila.delete'],

            /*Union*/
            ['group_name' => 'base', 'name' => 'settings.union.view'],
            ['group_name' => 'base', 'name' => 'settings.union.create'],
            ['group_name' => 'base', 'name' => 'settings.union.edit'],
            ['group_name' => 'base', 'name' => 'settings.union.delete'],

            /*Bank*/
            ['group_name' => 'base', 'name' => 'settings.bank.view'],
            ['group_name' => 'base', 'name' => 'settings.bank.create'],
            ['group_name' => 'base', 'name' => 'settings.bank.edit'],
            ['group_name' => 'base', 'name' => 'settings.bank.delete'],

            /*Disability*/
            ['group_name' => 'base', 'name' => 'settings.disability.view'],
            ['group_name' => 'base', 'name' => 'settings.disability.create'],
            ['group_name' => 'base', 'name' => 'settings.disability.edit'],
            ['group_name' => 'base', 'name' => 'settings.disability.delete'],

            /*Occupation*/
            ['group_name' => 'base', 'name' => 'settings.occupation.view'],
            ['group_name' => 'base', 'name' => 'settings.occupation.create'],
            ['group_name' => 'base', 'name' => 'settings.occupation.edit'],
            ['group_name' => 'base', 'name' => 'settings.occupation.delete'],

            /*Disease*/
            ['group_name' => 'base', 'name' => 'settings.disease.view'],
            ['group_name' => 'base', 'name' => 'settings.disease.create'],
            ['group_name' => 'base', 'name' => 'settings.disease.edit'],
            ['group_name' => 'base', 'name' => 'settings.disease.delete'],

            /*Income*/
            ['group_name' => 'base', 'name' => 'settings.income.view'],
            ['group_name' => 'base', 'name' => 'settings.income.create'],
            ['group_name' => 'base', 'name' => 'settings.income.edit'],
            ['group_name' => 'base', 'name' => 'settings.income.delete'],

            /*Asseet*/
            ['group_name' => 'base', 'name' => 'settings.asset.view'],
            ['group_name' => 'base', 'name' => 'settings.asset.create'],
            ['group_name' => 'base', 'name' => 'settings.asset.edit'],
            ['group_name' => 'base', 'name' => 'settings.asset.delete'],

            /*Disaster*/
            ['group_name' => 'base', 'name' => 'settings.disaster.view'],
            ['group_name' => 'base', 'name' => 'settings.disaster.create'],
            ['group_name' => 'base', 'name' => 'settings.disaster.edit'],
            ['group_name' => 'base', 'name' => 'settings.disaster.delete'],

            /*Recover*/
            ['group_name' => 'base', 'name' => 'settings.recover.view'],
            ['group_name' => 'base', 'name' => 'settings.recover.create'],
            ['group_name' => 'base', 'name' => 'settings.recover.edit'],
            ['group_name' => 'base', 'name' => 'settings.recover.delete'],

            /*Vocational*/
            ['group_name' => 'base', 'name' => 'settings.vocational.view'],
            ['group_name' => 'base', 'name' => 'settings.vocational.create'],
            ['group_name' => 'base', 'name' => 'settings.vocational.edit'],
            ['group_name' => 'base', 'name' => 'settings.vocational.delete'],

            /*Skill*/
            ['group_name' => 'base', 'name' => 'settings.skill.view'],
            ['group_name' => 'base', 'name' => 'settings.skill.create'],
            ['group_name' => 'base', 'name' => 'settings.skill.edit'],
            ['group_name' => 'base', 'name' => 'settings.skill.delete'],

            /* Access Control List (ACL) Start */
            //User
            ['group_name' => 'base', 'name' => 'acl.user.view'],
            ['group_name' => 'base', 'name' => 'acl.user.create'],
            ['group_name' => 'base', 'name' => 'acl.user.edit'],
            ['group_name' => 'base', 'name' => 'acl.user.delete'],
            //User Role
            ['group_name' => 'base', 'name' => 'acl.user_role.view'],
            ['group_name' => 'base', 'name' => 'acl.user_role.create'],
            ['group_name' => 'base', 'name' => 'acl.user_role.edit'],
            ['group_name' => 'base', 'name' => 'acl.user_role.delete'],
            //User Role Assign
            ['group_name' => 'base', 'name' => 'acl.user_role_assign.view'],
            ['group_name' => 'base', 'name' => 'acl.user_role_assign.create'],
            ['group_name' => 'base', 'name' => 'acl.user_role_assign.edit'],
            ['group_name' => 'base', 'name' => 'acl.user_role_assign.delete'],
            /* Access Control List (ACL) End */

            /* Base Route End */

            /* Jeebika Route Start*/
            /*Family Validation*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.family_validation.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.family_validation.create'],

            /*Project*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.project.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.project.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.project.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.project.delete'],

            /* GRO */
            ['group_name' => 'jeebika', 'name' => 'jeebika.gro.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.gro.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.gro.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.gro.delete'],

            /*Jeebika Start*/
            /*Health Session*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.health_session.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.health_session.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.health_session.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.health_session.delete'],
            /*Health Session Participant*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.health_session_participant.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.health_session_participant.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.health_session_participant.delete'],
            /*Health Session Implementation*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.health_session_implementation.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.health_session_implementation.update'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.health_session_implementation.delete'],
            /*Health Session Feedback*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.health_session_feedback.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.health_session_feedback.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.health_session_feedback.delete'],

            /*Training*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.training.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.training.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.training.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.training.delete'],
            /*Training Participant*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.training_participant.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.training_participant.delete'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.training_participant.create'],
            /*Training Implementation*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.training_implementation.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.training_implementation.update'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.training_implementation.delete'],
            /*Training Feedback*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.training_feedback.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.training_feedback.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.training_feedback.delete'],


            /*Project Implementation Create*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.implementation_create.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.implementation_create.create'],
            /*Project Implementation Feedback*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.implementation_feedback.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.implementation_feedback.edit'],
            /*Project Fund Transfer*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.fund_transfer.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.fund_transfer.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.fund_transfer.edit_one'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.fund_transfer.delete'],


            /* Mustahiq Family Create */
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_create.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_create.create'],

            /* Mustahiq Family Edit */
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_edit.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_edit.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_edit.update'],
            /* Family Info */
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_info_edit.update'],
            /* Family Asset */
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_asset_edit.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_asset_edit.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_asset_edit.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_asset_edit.delete'],
            /* Family Loan */
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_loan_edit.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_loan_edit.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_loan_edit.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_loan_edit.delete'],
            /* Family Saving */
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_saving_edit.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_saving_edit.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_saving_edit.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_saving_edit.delete'],
            /* Family Expense */
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_expense_edit.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_expense_edit.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_expense_edit.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_expense_edit.delete'],
            /* Family Income */
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_income_edit.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_income_edit.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_income_edit.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_income_edit.delete'],
            /* Family Other Ngo */
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_ngo_edit.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_ngo_edit.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_ngo_edit.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_ngo_edit.delete'],
            /* Family Disaster */
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_disaster_edit.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_disaster_edit.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_disaster_edit.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_disaster_edit.delete'],
            /* Family Safety */
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_safety_edit.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_safety_edit.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_safety_edit.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_safety_edit.delete'],
            /* Family Help From Neighbour */
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_neighbour_edit.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_neighbour_edit.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_neighbour_edit.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_neighbour_edit.delete'],
            /* Family Help From Rich */
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_rich_edit.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_rich_edit.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_rich_edit.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_rich_edit.delete'],
            /* Family Conflict Resolver */
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_conflict_edit.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_conflict_edit.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_conflict_edit.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_family_conflict_edit.delete'],


            /* View Mustahiqs */
            ['group_name' => 'jeebika', 'name' => 'jeebika.mustahiq_view.view'],


            /* Business plan Approve */
            ['group_name' => 'jeebika', 'name' => 'jeebika.business_plan_approve.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.business_plan_approve.create'],
            /*  Feedback Verification */
            ['group_name' => 'jeebika', 'name' => 'jeebika.feedback_verification.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.feedback_verification.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.feedback_verification.edit'],
            /*  Feedback Visit */
            ['group_name' => 'jeebika', 'name' => 'jeebika.feedback_visit.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.feedback_visit.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.feedback_visit.edit'],
            /*  Feedback Final */
            ['group_name' => 'jeebika', 'name' => 'jeebika.feedback_final.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.feedback_final.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.feedback_final.edit'],


            /*Family*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.family.view'],

            /* Single Business plan */
            ['group_name' => 'jeebika', 'name' => 'jeebika.business_plan.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.business_plan.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.business_plan.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.business_plan.delete'],
            /* Joint Business plan */
            ['group_name' => 'jeebika', 'name' => 'jeebika.business_plan_joint.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.business_plan_joint.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.business_plan_joint.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.business_plan_joint.delete'],
            /* Savings */
            ['group_name' => 'jeebika', 'name' => 'jeebika.savings.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.savings.create'],
            /* Savings Approve*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.savings_approve.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.savings_approve.edit'],
            /* Equity */
            ['group_name' => 'jeebika', 'name' => 'jeebika.equity.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.equity.create'],
            /* Equity Approve*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.equity_approve.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.equity_approve.edit'],

            /* Bank Charges */
            ['group_name' => 'jeebika', 'name' => 'jeebika.bank_charge.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.bank_charge.edit'],

            /* Bank Charges Approve*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.bank_charge_approve.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.bank_charge_approve.edit'],

            /* Miscellaneous */
            ['group_name' => 'jeebika', 'name' => 'jeebika.miscellaneous.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.miscellaneous.create'],

            /* Miscellaneous Approve */
            ['group_name' => 'jeebika', 'name' => 'jeebika.miscellaneous_approve.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.miscellaneous_approve.edit'],

            /* Withdrawal */
            ['group_name' => 'jeebika', 'name' => 'jeebika.withdrawal.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.withdrawal.create'],

            /* Withdrawal Approve */
            ['group_name' => 'jeebika', 'name' => 'jeebika.withdrawal_approve.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.withdrawal_approve.edit'],

            /* Settlement */
            ['group_name' => 'jeebika', 'name' => 'jeebika.settlement.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.settlement.create'],

            /* Settlement Approve */
            ['group_name' => 'jeebika', 'name' => 'jeebika.settlement_approve.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.settlement_approve.edit'],

            /* Investment */
            ['group_name' => 'jeebika', 'name' => 'jeebika.investment.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.investment.create'],
            /* Investment Approve*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.investment_approve.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.investment_approve.edit'],
            /* Investment Return */
            ['group_name' => 'jeebika', 'name' => 'jeebika.investment_return.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.investment_return.create'],

            /* Investment Return Approve*/
            ['group_name' => 'jeebika', 'name' => 'jeebika.investment_return_approve.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.investment_return_approve.edit'],

            /* Need */
            ['group_name' => 'jeebika', 'name' => 'jeebika.need.view'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.need.create'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.need.edit'],
            ['group_name' => 'jeebika', 'name' => 'jeebika.need.delete'],
            /*Jeebika end*/

            /* Indicator */
            ['group_name' => 'jeebika', 'name' => 'settings.indicator.view'],
            ['group_name' => 'jeebika', 'name' => 'settings.indicator.create'],
            ['group_name' => 'jeebika', 'name' => 'settings.indicator.edit'],
            ['group_name' => 'jeebika', 'name' => 'settings.indicator.delete'],

            /* Zone */
            ['group_name' => 'jeebika', 'name' => 'settings.zone.view'],
            ['group_name' => 'jeebika', 'name' => 'settings.zone.create'],
            ['group_name' => 'jeebika', 'name' => 'settings.zone.edit'],
            ['group_name' => 'jeebika', 'name' => 'settings.zone.delete'],

            /* Area */
            ['group_name' => 'jeebika', 'name' => 'settings.area.view'],
            ['group_name' => 'jeebika', 'name' => 'settings.area.create'],
            ['group_name' => 'jeebika', 'name' => 'settings.area.edit'],
            ['group_name' => 'jeebika', 'name' => 'settings.area.delete'],

            /*Investment Area*/
            ['group_name' => 'jeebika', 'name' => 'settings.investment_area.view'],
            ['group_name' => 'jeebika', 'name' => 'settings.investment_area.create'],
            ['group_name' => 'jeebika', 'name' => 'settings.investment_area.edit'],
            ['group_name' => 'jeebika', 'name' => 'settings.investment_area.delete'],

            /* Report */
            ['group_name' => 'jeebika', 'name' => 'reports.investment_area.view'],
            ['group_name' => 'jeebika', 'name' => 'reports.investment_area.create'],
        ];
        $data = [];
        $maxCount = count($permissions);
        for ($i = 0; $i < $maxCount; $i++) {
            $data[] = [
                'group_name' => $permissions[$i]['group_name'],
                'name' => $permissions[$i]['name'],
                'guard_name' => 'web',
                'created_at' => now(),
            ];
        }
        $chunks = array_chunk($data, $maxCount);
        foreach ($chunks as $chunk) {
            Permission::insert($chunk);
        }
    }
}
