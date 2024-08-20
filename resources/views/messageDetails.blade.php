@extends('layouts.app')

@section('content')

<div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  
                    <h4 class="card-title text-primary">Employee Details 
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">    
                    <a href="{{ route('show_message', ['message_id' => $message->id]) }}"button type="button" class="btn btn-primary justify-content-md-end" >Back</button></a>
                    </div>
                    <hr></h4>  
                    
                   
                    <!-- <p class="card-description"> Add class <code>.table-hover</code> -->
                    </p>
                    <div class="table-responsive">
                      <table class="table table-hover">
                       
                        <tbody>
                          <tr>
                            <td>Title</td>
                            <td>{{$message->title }}</td>
                          </tr>
                          <tr>
                            <td>Message</td>
                            <td>{{ $message->message }}</td>
                          </tr>
                          <tr>
                            <td>Category</td>
                            <td>{{ $message->category }}</td>
                          </tr>
                          

                          
                          
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

















                       
                 
@endsection