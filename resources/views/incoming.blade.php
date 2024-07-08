@extends('layouts.app')

@section('content')




<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
      <div class="form-group col-md-3">
            <h4 class="card-title text-primary">Today Incoming Call </h4>
          </div>


        
        <!-- table goes here -->


        <table id="example" class="table table-striped" style="width:100%">
          <thead>
            <tr>
              <th>PHONE</th>
              <th>CALL TYPE</th>
              <th>DURATION</th>
              <th>CALL DATE</th>
              <th>EMPLOYEE</th>
              <!-- <th>ACTION</th> -->
            </tr>
          </thead>
          <tbody>
            @foreach($callHistories as $calls)
        <tr>
        <td>{{ $calls->phone }}</td>
        <td>{{ $calls->type }}</td>

        <td>{{ $calls->call_duration }}</td>
        <td>{{ $calls->created_at }}</td> ``                                                                              

        <!-- @php
                    // Ensure that $calls->call_duration is numeric
                    $totalSeconds = is_numeric($calls->call_duration) ? (int)$calls->call_duration : 0;

                    // Perform the calculations
                    $minutes = floor($totalSeconds / 60);
                    $seconds = $totalSeconds % 60;
                @endphp -->

        @if(isset($calls->employee->name) && $calls->employee->name != null)
      <td>{{ $calls->employee->name }}</td>
    @else
    <td></td>
  @endif

  <td><a href="{{ route('dashboard', ['call_id' => $calls->id]) }}">
    <!-- <i class="fa fa-eye"></i> -->
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





