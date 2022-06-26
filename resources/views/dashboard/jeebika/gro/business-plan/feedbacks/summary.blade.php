<div class="card card-accent-info">
    <div class="card-header">
        <i class="fa fa-list"></i>
        <strong>{{ $bp->family->name }}'s</strong> Business Plan
    </div>
    <div class="card-body">
        <table class="table table-sm table-striped table-hover">
            <tbody>
            <tr>
                <td class="font-weight-bold">Business Plan Name:</td>
                <td>{{ $bp->business_name }}</td>
                <td class="font-weight-bold">Business Type:</td>
                <td>{{ $bp->j_investment_area ? $bp->j_investment_area->name : '' }}</td>
                <td class="font-weight-bold">Business Duration(Month):</td>
                <td>{{ $bp->business_duration }}</td>
                <td class="font-weight-bold">Business Seed Money:</td>
                <td>{{ $bp->business_seed_money }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Gro Meeting Date:</td>
                <td>{{ \Carbon\Carbon::parse($bp->meeting_date)->format('d M Y') }}</td>
                <td class="font-weight-bold">Gro Meeting Decision:</td>
                <td>
                    @if('Pending' === $bp->meeting_status->value)
                        <span class="badge badge-warning">Pending</span>
                    @elseif( 'Hold' === $bp->meeting_status->value)
                        <span class="badge badge-dark">Hold</span>
                    @elseif( 'Approved'=== $bp->meeting_status->value)
                        <span class="badge badge-primary">Approved</span>
                    @elseif( 'Rejected' === $bp->meeting_status->value)
                        <span class="badge badge-danger">Rejected</span>
                    @else
                        <span class="text-capitalize">{{ $bp->meeting_status->value }}</span>
                    @endif
                </td>
                <td class="font-weight-bold">Approved Amount:</td>
                <td colspan="3">{{ $bp->approved_amount }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Disbursement Date:</td>
                <td>{{ \Carbon\Carbon::parse($bp->disbursement_date)->format('d M Y') }}</td>
                <td class="font-weight-bold">Disbursement Amount:</td>
                <td>{{ $bp->disbursement_amount }}</td>
                <td class="font-weight-bold">Approved Investment Return Type:</td>
                <td colspan="3">{{ $bp->approved_investment_return_type?$bp->approved_investment_return_type->value:'' }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
