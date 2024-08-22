@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card-body">
                <h4 class="card-title text-primary">Show Messages</h4>
                <hr>
                
                <!-- table goes here -->
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                        <tr>
                            <td>{{ $message->title }}</td> 
                            <td>{{ $message->message }}</td>
                            <td>{{ $message->category }}</td>
                            <td>              
                                <a href="{{ route('message_detail', ['id' => $message->id]) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('message.edit', ['id' => $message->id]) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('messages.destroy', ['id' => $message->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this message?');"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
