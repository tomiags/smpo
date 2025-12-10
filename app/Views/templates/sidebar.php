<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion d-flex flex-column" id="accordionSidebar">

    <div class="flex-grow-1">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
            <div class="sidebar-brand-text mx-3">SMPO</div>
        </a>

        <hr class="sidebar-divider my-0">


        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePo"
                aria-expanded="true" aria-controls="collapsePo">
                <i class="fas fa-fw fa-folder"></i>
                <span>Purchasing</span>
            </a>
            <div id="collapsePo" class="collapse" aria-labelledby="headingBarang" data-parent="#accordionSidebar">
                <div class="py-2 collapse-inner rounded" style="background: transparent !important;">
                    <a class="collapse-item" href="<?= base_url('purchasing/request_po'); ?>">
                        <i class="fas fa-fw fa-file"></i> Request PO
                    </a>

                    <a class="collapse-item" href="<?= base_url('purchasing/po_list'); ?>">
                        <i class="fas fa-fw fa-list"></i> List PO
                    </a>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFinance"
                aria-expanded="true" aria-controls="collapseFinance">
                <i class="fas fa-fw fa-money-bill"></i>
                <span>Finance</span>
            </a>
            <div id="collapseFinance" class="collapse" aria-labelledby="headingBarang" data-parent="#accordionSidebar">
                <div class="py-2 collapse-inner rounded" style="background: transparent !important;">
                    <a class="collapse-item" href="<?= base_url('approval/request'); ?>">
                        <i class="fas fa-fw fa-file"></i> Request Approval
                    </a>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransaksi"
                aria-expanded="true" aria-controls="collapseTransaksi">
                <i class="fas fa-fw fa-dollar-sign"></i>
                <span>Transaksi</span>
            </a>
            <div id="collapseTransaksi" class="collapse" aria-labelledby="headingBarang" data-parent="#accordionSidebar">
                <div class="py-2 collapse-inner rounded" style="background: transparent !important;">
                    <a class="collapse-item" href="<?= base_url('transaksi/create'); ?>">
                        <i class="fas fa-fw fa-file"></i> Transaksi Baru
                    </a>

                    <a class="collapse-item" href="<?= base_url('transaksi/list'); ?>">
                        <i class="fas fa-fw fa-list"></i> List Transaksi
                    </a>

                    <a class="collapse-item" href="<?= base_url('transaksi/list_bayar'); ?>">
                        <i class="fas fa-fw fa-list"></i> List Bayar
                    </a>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBarang"
                aria-expanded="true" aria-controls="collapseBarang">
                <i class="fas fa-fw fa-box"></i>
                <span>Barang</span>
            </a>
            <div id="collapseBarang" class="collapse" aria-labelledby="headingBarang" data-parent="#accordionSidebar">
                <div class="py-2 collapse-inner rounded" style="background: transparent !important;">
                    <a class="collapse-item" href="<?= base_url('barang'); ?>">
                        <i class="fas fa-fw fa-list"></i> List Barang
                    </a>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider">

        <?php if (in_groups('admin')) : ?>
        <!-- Nav Item - Master Data Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMaster"
                aria-expanded="true" aria-controls="collapseMaster">
                <i class="fas fa-fw fa-database"></i>
                <span>Master Data</span>
            </a>
            <div id="collapseMaster" class="collapse" aria-labelledby="headingMaster" data-parent="#accordionSidebar">
                <div class="py-2 collapse-inner rounded" style="background: transparent !important;">

                    <a class="collapse-item" href="<?= base_url('pool'); ?>">
                        <i class="fas fa-fw fa-bus"></i> Pool
                    </a>

                    <a class="collapse-item" href="<?= base_url('supplier'); ?>">
                        <i class="fas fa-fw fa-truck"></i> Supplier
                    </a>

                    <a class="collapse-item" href="<?= base_url('departemen'); ?>">
                        <i class="fas fa-fw fa-building"></i> Departemen
                    </a>

                    <a class="collapse-item" href="<?= base_url('users'); ?>">
                        <i class="fas fa-fw fa-users"></i> Manajemen User
                    </a>

                </div>
            </div>
        </li>

        <hr class="sidebar-divider d-none d-md-block">
        <?php endif; ?>


    </div>

    <!-- 
    <li class="nav-item">
        <a href="<= base_url('logout'); ?>" class="nav-link">
            <i class="fas fa-fw fa-power-off"></i>
            <span>Logout</span></a>
    </li> -->

</ul>
<!-- End of Sidebar -->

<style>
#collapseMaster .collapse-item {
    color: #fff !important;         
}

#collapseMaster .collapse-item i {
    color: #fff !important;         
}

#collapseMaster .collapse-item:hover {
    color: #f8f9fa !important;       
    background: rgba(255,255,255,0.1) !important;
}

#collapseBarang .collapse-item {
    color: #fff !important;         
}

#collapseBarang .collapse-item i {
    color: #fff !important;         
}

#collapseBarang .collapse-item:hover {
    color: #f8f9fa !important;       
    background: rgba(255,255,255,0.1) !important;
}

#collapsePo .collapse-item {
    color: #fff !important;         
}

#collapsePo .collapse-item i {
    color: #fff !important;         
}

#collapsePo .collapse-item:hover {
    color: #f8f9fa !important;       
    background: rgba(255,255,255,0.1) !important;
}

#collapseFinance .collapse-item {
    color: #fff !important;         
}

#collapseFinance .collapse-item i {
    color: #fff !important;         
}

#collapseFinance .collapse-item:hover {
    color: #f8f9fa !important;       
    background: rgba(255,255,255,0.1) !important;
}

#collapseTransaksi .collapse-item {
    color: #fff !important;         
}

#collapseTransaksi .collapse-item i {
    color: #fff !important;         
}

#collapseTransaksi .collapse-item:hover {
    color: #f8f9fa !important;       
    background: rgba(255,255,255,0.1) !important;
}
</style>

