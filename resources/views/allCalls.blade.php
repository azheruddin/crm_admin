@extends('layouts.app')

@section('content')

<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  <h4 class="card-title text-primary">Call History</h4><hr>
                  <form action="{{ route('call_history') }}" method="GET">
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
                <th>CONTACT NAME</th>
                <th>PHONE</th>
                <th>CALL TYPE</th>
                <th>DURATION</th>
                <th>DATE</th>
                <th>TIME</th>
                <th>EMPLOYEE</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
        @foreach($callHistories as $calls)
        <tr>
            <td>{{ $calls->contact_name }}</td>
            <td>{{ $calls->phone }}</td>
            <td>{{ $calls->type }}</td>
            @php
    $totalSeconds = $calls->call_duration;
    $minutes = floor($totalSeconds / 60);
    $seconds = $totalSeconds % 60;

    $callDateString = $calls->call_date;

    // Validate the date string before parsing with Carbon
    if (strtotime($callDateString)) {
        $callDate = \Carbon\Carbon::parse($callDateString);
        $formattedDate = $callDate->format('Y-m-d');
        $formattedTime = $callDate->format('h:i:s A');
    } else {
        $formattedDate = 'Invalid Date'; // Handle invalid date
        $formattedTime = 'Invalid Time'; // Handle invalid time
    }
@endphp

<td>{{ $minutes }} min {{ $seconds }} sec</td>
<td>{{ $formattedDate }}</td>
<td>{{ $formattedTime }}</td>

        @if(isset($calls->employee->name) && $calls->employee->name != null)
      <td>{{ $calls->employee->name }}</td>
    @else
    <td></td>
  @endif

             
             <td><a href="{{ route('call_history_detail', ['call_id' => $calls->id]) }}" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
           
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
                       

