@extends('layouts.app')

@section('content')
<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  <h4 class="card-title text-primary">Today Sales</h4><hr>
                  <form action="{{ route('leads_feedback') }}" method="GET">
         
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
              <th>EMPLOYEE</th>
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
            <!-- <td>{{ $sale->state }}</td>   -->
            @if(isset($sale->state->state_name) && $sale->state->state_name != null)
             <td>{{ $sale->state->state_name }}</td> 
             @else
             <td>NA</td> 
             @endif


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
                       