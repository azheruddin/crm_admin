@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-primary">Call Duration</h4><hr>
                <form action="{{ route('call_duration') }}" method="GET">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="employee_id">Employee</label>
                            <select class="form-control" id="employee_id" name="employee_id">
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                   <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                       {{ $employee->name }}
                                             </option>
                                            @endforeach

                            </select>
                        </div>
   
                        <div class="form-group col-md-4">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">Filter</button>
                        </div>
                    </div>
                </form>

                <!-- Call history table -->
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>EMPLOYEE NAME</th>
                            <th>INCOMING DURATION</th>
                            <th>OUTGOING DURATION</th>
                            <th>TOTAL DURATION</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($callDurations as $duration)
                        <tr>
                        <td>{{ $duration->employee->name }}</td>

                            @php
                                // Convert incoming duration (seconds) to minutes and seconds
                                $incomingMinutes = floor($duration->incoming_duration / 60);
                                $incomingSeconds = $duration->incoming_duration % 60;

                                // Convert outgoing duration (seconds) to minutes and seconds
                                $outgoingMinutes = floor($duration->outgoing_duration / 60);
                                $outgoingSeconds = $duration->outgoing_duration % 60;

                                // Calculate total duration
                                $totalDuration = $duration->incoming_duration + $duration->outgoing_duration;
                                $totalMinutes = floor($totalDuration / 60);
                                $totalSeconds = $totalDuration % 60;
                            @endphp

                            <!-- Display incoming duration -->
                            <td>{{ $incomingMinutes }} min {{ $incomingSeconds }} sec</td>

                            <!-- Display outgoing duration -->
                            <td>{{ $outgoingMinutes }} min {{ $outgoingSeconds }} sec</td>

                            <!-- Display total duration -->
                            <td>{{ $totalMinutes }} min {{ $totalSeconds }} sec</td>

                            <td>
                                <a href="{{ route('call_duration_detail', ['call_id' => $duration->id]) }}" class="btn btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
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
