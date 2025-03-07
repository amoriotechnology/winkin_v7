<link rel="stylesheet" type="text/css" href="<?= base_url('../assets/css/booking_style.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?= base_url('../assets/css/calander.css'); ?>" />
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<style>
    .text-fixed-white {
      color: white;
    }
    .fw-medium {
      font-weight: 500;
    }
    .fw-semibold {
      font-weight: 600;
    }
    .landing-banner-heading {
      font-size: 24px;
    }
    .booked-slot {
        background-color: #ffcccc !important; 
        border-color: #ff0000 !important; 
        cursor: not-allowed;
        opacity: 0.6;
    }

    @media (max-width: 576px) { 
        .nav-tabs {
            display: flex !important;
            flex-wrap: nowrap !important;
            overflow-x: auto;
            white-space: nowrap;
        }
    }
    .time-active .align-items-center {
        color: #ffffff !important;
    }
    .border-end {
        background-color: #58c437 !important;
        border-radius: 0px 25px 25px 0px;
    }
    .border-start {
        background-color: #58c437 !important;
        border-radius: 25px 0px 0px 25px;
    }
    
    .wizard-nav{
        display: none !important; 
    }

    .no-dropdown {
    all: unset;
    display: inline-block;
    font-size: 16px;
    font-weight: bold;
    color: #5b6e00;
    cursor: text !important;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-color: transparent;
    padding-right: 10px;
   }

    small{
        font-size: 1.0em;
        font-weight: bold;
    }

</style>


<style type="text/css">
    .owl-carousel .item img {
    width: 100%;          
    height: 300px;        
    object-fit: cover;   
    border-radius: 10px;  
    transition: transform 0.3s ease;
}

.bg-orange {
    background-color: orange !important;
    color: black;
}
</style>

<?php 
$appkey = 0;
$appservs = $app_coup_name = "";
$app_date = CURDATE;
$app_time = [];
$gettimingcount = 0;
$weeks = !empty($setting_data[0]['fld_weekdays']) ? json_decode($setting_data[0]['fld_weekdays']) : [];

if(!empty($edit_appoint)) {
    $appkey = array_keys($edit_appoint)[0];
    $appservs = $edit_appoint[$appkey]['app_serv'];
    $app_time = $edit_appoint[$appkey]['app_time'];
    $gettimingcount = count(explode(",",$app_time));
    $app_date = $edit_appoint[$appkey]['app_date'];
    $app_coup_name = $edit_appoint[$appkey]['coup_name'];
} 

?>

