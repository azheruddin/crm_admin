

@extends('layouts.app')


@section('content')


<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  <h4 class="card-title text-primary">Call History by Employee </h4><hr>
                   <form> 
                    
                <select>
                @foreach($employees as $employee)
      
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
          
        @endforeach
                </select>
            
            </form>
                    <!-- table goes here -->
                    

<table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <!-- <th>CUSTOMER NAME</th> -->
                <th>PHONE</th>
                <th>CALL TYPE</th>
                <th>CALL DURATION</th>
                 <th>CALL DATE</th> 
               <th>EMPLOYEE NAME</th>
               <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
        <!-- @foreach($allCallsByEmployee as $calls)
        <tr>
            <td>{{ $calls->customer_name }}</td>
            <td>{{ $calls->phone }}</td>
            <td>{{ $calls->type }}</td>
            <td>{{ $calls->call_duration }}</td> 
             <td>{{ $calls->created_at }}</td> 
             <td>{{ $calls->employee->name }}</td> 
             <td><a href="#" class="btn btn-info"><i class="fa fa-eye"></i></a>
           
        </tr>
        @endforeach -->
</tbody>
</table>     
                  </div>
                </div> 
              </div>
</div>
@endsection



                       