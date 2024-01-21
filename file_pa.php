<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        $id_pa = mysqli_real_escape_string($config, $_REQUEST['id_pa']);
        $query = mysqli_query($config, "SELECT * FROM tbl_pa WHERE id_pa='$id_pa'");
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_array($query)){
                echo '
                    <div class="row jarak-form">
                        <ul class="collapsible white" data-collapsible="accordion">
                            <li>
                                <div class="collapsible-header white"><i class="material-icons md-prefix md-36">expand_more</i><span class="add">Tampilkan detail data E-P.A</span></div>
                                    <div class="collapsible-body white">
                                        <div class="col m12 white">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td width="13%">No. PA</td>
                                                        <td width="1%">:</td>
                                                        <td width="86%">'.$row['no_pa'].'</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="13%">Nama Perusahaan</td>
                                                        <td width="1%">:</td>
                                                        <td width="86%">'.$row['nama_perusahaan'].'</td>
                                                    </tr>
                                                    <td width="13%">Penanggung Jawab</td>
                                                    <td width="1%">:</td>
                                                    <td width="86%">'.$row['penanggung_jawab'].'</td>
                                                    </tr>
                                                    <tr>
                                                    <td width="13%">No.Telp</td>
                                                    <td width="1%">:</td>
                                                    <td width="86%">'.$row['no_telp'].'</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="13%">perhitungan_total</td>
                                                        <td width="1%">:</td>
                                                        <td width="86%">'.$row['perhitungan_total'].'</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="13%">Ruang Sewa</td>
                                                        <td width="1%">:</td>
                                                        <td width="86%">'.$row['ruangan_sewa'].'</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="13%">Judul</td>
                                                        <td width="1%">:</td>
                                                        <td width="86%">'.$row['judul'].'</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="13%">Tgl.Acara</td>
                                                        <td width="1%">:</td>
                                                        <td width="86%">'.indoDate($row['tgl_acara']).'</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>

                        <button onclick="window.history.back()" class="btn-large blue waves-effect waves-light left"><i class="material-icons">arrow_back</i> KEMBALI</button>';

                        if(empty($row['file'])){
                            echo '';
                        } else {

                            $ekstensi = array('jpg','png','jpeg');
                            $ekstensi2 = array('doc','docx');
                            $file = $row['file'];
                            $x = explode('.', $file);
                            $eks = strtolower(end($x));

                            if(in_array($eks, $ekstensi) == true){
                                echo '<img class="gbr" data-caption="'.date('d M Y', strtotime($row['tgl_acara'])).'" src="./upload/permintaan_acara/'.$row['file'].'"/>';
                            } else {

                                if(in_array($eks, $ekstensi2) == true){
                                    echo '
                                    <div class="gbr">
                                        <div class="row">
                                            <div class="col s12">
                                                <div class="col s9 left">
                                                    <div class="card">
                                                        <div class="card-content">
                                                            <p>File lampiran surat masuk ini bertipe <strong>document</strong>, silakan klik link dibawah ini untuk melihat file lampiran tersebut.</p>
                                                        </div>
                                                        <div class="card-action">
                                                            <strong>Lihat file :</strong> <a class="blue-text" href="./upload/pa/'.$row['file'].'" target="_blank">'.$row['file'].'</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col s3 right">
                                                    <img class="file" src="./asset/img/word.png">
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                } else {
                                    echo '
                                    <div class="gbr">
                                        <div class="row">
                                            <div class="col s12">
                                                <div class="col s9 left">
                                                    <div class="card">
                                                        <div class="card-content">
                                                            <p>File lampiran surat masuk ini bertipe <strong>PDF</strong>, silakan klik link dibawah ini untuk melihat file lampiran tersebut.</p>
                                                        </div>
                                                        <div class="card-action">
                                                            <strong>Lihat file :</strong> <a class="blue-text" href="./upload/pa/'.$row['file'].'" target="_blank">'.$row['file'].'</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col s3 right">
                                                    <img class="file" src="./asset/img/pdf.png">
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                }
                            }
                        } echo '
                    </div>';
            }
        }
    }
?>
