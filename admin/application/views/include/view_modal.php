<!--------------- Displaying customer details -------------->
<div class="modal fade" id="viewCust" aria-labelledby="ViewCustModalToggleLabel" tabindex="-1" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <h6 class="modal-title text-white" id="ViewCustModalToggleLabel">Customer Details</h6>
            <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th class="table-info text-uppercase" width="25%">Customer ID</th>
                        <td><span id="custid"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="25%">First Name</th>
                        <td><span id="cname"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="25%">Last Name</th>
                        <td><span id="clname"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="25%">Phone</th>
                        <td><span id="cphone"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="25%">Email</th>
                        <td><span id="cemail"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="25%">Date of Birth</th>
                        <td><span id="cdob"></span></td>
                    </tr>
                </table>
            </div>
  
        </div>
    </div>
</div>
</div>


<!------------------- Displaying staff details ---------------->
<div class="modal fade" id="viewStaff" aria-labelledby="ViewStaffModalToggleLabel" tabindex="-1" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <h6 class="modal-title text-white" id="ViewStaffModalToggleLabel">Staff Details</h6>
            <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th class="table-info text-uppercase" width="25%">Staff ID</th>
                        <td><span id="staffid"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="25%">Name</th>
                        <td><span id="staffname"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="25%">Phone</th>
                        <td><span id="staffphone"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="25%">Email</th>
                        <td><span id="staffemail"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="25%">Designation</th>
                        <td><span id="staff_design"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="25%">Date of Birth</th>
                        <td><span id="staffdob"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="25%">Experience</th>
                        <td><span id="staffexpe"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="25%">Date of Joining</th>
                        <td><span id="staffdoj"></span></td>
                    </tr>
                    
                    <tr>
                        <th class="table-info text-uppercase" width="25%">Gender</th>
                        <td><span id="staffgender"></span></td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="25%">Access Management <br> <small>(Module-wise)</small></th>
                        <td> <input type="text" id="staffserv" class="form-control" value="" readonly> </td>
                    </tr>
                    <tr>
                        <th class="table-info text-uppercase" width="25%">Address</th>
                        <td><span id="staffaddr"></span></td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>
</div>

<!------------------- My space modal ----------------------->
<div class="modal fade" id="MySpaceModel" tabindex="-1" aria-labelledby="MySpaceModel" data-bs-keyboard="false" aria-hidden="true">
<!-- Scrollable modal -->
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title text-white" id="staticBackdropLabel3">Client Info</h6>
                <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th class="table-info text-uppercase" width="25%">Name</th>
                            <td> <span id="name"></span> </td>
                        </tr>
                        <tr>
                            <th class="table-info text-uppercase" width="25%">Phone</th>
                            <td> <span id="phone"></span> </td>
                        </tr>
                        <tr>
                            <th class="table-info text-uppercase" width="25%">Date of Birth</th>
                            <td> <span id="dob"></span> </td>
                        </tr>
                        <tr>
                            <th class="table-info text-uppercase" width="25%">Anniversary Date</th>
                            <td> <span id="anni_date"></span> </td>
                        </tr>
                        <tr>
                            <th class="table-info text-uppercase" width="25%">Special Notes</th>
                            <td> <span id="cprefer"></span> </td>
                        </tr>
                        <tr>
                            <th class="table-info text-uppercase" width="25%">Service Notes</th>
                            <td> <span id="cserv_note"></span> </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


