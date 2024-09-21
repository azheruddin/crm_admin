@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Upload Excel File</h4>
                <form class="row" method="POST" action="{{ route('importscreate') }}" enctype="multipart/form-data">
                    @csrf

                   <!-- Display success or error message -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Display validation errors -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                    <div class="form-group col-md-6">
                    <label for="">Upload File</label>
                        <input type="file" name="file" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                            <label for="employee_id">Employee</label>
                            <select class="form-control" id="employee_id" name="employee_id">
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    <div class="form-group text-center">
                         <button type="submit" class="btn btn-primary">Upload</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
