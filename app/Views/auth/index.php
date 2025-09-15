<!DOCTYPE html>
<html>

<head>
  <!-- Basic Page Info -->
  <meta charset="utf-8" />
  <title><?= $title; ?></title>

  <!-- Site favicon -->
  <link rel="apple-touch-icon" sizes="180x180"
    href="<?= base_url(); ?>deskapp-master/vendors/images/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32"
    href="<?= base_url(); ?>deskapp-master/vendors/images/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16"
    href="<?= base_url(); ?>deskapp-master/vendors/images/favicon-16x16.png" />

  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet" />
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>deskapp-master/vendors/styles/core.css" />
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>deskapp-master/vendors/styles/icon-font.min.css" />
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>deskapp-master/vendors/styles/style.css" />
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>deskapp-master/css/toastr.css" />
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>deskapp-master/css/toastr.min.css" />

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"></script>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258"
    crossorigin="anonymous"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
      dataLayer.push(arguments);
    }
    gtag("js", new Date());

    gtag("config", "G-GBZ3SGGX85");
  </script>
  <!-- Google Tag Manager -->
  <script>
    (function (w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({ "gtm.start": new Date().getTime(), event: "gtm.js" });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != "dataLayer" ? "&l=" + l : "";
      j.async = true;
      j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, "script", "dataLayer", "GTM-NXZMQSS");
  </script>
  <!-- End Google Tag Manager -->
</head>

<body class="login-page">
  <div class="login-header box-shadow">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <div class="brand-logo">
        <a href="login.html">
          <img src="<?= base_url(); ?>deskapp-master/vendors/images/deskapp-logo.svg" alt="" />
        </a>
      </div>
      <div class="login-menu">

      </div>
    </div>
  </div>
  <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-6 col-lg-5">
          <div class="login-box bg-white box-shadow border-radius-10">
            <div class="login-title">
              <h2 class="text-center text-primary">Login Rental Mobil</h2>
            </div>
            <form id="loginSubmit">
              <input type="hidden" class="ci_csrf_data" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
              <div class="form-group">
                <label for="">Username/Email</label>
                <input type="text" class="form-control form-control-lg" name="username_email"
                  placeholder="Username/Email" />
                <small class="text-danger ml-2 text-error error_username_email"></small>
              </div>
              <div class="form-group ">
                <label for="">Password</label>
                <input type="password" class="form-control form-control-lg" name="password" placeholder="**********" />
                <small class="text-danger ml-2 text-error error_password"></small>
              </div>
              <div class="row pb-30">
                <div class="col-6">

                </div>
                <div class="col-6">
                  <div class="forgot-password">
                    <a href="forgot-password.html">Lupa Password</a>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="input-group mb-0">
                    <button class="btn btn-primary btn-lg btn-block loginBtn" type="submit">Login</button>
                  </div>
                  <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">
                    OR
                  </div>
                  <div class="input-group mb-0">
                    <a class="btn btn-outline-primary btn-lg btn-block"
                      href="<?= base_url('auth/register'); ?>">Registrasi</a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- js -->
  <script src="<?= base_url(); ?>deskapp-master/src/scripts/jquery.min.js"></script>
  <script src="<?= base_url(); ?>deskapp-master/vendors/scripts/core.js"></script>
  <script src="<?= base_url(); ?>deskapp-master/vendors/scripts/script.min.js"></script>
  <script src="<?= base_url(); ?>deskapp-master/vendors/scripts/process.js"></script>
  <script src="<?= base_url(); ?>deskapp-master/vendors/scripts/layout-settings.js"></script>
  <script src="<?= base_url(); ?>deskapp-master/js/toastr.min.js"></script>

  <?php if (session()->getFlashdata('success')): ?>
    <script>
      toastr.success('<?= session()->getFlashdata('success'); ?>', 'Berhasil')
    </script>
  <?php endif; ?>

  <script>
    $(document).ready(function (e) {
      toastr.options = {
        "progressBar": true,
        "closeButton": true,
      }
      $('#loginSubmit').on('submit', function (e) {
        e.preventDefault();

        let form = this;
        let csrfName = $('.ci_csrf_data').attr('name');
        let csrfHash = $('.ci_csrf_data').val();
        let formData = new FormData(form);
        formData.append(csrfName, csrfHash);

        $.ajax({
          url: "<?= base_url('auth/proses_submit_login'); ?>",
          method: "POST",
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',
          cache: false,
          beforeSend: function (response) {
            $(form).find('small.text-error').text('');
            $(form).find('.loginBtn').text('Loading...');
          },
          success: function (response) {
            if ($.isEmptyObject(response.error)) {
              if (response.status == 1) {
                $(form).find('.loginBtn').text('Login');
              } else {
                toastr.error(`${response.msg}`, 'Gagal');
                $(form).find('.loginBtn').text('Login');
              }

            } else {
              $(form).find('.loginBtn').text('Login');
              $.each(response.error, function (prefix, val) {
                $(form).find(`small.error_${prefix}`).text(val);
              });
            }
          },
          error: function (err) {
            $(form).find('.loginBtn').text('Login');
            console.error(err);
          }
        });

      });

    });
  </script>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0"
      style="display: none; visibility: hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
</body>

</html>