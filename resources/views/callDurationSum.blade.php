@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <!-- <h4 class="card-title text-primary">Call Duration</h4><hr> -->
                <a class="nav-link" href="{{ route('call_duration') }}">Call Duration Sum</a>

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
                        @foreach($employeeDurations as $duration)
                        <tr>
                            <td>{{ $duration['employee']->name }}</td>

                            <!-- Display incoming duration -->
                            <td>{{ $duration['incomingDurationFormatted'] }}</td>

                            <!-- Display outgoing duration -->
                            <td>{{ $duration['outgoingDurationFormatted'] }}</td>

                            <!-- Display total duration -->
                            <td>{{ $duration['totalDurationFormatted'] }}</td>

                            <td>
                                <a href="{{ route('call_duration_detail', ['call_id' => $duration['employee']->id]) }}" class="btn btn-info">
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
