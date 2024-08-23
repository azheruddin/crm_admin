@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-primary">Today Sales</h4><hr>
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