<?php

namespace App\Http\Controllers\Jeebika\Family\IGA;

use App\Enums\IGA\JBusinessPlanFieldCapital;
use App\Enums\IGA\JBusinessPlanInvestmentReturnType;
use App\Enums\IGA\JBusinessPlanMeetingStatus;
use App\Enums\IGA\JBusinessPlanSourceCapital;
use App\Enums\IGA\JBusinessPlanStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\IGA\Business\JBusinessPlanField;
use App\Models\Jeebika\IGA\Business\JBusinessPlanRisk;
use App\Models\Jeebika\IGA\Business\JBusinessPlanSource;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\Settings\JInvestmentArea;
use App\Rules\Name;
use App\Rules\Remarks;
use Error;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class BusinessPlanController extends Controller
{
    public function index($fid): Renderable
    {
        $family = Family::findOrFail($fid);
        return view('dashboard.jeebika.family.IGA.business-plan', compact('family'));
    }

    public function getList(Request $request, $fid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'business_name,created_at');
        $data = JBusinessPlan::with('j_investment_area:id,name')
            ->select('id', 'is_joint', 'family_id', 'business_name', 'j_investment_area_id', 'business_seed_money', 'status', 'created_at')
            ->where('is_joint', false)
            ->where('family_id', $fid)
            ->when($query, function ($sql) use ($query) {
                $sql->where('business_name', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $type)->paginate($item);

        return response()->json([
            'lists' => $data,
            'statuses' => JBusinessPlanStatus::cases(),
            'meetingStatuses' => JBusinessPlanMeetingStatus::cases(),
            'investmentAreas' => JInvestmentArea::getAll(),
            'investmentReturnTypes' => JBusinessPlanInvestmentReturnType::cases(),
            'sourceCapitalTypes' => JBusinessPlanSourceCapital::cases(),
            'fieldCapitalTypes' => JBusinessPlanFieldCapital::cases(),
        ], Response::HTTP_OK);
    }

    public function create(Request $request, $fid): JsonResponse
    {
        /* Validation */
        $this->_businessPlanValidation($request);
        $this->_sourceValidation($request);
        $this->_fieldValidation($request);
        $this->_riskValidation($request);

        $family = Family::findOrFail($fid);
        /* Create */
        try {
            DB::transaction(function () use ($request, $family) {
                $businessPlan = $this->_businessPlanCreate($request, $family);
                $this->_sourceCreate($request, $businessPlan);
                $this->_fieldCreate($request, $businessPlan);
                $this->_riskCreate($request, $businessPlan);
            });
        } catch (Exception $e) {
            return response()->json(["message" => "Exception - " . $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Error $e) {
            return response()->json(["message" => "Error - " . $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(['success' => 'Business Plan has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $item = JBusinessPlan::with([
            'created_user:id,name',
            'updated_user:id,name',
            'j_investment_area:id,name',
            'j_investment_approved_area:id,name',
            'sources:j_business_plan_id,source_name,source_amount,source_remarks',
            'fields:j_business_plan_id,field_name,field_unit_price,field_quantity,field_total_price',
            'risks:j_business_plan_id,risk_name,risk_prevention,risk_remarks',
            'approvedBy:id,name',
        ])->findOrFail($id);
        return response()->json(removeEmptyKey($item), Response::HTTP_OK);
    }

    public function update(Request $request, $fid, $id): JsonResponse
    {
        return response()->json(['message' => 'Need Work'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function delete($fid, $id): JsonResponse
    {
        $item = JBusinessPlan::findOrFail($id);
        if (JBusinessPlanStatus::Pending !== $item->status) {
            return response()->json(['message' => 'Only pending business plan can be deleted.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (!$item->delete()) {
            return response()->json(['message' => $item->name . ' in used'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        //Source Delete
        JBusinessPlanSource::where('j_business_plan_id', $item->id)->delete();
        //Field Delete
        JBusinessPlanField::where('j_business_plan_id', $item->id)->delete();
        //Risk Delete
        JBusinessPlanRisk::where('j_business_plan_id', $item->id)->delete();
        return response()->json(['success' => 'Business plan has been successfully deleted'], Response::HTTP_OK);
    }

    /* Validation Start */
    private function _businessPlanValidation(Request $request)
    {
        $request->validate([
            'business_name' => ['required', new Name(), 'min:2', 'max:50'],
            'j_investment_area_id' => ['required', Rule::exists(JInvestmentArea::getTableName(), 'id')],
            'business_duration' => ['required', 'numeric', 'min:1', 'max:9999'],
            'business_seed_money' => ['required', 'numeric', 'min:1', 'max:99999999'],
            'possible_gross_income' => ['required', 'numeric', 'min:1', 'max:99999999'],
            'possible_gross_expense' => ['required', 'numeric', 'min:1', 'max:99999999'],
            'investment_return_type' => ['required', new Enum(JBusinessPlanInvestmentReturnType::class)],
            'investment_return_amount_each' => ['required', 'numeric', 'min:1', 'max:99999999'],
            'business_assist' => ['required', new Name(), 'max:50'],
            'is_business_experience' => ['required', 'in:true,false'],
            'business_experience_duration' => [Rule::when($request->is_business_experience === 'true', ['required', 'numeric', 'min:1', 'max:9999'])],
            'is_business_training' => ['required', 'in:true,false'],
            'business_training_duration' => [Rule::when($request->is_business_training === 'true', ['required', 'numeric', 'min:1', 'max:9999'])],
            'business_training_institute_name' => [Rule::when($request->is_business_training === 'true', ['required', new Name(), 'max:50'])],
            'sourceCapitals' => ['required', 'array'],
            'fieldCapitals' => ['required', 'array'],
            'riskCapitals' => ['required', 'array'],
        ],
            [
                'sourceCapitals.required' => 'Source of Capitals are required.',
                'fieldCapitals.required' => 'Field of Capitals are required.',
                'riskCapitals.required' => 'Risk of Capitals are required.',
            ]);
    }

    private function _sourceValidation(Request $request)
    {
        $sourceCapitals = $request->sourceCapitals;
        if (!empty($sourceCapitals) && count($sourceCapitals) > 0) {
            $request->validate([
                'sourceCapitals.*.source_name' => ['required', new Enum(JBusinessPlanSourceCapital::class)],
                'sourceCapitals.*.source_amount' => ['required', 'numeric', 'min:1', 'max:999999'],
                'sourceCapitals.*.source_remarks' => ['nullable', new Remarks(), 'max:500'],
            ]);
        }
    }

    private function _fieldValidation(Request $request)
    {
        $fieldCapitals = $request->fieldCapitals;
        if (!empty($fieldCapitals) && count($fieldCapitals) > 0) {
            $request->validate([
                'fieldCapitals.*.field_name' => ['required', new Enum(JBusinessPlanFieldCapital::class)],
                'fieldCapitals.*.field_unit_price' => ['required', 'numeric', 'max:999999'],
                'fieldCapitals.*.field_quantity' => ['required', 'numeric', 'max:9999'],
                'fieldCapitals.*.field_remarks' => ['nullable', new Remarks(), 'max:500'],

            ]);
        }
    }

    private function _riskValidation(Request $request)
    {
        $riskCapitals = $request->riskCapitals;
        if (!empty($riskCapitals) && count($riskCapitals) > 0) {
            $request->validate([
                'riskCapitals.*.risk_name' => ['required', new Name(), 'max:191'],
                'riskCapitals.*.risk_prevention' => ['required', new Name(), 'max:500'],
                'riskCapitals.*.risk_remarks' => ['nullable', new Remarks(), 'max:500'],
            ]);
        }
    }
    /* Validation End */

    /* Private Create Functions Start */
    private function _businessPlanCreate(Request $request, Family $family): JBusinessPlan
    {
        $jeebika = Jeebika::firstWhere('family_id', $family->id);
        $bp = JBusinessPlan::create([
            'j_project_id' => $jeebika->j_project_id,
            'j_gro_id' => $jeebika->j_gro_id,
            'family_id' => $family->id,
            'business_name' => $request->input('business_name'),
            'j_investment_area_id' => $request->input('j_investment_area_id'),
            'business_duration' => $request->input('business_duration'),
            'business_seed_money' => $request->input('business_seed_money'),
            'possible_gross_income' => $request->input('possible_gross_income'),
            'possible_gross_expense' => $request->input('possible_gross_expense'),
            'investment_return_type' => $request->input('investment_return_type'),
            'investment_return_amount_each' => $request->input('investment_return_amount_each'),
            'business_assist' => $request->input('business_assist'),
            'is_business_experience' => $request->input('is_business_experience') == 'true' ? 1 : 0,
            'business_experience_duration' => $request->input('business_experience_duration') ?: 0,
            'is_business_training' => $request->input('is_business_training') == 'true' ? 1 : 0,
            'business_training_duration' => $request->input('business_training_duration') ?: 0,
            'business_training_institute_name' => $request->input('business_training_institute_name'),
            'created_by' => $request->input('created_by'),
            'created_at' => now(),
        ]);
        $bp->families()->create([
            'j_project_id' => $bp->j_project_id,
            'j_gro_id' => $bp->j_gro_id,
            'family_id' => $bp->family_id,
            'created_by' => 1,
            'created_at' => now(),
        ]);
        return $bp;
    }

    private function _sourceCreate(Request $request, JBusinessPlan $businessPlan)
    {
        $sourceCapitals = $request->sourceCapitals;
        if (!empty($sourceCapitals) && is_array($sourceCapitals) && count($sourceCapitals) > 0) {
            foreach ($sourceCapitals as $item) {
                $businessPlan->sources()->create([
                    'source_name' => $item['source_name'],
                    'source_amount' => $item['source_amount'],
                    'source_remarks' => $item['source_remarks'] ?: null,
                    'created_by' => $request->input('created_by'),
                    'created_at' => now(),
                ]);
            }
        }
    }

    private function _fieldCreate(Request $request, JBusinessPlan $businessPlan)
    {
        $fieldCapitals = $request->fieldCapitals;
        if (!empty($fieldCapitals) && is_array($fieldCapitals) && count($fieldCapitals) > 0) {
            $total = 0;
            foreach ($fieldCapitals as $item) {
                $itemTotalPrice = $item['field_unit_price'] * $item['field_quantity'];
                $businessPlan->fields()->create([
                    'field_name' => $item['field_name'],
                    'field_unit_price' => $item['field_unit_price'],
                    'field_quantity' => $item['field_quantity'],
                    'field_total_price' => $itemTotalPrice,
                    'created_by' => $request->input('created_by'),
                    'created_at' => now(),
                ]);
                $total += $itemTotalPrice;
            }
            $businessPlan->possible_net_profit = $total - $businessPlan->possible_gross_income;
            $businessPlan->save();
        }
    }


    private function _riskCreate(Request $request, JBusinessPlan $businessPlan)
    {
        $riskCapitals = $request->riskCapitals;
        if (!empty($riskCapitals) && is_array($riskCapitals) && count($riskCapitals) > 0) {
            foreach ($riskCapitals as $item) {
                $businessPlan->risks()->create([
                    'risk_name' => $item['risk_name'],
                    'risk_prevention' => $item['risk_prevention'],
                    'risk_remarks' => $item['risk_remarks'],
                    'created_by' => $request->input('created_by'),
                    'created_at' => now(),
                ]);
            }
        }
    }
    /* Private Create Functions End */
}
