<!-- Start::app-content -->
<div class="main-content landing-main px-0">
    <div class="landing-banner" id="home">
        <section class="section">
            <div class="container main-banner-container pb-lg-0">
                <div class="row">
                    <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-8">
                        <div class="py-lg-5">
                            <div class="mb-3">
                                <h6 class="fw-medium op-9" style="color: #000;">Winkin's Pickle Ball Zone</h6>
                            </div>
                            <p class="landing-banner-heading mb-3" style="color: #000;">My Profile</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="container">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Profile</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">

                <div class="card-body p-3">
                    <div class="text-right text-danger">* &nbsp; Required Fields</div>

                    <form method="post" id="userform_update">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                        <div class="p-4"> <div class="login_res"></div> </div>

                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name <span class="danger-text">*</span> </label>
                                <input type="text" name="first_name" id="first_name" class="form-control" value="<?= isset($user['fld_name']) ? htmlspecialchars($user['fld_name']) : '' ?>" oninput="AlphaOnly(this);">

                                <span class="profile-error-msg text-danger"></span>
                                </div>

                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name <span class="danger-text">*</span> </label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" value="<?= isset($user['fld_lastname']) ? htmlspecialchars($user['fld_lastname']) : '' ?>" oninput="AlphaOnly(this);">
                                    <span class="profile-error-msg text-danger"></span>
                                </div>

                                <div class="col-md-6">
                                    <label for="phoneno" class="form-label">Phone Number <span class="danger-text">*</span></label>
                                    <input type="number" name="contact_number" id="phoneno" class="form-control" aria-label="Phone number" value="<?= isset($user['fld_phone']) ? htmlspecialchars($user['fld_phone']) : '' ?>" oninput="NumberOnly(this, 10)" readonly >
                                    <span class="profile-error-msg text-danger"></span>
                                </div>

                                
                                <div class="col-md-6 col-sm-12">
                                    <label for="email" class="form-label">Email <span class="danger-text">*</span> </label>
                                    <input type="email" name="email" class="form-control" id="email" value="<?= isset($user['fld_email']) ? htmlspecialchars($user['fld_email']) : '' ?>">
                                    <span class="profile-error-msg text-danger"></span>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <label for="dob" class="form-label">Date of Birth </label>
                                    <div class="input-group">
                                        <input type="text" name="dob" class="selectdatepicker_dob form-control" id="dob" value="<?= (isset($user['fld_dob']) ? showDate($user['fld_dob']) : ''); ?>" >
                                        <div class="input-group-text">
                                            <label for="dob" class="bi bi-calendar"></label>
                                        </div>
                                    </div>
                                    <span class="profile-error-msg text-danger"></span>
                                </div>

                            </div>
                          
                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>                    
                    </form>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>
<br> <hr>
<!-- End::content  -->

<!-- Date & Time Picker JS -->
<script src="<?= base_url('assets/libs/flatpickr/flatpickr.min.js'); ?>"></script>

<script>
$(document).ready(function () {

    $('#userform_update').submit(function(e){
        e.preventDefault();

        var name = $('#first_name').val();
        var lname = $('#last_name').val();
        var emailid = $('#email').val();
        var pwd = $('#password').val();
        var gender = $('#gender').val();
        var dob = $('#dob').val();
        var phoneno = $('#phoneno').val();
        var Address = $('#Address').val();

        var action = validation({'first_name':name, 'last_name':lname, 'phoneno':phoneno , 'email':emailid});
        if(action === false) { return action; }

        let formData = $(this).serializeArray();
        formData.push({
            name: $('meta[name="csrf-token"]').attr('name'), 
            value: $('meta[name="csrf-token"]').attr('content') 
        });

        $.ajax({
            url: '<?= base_url("user_update"); ?>',
            type: 'POST',
            data: formData, 
            dataType: 'json',
            success: function (res) {
                if (res.status === 1) {
                    $('.login_res').html('<div class="alert alert-success">Profile updated successfully!</div>');
                } else {
                    $('.login_res').html('<div class="alert alert-danger">Sign up failed: ' + res.message + '</div>');
                }
                setTimeout(function () { location.reload(); }, 2600);
            },
            error: function () {
                $('.login_res').html('<div class="alert alert-danger">An error occurred. Please try again later.</div>');
            }
        });
    });

});


flatpickr(".selectdatepicker_dob",{
    dateFormat:"M d/Y",
    disableMobile:!0,
    maxDate: "Jan 01/2006",
});

</script>