<!-- Booking Detail Modal -->
<div class="main-content app-content">
    <div class="modal fade" id="customerDetailsModal" aria-labelledby="ViewCustModalToggleLabel" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white" id="ViewCustModalToggleLabel">Booking Details</h6>
                    <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th class="table-info text-uppercase" width="30%">Booking ID</th>
                                <td><span id="custid"></span></td>
                            </tr>
                            <tr>
                                <th class="table-info text-uppercase" width="30%">Name</th>
                                <td><span id="cname"></span></td>
                            </tr>
                            <tr>
                                <th class="table-info text-uppercase" width="30%">Phone</th>
                                <td><span id="cphone"></span></td>
                            </tr>
                            <tr>
                                <th class="table-info text-uppercase" width="30%">Court</th>
                                <td><span id="courtname"></span></td>
                            </tr>
                            <tr>
                                <th class="table-info text-uppercase" width="30%">Slot Date</th>
                                <td><span id="slotdate"></span></td>
                            </tr>
                            <tr>
                                <th class="table-info text-uppercase" width="30%">Slot Time</th>
                                <td><span id="slottime"></span></td>
                            </tr>
                            <tr>
                                <th class="table-info text-uppercase" width="30%">Payment&nbsp;Mode</th>
                                <td><span id="paymentmode"></span></td>
                            </tr>
                            <tr>
                                <th class="table-info text-uppercase" width="30%">Booking&nbsp;Status</th>
                                <td><span id="bookstatus"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="section section-bg" id="booking" >
        <div class="container">
            <!-- Start::row-1 -->
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header text-center">
                            <h5 class="text-dark fw-semibold"><?= ($appkey > 0) ? $appkey.' - Reschedule' : 'Book Your Court'; ?></h5>
                        </div>
                        <div class="card-body p-0">
                            <form class="wizard wizard-tab horizontal" method="POST" id="appointment_form">
                                <input type="hidden" id="csrftoken" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">

                                <aside class="wizard-content container">
                                    <div class="wizard-step" data-title="Date & Time" data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu" data-limit="3">

                                        <div class="choose-time-error-msg text-center mb-2" tabindex="-1"></div>
                                        <div class="row" id="staffCalender">

                                            <div class="col-xl-12">
                                                <div class="d-flex justify-content-center">
                                                    <ul class="nav nav-tabs mb-3 tab-style-6 rounded border-dark mobile_viewtabs" id="myTab1" role="tablist" style="background-color: #dfdedd; height: 55px;">
                                                        <li class="nav-item" role="presentation"> 
                                                            <label for="courtA" class="<?= ($appservs == 'courtA' || $appservs == "") ? 'active' : '' ?> court_btn nav-link w-lg rounded text-center" data-value="courtA" data-bs-toggle="tab" role="tab"> <b>Court A</b> </label>
                                                            <input name="admincourt" class="d-none fs-5 border-dark form-check-input form-checked-primary rounded" type="radio" value="courtA" data-duration="<?= !empty($cmpy_info['fld_court_duration']) ? $cmpy_info['fld_court_duration'] : '' ?>" data-rate="<?= !empty($cmpy_info['fld_court_rate']) ? $cmpy_info['fld_court_rate'] : '' ?>" id="courtA" checked <?= ( (!empty($appservs) && ($appservs == 'courtA') ) ? 'checked' : ''); ?>>
                                                            <input type="hidden" name="court_dura[courtA]" value="<?= !empty($cmpy_info['fld_court_duration']) ? $cmpy_info['fld_court_duration'] : '' ?>">
                                                            <input type="hidden" name="court_rate[courtA]" value="<?= !empty($cmpy_info['fld_court_rate']) ? $cmpy_info['fld_court_rate'] : '' ?>">
                                                        </li>
                                                        <li class="nav-item" role="presentation"> 
                                                            <label for="courtB" class="<?= ($appservs == 'courtB') ? 'active' : '' ?> court_btn nav-link w-lg rounded text-center" data-value="courtB" data-bs-toggle="tab" role="tab"> <b>Court B</b> </label> &nbsp;
                                                            <input name="admincourt" class="d-none fs-5 border-dark form-check-input form-checked-primary rounded" type="radio" value="courtB" data-duration="<?= !empty($cmpy_info['fld_court_duration']) ? $cmpy_info['fld_court_duration'] : '' ?>" data-rate="<?= !empty($cmpy_info['fld_court_rate']) ? $cmpy_info['fld_court_rate'] : '' ?>" id="courtB" <?= ( (!empty($appservs) && ($appservs == 'courtB') ) ? 'checked' : ''); ?>>
                                                            <input type="hidden" name="court_dura[courtB]" value="<?= !empty($cmpy_info['fld_court_duration']) ? $cmpy_info['fld_court_duration'] : '' ?>">
                                                            <input type="hidden" name="court_rate[courtB]" value="<?= !empty($cmpy_info['fld_court_rate']) ? $cmpy_info['fld_court_rate'] : '' ?>">
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
                                                      <button type="button" class="d-none calendar-today-button"></button>
                                                      <button type="button" class="calendar-left-arrow"> <i class="bi bi-caret-left-fill"></i> </button>
                                                      <button type="button" class="calendar-right-arrow"> <i class="bi bi-caret-right-fill"></i> </button>
                                                    </div>
                                                  </div>
                                                  <ul class="calendar-week"></ul>
                                                  <ul class="calendar-days"></ul>
                                                </div>
                                                <input type="hidden" name="court_date" id="court_date" value="<?= $app_date; ?>">
                                                <input type="hidden" name="existing_slot" id="existing_slot" value="<?= $gettimingcount; ?>">
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="row mt-4" id="courtCal"></div>
                                                <p style="margin-left: 10px;" id="viewTimes"></p>
                                            </div>
                
                                            <p class="text-center m-2"> 
                                                <span> <span class="rounded bg-success m-2">&emsp;&emsp;</span>Selected</span> 
                                                <span> <span class="rounded text-dark strike-out text-decoration-line-through btn-success m-2">&emsp;&emsp;</span>Booked</span> 
                                                <span> <span class="rounded bg-info strike-out m-2">&emsp;&emsp;</span>Pending</span> 
                                                <span> <span class="rounded bg-orange strike-out m-2">&emsp;&emsp;</span>Maintenance</span> 
                                                <span> <span class="rounded strike-out cal-disabled m-2">&emsp;&emsp;</span>UnAvailable</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="wizard-step" data-title="Client Info" data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">

                                        <div class="row gy-3 sign-up-tab mt-2">

                                            <div class="col-xl-6 mt-3">
                                                <label class="cust_phone" class="form-label">Phone Number <span class="text-danger">*</span> </label>
                                                <input type="text" name="cust_phone" list="browsers" class="form-control mt-2" id="cust_phone" oninput="NumberOnly(this, 10)" value="<?= (!empty($edit_appoint[$appkey]['app_phone']) ? $edit_appoint[$appkey]['app_phone'] : ''); ?>" <?= (!empty($edit_appoint[$appkey]['app_phone']) ? 'readonly' : ''); ?>>

                                                <datalist id="browsers">
                                                    <?php if(!empty($phone_records)) {
                                                        foreach($phone_records as $nos) {
                                                            echo '<option value="'.$nos['fld_phone'].'">';
                                                        }
                                                    } ?>
                                                </datalist>

                                                <span class="appoint-error-msg text-danger"></span>
                                            </div>

                                            <div class="col-xl-6 mt-3">
                                                <label for="cust_name" class="form-label">First Name <span class="text-danger">*</span> </label>
                                                <input type="text" name="cust_name" class="form-control" id="cust_name" value="<?= (!empty($edit_appoint[$appkey]['app_name']) ? $edit_appoint[$appkey]['app_name'] : ''); ?>" oninput="AlphaOnly(this)" />
                                                <span class="appoint-error-msg text-danger"></span>
                                            </div>

                                            <div class="col-xl-6 mt-3">
                                                <label for="cust_lname" class="form-label">Last Name </label>
                                                <input type="text" name="cust_lname" class="form-control" id="cust_lname" value="<?= (!empty($edit_appoint[$appkey]['app_lname']) ? $edit_appoint[$appkey]['app_lname'] : ''); ?>" oninput="AlphaOnly(this)" value="<?= (!empty($edit_appoint[$appkey]['app_lname']) ? $edit_appoint[$appkey]['app_lname'] : ''); ?>"/>
                                                <span class="appoint-error-msg text-danger"></span>
                                            </div>
                                           
                                            <div class="col-xl-6 mt-3">
                                                <label for="cust_email" class="form-label">Email Address <span class="text-danger">*</span> </label>
                                                <input type="text" name="cust_email" class="form-control " id="cust_email" value="<?= (!empty($edit_appoint[$appkey]['app_email']) ? $edit_appoint[$appkey]['app_email'] : ''); ?>"/>
                                                <span class="appoint-error-msg text-danger"></span>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="wizard-step" data-title="Confirmation" data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu" data-limit="3">
                                        <div class="row">
                                     <?php if(empty($edit_appoint)){ ?>
                                            <div class="col-xl-12">
                                                <div class="row gy-3">
                                                    <div class="col-xl-4">
                                                        <label for="paymode"> <b>Payment Mode</b></label>
                                                        <select name="pay_mode" class="form-select" id="paymode" required>
                                                            <option value="">Select Payment Mode</option>
                                                            <!-- <option value="Online">Online</option> -->
                                                            <option value="Cash">Cash</option>
                                                            <option value="UPI">UPI</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-12 UPI d-none">
                                                        <h6 class="text-center">UPI Transaction</h6>
                                                        <center><span id="qrcode_upi"></span></center>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                            <div class="col-xl-12">
                                             <?php if(empty($edit_appoint)){ ?>
                                                <div class="col-xl-6 mt-3">
                                                    <p class="fw-medium mb-1">Booked Date : <span class="text-muted " id="book_date_show"></span></p>
                                                </div>
                                                <?php } ?>

                                                <div class="checkout-payment-success">
                                                    <div class="col-xl-12 mb-4">
                                                        <div class="table-responsive">
                                                            <table class="table nowrap text-nowrap border mt-4">
                                                                <thead class="table-dark">
                                                                    <tr class="text-center">
                                                                        <th>COURT</th>
                                                                        <th>SLOT DATE</th>
                                                                        <th>DURATION</th>
                                                                        <th>TIMING</th>
                                                                        <th>AMOUNT ₹</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="billbody"></tbody>
                                                                <tfoot id="billfoot"></tfoot>
                                                            </table>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="app_id" id="app_id" value="<?= !empty($edit_appoint[$appkey]['app_aid']) ? $edit_appoint[$appkey]['app_aid'] : ''; ?>">
                                        <input type="hidden" name="cust_id" value="<?= !empty($edit_appoint) ? $edit_appoint[$appkey]['app_custid'] : ''; ?>">
                                        <input type="hidden" name="appoint_id" id="appoint_id" value="<?= !empty($edit_appoint[$appkey]['app_id']) ? $edit_appoint[$appkey]['app_id'] : ''; ?>">
                                        <div class="mb-4 text-center">
                                            <button type="submit" id="pay-btn" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </aside>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--End::row-1 -->
        </div>
    </section>
</div>
    
<!-- End:: Section-2 -->
<script type="text/javascript">
 
$(document).ready(function() {

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    var apptime = "<?= !empty($app_time) ? $app_time : ''; ?>";
    var appdate = "<?= !empty($app_date) ? $app_date : ''; ?>";
    var activeTab = $(".court_btn.active").attr("data-value"); 
    var appcourt = activeTab ? activeTab : "<?= !empty($appservs) ? $appservs : ''; ?>";
    var appkey = $("#app_id").val();

    $("input[name='admincourt'], .court_btn").on('click', function() {
        
        var court = $("input[name='admincourt']:checked").val();
        var label = $(this).data('value');

        $("input[name='admincourt']").prop('checked', false);
        $('.court_btn').removeClass('active');
        $('#'+court).prop('checked', true);
        $('.court_btn[data-value="'+court+'"]').addClass('active');
    });


    /* ----- For payment methode choosing ----- */
    $('.cardpay, .UPI').css('display', 'none');
    $("input[type=radio][name='paymethode']").on('change', function() {
        var paymode = $("input[type=radio][name='paymethode']:checked").val();
        
        $('.cardpay, .cov, .UPI').css('display', 'none');
        if(paymode == "Card") {
            $('.cardpay').css('display', 'block');
        } else if(paymode == 'COV') {
            $('.cov').css('display', 'block');
        } else if(paymode == 'UPI') {
            $('.UPI').css('display', 'block');
        }
    });


    $('body').on('click', '#sign-btn', function() {
        var title = $(this).data('title');

        if(title == "sign-in") {
            $('.sign-btn').html('Don&apos;t have an account? <a href="javascript:void(0)" id="sign-btn" data-title="sign-up" class="text-info"> SIGN UP </a> ');
            $('.sign-up-tab').addClass('d-none');
            $('.sign-in-tab').removeClass('d-none');
            $('.next').attr('disabled', 'disabled');
        } else {
            $('.sign-btn').html('Already have an account? <a href="javascript:void(0)" id="sign-btn" data-title="sign-in" class="text-info"> SIGN IN </a> ');
            $('.sign-in-tab').addClass('d-none');
            $('.sign-up-tab').removeClass('d-none'); 
            $('.next').removeAttr('disabled');
        }
    });


    $('body').on('click', "input[name='times[]']", function() {

        var element = $("input[name='times[]']").parent().parent().parent().parent();
        var checkedElement = $("input[name='times[]']:checked").parent().parent().parent().parent(); 
        element.removeClass('time-active btn-success text-white').addClass('btn-outline-success');
        checkedElement.removeClass('btn-outline-success').addClass('time-active btn-success text-white');

        var selCourt = $("input[type=radio][name='admincourt']:checked").val();  
        var selCourtDur = $("input[name='court_dura[courtA]']").val();
        var CourtRate = $("input[type=radio][name='admincourt']:checked").data('rate');

        var court_time = [];
        $("input[type=checkbox][name='times[]']:checked").each(function() {
            court_time.push($(this).val());
        });
        $('#billbody, #billfoot').empty();
        getCourtTable(court_time);
        $("#book_date_show").html(displayDate(new Date()));
    });

    $("#viewTimes").html('');
    var clickcount = 0;
    var allUnchecked = false;
    $('body').on('click', ".time-btn0, input[name='times[]']", function() {
        allUnchecked = $("input[name='times[]']:not(:checked)").length;
        var existingSlotCount = parseInt($('.existing_slot').val()) || 0;
        var element = $(this).children().children().children().children();
        var input = element[1];
        var prev_td = $(this).data('time');
        var prev_input = $('.'+prev_td).children().children().children().children();
        var prev_input = prev_input[1];
        var next_td = $(this).data('next');
        var next_input = $('.'+next_td).children().children().children().children();
        var next_input = next_input[1];
        var cont_td = $(prev_input).prop('checked');
        
        if ($(input).prop('checked')) {
            $(input).prop('checked', false);
        } else {
            $(input).prop('checked', true);
        }
        var ctiming = [];
        var duration = 0; var rate = 0;
        $("input[name='times[]']:checked").each(function() {
            ctiming.push($(this).val());
            duration += 30;
            rate += 600;
        });

        clickcount++;
        if(ctiming == "") { clickcount = 0; }
        if(ctiming.length == 1) { clickcount = 0; }
        if(ctiming != "") {
            if(clickcount >= 1 && (cont_td == false || cont_td == undefined)) {
                $(input).prop('checked', false);
                ctiming = [];
                var duration = 0; var rate = 0;
                $("input[name='times[]']:checked").each(function() {
                    ctiming.push($(this).val());
                    duration += 30;
                    rate += 600;
                });
            }
        }
        if($(prev_input).is(':checked') && $(next_input).is(':checked')) {
            $(input).prop('checked', true);
        }

        getCourtTable(ctiming);
        $("#book_date_show").html(displayDate(new Date()));
        var element = $("input[name='times[]']").parent().parent().parent().parent();
        var checkedElement = $("input[name='times[]']:checked").parent().parent().parent().parent();
        element.removeClass('time-active btn-success text-white').addClass('btn-outline-success');
        checkedElement.removeClass('btn-outline-success').addClass('time-active btn-success text-white');

        getTimeRate(ctiming[0], duration, rate);
    });

    
    /* --------- activate when page load ------------ */
    getdetails('<?= base_url('getCourtTiming') ?>', {[csrfName]: csrfHash, court:appcourt, date:appdate, apptime:apptime, appkey:appkey}, 'courtCal');

    $('#courtdate').val(appdate);

    var selCourt = $("input[type=radio][name='admincourt']:checked").val();
    var selCourtDur = $("input[name='court_dura[courtA]']").val();
    var CourtRate = $("input[type=radio][name='admincourt']:checked").data('rate');
    var courttimings = [];
    var timesplit = apptime.split(", ");

    for(var t=0; t < timesplit.length; t++) {
        courttimings.push(timesplit[t]);
    };

    $('#billbody, #billfoot').empty();
    getCourtTable(courttimings);


    /* -------- Check the mobile number exist or not --------- */
    $('#cust_phone').on('keyup', function() {
        var phone = $(this).val();
        var element = $('#cust_phone').parent().children('span');
        element.addClass('text-danger').removeClass('text-success').html('');

        $('#cust_name, #cust_lname, #cust_email, #cust_dob').val('').removeAttr('readonly');
        if(phone.length > 9) {
            $('.anni_field').addClass('d-none');
            $.ajax({
                url: '<?= base_url('checkExistorNot'); ?>',
                type: 'post',
                data: { [csrfName]: csrfHash, phone:phone },
                dataType: 'json',
                success: function(res) {
                    element.removeClass('text-danger').addClass('text-success').html('New Customer');
                    if(res != "") {
                        element.removeClass('text-danger').addClass('text-success').html('New Customer');
                        element.addClass('text-success').html('Existing Customer');
                        $("#cust_name, #cust_lname, #cust_email").attr('readonly', 'readonly');
                        $('#cust_name').val(res.custname);
                        $('#cust_lname').val(res.custlname);
                        $('#cust_email').val(res.custemail);
                        $('#cust_phone').val(res.custphone);
                        $('#cust_dob').val(res.custdob);
                    }
                },
                error: function(xhr, status, error) { console.log(xhr.responseText); }
            });
        }
    });


    var apptime = "";
    var appdate = "";
    /* --------- activate when stylist radio click ------------- */
    $('body').on('change', "input[type=radio][name='admincourt']", function() {
        
        var appdate = $('.calendar-day-active').data('date');
        var courts = $(this).val();

        $('#courtCal').empty();
        if(courts != "") {
            $("#viewTimes").html('');
            getdetails('<?= base_url('getCourtTiming') ?>', {[csrfName]: csrfHash, court:courts, date:appdate, apptime:apptime}, 'courtCal');
        }
    });


    /* -------- when click calendar date active change calender date --------- */
    $("body").on("click", ".cal-date", function(event) {
        var court = $("input[type=radio][name='admincourt']:checked").val();

        var selectedDate = $(this).data('date');
        $('#court_date').val(selectedDate);

        var curdate = new Date();
        var seleDate = new Date(selectedDate);
        curdate.setHours(0, 0, 0, 0);
        seleDate.setHours(0, 0, 0, 0);
        $('.next').removeAttr('disabled');
        if(curdate > seleDate) {
            $('.next').attr('disabled', 'disabled');
        }

        $('.cal-date').removeClass('calendar-day-active');
        $(this).addClass('calendar-day-active');

        $('#courtCal').empty();
        if(selectedDate != "" && court != "") {
            $("#viewTimes").html('');
            getdetails('<?= base_url('getCourtTiming') ?>', {[csrfName]:csrfHash, court:court, date:selectedDate, apptime:apptime}, 'courtCal');
        }
    });


    $("#signin_phone, #cust_password").on("keyup", function() {
        $('.next').attr('disabled', 'disabled');
    });

    $('#login_submit').on('click', function() {
        var signin_phone = $('#signin_phone').val();
        var cust_password = $('#cust_password').val();

        var action = validation({'signin_phone':signin_phone, 'cust_password':cust_password});
        $('.amount-error-msg').html('').removeClass('alert alert-success alert-danger');
        if(action === false) { return false; }

        $.ajax({
            url: '<?= base_url('login_submit'); ?>',
            type: 'POST',
            data: { [csrfName]:csrfHash, phone:signin_phone, password:cust_password },
            dataType: 'json',
            success:function(res) {

                $('.login-alert').html(res.alert_msg.word).addClass('alert alert-danger');
                $('.next').attr('disabled', 'disabled');
                if(res.status == 200) {
                    $('.next').removeAttr('disabled');
                    $('.login-alert').html('signed in successfully!!!').removeClass('alert-danger').addClass('alert alert-success');
                }
            },
            error: function(xhr, status, error) { console.log(xhr.responseText); }
        });

    });

    /* ------------------------ Model ajax for add / edit staff ---------------------- */
    $("#appointment_form").submit(function(event) {
        event.preventDefault();
        var amt = restrictAmt($('#amt').val());
        if(amt === false) { return amt; }

        var paymentType = $('select[name="pay_mode"]').val();
        var submitButton = $('button[type="submit"]');
        submitButton.prop('disabled', true).text('Loading...');
        var paymode = $('#paymode').val();

        if(paymode == "Online") {
            var appoint_status = false;
            var newapp_id = "";
            $.ajax({
                url: '<?= base_url('add_booking') ?>',
                type: 'post',
                data : $(this).serialize(),
                dataType: 'json',
                success:function(result) {
                    if(result.status == 200) {
                        submitButton.prop('disabled', false).text('Pay Now');
                        newapp_id = result.appoint_id;
                        var courtname = $("input[name='admincourt']:checked").val();
                        var courtdate = $("#court_date").val();
                        var courttime = "";
                        $("input[name='times[]']:checked").each(function() {
                            courttime += $(this).val()+" - ";
                        });
                        var customer_phone = $("#cust_phone").val();
                        var cust_name = $("#cust_name").val();
                        var cust_email = $("#cust_email").val();
                        if (!customer_phone) {
                            cust_name = "<?= (!empty($this->session->userdata('login_info')['uname'])) ? $this->session->userdata('login_info')['uname'] : ''; ?>";
                            cust_email = "<?= (!empty($this->session->userdata('login_info')['email_id'])) ? $this->session->userdata('login_info')['email_id'] : ''; ?>";
                            customer_phone = "<?= (!empty($this->session->userdata('login_info')['phone_no'])) ? $this->session->userdata('login_info')['phone_no'] : ''; ?>";
                        }

                        $.ajax({
                            url: '<?= base_url('payment_create'); ?>',
                            type: 'POST',
                            data:{[csrfName]:csrfHash, amount:$("#total_Amount").text(), gst:$("#gst_amount").val(), pay_charge: $("#payment_amount").val(), customer_phone: customer_phone},
                            dataType: 'json',
                            success : function (res) {
                                var responseData = (typeof res.data === "string") ? JSON.parse(res.data) : res.data;
                                submitButton.prop('disabled', false).text('Pay Now');
                                    var options = {
                                        "key": responseData.api_key, 
                                        "amount": responseData.amount, 
                                        "currency": "INR",
                                        "order_id": responseData.order_id, 
                                        "handler": function (response) {
                                            $.ajax({
                                                url: '<?= base_url('razorpaysuccess') ?>', 
                                                method: 'POST',
                                                data: {
                                                    [csrfName]:csrfHash,
                                                    razorpay_payment_id: response.razorpay_payment_id,
                                                    razorpay_order_id: response.razorpay_order_id,
                                                    razorpay_signature: response.razorpay_signature,
                                                    payment_status: response.payment_status,

                                                },
                                                dataType: 'json',
                                                success: function (data) {

                                                    if (data.code > 0) {
                                                        submitButton.prop('disabled', true).text('Loading...');
                                                        $.ajax({
                                                            url: '<?= base_url('update_cust_booking') ?>',
                                                            type: 'post',
                                                            data : {[csrfName]:csrfHash, 'appoint_id':newapp_id, 'pay_id':data.payment_id, 'ord_id':data.order_id, 'signature':data.signature, paymentdata:data},
                                                            dataType: 'json',
                                                            success:function(res) {
                                                                if(res.status == 200) {
                                                                    AlertPopup('Success!', 'Appointment Booked Successfully!', 'success', 'Ok', 'court_status');
                                                                    submitButton.prop('disabled', false).text('Pay Now');
                                                                } else {
                                                                    AlertPopup('Error!', 'Appointment Not Booked!!!', 'error', 'Ok', 'court_status');
                                                                }
                                                            }
                                                        });
                                                    } else {
                                                        AlertPopup('Failed!', 'Court not booking!!!', 'error', 'Ok', 'court_status');
                                                    }
                                                },
                                                error: function (err) {
                                                    AlertPopup('Error!', 'Payment verification failed. Please try again.', 'error', 'Ok', 'court_status');
                                                }
                                            });
                                        },
                                        "prefill": {
                                            "name": cust_name,
                                            "email": cust_email,
                                            "court": courtname,
                                            "slotdate": courtdate,
                                            "slottime": courttime,
                                        }
                                    };
                                    var rzp1 = new Razorpay(options);
                                    rzp1.open();
                            }
                        });

                    } else if(result.status == 300) {
                        AlertPopup('Warning!', result.alert_msg, 'warning', 'Ok', 'court_status');
                    } else {
                        AlertPopup('Error!', 'Appointment Not Booked!!!', 'error', 'Ok', 'court_status');
                        return false;
                    }
                }
            });
        } else {
            $.ajax({
                url: '<?= base_url('add_booking') ?>',
                type: 'post',
                data : $(this).serialize(),
                dataType: 'json',
                success:function(result) {
                    if(result.status == 200) {
                        AlertPopup('Success!', 'Appointment Booked Successfully!', 'success', 'Ok', 'court_status');
                        submitButton.prop('disabled', false).text('Pay Now');
                    } else {
                        AlertPopup('Error!', 'Appointment Not Booked!!!', 'error', 'Ok', 'court_status');
                    }
                }
            });
        }
    });
    
    // Coupon Amount 
    $('#coupon_apply').on('click', function(event) {
        if (event.which===13) event.preventDefault();
        
        var coupon_amt = $('#coupon_amt').val();
        var totalAmount = $('#old_amount').val();
        applycoupon(coupon_amt, totalAmount);
    });

    $('#coupon_amt').on('input', function(event) {
        if (event.which===13) event.preventDefault();

        var coupon_amt = $(this).val();
        var totalAmount = $('#old_amount').val();
        if (coupon_amt.trim() === '') {
            $('#total_Amount').text(totalAmount);
            $('.showCoupon').addClass('d-none');
            $('#coupon_apply').text('Apply');
        }
    });

    // Change Button name
    $('#paymode').on('change', function() {
        var paymentType = $('select[name="pay_mode"]').val();
        if (paymentType == 'Online') {
            $('#pay-btn').text('Pay Now'); 
        } else {
            $('#pay-btn').text('Submit'); 
        }
    });

});


function applycoupon(coupon_name, totalamt) {

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    $('.showCoupon').addClass('d-none');
    $('#coupon_apply').prop('disabled', true);
    $('#coupon_icon').removeClass().addClass('fas fa-sync fa-spin');
    $('.coupon_error').text('');

    var action = validation({'coupon_amt':coupon_amt});
    if(action === false) { return action; }
    
    $.ajax({
        url: '<?= base_url('get_coupons'); ?>',
        type: 'POST',
        data: { [csrfName]:csrfHash, coupon_amt:coupon_name, totalAmount:totalamt},
        dataType: 'json',
        success:function(res) {
            $('#total_Amount').text(res.finalamount);
            if(res.status == 200) {
                $('.showCoupon').removeClass('d-none');
                $('#coupon_Percent').text(res.percent + '%');
                $('#coupon_Amount').text(res.percentamount);
                $('#total_Amount').text(res.finalamount);
                $('#cpid').val(res.coupon_id);
                $('#cperc').val(res.percent);
                $('#cpamt').val(res.percentamount);
                $('#grand_Total').text((res.finalamount));
                $('#coupon_icon').removeClass().addClass('fas fa-check-circle'); 
                $('#coupon_apply').removeClass('btn-success').addClass('btn-primary'); 
                $('#coupon_apply').text('Applied');
                $('.coupon_error').removeClass('text-danger').addClass('text-success').text('Apply coupon successful!!!');
            } else {
                $('#coupon_icon').removeClass().addClass('fas fa-times-circle'); 
                $('#coupon_apply').text('Apply');
                $('.coupon_error').removeClass('text-success').addClass('text-danger').text('Coupon not valid');
            }
            handlePaymentMethodChange();
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        },
        complete: function() {
            $('#coupon_apply').prop('disabled', false);
        }
    });
}

// UPI Qr Generate
function handlePaymentMethodChange() 
{
    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
    var paymentMethod = $('input[name="paymethode"]:checked').val(); 
    var amount = $('#total_Amount').text(); 
    
    if (paymentMethod === 'UPI') {
        $.ajax({
            url: '<?= base_url('qr_generate'); ?>',
            type: 'POST',
            data: { [csrfName]: csrfHash, amount: amount },
            success: function(response) {
                $('.UPI').removeClass('d-none'); 
                $("#qrcode_upi").empty().append(response); 
            },
            error: function(xhr, status, error) {
                $('.UPI').removeClass('d-none');
                console.error('AJAX request failed:', status, error);
            }
        });
    } else {
        $('.UPI').addClass('d-none');
    }
}

function DisplayTime(time, duration) {
    var d = new Date('2000-01-01 '+time);
    d.setMinutes(d.getMinutes()+duration);
    var timestru = d.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true })
    return timestru;
}


