@extends('layouts.app')

@section('content')

<div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  
                    <h4 class="card-title text-primary">Today Call History Details 
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">    
                    <!-- <a href="/leadsfeedback_detail"button type="button" class="btn btn-primary justify-content-md-end" >Back</button></a> -->
                    <a href="/call_history_today"button type="button" class="btn btn-primary justify-content-md-end" >Back</button></a>

                    </div>
                    <hr></h4>  
                    
                   
                    <!-- <p class="card-description"> Add class <code>.table-hover</code> -->
                    </p>
                    <div class="table-responsive">
                      <table class="table table-hover">
                       
                        <tbody>
                          <tr>
                            <td>CUSTOMER NAME</td>
                            <td>{{ $calls->customer_name }}</td>
                          </tr>
                          <tr>
                            <td>PHONE</td>
                            <td>{{ $calls->phone }}</td>
                          </tr>
                          <tr>
                            <td>CALL TYPE</td>
                            <td>{{ $calls->call_type }}</td>
                          </tr>
                          <tr>
                            <td>DURATION</td>
                            <td>{{ $calls->duration }}</td>
                          </tr>
                          <tr>
                            <td>CALL DATE</td>
                            <td>{{ $calls->created_at }}</td>
                          </tr>
                          <tr>
                            <td>EMPLOYEE</td>
                            <td>{{ $calls->employee->name }}</td>
                          </tr>

                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

















                       
                 
@endsection