@extends('layouts.app')

@section('content')

<div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  
                    <h4 class="card-title text-primary">Employee Details 
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">    
                    <a href="{{ route('show_employee', ['employee_id' => $employee->id]) }}"button type="button" class="btn btn-primary justify-content-md-end" >Back</button></a>
                    </div>
                    <hr></h4>  
                    
                   
                    <!-- <p class="card-description"> Add class <code>.table-hover</code> -->
                    </p>
                    <div class="table-responsive">
                      <table class="table table-hover">
                       
                        <tbody>
                          <tr>
                            <td>Employee Name</td>
                            <td>{{ $employee->name }}</td>
                          </tr>
                          <tr>
                            <td>Employee Email</td>
                            <td>{{ $employee->email }}</td>
                          </tr>
                          <tr>
                            <td>Employee Phone</td>
                            <td>{{ $employee->phone }}</td>
                          </tr>
                          <tr>
                            <td>Employee Type</td>
                            <td>{{ $employee->type }}</td>
                          </tr>

                          <tr>
                            <td>Status</td>
                            @if($employee->is_active == 1 )
                            <td> <span class="badge bg-success"> Activated </span></td>
                            @else
                            <td>  <span class="badge bg-danger"> Deactivated</span></td>
                            @endif
                          </tr>
                          
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

















                       
                 
@endsection