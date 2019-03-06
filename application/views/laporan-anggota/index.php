 <!-- DataTables -->
<link href="<?php echo base_url('assets/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet">

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <span class="<?php echo $icon; ?>"></span> <?php echo $title; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard/index'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> <?php echo $title?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <?php echo validation_errors(); ?>
          <div class="box box-primary">
            <!-- form start -->
            <form class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <div class="col-sm-1">
                    <label class="col-sm-2 control-label">Status</label>
                  </div>
                  <div class="col-sm-7">
                    <select class="form-control" id="status">
                      <option value="1">AKTIF</option>
                      <option value="0">TDK AKTIF</option>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <button type="button" id="btn-tampilkan" class="form-control btn btn-primary"><i class="fa fa-refresh"></i> Tampilkan</button>
                  </div>
                  <div class="col-sm-2">
                    <button type="button" id="btn-download-pdf" class="form-control btn btn-danger"><i class="fa fa-file-pdf-o"></i> Download PDF</button>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            </form>
          </div>
          <!-- /.box -->

          <div class="box box-primary" id="box-anggota">
            <!-- form start -->
            <form id="form-pinjam" role="form" action="#">
              <div class="box-body">  
                  <!-- <div class="table-responsive"> -->
                  <table id="table-laporan-anggota" class="table table-bordered table-striped" style="width:100%">
                     <thead>
                          <tr>
                            <th>No</th>
                            <th>Anggota</th>
                            <th>Identitas</th>
                            <th>Alamat</th>
                            <th>Status</th>
                          </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                  </table>
              </div>
              <!-- /.box-body -->
          </form>
        </div>


        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- DataTables -->
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script>
  $(document).ready(function(){
    $("#box-anggota").hide();
    //datatables
    table = $('#table-laporan-anggota').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "order": [], 
        
        "ajax": {
            "url": "<?php echo base_url('laporanAnggota/ajaxGetAnggota')?>",
            "type": "POST",
            "data": function (data) {
                      data.status = $('#status').val();
                  }
        },
        "columnDefs": [
          { 
            "targets": [ 0 ], 
            "orderable": false, 
            "searchable": false
          },
          { 
            "targets": [ 4 ], 
            "visible": true,
            "orderable": false,
            "searchable": false
          }
        ],  
    });
  });

  $("#btn-tampilkan").on('click', function(e){
     $("#box-anggota").show();
     table.ajax.reload();
  });

  $("#btn-download-pdf").on('click', function(e){
    var status = $('#status').val();
    
    window.open("<?php echo base_url()?>laporanAnggota/downloadPdf/"+status); 
  });
</script>