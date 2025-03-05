<!-- Footer opened -->
<footer class="footer mt-auto py-3 bg-white text-center">
	<div class="container">
		<span class="text-muted">Designed & Developed by 
            <a href="https://amoriotech.com/" target="_blank" class="text-dark fw-medium">Amorio Technologies</a>
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
                                                            
                                                            $showbtn = 0;
                                                            $i = 0;
                                                            foreach($wishes['birth_days'] as $akey => $bday) { 
                                                            $i++;  ?>
                                                                <li class="p-1 mt-2 border-bottom">
                                                                    <p class="mb-1 fw-medium">
                                                                        <label for="bwish<?= $akey; ?>">
                                                                            <i class="bi bi-person-circle"></i>&nbsp; <?= $bday['name']; ?><span class="text-muted fs-11 ms-2"><?php if(AgeCal($bday['day']) == 1){ $yearsvar = 'Year'; }else{ $yearsvar = ' Years';  } ?><?= AgeCal($bday['day']).$yearsvar.' old'; ?></span>
                                                                        </label>

                                                                        <span class="float-end gap-2"> &nbsp;
                                                                            <?php if($bday['wish_noti'] != "") {
                                                                                echo '<span class="badge bi bi-check-circle bg-success rounded-pill text-white">  Email Sent </span>'; $showbtn++;
                                                                            } else { ?>
                                                                                <input type="checkbox" name="bday_wish[]" class="form-check-input h5 rounded-circle form-checked-success border-dark <?= ($info['role'] == ADMIN) ? '' : 'd-none' ?>" id="bwish<?= $akey; ?>" value="<?= $bday['email'].' | '.$bday['name']; ?>" >
                                                                            <?php } ?>
                                                                        </span><br> 
                                                                        <i class="bi bi-envelope"></i>&nbsp; <span class="fw-medium"><?= $bday['email']; ?></span><br> 
                                                                        <i class="bi bi-telephone"></i>&nbsp; <a href="tel:<?= $bday['phone']; ?>"> <span class="fw-medium"><?= $bday['phone']; ?></span> </a>
                                                                    </p>
                                                                </li>
                                                        <?php } } else { ?>
                                                            <li class="dropdown-item text-center p-4">No Birthday Records Found!!</li>
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
                    <?php if($showbtn !== $i){ ?><button type="submit" class="btn btn-primary <?= (($info['role'] == ADMIN) && (!empty($wishes['birth_days']) || !empty($wishes['anni_days'])) ) ? '' : 'd-none' ?>" id="wish_submit" >Send Wishes</button><?php } ?>
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
        <form action="" method="post" id="day_closing">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white" id="DaycloseModalLabel">Day Closing (<?php echo date('d/m/Y'); ?>)</h6>
                    <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModel('')"></button>
                </div>
                <div class="modal-body">
                     <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                    <div class="row">
                        <div style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th width="3%" style="font-weight: bold;">S.No</th>
                                        <th style="font-weight: bold;">Payment Mode</th>
                                        <th style="font-weight: bold;">Amount(₹)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total_amount = 0;
                                    if (!empty($day_report['daycloses']) && count($day_report['daycloses']) > 0) { ?>
                                        <?php $s = 1; foreach ($day_report['daycloses'] as $dayclose) {
                                            $total_amount += $dayclose['total_amount'];
                                        ?>
                                        <tr>
                                            <td><?= $s; ?></td>
                                            <td><?= $dayclose['fld_apaymode']; ?>
                                                <input type="hidden" name="fld_paymethod[]" value="<?= $dayclose['fld_apaymode']; ?>">
                                            </td>
                                            <td><?= number_format($dayclose['total_amount'], 2); ?>
                                                <input type="hidden" name="fld_split_amt[]" value="<?= $dayclose['total_amount']; ?>">
                                            </td>
                                        </tr>
                                    <?php $s++; } } else { ?>
                                        <tr>
                                            <td colspan="3" class="text-center">No records found</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="font-weight: bold; text-align: right;" colspan="2">Total:</th>
                                        <th style="font-weight: bold;"><?= number_format($total_amount, 2); ?></th> 
                                        <input type="hidden" id="previous_amount" name="closeAmount" value="<?= $total_amount; ?>">
                                         <input type="hidden" id="final_amount" name="final_amount" value="<?= ($total_amount); ?>">
                                    </tr>
                                </tfoot>
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
                            <input type="text" name="c_amount" id="c_amount" class="form-control cash_amount">
                            <!-- <input type="hidden" id="previous_amount"> -->
                            <span class="mt-2 error_closeamount text-danger"></span>
                        </div>
                    </div>
                    <div id="cashDenominators" style="display: none; max-height: 300px; overflow-y: auto;">
                       <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Note</th>
                                    <th>Qty</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <tr>
                                    <td class="2000"><?php echo '2000'; ?></td>
                                    <td><input type="number" class="form-control text_0" name="thousands" onkeyup="cashCalculator()"  onchange="cashCalculator()"></td>
                                    <td><span class='form-control' style='background-color: #eee;'>₹  
                                    <input type="text" style="background-color: inherit;border: none;" class="text_0_bal" value="0" readonly=""></span></td>
                                </tr> 
                                <tr>
                                    <td class="1000"><?php echo ('1000') ?></td>
                                    <td><input type="number" class="form-control text_1" name="thousands" onkeyup="cashCalculator()"  onchange="cashCalculator()"></td>
                                    <td><span class='form-control' style='background-color: #eee;'>₹  
                                    <input type="text" style="background-color: inherit;border: none;" class="text_1_bal" value="0" readonly=""></span></td>
                                </tr> 
                                <tr>
                                    <td class="500"><?php echo ('500') ?></td>
                                    <td><input type="number" class="form-control text_2" name="fivehnd" onkeyup="cashCalculator()" onchange="cashCalculator()"></td>
                                    <td><span class='form-control' style='background-color: #eee;'>₹ 
                                    <input type="text" style="background-color: inherit;border: none;" class="text_2_bal" value="0" readonly=""></span></td>
                                </tr>   
                                <tr>
                                    <td class="100"><?php echo ('100') ?></td>
                                    <td><input type="number" class="form-control text_3" name="hundrad" onkeyup="cashCalculator()" onchange="cashCalculator()"></td>
                                    <td><span class='form-control' style='background-color: #eee;'>₹
                                    <input type="text" style="background-color: inherit;border: none;" class="text_3_bal" value="0" readonly=""></span></td>
                                </tr>   
                                <tr>
                                    <td class="50"><?php echo ('50') ?></td>
                                    <td><input type="number" class="form-control text_4" name="fifty" onkeyup="cashCalculator()" onchange="cashCalculator()"></td>
                                    <td><span class='form-control' style='background-color: #eee;'>₹ 
                                    <input type="text" style="background-color: inherit;border: none;" class="text_4_bal" value="0" readonly=""></span></td>
                                </tr>   
                                <tr>
                                    <td class="20"><?php echo ('20') ?></td>
                                    <td><input type="number" class="form-control text_5" name="twenty" onkeyup="cashCalculator()" onchange="cashCalculator()"></td>
                                    <td><span class='form-control' style='background-color: #eee;'>₹ 
                                    <input type="text" style="background-color: inherit;border: none;" class="text_5_bal" value="0" readonly=""></span></td>
                                </tr>   
                                <tr>
                                    <td class="10"><?php echo ('10') ?></td>
                                    <td><input type="number" class="form-control text_6" name="ten" onkeyup="cashCalculator()" onchange="cashCalculator()"></td>
                                    <td><span class='form-control' style='background-color: #eee;'>₹ 
                                    <input type="text" style="background-color: inherit;border: none;" class="text_6_bal" value="0" readonly=""></span></td>
                                </tr>   
                                <tr>
                                    <td class="5"><?php echo ('5') ?></td>
                                    <td><input type="number" class="form-control text_7" name="five" onkeyup="cashCalculator()" onchange="cashCalculator()"></td>
                                    <td><span class='form-control' style='background-color: #eee;'>₹ 
                                    <input type="text" style="background-color: inherit;border: none;" class="text_7_bal" value="0" readonly=""></span></td>
                                </tr>   
                                <tr>
                                    <td class="2"><?php echo ('2') ?></td>
                                    <td><input type="number" class="form-control text_8" name="two" onkeyup="cashCalculator()" onchange="cashCalculator()"></td>
                                    <td><span class='form-control' style='background-color: #eee;'>₹  
                                    <input type="text" style="background-color: inherit;border: none;" class="text_8_bal" value="0" readonly=""></span></td>
                                </tr>
                                <tr>
                                    <td class="1"><?php echo ('1') ?></td>
                                    <td><input type="number" class="form-control text_9" name="one" onkeyup="cashCalculator()" onchange="cashCalculator()"></td>
                                    <td><span class='form-control' style='background-color: #eee;'>₹  
                                    <input type="text" style="background-color: inherit;border: none;" class="text_9_bal" value="0" readonly=""></span></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" align="right"><b>Grand Total</b></td>
                                    <td><span class='form-control' style='background-color: #eee;'>₹  
                                    <input type="text" style="background-color: inherit;border: none;" class="total_money" value="0.00" readonly="" name="grndtotal"></span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="toggleCashDenominators"
                        <?= $day_report['day_status'] == 1 ? 'disabled' : ''; ?>>Cash Denominators</button>
                    <button type="submit" class="btn btn-success"
                        <?= $day_report['day_status'] == 1 ? 'disabled' : ''; ?>>Day Close</button>
                </div>
            </div>
        </form>
</div>
</div>
<!------------ Day Close Modal End ----------->

<!------------ Day Open Modal start ----------->
<div class="modal fade" id="dayopen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="DayopenModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
                                    <td id="fld_opening_balance" class="text-center" style="font-weight: bold;"><?= isset($day_report['dayOpen'][0]['total_amount']) ? $day_report['dayOpen'][0]['total_amount'] : 0; ?></td>
                                    <td><textarea class="form-control" name="fld_opening_notes" id="fld_opening_notes"></textarea> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="cashdayDenominators" style="display: none; max-height: 300px; overflow-y: auto;">
                       <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Note</th>
                                    <th>Qty</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>₹2000</td>
                                    <td><input type="number" class="form-control qty_2000" onkeyup="calculateCashTotal()" onchange="calculateCashTotal()"></td>
                                    <td><span class="form-control" style="background-color: #eee;">₹  
                                    <input type="text" class="bal_2000" value="0" style="background-color: inherit;border: none;" readonly></span></td>
                                </tr> 
                                <tr>
                                    <td>₹1000</td>
                                    <td><input type="number" class="form-control qty_1000" onkeyup="calculateCashTotal()" onchange="calculateCashTotal()"></td>
                                    <td><span class="form-control" style="background-color: #eee;">₹  
                                    <input type="text" class="bal_1000" value="0" style="background-color: inherit;border: none;" readonly></span></td>
                                </tr> 
                                <tr>
                                    <td>₹500</td>
                                    <td><input type="number" class="form-control qty_500" onkeyup="calculateCashTotal()" onchange="calculateCashTotal()"></td>
                                    <td><span class="form-control" style="background-color: #eee;">₹  
                                    <input type="text" class="bal_500" value="0" style="background-color: inherit;border: none;" readonly></span></td>
                                </tr> 
                                <tr>
                                    <td>₹100</td>
                                    <td><input type="number" class="form-control qty_100" onkeyup="calculateCashTotal()" onchange="calculateCashTotal()"></td>
                                    <td><span class="form-control" style="background-color: #eee;">₹  
                                    <input type="text" class="bal_100" value="0" style="background-color: inherit;border: none;" readonly></span></td>
                                </tr> 
                                <tr>
                                    <td>₹50</td>
                                    <td><input type="number" class="form-control qty_50" onkeyup="calculateCashTotal()" onchange="calculateCashTotal()"></td>
                                    <td><span class="form-control" style="background-color: #eee;">₹  
                                    <input type="text" class="bal_50" value="0" style="background-color: inherit;border: none;" readonly></span></td>
                                </tr> 
                                <tr>
                                    <td>₹20</td>
                                    <td><input type="number" class="form-control qty_20" onkeyup="calculateCashTotal()" onchange="calculateCashTotal()"></td>
                                    <td><span class="form-control" style="background-color: #eee;">₹  
                                    <input type="text" class="bal_20" value="0" style="background-color: inherit;border: none;" readonly></span></td>
                                </tr> 
                                <tr>
                                    <td>₹10</td>
                                    <td><input type="number" class="form-control qty_10" onkeyup="calculateCashTotal()" onchange="calculateCashTotal()"></td>
                                    <td><span class="form-control" style="background-color: #eee;">₹  
                                    <input type="text" class="bal_10" value="0" style="background-color: inherit;border: none;" readonly></span></td>
                                </tr> 
                                <tr>
                                    <td>₹5</td>
                                    <td><input type="number" class="form-control qty_5" onkeyup="calculateCashTotal()" onchange="calculateCashTotal()"></td>
                                    <td><span class="form-control" style="background-color: #eee;">₹  
                                    <input type="text" class="bal_5" value="0" style="background-color: inherit;border: none;" readonly></span></td>
                                </tr> 
                                <tr>
                                    <td>₹2</td>
                                    <td><input type="number" class="form-control qty_2" onkeyup="calculateCashTotal()" onchange="calculateCashTotal()"></td>
                                    <td><span class="form-control" style="background-color: #eee;">₹  
                                    <input type="text" class="bal_2" value="0" style="background-color: inherit;border: none;" readonly></span></td>
                                </tr>
                                <tr>
                                    <td>₹1</td>
                                    <td><input type="number" class="form-control qty_1" onkeyup="calculateCashTotal()" onchange="calculateCashTotal()"></td>
                                    <td><span class="form-control" style="background-color: #eee;">₹  
                                    <input type="text" class="bal_1" value="0" style="background-color: inherit;border: none;" readonly></span></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" align="right"><b>Grand Total</b></td>
                                    <td><span class="form-control" style="background-color: #eee;">₹  
                                    <input type="text" class="grand_total" value="0.00" style="background-color: inherit;border: none;" readonly></span></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><span class="mt-2 error_tamount text-danger"></span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="toggledayCashDenominators">Cash Denominators</button>
                    <button type="submit" class="btn btn-success" id="dayopen_submit">Day Begin</button>
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
    <script src="<?= base_url('../assets/datatable/buttons.colVis.min.js'); ?>"></script>

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
  //  dayOpen();
    
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
                console.log(result);
                if(result.status == 200) {
                    AlertPopup('Success!', 'Day Begin Successfully!', 'success', 'Ok', '');
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
        var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
        var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
        let paymode = $(this).val();
        $('#cash_amounts').toggleClass('d-none', paymode !== 'cash to bank');
        $.ajax({
            url: '<?= base_url('setopening_balance') ?>',
            type: 'post',
            data: { [csrfName]:csrfHash},
            dataType: 'json',
            success:function(result) {
                if(result.status == 200) {
                   var totalAmount = result.data[0]['total_amount'];
                    if (!isNaN(totalAmount) && totalAmount !=null) {
                        $('#c_amount').val(parseFloat(totalAmount).toFixed(2));
                    } else {
                         $('#c_amount').val('');
                    }
                    $('#previous_amount').val(parseFloat(result.data[0]['total_amount']).toFixed(2));
                } else {
                     var totalAmount = result.data[0]['total_amount'];
                    if (!isNaN(totalAmount) && totalAmount !=null) {
                        $('#c_amount').val(parseFloat(totalAmount).toFixed(2));
                    } else {
                         $('#c_amount').val('');
                    }
                    $('#previous_amount').val(parseFloat(result.data[0]['total_amount']).toFixed(2));
                }
            }
        });
    });

    // Day Close
    $("#day_closing").submit(function (event) {
        event.preventDefault();
        var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
        var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
        var cashAmount = parseFloat($('#c_amount').val()) || 0;
        var prevAmount = parseFloat($('#previous_amount').val()) || 0;
        console.log(prevAmount);
        var formData = $("#day_closing").serializeArray();
        formData.push({ name: csrfName, value: csrfHash });
       if ((cashAmount > prevAmount) && (prevAmount !=0)) {
            $(".error_closeamount").text("Cash amount should not be greater than previous amount");
            return false;
        } else {
            $(".error_closeamount").text("");
            $.ajax({
                url: '<?= base_url('dayclose_update') ?>',
                type: 'post',
                data: formData,
                dataType: 'json',
                success:function(result) {
                    console.log(result);
                    if(result.status == 200) {
                        AlertPopup('Success!', 'Day Close Successfully', 'success', 'Ok', '');
                        $('#dayopen').modal('hide');
                    } else {
                        AlertPopup('Error!', 'Day Close Failed!!!', 'error', 'Ok', '');
                        $('#dayopen').modal('show');
                    }
                }
            });
        }
    });

    
    // cashDenominators
    $('#toggleCashDenominators').click(function() {
        $('#cashDenominators').toggle();
    });

    $('#toggledayCashDenominators').click(function() {
        $('#cashdayDenominators').toggle();
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
            if(result.status == 200) {
                $('#dayopen').modal('hide');
            } else {
                $('#dayopen').modal('show');
            }
        }
    });
}

