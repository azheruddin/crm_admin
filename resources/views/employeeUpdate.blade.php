@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          
            <div class="card-body">
                <h4 class="card-title text-primary">Edit Employee</h4>
                <hr>
                <form class="forms-sample" method="POST" action="{{ route('employees.update', $employee->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Name</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" name="name" placeholder="Employee" value="{{ $employee->name }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter Email" value="{{ $employee->email }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Phone Number</label>
                        <input type="number" class="form-control" id="exampleInputEmail1" name="phone" placeholder="Enter Phone Number" value="{{ $employee->phone }}">
                    </div>
                    <div class="form-group">
                        <label>Employee Type</label>
                        <select class="form-control" name="type">
                            <option value="manager" {{ $employee->type == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="caller" {{ $employee->type == 'caller' ? 'selected' : '' }}>Caller</option>
                            <option value="other" {{ $employee->type == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password (leave blank to keep current password)</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Update Employee</button> 
                    <button class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
