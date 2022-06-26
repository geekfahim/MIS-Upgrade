<div class="card card-accent-info">
    <div class="card-header">
        <i class="fa fa-list"></i>
        <strong>{{ $bp->family->name }}'s</strong> Business Plan
        <div class="pull-right badge badge-success p-2 font-lg">
            Current Balance: <span class="tk">{{ $bp->familyBalance->balance }}</span>
        </div>
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
                `
            </tr>
            <tr>
                <td class="font-weight-bold">Gross Possible Income:</td>
                <td>{{ $bp->possible_gross_income }}</td>
                <td class="font-weight-bold">Gross Possible Expense:</td>
                <td>{{ $bp->possible_gross_expense }}</td>
                <td class="font-weight-bold">Investment Return Type:</td>
                <td>{{ $bp->investment_return_type->value }}</td>
                <td class="font-weight-bold">Investment Return Amount Each:</td>
                <td>{{ $bp->investment_return_amount_each }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Assist In Business:</td>
                <td>{{ $bp->business_assist }}</td>
                <td class="font-weight-bold">Business Experience(Month):</td>
                <td>{{ $bp->is_business_experience?$bp->business_experience_duration:'' }}</td>
                <td class="font-weight-bold">Business Training(Month):</td>
                <td>{{ $bp->is_business_training?$bp->business_training_duration:'' }}</td>
                <td class="font-weight-bold">Training Institute Name:</td>
                <td>{{ $bp->is_business_training?$bp->business_training_institute_name:'' }}</td>
            </tr>
            </tbody>
        </table>
        @if(\App\Enums\IGA\JBusinessPlanMeetingStatus::Pending === $bp->meeting_status  || \App\Enums\IGA\JBusinessPlanMeetingStatus::Approved === $bp->meeting_status)
            @if(count($bp->sources))
                <table class="table table-sm table-striped table-hover">
                    <caption style="padding: 0;">Source of Capital</caption>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Remarks</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bp->sources as $source)
                        <tr>
                            <td>{{ $source->source_name }}</td>
                            <td>{{ $source->source_amount }}</td>
                            <td>{{ $source->source_remarks }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
            @if(count($bp->fields))
                <table class="table table-sm table-striped table-hover">
                    <caption style="padding: 0;">Fields of Expenditure</caption>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bp->fields as $field)
                        <tr>
                            <td>{{ $field->field_name }}</td>
                            <td>{{ $field->field_unit_price }}</td>
                            <td>{{ $field->field_quantity }}</td>
                            <td>{{ $field->field_total_price }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
            @if(count($bp->risks))
                <table class="table table-sm table-striped table-hover">
                    <caption style="padding: 0;">Business Risks</caption>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Prevention</th>
                        <th>Remarks</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bp->risks as $risk)
                        <tr>
                            <td>{{ $risk->risk_name }}</td>
                            <td>{{ $risk->risk_prevention }}</td>
                            <td>{{ $risk->risk_remarks }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
            @if(isset($bp->histories) && count($bp->histories))
                <table class="table table-sm table-striped table-hover">
                    <caption style="padding: 0;">Previous Approved Business History</caption>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Business Name</th>
                        <th>Investment Received Date</th>
                        <th>Investment Field</th>
                        <th>Investment Amount</th>
                        <th>Investment Paid(BDT)</th>
                        <th>Investment Payable</th>
                        <th>Profit/Loss</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bp->histories as $history)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $history->business_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($history->disbursement_date)->format('M d, Y') }}</td>
                            <td>{{ $history->j_investment_approved_area ? $history->j_investment_approved_area->name : '' }}</td>
                            <td>{{ $history->disbursement_amount }}</td>
                            <td>{{ $history->total_amount }}</td>
                            <td>{{ $history->disbursement_amount - $history->total_amount }}</td>
                            <td>Profit/Loss</td>
                            <td>
                                @if('Pending' === $history->status->value)
                                    <span class="badge badge-warning">Pending</span>
                                @elseif( 'Hold' === $history->status->value)
                                    <span class="badge badge-dark">Hold</span>
                                @elseif( 'Approved'=== $history->status->value)
                                    <span class="badge badge-primary">Approved</span>
                                @elseif( 'Ongoing' === $history->status->value)
                                    <span class="badge badge-success">Ongoing</span>
                                @elseif( 'Completed' === $history->status->value)
                                    <span class="badge badge-secondary">Completed</span>
                                @elseif( 'Rejected' === $history->status->value)
                                    <span class="badge badge-danger">Rejected</span>
                                @else
                                    <span class="text-capitalize">{{ $history->status->value }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        @endif
    </div>
</div>
