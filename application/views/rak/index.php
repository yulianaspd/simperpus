 <!-- DataTables -->
<link href="<?php echo base_url('assets/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet">


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Tables
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><a href="<?php echo base_url('rak/create') ?>" class="btn btn-success"><span class="fa fa-plus"></span> Add data</a></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tabel-rak" class="table table-bordered table-striped">
                 <thead>
                      <tr>
                          <th>No</th>
                          <th>Kode</th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>

                  <tfoot>
                      <tr>
                          <th>No</th>
                          <th>Kode</th>
                      </tr>
                  </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- DataTables -->
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script>  
 var table;
    $(document).ready(function() {

        //datatables
        table = $('#tabel-rak').DataTable({ 

            "processing": true, 
            "serverSide": true, 
            "order": [], 
            
            "ajax": {
                "url": "<?php echo base_url('rak/ajaxGetIndex')?>",
                "type": "POST"
            },

            
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],

        });

    });

</script>