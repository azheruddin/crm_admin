@extends('layouts.app')

@section('content')
<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  <h4 class="card-title text-primary">Sales</h4><hr>
                  <form action="{{ route('sales') }}" method="GET">
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
              <th>CUSTOMER NAME</th>
              <th>BUSINESS NAME</th>
              <th>KEYS</th>
              <th>AMOUNT</th>
              <th>TRANSACTION</th>
              <th>BALANCE</th>
              <th>STATE</th>
              <th>CITY</th>
              <th>EMPLOYEE ID</th>
              <th>ACTION</th>

            </tr>
        </thead> 
        <tbody>
        @foreach($Sales as $sale)
        <tr>
            <td>{{ $sale->customer_name }}</td>
            <td>{{ $sale->business_name }}</td>
            <td>{{ $sale->keys }}</td>
            <td>{{ $sale->amount }}</td> 
            <td>{{ $sale->transaction }}</td> 
            <td>{{ $sale->balance }}</td> 
            <td>{{ $sale->state }}</td>  
             <td>{{ $sale->city }}</td> 
 
             
             @if(isset($sale->employee->name) && $sale->employee->name != null)
             <td>{{ $sale->employee->name }}</td> 
             @else
             <td></td> 
             @endif


             <td><a href="{{ route('sale_details', ['id' => $sale->id]) }}" class="btn btn-info"><i class="fa fa-eye"></i></a></td>

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
                       