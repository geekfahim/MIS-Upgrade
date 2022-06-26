<?php

namespace App\Models\Validators;

use App\Enums\FamilyConflictResolveType;
use App\Enums\FamilyCookingFuelType;
use App\Enums\FamilyDisasterLevel;
use App\Enums\FamilyDrinkingWaterSource;
use App\Enums\FamilyElectricityConnectivityType;
use App\Enums\FamilyExpenseType;
use App\Enums\FamilyHeadedByType;
use App\Enums\FamilyHouseLandType;
use App\Enums\FamilyHouseLocation;
use App\Enums\FamilyHouseType;
use App\Enums\FamilyLoanPurposeType;
use App\Enums\FamilyLoanSourceType;
use App\Enums\FamilyNeighbourHelpType;
use App\Enums\FamilyOtherNGOHelpType;
use App\Enums\FamilyOtherWaterSource;
use App\Enums\FamilyRelationType;
use App\Enums\FamilyRichHelpType;
use App\Enums\FamilySafetyAbuserRelationType;
use App\Enums\FamilySafetyAbuseType;
use App\Enums\FamilySavingType;
use App\Enums\FamilyToiletOwnershipType;
use App\Enums\FamilyToiletType;
use App\Enums\MustahiqBloodGroup;
use App\Enums\MustahiqEducationLevel;
use App\Enums\MustahiqGender;
use App\Enums\MustahiqLivingStatus;
use App\Enums\MustahiqMaritalStatus;
use App\Enums\MustahiqOrphanType;
use App\Enums\MustahiqPregnancyStatus;
use App\Enums\MustahiqRelationalLivingStatus;
use App\Enums\MustahiqReligion;
use App\Enums\MustahiqStatus;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Base\Settings\Asset;
use App\Models\Base\Settings\Disability;
use App\Models\Base\Settings\Disaster;
use App\Models\Base\Settings\Disease;
use App\Models\Base\Settings\District;
use App\Models\Base\Settings\Income;
use App\Models\Base\Settings\Occupation;
use App\Models\Base\Settings\Recover;
use App\Models\Base\Settings\Skill;
use App\Models\Base\Settings\Union;
use App\Models\Base\Settings\Upazila;
use App\Models\Base\Settings\Vocational;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Project\JProjectSponsor;
use App\Rules\Mobile;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class MustahiqFamilyCreateValidator
{

    /**
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(array $attributes): array
    {
        $rules = array_merge($this->mustahiqRules(), $this->familyRules(), [
            /* Common & Others */
            "j_project_id" => ['nullable', Rule::exists(JProject::getTableName(), 'id')],
            "j_gro_id"     => ['nullable', Rule::exists(JGro::getTableName(), 'id')],
            "j_sponsor_id" => ['nullable', Rule::exists(JProjectSponsor::getTableName(), 'id')],
            'created_by'   => ['required'],
        ]);
        $messages = [
            'mustahiqs.*'                                  => 'Minimum one mustahiq is required, add at least one mustahiq.',
            'mustahiqs.*.is_earn_ability.bool'             => 'One of mustahiq selected earn ability is invalid.',
            'mustahiqs.*.is_birth_date.bool'               => 'One of mustahiq selected birth date or age option is invalid.',
            'mustahiqs.*.is_orphan.bool'                   => 'One of mustahiq selected orphan option is invalid.',
            'mustahiqs.*.is_disease.bool'                  => 'One of mustahiq selected disease option is invalid.',
            'mustahiqs.*.is_disease_regular_medicine.bool' => 'One of mustahiq selected disease regular medicine option is invalid.',
            'mustahiqs.*.is_disability.bool'               => 'One of mustahiq selected disability option is invalid.',
            'mustahiqs.*.is_permanent_as_present.bool'     => 'One of mustahiq selected address permanent as present option is invalid.',
            'mustahiqs.*.picture.max'                      => 'One of mustahiq picture size may not be greater than :max kilobytes.',
            'mustahiqs.*.picture.mimes'                    => 'One of mustahiq picture must be a file of type: :values'
        ];
        return validator($attributes, $rules, $messages)->validate();
    }

    private function mustahiqRules(): array
    {
        return [
            /* Mustahiqs */
            'mustahiqs'                               => ['required', 'array'],
            //required
            'mustahiqs.*.name'                        => ['required', new Name(), 'min:2', 'max:50'],
            'mustahiqs.*.gender'                      => ['required', new Enum(MustahiqGender::class)],
            'mustahiqs.*.religion'                    => ['required', new Enum(MustahiqReligion::class)],
            'mustahiqs.*.relation_with_family_head'   => ['required', new Enum(FamilyRelationType::class)],
            'mustahiqs.*.is_earn_ability'             => ['required', 'bool'],
            'mustahiqs.*.is_birth_date'               => ['required', 'bool'],
            'mustahiqs.*.is_orphan'                   => ['required', 'bool'],
            'mustahiqs.*.is_disease'                  => ['required', 'bool'],
            'mustahiqs.*.is_disease_regular_medicine' => ['required', 'bool'],
            'mustahiqs.*.is_disability'               => ['required', 'bool'],
            "mustahiqs.*.is_permanent_as_present"     => ['required', 'bool'],
            //nullable
            'mustahiqs.*.picture'                     => ['nullable', 'mimes:jpeg,jpg,png', 'max:500'], // 500kb jpeg,jpg,png
            'mustahiqs.*.is_picture_delete'           => ['nullable', 'bool'],
            'mustahiqs.*.birth_date'                  => ['nullable', Rule::when('mustahiqs.*.is_birth_date' == 1, ['required', 'date', 'max:10'])],
            'mustahiqs.*.age'                         => ['nullable', Rule::when('mustahiqs.*.is_birth_date' == 1, ['required', 'numeric', 'max:150'])],
            'mustahiqs.*.mobile'                      => ['nullable', 'numeric', new Mobile()],
            'mustahiqs.*.alternate_mobile'            => ['nullable', 'numeric', new Mobile()],
            'mustahiqs.*.emergency_mobile'            => ['nullable', 'numeric', new Mobile()],
            'mustahiqs.*.marital_status'              => ['nullable', new Enum(MustahiqMaritalStatus::class)],
            'mustahiqs.*.spouse_name'                 => ['nullable', new Name(), 'max:31'],
            'mustahiqs.*.spouse_living_status'        => ['nullable', new Enum(MustahiqRelationalLivingStatus::class)],
            'mustahiqs.*.spouse_mobile'               => ['nullable', 'numeric', new Mobile()],
            'mustahiqs.*.highest_education_level'     => ['nullable', new Enum(MustahiqEducationLevel::class)],
            'mustahiqs.*.pregnancy_status'            => ['nullable', new Enum(MustahiqPregnancyStatus::class)],
            'mustahiqs.*.orphan_type'                 => ['nullable', new Enum(MustahiqOrphanType::class)],
            'mustahiqs.*.blood_group'                 => ['nullable', new Enum(MustahiqBloodGroup::class)],
            'mustahiqs.*.email'                       => ['nullable', 'email', 'max:190'],
            "mustahiqs.*.nid"                         => ['nullable', 'alpha_num', 'min:5', 'max:20'],
            "mustahiqs.*.passport"                    => ['nullable', 'alpha_num', 'min:5 ', 'max:20'],
            "mustahiqs.*.birth_certificate"           => ['nullable', 'alpha_num', 'min:5 ', 'max:20'],
            'mustahiqs.*.reference_number'            => ['nullable', 'alpha_num', 'max:51'],
            'mustahiqs.*.father_name'                 => ['nullable', new Name(), 'max:31'],
            'mustahiqs.*.father_living_status'        => ['nullable', new Enum(MustahiqRelationalLivingStatus::class)],
            'mustahiqs.*.father_mobile'               => ['nullable', 'numeric', new Mobile()],
            'mustahiqs.*.mother_name'                 => ['nullable', new Name(), 'max:31'],
            'mustahiqs.*.mother_living_status'        => ['nullable', new Enum(MustahiqRelationalLivingStatus::class)],
            'mustahiqs.*.mother_mobile'               => ['nullable', 'numeric', new Mobile()],
            'mustahiqs.*.occupation_id'               => ['nullable', Rule::exists(Occupation::getTableName(), 'id')],
            'mustahiqs.*.monthly_income'              => ['nullable', 'numeric', 'digits_between:0,10', 'max:2000000001'],
            'mustahiqs.*.disease_id'                  => ['nullable', Rule::when('mustahiqs.*.is_disease' == 1, ['required', Rule::exists(Disease::getTableName(), 'id')])],
            'mustahiqs.*.disability_id'               => ['nullable', Rule::when('mustahiqs.*.is_disease' == 1, ['required', Rule::exists(Disability::getTableName(), 'id')])],
            'mustahiqs.*.remarks'                     => ['nullable', 'min:2', 'max:999'],
            "mustahiqs.*.permanent_address"           => ['nullable', 'string', 'max:999'],
            "mustahiqs.*.permanent_district_id"       => ['nullable', Rule::exists(District::getTableName(), 'id')],
            "mustahiqs.*.permanent_upazila_id"        => ['nullable', Rule::exists(Upazila::getTableName(), 'id')],
            "mustahiqs.*.permanent_union_id"          => ['nullable', Rule::exists(Union::getTableName(), 'id')],
            "mustahiqs.*.permanent_post_code"         => ['nullable', 'numeric', 'digits_between:0,10'],
            "mustahiqs.*.present_address"             => ['nullable', 'string', 'max:999'],
            "mustahiqs.*.present_district_id"         => ['nullable', Rule::exists(District::getTableName(), 'id')],
            "mustahiqs.*.present_upazila_id"          => ['nullable', Rule::exists(Upazila::getTableName(), 'id')],
            "mustahiqs.*.present_union_id"            => ['nullable', Rule::exists(Union::getTableName(), 'id')],
            "mustahiqs.*.present_post_code"           => ['nullable', 'numeric', 'digits_between:0,10'],
            "mustahiqs.vocational_haves"              => ['nullable', 'array'],
            "mustahiqs.vocational_needs"              => ['nullable', 'array'],
            "mustahiqs.*.vocational_haves.*"          => ['nullable', Rule::exists(Vocational::getTableName(), 'id')],
            "mustahiqs.*.vocational_needs.*"          => ['nullable', Rule::exists(Vocational::getTableName(), 'id')],
            "mustahiqs.skill_haves"                   => ['nullable', 'array'],
            "mustahiqs.skill_needs"                   => ['nullable', 'array'],
            "mustahiqs.*.skill_haves.*"               => ['nullable', Rule::exists(Skill::getTableName(), 'id')],
            "mustahiqs.*.skill_needs.*"               => ['nullable', Rule::exists(Skill::getTableName(), 'id')],
        ];
    }

    private function familyRules(): array
    {
        return [
            /* Family Info */
            'family_headed_by'                               => ['nullable', new Enum(FamilyHeadedByType::class)],
            'house_land_type'                                => ['nullable', new Enum(FamilyHouseLandType::class)],
            'house_type'                                     => ['nullable', new Enum(FamilyHouseType::class)],
            'house_location'                                 => ['nullable', new Enum(FamilyHouseLocation::class)],
            'drinking_water'                                 => ['nullable', new Enum(FamilyDrinkingWaterSource::class)],
            'other_water'                                    => ['nullable', new Enum(FamilyOtherWaterSource::class)],
            'toilet_owner'                                   => ['nullable', new Enum(FamilyToiletOwnershipType::class)],
            'toilet_type'                                    => ['nullable', new Enum(FamilyToiletType::class)],
            'cooking_fuel'                                   => ['nullable', new Enum(FamilyCookingFuelType::class)],
            'electricity_connectivity'                       => ['nullable', new Enum(FamilyElectricityConnectivityType::class)],
            'total_room'                                     => ['nullable', 'numeric', 'max:20'],
            'family_reference_number'                        => ['nullable', new Name(), 'max:20'],

            /* Family Assets */
            'familyAssets.*.asset_id'                        => ['required', Rule::exists(Asset::getTableName(), 'id')],
            'familyAssets.*.asset_quantity'                  => ['nullable', new Name(), 'max:151'],
            'familyAssets.*.asset_location'                  => ['nullable', 'string', 'max:31'],
            'familyAssets.*.asset_value'                     => ['required', 'numeric', 'digits_between:1,8'],

            /* Family Loans */
            'familyLoans.*.loan_taking_date'                 => ['required', 'date', 'max:10'],
            'familyLoans.*.loan_source'                      => ['required', new Enum(FamilyLoanSourceType::class)],
            'familyLoans.*.loan_source_name'                 => ['required', new Name(), 'max:30'],
            'familyLoans.*.loan_amount'                      => ['required', 'numeric', 'digits_between:1,8'],
            'familyLoans.*.loan_duration'                    => ['required', new Name(), 'digits_between:1,8'],
            'familyLoans.*.loan_purpose'                     => ['required', new Enum(FamilyLoanPurposeType::class)],
            'familyLoans.*.loan_outstanding_amount'          => ['required', 'numeric', 'digits_between:1,8'],
            'familyLoans.*.loan_rate_or_extra_amount'        => ['nullable', 'numeric', 'digits_between:1,8'],
            'familyLoans.*.loan_remarks'                     => ['nullable', new Name(), 'max:998'],

            /* Family Incomes */
            'familyIncomes.*.income_source_id'               => ['required', Rule::exists(Income::getTableName(), 'id')],
            'familyIncomes.*.income_amount'                  => ['required', 'numeric', 'digits_between:0,8'],
            'familyIncomes.*.income_remarks'                 => ['nullable', new Name(), 'max:998'],

            /* Family Expenses */
            'familyExpenses.*.expense_type'                  => ['required', new Enum(FamilyExpenseType::class)],
            'familyExpenses.*.expense_amount'                => ['required', 'numeric', 'digits_between:0,8'],
            'familyExpenses.*.expense_remarks'               => ['nullable', new Name(), 'max:998'],

            /* Family Savings */
            'familySavings.*.savings_type'                   => ['required', new Enum(FamilySavingType::class)],
            'familySavings.*.savings_amount'                 => ['required', 'numeric', 'digits_between:0,8'],
            'familySavings.*.savings_remarks'                => ['nullable', new Name(), 'max:998'],

            /* Family OtherNgos */
            'familyOtherNgos.*.ngo_name'                     => ['required', new Name(), 'max:191'],
            'familyOtherNgos.*.ngo_help_type'                => ['required', new Enum(FamilyOtherNGOHelpType::class)],
            'familyOtherNgos.*.ngo_remarks'                  => ['nullable', new Name(), 'max:998'],

            /* Family Safeties */
            'familySafeties.*.safety_victim_name'            => ['required', new Name(), 'max:191'],
            'familySafeties.*.safety_relation_with_abuser'   => ['required', new Enum(FamilySafetyAbuserRelationType::class)],
            'familySafeties.*.safety_type_of_abuse'          => ['required', new Enum(FamilySafetyAbuseType::class)],
            'familySafeties.*.safety_place_of_abuse'         => ['required', new Name(), 'max:191'],
            'familySafeties.*.safety_abuser_name'            => ['required', new Name(), 'max:191'],

            /* Family NeighborHelps */
            'familyNeighborHelps.*.neighbour_help_type'      => ['required', new Enum(FamilyNeighbourHelpType::class)],

            /* Family RichHelps */
            'familyRichHelps.*.rich_help_type'               => ['required', new Enum(FamilyRichHelpType::class)],

            /* Family ConflictResolves */
            'familyConflictResolves.*.conflict_resolve_type' => ['required', new Enum(FamilyConflictResolveType::class)],

            /* Family Disasters */
            'familyDisasters.*.disaster_id'                  => ['required', Rule::exists(Disaster::getTableName(), 'id')],
            'familyDisasters.*.disaster_level'               => ['required', new Enum(FamilyDisasterLevel::class)],
            'familyDisasters.*.disaster_recover_id'          => ['required', Rule::exists(Recover::getTableName(), 'id')],
        ];
    }

    /**
     * @param bool $isCreate
     * @param array $attributes
     * @return array
     */
    public function validateSingleMustahiq(array $attributes, bool $isCreate = true): array
    {
        $rules = [
            'id'         => ['sometimes', 'required', Rule::exists(Mustahiq::getTableName(), 'id')],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ];
        foreach (Arr::except($this->mustahiqRules(), 'mustahiqs') as $key => $value) {
            $rules[str_replace('mustahiqs.*.', '', $key)] = $value;
        }
        $rules = $isCreate ? $rules : Arr::except($rules, 'relation_with_family_head');
        $messages = [
            'picture.max'   => 'One of mustahiq picture size may not be greater than :max kilobytes.',
            'picture.mimes' => 'One of mustahiq picture must be a file of type: :values'
        ];
        return validator($attributes, $rules, $messages)->validate();
    }
}
