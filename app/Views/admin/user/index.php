<?= $this->extend('Templates/template'); ?>

<?= $this->section('content_page'); ?>
<div class="row">
  <div class="col-md-12 col-lg-12 col-sm-12">
    <div class="card">
      <div class="card-body">
        <table class="table" id="Container">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Lengkap</th>
              <th scope="col">Username/Email</th>
              <th scope="col">No.HP/Wa</th>
              <th scope="col">Alamat</th>
              <th scope="col">Role</th>
              <th scope="col">Jenis Kelamin</th>
              <th scope="col">KTP</th>
              <th scope="col">SIM</th>
              <th scope="col">Gambar</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?= $this->section('script'); ?>
<script>
  $(document).ready(function () {
    function getUser() {
      $('#Container').DataTable({
        "processing": true,
        // "serverSide": true,
        "ajax": {
          "url": "<?= base_url('admin/car/action_car/ambil'); ?>",
          "method": "POST",
          "succes": function (response) {
            console.log(response);
          }
        },
        "columns": [
          {
            "data": null,
            "sortable": false,
            "render": function (data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }
          },
          { "data": "nama" },
          { "data": "no_plat" },
          { "data": "harga_sewa" },
          { "data": "gambar" },
          { "data": "status" },
          {
            "data": null,
            "sortable": false,
            "render": function (data, row) {
              return `
                <button class="btn btn-sm btn-warning btnEdit" data-iduser="${data.id_user}"><i class="fas fa-pencil"></i></button>
                <button class="btn btn-sm btn-danger btnHapus" data-iduser="${data.id_user}"><i class="fas fa-trash"></i></button>
              `
            }
          },
        ],
        "columnDefs": [
          { "width": "200px", "targets": 6 },
          { "className": "text-center", "targets": [5, 6] }
        ],
      });
    }
    getUser();
  });
</script>
<?= $this->endSection(); ?>
<?= $this->endSection(); ?>