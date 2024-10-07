@extends('layouts.app')

@section('content')




<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
      <h4 class="card-title text-primary"> Today's Call History</h4><hr>


          <!-- Employee Filter Form -->
          <form action="{{ route('call_history_today') }}" method="GET">
            <div class="form-group col-md-3">
                <label for="">Employee</label> 
                <select class="form-control" id="employee_id" name="employee_id" onchange="this.form.submit()">
                    <option value="">Select Employee</option>
                    @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                    @endforeach
                </select>

                <!-- <button type="submit" class="btn btn-primary btn-block">Search</button> -->
            </div>
        </form>
    

        <!-- table goes here -->


        <table id="example" class="table table-striped" style="width:100%">
          <thead>
            <tr>
              <th>Contact Name</th>
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

    try {
        // Check if call_date is valid before parsing
        $callDate = \Carbon\Carbon::parse($calls->call_date);
        $formattedDate = $callDate->format('Y-m-d'); // Extract date part
        $formattedTime = $callDate->format('h:i:s A'); // Extract time part
    } catch (\Carbon\Exceptions\InvalidFormatException $e) {
        // Handle invalid date format by setting defaults or showing error
        $formattedDate = 'Invalid Date';
        $formattedTime = 'Invalid Time';
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

        <td><a href="{{ route('today_call_history_detail', ['call_id' => $calls->id]) }}" class="btn btn-info"><i
            class="fa fa-eye"></i></a></a>

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