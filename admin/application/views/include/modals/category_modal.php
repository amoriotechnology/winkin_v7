<!----------------- Model form for add new / edit category ------------------->
<div class="modal fade" id="categoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="CategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="" method="post" id="cate_form">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white" id="CategoryModalLabel"><?= isset($edit_cate[0]) ? 'Edit' : 'Add New'; ?> Category</h6>
                    <button type="button" class="btn btn-danger opacity-100 rounded-circle btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModel('category')"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" style="text-align: right;"> <span class="text-danger fs-14">* Required Fields</span> </div>

                        <div class="col-md-12">
                            <label for="cate_name" class="form-label">Category Name <span class="text-danger">*</span> </label>
                            <input type="text" name="cate_name" id="cate_name" class="form-control mt-2" value="<?= (isset($edit_cate[0]['fld_catename']) ? $edit_cate[0]['fld_catename'] : ''); ?>" >
                            <span class="cate-error-msg text-danger"></span>
                        </div>
                        <div class="col-md-12 mt-3">
                            <label for="cate_type" class="form-label">Category For <span class="text-danger">*</span> </label>
                            <select class="form-control" name="cate_type" id="cate_type">
                                <option value=""> Select Option </option>
                                <?php $catetype = (isset($edit_cate[0]['fld_catetype']) ? $edit_cate[0]['fld_catetype'] : ''); ?>
                                <option value="Male" <?= isSame( $catetype, 'Male'); ?> >Male</option>
                                <option value="Female" <?= isSame( $catetype, 'Female'); ?> >Female</option>
                                <option value="Both" <?= isSame( $catetype, 'Both'); ?> >Both</option>
                            </select>
                            <span class="cate-error-msg text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModel('category')" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                    <input type="hidden" name="cateid" value="<?= (isset($edit_cate[0]['fld_cateid']) ? md5($edit_cate[0]['fld_cateid']) : ''); ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                </div>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">

$(document).ready(function() {

    /* ----------------- Model ajax for add / edit category ------------------- */
    $("#cate_form").submit(function(e) {
        e.preventDefault();

        const category = $('#cate_name').val();
        const category_type = $('#cate_type').val();

        $('.cate-error-msg').html('');
        $(this).find('.form-control').css('border', '');

        var action = validation({'cate_name' : category, 'cate_type' : category_type});
        if(action === false) { return action;}

        $.ajax({
            url: '<?= base_url('add_category') ?>',
            type: 'post',
            data : $(this).serialize(),
            dataType: 'json',
            success : function (res) {                    
                if(res.status == 200) {
                    AlertPopup('Success!', res.alert_msg.word, 'success', 'Ok', 'category');
                } else {
                    AlertPopup('No Changes Detected!', '', 'info', 'Ok', 'category');
                }
            }, 
            error : function(res) { console.log(res); }
       });
    });

});
</script>