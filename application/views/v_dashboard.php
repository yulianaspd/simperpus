<!-- jvectormap -->
<!-- <link rel="stylesheet" href="<?php echo site_url()?>assets/bower_components/jvectormap/jquery-jvectormap.css"> -->
<!-- Theme style -->
  <!-- <link rel="stylesheet" href="<?php echo site_url() ?>assets/dist/css/AdminLTE.min.css"> -->
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <!-- <link rel="stylesheet" href="<?php echo site_url() ?>assets/dist/css/skins/_all-skins.min.css"> -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>SIMPERPUS</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Anggota Aktif</span>
              <span class="info-box-number"><?php echo $total_anggota_aktif; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-book"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Judul Buku</span>
              <span class="info-box-number"><?php echo $total_judul_buku; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Peminjaman Hari Ini</span>
              <span class="info-box-number"><?php echo $total_pinjam_hari_ini ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-download-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Buku Kembali Hari Ini</span>
              <span class="info-box-number"><?php echo $total_kembali_hari_ini ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        
        <div class="col-md-8">
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class="active"><a href="#revenue-chart" data-toggle="tab">Per Minggu</a></li>
              <li><a href="#sales-chart" data-toggle="tab">Per Bulan</a></li>
              <li><a href="#sales-chart" data-toggle="tab">Per Tahun</a></li>
              <li class="pull-left header"><i class="fa fa-shopping-cart"></i> Peminjaman Buku</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
              <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
         
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-light-blue">
              <div class="widget-user-image">
                <?php if($jenis_kelamin == 1){ ?>
                  <img class="img-circle" src="<?php echo site_url()?>assets/img/user_laki.png" alt="User Simperpus">
                <?php } else if( $jenis_kelamin == 0 ){?>  
                  <img class="img-circle" src="<?php echo site_url()?>assets/img/user_perempuan.png" alt="User Simperpus">
                <?php } ?>  
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?php echo $nama_petugas; ?></h3>
              <h5 class="widget-user-desc"><?php echo $jabatan; ?></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#">IP Address <span class="pull-right badge bg-blue"><?php echo $ip; ?></span></a></li>
                <li><a href="#">Perangkat <span class="pull-right badge bg-aqua"><?php echo $perangkat; ?></span></a></li>
                <li><a href="#">Browser <span class="pull-right badge bg-green"><?php echo $browser; ?></span></a></li>
                <li><a href="#">Sistem Operasi   <span class="pull-right badge bg-red"><?php echo $os; ?></span></a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
       

      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- AdminLTE App -->
<!-- <script src="<?php echo base_url() ?>assets/dist/js/adminlte.min.js"></script> -->
<!-- Sparkline -->
<!-- <script src="<?php echo site_url()?>assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script> -->
<!-- jvectormap  -->
<!-- <script src="<?php echo site_url()?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo site_url()?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> -->
<!-- ChartJS -->
<!-- <script src="<?php echo site_url()?>assets/bower_components/chart.js/Chart.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?php echo site_url()?>assets/dist/js/pages/dashboard2.js"></script>  -->