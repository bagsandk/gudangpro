<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <form>
        <div class="form-row">
          <div class="col-md-3">
            <div class="form-group">
              <label class="control-label">No Faktur</label>
              <input name="nofaktur" placeholder="No Faktur" class="form-control" type="text">
              <span class="invalid-feedback"></span>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label class="control-label">Tanggal</label>
              <input name="tgl_transaksi" type="date" class="form-control">
              <span class="invalid-feedback"></span>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label class="control-label">Jenis DO</label>
              <select name="jenis_do" class="form-control" type="text">
                <option>Pilih</option>
                <option value="TAKEIT">TAKEIT</option>
                <option value="DELIVERY">DELIVERY</option>
                <option value="KURIR">KURIR</option>
              </select>
              <span class="invalid-feedback"></span>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label class="control-label">Pelanggan</label>
              <select id="idpelanggan" name="idpelanggan" class="form-control" type="text">
                <option>Pilih</option>
              </select>
              <span class="invalid-feedback"></span>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table id="input-penjualan" class="table">
            <thead class="bg-secondary text-white">
              <tr>
                <th style="width: 200px;">Barang</th>
                <th style="width: 170px;">Harga</th>
                <th style="width: 80px;">Qty</th>
                <th style="width: 80px;">Tonase</th>
                <th style="width: 80px;">Diskon %</th>
                <th style="width: 150px;">Total</th>
                <th class="text-right">
                  <button onclick="addItem()" type="button" class="btn btn-info btn-sm">
                    <i class="fa fa-plus"></i>
                  </button>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr id="baris-0">
                <td>
                  <select style="width: 200px;" name="idbarang[]" class="form-control idbarang" type="text">
                    <option>Pilih</option>
                  </select>
                </td>
                <td><input id="harga_jual-0" name="harga_jual[]" style="width: 170px;" type="text" placeholder="Harga" class="form-control harga_jual"></td>
                <td><input value="0" id="qty-0" name="qty[]" type="number" style="width: 70px;" class="form-control qty"></td>
                <td><input value="0" id="tonase-0" name="tonase[]" type="number" style="width: 70px;" class="form-control tonase"></td>
                <td><input value="0" id="diskon-0" name="diskon[]" type="text" style="width: 70px;" class="form-control diskon"></td>
                <td id="total-0">0</td>
                <td class="text-right"></td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="4"></td>
                <td span="">Total Harga</td>
                <td id="total-semua">0</td>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <textarea class="form-control" placeholder="Keterangan" name="keterangan"></textarea>
        <button type="button" class="btn btn-success mt-3 float-right">Simpan</button>
      </form>
    </div>
  </div>
</div>

<script>
  function selectBarang() {
    $('.idbarang').select2({
      theme: 'bootstrap4',
      ajax: {
        url: '<?= base_url('select2/barang') ?>',
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
    });
  }
  $(document).ready(function() {
    $('#idpelanggan').select2({
      theme: 'bootstrap4',
      ajax: {
        url: '<?= base_url('select2/pelanggan') ?>',
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
    });
    selectBarang()
    checkInputMask()
  })

  function checkInputMask() {
    $('.harga_jual').mask('00000000000', {
      reverse: true
    });
    $('.qty').mask('00', {
      reverse: true
    });
    $('.tonase').mask('00', {
      reverse: true
    });
    $('.diskon').mask('00', {
      reverse: true
    });
  }

  function addItem() {
    let baris = parseInt($('#input-penjualan > tbody tr:last').attr('id').split('-')[1]);
    console.log(baris)
    $('tbody').append(`<tr id="baris-${baris+1}">
                <td> <select style="width: 200px;" name="idbarang[]" class="form-control idbarang" type="text">
                    <option>Pilih</option>
                  </select></td>
                <td><input id="harga_jual-${baris+1}" name="harga_jual[]" style="width: 170px;" type="text" placeholder="Harga" class="form-control harga_jual"></td>
                <td><input id="qty-${baris+1}" value="0" name="qty[]" type="number" style="width: 70px;" class="form-control qty"></td>
                <td><input id="tonase-${baris+1}" value="0" name="tonase[]" type="number" style="width: 70px;" class="form-control tonase"></td>
                <td><input id="diskon-${baris+1}" value="0" name="diskon[]" type="text" style="width: 70px;" class="form-control diskon"></td>
                <td id="total-${baris+1}">0</td>
                <td class="text-right"><button onclick="deleteItem(this)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-minus"></i></button></td>
              </tr>`)
    selectBarang()
    checkInputMask()
  }

  $('body').on('input', '.harga_jual', function() {
    hitungRow(this)
  });
  $('body').on('input', '.qty', function() {
    hitungRow(this)
  });
  $('body').on('input', '.diskon', function() {
    hitungRow(this)
  });

  function hitungRow(element) {
    var baris = $(element).attr('id').split('-')[1];
    var price = parseFloat($('#harga_jual-' + baris).val().replace('.', '')) || 0;
    var qty = parseInt($('#qty-' + baris).val()) || 0;
    var diskon = parseInt($('#diskon-' + baris).val()) || 0;
    var total = price * qty;
    var fixTotal = total - (total * diskon / 100)
    var totalrp = new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR"
    }).format(fixTotal);
    $('#total-' + baris).text(totalrp);
    hitung()
  }

  function hitung() {
    let total = 0;
    $('#input-penjualan > tbody  > tr').each(function(i) {
      total += parseFloat(Number($('#total-' + i).text().replace(/,.*|[^0-9]/g, '')))
    });
    console.log()
    var totalrp = new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR"
    }).format(total);
    $('#total-semua').text(totalrp)
  }

  function deleteItem(element) {
    $(element).closest("tr").remove();
  }
</script>