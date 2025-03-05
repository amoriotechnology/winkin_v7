
<!--------------------- Model form for add new / edit staffs ---------------------->
<div class="modal fade" id="addStaffModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staffModalLabel" style="display: none;" aria-hidden="true">
<?php 
    $staff_exp = ['', '']; 
    $staff_gen = $staff_mari = "";
    if(isset($edit_staff[0])) { 
        $staff_exp = explode(", ", $edit_staff[0]['fld_uexperience']); 
        $staff_gen = $edit_staff[0]['fld_ugender'];
        $staff_mari = $edit_staff[0]['fld_umarital_sts'];
    } 

?>
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <h6 class="modal-title text-white" id="staffModalLabel"> Add New Staff</h6>
            <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="editStaff(this)"></button>
        </div>

        <form action="" method="post" id="staff_form">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" style="text-align: right;"> <span class="text-danger fs-14">* Required Fields</span> </div>

                    <div class="col-md-6 mt-3">
                        <label for="staff_name" class="form-label">Name <span class="text-danger">*</span> </label>
                        <input type="text" name="staff_name" id="staff_name" class="form-control" value="" oninput="AlphaWithSpaces(this)">
                        <span class="staff-error-msg text-danger"></span>
                    </div>
                    
                    <div class="col-md-6 mt-3">
                        <label for="staff_phone" class="form-label">Phone <span class="text-danger">*</span> </label>
                        <input type="text" name="staff_phone" id="staff_phone" class="form-control" value="" oninput="NumberOnly(this, 10)" >
                        <span class="staff-error-msg text-danger"></span>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="staff_email" class="form-label">Email <span class="text-danger">*</span> </label>
                        <input type="text" name="staff_email" id="staff_email" class="form-control" value="" >
                        <span class="staff-error-msg text-danger"></span>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="staff_designation" class="form-label">Designation <span class="text-danger">*</span> </label>
                        <input type="text" name="staff_designation" id="staff_designation" class="form-control" value="" oninput="AlphaWithSpaces(this)">
                        <span class="staff-error-msg text-danger"></span>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="staff_doj" class="form-label">Date of Joining <span class="text-danger">*</span> </label>
                        <div class="input-group">
                            <input type="text" name="staff_doj" id="staff_doj" class="anni_datepicker form-control" value="" >
                            <div class="input-group-text">
                                <label for="staff_doj" class="bi bi-calendar "></label>
                            </div>
                        </div>
                        <span class="staff-error-msg text-danger"></span>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="staff_gender" class="form-label mb-1">Gender <span class="text-danger">*</span> </label>
                        <select name="gender" class="form-control" id="staff_gender">
                            <option value="">Select Option</option>
                            <option value="Male" >Male</option>
                            <option value="Female" >Female</option>
                            <option value="Other" >Other</option>
                        </select>
                        <span class="staff-error-msg text-danger"></span>
                    </div>


                    <div class="col-md-6 mt-3">
                        <label for="staff_dob" class="form-label">Date of Birth <span class="text-danger">*</span> </label>
                        <div class="input-group">
                            <input type="text" name="staff_dob" id="staff_dob" class="anni_datepicker form-control" value="" >
                            <div class="input-group-text">
                                <label for="staff_dob" class="bi bi-calendar "></label>
                            </div>
                        </div>                        
                        <span class="staff-error-msg text-danger"></span>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="staff_year" class="form-label">Experience in Year(s)</label>
                                <input type="text" name="staff_year" id="staff_year" class="form-control" value="" oninput="NumberOnly(this, 2);" >
                                <span class="staff-error-msg text-danger"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="staff_month" class="form-label">Experience in Month(s)</label>
                                <select name="staff_month" class="form-control" id="staff_month">
                                    <option value="0" >0</option>
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                                    <option value="5" >5</option>
                                    <option value="6" >6</option>
                                    <option value="7" >7</option>
                                    <option value="8" >8</option>
                                    <option value="9" >9</option>
                                    <option value="10" >10</option>
                                    <option value="11" >11</option>
                                </select>
                                <span class="staff-error-msg text-danger"></span>
                            </div>
                        </div>
                        <span class="staff-error-msg text-danger"></span>
                    </div>

                    <div class="col-md-6 mt-3 uanni_field d-none">
                        <label for="staff_anniversary" class="form-label">Anniversary Date</label>
                        <div class="input-group">
                            <input type="text" name="staff_anni" id="staff_anniversary" class="form-control anni_datepicker" value="" >
                            <div class="input-group-text">
                                <label for="staff_anniversary" class="bi bi-calendar"></label>
                            </div>
                        </div>
                        <span class="cate-error-msg text-danger"></span>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="staff_serv" class="form-label">Access Management <small>(Module-wise)</small> <span class="text-danger">*</span> </label>
                        <input type="text" name="staff_access" id="staff_access" class="form-control" value="">
                        <span class="staff-error-msg text-danger"></span>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="staff_addr" class="form-label">Address <span class="text-danger">*</span> </label>
                        <textarea name="staff_addr" id="staff_addr" rows="4" class="form-control"></textarea>
                        <span class="staff-error-msg text-danger"></span>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="editStaff(this)" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" id="staff_submit">Save</button>
                <input type="hidden" name="staff_id" id="uid" value="">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
            </div>
        </form>

    </div>
