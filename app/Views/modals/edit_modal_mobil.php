<div class="modal fade" id="editModalMobil" tabindex="-1" aria-labelledby="editModalMobilLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalMobilLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" id="submitEditFormMobil">
        <input type="hidden" class="ci_csrf_data" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
        <input type="hidden" class="idMobil" name="id_mobil" value="">
        <input type="hidden" class="gambarLama" name="gambar_lama" value="">
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
            <input type="text" class="form-control form-control-sm" id="hargaSewa" name="harga_sewa"
              placeholder="1500000" />
            <small class="text-danger ml-2 text-error error_harga_sewa"></small>
          </div>
          <div class="form-group">
            <label for="">Upload Gambar</label>
            <div class="col-md-4 my-2 p-0">
              <img id="output" class="img-thumbnail" src="" alt="">
            </div>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="gambar" id="inputGroupFile01"
                aria-describedby="inputGroupFileAddon01">
              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
            </div>
            <small class="text-danger ml-2 text-error error_gambar"></small>

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

  $(document).ready(function (e) {
    $('#hargaSewa').on('input', function (e) {
      e.preventDefault();

      let val = $(this).val();

      val = val.replace(/\D/g, '');

      val = val.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

      $(this).val(val);
    });

    $('#inputGroupFile01').on('change', function (e) {
      e.preventDefault();

      let typeImage = e.target.files[0].type;
      console.log(typeImage);
      if ((typeImage == "image/png") || (typeImage == "image/jpg") || (typeImage == "image/jpeg")) {
        let reader = new FileReader();
        reader.onload = function () {
          let image = $('#output');
          image.attr('src', reader.result);
        }
        reader.readAsDataURL(e.target.files[0]);

        let nama = e.target.files[0].name;
        $('.custom-file-label').text(nama);
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "File tidak dapat di Upload!",
        });
        $(this).val('');
      }
    });


  });

</script>
<?= $this->endSection(); ?>