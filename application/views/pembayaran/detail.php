<?php
$sdhdibayar = 0;
foreach ($pembayaran as $pem) {
  $sdhdibayar += $pem->total;
}
?>
<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <div class="col-12 d-flex justify-content-between mt-4">
        <div class="col-4 text-left">
          <img width="100" src="<?= base_url('assets/images/logo-1.png') ?>" />
        </div>
        <div class="col-4 text-center">
          <p>PT.Central Artha Ulam</p>
        </div>
        <div class="col-4 text-right">
          <h5>Status Pembayaran <span class="badge badge-<?= $sdhdibayar < $penjualan->total ? 'warning' : 'success' ?>"><?= $sdhdibayar < $penjualan->total ? 'Belum Lunas' : 'Lunas' ?></span></h5>
          <h5>Status Penjualan <span class="badge badge-info"><?= $penjualan->status ?></span></h5>
          <a target="_blank" class="btn btn-outline-danger" href="<?= base_url('dokumen/faktur/' . $penjualan->idt_penjualan) ?>">Cetak Faktur <i class="fa fa-print"></i></a>
        </div>
      </div>
      <h3 class="text-center text-weight-bold">DETAIL PENJUALAN</h3>
      <div class="col-12 d-flex justify-content-between mt-4">
        <div class="col-4 text-left">
          <p>Jl. Soekarno Hatta No.10, Rajabasa Raya, Kec. Rajabasa, Kota Bandar Lampung, Lampung 35141</p>
        </div>
        <div class="col-4 text-center">
          <p> Tanggal : <?= $penjualan->tgl_transaksi ?></p>
          <p> Faktur : <?= $penjualan->nofaktur ?></p>
        </div>
        <div class="col-4 text-right">
          <p class="m-1">Pelanggan : <?= $penjualan->nmpelanggan ?></p>
          <p class="m-1"> Alamat : <?= $penjualan->alamat_jalan . ' ' . $penjualan->kabupaten . ' ' . $penjualan->provinsi . ' ' . $penjualan->negara  ?></p>
          <p class="m-1"> Telepon : <?= $penjualan->notelp ?></p>
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
              <td class="text-danger" id="total-semua">Rp <?= number_format($penjualan->total, 2) ?></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <small class="mb-4">ket: <?= $penjualan->keterangan ?></small>
      <h4 class="text-capitalize mt-4">Terbilang : <?= terbilang($penjualan->total) ?></h4>
      <div class="d-flex justify-content-end">
        <?php if ($penjualan->status == 'PROSES') { ?>
          <button type="button" onclick="kirim()" id="btn-kirim" class="btn btn-warning ml-2">Kirim barang</button>
        <?php } ?>
      </div>
      <?php if (count($pembayaran) !== 0) : ?>
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
          Detail Pembayaran
        </button>
        <div class="collapse" id="collapseExample">
          <div class="card card-body">
            <div class="table-responsive mt-4">
              <table id="input-penjualan" class="table table-sm">
                <thead>
                  <tr>
                    <th>KD</th>
                    <th>Tgl Bayar</th>
                    <th>Metode Bayar</th>
                    <th>Rekening Bank</th>
                    <th>Status Bayar</th>
                    <th>Jumlah</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($pembayaran as $pem) :
                  ?>
                    <tr>
                      <td><?= $pem->kdtp_penjualan ?></td>
                      <td><?= $pem->tgl_pembayaran ?></td>
                      <td><?= $pem->metode_bayar ?></td>
                      <td>
                        No-Rek : <?= $pem->norekening ?><br>
                        AN : <?= $pem->nmnasabah ?><br>
                      </td>
                      <td><?= $pem->status_bayar ?></td>
                      <td>Rp <?= number_format($pem->total, 2) ?></td>
                    </tr>
                  <?php endforeach ?>
                  <tr>
                    <td colspan="4">
                    </td>
                    <td>
                      Total Pembayaran
                    </td>
                    <td>
                      Rp <?= number_format($sdhdibayar, 2) ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="4">
                    </td>
                    <td>
                      Harus Dibayar
                    </td>
                    <td>
                      Rp <?= number_format($penjualan->total, 2) ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="4">
                    </td>
                    <td>
                      Status
                    </td>
                    <td>
                      <h4> <span class="badge badge-<?= $sdhdibayar < $penjualan->total ? 'warning' : 'success' ?>"><?= $sdhdibayar < $penjualan->total ? 'Belum Lunas' : 'Lunas' ?></span></h4>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <?php endif ?>
    </div>
  </div>
</div>

