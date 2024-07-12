@extends('layouts.app')

@section('content')
<div class="row">
              <!-- <div class="col-md-6 grid-margin stretch-card"> -->
    
                <div class="card">
                @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
                  <div class="card-body">
                    <h4 class="card-title text-primary">Add New Leads</h4>
               
                    <hr>
                    <form class="forms-sample" method="POST" action="{{ route('add_leads_store') }} "> 
            @csrf
                    
                      <div class="form-group">
                        <label for="exampleInputUsername1">Name</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" name="customer_name" placeholder="Leads"> 
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="customer_email" placeholder="Enter Email">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Phone Number</label>
                        <input type="number" class="form-control" id="exampleInputEmail1" name="phone" placeholder="Enter Phone Number">
                      </div>

                      <div class="form-group">
                    <label for="state">State</label>
                    <select class="form-control" id="state" name="state" onchange="fetchCities(this.value)">
                        <option value="">Select State</option>
                        @foreach($States as $state)
                            <option value="{{ $state->state_id }}">{{ $state->state_name }}</option>  
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                        <label for="city">City</label>
                        <select class="form-control" id="city" name="city">
                            <option value="">Select City</option>
                        </select>
                    </div>
               
                      <button type="submit" class="btn btn-primary me-2">Add Leads</button>
                      <button class="btn btn-light">Cancel</button>
                    </form>
                  </div>
                </div>
              <!-- </div> -->
</div>

<script>
function fetchCities(stateId) {
    if (stateId) {
        // alert(stateId);
        fetch(`/get-cities/${stateId}`)
            .then(response => response.json())
            .then(data => {
                const citySelect = document.getElementById('city');
                citySelect.innerHTML = '<option value="">Select City</option>';
                data.forEach(city => {
                    citySelect.innerHTML += `<option value="${city.city_id}">${city.city_name}</option>`;
                });
            })
            .catch(error => console.error('Error:', error));
    } else {
        document.getElementById('city').innerHTML = '<option value="">Select City</option>';
    }
}
</script>
@endsection