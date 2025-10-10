<?= $this->extend('Templates/template'); ?>

<?= $this->section('content_page'); ?>
<div class="row">
  <div class="col-md-12 col-lg-12 col-sm-12">
    <div class="card">
      <div class="card-body">
        <button class="btn btn-primary btn-sm my-4 btnTambahModal">Tambah Data</button>
        <table class="table" id="Container" style="width: 100%;">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Role</th>
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

<?= $this->include('modals/v_role_modal'); ?>

<?= $this->section('script'); ?>
<script>
  $(document).ready(function () {

    $('#Container').DataTable({
      processing: true,
      responsive: true,
      ajax: {
        url: "<?= base_url('admin/role/action_role/ambil'); ?>",
        method: "POST",

      },
      columns: [
        {
          "data": null,
          "sortable": false,
          "render": function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          data: "role"
        },
        {
          data: null,
          render: function (data, row) {
            return `
                <button class="btn btn-sm btn-warning btnEdit" data-iduser="${data.id_role}"><i class="fas fa-pencil"></i></button>
                <button class="btn btn-sm btn-danger btnHapus" data-iduser="${data.id_role}"><i class="fas fa-trash"></i></button>
              `
          }
        }
      ]
    });

    $('.btnTambahModal').on('click', function (e) {
      e.preventDefault();

      let modal = $('#modalRole');
      $(modal).find('.modal-title').text('Tambah Data Role');
      $(modal).find('.modal-footer > .btn-secondary').text('Tutup');
      $(modal).find('.modal-footer > .btn-primary').text('Simpan');

      $(modal).modal('show');

      $('#submitFormRole').on('submit', function (e) {
        e.preventDefault();

        let form = this;
        let csrfHash = $('.ci_csrf_data').attr('name');
        let csrfToken = $('.ci_csrf_data').val();
        let formData = new FormData(form);
        formData.append(csrfHash, csrfToken);

        $.ajax({
          url: "<?= base_url('admin/role/action_role/tambah'); ?>",
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
        });

      });

    });

  });
</script>
<?= $this->endSection(); ?>
<?= $this->endSection(); ?>