<?php if ($penjualan->status == 'PROSES') { ?>
  <div class="modal fade" id="modal_form" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered  modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title">Pengiriman <span class="badge badge-warning"><?= $penjualan->nofaktur ?></span> </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body form">
          <form action="#" id="form" class="form-horizontal">
            <input type="hidden" name="idt_penjualan" value="<?= $penjualan->idt_penjualan ?>">
            <div class="form-body">
              <div class="form-row">
                <div class="col-md-12 col-xs-12">
                  <div class="form-group">
                    <label class="control-label">Armada <small>(kode|no plat|daya angkut|no stnk|jenis|staf|kondisi)</small></label>
                    <select data-allow-clear="1" id="idarmada_select2" name="idarmada" class="form-control ">
                    </select>
                    <span class="invalid-feedback"></span>
                  </div>
                </div>
                <div class="col-md-6 col-xs-12">
                  <div class="form-group">
                    <label class="control-label">Kode Pengiriman</label>
                    <input name="kdtpdo_penjualan" placeholder="Kode Pengiriman" class="form-control" type="text">
                    <span class="invalid-feedback"></span>
                  </div>
                </div>
                <div class="col-md-6 col-xs-12">
                  <div class="form-group">
                    <label class="control-label">Nama Penerima</label>
                    <input name="nmpenerima" placeholder="Nama Penerima" class="form-control" type="text">
                    <span class="invalid-feedback"></span>
                  </div>
                </div>
                <div class="col-md-6 col-xs-12">
                  <div class="form-group">
                    <label class="control-label">No Telpon</label>
                    <input name="notelp" placeholder="No Telpon" class="form-control" type="text">
                    <span class="invalid-feedback"></span>
                  </div>
                </div>
                <div class="col-md-6 col-xs-12">
                  <div class="form-group">
                    <label class="control-label">Email</label>
                    <input name="email" placeholder="Email" class="form-control" type="email">
                    <span class="invalid-feedback"></span>
                  </div>
                </div>
                <div class="col-md-12 col-xs-12">
                  <div class="form-group">
                    <label class="control-label">Alamat Jalan</label>
                    <input name="alamat_jalan" placeholder="Alamat Jalan" class="form-control" type="text">
                    <span class="invalid-feedback"></span>
                  </div>
                </div>
                <div class="col-md-4 col-xs-12">
                  <div class="form-group">
                    <label class="control-label">Kabupaten</label>
                    <input name="kabupaten" placeholder="Kabupaten" class="form-control" type="text">
                    <span class="invalid-feedback"></span>
                  </div>
                </div>
                <div class="col-md-4 col-xs-12">
                  <div class="form-group">
                    <label class="control-label">Provinsi</label>
                    <input name="provinsi" placeholder="Provinsi" value="LAMPUNG" class="form-control" type="text">
                    <span class="invalid-feedback"></span>
                  </div>
                </div>
                <div class="col-md-4 col-xs-12">
                  <div class="form-group">
                    <label class="control-label">Negara</label>
                    <input name="negara" placeholder="Negara" value="INDONESIA" class="form-control" type="text">
                    <span class="invalid-feedback"></span>
                  </div>
                </div>
                <div class="col-md-12 col-xs-12">
                  <label class="control-label">Keterangan</label>
                  <textarea class="form-control" name="keterangan" placeholder="Masukan keterangan"></textarea>
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" id="btnSave" onclick="save()" class="btn btn-success">Simpan</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>
  <script>
    $(document).ready(function() {
      $('#idarmada_select2').select2({
        theme: 'bootstrap4',
        ajax: {
          url: '<?= base_url('select2/armada') ?>',
          dataType: 'json',
          data: function(params) {
            var query = {
              search: params.term,
            }
            return query;
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        },
        dropdownParent: $('#modal_form')
      });
    });

    function kirim() {
      $('#modal_form').modal('show')
    }

    function save() {
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled', true);
      $('#btn-kirim').attr('disabled', true);
      const form = $('#form').serialize()
      $.ajax({
        url: "<?= base_url('delivery_order/kirim/' . $penjualan->idt_penjualan) ?>",
        type: "POST",
        data: form,
        dataType: "json",
        success: function(data) {
          console.log(data);
          if (data.status) //if success close modal and reload ajax table
          {
            $('#modal_form').modal('hide')
            Swal({
              title: 'Success',
              text: 'Data Pengiriman Berhasil Dibuat',
              type: 'success'
            });
            setTimeout(window.location.href = "<?= base_url('delivery_order/detail/' . $penjualan->idt_penjualan); ?>", 2000)
          } else {
            $.each(data.errors, function(key, value) {
              $('[name="' + key + '"]').addClass('is-invalid');
              if (key != 'idarmada') {
                $('[name="' + key + '"]').next().text(value);
              }
              if (value == "") {
                $('[name="' + key + '"]').removeClass('is-invalid');
                $('[name="' + key + '"]').addClass('is-valid');
              }
            });
          }
          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 
          $('#btn-kirim').attr('disabled', false);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error adding / update data');
          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 
          $('#btn-kirim').attr('disabled', false);
        }
      });
      $('#form input, #form textarea').on('keyup', function() {
        $(this).removeClass('is-valid is-invalid');
      });
      $('#form select').on('change', function() {
        $(this).removeClass('is-valid is-invalid');
      });
    }
  </script>
<?php } ?>