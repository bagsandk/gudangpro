<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="card-title text-center">Barang</h4>
        <div class="d-flex align-items-center">
          <button class="btn btn-sm btn-outline-warning" onclick="addData()"><i class="fa fa-plus"></i> Tambah</button>
        </div>
      </div>
      <div class="table-responsive">
        <table id="barang-list" class="table table-hover">
          <thead>
            <tr>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Merek</th>
              <th>Kategori</th>
              <th>Satuan</th>
              <th>Supplier</th>
              <th>Tonase</th>
              <th>Harga Net</th>
              <th>Harga Jual</th>
              <th>Stok</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" data-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="idbarang" />
          <div class="form-body">
            <div class="form-row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Kode Barang</label>
                  <input name="kdbarang" placeholder="Kode Barang" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Merek</label>
                  <input name="merek" placeholder="Merek" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Nama Barang</label>
                  <input name="nmbarang" placeholder="Nama Barang" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Kategori Barang</label>
                  <select data-allow-clear="1" id="idkategori_select2" name="idkategori" class="form-control ">
                  </select>
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Satuan Barang</label>
                  <select data-allow-clear="1" id="idsatuan_select2" name="idsatuan" class="form-control ">
                  </select>
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Supplier</label>
                  <select data-allow-clear="1" id="idsupplier_select2" name="idsupplier" class="form-control ">
                  </select>
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Tonase</label>
                  <input name="tonase" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Harga Net</label>
                  <input name="harga_net" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Harga Jual</label>
                  <input name="harga_jual" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
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
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script type="text/javascript">
  $(document).ready(function() {
    $('#idkategori_select2').select2({
      theme: 'bootstrap4',
      ajax: {
        url: '<?= base_url('select2/barang_kategori') ?>',
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
    $('#idsatuan_select2').select2({
      theme: 'bootstrap4',
      ajax: {
        url: '<?= base_url('select2/barang_satuan') ?>',
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
    $('#idsupplier_select2').select2({
      theme: 'bootstrap4',
      ajax: {
        url: '<?= base_url('select2/supplier') ?>',
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
  })
</script>

<script type="text/javascript">
  var save_label;
  var table;

  $(document).ready(function() {
    //DataTable
    table = $('#barang-list').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url('barang/list') ?>",
        "type": "POST"
      },
      "columnDefs": [{
        "targets": [-1],
        "orderable": false,
      }],
    });

    $('#modal_form').on('hidden.bs.modal', function(e) {
      var inputs = $('#form input, #form textarea, #form select');
      inputs.removeClass('is-valid is-invalid');
    });
  });

  function swalert(method) {
    Swal({
      title: 'Success',
      text: 'Data has been ' + method,
      type: 'success'
    });
  };

  function addData() {
    save_label = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Barang'); // Set Title to Bootstrap modal title
  }

  function edit_data(id) {
    save_label = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?= base_url('barang/edit/') ?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        var idkategori = new Option(data.nmkategori, data.idkategori, true, true);
        var idsatuan = new Option(data.nmsatuan, data.idsatuan, true, true);
        var idsupplier = new Option(data.nmsupplier, data.idsupplier, true, true);
        $('[name="idbarang"]').val(data.idbarang);
        $('[name="kdbarang"]').val(data.kdbarang);
        $('[name="nmbarang"]').val(data.nmbarang);
        $('[name="merek"]').val(data.merek);
        $('[name="idkategori"]').append(idkategori).trigger('change');
        $('[name="idsatuan"]').append(idsatuan).trigger('change');
        $('[name="idsupplier"]').append(idsupplier).trigger('change');
        $('[name="tonase"]').val(data.tonase);
        $('[name="harga_net"]').val(data.harga_net);
        $('[name="harga_jual"]').val(data.harga_jual);
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Barang'); // Set title to Bootstrap modal title
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function reload() {
    table.ajax.reload(null, false); //reload datatable ajax 
  }

  function save() {
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 
    var url, method;

    if (save_label == 'add') {
      url = "<?= base_url('barang/add') ?>";
      method = 'saved';
    } else {
      url = "<?= base_url('barang/update') ?>";
      method = 'updated'
    }

    // ajax adding data to database
    $.ajax({
      url: url,
      type: "POST",
      data: $('#form').serialize(),
      dataType: "json",
      success: function(data) {
        //console.log(data);
        if (data.status) //if success close modal and reload ajax table
        {
          $('#modal_form').modal('hide');
          reload();
          swalert(method);
        } else {
          $.each(data.errors, function(key, value) {
            $('[name="' + key + '"]').addClass('is-invalid'); //select parent twice to select div form-group class and add has-error class
            if ($('[name="' + key + '"]').is("select")) {
              $('[name="' + key + '"]').next().next().text(value); //select span help-block class set text error string
            } else {
              $('[name="' + key + '"]').next().text(value); //select span help-block class set text error string
            }
            if (value == "") {
              $('[name="' + key + '"]').removeClass('is-invalid');
              $('[name="' + key + '"]').addClass('is-valid');
            }
          });
        }
        $('#btnSave').text('save'); //change button text
        $('#btnSave').attr('disabled', false); //set button enable 
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
        $('#btnSave').text('save'); //change button text
        $('#btnSave').attr('disabled', false); //set button enable 
      }
    });

    $('#form input, #form textarea').on('keyup', function() {
      $(this).removeClass('is-valid is-invalid');
    });
    $('#form select').on('change', function() {
      $(this).removeClass('is-valid is-invalid');
    });
  }

  function delete_data(id) {
    Swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        // ajax delete data to database
        $.ajax({
          url: "<?= base_url('barang/delete') ?>/" + id,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            reload();
            swalert('deleted');
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error deleting data');
          }
        });
      }
    });
  }
</script>