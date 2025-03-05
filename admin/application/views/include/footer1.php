<!-- Footer opened -->
<footer class="footer mt-auto py-3 bg-white text-center">
	<div class="container">
		<span class="text-muted"> Copyright © <span id="year"></span> 
            <a href="https://amoriotech.com/" target="_blank" class="text-dark fw-medium">Amorio</a>.
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
                        <div class="col-md-12 col-sm-12">
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
                                                                <li class="p-1 mt-2 border-bottom">
                                                                    <p class="mb-1 fw-medium">
                                                                        <label for="bwish<?= $akey; ?>">
                                                                            <i class="bi bi-person-circle"></i>&nbsp; <?= $bday['name']; ?><span class="text-muted fs-11 ms-2"><?= AgeCal($bday['day']).'  Year old'; ?></span>
                                                                        </label>

                                                                        <span class="float-end gap-2">
                                                                            <?php if($bday['wish_noti'] != "") {
                                                                                echo '<span class="badge bi bi-check-circle bg-success rounded-pill text-white"> sended </span>';
                                                                            } else { ?>
                                                                                <input type="checkbox" name="bday_wish[]" class="form-check-input h5 rounded-circle form-checked-success border-dark <?= ($info['role'] == ADMIN) ? '' : 'd-none' ?>" id="bwish<?= $akey; ?>" value="<?= $bday['email'].' | '.$bday['name']; ?>" >
                                                                            <?php } ?>
                                                                        </span><br> 
                                                                        <i class="bi bi-envelope"></i>&nbsp; <span class="fw-medium"><?= $bday['email']; ?></span><br> 
                                                                        <i class="bi bi-telephone"></i>&nbsp; <a href="tel:<?= $bday['phone']; ?>"> <span class="fw-medium"><?= $bday['phone']; ?></span> </a>
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
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary <?= (($info['role'] == ADMIN) && (!empty($wishes['birth_days']) || !empty($wishes['anni_days'])) ) ? '' : 'd-none' ?>" id="wish_submit" >Send Wishes</button>
                </div>
            </form>
        </div>

    </div>
</div>
<!------------ Birthday / Anniversary Modal end ----------->

