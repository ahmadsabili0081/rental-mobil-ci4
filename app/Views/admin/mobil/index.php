<?= $this->extend('Templates/template'); ?>

<?= $this->section('content_page'); ?>
<div class="row">
  <div class="col-md-12 col-lg-12 col-sm-12">
    <div class="card">
      <div class="card-body">
        <button class="btn btn-primary btn-sm my-4 btnTambahModal">Tambah Data</button>
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
<?= $this->include('modals/edit_modal_mobil'); ?>

<?= $this->section('stylesheet'); ?>
<link rel="stylesheet" href="<?= base_url(); ?>package/dist/sweetalert2.min.css">
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?= base_url(); ?>package/dist/sweetalert2.all.min.js"></script>

<script>
  $(document).ready(function () {
    toastr.options = {
      "progressBar": true,
      "closeButton": true,
    }
    function getUser() {
      $('#Container').DataTable({
        "processing": true,
        "responsive": true,
        // "serverSide": true,
        "ajax": {
          "url": "<?= base_url('admin/car/action_car/ambil'); ?>",
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
          { "data": "no_plat" },
          {
            "data": null,
            "render": function (data, row) {
              return `Rp. ${data.harga_sewa.replace(/\B(?=(\d{3})+(?!\d))/g, '.')}`;
            }
          },
          {
            data: null,
            render: function (data, row) {
              return `<img class="img-thumbnail" style="width:150px;" src="<?= base_url() . "gambar/admin/mobil/" ?>${data.gambar}" alt="" />`;
            }
          },
          {
            "data": null,
            "render": function (data, row) {
              let warna = data.status == "Tersedia" ? 'success' : 'danger';
              return `<span class="badge badge-${warna}">${data.status}</span>`
            }
          },
          {
            "data": null,
            "sortable": false,
            "render": function (data, row) {
              return `
                <button class="btn btn-sm btn-warning btnEdit" data-idMobil="${data.id_mobil}"><i class="fas fa-pencil"></i></button>
                <button class="btn btn-sm btn-danger btnHapus" data-idMobil="${data.id_mobil}"><i class="fas fa-trash"></i></button>
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
            $(form).find('.modal-footer > .btn-primary').text('Loading...');
          },
          success: function (response) {
            $('.ci_csrf_data').val(response.token);
            if ($.isEmptyObject(response.error)) {
              if (response.status == 1) {
                $(form)[0].reset();
                toastr.success(`${response.msg}`, 'Berhasil');
                $('#Container').DataTable().ajax.reload();
                $(modal).modal('hide');
                $(form).find('.modal-footer > .btn-primary').text('Simpan');
              }
            } else {
              $(form).find('.modal-footer > .btn-primary').text('Simpan');
              $.each(response.error, function (prefix, val) {
                $(form).find(`small.error_${prefix}`).text(val);
              });
            }

          },
          error: function (response) {
            $(form).find('.modal-footer > .btn-primary').text('Simpan');
            console.error(response);
          }
        });
      });


    });


    $(document).on('click', '.btnHapus', function (e) {
      e.preventDefault();
      let idMobil = $(this).data('idmobil');

      Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Ingin Menghapus Data ini!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Hapus!"
      }).then((result) => {
        if (result.isConfirmed) {
          $.post('<?= base_url('admin/car/action_car/hapus') ?>', { idMobil }, function (response) {
            if (response.status == 1) {
              toastr.success(`${response.msg}`, 'Berhasil');
              $('#Container').DataTable().ajax.reload();
            } else {
              toastr.error(`${response.msg}`, 'Gagal');
            }
          }, 'json');
        }
      });
    });

    $(document).on('click', '.btnEdit', function (e) {
      e.preventDefault();
      let modal = $('#editModalMobil');
      $(modal).find('.modal-title').text('Edit Data Mobil');
      $(modal).find('.modal-footer > .btn-secondary').text('Tutup');
      $(modal).find('.modal-footer > .btn-primary').text('Simpan');
      let idMobil = $(this).data('idmobil');

      $.post('<?= base_url('admin/car/action_car/ambil_data') ?>', { idMobil }, function (response) {
        if (response.status == 1) {
          $(modal).find('.idMobil').val(response.data[0].id_mobil);
          $(modal).find('#nama').val(response.data[0].nama);
          $(modal).find('#noPlat').val(response.data[0].no_plat);
          $(modal).find('#hargaSewa').val(response.data[0].harga_sewa);
          $(modal).find('.img-thumbnail').attr('src', `<?= base_url('gambar/admin/mobil/') ?>${response.data[0].gambar}`);
          $(modal).modal('show');
        } else {

        }
      }, 'json');
    });

    $('#submitEditFormMobil').on('submit', function (e) {
      e.preventDefault();
      let form = this;
      let csrfHash = $('.ci_csrf_data').attr('name');
      let csrfToken = $('.ci_csrf_data').val();
      let formData = new FormData(form);
      formData.append(csrfHash, csrfToken);

      $.ajax({
        url: "<?= base_url('admin/car/action_car/edit'); ?>",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        beforeSend: function (response) {
          $(form).find('.modal-footer > .btn-primary').text('Loading...');
          $(form).find('small.text-error').text('');
        },
        success: function (response) {
          if ($.isEmptyObject(response.error)) {
            if (response.status == 1) {
              $('#editModalMobil').modal('hide');
              $(form).find('.modal-footer > .btn-primary').text('Simpan');
              $('#Container').DataTable().ajax.reload();
              toastr.success(`${response.msg}`, 'Berhasil');
            } else {
              $('#editModalMobil').modal('hide');
              toastr.error(`${response.msg}`, 'Gagal');
              $(form).find('.modal-footer > .btn-primary').text('Simpan');
            }
          } else {
            $('#editModalMobil').modal('hide');
            $(form).find('.modal-footer > .btn-primary').text('Simpan');
            $.each(response.error, function (prefix, val) {
              $(form).find(`small.error_${prefix}`).text(val);
            });
          }
        },
        error: function (err) {
          console.error(err);
        }
      });

    });

    $('#hargaSewa').on('input', function (e) {
      e.preventDefault();

      let val = $(this).val();

      val = val.replace(/\D/g, '');

      val = val.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

      $(this).val(val);
    })
  });
</script>
<?= $this->endSection(); ?>
<?= $this->endSection(); ?>