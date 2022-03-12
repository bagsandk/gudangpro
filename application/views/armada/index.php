<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="card-title text-center">Armada</h4>
        <div class="d-flex align-items-center">
          <button class="btn btn-sm btn-outline-warning" onclick="addData()"><i class="fa fa-plus"></i> Tambah</button>
        </div>
      </div>
      <div class="table-responsive">
        <table id="armada-list" class="table table-hover">
          <thead>
            <tr>
              <th>Kode Armada</th>
              <th>Nomor Plat</th>
              <th>Jenis Armada</th>
              <th>Daya Angkut</th>
              <th>No Stnk</th>
              <th>Tgl Pajak</th>
              <th>Staf</th>
              <th>Kondisi</th>
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
        <h5 class="modal-title" id="modal_title">Armada</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="idarmada" />
          <div class="form-body">
            <div class="form-row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Kode Armada</label>
                  <input name="kdarmada" placeholder="Kode Armada" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">No Plat</label>
                  <input name="nomor_plat" placeholder="No Plat" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Jenis Armada</label>
                  <select data-allow-clear="1" id="idjenis_armada_select2" name="idjenis_armada" class="form-control ">
                  </select>
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Daya Angkut</label>
                  <input name="daya_angkut" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Tgl Pajak</label>
                  <input name="tglpajak" class="form-control" type="date">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">No STNK</label>
                  <input name="nostnk" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Staf</label>
                  <select id="idstaf_select2" name="idstaf" class="form-control ">
                  </select>
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Kondisi</label>
                  <select name="kondisi_armada" class="form-control">
                    <option value="BAIK">BAIK</option>
                    <option value="RUSAK-RINGAN">RUSAK-RINGAN</option>
                    <option value="RUSAK-BERAT">RUSAK-BERAT</option>
                    <option value="PERBAIKAN">PERBAIKAN</option>
                  </select>
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
    $('#idjenis_armada_select2').select2({
      theme: 'bootstrap4',
      ajax: {
        url: '<?= base_url('select2/armada_jenis') ?>',
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
    $('#idstaf_select2').select2({
      theme: 'bootstrap4',
      ajax: {
        url: '<?= base_url('select2/staf') ?>',
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
    table = $('#armada-list').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url('armada/list') ?>",
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
    $('.modal-title').text('Tambah Armada'); // Set Title to Bootstrap modal title
  }

  function edit_data(id) {
    save_label = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?= base_url('armada/edit/') ?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        var idjenis_armada = new Option(data.nmjenis_armada, data.idjenis_armada, true, true);
        var idstaf = new Option(data.nmstaf, data.idstaf, true, true);
        $('[name="idarmada"]').val(data.idarmada);
        $('[name="kdarmada"]').val(data.kdarmada);
        $('[name="nomor_plat"]').val(data.nomor_plat);
        $('[name="idjenis_armada"]').append(idjenis_armada).trigger('change');
        $('[name="daya_angkut"]').val(data.daya_angkut);
        $('[name="nostnk"]').val(data.nostnk);
        $('[name="tglpajak"]').val(data.tglpajak);
        $('[name="idstaf"]').append(idstaf).trigger('change');
        $('[name="kondisi_armada"]').val(data.kondisi_armada);
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Armada'); // Set title to Bootstrap modal title
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
      url = "<?= base_url('armada/add') ?>";
      method = 'saved';
    } else {
      url = "<?= base_url('armada/update') ?>";
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
          url: "<?= base_url('armada/delete') ?>/" + id,
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