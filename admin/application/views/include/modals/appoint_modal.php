<link rel="stylesheet" type="text/css" href="<?= base_url('../assets/css/calander.css'); ?>" />
<script src="<?= base_url('../assets/js/calander.js'); ?>"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style type="text/css">
    .wizard-tab .wizard-content{
        padding: 1rem !important;
    }
    .time-active .align-items-center {
        color: #ffffff !important;
    }
</style>

<?php 
$appkey = 0;
$appservs = $app_coup_name = "";
$app_date = CURDATE;
$app_time = [];
$weeks = !empty($setting_records[0]['fld_weekdays']) ? json_decode($setting_records[0]['fld_weekdays']) : [];

if(!empty($edit_appoint)) {
    $appkey = array_keys($edit_appoint)[0];
    $appservs = $edit_appoint[$appkey]['app_serv'];
    $app_time = $edit_appoint[$appkey]['app_time'];
    $app_date = $edit_appoint[$appkey]['app_date'];
    $app_coup_name = $edit_appoint[$appkey]['coup_name'];
} 

?>

<!-------------------- Model form for add new / edit appointment ----------------->
<div class="modal fade" id="AppointmentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="appointmentModalLabel" style="display: none;" aria-hidden="true">
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <h6 class="modal-title text-white" id="appointmentModalLabel"> <?= ($appkey == 0) ? 'New' : '#'.$appkey.' - '; ?> Booking</h6>
            <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" onclick="closeModel('bookings')" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Follow the below steps:</div>
                    </div>

                    <div class="card-body p-0">
                        <form class="wizard wizard-tab horizontal" method="POST" id="appointment_form">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                            <aside class="wizard-content container">

                                <div class="wizard-step" data-title="Customer Detail" data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-12">
                                            <div class="register-page">
                                                <div class="row gy-3 mt-3">
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
                                                        <input type="text" name="cust_name" class="form-control" id="cust_name" value="<?= (!empty($edit_appoint[$appkey]['app_name']) ? $edit_appoint[$appkey]['app_name'] : ''); ?>">
                                                        <span class="appoint-error-msg text-danger"></span>
                                                    </div>

                                                    <div class="col-xl-6 mt-3">
                                                        <label for="cust_lname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="cust_lname" class="form-control" id="cust_lname" value="<?= (!empty($edit_appoint[$appkey]['app_lname']) ? $edit_appoint[$appkey]['app_lname'] : ''); ?>">
                                                        <span class="appoint-error-msg text-danger"></span>
                                                    </div>
                                                   
                                                    <div class="col-xl-6 mt-3">
                                                        <label for="cust_email" class="form-label">Email Address <span class="text-danger">*</span> </label>
                                                        <input type="text" name="cust_email" class="form-control " id="cust_email" value="<?= (!empty($edit_appoint[$appkey]['app_email']) ? $edit_appoint[$appkey]['app_email'] : ''); ?>" >
                                                        <span class="appoint-error-msg text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            
                                <div class="wizard-step" data-title="Court" data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
                                    <span class="choose-serv-error-msg text-center"></span>
                                    <div class="row gy-4 mt-3">
                                        <div class="col-xl-6">
                                            <div class="form-check d-flex align-items-center">
                                                <div class="flex-fill align-items-center">
                                                    <label for="courtA">
                                                        <img src="<?= base_url('../assets/images/court.png'); ?>" width="80%" class="" alt="Court A" style="border-radius: 5%;">
                                                    </label>
                                                    <div class="d-flex justify-content-center input-group">
                                                        <label for="courtA" class="text-center mt-2"> <b>Court A</b> </label> &nbsp;
                                                        <input name="admincourt" class="fs-5 border-dark form-check-input form-checked-primary rounded-circle" type="radio" value="courtA" data-duration="30" data-rate="600" id="courtA" <?= ( (!empty($appservs) && ($appservs == 'courtA') ) ? 'checked' : ''); ?> >
                                                        <input type="hidden" name="court_dura[courtA]" value="30" >
                                                        <input type="hidden" name="court_rate[courtA]" value="600" >
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-check d-flex align-items-center">
                                                <div class="flex-fill">
                                                    <label for="courtB">
                                                        <img src="<?= base_url('../assets/images/court.png'); ?>" width="80%" class="" alt="Court B" style="border-radius: 5%;">
                                                    </label>
                                                    <div class="d-flex justify-content-center input-group">
                                                        <label for="courtB" class="text-center mt-2"> <b>Court B</b> </label> &nbsp;
                                                        <input name="admincourt" class="fs-5 border-dark form-check-input form-checked-primary rounded-circle" type="radio" value="courtB" data-duration="30" data-rate="600" id="courtB" <?= ( (!empty($appservs) && ($appservs == 'courtB') ) ? 'checked' : ''); ?> >
                                                        <input type="hidden" name="court_dura[courtB]" value="30" >
                                                        <input type="hidden" name="court_rate[courtB]" value="600" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="wizard-step" data-title="Date & Time" data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu">

                                    <span class="choose-time-error-msg text-center"></span>
                                    <div class="row justify-content-center summary-view" id="staffCalender">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="d-flex justify-content-center">
                                                    <ul class="nav nav-tabs mb-3 tab-style-6 bg-white rounded-pill border-dark" id="myTab1" role="tablist">
                                                        <li class="nav-item" role="presentation"> 
                                                            <label for="courtA" class="court_btn nav-link w-lg rounded-pill text-center" data-value="courtA" data-bs-toggle="tab" role="tab"> <b>Court A</b> </label>
                                                        </li>
                                                        <li class="nav-item" role="presentation"> 
                                                            <label for="courtB" class="court_btn nav-link w-lg rounded-pill text-center" data-value="courtB" data-bs-toggle="tab" role="tab"> <b>Court B</b> </label> &nbsp;
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
                                                <input type="hidden" name="court_date" id="court_date" value="<?= date('Y-m-d'); ?>">
                                                <p class="text-center m-2"> 
                                                    <span class="m-2"> <span class="bg-success m-2">&emsp;</span>Selected</span> 
                                                    <span class="m-2"> <span class="cal-disabled m-2">&emsp;</span>Disabled</span> 
                                                </p>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="row mt-4" id="courtTimeCal"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="wizard-step" data-title="Payment" data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu" data-limit="3">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div>
                                                <div class="fs-15 fw-medium d-sm-flex d-block align-items-center justify-content-between mb-3">
                                                    <div>Payment Details :</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="card custom-card border shadow-none mb-3">
                                                            <div class="card-body">

                                                                <div class="row gy-3">

                                                                    <div class="col-xl-6">
                                                                        <div class="row gy-3">
                                                                            <div class="col-xl-12">
                                                                                <label for="pay_mode" class="form-label">Payment Mode</label>
                                                                                <select name="paymode" class="form-select" id="pay_mode">
                                                                                    <option value="Online">Online</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="col-xl-12">
                                                                                <label for="coupon_amt"> <b>Coupon</b></label>
                                                                                <div class="input-group">
                                                                                    <input type="text" name="coupon_amt" class="form-control" id="coupon_amt" value="<?= $app_coup_name; ?>">
                                                                                    <button type="button" class="btn btn-success" id="coupon_apply">Apply</button>
                                                                                </div>
                                                                                <span class="amount-error-msg text-danger"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-xl-6">
                                                                        <p class="fw-medium text-muted mb-1">Date Issued :
                                                                            <?= !empty($app_date) ? showDate($app_date) : date('M d/Y'); ?> - <span class="text-muted fs-12"> <?= !empty($app_time) ? $app_time : date('h:i a'); ?></span>
                                                                        </p>                                                                    
                                                                        <div class="table-responsive">
                                                                            <table class="table nowrap text-nowrap border mt-4">
                                                                                <thead class="table-dark">
                                                                                    <tr class="text-center">
                                                                                        <th>COURT</th>
                                                                                        <th>DURATION</th>
                                                                                        <th>TIMING</th>
                                                                                        <th>AMOUNT (₹)</th>
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
                                                            <button type="submit" class="btn btn-success float-end">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
