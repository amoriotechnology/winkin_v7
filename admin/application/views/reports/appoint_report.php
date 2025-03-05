<style type="text/css">
    .bg-completesuccess{
        background-color: #8274FF !important;
    }
</style>
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Bookings</h1>
            </div>
        </div>
        <!-- Page Header Close -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <a href="<?php echo base_url('court_status'); ?>" class="btn btn-primary"><i class="bi bi-plus"></i> New Booking</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="row d-flex justify-content-end">
                                <div class="col-xl-4 col-md-12 col-sm-12">
                                    <div class="input-group">
                                        <input type="text" name="datefilter" id="datefilter" class="form-control datefilter" placeholder="Search date">
                                        <a href="<?= base_url('bookings') ?>" id="search" class="btn btn-primary">Refresh</a>
                                    </div>
                                </div>
                            </div>
                            <table id="booking_list" class="table table-bordered table-hover text-nowrap w-100">
                                <thead class="table-dark">
                                    <tr class="filter-row">
                                        <td>Advanced <br> Search</td>
                                        <td><input type="text" class="column-search form-control"></td>
                                        <td><input type="text" class="column-search form-control"></td>
                                        <td><input type="text" class="column-search form-control"></td>
                                        <td><input type="text" class="column-search form-control"></td>
                                        <td><input type="text" class="column-search form-control"></td>
                                        <td><input type="text" class="column-search form-control"></td>
                                        <td><input type="text" class="column-search form-control"></td>
                                        <td><input type="text" class="column-search form-control"></td>
                                        <td><input type="text" class="column-search form-control"></td>
                                        <td><input type="text" class="column-search form-control"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Booking ID</th>
                                        <th>Booking Date</th>
                                        <th>Slot Date</th>
                                        <th>Slot Time</th>
                                        <th>Court</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Pay Mode</th>
                                        <th>Amount(₹)</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<!-- End::content  -->


