<?php

namespace App\Http\Controllers\Jeebika\Approve;

use App\Enums\IGA\JSavingStatus;
use App\Enums\IGA\JEquityStatus;
use App\Enums\IGA\JBankChargeStatus;
use App\Enums\IGA\JInvestmentReturnStatus;
use App\Enums\IGA\JInvestmentStatus;
use App\Enums\IGA\JMiscellaneousStatus;
use App\Enums\IGA\JSettlementStatus;
use App\Enums\IGA\JWithdrawlStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\IGA\BalanceUpdate;
use App\Models\Jeebika\IGA\JBankCharge;
use App\Models\Jeebika\IGA\JInvestment;
use App\Models\Jeebika\IGA\JInvestmentReturn;
use App\Models\Jeebika\IGA\JMiscellaneous;
use App\Models\Jeebika\IGA\JSaving;
use App\Models\Jeebika\IGA\JEquity;
use App\Models\Jeebika\IGA\JSettlement;
use App\Models\Jeebika\IGA\JWithdrawal;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Project\JProjectFieldOfficer;
use App\Models\Jeebika\Validators\JBankChargeApproveValidator;
use App\Models\Jeebika\Validators\JInvestmentReturnApproveValidator;
use App\Models\Jeebika\Validators\JInvestmentApproveValidator;
use App\Models\Jeebika\Validators\JMiscellaneousApproveValidator;
use App\Models\Jeebika\Validators\JSavingsApproveValidator;
use App\Models\Jeebika\Validators\JEquityApproveValidator;
use App\Models\Jeebika\Validators\JSettlementApproveValidator;
use App\Models\Jeebika\Validators\JWithdrawalApproveValidator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AccountApproveController extends Controller
{
    /* Savings */
    public function indexSavings($pid): Renderable
    {
        $project = JProject::find($pid);
        return view('dashboard.jeebika.approve.savings', compact('project'));
    }

    public function getSavingsList(Request $request, $pid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'name,created_at,confirmed_amount,approved_amount,collector_id,status,created_by,date');
        $js = JSaving::getTableName();
        $f = Family::getTableName();
        $data = JSaving::with(['created_user:id,name', 'collector:id,name'])
            ->select($js . '.id as id', $js . '.status as status', $js . '.created_by as created_by', $js . '.created_at as created_at',
                'date', 'confirmed_amount', 'approved_amount', 'collector_id', 'remarks', 'name', 'family_id', 'j_project_id')
            ->join($f . ' as f', 'f.id', '=', 'family_id')
            ->when($query, function ($builder) use ($query) {
                $builder->where('name', 'LIKE', '%' . $query . '%');
            })
            ->where($js . '.status', '!=', JSavingStatus::Pending)
            ->where('j_project_id', $pid)
            ->orderBy($sort, $type)->paginate($item);

        return response()->json([
            'lists'         => $data,
            'fieldOfficers' => JProjectFieldOfficer::getOfficersByProjectId($pid),
            'statuses'      => JSavingStatus::cases()
        ], Response::HTTP_OK);
    }

    public function editSavings($pid, $id): JsonResponse
    {
        $data = JSaving::findOrFail($id);
        if (JSavingStatus::Confirmed !== $data->status) {
            return response()->json(["message" => "Only confirmed savings can be updated."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JSavingsApproveValidator())->validate($data, \request()->all());
        if (JSavingStatus::Rejected->value === $attributes['status']) {
            unset($attributes['approved_amount']);
        }
        $data->fill($attributes)->save();
        if (JSavingStatus::Approved === $data->status) {
            BalanceUpdate::update($data->family_id, $data->approved_amount);
        }
        return response()->json(['success' => 'Savings has been successfully updated.'], Response::HTTP_OK);
    }

    /* Equity */
    public function indexEquity($pid): Renderable
    {
        $project = JProject::find($pid);
        return view('dashboard.jeebika.approve.equity', compact('project'));
    }

    public function getEquityList(Request $request, $pid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'name,created_at,confirmed_amount,approved_amount,status,created_by,date');
        $js = JEquity::getTableName();
        $f = Family::getTableName();
        $data = JEquity::with(['created_user:id,name'])
            ->select($js . '.id as id', $js . '.status as status', $js . '.created_by as created_by', $js . '.created_at as created_at', 'date', 'confirmed_amount', 'approved_amount', 'remarks', 'name', 'j_project_id')
            ->join($f . ' as f', 'f.id', '=', 'family_id')
            ->when($query, function ($builder) use ($query) {
                $builder->where('name', 'LIKE', '%' . $query . '%');
            })
            ->where($js . '.status', '!=', JEquityStatus::Pending)
            ->where('j_project_id', $pid)
            ->orderBy($sort, $type)->paginate($item);

        return response()->json([
            'lists'    => $data,
            'statuses' => JEquityStatus::cases()
        ], Response::HTTP_OK);
    }

    public function editEquity($pid, $id): JsonResponse
    {
        $data = JEquity::findOrFail($id);
        if (JEquityStatus::Confirmed !== $data->status) {
            return response()->json(["message" => "Only confirmed equity can be updated."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JEquityApproveValidator())->validate($data, \request()->all());
        if (JEquityStatus::Rejected->value === $attributes['status']) {
            unset($attributes['approved_amount']);
        }
        $data->fill($attributes)->save();
        if (JEquityStatus::Approved === $data->status) {
            BalanceUpdate::update($data->family_id, $data->approved_amount);
        }
        return response()->json(['success' => 'Equity has been successfully updated.'], Response::HTTP_OK);
    }

    /* Investment*/
    public function indexInvestment($pid): Renderable
    {
        $project = JProject::find($pid);
        return view('dashboard.jeebika.approve.investment', compact('project'));
    }

    public function getInvestmentList(Request $request, $pid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'name,created_at,confirmed_amount,approved_amount,status,created_by,date');
        $ji = JInvestment::getTableName();
        $f = Family::getTableName();
        $data = JInvestment::with(['created_user:id,name', 'business:id,business_name'])
            ->select($ji . '.id as id', $ji . '.status as status', $ji . '.created_by as created_by', $ji . '.created_at as created_at', 'date', 'j_business_plan_id', 'confirmed_amount', 'approved_amount', 'remarks', 'reference_number', 'name', 'j_project_id')
            ->join($f . ' as f', 'f.id', '=', 'family_id')
            ->when($query, function ($builder) use ($query) {
                $builder->where('name', 'LIKE', '%' . $query . '%');
            })
            ->where($ji . '.status', '!=', JInvestmentStatus::Pending)
            ->where('j_project_id', $pid)
            ->orderBy($sort, $type)->paginate($item);
        return response()->json([
            'lists'    => $data,
            'statuses' => JInvestmentStatus::cases()
        ], Response::HTTP_OK);
    }

    public function editInvestment($pid, $id): JsonResponse
    {
        $data = JInvestment::findOrFail($id);
        if (JInvestmentStatus::Confirmed !== $data->status) {
            return response()->json(["message" => "Only confirmed investment can be updated."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JInvestmentApproveValidator())->validate($data, \request()->all());
        if (JInvestmentStatus::Rejected->value === $attributes['status']) {
            unset($attributes['approved_amount']);
        }
        $data->fill($attributes)->save();
        if (JInvestmentStatus::Approved === $data->status) {
            BalanceUpdate::update($data->family_id, $data->approved_amount, false);
        }
        return response()->json(['success' => 'Investment has been successfully updated.'], Response::HTTP_OK);
    }

    /* Investment Return */
    public function indexInvestmentReturn($pid): Renderable
    {
        $project = JProject::find($pid);
        return view('dashboard.jeebika.approve.investment_return', compact('project'));
    }

    public function getInvestmentReturnList(Request $request, $pid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'name,created_at,confirmed_amount,approved_amount,status,created_by,date');
        $ji = JInvestmentReturn::getTableName();
        $f = Family::getTableName();
        $data = JInvestmentReturn::with(['created_user:id,name', 'business:id,business_name'])
            ->select($ji . '.id as id', $ji . '.status as status', $ji . '.created_by as created_by', $ji . '.created_at as created_at', 'date', 'j_business_plan_id', 'confirmed_amount', 'approved_amount', 'remarks', 'name', 'j_project_id')
            ->join($f . ' as f', 'f.id', '=', 'family_id')
            ->when($query, function ($builder) use ($query) {
                $builder->where('name', 'LIKE', '%' . $query . '%');
            })
            ->where($ji . '.status', '!=', JInvestmentReturnStatus::Pending)
            ->where('j_project_id', $pid)
            ->orderBy($sort, $type)->paginate($item);
        return response()->json([
            'lists'    => $data,
            'statuses' => JInvestmentReturnStatus::cases()
        ], Response::HTTP_OK);
    }

    public function editInvestmentReturn($pid, $id): JsonResponse
    {
        $data = JInvestmentReturn::findOrFail($id);
        if (JInvestmentReturnStatus::Confirmed !== $data->status) {
            return response()->json(["message" => "Only confirmed investment return can be updated."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JInvestmentReturnApproveValidator)->validate($data, \request()->all());
        if (JInvestmentReturnStatus::Rejected->value === $attributes['status']) {
            unset($attributes['approved_amount']);
        }
        $data->fill($attributes)->save();
        if (JInvestmentReturnStatus::Approved === $data->status) {
            BalanceUpdate::update($data->family_id, $data->approved_amount);
        }
        return response()->json(['success' => 'Investment Return has been successfully updated.'], Response::HTTP_OK);
    }

    /* Bank Charge */
    public function indexBankCharge($pid): Renderable
    {
        $project = JProject::find($pid);
        return view('dashboard.jeebika.approve.bank_charge', compact('project'));
    }

    public function getBankChargeList(Request $request, $pid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'name,created_at,confirmed_amount,approved_amount,status,created_by,date');
        $ji = JBankCharge::getTableName();
        $f = Family::getTableName();
        $data = JBankCharge::with(['created_user:id,name'])
            ->select($ji . '.id as id', $ji . '.status as status', $ji . '.created_by as created_by', $ji . '.created_at as created_at', 'date', 'confirmed_amount', 'approved_amount', 'remarks', 'name', 'j_project_id')
            ->join($f . ' as f', 'f.id', '=', 'family_id')
            ->when($query, function ($builder) use ($query) {
                $builder->where('name', 'LIKE', '%' . $query . '%');
            })
            ->where($ji . '.status', '!=', JBankChargeStatus::Pending)
            ->where('j_project_id', $pid)
            ->orderBy($sort, $type)->paginate($item);

        return response()->json([
            'lists'    => $data,
            'statuses' => JBankChargeStatus::cases()
        ], Response::HTTP_OK);
    }

    public function editBankCharge($pid, $id): JsonResponse
    {
        $data = JBankCharge::findOrFail($id);
        if (JBankChargeStatus::Confirmed !== $data->status) {
            return response()->json(["message" => "Only confirmed bank charge can be updated."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JBankChargeApproveValidator)->validate($data, \request()->all());
        if (JBankChargeStatus::Rejected->value === $attributes['status']) {
            unset($attributes['approved_amount']);
        }
        $data->fill($attributes)->save();
        if (JBankChargeStatus::Approved === $data->status) {
            BalanceUpdate::update($data->family_id, $data->approved_amount, false);
        }
        return response()->json(['success' => 'Bank Charge has been successfully updated.'], Response::HTTP_OK);
    }

    /* Miscellaneous */
    public function indexMiscellaneous($pid): Renderable
    {
        $project = JProject::find($pid);
        return view('dashboard.jeebika.approve.miscellaneous', compact('project'));
    }

    public function getMiscellaneousList(Request $request, $pid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'name,created_at,confirmed_amount,approved_amount,status,created_by,date');
        $ji = JMiscellaneous::getTableName();
        $f = Family::getTableName();
        $data = JMiscellaneous::with(['created_user:id,name'])
            ->select($ji . '.id as id', $ji . '.status as status', $ji . '.created_by as created_by', $ji . '.created_at as created_at', 'date', 'confirmed_amount', 'approved_amount', 'remarks', 'name', 'j_project_id')
            ->join($f . ' as f', 'f.id', '=', 'family_id')
            ->when($query, function ($builder) use ($query) {
                $builder->where('name', 'LIKE', '%' . $query . '%');
            })
            ->where($ji . '.status', '!=', JMiscellaneousStatus::Pending)
            ->where('j_project_id', $pid)
            ->orderBy($sort, $type)->paginate($item);

        return response()->json([
            'lists'    => $data,
            'statuses' => JMiscellaneousStatus::cases()
        ], Response::HTTP_OK);
    }

    public function editMiscellaneous($pid, $id): JsonResponse
    {
        $data = JMiscellaneous::findOrFail($id);
        if (JMiscellaneousStatus::Confirmed !== $data->status) {
            return response()->json(["message" => "Only confirmed miscellaneous can be updated."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JMiscellaneousApproveValidator)->validate($data, \request()->all());
        if (JMiscellaneousStatus::Rejected->value === $attributes['status']) {
            unset($attributes['approved_amount']);
        }
        $data->fill($attributes)->save();
        if (JMiscellaneousStatus::Approved === $data->status) {
            BalanceUpdate::update($data->family_id, $data->approved_amount, false);
        }
        return response()->json(['success' => 'Miscellaneous  has been successfully updated.'], Response::HTTP_OK);
    }

    /* Withdrawal */
    public function indexWithdrawal($pid): Renderable
    {
        $project = JProject::find($pid);
        return view('dashboard.jeebika.approve.withdrawal', compact('project'));
    }

    public function getWithdrawalList(Request $request, $pid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'name,created_at,confirmed_amount,approved_amount,status,created_by,date');
        $ji = JWithdrawal::getTableName();
        $f = Family::getTableName();
        $data = JWithdrawal::with(['created_user:id,name'])
            ->select($ji . '.id as id', $ji . '.status as status', $ji . '.created_by as created_by', $ji . '.created_at as created_at', 'date', 'confirmed_amount', 'approved_amount', 'remarks', 'name', 'j_project_id')
            ->join($f . ' as f', 'f.id', '=', 'family_id')
            ->when($query, function ($builder) use ($query) {
                $builder->where('name', 'LIKE', '%' . $query . '%');
            })
            ->where($ji . '.status', '!=', JWithdrawlStatus::Pending)
            ->where('j_project_id', $pid)
            ->orderBy($sort, $type)->paginate($item);

        return response()->json([
            'lists'    => $data,
            'statuses' => JWithdrawlStatus::cases()
        ], Response::HTTP_OK);
    }

    public function editWithdrawal($pid, $id): JsonResponse
    {
        $data = JWithdrawal::findOrFail($id);
        if (JWithdrawlStatus::Confirmed !== $data->status) {
            return response()->json(["message" => "Only confirmed withdrawal can be updated."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JWithdrawalApproveValidator)->validate($data, \request()->all());
        if (JWithdrawlStatus::Rejected->value === $attributes['status']) {
            unset($attributes['approved_amount']);
        }
        $data->fill($attributes)->save();
        if (JWithdrawlStatus::Approved === $data->status) {
            BalanceUpdate::update($data->family_id, $data->approved_amount, false);
        }
        return response()->json(['success' => 'Withdrawal  has been successfully updated.'], Response::HTTP_OK);
    }

    /* Settlement */
    public function indexSettlement($pid): Renderable
    {
        $project = JProject::find($pid);
        return view('dashboard.jeebika.approve.settlement', compact('project'));
    }

    public function getSettlementList(Request $request, $pid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'name,created_at,confirmed_amount,approved_amount,status,created_by,date');
        $ji = JSettlement::getTableName();
        $f = Family::getTableName();
        $data = JSettlement::with(['created_user:id,name'])
            ->select($ji . '.id as id', $ji . '.status as status', $ji . '.created_by as created_by', $ji . '.created_at as created_at', 'date', 'confirmed_amount', 'approved_amount', 'remarks', 'name', 'j_project_id')
            ->join($f . ' as f', 'f.id', '=', 'family_id')
            ->when($query, function ($builder) use ($query) {
                $builder->where('name', 'LIKE', '%' . $query . '%');
            })
            ->where($ji . '.status', '!=', JSettlementStatus::Pending)
            ->where('j_project_id', $pid)
            ->orderBy($sort, $type)->paginate($item);

        return response()->json([
            'lists'    => $data,
            'statuses' => JSettlementStatus::cases()
        ], Response::HTTP_OK);
    }

    public function editSettlement($pid, $id): JsonResponse
    {
        $data = JSettlement::findOrFail($id);
        if (JSettlementStatus::Confirmed !== $data->status) {
            return response()->json(["message" => "Only confirmed settlement can be updated."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JSettlementApproveValidator)->validate($data, \request()->all());
        if (JSettlementStatus::Rejected->value === $attributes['status']) {
            unset($attributes['approved_amount']);
        }
        $data->fill($attributes)->save();
        if (JSettlementStatus::Approved === $data->status) {
            BalanceUpdate::update($data->family_id, $data->approved_amount, false);
        }
        return response()->json(['success' => 'Settlement  has been successfully updated.'], Response::HTTP_OK);
    }
}
