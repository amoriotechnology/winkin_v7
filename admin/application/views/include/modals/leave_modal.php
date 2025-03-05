<!--------------------- Model form for add new / edit leave ---------------------->
<div class="modal fade" id="LeaveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="LeaveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="" method="post" id="leave_form">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white" id="LeaveModalLabel"> Add Leave</h6>
                    <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModel('leaves')"> </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="person" class="form-label">Name <span class="text-danger">*</span> </label>
                            <select name="person" class="form-control" id="person" >
                                <?php 
                                if($info['role'] == STAFF) {
                                    echo '<option value="'.$info['uname'].'|'.$info['uid'].'" >'.$info['uname'].'</option>';
                                }

                                if(!empty($staff_ids) && $info['role'] == ADMIN) {
                                    $staff_id = (isset($edit_leave[0])) ? $edit_leave[0]['fld_lstaff_id'] : '';
                                    echo '<option value="">Select Option</option>';
                                    foreach($staff_ids as $ids) {
                                ?>
                                    <option value="<?= $ids['fld_uname'].'|'.$ids['fld_uid']; ?>" > <?= $ids['fld_uname']; ?> </option>
                                <?php } } ?>
                            </select>
                            <span class="leave-error-msg text-danger"></span>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="leave_date" class="form-label">From & To Date <span class="text-danger">*</span> </label>
                            <div class="input-group">
                                <input type="text" name="leave_date" class="form-control leavedatepicker" id="leave_date" value="" >
                                <div class="input-group-text">
                                    <label for="leave_date" class="bi bi-calendar"></label>
                                </div>
                            </div>
                            <span class="leave-error-msg text-danger" id="leavevalidate"></span>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="reason" class="form-label">Reason <span class="text-danger">*</span> </label>
                            <textarea name="reason" rows="4" id="reason" class="form-control"></textarea>
                            <span class="leave-error-msg text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModel('leaves')" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="leave_submit" >Save</button>
                    <input type="hidden" name="lid" id="lid" value="<?= (isset($edit_leave[0]['fld_lid']) ? $edit_leave[0]['fld_lid'] : ''); ?>" >
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>" >
                </div>
            </div>
        </form>
    </div>
</div>


<!-------- Leave rejection reason model --------->
<div class="modal fade" id="RejectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="RejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="" method="post" id="reject_form">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white" id="RejectModalLabel"> Rejection Reason </h6>
                    <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModel('leaves')"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="rej_person" class="form-label">Person</label>
                            <input type="text" class="form-control" id="rej_person" value="" readonly >
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="leavedate" class="form-label">From & To Date</label>
                            <input type="text" class="form-control leavedate" id="leavedate" value="" disabled >
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="rej_reason" class="form-label">Reason For Rejection <span class="text-danger">*</span> </label>
                            <textarea name="rej_reason" rows="4" id="rej_reason" class="form-control"><?= (isset($edit_leave[0]) ? $edit_leave[0]['fld_lreason'] : ''); ?></textarea>
                            <span class="leave-error-msg text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModel('leaves')" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="leave_submit">Save</button>
                    <input type="hidden" name="lid" id="rej_lid" value="" >
                    <input type="hidden" name="sts" value="Rejected" >
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>" >
                </div>
            </div>
        </form>
    </div>
</div>


<!-------- Leave rejection reason model --------->
<div class="modal fade" id="RejectRequModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="RejectRequModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="" method="post" id="reject_form">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white" id="RejectRequModalLabel"> Rejection Request Detail </h6>
                    <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModel('leaves')"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="rej_requ_person" class="form-label">Person</label>
                            <input type="text" class="form-control" id="rej_requ_person" value="" readonly >
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="requ_leavedate" class="form-label">From & To Date</label>
                            <input type="text" class="form-control requ_leavedate" id="requ_leavedate" value="" disabled >
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="rej_requ_reason" class="form-label"> Rejection Request </label>
                            <textarea name="rej_requ_reason" rows="4" id="rej_requ_reason" class="form-control" readonly><?= (isset($edit_leave[0]) ? $edit_leave[0]['fld_lreason'] : ''); ?></textarea>
                            <span class="leave-error-msg text-danger"></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">

