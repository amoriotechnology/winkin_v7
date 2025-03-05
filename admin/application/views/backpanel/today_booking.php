<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        	
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Today's Booking</h1>
            </div>
        </div>
        <!-- Page Header Close -->

        <!-- Start:: row-2 -->
        <div class="row">
            <!-- Start::row-7 -->
            <h6 class="mb-3"></h6>

            <div class="row">

                <?php 

                if(!empty($today_appoint)) {
                    foreach($today_appoint as $appoint) {
                ?>

                <div class="col-xl-4">
                    <div class="card custom-card">
                        <div class="row g-0">
                            <div class="col-md-12">

                                <div class="card-body">
                                    <ul class="list-group fs-6">
                                        <li class="list-group-item d-flex justify-content-between align-items-center fw-medium">
                                           <?= '#'.$appoint['app_id']; ?> 
                                            <span class="badge bg-primary">
                                                <button type="button" class="btn btn-primary" onclick="viewDatas('<?= md5($appoint['app_id']); ?>', 'my_space')" data-bs-toggle="modal" data-bs-target="#MySpaceModel" title="Click Me">
                                                    <i class="bi bi-info-circle-fill text-white"></i>
                                                </button>
                                            </span>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex align-items-center">
                                                <div class="ms-2 fw-medium">
                                                    <i class="bi bi-person-fill fs-6"></i> <span class="text-muted">&nbsp; Name: </span> <?= $appoint['app_name']; ?>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex align-items-center">
                                                <div class="ms-2 fw-medium">
                                                    <i class="bi bi-alarm-fill fs-6"></i> <span class="text-muted">&nbsp; Start time: </span> <?= $appoint['app_time']; ?>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex align-items-center">
                                                <div class="ms-2 fw-medium">
                                                   <i class="bi bi-suitcase-lg-fill fs-6"></i> <span class="text-muted">&nbsp; Services: </span> <span class="badge bg-primary mt-2"> <?= str_replace([','], '</span> <span class="badge bg-primary mt-2">', $appoint['app_serv']); ?></span> 
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex align-items-center">
                                                <div class="ms-2 fw-medium">
                                                   <i class="bi bi-exclamation-circle-fill fs-6"></i> <span class="text-muted">&nbsp; Status: </span> 
                                                   <span class="badge bg-<?= Bgcolors($appoint['app_sts']); ?>"> <?= $appoint['app_sts']; ?> </span>
                                                </div>
                                            </div>
                                        </li>
                                        
                                        <li class="list-group-item">
                                            <div class="align-items-center">
                                                <div class="ms-2 fw-medium">
                                                    <?php if($appoint['app_sts'] != "Cancelled") { ?>
                                                   <span class="text-muted"> Update Status: </span>
                                                   <select name="sts" class="form-control mt-1 app_status" data-id="<?= md5($appoint['app_id']); ?>" >
                                                        <option value="Confirmed" <?= isSame($appoint['app_sts'], 'Confirmed'); ?> >Confirm</option>
                                                        <option value="Completed" <?= isSame($appoint['app_sts'], 'Completed'); ?> >Completed</option>
                                                        <option value="Cancelled" <?= isSame($appoint['app_sts'], 'Cancelled'); ?> >Cancelled</option>
                                                        <option value="In-Progress" <?= isSame($appoint['app_sts'], 'In-Progress'); ?> >In-Progress</option>
                                                        <option value="Hold" <?= isSame($appoint['app_sts'], 'Hold'); ?> >Hold</option>
                                                    </select>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </li>
                                        
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        
                <?php } }  else {
                    echo "<div class='col-12 text-center'> <h5> <i class='fs-3 bi bi-box-seam'></i> No Today's Booking </h5> </div>";
                } ?>

            </div>
            <!-- End::row-7 -->
        </div>
        <!-- End:: row-2 -->
        
    </div>
</div>
<!-- End::content  -->

<script type="text/javascript">
    $(document).ready(function() {

        var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
        var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

        $("body").on('change', '.app_status', function () {

            var type = $(this).val();

            $.ajax({
                url: '<?= base_url('common_update'); ?>',
                type: 'post',
                data: { [csrfName]: csrfHash, id: $(this).data('id'), type: type, coloum : 'fld_astatus', table: 'appoint' },
                dataType: 'json',
                success: function(res) { 
                    Swal.fire({
                        title : "Success!", 
                        text : "Appointment status changed successfully", 
                        icon : "success",
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if(result.isConfirmed) {
                            location.reload();
                        }
                    }); 
                }
            });

        });

    })
</script>


