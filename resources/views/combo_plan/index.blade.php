@extends('layouts.master')
@section('content')
    <div class="main-content" id="main-content">
        <a href="{{ route('combo_plan.create') }}" class="btn btn-success"><i class="bi bi-plus-circle-fill"></i> Add New Combo
            Plan </a>
        @if (Session::has('success'))
            <div class="alert alert-danger custom-error alert-dismissible fade show mt-2" role="alert"
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

        <table class="table table-striped mt-2">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Combo Plan Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Associated Plans </th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($combo_plans as $combo_plan)
                    <tr>
                        {{-- @dd($combo_plan) --}}
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $combo_plan->name }}</td>
                        <td>${{ $combo_plan->price }}</td>
                        <td>
                            @foreach ($combo_plan->plans as $plan)
                                <div>{{ $plan->name }} : ${{ $plan->price }} </div>
                            @endforeach
                        </td>
                        <td>
                            <a class="btn btn-secondary" href="{{ route('combo_plan.edit', $combo_plan->id) }}"><i
                                    class="bi bi-pencil-square"> </i>Edit</a>
                            <form action="{{ route('combo_plan.destroy', $combo_plan->id) }}" method="post"
                                style="display: inline-block;"
                                onsubmit="return confirm('Are you sure you want to delete this combo plan?')">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i>Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center mt-2"> No data found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $combo_plans->links() }}


    </div>
@endsection
