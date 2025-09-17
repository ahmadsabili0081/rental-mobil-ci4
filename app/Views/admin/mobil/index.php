<?= $this->extend('Templates/template'); ?>

<?= $this->section('content_page'); ?>
<div class="row">
  <div class="col-md-12 col-lg-12 col-sm-12">
    <div class="card">
      <div class="card-body">
        <button class="btn btn-primary btn-sm m-2 btnTambahModal">Tambah Data</button>
        <table class="table" id="Container" style="width:100%;">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Mobil</th>
              <th scope="col">No Plat</th>
              <th scope="col">Harga Sewa</th>
              <th scope="col">Gambar</th>
              <th scope="col">Status</th>
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

<?= $this->include('modals/modal_mobil'); ?>
<?= $this->section('script'); ?>
<script>
  $(document).ready(function () {
    function getUser() {
      $('#Container').DataTable({
        "processing": true,
        // "serverSide": true,
        "responsive": true,
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

    $('.btnTambahModal').on('click', function (e) {
      e.preventDefault();

      let modal = $('#modalMobil');

      $(modal).modal('show');
      $(modal).find('.modal-title').text('Tambah Data Mobil');
      $(modal).find('.modal-footer > .btn-secondary').text('Tutup');
      $(modal).find('.modal-footer > .btn-primary').text('Simpan');

      $('#submitFormMobil').on('submit', function (e) {
        e.preventDefault();

        let form = this;
        let csrfHash = $('.ci_csrf_data').attr('name');
        let csrfToken = $('.ci_csrf_data').val();

        let formData = new FormData(form);
        formData.append(csrfHash, csrfToken);

        $.ajax({
          url: "<?= base_url('admin/car/action_car/tambah'); ?>",
          method: "POST",
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',
          cache: false,
          beforeSend: function (response) {
            $(form).find('small.text-error').text('');
          },
          success: function (response) {
            $('.ci_csrf_data').val(response.token);
            if ($.isEmptyObject(response.error)) {
              if (response.status == 1) {
                $('#Container').DataTable().ajax.reload();
                $(modal).modal('hide');
              }
            } else {
              $.each(response.error, function (prefix, val) {
                $(form).find(`small.error_${prefix}`).text(val);
              });
            }

          },
          error: function (response) {
            console.error(response);
          }
        });
      });

    });
  });
</script>
<?= $this->endSection(); ?>
<?= $this->endSection(); ?>