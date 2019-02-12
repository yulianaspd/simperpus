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
        <li class="active"><?php echo $title?></li>
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
            <form id="form-pinjam" role="form" action="#">
              <div class="box-body">
                <label>Kode Anggota</label>
                <div class="input-group input-group-md">
                  <input type="text" name="kode" id="kode" class="form-control" placeholder="Kode Anggota">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-info btn-flat" id="btn-cek-anggota"><i class="fa fa-refresh"></i></button>
                    </span>
                </div>
              </div>
                <!-- /.box-body -->
            </form>
          </div>
          <!-- /.box -->

          <div class="box box-primary" id="box-buku">
            <!-- form start -->
            <form id="form-pinjam" role="form" action="#">
              <div class="box-body">  
                <table class="table table-striped">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th></th>
                      <th></th>
                    </tr>
                    <tr>
                      <td>1.</td>
                      <td>KODE</td>
                      <input type="hidden" id="anggota_id" value="">
                      <td class="text-right kode"></td>
                    </tr>
                    <tr>
                      <td>2.</td>
                      <td>NAMA LENGKAP <?php echo $this->session->userdata('id') ?></td>
                      <td class="text-right nama_lengkap"></td>
                    </tr>
                    <tr>
                      <td>3.</td>
                      <td>Alamat</td>
                      <td class="text-right alamat"></td>
                    </tr>
                    <tr>
                      <td>4.</td>
                      <td>TELEPON</td>
                      <td class="text-right telepon"></td>
                    </tr>
                  </table>
                  
                  <br>
                  <br>
                  <b><h1 class="page-header text-center">DAFTAR PINJAM BUKU</h1></b>
                  <!-- <div class="table-responsive"> -->
                    <table id="table-pinjam" class="table table-bordered table-striped" style="width:100%">
                       <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Terlambat</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                    </table>
                    
                
                
              </div>
                <!-- /.box-body -->
              <div class="box-footer">
                <button type="button" class="btn btn-success pull-right" id="btn-proses"><i class="fa fa-rocket"></i> Proses</button>
              </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
   var table;
  $(document).ready(function(){
    
    $("#box-buku").hide();
    //datatables
    table = $('#table-pinjam').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "pagination": false,
        "lengthChange": false,
        "order": [], 
        
        "ajax": {
            "url": "<?php echo base_url('kembali/ajaxGetPinjam')?>",
            "type": "POST",
            "data": function (data) {
                      data.anggota_id = $('#anggota_id').val();
                  }
        },
        
        "columnDefs": [
          { 
            "targets": [ 0 ], 
            "orderable": false, 
          },
          {
            "targets": [ 1 ],
            "visible": true,
            "orderable": false,
            "searchable": false
          },
        ],
    });

    function clearForm(){
      $("#anggota_id").val('');
      $(".kode").html('');
      $(".nama_lengkap").html('');
      $(".alamat").html('');
      $(".telepon").html('');
      $("#box-buku").slideUp(); 
      $("#kode").prop('disabled', false);
      table.ajax.reload();
    }

    $("#btn-cek-anggota").click(function(){
      var kode = $("#kode").val();
        $.ajax({
            type: "POST",
            dataType: 'JSON',
            data:{
                  kode : kode
                },
            url:"<?php echo base_url('kembali/showAnggota'); ?>",
            success: function (data) {
                   
              if(data.keterangan != 'NOK'){
                $("#anggota_id").val(data.anggota.id);
                $(".kode").html('<b>'+data.anggota.kode +'</b>');
                $(".nama_lengkap").html('<b>'+data.anggota.nama_lengkap +'</b>');
                $(".alamat").html('<b>'+data.anggota.alamat +'</b>');
                $(".telepon").html('<b>'+data.anggota.telepon +'</b>');
                $("#box-buku").slideDown(); 
                $("#kode").prop('disabled', true);
                table.ajax.reload();
              }else{
                $("#box-buku").slideUp();
                alert(data.error);
              }   
            },
            error: function(data){
              console.log(data);
            }
        });     
    });

    $("#btn-input-buku").click(function(e){
      var isbn = $("#isbn").val();
      $.ajax({
         type: "POST",
          dataType: 'JSON',
          data:{
                isbn : isbn
              },
          url:"<?php echo base_url('pinjam/scanInputTemp'); ?>",
          success: function (data) {
            
            if(data.keterangan != 'NOK'){
               if(data.keterangan != 'NOK' ){
                  table.ajax.reload();
                  $("#isbn").val('');
                  console.log(data.keterangan);
                  console.log(data.msg);
               }else{
                  alert(data.error)
               }
            }else{
              $("#isbn").val('');
              alert(data.error);
            }   
          },
          error: function(data){
            console.log(data);
          }
      })
    })

    $("#table-pinjam-temp_wrapper").on('click', '.delete-temp', function(e){
      var url = $(this).data('href');
      $.ajax({
        
        type: "POST",
        dataType:"JSON",
        url: url,
        success: function(data){
           table.ajax.reload();
        },
        error:function(data){
          console.log(data);
        }

      })
    });


    $('#btn-proses').click(function(e) {
        var anggota_id  = $("#anggota_id").val();
        var user_id     = "<?php echo $this->session->userdata('id') ?>";

        $.ajax({
          type: "POST",
          dataType:"JSON",
          url: "<?php echo base_url('pinjam/store'); ?>",
          data: {
            user_id:user_id,
            anggota_id:anggota_id
          },
          success: function(data){
            var pinjam_id = data.result_pinjam.id;
            var buku_id = $.map(table.data(), function (item) {
                              return item[1]
                          });
             $.ajax({
                type: "POST",
                dataType:"JSON",
                url:"<?php echo base_url('pinjam/storeDetail'); ?>",
                data:{
                  buku_id:buku_id,
                  pinjam_id:pinjam_id
                },
                success: function(data){
                  clearForm();
                  swal({
                    title: "success!",
                    icon: "success",
                  });
                },
                error:function(data){
                  console.log(data);
                }
             })
          },
          error:function(data){
           console.log(data);
          }
        })
        
    });

  });
</script>