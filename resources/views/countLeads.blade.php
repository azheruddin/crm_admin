@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-primary">Leads Summary by Employee</h4>
                <hr>

                <!-- <form action="{{ route('count_leads') }}" method="GET"> -->
                <form action="{{ route('count_leads') }}" method="GET">
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
                    
                <!-- Leads table grouped by employee -->
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>SERIAL NO.</th>
                            <th>EMPLOYEE</th>
                            <th>ALL</th>
                            <th>TODAY UPLOAD</th>
                            <th>NEW</th>
                             <th>FOLLOW UP</th>
                            <th>HOT</th>
                            <th>INTERESTED</th>
                            <th>NOT ANSWERED</th>
                            <th>NOT INTERESTED</th>
                            <th>CLOSE</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $index => $employee)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->totalLeads ?? 0 }}</td> <!-- Hot leads count -->
                                <td>{{ $employee->todaysUploadedLeads ?? 0 }}</td> <!-- Hot leads count -->
                                <td>{{ $employee->newLeads ?? 0 }}</td> <!-- Hot leads count -->
                                <td>{{ $employee->followUpLeads ?? 0 }}</td> <!-- Hot leads count -->
                                <td>{{ $employee->hotLeads ?? 0 }}</td> <!-- Hot leads count -->
                                <td>{{ $employee->interested ?? 0 }}</td> <!-- Interested leads count -->
                                <td>{{ $employee->notAnswered ?? 0 }}</td> <!-- No Answer leads count -->
                                 <td>{{ $employee->notInterested ?? 0 }}</td> <!-- Not Interested leads count -->
                                <td>{{ $employee->close ?? 0 }}</td> <!-- No Answer leads count -->
                                <!--  <td> Logic for the next follow-up can be added here </td>  -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>     
            </div>
        </div> 
    </div>
</div>
@endsection
