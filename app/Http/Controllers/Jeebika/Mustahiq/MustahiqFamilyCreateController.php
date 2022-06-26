<?php

namespace App\Http\Controllers\Jeebika\Mustahiq;

use App\Enums\FamilyRelationType;
use App\Enums\OriginProgram;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyAsset;
use App\Models\Base\Family\FamilyConflictResolve;
use App\Models\Base\Family\FamilyDisaster;
use App\Models\Base\Family\FamilyExpense;
use App\Models\Base\Family\FamilyIncome;
use App\Models\Base\Family\FamilyLoan;
use App\Models\Base\Family\FamilyMember;
use App\Models\Base\Family\FamilyNeighbourHelp;
use App\Models\Base\Family\FamilyOtherNgo;
use App\Models\Base\Family\FamilyRichHelp;
use App\Models\Base\Family\FamilySafety;
use App\Models\Base\Family\FamilySaving;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\JGro;
use App\Models\Validators\MustahiqFamilyCreateValidator;
use Error;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MustahiqFamilyCreateController extends Controller
{
    /* Max Limits */
    private static int $_maxMustahiqs = 10;
    private static int $_maxFamilyAssets = 10;
    private static int $_maxFamilyLoans = 10;
    private static int $_maxFamilyIncomes = 10;
    private static int $_maxFamilyExpenses = 10;
    private static int $_maxFamilySavings = 10;
    private static int $_maxFamilyOtherNgos = 10;
    private static int $_maxFamilySafeties = 10;
    private static int $_maxFamilyNeighborHelps = 10;
    private static int $_maxFamilyRichHelps = 10;
    private static int $_maxFamilyConflictResolves = 10;
    private static int $_maxFamilyDisasters = 10;

    /* Public functions */

    public function index(): Renderable
    {
        return view('dashboard.jeebika.mustahiq.create-mustahiq-family');
    }

    public function create(): JsonResponse
    {
        /* Validation */
        $attributes = (new MustahiqFamilyCreateValidator())->validate(\request()->all());

        /* Max Value Checking */
        if (!empty($attributes["mustahiqs"]) && count($attributes["mustahiqs"]) > self::$_maxMustahiqs) return response()->json(["message" => "Family member are not more than " . self::$_maxMustahiqs], Response::HTTP_UNPROCESSABLE_ENTITY);
        if (!empty($attributes["familyAssets"]) && count($attributes["familyAssets"]) > self::$_maxFamilyAssets) return response()->json(["message" => "Family assets are not more than " . self::$_maxFamilyAssets], Response::HTTP_UNPROCESSABLE_ENTITY);
        if (!empty($attributes["familyLoans"]) && count($attributes["familyLoans"]) > self::$_maxFamilyLoans) return response()->json(["message" => "Family liabilities are not more than " . self::$_maxFamilyLoans], Response::HTTP_UNPROCESSABLE_ENTITY);
        if (!empty($attributes["familyIncomes"]) && count($attributes["familyIncomes"]) > self::$_maxFamilyIncomes) return response()->json(["message" => "Family incomes are not more than " . self::$_maxFamilyIncomes], Response::HTTP_UNPROCESSABLE_ENTITY);
        if (!empty($attributes["familyExpenses"]) && count($attributes["familyExpenses"]) > self::$_maxFamilyExpenses) return response()->json(["message" => "Family expenses are not more than " . self::$_maxFamilyExpenses], Response::HTTP_UNPROCESSABLE_ENTITY);
        if (!empty($attributes["familySavings"]) && count($attributes["familySavings"]) > self::$_maxFamilySavings) return response()->json(["message" => "Family savings are not more than " . self::$_maxFamilySavings], Response::HTTP_UNPROCESSABLE_ENTITY);
        if (!empty($attributes["familyOtherNgos"]) && count($attributes["familyOtherNgos"]) > self::$_maxFamilyOtherNgos) return response()->json(["message" => "Family other ngo are not more than " . self::$_maxFamilyOtherNgos], Response::HTTP_UNPROCESSABLE_ENTITY);
        if (!empty($attributes["familySafeties"]) && count($attributes["familySafeties"]) > self::$_maxFamilySafeties) return response()->json(["message" => "Family safeties are not more than " . self::$_maxFamilySafeties], Response::HTTP_UNPROCESSABLE_ENTITY);
        if (!empty($attributes["familyNeighborHelps"]) && count($attributes["familyNeighborHelps"]) > self::$_maxFamilyNeighborHelps) return response()->json(["message" => "Family neighbor people helps are not more than " . self::$_maxFamilyNeighborHelps], Response::HTTP_UNPROCESSABLE_ENTITY);
        if (!empty($attributes["familyRichHelps"]) && count($attributes["familyRichHelps"]) > self::$_maxFamilyRichHelps) return response()->json(["message" => "Family rich people helps are not more than " . self::$_maxFamilyRichHelps], Response::HTTP_UNPROCESSABLE_ENTITY);
        if (!empty($attributes["familyConflictResolves"]) && count($attributes["familyConflictResolves"]) > self::$_maxFamilyConflictResolves) return response()->json(["message" => "Family conflict resolves are not more than " . self::$_maxFamilyConflictResolves], Response::HTTP_UNPROCESSABLE_ENTITY);
        if (!empty($attributes["familyDisasters"]) && count($attributes["familyDisasters"]) > self::$_maxFamilyDisasters) return response()->json(["message" => "Family disasters are not more than " . self::$_maxFamilyDisasters], Response::HTTP_UNPROCESSABLE_ENTITY);

        /* Check Family Head Selected or Not && Check Multi Family Head Selected */
        $familyHeadFound = false;
        $headCount = 0;
        if (!empty($attributes["mustahiqs"]) && count($attributes["mustahiqs"]) > 0) {
            foreach ($attributes["mustahiqs"] as $mustahiq) {
                if (FamilyRelationType::Self->value == $mustahiq['relation_with_family_head']) {
                    $familyHeadFound = true;
                    $headCount++;
                }
            }
        }
        if ($headCount > 1) {
            return response()->json(["message" => "Multiple family head are selected. Please select only one family head member."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (!$familyHeadFound) {
            return response()->json(["message" => "Family head is not selected. Please add a family head member."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /* Insert to database */
        try {
            DB::transaction(function () use ($attributes) {
                $family = $this->_createFamily($attributes);
                $this->_familyAssetsCreate($family, $attributes);
                $this->_familyLoansCreate($family, $attributes);
                $this->_familyIncomesCreate($family, $attributes);
                $this->_familyExpensesCreate($family, $attributes);
                $this->_familySavingsCreate($family, $attributes);
                $this->_familyOtherNgosCreate($family, $attributes);
                $this->_familySafetiesCreate($family, $attributes);
                $this->_familyNeighborHelpsCreate($family, $attributes);
                $this->_familyRichHelpsCreate($family, $attributes);
                $this->_familyConflictResolvesCreate($family, $attributes);
                $this->_familyDisastersCreate($family, $attributes);
            });
        } catch (Exception $e) {
            return response()->json(["message" => "Exception - " . $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Error $e) {
            return response()->json(["message" => "Error - " . $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(["success" => "New Mustahiq & its family has been successfully created."], Response::HTTP_OK);
    }

    /* Private functions */

    private function _createFamily(array $attributes)
    {
        $allMembers = $this->_mustahiqsCreate($attributes);
        $head = collect($allMembers)->filter(function ($item) {
            return FamilyRelationType::Self->value == $item['relation'];
        })->first();
        $familyName = $head['name'];
        $familyHeadId = $head['id'];
        $family = Family::create([
            'name'                     => $familyName . "'s family",
            'family_head_id'           => $familyHeadId,
            'number_of_family_member'  => count($allMembers),
            'family_headed_by'         => $attributes['family_headed_by'],
            'total_room'               => $attributes['total_room'],
            'house_type'               => $attributes['house_type'],
            'house_land_type'          => $attributes['house_land_type'],
            'house_location'           => $attributes['house_location'],
            'drinking_water'           => $attributes['drinking_water'],
            'other_water'              => $attributes['other_water'],
            'toilet_type'              => $attributes['toilet_type'],
            'toilet_owner'             => $attributes['toilet_owner'],
            'cooking_fuel'             => $attributes['cooking_fuel'],
            'electricity_connectivity' => $attributes['electricity_connectivity'],
            'family_reference_number'  => $attributes['family_reference_number'],
            'origin_program'           => OriginProgram::JEEBIKA->value,
            "created_by"               => $attributes['created_by'],
        ]);
        if (!empty($allMembers) && count($allMembers) > 0) {
            foreach ($allMembers as $item) {
                FamilyMember::create([
                    'family_id'                 => $family->id,
                    'mustahiq_id'               => $item['id'],
                    'is_family_head'            => $familyHeadId == $item['id'],
                    'relation_with_family_head' => $item['relation'],
                    "created_by"                => $attributes['created_by'],
                ]);
            }
        }
        $gro = JGro::with('j_project')->find($attributes['j_gro_id']);
        Jeebika::create([
            'j_project_id' => $gro->j_project->id,
            'j_gro_id'     => $gro->id,
            'family_id'    => $family->id,
            'created_by'   => $attributes['created_by'],
        ]);
        return $family;
    }

    private function _mustahiqsCreate(array $attributes): array
    {
        $data = [];
        if (!empty($attributes['mustahiqs']) && count($attributes['mustahiqs']) > 0) {
            foreach ($attributes['mustahiqs'] as $item) {
                $mustahiq = Mustahiq::createOrUpdateMustahiq(true, $item, $attributes['created_by'], $attributes['j_sponsor_id']);
                $data[] = ['id' => $mustahiq->id, 'name' => $mustahiq->name, 'relation' => $item['relation_with_family_head']];
            }
        }
        return $data;
    }

    private function _familyAssetsCreate(Family $family, array $attributes)
    {
        if (!empty($attributes["familyAssets"]) && count($attributes["familyAssets"]) > 0 && is_array($attributes["familyAssets"])) {
            foreach ($attributes["familyAssets"] as $item) {
                FamilyAsset::create([
                    'family_id'      => $family->id,
                    'asset_id'       => $item['asset_id'],
                    'asset_quantity' => $item['asset_quantity'] ?? null,
                    'asset_location' => $item['asset_location'] ?? null,
                    'asset_value'    => $item['asset_value'] ?: 0,
                    'asset_remarks'  => $item['asset_remarks'] ?? null,
                    "created_by"     => $attributes['created_by'],
                ]);
            }
        }
    }

    private function _familyLoansCreate(Family $family, array $attributes)
    {
        if (!empty($attributes["familyLoans"]) && count($attributes["familyLoans"]) > 0 && is_array($attributes["familyLoans"])) {
            foreach ($attributes["familyLoans"] as $item) {
                FamilyLoan::create([
                    'family_id'                 => $family->id,
                    'loan_taking_date'          => $item['loan_taking_date'],
                    'loan_source'               => $item['loan_source'],
                    'loan_source_name'          => $item['loan_source_name'],
                    'loan_amount'               => $item['loan_amount'] ?: 0,
                    'loan_rate_or_extra_amount' => $item['loan_rate_or_extra_amount'] ?: null,
                    'loan_duration'             => $item['loan_duration'],
                    'loan_purpose'              => $item['loan_purpose'],
                    'loan_outstanding_amount'   => $item['loan_outstanding_amount'] ?: 0,
                    'loan_remarks'              => $item['loan_remarks'] ?: null,
                    "created_by"                => $attributes['created_by'],
                ]);
            }
        }
    }

    private function _familyIncomesCreate(Family $family, array $attributes)
    {
        if (!empty($attributes["familyIncomes"]) && count($attributes["familyIncomes"]) > 0 && is_array($attributes["familyIncomes"])) {
            foreach ($attributes["familyIncomes"] as $item) {
                FamilyIncome::create([
                    'family_id'      => $family->id,
                    'income_id'      => $item['income_source_id'],
                    'income_amount'  => $item['income_amount'] ?: 0,
                    'income_remarks' => $item['income_remarks'] ?? null,
                    "created_by"     => $attributes['created_by'],
                ]);
            }
        }
    }

    private function _familyExpensesCreate(Family $family, array $attributes)
    {
        if (!empty($attributes["familyExpenses"]) && count($attributes["familyExpenses"]) > 0 && is_array($attributes["familyExpenses"])) {
            foreach ($attributes["familyExpenses"] as $item) {
                FamilyExpense::create([
                    'family_id'       => $family->id,
                    'expense_type'    => $item['expense_type'],
                    'expense_amount'  => $item['expense_amount'] ?: 0,
                    'expense_remarks' => $item['expense_remarks'] ?: null,
                    "created_by"      => $attributes['created_by'],
                ]);
            }
        }
    }

    private function _familySavingsCreate(Family $family, array $attributes)
    {
        if (!empty($attributes["familySavings"]) && count($attributes["familySavings"]) > 0 && is_array($attributes["familySavings"])) {
            foreach ($attributes["familySavings"] as $item) {
                FamilySaving::create([
                    'family_id'       => $family->id,
                    'savings_type'    => $item['savings_type'],
                    'savings_amount'  => $item['savings_amount'] ?: 0,
                    'savings_remarks' => $item['savings_remarks'] ?? null,
                    "created_by"      => $attributes['created_by'],
                ]);
            }
        }
    }

    private function _familyOtherNgosCreate(Family $family, array $attributes)
    {
        if (!empty($attributes["familyOtherNgos"]) && count($attributes["familyOtherNgos"]) > 0 && is_array($attributes["familyOtherNgos"])) {
            foreach ($attributes["familyOtherNgos"] as $item) {
                FamilyOtherNgo::create([
                    'family_id'     => $family->id,
                    'ngo_name'      => $item['ngo_name'],
                    'ngo_help_type' => $item['ngo_help_type'],
                    'ngo_remarks'   => $item['ngo_remarks'] ?: null,
                    "created_by"    => $attributes['created_by'],
                ]);
            }
        }
    }

    private function _familySafetiesCreate(Family $family, array $attributes)
    {
        if (!empty($attributes["familySafeties"]) && count($attributes["familySafeties"]) > 0 && is_array($attributes["familySafeties"])) {
            foreach ($attributes["familySafeties"] as $item) {
                FamilySafety::create([
                    'family_id'                   => $family->id,
                    'safety_victim_name'          => $item['safety_victim_name'],
                    'safety_relation_with_abuser' => $item['safety_relation_with_abuser'],
                    'safety_type_of_abuse'        => $item['safety_type_of_abuse'],
                    'safety_place_of_abuse'       => $item['safety_place_of_abuse'],
                    'safety_abuser_name'          => $item['safety_abuser_name'],
                    "created_by"                  => $attributes['created_by'],
                ]);
            }
        }
    }

    private function _familyNeighborHelpsCreate(Family $family, array $attributes)
    {
        if (!empty($attributes["familyNeighborHelps"]) && count($attributes["familyNeighborHelps"]) > 0 && is_array($attributes["familyNeighborHelps"])) {
            foreach ($attributes["familyNeighborHelps"] as $item) {
                FamilyNeighbourHelp::create([
                    'family_id'           => $family->id,
                    'neighbour_help_type' => $item['neighbour_help_type'],
                    "created_by"          => $attributes['created_by'],
                ]);
            }
        }
    }

    private function _familyRichHelpsCreate(Family $family, array $attributes)
    {
        if (!empty($attributes["familyRichHelps"]) && count($attributes["familyRichHelps"]) > 0 && is_array($attributes["familyRichHelps"])) {
            foreach ($attributes["familyRichHelps"] as $item) {
                FamilyRichHelp::create([
                    'family_id'      => $family->id,
                    'rich_help_type' => $item['rich_help_type'],
                    "created_by"     => $attributes['created_by'],
                ]);
            }
        }
    }

    private function _familyConflictResolvesCreate(Family $family, array $attributes)
    {
        if (!empty($attributes["familyConflictResolves"]) && count($attributes["familyConflictResolves"]) > 0 && is_array($attributes["familyConflictResolves"])) {
            foreach ($attributes["familyConflictResolves"] as $item) {
                FamilyConflictResolve::create([
                    'family_id'             => $family->id,
                    'conflict_resolve_type' => $item['conflict_resolve_type'],
                    "created_by"            => $attributes['created_by'],
                ]);
            }
        }
    }

    private function _familyDisastersCreate(Family $family, array $attributes)
    {
        if (!empty($attributes["familyDisasters"]) && count($attributes["familyDisasters"]) > 0 && is_array($attributes["familyDisasters"])) {
            foreach ($attributes["familyDisasters"] as $item) {
                FamilyDisaster::create([
                    'family_id'      => $family->id,
                    'disaster_id'    => $item['disaster_id'],
                    'disaster_level' => $item['disaster_level'],
                    'recover_id'     => $item['disaster_recover_id'],
                    "created_by"     => $attributes['created_by'],
                ]);
            }
        }
    }
}
