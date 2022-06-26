<?php

namespace App\Models\Base\Mustahiq;

use App\Enums\Evaluation;
use App\Enums\MustahiqBloodGroup;
use App\Enums\MustahiqGender;
use App\Enums\MustahiqReligion;
use App\Enums\MustahiqStatus;
use App\Enums\OriginProgram;
use App\Models\Base\Family\FamilyMember;
use App\Models\Base\Settings\Disability;
use App\Models\Base\Settings\Disease;
use App\Models\Base\Settings\District;
use App\Models\Base\Settings\Occupation;
use App\Models\Base\Settings\Sponsor;
use App\Models\Base\Settings\Union;
use App\Models\Base\Settings\Upazila;
use App\Models\File;
use App\Models\Jeebika\HealthSession\JHealthSession;
use App\Models\Jeebika\HealthSession\JHealthSessionFeedback;
use App\Models\Jeebika\HealthSession\JHealthSessionParticipant;
use App\Models\Jeebika\Training\JTraining;
use App\Models\Jeebika\Training\JTrainingFeedback;
use App\Models\Jeebika\Training\JTrainingMustahiq;
use App\Traits\CommonTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mustahiq extends Model
{
    use CommonTrait, HasFactory, SoftDeletes;

    const RESOURCE_PATH = 'mustahiq';

    protected $casts = [
        'gender'                      => MustahiqGender::class,
        'religion'                    => MustahiqReligion::class,
        'blood_group'                 => MustahiqBloodGroup::class,
        'is_disability'               => 'int',
        'is_disease'                  => 'int',
        'is_disease_regular_medicine' => 'int',
        'mobile'                      => 'int',
        'alternate_mobile'            => 'int',
        'emergency_mobile'            => 'int',
        'is_permanent_as_present'     => 'int',
        'status'                      => MustahiqStatus::class,
        'origin_program'              => OriginProgram::class,
        'birth_date'                  => 'date:Y-m-d',
        'created_at'                  => 'immutable_date:Y-m-d',
        'updated_at'                  => 'immutable_date:Y-m-d',
    ];
    protected $appends = ['age'];

    public static function createOrUpdateMustahiq(bool $isCreate, array $attributes, $operationBy = null, $sponsor_id = null, $evaluation = null): self
    {
        $operationBy ??= auth()->id();
        $birthDate = (1 == $attributes['is_birth_date']) ? $attributes['birth_date'] : (Carbon::now()->copy()->year - (int)$attributes['age']) . '-01-01';
        $personal = [
            'name'                        => $attributes['name'],
            'gender'                      => $attributes['gender'],
            'birth_date'                  => $birthDate,
            'religion'                    => $attributes['religion'],
            'blood_group'                 => $attributes['blood_group'],
            'email'                       => $attributes['email'],
            'nid'                         => $attributes['nid'],
            'passport'                    => $attributes['passport'],
            'birth_certificate'           => $attributes['birth_certificate'],
            'is_disability'               => $attributes['is_disability'],
            'disability_id'               => (1 == $attributes['is_disability'] && $attributes['disability_id']) ? $attributes['disability_id'] : null,
            'is_disease'                  => $attributes['is_disease'],
            'disease_id'                  => (1 == $attributes['is_disease'] && $attributes['disease_id']) ? $attributes['disease_id'] : null,
            'is_disease_regular_medicine' => (1 == $attributes['is_disease'] && $attributes['is_disease_regular_medicine']),
            'reference_number'            => $attributes['reference_number'],
            'mobile'                      => $attributes['mobile'],
            'alternate_mobile'            => $attributes['alternate_mobile'],
            'emergency_mobile'            => $attributes['emergency_mobile'],
            'permanent_address'           => $attributes['permanent_address'],
            'is_permanent_as_present'     => $attributes['is_permanent_as_present'],
            'permanent_district_id'       => (1 == $attributes['is_permanent_as_present'] && $attributes['present_district_id']) ? $attributes['present_district_id'] : ($attributes['permanent_district_id'] ?? null),
            'permanent_upazila_id'        => (1 == $attributes['is_permanent_as_present'] && $attributes['present_upazila_id']) ? $attributes['present_upazila_id'] : ($attributes['permanent_upazila_id'] ?? null),
            'permanent_union_id'          => (1 == $attributes['is_permanent_as_present'] && $attributes['present_union_id']) ? $attributes['present_union_id'] : ($attributes['permanent_union_id'] ?? null),
            'permanent_post_code'         => $attributes['permanent_post_code'],
            'remarks'                     => $attributes['remarks'],
        ];
        $personalDetail = [
            'is_orphan'               => $attributes['is_orphan'],
            'orphan_type'             => $attributes['orphan_type'],
            'pregnancy_status'        => $attributes['pregnancy_status'],
            'father_name'             => $attributes['father_name'],
            'father_living_status'    => $attributes['father_living_status'],
            'father_mobile'           => $attributes['father_mobile'],
            'mother_name'             => $attributes['mother_name'],
            'mother_living_status'    => $attributes['mother_living_status'],
            'mother_mobile'           => $attributes['mother_mobile'],
            'marital_status'          => $attributes['marital_status'],
            'spouse_name'             => $attributes['spouse_name'],
            'spouse_living_status'    => $attributes['spouse_living_status'],
            'spouse_mobile'           => $attributes['spouse_mobile'],
            'highest_education_level' => $attributes['highest_education_level'],
            'is_earn_ability'         => $attributes['is_earn_ability'],
            'occupation_id'           => $attributes['occupation_id'] ?? null,
            'monthly_income'          => $attributes['monthly_income'] ?? 0,
            'present_address'         => $attributes['present_address'],
            'present_district_id'     => $attributes['present_district_id'] ?? null,
            'present_upazila_id'      => $attributes['present_upazila_id'] ?? null,
            'present_union_id'        => $attributes['present_union_id'] ?? null,
            'present_post_code'       => $attributes['present_post_code'],
        ];
        if ($isCreate) {
            $personal['origin_program'] = OriginProgram::JEEBIKA->value;
            $personal['sponsor_id'] = $sponsor_id;
            $personal['status'] = MustahiqStatus::Inactive->value;
            $personal['created_by'] = $operationBy;
            $personal['created_at'] = now();
            $personal['updated_by'] = null;
            $personal['updated_at'] = null;
            $personalDetail['evaluation'] = $evaluation ?? Evaluation::First;
            $mustahiq = self::create($personal);
            $mustahiq->details()->create($personalDetail);
        } else {
            $mustahiq = self::find($attributes['id']);
            $personal['updated_by'] = $operationBy;
            $personal['updated_at'] = now();
            $mustahiq->update($personal);
            $mustahiq->details()->update($personalDetail);
            $mustahiq->vocationals() && $mustahiq->vocationals()->delete();
            $mustahiq->skills() && $mustahiq->skills()->delete();
        }
        if (isset($attributes['vocational_haves']) && !empty($attributes["vocational_haves"]) && count($attributes["vocational_haves"]) > 0) {
            foreach ($attributes["vocational_haves"] as $id) {
                $mustahiq->vocationals()->create(['vocational_id' => $id, 'is_have' => 1]);
            }
        }
        if (isset($attributes['vocational_needs']) && !empty($attributes["vocational_needs"]) && count($attributes["vocational_needs"]) > 0) {
            foreach ($attributes["vocational_needs"] as $id) {
                $mustahiq->vocationals()->create(['vocational_id' => $id]);
            }
        }
        if (isset($attributes['skill_haves']) && !empty($attributes["skill_haves"]) && count($attributes["skill_haves"]) > 0) {
            foreach ($attributes["skill_haves"] as $id) {
                $mustahiq->skills()->create(['skill_id' => $id, 'is_have' => 1]);
            }
        }
        if (isset($attributes['skill_needs']) && !empty($attributes["skill_needs"]) && count($attributes["skill_needs"]) > 0) {
            foreach ($attributes["skill_needs"] as $id) {
                $mustahiq->skills()->create(['skill_id' => $id]);
            }
        }
        if (isset($attributes['picture']) && !empty($attributes['picture']) && is_file($attributes['picture'])) {
            $mustahiq->resource()->first() && File::resourceDelete(self::RESOURCE_PATH, $mustahiq->resource()->first()->name) && $mustahiq->resource()->delete();
            $fileName = strtolower(File::getUniqueFileName() . '.' . $attributes['picture']->getClientOriginalExtension());
            $attributes['picture']->storeAs(self::RESOURCE_PATH, $fileName, 'public');
            $mustahiq->resource()->create(['path' => self::RESOURCE_PATH, 'name' => $fileName]);
        } elseif (isset($attributes['is_picture_delete']) && !empty($attributes['is_picture_delete']) && 1 == $attributes['is_picture_delete'] && $mustahiq->resource()->first()) {
            File::resourceDelete(self::RESOURCE_PATH, $mustahiq->resource()->first()->name);
            $mustahiq->resource()->first()->delete();
        }
        return $mustahiq;
    }

    public static function getAll($selected = "*", MustahiqStatus $status = MustahiqStatus::Active)
    {
        return static::select($selected)->when($status, function ($sql) use ($status) {
            $sql->where("status", $status);
        })->orderBy("name")->get();
    }

    public function details(): HasOne
    {
        return $this->hasOne(MustahiqDetail::class);
    }

    public function vocationals(): HasMany
    {
        return $this->hasMany(MustahiqVocational::class, 'mustahiq_id');
    }

    public function skills(): HasMany
    {
        return $this->hasMany(MustahiqSkill::class);
    }

    public function resource(): MorphOne
    {
        return $this->morphOne(File::class, 'resource');
    }

    public function getAgeAttribute()
    {
        if ($this->birth_date) {
            return $this->birth_date->age >= 1 ? $this->birth_date->age : 'below 1';
        }
    }

    public function member(): HasOne
    {
        return $this->hasOne(FamilyMember::class, 'mustahiq_id', 'id');
    }

    public function skill_needs(): HasMany
    {
        return $this->hasMany(MustahiqSkill::class)->where('is_have', false);
    }

    public function skill_haves(): HasMany
    {
        return $this->hasMany(MustahiqSkill::class)->where('is_have', true);
    }

    public function vocational_haves(): HasMany
    {
        return $this->hasMany(MustahiqVocational::class)->where('is_have', true);
    }

    public function vocational_needs(): HasMany
    {
        return $this->hasMany(MustahiqVocational::class)->where('is_have', false);
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function disability(): BelongsTo
    {
        return $this->belongsTo(Disability::class);
    }

    public function disease(): BelongsTo
    {
        return $this->belongsTo(Disease::class);
    }

    public function permanent_district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'permanent_district_id', 'id');
    }

    public function permanent_upazila(): BelongsTo
    {
        return $this->belongsTo(Upazila::class, 'permanent_upazila_id', 'id');
    }

    public function permanent_union(): BelongsTo
    {
        return $this->belongsTo(Union::class, 'permanent_union_id', 'id');
    }

    public function occupation(): BelongsTo
    {
        return $this->belongsTo(Occupation::class);
    }

    /*Jeebika Training Start*/
    public function j_training(): BelongsToMany
    {
        return $this->belongsToMany(JTraining::class, JTrainingMustahiq::class, 'mustahiq_id', 'j_training_id');
    }

    public function j_training_feedbacks(): HasMany
    {
        return $this->hasMany(JTrainingFeedback::class);
    }

    /*Jeebika Training End*/

    /*Health Session*/
    public function j_health_session(): BelongsToMany
    {
        return $this->belongsToMany(JHealthSession::class, JHealthSessionParticipant::class, 'mustahiq_id', 'j_health_session_id');
    }

    public function j_health_session_feedbacks(): HasMany
    {
        return $this->hasMany(JHealthSessionFeedback::class);
    }

    /*Health Session*/


}
