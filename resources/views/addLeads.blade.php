@extends('layouts.app')

@section('content')
<div class="row">
    <div class="card">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card-body"> 
            <h4 class="card-title text-primary">Add New Leads</h4>
            <hr>
            <form class="forms-sample" method="POST" action="{{ route('leads.store') }}" onsubmit="return validateForm()"> 
                @csrf
                <div class="form-group">
                    <label for="exampleInputUsername1">Name</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" name="customer_name" placeholder="Leads">
                    <span id="nameError" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="customer_email" placeholder="Enter Email">
                    <span id="emailError" class="text-danger"></span>
                    
                </div>
                <div class="form-group">
                    <label for="exampleInputPhone">Phone Number</label>
                    <input type="number" class="form-control" id="exampleInputPhone" name="phone" placeholder="Enter Phone Number">
                    <span id="phoneError" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="state">State</label>
                    <select class="form-control" id="state" name="state" onchange="fetchCities(this.value)">
                        <option value="">Select State</option>
                        @foreach($States as $state)
                            <option value="{{ $state->state_id }}">{{ $state->state_name }}</option>  
                        @endforeach
                    </select>
                    <span id="stateError" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <select class="form-control" id="city" name="city">
                        <option value="">Select City</option>
                    </select>
                    <span id="cityError" class="text-danger"></span>
                </div>
                <button type="submit" class="btn btn-primary me-2">Add Leads</button>
                <button type="reset" class="btn btn-light">Cancel</button>
            </form>
        </div>
    </div>
</div>

<script>
function validateForm() {
    let isValid = true;

    // Clear previous errors
    document.getElementById('nameError').textContent = '';
    document.getElementById('emailError').textContent = '';
    document.getElementById('phoneError').textContent = '';
    document.getElementById('stateError').textContent = '';
    document.getElementById('cityError').textContent = '';

    // Validate Name
    const name = document.getElementById('exampleInputUsername1').value.trim();
    if (name === '') {
        document.getElementById('nameError').textContent = 'Please enter a name.';
        isValid = false;
    }

    // Validate Email
    const email = document.getElementById('exampleInputEmail1').value.trim();
    if (email === '') {
        document.getElementById('emailError').textContent = 'Please enter an email address.';
        isValid = false;
    } else if (!validateEmail(email)) {
        document.getElementById('emailError').textContent = 'Please enter a valid email address.';
        isValid = false;
    }

    // Validate Phone
    const phone = document.getElementById('exampleInputPhone').value.trim();
    if (phone === '') {
        document.getElementById('phoneError').textContent = 'Please enter a phone number.';
        isValid = false;
    } else if (!/^\d{10}$/.test(phone)) {
        document.getElementById('phoneError').textContent = 'Please enter a valid 10-digit phone number.';
        isValid = false;
    }

    // Validate State
    const state = document.getElementById('state').value;
    if (state === '') {
        document.getElementById('stateError').textContent = 'Please select a state.';
        isValid = false;
    }

    // Validate City
    const city = document.getElementById('city').value;
    if (city === '') {
        document.getElementById('cityError').textContent = 'Please select a city.';
        isValid = false;
    }

    return isValid;
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function fetchCities(stateId) {
    if (stateId) {
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
