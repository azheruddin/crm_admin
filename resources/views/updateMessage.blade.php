@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-primary">Edit Message</h4>
                <hr>
                <form class="forms-sample" method="POST" action="{{ route('message.update', $message->id) }}">
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $message->title) }}" required>
                        @error('title')
                            <div class="text-danger">{{ $title }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" class="form-control" rows="5" required>{{ old('message', $message->message) }}</textarea>
                        @error('message')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group"> 
                        <label for="category">Category</label>
                        <input type="text" id="category" name="category" class="form-control" value="{{ old('category', $message->category) }}" required>
                        @error('category')
                            <div class="text-danger">{{ $category }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update Message</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