</div>
</div>

<?php 
    $listserv = "[]";
    if(isset($serv_record) && !empty($serv_record)) {
        $listserv = $serv_record;
    } 
?>

<script type="text/javascript">

$(document).ready(function() {

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    var servs = <?= $listserv; ?>;
    var input = document.getElementById('staff_access');
    
    p = document.querySelector('input[name="staff_access"]');
    a = new Tagify(p, {
        whitelist: servs,
        maxTags: 10,
        dropdown: {
            maxItems: 20,
            classname: "tags-look",
            enabled: 0,
            closeOnSelect: !1
        }
    });


    /* -------- Check the mobile number exist or not --------- */
    $('#staff_email').on('keyup', function() {
        var email = $(this).val();
        var element = $('#staff_email').parent().children('span');
        element.html('').addClass('text-danger');

        if(IsEmail(email) != false) {

            $('#staff_submit').removeAttr('disabled');
            $.ajax({
                url: "<?= base_url('checkExiststaff'); ?>",
                type: 'post',
                data: {[csrfName]: csrfHash, email : email},
                dataType: 'json',
                success: function(res) {
                    element.html('New Staff').removeClass('text-danger').addClass('text-success');

                    if(res != "") {
                        element.html('Existing Staff').removeClass('text-success').addClass('text-danger');
                        $('#staff_submit').attr('disabled', 'disabled');
                    }
                },
                error: function(xhr, status, error) { console.log(xhr.responseText); }
            });
        }
    });


    /* ------------------------ Model ajax for update active / deactive ---------------------- */
    $("body").on('click', '.update_staff_btn', function () {
        
        var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
        var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
        var status = $(this).data('status');

        Swal.fire({
            title: "Are you sure "+status+"?",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, "+status+" it!",
        }).then((e) => {

        if (e.isConfirmed) {
            
            $.ajax({
                url: '<?= base_url('common_update'); ?>',
                type: 'post',
                data: { [csrfName]: csrfHash, id: $(this).data('id'), type:status, coloum : 'fld_ustatus', table: 'staff' },
                dataType: 'json',
                success: function(res) { 
                    AlertPopup('Success', "Staff has been "+status, 'success', 'Ok', "");
                }
            });
        }/* else if (e.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Cancelled', 'Your data is safe :)', 'info');
        }*/
        });
    });


    /* ------------------------ manipulate anniversary date ---------------------- */
    $('#staff_marital_sts').on('change', function() {
        var maritial_sts = $(this).val();
        $('.uanni_field').addClass('d-none');
        if(maritial_sts == "Married") { $('.uanni_field').removeClass('d-none'); }
    });


    /* ------------------------ Model ajax for add / edit staff ---------------------- */
    $("#staff_form").submit(function(e) {
        e.preventDefault();

        const staff_name = $('#staff_name').val();
        const staff_phone = $('#staff_phone').val();
        const staff_email = $('#staff_email').val();
        const staff_doj = $('#staff_doj').val();
        const staff_dob = $('#staff_dob').val();
        const staff_access = $('#staff_access').val();
        const staff_addr = $('#staff_addr').val();
        const staff_gender = $("#staff_gender").val();
        const staff_designation = $("#staff_designation").val();
        const staff_month = $("#staff_month").val();

        $('.staff-error-msg').html('');
        $(this).find('.form-control, .row').css('border', '');

        var action = validation({'staff_name': staff_name, 'staff_phone':staff_phone, 'staff_email':staff_email, 'staff_doj':staff_doj, 'staff_gender':staff_gender, 'staff_designation':staff_designation, 'staff_month':staff_month, 'staff_dob':staff_dob, 'staff_access':staff_access, 'staff_addr':staff_addr});

        if(action === false) { return action; }

        $.ajax({
            url: '<?= base_url('add_staff') ?>',
            type: 'post',
            data : $(this).serialize(),
            dataType: 'json',
            success : function (res) {
                
                if(res.status == 200) {
                    AlertPopup('Success', res.alert_msg.word, 'success', 'Ok', "staff");
                } else {
                    AlertPopup('No Changes Detected!', "", 'info', 'Ok', "staff");
                }
            }, 
            error: function(xhr, status, error) { console.log(xhr.responseText); }
       });
    });

});


