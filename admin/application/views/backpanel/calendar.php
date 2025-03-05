<style type="text/css">
.fc-event-title { 
    font-size: 12px !important;
    font-weight: bold !important;
}    
</style>

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        	
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h1 class="page-title fw-medium fs-18 mb-2">Full Calendar</h1>
        </div>
        </div>
        <!-- Page Header Close -->

        <!-- Start::row-1 -->
        <div class="row">

            <div class="col-xl-9">
                <div class="card custom-card">
                <div class="card-body">
                    <div id='staffcalendar'></div>
                </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card custom-card">
                    <div class="card-body p-0">
                        <div class="p-3">
                            <h6 class="align-items-center"> 
                                <!-- <p> <span class="badge bg-success rounded-circle">&nbsp;</span> - Present </p> -->
                                <p> <span class="badge bg-info">&nbsp;</span>&emsp;Appointments </p>
                                <p> <span class="badge bg-warning">&nbsp;</span>&emsp;Holidays </p>
                                <p> <span class="badge bg-danger">&nbsp;</span>&emsp;Leave </p>
                            </h6>
                        </div>
                    </div>
                </div>

                <div class="card custom-card">
                <div class="card-body p-0">
                    <div class="p-3 bg-primary">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-medium text-white"> Appointment Info </h6>
                    </div>
                    </div>

                    <div class="p-3 border-bottom" id="full-calendar-activity">
                        <ul class="list-unstyled mb-0 fullcalendar-events-activity app_detail"></ul>
                    </div>
                </div>
                </div>
            </div>

        </div>
        <!--End::row-1 -->

        
    </div>
</div>
<!-- End::content  -->

<script type="text/javascript">
    var appointments  = <?= $appoint_record; ?>;
    var holidays  = <?= $holiday_record; ?>;
    var attendance = <?= $attend_record; ?>;
</script>

<!-- Fullcalendar JS -->
<script src="<?= base_url('../assets/libs/fullcalendar/index.global.min.js'); ?>"></script>
<link rel="modulepreload" href="<?= base_url('../assets/js/fullcalendar.js'); ?>" />
<script type="module" src="<?= base_url('../assets/js/fullcalendar.js'); ?>"></script>