/* ----- For confirmation screen table ----- */
function getCourtTable(court_data) {
    var selCourt = $("input[type=radio][name='admincourt']:checked").val();
    var courtName = "";
    if (selCourt === "courtA") { 
        courtName = "Court A"; 
    }else{
        courtName = "Court B"; 
    }
    var selCourtDur = $("input[name='court_dura[courtA]']").val();
    var CourtRate = $("input[type=radio][name='admincourt']:checked").data('rate');
    var booking_date = $("#court_date").val();

    $('#billbody, #billfoot').empty();
    var tbody = "";
    var tfoot = "";
    var courttotal = 0;

    for(var c = 0; c < court_data.length; c++) {
        var endTime = DisplayTime(court_data[c], parseInt(selCourtDur));
        tbody += "<tr class='text-center'> <td>" + courtName + "</td>  <td>" + displayDate(booking_date) + "</td> <td>" + selCourtDur + " mins</td> <td>" + court_data[c] + " - " + endTime + "</td> <td>" + (CourtRate / 1.18).toFixed(2) + "</td> </tr>";
        courttotal += parseFloat(CourtRate);
    }

    var paymentAmount = courttotal * 0.02;
    var total = (courttotal / 1.18);
    var storeGstAmount = (courttotal / 1.18);
    var grandTotal = total * 1.18;
    var gst = (courttotal - total);

   tfoot += "<tr>" +
        "<td colspan='4' align='right'> <b>SUBTOTAL :</b> </td>" +
        "<td align='center' id='sub_Amount'>" + (total).toFixed(2) + "</td>" +
        "<input type='hidden' id='cpid' name='fld_acpid' />" +
        "<input type='hidden' name='fld_acppercent' id='cperc' />" +
        "<input type='hidden' name='fld_acpamt' id='cpamt' />" +
        "<input type='hidden' name='old_amount' id='old_amount' value='" + (grandTotal).toFixed(2) + "' />" +
        "<input type='hidden' name='getAmount' id='gst_amount' value='" + (gst).toFixed(2) + "' />" +
        "<input type='hidden' name='payment_amount' id='payment_amount' value='" + paymentAmount + "' />" +
        "<input type='hidden' name='fld_rate' id='fld_rate' value='" + (total).toFixed(2) + "'/>" +
    "</tr>" + 

    "<tr>" +
        "<td colspan='4' align='right'> <b>GST AMOUNT( 18% ) :</b> </td>" +
        "<td align='center' id='gstAmounts'>" + gst.toFixed(2) + "</td>" +
    "</tr>" +
        "<tr class='showCoupon d-none'>" +
        "<td colspan='4' align='right'> <b>COUPON PERCENT % :</b> </td>" +
        "<td align='center' id='coupon_Percent'></td>" +
    "</tr>" +

    "<tr class='showCoupon d-none'>" +
        "<td colspan='4' align='right'> <b>COUPON AMOUNT :</b> </td>" +
        "<td align='center' id='coupon_Amount'></td>" +
    "</tr>" +

    "<tr>" +
        "<td colspan='4' align='right'> <b>TOTAL :</b></td>" +
        "<td align='center' id='total_Amount'>" + (total + gst).toFixed(2) + "</td>" +
    "</tr>" +

    "<tr>" +
        "<td colspan='4' align='right'> <b>GRAND TOTAL :</b> <br> <small>(Round Off)</small> </td>" +
        "<td align='center' id='grand_Total'>" + Math.round(courttotal).toFixed(2) + "</td>" +
    "</tr>" +

    $('#billbody').append(tbody);
    $('#billfoot').append(tfoot);

}