// Calculate
function cashCalculator() 
{   
    
    var mul0 = $('.text_0').val();
    var text_0_bal = mul0 * 2000;
    console.log(text_0_bal);
    $('.text_0_bal').val(text_0_bal);

    var mul1 = $('.text_1').val();
    var text_1_bal = mul1 * 1000;
    $('.text_1_bal').val(text_1_bal);

    var mul2 = $('.text_2').val();
    var text_2_bal = mul2 * 500;
    $('.text_2_bal').val(text_2_bal);

    var mul3 = $('.text_3').val();
    var text_3_bal = mul3 * 100;
    $('.text_3_bal').val(text_3_bal);

    var mul4 = $('.text_4').val();
    var text_4_bal = mul4 * 50;
    $('.text_4_bal').val(text_4_bal);

    var mul5 = $('.text_5').val();
    var text_5_bal = mul5 * 20;
    $('.text_5_bal').val(text_5_bal);

    var mul6 = $('.text_6').val();
    var text_6_bal = mul6 * 10;
    $('.text_6_bal').val(text_6_bal);

    var mul7 = $('.text_7').val();
    var text_7_bal = mul7 * 5;
    $('.text_7_bal').val(text_7_bal);

    var mul8 = $('.text_8').val();
    var text_8_bal = mul8 * 2;
    $('.text_8_bal').val(text_8_bal);

    var mul9 = $('.text_9').val();
    var text_9_bal = mul9 * 1;
    $('.text_9_bal').val(text_9_bal);


    var total_money = (text_0_bal + text_1_bal + text_2_bal + text_3_bal + text_4_bal + text_5_bal + text_6_bal + text_7_bal + text_8_bal + text_9_bal);

    $('.total_money').val(total_money);
}