$(document).ready(function() {

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    /* ------------------------ Model ajax for delete leave ---------------------- */
    $("body").on('click', '.update_btn', function () {
        var status = $(this).data('status');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
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
                data: { [csrfName]: csrfHash, id: $(this).data('id'), type: status, coloum : 'fld_lstatus', table: 'leave' },
                dataType: 'json',
                success: function(res) { 
                    AlertPopup(status, "Your leave has been "+status, 'success', 'Ok', ''); 
                }
            });
        }/* else if (e.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Cancelled', 'Your data is safe :)', 'info');
        }*/
        });
    });


    /* ------------------------ Model ajax for edit leave status ---------------------- */
    $('body').on('click', '.update_leave', function() {
        var lid = $(this).data('id');
        var status = $(this).data('status');
        
        $.ajax({
            url: '<?= base_url('add_leave'); ?>',
            type: 'post',
            data: { [csrfName]: csrfHash, 'lid': lid, 'sts': status },
            dataType: 'json',
            success: function(res) {
                if(res.status == 200) {
                    AlertPopup('Success!', status+' Successfully!!!', 'success', 'Ok', 'leaves');                    
                } else {
                    AlertPopup('No Changes Detected!!!', '', 'info', 'Ok', 'leaves');
                }
            },
            error: function(xhr, status, error) { console.log(xhr.responseText); }
        });
    });


    /* ------------------------ Model ajax for add / edit leave ---------------------- */
    $("#leave_form").submit(function(e) {
        e.preventDefault();

        const person = $('#person').val();
        const leave_date = $('#leave_date').val();
        const reason = $('#reason').val();

        $('.leave-error-msg').html('');
        $(this).find('.form-control, .row').css('border', '');

        var action = validation({'person':person, 'leave_date':leave_date, 'reason':reason});
        if(action === false) { return action; }

        var ids = person.split("|");
        var leavedates = leave_date.split(" to ");

        $.ajax({
            url: '<?= base_url('add_leave') ?>',
            type: 'post',
            data : $(this).serialize(),
            dataType: 'json',
            success : function (res) {

                if(res.status == 200) {
                    AlertPopup('Success!!!', res.alert_msg.word, 'success', 'Ok', 'leaves');                     
                } else if(res.status == 402) {
                    AlertPopup('Warning!!!', res.alert_msg.word, 'info', 'Ok', 'leaves');                
                } else {
                    AlertPopup('No Changes Detected!!!', '', 'info', 'Ok', 'leaves');
                }
            }, 
            error: function(xhr, status, error) { console.log(xhr.responseText); }
       });
    });


    /* ------------------------ Model ajax for update rejection reason leave ---------------------- */
    $("#reject_form").submit(function(e) {
        e.preventDefault();

        const rej_reason = $('#rej_reason').val();

        $('.leave-error-msg').html('');
        $(this).find('.form-control, .row').css('border', '');
        var action = validation({'rej_reason': rej_reason});
        if(action === false) { return action; }

        $.ajax({
            url: '<?= base_url('add_leave') ?>',
            type: 'post',
            data : $(this).serialize(),
            dataType: 'json',
            success : function (res) {
                
                if(res.status == 200) {
                    AlertPopup('Success!', 'Rejected Successfully!!!', 'success', 'Ok', 'leaves');                    
                } else {
                    AlertPopup('No Changes Detected!!!', '', 'info', 'Ok', 'leaves');
                }
            }, 
            error: function(xhr, status, error) { console.log(xhr.responseText); }
       });
    });

});


/* --------- Edit Leave Details ------------- */
function editLeave(editid) {
    var lid = $(editid).data('id');
    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    $('#LeaveModalLabel').html('Add Leave');
    $('#lid, #person, #leave_date, #reason').val('');
    removeValidation({ 'person':person, 'leave_date':leave_date, 'reason':reason });

    if(lid != "" && lid != undefined) {
        $.ajax({
            url: "<?= base_url('view_records'); ?>",
            type: 'POST',
            data: { [csrfName]:csrfHash, id:lid, type:'leave' },
            dataType: 'json',
            success: function(res) {

                if(res.length > 0) {
                    $('#LeaveModalLabel').html('Edit Leave');
                    $('#lid').val(res[0]["fld_lid"]);
                    $('#person').val(res[0]['fld_lperson']+'|'+res[0]['fld_lstaff_id']);
                    $('#leave_date').val(res[0]['fld_ldate']);
                    $('#reason').val(res[0]['fld_lreason']);
                }
            },
            error: function(xhr, status, error) { console.log(xhr.responseText); }
        });
    }
}

</script>