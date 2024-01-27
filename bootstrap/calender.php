<!DOCTYPE html>
<html lang="en">
<?php
session_start();
?>

<head>
    <!-- Favicon icon -->
    <!-- Custom Stylesheet -->

    <link href="plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
</head>
<style>
    .fc-content span {
        color: white !important;
    }

    .external-event.bg-success.ui-draggable.ui-draggable-handle {
        color: white !important;
    }
</style>

<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <div class="nav-header">
            <div class="brand-logo">
                <a href="../admin.php">
                    <b class="logo-abbr"></b>

                    <span class="logo-compact" style="color: white;">
                        <span style="color:#f5c483;">LABA</span>HO
                    </span>
                    <span class="brand-title">

                    </span>
                </a>
            </div>
        </div>
        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content clearfix">

                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>

            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->
        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label"><a href="../admin.php">Beranda</a></li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Aktifitas</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="../admin.php?page=booking">Booking</a></li>
                            <li><a href="javascript:void()">Calender</a></li>
                            <li><a href="javascript:void(0)">Cek Kamar</a></li>
                            <li><a href="javascript:void(0)">Cek Kesiapan Kamar</a></li>
                            <li><a href="javascript:void(0)">Cek Kesiapan Kapal</a></li>
                            <li><a href="javascript:void(0)">Pembelian</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-note menu-icon"></i><span class="nav-text">Laporan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="javascript:void()">Laporan Booking</a></li>
                            <li><a href="javascript:void()">Laporan Pembelian</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
        <!--**********************************
            Content body start
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="container-fluid">
            <div class=" content-body">
                <div class="row page-titles mx-0">
                    <div class="col p-md-0">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../">Beranda</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Calender</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h4>Calendar</h4>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 mt-5">
                                        <a href="#" data-toggle="modal" data-target="#add-category"
                                            class="btn btn-primary btn-block"><i class="ti-plus f-s-12 m-r-5"></i>
                                            Membuat
                                            Acara</a>
                                        <div id="external-events" class="m-t-20">
                                            <p>Seret dan letakkan acara Anda atau klik di kalender</p>
                                            <div class="external-event bg-primary text-white" data-class="bg-primary"><i
                                                    class="fa fa-move"></i>Keberangkatan</div>
                                            <div class="external-event bg-success text-white" data-class="bg-success"><i
                                                    class="fa fa-move"></i>Cek Kamar</div>
                                            <div class="external-event bg-warning text-white" data-class="bg-warning"><i
                                                    class="fa fa-move"></i>Meet manager</div>
                                            <div class="external-event bg-danger text-white" data-class="bg-danger"><i
                                                    class="fa fa-move"></i>Cek Kapal</div>
                                        </div>
                                        <!-- checkbox -->
                                        <div class="checkbox m-t-40">
                                            <input id="drop-remove" type="checkbox">
                                            <label for="drop-remove">Hapus setelah diletakkan.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-box m-b-50">
                                            <div id="calendar"></div>
                                        </div>
                                    </div>

                                    <!-- end col -->
                                    <!-- BEGIN MODAL -->
                                    <div class="modal fade none-border" id="event-modal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><strong>Tambahkan Acara Baru</strong></h4>
                                                </div>
                                                <div class="modal-body"></div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default waves-effect"
                                                        data-dismiss="modal">Tutup</button>
                                                    <button type="button"
                                                        class="btn btn-info save-event waves-effect waves-light">Membuat
                                                        acara</button>
                                                    <button type="button"
                                                        class="btn btn-danger delete-event waves-effect waves-light"
                                                        data-dismiss="modal">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Add Category -->
                                    <div class="modal fade none-border" id="add-category">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><strong>Menambahkan kategori</strong></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="control-label">Nama Kategori</label>
                                                                <input class="form-control form-white"
                                                                    placeholder="Enter name" type="text"
                                                                    name="category-name">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="control-label">Pilih Warna
                                                                    Kategori</label>
                                                                <select class="form-control form-white"
                                                                    data-placeholder="Choose a color..."
                                                                    name="category-color">
                                                                    <option value="success">hijau</option>
                                                                    <option value="danger">Merah</option>
                                                                    <option value="info">Biru</option>
                                                                    <option value="pink">Pink</option>
                                                                    <option value="primary">Ungu</option>
                                                                    <option value="warning">Kuning</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default waves-effect"
                                                        data-dismiss="modal">Tutup</button>
                                                    <button type="button"
                                                        class="btn btn-danger waves-effect waves-light save-category"
                                                        data-dismiss="modal">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END MODAL -->
                                </div>
                            </div>
                        </div>
                        <!-- /# card -->
                    </div>
                    <!-- /# column -->
                </div>
            </div>
            <!--**********************************
            Content body end
        ***********************************-->
        </div>
        <!--**********************************
        Main wrapper end
    ***********************************-->

        <!--**********************************
        Scripts
    ***********************************-->
        <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>

        <script>
            // const Toast = Swal.mixin({
            //     toast: true,
            //     position: "top-end",
            //     showConfirmButton: false,
            //     timer: 3000,
            //     timerProgressBar: true,
            //     didOpen: (toast) => {
            //         toast.onmouseenter = Swal.stopTimer;
            //         toast.onmouseleave = Swal.resumeTimer;
            //     }
            // });

            // o.$modal.find(".save-event").unbind("click").on("click", function () {
            //     // Ambil data dari formulir
            //     var eventData = {
            //         title: i.find("input[name='title']").val(),
            //         category: i.find("select[name='category'] option:checked").val(),
            //         start: t,
            //         end: n
            //     };

            //     // Kirim data ke server-side menggunakan AJAX
            //     $.ajax({
            //         url: 'proses_calender.php', // Sesuaikan dengan path ke skrip PHP Anda
            //         method: 'POST',
            //         data: eventData,
            //         success: function (response) {
            //             console.log('Data berhasil dikirim ke server');
            //             Toast.fire({
            //                 icon: "success",
            //                 title: "Acara Berhasil Disimpan"
            //             });
            //         },
            //         error: function (error) {
            //             console.error('Gagal mengirim data ke server', error);
            //             Toast.fire({
            //                 icon: "error",
            //                 title: "Terjadi Kesalahan..."
            //             });
            //         }
            //     });
            // });

        </script>
        <script src="plugins/common/common.min.js"></script>
        <script src="js/custom.min.js"></script>
        <script src="js/settings.js"></script>
        <script src="js/gleek.js"></script>
        <script src="js/styleSwitcher.js"></script>


        <script src="plugins/jqueryui/js/jquery-ui.min.js"></script>
        <script src="plugins/moment/moment.min.js"></script>
        <script src="plugins/fullcalendar/js/fullcalendar.min.js"></script>
        <script src="js/plugins-init/fullcalendar-init.js"></script>

</body>

</html>