</div>
</div>

<!--------------- Update Appointment Payment -------------->
<div class="modal fade" id="PaymentModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="PaymentModalToggleLabel" tabindex="-1" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <h6 class="modal-title text-white" id="PaymentModalToggleLabel">Payment Detail</h6>
            <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" onclick="closeModel('')" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th class="table-info text-uppercase" width="30%">Booking ID</th>
                        <td><b><span id="payapp_id" class="text-primary h5"></span></b></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="30%">Booking Date</th>
                        <td><span id="paybook_date"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="30%">Booked Date</th>
                        <td><span id="payapp_date"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="30%">Booking Time</th>
                        <td><span id="payapp_time"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="30%">First Name</th>
                        <td><span id="payapp_name"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="30%">Last Name</th>
                        <td><span id="payapp_lname"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="30%">Phone</th>
                        <td><span id="payapp_number"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="30%">Email</th>
                        <td><span id="payapp_email"></span></td>
                    </tr>

                    <tr> <th> <td></td> </th> </tr>

                    <tr class="table-info text-center">
                        <th class="text-uppercase">COURT</th>
                        <th class="text-uppercase">DURATION</th>
                        <th class="text-uppercase">TIMING</th>
                        <th class="text-uppercase">AMOUNT (₹)</th>
                    </tr>
                    <tbody id="payservbody"></tbody>
                    <tfoot id="payservfoot"></tfoot>
                </table>
                <form method="post" id="payment_form">
                    <div class="row mb-3">
                        <div class="col-md-8 mt-2">
                            <div class="input-group">
                                <label for="payamount" class="form-label mt-2"> <b>AMOUNT: &nbsp;</b> </label>
                                <input type="text" name="payamount" id="payamount" class="form-control" oninput="AmtOnly(this, 10)" onkeyup="restrictPayment(this.value);" readonly>
                            </div>
                            <span class="payment-error-msg text-danger"></span>
                        </div>

                        <div class="col-md-4 float-end mt-2">
                            <input type="hidden" name="billamount" id="billamount" value="">
                            <input type="hidden" name="appointid" id="appointid" value="">
                            <button type="submit" id="payment_submit" class="btn btn-success" >Save</button>
                        </div>
                    </div>
                </form>
            </div>
  
        </div>
    </div>
