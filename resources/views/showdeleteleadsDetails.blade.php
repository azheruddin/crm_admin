@extends('layouts.app')

@section('content')

<div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  
                    <h4 class="card-title text-primary">Show Delete Leads Details 
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">    
                    <!-- <a href="/leadsdelete_detail"button type="button" class="btn btn-primary justify-content-md-end" >Back</button></a> -->
                    <a href='/leads_delete'button type="button" class="btn btn-primary justify-content-md-end" >Back</button></a>


                    </div>
                    <hr></h4>  
                    
                   
                    </p>
                    <div class="table-responsive">
                      <table class="table table-hover">
                       
                        <tbody>
                          <tr>
                            <td>Customer Name</td>
                            <td>{{ $leads->customer_name }}</td>
                          </tr>
                          <tr>
                            <td>Email</td>
                            <td>{{ $leads->customer_email }}</td>
                          </tr>
                          <tr>
                            <td>Phone</td>
                            <td>{{ $leads->phone }}</td>
                          </tr>
                          
                         
                          <tr>
                            <td>Delete Reason</td>
                            <td>{{ $leads->delete_reason }}</td>  
                            </tr>

                          <tr>
                            <td>Employee</td>
                            <td>
                                @if ($leads->employee)
                                    {{ $leads->employee->name }}
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