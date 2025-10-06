<?= $this->extend('Templates/template'); ?>

<?= $this->section('content_page'); ?>
<div class="row">
  <div class="col-md-12 col-lg-12 col-sm-12">
    <div class="card">
      <div class="card-body">
        <button class="btn btn-primary btn-sm my-4 btnTambahModal">Tambah Data</button>
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

<?= $this->include('modals/user_modal'); ?>

<?= $this->section('script'); ?>
<script>
  $(document).ready(function () {
    function getUser() {
      $('#Container').DataTable({
        "processing": true,
        // "serverSide": true,
        "responsive": true,
        "ajax": {
          "url": "<?= base_url('admin/user/action_user/ambil'); ?>",
          "method": "POST",
          // "success": function (response) {
          //   return response.data;
          // }
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
          { "data": "username_email" },
          { "data": "no_hp" },
          { "data": "alamat" },
          { "data": "id_role" },
          { "data": "jenis_kel" },
          { "data": "no_ktp" },
          { "data": "no_sim" },
          { "data": "gambar" },
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
      let modal = $('#userModal');
      $(modal).find('.modal-title').text('Tambah Data User');
      $(modal).find('.modal-footer > .btn-secondary').text('Tutup');
      $(modal).find('.modal-footer > .btn-primary').text('Simpan');

      $(modal).modal('show');

      $('#submitUser').on('submit', function (e) {
        e.preventDefault();
        let form = this;
        let csrfHash = $('.ci_csrf_data').attr('name');
        let csrfToken = $('.ci_csrf_data').val();
        let formData = new FormData(form);
        formData.append(csrfHash, csrfToken);

        $.ajax({
          url: "<?= base_url('admin/user/action_user/tambah'); ?>",
          method: "POST",
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          cache: false,
          beforeSend: function (response) {
            $(form).find('.modal-footer > .btn-primary').text('Loading...');
            $(form).find('small.text-error').text('');
          },
          success: function (response) {
            $('.ci_csrf_data').val(response.token);
            if ($.isEmptyObject(response.error)) {
              if (response.status == 1) {
                $(form)[0].reset();
                Swal.fire({
                  icon: "success",
                  title: "Berhasil...",
                  text: `${response.msg}`,
                });
                $('#Container').DataTable().ajax.reload();
                $(modal).modal('hide');
                $(form).find('.modal-footer > .btn-primary').text('Simpan');
              } else {
                $(form).find('.modal-footer > .btn-primary').text('Simpan');
              }
            } else {
              $(form).find('.modal-footer > .btn-primary').text('Simpan');
              $.each(response.error, function (prefix, val) {
                $(form).find(`small.error_${prefix}`).text(val);
              });
            }
          },
          error: function (err) {
            $(form).find('.modal-footer > .btn-primary').text('Simpan');
            console.error(err);
          }
        })

      });

    });

  });
</script>
<?= $this->endSection(); ?>
<?= $this->endSection(); ?>