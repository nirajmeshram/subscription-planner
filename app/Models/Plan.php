<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plan extends Model
{
    protected $fillable = ['name', 'price'];

    // Relationship with combo plans

    public function combo_plans(): BelongsToMany
    {
        /**
         * Many to many relationships
         * combo_plan_item - Pivot table
         * plan_id - foreign key refenceing current model
         * combo_plan_id - foreign key refenceing combo plan model
         */

        return $this->belongsToMany(ComboPlan::class, 'combo_plan_item', 'plan_id', 'combo_plan_id');
    }

    // Relationship with eligibility_criterias
    public function eligibility_criterias(): BelongsToMany
    {
        /**
         * Many to many relationships
         * combo_plan_item - Pivot table
         * eligibility_criteria_id - foreign key refenceing current model
         * plan_id - foreign key refenceing combo plan model
         */

        return $this->belongsToMany(EligibilityCriteria::class, 'eligibility_criteria_plan', 'eligibility_criteria_id', 'plan_id');
    }
}
