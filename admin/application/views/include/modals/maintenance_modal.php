<?php 

    $cmpy_time = $cmpy_info['fld_hours'];
    $cmpy_time = explode(" - ", $cmpy_time);
    $start_time = $cmpy_time[0];
    $end_time = str_replace(['00'], '30', $cmpy_time[1]);
?>
<!----------------- Model form for add new / edit category ------------------->
<div class="modal fade" id="maintain_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="MaintainModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form action="" method="post" id="maintain_form">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white" id="MaintainModalLabel"><?= isset($edit_maintenance[0]) ? 'Edit' : 'Add'; ?> Court Maintenance</h6>
                    <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModel('view_maintenance')"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" style="text-align: right;"> <span class="text-danger fs-14">* Required Fields</span> </div>

                        <div class="col-md-6">
                            <label for="fld_cpname" class="form-label">Court <span class="text-danger">*</span> </label>
                            <select class="form-select" name="mnt_court" id="mnt_court">
                                <option value="courtA" <?= ((isset($edit_maintenance[0]['fld_aserv']) && $edit_maintenance[0]['fld_aserv'] == "courtA" ) ? 'Selected' : ''); ?> >Court A</option>
                                <option value="courtB" <?= ((isset($edit_maintenance[0]['fld_aserv']) && $edit_maintenance[0]['fld_aserv'] == "courtB" ) ? 'Selected' : ''); ?> >Court B</option>
                            </select>
                            <span class="maintaincourt-error-msg text-danger"></span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fs-14">Date <span class="text-danger">*</span></label>
                            <input type="text" name="mnt_date" class="form-control daterange" id="mnt_date" value="<?= (isset($edit_maintenance[0]['fld_adate']) ? showDate($edit_maintenance[0]['fld_adate']) : ''); ?>">
                            <span class="maintaindate-error-msg text-danger"></span>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label fs-14">From Time <span class="text-danger">*</span></label>
                            <input type="text" name="mnt_frm_time" class="form-control timerange" min="" id="mnt_frm_time" value="<?= (isset($startTime) ? $startTime : ''); ?>">
                            <span class="maintainfrm_time-error-msg text-danger"></span>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label fs-14">End Time <span class="text-danger">*</span></label>
                            <input type="text" name="mnt_end_time" class="form-control timerange" id="mnt_end_time" value="<?= (isset($last_time) ? TimeDuration($last_time, 30) : ''); ?>">
                            <span class="maintainfrm_end-error-msg text-danger"></span>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label class="form-label fs-14">Reason</label>
                            <textarea class="form-control" name="mnt_reason" id="mnt_reason"><?= (isset($edit_maintenance[0]['fld_areason']) ? $edit_maintenance[0]['fld_areason'] : ''); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModel('view_maintenance')" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                    <input type="hidden" name="maintain_id" value="<?= (isset($edit_maintenance[0]['fld_aid']) ? $edit_maintenance[0]['fld_aid'] : ''); ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                </div>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">

$(document).ready(function() {

    /* ----------------- Model ajax for add / edit coupon ------------------- */
    $("#maintain_form").submit(function(e) {
        e.preventDefault();

        const mnt_court = $('#mnt_court').val();
        const mnt_date = $('#mnt_date').val();
        const mnt_frm_time = $('#mnt_frm_time').val();
        const mnt_end_time = $('#mnt_end_time').val();

        $('.coupon-error-msg').html('');
        $(this).find('.form-control, .row').css('border', '');

        var action = validation({'mnt_court' : mnt_court, 'mnt_date' : mnt_date, 'mnt_frm_time' : mnt_frm_time, 'mnt_end_time' : mnt_end_time});
        if(action === false) { return action;}

        $.ajax({
            url: '<?= base_url('add_maintenance') ?>',
            type: 'post',
            data : $(this).serialize(),
            dataType: 'json',
            success : function (res) {                    
                if(res.status == 200) {
                    AlertPopup('Success!', res.alert_msg.word, 'success', 'Ok', 'view_maintenance');
                } else {
                    AlertPopup(res.alert_msg, '', 'error', 'Ok', 'view_maintenance');
                }
            }, 
            error : function(res) { console.log(res); }
       });
    });

    $("#mnt_date").flatpickr({
        dateFormat: "d/m/Y",
        minDate: new Date(), 
        maxDate: new Date().fp_incr(30),
        defaultDate: new Date(),
        onChange: function(selectedDates, dateStr, instance) {
            selectedDate = selectedDates; 
            if(selectedDates[0] != undefined && selectedDates[0].toLocaleDateString('en-GB') == dateStr) {
                $('.flatpickr-day').removeClass('today');
            }
        }
    });

    $('#mnt_frm_time').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K",
        time_24hr: false,
        allowInput: true,
        minuteIncrement: 30,
        onChange: function(selectedDates, dateStr, instance) {
            var sel_date = $("#mnt_date").val();
            var sel_date = sel_date.split("/");
            var today = new Date();
            if(sel_date != "") {
                today = new Date(sel_date[1]+'/'+sel_date[0]+'/'+sel_date[2]);
            }
            const selectedDate = selectedDates[0];
            if (selectedDate && selectedDate.toDateString() !== today.toDateString()) {
                instance.config.minTime = "<?= $start_time; ?>";
                instance.config.maxTime = "<?= $end_time ?>";
            } else {
                const now = new Date();
                const minutes = now.getMinutes();
                const nextHalfHour = Math.ceil(minutes / 30) * 30;
                now.setMinutes(nextHalfHour, 0, 0);
                instance.config.minTime = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                instance.config.maxTime = "<?= $end_time ?>";
            }
            instance.set('minTime', instance.config.minTime);
            instance.set('maxTime', instance.config.maxTime);
        }
    });

    $('#mnt_end_time').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K",
        time_24hr: false,
        minuteIncrement: 30,
        onChange: function(selectedDates, dateStr, instance) {
            var sel_date = $("#mnt_date").val();
            var sel_date = sel_date.split("/");
            var today = new Date();
            if(sel_date != "") {
                today = new Date(sel_date[1]+'/'+sel_date[0]+'/'+sel_date[2]);
            }
            const selectedDate = selectedDates[0];
            if (selectedDate && selectedDate.toDateString() !== today.toDateString()) {
                instance.config.minTime = "<?= $start_time; ?>";
                instance.config.maxTime = "<?= $end_time ?>";
            } else {
                const now = new Date();
                const minutes = now.getMinutes();
                const nextHalfHour = Math.ceil(minutes / 30) * 30;
                now.setMinutes(nextHalfHour, 0, 0);
                instance.config.minTime = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                instance.config.maxTime = "<?= $end_time ?>";
            }
            instance.set('minTime', instance.config.minTime);
            instance.set('maxTime', instance.config.maxTime);
        }
    });

});

</script>