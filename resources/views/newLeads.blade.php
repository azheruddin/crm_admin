@extends('layouts.app')

@section('content')
<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  <h4 class="card-title text-primary">New Leads</h4><hr>
                  <!-- Display success or error messages -->
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
                  <form action="{{ route('new_leads') }}" method="GET">
          <div class="form-row">
            

            
            <div class="form-group col-md-3">
                            <label for="employee_id">Employee</label>
                            <select class="form-control" id="employee_id" name="employee_id">
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>

            <div class="form-group col-md-4">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">Filter</button>
                        </div>
          </div>
        </form>
                    
                   
                    <!-- table goes here -->
                    

<table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Sr No.</th>
                <th>CUSTOMER NAME</th>
                <th>EMAIL</th>
                <th>PHONE</th>
                 <th>LEAD STAGE</th>
               <th>LEAD DATE</th>
               <!-- <th>EXPECTED REVENUE</th> -->
               <!-- <th>NOTES</th> -->
               <th>EMPLOYEE</th>
               <th>ACTION</th>

            </tr>
        </thead>
        <tbody>
        @foreach($LeadsFeedback as $index => $leads)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $leads->customer_name }}</td>
            <td>{{ $leads->customer_email }}</td>
            <td>{{ $leads->phone }}</td>
            <td>{{ $leads->lead_stage }}</td> 
             <td>{{ $leads->created_at }}</td> 
             <!-- <td>{{ $leads->expected_revenue }}</td>  -->
             <!-- <td>{{ $leads->notes }}</td>  -->
 
             
             @if(isset($leads->employee->name) && $leads->employee->name != null)
             <td>{{ $leads->employee->name }}</td> 
             @else
             <td></td> 
             @endif

              

             <td>
                 <a href="{{ route('leadsfeedback_detail', ['lead_id' => $leads->id]) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                <form action="{{ route('leads.delete', $leads->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this lead?');">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
             </td>

        </tr>
        @endforeach
</tbody>
</table>     
                  </div>
                </div> 
              </div>
</div>
@endsection



<tbody>
                       