<ol class="breadcrumb">
    <!-- Breadcrumb Menu-->
    <li class="breadcrumb-menu">
        <div class="btn-group" role="group" aria-label="Button group">
            <div class="ml-2">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="btn btn-success dropdown-toggle czm-a-button" data-toggle="dropdown" href="#"
                           role="button"
                           aria-haspopup="true" aria-expanded="false">Approvals
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.savings_approve.view', ['pid' => $project->id]) }}">
                                <i class="fa fa-money text-info"></i>Savings</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.equity_approve.view', ['pid' => $project->id]) }}">
                                <i class="fa fa-money text-info"></i>Equity</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.investment_approve.view', ['pid' => $project->id]) }}">
                                <i class="fa fa-money text-info"></i>Investment</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.investment_return_approve.view', ['pid' => $project->id]) }}">
                                <i class="fa fa-money text-info"></i>Investment Return</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.bank_charge_approve.view', ['pid' => $project->id]) }}">
                                <i class="fa fa-money text-info"></i>Bank Charges</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.miscellaneous_approve.view', ['pid' => $project->id]) }}">
                                <i class="fa fa-money text-info"></i>Miscellaneous</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.withdrawal_approve.view', ['pid' => $project->id]) }}">
                                <i class="fa fa-money text-info"></i>Withdrawal</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.settlement_approve.view', ['pid' => $project->id]) }}">
                                <i class="fa fa-money text-info"></i>Settlement</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.verification_approve.view', ['pid' => $project->id]) }}">
                                <i class="fa fa-check text-info"></i>Business Plan Verification</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.visit_approve.view', ['pid' => $project->id]) }}">
                                <i class="fa fa-check text-info"></i>Business Plan Visit</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.final_approve.view', ['pid' => $project->id]) }}">
                                <i class="fa fa-check text-info"></i>Business Plan Final</a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="ml-2">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="btn btn-info dropdown-toggle czm-a-button" data-toggle="dropdown" href="#"
                           role="button"
                           aria-haspopup="true" aria-expanded="false">Implementation Plan
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route("jeebika.implementation_create.view",['pid'=>$project->id]) }}">
                                <i class="fa fa-money text-info"></i>Implementation Plan Create</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route("jeebika.implementation_feedback.view",['pid'=>$project->id]) }}">
                                <i class="fa fa-money text-info"></i>Implementation Plan Feedback</a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="ml-2">
                <ul class="nav navbar-nav ml-auto">
                    <a class="btn btn-success czm-a-button" role="button"
                       href="{{ route("jeebika.fund_transfer.view",['pid'=>$project->id]) }}">
                        Fund Transfer</a>
                </ul>
            </div>
        </div>
    </li>
</ol>
