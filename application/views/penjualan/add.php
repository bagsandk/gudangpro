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
                <th>Barang</th>
                <th>Harga</th>
                <th style="width: 100px;">Qty</th>
                <th style="width: 100px;">Diskon %</th>
                <th style="width: 200px;">Total</th>
                <th class="text-right">
                  <button onclick="pilihBarang()" type="button" class="btn btn-info btn-sm">
                    <i class="fa fa-plus"></i>
                  </button>
                </th>
              </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
              <tr>
                <td colspan="3"></td>
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


<div class="modal fade" id="modal_form" data-backdrop="static" tabindex="-1" role="dialog">
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
          <div id="listbarang" class="row col-md-12">
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<script>
  $(document).ready(function() {
    $.ajax({
      url: '<?= base_url('ajax/get_barang') ?>',
      method: 'GET',
      success: function(data) {
        $('#listbarang').html(data);
      }
    });
  })

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

  function pilihBarang() {
    $('#modal_form').modal('show')
  }

  function addItem(item) {

    var harga = new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR"
    }).format(parseFloat(item.harga_jual));
    let as = $(`#baris-${item.idbarang}`).attr('id')
    if (as) {
      return alert('sudah ada')
    }
    $('tbody').append(`<tr id="baris-${item.idbarang}">
                <td>
                  <div class="">
                    <p class="m-0">${item.nmbarang} | ${item.merek}</p>
                    <small class="text-secondary">${item.nmsatuan}</small><br>
                    <small class="text-secondary">${item.nmkategori}</small><br>
                  </div>
                </td>
                <td id="harga_jual-${item.idbarang}">
                ${harga}
                </td>
                <td><input value="0" id="qty-${item.idbarang}" name="qty[]" type="number" class="form-control qty"></td>
                <td><input value="0" id="diskon-${item.idbarang}" name="diskon[]" type="text" class="form-control diskon"></td>
                <td id="total-${item.idbarang}">0</td>
                <td class="text-right"><button onclick="deleteItem(this)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-minus"></i></button></td>
              </tr>`)
    selectBarang()
    checkInputMask()
  }

  $('body').on('input', '.qty', function() {
    hitungRow(this)
  });
  $('body').on('input', '.diskon', function() {
    hitungRow(this)
  });

  function hitungRow(element) {
    var baris = $(element).attr('id').split('-')[1];
    var price = parseFloat(Number($('#harga_jual-' + baris).text().replace(/,.*|[^0-9]/g, '')))
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
    $('#input-penjualan > tbody  > tr').each(function() {
      var baris = $(this).attr('id').split('-')[1]
      total += parseFloat(Number($('#total-' + baris).text().replace(/,.*|[^0-9]/g, '')))
    });
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