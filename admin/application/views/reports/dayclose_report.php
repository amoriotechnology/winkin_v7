<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Dayclose Report</h1>
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
                                        <button type="button" id="search" class="btn btn-primary">Search</button>&nbsp;
                                        <a href="<?= base_url('day_close') ?>" id="search" class="btn btn-primary">Clear</a>
                                    </div>
                                </div>
                            </div>
                            <table id="dayclose_list" class="table table-bordered table-hover text-nowrap w-100">
                                <thead class="table-dark">
                                    <tr class="text-center">
                                        <th>S.No</th>
                                        <th>Date</th>
                                        <th>Opening Balance(₹)</th>
                                        <th>Today Collection(₹)</th>
                                        <th>Cash to Bank</th>
                                        <th>Closing Balance(₹)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead> 
                                <tfoot>
                                    <tr>
                                        <th colspan="2" style="font-weight: bold; text-align: right !important;">Total</th>
                                        <th id="totalOpeningBalance" style="font-weight: bold">0.00</th>
                                        <th id="totalcollection" style="font-weight: bold">0.00</th>
                                        <th id="totalcash" style="font-weight: bold">0.00</th>
                                        <th id="totalclosingbalance" style="font-weight: bold">0.00</th>
                                        <th style="font-weight: bold"></th>
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

<div class="modal fade" id="dayclosedview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="DaycloseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="" method="post" id="day_closing">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white" id="DaycloseModalLabel">Day Closing Details</h6>
                    <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModel('')"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th width="3%" style="font-weight: bold;">S.No</th>
                                        <th style="font-weight: bold;">Payment Mode</th>
                                        <th style="font-weight: bold;">Amount (₹)</th>
                                    </tr>
                                </thead>
                                <tbody id="showdayclose"></tbody>
                                <tfoot id="showdayclose_footer"></tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
