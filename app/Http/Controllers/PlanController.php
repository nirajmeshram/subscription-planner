<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::select('id', 'name', 'price')->paginate(30);
        return view('plan.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('plan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanRequest $request)
    {
        try {

            // validate and create new plan
            $validated = $request->validated();
            Plan::create($validated);

            return redirect()->route('plan.index')->with('success', 'Plan created successfully!');
        
        } catch (Exception $e) {
            // Log error details for debugging
            Log::error('Error occured during creation of plan   ' . $e->getMessage());
            Log::error('Request payload for failed plan creation', [
                'payload' => $request->all()
            ]);
            return redirect()->back()->with('error', 'failed to create Plan. Please try agin.');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        return view('plan.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanRequest $request, Plan $plan)
    {
        try {
            // Validate and update plan
            $validated = $request->validated();
            $plan->update($validated);

            return redirect()->route('plan.index')->with('success', 'Plan updated successfully!');

        } catch (Exception $e) {
            // Log error details for debugging
            Log::error('Error occured during updation of plan   ' . $e->getMessage());
            Log::error('Request payload for failed plan updation', [
                'payload' => $request->all()
            ]);
            return redirect()->back()->with('error', 'failed to update Plan. Please try agin.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        DB::beginTransaction();

        try {

            //  detach combo plans association 
            $plan->combo_plans()->detach();

            //  Delete plans
            $plan->delete();

            // If everthing works then save changes
            DB::commit();

            return redirect()->route('plan.index')->with('success', 'Plan deleted successfully!');
            
        } catch (\Exception $e) {

            // Rollback if any exeception occurs
            DB::rollBack();

            // Log error details for debugging
            Log::error('Error occured during deletion of plan   ' . $e->getMessage());
            Log::error('failed plan id' . $plan->id);
            return redirect()->route('plan.index')->with('error', 'Failed to delete the combo plan. Please try again.');
        }
    }
}
