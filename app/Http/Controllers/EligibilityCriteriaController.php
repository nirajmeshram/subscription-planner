<?php

namespace App\Http\Controllers;

use App\Http\Requests\EligibilityCriteriaRequest;
use App\Models\ComboPlan;
use App\Models\EligibilityCriteria;
use Illuminate\Http\Request;
use App\Models\Plan;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EligibilityCriteriaController extends Controller
{
    /**
     * Display a listing of the eligibility criteria.
     */
    public function index()
    {
        $eligibilityCriterias = EligibilityCriteria::with(
            'plans:id,price,name',
            'combo_plans:id,name,price',
            'combo_plans.plans:id,name,price'
        )->paginate(30);
        return view('eligibility_criteria.index', compact('eligibilityCriterias'));
    }

    /**
     * Show a form for a new eligibility criteria
     */
    public function create()
    {
        //  Pluck only neccessary columns from database
        $plans = Plan::pluck('name', 'id');
        $comboPlans = ComboPlan::pluck('name', 'id');
        return view('eligibility_criteria.create', compact('plans', 'comboPlans'));
    }

    /**
     * Store a new eligibility criteria 
     * with its associated plans 
     * and combo plans 
     */
    public function store(EligibilityCriteriaRequest $request)
    {
        try {
            $validated = $request->validated();

            $eligibilityCriteria = EligibilityCriteria::create($request->all());

            // Save eligibilityCriteria association with plans
            $eligibilityCriteria->plans()->attach($request->plans);

            // Save eligibilityCriteria association with combo plans
            $eligibilityCriteria->combo_plans()->attach($request->combo_plans);

            //  If No error save the db transaction
            DB::commit();
            return redirect()->route('eligibility_criteria.index')->with('success', 'Eligibility Criteria created successfully!');
        } catch (Exception $e) {

            // If error rollback the db transaction
            DB::rollBack();

            // Log erros
            Log::error('Error occured during creation of eligibilty criteria   ' . $e->getMessage());
            Log::error($request->all());
            return redirect()->back()->with('error', 'failed to create Eligibility Criteria. Please try agin.');
        }
    }

    /**
     * Display the specified eligibility criteria.
     */
    public function show(EligibilityCriteria $eligibilityCriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $eligibilityCriteria = EligibilityCriteria::with(
            'plans',
            'combo_plans',
            'combo_plans.plans'
        )->where('id', $id)
            ->first();

        // Early return if eligibilityCriteria not found
        if (!$eligibilityCriteria) {
            return back()->with('error', 'Something went wrong. Eligibility criteria not found.');
        }

        $plans = Plan::pluck('name', 'id');
        $comboPlans = ComboPlan::pluck('name', 'id');
        $eligibilityCriteriaComboPlanIds = $eligibilityCriteria->combo_plans->pluck('id');
        $eligibilityCriteriaPlanIds = $eligibilityCriteria->plans->pluck('id');
        return view('eligibility_criteria.edit', compact('eligibilityCriteria', 'plans', 'comboPlans', 'eligibilityCriteriaComboPlanIds', 'eligibilityCriteriaPlanIds'));
    }

    /**
     * Update the specified eligibility criteria in storage.
     */
    public function update(EligibilityCriteriaRequest $request, $id)
    {
        DB::beginTransaction(); // Start the transaction

        try {
            $validated = $request->validated();
            $eligibilityCriteria = EligibilityCriteria::findOrFail($id);

            // Check if the eligibilityCriteria is valid object
            if (!$eligibilityCriteria) {
                return back()->with('error', 'Something went wrong. Eligibility criteria not found.');
            }
            $eligibilityCriteria->update($validated);
            // Save eligibilityCriteria association with plans
            $eligibilityCriteria->plans()->sync($request->plans);

            // Save eligibilityCriteria association with combo plans
            $eligibilityCriteria->combo_plans()->sync($request->combo_plans);

            //  If No error save the db transaction
            DB::commit();
            return redirect()->route('eligibility_criteria.index')->with('success', 'Eligibility Criteria created successfully!');
        } catch (Exception $e) {

            // If error rollback the db transaction
            DB::rollBack();

            // Log errors
            Log::error('Error occured during creation of eligibilty criteria   ' . $e->getMessage());
            Log::error($request->all());
            return redirect()->back()->with('error', 'failed to update Eligibility Criteria. Please try agin.');
        }
    }

    /**
     * Remove the specified eligibility criteria 
     * and all the associated plans and combo plans
     */
    public function destroy($id)
    {

        try {
            $eligibilityCriteria = EligibilityCriteria::findOrFail($id);

            // Check if the eligibilityCriteria is valid object
            if (!$eligibilityCriteria) {
                return back()->with('error', 'Something went wrong. Eligibility criteria not found.');
            }
            DB::beginTransaction();

            // delete associated plans
            $eligibilityCriteria->plans()->detach();

            // delete associated combo plans
            $eligibilityCriteria->combo_plans()->detach();

            // delete eligibility criteria
            $eligibilityCriteria->delete();

            //  if everything goes well save changes
            DB::commit();
            return redirect()->route('eligibility_criteria.index')->with('success', 'Eligibility Criteria deleted successfully!');
            //handl any exeception occur at the time of delete 
        } catch (\Exception $e) {

            // Rollback if any exeception occurs
            DB::rollBack();

            //  Log erros
            Log::error('Error occured during deletion of eligibilty criteria   ' . $e->getMessage());
            Log::error('eligibilty criteria id  ' . $id);
            return redirect()->route('eligibility_criteria.index')->with('error', 'Failed to delete the Eligibility Criteria. Please try again.');
        }
    }
}
