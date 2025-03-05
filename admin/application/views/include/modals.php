<!----------------- Model form edit appointment ------------------->
<div class="modal fade" id="editAppointModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editAppointModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="" method="post" id="edit_appoint_form">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white" id="editAppointModalLabel">Edit Appointment</h6>
                    <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModel('appointment')"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6 mt-3">
                            <label for="appoint_id" class="form-label">Appointment ID</label>
                            <input type="text" id="appoint_id" class="form-control mt-2" value="<?= (isset($edit_appoint[0]['appoint_id']) ? $edit_appoint[0]['appoint_id'] : ''); ?>" readonly >
                            <span class="edit-appoint-error-msg text-danger"></span>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="adate" class="form-label">Appointment Date & Time</label>
                            <input type="text" id="adate" class="form-control mt-2" value="<?= (isset($edit_appoint[0]['adate']) ? showDate($edit_appoint[0]['adate'] .' '.$edit_appoint[0]['atime']) : ''); ?>" readonly >
                            <span class="cate-error-msg text-danger"></span>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="cname" class="form-label">Customer Name</label>
                            <input type="text" id="cname" class="form-control mt-2" value="<?= (isset($edit_appoint[0]['cname']) ? $edit_appoint[0]['cname'] : ''); ?>" readonly >
                            <span class="cate-error-msg text-danger"></span>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="cphone" class="form-label">Phone</label>
                            <input type="text" id="cphone" class="form-control mt-2" value="<?= (isset($edit_appoint[0]['cphone']) ? $edit_appoint[0]['cphone'] : ''); ?>" readonly >
                            <span class="cate-error-msg text-danger"></span>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="cdob" class="form-label">Date of Birth</label>
                            <input type="text" id="cdob" class="form-control mt-2" value="<?= (isset($edit_appoint[0]['cdob']) ? showDate($edit_appoint[0]['cdob']) : ''); ?>" readonly >
                            <span class="cate-error-msg text-danger"></span>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="canni_date" class="form-label">Anniversary Date</label>
                            <input type="text" id="canni_date" class="form-control mt-2" value="<?= (isset($edit_appoint[0]['canni_date']) ? showDate($edit_appoint[0]['canni_date']) : ''); ?>" readonly >
                            <span class="cate-error-msg text-danger"></span>
                        </div>

                        <div class="table-responsive mt-4">
                            <table class="table nowrap">
                                <thead class="table-dark">
                                    <tr class="text-center">
                                        <th>Services</th>
                                        <th>Duration</th>
                                        <th>Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if(!empty($edit_appoint)) { 
                                            foreach($edit_appoint as $servs) { ?> 
                                        <tr class="text-center">
                                            <td> <?= $servs['aserv']; ?> </td>
                                            <td> <?= $servs['aduring']; ?> </td>
                                            <td> <?= $servs['arate']; ?> </td>
                                        </tr>
                                    <?php } } ?>
                                </tbody>
                                <tfoot>
                                    <tr class="text-center"> <td colspan="2"> <b>TOTAL:</b> </td> <td></td> </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModel('appointment')" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                    <input type="hidden" name="appoint_id" value="<?= (isset($edit_appoint[0]['appoint_id']) ? md5($edit_appoint[0]['appoint_id']) : ''); ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    $('.cardpay').css('display', 'none');

});
</script>