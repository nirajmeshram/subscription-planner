<div class="sidebar" id="sidebar">
    <h4 class="text-white text-center py-3 border-bottom text-bold">Subcription Planner</h4>
    <ul class="nav flex-column p-3">
        <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center {{ Route::currentRouteName() === 'plan.index' || Route::currentRouteName() === 'plan.edit' || Route::currentRouteName() === 'plan.create' ? 'active' : '' }}"
                href="{{ route('plan.index') }}">
                <i class="bi bi-currency-dollar me-2"></i>
                Plan
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center {{ Route::currentRouteName() === 'combo_plan.index' || Route::currentRouteName() === 'combo_plan.create' || Route::currentRouteName() === 'combo_plan.edit' ? 'active' : '' }}"
                href="{{ route('combo_plan.index') }}">
                <i class="bi bi-box me-2"></i>
                Combo Plan
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center {{ Route::currentRouteName() === 'eligibility_criteria.index' || Route::currentRouteName() === 'eligibility_criteria.create' || Route::currentRouteName() === 'eligibility_criteria.edit' ? 'active' : '' }}"
                href="{{ route('eligibility_criteria.index') }}">
                <i class="bi bi-database-add me-2"></i> Eligibility Criteria
            </a>
        </li>
    </ul>
</div>
