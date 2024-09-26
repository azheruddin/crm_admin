@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-primary">Today's Leads Feedback</h4>
                <hr>


                <form action="{{ route('filter_leads') }}" method="GET">
          <div class="form-row">
            <div class="form-group col-md-3">
              
             
            </div>

            <div class="form-group col-md-3">
                            <label for="employee_id">Employee</label>
                            <select class="form-control" id="employee_id" name="employee_id">
                                <option value="">Select Employee</option>
                                
                                @isset($employees)

                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}</option>
                                @endforeach
                                @endisset

                            </select>
                        </div>

                        <div class="form-group col-md-3">
    <label for="lead_stage">Lead Stage</label>
    <select class="form-control" id="lead_stage" name="lead_stage">
        <option value="">Select Lead Stage</option>
        <option value="hot" {{ request('lead_stage') == 'hot' ? 'selected' : '' }}>Hot</option>
        <option value="interested" {{ request('lead_stage') == 'interested' ? 'selected' : '' }}>Interested</option>
        <option value="not_interested" {{ request('lead_stage') == 'not_interested' ? 'selected' : '' }}>Not Interested</option>
        <option value="no_answer" {{ request('lead_stage') == 'not_answer' ? 'selected' : '' }}>Not Answer</option>
        <option value="close" {{ request('lead_stage') == 'close' ? 'selected' : '' }}>Close</option>
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
                            <th>NEXT FOLLOW UP</th>
                            <th>EMPLOYEE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($todayLeads as $index => $lead)
                        <tr>
                            <td>{{ $index +1 }}</td>
                            <td>{{ $lead->customer_name }}</td>
                            <td>{{ $lead->customer_email }}</td>
                            <td>{{ $lead->phone }}</td>
                            <td>{{ $lead->lead_stage }}</td>
                            <td>{{ $lead->created_at }}</td>
                            <td>{{ $lead->next_follow_up }}</td>
                            <td>{{ $lead->employee->name ?? '' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>     
            </div>
        </div> 
    </div>
</div>
@endsection