</div>
</div>

<script type="text/javascript">

function PaymentData(appid) {

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
    
    $('#payservbody, #payservfoot').empty();
    $('#payapp_id, #paybook_date, #paybook_time, #payapp_date, #payapp_number, #payapp_email').html('');
    $('#payamount, #appointid').val('');
    $.ajax({
        url: '<?= base_url('view_records'); ?>',
        type: 'post',
        data: { [csrfName]: csrfHash, id:appid, type:'appointment' },
        dataType: 'json',
        success: function(res) {

            if(res != "") {
                var key = Object.keys(res);
                $('#payapp_id').html(key);
                $('#appointid').val(res[key].app_aid);
                $('#paybook_date').html(displayDate(res[key].book_date));
                $('#payapp_date').html(displayDate(res[key].app_date));
                $('#payapp_time').html(res[key].app_time);
                $('#payapp_name').html(res[key].app_name);
                $('#payapp_lname').html(res[key].app_lname);
                $('#payapp_number').html(res[key].app_phone);
                $('#payapp_email').html(res[key].app_email);
                $('#billamount').val(res[key].app_balance);
                $('#payamount').val(res[key].app_balance);
                var tbody = '';
                var rate = 0;
                for (var i = 0; i < res[key].serv_data.length; i++) {

                    var value = res[key].serv_data[i];
                    if(i <= 0) { var starttime = value[3]; }
                    if(i > 0) { starttime = endtime; }
                    var endtime = DisplayTime(starttime, parseFloat(value[1]));
                    var courtname = 'Court B';
                    if(value[0] == 'courtA') { courtname = 'Court A'; }

                    tbody += '<tr class="text-center"> <td>' + courtname + '</td> <td>' + value[1] + ' mins</td> <td>' + starttime + ' - ' + endtime + '</td> <td>' + (value[2] / 1.18).toFixed(2) + '</td> </tr>';
                    rate += parseFloat((value[2] / 1.18).toFixed(2));
                }

                // '<tr class="table-info text-center"> ' +
                   //     '<td colspan="3" align="right"> <b>DISCOUNT( '+res[key].coup_perc+'% ): </b></td> ' +
                      //  '<td><b>' + parseFloat(res[key].app_cpamt).toFixed(2) + '</b> </td> </tr>' +
                    var subtotal = rate.toFixed(2);
                    var gst = (parseFloat(res[key].app_gst) || 0).toFixed(2);
                    var total =  (parseFloat(subtotal+gst)).toFixed(2);
                    var tfoot = '<tr class="table-info text-center"> ' +
                    
                        '<td colspan="3" align="right"> <b>SUBTOTAL: </b></td> ' +
                        '<td><b>' + rate.toFixed(2) + '</b> </td> </tr>' +
                       '<tr class="table-info text-center"> ' +
                            '<td colspan="3" align="right"> <b>GST AMOUNT (18%) : </b></td> ' +
                            '<td> <b>' + gst + '</b> </td>' + 
                            '</tr>' + 
                            '<tr class="table-info text-center"> ' +
                                '<td colspan="3" align="right"> <b>TOTAL : </b></td> ' +
                                '<td> <b>' + (parseFloat(subtotal) + parseFloat(gst)).toFixed(2) + '</b> </td>' + 
                            '</tr>' +

                '<tr class="table-info text-center"> ' +
                    '<td colspan="3" align="right"> <b>PAID: </b></td> ' +
                    '<td><b>' + res[key].app_paid + '</b> </td> </tr>' +
                '<tr class="table-info text-center"> ' +
                    '<td colspan="3" align="right"> <b>BALANCE (Round Off): </b></td> ' +
                    '<td><b>' + (parseFloat(res[key].app_balance) <= 0 ? rate : res[key].app_balance) + '</b> </td> </tr>';

                $('#payservbody').append(tbody);
                $('#payservfoot').append(tfoot);
            }
        }
    });
}


