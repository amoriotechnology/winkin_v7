<!--------------------- Model form for add new / edit service ---------------------->
<div class="modal fade" id="serviceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="" method="post" id="serv_form">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white" id="serviceModalLabel"> Add New Service </h6>
                    <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" onclick="editService(this)" data-bs-dismiss="modal" aria-label="Close" ></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="serv_name" class="form-label">Service Name <span class="text-danger">*</span> </label>
                            <input type="text" name="serv_name" id="serv_name" class="form-control mt-2" value="" >
                            <span class="error-msg text-danger"></span>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="cate" class="form-label">Category</label>
                            <select class="form-control" name="cate" id="cate">
                                <option value=""> Select Option </option>
                                <?php if(!empty($cate_records)) {
                                    $scate = isset($edit_serv[0]['fld_scate']) ? $edit_serv[0]['fld_scate'] : "";
                                    foreach($cate_records as $cate) { ?>
                                    <option value="<?= $cate['fld_catename']; ?>" > <?= $cate['fld_catename']; ?> </option>
                                <?php } } ?>
                            </select>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="serv_duration" class="form-label">Duration <span class="text-danger">*</span> </label>
                            <div class="input-group">
                                <input type="text" name="serv_duration" class="form-control" id="serv_duration" value="" >
                                <div class="input-group-text">
                                    <label for="serv_duration" class="bi bi-clock"></label>
                                </div>
                            </div>
                            <span class="error-msg text-danger"></span>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="serv_rate" class="form-label">Rate ($) <span class="text-danger">*</span> </label>
                            <input type="text" name="serv_rate" id="serv_rate" class="form-control mt-2" oninput="AmtOnly(this, 8)" value="" >
                            <span class="error-msg text-danger"></span>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="serv_type" class="form-label">Service for <span class="text-danger">*</span> </label>
                            <select class="form-control" name="serv_type" id="serv_type">
                                <option value=""> Select Option </option>
                                <?php $stype = isset($edit_serv[0]['fld_stype']) ? $edit_serv[0]['fld_stype'] : ""; ?>
                                <option value="Male" >Male</option>
                                <option value="Female" >Female</option>
                                <option value="Both" >Both</option>
                            </select>
                            <span class="error-msg text-danger"></span>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="serv_desc" class="form-label">Short Description</label>
                            <textarea name="serv_desc" rows="4" maxlength="250" id="serv_desc" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="editService(this)" >Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                    <input type="hidden" name="sid" id="servid" value="">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                </div>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">

$(document).ready(function() {

    $('#serv_duration').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
    });

    /* ------------------------ Model ajax for active / deactive service ---------------------- */
    $("body").on('click', '.update_serv_btn', function () {
        
        var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
        var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
        var status = $(this).data('status');

        Swal.fire({
            title: "Are you sure?",
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
                data: { [csrfName]: csrfHash, id: $(this).data('id'), type:status, coloum : 'fld_sstatus', table: 'service' },
                dataType: 'json',
                success: function(res) { 
                    AlertPopup('Success!', "Service has been "+status+"!!!", 'success', 'Ok', '');
                }
            });
        }/* else if (e.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Cancelled', 'Your data is safe :)', 'info');
        }*/
        });
    });


    /* ------------------- Model ajax for add / edit service ------------------------ */
    $("#serv_form").submit(function(e) {
        e.preventDefault();

        const serv = $('#serv_name').val();
        const serv_duration = $('#serv_duration').val();
        const serv_rate = $('#serv_rate').val();
        const serv_type = $('#serv_type').val();

        $('.error-msg').html('');
        $(this).find('.form-control').css('border', '');
        
        var action = validation({'serv_name':serv, 'serv_duration':serv_duration, 'serv_rate':serv_rate, 'serv_type':serv_type});
        if(action === false) { return action; }

        $.ajax({
            url: '<?= base_url('add_service') ?>',
            type: 'post',
            data : $(this).serialize(),
            dataType: 'json',
            success : function (res) {
                
                if(res.status == 200) {
                    AlertPopup('Success!', res.alert_msg.word, 'success', 'Ok', 'service');
                } else {
                    AlertPopup('No Changes Detected!', res.alert_msg.word, 'info', 'Ok', 'service');
                }
            }, 
            error: function(xhr, status, error) { console.log(xhr.responseText); }
       });
    });

});


/* --------- Edit Service Details ------------- */
function editService(editid) {
    var sid = $(editid).data('id');
    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    $('#serviceModalLabel').html('Add New Service');
    $('#servid, #serv_name, #cate, #serv_duration, #serv_rate, #serv_type, #serv_desc').val('');
    removeValidation({'serv_name':serv_name, 'serv_duration':serv_duration, 'serv_rate':serv_rate, 'serv_type':serv_type});

    if(sid != "" && sid != undefined) {
        $.ajax({
            url: "<?= base_url('view_records'); ?>",
            type: 'POST',
            data: { [csrfName]:csrfHash, id:sid, type:'service' },
            dataType: 'json',
            success: function(res) {

                if(res.length > 0) {
                    $('#serviceModalLabel').html('Edit Service');
                    $('#servid').val(res[0]["fld_sid"]);
                    $('#serv_name').val(res[0]['fld_sname']);
                    $('#cate').val(res[0]['fld_scate']);
                    $('#serv_duration').val(MinutesToHour(res[0]['fld_sduration']));
                    $('#serv_rate').val(res[0]['fld_srate']);
                    $('#serv_type').val(res[0]['fld_stype']);
                    $('#serv_desc').val(res[0]['fld_sdesc']);
                }
            },
            error: function(xhr, status, error) { console.log(xhr.responseText); }
        });
    }
}

</script>