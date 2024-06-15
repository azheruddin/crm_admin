@extends('layouts.app')

@section('content')

<div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  
                    <h4 class="card-title text-primary">Call History Details 
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">    
                    <a href="/call_history"button type="button" class="btn btn-primary justify-content-md-end" >Back</button></a>
                    </div>
                    <hr></h4>  
                    
                   
                    <!-- <p class="card-description"> Add class <code>.table-hover</code> -->
                    </p>
                    <div class="table-responsive">
                      <table class="table table-hover">
                       
                        <tbody>
                          <tr>
                            <td>Customer Name</td>
                            <td>{{ $calls->customer_name }}</td>
                          </tr>
                          <tr>
                            <td>Customer Phone </td>
                            <td>{{ $calls->phone }}</td>
                          </tr>
                          <tr>
                            <td>Call Type</td>
                            <td>{{ $calls->type }}</td>
                          </tr>
                          <tr>
                            <td>Duration</td>
                            @php
    $totalSeconds = $calls->call_duration;
    $minutes = floor($totalSeconds / 60);
    $seconds = $totalSeconds % 60;
    @endphp
<td>{{ $minutes }} min {{ $seconds }} sec</td>
                          </tr>
                          <tr>
                            <td>Call Date</td>
                            <td>{{ $calls->created_at }}</td>
                          </tr>
                          <tr>
                            <td>Employee</td>
                            <td>{{ $calls->employee->name }}</td>
                          </tr>
                          
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

















                       
                 
@endsection