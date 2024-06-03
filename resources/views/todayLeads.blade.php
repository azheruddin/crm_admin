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
              
              <label for="from_date">From Date</label>
              <input type="date" class="form-control" id="from_date" name="from_date"
          value="{{ request('from_date') }}">
          
              <label for="to_date">To Date</label>
              <input type="date" class="form-control" id="to_date" name="to_date" value="{{ request('to_date') }}">
            </div>

            <div class="form-group col-md-3">

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
                            <th>CUSTOMER NAME</th>
                            <th>EMAIL</th>
                            <th>PHONE</th>
                            <th>LEAD STAGE</th>
                            <th>LEAD DATE</th>
                            <th>NEXT FOLLOW UP</th>
                            <th>EMPLOYEE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($todayLeads as $lead)
                        <tr>
                            <td>{{ $lead->customer_name }}</td>
                            <td>{{ $lead->customer_email }}</td>
                            <td>{{ $lead->phone }}</td>
                            <td>{{ $lead->lead_stage }}</td>
                            <td>{{ $lead->created_at }}</td>
                            <td>{{ $lead->next_follow_up }}</td>
                            <td>{{ $lead->employee->name ?? '' }}</td>
                            <td>
                                <a href="{{ route('leadsfeedback_detail', ['lead_id' => $lead->id]) }}" class="btn btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
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
