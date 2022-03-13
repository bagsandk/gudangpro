<!DOCTYPE html>
<html lang="en">
<?php
function menuActive($menu, $type = 'menu')
{
  $ci = &get_instance();
  $uri = $ci->uri->segment(1);
  switch ($type) {
    case 'menu':
      return $uri == str_replace('/', '', $menu) ? 'active' : '';
      break;
    case 'submenu':
      return $uri == str_replace('/', '', $menu) ? 'active' : '';
      break;
    case 'collapse':
      $mc = [];
      foreach ($menu as $m) {
        $mc[] = str_replace('/', '', $m['url']);
      }
      return in_array($uri, $mc) ? 'active pcoded-trigger' : '';
      break;
    default:
      return '';
  }
}
$items = [
  [
    "id" => "dahsboard",
    "title" => "Dahsboard",
    "type" => "group",
    "icon" => "icon-navigation",
    "children" => [
      [
        "id" => "dashboard",
        "title" => "Dashboard",
        "type" => "item",
        "url" => "/home",
        "icon" => "feather icon-home",
      ],
    ],
  ],
  [
    "id" => "penjualan",
    "title" => "Main Menu",
    "type" => "group",
    "icon" => "icon-ui",
    "children" => [
      [
        "id" => "penjualan",
        "title" => "Penjualan",
        "type" => "collapse",
        "icon" => "feather icon-box",
        "children" => [
          [
            "id" => "penjualan",
            "title" => "Penjualan",
            "type" => "item",
            "url" => "/penjualan/",
          ],
          [
            "id" => "penjualan-pembayaran",
            "title" => "Pembayaran",
            "type" => "item",
            "url" => "/penjualan/pembayaran",
          ],
          [
            "id" => "delivery-order",
            "title" => "Delivery Order",
            "type" => "item",
            "url" => "/penjualan/delivery-order",
          ],
          [
            "id" => "laporan",
            "title" => "Laporan",
            "type" => "item",
            "url" => "/basic/collapse",
          ],
        ],
      ],
    ],
  ],
  [
    "id" => "ui-master",
    "title" => "Manajemen Data",
    "type" => "group",
    "icon" => "icon-ui",
    "children" => [
      [
        "id" => "armada",
        "title" => "Armada",
        "type" => "collapse",
        "icon" => "feather icon-box",
        "children" => [
          [
            "id" => "armada-i",
            "title" => "Armada",
            "type" => "item",
            "url" => "/armada",
          ],
          [
            "id" => "armada-jenis",
            "title" => "Jenis",
            "type" => "item",
            "url" => "/armada_jenis",
          ],
        ],
      ],
      [
        "id" => "barang",
        "title" => "Barang",
        "type" => "collapse",
        "icon" => "feather icon-box",
        "children" => [
          [
            "id" => "barang-i",
            "title" => "Barang",
            "type" => "item",
            "url" => "/barang",
          ],
          [
            "id" => "barang-kategori",
            "title" => "Kategori",
            "type" => "item",
            "url" => "/barang_kategori",
          ],
          [
            "id" => "barang-satuan",
            "title" => "Satuan",
            "type" => "item",
            "url" => "/barang_satuan",
          ],
        ],
      ],
      [
        "id" => "pembayaran-master",
        "title" => "Pembayaran",
        "type" => "collapse",
        "icon" => "feather icon-box",
        "children" => [
          [
            "id" => "metode-bayar",
            "title" => "Metode Pembayaran",
            "type" => "item",
            "url" => "/metode_bayar",
          ],
          [
            "id" => "status-bayar",
            "title" => "Status Bayar",
            "type" => "item",
            "url" => "/pembayaran-master/status-bayar",
          ],
          [
            "id" => "rekening-bank",
            "title" => "Rekening Bank",
            "type" => "item",
            "url" => "/pembayaran-master/rekening-bank",
          ],
        ],
      ],
      [
        "id" => "user",
        "title" => "User",
        "type" => "collapse",
        "icon" => "feather icon-box",
        "children" => [
          [
            "id" => "user",
            "title" => "User",
            "type" => "item",
            "url" => "/user",
          ],
          [
            "id" => "staf",
            "title" => "Staf",
            "type" => "item",
            "url" => "/user/staf",
          ],
          [
            "id" => "pelanggan",
            "title" => "Pelanggan",
            "type" => "item",
            "url" => "/pelanggan",
          ],
          [
            "id" => "supplier",
            "title" => "Supplier",
            "type" => "item",
            "url" => "/user/supplier",
          ],
        ],
      ],
      [
        "id" => "jabatan",
        "title" => "Jabatan",
        "type" => "item",
        "url" => "/jabatan",
        "icon" => "feather icon-box",
      ],
      [
        "id" => "pendidikan",
        "title" => "Pendidikan",
        "type" => "item",
        "url" => "/pendidikan",
        "icon" => "feather icon-box",
      ],
      [
        "id" => "unit",
        "title" => "Unit",
        "type" => "item",
        "url" => "/unit",
        "icon" => "feather icon-box",
      ],
    ],
  ],
];

?>

<head>
  <title>Gudang Pro </title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!-- Favicon icon -->
  <link rel="icon" href="<?= base_url() ?>assets/images/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
  <!-- fontawesome icon -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/fontawesome/css/fontawesome-all.min.css">
  <!-- animation css -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/animation/css/animate.min.css">
  <!-- vendor css -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
  <script src="<?= base_url(); ?>assets/jquery-3.3.1/jquery-3.3.1.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">