// Get Customer Details
function getCustomerDetails(id) {
    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
    $.ajax({
        url: '<?= base_url('get_customerdata') ?>',
        type: 'post',
        data: { [csrfName]: csrfHash, id: id },
        dataType: 'json',
        success: function(result) {
            var html = "";
            if (result.status == 200) {
                const value = result.data;
                var slottime = TimeAlign(value.fld_atime)[0];
                // Populate modal fields
                $("#custid").text(value.fld_appointid);
                $("#cname").text(value.fld_name);
                $("#cphone").text(value.fld_phone);
                $("#courtname").text((value.fld_aserv == "courtA") ? 'Court A' : 'Court B');
                $("#slotdate").text(displayDate(value.fld_adate));
                $("#slottime").text(slottime+ ' - ' + DisplayTime(slottime, parseInt(value.fld_aduring)));
                $("#paymentmode").text(value.fld_apaymode);
                $("#bookstatus").text(value.fld_astatus);
                $("#customerDetailsModal").modal("show");
            } else {
                $('#customerDetailsModal').html("<tr><td colspan='3' class='text-center'>No customer details found</td></tr>");
            }
            $('#customerDetailsModal').modal('show');
        }
    });
}

function getTimeRate(starttime, duration, rate) {

    var viewtimes = "Timings: <b>"+starttime+" - "+DisplayTime(starttime, parseInt(duration))+"</b> <br> Amount ₹: <b>"+rate+"</b>";
    viewtimes = (starttime == undefined) ? "" : viewtimes;
    $("#viewTimes").html(viewtimes);
}

