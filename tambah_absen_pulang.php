<?php
//cek session
if (empty($_SESSION['admin']) || empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if (isset($_REQUEST['submit'])) {
        // // // Periksa CSRF Token
        if (!empty($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            // Token cocok, lanjutkan dengan pemrosesan data
            // ...
            // Hapus token dari sesi agar tidak dapat digunakan lagi
            unset($_SESSION['csrf_token']);
        } else {
            // Token tidak cocok, mungkin serangan CSRF
            echo 'Token tidak valid. Formulir tidak dapat diproses.';
        }
        if (empty($_REQUEST['long']) || empty($_REQUEST['lat']) || empty($_FILES['file']['name'])) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {
            $longi = $_REQUEST['long'];
            $lati = $_REQUEST['lat'];
            $status_absen = "Sudah Pulang";
            $jenis_absen = "Pulang";
            $id = $_REQUEST['id'];
            $id_user = $_SESSION['id_user'];


            $ekstensi = array('jpg', 'png', 'jpeg');
            $file = $_FILES['file']['name'];
            $x = explode('.', $file);
            $eks = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $file = preg_replace('/[,]/', '-', $file);
            $target_dir = "upload/absen/";

            //jika form file tidak kosong akan mengeksekusi script dibawah ini
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            //jika form file tidak kosong akan mengeksekusi script dibawah ini
            if (!empty($file)) {

                $nfile = uniqid() . "-" . $file;
                //validasi file
                if (in_array($eks, $ekstensi) == true) {
                    if ($ukuran < 10000000) {

                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                        $query = mysqli_query($config, "INSERT INTO tbl_absen (longi, lati, status_absen, jenis_absen,file,id, id_user)
                        VALUES ('$longi', '$lati', '$status_absen', '$jenis_absen','$nfile','$id','$id_user')");

                        if ($query == true) {
                            mysqli_query($conn, "UPDATE tbl_absen SET status_absen = '$status_absen' WHERE id_absen = '$id'");
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=absen");
                            die();
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">window.history.back();</script>';
                        }
                    } else {
                        $_SESSION['errSize'] = 'Ukuran file yang diupload terlalu besar!';
                        echo '<script language="javascript">window.history.back();</script>';
                    }
                } else {
                    $_SESSION['errFormat'] = 'Format file yang diperbolehkan hanya *.JPG, *.PNG, *.DOC, *.DOCX atau *.PDF!';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            } else {

                //jika form file kosong akan mengeksekusi script dibawah ini
                $query = mysqli_query($config, "INSERT INTO tbl_absen (longi, lati, status_absen, jenis_absen, id_user)
                VALUES ('$longi', '$lati', '$status_absen', '$jenis_absen','$id_user')");

                if ($query === true) {
                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                    header("Location: ./admin.php?page=absen");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }
            }
        }
    }
    // Generate CSRF Token
    $csrf_token = bin2hex(random_bytes(32));

    // Simpan token di sesi
    $_SESSION['csrf_token'] = $csrf_token;
    $id = intval($_REQUEST['id_absen']); ?>
    <!-- Row Start -->
    <div class="row">
        <!-- Secondary Nav START -->
        <div class="col s12">
            <div class="z-depth-1">
                <nav class="secondary-nav">
                    <div class="nav-wrapper blue darken-2">
                        <div class="col m7">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons md-3">add_alert</i> Tambah Absen Pulang</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Secondary Nav END -->
    </div>
    <!-- Row END -->

    <?php
    if (isset($_SESSION['succAdd'])) {
        $succAdd = $_SESSION['succAdd'];
        echo '<div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succAdd . '</span>
                            </div>
                        </div>
                    </div>
                </div>';
        unset($_SESSION['succAdd']);
    }
    if (isset($_SESSION['succEdit'])) {
        $succEdit = $_SESSION['succEdit'];
        echo '<div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succEdit . '</span>
                            </div>
                        </div>
                    </div>
                </div>';
        unset($_SESSION['succEdit']);
    }
    if (isset($_SESSION['succDel'])) {
        $succDel = $_SESSION['succDel'];
        echo '<div id="alert-message" class="row">
                    <div class="col m12">
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succDel . '</span>
                            </div>
                        </div>
                    </div>
                </div>';
        unset($_SESSION['succDel']);
    }

    ?>
    <!-- Row form Start -->
    <div class="row jarak-form">
        <button class="btn small blue-grey waves-effect waves-light" name="getloc" id="getloc" onclick="getLocation()">Get Location</button>
        <!-- Form START -->
        <form class=" col s12" method="post" enctype="multipart/form-data">

            <!-- Row in form START -->
            <div class="row">
                <div class="input-field col s12">
                    <input type="text" id="lati" placeholder="Latitude" disabled>
                    <input type="hidden" name="lat" id="lat" required>
                    <input type="text" id="longi" placeholder="Longitude" disabled>
                    <input type="hidden" name="long" id="long" required>
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <a id="locationLink" href="#" target="_blank"></a>
                </div>
                <div class="input-field col s12">
                    <div class="file-field input-field">
                        <div class="btn small light-green darken-1">
                            <span>File</span>
                            <input type="file" id="file" name="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload Foto">
                            <?php
                            if (isset($_SESSION['errSize'])) {
                                $errSize = $_SESSION['errSize'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errSize . '</div>';
                                unset($_SESSION['errSize']);
                            }
                            if (isset($_SESSION['errFormat'])) {
                                $errFormat = $_SESSION['errFormat'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errFormat . '</div>';
                                unset($_SESSION['errFormat']);
                            }
                            ?>
                            <small class="red-text">*Format file yang diperbolehkan *.JPG, *.PNG, *.DOC, *.DOCX, *.PDF dan ukuran maksimal file 2 MB!</small>
                        </div>
                    </div>
                </div>
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">


            </div>
            <div class="row">
                <div class="col 6">
                    <button type="submit" name="submit" class="btn small blue waves-effect waves-light" onclick="disableButton()">SIMPAN <i class="material-icons">done</i></button>
                </div>
                <div class="col 6">
                    <button type="reset" onclick="window.history.back();" class="btn small deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></button>
                </div>
            </div>
            <!-- ROW IN FORM END -->
        </form>
        <!-- FORM END -->
    </div>
    <!-- ROW END -->
    <script>
        function disableButton() {
            document.getElementById('submitBtn').disabled = true;
        }
    </script>
    <script>
        function showPosition(position) {
            // Menyusun tautan dan menampilkannya setelah mendapatkan lokasi

        }

        function getLocation() {
            if (navigator.permissions) {
                navigator.permissions.query({
                    name: 'geolocation'
                }).then(permissionStatus => {
                    if (permissionStatus.state === 'granted') {
                        // Izin lokasi sudah diberikan, dapatkan lokasi
                        navigator.geolocation.getCurrentPosition(showPosition);
                    } else if (permissionStatus.state === 'prompt') {
                        // Izin lokasi belum diberikan, tampilkan notifikasi
                        navigator.geolocation.getCurrentPosition(
                            showPosition,
                            error => {
                                console.error(error);
                                alert("Gagal mendapatkan lokasi. Pastikan Anda memberikan izin akses lokasi.");
                            }
                        );
                    } else if (permissionStatus.state === 'denied') {
                        // Izin lokasi ditolak
                        alert("Akses lokasi ditolak. Silakan izinkan akses lokasi pada browser Anda.");
                    }
                });
            } else {
                // Browser tidak mendukung Permissions API
                alert("Browser tidak mendukung Permissions API. Periksa pengaturan izin lokasi secara manual.");
            }
        }

        function handleError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }

        function showPosition(position) {
            var input = document.getElementById('lati');
            var input2 = document.getElementById('longi');
            var input3 = document.getElementById('lat');
            var input4 = document.getElementById('long');
            var getloc = document.getElementById('getloc');
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            // Mengisi nilai input dengan data lokasi
            input.value = position.coords.latitude;
            input2.value = position.coords.longitude;
            input3.value = position.coords.latitude;
            input4.value = position.coords.longitude;
            // link google map
            var link = `https://www.google.com/maps/place/${latitude},${longitude}/@${latitude},${longitude},17z/data=!3m1!4b1!4m4!3m3!8m2!3d${latitude}!4d${longitude}?entry=ttu`;
            // link latlong.net
            var linkUrl = "https://www.latlong.net/c/?lat=" + position.coords.latitude + "&long=" + position.coords.longitude;
            locationLink.href = link; //pilih mau pake yang mana google map atau latlong.net
            locationLink.textContent = "(" + "Cek lokasi Anda" + ")"; //untuk text pada link
            locationLink.style.display = 'inline'; // Menampilkan tautan
            getloc.style.display = 'none'; // Menampilkan tautan
        }
    </script>
    <!-- <script>
        let stream;
        const videoElement = document.getElementById('videoElement');
        const btnStart = document.getElementById('start');
        const btnPhoto = document.getElementById('btnPhoto');
        const photoElement = document.getElementById('photo');
        const fileInput = document.getElementById('file');
        // document.addEventListener('DOMContentLoaded', function() {
        //     startCamera();
        // });
        async function startCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: true
                });
                const videoElement = document.getElementById('videoElement');
                videoElement.srcObject = stream;
                btnStart.style.display = 'none';
                btnPhoto.style.display = 'block'; // Tampilkan tombol ambil foto
            } catch (error) {
                console.error('Gagal mendapatkan akses kamera:', error);
                alert('Gagal mendapatkan akses kamera. Pastikan izin kamera diizinkan.');
            }

        }

        function stopCamera() {
            const tracks = stream.getTracks();
            tracks.forEach(track => track.stop());
            videoElement.srcObject = null;
        }

        function capturePhoto() {
            const canvas = document.createElement('canvas');
            canvas.width = videoElement.videoWidth;
            canvas.height = videoElement.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

            // Mengonversi elemen <canvas> ke dalam gambar (PNG)
            const imageDataURL = canvas.toDataURL('image/png');

            // Fungsi untuk mengonversi data URL ke dalam objek File
            function dataURLtoFile(dataURL, fileName) {
                const arr = dataURL.split(',');
                const mime = arr[0].match(/:(.*?);/)[1];
                const bstr = atob(arr[1]);
                let n = bstr.length;
                const u8arr = new Uint8Array(n);
                while (n--) {
                    u8arr[n] = bstr.charCodeAt(n);
                }
                return new File([u8arr], fileName, {
                    type: mime
                });
            }


            // Tampilkan foto dalam elemen gambar
            photoElement.src = imageDataURL;
            photoElement.style.display = 'block';

            // Sembunyikan elemen video setelah mengambil foto
            videoElement.style.display = 'none';
            btnPhoto.style.display = 'none';

            // Hentikan kamera setelah mengambil foto
            stopCamera();

            // Selanjutnya, Anda dapat mengirim formData ke server atau melakukan operasi lain sesuai kebutuhan
            // Membuat objek FormData dan menambahkan file ke dalamnya
            const formData = new FormData();
            const file = dataURLtoFile(imageDataURL, 'captured_image.png');
            formData.append('file', file);

            // Menetapkan FormData ke input file
            fileInput.files = formData.getAll('file');
            var long = document.getElementById('long').value;
            var lat = document.getElementById('lat').value;
            var id_user = document.getElementById('id_user').value;
            // Tambahkan variabel $nama ke objek FormData
            formData.append('long', long);

            // Tambahkan variabel $id_user ke objek FormData
            formData.append('lat', lat);
            formData.append('id_user', id_user);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'upload_absen.php');
            // Hapus baris ini jika tidak membutuhkan responseType blob
            // xhr.responseType = 'blob';

            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert('Berhasil Menambahkan Data!');
                    window.location.href = '?page=absen';
                } else {
                    alert('GAGAL! Terdapat masalah dalam pengiriman data ke server.');
                }
            };

            xhr.send(formData);
        }
    </script> -->

<?php
}
