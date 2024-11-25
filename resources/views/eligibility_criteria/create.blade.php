@extends('layouts.master')
@section('content')
    <div class="main-content" id="main-content">
        <h2>Create Eligibility Criteria</h2>
        @if (Session::has('error'))
            <div class="alert alert-danger custom-error alert-dismissible fade show mt-2" role="alert">
                <h6>
                    <i class="bi bi-exclamation-circle" style="margin-right: 5px;"></i>
                    {{ Session::get('error') }}
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- Form Section -->
        <form action="{{ route('eligibility_criteria.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="Enter eligibilty criteria name" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            {{-- Age criteria --}}
            <div class="mb-3">
                <label for="age_less_than" class="form-label">Age Less Than</label>
                <input type="number" class="form-control @error('name') is-invalid @enderror" id="age_less_than"
                    placeholder="Enter maximum age" name="age_less_than" value="{{ old('age_less_than') }}">
                @error('age_less_than')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="age_greater_than" class="form-label">Age Greater Than</label>
                <input type="number" class="form-control @error('age_greater_than') is-invalid @enderror"
                    id="age_greater_than" placeholder="Enter mimimum age" name="age_greater_than"
                    value="{{ old('age_greater_than') }}">
                @error('age_greater_than')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            {{-- Last login days ago --}}
            <div class="mb-3">
                <label for="last_login_days_ago" class="form-label">Last Login Days Ago</label>
                <input type="number" class="form-control @error('last_login_days_ago') is-invalid @enderror"
                    id="last_login_days_ago" placeholder="Enter days since last login" name="last_login_days_ago"
                    value="{{ old('last_login_days_ago') }}">
                @error('last_login_days_ago')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            {{-- Income criteria --}}
            <div class="mb-3">
                <label for="income_less_than" class="form-label">Income Less Than</label>
                <input type="number" class="form-control @error('income_less_than') is-invalid @enderror"
                    id="income_less_than" placeholder="Please enter maximum income" name="income_less_than"
                    value="{{ old('income_less_than') }}">
                @error('income_less_than')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="income_greater_than" class="form-label">Income Greater Than</label>
                <input type="number" class="form-control @error('income_greater_than') is-invalid @enderror"
                    id="income_greater_than" placeholder="Please enter minimum income" name="income_greater_than"
                    value="{{ old('income_greater_than') }}">
                @error('income_greater_than')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="plan" class="form-label">Plan</label>
                <select class="form-select js-plan" id="plan" name="plans[]" multiple="multiple"
                    aria-label="Default select example" value="{{ old('plan') }}">
                    @foreach ($plans as $id => $name)
                        <option value="{{ $id }}">{{ ucfirst($name) }}</option>
                    @endforeach
                </select>
                @error('plan')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="combo_plan" class="form-label">Combo Plan</label>
                <select class="form-select js-combo_plan" name="combo_plans[]" multiple="multiple"
                    aria-label="Default select example" value="{{ old('combo_plan') }}">
                    @foreach ($comboPlans as $id => $name)
                        <option value="{{ $id }}">{{ ucfirst($name) }}</option>
                    @endforeach
                </select>
                @error('combo_plan')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <a class="btn btn-danger" href="{{ route('eligibility_criteria.index') }}">Cancel</a>
            <button type="submit" class="btn btn-success">Submit</button>

        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('.js-combo_plan').select2({
                placeholder: "Select an Combo Plan",
                allowClear: true
            });
            $('.js-plan').select2({
                placeholder: "Select an Plan",
                allowClear: true
            });

        });
    </script>
@endsection
