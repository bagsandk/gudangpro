<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <div class="d-flex justify-content-between align-items-center">
          <img class="mb-4" width="100" src="<?= base_url('assets/images/logo-1.png') ?>" />
          <h3 class="mx-3">PT.Central Artha Ulam</h3>
        </div>
        <div class="text-right">
          <small><?= substr($do['tgl_buat'], 0, 10) ?></small>
          <br>
          <a target="_blank" class="btn btn-outline-danger" href="<?= base_url('dokumen/do/' . $penjualan['idt_penjualan']) ?>">Cetak DO <i class="fa fa-print"></i></a>
        </div>
      </div>
      <p>Jl. Soekarno Hatta No.10, Rajabasa Raya, Kec. Rajabasa, Kota Bandar Lampung, Lampung 35141</p>
      <div class="d-flex justify-content-between mt-4">
        <div>
          <h3 class="text-warning"><?= $penjualan['nofaktur'] ?></h3>
          <table class="table table-sm">
            <tr>
              <td style="padding:3px">Tanggal Transaksi</td>
              <td style="padding:3px">:</td>
              <td style="padding:3px"><?= $penjualan['tgl_transaksi'] ?></td>
            </tr>
            <tr>
              <td style="padding:3px">Tanggal Kirim</td>
              <td style="padding:3px">:</td>
              <td style="padding:3px"><?= ($do['tgl_kirim'] == NULL) ? '-' : substr($do['tgl_kirim'], 0, 10) ?></td>
            </tr>
            <tr>
              <td style="padding:3px">Tanggal Tiba</td>
              <td style="padding:3px">:</td>
              <td style="padding:3px"><?= ($do['tgl_tiba'] == NULL) ? '-' : substr($do['tgl_tiba'], 0, 10) ?></td>
            </tr>
            <tr>
              <td style="padding:3px">Jenis</td>
              <td style="padding:3px">:</td>
              <td style="padding:3px"><?= $penjualan['jenis_do'] ?></td>
            </tr>
            <tr>
              <td style="padding:3px">Status</td>
              <td style="padding:3px">:</td>
              <td style="padding:3px"><?= $penjualan['status'] . '-' . $do['status_do'] ?></td>
            </tr>
          </table>
        </div>
        <div class="text-right">
          <h4 class="text-info">To</h4>
          <p class="m-1">Nama : <?= $do['nmpenerima'] ?></p>
          <p class="m-1"> Alamat : <?= $do['alamat_jalan'] . ' ' . $do['kabupaten'] . ' ' . $do['provinsi'] . ' ' . $do['negara']  ?></p>
          <p class="m-1"> No Telp : <?= $do['notelp'] ?></p>
          <p class="m-1"> Email : <?= $do['email'] ?> </p>
        </div>
      </div>
      <p class="m-0 p-0">Armada : </p>
      <p class="m-0 p-0 ml-1"><small>- (Kode) Nomor Plat : (<?= $do['kdarmada'] ?>) <?= $do['nomor_plat'] ?></small></p>
      <p class="m-0 p-0 ml-1"><small>- Kondisi : <?= $do['kondisi_armada'] ?></small></p>
      <p class="m-0 p-0 ml-1"><small>- Daya Angkut : <?= $do['daya_angkut'] ?> kg</small></p>
      <p class="m-0 p-0 ml-1"><small>- Staf : <?= $do['nmstaf'] ?></small></p>
      <div class="table-responsive mt-4">
        <p>Items : </p>
        <table id="input-penjualan" class="table table-sm">
          <thead>
            <tr>
              <th>Barang</th>
              <th>Harga</th>
              <th>Qty</th>
              <th>Tonase</th>
              <th>Diskon(Rp/Qty)</th>
              <th>Total Diskon</th>
              <th>Sub Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $tonase = 0;
            $totalItem = 0;
            foreach ($detail as $item) : ?>
              <?php $total = $item->harga_jual * $item->qty;
              $tonase += $item->tonase;
              $totalFix = $total - ($item->qty * $item->discount);
              $totalItem += $totalFix; ?>
              <tr id="baris-<?= $item->idbarang ?>">
                <td>
                  <?= $item->nmbarang ?>
                </td>
                <td>
                  Rp <?= number_format($item->harga_jual, 2) ?>
                </td>
                <td>
                  <?= $item->qty ?>
                </td>
                <td>
                  <?= $item->tonase ?>
                </td>
                <td>
                  Rp <?= number_format($item->discount, 2) ?>
                </td>
                <td>
                  Rp <?= number_format($item->qty * $item->discount, 2) ?>
                </td>
                <td id="total-0">Rp <?= number_format($totalFix, 2) ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="2"></td>
              <td span="">Total Tonase</td>
              <td id="total-semua"><?= $tonase ?></td>
              <td></td>
              <td span="">Total</td>
              <td class="" id="total-semua">Rp <?= number_format($totalItem, 2) ?></td>
            </tr>
            <tr>
              <td colspan="5"></td>
              <td span="">Ongkir</td>
              <td class="" id="total-semua">Rp <?= number_format($tonase * 60, 2) ?></td>
            </tr>
            <tr>
              <td colspan="5"></td>
              <td span="">Grand Total</td>
              <td class="text-danger" id="total-semua">Rp <?= number_format($penjualan['total'], 2) ?></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <small>Ket : cepet ya...</small>
      <div class="d-flex justify-content-end">
        <?php if ($do['status_do'] == 'LETTER') { ?>
          <button type="button" data-id="<?= ($do['idtpdo_penjualan']) ?>" id="btnChange" class="btn btn-success ml-2" style="color:white;">To Loading</a>
          <?php } ?>
          <?php if ($do['status_do'] == 'LOADING') { ?>
            <button type="button" data-id="<?= ($do['idtpdo_penjualan']) ?>" id="btnChange" class="btn btn-success ml-2" style="color:white;">To Delivery</a>
            <?php } ?>
            <?php if ($do['status_do'] == 'DELIVERY') { ?>
              <button type="button" data-id="<?= ($do['idtpdo_penjualan']) ?>" id="btnChange" class="btn btn-success ml-2" style="color:white;">To Arrive</a>
              <?php } ?>
      </div>
    </div>
  </div>
</div>
<script>
  $('#btnChange').on('click', function(e) {
    toLoading();
  });

  function toLoading() {
    $('#btnChange').text('Progress...');
    $('#btnChange').attr('disabled', true);
    var url;
    <?php if ($do['status_do'] == 'LETTER') { ?>
      url = "<?= base_url('delivery_order/toLoading/' . $do['idtpdo_penjualan']) ?>";
    <?php } ?>
    <?php if ($do['status_do'] == 'LOADING') { ?>
      url = "<?= base_url('delivery_order/toDelivery/' . $do['idtpdo_penjualan']) ?>";
    <?php } ?>
    <?php if ($do['status_do'] == 'DELIVERY') { ?>
      url = "<?= base_url('delivery_order/toArrive/' . $do['idtpdo_penjualan']) ?>";
    <?php } ?>
    $.ajax({
      url: url,
      type: "GET",
      success: function(data) {
        if (data.status) {
          Swal({
            title: 'Berhasil',
            text: data.message,
            type: 'success'
          }).then(() => {
            window.location.reload();
          });
        } else {
          Swal({
            title: 'Gagal',
            text: data.message,
            type: 'error'
          }).then(() => {
            window.location.reload();
          });
        }
      }
    });
  }
</script>