@extends('layouts.app')

@section('content')

           
<div class="container">
  <div class="row">
    <!-- First Row -->
    
    <div class="col-md-4 col-lg-4 grid-margin stretch-card">
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


    <div class="col-md-4 col-lg-4 grid-margin stretch-card">
      <div class="card card-rounded">
        <div class="card-body">
            <h4 class="text-primary"> Calls </h4><hr>

          <div class="row">
            <div class="col-lg-3">
              <div class="d-flex justify-content-between align-items-center mb-2 mb-sm-0">
                <div class="circle-progress-width">
                  <div id="totalVisitors1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div>
                  <p class="text-small mb-2"><span class="text-primary">Today</span></p>
                  <h4 class="mb-0 fw-bold">26.80</h4>
                </div>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="d-flex justify-content-between align-items-center">
                <div class="circle-progress-width">
                  <div id="visitperday1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div>
                  <p class="text-small mb-2"><span class="text-primary">Incoming</span></p>
                  <h4 class="mb-0 fw-bold">26.80</h4>
                </div>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="d-flex justify-content-between align-items-center">
                <div class="circle-progress-width">
                  <div id="visitperday1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div>
                  <p class="text-small mb-2"><span class="text-primary">Outgoing</span></p>
                  <h4 class="mb-0 fw-bold">9065</h4>
                </div>
              </div>
            </div>

            <div class="col-lg-3">
              <div class="d-flex justify-content-between align-items-center">
                <div class="circle-progress-width">
                  <div id="visitperday1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div>
                  <p class="text-small mb-2"><span class="text-primary">Missed</span></p>
                  <h4 class="mb-0 fw-bold">9065</h4>
                </div>
              </div>
            </div>
            </div>
            </div>
            </div>
            </div>             


            <div class="col-md-4 col-lg-4 grid-margin stretch-card">
      <div class="card card-rounded">
        <div class="card-body">
            <h4 class="text-primary"> Leads </h4><hr>

          <div class="row">
            <div class="col-lg-4">
              <div class="d-flex justify-content-between align-items-center mb-2 mb-sm-0">
                <div class="circle-progress-width">
                  <div id="totalVisitors1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div>
                  <p class="text-small mb-2"><span class="text-primary">Hot List</span></p>
                  <h4 class="mb-0 fw-bold">26.80</h4>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="d-flex justify-content-between align-items-center">
                <div class="circle-progress-width">
                  <div id="visitperday1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div>
                  <p class="text-small mb-2"><span class="text-primary">Interested</span></p>
                  <h4 class="mb-0 fw-bold">26.80</h4>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="d-flex justify-content-between align-items-center">
                <div class="circle-progress-width">
                  <div id="visitperday1" class="progressbar-js-circle pr-2"></div>
                </div>
                <div>
                  <p class="text-small mb-2"><span class="text-primary">Not Interested</span></p>
                  <h4 class="mb-0 fw-bold">9065</h4>
                </div>
              </div>
            </div>
            </div>
            </div>
            </div>
            </div>             
</div>
@endsection

    


   
                 
                  
   
               
       

 
           
    
                       

   
                 
                  
   
               
       

 
           
    
                       


           
            
           
            
            
          



 
                 
           
   
                

                  


          

                  

    


   
                 
                  
   
               
       

 
           
    
                       

   
                 
                  
   
               
       

 
           
    
                       

    


   
                 
                  
   
               
       

 
           
    
                       

   
                 
                  
   
               
       

 
           
    
                       


           
            
           
            
            
          



 
                 
           
   
                

                  


          

                  

    


   
                 
                  
   
               
       

 
           
    
                       

   
                 
                  
   
               
       

 
           
    
                       