<!------------------ Displaying appointment details -------------->
<div class="modal fade" id="viewAppintment" aria-labelledby="ViewAppointmentModalToggleLabel" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title text-white" id="ViewAppointmentModalToggleLabel">Booking Details</h6>
                <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th class="table-info text-uppercase" width="30%">Booking ID</th>
                            <td><b><span id="appo_id" class="text-primary h5"></span></b></td>
                        </tr>
                        <tr>
                            <th class="table-info text-uppercase" width="30%">Booking Date</th>
                            <td><span id="book_date"></span></td>
                        </tr>
                        <tr>
                            <th class="table-info text-uppercase" width="30%">Slot Date & Time</th>
                            <td><span id="app_date"></span></td>
                        </tr>
                        <tr>
                            <th class="table-info text-uppercase" width="30%">Full Name</th>
                            <td><span id="app_name"></span></td>
                        </tr>
                      
                        <tr>
                            <th class="table-info text-uppercase" width="30%">Phone</th>
                            <td><span id="app_number"></span></td>
                        </tr>
                        <tr>
                            <th class="table-info text-uppercase" width="30%">Email</th>
                            <td><span id="app_email"></span></td>
                        </tr>
                        <tr>
                            <th class="table-info text-uppercase" width="30%">Date of Birth</th>
                            <td><span id="app_dob"></span></td>
                        </tr>
                      
                        <tr>
                            <th class="table-info text-uppercase" width="30%">Pay Mode</th>
                            <td><span id="app_paymode"></span></td>
                        </tr>
                    
                        <tr> <th> <td></td> </th> </tr>

                        <tr class="table-info text-center">
                            <th class="text-uppercase">COURT</th>
                            <th class="text-uppercase">DURATION</th>
                            <th class="text-uppercase">TIMING</th>
                            <th class="text-uppercase">AMOUNT (₹)</th>
                        </tr>
                        <tbody id="servbody"></tbody>
                        <tfoot id="servfoot"></tfoot>

                    </table>
                </div>
      
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    var input = document.getElementById('staffserv');
    new Tagify(input);

    function viewDatas(id, type) {

        var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
        var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
        
        $('#servbody, #servfoot').empty();
        if(type == 'customer') {
            $('#cname, #clname, #cphone, #cemail, #cdob, #cmarital, #canni, #cgender, #ctype, #caddr, #cnotes').html('');

        } else if(type == 'staff') {
            $('#staffname, #staffphone, #staffemail, #staffdob, #staffdoj, #staffexpe, #staff_design, #staffanni, #staffgender, #staffaddr').html('');
            $('#staffserv').val('');

        } else if(type == 'my_space') {
            $('#name, #phone, #dob, #anni_date, #cprefer, #cserv_note').html('');

        } else if(type == 'appointment') {
            $('#appo_id, #book_date, #app_date, #app_name, #app_number, #app_email, #app_serv, #app_paymode, #app_dob, #app_marital_sts, #app_anni_date, #app_prefe, #app_notes').html('');
        }

        $.ajax({
            url: '<?= base_url('view_records'); ?>',
            type: 'post',
            data: { [csrfName]: csrfHash, id : id, type: type },
            dataType: 'json',
            success: function(res) {

                if(res != "") {
                    if(type == 'customer') {
                        $('#custid').html(res[0].fld_custid);
                        $('#cname').html(res[0].fld_name);
                        $('#clname').html(res[0].fld_lastname);
                        $('#cphone').html(res[0].fld_phone);
                        $('#cemail').html(res[0].fld_email);
                        $('#cdob').html(displayDate(res[0].fld_dob));
                        $('#cmarital').html(res[0].fld_maritial_sts);
                        $('#canni').html(displayDate(res[0].fld_anniversary));
                        $('#cgender').html(res[0].fld_gender);
                        $('#ctype').html(res[0].fld_type);
                        $('#caddr').html(res[0].fld_address);
                        $('#cnotes').html(res[0].fld_notes);

                    } else if(type == 'staff') {
                        $('#staffid').html(res[0].fld_staffid);
                        $('#staffname').html(res[0].fld_uname);
                        $('#staffphone').html(res[0].fld_uphone);
                        $('#staffemail').html(res[0].fld_uemail);
                        $('#staffdob').html(displayDate(res[0].fld_udob));
                        $('#staffdoj').html(displayDate(res[0].fld_udoj));
                        var expe = res[0].fld_uexperience.split(", ");
                        $('#staffexpe').html(expe[0]+' Year(s), '+expe[1]+' Month(s)');
                        $('#staff_design').html(res[0].fld_staff_designation);
                        $('#staffanni').html(displayDate(res[0].fld_uanniversary));
                        $('#staffgender').html(res[0].fld_ugender);
                        $('#staffserv').val(res[0].fld_access);
                        $('#staffaddr').html(res[0].fld_uaddress);
                    
                    } else if(type == 'my_space') {
                        var key = Object.keys(res);
                        $('#name').html(res[key].app_name);
                        $('#phone').html(res[key].app_phone);
                        $('#dob').html(displayDate(res[key].cdob));
                        $('#anni_date').html(displayDate(res[key].canniversary));
                        $('#cprefer ').html(res[key].cnote);
                        $('#cserv_note ').html(res[key].app_note);
                    
                    }  else if(type == 'leave') {
                        $('#rej_lid').val(res[0].fld_lid);
                        $('#rej_person').val(res[0].fld_lperson);
                        $('#leavedate').val(res[0].fld_ldate);

                        $('#rej_requ_person').val(res[0].fld_lperson);
                        $('#requ_leavedate').val(res[0].fld_ldate);
                        $('#rej_requ_reason').val(res[0].fld_req_reject);
                    
                    } else if(type == 'appointment') {

                        var key = Object.keys(res);
                        $('#appo_id').html(res[key].app_id);
                        $('#book_date').html(displayDateOnly(res[key].book_date));
                        $('#app_date').html(displayDate(res[key].app_date)+'<br>'+ TimeAlign(res[key].app_time ));
                        $('#app_name').html(res[key].app_name+' '+res[key].app_lname);
                        $('#app_number').html(res[key].app_phone);
                        $('#app_email').html(res[key].app_email);
                        $('#app_paymode').html(res[key].app_paymode);
                        $('#app_dob').html(displayDate(res[key].cdob));
                        var tbody = '';
                        var rate = 0;
                        
                        var servData = arrayAlign(res[key].serv_data);
                        for (var i = 0; i < servData.length; i++) {
                            
                            var value = servData[i];
                            if(i == 0) { var starttime = value[3]; }
                            if(i > 0) { starttime = endtime; }
                            var endtime = DisplayTime(starttime, parseFloat(value[1]));
                            var courtname = (value[0] == 'courtA') ? 'Court A' : 'Court B';

                            tbody += '<tr class="text-center"> <td width="30%">' + courtname + '</td> <td width="30%">' + value[1] + ' mins</td> <td width="30%">' + starttime + ' - ' + endtime + '</td> <td width="30%">' + (value[2] / 1.18).toFixed(2) + '</td> </tr>';
                            rate += parseFloat((value[2] / 1.18).toFixed(2));
                        }
                        var subtotal = rate.toFixed(2);
                        var gst = (parseFloat(res[key].app_gst) || 0).toFixed(2);
                        var total =  (parseFloat(subtotal+gst)).toFixed(2);
                        var tfoot = '<tr class="table-info text-center"> ' +
                                        '<td colspan="3" align="right"> <b>SUBTOTAL: </b></td> ' +
                                        '<td> <b>' + subtotal + '</b> </td>  </tr>';

                        if (res[key].app_cpamt > 0) {
                            tfoot += '<tr class="table-info text-center">' +
                                '<td colspan="3" align="right"> <b>DISCOUNT ('+res[key].coup_perc+'%): </b></td> ' +
                                '<td> <b>' + res[key].app_cpamt + '</b> </td> </tr>';
                        }
                      tfoot += '<tr class="table-info text-center"> ' +
                                '<td colspan="3" align="right"> <b>GST AMOUNT (18%) : </b></td> ' +
                                '<td> <b>' + gst + '</b> </td>' + 
                                '</tr>' + 
                            '<tr class="table-info text-center"> ' +
                                '<td colspan="3" align="right"> <b>TOTAL : </b></td> ' +
                                '<td> <b>' + (parseFloat(subtotal) + parseFloat(gst)).toFixed(2) + '</b> </td>' + 
                            '</tr>' ;

                        tfoot += '<tr class="table-info text-center"> ' +
                            '<td colspan="3" align="right"> <b>PAID: </b></td> ' +
                            '<td> <b>' + (res[key].app_paid) + '</b> </td>' + 
                            '</tr>' + 

                            '<tr class="table-info text-center"> ' +
                            '<td colspan="3" align="right"> <b>BALANCE: </b></td> ' +
                            '<td> <b>' + (parseFloat(res[key].app_balance) <= 0 ? 0 : res[key].app_balance) + '</b> </td> </tr>';

                        $('#servbody').append(tbody);
                        $('#servfoot').append(tfoot);
                    }
                }
            }
        });
    }

</script>