/* ----- Restrict pay amount ----- */
function restrictPayment(amount) {

    let total = 0;
    total = parseFloat($("#billamount").val());

    $('.payment-error-msg').html('');
    $('#payment_submit').removeAttr('disabled');
    var action = true;
    if (total > 0 && parseFloat(amount) > total) {
        $('.payment-error-msg').html('Amount cannot exceed total rate of selected services.');
        $('#payment_submit').attr('disabled', 'disabled');
        action = false;
    }
    return action;
}

    
$(document).ready(function() {

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    /*var mari_sts = "<?= !empty($edit_appoint[0]) ? $edit_appoint[0]['mari_sts'] : '' ?>";
    if(mari_sts == "Married") { $('.anni_field').removeClass('d-none'); }*/

    $('#mari_sts').on('change', function() {
        var maritial_sts = $(this).val();

        $('.anni_field').addClass('d-none');
        if(maritial_sts == "Married") {
            $('.anni_field').removeClass('d-none');
        }
    });


    $('#payment_form').submit(function(e) {
        e.preventDefault();

        var Payamount = $('#payamount').val();
        var id = $('#appointid').val();

        var action = validation({'payamount':Payamount});
        if(action === false) { return action; }
        
        $.ajax({
            url: '<?= base_url('updatePayment'); ?>',
            type: 'POST',
            data: { [csrfName]: csrfHash, id:id, payamount:Payamount },
            dataType: 'json',
            success: function(res) {
                if(res.status == 200) {
                    AlertPopup('Success!', 'Paymnent updated Successfully!', 'success', 'Ok', 'bookings');
                }
            },
            error: function(xhr, status, error) { console.log(xhr.responseText); }
        });
    });


    $('body').on('click', "input[name='times[]']", function() {

        var element = $("input[name='times[]']").parent().parent().parent().parent();
        var checkedElement = $("input[name='times[]']:checked").parent().parent().parent().parent(); 
        element.removeClass('time-active btn-success text-white').addClass('btn-outline-success');
        checkedElement.removeClass('btn-outline-success').addClass('time-active btn-success text-white');

        var selCourt = $("input[type=radio][name='admincourt']:checked").val();  
        var selCourtDur = $("input[name='court_dura[courtA]']").val();
        var CourtRate = $("input[type=radio][name='admincourt']:checked").data('rate');

        var courttimings = [];
        $("input[type=checkbox][name='times[]']:checked").each(function() {
            courttimings.push($(this).val());
        });
        getCourtTable(courttimings);

        /* ---- QRCode generate with dynamic amount ----- */
        var amount = $('#total_Amount').text();
        $.ajax({
          url: '<?= base_url('generate_upi_qr'); ?>',
          type: 'POST',
          data: { [csrfName]:csrfHash, amount:amount},
          success: function(response) {
            $("#upi_qrcode").empty();
            $("#upi_qrcode").append(response);
          },
          error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
          }
        });
    });
    

    /* -------- Check the mobile number exist or not --------- */
    $('#cust_phone').on('keyup', function() {
        var phone = $(this).val();
        var element = $('#cust_phone').parent().children('span');
        element.addClass('text-danger').removeClass('text-success').html('');

        $('#cust_name, #cust_lname, #cust_email, #cust_gender, #cust_dob, #mari_sts, #cust_addr, #cust_pref').val('');
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
                        $('#cust_name').val(res.custname);
                        $('#cust_lname').val(res.custlname);
                        $('#cust_email').val(res.custemail);
                        $('#cust_phone').val(res.custphone);
                        $('#cust_dob').val(res.custdob);
                        $('#anni_date').val(res.annidate);
                        $('#mari_sts').val(res.marists);
                        if(res.marists == "Married") {
                            $('.anni_field').removeClass('d-none');
                        }
                        $('#cust_gender').val(res.custgen);
                        $('#cust_addr').val(res.custaddr);
                        $('#cust_pref').val(res.notes);
                    }
                },
                error: function(xhr, status, error) { console.log(xhr.responseText); }
            });
        }
    });


    var apptime = "<?= !empty($app_time) ? $app_time : ''; ?>";
    var appdate = "<?= !empty($app_date) ? $app_date : ''; ?>";
    var appcourt = "<?= !empty($appservs) ? $appservs : ''; ?>";
    var appkey = $("#app_id").val();
    /* --------- activate when page load ------------ */
    getdetails('<?= base_url('getCourtTiming') ?>', {[csrfName]: csrfHash, court:appcourt, date:appdate, apptime:apptime, appkey:appkey}, 'courtTimeCal');

    $('#court_date').val(appdate);

    var selCourt = $("input[type=radio][name='admincourt']:checked").val();
    var selCourtDur = $("input[name='court_dura[courtA]']").val();
    var CourtRate = $("input[type=radio][name='admincourt']:checked").data('rate');
    var timesplit = apptime.split(", ");

    var courttime = [];
    for(var t=0; t < timesplit.length; t++) {
        courttime.push(timesplit[t]);
    };
    $('#billbody, #billfoot').empty();
    getCourtTable(courttime);

    /* --------- activate when staff checkbox click ------------- */
    $('body').on('change', "input[type=radio][name='admincourt']", function() {
        
        var appdate = $('.calendar-day-active').data('date');
        var courts = $(this).val();

        $('#courtCal').empty();
        if(courts != "") {
            getdetails('<?= base_url('getCourtTiming') ?>', {[csrfName]: csrfHash, court:courts, date:appdate, apptime:apptime}, 'courtCal');
        }
    });


    /* -------- when click calendar date active change calender date --------- */
    $("body").on("click", ".cal-date", function(event) {
        var selectCourt = $("input[type=radio][name='admincourt']:checked").val();

        var selectedDate = $(this).data('date');
        $('#court_date').val(selectedDate);
        $('.cal-date').removeClass('calendar-day-active');
        $(this).addClass('calendar-day-active');

        $('#courtTimeCal').empty();
        if(selectedDate != "" && selectCourt != "") {
            getdetails('<?= base_url('getCourtTiming') ?>', {[csrfName]: csrfHash, court:selectCourt, date: selectedDate, apptime: apptime, appkey:appkey}, 'courtTimeCal');
        }
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


    /* ------------------------ Model ajax for add / edit staff ---------------------- */
     $("#appointment_form").submit(function(event) {
        event.preventDefault();

        var amt = restrictAmt($('#amt').val());
        if(amt === false) { return amt; }

        var paymentType = $('select[name="pay_mode"]').val();
        var submitButton = $('button[type="submit"]');
        submitButton.prop('disabled', true).text('Loading...');
        $.ajax({
            url: '<?= base_url('payment_create'); ?>',
            type: 'POST',
            data:{[csrfName]:csrfHash, amount:$("#total_Amount").text(), gst:$("#gst_amount").val(), pay_charge: $("#payment_amount").val()},
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
                                    payment_status: response.payment_status
                                },
                                dataType: 'json',
                                success: function (data) {

                                    if (data.status === 'Payment Successfull') {
                                        var formData = $("#appointment_form").serializeArray();
                                        formData.push({ name: 'pay_id', value: data.payment_id });
                                        formData.push({ name: 'ord_id', value: data.order_id });
                                        formData.push({ name: 'signature', value: data.signature });
                                        formData.push({ name: 'pay_mode', value: data.pay_mode });
                                        formData.push({ name: csrfName, value: csrfHash });
                                        submitButton.prop('disabled', true).text('Loading...');
                                        $.ajax({
                                            url: '<?= base_url('add_booking') ?>',
                                            type: 'post',
                                            data : formData,
                                            dataType: 'json',
                                            success:function(result) {
                                                if(result.status == 200) {
                                                    AlertPopup('Success!', 'Appointment Booked Successfully!', 'success', 'Ok', '');
                                                    submitButton.prop('disabled', false).text('Pay Now');
                                                } else {
                                                    AlertPopup('Error!', 'Appointment Not Booked!!!', 'error', 'Ok', '');
                                                }
                                            }
                                        });
                                    } else {
                                       AlertPopup('Success!', 'Appointment Booked Successfully!', 'success', 'Ok', '');
                                    }
                                },
                                error: function (err) {
                                    AlertPopup('Error!', 'Payment verification failed. Please try again.', 'error', 'Ok', '');
                                }
                            });
                        },
                        "prefill": {
                            "name": "Customer Name", 
                            "email": "customer@example.com", 
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
            }
        });
    });

    $("body").on('click', '.cancel-confirm', function () {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Cancel it!",
      }).then((e) => {

        if (e.isConfirmed) {

            $.ajax({
                url: '<?= base_url('cancel_appoint'); ?>',
                type: 'post',
                data: { [csrfName]: csrfHash, id: $(this).data('id'), type: 'Cancelled' },
                dataType: 'json',
                success: function(res) { 
                    AlertPopup('Cancelled!', 'Your appointment has been cancelled.', 'success', 'Ok', '');
                },
                error: function(xhr, status, error) { console.log(xhr.responseText); }
            });
        }/* else if (e.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Cancelled', 'Your data is safe :)', 'info');
        }*/
      });
    });


    $("#coupon_amt").on('keyup', function() {

        var value = $(this).val();
        var totAmt = $('#tot_amt').val();

        if(value.length == 0) {
            $('#coupon_Percent').text('');
            $('#coupon_Amount').text('');
            $('#total_Amount').text(totAmt);
        }
    });


    applyCoupon($('#coupon_amt').val(), $('#tot_amt').val());
    /*------ Coupon Amount ------*/
    $('#coupon_apply').on('click', function() {

        var coupon_amt = $('#coupon_amt').val();
        var totalAmount = $('#tot_amt').val();
        applyCoupon(coupon_amt, totalAmount);        
    });

});


