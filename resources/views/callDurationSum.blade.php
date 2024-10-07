@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-primary">Calls Status Today</h4>
                <hr>

                <!-- <form action="{{ route('call_duration') }}" method="GET"> -->
                <form action="{{ route('call_duration') }}" method="GET">
            <div class="form-group col-md-3">
                <label for="">Employee</label> 
                <select class="form-control" id="employee_id" name="employee_id" onchange="this.form.submit()">
                    <option value="">Select Employee</option>
                    @foreach($employeesSelect as $employee)
                    <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                    @endforeach
                </select>

                <!-- <button type="submit" class="btn btn-primary btn-block">Search</button> -->
            </div>
        </form>
                <!-- Calls and Leads table grouped by employee -->
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>SERIAL NO.</th>
                            <th>EMPLOYEE</th>
                            <th>TODAY CALLS</th> <!-- Today’s calls -->
                            <th>INCOMING CALLS</th> <!-- Incoming calls -->
                            <th>OUTGOING CALLS</th> <!-- Outgoing calls -->
                            <th>MISSED CALLS</th> <!-- Missed calls -->
                            <th>UNKNOWN CALLS</th> <!-- Unknown calls -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $index => $employee)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->todayCalls ?? 0 }}</td> <!-- Today’s calls -->
                                <td>{{ $employee->incoming ?? 0 }}</td> <!-- Incoming calls -->
                                <td>{{ $employee->outgoing ?? 0 }}</td> <!-- Outgoing calls -->
                                <td>{{ $employee->missed ?? 0 }}</td> <!-- Missed calls -->
                                <td>{{ $employee->unknown ?? 0 }}</td> <!-- Unknown calls -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>     
            </div>
        </div> 
    </div>
</div>
@endsection
