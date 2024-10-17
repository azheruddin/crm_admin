@extends('layouts.app')

@section('content')

           
<div class="container">
  <div class="row">
    <!-- First Row -->
    
    <div class="col-md-6 col-lg-6 grid-margin stretch-card">
      <div class="card card-rounded">
        <div class="card-body">
            <h4 class="text-primary"> Employees </h4><hr>

          <div class="row">
            <div class="col-lg-4">
              <div class="d-flex justify-content-between align-items-center mb-2 mb-sm-0">
                <div class="circle-progress-width">
                  <div id="totalVisitors1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div>
                  <p class="text-small mb-2"><span class="text-primary">Total</span></p>
                  <h4 class="mb-0 fw-bold">{{ $totalEmployees }}</h4>
                  <!-- <h4 class="mb-0 fw-bold">26.80</h4> -->
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="d-flex justify-content-between align-items-center">
                <div class="circle-progress-width">
                  <div id="visitperday1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div>
                  <p class="text-small mb-2"><span class="text-primary">Active</span></p>
                  <h4 class="mb-0 fw-bold">{{ $activeEmployees }}</h4>
 
                  <!-- <h4 class="mb-0 fw-bold">26.80</h4> --> 
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="d-flex justify-content-between align-items-center">
                <div class="circle-progress-width">
                  <div id="visitperday1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div>
                  <p class="text-small mb-2"><span class="text-primary">De Active</span></p>
                  <!-- <h4 class="mb-0 fw-bold">9065</h4> -->
                  <h4 class="mb-0 fw-bold">{{ $deactivatedEmployees }}</h4>
                </div>
              </div>
            </div>
            </div>
            </div>
            </div>
            </div>


    <div class="col-md-6 col-lg- grid-margin stretch-card">
      <div class="card card-rounded">
        <div class="card-body">
        <div class="row">

        <h4 class="text-primary">
    <a href="{{ route('filter_call_history') }}"><span class="text-primary">
    Today Calls</span><span class="text-dark">&nbsp:{{ $total }}</span>
    </a>
</h4><hr>
<div class="col-lg-3">
              <div class="d-flex justify-content-between align-items-center">
                <div class="circle-progress-width">
                  <div id="visitperday1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div> 
                  <p class="text-small mb-2"><a href="{{ route('incoming_call_history') }}"><span class="text-primary">Incoming</a></span></p>
                  <h4 class="mb-0 fw-bold">{{ $incoming}}</h4>
                </div>
              </div>
            </div>



            <div class="col-lg-3">
              <div class="d-flex justify-content-between align-items-center">
                <div class="circle-progress-width">
                  <div id="visitperday1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div>
                  <p class="text-small mb-2"><span class="text-primary"> <a href="{{ route('outgoing_call_history') }}">Outgoing</a></span></p>
                  <h4 class="mb-0 fw-bold">{{ $uniqueOutgoingCallsToday}}</h4>
                </div>
              </div>
            </div>
           

            <div class="col-lg-3">
              <div class="d-flex justify-content-between align-items-center">
                <div class="circle-progress-width">
                  <div id="visitperday1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div>
                  <p class="text-small mb-2"><a href="{{ route('missed_call_history') }}"><span class="text-primary">Missed</a></span></p>
                  <h4 class="mb-0 fw-bold">{{ $missed}}</h4>
                </div>
              </div>
            </div>
  
            <div class="col-lg-3">
              <div class="d-flex justify-content-between align-items-center">
                <div class="circle-progress-width">
                  <div id="visitperday1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div>
                  <p class="text-small mb-2"><a href="{{ route('unknown_call_history') }}"><span class="text-primary">Unknown</a></span></p>
                  <h4 class="mb-0 fw-bold">{{ $unknown }}</h4>
                </div>
              </div>
            </div>


            </div>
            </div>
            </div>
            </div>             
            </div>

  <div class="col-md-6 col-lg-6 grid-margin stretch-card">
  <div class="card card-rounded">
        <div class="card-body">
        <div class="row">

        <h4 class="text-primary">

        <span class="text-primary">
    Today Uploaded Leads</span><span class="text-dark">&nbsp; {{$todaysUploadedLeads }} </span> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <span class="text-primary">
    Today Leads</span><span class="text-dark">&nbsp;{{$totalLeads }}</span>
</h4><hr>
         

            <div class="col-lg-3">
              <div class="d-flex justify-content-between align-items-center mb-2 mb-sm-0">
                <div class="circle-progress-width">
                  <div id="totalVisitors1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div>
                  <p class="text-small mb-2"><span class="text-primary">Hot</span></p>
                  <h4 class="mb-0 fw-bold">{{$hotLeads}}</h4>
                </div>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="d-flex justify-content-between align-items-center">
                <div class="circle-progress-width">
                  <div id="visitperday1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div>
                  <p class="text-small mb-2"><span class="text-primary">Interested</span></p>
                  <h4 class="mb-0 fw-bold">{{$interested}}</h4>
                </div>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="d-flex justify-content-between align-items-center">
                <div class="circle-progress-width">
                  <div id="visitperday1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div>
                  <p class="text-small mb-2"><span class="text-primary">Not Interested</span></p>
                  <h4 class="mb-0 fw-bold">{{$notInterested}}</h4>
                </div>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="d-flex justify-content-between align-items-center">
                <div class="circle-progress-width">
                  <div id="visitperday1" class="progressbar-js-circle pr-2"></div>
                </div>
            <div>
                  <p class="text-small mb-2"><span class="text-primary">Not Answered</span></p>
                  <h4 class="mb-0 fw-bold">{{$notAnswered}}</h4>
                </div>
              </div>
            </div>


            <div class="col-lg-3">
              <div class="d-flex justify-content-between align-items-center">
                <div class="circle-progress-width">
                  <div id="visitperday1" class="progressbar-js-circle pr-2"></div>
                </div>
            <div>
                  <p class="text-small mb-2"><span class="text-primary">Close</span></p>
                  <h4 class="mb-0 fw-bold">{{$close}}</h4>
                </div>
              </div>
            </div>
            </div>
            </div>
            </div>
            </div>   
            
            <!-- -->
            <!-- -->
            
          

</div>




@endsection

