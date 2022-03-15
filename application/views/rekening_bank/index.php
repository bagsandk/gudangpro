<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="card-title text-center">Rekening Bank</h4>
        <div class="d-flex align-items-center">
          <button class="btn btn-sm btn-outline-warning" onclick="addData()"><i class="fa fa-plus"></i> Tambah</button>
        </div>
      </div>
      <div class="table-responsive">
        <table id="rekening_bank_list" class="table table-hover">
          <thead>
            <tr>
              <th>No Rekening</th>
              <th>Nama Bank</th>
              <th>Cabang</th>
              <th>Nama Nasabah</th>
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
        <h5 class="modal-title" id="modal_title">Rekening Bank</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="idrekeningbank" />
          <div class="form-body">
            <div class="form-row">
              <div class="col-md-12 col-xs-12">
                <div class="form-group">
                  <label class="control-label">No Rekening</label>
                  <input name="norekening" placeholder="No Rekening" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Nama Bank</label>
                  <input name="nmbank" placeholder="Nama Bank" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Cabang</label>
                  <input name="cabang" placeholder="Cabang" class="form-control" type="text">
                  <span class="invalid-feedback"></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Nama Nasabah</label>
                  <input name="nmnasabah" placeholder="Nama Nasabah" class="form-control" type="text">
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
  var save_label;
  var table;

  $(document).ready(function() {
    //DataTable
    table = $('#rekening_bank_list').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url('rekening_bank/list') ?>",
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
    $('.modal-title').text('Tambah Rekening Bank'); // Set Title to Bootstrap modal title
  }

  function edit_data(id) {
    save_label = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?= base_url('rekening_bank/edit/') ?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('[name="idrekeningbank"]').val(data.idrekeningbank);
        $('[name="norekening"]').val(data.norekening);
        $('[name="nmbank"]').val(data.nmbank);
        $('[name="cabang"]').val(data.cabang);
        $('[name="nmnasabah"]').val(data.nmnasabah);
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Rekening Bank'); // Set title to Bootstrap modal title
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
      url = "<?= base_url('rekening_bank/add') ?>";
      method = 'saved';
    } else {
      url = "<?= base_url('rekening_bank/update') ?>";
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
            $('[name="' + key + '"]').next().text(value); //select span help-block class set text error string
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
          url: "<?= base_url('rekening_bank/delete') ?>/" + id,
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