<script type="text/javascript">
    $(document).ready(function() {

        $("#datefilter").daterangepicker({
            locale: { format: 'DD/MM/YYYY' },
        });

        var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
        var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

        var edit_appoint = "<?= (!empty($edit_appoint) ? true : false); ?>";
        if(edit_appoint > 0) {
            $('#AppointmentModal').modal('show');
        }
 
        // Release and Confirm on change by the Admin , when the booking is empty
        function handleStatusAction(id,status, inputLabel = '', inputPlaceholder = '') {
            let swalOptions = {
                showCancelButton: true,
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
            };
            if (status === 'admin_update') {
                swalOptions.title = 'Select Payment Mode';
                    swalOptions.input = 'select'; 
                    swalOptions.inputPlaceholder = inputPlaceholder || 'Select the payment mode';
                    swalOptions.inputOptions = {
                        'Cash': 'Cash',
                        'Upi': 'Upi',
                        'Online': 'Online',
                    };
                swalOptions.preConfirm = (paymentMode) => {
                    if (!paymentMode) {
                        Swal.showValidationMessage('Please enter a payment mode');
                    } else {
                        sendAjaxRequest(status,{ id: id, paymentMode: paymentMode });
                    }
                };
            } else if (status === 'Cancelled') {
                swalOptions.title = 'Are you sure?';
                swalOptions.text = 'Do you really want to cancel?';
                swalOptions.icon = 'warning';
                swalOptions.confirmButtonText = 'Yes, Cancel it!';
                swalOptions.cancelButtonText = 'No, Keep it';
                swalOptions.preConfirm = (paymentMode) => {
                    if (!paymentMode) {
                        Swal.showValidationMessage('Please enter a payment mode');
                    } else {
                        sendAjaxRequest(status,{ id: id, paymentMode: paymentMode });
                    }
                };
            }
            Swal.fire(swalOptions);
        }

        function sendAjaxRequest(status, data = {}) {
            var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
            var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
            $.ajax({
                url: '<?= base_url('common_update'); ?>',
                type: 'post',
                data: { [csrfName]: csrfHash,  type:status,...data, coloum:'fld_astatus', table:'update_status' },
                dataType: 'json',
                success: function(res) { 
                    if(status == 'admin_update'){
                        status ='Confirmed';
                    }
                    AlertPopup('Success!', "Booking status updated as "+status+"!!!", 'success', 'Ok', '');
                }
            });
        }
        
   $("body").on('click', ".release_confirm", function() {
            var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
            var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
            var status = $(this).data('status');
            var id = $(this).data('id');
            if (status === 'admin_update') {
                handleStatusAction(id,'admin_update', 'Payment Mode', 'Enter the payment mode');
            } else if (status === 'Release') {
                handleStatusAction(id,'Cancelled');
            }
        });


        /* ----- Update booking Status ----- */
        $("body").on('click', ".update_booking", function() {
            
            var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
            var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
            var status = $(this).data('status');
            if (status === 'Release') {
                handleStatusAction('Release', 'Payment Mode', 'Enter the payment mode');
            } else if (status === 'Cancel') {
                handleStatusAction('Cancel');
            }
            $.ajax({
                url: '<?= base_url('common_update'); ?>',
                type: 'post',
                data: { [csrfName]: csrfHash, id: $(this).data('id'), type:status, coloum:'fld_astatus', table:'appoint' },
                dataType: 'json',
                success: function(res) { 
                    AlertPopup('Success!', "Booking status updated as "+status+"!!!", 'success', 'Ok', '');
                }
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
            confirmButtonText: "Yes, Cancelled it!",
          }).then((e) => {

            if (e.isConfirmed) {
                
                $.ajax({
                    url: '<?= base_url('common_update'); ?>',
                    type: 'post',
                    data: { [csrfName]: csrfHash, id: $(this).data('id'), type:'Cancelled', coloum:'fld_astatus', table: 'appoint' },
                    dataType: 'json',
                    success: function(res) { 
                        Swal.fire({
                            title : "Cancelled!", 
                            text : "Your appointment has been cancelled.", 
                            icon : "success",
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            if(result.isConfirmed) {
                                location.reload();
                            }
                        }); 
                    }
                });
            }

          });
        });


        if ($.fn.DataTable.isDataTable('#booking_list')) {
            $('#booking_list').DataTable().clear().destroy();
        }
        
        var table =  $('#booking_list').DataTable({
            responsive: 0,
            "processing": true,
            "serverSide": true,
            "lengthMenu":[[10,25,50,100],[10,25,50,100]],
            "ajax": {
                "url": "<?= base_url('getbookingsDatas'); ?>",
                "type": "POST",
               "data": function(d) {
                  d['<?= $this->security->get_csrf_token_name(); ?>'] = '<?= $this->security->get_csrf_hash(); ?>';
                  d['datefilter'] = $('#datefilter').val();
                    $('#booking_list .column-search').each(function() {
                        var columnIndex = $(this).parent().index();
                        if (this.value) {
                            d['search_columns[' + columnIndex + ']'] = this.value;
                        }
                    });
               },
               "dataSrc": function(json) {
                   csrfHash = json['<?= $this->security->get_csrf_token_name(); ?>'];
                  return json.data;
               }
            },
            "columns": [
                 { "data": "fld_aid" },
                 { "data": "fld_appointid", "className": "style-column" },
                 { "data": "fld_booked_date", "className": "style-column"},
                 { "data": "fld_adate", "className": "style-column"},
                 { "data": "fld_atime", "className": "style-column"},
                 { "data": "fld_aserv", "className": "style-column"},
                 { "data": "fld_name", "className": "style-column"},
                 { "data": "fld_phone" },
                 { "data": "fld_apaymode" },
                 { "data": "fld_arate" },
                 { "data": "status" },
                 { "data": "action" },
            ],
            "order": [[0, "desc"]],
            "columnDefs": [
                { "orderable": false, "targets": "_all" }
            ],
            "pageLength": 10,
            "colReorder": true,
            "stateSave": true,
            "stateSaveCallback": function(settings, data) {
                localStorage.setItem('bookings', JSON.stringify(data));
            },
            "stateLoadCallback": function(settings) {
                var savedState = localStorage.getItem('bookings');
                return savedState ? JSON.parse(savedState) : null;
            },
           "dom": "<'row'<'col-sm-4 mt-2'l><'col-sm-4 mt-2 d-flex justify-content-center align-items-center text-center'B><'col-sm-4  mt-2'f>>" + "<'row'<'col-sm-12 mt-2'tr>>" + "<'row'<'col-sm-6 mt-2'i><'col-sm-6 mt-2'p>>",
            "buttons": [
                {
                    "extend": "excel",
                    "title": "Booking Report",
                    "className": "btn-sm",
                    "exportOptions": { 
                        "columns": function(idx, data, node) {
                            return $(node).index() !== $(node).closest('tr').find('td, th').length - 1; 
                        }
                    }
                },
                {
                    "extend": "pdf",
                    "title": "Booking Report",
                    "className": "btn-sm",
                    "orientation": "landscape",
                    "pageSize": "A4",
                    "exportOptions": {
                        "columns": function(idx, data, node) {
                            return $(node).index() !== $(node).closest('tr').find('td, th').length - 1; 
                        }
                    },
                    "customize": function(doc) {
                        if (doc.content.length > 1 && doc.content[1].table) {
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('*');
                            doc.content[1].layout = {
                                hLineWidth: function(i, node) { return 0.5; }, 
                                vLineWidth: function(i, node) { return 0.5; }, 
                                hLineColor: function(i, node) { return '#aaa'; }, 
                                vLineColor: function(i, node) { return '#aaa'; }, 
                                paddingLeft: function(i, node) { return 5; },
                                paddingRight: function(i, node) { return 5; },
                                paddingTop: function(i, node) { return 3; },
                                paddingBottom: function(i, node) { return 3; }
                            };

                            doc.pageMargins = [10, 10, 10, 10];

                            doc.styles.tableHeader = {
                                alignment: 'center',
                                valign: 'middle',
                                bold: true,
                                fontSize: 12,
                                fillColor: '#f3f3f3' 
                            };

                            doc.styles.tableBodyOdd = { alignment: 'center', valign: 'middle' };
                            doc.styles.tableBodyEven = { alignment: 'center', valign: 'middle' };

                            doc.defaultStyle.fontSize = 10;
                        }
                    }
                },
                {
                "extend": "print",
                "title": "Booking Report",
                "className": "btn-sm",
                "exportOptions": { 
                    "columns": function(idx, data, node) {
                        return $(node).index() !== $(node).closest('tr').find('td, th').length - 1; 
                    }
                },
                "customize": function(win) {
                    $(win.document.body)
                        .css('font-size', '10px')
                        .css('text-align', 'center')
                        .css('margin', '0')
                        .css('padding', '0');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit')
                        .css('width', '100%'); 

                    $(win.document.body).find('h1')
                        .css('font-size', '16px')
                        .css('text-align', 'center')
                        .css('margin', '0 0 10px 0');

                    var rows = $(win.document.body).find('table tbody tr');
                    rows.each(function() {
                        if ($(this).find('td').length === 0) { $(this).remove(); }
                    });

                    var css = '@page { size: landscape; }';
                    var style = document.createElement('style');
                    style.type = 'text/css';
                    style.media = 'print';
                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(document.createTextNode(css));
                    }
                    win.document.head.appendChild(style);

                    $(win.document.body).find('div:last-child').css('page-break-after', 'auto');
                }
            },
             {
                "extend": "colvis",
                "className": "btn-sm",
                "exportOptions": { "columns": ':visible' }
            },

            ],
        });

        $('#datefilter').on('change', function() {
            table.draw();
        });
        
        $('#booking_list thead').on('keyup change', '.column-search', function() {
            table.draw();
        });

    });
</script>

<script src="<?= base_url('../assets/js/cal_scroll.js'); ?>"></script>

<!-- Date & Time Picker JS -->
<script src="<?= base_url('../assets/libs/flatpickr/flatpickr.min.js'); ?>"></script>