// Day Open
function calculateCashTotal() {   
    var mul0 = $('.qty_2000').val();
    var bal_2000 = mul0 * 2000;
    $('.bal_2000').val(bal_2000);

    var mul1 = $('.qty_1000').val();
    var bal_1000 = mul1 * 1000;
    $('.bal_1000').val(bal_1000);

    var mul2 = $('.qty_500').val();
    var bal_500 = mul2 * 500;
    $('.bal_500').val(bal_500);

    var mul3 = $('.qty_100').val();
    var bal_100 = mul3 * 100;
    $('.bal_100').val(bal_100);

    var mul4 = $('.qty_50').val();
    var bal_50 = mul4 * 50;
    $('.bal_50').val(bal_50);

    var mul5 = $('.qty_20').val();
    var bal_20 = mul5 * 20;
    $('.bal_20').val(bal_20);

    var mul6 = $('.qty_10').val();
    var bal_10 = mul6 * 10;
    $('.bal_10').val(bal_10);

    var mul7 = $('.qty_5').val();
    var bal_5 = mul7 * 5;
    $('.bal_5').val(bal_5);

    var mul8 = $('.qty_2').val();
    var bal_2 = mul8 * 2;
    $('.bal_2').val(bal_2);

    var mul9 = $('.qty_1').val();
    var bal_1 = mul9 * 1;
    $('.bal_1').val(bal_1);

    var total_money = (bal_2000 + bal_1000 + bal_500 + bal_100 + bal_50 + bal_20 + bal_10 + bal_5 + bal_2 + bal_1);
    $('.grand_total').val(total_money);
}


</script>

</body> 

</html>
