@extends('layouts.app')

@section('content')

<div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  
                    <h4 class="card-title text-primary">Sales Details 
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">    
                    <a href="/sales"button type="button" class="btn btn-primary justify-content-md-end" >Back</button></a>

                    </div>
                    <hr></h4>  
                    
                    </p>
                    <div class="table-responsive">
                      <table class="table table-hover">
                       
                        <tbody>
                          <tr>
                            <td>Customer Name</td>
                            <td>{{  $sale->customer_name }}</td>
                          </tr>
                          <tr>
                            <td>Business Name</td>
                            <td>{{ $sale->business_name }}</td>
                          </tr>
                          <tr>
                            <td>Keys</td>
                            <td>{{ $sale->keys }}</td>
                          </tr>
                          <tr>
                            <td>Amount</td>
                            <td>{{ $sale->amount }}</td>
                          </tr>
                          <tr>
                            <td>Transaction</td>
                            <td>{{ $sale->transaction }}</td>
                          </tr>
                          <tr>
                            <td>Balance</td>
                            <td>{{ $sale->balance }}</td>
                          </tr>

                          <tr>
                            <td>State</td>
                            <td>{{ $sale->state }}</td>
                          </tr>
                          <tr>
                            <td>City</td>
                            <td>{{ $sale->city  }}</td>
                          </tr>

                          <tr>
                            <td>Employee</td>
                            <td>
                                @if ($sale->employee)
                                    {{ $sale->employee->name }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

















                       
                 
@endsection