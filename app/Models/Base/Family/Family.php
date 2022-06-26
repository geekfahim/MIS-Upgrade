<?php

namespace App\Models\Base\Family;

use App\Enums\FamilyCookingFuelType;
use App\Enums\FamilyDrinkingWaterSource;
use App\Enums\FamilyElectricityConnectivityType;
use App\Enums\FamilyHeadedByType;
use App\Enums\FamilyHouseLandType;
use App\Enums\FamilyHouseLocation;
use App\Enums\FamilyHouseType;
use App\Enums\FamilyOtherWaterSource;
use App\Enums\FamilyStatus;
use App\Enums\FamilyToiletOwnershipType;
use App\Enums\FamilyToiletType;
use App\Enums\OriginProgram;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Jeebika\IGA\JBankCharge;
use App\Models\Jeebika\IGA\JFamilyBalance;
use App\Models\Jeebika\IGA\JMiscellaneous;
use App\Models\Jeebika\IGA\JSaving;
use App\Models\Jeebika\IGA\JEquity;
use App\Models\Jeebika\IGA\JSettlement;
use App\Models\Jeebika\IGA\JWithdrawal;
use App\Models\Jeebika\Jeebika;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $casts = [
        'family_headed_by'         => FamilyHeadedByType::class,
        'house_type'               => FamilyHouseType::class,
        'house_land_type'          => FamilyHouseLandType::class,
        'house_location'           => FamilyHouseLocation::class,
        'drinking_water'           => FamilyDrinkingWaterSource::class,
        'other_water'              => FamilyOtherWaterSource::class,
        'toilet_type'              => FamilyToiletType::class,
        'toilet_owner'             => FamilyToiletOwnershipType::class,
        'cooking_fuel'             => FamilyCookingFuelType::class,
        'electricity_connectivity' => FamilyElectricityConnectivityType::class,
        'status'                   => FamilyStatus::class,
        'origin_program'           => OriginProgram::class,
        'number_of_family_member'  => 'integer',
        'total_room'               => 'integer',
        'need_assessment'          => 'integer',
        'created_at'               => 'immutable_date:Y-m-d',
        'updated_at'               => 'immutable_date:Y-m-d',
    ];

    public function familyBalance(): HasOne
    {
        return $this->hasOne(JFamilyBalance::class)->withDefault(['balance' => 0]);
    }

    public function jeebika(): HasOne
    {
        return $this->hasOne(Jeebika::class, 'family_id', 'id');
    }

    public function head(): HasOne
    {
        return $this->hasOne(Mustahiq::class, "id", "family_head_id");
    }

    public function members(): HasMany
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function members_info(): HasManyThrough
    {
        return $this->hasManyThrough(Mustahiq::class, FamilyMember::class, 'family_id', 'id', 'id', 'mustahiq_id');
    }

    public function assets(): HasMany
    {
        return $this->hasMany(FamilyAsset::class);
    }

    public function savings(): HasMany
    {
        return $this->hasMany(FamilySaving::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(FamilyExpense::class);
    }

    public function incomes(): HasMany
    {
        return $this->hasMany(FamilyIncome::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(FamilyLoan::class);
    }

    public function neighbourHelps(): HasMany
    {
        return $this->hasMany(FamilyNeighbourHelp::class);
    }

    public function otherNgos(): HasMany
    {
        return $this->hasMany(FamilyOtherNgo::class);
    }

    public function richHelps(): HasMany
    {
        return $this->hasMany(FamilyRichHelp::class);
    }

    public function safeties(): HasMany
    {
        return $this->hasMany(FamilySafety::class);
    }

    public function disasters(): HasMany
    {
        return $this->hasMany(FamilyDisaster::class);
    }

    public function conflictResolves(): HasMany
    {
        return $this->hasMany(FamilyConflictResolve::class);
    }

    public function j_savings(): HasMany
    {
        return $this->hasMany(JSaving::class)->orderBy('date');
    }

    public function j_equity(): HasMany
    {
        return $this->hasMany(JEquity::class)->orderBy('date');
    }

    public function j_bank_charge(): HasMany
    {
        return $this->hasMany(JBankCharge::class)->orderBy('date');
    }

    public function j_miscellaneous(): HasMany
    {
        return $this->hasMany(JMiscellaneous::class)->orderBy('date');
    }

    public function j_withdrawal(): HasMany
    {
        return $this->hasMany(JWithdrawal::class)->orderBy('date');
    }

    public function j_settlement(): HasMany
    {
        return $this->hasMany(JSettlement::class)->orderBy('date');
    }


}
