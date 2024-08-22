@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-primary">Edit Message</h4>
                <hr>
                <form class="forms-sample" method="POST" action="{{ route('message.update', $message->id) }}">
                @csrf


                <div class="form-group">
              <label for="category">Category</label>
              <select class="form-control" id="category" name="category" required>
        <option value="Offer" {{ $message->category == 'Offer' ? 'selected' : '' }}>Offer</option>
        <option value="Announcement" {{ $message->category == 'Announcement' ? 'selected' : '' }}>Announcement</option>
        <option value="Normal" {{ $message->category == 'Normal' ? 'selected' : '' }}>Normal</option>
        <option value="Other" {{ $message->category == 'Other' ? 'selected' : '' }}>Other</option>
    </select>
</div>
                   
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control" value="{{  $message->title }}" required>
                      
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" class="form-control" rows="10" style="height:100%;" required>{{ $message->message }}</textarea>
                       
                    </div>
                   

                    <button type="submit" class="btn btn-primary">Update Message</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
