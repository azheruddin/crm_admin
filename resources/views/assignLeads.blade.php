@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card-body">
                <h4 class="card-title text-primary">Assign Leads</h4>
                <hr>
                <form class="forms-sample" method="POST" action="assign_leads_employee"> 
                    @csrf
                    <div class="form-group">
                        <label for="state">State</label>
                        <select class="form-control" id="state" name="state_id" onchange="fetchCities(this.value)">
                            <option value="">Select State</option>
                            @foreach($States as $state)
                                <option value="{{ $state->state_id }}">{{ $state->state_name }}</option>  
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="city">City</label>
                        <select class="form-control" id="city" name="city_id">
                            <option value="">Select City</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="employee_id">Employee</label>
                        <select class="form-control" id="employee_id" name="employee_id">
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                   
                    <button type="submit" class="btn btn-primary me-2">Assign</button>
                </form>
            </div>
        </div>
    </div>
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
