<?php

namespace App\Http\Controllers\Jeebika\Project;

use App\Enums\JGroStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Acl\User;
use App\Models\Base\Settings\District;
use App\Models\Base\Settings\Sponsor;
use App\Models\File;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Project\JProjectFieldOfficer;
use App\Models\Jeebika\Project\JProjectSponsor;
use App\Models\Jeebika\Settings\JArea;
use App\Models\Jeebika\Settings\JZone;
use App\Models\Validators\JProjectValidator;
use Arr;
use DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JProjectController extends Controller
{
    public function index(): Renderable
    {
        if ($projectId = session('s_j_project_id')) {
            $project = JProject::find($projectId);
            return view('dashboard.jeebika.project.project-manager-view', compact('project'));
        }
        return view('dashboard.jeebika.project.project');
    }

    public function getList(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'name,status,created_at');
        $data = JProject::with(['manager:id,name', 'district:id,name'])
            ->select('id', 'name', 'manager_id', 'district_id', 'number_of_household_cover', 'status', 'start_date', 'created_at')
            ->withCount('families')
            ->when($query, function ($sql) use ($query) {
                $sql->where('name', 'LIKE', "%{$query}%");
            })
            ->orderBy($sort, $type)->paginate($item);

        return response()->json([
            'lists' => $data,
            'users' => User::getAllWithOfficeID(),
            'sponsors' => Sponsor::getAll(['id', 'name as text']),
            'districts' => District::getAll(['id', 'name as text']),
            'statuses' => JGroStatus::cases(),
            'jZones' => JZone::all(['id', 'name']),
            'jAreas' => JArea::all(['id', 'name', 'j_zone_id'])
        ], Response::HTTP_OK);
    }

    public function create(): JsonResponse
    {
        $attributes = (new JProjectValidator())->validate($JProject = new JProject(), request()->all());
        $JProject = DB::transaction(function () use ($JProject, $attributes) {
            //Creating Project
            $JProject->fill(Arr::except($attributes, ['sponsor_ids', 'field_officer_ids', 'files', 'file_remarks', 'delete_file_ids']))->save();
            //Creating Sponsors
            if (isset($attributes['sponsor_ids']) && !empty($attributes['sponsor_ids']) && count($attributes['sponsor_ids']) > 0) {
                $this->_createSponsors($JProject, $attributes['sponsor_ids']);
            }
            //Creating Field Officers
            if (isset($attributes['field_officer_ids']) && !empty($attributes['field_officer_ids']) && count($attributes['field_officer_ids']) > 0) {
                $this->_createFieldOfficers($JProject, $attributes['field_officer_ids']);
            }
            //Creating Files
            if (isset($attributes['files']) && !empty($attributes['files']) && count($attributes['files']) > 0) {
                $this->_createResource($JProject, $attributes);
            }
            return $JProject;
        });
        return response()->json(['success' => $JProject->name . ' has been successfully created.'], Response::HTTP_OK);
    }

    private function _createSponsors(JProject $JProject, $sids)
    {
        foreach ($sids as $sid) {
            $sponsor = Sponsor::find($sid);
            $JProject->sponsors()->create([
                'sponsor_id' => $sponsor->id,
                'created_by' => \request('created_by'),
                'created_at' => now(),
            ]);
        }
    }

    private function _createFieldOfficers(JProject $JProject, $foids)
    {
        foreach ($foids as $foid) {
            $fieldOfficer = User::find($foid);
            $JProject->field_officers()->create([
                'officer_id' => $fieldOfficer->id,
                'created_by' => \request('created_by'),
                'created_at' => now(),
            ]);
        }
    }

    private function _createResource(JProject $JProject, $attributes)
    {
        for ($i = 0; $i < count($attributes['files']); $i++) {
            list($file, $remarks) = [$attributes['files'][$i], $attributes['file_remarks'][$i]];
            $fileName = strtolower(File::getUniqueFileName() . '.' . $file->getClientOriginalExtension());
            $file->storeAs($JProject::RESOURCE_PATH, $fileName, 'public');
            $JProject->resource()->create(['path' => $JProject::RESOURCE_PATH, 'name' => $fileName, 'remarks' => $remarks]);
        }
    }

    public function getElementById($id): JsonResponse
    {
        $item = JProject::with('resource')
            ->select('id', 'name', 'manager_id', 'district_id', 'number_of_household_cover', 'start_date', 'end_date', 'status', 'remarks', 'j_zone_id', 'j_area_id')
            ->findOrFail($id);
        $item['sponsor_ids'] = JProjectSponsor::where("j_project_id", $id)->get()->pluck('sponsor_id');
        $item['field_officer_ids'] = JProjectFieldOfficer::where("j_project_id", $id)->get()->pluck('officer_id');
        $item = removeEmptyKey($item);
        return response()->json($item, Response::HTTP_OK);
    }

    public function update($id): JsonResponse
    {
        $JProject = JProject::findOrFail($id);
        $attributes = (new JProjectValidator())->validate($JProject, request()->all());
        $JProject = DB::transaction(function () use ($JProject, $attributes) {
            //Updating Project
            $JProject->fill(Arr::except($attributes, ['sponsor_ids', 'field_officer_ids', 'files', 'file_remarks', 'delete_file_ids']))->save();
            //Creating New Sponsors
            $existingSponsorIds = $JProject->sponsors()->pluck('sponsor_id')->all();
            $deleteSponsorIds = array_diff($existingSponsorIds, $attributes['sponsor_ids']);
            $createSponsorIds = array_diff($attributes['sponsor_ids'], $existingSponsorIds);
            $this->_createSponsors($JProject, $createSponsorIds);
            //Deleting Old Sponsors
            $JProject->sponsors()->whereIn('sponsor_id', $deleteSponsorIds)->delete();

            //Updating Field Officers
            $existingFieldOfficerIds = $JProject->field_officers()->pluck('officer_id')->all();
            $deleteFieldOfficerIds = array_diff($existingFieldOfficerIds, $attributes['field_officer_ids']);
            $createFieldOfficerIds = array_diff($attributes['field_officer_ids'], $existingFieldOfficerIds);
            //Creating New Field Officers
            $this->_createFieldOfficers($JProject, $createFieldOfficerIds);
            //Deleting Old Field Officers
            $JProject->field_officers()->whereIn('officer_id', $deleteFieldOfficerIds)->delete();

            //Creating New Files
            if (isset($attributes['files']) && !empty($attributes['files']) && count($attributes['files']) > 0) {
                $this->_createResource($JProject, $attributes);
            }
            //Deleting Deleted Files
            if (isset($attributes['delete_file_ids']) && !empty($attributes['delete_file_ids']) && count($attributes['delete_file_ids']) > 0) {
                foreach ($attributes['delete_file_ids'] as $id) {
                    $file = File::find($id);
                    File::resourceDelete($file->getRawOriginal('path'), $file->name);
                    $file->delete();
                }
            }
            return $JProject;
        });
        return response()->json(['success' => $JProject->name . ' has been successfully updated.'], Response::HTTP_OK);
    }

    public function viewById($id): Renderable
    {
        $project = JProject::findOrFail($id);
        return view('dashboard.jeebika.project.view', compact('project'));
    }
}
