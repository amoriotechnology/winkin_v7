<!---------------- Modal form for add new / edit customer ------------------->
<div class="modal fade" id="addCustModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="custModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title text-white" id="custModalLabel"> Add New Customer </h6>
                <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="editCustomer(this)"></button>
            </div>

            <form action="" method="post" id="cust_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" style="text-align: right;"> <span class="text-danger fs-14">* Required Fields</span> </div>

                        <div class="col-md-6 mt-3">
                            <label for="cust_name" class="form-label">First Name <span class="text-danger">*</span> </label>
                            <input type="text" name="cust_name" id="cust_name" class="form-control" value="" oninput="AlphaOnly(this)" >
                            <span class="cust-error-msg text-danger"></span>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="cust_lname" class="form-label">Last Name </label>
                            <input type="text" name="cust_lname" id="cust_lname" class="form-control" value="" oninput="AlphaOnly(this)" >
                            <span class="cust-error-msg text-danger"></span>
                        </div>

                        <div class="col-xl-6 mt-3">
                            <label class="cust_phone" class="form-label">Phone Number <span class="text-danger">*</span> </label>
                            <div class="input-group">
                                
                            </div>
                            <input type="text" name="cust_phone" class="form-control mt-2" id="cust_phone" oninput="NumberOnly(this, 10)" value="" >
                            <input type="hidden" id="checkmob_list">
                            <span class="appoint-error-msg text-danger"></span>
                        </div>
                    
                        <div class="col-md-6 mt-3">
                            <label for="cust_email" class="form-label">Email <span class="text-danger">*</span> </label>
                            <input type="text" name="cust_email" id="cust_email" class="form-control" value="" >
                            <span class="cust-error-msg text-danger"></span>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="cust_dob" class="form-label">Date of Birth <span class="text-danger">*</span> </label>
                            <div class="input-group">
                                <input type="text" name="cust_dob" id="cust_dob" class="anni_datepicker form-control" value="" >
                                <div class="input-group-text">
                                    <label for="cust_dob"class="bi bi-calendar"></label>
                                </div>
                            </div>
                            <span class="cust-error-msg text-danger"></span>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="editCustomer(this)" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="cust_submit">Save</button>
                    <input type="hidden" name="cust_id" id="custoid" value="<?= (isset($edit_cust[0]['fld_id']) ? md5($edit_cust[0]['fld_id']) : ''); ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                </div>
            </form>

        </div>
    </div>
</div>


<script type="text/javascript">

$(document).ready(function() {

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    /* -------- Check the mobile number exist or not --------- */
    $('#cust_phone').on('keyup', function() {
        var phone = $(this).val();
        var checkmob = $('#checkmob_list').val();
        var element = $('#cust_phone').parent().children('span');
        element.html('').addClass('text-danger');

        if(phone.length > 9) {

            $('#cust_submit').removeAttr('disabled');
            $.ajax({
                url: "<?= base_url('checkExistorNot'); ?>",
                type: 'post',
                data: {[csrfName]: csrfHash, phone : phone},
                dataType: 'json',
                success: function(res) {
                    element.html('New Customer').removeClass('text-danger').addClass('text-success');

                    if (checkmob == '') {
                        if (res != "") {
                            element.html('Existing Customer').removeClass('text-success').addClass('text-danger');
                            $('#cust_submit').attr('disabled', 'disabled');
                        } else {
                            element.html('').removeClass('text-success').addClass('text-danger');
                        }
                    }
                },
                error: function(xhr, status, error) { console.log(xhr.responseText); }
            });
        }
    });


    /*--------- manipulate anniversary date -----------*/
    $('#cust_mari_sts').on('change', function() {
        var maritial_sts = $(this).val();
        $('.anni_field').addClass('d-none');
        if(maritial_sts == "Married") { $('.anni_field').removeClass('d-none'); }
    });


    /* ------------------------ Modal ajax for add / edit customer ---------------------- */
    $("#cust_form").submit(function(e) {
        e.preventDefault();

        const cust_name = $('#cust_name').val();
        const cust_phone = $('#cust_phone').val();
        const cust_email = $('#cust_email').val();
        const cust_dob = $('#cust_dob').val();
        const cust_gender = $("#cust_gender").val();
        const cust_mari_sts = $("#cust_mari_sts").val();
        const cust_addr = $('#cust_addr').val();
        const cust_notes = $('#cust_notes').val();

        $('.cust-error-msg').html('');
        $(this).find('.form-control, .row').css('border', '');

        var action = validation({'cust_name':cust_name, 'cust_phone':cust_phone, 'cust_email':cust_email, 'cust_gender':cust_gender, 'cust_dob':cust_dob, 'cust_mari_sts':cust_mari_sts, 'cust_addr':cust_addr});

        if(action === false) { return action; }

        $.ajax({
            url: '<?= base_url('add_customer') ?>',
            type: 'post',
            data : $(this).serialize(),
            dataType: 'json',
            success : function (res) {
                console.log(res);
                if(res.status == 200) {
                    AlertPopup('Success!', res.alert_msg.word, 'success', 'Ok', 'customer');
                } else {
                    AlertPopup('Error', res.alert_msg, 'error', 'Ok', 'customer');
                }
            }, 
            error : function(xhr, status, error) { console.log(xhr.responseText); }
       });
    });

});



function editCustomer(editid) {
    var cid = $(editid).data('id');
    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    $('#custModalLabel').html('Add New Customer');
    $('#custoid, #cust_name, #cust_phone, #cust_email, #cust_dob').val('');
    removeValidation({'cust_name':cust_name, 'cust_phone':cust_phone, 'cust_email':cust_email, 'cust_dob':cust_dob});
    $('#cust_phone').removeAttr('readonly');
    $('#checkmob_list').val('');

    if(cid != "" && cid != undefined) {
        $.ajax({
            url: "<?= base_url('view_records'); ?>",
            type: 'POST',
            data: { [csrfName]:csrfHash, id:cid, type:'customer' },
            dataType: 'json',
            success: function(res) {

                if(res.length > 0) {
                    $('#custModalLabel').html('#'+res[0].fld_custid+' - Edit Customer');
                    $('#custoid').val(res[0].fld_id);
                    $('#cust_name').val(res[0].fld_name);
                    $('#cust_lname').val(res[0].fld_lastname);
                    $('#cust_phone').val(res[0].fld_phone);
                    $('#cust_phone').attr('readonly', 'readonly');
                    $('#checkmob_list').val('edit_mobileno');
                    $('#cust_email').val(res[0].fld_email);
                    $('#cust_dob').val(displayDate(res[0].fld_dob));
                }
            },
            error: function(xhr, status, error) { console.log(xhr.responseText); }
        });
    }
}
</script>
