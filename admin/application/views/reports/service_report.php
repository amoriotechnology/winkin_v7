<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Services Report</h1>
            </div>
        </div>
        <!-- Page Header Close -->

        <!--Start:: row-7 -->
        <div class="row">
            <div class="col-md-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title d-flex gap-2">
                            <button type="button" class="btn btn-primary" onclick="editService(this);" data-bs-effect="effect-flip-vertical" data-bs-toggle="modal" data-bs-target="#serviceModal"> 
                                <i class="bi bi-plus"></i> Add Service
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="service_list" class="table table-bordered table-hover w-100">
                                <thead class="table-dark text-center">
                                    <tr class="">
                                        <th width="3%">S.No</th>
                                        <th>Category</th>
                                        <th>Service Name</th>
                                        <th>Duration</th>
                                        <th>Rate</th>
                                        <th>Service For</th>
                                        <th>Desc</th>
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
        var edit_serv = "<?= (!empty($edit_serv) ? true : false); ?>";
        if(edit_serv > 0) {
            $('#serviceModal').modal('show');
        }

        $('#service_list').DataTable({
            responsive: !0,
            "processing": true,
            "serverSide": true,
            "lengthMenu":[[10,25,50,100],[10,25,50,100]],
            "ajax": {
                "url": "<?= base_url('getserviceDatas'); ?>",
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
                 { "data": "fld_sid" },
                 { "data": "fld_scate", "className": "style-column" },
                 { "data": "fld_sname", "className": "style-column"},
                 { "data": "fld_sduration" },
                 { "data": "fld_srate", "className": "style-column" },
                 { "data": "fld_stype" , "className": "style-column"},
                 { "data": "fld_sdesc" },
                 { "data": "fld_sstatus" },
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
                localStorage.setItem('service', JSON.stringify(data));
            },
            "stateLoadCallback": function(settings) {
                var savedState = localStorage.getItem('service');
                return savedState ? JSON.parse(savedState) : null;
            },
           "dom": "<'row'<'col-sm-4 mt-2'l><'col-sm-4 mt-2 d-flex justify-content-center align-items-center text-center'B><'col-sm-4  mt-2'f>>" + "<'row'<'col-sm-12 mt-2'tr>>" + "<'row'<'col-sm-6 mt-2'i><'col-sm-6 mt-2'p>>",
            "buttons": [
                {
                    "extend": "csv",
                    "title": "Staff Info",
                    "className": "btn-sm",
                    "exportOptions": { "columns": ':visible' }
                },
                {
                    "extend": "pdf",
                    "title": "Staff Info",
                    "className": "btn-sm",
                    "exportOptions": { "columns": ':visible' }
                },
                {
                    "extend": "print",
                    "title": "Manage Staff",
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