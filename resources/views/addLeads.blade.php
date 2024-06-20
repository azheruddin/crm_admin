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
                    <h4 class="card-title text-primary">Add New Leads</h4>
               
                    <hr>
                    <form class="forms-sample" method="POST" action="{{ route('leads.store') }}"> 
            @csrf
                    
                      <div class="form-group">
                        <label for="exampleInputUsername1">Name</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" name="customer_name" placeholder="Leads"> 
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="customer_email" placeholder="Enter Email">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Phone Number</label>
                        <input type="number" class="form-control" id="exampleInputEmail1" name="phone" placeholder="Enter Phone Number">
                      </div>

                      <div class="form-group">
                      <label>State</label>
                      <select onchange="print_city('state', this.selectedIndex);" id="city" class="form-control"  name="state" required></select>

                    </div>

                      <div class="form-group">
                      <label>City</label>
                      <select id ="state" class="form-control" required name="city"></select> 

                    </div>

                      <div class="form-check form-check-flat form-check-primary"> 
                        <label class="form-check-label">
                      </div>
                      <button type="submit" class="btn btn-primary me-2">Add Leads</button>
                      <button class="btn btn-light">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
</div>
@endsection