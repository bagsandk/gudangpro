<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="card-title text-center">Staf</h4>
        <div class="d-flex align-items-center">
          <button class="btn btn-sm btn-outline-warning" onclick="addData()"><i class="fa fa-plus"></i> Tambah</button>
        </div>
      </div>
      <div class="table-responsive">
        <table id="staf-list" class="table table-hover">
          <thead>
            <tr>
              <th>Kode Staf</th>
              <th>Nama Staf</th>
              <th>Jenis Kelamin</th>
              <th>No Telp</th>
              <th>Email</th>
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
        <h5 class="modal-title" id="modal_title">Staf</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="idstaf" />
          <div class="form-body">
            <div class="form-row">
              <div class="col-md-12 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Nama Staf</label>
                  <input name="nmstaf" placeholder="Nama Staf" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Kode Staf</label>
                  <input name="kdstaf" placeholder="Kode Staf" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">NIK</label>
                  <input name="nik" placeholder="NIK" class="form-control" type="number">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Tempat Lahir</label>
                  <input name="tempat_lahir" placeholder="Tempat Lahir" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Tanggal Lahir</label>
                  <input name="tanggal_lahir" placeholder="Tanggal Lahir" class="form-control" type="date">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Jenis Kelamin</label>
                  <select name="sex" class="form-control">
                    <option value="-">-</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                  </select>
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">No Telp</label>
                  <input name="notelp" placeholder="No Telpon" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Email</label>
                  <input name="email" placeholder="Email" class="form-control" type="email">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Alamat Jalan</label>
                  <input name="alamat_jalan" placeholder="Alamat Jalan" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Kabupaten</label>
                  <input name="kabupaten" placeholder="Kabupaten" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Provinsi</label>
                  <input name="provinsi" placeholder="Provinsi" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Negara</label>
                  <input name="negara" placeholder="Negara" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Tanggal Masuk</label>
                  <input name="tgl_masuk" placeholder="Tanggal Masuk" class="form-control" type="date">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Tanggal Berhenti</label>
                  <input name="tgl_berhenti" placeholder="Tanggal Berhenti" class="form-control" type="date">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Jabatan</label>
                  <select data-allow-clear="1" id="idjabatan_select2" name="idjabatan" class="form-control ">
                  </select>
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Pendidikan</label>
                  <select data-allow-clear="1" id="idpendidikan_select2" name="idpendidikan" class="form-control ">
                  </select>
                  <span class="invalid-feedback"></span>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Unit</label>
                  <select data-allow-clear="1" id="idunit_select2" name="idunit" class="form-control ">
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
<!-- Bootstrap modal detail-->
<div class="modal fade" id="modal_detail" data-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Detail Staf</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mx-2 d-flex justify-content-between">
          <p class="text-uppercase font-weight-bold font-italic" id="unit-jabatan-kode-nama"></p>
          <p class="text-uppercase font-weight-bold font-italic" id="masuk-berhenti"></p>
        </div>
        <div class="row d-flex justify-content-center">
          <div class="col-4 my-0 py-0">
            <p class="font-weight-bold my-0 py-0">NIK</p>
          </div>
          <div class="col-8 my-0 py-0">
            <p class="my-0 py-0" id="NIK"></p>
          </div>
          <div class="col-4 my-0 py-0">
            <p class="font-weight-bold my-0 py-0">Tempat Lahir</p>
          </div>
          <div class="col-8 my-0 py-0">
            <p class="my-0 py-0" id="tempat_lahir"></p>
          </div>
          <div class="col-4 my-0 py-0">
            <p class="font-weight-bold my-0 py-0">Tanggal Lahir</p>
          </div>
          <div class="col-8 my-0 py-0">
            <p class="my-0 py-0" id="tanggal_lahir"></p>
          </div>
          <div class="col-4 my-0 py-0">
            <p class="font-weight-bold my-0 py-0">Jenis Kelamin</p>
          </div>
          <div class="col-8 my-0 py-0">
            <p class="my-0 py-0" id="sex"></p>
          </div>
          <div class="col-4 my-0 py-0">
            <p class="font-weight-bold my-0 py-0">No Telpon</p>
          </div>
          <div class="col-8 my-0 py-0">
            <p class="my-0 py-0" id="notelp"></p>
          </div>
          <div class="col-4 my-0 py-0">
            <p class="font-weight-bold my-0 py-0">Email</p>
          </div>
          <div class="col-8 my-0 py-0">
            <p class="my-0 py-0" id="email"></p>
          </div>
          <div class="col-4 my-0 py-0">
            <p class="font-weight-bold my-0 py-0">Alamat Jalan</p>
          </div>
          <div class="col-8 my-0 py-0">
            <p class="my-0 py-0" id="alamat_jalan"></p>
          </div>
          <div class="col-4 my-0 py-0">
            <p class="font-weight-bold my-0 py-0">Kabupaten</p>
          </div>
          <div class="col-8 my-0 py-0">
            <p class="my-0 py-0" id="kabupaten"></p>
          </div>
          <div class="col-4 my-0 py-0">
            <p class="font-weight-bold my-0 py-0">Provinsi</p>
          </div>
          <div class="col-8 my-0 py-0">
            <p class="my-0 py-0" id="provinsi"></p>
          </div>
          <div class="col-4 my-0 py-0">
            <p class="font-weight-bold my-0 py-0">Negara</p>
          </div>
          <div class="col-8 my-0 py-0">
            <p class="my-0 py-0" id="negara"></p>
          </div>
          <div class="col-4 my-0 py-0">
            <p class="font-weight-bold my-0 py-0">Pendidikan</p>
          </div>
          <div class="col-8 my-0 py-0">
            <p class="my-0 py-0" id="pendidikan"></p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
  $(document).ready(function() {
    $('#idjabatan_select2').select2({
      theme: 'bootstrap4',
      ajax: {
        url: '<?= base_url('select2/jabatan') ?>',
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
    $('#idunit_select2').select2({
      theme: 'bootstrap4',
      ajax: {
        url: '<?= base_url('select2/unit') ?>',
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
    $('#idpendidikan_select2').select2({
      theme: 'bootstrap4',
      ajax: {
        url: '<?= base_url('select2/pendidikan') ?>',
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
    table = $('#staf-list').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url('staf/list') ?>",
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
    $('.modal-title').text('Tambah Staf'); // Set Title to Bootstrap modal title
  }

  function edit_data(id) {
    save_label = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?= base_url('staf/edit/') ?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        var idunit = new Option(data.nmunit, data.idunit, true, true);
        var idpendidikan = new Option(data.nmpendidikan, data.idpendidikan, true, true);
        var idjabatan = new Option(data.nmjabatan, data.idjabatan, true, true);
        $('[name="idstaf"]').val(data.idstaf);
        $('[name="kdstaf"]').val(data.kdstaf);
        $('[name="nmstaf"]').val(data.nmstaf);
        $('[name="nik"]').val(data.nik);
        $('[name="tempat_lahir"]').val(data.tempat_lahir);
        $('[name="tanggal_lahir"]').val(data.tanggal_lahir);
        $('[name="sex"]').val(data.sex);
        $('[name="notelp"]').val(data.notelp);
        $('[name="email"]').val(data.email);
        $('[name="alamat_jalan"]').val(data.alamat_jalan);
        $('[name="kabupaten"]').val(data.kabupaten);
        $('[name="provinsi"]').val(data.provinsi);
        $('[name="negara"]').val(data.negara);
        $('[name="tgl_masuk"]').val(data.tgl_masuk);
        $('[name="tgl_berhenti"]').val(data.tgl_berhenti);
        $('[name="idunit"]').append(idunit).trigger('change');
        $('[name="idpendidikan"]').append(idpendidikan).trigger('change');
        $('[name="idjabatan"]').append(idjabatan).trigger('change');
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Staf'); // Set title to Bootstrap modal title
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
      url = "<?= base_url('staf/add') ?>";
      method = 'saved';
    } else {
      url = "<?= base_url('staf/update') ?>";
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
          url: "<?= base_url('staf/delete') ?>/" + id,
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

  function detail_data(id) {
    $.ajax({
      url: "<?= base_url('staf/detail/') ?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        console.log(data);
        $('#unit-jabatan-kode-nama').text(data.nmunit + '/' + data.nmjabatan + '/' + data.kdstaf + '/' + data.nmstaf);
        $('#NIK').text(data.nik);
        $('#tempat_lahir').text(data.tempat_lahir);
        $('#tanggal_lahir').text(data.tanggal_lahir);
        $('#sex').text(((data.sex == 'L') ? 'Laki-laki' : ((data.sex == 'P') ? 'Perempuan' : '-')));
        $('#notelp').text(data.notelp);
        $('#email').text(data.email);
        $('#alamat_jalan').text(data.alamat_jalan);
        $('#kabupaten').text(data.kabupaten);
        $('#provinsi').text(data.provinsi);
        $('#negara').text(data.negara);
        $('#pendidikan').text(data.nmpendidikan + ' (' + data.alias + ')');
        $('#masuk-berhenti').text(data.tgl_masuk + '-' + ((data.tgl_berhenti == '0000-00-00' || data.tgl_berhenti == NULL) ? 'sekarang' : data.tgl_berhenti));
        $('#modal_detail').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Detail Staf'); // Set title to Bootstrap modal title
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }
</script>