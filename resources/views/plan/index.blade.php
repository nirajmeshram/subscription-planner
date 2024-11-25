@extends('layouts.master')
@section('content')
    <div class="main-content" id="main-content">
        <a href="{{ route('plan.create') }}" class="btn btn-success"> <i class="bi bi-plus-circle-fill mx-1"></i>Add New Plan
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


        <table class="table table-striped mt-2">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Plan Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($plans as $plan)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $plan->name }}</td>
                        <td>${{ $plan->price }}</td>
                        <td>
                            <a class="btn btn-secondary" href="{{ route('plan.edit', $plan->id) }}"><i
                                    class="bi bi-pencil-square"> </i>Edit</a>
                            <form method="post" action="{{ route('plan.destroy', $plan->id) }}"
                                style="display: inline-block;"
                                onsubmit="return confirm('Are you sure want to delete this plan ?')">
                                @method('delete')
                                @csrf

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
        {{ $plans->links() }}
    </div>
@endsection
