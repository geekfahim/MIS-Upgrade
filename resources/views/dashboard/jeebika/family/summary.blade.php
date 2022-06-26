<div class="card card-accent-info">
    <div class="card-header">
        <i class="fa fa-list"></i>
        <strong>{{ $family->name ?? 'Family' }}</strong> Information
    </div>
    <div class="card-body">
        <div class="row no-gutters">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <table class="table table-stripe table-sm table-striped table-hover">
                    <thead>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Relation with Head</th>
                    <th>Disability</th>
                    <th>Mobile</th>
                    </thead>
                    <tbody>
                    @if (isset($family->members) && !is_null($family->members))
                        @foreach ($family->members as $key => $member)
                            <tr>
                                <td class="text-capitalize">{{ $member->mustahiq ? $member->mustahiq->name : '' }}</td>
                                <td>{{ $member->mustahiq->gender->value }}</td>
                                <td>{{ $member->mustahiq ? $member->mustahiq->age : '' }}</td>
                                <td>{{ $member->relation_with_family_head }}</td>
                                <td>
                                    @if ($member->mustahiq->disability_id)
                                        <span
                                            class="text-capitalize text-danger">{{ $member->mustahiq->disability->name }}</span>
                                    @else <span class="text-success">Not Disable</span>
                                    @endif
                                </td>
                                <td>{{ $member->mustahiq->mobile }}</td>
                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