</head>

<body>
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->
  <!-- [ navigation menu ] start -->
  <nav class="pcoded-navbar">
    <div class="navbar-wrapper">
      <div class="navbar-brand header-logo">
        <a href="index.html" class="b-brand">
          <div class=""><img width="55" src="<?= base_url('assets/images/logo-1.png') ?>" class=""></div>
          <span class="b-title">Gudang Pro</span>
        </a>
        <a class="mobile-menu" id="mobile-collapse" href="#"><span></span></a>
      </div>
      <div class="navbar-content scroll-div">
        <ul class="nav pcoded-inner-navbar">
          <?php foreach ($items as $menus) { ?>
            <li class="nav-item pcoded-menu-caption">
              <label><?= $menus['title'] ?></label>
            </li>
            <?php foreach ($menus['children'] as $menu) { ?>
              <?php if (isset($menu['children'])) { ?>
                <li class="nav-item pcoded-hasmenu <?= menuActive($menu['children'], 'collapse') ?>">
                  <a href="javascript:" class="nav-link"><span class="pcoded-micon"><i class="<?= $menu['icon'] ?>"></i></span><span class="pcoded-mtext"><?= $menu['title'] ?></span></a>
                  <ul class="pcoded-submenu">
                    <?php foreach ($menu['children'] as $submemu) { ?>
                      <li class="<?= menuActive($submemu['url'], 'submenu') ?>"><a href="<?= base_url($submemu['url']) ?>" class=""><?= $submemu['title'] ?></a></li>
                    <?php } ?>
                  </ul>
                </li>
              <?php } else { ?>
                <li class="nav-item <?= menuActive($menu['url'], 'menu') ?>">
                  <a href="<?= base_url($menu['url']) ?>" class="nav-link "><span class="pcoded-micon"><i class="<?= $menu['icon'] ?>"></i></span><span class="pcoded-mtext"><?= $menu['title'] ?></span></a>
                </li>
            <?php }
            } ?>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>
  <!-- [ navigation menu ] end -->

  <!-- [ Header ] start -->
  <header class="navbar pcoded-header navbar-expand-lg navbar-light">
    <div class="m-header">
      <a class="mobile-menu" id="mobile-collapse1" href="javascript:"><span></span></a>
      <a href="index.html" class="b-brand">
        <div class="b-bg">
          <i class="feather icon-trending-up"></i>
        </div>
        <span class="b-title"></span>
      </a>
    </div>
    <a class="mobile-menu" id="mobile-header" href="javascript:">
      <i class="feather icon-more-horizontal"></i>
    </a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav mr-auto">
        <li><a href="javascript:" class="full-screen" onclick="javascript:toggleFullScreen()"><i class="feather icon-maximize"></i></a></li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li>
          <div class="dropdown">
            <a class="dropdown-toggle" href="javascript:" data-toggle="dropdown"><i class="icon feather icon-bell"></i></a>
            <div class="dropdown-menu dropdown-menu-right notification">
              <div class="noti-head">
                <h6 class="d-inline-block m-b-0">Notifications</h6>
                <div class="float-right">
                  <a href="javascript:" class="m-r-10">mark as read</a>
                  <a href="javascript:">clear all</a>
                </div>
              </div>
              <ul class="noti-body">
                <li class="n-title">
                  <p class="m-b-0">NEW</p>
                </li>
                <li class="notification">
                  <div class="media">
                    <img class="img-radius" src="<?= base_url() ?>assets/images/user/avatar-1.jpg" alt="Generic placeholder image">
                    <div class="media-body">
                      <p><strong>John Doe</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>30 min</span></p>
                      <p>New ticket Added</p>
                    </div>
                  </div>
                </li>
              </ul>
              <div class="noti-footer">
                <a href="javascript:">show all</a>
              </div>
            </div>
          </div>
        </li>
        <li>
          <div class="dropdown drp-user">
            <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown">
              <i class="icon feather icon-settings"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-notification">
              <div class="pro-head">
                <img src="<?= base_url() ?>assets/images/user/avatar-1.jpg" class="img-radius" alt="User-Profile-Image">
                <span>John Doe</span>
                <a href="auth-signin.html" class="dud-logout" title="Logout">
                  <i class="feather icon-log-out"></i>
                </a>
              </div>
              <ul class="pro-body">
                <li><a href="javascript:" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </header>
  <!-- [ Header ] end -->

  <!-- [ Main Content ] start -->
  <div class="pcoded-main-container">
    <div class="pcoded-wrapper">
      <div class="pcoded-content">
        <div class="pcoded-inner-content">
          <!-- [ breadcrumb ] start -->

          <!-- [ breadcrumb ] end -->
          <div class="main-body">
            <div class="page-wrapper">
              <!-- [ Main Content ] start -->
              <div class="row">
                <?php if ($content) $this->load->view($content); ?>
              </div>
              <!-- [ Main Content ] end -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= base_url() ?>assets/js/vendor-all.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?= base_url() ?>assets/js/pcoded.min.js"></script>

  <script src="<?= base_url(); ?>assets/popper/popper.min.js"></script>
  <script src="<?= base_url(); ?>assets/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url(); ?>assets/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url(); ?>assets/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>

</html>