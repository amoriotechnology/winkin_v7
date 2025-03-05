<style type="text/css">
    .overflow { max-width: 200px; word-wrap: break-word; word-break: break-word; }
</style>

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Coupons</h1>
            </div>
        </div>
        <!-- Page Header Close -->

        <!--Start:: row-7 -->
        <div class="row">
            <div class="col-md-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title d-flex gap-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#couponModal"> 
                                <i class="bi bi-plus"></i> Add Coupons
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="coupon_list" class="table table-bordered table-hover w-100">
                                <thead class="table-dark">
                                    <tr class="text-center">
                                        <th width="3%">S.No</th>
                                        <th>Coupon Name</th>
                                        <th>Expiry Date</th>
                                        <th>Percentage</th>
                                        <th>Limit</th>
                                        <th>Used</th>
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

    var edit_cate = "<?= (!empty($edit_cate) ? true : false); ?>";
    if(edit_cate > 0) { $('#couponModal').modal('show'); }

    /* ------------------------ Model ajax for delete leave ---------------------- */
    $("body").on('click', '.update_cp_btn', function () {
        
        var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
        var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
        var status = $(this).data('status');
        var coloum = $(this).data('type');

        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, "+status+" it!",
        }).then((e) => {

        if (e.isConfirmed) {
            $.ajax({
                url: '<?= base_url('common_update'); ?>',
                type: 'post',
                data: { [csrfName]: csrfHash, id:$(this).data('id'), type:status, coloum:coloum, table:'coupon' },
                dataType: 'json',
                success: function(res) { 
                    Swal.fire({
                        title : "Success!", 
                        text : "Coupons has been "+status+".", 
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


    if ($.fn.DataTable.isDataTable('#coupon_list')) {
        $('#coupon_list').DataTable().clear().destroy();
    }

    $('#coupon_list').DataTable({
        responsive: !0,
        "processing": true,
        "serverSide": true,
        "lengthMenu":[[10,25,50,100], [10,25,50,100]],
        "ajax": {
           "url": "<?= base_url('getcouponDatas'); ?>",
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
            { "data": "fld_cpid" },
            { "data": "fld_cpname", "className": "style-column"},
            { "data": "fld_cp_expdate" },
            { "data": "fld_cp_percentage"},
            { "data": "fld_cplimit"},
            { "data": "fld_cpused"},
            { "data": "fld_cpstatus"},
            { "data": "action" },
        ],
        "order": [[0, "desc"]],
        "columnDefs": [
            { "orderable": false, "targets": [0, 4] }
        ],
        "paging": true, 
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
                "title": "Coupon Report",
                "className": "btn-sm",
                "orientation": "landscape",
                "pageSize": "A4",
                "exportOptions": {
                    "columns": function(idx, data, node) {
                        return $(node).index() !== $(node).closest('tr').find('td, th').length - 1; 
                    }
                },
            },
            {
                    "extend": "colvis",
                    "className": "btn-sm",
                    "exportOptions": { "columns": ':visible' }
            },
            {
                "extend": "pdf",
                "title": "Coupon Report",
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

                            doc.pageMargins = [20, 20, 20, 20]; 

                            doc.defaultStyle.fontSize = 8; 
                            doc.content[1].table.body.forEach(function(row) {
                                row.forEach(function(cell) {
                                    cell.fontSize = 8;
                                });
                            });

                            doc.styles.tableHeader = {
                                alignment: 'center',
                                bold: true,
                                fontSize: 10,
                                fillColor: '#f3f3f3'
                            };

                            doc.styles.tableBodyOdd = { alignment: 'center' };
                            doc.styles.tableBodyEven = { alignment: 'center' };

                            doc.styles.tableBody = {
                                alignment: 'center'
                            };
                        }
                    }
            },
            {
                "extend": "print",
                "title": "Coupon Report",
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
        ],
        "createdRow": function(row, data, dataIndex) {
            var today = new Date();
            var expdate = new Date(data.fld_exp_date);
            if ((today > expdate) || (data.fld_sts == 'Deactive')) {
                $(row).addClass('table-danger');
            }
        }
    });

});
</script>