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
                <form class="forms-sample" method="POST" action="{{ route('message.store') }}">
                    @csrf

                    <!-- New Category Dropdown -->
                    

                    <!-- New Title Field -->
                    <div class="form-group">
                        <label for="exampleInputTitle">Title</label>
                        <input type="text" class="form-control" id="exampleInputTitle" name="title" placeholder="Enter Title">
                    </div>

                    <!-- New Message Field -->
                    <div class="form-group">
                        <label for="exampleInputMessage">Message</label>
                        <textarea class="form-control" id="exampleInputMessage" name="message" rows="3" placeholder="Enter Message"></textarea>
                    </div>


                    <div class="form-group">
                        <label for="exampleInputCategory">Category</label>
                        <select class="form-control" id="exampleInputCategory" name="category"  placeholder="Enter Category">
                            <option value="Offer">Offer</option>
                            <option value="Announcement">Announcement</option>
                            <option value="Normal">Normal</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Add Message</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
