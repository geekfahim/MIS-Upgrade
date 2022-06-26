<div class="row no-gutters">
    <div class="col-12">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Jeebika</li>
            <li class="breadcrumb-item"><a href="{{ route('jeebika.gro.view') }}">GROs</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('jeebika.gro.view__details',['id'=>$bp->j_gro->id]) }}">{{ $bp->j_gro->name }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route("jeebika.business_plan_approve.view",['gid'=>$bp->j_gro->id]) }}">Business
                    Plan Approve</a></li>
            <li class="breadcrumb-item active">{{ $bp->business_name }}</li>
            <!-- new -->
            <li class="breadcrumb-menu">
                <div class="btn-group" role="group" aria-label="Button group">
                    <ul class="nav navbar-nav ml-auto">
                        <a class="btn btn-dark czm-a-button px-3" role="button"
                           href="{{ route("jeebika.business_plan_approve.view",['gid'=>$bp->j_gro->id]) }}">
                            Back</a>
                    </ul>
                    <div class="ml-2">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="btn btn-info dropdown-toggle czm-a-button" data-toggle="dropdown" href="#"
                                   role="button"
                                   aria-haspopup="true" aria-expanded="false">Feedbacks
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item py-1 px-3"
                                       href="{{ route("jeebika.feedback_verification.view",['gid'=>$bp->j_gro->id,'bpid'=>$bp->id]) }}">
                                        <i class="fa fa-money text-info"></i>Verification</a>
                                    <a class="dropdown-item py-1 px-3"
                                       href="{{ route("jeebika.feedback_visit.view",['gid'=>$bp->j_gro->id,'bpid'=>$bp->id]) }}">
                                        <i class="fa fa-money text-info"></i>Visit</a>
                                    <a class="dropdown-item py-1 px-3"
                                       href="{{ route("jeebika.feedback_final.view",['gid'=>$bp->j_gro->id,'bpid'=>$bp->id]) }}">
                                        <i class="fa fa-money text-info"></i>Final Feedback</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ol>
    </div>
</div>
