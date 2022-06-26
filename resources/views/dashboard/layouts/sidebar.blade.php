<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="nav-icon icon-speedometer"></i> Dashboard
                </a>
            </li>
            <li class="nav-title">Jeebika</li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('jeebika.family_validation.view') }}">
                    <i class="nav-icon icon-check"></i> Validation
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('jeebika.training.view') }}">
                    <i class="nav-icon icon-trophy"></i> Training
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('jeebika.health_session.view') }}">
                    <i class="nav-icon fa fa-medkit"></i> Health Session
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('jeebika.project.view') }}">
                    <i class="nav-icon icon-layers"></i> Projects
                </a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" style="cursor: pointer">
                    <i class="nav-icon icon-pin" aria-hidden="true"></i> Mustahiq</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('jeebika.mustahiq_family_create.view') }}">
                            <i class="nav-icon icon-plus" aria-hidden="true"></i>Add Mustahiq</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('jeebika.mustahiq_view.view__list') }}">
                            <i class="nav-icon icon-list" aria-hidden="true"></i>View Mustahiq</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('jeebika.gro.view') }}">
                    <i class="nav-icon icon-list"></i> GROs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('jeebika.family.view') }}">
                    <i class="nav-icon icon-list"></i> Families
                </a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" style="cursor: pointer">
                    <i class="nav-icon icon-docs" aria-hidden="true"></i> Reports</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('reports.statistic.view') }}">
                            <i class="nav-icon icon-doc"></i> Statistics</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('reports.mustahiq.view') }}">
                            <i class="nav-icon icon-doc"></i> Mustahiq Reports</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('reports.family.view') }}">
                            <i class="nav-icon icon-doc"></i> Family Reports</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('reports.gro.view') }}">
                            <i class="nav-icon icon-doc"></i> Gro Reports</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('reports.project.view') }}">
                            <i class="nav-icon icon-doc"></i> Project Reports</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('reports.training.view') }}">
                            <i class="nav-icon icon-doc"></i> Training Reports</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('reports.health_session.view') }}">
                            <i class="nav-icon icon-doc"></i> Health Session Reports</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" style="cursor: pointer">
                    <i class="nav-icon icon-settings" aria-hidden="true"></i> Settings</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.zone.view') }}">
                            <i class="nav-icon icon-list"></i> Zone</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.area.view') }}">
                            <i class="nav-icon icon-list"></i> Area</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.indicator.view') }}">
                            <i class="nav-icon icon-list"></i> Indicator</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.investment_area.view') }}">
                            <i class="nav-icon icon-list"></i> Investment Area</a>
                    </li>
                </ul>
            </li>
            <li class="nav-title">Base</li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" style="cursor: pointer">
                    <i class="nav-icon icon-people"></i>All Mustahiq</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('allmustahiq.information.view') }}">
                            <i class="nav-icon icon-list"></i> View All Mustahiq</a>
                    </li>
                </ul>
                <ul class="nav-dropdown-items">
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('allmustahiq.report.view') }}">
                            <i class="nav-icon icon-docs" aria-hidden="true"></i>Reports All Mustahiq</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" style="cursor: pointer">
                    <i class="nav-icon icon-settings" aria-hidden="true"></i> Settings</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.sponsor.view') }}">
                            <i class="nav-icon icon-plus"></i> Sponsors</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.district.view') }}">
                            <i class="nav-icon icon-plus"></i> Districts</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.upazila.view') }}">
                            <i class="nav-icon icon-plus"></i> Upazilas</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.union.view') }}">
                            <i class="nav-icon icon-plus"></i> Unions</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.bank.view') }}">
                            <i class="nav-icon icon-plus"></i> Banks</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.disability.view') }}">
                            <i class="nav-icon icon-plus"></i> Disability</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.occupation.view') }}">
                            <i class="nav-icon icon-plus"></i> Occupation</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.disease.view') }}">
                            <i class="nav-icon icon-plus"></i> Disease</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.asset.view') }}">
                            <i class="nav-icon icon-plus"></i> Asset</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.income.view') }}">
                            <i class="nav-icon icon-plus"></i> Income</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.disaster.view') }}">
                            <i class="nav-icon icon-plus"></i> Disaster</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.recover.view') }}">
                            <i class="nav-icon icon-plus"></i> Recover</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.vocational.view') }}">
                            <i class="nav-icon icon-plus"></i> Vocational Training</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('settings.skill.view') }}">
                            <i class="nav-icon icon-plus"></i> Skill Training</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" style="cursor: pointer">
                    <i class="nav-icon icon-settings" aria-hidden="true"></i> ACL</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('acl.user.view') }}">
                            <i class="nav-icon icon-user"></i> User</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('acl.role.view') }}">
                            <i class="nav-icon icon-user"></i> Role</a>
                    </li>
                    <li class="nav-item" style="padding: 0 5px">
                        <a class="nav-link" href="{{ route('acl.role_assign.view') }}">
                            <i class="nav-icon icon-user"></i> Role Assign</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
