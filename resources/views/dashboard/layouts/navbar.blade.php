<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ route('dashboard') }}">
        <img class="navbar-brand-full" src="{{ asset('assets/images/czm/czm-logo-full.svg') }}" width="150" height="45"
             alt="CZM Logo">
        <img class="navbar-brand-minimized" src="{{ asset('assets/images/czm/czm-logo-half.svg') }}" width="40"
             height="40" alt="CZM Logo">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
               aria-expanded="false"> <i class="icon-bell"></i><span
                    class="badge badge-pill badge-danger">{{ auth()->user()->unreadNotifications()->count() }}</span>
            </a>

            @if(auth()->user()->unreadNotifications()->count())
                <div class="dropdown-menu dropdown-menu-right custom-dropdown ">
                    <div class="d-flex justify-content-between dropdown-item dropdown-title">
                        <h5>Notification</h5>
                        {{--  <a href="#"><i class="fa fa-envelope-open-o mx-1" aria-hidden="true"></i>Mark All Read</a>--}}
                    </div>
                    <div class="notification-area">
                        @foreach(auth()->user()->unreadNotifications()->get() as $notification)
                            <div class="dropdown-item">
                                <a class="" href="{{ route('notification.view',['notification'=>$notification]) }}">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="notification-title">
                                                {{ $notification->data['title'] }}
                                            </p>
                                            <p class="notification-sub-title">
                                                {{ $notification->data['message'] }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </li>
        <li class="mx-2 nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
               aria-expanded="false">
                <strong style="color: grey">{{ auth()->user()->name }}</strong>&nbsp;
                <i class="icon-user"></i>
                {{-- <img class="img-avatar" src="{{ asset('assets/images/avatars/6.png') }}"
                     alt="admin@bootstrapmaster.com"> --}}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <div class="dropdown-menu dropdown-menu-right">
                <!--                <div class="dropdown-header text-center" style="color:#23408F">
                    <strong>{{ auth()->user()->name }}</strong>
                </div>
                -->
                <a class="dropdown-item" href="{{ route('acl.profile.view') }}">
                    <i class="fa fa-user"></i> Profile</a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i> Logout</a>
                {{-- <div class="dropdown-header text-center">
                    <strong>Account</strong>
                </div>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-bell-o"></i> Updates
                    <span class="badge badge-info">42</span>
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-envelope-o"></i> Messages
                    <span class="badge badge-success">42</span>
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-tasks"></i> Tasks
                    <span class="badge badge-danger">42</span>
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-comments"></i> Comments
                    <span class="badge badge-warning">42</span>
                </a>
                <div class="dropdown-header text-center">
                    <strong>Settings</strong>
                </div>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-user"></i> Profile</a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-wrench"></i> Settings</a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-usd"></i> Payments
                    <span class="badge badge-secondary">42</span>
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-file"></i> Projects
                    <span class="badge badge-primary">42</span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-shield"></i> Lock Account</a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-lock"></i> Logout</a> --}}
            </div>
        </li>
    </ul>
</header>
