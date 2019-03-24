<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <span class="<?php echo $icon; ?>"></span> <?php echo $title; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard/index'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo base_url('user/index'); ?>"><?php echo $parent_title?></a></li>
        <li class="active"> <?php echo $title?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
         <div class="col-md-12">
          <div class="callout callout-info">
            <h4><i class="fa fa-info"></i> Info</h4>

            <p>Password setiap user baru masih standar dari sistem.</p>
          </div>
        </div>  
        <div class="col-md-12">
          <!-- general form elements -->
          <?php echo validation_errors(); ?>
          <div class="box box-primary">
            <!-- form start -->
            <form role="form" action="<?php echo base_url('user/store'); ?>" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-8">
                      <label for="namaLengkapLabel">Nama Lengkap</label>
                      <?php echo $this->session->flashdata('form_nama_lengkap') ?>
                      <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" value="<?php echo $this->session->flashdata('nama_lengkap_value') ?>">
                    </div>
                    <div class="col-md-4">
                      <label for="panggilanLabel">Panggilan</label>
                      <?php echo $this->session->flashdata('form_panggilan') ?>
                      <input type="text" class="form-control" name="panggilan" id="panggilan" placeholder="Panggilan" value="<?php echo $this->session->flashdata('panggilan_value') ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="jenisKelaminLabel">Jenis Kelamin</label>
                  <?php echo $this->session->flashdata('form_jenis_kelamin') ?>
                  <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                    <option value="" disabled selected>-Pilih Jenis Kelamin-</option>
                    <?php foreach ($jenis_kelamin as $key_jk => $value_jk){ ?>
                      <option value="<?php echo $key_jk ?>"><?php echo $value_jk; ?></option>
                    <?php } ?>
                  </select>
                </div>
                 <div class="form-group">
                  <label for="alamatLabel">Alamat</label>
                  <?php echo $this->session->flashdata('form_alamat') ?>
                  <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Alamat"><?php echo $this->session->flashdata('alamat_value') ?></textarea>
                </div>
                <div class="form-group">
                  <label for="hakAksesLabel">Hak Akses</label>
                  <?php echo $this->session->flashdata('form_hak_akses') ?>
                  <select class="form-control" name="hak_akses" id="hak_akses">
                    <option value="" disabled selected>-Pilih Hak Akses-</option>
                    <?php foreach ($hak_akses as $key_ha => $value_ha){ ?>
                      <option value="<?php echo $key_ha ?>"><?php echo $value_ha; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="emailLabel">Email</label>
                  <?php echo $this->session->flashdata('form_email') ?>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $this->session->flashdata('email_value') ?>">
                </div>
                <div class="form-group">
                  <label for="teleponLabel">Telepon</label>
                  <?php echo $this->session->flashdata('form_telepon') ?>
                  <input type="number" class="form-control" name="telepon" id="telepon" placeholder="Telepon" value="<?php echo $this->session->flashdata('telepon_value') ?>">
                </div>
                <div class="form-group">
                  <label for="statusLabel">Status</label>
                  <?php echo $this->session->flashdata('form_status') ?>
                  <select class="form-control" name="status" id="status">
                    <option value="" disabled selected>-Pilih Status-</option>
                    <?php foreach ($status as $key => $value){ ?>
                      <option value="<?php echo $key ?>"><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->