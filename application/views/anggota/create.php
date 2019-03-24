<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <span class="<?php echo $icon; ?>"></span> <?php echo $title; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard/index'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo base_url('anggota/index'); ?>"><?php echo $parent_title?></a></li>
        <li class="active"> <?php echo $title?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- form start -->
            <form role="form" action="<?php echo base_url('anggota/store'); ?>" method="POST">
              <div class="box-body">

                <div class="form-group">
                  <div class="row">
                      <div class="col-md-8">
                        <label for="namaLengkapLabel">Nama Lengkap</label>
                        <?php echo $this->session->flashdata('nama_lengkap') ?>
                        <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" value="<?php echo $this->session->flashdata('nama_lengkap_value') ?>">
                            </div>
                      <div class="col-md-4">
                        <label for="namaPanggilanLabel">Nama Panggilan</label>
                        <?php echo $this->session->flashdata('nama_panggilan') ?>
                        <input type="text" class="form-control" name="nama_panggilan" id="nama_panggilan" placeholder="Nama Panggilan" value="<?php echo $this->session->flashdata('nama_panggilan_value') ?>">
                      </div> 
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                      <div class="col-md-8">
                          <label for="noIdentitasLabel">No Identitas</label>
                          <?php echo $this->session->flashdata('no_identitas') ?>
                          <input type="number" class="form-control" name="no_identitas" id="no_identitas" placeholder="No identitas" value="<?php echo $this->session->flashdata('no_identitas_value') ?>">
                      </div>  
                      <div class="col-md-4">
                          <label for="jenisIdentitasLabel">Jenis Identitas</label>
                          <?php 
                          $jenis_identitas_value = $this->session->flashdata('jenis_identitas_value');
                          echo $this->session->flashdata('jenis_identitas') 
                          ?>
                          <select class="form-control" name="jenis_identitas" id="jenis_identitas">
                              <option disabled selected>-Pilih Jenis Identitas-</option>
                              <?php foreach($jenis as $value){ ?>
                              <option value="<?php echo $value ?>" <?php if($value == $jenis_identitas_value){ echo 'selected'; } ?> ><?php echo $value?></option>
                              <?php }?>
                          </select>
                      </div>  
                  </div>
                </div>

                <div class="form-group">
                    <label for="teleponLabel">Telepon</label>
                    <?php echo $this->session->flashdata('telepon') ?>
                     <input type="number" class="form-control" name="telepon" id="telepon" placeholder="telepon" value="<?php echo $this->session->flashdata('telepon_value') ?>">
                </div>

                <div class="form-group">
                    <label for="alamatLabel">Alamat</label>
                    <?php echo $this->session->flashdata('alamat') ?>
                    <textarea class="form-control" cols="20" rows="3" name="alamat" id="alamat" placeholder="Alamat"><?php echo $this->session->flashdata('alamat_value')?></textarea>
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