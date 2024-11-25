<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComboPlanRequest;
use App\Models\ComboPlan;
use App\Models\Plan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ComboPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $combo_plans = ComboPlan::select('id', 'name', 'price')
            ->with(['plans:id,name,price'])
            ->paginate(30);

        return view('combo_plan.index', compact('combo_plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $plans = Plan::pluck('name', 'id');
        return view('combo_plan.create', compact('plans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ComboPlanRequest $request)
    {
        DB::beginTransaction();
        try {
            // Validate and create comboPlan
            $validated = $request->validated();
            $comboPlan = ComboPlan::create($validated);

            // attach plan with combo plan
            $comboPlan->plans()->attach($request->plans);

            DB::commit();
            return redirect()->route('combo_plan.index')->with('success', 'Combo Plan created successfully!');
        } catch (Exception $e) {

            // If any error rollback the changes
            DB::rollBack();

            // Log error details for debugging
            Log::error('Error occured during creation of combo plan   ' . $e->getMessage());
            Log::error('Request payload for failed combo plan creation', [
                'payload' => $request->all()
            ]);
            return back()->with('error', 'Failed to create combo plan. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ComboPlan $comboPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComboPlan $comboPlan)
    {
        $plans = Plan::all();
        $comboPlanPlanIds = $comboPlan->plans->pluck('id');
        return view('combo_plan.edit', compact('plans', 'comboPlan', 'comboPlanPlanIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ComboPlanRequest $request, ComboPlan $comboPlan)
    {
        DB::beginTransaction();
        try {

            //  Validate and update combo plan 
            $validated = $request->validated();
            $comboPlan->update($validated);

            // update the associated plans
            $comboPlan->plans()->sync($request->plans);

            // Commit changes if no error
            DB::commit();
            return redirect()->route('combo_plan.index')->with('success', 'Plan created successfully!');
        } catch (Exception $e) {

            // If any error rollback the changes
            DB::rollBack();

            // Log error details for debugging
            Log::error('Error occured during creation of combo plan   ' . $e->getMessage());
            Log::error('Request payload for failed combo plan creation', [
                'payload' => $request->all()
            ]);
            return back()->with('error', 'Failed to update combo plan. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComboPlan $comboPlan)
    {
        DB::beginTransaction();
        try {
            //  Detach all the assoictaed plans ande delete combo plans
            $comboPlan->plans()->detach();
            $comboPlan->delete();

            DB::commit();
            return redirect()->route('combo_plan.index')->with('success', 'Combo plan deleted successfully!');
        } catch (\Exception $e) {

            // rollback the changes if any error occurs
            DB::rollBack();

            // Log error details for debugging
            Log::error('Error occured during creation of combo plan   ' . $e->getMessage());
            Log::error('combo plan id  ' . $comboPlan->id);

            return redirect()->route('combo_plan.index')->with('error', 'Failed to delete the combo plan. Please try again.');
        }
    }
}
