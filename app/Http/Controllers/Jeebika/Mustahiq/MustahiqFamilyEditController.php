<?php

namespace App\Http\Controllers\Jeebika\Mustahiq;

use App\Enums\FamilyRelationType;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Validators\MustahiqFamilyCreateValidator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MustahiqFamilyEditController extends Controller
{
    public function index(): Renderable
    {
        request()->validate(['fid' => ['required', Rule::exists(Family::getTableName(), 'id')]]);
        $family = Family::with([
            'members' => function ($builder) {
                $builder->with('mustahiq:id,name')->select(['family_id', 'mustahiq_id', 'relation_with_family_head']);
            },
            'members_info' => function ($builder) {
                $builder->with(['details', 'member', 'resource', 'vocational_needs', 'vocational_haves', 'skill_needs', 'skill_haves']);
            },
        ])->find(request('fid'));
        return view('dashboard.jeebika.mustahiq.edit-mustahiq-family', compact('family'));
    }

    public function createAMember($id): JsonResponse
    {
        $attributes = (new MustahiqFamilyCreateValidator())->validateSingleMustahiq(\request()->all());
        if (FamilyRelationType::Self->value == $attributes['relation_with_family_head']) {
            return response()->json(["message" => "Family head already selected. Please select different relation."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $family = Family::findOrFail($id);
        $family->number_of_family_member += 1;
        $mustahiq = DB::transaction(function () use ($attributes, $family) {
            $mustahiq = Mustahiq::createOrUpdateMustahiq(true, $attributes, $attributes['created_by'], $family->head->sponsor_id);
            $family->save();
            $family->members()->create([
                'mustahiq_id' => $mustahiq->id,
                'relation_with_family_head' => $attributes['relation_with_family_head'],
                'created_by' => $attributes['created_by'],
                'created_at' => now(),
            ]);
            return $mustahiq;
        });
        return response()->json(['success' => $mustahiq->name . ' has been successfully created.'], Response::HTTP_OK);
    }

    public function updateAMember($id): JsonResponse
    {
        $attributes = (new MustahiqFamilyCreateValidator())->validateSingleMustahiq(\request()->all(), false);
        $family = Family::findOrFail($id);
        $mustahiq = Mustahiq::findOrFail($attributes['id']);
        $updatedMustahiq = DB::transaction(function () use ($attributes, $mustahiq, $family) {
            $updatedMustahiq = Mustahiq::createOrUpdateMustahiq(false, $attributes, $attributes['updated_by']);
            if ($family->family_head_id == $mustahiq->id && $family->head->name != $mustahiq->name) {
                $family->name = $updatedMustahiq->name . "'s family";
                $family->save();
            }
            return $updatedMustahiq;
        });
        return response()->json(['success' => $updatedMustahiq->name . ' has been successfully updated.'], Response::HTTP_OK);
    }
}
