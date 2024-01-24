<?php
//cek session
if (!empty($_SESSION['admin'])) {
    ?>

    <noscript>
        <meta http-equiv="refresh" content="0;URL='./enable-javascript.html'" />
    </noscript>

    <!-- Footer START -->
    <footer class="page-footer">
        <div class="container">
            <div class="row">
                <br />
            </div>
        </div>
        <div class="footer-copyright blue darken-3 white-text">
            <div class="container" id="footer">
                <?php
                $query = mysqli_query($config, "SELECT * FROM tbl_instansi");
                while ($data = mysqli_fetch_array($query)) {
                    ?>
                    <?php echo "LABAHO - Labuan Bajo Holiday © 2024"; ?>
                <?php } ?>
            </div>
        </div>
    </footer>
    <!-- Footer END -->

    <!-- Javascript START -->
    <script type="text/javascript" src="asset/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="asset/js/materialize.min.js"></script>
    <script type="text/javascript" src="asset/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="asset/js/jquery.autocomplete.min.js"></script>
    <script data-pace-options='{ "ajax": false }' src='asset/js/pace.min.js'></script>
    <script src="node_modules/chart.js/dist/chart.umd.js"></script>
    <script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="asset/js/chartCustom.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            //jquery dropdown
            $(".dropdown-button").dropdown({
                hover: false
            });

            //jquery sidenav on mobile
            $('.button-collapse').sideNav({
                menuWidth: 240,
                edge: 'left',
                closeOnClick: true
            });

            //jquery datepicker
            $('#tgl_verifikator,#tgl_lpt,#tgl_surat,#jadwal,#keterangan,#batas_waktu,#dari_tanggal,#sampai_tanggal,#tgl,#tgl_acara,#tgl_ppi,#tgl_verifikasi,#tgl_pp,#target,#tgl_wo,#tgl_selesai,#tgl_join,#tgl_wo_fc,#tgl_selesai_fc,#tgl_lpg,#tgl_selesai,#target_mod,#tgl_op,#tgl_opb,#tgl_brg_dtg,#tgl_lahir,#tgl_gabung,#kontrak_habis,#tgl_cuti,#akhir_cuti,#tgl_cutibs_awal,#tgl_cutibs_akhir').pickadate({
                selectMonths: true,
                selectYears: 500,
                format: "yyyy-mm-dd"
            });

            //jquery textarea
            $('#isi_ringkas').val('');
            $('#isi_ringkas').trigger('autoresize');

            //jquery dropdown select dan tooltip
            $('select').material_select();
            $('.tooltipped').tooltip({
                delay: 10
            });

            //jquery autocomplete
            $("#kode").autocomplete({
                serviceUrl: "kode.php", // Kode php untuk prosesing data.
                dataType: "JSON", // Tipe data JSON.
                onSelect: function (suggestion) {
                    $("#kode").val(suggestion.kode);
                }
            });

            //jquery untuk menampilkan pemberitahuan
            $("#alert-message").alert().delay(5000).fadeOut('slow');

            //jquery modal
            $('.modal-trigger').leanModal();
        });
    </script>
    <script>
        $(window).on("load", function () {
            setTimeout(removeLoader); //wait for page load PLUS two seconds.
        });

        function removeLoader() {
            $("#loader").fadeOut(500, function () {
                // fadeOut complete. Remove the loading div
                $("#loader").remove(); //makes page more lightweight 
            });
        }
    </script>
    <script>
        function cetak() {
            setTimeout(function () {
                window.print();
            }, 500);
        }
    </script>
    <script>


    </script>
    <!-- Javascript END -->

    <?php
} else {
    header("Location: ../");
    die();
}
?>