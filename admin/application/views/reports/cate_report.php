<style type="text/css">
    .overflow { max-width: 200px; word-wrap: break-word; word-break: break-word; }
</style>

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Category Report</h1>
            </div>
        </div>
        <!-- Page Header Close -->

        <!--Start:: row-7 -->
        <div class="row">
            <div class="col-md-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title d-flex gap-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal"> 
                                <i class="bi bi-plus"></i> Add Category
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="category_list" class="table table-bordered table-hover w-100">
                                <thead class="table-dark">
                                    <tr class="text-center">
                                        <th width="3%">S.No</th>
                                        <th>Category Name</th>
                                        <th>Category For</th>
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
    if(edit_cate > 0) { $('#categoryModal').modal('show'); }

    /* ------------------------ Model ajax for delete leave ---------------------- */
    $("body").on('click', '.update_cate_btn', function () {
        
        var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
        var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
        var status = $(this).data('status');

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
                data: { [csrfName]: csrfHash, id: $(this).data('id'), type:status, coloum : 'fld_catestatus', table: 'cate' },
                dataType: 'json',
                success: function(res) { 
                    Swal.fire({
                        title : "Success!", 
                        text : "Category has been "+status+".", 
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


    if ($.fn.DataTable.isDataTable('#category_list')) {
        $('#category_list').DataTable().clear().destroy();
    }

    $('#category_list').DataTable({
        responsive: !0,
        "processing": true,
        "serverSide": true,
        "lengthMenu":[[10,25,50,100], [10,25,50,100]],
        "ajax": {
           "url": "<?= base_url('getcategoryDatas'); ?>",
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
            { "data": "fld_cateid" },
            { "data": "fld_catename", "className": "style-column"},
            { "data": "fld_catetype" },
            { "data": "fld_catestatus" , "className": "style-column"},
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
                "extend": "csv",
                "title": "Category Report",
                "className": "btn-sm",
                "exportOptions": { "columns": ':visible' }
            },
            {
                "extend": "pdf",
                "title": "Category Report",
                "className": "btn-sm",
                "exportOptions": { "columns": ':visible' }
            },
            {
                "extend": "print",
                "title": "Category Report",
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