<!DOCTYPE html>
<html lang="en">

<head>
  <title>Gudang Pro </title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!-- Favicon icon -->
  <link rel="icon" href="<?= base_url() ?>assets/images/favicon.ico" type="image/x-icon">
  <!-- fontawesome icon -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/fontawesome/css/fontawesome-all.min.css">
  <!-- animation css -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/animation/css/animate.min.css">
  <!-- vendor css -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body>
  <?php if ($this->session->flashdata('message')) {
    echo $this->session->flashdata('message');
  } ?>
  <div class="auth-wrapper">
    <div class="auth-content">
      <div class="auth-bg">
        <span class="r"></span>
        <span class="r s"></span>
        <span class="r s"></span>
        <span class="r"></span>
      </div>
      <div class="card">
        <div class="card-body text-center">
          <div class="mb-4">
            <i class="feather icon-unlock auth-icon"></i>
          </div>
          <h3 class="mb-4">Login</h3>
          <form action="<?php echo base_url('login/act_login') ?>" method="post">
            <div class="input-group mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email">
            </div>
            <div class="input-group mb-4">
              <input type="password" name="password" class="form-control" placeholder="password">
            </div>
            <div class="form-group text-left">
              <div class="checkbox checkbox-fill d-inline">
                <input type="checkbox" name="checkbox-fill-1" id="checkbox-fill-a1" checked="">
                <label for="checkbox-fill-a1" class="cr"> Save Details</label>
              </div>
            </div>
            <button type="submit" class="btn btn-primary shadow-2 mb-4">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Required Js -->
  <script src="<?= base_url() ?>assets/js/vendor-all.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>