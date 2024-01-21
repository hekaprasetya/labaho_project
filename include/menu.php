<?php
//cek session
if (!empty($_SESSION['admin'])) {
    ?>

    <nav class="blue darken-3">
        <div class="nav-wrapper">
            <a href="./" class="brand-logo center hide-on-large-only"><i class="material-icons md-36"></i>
                <span>Laba</span>Ho</a>


            <!-- profile start -->
            <div class="right hide-on-med-and-down pro-1" style="margin-right: 2rem;">
                <?php
                if (!empty($_SESSION['file'])) {
                    $profileImageUrl = "./upload/user/" . $_SESSION['file'];
                } else {
                    $profileImageUrl = "./asset/gif/profile.gif";
                }
                ?>

                <a href="<?= $profileImageUrl ?>" title="Profile Picture">
                    <img src="<?= $profileImageUrl ?>" class="circle" alt="Profile Picture">
                </a>

                <a class="dropdown-button" href="#!" data-activates="logout">
                    <?php echo $_SESSION['nama']; ?><i class="material-icons md-18">arrow_drop_down</i>
                </a>
            </div>
            <!--div class="right hide-on-med-and-down" style="margin-right: 1rem;"><a class="dropdown-button" href="#!" data-activates="logout"><i class="material-icons">account_circle</i> <?php echo $_SESSION['nama']; ?><i class="material-icons md-18">arrow_drop_down</i></a></div-->
            <ul id='logout' class='dropdown-content hide-on-med-and-down'>
                <li><a href="?page=pro_karyawan">Profil</a></li>
                <li class="divider"></li>
                <li><a href="?page=pro_karyawan&sub=pass">Ubah Password</a></li>
                <li class="divider"></li>
                <li><a href="logout.php"><i class="material-icons">settings_power</i> Logout</a></li>
            </ul>
            <!-- profile end -->

            <ul id="slide-out" class="side-nav blue darken-3" data-simplebar-direction="vertical">
                <li class="no-padding">
                    <div class="logo-side center blue darken-4">
                        <?php
                        $query = mysqli_query($config, "SELECT * FROM tbl_instansi");
                        while ($data = mysqli_fetch_array($query)) {
                            if (!empty($data['logo'])) {
                                echo '<img class="logoside" src="./upload/' . $data['logo'] . '"/>';
                            } else {
                                echo '<img class="logoside" src="./asset/img/logo.png"/>';
                            }
                            if (!empty($data['nama'])) {
                                echo '<h5 class="smk-side">' . $data['nama'] . '</h5>';
                            } else {
                                echo '<h5 class="smk-side">LABAHO</h5>';
                            }
                            if (!empty($data['alamat'])) {
                                echo '<p class="de  scription-side">' . $data['alamat'] . '</p>';
                            } else {
                                echo '<p class="description-side">Labuan Bajo Holiday</p>';
                            }
                        }
                        ?>
                    </div>
                </li>

                <li><a href="./"><i class="material-icons middle">dashboard</i> Beranda</a></li>

                <li class="no-padding">
                    <?php
                    //GM
                
                    if ($_SESSION['admin'] == 2 || $_SESSION['admin'] == 7) {
                        ?>
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="material-icons">repeat</i> Aktifitas</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="?page=booking">Booking</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=">Calender</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=">Cek Kamar</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=">Cek Kesiapan Kamar</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=">Cek Kesiapan Kapal</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=pp">Pembelian</a></li>

                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="material-icons">assignment</i>Laporan</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="?page=report_pp">Laporan Booking</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_pp">Laporan Pembelian</a></li>


                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="material-icons">settings</i>Master</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="?page=master_jabatan">Master Jabatan</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=usr">Master User</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_pajak">Master Pajak</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_pph">Master PPH</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_supplier">Master Supplier</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_satuan">Master Satuan</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_barang">Master Barang</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=sett&sub=back">Backup Database</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=sett&sub=rest">Restore Database</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <?php
                    }
                    ?>
                </li>

                <li class="no-padding">
                    <?php
                    //KABAG
                
                    if ($_SESSION['admin'] == 3) {
                        ?>
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="material-icons">repeat</i> Aktifitas</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="?page=tsm">E - PMK</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=pa">E - PA</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=ppi">E - PPI</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=lpt">E - LPT</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=opb">E - OPB</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=pp">E - PP</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=mod">E - MOD</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=lapor">E - LAPOR</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=cuti">E - CUTI</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=pengaduan">PENGADUAN</a></li>
                                    </ul>

                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="material-icons">assignment</i>Laporan</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="?page=asm">Laporan E-PMK</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_lpt">Laporan E-LPT</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_pa">Laporan E-P.A</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_ppi">Laporan E-PPI</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_pp">Laporan E-PP</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=op&act=report_op">Laporan E-OP</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_lpg">Laporan E-LPG</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_eng">Laporan Engineering</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=lapor&act=report_lapor">E-LAPOR</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=mod&act=report_mod">Laporan E-MOD</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_pengaduan">Laporan PENGADUAN</a></li>

                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="material-icons">settings</i>Master</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="?page=master_tenant">Master Tenant</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=usr">Master User</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_pajak">Master Pajak</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_pph">Master PPH</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_supplier">Master Supplier</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_satuan">Master Satuan</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_barang">Master Barang</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>

                        <?php
                    }
                    ?>
                </li>

                <li class="no-padding">
                    <?php
                    //MARKETING
                
                    if ($_SESSION['admin'] == 4) {
                        ?>
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="material-icons">repeat</i> Aktifitas</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="?page=tsm">E - PMK</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=pa">E - PA</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=ppi">E - PPI</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=lpt">E - LPT</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=opb">E - OPB</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=pp">E - PP</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=mod">E - MOD</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=lapor">E - LAPOR</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=cuti">E - CUTI</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=pengaduan">PENGADUAN</a></li>
                                    </ul>

                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="material-icons">assignment</i>Laporan</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="?page=asm">Laporan E-PMK</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_lpt">Laporan E-LPT</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_pa">Laporan E-P.A</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_ppi">Laporan E-PPI</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_pp">Laporan E-PP</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=op&act=report_op">Laporan E-OP</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_lpg">Laporan E-LPG</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_eng">Laporan Engineering</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=lapor&act=report_lapor">E-LAPOR</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=mod&act=report_mod">Laporan E-MOD</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_pengaduan">Laporan PENGADUAN</a></li>

                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="material-icons">settings</i>Master</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="?page=master_tenant">Master Tenant</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=usr">Master User</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_pajak">Master Pajak</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_pph">Master PPH</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_supplier">Master Supplier</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_satuan">Master Satuan</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_barang">Master Barang</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>

                        <?php
                    }
                    ?>
                </li>

                <li class="no-padding">
                    <?php
                    //KEUANGAN
                
                    if ($_SESSION['admin'] == 5) {
                        ?>
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="material-icons">repeat</i> Aktifitas</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="?page=tsm">E - PMK</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=pa">E - PA</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=ppi">E - PPI</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=lpt">E - LPT</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=opb">E - OPB</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=pp">E - PP</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=mod">E - MOD</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=lapor">E - LAPOR</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=cuti">E - CUTI</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=pengaduan">PENGADUAN</a></li>
                                    </ul>

                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="material-icons">assignment</i>Laporan</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="?page=asm">Laporan E-PMK</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_lpt">Laporan E-LPT</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_pa">Laporan E-P.A</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_ppi">Laporan E-PPI</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_pp">Laporan E-PP</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=op&act=report_op">Laporan E-OP</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_lpg">Laporan E-LPG</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_eng">Laporan Engineering</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=lapor&act=report_lapor">E-LAPOR</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=mod&act=report_mod">Laporan E-MOD</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_pengaduan">Laporan PENGADUAN</a></li>

                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="material-icons">settings</i>Master</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="?page=master_tenant">Master Tenant</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=usr">Master User</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_pajak">Master Pajak</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_pph">Master PPH</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_supplier">Master Supplier</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_satuan">Master Satuan</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_barang">Master Barang</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>

                        <?php
                    }
                    ?>
                </li>

                <li class="no-padding">
                    <?php
                    //GUDANG
                
                    if ($_SESSION['admin'] == 6) {
                        ?>
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="material-icons">repeat</i> Aktifitas</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="?page=tsm">E - PMK</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=pa">E - PA</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=ppi">E - PPI</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=lpt">E - LPT</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=opb">E - OPB</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=pp">E - PP</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=mod">E - MOD</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=lapor">E - LAPOR</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=cuti">E - CUTI</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=pengaduan">PENGADUAN</a></li>
                                    </ul>

                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="material-icons">assignment</i>Laporan</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="?page=asm">Laporan E-PMK</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_lpt">Laporan E-LPT</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_pa">Laporan E-P.A</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_ppi">Laporan E-PPI</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_pp">Laporan E-PP</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=op&act=report_op">Laporan E-OP</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_lpg">Laporan E-LPG</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_eng">Laporan Engineering</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=lapor&act=report_lapor">E-LAPOR</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=mod&act=report_mod">Laporan E-MOD</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=report_pengaduan">Laporan PENGADUAN</a></li>

                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="material-icons">settings</i>Master</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="?page=master_tenant">Master Tenant</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=usr">Master User</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_pajak">Master Pajak</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_pph">Master PPH</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_supplier">Master Supplier</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_satuan">Master Satuan</a></li>
                                        <li class="divider"></li>
                                        <li><a href="?page=master_barang">Master Barang</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>

                        <?php
                    }
                    ?>
                </li>


                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                    </ul>
                </li>

                <li class="no-padding blue darken-4">
                    <ul class="collapsible collapsible-accordion">
                        <li>
                            <a class="collapsible-header"><i class="material-icons">account_circle</i>
                                <?php echo $_SESSION['nama']; ?>
                            </a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="?page=pro_karyawan">Profil</a></li>
                                    <li class="divider"></li>
                                    <li><a href="?page=pro_karyawan&sub=pass">Ubah Password</a></li>
                                    <li class="divider"></li>
                                    <li><a href="logout.php"><i class="material-icons">settings_power</i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>

            <a href="#" data-activates="slide-out" class="button-collapse waves-effect waves-light" id="menu"><img
                    src="./asset/img/ham2.png" alt=""></a>

        </div>
    </nav>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var myApp = {
            init: function () {
                $(document).ready(function () {
                    // Saat mengklik collapsible-header
                    $(".collapsible-header").click(function () {
                        // Periksa apakah collapsible-body terbuka
                        var isClosed = $(this).next().is(":hidden");

                        // Tutup semua collapsible-body kecuali yang sedang aktif
                        $(".collapsible-body").slideUp(300);
                        $(".collapsible-header").removeClass("active");
                        // Buka collapsible-body jika semula tertutup
                        if (isClosed) {
                            $(this).next().slideDown(300);
                            $(this).addClass("active");
                        }
                    });
                });
            }
        };

        $(document).ready(function () {
            myApp.init();
        });
    </script>
    <?php
} else {
    header("Location: ../");
    die();
}
?>