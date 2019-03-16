 <!-- DataTables -->
<link href="<?php echo base_url('assets/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet">
<!-- daterange picker -->
<link rel="stylesheet" href="<?php echo site_url()?>/assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">

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
                    <label class="col-sm-2 control-label">Tanggal</label>
                  </div>
                  <div class="col-sm-7">
                    <div class="input-group" style="width:100%" id="daterange" val="">
                      <button type="button" class="btn btn-default pull-right" id="daterange-btn" style="width:100%">
                        <span>
                          <i class="fa fa-calendar"></i> Pilih Tanggal
                        </span>
                        <i class="fa fa-caret-down"></i>
                      </button>
                    </div>
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
                  <table id="table-mutasi-pinjam" class="table table-bordered table-striped" style="width:100%">
                     <thead>
                          <tr>
                            <th>No</th>
                            <th>Anggota</th>
                            <th>Judul</th>
                            <th>Tanggal Pinjam & Jatuh Tempo</th>
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
<!-- date-range-picker -->
<script src="<?php echo site_url()?>/assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo site_url()?>/assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>

  var daterange_array = new Array();
  const formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  });
  $(document).ready(function(){
    $("#box-anggota").hide();

    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        startDate: moment().subtract(29, 'days'),
        endDate  : moment(),
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        }
       
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'))
        var tgl;
        var bulan = ['01','02','03','04','05','06','09','10','11','12'];

        var tgl_start = $('#daterange-btn').data('daterangepicker').startDate._d.getDate();
        var bln_start = $('#daterange-btn').data('daterangepicker').startDate._d.getMonth();
        var thn_start = $('#daterange-btn').data('daterangepicker').startDate._d.getFullYear();

        var tgl_end = $('#daterange-btn').data('daterangepicker').endDate._d.getDate();
        var bln_end = $('#daterange-btn').data('daterangepicker').endDate._d.getMonth();
        var thn_end = $('#daterange-btn').data('daterangepicker').endDate._d.getFullYear();

        daterange_array[0] = thn_start+'-'+bulan[bln_start]+'-'+ (tgl_start < 10 ? 0+''+tgl_start : tgl_start);
        daterange_array[1] = thn_end+'-'+bulan[bln_end]+'-'+ (tgl_end < 10 ? 0+''+tgl_end : tgl_end);
      }
    )
    
    //datatables
    table = $('#table-mutasi-pinjam').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "order": [], 
        
        "ajax": {
            "url": "<?php echo base_url('laporanMutasiBuku/ajaxGetMutasiPinjam')?>",
            "type": "POST",
            "data": function (data) {
                      data.tanggal = daterange_array
                  }
        },
        "columnDefs": [
          { 
            "targets": [ 0 ], 
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
    var param  = daterange_array.toString();
    window.open("<?php echo base_url()?>laporanDenda/downloadPdf/"+param.replace(",","/")); 
  });
</script>