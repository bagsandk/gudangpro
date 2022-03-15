<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <h3>PT Gudang Pro</h3>
      <p>Jl. Soekarno Hatta No.10, Rajabasa Raya, Kec. Rajabasa, Kota Bandar Lampung, Lampung 35141</p>
      <div class="d-flex justify-content-between mt-4">
        <div>
          <h3 class="text-warning"><?= $penjualan->nofaktur ?></h3>
          <table class="table table-sm">
            <tr>
              <td style="padding:3px">Tanggal</td>
              <td style="padding:3px">:</td>
              <td style="padding:3px"><?= $penjualan->tgl_transaksi ?></td>
            </tr>
            <tr>
              <td style="padding:3px">Jenis</td>
              <td style="padding:3px">:</td>
              <td style="padding:3px"><?= $penjualan->jenis_do ?></td>
            </tr>
            <tr>
              <td style="padding:3px">Status</td>
              <td style="padding:3px">:</td>
              <td style="padding:3px"><?= $penjualan->status ?></td>
            </tr>
          </table>
        </div>
        <div class="text-right">
          <h4 class="text-info">To</h4>
          <p class="m-1">Nama : <?= $penjualan->nmpelanggan ?></p>
          <p class="m-1"> Alamat : <?= $penjualan->alamat_jalan . ' ' . $penjualan->kabupaten . ' ' . $penjualan->provinsi . ' ' . $penjualan->negara  ?></p>
          <p class="m-1"> No Telp : <?= $penjualan->notelp ?></p>
          <p class="m-1"> Email : <?= $penjualan->email ?> </p>
        </div>
      </div>
      <div class="table-responsive mt-4">
        <p>Items : </p>
        <table id="input-penjualan" class="table table-sm">
          <thead>
            <tr>
              <th>Barang</th>
              <th>Harga</th>
              <th>Qty</th>
              <th>Tonase</th>
              <th>Diskon %</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($detail as $item) : ?>
              <?php $total = $item->harga_jual * $item->qty;
              $totalFix = $total - ($total * $item->discount / 100); ?>
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
                  <?= $item->discount ?>
                </td>
                <td id="total-0">Rp <?= number_format($totalFix, 2) ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4"></td>
              <td span="">Total Harga</td>
              <td id="total-semua">Rp <?= number_format($penjualan->total, 2) ?></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <small>Ket : cepet ya...</small>
    </div>
  </div>
</div>