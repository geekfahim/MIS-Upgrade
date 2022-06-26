<div class="card card-accent-info">
    <div class="card-header">
        <i class="fa fa-list"></i>
        <strong>{{ $project->name??'Project' }}</strong> Information
    </div>
    <div class="card-body">
        <table class="table table-sm table-striped table-hover" style="table-layout: fixed">
            <tbody>
            <tr>
                <td class="font-weight-bold">Name:</td>
                <td>{{$project->name}}</td>
                <td class="font-weight-bold">Manager Name:</td>
                <td>{{$project->manager?$project->manager->name:''}}</td>
                <td class="font-weight-bold">Status:</td>
                <td>
                    @if ('Active'===$project->status->value)
                        <span class="badge bg-success">Active</span>
                    @elseif('Inactive'===$project->status->value)
                        <span class="badge bg-warning">Inactive</span>
                    @elseif('Blocked'===$project->status->value)
                        <span class="badge bg-danger">Blocked</span>
                    @else
                        <span class="text-capitalize">{{ $project->status->value }}</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold">District Name:</td>
                <td>{{$project->district?$project->district->name:''}}</td>
                <td class="font-weight-bold">Zone Name:</td>
                <td>{{$project->j_zone?$project->j_zone->name:''}}</td>
                <td class="font-weight-bold">Area Name:</td>
                <td>{{$project->j_area?$project->j_area->name:''}}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Start Date:</td>
                <td>{{$project->start_date->format('d-M-Y')}}</td>
                <td class="font-weight-bold">Possible End Date:</td>
                <td>{{$project->end_date->format('d-M-Y')}}</td>
                <td class="font-weight-bold">Household Cover:</td>
                <td>{{$project->number_of_household_cover}}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Remarks:</td>
                <td colspan="5">{{$project->remarks}}</td>
            </tr>
            @if ($project->resource)
                @foreach($project->resource as $resource)
                    <tr>
                        <td class="font-weight-bold">File:</td>
                        <td colspan="5" style="word-wrap: break-word">
                            <a download="{{ $resource->name }}" href="{{ $resource->path }}"
                               target="_blank"
                               class="badge bg-success text-capitalize">Download</a>
                            @if($resource->remarks)
                                <span>({{ $resource->remarks }})</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
