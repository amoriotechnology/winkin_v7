<!-- Start::app-content -->
<div class="main-content landing-main px-0">
    <div class="container">
        <!-- Page Header -->
        <br><br><br><br>
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Qr Code</h1>
            </div>
        </div>
        <!-- Page Header Close -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">

                <div class="card-body p-3">
                    <?php if (isset($qr_code_path)) { ?>
                        <img src="<?php echo $qr_code_path; ?>" alt="UPI QR Code">
                    <?php } else { ?>
                        <p>QR code generation failed.</p>
                    <?php } ?>
                
                </div>

                </div>
            </div>
        </div>
        
    </div>
</div>
