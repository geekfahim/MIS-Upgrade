<div class="card card-accent-info">
    <div class="card-header">
        <i class="fa fa-list"></i>
        <strong>{{ $gro->name ?? 'Gro' }}</strong> Information
    </div>
    <div class="card-body">
        <table class="table table-sm table-striped table-hover">
            <tbody>
            <tr>
                <td class="font-weight-bold">Gro Name:</td>
                <td>{{ $gro->name }}</td>
                <td class="font-weight-bold">Reference Id:</td>
                <td>{{ $gro->reference_id }}</td>
                <td class="font-weight-bold">Project Name:</td>
                <td>{{ $gro->j_project?$gro->j_project->name:'' }}</td>
                <td class="font-weight-bold">Project Manager Name:</td>
                <td>{{ $gro->j_project->manager?$gro->j_project->manager->name:'' }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">District:</td>
                <td>{{ $gro->j_project->district?$gro->j_project->district->name:'' }}</td>
                <td class="font-weight-bold">Zone Name:</td>
                <td>{{ $gro->j_project->j_zone?$gro->j_project->j_zone->name:'' }}</td>
                <td class="font-weight-bold">Area Name:</td>
                <td>{{ $gro->j_project->j_area?$gro->j_project->j_area->name:'' }}</td>
                <td class="font-weight-bold">Leader Name:</td>
                <td>{{ $gro->leader?$gro->leader->name:'' }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Cashier Name:</td>
                <td>{{ $gro->cashier?$gro->cashier->name:'' }}</td>
                <td class="font-weight-bold">Number of Family:</td>
                <td>{{ $gro->number_of_family }}</td>
                <td class="font-weight-bold">Account Holder Name:</td>
                <td>{{ $gro->bank_account_name }}</td>
                <td class="font-weight-bold">Bank Name:</td>
                <td>{{ $gro->bank?$gro->bank->name:'' }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Bank Account Branch Name:</td>
                <td>{{ $gro->bank_branch_name }}</td>
                <td class="font-weight-bold">Bank Account Number:</td>
                <td colspan="5">{{ $gro->bank_account_number }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
