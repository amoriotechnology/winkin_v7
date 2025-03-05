<?php 
    $display = ($info['role'] == STAFF) ? 'readonly disabled' : '';
    $weeks_record = !empty($setting_records[0]) ? json_decode($setting_records[0]['fld_weekdays']) : [];
    $weeks_hours = !empty($setting_records[0]) ? explode(" - ", $setting_records[0]['fld_hours']) : ['', ''];
?>
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
            
        <!-- Start::page-header -->
        <div
            class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2"> <?= ($info['role'] == ADMIN) ? 'Settings' : 'Profile' ?> </h1>
            </div>
        </div>
        <!-- End::page-header -->

        <!-- Start::row-1 -->
        <div class="row mb-5">
            <div class="col-xl-3">
                <div class="card custom-card"> 
                    <div class="card-header">
                        <div class="card-title">My settings</div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs flex-column nav-tabs-header mb-0" role="tablist">
                            <li class="nav-item m-1">
                                <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-current="page" href="#personal-info" aria-selected="true">
                                    <i class="bi bi-person fs-6"></i>&emsp;Personal Information
                                </a>
                            </li>
                            <li class="nav-item m-1">
                                <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page" href="#change-password" aria-selected="true">
                                    <i class="bi bi-lock"></i>&emsp;Change Password
                                </a>
                            </li>
                            <li class="nav-item m-1 <?= ($info['role'] == STAFF) ? 'd-none' : '' ?>">
                                <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page" href="#account-settings" aria-selected="true">
                                    <i class="bi bi-calendar fs-6"></i>&emsp;Calendar - Holiday(s)
                                </a>
                            </li>
                            <li class="nav-item m-1 <?= ($info['role'] == STAFF) ? 'd-none' : '' ?>">
                                <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page" href="#email-settings" aria-selected="true">
                                    <i class="bi bi-envelope fs-6"></i>&emsp;Email Configuration
                                </a>
                            </li>
                            <li class="nav-item m-1 <?= ($info['role'] == STAFF) ? 'd-none' : '' ?>">
                                <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page" href="#company-info" aria-selected="true">
                                    <i class="bi bi-briefcase fs-6"></i>&emsp;Company Information
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="card custom-card <?= ($info['role'] == STAFF) ? 'd-none' : '' ?>">
                    <div class="card-header">
                        <div class="card-title">Working Days</div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">

                            <div class="d-flex">
                                <div class="form-group">
                                    <label class="form-label p-1" for="sun">Sun</label>
                                    <input type="checkbox" name="setting_weeks[]" class="form-check-input" <?= (in_array('Sun', $weeks_record)) ? 'checked' : ''; ?> value="Sun" id="sun" >
                                </div>
                                <div class="form-group">
                                    <label class="form-label p-1" for="mon">Mon</label>
                                    <input type="checkbox" name="setting_weeks[]" class="form-check-input" <?= (in_array('Mon', $weeks_record)) ? 'checked' : ''; ?> value="Mon" id="mon" >
                                </div>
                                <div class="form-group">
                                    <label class="form-label p-1" for="tue">Tue</label>
                                    <input type="checkbox" name="setting_weeks[]" class="form-check-input" <?= (in_array('Tue', $weeks_record)) ? 'checked' : ''; ?> value="Tue" id="tue" >
                                </div>
                                <div class="form-group">
                                    <label class="form-label p-1" for="wed">Wed</label>
                                    <input type="checkbox" name="setting_weeks[]" class="form-check-input" <?= (in_array('Wed', $weeks_record)) ? 'checked' : ''; ?> value="Wed" id="wed" >
                                </div>
                                <div class="form-group">
                                    <label class="form-label p-1" for="thu">Thu</label>
                                    <input type="checkbox" name="setting_weeks[]" class="form-check-input" <?= (in_array('Thu', $weeks_record)) ? 'checked' : ''; ?> value="Thu" id="thu" >
                                </div>
                                <div class="form-group">
                                    <label class="form-label p-1" for="fri">Fri</label>
                                    <input type="checkbox" name="setting_weeks[]" class="form-check-input" <?= (in_array('Fri', $weeks_record)) ? 'checked' : ''; ?> value="Fri" id="fri" >
                                </div>
                                <div class="form-group">
                                    <label class="form-label p-1" for="sat">Sat</label>
                                    <input type="checkbox" name="setting_weeks[]" class="form-check-input" <?= (in_array('Sat', $weeks_record)) ? 'checked' : ''; ?> value="Sat" id="sat" >
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card custom-card <?= ($info['role'] == STAFF) ? 'd-none' : '' ?>"> 
                    <div class="card-header">
                        <div class="card-title">Working Hours</div>
                    </div>
                    <div class="card-body">
                       <div class="row">
                           <div class="col-6">
                                <label class="form-label">Start Time</label>
                                <input type="time" name="start_time" class="form-control" id="start" value="<?= $weeks_hours[0]; ?>" >
                                <span class="time-error-msg text-danger"></span>
                            </div>

                            <div class="col-6">
                                <label class="form-label">End Time</label>
                                <input type="time" name="end_time" class="form-control" id="end" value="<?= $weeks_hours[1]; ?>" >
                                <span class="time-error-msg text-danger"></span>
                            </div>
                            <span class="text-danger" id="time-error"></span>
                       </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-9">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personal-info" role="tabpanel">
                                <div class="p-sm-2 p-0">
                                    <form method="post" id="profile_form">
                                        <h5 class="fw-medium mb-3 text-center"> Personal Information </h5>
                                        <div class="row gy-3 mb-3">
                                            <div class="col-xl-6">
                                                <label for="uname" class="form-label">Name <span class="text-danger">*</span></label>
                                                <input type="text" name="staff_name" class="form-control" id="uname" value="<?= isset($profile_records[0]) ? $profile_records[0]['fld_uname'] : ''; ?>" <?= $display; ?> >
                                                <span class="pro-errro-msg text-danger"></span>
                                            </div>

                                            <div class="col-xl-6">
                                                <label for="uphone" class="form-label">Phone <span class="text-danger">*</span></label>
                                                <input type="text" name="staff_phone" class="form-control" id="uphone" value="<?= isset($profile_records[0]) ? $profile_records[0]['fld_uphone'] : ''; ?>" oninput="NumberOnly(this, 10)" <?= $display; ?> >
                                                <span class="pro-errro-msg text-danger"></span>
                                            </div>

                                            <div class="col-xl-6">
                                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                                <input type="email" name="staff_email" class="form-control" id="uemail" value="<?= isset($profile_records[0]) ? $profile_records[0]['fld_uemail'] : ''; ?>" <?= $display; ?> >
                                                <span class="pro-errro-msg text-danger"></span>
                                            </div>

                                            <div class="col-xl-6">
                                                <label for="ugender" class="form-label">Gender <span class="text-danger">*</span></label>
                                                <select name="gender" class="form-select" id="ugender" <?= $display; ?> >
                                                    <option value="">Select Option</option>
                                                    <?= $ugend = isset($profile_records[0]) ? $profile_records[0]['fld_ugender'] : ''; ?>
                                                    <option value="Female" <?= isSame( 'Female', $ugend ); ?> >Female</option>
                                                    <option value="Male" <?= isSame( 'Male', $ugend ); ?> >Male</option>
                                                    <option value="Other" <?= isSame( 'Other', $ugend ); ?> >Other</option>
                                                </select>
                                                <span class="pro-errro-msg text-danger"></span>
                                            </div>

                                            <div class="col-xl-6">
                                                <label for="udob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" name="staff_dob" class="form-control daterange" id="udob" value="<?= isset($profile_records[0]) ? showDate($profile_records[0]['fld_udob']) : ''; ?>" <?= $display; ?> >
                                                    <div class="input-group-text">
                                                        <label for="udob" class="bi bi-calendar "></label>
                                                    </div>
                                                </div>
                                                <span class="pro-errro-msg text-danger"></span>                                                
                                            </div>

                                            <div class="col-xl-6">
                                                <?php
                                                    $staff_exp = [0, 0]; 
                                                    if(isset($profile_records[0])) { 
                                                        $staff_exp = explode(", ", $profile_records[0]['fld_uexperience']); 
                                                    } 
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="uyear" class="form-label">Experience in Year(s) <span class="text-danger">*</span></label>
                                                        <input type="text" name="staff_year" id="uyear" class="form-control" value="<?= (!empty($staff_exp[0]) ? $staff_exp[0] : 0); ?>" oninput="NumberOnly(this, 2);" <?= $display; ?>  >
                                                        <span class="pro-errro-msg text-danger"></span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="umonth" class="form-label">Experience in Month(s) <span class="text-danger">*</span></label>
                                                        <select name="staff_month" class="form-select" id="umonth" <?= $display; ?> >
                                                            <option value="0" <?= isSame( $staff_exp[1], '0'); ?> >0</option>
                                                            <option value="1" <?= isSame( $staff_exp[1], '1'); ?> >1</option>
                                                            <option value="2" <?= isSame( $staff_exp[1], '2'); ?> >2</option>
                                                            <option value="3" <?= isSame( $staff_exp[1], '3'); ?> >3</option>
                                                            <option value="4" <?= isSame( $staff_exp[1], '4'); ?> >4</option>
                                                            <option value="5" <?= isSame( $staff_exp[1], '5'); ?> >5</option>
                                                            <option value="6" <?= isSame( $staff_exp[1], '6'); ?> >6</option>
                                                            <option value="7" <?= isSame( $staff_exp[1], '7'); ?> >7</option>
                                                            <option value="8" <?= isSame( $staff_exp[1], '8'); ?> >8</option>
                                                            <option value="9" <?= isSame( $staff_exp[1], '9'); ?> >9</option>
                                                            <option value="10" <?= isSame( $staff_exp[1], '10'); ?> >10</option>
                                                            <option value="11" <?= isSame( $staff_exp[1], '11'); ?> >11</option>
                                                        </select>
                                                        <span class="pro-errro-msg text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <label for="udoj" class="form-label">Date of Joining <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" name="staff_doj" class="form-control daterange" id="udoj" value="<?= isset($profile_records[0]) ? showDate($profile_records[0]['fld_udoj']) : ''; ?>" <?= $display; ?> >
                                                    <div class="input-group-text">
                                                        <label for="udoj" class="bi bi-calendar "></label>
                                                    </div>
                                                </div>
                                                <span class="pro-errro-msg text-danger"></span>
                                            </div>

                                            <div class="col-xl-6 d-none">
                                                <label for="uservs" class="form-label">Services </label>
                                                <input type="text" name="staff_serv" class="form-control" id="uservs" value="<?= isset($profile_records[0]) ? $profile_records[0]['fld_uservices'] : ''; ?>" <?= $display; ?> >
                                                <span class="pro-errro-msg text-danger"></span>
                                            </div>

                                            <div class="col-xl-6">
                                                <label for="uanni_date" class="form-label">Anniversary Date </label>
                                                <div class="input-group">
                                                    <input type="text" name="uanni_date" class="form-control daterange" id="uanni_date" value="<?= isset($profile_records[0]) ? showDate($profile_records[0]['fld_uanniversary']) : ''; ?>" <?= $display; ?> >
                                                    <div class="input-group-text">
                                                        <label for="uanni_date" class="bi bi-calendar"></label>
                                                    </div>
                                                </div>                                                
                                            </div>

                                            <div class="col-xl-12">
                                                <label for="uaddr" class="form-label">Address <span class="text-danger">*</span></label>
                                                <textarea name="staff_addr" class="form-control" id="uaddr" rows="5" <?= $display; ?>><?= isset($profile_records[0]) ? $profile_records[0]['fld_uaddress'] : ''; ?></textarea>
                                                <span class="pro-errro-msg text-danger"></span>
                                            </div>

                                            <div class="col-xl-12">
                                                <input type="hidden" name="staff_id" value="<?= isset($profile_records[0]) ? $profile_records[0]['fld_uid'] : '';  ?>">
                                                <button type="submit" class="btn btn-success float-end <?= ($info['role'] == STAFF) ? 'd-none' : ''; ?>">Save</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                                    </form>
                                </div>
                            </div>


                            <div class="tab-pane border-0 p-0 show" id="change-password" role="tabpanel">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <h5 class="fw-medium mb-3 text-center"> Change Password </h5>
                                            <div class="row gy-3">
                                                <div class="col-12 align-middle">
                                                    Click this to change password <i class="bi bi-arrow-right"></i> <button type="button" id="otp_sender" class="btn btn-primary">Get OTP</button>
                                                </div>

                                                <div class="col-6 otp_field d-none">
                                                    <label for="otp" class="form-label">Enter OTP <span class="text-danger">*</span> </label>
                                                    <div class="input-group">
                                                        <input type="text" name="otp" id="otp" class="form-control" oninput="NumberOnly(this, 6)" >
                                                        <button type="button" id="otp_submit" class="btn btn-success">Proceed</button>
                                                    </div>
                                                    <span class="otp-error-msg text-danger"></span>
                                                </div>
                                                <div class="d-none password_field">
                                                    <div class="col-6">
                                                        <label for="new_pass" class="form-label">New Password <span class="text-danger">*</span> </label>
                                                        <input type="password" name="new_pass" id="new_pass" class="form-control" autocomplete="off" >
                                                        <span class="pass-error-msg new_pass_alt text-danger"></span>
                                                    </div>
                                                    <div class="col-6 mt-2">
                                                        <label for="confirm_pass" class="form-label">Confirm Password <span class="text-danger">*</span> </label>
                                                        <input type="password" name="confirm_pass" id="confirm_pass" class="form-control" autocomplete="off" >
                                                        <span class="pass-error-msg confirm_alt text-danger"></span>
                                                    </div>

                                                    <a href="<?= base_url('admin_setting'); ?>" class="btn btn-danger mt-3">Cancel</a>
                                                    <button type="button" id="change_submit" class="btn btn-success mt-3">Save Password</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>                    
                                </div>
                            </div>

                            <div class="tab-pane border-0 p-0 show" id="account-settings" role="tabpanel">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <h5 class="fw-medium mb-3 text-center"> Calendar - Holiday(s) </h5>
                                            <div class="row gy-3">
                                                <div class="col-xxl-5">                                        
                                                    <div class="card custom-card shadow-none mb-0 border">
                                                        <div class="card-header justify-content-between bg-primary d-block">
                                                            <div class="card-title">Add Holiday</div>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            <form method="post" id="cal_form">
                                                                <ul class="list-group">
                                                                    <li class="list-group-item border-0 border-bottom">
                                                                        <div class="d-sm-flex d-block align-items-top">
                                                                            <div class="lh-1 flex-fill">
                                                                                <p class="mb-1"> <span class="fw-medium">Title <span class="text-danger">*</span></span> </p>
                                                                                <p class="mb-0">
                                                                                    <input type="text" name="cal_title" id="cal_title" class="form-control" value="<?= (isset($edit_calender[0]) ? $edit_calender[0]['fld_satitle'] : ''); ?>" >
                                                                                    <span class="cal-error-msg text-danger"></span>
                                                                                </p>
                                                                            </div>
                                                                    </li>
                                                                    <li class="list-group-item border-0 border-bottom">
                                                                        <div class="d-sm-flex d-block align-items-top">
                                                                           
                                                                            <div class="lh-1 flex-fill">
                                                                                <p class="mb-1"> <span class="fw-medium">Date <span class="text-danger">*</span></span> </p>
                                                                                <p class="mb-0">
                                                                                    <input type="text" name="cal_date" id="cal_date" class="form-control holidates" value="<?= (isset($edit_calender[0]) ? showDate($edit_calender[0]['fld_sadate']) : ''); ?>" >
                                                                                    <span class="fs-14 cal-error-msg text-danger"></span>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                                                                        <input type="hidden" name="cal_id" value="<?= (isset($edit_calender[0]) ? md5($edit_calender[0]['fld_said']) : ''); ?>">
                                                                        <div class="d-flex gap-2 float-end">
                                                                            <a href="<?= base_url('admin_setting'); ?>" name="cancel" class="btn btn-danger mt-3">Cancel</a>
                                                                            <button type="submit" name="add_holiday" id="holidaycal_submit" class="btn btn-success mt-3">Save</button>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xxl-7">
                                                    <ul class="list-group list-group-flush list-unstyled rounded">
                                                        <li class="list-group-item">
                                                            <div class="row gx-5 gy-3">
                                                                <div class="col-xl-12">
                                                                    <div class="input-group">
                                                                        <label for="calen_year" class="mt-2">Calender: </label>
                                                                            &emsp;<select class="form-control" name="max-login-attempts" id="calen_year" onchange="getCalender(this.value);">
                                                                                <option value="<?= date('Y', strtotime('last year')); ?>" ><?= date('Y', strtotime('last year')); ?>
                                                                                </option>
                                                                                <option value="<?= date('Y'); ?>" selected><?= date('Y'); ?></option>
                                                                                <option value="<?= date('Y', strtotime('next year')); ?>"><?= date('Y', strtotime('next year')); ?></option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="tab-pane show active border-0 chat-users-tab" id="users-tab-pane" role="tabpanel" aria-labelledby="users-tab" tabindex="0">
                                                                            <ul class="list-unstyled mb-0 pb-2 mt-2 chat-users-tab simplebar-scrollable-y" id="chat-msg-scroll" data-simplebar="init">

                                                                                <div class="simplebar-wrapper" style="margin: 0px 0px -8px;">
                                                                                    <div class="simplebar-height-auto-observer-wrapper">
                                                                                        <div class="simplebar-height-auto-observer"></div>
                                                                                    </div>
                                                                                    <div class="simplebar-mask">
                                                                                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                                                            <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;">
                                                                                                <div class="simplebar-content" style="padding: 0px 0px 8px;" id="holiday_calender">
                                                                                                    <?php if(!empty($calendar_records)) {
                                                                                                        foreach($calendar_records as $cal_rec) { 
                                                                                                    ?>
                                                                                                    <li class="border-0 border-bottom mt-3">
                                                                                                        <p class="fs-16 mb-1 fw-medium">
                                                                                                            <?= $cal_rec['fld_satitle']; ?>
                                                                                                            <span class="float-end gap-3">
                                                                                                                <a href="<?= base_url('admin_setting/' . md5($cal_rec['fld_said']) . '#calander'); ?>" class="btn btn-info" >
                                                                                                                    <i class="bi bi-pencil-square"></i>
                                                                                                                </a> 
                                                                                                                <a class="btn btn-danger alert-confirm" data-id="<?= md5($cal_rec['fld_said']); ?>" >
                                                                                                                    <i class="bi bi-trash3"></i>
                                                                                                                </a> 
                                                                                                            </span>
                                                                                                        </p>
                                                                                                        <p class="fs-12 mb-0 text-muted"> <?= showDate($cal_rec['fld_sadate']).' - '.date('D', strtotime($cal_rec['fld_sadate'])); ?> </p>
                                                                                                    </li>
                                                                                                    <?php } } ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="simplebar-placeholder" style="width: 398px; height: 520px;"></div>
                                                                                </div>
                                                                                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                                                                    <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                                                                </div>
                                                                                <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                                                                    <div class="simplebar-scrollbar" style="height: 122px; display: block; transform: translate3d(0px, 0px, 0px);"></div>
                                                                                </div>
                                                                            </ul>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>

                                    </div>                                        
                                </div>
                            </div>


                            <div class="tab-pane" id="email-settings" role="tabpanel">
                                <h5 class="fw-medium mb-3 text-center"> Email Configuration </h5>
                                <ul class="list-group list-group-flush rounded">
                                    <form method="post" id="mail_form">
                                        <li class="list-group-item">
                                            <div class="row gy-2 d-sm-flex align-items-center justify-content-between">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                                    <label class="form-label fs-14">Host Address <span class="text-danger">*</span></label>
                                                    <input type="text" name="mail_host" id="mail_host" class="form-control mt-2" value="<?= (isset($setting_records[0]) ? $setting_records[0]['fld_host'] : ''); ?>" >
                                                    <span class="mail-error-msg text-danger"></span>
                                                </div>

                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                                    <label class="fs-14 fw-medium mb-0">Email Address <span class="text-danger">*</span> </label>
                                                    <input type="text" name="mail_addr" id="mail_addr" class="form-control mt-2" value="<?= (isset($setting_records[0]) ? $setting_records[0]['fld_fromemail'] : ''); ?>" >
                                                    <span class="mail-error-msg text-danger"></span>
                                                </div>

                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                                    <label class="fs-14 fw-medium mb-0">Password <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                    <input type="password" name="mail_pass" id="mail_pass" class="form-control mt-2" value="<?= (isset($setting_records[0]) ? $setting_records[0]['fld_emailpass'] : ''); ?>" >
                                                        <a href="javascript:void(0);" class="input-group-text text-muted bg-white mt-2" onclick="createpassword('mail_pass',this)">
                                                            <i class="ri-eye-off-line align-middle"></i>
                                                        </a>    
                                                    </div>
                                                    <span class="mail-error-msg text-danger"></span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row gy-3 d-sm-flex align-items-center justify-content-between mt-3">
                                                <div class="col-12">
                                                    <h5 class="text-center">Birthday Wishes :</h5>
                                                    <div class="col-xl-12">
                                                        <label for="mail-language" class="fs-14 fw-medium">Subject <span class="text-danger">*</span></label>
                                                        <textarea name="bday_subject" class="form-control" id="bday_subject" rows="2"><?= (isset($setting_records[0]) ? $setting_records[0]['fld_bdaysubj'] : ''); ?></textarea>
                                                        <span class="mail-error-msg text-danger"></span>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <label for="mail-language" class="fs-14 fw-medium mt-3">Template <span class="text-danger">*</span></label>
                                                        <textarea name="bday_template" class="form-control" id="bday_template" rows="10"><?= (isset($setting_records[0]) ? strip_tags($setting_records[0]['fld_bdaytemp']) : ''); ?></textarea>
                                                        <span class="mail-error-msg text-danger"></span>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                                            </div>
                                            <button type="submit" class="btn btn-success float-end mt-3">Save</button>
                                        </li>
                                    </form>
                                </ul>
                            </div>

                            <div class="tab-pane" id="company-info" role="tabpanel">
                                <h5 class="fw-medium mb-3 text-center"> Company Information </h5>
                                <form method="post" id="cmpy_form" enctype="multipart/form-data">
                                    <div class="row gy-2">
                                        <div class="col-xxl-6 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12 mt-3">
                                            <label for="cmpy_name" class="form-label ms-2">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="cmpy_name" class="form-control" id="cmpy_name" value="<?= (isset($setting_records[0]) ? $setting_records[0]['fld_cmpyname'] : ''); ?>" >
                                            <span class="cmpy-error-msg text-danger"></span>
                                        </div>

                                        <div class="col-xxl-6 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12 mt-3">
                                            <label for="cmpy_email" class="form-label ms-2">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="cmpy_email" class="form-control" id="cmpy_email" value="<?= (isset($setting_records[0]) ? $setting_records[0]['fld_cmpyemail'] : ''); ?>" >
                                            <span class="cmpy-error-msg text-danger"></span>
                                        </div>

                                        <div class="col-xxl-6 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12 mt-3">
                                            <label for="cmpy_logo" class="form-label ms-2">Logo ( W:130px * H:56px ) <span class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="file" name="cmpy_logo" class="form-control" id="cmpy_logo" accept=".png, .jpg, .jpeg" >
                                                    <span class="cmpy-error-msg text-danger"></span>
                                                </div>
                                                <div class="col-6">
                                                    <img src="<?= base_url('../assets/images/company_imgs/'.$setting_records[0]['fld_cmpylogo']) ?>" width="50%" title="<?= isset($setting_records[0]) ? $setting_records[0]['fld_cmpylogo'] : '' ?>" >
                                                    <input type="hidden" name="edit_logo" id="edit_logo" value="<?= isset($setting_records[0]) ? $setting_records[0]['fld_cmpylogo'] : '' ?>" >
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="col-xxl-6 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12 mt-3">
                                            <label for="cmpy_favicon" class="form-label ms-2">Favicon ( W:40px * H:40px ) <span class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="file" name="cmpy_favicon" class="form-control" id="cmpy_favicon" accept=".png, .jpg, .jpeg" >
                                                    <span class="cmpy-error-msg text-danger"></span>
                                                </div>
                                                <div class="col-6">
                                                    <img src="<?= base_url('../assets/images/company_imgs/'.$setting_records[0]['fld_cmpyfav']) ?>" width="25%" title="<?= isset($setting_records[0]) ? $setting_records[0]['fld_cmpyfav'] : '' ?>" >
                                                    <input type="hidden" name="edit_favicon" id="edit_favicon" value="<?= isset($setting_records[0]) ? $setting_records[0]['fld_cmpyfav'] : '' ?>" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <label for="cmpy_addr" class="form-label ms-2">Address <span class="text-danger">*</span></label>
                                            <textarea name="cmpy_addr" class="form-control" id="cmpy_addr" rows="5"><?= (isset($setting_records[0]) ? $setting_records[0]['fld_cmpyaddr'] : ''); ?></textarea>
                                            <span class="cmpy-error-msg text-danger"></span>
                                        </div>
                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success float-end mt-3">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--End::row-1 -->
    </div>
