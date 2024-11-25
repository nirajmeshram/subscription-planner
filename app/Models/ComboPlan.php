<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComboPlan extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'price'];

    // Relationship with plans
    public function plans(): BelongsToMany
    {
        /**
         * Many to many relationships
         * combo_plan_item - Pivot table
         * combo_plan_id - foreign key refenceing current model
         * plan_id - foreign key refenceing combo plan model
         */

        return $this->belongsToMany(Plan::class, 'combo_plan_item', 'combo_plan_id', 'plan_id');
    }

    // Relationship with plans to associate combo plans with plans
    public function eligibility_criterias(): BelongsToMany
    {
        /**
         * Many to many relationships
         * eligibility_criteria_combo_plan - Pivot table
         * combo_plan_id - foreign key refenceing current model
         * eligibility_criteria_id - foreign key refenceing combo plan model
         */
        return $this->belongsToMany(EligibilityCriteria::class, 'eligibility_criteria_combo_plan', 'combo_plan_id', 'eligibility_criteria_id');
    }
}
