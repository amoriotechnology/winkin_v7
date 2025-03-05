<style type="text/css">
    .highcharts-credits {
        display: none;
    }    
</style>

<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Start::page-header -->
        <div
            class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Dashboard</h1>
            </div>
        </div>
        <!-- End::page-header -->

        <!-- Start:: row-1 -->
        <div class="row">
            <div class="col-xxl-12">
                <div class="row">
                    <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="card custom-card border-5 rounded-4 border-top-0 border-end-0 border-bottom-0 border-success">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <div class="mb-1 text-uppercase text-dark">Bookings</div>
                                        <h4 class=" mb-0"> <?= $today_appoint; ?> </h4>
                                    </div>
                                    <div> 
                                        <span class="avatar avatar-md bg-success svg-white"> 
                                            <i class="bi bi-journal-check"></i>
                                        </span> 
                                    </div>
                                </div>
                                <div class="d-flex align-items-end flex-wrap justify-content-between mt-2">
                                    <div>
                                        <span class=""><span class="text-success fw-medium me-1 d-inline-flex"></span></span>
                                        <p class="mb-0 text-dark">Today</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="card custom-card border-5 rounded-4 border-top-0 border-end-0 border-bottom-0 border-primary">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <div class="mb-1 text-uppercase text-dark">Bookings</div>
                                        <h4 class=" mb-0"> <?= $mon_appoint; ?> </h4>
                                    </div>
                                    <div> 
                                        <span class="avatar avatar-md bg-info svg-white"> 
                                            <i class="bi bi-journal-check"></i>
                                        </span> 
                                    </div>
                                </div>
                                <div class="d-flex align-items-end flex-wrap justify-content-between mt-2">
                                    <div>
                                        <span class=""><span class="text-success fw-medium me-1 d-inline-flex"></span></span>
                                        <p class="mb-0 text-dark">This Month</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="card custom-card border-5 rounded-4 border-top-0 border-end-0 border-bottom-0 border-success">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <div class="mb-1 text-uppercase text-dark">Revenue</div>
                                        <h4 class=" mb-0">₹ <?= $today_sales; ?> </h4>
                                    </div>
                                    <div> <span class="avatar avatar-md bg-success  svg-white">
                                        <i class="bi bi-currency-rupee fs-20"></i>
                                    </span> </div>
                                </div>
                                <div class="d-flex align-items-end flex-wrap justify-content-between mt-2">
                                    <div>
                                        <span class=""><span class="text-success fw-medium me-1 d-inline-flex"></span></span>
                                        <p class="mb-0 text-dark">Today</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="card custom-card border-5 rounded-4 border-top-0 border-end-0 border-bottom-0 border-primary">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <div class="mb-1 text-uppercase text-dark">Revenue</div>
                                        <h4 class=" mb-0">₹ <?= $monthly_sales; ?> </h4>
                                    </div>
                                    <div> <span class="avatar avatar-md bg-info  svg-white">
                                        <i class="bi bi-currency-rupee fs-20"></i>
                                        
                                    </span> </div>
                                </div>
                                <div class="d-flex align-items-end flex-wrap justify-content-between mt-2">
                                    <div>
                                        <span class=""><span class="text-success fw-medium me-1 d-inline-flex"></span></span>
                                        <p class="mb-0 text-dark">This Month</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="card custom-card border-5 rounded-4 border-top-0 border-end-0 border-bottom-0 border-success">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <div class="mb-1 text-uppercase text-dark">Customers</div>
                                        <h4 class=" mb-0"> <?= $totcust; ?> </h4>
                                    </div>
                                    <div> <span class="avatar avatar-md bg-success svg-white"> 
                                        <i class="ti ti-users fs-20"></i> </span> 
                                    </div>
                                </div>
                                <div class="d-flex align-items-end flex-wrap  justify-content-between mt-2">
                                    <div>
                                        <span class=""><span class="text-danger fw-medium me-1 d-inline-flex"></span></span>
                                        <p class="mb-0 text-dark">Total Customers</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="row">
           <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-6 mb-4">
                <div id="booking_chart"></div>
            </div> 

            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-6 mb-4">
                <div id="revenue_chart"></div>
            </div> 
        </div>
        <!-- End:: row-1 -->

    </div>
</div>
<!-- End::content  -->


<script type="text/javascript">

// Booking Charts
var bookingData = <?php echo $booking_chart_data; ?>;
Highcharts.chart('booking_chart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Bookings ' + new Date().getFullYear()
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        crosshair: true,
        accessibility: {
            description: 'Bookings'
        }
    },
    yAxis: {
        min: 0,
        max: 5,
        title: {
            text: 'Bookings Count'
        }
    },
    tooltip: {
        valueSuffix: 'Bookings'
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{y}',
                style: {
                    fontWeight: 'bold',
                    color: '#000'
                }
            }
        }
    },
    series: [
        {
            name: 'This Year Bookings',
            data: bookingData
        }
    ]
});


// Revenue Charts

 var revenueData = [];
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    <?php foreach ($monthly_revenue as $row) { ?>
        revenueData.push({
            month: '<?= date('M', strtotime($row['month'] . "-01")) ?>', 
            total: <?= $row['total_revenue'] ?>
        });
    <?php } ?>

    var chartData = months.map(m => {
        var found = revenueData.find(r => r.month === m);
        return found ? found.total : 0;
    });

    Highcharts.chart('revenue_chart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Revenue ' + new Date().getFullYear()
        },
        xAxis: {
            categories: months, 
            crosshair: true
        },
        yAxis: {
            min: 0,
            max: 500,
            title: {
                text: 'Revenue Amount'
            }
        },
        tooltip: {
            valueSuffix: ' INR'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{y}'
                }
            }
        },
        series: [
            {
                name: 'This Year Revenue',
                data: chartData 
            }
        ]
    });

</script>
