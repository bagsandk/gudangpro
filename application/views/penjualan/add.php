<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <form id="form">
        <div class="form-row">
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">No Faktur</label>
                  <input name="nofaktur" placeholder="No Faktur" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Tanggal</label>
                  <input name="tgl_transaksi" type="date" class="form-control">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Jenis DO</label>
                  <select name="jenis_do" class="form-control" type="text">
                    <option value="">Pilih</option>
                    <option value="TAKEIT">TAKEIT</option>
                    <option value="DELIVERY">DELIVERY</option>
                    <option value="KURIR">KURIR</option>
                  </select>
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Pelanggan</label>
                  <select id="idpelanggan" name="idpelanggan" class="form-control" type="text">
                    <option value="">Pilih</option>
                  </select>
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card" style="padding: 0px;">
              <div class="card-body p-auto m-0">
                <h1 class="text-right text-danger my-auto py-3" id="grand-total">0</h1>
              </div>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table id="input-penjualan" class="table">
            <thead class="bg-secondary text-white">
              <tr>
                <th style="min-width: 180px;">Barang</th>
                <th style="min-width: 150px;">Harga</th>
                <th style="width: 200px;">Qty</th>
                <th style="width: 10px;">Tonase</th>
                <th style="width: 100px;">Diskon(Rp/Qty)</th>
                <th style="width: 200px;">Total Diskon</th>
                <th style="width: 200px;">Sub Total</th>
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
                <td colspan="5"></td>
                <td span="">Grand Total</td>
                <td class="text-danger" id="total-semua">0</td>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <textarea class="form-control" placeholder="Keterangan" name="keterangan"></textarea>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6 row">
              <div class="col-md-4">
                <div class="form-group  ">
                  <label class="control-label">Total Tonase</label>
                  <input id="total-tonase" readonly class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Ongkir</label>
                  <input readonly id="ongkir" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-4 pb-1 mt-1">
                <button style="width: 100%;" disabled="true" id="btnTambah" onclick="simpan()" type="button" class="btn btn-success mt-4 mb-0">Simpan</button>
              </div>
            </div>
          </div>

        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="modal_form" data-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
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
      url: '<?= base_url('ajax/transaksi/get_barang') ?>',
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

    $('.qty').mask('00000', {
      reverse: true
    });

    $('.discount').mask('000000000', {
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
            <input type="hidden" value="${item.idbarang}" name="idbarang[${item.idbarang}]" />
                <td>
                  <div class="">
                    <p class="m-0 text-info">${item.nmbarang  }</p>
                    <p class="m-0">${item.merek}</p>
                    <small class="text-secondary">Satuan :${item.nmsatuan}</small><br>
                    <small class="text-secondary">Kat : ${item.nmkategori}</small><br>
                  </div>
                </td>
                <td id="harga_jual-${item.idbarang}">
                ${harga}
                </td>
                <td><input style="min-width:100px" value="1" id="qty-${item.idbarang}" name="qty[${item.idbarang}]" type="number" class="form-control qty"><span style="width:150px;" class=" text-wrap invalid-feedback"></span></td>
                <td id="tonase-${item.idbarang}">
                ${item.tonase}
                </td>
                <td><input value="" id="discount-${item.idbarang}" name="discount[${item.idbarang}]" type="text" class="form-control discount"><span style="width:150px;" class=" text-wrap invalid-feedback"></span></span></td>
                <td id="total-diskon-${item.idbarang}">Rp 0,00</td>
                <td id="total-${item.idbarang}">${harga}</td>
                <td class="text-right"><button onclick="deleteItem(this)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-minus"></i></button></td>
              </tr>`)
    selectBarang()
    checkInputMask()
    checkBtn();
    hitung()
    $('#modal_form').modal('toggle')

  }

  function checkBtn() {
    const sumTR = $('#input-penjualan > tbody  > tr').length
    if (sumTR > 0) {
      $('#btnTambah').attr('disabled', false); //set button enable 
    } else {
      $('#btnTambah').attr('disabled', true); //set button enable 
    }
  }
  $('body').on('input', '.qty', function() {
    hitungRow(this)
  });
  $('body').on('input', '.discount', function() {
    hitungRow(this)
  });

  function hitungRow(element) {
    var baris = $(element).attr('id').split('-')[1];
    var price = parseFloat(Number($('#harga_jual-' + baris).text().replace(/,.*|[^0-9]/g, '')))
    var qty = parseInt($('#qty-' + baris).val()) || 0;
    var discount = parseInt($('#discount-' + baris).val()) || 0;
    var total = price * qty;
    var diskon = qty * discount
    var fixTotal = total - diskon
    console.log(discount)
    var totalrp = new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR"
    }).format(fixTotal);
    var totalDiskon = new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR"
    }).format(diskon);
    $('#total-' + baris).text(totalrp);
    $('#total-diskon-' + baris).text(totalDiskon);
    hitung()
  }

  function hitung() {
    let total = 0;
    let tonase = 0;
    $('#input-penjualan > tbody  > tr').each(function() {
      var baris = $(this).attr('id').split('-')[1]
      total += parseFloat(Number($('#total-' + baris).text().replace(/,.*|[^0-9]/g, '')))
      tonase += parseInt($('#tonase-' + baris).text().replace(/,.*|[^0-9]/g, ''))
    });
    const ongkir = 60 * tonase
    var totalrp = new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR"
    }).format(total + ongkir);
    var ongkiCur = new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR"
    }).format(ongkir);
    $('#total-semua').text(totalrp)
    $('#grand-total').text(totalrp)
    $('#total-tonase').val(tonase)
    $('#ongkir').val(ongkiCur)
  }

  function deleteItem(element) {
    $(element).closest("tr").remove();
    checkBtn();
    hitung()
  }

  function simpan() {

    $('#btnTambah').text('saving...'); //change button text
    $('#btnTambah').attr('disabled', true);
    const form = $('#form').serialize()
    console.log(form)
    $.ajax({
      url: "<?= base_url('penjualan/tambahPenjualan') ?>",
      type: "POST",
      data: form,
      dataType: "json",
      success: function(data) {
        //console.log(data);
        if (data.status) //if success close modal and reload ajax table
        {
          Swal({
            title: 'Success',
            text: 'Data Penjualan Berhasil Ditambah',
            type: 'success'
          });
          window.location.href = "<?= base_url('penjualan'); ?>";
        } else {
          $.each(data.errors, function(key, value) {
            if (key === 'idpelanggan') {
              $('[name="' + key + '"]').addClass('is-invalid');
              $('[name="' + key + '"]').next().next().text(value); //select span help-block class set text error string
            } else if (key === 'qty') {
              $.each(value, function(id, val) {
                console.log(id)
                $('[name="' + id + '"]').addClass('is-invalid');
                $('[name="' + id + '"]').next().text(val);
                if (val == "") {
                  $('[name="' + id + '"]').removeClass('is-invalid');
                  $('[name="' + id + '"]').addClass('is-valid');
                } //select span help-block class set text error string
              })
            } else if (key === 'discount') {
              $.each(value, function(id, val) {
                console.log(id)
                $('[name="' + id + '"]').addClass('is-invalid');
                $('[name="' + id + '"]').next().text(val);
                if (val == "") {
                  $('[name="' + id + '"]').removeClass('is-invalid');
                  $('[name="' + id + '"]').addClass('is-valid');
                }
              })
            } else {
              $('[name="' + key + '"]').addClass('is-invalid');
              $('[name="' + key + '"]').next().text(value); //select span help-block class set text error string
            } //select parent twice to select div form-group class and add has-error class
            if (value == "") {
              $('[name="' + key + '"]').removeClass('is-invalid');
              $('[name="' + key + '"]').addClass('is-valid');
            }
          });
        }
        $('#btnTambah').text('save'); //change button text
        $('#btnTambah').attr('disabled', false); //set button enable 
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
        $('#btnTambah').text('save'); //change button text
        $('#btnTambah').attr('disabled', false); //set button enable 
      }
    });
  }
</script>