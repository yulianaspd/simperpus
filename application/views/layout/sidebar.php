<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
        <div class="pull-left image">
            <?php
            $jenis_kelamin = $this->session->userdata('jenis_kelamin');
            if($jenis_kelamin == 1){
            ?>
                <img src="<?php echo site_url()?>assets/img/user_laki.png" class="img-rectangle" alt="User Image">
            <?php }else if($jenis_kelamin == 0){ ?>
                <img src="<?php echo site_url()?>assets/img/user_perempuan.png" class="img-rectangle" alt="User Image">
            <?php } ?>    
        </div>
        <div class="pull-left info">
            <p><?php echo $this->session->userdata('panggilan'); ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
        </div>
      
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">DATA MASTER </li>
            <li class="<?php echo $uri === 'dashboard' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('dashboard/index');?>">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="<?php echo $uri === 'rak' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('rak/index');?>">
                <i class="fa fa-tasks"></i> <span>Rak</span>
                </a>
            </li>
            <li class="<?php echo $uri === 'kategori' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('kategori/index');?>">
                <i class="fa fa-bookmark"></i> <span>Kategori</span>
                </a>
            </li>
            <li class="<?php echo $uri === 'penulis' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('penulis/index'); ?>">
                <i class="fa fa-user"></i> <span>Penulis</span>
                </a>
            </li>
            <li class="<?php echo $uri === 'penerbit' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('penerbit/index'); ?>">
                <i class="fa fa-copyright"></i> <span>Penerbit</span>
                </a>
            </li>
            <li class="<?php echo $uri === 'buku' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('buku/index'); ?>">
                <i class="fa fa-book"></i> <span>Buku</span>
                </a>
            </li>
            <li class="<?php echo $uri === 'anggota' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('anggota/index'); ?>">
                <i class="fa fa-users"></i> <span>Anggota</span>
                </a>
            </li>
            <li class="<?php echo $uri === 'user' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('user/index'); ?>">
                <i class="fa fa-unlock-alt"></i> <span>User</span>
                </a>
            </li>
            <li class="header">TRANSAKSI</li>
            <li class="<?php echo $uri === 'pinjam' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('pinjam/index'); ?>">
                <i class="fa fa-shopping-cart"></i> <span>Pinjam</span>
                </a>
            </li>
            <li class="<?php echo $uri === 'kembali' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('kembali/index'); ?>">
                <i class="fa  fa-download"></i> <span>Kembali</span>
                </a>
            </li>
            <li class="<?php echo $uri === 'perpanjangan' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('perpanjangan/index'); ?>">
                <i class="fa fa-exchange"></i> <span>Perpanjang</span>
                </a>
            </li>
            <li class="header">LAPORAN</li> 

            <li class="<?php echo $uri === 'laporanAnggota' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('laporanAnggota/index'); ?>">
                <i class="fa fa-list-alt"></i> <span>Laporan Angggota</span>
                </a>
            </li>

            <li class="<?php echo $uri === 'laporanMutasiBuku' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('laporanMutasiBuku/index'); ?>">
                <i class="fa fa-retweet"></i> <span>Laporan Mutasi Buku</span>
                </a>
            </li>

            <li class="<?php echo $uri === 'laporanDenda' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('laporanDenda/index'); ?>">
                <i class="fa fa-money"></i> <span>Laporan Denda</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
