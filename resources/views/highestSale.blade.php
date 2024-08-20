@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <!-- Add your CSS here -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .tabs {
            display: flex;
            cursor: pointer;
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
        }

        .tab {
            flex: 1;
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            border-bottom: none;
            background-color: #f9f9f9;
            border-radius: 8px 8px 0 0;
            font-size: 16px;
            font-weight: 500;
            color: #333;
            transition: background-color 0.3s, color 0.3s;
        }

        .tab.active {
            background-color: #007bff;
            color: #fff;
            border-bottom: 2px solid #007bff;
            font-weight: bold;
        }

        .tab-content {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 0 0 8px 8px;
            background-color: #fff;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .tab-content ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tab-content ul li {
            padding: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            transition: background-color 0.3s;
        }

        .tab-content ul li:hover {
            background-color: #f1f1f1;
        }

        .tab-content ul li .item {
            font-weight: bold;
            color: #333;
        }

        .tab-content ul li .amount {
            color: #007bff;
        }

        .no-sales {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .tab {
                font-size: 14px;
                padding: 10px;
            }

            .container {
                width: 95%;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<div class="container">
<div class="heading">
<h4 class="card-title text-primary">Highest Sales</h4><hr>
</div>

    <div class="tabs">
        <div class="tab active" data-target="today-sales" bg="bg-primary">Today’s Sales</div>
        <div class="tab" data-target="monthly-sales">Monthly Sales</div>
    </div>

    <div id="today-sales" class="tab-content active">
    <table border="1" class="table">
        <thead>
            <tr> 
                <th>Rank</th>
                <th>Employee Name</th>
                <th>Total Sales</th>
            </tr>
        </thead>
        <tbody>
            @php $rank = 1; @endphp
            @foreach ($topSalesToday as $sale)
                <tr>
                    <td>{{ $rank++ }}</td> <!-- Increment rank with each iteration -->
                    <td>{{ $sale->employee_name }}</td>
                    <td>₹ {{ number_format($sale->total_sales, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div> 

    <div id="monthly-sales" class="tab-content">
        @if($topSales->isEmpty())
            <p class="no-sales">No sales this month.</p>
        @else
        <table border="1" class="table">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Employee Name</th>
                <th>Total Sales</th>
            </tr>
        </thead>
        <tbody>
            @php $rank = 1; @endphp
            @foreach ($topSales as $sale)
                <tr>
                    <td>{{ $rank++ }}</td> <!-- Increment rank with each iteration -->
                    <td>{{ $sale->employee_name }}</td>
                    <td>₹ {{ number_format($sale->total_sales, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
        @endif
    </div>
</div>

<script>
    // JavaScript for tab switching
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                contents.forEach(c => c.classList.remove('active'));

                // Add active class to the clicked tab and corresponding content
                tab.classList.add('active');
                document.getElementById(tab.getAttribute('data-target')).classList.add('active');
            });
        });
    });
</script>

</body>
</html>
@endsection
