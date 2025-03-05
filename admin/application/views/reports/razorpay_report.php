<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Razorpay Report</h1>
            </div> 
        </div>
        <!-- Page Header Close -->
        <!--Start:: row-7 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="row d-flex justify-content-end">
                                <div class="col-xl-5 col-md-12 col-sm-12">
                                    <div class="input-group">
                                        <input type="text" name="datefilter" id="datefilter" class="form-control datefilter" placeholder="Search date">
                                        <a href="<?= base_url('view_razorpay') ?>" id="search" class="btn btn-primary">Refresh</a>
                                    </div>
                                </div>
                            </div>
                            <table id="razorpay_list" class="table table-bordered table-hover text-nowrap w-100">
                                <thead class="table-dark">
                                    <tr class="filter-row">
                                        <th>Advanced<br>Search</th>
                                        <th><input type="text" class="column-search form-control"></th>
                                        <th><input type="text" class="column-search form-control"></th>
                                        <th><input type="text" class="column-search form-control"></th>
                                        <th><input type="text" class="column-search form-control"></th>
                                        <th><input type="text" class="column-search form-control"></th>
                                        <th><input type="text" class="column-search form-control"></th>
                                        <th><input type="text" class="column-search form-control"></th>
                                        <th><input type="text" class="column-search form-control"></th>
                                        <th><input type="text" class="column-search form-control"></th>
                                        <th><input type="text" class="column-search form-control"></th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>S.No</th>
                                        <th>Booking Date</th>
                                        <th>Payment Date</th>
                                        <th>Booking ID</th>
                                        <th>Name</th>
                                        <th>Phone No</th>
                                        <th>Amount ₹</th>
                                        <th>Payment ID</th>
                                        <th>Payment Method</th>
                                        <th>Payment Status</th>
                                        <th>Booking Status</th>
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
var razorpayReport;
$(document).ready(function() {
    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
    $("#datefilter").daterangepicker({
        locale: { format: 'DD/MM/YYYY' },
    });
    if ($.fn.DataTable.isDataTable('#razorpay_list')) {
        $('#razorpay_list').DataTable().clear().destroy();
    }
    razorpayReport = $('#razorpay_list').DataTable({
        responsive: 0,
        "processing": true,
        "serverSide": true,
        "lengthMenu":[[10,25,50,100], [10,25,50,100]],
        "ajax": {
           "url": "<?= base_url('getrazorpayDatas'); ?>",
           "type": "POST",
           "data": function(d) {
              d['<?= $this->security->get_csrf_token_name(); ?>'] = '<?= $this->security->get_csrf_hash(); ?>';
              d['datefilter'] = $('#datefilter').val();
                $('#razorpay_list .column-search').each(function() {
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
            { "data": "fld_bookingdate", "className": "style-column"},
            { "data": "fld_pdate", "className": "style-column"},
            { "data": "fld_appointid", "className": "style-column"},
            { "data": "fld_name", "className": "style-column"},
            { "data": "fld_phone", "className": "style-column"},
            { "data": "fld_pamt", "className": "style-column"},
            { "data": "fld_payment_id", "className": "style-column"},
            { "data": "fld_phistory", "className": "style-column"},
            { "data": "fld_apaystatus", "className": "style-column"},
            { "data": "fld_astatus", "className": "style-column"},
        ],
        "order": [[0, "desc"]],
        "columnDefs": [
            { "orderable": false, "targets": "_all" }
        ],
        "pageLength": 10,
        "colReorder": true,
        "stateSave": true,
        "stateSaveCallback": function(settings, data) {
            localStorage.setItem('razorpay', JSON.stringify(data));
        },
        "stateLoadCallback": function(settings) {
            var savedState = localStorage.getItem('razorpay');
            return savedState ? JSON.parse(savedState) : null;
        },
       "dom": "<'row'<'col-sm-4 mt-2'l><'col-sm-4 mt-2 d-flex justify-content-center align-items-center text-center'B><'col-sm-4  mt-2'f>>" + "<'row'<'col-sm-12 mt-2'tr>>" + "<'row'<'col-sm-6 mt-2'i><'col-sm-6 mt-2'p>>",
        "buttons": [
            {
                "extend": "excel",
                "title": "Razorpay Report",
                "className": "btn-sm",
                "exportOptions": { "columns": ':visible' }
            },
            {
                "extend": "pdf",
                "title": "Razorpay Report",
                "className": "btn-sm",
                "orientation": "landscape",
                "pageSize": "A4",
                "customize": function(doc) {
                    if (doc.content.length > 1 && doc.content[1].table) {
                        let tableBody = doc.content[1].table.body;

                        tableBody.forEach(row => row.shift());

                        doc.content[1].table.widths = [
                            '10%', '10%', '10%', '10%', '10%', '10%', '10%', '10%', '10%', '10%', '10%'
                        ]; 

                        doc.content[1].layout = {
                            hLineWidth: function() { return 0.5; }, 
                            vLineWidth: function() { return 0.5; }, 
                            hLineColor: function() { return '#aaa'; }, 
                            vLineColor: function() { return '#aaa'; }, 
                            paddingLeft: function() { return 3; },   
                            paddingRight: function() { return 3; },  
                            paddingTop: function() { return 2; },    
                            paddingBottom: function() { return 2; }  
                        };

                        doc.pageMargins = [5, 5, 5, 5];

                        doc.styles.tableHeader = {
                            alignment: 'center',
                            bold: true,
                            fontSize: 8,
                            fillColor: '#f3f3f3',
                            margin: [0, 2, 0, 2],
                        };

                        doc.styles.tableBodyOdd = { alignment: 'center', fontSize: 7 };
                        doc.styles.tableBodyEven = { alignment: 'center', fontSize: 7 };
                        doc.defaultStyle.fontSize = 7;

                        doc.styles.title = {
                            fontSize: 14,
                            bold: true,
                            alignment: 'center',
                            margin: [0, 0, 0, 5]
                        };
                    }
                }
            },
            {
                "extend": "print",
                "title": "Razorpay Report",
                "className": "btn-sm",
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

    $('#datefilter').on('change', function() {
        razorpayReport.draw();
    });
    $('#razorpay_list thead').on('keyup change', '.column-search', function() {
        razorpayReport.draw();
    });
});
</script>