const settingweeks = <?= (!empty(json_encode($weeks)) ? json_encode($weeks) : []); ?>;


</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let yearDropdown = document.querySelector(".calendar-years");
    let monthDropdown = document.querySelector(".calendar-months");

    // Add class to remove dropdown arrow and prevent clicking
    yearDropdown.classList.add("no-dropdown");
    monthDropdown.classList.add("no-dropdown");

    // Disable the select elements
    yearDropdown.setAttribute("disabled", true);
    monthDropdown.setAttribute("disabled", true);
});


</script>

<script src="<?= base_url('../assets/js/cal_scroll.js'); ?>" ></script>

<script src="<?= base_url('../assets/js/status_calander.js'); ?>"></script>
<!-- Show Password JS -->
<script src="<?= base_url('../assets/js/show-password.js'); ?>"></script>

<!-- Date & Time Picker JS -->
<script src="<?= base_url(); ?>../assets/libs/flatpickr/flatpickr.min.js"></script>

<!-- Vanilla-Wizard JS -->
<script src="<?= base_url(); ?>../assets/libs/vanilla-wizard/js/wizard.min.js"></script>

<!-- Internal Form Wizard JS -->
<script src="<?= base_url(); ?>../myassets/form-wizard.js"></script>
<link rel="modulepreload" href="<?= base_url(); ?>../assets/js/status-wizard.js" />
<script type="module" src="<?= base_url(); ?>../assets/js/status-wizard.js"></script>


<!-- Sticky JS -->
<script src="<?= base_url(); ?>../assets/js/sticky.js"></script>