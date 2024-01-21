<?php
// Mulai atau lanjutkan session
session_start();

// ...

// Ambil nilai pesan dari session
$pesan = isset($_SESSION['pesan']) ? htmlspecialchars($_SESSION['pesan'], ENT_QUOTES, 'UTF-8') : '';
// Hapus nilai pesan dari session
unset($_SESSION['pesan']);

// Ambil nilai pesan_kosong dari session
$pesan_kosong = isset($_SESSION['pesan_kosong']) ? htmlspecialchars($_SESSION['pesan_kosong'], ENT_QUOTES, 'UTF-8') : '';
// Hapus nilai pesan_kosong dari session
unset($_SESSION['pesan_kosong']);



if (isset($_REQUEST['submitQR'])) {
    $posisi= htmlspecialchars($_POST['kode'], ENT_QUOTES, 'UTF-8');
    $csrf_token = htmlspecialchars($_POST['x'], ENT_QUOTES, 'UTF-8');

    // Verifikasi token CSRF
    if (!isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
        // Token CSRF tidak valid, tangani sesuai kebutuhan
        echo "Terjadi Kesalahan Silahkan Kembali Isi Formulir.";
        exit;
    }

    // Simpan data dalam sesi
    $_SESSION['form_qrcode'] = ['posisi' => $posisi];
    // Hapus token CSRF setelah digunakan (opsional)
    unset($_SESSION['csrf_token']);
    // Meneruskan nilai ke halaman qrcode_apar.php tanpa menyertakan data di URL
    header("Location: ./qrcode_apar.php");
    exit;
}


function generate_csrf_token()
{
    // Logika untuk menghasilkan token CSRF
    $token = bin2hex(random_bytes(32)); // Menggunakan random_bytes untuk mendapatkan string acak
    return $token;
}
$csrf_token = generate_csrf_token();
$_SESSION['csrf_token'] = $csrf_token;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GrahaPena</title>
</head>
<style>
    body {

        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 95vh;
    }

    .row {
        margin-left: auto;
        margin-right: auto;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    .container {
        padding: 0 1.5rem;
        margin: 0 auto;
        max-width: 1280px;
        width: 90%;
    }

    @media only screen and (min-width: 601px) {
        .container {
            width: 85%;
        }
    }

    @media only screen and (min-width: 993px) {
        .container {
            width: 90%;
        }
    }

    .bg::before {
        content: '';
        background-image: url('./asset/img/background.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
        position: absolute;
        z-index: -1;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        opacity: 100;
        filter: alpha(opacity=100);
        height: 100%;
        width: 100%;
    }

    .form-container {
        max-width: 400px;
        background-color: #fff;
        padding: 50px 50px;
        font-size: 14px;
        font-family: inherit;
        color: #212121;
        display: flex;
        flex-direction: column;
        gap: 20px;
        box-sizing: border-box;
        border-radius: 10px;
        box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.084), 0px 2px 3px rgba(0, 0, 0, 0.168);
    }

    .form-container button:active {
        scale: 0.95;
    }

    .form-container .logo-container {
        text-align: center;
        font-weight: 600;
        font-size: 18px;
    }

    .form-container .form {
        display: flex;
        flex-direction: column;
    }

    .form-container .form-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .form-container .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-container .form-group input {
        width: 90%;
        padding: 15px 10px;
        border-radius: 6px;
        font-family: inherit;
        border: 1px solid #ccc;
    }

    .form-container .form-group input::placeholder {
        opacity: 0.5;
    }

    .form-container .form-group input:focus {
        outline: none;
        border-color: #1778f2;
    }

    .form-container .form-submit-btn {
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: inherit;
        color: #fff;
        background-color: #212121;
        border: none;
        width: 100%;
        padding: 12px 16px;
        font-size: inherit;
        gap: 8px;
        margin: 12px 0;
        cursor: pointer;
        border-radius: 6px;
        box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.084), 0px 2px 3px rgba(0, 0, 0, 0.168);
    }

    .form-container .form-submit-btn:hover {
        background-color: #313131;
    }

    .form-container .link {
        color: #1778f2;
        text-decoration: none;
    }

    .form-container .signup-link {
        align-self: center;
        font-weight: 500;
    }

    .form-container .signup-link .link {
        font-weight: 400;
    }

    .form-container .link:hover {
        text-decoration: underline;
    }

    #alert-message {
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        font-size: 16px;
        margin-bottom: -15px;
    }

    .error {
        color: #f44336;
        padding: 10px;
    }

    .red.lighten-5 {
        background-color: #ffebee !important;
    }

    .center,
    .center-align {
        text-align: center;
    }

    .error_img {
        width: 20px;
    }
</style>

<body class="blue-grey lighten-3 bg">
    <div class="row">

        <div class="form-container">
            <div class="logo-container">
                Masukan Kode Item APAR
            </div>

            <form class="form" method="post">
                <div class="form-group">
                    <input type="hidden" name="x" value="<?= $csrf_token; ?>">
                    <label for="kode">Kode</label>
                    <input type="text" id="kode" name="kode" placeholder=" Masukan Kode Item" required>
                </div>

                <button class="form-submit-btn" name="submitQR" type="submit">Kirim</button>
            </form>
            <?php
            if (!empty($pesan)) {
                echo '<div id="alert-message" class="error red lighten-5" style="z-index: 1;"><div class="center"><img class="error_img" src="asset/img/warning.png"> <strong>ISI KODE ITEM TERLEBIH DAHULU</strong></div>';
            }
            if (!empty($pesan_kosong)) {
                echo '<div id="alert-message" class="error red lighten-5" style="z-index: 1;"><div class="center"><img class="error_img" src="asset/img/warning.png"> <strong>Data Tidak Ditemuka</strong></div>';
            }
            ?>
        </div>

    </div>
    <script>
        function hanyaAngka(event) {
            var charCode = (event.which) ? event.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                event.preventDefault();
            }
        }

        // Menambahkan event listener ke elemen input
      //  document.querySelector("input[name='kode']").addEventListener("keydown", hanyaAngka);
    </script>
    <script type="text/javascript">
        var message = "Ngapain?";

        function clickIE4() {

            if (event.button == 2) {

                alert(message);

                return false;

            }

        }

        function clickNS4(e) {

            if (document.layers || document.getElementById && !document.all) {

                if (e.which == 2 || e.which == 3) {

                    alert(message);

                    return false;

                }

            }

        }

        if (document.layers) {

            document.captureEvents(Event.MOUSEDOWN);

            document.onmousedown = clickNS4;

        } else if (document.all && !document.getElementById) {

            document.onmousedown = clickIE4;

        }

        document.oncontextmenu = new Function("alert(message);return false");
    </script>
</body>

</html>