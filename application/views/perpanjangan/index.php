<!-- DataTables -->
<link href="<?php echo base_url('assets/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet">
<!-- DataTables -->
<link href="<?php echo base_url('assets/sweetalert/dist/sweetalert.css')?>" rel="stylesheet">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/all.css')?>">

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
                  <!-- <div class="table-responsive"> -->
                    <table id="table-pinjam" class="table table-bordered table-striped" style="width:100%">
                       <thead>
                            <tr>
                              <th>
                                <div class="checkbox">
                                  <label><input type="checkbox" class="icheckbox_flat-blue" id="check-all" value=""></label>
                                </div>
                              </th>
                              <th>No</th>
                              <th>Judul</th>
                              <th>Keterangan</th>
                              <th>Jatuh Tempo Awal</th>
                              <th>Jatuh Tempo Berikutnya</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                    </table>
                    <div class="total_denda_footer"></div>
              </div>
                <!-- /.box-body -->
              <div class="box-footer">
                  <button type="button" class="btn btn-success pull-right" id="btn-checkout"><i class="fa fa-refresh"></i> Checkout</button>
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

<div class="modal fade" id="modal-confirm-list-kembali" role="dialog" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><center><span class="fa fa-question-circle"></span> List Perpanjang Sewa</center></h4>
            </div>
           <!--  <form action="#"> -->
                <div class="modal-body">
                  <table class="table table-striped">
                    <thead>
                      <th></th>
                      <th></th>
                    </thead>
                    <tr>
                      <td>Jumlah Buku Diperpanjang</td>
                      <td class="text-right jml_buku"></td>
                    </tr>
                  </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
                    <button type="button" class="btn btn-success" id="btn-proses"><span class="fa fa-rocket"></span> Proses</button>
                </div>
            <!-- </form> -->
        </div>
    </div>
</div>

 
<!-- DataTables -->
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<!-- DataTables -->
<script src="<?php echo site_url('assets/sweetalert/dist/sweetalert.min.js')?>"></script>
<!-- iCheck 1.0.1 -->
<script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js') ?>"></script>

<script>
  var table;

  $(document).ready(function(){

    $("#box-buku").hide();
    //datatables
    table = $('#table-pinjam').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "pagination": false,
        "searching": false,
        "lengthChange": false,
        "order": [], 
        
        "ajax": {
            "url": "<?php echo base_url('perpanjangan/ajaxGetPinjam')?>",
            "type": "POST",
            "data": function (data) {
                      data.anggota_id = $('#anggota_id').val();
                  }
        },
        "columnDefs": [
          { 
            "targets": [ 0 ], //nomor
            "orderable": false, 
          },
          {
            "targets": [ 6 ], //pinjam_detail.id
            "visible" : false,
            "orderable": false,
            "searchable": false  
          },
          {
            "targets": [ 7 ], //pinjam_detail.buku_id
            "visible" : false,
            "orderable": false,
            "searchable": false  
          }
        ],  
    });

 }); 



function clearForm(){
    $("#anggota_id").val('');
    $(".kode").html('');
    $(".nama_lengkap").html('');
    $(".alamat").html('');
    $(".telepon").html('');
    $("#box-buku").slideUp(); 
    $("#kode").prop('disabled', false);
    $("#kode").val('');
    $("#kode").focus();
    $("#btn-cek-anggota").attr('disabled',false);
    $("#check-all").prop('checked', false);
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
              $("#btn-cek-anggota").attr('disabled','disabled');
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

  var arr_req_perpanjangan = [];

  $('#modal-confirm-list-kembali').on('show.bs.modal', function(e) {
    arr_req_perpanjangan = [];
  });

 

  $("#btn-checkout").click(function(){
        var buku_id = $.map(table.data(), function (item) {
                              return item[1]
                      });
        var jml_check_buku = $("#table-pinjam_wrapper").find('input[name="pinjam_detail_id"]:checked').length;
        if(jml_check_buku == 0){
            alert("Data belum dipilih !");
        }else{
          $("#modal-confirm-list-kembali").modal('show');
          $(".jml_buku").html('<b>'+jml_check_buku+'</b>');
          
          var arr_get_data = [];
          $.map(table.data(), function (item) {
              var arr = [];
              arr['id']                     = item[6];
              arr['buku_id']                = item[7];
              arr['jatuh_tempo_awal']       = item[4];
              arr['jatuh_tempo_berikutnya'] = item[5];
              return arr_get_data.push(arr);
          });

          var row_collection =  table.$("input[name='pinjam_detail_id']:checked");
         
          row_collection.each(function(index,elem){
            var checkbox_value = $(elem).val();
            var arr_perpanjang = arr_get_data.find( function(item) { 
              return item['id'] == checkbox_value 
            });

            //declare array untuk request ke ajax
            var valueToPush = new Array();
            valueToPush[0] = arr_perpanjang['id'];
            valueToPush[1] = arr_perpanjang['buku_id'];
            valueToPush[2] = arr_perpanjang['jatuh_tempo_awal'];
            valueToPush[3] = arr_perpanjang['jatuh_tempo_berikutnya'];
            arr_req_perpanjangan.push(valueToPush);

          });    
        }  
    });  

 $('#btn-proses').click(function(e) {
      console.log(arr_req_perpanjangan);
      $.ajax({
        type: "POST",
        dataType:"json",
        url: "<?php echo base_url('perpanjangan/prosesPerpanjangan'); ?>",
        data: {
          req_perpanjangan:arr_req_perpanjangan
        },
        success: function(data){
          if(data.keterangan == 'OK'){
              $('#modal-confirm-list-kembali').modal('hide');
          }
          swal(data.msg, "You clicked the button!", "success");
          clearForm();
        },
        error:function(data){
         console.log(data);
        }
      }) 
  });

  $("#check-all").on('change', function(){
    if(this.checked) {
      $("#table-pinjam_wrapper ,input:checkbox").not(this).prop('checked', this.checked);
    }else{
      $("#table-pinjam_wrapper ,input:checkbox").not(this).prop('checked', false);
    }
  }); 
</script>