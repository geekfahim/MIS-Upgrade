<?php

use App\Enums\FamilyStatus;
use App\Enums\MustahiqStatus;
use App\Enums\OriginProgram;
use App\Models\Base\Family\FamilyMember;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Jeebika\Jeebika;

if (!function_exists('getIndicatorProgramTypes')) {
    function getIndicatorProgramTypes(): array
    {
        return [
            ['key' => OriginProgram::JEEBIKA->name, 'sequence' => 1],
            ['key' => OriginProgram::INSANIAT->name, 'sequence' => 2],
            ['key' => OriginProgram::FERDOUSI->name, 'sequence' => 3],
            ['key' => OriginProgram::NAIPUNNABIKASH->value, 'sequence' => 4],
            ['key' => OriginProgram::GULBAGICHA->name, 'sequence' => 5],
            ['key' => 'EPIDEMIC', 'sequence' => 6],
            ['key' => 'DISASTER', 'sequence' => 7],
        ];
    }
}
if (!function_exists('getIndicatorProgramTypesOnlyNames')) {
    function getIndicatorProgramTypesOnlyNames(): array
    {
        return collect(getIndicatorProgramTypes())->map(fn($item) => $item['key'])->all();
    }
}
if (!function_exists('getOccupationNameByMustahiqId')) {
    function getOccupationNameByMustahiqId($id): string
    {
        if (!$id) return '';
        $mustahiq = Mustahiq::find($id);
        return $mustahiq->details->occupation->name ?: '';
    }
}
if (!function_exists('getTotalMemberCount')) {
    function getTotalMemberCount($projectId = null, $groId = null, $familyId = null, int $earnAbility = null, int $disability = null): int
    {
        $ids = [];
        $jeebikas = Jeebika::whereRelation('family', 'status', FamilyStatus::Active)
            ->when($projectId, fn($builder) => $builder->where('j_project_id', $projectId))
            ->when($groId, fn($builder) => $builder->where('j_gro_id', $groId))
            ->when($familyId, fn($builder) => $builder->where('family_id', $familyId))
            ->get();

        foreach ($jeebikas as $item) {
            foreach ($item->family->members_info as $mustahiq) {
                $ids[] = $mustahiq->id;
            }
        }
        return Mustahiq::with(['details' => function ($builder) use ($earnAbility) {
            $builder->when(null != $earnAbility && 0 == $earnAbility, fn($builder1) => $builder1->where('is_earn_ability', 0))
                ->when(1 == $earnAbility, fn($builder1) => $builder1->where('is_earn_ability', 1));
        }])->when(null != $disability && 0 == $disability, fn($builder) => $builder->where('is_disability', 0))
            ->when(1 == $disability, fn($builder) => $builder->where('is_disability', 1))
            ->whereIn('id', $ids)->count();
    }
}

if (!function_exists('getUnproductiveFamily')) {
    function getUnproductiveFamily($earnAbility = null)
    {
        $mustahiqs = Mustahiq::whereRelation('details', 'is_earn_ability', 1)
            ->whereStatus(MustahiqStatus::Active->value)
            ->pluck('id');
        return FamilyMember::whereIn('mustahiq_id', $mustahiqs)->distinct()->count('family_id');
        dd($familyMember);
    }
}
