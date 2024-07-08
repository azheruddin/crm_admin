@extends('layouts.app')

@section('content')




<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
      <div class="form-group col-md-3">
            <h4 class="card-title text-primary">Today Call History</h4>
          </div>


        <form action="{{ route('filter_call_history') }}" method="GET">
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
              <th>PHONE</th>
              <th>CALL TYPE</th>
              <th>DURATION</th>
              <th>CALL DATE</th>
              <th>EMPLOYEE</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody>
            @foreach($callHistories as $calls)
        <tr>
        <td>{{ $calls->phone }}</td>
        <td>{{ $calls->type }}</td>

        <td>{{ $calls->call_duration }}</td>
        <td>{{ $calls->created_at }}</td>                                                                             

       
        <td>{{ $calls->created_at }}</td>

        @if(isset($calls->employee->name) && $calls->employee->name != null)
      <td>{{ $calls->employee->name }}</td>
    @else
    <td></td>
  @endif

        <td><a href="{{ route('today_call_history_detail', ['call_id' => $calls->id]) }}" class="btn btn-info">

          <i class="fa fa-eye"></i></a></td>

          <!-- <i class="fa fa-eye"></i></a></a> -->






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





