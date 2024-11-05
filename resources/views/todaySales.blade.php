@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-primary">Today Sales</h4><hr>



                <form action="{{ route('today_sales') }}" method="GET">
          <div class="form-row">
            <div class="form-group col-md-3">
              
             
            </div>

                           <div class="form-group col-md-3">
                            <label for="employee_id">Employee</label>
                            <select class="form-control" id="employee_id" name="employee_id" onchange="this.form.submit()">
                    <option value="">Select Employee</option>
                    @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                    @endforeach
                </select>
                        </div>

                <!-- table goes here -->
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>SERIAL NO.</th>
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
                       
                        @foreach($Sales as $index => $sale)
                          <tr>
                            <td>{{ $index +1 }}</td>
                            <td>{{ $sale->customer_name }}</td>
                            <td>{{ $sale->business_name }}</td>
                            <td>{{ $sale->keys }}</td>
                            <td>{{ $sale->amount }}</td> 
                            <td>{{ $sale->transaction }}</td> 
                            <td>{{ $sale->balance }}</td> 
                            <td>
                                @if($sale->state && $sale->state->state_name)
                                    {{ $sale->state->state_name }}
                                @else
                                    NA
                                @endif
                            </td>
                            <td>
                                @if($sale->city && $sale->city->city_name)
                                    {{ $sale->city->city_name }}
                                @else
                                    NA
                                @endif
                            </td>
                            <td>
                                @if($sale->employee && $sale->employee->name)
                                    {{ $sale->employee->name }}
                                @else
                                    NA
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('sale_details', ['id' => $sale->id]) }}" class="btn btn-info">
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
