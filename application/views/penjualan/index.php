<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <a class="btn btn-outline-success float-right" href="<?= base_url('penjualan/add') ?>">Tambah Penjualan</a>
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-link active" id="nav-semua-tab" data-toggle="tab" href="#nav-semua" role="tab" aria-controls="nav-semua" aria-selected="true">semua</a>
          <a class="nav-link" id="nav-takeit-tab" data-toggle="tab" href="#nav-takeit" role="tab" aria-controls="nav-takeit" aria-selected="false">takeit</a>
          <a class="nav-link" id="nav-delivery-tab" data-toggle="tab" href="#nav-delivery" role="tab" aria-controls="nav-delivery" aria-selected="false">delivery</a>
          <a class="nav-link" id="nav-kurir-tab" data-toggle="tab" href="#nav-kurir" role="tab" aria-controls="nav-kurir" aria-selected="false">kurir</a>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-semua" role="tabpanel" aria-labelledby="nav-semua-tab">
          <div class="mb-3 row">
            <div class="mb-1 col-md-9 col-sm-8 col-12">
              <div class="input-group">
                <select class="input-group-text" style="width: 150px; padding:0px">
                  <option>No faktur</option>
                  <option>...</option>
                </select>
                <input placeholder="Masukan no faktur" id="pencarian" class="form-control">
              </div>
            </div>
            <div class="text-right col-md-3 col-sm-4 col-12">
              <button type="button" class="btn btn-primary btn-md">Cari</button>
              <button type="button" class="mr-0 btn btn-light btn-md">Reset</button>
            </div>
          </div>
          <div id="content-semua">

          </div>
        </div>
        <div class="tab-pane fade" id="nav-takeit" role="tabpanel" aria-labelledby="nav-takeit-tab">

        </div>
        <div class="tab-pane fade" id="nav-delivery" role="tabpanel" aria-labelledby="nav-delivery-tab">...</div>
        <div class="tab-pane fade" id="nav-kurir" role="tabpanel" aria-labelledby="nav-kurir-tab">...</div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $.ajax({
      url: '<?= base_url('penjualan/get_penjualan') ?>',
      method: 'GET',
      success: function(data) {
        $('#content-semua').html(data);
      }
    });
  })
</script>