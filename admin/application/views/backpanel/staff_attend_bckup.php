<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Staff Attendance</h1>
            </div>
        </div>
        <!-- Page Header Close -->

        <!--Start:: row-7 -->
        <div class="row">
            <div class="col-md-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title d-flex gap-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staffAttendModal"> 
                                <i class="bi bi-plus"></i> Add Attendance
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="" class="table text-nowrap w-100">
                                <thead class="table-info">
                                    <tr class="text-center">
                                        <th>S.No</th>
                                        <th>Staff Name</th>
                                        <th>Monday</th>
                                        <th>Tuesday</th>
                                        <th>Wednesday</th>
                                        <th>Thursday</th>
                                        <th>Friday</th>
                                        <th>Saturday</th>
                                        <th>Sunday</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php if(!empty($attend_records)) { 
                                        $i = 1;
                                        foreach($attend_records as $staff_name => $values) {
                                    ?>
                                    <tr class="text-center">
                                        <td> <?= $i++; ?> </td>
                                        <td> <?= ucfirst($staff_name); ?> </td>
                                        <?php
                                            $i = 1;
                                            $monday = date('Y-m-d',strtotime('last Monday'));
                                            $sunday = date('Y-m-d',strtotime('next Sunday'));
                                            $days = (DateDiff($monday, $sunday) + 1);

                                            for($d = 0; $d < $days; $d++) {
                                                $strtotime = strtotime($monday. '+'.$d.' days');
                                        ?>
                                        <td>
                                            <?= (isset($values[date('Y-m-d', $strtotime)])) ? $values[date('Y-m-d', $strtotime)] : ''; ?>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                    <?php } } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End:: row-7 -->
        
    </div>
</div>
<!-- End::content  -->


<!----------------- Model form for add new / edit category ------------------->
<div class="modal fade" id="staffAttendModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staffAttendModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="" method="post" id="attend_form">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h6 class="modal-title text-white" id="staffAttendModalLabel">Add Attendance</h6>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="staff_name" class="form-label">Staff Name *</label>
                            <select name="staff_name" id="staff_name" class="form-control mt-2" >
                                <option value="">Select Option</option>
                                <?php if(!empty($staff_records)) {
                                    foreach($staff_records as $rec) { ?>
                                        <option value="<?= $rec['staff_id']; ?>"> <?= ucfirst($rec['uname']); ?> </option>
                                <?php } } ?>
                            </select>
                            <span class="attend-error-msg text-danger"></span>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="table-responsive">
                                <table class="table text-nowrap w-100">
                                    <thead class="table-info text-center">
                                        <tr>
                                            <th>Date</th>
                                            <th>Day</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $startDate = date('Y-m-d 24:00:00');
                                            $endDate = date('Y-m-d 24:00:00', strtotime('+7 days'));
                                            $days = DateDiff($startDate, $endDate);
                                            $cnt = 1;
                                            for ($d = 0; $d < $days; $d++) {
                                                $strtotime = strtotime('+'.$cnt++.' days');
                                        ?>
                                        <tr class="<?= (date('w', $strtotime) == 0) ? 'table-warning' : ''; ?>" >
                                            <td> 
                                                <input type="text" name="attend_date[]" class="form-control text-center" value="<?= showDate(date('d-m-Y', $strtotime)); ?>" readonly > 
                                            </td>
                                            <td>
                                                <input type="text" name="attend_day[]" class="form-control text-center" value="<?= date('D', $strtotime); ?>" readonly >
                                            </td>
                                            <td>
                                                <select name="attend_start[]" class="form-control text-center">
                                                    <option value="08:00">08:00 am</option>
                                                    <option value="09:00">09:00 am</option>
                                                    <option value="10:00">10:00 am</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="attend_end[]" class="form-control text-center">
                                                    <option value="18:00">06:00 pm</option>
                                                    <option value="19:00">07:00 pm</option>
                                                    <option value="20:00">08:00 pm</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="attend_sts[]" class="form-control attend_sts" id="attend_sts" >
                                                    <option value="">Select Option</option>
                                                    <option value="P">Present</option>
                                                    <option value="L">Leave</option>
                                                    <option value="WO">Weekoff</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <span class="attend-error-msg text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModel('staff_attend')" data-bs-dismiss="modal">Close</button>
                    <input type="hidden" name="staff_id" value="">
                </div>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function() {

        /* ----------------- Model ajax for add / edit category ------------------- */
        $("#attend_form").submit(function(e) {
            e.preventDefault();

            const staff_name = $('#staff_name').val();
            const sts = $(".attend_sts").val();

            $('.attend-error-msg').html('');
            $(this).find('.form-control').css('border', '');

            var action = validation({'staff_name' : staff_name, 'attend_sts' : sts});
            if(action === false) {
                return action;
            }

            $.ajax({
                url: '<?= base_url('add_attend') ?>',
                type: 'post',
                data : $(this).serialize(),
                dataType: 'json',
                success : function (res) {                    
                    if(res.status == 200) {
                        Swal.fire({
                            title: 'Success!',
                            text: res.alert_msg.word,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            if(result.isConfirmed) {
                                window.location.href = '<?= base_url('business_hour') ?>';
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Failed!',
                            text: res.alert_msg.word,
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        }).then((result) => {
                            if(result.isConfirmed) {
                                window.location.href = '<?= base_url('business_hour') ?>';
                            }
                        });
                    }
                }, 
                error : function(res) { console.log(res); }
           });
        });
    });
</script>