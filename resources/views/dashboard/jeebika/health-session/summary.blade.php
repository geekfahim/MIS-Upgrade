<div class="card card-accent-info">
    <div class="card-header">
        <i class="fa fa-list"></i>
        <strong>{{ $data->session_heading??'Health Session' }}</strong> Information
    </div>
    <div class="card-body">
        <table class="table table-sm table-striped table-hover" style="table-layout: fixed">
            <tbody>
            <tr>
                <td class="font-weight-bold">Project Name:</td>
                <td>{{$data->j_project?$data->j_project->name:''}}</td>
                <td class="font-weight-bold">Session Name:</td>
                <td>{{$data->session_heading}}</td>
                <td class="font-weight-bold">Status:</td>
                <td>
                    @if ('Upcoming'===$data->status->value)
                        <span class="badge bg-warning">Upcoming</span>
                    @elseif('Complete'===$data->status->value)
                        <span class="badge bg-success">Complete</span>
                    @elseif('Postponed'===$data->status->value)
                        <span class="badge bg-primary">Postponed</span>
                    @elseif('Rejected'===$data->status->value)
                        <span class="badge bg-danger">Rejected</span>
                    @else
                        <span style="color: #e55353"><i class="fa fa-exclamation-triangle"></i></span>
                    @endif
                </td>
                <td class="font-weight-bold">Session Method:</td>
                <td>
                    <span
                        class="badge bg-primary">{{$data->session_method}}</span>
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold">Resource Person:</td>
                <td>{{$data->resource_person_name}}</td>
                <td class="font-weight-bold">Resource Phone:</td>
                <td>{{$data->resource_person_phone}}</td>
                <td class="font-weight-bold">Resource Designation:</td>
                <td colspan="3">{{$data->resource_person_designation}}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Remarks:</td>
                <td colspan="7">{{$data->remarks}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
