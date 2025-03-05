<style type="text/css">
    tr,th,td{
        text-align: center;
    }
   
    .custname {
        background-color: #fff !important;
        color: #000 !important;
    }

    ul {
        margin-top: 0;
        margin-bottom: 1rem;
        list-style: none;
    }
}
</style>
<!-- Start::app-content -->
<div class="main-content landing-main px-0">
    <div class="landing-banner" id="home">
        <section class="section">
            <div class="container main-banner-container pb-lg-0">
                <div class="row">
                   <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10">
                        <div style="padding-top: 8rem !important;" class="py-lg-5">
                            <div class="mb-3">
                                <h6 class="fw-medium op-9" style="color: #000;">Winkin's Pickle Ball Zone</h6>
                            </div>
                            <p class="landing-banner-heading mb-3">My Bookings</p>
                            <div class="fs-16 mb-5 op-7" style="color: #000;">Manage your reservations effortlessly – your schedule, your way!</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="container">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">My Booking(s)</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="custbooking_list" class="table table-bordered table-hover text-nowrap w-100">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="alignment">S.No</th>
                                        <th class="alignment">Booking ID</th>
                                        <th class="alignment">Booking Date </th>
                                        <th class="alignment">Slot Date</th>
                                        <th class="alignment">Slot Time</th>
                                        <th class="alignment">Court Name</th>
                                        <th class="alignment">Paymode</th>
                                        <th class="alignment">Rate</th>
                                        <th class="alignment">Status</th>
                                        <th class="alignment">Action</th>
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
<br> <hr>
<!-- End::content  -->


<script type="text/javascript">
$(document).ready(function() {

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    var edit_appoint = "<?= (!empty($edit_appoint) ? true : false); ?>";
    if(edit_appoint > 0) {
        $('#AppointmentModal').modal('show');
    }

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
                data: { [csrfName]: csrfHash, id: $(this).data('id'), type: 'Cancelled', coloum : 'astatus', table: 'appoint' },
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


    if ($.fn.DataTable.isDataTable('#custbooking_list')) {
        $('#custbooking_list').DataTable().clear().destroy();
    }
    
    $('#custbooking_list').DataTable({
        responsive: !0,
        "processing": true,
        "serverSide": true,
        "lengthMenu":[[10,25,50,100],[10,25,50,100]],
        "ajax": {
            "url": "<?= base_url('getcustbookingsDatas'); ?>",
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
             { "data": "fld_aid" },
             { "data": "fld_appointid", "className": "style-column" },
             { "data": "fld_booked_date", "className": "style-column"},
             { "data": "fld_adate", "className": "style-column"},
             { "data": "fld_atime", "className": "style-column"},
             { "data": "fld_aserv", "className": "style-column"},
             { "data": "fld_apaymode" },
             { "data": "fld_arate" },
             { "data": "fld_astatus" },
             { "data": "action" },
        ],
        "order": [[0, "desc"]],
        "columnDefs": [
            { "orderable": false, "targets": [0,8] }
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
    });
});

$(document).ready(function() {

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    $("body").on('click', '.cancel-confirm', function () {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#3085D6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Cancel it!",
      }).then((e) => {
        if (e.isConfirmed) {
            $.ajax({
                url: '<?= base_url('cancel_appoint'); ?>',
                type: 'post',
                data: { [csrfName]: csrfHash, id: $(this).data('id'), type: 'Cancelled' },
                dataType: 'json',
                success: function(res) {
                    AlertPopup('Cancelled!', 'Your appointment has been cancelled.', 'success', 'Ok', '');
                },
                error: function(xhr, status, error) { console.log(xhr.responseText); }
            });
        }
      });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        window.scrollTo({
            top: document.body.scrollHeight, // Scroll to the bottom
            behavior: "smooth" // Smooth scrolling effect
        });
    }, 300); // Delay before scrolling (adjust if needed)
});


</script>

<!-- Date & Time Picker JS -->
<script src="<?= base_url('assets/libs/flatpickr/flatpickr.min.js'); ?>"></script>

