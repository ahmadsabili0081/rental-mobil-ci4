<div class="modal fade" id="modalMobil" tabindex="-1" aria-labelledby="modalMobilLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalMobilLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" id="submitFormMobil">
        <input type="hidden" class="ci_csrf_data" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Nama Mobil</label>
            <input type="text" class="form-control form-control-sm" id="nama" name="nama" placeholder="Kijang" />
            <small class="text-danger ml-2 text-error error_nama"></small>
          </div>
          <div class="form-group">
            <label for="">No. Plat Mobil</label>
            <input type="text" class="form-control form-control-sm" id="noPlat" name="no_plat" placeholder="B1234CXD" />
            <small class="text-danger ml-2 text-error error_no_plat"></small>
          </div>
          <div class="form-group">
            <label for="">Harga Sewa</label>
            <input type="text" class="form-control form-control-sm" name="harga_sewa" placeholder="1500000" />
            <small class="text-danger ml-2 text-error error_harga_sewa"></small>
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