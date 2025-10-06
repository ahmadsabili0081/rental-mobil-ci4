<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" id="submitUser">
        <input type="hidden" class="ci_csrf_data" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Nama lengkap</label>
            <input type="text" class="form-control form-control-sm" id="nama" name="nama" placeholder="Ahmad sabili" />
            <small class="text-danger ml-2 text-error error_nama"></small>
          </div>
          <div class="form-group">
            <label for="">Username/Email</label>
            <input type="text" class="form-control form-control-sm" id="usernameEmail" name="username_email"
              placeholder="ahmadsabili0081@gmail.com" />
            <small class="text-danger ml-2 text-error error_username_email"></small>
          </div>
          <div class="form-group">
            <label for="">No. HP</label>
            <input type="text" class="form-control form-control-sm" id="noHp" name="no_hp" placeholder="088291417823" />
            <small class="text-danger ml-2 text-error error_no_hp"></small>
          </div>

          <div class="form-group">
            <label for="">Alamat</label>
            <input type="text" class="form-control form-control-sm" id="alamat" name="alamat"
              placeholder="Jl. Kerta Jaya II No.2" />
            <small class="text-danger ml-2 text-error error_alamat"></small>
          </div>

          <div class="form-group">
            <label for="">Jenis Kelamin</label>
            <select name="jenis_kel" class="form-control" id="jenisKel">
              <option value="">--Pilih Jenis Kelamin--</option>
              <option value="L">Laki-Laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>

          <div class="form-group">
            <label for="">Upload KTP</label>
            <div class="col-md-4 my-2 p-0">
              <img id="previewKtp" class="img-thumbnail" src="" />
            </div>
            <div class="col-md-6 my-2 p-0">
              <input type="text" class="form-control form-control-sm nik" name="no_ktp" disabled>
            </div>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="no_ktp" id="inputGroupFile01"
                aria-describedby="inputGroupFileAddon01">
              <label class="custom-file-label label-ktp" for="inputGroupFile01">Choose file</label>
            </div>
            <div id="status" style="margin-top:10px; font-size:14px; color:#555;"></div>
            <small class="text-danger ml-2 text-error error_no_ktp"></small>

          </div>

          <div class="form-group">
            <label for="">Upload SIM</label>
            <div class="col-md-4 my-2 p-0">
              <img id="previewSim" class="img-thumbnail" src="" />
            </div>
            <div class="col-md-6 my-2 p-0">
              <input type="text" class="form-control form-control-sm sim" name="no_sim" disabled>
            </div>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="no_sim" id="noSimUpload"
                aria-describedby="inputGroupFileAddon01">
              <label class="custom-file-label label-sim" for="noSimUpload">Choose file</label>
            </div>
            <div id="statusSim" style="margin-top:10px; font-size:14px; color:#555;"></div>
            <small class="text-danger ml-2 text-error error_no_sim"></small>

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
<script src="<?= base_url(); ?>deskapp-master/js/tesseract.min.js"></script>

<script>
  $(document).ready(function () {

    $('#inputGroupFile01').on('change', function (e) {
      let file = e.target.files[0];
      if (!file) return;

      let reader = new FileReader();
      reader.onload = function (ev) {
        $('#previewKtp').attr('src', ev.target.result).show();

        $('#status').text("Membaca KTP... harap tunggu.");

        // Jalankan OCR
        Tesseract.recognize(
          ev.target.result,
          'ind', // bahasa Indonesia
          {
            logger: m => {
              if (m.status === "recognizing text") {
                $('#status').text(`Sedang membaca... ${Math.round(m.progress * 100)}%`);
              }
            }
          }
        ).then(({ data: { text } }) => {

          let match = text.match(/\b\d{16}\b/);
          if (match) {
            $('.label-ktp').text(file.name)
            $('.nik').val(match[0]);
            $('#status').text("NIK berhasil dibaca!");
          } else {
            $('#status').text("NIK tidak terbaca, coba foto lebih jelas.");
          }
        }).catch(err => {
          console.error(err);
          $('#status').text("Terjadi kesalahan saat membaca gambar.");
        });
      };
      reader.readAsDataURL(file);
    });

    $('#noSimUpload').on('change', function (e) {
      let file = e.target.files[0];
      if (!file) return;

      let reader = new FileReader();
      reader.onload = function (ev) {
        $('#previewSim').attr('src', ev.target.result).show();

        $('#statusSim').text("Membaca SIM... harap tunggu.");

        // Jalankan OCR
        Tesseract.recognize(
          ev.target.result,
          'ind', // bahasa Indonesia
          {
            logger: m => {
              if (m.status === "recognizing text") {
                $('#statusSim').text(`Sedang membaca... ${Math.round(m.progress * 100)}%`);
              }
            }
          }
        ).then(({ data: { text } }) => {

          let match = text.match(/\b\d{12}\b/);
          if (match) {
            $('.label-sim').text(file.name)
            $('.sim').val(match[0]);
            $('#statusSim').text("SIM berhasil dibaca!");
          } else {
            $('#statusSim').text("SIM tidak terbaca, coba foto lebih jelas.");
          }
        }).catch(err => {
          console.error(err);
          $('#status').text("Terjadi kesalahan saat membaca gambar.");
        });
      };
      reader.readAsDataURL(file);
    });


  });
</script><?= $this->endSection(); ?>