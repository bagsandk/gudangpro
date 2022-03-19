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
      <div class="d-flex justify-content-end">
        <?php if ($penjualan->status == 'PROSES') { ?>
          <button type="button" onclick="kirim()" id="btn-kirim" class="btn btn-warning ml-2">Kirim barang</button>
        <?php } ?>
      </div>
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
          //console.log(data);
          if (data.status) //if success close modal and reload ajax table
          {
            $('#modal_form').modal('hide')
            Swal({
              title: 'Success',
              text: 'Data Pengiriman Berhasil Dibuat',
              type: 'success'
            });
            window.location.reload();
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