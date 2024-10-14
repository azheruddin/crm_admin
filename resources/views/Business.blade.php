@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-primary">Business In</h4>
                <hr>
                <form action="{{ route('business_in') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="name">Business Type:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </div>
                </form>

                <!-- Display Success Message -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Table to display records -->
                <table id="masterdata" class="table table-striped" style="width:80%">
                    <thead>
                        <tr>
                            <th>SERIAL NO.</th>
                            <th>BUSINESS TYPE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($businessIn as $index => $business)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $business->business_type }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="1">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
