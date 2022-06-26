<ol class="breadcrumb">
    <!-- Breadcrumb Menu-->
    <li class="breadcrumb-menu">
        <div class="btn-group" role="group" aria-label="Button group">
            <div class="ml-2">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="btn btn-success dropdown-toggle czm-a-button" data-toggle="dropdown" href="#"
                           role="button"
                           aria-haspopup="true" aria-expanded="false">Account Manager
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.savings.view', ['fid' => $family->id]) }}">
                                <i class="fa fa-money text-info"></i>Savings</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.equity.view', ['fid' => $family->id]) }}">
                                <i class="fa fa-money text-info"></i>Equity</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.investment.view', ['fid' => $family->id]) }}">
                                <i class="fa fa-money text-info"></i>Investment</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.investment_return.view', ['fid' => $family->id]) }}">
                                <i class="fa fa-money text-info"></i>Investment Return</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.bank_charge.view', ['fid' => $family->id]) }}">
                                <i class="fa fa-money text-info"></i>Bank Charges</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.miscellaneous.view', ['fid' => $family->id]) }}">
                                <i class="fa fa-money text-info"></i>Miscellaneous</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.withdrawal.view', ['fid' => $family->id]) }}">
                                <i class="fa fa-money text-info"></i>Withdrawal</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.settlement.view', ['fid' => $family->id]) }}">
                                <i class="fa fa-money text-info"></i>Settlement</a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="ml-2">
                <ul class="nav navbar-nav ml-auto">
                    <a class="btn btn-primary czm-a-button" role="button"
                       href="{{ route('jeebika.need.view', ['fid' => $family->id]) }}">
                        Need Assessment</a>
                </ul>
            </div>
            <div class="ml-2">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="btn btn-info dropdown-toggle czm-a-button" data-toggle="dropdown" href="#"
                           role="button"
                           aria-haspopup="true" aria-expanded="false">Business Plan
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.business_plan.view', ['fid' => $family->id]) }}">
                                <i class="fa fa-user text-info"></i>Single</a>
                            <a class="dropdown-item py-1 px-3"
                               href="{{ route('jeebika.business_plan_joint.view', ['fid' => $family->id]) }}">
                                <i class="fa fa-users text-info"></i>Joint</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </li>
</ol>
