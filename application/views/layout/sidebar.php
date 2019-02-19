<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
        <div class="pull-left image">
            <img src="<?php echo site_url()?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p><?php echo $this->session->userdata('nama') ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
        </div>
      
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">DATA MASTER</li>
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
            <li class="<?php echo $uri === 'user' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('kembali/index'); ?>">
                <i class="fa  fa-download"></i> <span>Kembali</span>
                </a>
            </li>
            <li class="<?php echo $uri === 'user' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('perpanjang/index'); ?>">
                <i class="fa fa-exchange"></i> <span>Perpanjang</span>
                </a>
            </li>
            <li class="header">LAPORAN</li> 

            <li class="<?php echo $uri === 'laporananggota' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('laporananggota/index'); ?>">
                <i class="fa fa-list-alt"></i> <span>Laporan Angggota</span>
                </a>
            </li>

            <li class="<?php echo $uri === 'laporanbuku' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('laporanbuku/index'); ?>">
                <i class="fa fa-file-text-o"></i> <span>Laporan Buku</span>
                </a>
            </li>

            <li class="<?php echo $uri === 'laporantransaksi' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('laporantransaksi/index'); ?>">
                <i class="fa fa-line-chart"></i> <span>Laporan Transaksi</span>
                </a>
            </li>

            <li class="<?php echo $uri === 'laporantransaksi' ? 'active treeview menu-open':''; ?>">
                <a href="<?php echo base_url('laporandenda/index'); ?>">
                <i class="fa fa-money"></i> <span>Laporan Denda</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
