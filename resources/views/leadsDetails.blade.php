@extends('layouts.app')

@section('content')

<div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  
                    <h4 class="card-title text-primary">LeadsFeedback Details 
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">    
                    <a href="/leads_feedback"><button type="button" class="btn btn-primary justify-content-md-end">Back</button></a>

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
                            <td>Lead Stage</td>
                            <td>{{ $leads->lead_stage }}</td>
                          </tr>
                          <tr>
                            <td>Lead Date</td>
                            <td>{{ $leads->created_at }}</td>
                          </tr>
                          <tr>
                            <td>Next_Follow_Up</td>
                            <td>{{ $leads->next_follow_up }}</td>
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




              <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title text-primary">Lead Review 
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <!-- <a href="/leads_feedback" class="btn btn-primary justify-content-md-end">Back</a> -->
                    <!-- <a href="{{ route('leads_feedback', ['id' => $lead_review->id]) }}" class="btn btn-primary">View Review</a> -->

                </div>
                <hr>
            </h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td>Lead ID</td>
                            <td>{{ $lead_review->lead_id }}</td>
                        </tr>
                        <tr>
                            <td>Employee ID</td>
                            <td>{{ $lead_review->employee_id }}</td>
                        </tr>
                        <tr>
                            <td>Review Text</td>
                            <td>{{ $lead_review->review_text }}</td>
                        </tr>
                        <tr>
                            <td>Call Date</td>
                            <td>{{ $created_at->call_date }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

                 
@endsection



