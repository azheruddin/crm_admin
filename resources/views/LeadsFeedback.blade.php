@extends('layouts.app')

@section('content')
<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  <h4 class="card-title text-primary">Leads Feedback</h4><hr>
                  <form action="{{ route('leads_feedback') }}" method="GET">
          <div class="form-row">
            <div class="form-group col-md-3">
              
              <label for="from_date">From Date</label>
              <input type="date" class="form-control" id="from_date" name="from_date"
          value="{{ request('from_date') }}">
          
              <label for="to_date">To Date</label>
              <input type="date" class="form-control" id="to_date" name="to_date"
          value="{{ request('to_date') }}">
            </div>

            
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
                <th>SERIAL NO.</th>
                <th>CUSTOMER NAME</th>
                <th>EMAIL</th>
                <th>PHONE</th>
                 <th>LEAD STAGE</th>
               <th>LEAD DATE</th>
               <!-- <th>EXPECTED REVENUE</th> -->
               <th>NEXT FOLLOW UP</th>
               <!-- <th>NOTES</th> -->
               <th>EMPLOYEE</th>
               <th>ACTION</th>

            </tr>
        </thead>
        <tbody>
       

        @foreach($LeadsFeedback as $index => $leads)
                        <tr>
              <td>{{ $index +1 }}</td>
            <td>{{ $leads->customer_name }}</td>
            <td>{{ $leads->customer_email }}</td>
            <td>{{ $leads->phone }}</td>
            <td>{{ $leads->lead_stage }}</td> 
             <td>{{ $leads->created_at }}</td> 
             <!-- <td>{{ $leads->expected_revenue }}</td>  -->
             <td>{{ $leads->next_follow_up }}</td> 
             <!-- <td>{{ $leads->notes }}</td>  -->
 
             
             @if(isset($leads->employee->name) && $leads->employee->name != null)
             <td>{{ $leads->employee->name }}</td> 
             @else
             <td></td> 
             @endif

              
            <td>
             <a href="{{ route('leadsfeedback_detail', ['id' => $leads->id]) }}" class="btn btn-info">
    <i class="fa fa-eye"></i>
</a></td>
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
                       