 <!-- DataTables -->
<link href="<?php echo base_url('assets/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet">


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><span class="<?php echo $icon; ?>"></span> <?php echo $title; ?></h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('anggota/index'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
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
              <h3 class="box-title"><a href="<?php echo base_url('anggota/create') ?>" class="btn btn-primary"><span class="fa fa-plus"></span> Input data</a></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive ">
                <table id="table-buku" class="table table-bordered table-striped nowrap">
                   <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Anggota</th>
                            <th>Identitas</th>
                            <th>Alamat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                </table>
              </div>
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

<div class="modal fade" id="modal-detail-buku" role="dialog" tabindex="-1"  aria-hidden="true">
      <div class="modal-dialog modal-md">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><center><span class="fa fa-info-circle"></span> Detail Buku</center></h4>
              </div> 
              <div class="modal-body">
                  <table class="table table-striped">
                <tr>
                  <th style="width: 10px">#</th>
                  <th></th>
                  <th></th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>Judul</td>
                  <td class="text-right judul"></td>
                </tr>
                <tr>
                  <td>2.</td>
                  <td>Kategori</td>
                  <td class="text-right kategori"></td>
                </tr>
                <tr>
                  <td>3.</td>
                  <td>Penulis</td>
                  <td class="text-right penulis"></td>
                </tr>
                <tr>
                  <td>4.</td>
                  <td>Penerbit</td>
                  <td class="text-right penerbit"></td>
                </tr>
                <tr>
                  <td>5.</td>
                  <td>Halaman</td>
                  <td class="text-right halaman"></td>
                </tr>
                <tr>
                  <td>6.</td>
                  <td>ISBN</td>
                  <td class="text-right isbn"></td>
                </tr>
              </table>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-times"></span> Tutup</button>
              </div>
          </div>
      </div>
  </div>

<!-- DataTables -->
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script>  
 var table;
    $(document).ready(function() {

        //datatables
        table = $('#table-buku').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            
            "ajax": {
                "url": "<?php echo base_url('anggota/ajaxGetIndex')?>",
                "type": "POST"
            },
            
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

      $('#modal-detail-buku').on('show.bs.modal', function(e) {
            var this_elem = $(this);
            var relTarget = $(e.relatedTarget);

            var judul     = relTarget.data('judul');  
            var kategori  = relTarget.data('kategori');
            var penulis   = relTarget.data('penulis');
            var penerbit  = relTarget.data('penerbit');
            var halaman   = relTarget.data('halaman');
            var isbn      = relTarget.data('isbn');

            this_elem.find(".judul").html('<b>'+judul+'</b>');
            this_elem.find(".kategori").html('<b>'+kategori+'</b>');
            this_elem.find(".penulis").html('<b>'+penulis+'</b>');
            this_elem.find(".penerbit").html('<b>'+penerbit+'</b>');
            this_elem.find(".halaman").html('<b>'+halaman+'</b>');
            this_elem.find(".isbn").html('<b>'+isbn+'</b>');
        });

    });

</script>