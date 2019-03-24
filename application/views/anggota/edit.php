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
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- form start -->
            <form role="form" action="<?php echo base_url('anggota/update'); ?>" method="POST">
              <div class="box-body">
                <?php $anggota = $anggota[0];?>
                <div class="form-group">
                  <div class="row">
                      <div class="col-md-8">
                        <label for="namaLengkapLabel">Nama Lengkap</label>
                        <input type="hidden" name="id" value="<?php echo $anggota->id ?>">
                        <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" value="<?php echo $anggota->nama_lengkap ?>" required>
                            </div>
                      <div class="col-md-4">
                        <label for="namaPanggilanLabel">Nama Panggilan</label>
                        <input type="text" class="form-control" name="nama_panggilan" id="nama_panggilan" placeholder="Nama Panggilan" value="<?php echo $anggota->nama_panggilan ?>" required>
                      </div> 
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                      <div class="col-md-8"
                          <label for="noIdentitasLabel">No Identitas</label>
                          <?php echo $this->session->flashdata('no_identitas') ?>
                          <input type="number" class="form-control" name="no_identitas" id="no_identitas" placeholder="No identitas" value="<?php echo $anggota->no_identitas ?>" required>
                      </div>  
                      <div class="col-md-4">
                          <label for="jenisIdentitasLabel">Jenis Identitas</label>
                          <select class="form-control" name="jenis_identitas" id="jenis_identitas" required>
                              <option disabled selected>-Pilih Jenis Identitas-</option>
                              <?php foreach($jenis as $value){ ?>
                              <option value="<?php echo $value ?>" <?php if($value == $anggota->jenis_identitas){ echo 'selected'; } ?> ><?php echo $value?></option>
                              <?php }?>
                          </select>
                      </div>  
                  </div>
                </div>

                <div class="form-group">
                    <label for="teleponLabel">Telepon</label>
                    <input type="number" class="form-control" name="telepon" id="telepon" placeholder="telepon" value="<?php echo $anggota->telepon ?>" required>
                </div>

                <div class="form-group">
                    <label for="alamatLabel">Alamat</label>
                    <textarea class="form-control" cols="20" rows="3" name="alamat" id="alamat" placeholder="Alamat" required><?php echo $anggota->alamat ?></textarea>
                </div>
                <div class="form-group">
                  <label for="statusLabel">Status</label>
                  <select class="form-control" name="status" id="status">
                      <?php foreach($status as $key_st => $val_st){ ?>
                      <option value="<?php echo $val_st ?>" <?php if($key_st == $anggota->status){ echo 'selected'; } ?> ><?php echo $val_st; ?></option>
                      <?php }?>
                  </select>
                </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
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