var dayCloseReport;
$(document).ready(function() {

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

   
    $("#datefilter").daterangepicker({
        locale: { format: 'MMM DD/YYYY' },
    });
    

    if ($.fn.DataTable.isDataTable('#dayclose_list')) {
        $('#dayclose_list').DataTable().clear().destroy();
    }

    dayCloseReport = $('#dayclose_list').DataTable({
    responsive: true,
    "processing": true,
    "serverSide": true,
    "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
    "ajax": {
        "url": "<?= base_url('getdaycloseDatas'); ?>",
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
        { "data": "fld_id" },
        { "data": "fld_date", "className": "style-column" },
        { "data": "fld_opening_balance", "className": "text-end" },
        { "data": "fld_amount", "className": "text-end" },
        { "data": "fld_cash_amount", "className": "text-end" },
        { "data": "fld_closing_balance", "className": "text-end" },
        { "data": "action" }
    ],
    "order": [[0, "desc"]],
    "columnDefs": [
        { "orderable": false, "targets": [0, 6] }
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
    "dom": "<'row'<'col-sm-4 mt-2'l><'col-sm-4 mt-2 d-flex justify-content-center align-items-center text-center'B><'col-sm-4  mt-2'f>>" +
           "<'row'<'col-sm-12 mt-2'tr>>" +
           "<'row'<'col-sm-6 mt-2'i><'col-sm-6 mt-2'p>>",
    "buttons": [
        {
            "extend": "excel",
            "title": "Dayclose Report",
            "className": "btn-sm",
            "exportOptions": {
                "columns": [0, 1, 2, 3, 4, 5] 
            }
        },
        {
            "extend": "pdf",
            "title": "Dayclose Report",
            "className": "btn-sm",
            "orientation": "landscape",
            "pageSize": "A4",
            "exportOptions": {
                "columns": [0, 1, 2, 3, 4, 5]
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
                        bold: true,
                        fontSize: 9,
                        fillColor: '#f3f3f3' 
                    };

                    doc.styles.tableBodyOdd = { alignment: 'center' };
                    doc.styles.tableBodyEven = { alignment: 'center' };

                    doc.defaultStyle.fontSize = 9;
                }
            }
        },
        {
                "extend": "print",
                "title": "Revenue Report",
                "className": "btn-sm",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5] 
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

                    var api = $('#dayclose_list').DataTable();

                    var totalOpeningBalance = api.column(2).data().reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                    var totalClosingBalance = api.column(3).data().reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                    var totalCollection = api.column(4).data().reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                    var totalCashToBank = api.column(5).data().reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                    var footerRow = `
                        <tr style="font-weight: bold;">
                            <td colspan="2" style="font-weight: bold;text-align: right !important;">Total</td>
                            <td style="font-weight: bold;">${totalOpeningBalance.toFixed(2)}</td>
                            <td style="font-weight: bold;">${totalClosingBalance.toFixed(2)}</td>
                            <td style="font-weight: bold;">${totalCollection.toFixed(2)}</td>
                        <td style="font-weight: bold;">${totalCashToBank.toFixed(2)}</td>
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

        var totalOpeningBalance = api.column(2).data().reduce(function(a, b) {
            return parseFloat(a) + parseFloat(b);
        }, 0);

        var totalClosingBalance = api.column(3).data().reduce(function(a, b) {
            return parseFloat(a) + parseFloat(b);
        }, 0);

        var totalCollection = api.column(4).data().reduce(function(a, b) {
            return parseFloat(a) + parseFloat(b);
        }, 0);

        var totalCashToBank = api.column(5).data().reduce(function(a, b) {
            return parseFloat(a) + parseFloat(b);
        }, 0);

        $('#totalOpeningBalance').text(totalOpeningBalance.toFixed(2));
        $('#totalcollection').text(totalClosingBalance.toFixed(2));
        $('#totalcash').text(totalCollection.toFixed(2));   
        $('#totalclosingbalance').text(totalCashToBank.toFixed(2)); 
    }

    });


    $('#search').on('click', function() {
        dayCloseReport.draw();
    });

});

// Day Close Modal
function openDaycloseModal(id) { 
    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    $.ajax({
        url: '<?= base_url('showday_closeview') ?>',
        type: 'post',
        data: { [csrfName]: csrfHash, id: id },
        dataType: 'json',
        success: function(result) {
            console.log(result);
            var html = "";
            var count = 1;
            var totalAmount = 0;

            if (result.status == 200 && result.data.length > 0) {
                $.each(result.data, function(index, item) {
                    var amount = parseFloat(item.fld_split_amt) || 0;
                    totalAmount += amount;

                    html += "<tr>";
                    html += "<td class='text-left'>" + count + "</td>";
                    html += "<td>" + item.fld_paymethod + "</td>"; 
                    html += "<td class='text-left'>" + amount.toFixed(2) + "</td>";
                    html += "</tr>";

                    count++;
                });

                var footerHtml = "<tr>";
                footerHtml += "<td colspan='2' class='fw-bold' style='text-align: right !important;'>Total:</td>";
                footerHtml += "<td class='text-left fw-bold'>" + totalAmount.toFixed(2) + "</td>";
                footerHtml += "</tr>";
            
                $('#showdayclose').html(html);
                $('#showdayclose_footer').html(footerHtml);

            } else {
                $('#showdayclose').html("<tr><td colspan='3' class='text-center'>No Data Available</td></tr>");
                $('#showdayclose_footer').html(""); 
            }

            $('#dayclosedview').modal('show');
        }
    });
}
$("#day_closing").submit(function (event) {
        event.preventDefault();
        var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
        var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
        var cashAmount = parseFloat($('#c_amount').val()) || 0;
        var prevAmount = parseFloat($('#previous_amount').val()) || 0;
        console.log(prevAmount);
        var formData = $("#day_closing").serializeArray();
        formData.push({ name: csrfName, value: csrfHash });
        if (cashAmount > prevAmount) {
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
</script>