function applyCoupon(coupon_name, totalamt) {

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    $('.showCoupon').addClass('d-none');
    $('#coupon_apply').prop('disabled', true);
    $('#coupon_icon').removeClass().addClass('fas fa-sync fa-spin');
    $.ajax({
        url: '<?= base_url('get_coupons'); ?>',
        type: 'POST',
        data: { [csrfName]:csrfHash, coupon_amt:coupon_name, totalAmount:totalamt},
        dataType: 'json',
        success:function(res) {
            $('#total_Amount').text(res.finalamount);
            if(res.status == 200) {
                $('.showCoupon').removeClass('d-none');
                $('#coupon_Percent').text(res.percent+"%");
                $('#coupon_Amount').text(res.percentamount);
                $('#total_Amount').text(res.finalamount);
                $('#cpid').val(res.coupon_id);
                $('#cperc').val(res.percent);
                $('#cpamt').val(res.percentamount);
                $('#coupon_icon').removeClass().addClass('fas fa-check-circle');
                $('#coupon_apply').removeClass('btn-success').addClass('btn-primary');
                $('#coupon_apply').text('Applied');
            } else {
                $('#coupon_icon').removeClass().addClass('fas fa-times-circle');
                $('#coupon_apply').text('Apply');
            }
            var amount = $('#total_Amount').text();
            $.ajax({
              url: '<?= base_url('generate_upi_qr'); ?>',
              type: 'POST',
              data: { [csrfName]:csrfHash, amount:amount},
              success: function(response) {
                $("#upi_qrcode").empty();
                $("#upi_qrcode").append(response);
              },
              error: function(xhr, status, error) {
                console.error('AJAX request failed:', status, error);
              }
            });
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            $('#coupon_icon').removeClass().addClass('fas fa-times-circle');
            $('#coupon_apply').text('Apply');
        },
        complete: function() {
            $('#coupon_apply').prop('disabled', false);
        }
    });

}

