@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          
            <div class="card-body">
                <h4 class="card-title text-primary">Change Employee</h4>
                <hr>
                <form class="forms-sample" method="POST" action="{{ route('update_password', $employee->id) }}">
                <form class="forms-sample" method="POST" action="{{ route('employees.update', $employee->id) }}">

                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Name</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" name="name" placeholder="Employee" value="{{ $employee->name }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">change Password </label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password"  value="{{ $employee->password }}">
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Save</button> 
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
