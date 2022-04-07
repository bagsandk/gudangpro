<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <div class="col-12 d-flex justify-content-between mt-4">
        <div class="col-4 text-left">
          <img width="150" src="<?= base_url('assets/images/logo-1.png') ?>" />
        </div>
        <div class="col-4 text-center">
          <p>PT.Central Artha Ulam</p>
        </div>
        <div class="col-4 text-right">
          <p>01 Jan 2020 10:20</p>
        </div>
      </div>
      <h3 class="text-center text-weight-bold">FAKTUR PENJUALAN</h3>
      <div class="col-12 d-flex justify-content-between mt-4">
        <div class="col-4 text-left">
          <p>Jl. Soekarno Hatta No.10, Rajabasa Raya, Kec. Rajabasa, Kota Bandar Lampung, Lampung 35141</p>
        </div>
        <div class="col-4 text-center">
          <tr>
            <td style="padding:3px">Tanggal</td>
            <td style="padding:3px">:</td>
            <td style="padding:3px"><?= $penjualan->tgl_transaksi ?></td>
          </tr>
          <tr>
            <td style="padding:3px">Faktur</td>
            <td style="padding:3px">:</td>
            <td style="padding:3px"><?= $penjualan->nofaktur ?></td>
          </tr>
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
            foreach ($detail as $item) : ?>
              <?php $total = $item->harga_jual * $item->qty;
              $tonase += $item->tonase;
              $totalFix = $total - ($item->qty * $item->discount); ?>
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
              <td id="total-semua">Rp <?= $tonase ?></td>
              <td></td>
              <td span="">Total</td>
              <td class="" id="total-semua">Rp <?= number_format($penjualan->total, 2) ?></td>
            </tr>
            <tr>
              <td colspan="5"></td>
              <td span="">Ongkir</td>
              <td class="" id="total-semua">Rp <?= number_format($tonase * 60, 2) ?></td>
            </tr>
            <tr>
              <td colspan="5"></td>
              <td span="">Grand Total</td>
              <td class="text-danger" id="total-semua">Rp <?= number_format($penjualan->total + $tonase * 60, 2) ?></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <small class="mb-4">ket: <?= $penjualan->keterangan ?></small>
      <h4 class="text-capitalize mt-4">Terbilang : <?= terbilang($penjualan->total + $tonase * 60) ?></h4>
      <p>Memo : *</p>
      <div class="d-flex justify-content-end">
        <?php if ($penjualan->status == 'BELUM BAYAR') { ?>
          <button type="button" class="btn btn-danger">Batalkan</button>
          <!-- <button type="button" class="btn btn-info ml-2">Edit</button> -->
          <button onclick="bayar()" id="btn-bayar" type="button" class="btn btn-success ml-2">Bayar</button>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php if ($penjualan->status == 'BELUM BAYAR') { ?>
  <div class="modal fade" id="modal_form" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered  modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title">Input Pembayaran <span class="badge badge-warning"><?= $penjualan->nofaktur ?></span> </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body form">
          <form action="#" id="form" class="form-horizontal">
            <div class="form-body">
              <div class="form-row">
                <div class="col-md-6 col-xs-12">
                  <div class="form-group">
                    <label class="control-label">Kode Bayar</label>
                    <input name="kdtp_penjualan" placeholder="Kode bayar" class="form-control" type="text">
                    <span class="invalid-feedback"></span>
                  </div>
                </div>
                <div class="col-md-6 col-xs-12">
                  <div class="form-group">
                    <label class="control-label">Tanggal</label>
                    <input name="tgl_pembayaran" placeholder="" class="form-control" type="datetime-local">
                    <span class="invalid-feedback"></span>
                  </div>
                </div>
                <div class="col-md-12 col-xs-12">
                  <label class="control-label">Metode Bayar</label>
                  <div class="form-group">
                    <?php foreach ($metodebayar as $i => $mb) { ?>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" checked="<?= $i === 0 ? 'true' : 'false' ?>" type="radio" value="<?= $mb->idmetode_bayar ?>" name="idmetode_bayar" id="metode_bayar-<?= $i ?>" value="option1">
                        <label class="form-check-label" for="metode_bayar-<?= $i ?>"><?= $mb->metode_bayar ?></label>
                      </div>
                    <?php } ?>
                  </div>

                </div>
                <div class="col-md-12 col-xs-12">
                  <label class="control-label">Status Bayar</label>
                  <div class="form-group">
                    <?php foreach ($statusbayar as $i => $mb) { ?>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" checked="<?= $i === 0 ? 'true' : 'false' ?>" type="radio" value="<?= $mb->idstatus_bayar ?>" name="idstatus_bayar" id="status_bayar-<?= $i ?>">
                        <label class="form-check-label" for="status_bayar-<?= $i ?>"><?= $mb->status_bayar ?></label>
                      </div>
                    <?php } ?>
                  </div>
                </div>
                <div id="rekening-bank" class="col-md-12 col-xs-12">
                  <button type="button" id="btn-pilih-rekening" style="display: none;" onclick="pilihRekening()" class="btn btn-info btn-sm col-12">Pilih Rekening</button>
                  <input type="hidden" name="idrekeningbank">
                  <div id="card-rekening">

                  </div>
                </div>
                <div class="col-md-12 col-xs-12">
                  <label class="control-label">Total Bayar</label>
                  <input name="total" placeholder="" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
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
  <div class="modal fade" id="modal_rekening_bank" tabindex="-1000000" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title">Pilih Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body form">
          <form action="#" id="form" class="form-horizontal">
            <div class="form-body">
              <div class="form-row">
                <div class="col-md-12 col-xs-12">
                  <div class="form-group">
                    <input name="q" placeholder="Cari" class="form-control" type="search">
                  </div>
                </div>
              </div>
            </div>
            <div id="listrekeningbank" class="row col-md-12">
            </div>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>
  <script>
    $(document).ready(function() {
      $.ajax({
        url: '<?= base_url('ajax/transaksi/get_rekening_bank') ?>',
        method: 'GET',
        success: function(data) {
          $('#listrekeningbank').html(data);
        }
      });
    })

    function bayar() {
      $('#modal_form').modal('show')
    }

    function pilihRekening() {
      $('#modal_rekening_bank').modal('show')
    }

    function tambahRekening(item) {
      let html = `<div class="card">
						<div class="card-body">
							<div class="d-flex justify-content-between">
								<div class="">
									<p class="m-0 text-info">No Rek : ${item.norekening}</p>
									<small class="text-secondary">AN : ${item.nmnasabah}</small><br>
                  </div>
                  <div class="text-right">
									<p class="m-0 text-warning">Bank ${item.nmbank}</p>
									<small class="text-secondary">Cabang : ${item.cabang}</small><br>
								</div>
							</div>
						</div>
					</div>`
      $('#card-rekening').html(html)
      console.log(item.idrekeningbank)
      $('[name="idrekeningbank"]').val(item.idrekeningbank)
      $('#modal_rekening_bank').modal('toggle')

    }
    $('[name="idmetode_bayar"]').change(function() {
      const val = $(this).val()
      if (val != 1) {
        $('#btn-pilih-rekening').show()
      } else {
        $('#btn-pilih-rekening').hide()
        $('#card-rekening').html('')
      }
    })

    function save() {
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled', true);
      $('#btn-bayar').attr('disabled', true);
      const form = $('#form').serialize();
      $.ajax({
        url: "<?= base_url('pembayaran/tambahPembayaran/' . $penjualan->idt_penjualan) ?>",
        type: "POST",
        data: form,
        dataType: "json",
        success: function(data) {
          if (data.status) //if success close modal and reload ajax table
          {
            $('#btn-bayar').attr('disable', true);
            Swal({
              title: 'Success',
              text: 'Data Penjualan Berhasil Ditambah',
              type: 'success'
            });
            window.location.reload();
          } else {
            $.each(data.errors, function(key, value) {
              $('[name="' + key + '"]').addClass('is-invalid');
              if (key != 'idmetode_bayar' && key != 'idstatus_bayar') {
                $('[name="' + key + '"]').next().text(value);
              }
              if (value == "") {
                $('[name="' + key + '"]').removeClass('is-invalid');
                $('[name="' + key + '"]').addClass('is-valid');
              }
            });
          }
          $('#btnSave').text('save');
          $('#btnSave').attr('disabled', false);
          $('#btn-bayar').attr('disabled', false);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error adding / update data');
          $('#btnSave').text('save');
          $('#btnSave').attr('disabled', false);
          $('#btn-bayar').attr('disabled', false);
        }
      });
    }
  </script>
<?php } ?>