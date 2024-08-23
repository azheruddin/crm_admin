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
                <h4 class="card-title text-primary">Add Message</h4>                  
                <hr>
                <form class="forms-sample" method="POST" action="{{ route('message.store') }}" onsubmit="return validateForm()">
                    @csrf

                    <!-- New Category Dropdown -->
                    <div class="form-group">
                        <label for="exampleInputCategory">Category</label>
                        <select class="form-control" id="exampleInputCategory" name="category"> 
                            <option value="">Select Category</option>
                            <option value="Offer">Offer</option>
                            <option value="Announcement">Announcement</option>
                            <option value="Normal">Normal</option>
                            <option value="Other">Other</option>
                        </select>
                        <span id="categoryError" class="text-danger"></span>
                    </div>

                    <!-- New Title Field -->
                    <div class="form-group">
                        <label for="exampleInputTitle">Title</label>
                        <input type="text" class="form-control" id="exampleInputTitle" name="title" placeholder="Enter Title">
                        <span id="titleError" class="text-danger"></span> 
                    </div>

                    <!-- New Message Field -->
                    <div class="form-group">
                        <label for="exampleInputMessage">Message</label>
                        <textarea class="form-control" id="exampleInputMessage" name="message" rows="10" style="height:100%;" placeholder="Enter Message"></textarea>
                        <span id="messageError" class="text-danger"></span>
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Add Message</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Validation Script -->
<script>
    function validateForm() {
        let isValid = true;

        // Clear previous errors
        document.getElementById('categoryError').textContent = '';
        document.getElementById('titleError').textContent = '';
        document.getElementById('messageError').textContent = '';

        // Validate Category
        const category = document.getElementById('exampleInputCategory').value;
        if (category === '') {
            document.getElementById('categoryError').textContent = 'Please select a category.';
            isValid = false;
        }

        // Validate Title
        const title = document.getElementById('exampleInputTitle').value.trim();
        if (title === '') {
            document.getElementById('titleError').textContent = 'Please enter a title.';
            isValid = false;
        }

        // Validate Message
        const message = document.getElementById('exampleInputMessage').value.trim();
        if (message === '') {
            document.getElementById('messageError').textContent = 'Please enter a message.';
            isValid = false;
        }

        return isValid;
    }
</script>
@endsection
