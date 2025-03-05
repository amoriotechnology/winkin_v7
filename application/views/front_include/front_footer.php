<div class="text-center landing-main-footer py-3">
    <span class="text-muted fs-15"> Copyright © <?= date('Y'); ?> . Designed & Developed by 
        <a href="https://amoriotech.com" class="text-primary fw-medium" target="_blank"><u>Amorio Technologies</u></a>
    </span>
</div>

</div>
<!-- End::main-content -->
    
</div>
<!--app-content closed-->


<!-- SCRIPTS -->
<!-- Back To Top -->
<div class="scrollToTop">
<span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
</div>
<div id="responsive-overlay"></div>

<!-- Popper JS -->
<script src="<?= base_url(); ?>assets/libs/@popperjs/core/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="<?= base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Color Picker JS -->
<script src="<?= base_url(); ?>assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>

<!-- Sweetalerts JS -->
<script src="<?= base_url('assets/libs/sweetalert2/sweetalert2.min.js'); ?>"></script>

<!-- Choices JS -->
<script src="<?= base_url(); ?>assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

<!-- Swiper JS -->
<script src="<?= base_url(); ?>assets/libs/swiper/swiper-bundle.min.js"></script>

<!-- Defaultmenu JS -->
<link rel="modulepreload" href="<?= base_url(); ?>assets/js/defaultmenu.js" />
<script type="module" src="<?= base_url(); ?>assets/js/defaultmenu.js"></script>

<!-- Node Waves JS-->
<script src="<?= base_url('assets/libs/node-waves/waves.min.js'); ?>"></script>

<!-- Sticky JS -->
<script src="<?= base_url('assets/js/sticky.js'); ?>"></script>

<script src="<?= base_url('assets/js/footer.js'); ?>"></script>

<!-- Datatables Cdn -->
<script src="<?= base_url('assets/datatable/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/datatable/dataTables.bootstrap5.min.js'); ?>"></script>
<script src="<?= base_url('assets/datatable/dataTables.responsive.min.js'); ?>"></script>
<script src="<?= base_url('assets/datatable/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= base_url('assets/datatable/buttons.print.min.js'); ?>"></script>
<script src="<?= base_url('assets/datatable/pdfmake.min.js'); ?>"></script>
<script src="<?= base_url('assets/datatable/vfs_fonts.js'); ?>"></script>
<script src="<?= base_url('assets/datatable/buttons.html5.min.js'); ?>"></script>
<script src="<?= base_url('assets/datatable/jszip.min.js'); ?>"></script>

<script src="<?= base_url('myassets/OwlCarousel2-2.3.4/dist/owl.carousel.min.js'); ?>"></script>

<script type="text/javascript">
    /* -------- When click close model button reload the page --------- */
    function closeModel(pagename) {
        $('.cate-error-msg, .error-msg').html('');
        $('form').find('.form-control').css('border', '');
        (pagename == '') ? location.reload() : window.location.href = '<?= base_url("'+ pagename +'")?>';
    }


    function AlertPopup(altTitle, altText, altIcon, btnText, pageName, extra_btn = "") {
        if(extra_btn != "") {
           Swal.fire({
                title: "Success",
                icon: "success",
                showCancelButton: !0,
                cancelButtonColor: "#0DCAF0",
                cancelButtonText: "close",
                confirmButtonColor: "#3085D6",
                confirmButtonText: "Book Another Slot",
            }).then((e) => {
                if (e.isConfirmed) {
                   window.location.href = '<?= base_url("booking")?>';
                } else {
                    window.location.href = '<?= base_url("")?>';
                }
            });
        } else {
            Swal.fire({
                title: altTitle,
                text: altText,
                icon: altIcon,
                confirmButtonText: btnText,
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if(result.isConfirmed) {
                    (pageName == '') ? location.reload() : window.location.href = '<?= base_url("'+ pageName +'")?>';
                }
            });
        }
    }
</script>

<style type="text/css">
    .danger-text{
        color: red !important;
    }
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>

</body> 

</html>