<!------------ Day Close Modal start ----------->
<div class="modal fade" id="dayclosed" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="DaycloseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="" method="post" id="cate_form">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white" id="DaycloseModalLabel">Day Closing (<?php echo date('d/m/Y'); ?>)</h6>
                    <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModel('')"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th width="3%" style="font-weight: bold;">S.No</th>
                                        <th style="font-weight: bold;">Payment Method</th>
                                        <th style="font-weight: bold;">Recieved (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($daycloses) && count($daycloses) > 0) { ?>
                                        <?php $s=1; foreach ($daycloses as $dayclose) { ?>
                                        <tr>
                                            <td><?= $s; ?></td>
                                            <td><?= $dayclose['fld_apaymode']; ?></td>
                                            <td><?= $dayclose['total_amount']; ?></td>
                                        </tr>
                                    <?php $s++; } } else { ?>
                                        <tr>
                                            <td colspan="3" class="text-center">No records found</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label>Closing Notes</label>
                            <textarea class="form-control" name="fld_closing_notes" id="fld_closing_notes"></textarea>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label>Paymode</label>
                            <select class="form-select" name="cashpaymode" id="cashpaymode">
                                <option value="">Select Paymode</option>
                                <option value="cash to bank">Cash to Bank</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-4">
                        </div>
                        <div class="col-md-6 d-none" id="cash_amounts">
                            <label>Amount</label>
                            <input type="number" name="c_amount" id="c_amount" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModel('')" data-bs-dismiss="modal">Back</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!------------ Day Close Modal End ----------->

<!------------ Day Open Modal start ----------->
<div class="modal fade" id="dayopen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="DayopenModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form action="" method="post" id="day_openform">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white" id="DayopenModalLabel">Day Open (<?php echo date('d/m/Y'); ?>)</h6>
                    <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModel('')"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                       <table class="table table-bordered w-100">
                            <thead>
                                <tr class="text-center">
                                    <th>Opening Balance (Rs.)</th>
                                    <th>Opening Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="fld_opening_balance" class="text-center" style="font-weight: bold;"><?= number_format(isset($dayOpen[0]['total_amount']) ? $dayOpen[0]['total_amount'] : 0, 2); ?></td>
                                    <td><textarea class="form-control" name="fld_opening_notes" id="fld_opening_notes"></textarea> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModel('')" data-bs-dismiss="modal">Back</button>
                    <button type="submit" class="btn btn-success" id="dayopen_submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!------------ Day Open Modal End ----------->

</div>

    <!-- SCRIPTS -->
    <!-- Scroll To Top -->
    <div class="scrollToTop">
        <span class="arrow lh-1"><i class="ti ti-caret-up fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>
    <!-- Scroll To Top -->

    <!-- Popper JS -->
    <script src="<?= base_url('../assets/libs/@popperjs/core/umd/popper.min.js'); ?>"></script>

    <!-- Bootstrap JS -->
    <script src="<?= base_url('../assets/libs/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <!-- Node Waves JS-->
    <script src="<?= base_url('../assets/libs/node-waves/waves.min.js'); ?>"></script>

    <!-- Simplebar JS -->
    <script src="<?= base_url('../assets/libs/simplebar/simplebar.min.js'); ?>"></script>
    <link rel="modulepreload" href="<?= base_url('../assets/js/simplebar.js'); ?>" />
    <script type="module" src="<?= base_url('../assets/js/simplebar.js'); ?>"></script>

    <!-- Auto Complete JS -->
    <script src="<?= base_url('../assets/libs/@tarekraafat/autocomplete.js/autoComplete.min.js'); ?>"></script>

    <!-- Color Picker JS -->
    <script src="<?= base_url('../assets/libs/@simonwep/pickr/pickr.es5.min.js'); ?>"></script>

    <!-- Prism JS -->
    <script src="<?= base_url('../assets/libs/prismjs/prism.js'); ?>"></script>
    <link rel="modulepreload" href="<?= base_url('../assets/js/prism-custom.js'); ?>" />
    <script type="module" src="<?= base_url('../assets/js/prism-custom.js'); ?>"></script>

    <!-- Sweetalerts JS -->
    <script src="<?= base_url('../assets/libs/sweetalert2/sweetalert2.min.js'); ?>"></script>

    <!-- Sticky JS -->
    <script src="<?= base_url('../assets/js/sticky.js'); ?>"></script>

    <!-- Moment JS -->
    <script src="<?= base_url('../assets/libs/moment/moment.js'); ?>"></script>
    <script src="<?= base_url('../assets/datepicker/daterangepicker.js'); ?>"></script>

    <!-- Date & Time Picker JS -->
    <link rel="modulepreload" href="<?= base_url('../assets/js/date_time_pickers.js'); ?>" />
    <script type="module" src="<?= base_url('../assets/js/date_time_pickers.js'); ?>"></script>

    <!-- Datatables Cdn -->
    <script src="<?= base_url('../assets/datatable/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= base_url('../assets/datatable/dataTables.bootstrap5.min.js'); ?>"></script>
    <script src="<?= base_url('../assets/datatable/dataTables.responsive.min.js'); ?>"></script>
    <script src="<?= base_url('../assets/datatable/dataTables.buttons.min.js'); ?>"></script>
    <script src="<?= base_url('../assets/datatable/buttons.print.min.js'); ?>"></script>
    <script src="<?= base_url('../assets/datatable/pdfmake.min.js'); ?>"></script>
    <script src="<?= base_url('../assets/datatable/vfs_fonts.js'); ?>"></script>
    <script src="<?= base_url('../assets/datatable/buttons.html5.min.js'); ?>"></script>
    <script src="<?= base_url('../assets/datatable/jszip.min.js'); ?>"></script>

    <!-- Internal Datatables JS -->
    <link rel="modulepreload" href="<?= base_url('../assets/js/datatables.js'); ?>" />
    <script type="module" src="<?= base_url('../assets/js/datatables.js'); ?>"></script>

    <!-- Custom-Switcher JS -->
    <link rel="modulepreload" href="<?= base_url('../assets/js/custom-switcher.js'); ?>" />
    <script type="module" src="<?= base_url('../assets/js/custom-switcher.js'); ?>"></script>

    <!-- Form Validation JS -->
    <script type="module" src="<?= base_url('../assets/js/jquery.validate.min.js'); ?>"></script>

    <!-- APP JS-->
	<link rel="modulepreload" href="<?= base_url('../assets/js/app.js'); ?>" />
    <script type="module" src="<?= base_url('../assets/js/app.js'); ?>"></script>

    <script src="<?= base_url('../assets/js/footer.js'); ?>"></script>
    <!-- END SCRIPTS -->

    <style type="text/css">
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
          -webkit-appearance: none;
          margin: 0;
        }

        /* Firefox */
        input[type=number] {
          -moz-appearance: textfield;
        }
    </style>

    <script type="text/javascript">
        /* -------- When click close model button reload the page --------- */
        function closeModel(pagename) {
            $('.cate-error-msg, .error-msg').html('');
            $('form').find('.form-control').css('border', '');
            (pagename == '') ? location.reload() : window.location.href = '<?= base_url("'+ pagename +'")?>';
        }


        function MinutesToHour(minutes) {
            var Hours = parseInt(parseFloat(minutes) / 60);
            var Mints = (parseFloat(minutes) - (Hours * 60));
            var Hour = (Hours < 9) ? '0'+Hours : Hours;
            var Mins = (Mints < 9) ? '0'+Mints : Mints;
            return Hour+':'+Mins;
        }

        function AlertPopup(altTitle, altText, altIcon, btnText, pageName) {
            Swal.fire({
                title: altTitle,
                text: altText,
                icon: altIcon,
                confirmButtonText: btnText,
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if(result.isConfirmed) {
                    (pageName == '') ? location.reload() : window.location.href = '<?= base_url("'+ pageName +'")?>';
                }
            });
        }

$(document).ready(function(){
    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
    dayOpen();
    
    $('#dayopen_submit').on('click', function(event) {
        event.preventDefault();
        var openbalance = $('#fld_opening_balance').text();
        var opennotes = $('#fld_opening_notes').val();
        $.ajax({
            url: '<?= base_url('day_openinsert') ?>',
            type: 'post',
            data: { [csrfName]:csrfHash, openbalance:openbalance, opennotes:opennotes },
            dataType: 'json',
            success:function(result) {
                if(result.status == 200) {
                    AlertPopup('Success!', 'Day Open Successfully!', 'success', 'Ok', '');
                    $('#dayopen').modal('hide');
                } else {
                    AlertPopup('Error!', 'Day Open Failed!!!', 'error', 'Ok', '');
                }
            }
        });
    });

    // Cash Bank 
    $('#cashpaymode').on('change', function(event) {
        event.preventDefault();
        let paymode = $(this).val();
        $('#cash_amounts').toggleClass('d-none', paymode !== 'cash to bank');
    });
});

function dayOpen()
{
    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
    $.ajax({
        url: '<?= base_url('checkdayopen_data') ?>',
        type: 'post',
        data: { [csrfName]:csrfHash},
        dataType: 'json',
        success:function(result) {
            console.log(result);
            if(result.status == 200) {
                $('#dayopen').modal('hide');
            } else {
                $('#dayopen').modal('show');
            }
        }
    });
}

</script>

</body> 

</html>