/* ----- Edit staff details ----- */
function editStaff(editid) {
    var cid = $(editid).data('id');
    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    $('#staffModalLabel').html('Add New Staff');
    $('#uid, #staff_name, #staff_phone, #staff_email, #staff_designation, #staff_doj, #staff_gender, #staff_dob, #staff_year, #staff_month, #staff_anniversary, #staff_access, #staff_addr').val('');
    removeValidation({'staff_name': staff_name, 'staff_phone':staff_phone, 'staff_email':staff_email, 'staff_doj':staff_doj, 'staff_gender':staff_gender,'staff_year':staff_year, 'staff_designation':staff_designation, 'staff_month':staff_month, 'staff_dob':staff_dob, 'staff_access':staff_access, 'staff_addr':staff_addr});

    if(cid != "" && cid != undefined) {
        $.ajax({
            url: "<?= base_url('view_records'); ?>",
            type: 'POST',
            data: { [csrfName]:csrfHash, id:cid, type:'staff' },
            dataType: 'json',
            success: function(res) {

                if(res.length > 0) {
                    $('#staffModalLabel').html('#'+res[0].fld_staffid+' - Edit Staff');
                    $('#uid').val(res[0].fld_uid);
                    $('#staff_name').val(res[0].fld_uname);
                    $('#staff_phone').val(res[0].fld_uphone);
                    $('#staff_email').val(res[0].fld_uemail);
                    $('#staff_doj').val(displayDate(res[0].fld_udoj));
                    $('#staff_gender').val(res[0].fld_ugender);
                    $('#staff_dob').val(displayDate(res[0].fld_udob));
                    $('#staff_designation').val(res[0].fld_staff_designation);
                    if(res[0].fld_umarital_sts == "Married") { $('.uanni_field').removeClass('d-none'); }
                    $('#staff_anniversary').val(displayDate(res[0].fld_uanniversary));
                    var expe = res[0].fld_uexperience.split(", ");
                    $('#staff_year').val(expe[0]);
                    $('#staff_month').val(expe[1]);
                    $('#staff_access').val(res[0].fld_access);
                    $('#staff_addr').val(res[0].fld_uaddress);
                }
            },
            error: function(xhr, status, error) { console.log(xhr.responseText); }
        });
    }
}
</script>