</div>
<!-- End::content  -->

<!-- Show Password JS -->
<script src="<?= base_url('../assets/js/show-password.js'); ?>"></script>

<script type="text/javascript">
    
    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    var servs = <?= $serv_record; ?>;
    var input = document.getElementById('uservs');
    
    p = document.querySelector('input[name="staff_serv"]');
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

    $(document).ready(function() {

        var curdate = new Date();

        $('.holidates').flatpickr({
            dateFormat:"M d/Y",
            disableMobile:!0,
            minDate: 'Jan 01/'+(curdate.getFullYear()-1),
            maxDate: 'Dec 31/'+(curdate.getFullYear()+1),
        });

        
        $("input[name='setting_weeks[]']").on('change', function() {
            var weeks = [];
            $("input[name='setting_weeks[]']:checked").each(function() {
                weeks.push($(this).val());
            });

            if(weeks != "") {
                $.ajax({
                    url: "<?= base_url('setting_config'); ?>",
                    type: 'post',
                    data: { [csrfName]: csrfHash, week: weeks },
                    dataType: 'json',
                    success: function(res) { AlertPopup('Success!', 'Updated Successfully!', 'success', 'Ok', ''); },
                    error: function(xhr, status, error) { console.log(xhr.responseText); }
                });
            }
        });


        $("#start, #end").on('change', function() {

            var start = $("#start").val();
            var end = $("#end").val();
            var action = validation({'start':start, 'end':end});

            if( (parseFloat(start) >= parseFloat(end)) )  { $('#time-error').html('End Time Should Grater than Start Time'); action = false; }
            if(action === false) { return action; }

            $.ajax({
                url: "<?= base_url('setting_config'); ?>",
                type: 'post',
                data: { [csrfName]: csrfHash, hour: start+' - '+end },
                dataType: 'json',
                success: function(res) { 
                    AlertPopup('Success!', 'Updated Successfully!', 'success', 'Ok', '');
                },
                error: function(xhr, status, error) { console.log(xhr.responseText); }
            });
        });


        $('#profile_form').submit(function(e) {
            e.preventDefault();

            var uid = $('#uid').val();
            var uname = $('#uname').val();
            var uphone = $('#uphone').val();
            var uemail = $('#uemail').val();
            var ugender = $('#ugender').val();
            var udob = $('#udob').val();
            var umari_sts = $('#umari_sts').val();
            var uyear = $('#uyear').val();
            var umonth = $('#umonth').val();
            var udoj = $('#udoj').val();
            var userv = $('#userv').val();
            var addr = $('#uaddr').val();

            var action = validation({'uname': uname, 'uphone': uphone, 'uemail': uemail, 'ugender' : ugender, 'udob': udob, 'umari_sts': umari_sts, 'uyear': uyear, 'umonth': umonth, 'udoj': udoj, 'userv': userv, 'uaddr': addr});

            if(action === false) { return action; }

            $.ajax({
                url: '<?= base_url('add_staff'); ?>',
                type: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {
                    if(res.status == 200) {
                        AlertPopup('Success!', 'Updated Successfully!!', 'success', 'Ok', 'admin_setting');
                    } else {
                        AlertPopup('No Changes Detected!', '', 'info', 'Ok', 'admin_setting');
                    }
                },
                error: function(xhr, status, error) { console.log(xhr.responseText); }
            });
        });

        /* ----- Send 6 digit OTP ------ */
        $('#otp_sender').on('click', function(e) {

            $(this).html('OTP Sended').attr('disabled', 'disabled');
            $('.otp_field').removeClass('d-none');

            $.ajax({
                url: '<?= base_url('send_otp'); ?>',
                type: 'POST',
                data: { [csrfName]: csrfHash, trigger: 'Yes' },
                dataType: 'json',
                success: function(res) {
                    Swal.fire({
                        title: res.title,
                        text: res.text,
                        icon: res.icon,
                        confirmButtonText: 'Ok',
                    });
                },
                error: function(xhr, status, error) { console.log(xhr.responseText); }
            });
        });

        /* ----- Validate OTP Number ----- */
        $('#otp_submit').on('click', function(e) {

            const OTP = $('#otp').val();
            var action = validation({'otp':OTP});
            $('.password_field').addClass('d-none');
            if(action === false) { return false; }

            $.ajax({
                url: '<?= base_url('validateOTP'); ?>',
                type: 'POST',
                data: { [csrfName]: csrfHash, otp:OTP },
                dataType: 'json',
                success:function(res) {

                    $('.otp-error-msg').html(res.text).addClass('text-danger').removeClass('text-success');
                    if(res.status == 200) {
                        $('.otp-error-msg').html(res.text).addClass('text-success').removeClass('text-danger');
                        $('.password_field').removeClass('d-none');
                    
                    } else if(res.status == 403) {
                        AlertPopup('Warning', res.text, 'warning', 'OK', '');
                    }
                },
                error: function(xhr, status, error) { console.log(xhr.responseText); }
            });
        });
        
        /* ----- Change New Password ----- */
        $('#change_submit').on('click', function(e) {
            const new_pass = $('#new_pass').val();
            const confirm_pass = $('#confirm_pass').val();

            var action = true;
            action = validation({'new_pass':new_pass, 'confirm_pass':confirm_pass});
            
            if($.trim(new_pass).length <= 6 && action === true) {
                $('.new_pass_alt').html('Password must be 6 characters or above');
                action = false;
            }

            if(new_pass != confirm_pass) {
                $('.confirm_alt').html('Please match with new password');
                action = false;
            }

            if(action === false) { return action; }

            $.ajax({
                url: '<?= base_url('change_password'); ?>',
                type: 'POST',
                data: { [csrfName]: csrfHash, new:new_pass, confirm:confirm_pass },
                dataType: 'json',
                success:function(res) {
                    AlertPopup('Success!', 'Password changed successfully!!!', 'success', 'Ok', '');
                },
                error: function(xhr, status, error) { console.log(xhr.responseText); }
            });
        });

        $('#cal_date').on('change', function() {
            var cal_date = $(this).val();
            var element = $(this).parent().find('span');
            element.html('');
            $('#holidaycal_submit').removeAttr('disabled');

            if(cal_date != "") {
                $.ajax({
                    url: '<?= base_url('view_records'); ?>',
                    type: 'post',
                    data: { [csrfName]: csrfHash, id : cal_date, type: 'attend' },
                    dataType: 'json',
                    success: function(res) { 
                        if(res.length > 0) {
                            element.html('This date have record!!!');
                            $('#holidaycal_submit').attr('disabled', 'disabled');
                        }
                    },
                    error: function(xhr, status, error) { console.log(xhr.responseText); }
                });
            }
        });

        $('#cal_form').submit(function(e) {
            e.preventDefault();
            var cal_title = $('#cal_title').val();
            var cal_date = $('#cal_date').val();
            var action = validation({'cal_title' : cal_title, 'cal_date' : cal_date});

            if(action === false) { return action; }

            $.ajax({
                url: '<?= base_url('add_holiday'); ?>',
                type: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {
                    if(res.status == 200) {
                        AlertPopup('Success!', res.alert_msg.word, 'success', 'Ok', 'admin_setting');
                    } else {
                        AlertPopup('No Changes Detected!', '', 'info', 'Ok', 'admin_setting');
                    }
                },
                error: function(xhr, status, error) { console.log(xhr.responseText); }
            });
        });

        $('#mail_form').submit(function(e) {
            e.preventDefault();
            var mail_host = $('#mail_host').val();
            var mail_addr = $('#mail_addr').val();
            var mail_pass = $('#mail_pass').val();
            var bday_subject = $('#bday_subject').val();
            var bday_template = $('#bday_template').val();
            var anni_subject = $('#anni_subject').val();
            var anni_template = $('#anni_template').val();

            var action = validation({'mail_host': mail_host, 'mail_addr': mail_addr, 'mail_pass': mail_pass, 'bday_subject': bday_subject, 'bday_template': bday_template, 'anni_subject': anni_subject, 'anni_template': anni_template });

            if(action === false) { return action; }

            $.ajax({
                url: '<?= base_url('setting_config'); ?>',
                type: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {
                    if(res.status == 200) {
                        AlertPopup('Success!', res.alert_msg.word, 'success', 'Ok', 'admin_setting');
                    } else {
                        AlertPopup('No Changes Detected!', '', 'info', 'Ok', 'admin_setting');
                    }
                },
                error: function(xhr, status, error) { console.log(xhr.responseText); }
            });            
        });

        $('#cmpy_form').submit(function(e) {
            e.preventDefault();
            
            var formData = new FormData();

            var cmpy_name = $('#cmpy_name').val();
            var cmpy_email = $('#cmpy_email').val();
            var cmpy_addr = $('#cmpy_addr').val();
            var cmpy_logo = $('#cmpy_logo').val();
            var cmpy_favicon = $('#cmpy_favicon').val();
            var edit_logo = $('#edit_logo').val();
            var edit_favicon = $('#edit_favicon').val();

            var logo = (cmpy_logo != "") ? $('#cmpy_logo')[0].files[0] : edit_logo;
            var favicon = (cmpy_favicon != "") ? $('#cmpy_favicon')[0].files[0] : edit_favicon;

            var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
            var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

            formData.append(csrfName, csrfHash);
            formData.append('cmpy_name', cmpy_name);
            formData.append('cmpy_email', cmpy_email);
            formData.append('cmpy_addr', cmpy_addr);
            formData.append('edit_logo', edit_logo);
            formData.append('edit_favicon', edit_favicon);
            formData.append('cmpy_logo', logo);
            formData.append('cmpy_favicon', favicon);

            var action = validation({
                'cmpy_name': cmpy_name,
                'cmpy_email': cmpy_email,
                'cmpy_logo': logo,
                'cmpy_favicon': favicon,
                'cmpy_addr': cmpy_addr
            });

            if (action === false) { return action;  }

            $.ajax({
                url: '<?= base_url('setting_config'); ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(res) {

                    if (res.status == 200) {
                        AlertPopup('Success!', res.alert_msg.word, 'success', 'Ok', 'admin_setting');
                    } else if(res.status == 400) {
                        AlertPopup('Warning', res.alert_msg.word, 'warning', 'Ok', 'admin_setting');
                    } else {
                        AlertPopup('No Changes Detected!', '', 'info', 'Ok', 'admin_setting');
                    }
                },
                error: function(xhr, status, error) { console.log(xhr.responseText); }
            });
        });

        $("body").on('click', '.alert-confirm', function () {
          Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
          }).then((e) => {

            if (e.isConfirmed) {
                
                $.ajax({
                    url: '<?= base_url('common_update'); ?>',
                    type: 'post',
                    data: { [csrfName]: csrfHash, id: $(this).data('id'), type: 'disabled', coloum : 'fld_saflag', table: 'calender' },
                    dataType: 'json',
                    success: function(res) { 
                        AlertPopup('Deleted!', 'Select date has been deleted.', 'success', 'Ok', '');
                    }
                });
            }

          });
        });

    });

    function getCalender(year) {
        $('#holiday_calender').empty();
        $.ajax({
            url: '<?= base_url('holiday_calender'); ?>',
            type: 'post',
            data: {[csrfName]: csrfHash, year : year},
            success: function(res) { $('#holiday_calender').append(res); },
            error: function(xhr, status, error) { console.log(xhr.responseText); }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        if (window.location.hash === "#calander") {
            let calanderTab = new bootstrap.Tab(document.querySelector('a[href="#account-settings"]'));
            calanderTab.show(); 
        }
    });
    
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr("#mnt_frm_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            time_24hr: false,
            minuteIncrement: 30
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        flatpickr("#mnt_end_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            time_24hr: false,
            minuteIncrement: 30
        });
    });

    $(document).ready(function() {
        let selectedDate = null; 

        $("#mnt_date").flatpickr({
            dateFormat: "d-m-Y",
            minDate: "today", 
            onChange: function(selectedDates, dateStr, instance) {
                selectedDate = dateStr; 
                disableSelectedDate();
            }
        });

        function disableSelectedDate() {
            $("#mnt_date").flatpickr({
                dateFormat: "d-m-Y",
                minDate: "today", 
                disable: selectedDate ? [selectedDate] : [], 
                onChange: function(selectedDates, dateStr, instance) {
                    selectedDate = dateStr; 
                    disableSelectedDate(); 
                }
            });
        }
    });
</script>