@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-primary">Sales Report</h4>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">    
                        <a href="/sales" class="btn btn-primary">Back</a>
                    </div>
                    <hr>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="salesTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="today-tab" data-bs-toggle="tab" href="#today-sales" role="tab" aria-controls="today-sales" aria-selected="true">Today’s Sales</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="monthly-tab" data-bs-toggle="tab" href="#monthly-sales" role="tab" aria-controls="monthly-sales" aria-selected="false">Monthly Sales</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content mt-3" id="salesTabsContent">
                        <div class="tab-pane fade show active" id="today-sales" role="tabpanel" aria-labelledby="today-tab">
                            @if($todaySales->isEmpty())
                                <p>No sales today.</p>
                            @else
                                <ul class="list-group">
                                    @foreach($todaySales as $sale)
                                        <li class="list-group-item">
                                            {{ $sale->item }}: ${{ number_format($sale->amount, 2) }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="monthly-sales" role="tabpanel" aria-labelledby="monthly-tab">
                            @if($monthlySales->isEmpty())
                                <p>No sales this month.</p>
                            @else
                                <ul class="list-group">
                                    @foreach($monthlySales as $sale)
                                        <li class="list-group-item">
                                            {{ $sale->item }}: ${{ number_format($sale->amount, 2) }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
