@extends('servers.layouts.app')

@section('css')
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Flot CSS -->
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/flot/jquery.flot.pie.css">
@endsection

@section('preloader')
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="{{ asset('img/icon.svg') }}" alt="AdminLTELogo" height="60" width="60">
    </div>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <!-- Total Income -->
            <div class="col-lg-3 col-12">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h4 class="font-weight-bold">Rp {{ number_format($totalIncomeThisMonth, 0, ',', '.') }}</h4>
                        <p>Total Income This Month</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-arrow-up-a"></i>
                    </div>
                    <a href="#" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Total Expense -->
            <div class="col-lg-3 col-12">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h4 class="font-weight-bold">Rp {{ number_format($totalExpenseThisMonth, 0, ',', '.') }}</h4>
                        <p>Total Expense This Month</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-arrow-down-a"></i>
                    </div>
                    <a href="#" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Current Balance -->
            <div class="col-lg-3 col-12">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h4 class="font-weight-bold">Rp {{ number_format($currentBalance, 0, ',', '.') }}</h4>
                        <p>Current Balance</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="#" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Percentage Spent -->
            <div class="col-lg-3 col-12">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h4 class="font-weight-bold">{{ $percentageSpent }}%</h4>
                        <p>Percentage of Income Spent</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            @if (auth()->user()->role->name == 'Admin')
                <div class="col-lg-6 col-12">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h4 class="font-weight-bold">{{ $total_user ?? 0 }}</h4>
                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
                    </div>

                </div>

                <div class="col-lg-6 col-12">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h4 class="font-weight-bold">{{ $currentMonthVisitors ?? 0 }}</h4>
                            <p>Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
                    </div>

                </div>
            @endif

        </div>

        <div class="row">
            <!-- Expenses Donut Chart -->
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Expenses</h4>
                    </div>
                    <div class="card-body">
                        <div id="expenses-donut-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <!-- Income Donut Chart -->
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Income</h4>
                    </div>
                    <div class="card-body">
                        <div id="income-donut-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>

        @if (auth()->user()->role->name == 'Admin')
            <!-- Visitors Chart -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4>Action Visitors</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span id="currentVisitors" class="text-bold text-lg">{{ $currentMonthVisitors }}
                                    Action</span>
                                <span>Action Visitors This Month</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                @if ($percentageChange > 0)
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> {{ $percentageChange }}%
                                    @elseif ($percentageChange == 0)
                                        <span class="text-success">
                                            <i class="fas fa-arrow-up"></i> 100%
                                        @else
                                            <span class="text-danger">
                                                <i class="fas fa-arrow-down"></i> {{ $percentageChange }}%
                                @endif
                                </span>
                                <span class="text-muted">Since last week</span>
                            </p>
                        </div>
                        <div class="position-relative mb-4">
                            <canvas id="visitors-chart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- /.card-body -->
@endsection

@section('js')
    <!-- jQuery -->
    <script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
    @if (auth()->user()->role->name == 'Admin')
        <!-- ChartJS -->
        <script src="https://adminlte.io/themes/v3/plugins/chart.js/Chart.min.js"></script>
    @endif
    <!-- FLOT CHARTS -->
    <script src="https://adminlte.io/themes/v3/plugins/flot/jquery.flot.js"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="https://adminlte.io/themes/v3/plugins/flot/plugins/jquery.flot.resize.js"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="https://adminlte.io/themes/v3/plugins/flot/plugins/jquery.flot.pie.js"></script>

    <script>
        $(function() {
            @if (auth()->user()->role->name == 'Admin')
                // Chart for Visitors
                const visitorsCtx = $('#visitors-chart').get(0).getContext('2d');

                // Fetch data for Visitors
                $.ajax({
                    url: 'api/visitor-stats',
                    method: 'GET',
                    success: function(response) {
                        const currentMonth = response.currentMonth;
                        const lastMonth = response.lastMonth;

                        // Extract labels and datasets
                        const currentLabels = currentMonth.map(item => item.date);
                        const currentData = currentMonth.map(item => item.count);

                        const lastLabels = lastMonth.map(item => item.date);
                        const lastData = lastMonth.map(item => item.count);

                        // Combine labels for consistent X-Axis
                        const labels = [...new Set([...lastLabels, ...currentLabels])];

                        const lastMonthData = labels.map(label => {
                            const entry = lastMonth.find(item => item.date === label);
                            return entry ? entry.count : 0;
                        });

                        const currentMonthData = labels.map(label => {
                            const entry = currentMonth.find(item => item.date === label);
                            return entry ? entry.count : 0;
                        });

                        // Create the chart for Visitors
                        new Chart(visitorsCtx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                        label: 'This Month',
                                        data: currentMonthData,
                                        borderColor: 'rgba(60,141,188,0.8)',
                                        backgroundColor: 'rgba(60,141,188,0.4)',
                                        fill: true,
                                    },
                                    {
                                        label: 'Last Month',
                                        data: lastMonthData,
                                        borderColor: 'rgba(210, 214, 222, 1)',
                                        backgroundColor: 'rgba(210, 214, 222, 0.4)',
                                        fill: true,
                                    }
                                ]
                            },
                            options: {
                                maintainAspectRatio: false,
                                responsive: true,
                                plugins: {
                                    legend: {
                                        display: true
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    },
                                }
                            }
                        });
                    }
                });
            @endif

            // Fetch data for Donut Charts
            $.ajax({
                url: 'api/category-stats',
                method: 'GET',
                success: function(response) {
                    // Handle Expenses Chart
                    if (response.expenses && response.expenses.length > 0) {
                        // Render Donut Chart for Expenses
                        $.plot('#expenses-donut-chart', response.expenses, {
                            series: {
                                pie: {
                                    show: true,
                                    radius: 1,
                                    innerRadius: 0.5,
                                    label: {
                                        show: true,
                                        radius: 2 / 3,
                                        formatter: labelFormatter,
                                        threshold: 0.1
                                    }
                                }
                            },
                            legend: {
                                show: false
                            }
                        });
                    } else {
                        // If no data, show message
                        $('#expenses-donut-chart').html(
                            '<p class="text-center">No expense data available.</p>');
                    }

                    // Handle Income Chart
                    if (response.income && response.income.length > 0) {
                        // Render Donut Chart for Income
                        $.plot('#income-donut-chart', response.income, {
                            series: {
                                pie: {
                                    show: true,
                                    radius: 1,
                                    innerRadius: 0.5,
                                    label: {
                                        show: true,
                                        radius: 2 / 3,
                                        formatter: labelFormatter,
                                        threshold: 0.1
                                    }
                                }
                            },
                            legend: {
                                show: false
                            }
                        });
                    } else {
                        // If no data, show message
                        $('#income-donut-chart').html(
                            '<p class="text-center">No income data available.</p>');
                    }
                },
                error: function() {
                    console.error('Failed to fetch data for charts');
                    // Handle error by showing a message
                    $('#expenses-donut-chart').html(
                        '<p class="text-center text-danger">Failed to load expense chart data.</p>');
                    $('#income-donut-chart').html(
                        '<p class="text-center text-danger">Failed to load income chart data.</p>');
                }
            });

            // Formatter for labels
            function labelFormatter(label, series) {
                return `<div style="font-size:8pt; text-align:center; padding:2px; color:white;">${label}<br>${Math.round(series.percent)}%</div>`;
            }
        });
    </script>
@endsection
