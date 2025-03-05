<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Manage Logs</h1>
            </div>


        </div>
        <!-- Page Header Close -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="row d-flex justify-content-end">
                                <div class="col-xl-5 col-md-12 col-sm-12">
                                    <div class="input-group">
                                        <input type="text" name="datefilter" id="datefilter" class="form-control datefilter" placeholder="Search date">
                                        <a href="<?= base_url('revenue') ?>" id="search" class="btn btn-primary">Refresh</a>
                                    </div>
                                </div>
                            </div>
                            <table id="logs_list" class="table table-bordered table-hover text-nowrap w-100">
                                <thead class="table-dark">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Username</th>
                                        <th>Module</th>
                                        <th>Details</th>
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
var logDataTable;
    $(document).ready(function() {
        $("#datefilter").daterangepicker({
            locale: { format: 'DD/MM/YYYY' },
        });
        var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
        var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

        if ($.fn.DataTable.isDataTable('#logs_list')) {
            $('#logs_list').DataTable().clear().destroy();
        }
        
        logDataTable =  $('#logs_list').DataTable({
            responsive: 0,
            "processing": true,
            "serverSide": true,
            "lengthMenu":[[10,25,50,100],[10,25,50,100]],
            "ajax": {
                "url": "<?= base_url('getlogDatas'); ?>",
                "type": "POST",
               "data": function(d) {
                  d['<?= $this->security->get_csrf_token_name(); ?>'] = '<?= $this->security->get_csrf_hash(); ?>';
                  d['datefilter'] = $('#datefilter').val();
               },
               "dataSrc": function(json) {
                   csrfHash = json['<?= $this->security->get_csrf_token_name(); ?>'];
                  return json.data;
               }
            },
            "columns": [
                { 
                    "data": "id",
                    "render": function(data, type, row) {
                        return '<i class="bi bi-caret-right-fill"></i> ' + data;
                    }
                },
                { "data": "c_date", "className": "style-column" },
                { "data": "c_time", "className": "style-column" },
                { "data": "username", "className": "style-column" },
                { "data": "module", "className": "style-column" },
                { "data": "details", "className": "style-column" }
            ],
            "order": [[0, "desc"]],
            "columnDefs": [
                { "orderable": false, "targets": [0, 5] }
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
                    "title": "Log Reports",
                    "className": "btn-sm",
                    "exportOptions": { 
                        "columns": function(idx, data, node) {
                            return $(node).index() !== $(node).closest('tr').find('td, th').length - 1; 
                        }
                    }
                },
                {
                    "extend": "pdf",
                    "title": "Log Reports",
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
                "title": "Log Reports",
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

            ]
        });
        
        $('#logs_list tbody').on('click', 'tr', function() {
        var accordionRow = $(this).next('.accordion-row');
        if (accordionRow.length) {
            accordionRow.toggle();
        } else {
            var data = logDataTable.row(this).data(); 
            console.log(data);
            var detailsHtml = `
                <tr class="accordion-row">
                  <td colspan="7">
                     <div class="row">
                        <div class="col-md-6" style="display: flex; justify-content: start">
                           <strong>Information:</strong>&nbsp;
                           <p> ${data.details || ''} ${data.field_id ? ' | <strong>' + data.field_id + '</strong>' : ''} </p>
                        </div>
                     </div>
                  </td>
               </tr>
            `;
            $(this).after(detailsHtml);
        }
    });
    

    $('#datefilter').on('change', function() {
        logDataTable.draw();
    });

});
</script>

<script src="<?= base_url('../assets/js/cal_scroll.js'); ?>"></script>

<!-- Date & Time Picker JS -->
<script src="<?= base_url('../assets/libs/flatpickr/flatpickr.min.js'); ?>"></script>

<!-- Vanilla-Wizard JS -->
<script src="<?= base_url('../assets/libs/vanilla-wizard/js/wizard.min.js'); ?>"></script>

<!-- Internal Form Wizard JS -->
<link rel="modulepreload" href="<?= base_url('../assets/js/form-wizard-init.js'); ?>" />
<script type="module" src="<?= base_url('../assets/js/form-wizard-init.js'); ?>"></script>
<script src="<?= base_url('../assets/js/form-wizard.js'); ?>"></script>
