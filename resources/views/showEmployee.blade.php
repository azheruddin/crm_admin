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
                  <h4 class="card-title text-primary">Show Employees</h4><hr>
                   
                    <!-- table goes here -->
                    

<table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Employee Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($employees as $employee)
        <tr>
            <td>{{ $employee->name }}</td>
            <td>{{ $employee->email }}</td>
            <td>{{ $employee->phone }}</td>
            <td>{{ $employee->type }}</td>
            <td>
            <a href="{{ route('employees.toggle', ['id' => $employee->id]) }}" class="btn btn-{{ $employee->is_active ? 'danger' : 'success' }}" onclick="return confirm('Are you sure you want to {{ $employee->is_active ? 'deactivate' : 'activate' }} this employee?');">
             {{ $employee->is_active ? 'Deactivate' : 'Activate' }}
            </a>
            </td>
            <td>              
          <a href="{{ route('employee_detail', ['employee_id' => $employee->id]) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
          <a href="{{ route('employees.edit', ['id' => $employee->id]) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
          <form action="{{ route('employees.destroy', ['id' => $employee->id]) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this employee?');"><i class="fa fa-trash"></i></button>
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