/* ----- For confirmation screen table ----- */
function getCourtTable(court_data) {

    $('#billbody, #billfoot').empty();

    if(court_data != "") {
        var selCourt = $("input[type=radio][name='admincourt']:checked").val();
        var selCourtDur = $("input[name='court_dura[courtA]']").val();
        var CourtRate = $("input[type=radio][name='admincourt']:checked").data('rate');

        var tblbody = "";
        var tblfoot = "";
        var courttotal = 0;
        for(var c = 0; c < court_data.length; c++) {

            if(c <= 0) { var starttime = court_data[c]; }
            if(c > 0) { starttime = endtime; }
            var endtime = DisplayTime(starttime, parseFloat(selCourtDur));

            tblbody += "<tr class='text-center'> <td>"+selCourt+"</td>  <td>"+MinutesToHour(selCourtDur)+"</td> <td>"+starttime+' - '+endtime+"</td> <td> ₹"+CourtRate+"</td> </tr>";
            courttotal += parseFloat(CourtRate);
        }

        var gstAmount = ((courttotal - (c * 100)) * 0.02);
        var storeGstAmount = ((courttotal - (c * 100)) * 0.18);
        var paymentAmount = ((courttotal - (c * 100)) * 0.02);
        var grandTotal = courttotal;

        tblfoot += "<tr class='showCoupon d-none'>"+
                        "<td colspan='3' align='right'> <b>COUPON PERCENT % :</b> </td>"+
                        "<td align='center' id='coupon_Percent'></td> </tr>"+
                    " <tr class='showCoupon d-none'>"+
                        "<td colspan='3' align='right'> <b>COUPON AMOUNT :</b> </td>"+
                        "<td align='center' id='coupon_Amount'></td> </tr>"+
                    " <tr>"+
                        "<td colspan='3' align='right'> <b>SUBTOTAL :</b> </td>"+
                        "<td align='center'><span id='sub_Amount'> ₹"+courttotal+"</span></td> </tr>"+
                    "<tr> <td colspan='3' align='right'> <b>TOTAL :</b> <br> <small>(Including GST)</small> </td>"+
                        "<td align='center'> <span id='total_Amount'> ₹"+grandTotal+"</span>"+
                        "<input type='hidden' id='tot_amt' value='"+grandTotal+"' >"+
                        "<input type='hidden' id='getAmount' name='getAmount' value='"+storeGstAmount+"' >"+
                        "<input type='hidden' id='payment_amount' name='payment_amount' value='"+paymentAmount+"' >"+
                        "<input type='hidden' name='fld_acpid' id='cpid' />"+
                        "<input type='hidden' name='fld_acppercent' id='cperc' />"+
                        "<input type='hidden' name='fld_acpamt' id='cpamt' />"+
                        "</td> </tr>";

        $('#billbody').append(tblbody);
        $('#billfoot').append(tblfoot);
    }
    applyCoupon($('#coupon_name').val(), $('#tot_amt').val());
}

const settingweeks = <?= (!empty(json_encode($weeks)) ? json_encode($weeks) : []); ?>;

</script>