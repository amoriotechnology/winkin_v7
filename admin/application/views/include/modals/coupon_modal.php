<!----------------- Model form for add new / edit category ------------------->
<div class="modal fade" id="couponModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="CouponModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="" method="post" id="coupon_form">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white" id="CouponModalLabel"><?= isset($edit_cate[0]) ? 'Edit' : 'Add New'; ?> Coupons</h6>
                    <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModel('coupons')"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" style="text-align: right;"> <span class="text-danger fs-14">* Required Fields</span> </div>

                        <div class="col-md-12">
                            <label for="fld_cpname" class="form-label">Coupon Name <span class="text-danger">*</span> </label>
                            <input type="text" name="fld_cpname" id="fld_cpname" class="form-control mt-2" value="<?= (isset($edit_cate[0]['fld_cpname']) ? $edit_cate[0]['fld_cpname'] : ''); ?>" >
                            <span class="coupon-error-msg text-danger"></span>
                        </div>

                         <div class="col-md-12 mt-3">
                            <label for="fld_cp_percentage" class="form-label">Coupon Percentage % <span class="text-danger">*</span> </label>
                            <input type="text" name="fld_cp_percentage" id="fld_cp_percentage" oninput="NumberOnly(this, 2)" class="form-control mt-2" value="<?= (isset($edit_cate[0]['fld_cp_percentage']) ? $edit_cate[0]['fld_cp_percentage'] : ''); ?>" >
                            <span class="coupon-error-msg text-danger"></span>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="fld_cplimit" class="form-label">Coupon Usage Limit <span class="text-danger">*</span> </label>
                            <input type="text" name="fld_cplimit" id="fld_cplimit" oninput="NumberOnly(this, 2)" class="form-control mt-2" value="<?= (isset($edit_cate[0]['fld_cplimit']) ? $edit_cate[0]['fld_cplimit'] : ''); ?>" >
                            <span class="coupon-error-msg text-danger"></span>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="fld_cp_expdate" class="form-label">Coupon Expiry Date <span class="text-danger">*</span> </label>
                            <div class="input-group">
                                <input type="text" name="fld_cp_expdate" class="form-control flatpickr-input" id="fld_cp_expdate" value="<?= (isset($edit_cate[0]['fld_cp_expdate']) ? $edit_cate[0]['fld_cp_expdate'] : ''); ?>">
                                <div class="input-group-text">
                                    <label for="fld_cp_expdate" class="bi bi-calendar"></label>
                                </div>
                            </div>
                            <span class="coupon-error-msg text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModel('coupons')" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                    <input type="hidden" name="cpid" value="<?= (isset($edit_cate[0]['fld_cpid']) ? md5($edit_cate[0]['fld_cpid']) : ''); ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                </div>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">

$(document).ready(function() {

    /* ----------------- Model ajax for add / edit coupon ------------------- */
    $("#coupon_form").submit(function(e) {
        e.preventDefault();

        const couponname = $('#fld_cpname').val();
        const couponpercent = $('#fld_cp_percentage').val();
        const couponlimit = $('#fld_cplimit').val();
        const couponexpdate = $('#fld_cp_expdate').val();

        $('.coupon-error-msg').html('');
        $(this).find('.form-control, .row').css('border', '');

        var action = validation({'fld_cpname' : couponname, 'fld_cp_percentage' : couponpercent, 'fld_cplimit' : couponlimit, 'fld_cp_expdate' : couponexpdate});
        if(action === false) { return action;}

        $.ajax({
            url: '<?= base_url('add_coupon') ?>',
            type: 'post',
            data : $(this).serialize(),
            dataType: 'json',
            success : function (res) {                    
                if(res.status == 200) {
                    AlertPopup('Success!', res.alert_msg.word, 'success', 'Ok', 'coupons');
                } else {
                    AlertPopup('No Changes Detected!', '', 'info', 'Ok', 'coupons');
                }
            }, 
            error : function(res) { console.log(res); }
       });
    });

});


document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#fld_cp_expdate", {
        enableTime: false, 
        dateFormat: "d-m-Y",
        minDate: "today"
    });
});
</script>