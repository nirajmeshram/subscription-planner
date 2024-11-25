@extends('layouts.master')
@section('content')
    <div class="main-content" id="main-content">
        <a href="{{ route('eligibility_criteria.create') }}" class="btn btn-success"> <i
                class="bi bi-plus-circle-fill mx-1"></i>
            Add New Eligibility Criteria
        </a>
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert"
                style="background-color: green; color:#fff">
                <h6>
                    <i class="bi bi-check-circle-fill" style="margin-right: 5px;"></i>
                    {{ Session::get('success') }}
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger custom-error alert-dismissible fade show mt-2" role="alert">
                <h6>
                    <i class="bi bi-exclamation-circle" style="margin-right: 5px;"></i>
                    {{ Session::get('error') }}
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive" style="overflow-x:auto; max-width:100%;">
            <table class="table table-striped" style="width:100%; white-space:nowrap;">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Age Less Than</th>
                        <th scope="col">Age Greater Than</th>
                        <th scope="col">Last Login Days Ago</th>
                        <th scope="col">Income Less Than</th>
                        <th scope="col">Income Greater Than</th>
                        <th scope="col">Plan</th>
                        <th scope="col">Combo Plan</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($eligibilityCriterias as $eligibilityCriteria)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $eligibilityCriteria->name }}</td>
                            <td>{{ $eligibilityCriteria->age_less_than }} Years</td>
                            <td>{{ $eligibilityCriteria->age_greater_than }} Years</td>
                            <td>{{ $eligibilityCriteria->last_login_days_ago }} days</td>
                            <td>${{ number_format($eligibilityCriteria->income_less_than, 2) }}</td>
                            <td>${{ number_format($eligibilityCriteria->income_greater_than, 2) }}</td>

                            <td>
                                @if ($eligibilityCriteria->plans->isNotEmpty())
                                    <ul>
                                        @foreach ($eligibilityCriteria->plans as $plan)
                                            <li>{{ $plan->name }} : ${{ number_format($plan->price, 2) }} </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span>No Plans Available</span>
                                @endif
                            </td>
                            <td>
                                @if ($eligibilityCriteria->combo_plans->isNotEmpty())
                                    @foreach ($eligibilityCriteria->combo_plans as $combo_plan)
                                        <div><b>Combo Plan - {{ $combo_plan->name }}:
                                                ${{ number_format($combo_plan->price, 2) }}</b></div>
                                        @foreach ($combo_plan->plans as $plan)
                                            <div>{{ $plan->name }} : ${{ number_format($plan->price, 2) }} </div>
                                        @endforeach
                                    @endforeach
                                @else
                                    <span>No Combo Plans Available</span>
                                @endif
                            </td>
                            <td>
                                {{-- <a class="btn btn-secondary"
                                    href="{{ route('eligibility_criteria.edit', $eligibilityCriteria->id) }}"><i
                                        class="bi bi-pencil-square"> </i>
                                    Edit
                                </a> --}}
                                <a class="btn btn-secondary"
                                    href="{{ route('eligibility_criteria.edit', $eligibilityCriteria->id) }}"><i
                                        class="bi bi-pencil-square"> </i>Edit
                                </a>
                                <form method="post"
                                    action="{{ route('eligibility_criteria.destroy', $eligibilityCriteria->id) }}"
                                    style="display: inline-block;"
                                    onsubmit="return confirm('Are you sure want to delete this eligibility criteria ?')">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i>Delete</button>
                                </form>


                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center mt-2"> No Eligibility Criteria Found</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection
