
<!-- Footer opened -->
<footer class="footer mt-auto py-3 bg-white text-center">
	<div class="container">
		<span class="text-muted"> Copyright © <span id="year"></span> 
            <a href="https://amoriotech.com/" target="_blank" class="text-dark fw-medium">Amorio Technologies</a>.
		</span>
	</div>
</footer>
<!-- End Footer -->

<!-- Country-selector modal -->
<div class="modal fade" id="header-responsive-search" tabindex="-1" aria-labelledby="header-responsive-search" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <div class="input-group">
                <input type="text" class="form-control border-end-0" placeholder="Search Anything ..."
                    aria-label="Search Anything ..." aria-describedby="button-addon2">
                <button class="btn btn-primary" type="button"
                    id="button-addon2"><i class="bi bi-search"></i></button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- End Country-selector modal -->


<!------------ Birthday / Anniversary Modal start ----------->
<div class="modal fade" id="wishesModal" tabindex="-1" aria-labelledby="wishesModal" data-bs-keyboard="false" aria-hidden="true">
<!-- Scrollable modal -->
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form method="post" id="wish_form">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white" id="staticBackdropLabel2">Today's Wishes</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModel('');"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <h5 class="text-center">
                                <span class="avatar avatar-md avatar-rounded bg-primary p-1 svg-white">
                                    <i class="bi bi-cake2-fill fs-5"></i>
                                </span>&emsp;
                                Birthday Record(s)
                            </h5>
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
                                                        <?php 
                                                        if(!empty($wishes['birth_days'])) {
                                                            foreach($wishes['birth_days'] as $akey => $bday) { ?>
                                                                <li class="p-4 border-0 border-bottom">
                                                                    <p class="fs-15 mb-1 fw-medium">
                                                                        <label for="bwish<?= $akey; ?>">
                                                                            <?= $bday['name']; ?><span class="text-muted fs-11 ms-2"><?= AgeCal($bday['day']).'  Year old'; ?></span>
                                                                        </label>

                                                                        <span class="float-end gap-3">
                                                                            <input type="checkbox" name="bday_wish[]" class="form-check-input h5 rounded-circle form-checked-success border-dark <?= ($info['role'] == ADMIN) ? '' : 'd-none' ?>" id="bwish<?= $akey; ?>" value="<?= $bday['email'].' | '.$bday['name']; ?>" >
                                                                        </span><br> 
                                                                        <span class="fw-medium"><?= $bday['email']; ?></span><br> 
                                                                        <a href="tel:<?= $bday['phone']; ?>"> <span class="fw-medium"><?= $bday['phone']; ?></span> </a>
                                                                    </p>
                                                                </li>
                                                        <?php } } else { ?>
                                                            <li class="dropdown-item text-center p-4">No Birthday Records Found!!!</li>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="simplebar-placeholder" style="width: 398px; height: 400px;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                        <div class="simplebar-scrollbar" style="height: 100px; display: block; transform: translate3d(0px, 0px, 0px);"></div>
                                    </div>
                                </ul>
                            </div>

                        </div>

                        <div class="col-md-6 col-sm-12">
                            <h5 class="text-center">
                                <span class="avatar avatar-md avatar-rounded bg-primary p-1 svg-white">
                                    <i class="bi bi-balloon-heart-fill fs-5"></i>
                                </span>&emsp;
                                Anniversary Record(s)
                            </h5>
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
                                                        <?php 
                                                        if(!empty($wishes['anni_days'])) {
                                                            foreach($wishes['anni_days'] as $akey => $aday) { ?>
                                                                <li class="p-4 border-0 border-bottom">
                                                                    <p class="fs-15 mb-1 fw-medium">
                                                                        <label for="anni_wish<?= $akey; ?>">
                                                                            <?= $aday['name']; ?>
                                                                            <span class="text-muted fs-11 ms-2">
                                                                                <?= AgeCal($aday['day']).' Year(s)'; ?>
                                                                            </span>
                                                                        </label>

                                                                        <span class="float-end gap-3 p-3">
                                                                            <input type="checkbox" name="anni_daywish[]" class="form-check-input h5 rounded-circle form-checked-success border-dark <?= ($info['role'] == ADMIN) ? '' : 'd-none' ?>" id="anni_wish<?= $akey; ?>" value="<?= $aday['email'].' | '.$aday['name']; ?>" >
                                                                        </span>
                                                                        <span class="fw-medium"><?= $aday['email']; ?></span><br> 
                                                                        <a href="tel:<?= $aday['phone']; ?>"> <span class="fw-medium"><?= $aday['phone']; ?></span> </a>
                                                                    </p>
                                                                </li>
                                                        <?php } } else { ?>
                                                            <li class="dropdown-item text-center p-4">No Anniversary Records Found!!!</li>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="simplebar-placeholder" style="width: 398px; height: 400px;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                        <div class="simplebar-scrollbar" style="height: 100px; display: block; transform: translate3d(0px, 0px, 0px);"></div>
                                    </div>
                                </ul>
                            </div>
                            <span class="wish-error text-danger text-center"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary <?= ($info['role'] == ADMIN) ? '' : 'd-none' ?> <?= (!empty($wishes['birth_days']) || !empty($wishes['anni_days'])) ? '' : 'd-none' ?>" >Send Wishes</button>
                </div>
            </form>
        </div>

    </div>
</div>
<!------------ Birthday / Anniversary Modal end ----------->
</div>

    <!-- SCRIPTS -->
    <!-- Scroll To Top -->
    <div class="scrollToTop">
         <span class="arrow lh-1"><i class="ti ti-caret-up fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>
    <!-- Scroll To Top -->


    <!-- Popper JS -->
    <script src="<?= base_url('assets/libs/@popperjs/core/umd/popper.min.js'); ?>"></script>

    <!-- Bootstrap JS -->
    <script src="<?= base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <!-- Node Waves JS-->
    <script src="<?= base_url('assets/libs/node-waves/waves.min.js'); ?>"></script>

    <!-- Simplebar JS -->
    <script src="<?= base_url('assets/libs/simplebar/simplebar.min.js'); ?>"></script>
    <link rel="modulepreload" href="<?= base_url('assets/js/simplebar.js'); ?>" />
    <script type="module" src="<?= base_url('assets/js/simplebar.js'); ?>"></script>

    <!-- Auto Complete JS -->
    <script src="<?= base_url('assets/libs/@tarekraafat/autocomplete.js/autoComplete.min.js'); ?>"></script>

    <!-- Color Picker JS -->
    <script src="<?= base_url('assets/libs/@simonwep/pickr/pickr.es5.min.js'); ?>"></script>


    <!-- Date & Time Picker JS -->
    <script src="<?= base_url('assets/libs/flatpickr/flatpickr.min.js'); ?>"></script>


    <!-- Prism JS -->
    <script src="<?= base_url('assets/libs/prismjs/prism.js'); ?>"></script>
    <link rel="modulepreload" href="<?= base_url('assets/js/prism-custom.js'); ?>" />
    <script type="module" src="<?= base_url('assets/js/prism-custom.js'); ?>"></script>

    <!-- Sweetalerts JS -->
    <script src="<?= base_url('assets/libs/sweetalert2/sweetalert2.min.js'); ?>"></script>

    <!-- Sticky JS -->
    <script src="<?= base_url('assets/js/sticky.js'); ?>"></script>

    <!-- Moment JS -->
    <script src="<?= base_url('assets/libs/moment/moment.js'); ?>"></script>
    <script src="<?= base_url('assets/datepicker/daterangepicker.js'); ?>"></script>

    <!-- Date & Time Picker JS -->
    <link rel="modulepreload" href="<?= base_url('assets/js/date_time_pickers.js'); ?>" />
    <script type="module" src="<?= base_url('assets/js/date_time_pickers.js'); ?>"></script>

    <!-- Datatables Cdn -->
    <script src="<?= base_url('assets/datatable/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= base_url('assets/datatable/dataTables.bootstrap5.min.js'); ?>"></script>
    <script src="<?= base_url('assets/datatable/dataTables.responsive.min.js'); ?>"></script>
    <script src="<?= base_url('assets/datatable/dataTables.buttons.min.js'); ?>"></script>
    <script src="<?= base_url('assets/datatable/buttons.print.min.js'); ?>"></script>
    <script src="<?= base_url('assets/datatable/pdfmake.min.js'); ?>"></script>
    <script src="<?= base_url('assets/datatable/vfs_fonts.js'); ?>"></script>
    <script src="<?= base_url('assets/datatable/buttons.html5.min.js'); ?>"></script>
    <script src="<?= base_url('assets/datatable/jszip.min.js'); ?>"></script>


    <!-- Custom-Switcher JS -->
    <link rel="modulepreload" href="<?= base_url('assets/js/custom-switcher.js'); ?>" />
    <script type="module" src="<?= base_url('assets/js/custom-switcher.js'); ?>"></script>

    <!-- APP JS-->
	<link rel="modulepreload" href="<?= base_url('assets/js/app.js'); ?>" />
    <script type="module" src="<?= base_url('assets/js/app.js'); ?>"></script>

    <script src="<?= base_url('assets/js/footer.js') ?>"></script>
    <!-- END SCRIPTS -->

</body> 

</html>
