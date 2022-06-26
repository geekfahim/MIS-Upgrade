<?php

namespace Database\Seeders;

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
use App\Enums\MustahiqMaritalStatus;
use App\Enums\MustahiqOrphanType;
use App\Enums\MustahiqPregnancyStatus;
use App\Enums\MustahiqRelationalLivingStatus;
use App\Enums\MustahiqReligion;
use App\Enums\MustahiqStatus;
use App\Enums\OriginProgram;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyMember;
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
use App\Models\Base\Settings\Sponsor;
use App\Models\Base\Settings\Union;
use App\Models\Base\Settings\Upazila;
use App\Models\Base\Settings\Vocational;
use App\Models\Jeebika\IGA\JFamilyBalance;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\JGro;
use Arr;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Str;

class MustahiqSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return Generator
     */
    protected function withFaker(): Generator
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createFamily(OriginProgram::JEEBIKA->value, 30);
        $this->createFamily(OriginProgram::GENIUS->value, 1);
        $this->createFamily(OriginProgram::INSANIAT->value, 1);
        $this->createFamily(OriginProgram::FERDOUSI->value, 1);
        $this->createFamily(OriginProgram::NAIPUNNABIKASH->value, 1);
        $this->createFamily(OriginProgram::GULBAGICHA->value, 1);
        //Update leader and cashier in GRO
        $this->updateGROs();
    }

    private function createFamily($program, $familyLimit)
    {
        for ($i = 1; $i <= $familyLimit; $i++) {
            $mustahiqs = $this->_createMustahiqs($program);
            $family = $this->_createFamily($mustahiqs);
            $this->_createFamilyOtherTableData($family);

            //Forcefully take service from jeebika project 1 and gro 1
            if (OriginProgram::JEEBIKA->value === $program && $i < 3) {
                Jeebika::create([
                    'j_project_id' => 1,
                    'j_gro_id'     => 1,
                    'family_id'    => $family->id,
                    'created_by'   => 1,
                    'created_at'   => now()
                ]);
                //Create fake balance
                JFamilyBalance::create([
                    'j_project_id' => 1,
                    'j_gro_id'     => 1,
                    'family_id'    => $family->id,
                    'balance'      => rand(1000, 10000),
                ]);
                continue;
            }

            //Jeebika Service Taking
            if (OriginProgram::JEEBIKA->value === $program) {
                $this->_tookServiceFromJeebika($family);
            }
        }
    }

    private function _createMustahiqs($program): array
    {
        $mustahiqs = [];
        $number = $this->faker->numberBetween(1, count(FamilyRelationType::cases()));
        $data = $this->__createMustahiqByNumber($number, $program);
        for ($i = 0; $i < $number; $i++) {
            $mustahiq = Mustahiq::create($data[$i]['main']);
            $mustahiq->details()->create($data[$i]['details']);
            $mustahiqs[] = $mustahiq;
            //Create Vocationals and Skills
            $limit = random_int(2, 4);
            for ($j = 0; $j < $limit; $j++) {
                $mustahiq->vocationals()->create(['vocational_id' => $this->faker->numberBetween(1, Vocational::count()), 'is_have' => $this->faker->boolean]);
                $mustahiq->skills()->create(['skill_id' => $this->faker->numberBetween(1, Skill::count()), 'is_have' => $this->faker->boolean]);
            }
        }
        return $mustahiqs;
    }

    private function __createMustahiqByNumber($limit, $program): array
    {
        $data = [];
        for ($i = 1; $i <= $limit; $i++) {
            $temp = [];
            $gender = Arr::random(MustahiqGender::cases());
            $name = $this->faker->name('Female' == $gender ? 'female' : 'male');
            $isDisability = $this->faker->boolean;
            $isDisease = $this->faker->boolean;
            $isPAP = $this->faker->boolean;
            $presentDistrict = District::find($this->faker->numberBetween(1, District::count()));
            $presentUpazila = Upazila::where('district_id', $presentDistrict->id)->first();
            $presentUnion = Union::where('upazila_id', $presentUpazila->id)->first();
            $presentPostCode = $this->faker->randomNumber(4);
            if (!$isPAP) {
                $permanentDistrict = District::find($this->faker->numberBetween(1, District::count()));
                $permanentUpazila = Upazila::where('district_id', $permanentDistrict->id)->first();
                $permanentUnion = Union::where('upazila_id', $permanentUpazila->id)->first();
            }
            $temp['main'] = [
                'name'                        => $name,
                'gender'                      => $gender,
                'birth_date'                  => $this->faker->date,
                'religion'                    => Arr::random(MustahiqReligion::cases()),
                'blood_group'                 => Arr::random(MustahiqBloodGroup::cases()),
                'email'                       => $this->faker->unique()->safeEmail,
                'nid'                         => $this->faker->shuffle($this->faker->firstName . $this->faker->randomNumber(7)),
                'passport'                    => $this->faker->shuffle($this->faker->firstName . $this->faker->randomNumber(7)),
                'birth_certificate'           => $this->faker->shuffle($this->faker->firstName . $this->faker->randomNumber(7)),
                'is_disability'               => $isDisability,
                'disability_id'               => $isDisability ? $this->faker->numberBetween(1, Disability::count()) : null,
                'is_disease'                  => $isDisease,
                'disease_id'                  => $isDisease ? $this->faker->numberBetween(1, Disease::count()) : null,
                'is_disease_regular_medicine' => $this->faker->boolean,
                'reference_number'            => $this->faker->shuffle($this->faker->firstName . $this->faker->randomNumber(7)),
                'mobile'                      => $this->faker->numerify('17########'),
                'alternate_mobile'            => $this->faker->numerify('18########'),
                'emergency_mobile'            => $this->faker->numerify('19########'),
                'permanent_address'           => $this->faker->address,
                'is_permanent_as_present'     => $isPAP,
                'permanent_district_id'       => $isPAP ? $presentDistrict->id : $permanentDistrict->id,
                'permanent_upazila_id'        => $isPAP ? $presentUpazila->id : $permanentUpazila->id,
                'permanent_union_id'          => $isPAP ? $presentUnion->id : $permanentUnion->id,
                'permanent_post_code'         => $isPAP ? $presentPostCode : $this->faker->randomNumber(4),
                'remarks'                     => $this->faker->sentence,
                'origin_program'              => $program,
                'sponsor_id'                  => $this->faker->numberBetween(1, Sponsor::count()),
                'status'                      => MustahiqStatus::Inactive->value,
                'created_by'                  => 1,
                'created_at'                  => now()
            ];
            $isOrphan = $this->faker->boolean;
            $maritalStatus = Arr::random(MustahiqMaritalStatus::cases());
            $occupation = Occupation::find($this->faker->numberBetween(1, Occupation::count()));
            $temp['details'] = [
                'is_orphan'               => $isOrphan,
                'orphan_type'             => $isOrphan ? Arr::random(MustahiqOrphanType::cases()) : null,
                'pregnancy_status'        => (MustahiqGender::Female == $gender && MustahiqMaritalStatus::Unmarried != $maritalStatus) ? Arr::random(MustahiqPregnancyStatus::cases()) : null,
                'father_name'             => $this->faker->name('male'),
                'father_mobile'           => $this->faker->numerify('13########'),
                'father_living_status'    => Arr::random(MustahiqRelationalLivingStatus::cases()),
                'mother_name'             => $this->faker->name('female'),
                'mother_mobile'           => $this->faker->numerify('14########'),
                'mother_living_status'    => Arr::random(MustahiqRelationalLivingStatus::cases()),
                'marital_status'          => $maritalStatus,
                'spouse_name'             => 'Unmarried' != $maritalStatus ? $this->faker->name : null,
                'spouse_mobile'           => $this->faker->numerify('11########'),
                'spouse_living_status'    => Arr::random(MustahiqRelationalLivingStatus::cases()),
                'highest_education_level' => Arr::random(MustahiqEducationLevel::cases()),
                'is_earn_ability'         => $this->faker->boolean,
                'occupation_id'           => $occupation->id,
                'monthly_income'          => $this->faker->randomNumber(4),
                'present_address'         => $this->faker->address,
                'present_district_id'     => $presentDistrict->id,
                'present_upazila_id'      => $presentUpazila->id,
                'present_union_id'        => $presentUnion->id,
                'present_post_code'       => $presentPostCode,
            ];
            $data[] = $temp;
        }
        return $data;
    }

    private function _createFamily($mustahiqs)
    {
        $mustahiqs = collect($mustahiqs);
        $family = Family::create([
            'name'                     => $mustahiqs->first()->name . "'s family",
            'family_head_id'           => $mustahiqs->first()->id,
            'number_of_family_member'  => $mustahiqs->count(),
            'family_headed_by'         => Arr::random(FamilyHeadedByType::cases()),
            'house_land_type'          => Arr::random(FamilyHouseLandType::cases()),
            'house_type'               => Arr::random(FamilyHouseType::cases()),
            'house_location'           => Arr::random(FamilyHouseLocation::cases()),
            'drinking_water'           => Arr::random(FamilyDrinkingWaterSource::cases()),
            'other_water'              => Arr::random(FamilyOtherWaterSource::cases()),
            'toilet_type'              => Arr::random(FamilyToiletType::cases()),
            'toilet_owner'             => Arr::random(FamilyToiletOwnershipType::cases()),
            'cooking_fuel'             => Arr::random(FamilyCookingFuelType::cases()),
            'electricity_connectivity' => Arr::random(FamilyElectricityConnectivityType::cases()),
            'total_room'               => $this->faker->randomNumber(1),
            'family_reference_number'  => Str::random(),
            'origin_program'           => $mustahiqs->first()->origin_program,
            "created_by"               => 1,
            'created_at'               => now()
        ]);
        $this->__createFamilyMember($family, $mustahiqs);
        return $family;
    }

    private function __createFamilyMember(Family $family, $mustahiqs)
    {
        foreach ($mustahiqs as $key => $mustahiq) {
            FamilyMember::create([
                'family_id'                 => $family->id,
                'mustahiq_id'               => $mustahiq->id,
                'is_family_head'            => 0 === $key,
                'relation_with_family_head' => 0 === $key ? FamilyRelationType::Self->value : \Arr::random(\Arr::except(FamilyRelationType::cases(), 0))->value,
                "created_by"                => 1,
                'created_at'                => now()
            ]);
        }
    }

    private function _createFamilyOtherTableData(Family $family)
    {
        $ac = Asset::count();
        $ic = Income::count();
        $dc = Disaster::count();
        $rc = Recover::count();
        $limit = $this->faker->numberBetween(2, 5);
        for ($i = 1; $i <= $limit; $i++) {
            $data = [
                'created_by' => 1,
                'created_at' => now(),
            ];
            //Assets
            $family->assets()->create(array_merge($data, [
                'asset_id'       => Asset::find(rand(1, $ac))->id,
                'asset_quantity' => rand(1, 2),
                'asset_location' => $this->faker->sentence(5),
                'asset_value'    => $this->faker->randomNumber(4),
                'asset_remarks'  => $this->faker->text(50),
            ]));
            //Expense
            $family->expenses()->create(array_merge($data, [
                'expense_type'    => Arr::random(FamilyExpenseType::cases()),
                'expense_amount'  => $this->faker->randomNumber(4),
                'expense_remarks' => $this->faker->text(50),
            ]));
            //Loans
            $family->loans()->create(array_merge($data, [
                'loan_taking_date'          => $this->faker->date,
                'loan_source'               => Arr::random(FamilyLoanSourceType::cases()),
                'loan_source_name'          => $this->faker->name,
                'loan_amount'               => $this->faker->randomNumber(4),
                'loan_rate_or_extra_amount' => $this->faker->randomNumber(4),
                'loan_duration'             => $this->faker->sentence,
                'loan_purpose'              => Arr::random(FamilyLoanPurposeType::cases()),
                'loan_outstanding_amount'   => $this->faker->randomNumber(4),
                'loan_remarks'              => $this->faker->text(50),
            ]));
            //Incomes
            $family->incomes()->create(array_merge($data, [
                'income_id'      => Income::find(rand(1, $ic))->id,
                'income_amount'  => $this->faker->randomNumber(4),
                'income_remarks' => $this->faker->text(50),
            ]));
            //Safeties
            $family->safeties()->create(array_merge($data, [
                'safety_victim_name'          => $this->faker->name,
                'safety_relation_with_abuser' => Arr::random(FamilySafetyAbuserRelationType::cases()),
                'safety_type_of_abuse'        => Arr::random(FamilySafetyAbuseType::cases()),
                'safety_place_of_abuse'       => $this->faker->text(10),
                'safety_abuser_name'          => $this->faker->name,
            ]));
            //Savings
            $family->savings()->create(array_merge($data, [
                'savings_type'    => Arr::random(FamilySavingType::cases()),
                'savings_amount'  => $this->faker->randomNumber(4),
                'savings_remarks' => $this->faker->text(50),
            ]));
            //Neighbour Helps
            $family->neighbourHelps()->create(array_merge($data, [
                'neighbour_help_type' => Arr::random(FamilyNeighbourHelpType::cases()),
            ]));
            //Rich Helps
            $family->richHelps()->create(array_merge($data, [
                'rich_help_type' => Arr::random(FamilyRichHelpType::cases()),
            ]));
            //Other Ngos
            $family->otherNgos()->create(array_merge($data, [
                'ngo_name'      => $this->faker->name,
                'ngo_help_type' => Arr::random(FamilyOtherNGOHelpType::cases()),
                'ngo_remarks'   => $this->faker->text(50),
            ]));
            //Disasters
            $family->disasters()->create(array_merge($data, [
                'disaster_id'    => Disaster::find(rand(1, $dc))->id,
                'disaster_level' => Arr::random(FamilyDisasterLevel::cases()),
                'recover_id'     => Recover::find(rand(1, $rc))->id,
            ]));
            //Conflict Resolves
            $family->conflictResolves()->create(array_merge($data, [
                'conflict_resolve_type' => Arr::random(FamilyConflictResolveType::cases()),
            ]));
        }
    }

    private function _tookServiceFromJeebika(Family $family)
    {
        $gro = JGro::find(rand(1, JGro::count()));
        Jeebika::create([
            'j_project_id' => $gro->j_project->id,
            'j_gro_id'     => $gro->id,
            'family_id'    => $family->id,
            'created_by'   => 1,
            'created_at'   => now()
        ]);
    }

    private function updateGROs()
    {
        foreach (JGro::all() as $item) {
            $item->leader_id = Mustahiq::inRandomOrder()->first()->id;
            $item->cashier_id = Mustahiq::inRandomOrder()->first()->id;
            $item->bank_account_name = Mustahiq::inRandomOrder()->first()->name . ' Account';
            $item->save();
        }
    }
}
