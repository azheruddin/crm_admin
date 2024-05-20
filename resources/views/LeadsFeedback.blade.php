@extends('layouts.app')

@section('content')
<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  <h4 class="card-title text-primary">Leads Feedback</h4><hr>
                   
                    <!-- table goes here -->
                    

<table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
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
        @foreach($LeadsFeedback as $leads)
        <tr>
            <td>{{ $leads->customer_name }}</td>
            <td>{{ $leads->customer_email }}</td>
            <td>{{ $leads->phone }}</td>
            <td>{{ $leads->lead_stage }}</td> 
             <td>{{ $leads->created_at }}</td> 
             <!-- <td>{{ $leads->expected_revenue }}</td>  -->
             <td>{{ $leads->next_follow_up }}</td> 
             <!-- <td>{{ $leads->notes }}</td>  -->
             <!-- <td>{{ $leads->employee_id }}</td>  -->

             
             @if(isset($leads->employee->name) && $leads->employee->name != null)
             <td>{{ $leads->employee->name }}</td> 
             @else
             <td></td> 
             @endif

             <td><a href="{{ route('leadsfeedback_detail', ['lead_id' => $leads->id]) }}" class="btn btn-info"><i class="fa fa-eye"></i></a></a>



           

           
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
                       