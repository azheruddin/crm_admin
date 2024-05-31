@extends('layouts.app')

@section('content')
<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  <h4 class="card-title text-primary">Call History</h4><hr>
                   
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
        @foreach($CallHistory as $calls)
        <tr>
         <td>{{ $calls->phone }}</td>
            <td>{{ $calls->type }}</td>
            <td>{{ $calls->duration }}</td> 
             <td>{{ $calls->created_at }}</td> 
            @if(isset($calls->employee->name) && $calls->employee->name != null)
             <td>{{ $calls->employee->name }}</td> 
             @else
             <td></td> 
             @endif
             <td><a href="{{ route('call_history_detail', ['call_id' => $calls->id]) }}" class="btn btn-info"><i class="fa fa-eye"></i></a></a>
           
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
                       