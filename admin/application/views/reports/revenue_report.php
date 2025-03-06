<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
        </div>
        <!-- Page Header Close -->
        <!--Start:: row-7 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                           <div class="row d-flex justify-content-end">
                                <div class="col-12 text-end">
                                    <label for="datefilter" class="fw-bold" style="position: relative; right: 13em;">Search by Payment Date</label>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <div class="input-group" style="max-width: 25em;">
                                        <input type="text" name="datefilter" id="datefilter" class="form-control datefilter" placeholder="Search date">
                                        <a href="<?= base_url('revenue') ?>" id="search" class="btn btn-primary">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <table id="revenue_list" class="table table-bordered table-hover text-nowrap w-100">
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
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>S.No</th>
                                        <th>Booking Date</th>
                                        <th>Slot Date</th>
                                        <th>Booking ID</th>
                                        <th>Area</th>
                                        <th>Name</th>
                                        <th>Phone No.</th>
                                        <th>Pay mode</th>
                                        <th>Payment Date</th>
                                        <th>Amount(₹)</th>
                                        <th>GST Amount(₹)</th>
                                        <th>Total Amount(₹)</th>
                                    </tr>
                                </thead> 
                                <tfoot>
                                    <tr>
                                        <th colspan="9" style="font-weight: bold; text-align: right !important;">Total</th>
                                        <th id="totalAmount" style="font-weight: bold">0.00</th>
                                        <th id="totalGST" style="font-weight: bold">0.00</th>
                                        <th id="totalTotal" style="font-weight: bold">0.00</th>
                                    </tr>
                                </tfoot>                   
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
var revenueReport;
$(document).ready(function() {
    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
    $("#datefilter").daterangepicker({
        locale: { format: 'DD/MM/YYYY' },
    });
    if ($.fn.DataTable.isDataTable('#revenue_list')) {
        $('#revenue_list').DataTable().clear().destroy();
    }
    revenueReport = $('#revenue_list').DataTable({
        responsive: 0,
        "processing": true,
        "serverSide": true,
        "lengthMenu":[[10,25,50,100], [10,25,50,100]],
        "ajax": {
           "url": "<?= base_url('getrevenueDatas'); ?>",
           "type": "POST",
           "data": function(d) {
              d['<?= $this->security->get_csrf_token_name(); ?>'] = '<?= $this->security->get_csrf_hash(); ?>';
              d['datefilter'] = $('#datefilter').val();
                $('#revenue_list .column-search').each(function() {
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
            { "data": "fld_adate", "className": "style-column"},
            { "data": "fld_appointid", "className": "style-column"},
            { "data": "fld_aserv", "className": "style-column"},
            { "data": "fld_name" },
            { "data": "fld_phone" },
            { "data": "fld_apaymode" },
            { "data": "fld_pdate" },
            { "data": "fld_arate" , "className": "style-column"},
            { "data": "fld_gst_amt" },
            { "data": "fld_atotal" },
        ],
        "order": [[0, "desc"]],
        "columnDefs": [
            { "orderable": false, "targets": "_all" }
        ],
        "pageLength": 10,
        "colReorder": true,
        "stateSave": true,
        "stateSaveCallback": function(settings, data) {
            localStorage.setItem('staff', JSON.stringify(data));
        },
        "stateLoadCallback": function(settings) {
            var savedState = localStorage.getItem('staff');
            return savedState ? JSON.parse(savedState) : null;
        },
       "dom": "<'row'<'col-sm-4 mt-2'l><'col-sm-4 mt-2 d-flex justify-content-center align-items-center text-center'B><'col-sm-4  mt-2'f>>" + "<'row'<'col-sm-12 mt-2'tr>>" + "<'row'<'col-sm-6 mt-2'i><'col-sm-6 mt-2'p>>",
        "buttons": [
            {
                "extend": "excel",
                "title": "Revenue Report",
                "className": "btn-sm",
                "exportOptions": { "columns": ':visible' }
            },
            {
                "extend": "pdf",
                "title": "Revenue Report",
                "className": "btn-sm",
                "orientation": "landscape",
                "pageSize": "A4",
                "customize": function(doc) {
                    if (doc.content.length > 1 && doc.content[1].table) {
                        let tableBody = doc.content[1].table.body;
                        doc.content[1].table.widths = Array(tableBody[0].length).fill('*');
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
                            bold: true,
                            fontSize: 9,
                            fillColor: '#f3f3f3' 
                        };
                        doc.styles.tableBodyOdd = { alignment: 'center' };
                        doc.styles.tableBodyEven = { alignment: 'center' };
                        doc.defaultStyle.fontSize = 9;
                        let totalAmount = $('#totalAmount').text();
                        let totalGST = $('#totalGST').text();
                        let totalTotal = $('#totalTotal').text();
                        let footerRow = [
                            { text: 'Total', alignment: 'right', bold: true, colSpan: 7 }, '', '', '', '', '', '',
                            { text: totalAmount, alignment: 'center', bold: true },
                            { text: totalGST, alignment: 'center', bold: true },
                            { text: totalTotal, alignment: 'center', bold: true }
                        ];
                        tableBody.push(footerRow);
                    }
                }
            },
            {
                "extend": "print",
                "title": "Revenue Report",
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
                    var api = $('#revenue_list').DataTable();
                    var totalAmount = api.column(9).data().reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);
                    var totalGST = api.column(10).data().reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);
                    var totalTotal = api.column(11).data().reduce(function(a, b) {
                        console.log(totalTotal);
                        return parseFloat(a) + parseFloat(b);
                    }, 0);
                    var footerRow = `
                        <tr style="font-weight: bold;">
                            <td colspan="8" style="font-weight: bold;text-align: right !important;">Total</td>
                            <td style="font-weight: bold;">${totalAmount.toFixed(2)}</td>
                            <td style="font-weight: bold;">${totalGST.toFixed(2)}</td>
                            <td style="font-weight: bold;">${totalTotal.toFixed(2)}</td>
                        </tr>
                    `;
                    $(win.document.body).find('table tbody').append(footerRow);
                    $(win.document.body).find('div:last-child').css('page-break-after', 'auto');
                }
            },
            {
                "extend": "colvis",
                "className": "btn-sm",
                "exportOptions": { "columns": ':visible' }
            },
        ],
         "footerCallback": function(row, data, start, end, display) {
            var api = this.api();
            var totalAmount = api.column(9).data().reduce(function(a, b) {
                return parseFloat(a) + parseFloat(b);
            }, 0);
            var totalGST = api.column(10).data().reduce(function(a, b) {
                return parseFloat(a) + parseFloat(b);
            }, 0);
            var totalTotal = api.column(11).data().reduce(function(a, b) {
                return parseFloat(a) + parseFloat(b);
            }, 0);
            $(api.column(9).footer()).html(totalAmount.toFixed(2));
            $(api.column(10).footer()).html(totalGST.toFixed(2));
            $(api.column(11).footer()).html(totalTotal.toFixed(2));
        }
    });

    $('#datefilter').on('change', function() {
        revenueReport.draw();
    });
    $('#revenue_list thead').on('keyup change', '.column-search', function() {
        revenueReport.draw();
    });
});
</script>