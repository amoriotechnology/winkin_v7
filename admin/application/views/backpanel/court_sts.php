<?php
    $weeks = !empty($cmpy_info['fld_weekdays']) ? json_decode($cmpy_info['fld_weekdays']) : [];
?>

<link rel="stylesheet" type="text/css" href="<?= base_url('../assets/css/calander.css'); ?>" />

<style type="text/css">
    .sticky-header {
        position: sticky;
        top: 0; 
        background: white; 
        padding: 10px;
        z-index: 1000; 
        border-bottom: 1px solid #ddd;
    }
    .reason-text {
        white-space: nowrap;         
        overflow: hidden;          
        text-overflow: ellipsis;     
        max-width: 200px;            
        display: inline-block; 
    }
</style>

<div class="main-content app-content">
    <div class="container-fluid">

      <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div> <h1 class="page-title fw-medium fs-18 mb-2">Court Status</h1> </div>
      </div>

        <div class="row">
            <div class="card-body">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">

                    <span class="choose-time-error-msg text-center"></span>
                    <div class="row justify-content-center summary-view" id="staffCalender">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="d-flex justify-content-center">
                                    <ul class="nav nav-tabs mb-3 tab-style-6 bg-white rounded-pill border-dark" id="myTab1" role="tablist">
                                        <li class="nav-item" role="presentation"> 
                                            <label for="courtA" class="active court_btn nav-link w-lg rounded-pill text-center" data-bs-toggle="tab" role="tab"> <b>Court A</b> </label>
                                            <input name="admincourt" class="d-none border-dark form-check-input form-checked-primary rounded-circle" type="radio" value="courtA" data-duration="30" data-rate="600" id="courtA" >
                                        </li>
                                        <li class="nav-item" role="presentation"> 
                                            <label for="courtB" class="court_btn nav-link w-lg rounded-pill text-center" data-bs-toggle="tab" role="tab"> <b>Court B</b> </label> 
                                            <input name="admincourt" class="d-none border-dark form-check-input form-checked-primary rounded-circle" type="radio" value="courtB" data-duration="30" data-rate="600" id="courtB" >
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="calendar-container">
                                  <div class="calendar-month-arrow-container">
                                    <div class="calendar-month-year-container">
                                      <select class="calendar-years"></select>&nbsp;&nbsp;
                                      <select class="calendar-months"></select>
                                    </div>
                                    <div class="calendar-month-year"></div>
                                    <div class="calendar-arrow-container">
                                      <button type="button" class="calendar-today-button"></button>
                                      <button type="button" class="calendar-left-arrow"> <i class="bi bi-caret-left-fill"></i> </button>
                                      <button type="button" class="calendar-right-arrow"> <i class="bi bi-caret-right-fill"></i> </button>
                                    </div>
                                  </div>
                                  <ul class="calendar-week"></ul>
                                  <ul class="calendar-days"></ul>
                                </div>
                                <input type="hidden" name="court_date" id="court_date" value="<?= CURDATE; ?>">
                            </div>

                            <div class="col-xl-6">
                                <div class="row mt-4" id="courtTimeCal"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

    </div>
</div>


<script type="text/javascript" src="<?= base_url('../assets/js/schedular/popper.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('../assets/js/schedular/jquery-ui.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('../assets/js/schedular/select2.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('../assets/js/schedular/jquery.mCustomScrollbar.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('../assets/js/schedular/jquery.datetimepicker.full.min.js'); ?>"></script>

<script type="text/javascript">
$(window).on("load", function() {
    
    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    var appcourt = $("input[name='admincourt']:checked").val();
    var appdate = $("#court_date").val();
    var apptime = '<?= date('H:i A') ?>';

    getdetails('<?= base_url('getCourtTiming') ?>', {[csrfName]: csrfHash, court:appcourt, date:appdate, apptime:apptime, appkey:0}, 'courtTimeCal');

    /* -------- when click calendar date active change calender date --------- */
    $("body").on("click", ".cal-date, input[name='admincourt']", function(event) {

        var selectCourt = $("input[name='admincourt']:checked").val();
        var selectedDate = $(this).data('date');
        selectedDate = (selectedDate == undefined) ? $("#court_date").val() : selectedDate;
        $('#court_date').val(selectedDate);
        $('.cal-date').removeClass('calendar-day-active');
        $('.cal-date[data-date="'+selectedDate+'"]').addClass('calendar-day-active');
        console.log(selectedDate);

        $('#courtTimeCal').empty();
        if(selectedDate != "" && selectCourt != "") {
            getdetails('<?= base_url('getCourtTiming') ?>', {[csrfName]: csrfHash, court:selectCourt, date: selectedDate, apptime: apptime, appkey:0}, 'courtTimeCal');
        }
    });

});

const settingweeks = <?= (!empty(json_encode($weeks)) ? json_encode($weeks) : []); ?>;

</script>

<script src="<?= base_url('../assets/js/calander.js'); ?>"></script>
