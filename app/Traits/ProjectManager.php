<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ProjectManager
{
    /**
     * Scope a query to only include project manager users.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeProjectManager(Builder $query): Builder
    {
        return $query->when(session('s_j_project_id'), fn($builder) => $builder->where('j_project_id', session('s_j_project_id')));
    }
}
