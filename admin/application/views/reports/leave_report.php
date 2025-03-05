<style type="text/css">
    .overflow { max-width: 200px; word-wrap: break-word; word-break: break-word; }
</style>

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Leaves</h1>
            </div>
        </div>
        <!-- Page Header Close -->

        <!--Start:: row-7 -->
        <div class="row">
            <div class="col-md-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title d-flex gap-2">
                            <button type="button" class="btn btn-primary" data-bs-effect="effect-flip-vertical" data-bs-toggle="modal" data-bs-target="#LeaveModal" > 
                                <i class="bi bi-plus"></i> Add Leave
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="leave_list" class="table table-bordered table-hover w-100">
                                <thead class="table-dark">
                                    <tr class="text-center">
                                        <th width="3%">S.No</th>
                                        <th>Applied Date</th>
                                        <th>Leave From & To Date</th>
                                        <th>Staff ID</th>
                                        <th>Name</th>
                                        <th>Reason</th>
                                        <th>Rejection Reason</th>
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
        <!--End:: row-7 -->
        
    </div>
</div>
<!-- End::content  -->



<script type="text/javascript">

    $(document).ready(function() {

        var edit_leave = "<?= (!empty($edit_leave) ? true : false); ?>";
        if(edit_leave > 0) { $('#LeaveModal').modal('show'); }

        $('input[name=leave_date]').on('focus', function() {

            $('#leavevalidate').html('');
            $('#leave_submit').removeAttr('disabled');

            $('input[name=leave_date]').daterangepicker({

                locale: { format: 'MMM DD/YYYY' },
                minDate: moment().startOf('day'),

            }).on('apply.daterangepicker', function(ev, picker) {

                var ids = $('#person').val().split("|");
                var staffid = ids[1];
                var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
                var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

                if(picker != undefined) {
                    
                    var leavestart = picker.startDate.format('YYYY-M-DD');
                    var leaveend = picker.endDate.format('YYYY-M-DD');
                
                } else if(picker == undefined) {

                    var leaveDate = $(this).val();
                    var splitdate = leaveDate.split(' to ');
                    var leavestart = dbDate(splitdate[0]);
                    var leaveend = dbDate(splitdate[1]);
                }

                $.ajax({
                    url: '<?= base_url('leave_check'); ?>',
                    type: 'POST',
                    data: { [csrfName]: csrfHash, id: staffid, startdate : leavestart, enddate: leaveend },
                    dataType: 'json',
                    success:function(res) {
                        if(res != "") {
                            $('#leavevalidate').html(res);
                            $('#leave_submit').attr('disabled', 'disabled');
                        }
                    }
                });

            });

        });


        if ($.fn.DataTable.isDataTable('#leave_list')) {
            $('#leave_list').DataTable().clear().destroy();
        }
        
        $('#leave_list').DataTable({
            responsive: !0,
            "processing": true,
            "serverSide": true,
            "lengthMenu":[[10,25,50,100],[10,25,50,100]],
            "ajax": {
                "url": "<?= base_url('getleaveDatas'); ?>",
                "type": "POST",
               "data": function(d) {
                  d['<?= $this->security->get_csrf_token_name(); ?>'] = '<?= $this->security->get_csrf_hash(); ?>';
               },
               "dataSrc": function(json) {
                   csrfHash = json['<?= $this->security->get_csrf_token_name(); ?>'];
                  return json.data;
               }
            },
            "columns": [
                 { "data": "fld_lid" },
                 { "data": "fld_create_date", "className": "style-column" },
                 { "data": "fld_ldate", "className": "style-column"},
                 { "data": "fld_lstaff_id" },
                 { "data": "fld_lperson", "className": "style-column" },
                 { "data": "fld_lreason" , "className": "style-column"},
                 { "data": "fld_lrej_reason" },
                 { "data": "fld_lstatus" },
                 { "data": "action" },
            ],
            "order": [[0, "desc"]],
            "columnDefs": [
                { "orderable": false, "targets": [0, 8] }
            ],
            "pageLength": 10,
            "colReorder": true,
            "stateSave": true,
            "stateSaveCallback": function(settings, data) {
                localStorage.setItem('leave', JSON.stringify(data));
            },
            "stateLoadCallback": function(settings) {
                var savedState = localStorage.getItem('leave');
                return savedState ? JSON.parse(savedState) : null;
            },
           "dom": "<'row'<'col-sm-4 mt-2'l><'col-sm-4 mt-2 d-flex justify-content-center align-items-center text-center'B><'col-sm-4  mt-2'f>>" + "<'row'<'col-sm-12 mt-2'tr>>" + "<'row'<'col-sm-6 mt-2'i><'col-sm-6 mt-2'p>>",
            "buttons": [
                {
                    "extend": "csv",
                    "title": "Leave Report",
                    "className": "btn-sm",
                    "exportOptions": { "columns": ':visible' }
                },
                {
                    "extend": "pdf",
                    "title": "Leave Report",
                    "className": "btn-sm",
                    "exportOptions": { "columns": ':visible' }
                },
                {
                    "extend": "print",
                    "title": "Leave Report",
                    "className": "btn-sm",
                    "exportOptions": { "columns": ':visible' },
                    "customize": function(win) {
                        $(win.document.body).css('font-size', '10px') .css('text-align', 'center') .css('margin', '0') .css('padding', '0');
                        $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                        $(win.document.body).find('h1').css('font-size', '16px') .css('text-align', 'center').css('margin', '0 0 10px 0');
                        var rows = $(win.document.body).find('table tbody tr');
                        rows.each(function() {
                            if ($(this).find('td').length === 0) { $(this).remove(); }
                        });
                        $(win.document.body).find('div:last-child').css('page-break-after', 'auto');
                    }
                },
            ]
        });        

    });

</script>