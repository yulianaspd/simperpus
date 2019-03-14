 <!-- DataTables -->
<link href="<?php echo base_url('assets/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet">


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><span class="<?php echo $icon; ?>"></span> <?php echo $title; ?></h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard/index'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><?php echo $title; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <?php echo $this->session->flashdata('notif') ?>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><a href="<?php echo base_url('penerbit/create') ?>" class="btn btn-primary"><span class="fa fa-plus"></span> Input data</a></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="table-penerbit" class="table table-bordered table-striped">
                 <thead>
                      <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Alamat</th>
                          <th>Telepon</th>
                          <th>Email</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
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
        table = $('#table-penerbit').DataTable({ 

            "processing": true, 
            "serverSide": true, 
            "order": [], 
            
            "ajax": {
                "url": "<?php echo base_url('penerbit/ajaxGetIndex')?>",
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