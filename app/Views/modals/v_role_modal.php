<div class="modal fade" id="modalRole" tabindex="-1" aria-labelledby="modalRoleLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalRoleLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" id="submitFormRole">
        <input type="hidden" class="ci_csrf_data" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Role</label>
            <input type="text" class="form-control form-control-sm" id="nama" name="nama" placeholder="Admin" />
            <small class="text-danger ml-2 text-error error_nama"></small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>


<?= $this->section('stylesheet'); ?>
<link rel="stylesheet" href="<?= base_url(); ?>package/dist/sweetalert2.min.css">
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?= base_url(); ?>package/dist/sweetalert2.all.min.js"></script>

<script>
  $(document).ready(function () {

  });
</script>
<?= $this->endSection(); ?>