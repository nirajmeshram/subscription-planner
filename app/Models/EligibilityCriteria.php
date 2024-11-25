<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EligibilityCriteria extends Model
{
    protected $table = 'eligibility_criterias';

    protected $fillable = [
        'name',
        'age_less_than',
        'age_greater_than',
        'last_login_days_ago',
        'income_less_than',
        'income_greater_than',
    ];


    // Relationship with plans 
    public function plans(): BelongsToMany
    {
        /**
         * Many to many relationship with the Plan model.
         * eligibility_criteria_plan - Pivot table
         * eligibility_criteria_id - Foreign key referencing the current model
         * plan_id - Foreign key referencing the Plan model
         */
        return $this->belongsToMany(Plan::class, 'eligibility_criteria_plan', 'eligibility_criteria_id', 'plan_id');
    }


    // Relationship with combo plans 
    public function combo_plans(): BelongsToMany
    {
        /**
         * Many to many relationships
         * eligibility_criteria_combo_plan - Pivot table
         * eligibility_criteria_id - foreign key refenceing current model
         * combo_plan_id - foreign key refenceing combo plan model
         */
        return $this->belongsToMany(ComboPlan::class, 'eligibility_criteria_combo_plan', 'eligibility_criteria_id', 'combo_plan_id');
    }
}
