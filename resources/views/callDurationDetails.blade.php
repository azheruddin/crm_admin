@extends('layouts.app')

@section('content')

<div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  
                    <h4 class="card-title text-primary">Call Duration Details 
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">    
                    <a href="/call_duration"button type="button" class="btn btn-primary justify-content-md-end" >Back</button></a>

                    </div>
                    <hr></h4>  
                    
                    </p>
                    <div class="table-responsive">
                      <table class="table table-hover">
                       
                        <tbody>
                          <tr>
                            <td>Employee Name</td>
                            <td>{{ $duration->employee->name }}</td>
                          </tr>
                          <tr>
                            <td>Incoming Duration</td>
                            <td>{{ $incomingMinutes }} min {{ $incomingSeconds }}sec</td>
                          </tr>
                          <tr>
                            <td>Outgoing Duration</td>
                            <td>{{ $outgoingMinutes }} min {{ $outgoingSeconds }}sec</td>
                          </tr>
                          <tr>
                            <td>Total Duration</td>
                            <td>{{ $totalMinutes }} min {{ $totalSeconds }}sec</td>
                          </tr>
                         

                          
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

















                       
                 
@endsection