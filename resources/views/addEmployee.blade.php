@extends('layouts.app')

@section('content')
<div class="row">
              <div class="col-md-6 grid-margin stretch-card">
    
                <div class="card">
                @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
                  <div class="card-body">
                    <h4 class="card-title text-primary">Add New Employee</h4>
               
                    <hr>
                    <form class="forms-sample" method="POST" action="{{ route('employees.store') }}">
    @csrf
                    
                      <div class="form-group">
                        <label for="exampleInputUsername1">Name</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" name="name" placeholder="Employee">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter Email">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Phone Number</label>
                        <input type="number" class="form-control" id="exampleInputEmail1" name="phone" placeholder="Enter Phone Number">
                      </div>
                      <div class="form-group">
                      <label>Employee Type</label>
                      <select class="form-control" name="type">
                        <option value="manager">Manager</option>
                        <option value="caller">Caller</option>
                        <option value="Other">other</option>
                      </select>
                    </div>
                      
                      <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
                      </div>
                      <div class="form-check form-check-flat form-check-primary">
                        <label class="form-check-label">
                      </div>
                      <button type="submit" class="btn btn-primary me-2">Add Employee</button>
                      <button class="btn btn-light">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
</div>
@endsection