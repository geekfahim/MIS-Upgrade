<?php

namespace App\Schedules;

use App\Enums\IGA\JBusinessPlanInvestmentReturnType;
use App\Enums\IGA\JBusinessPlanStatus;
use App\Enums\JGroStatus;
use App\Enums\UserStatus;
use App\Models\Base\Acl\User;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\Project\JProject;
use Notification;

class InvestmentReturnDue
{
    protected JBusinessPlanInvestmentReturnType $type;

    public function __construct(JBusinessPlanInvestmentReturnType $returnType)
    {
        $this->type = $returnType;
    }

    public function __invoke()
    {
        $bp = JBusinessPlan::getTableName();
        $f = Family::getTableName();
        $p = JProject::getTableName();
        $u = User::getTableName();
        $items = User::select($u . '.id as id', 'f.name as family_name', 'business_name')
            ->join($p . ' as p', 'p.manager_id', '=', $u . '.id')
            ->join($bp . ' as bp', 'bp.j_project_id', '=', 'p.id')
            ->join($f . ' as f', 'f.id', '=', 'bp.family_id')
            ->where('approved_investment_return_type', $this->type)
            ->where('bp.status', JBusinessPlanStatus::Approved)
            ->orWhere('bp.status', JBusinessPlanStatus::Ongoing)
            ->where($u . '.status', UserStatus::Active)
            ->where('p.status', JGroStatus::Active)
            ->get();

        $data['route'] = '';
        foreach ($items as $item) {
            $data['title'] = "investment due";
            $data['message'] = "{$item->business_name} of {$item->family_name}";
            Notification::send($item, new \App\Notifications\InvestmentReturnDue($data));
        }
    }
}
