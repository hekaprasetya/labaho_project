<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if(isset($_SESSION['errQ'])){
            $errQ = $_SESSION['errQ'];
            echo '<div id="alert-message" class="row jarak-card">
                    <div class="col m12">
                        <div class="card red lighten-5">
                            <div class="card-content notif">
                                <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errQ.'</span>
                            </div>
                        </div>
                    </div>
                </div>';
            unset($_SESSION['errQ']);
        }

    	$id_lpt = mysqli_real_escape_string($config, $_REQUEST['id_lpt']);

    	$query = mysqli_query($config, "SELECT * FROM tbl_lpt WHERE id_lpt='$id_lpt'");

    	if(mysqli_num_rows($query) > 0){
            $no = 1;
            while($row = mysqli_fetch_array($query)){

    		  echo '<!-- Row form Start -->
    				<div class="row jarak-card">
    				    <div class="col m12">
                            <div class="card">
                                <div class="card-content">
            				        <table>
            				            <thead class="red lighten-5 red-text">
            				                <div class="confir red-text"><i class="material-icons md-36">error_outline</i>
            				                Apakah Anda yakin akan menghapus data ini?</div>
            				            </thead>

            				            <tbody>
            				                <tr>
            				                    <td width="13%">No.PMK</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">'.$row['no_lpt'].'</td>
            				                </tr>
            				                <tr>
            				                    <td width="13%">No.Form</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">'.$row['no_form'].'</td>
            				                </tr>
            				                <tr>
            				                    <td width="13%">Tgl.LPT</td>
            				                    <td width="1%">:</td>
            				                   <td width="86%">'.date('d M Y', strtotime($row['tgl_lpt'])).'</td>
            				                </tr>
            				                <tr>
            				                    <td width="13%">Nama Teknisi</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">'.$row['nama_tk'].'</td>
            				                </tr>
                                                        <tr>
                                                            <td width="13%">Nama Perusahaan</td>
                                                            <td width="1%">:</td>
                                                            <td width="86%">'.$row['nama_perusahaan'].'</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="13%">Peminta</td>
                                                            <td width="1%">:</td>
                                                            <td width="86%">'.$row['peminta'].'</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="13%">Lokasi Pengerjaan</td>
                                                            <td width="1%">:</td>
                                                            <td width="86%">'.$row['lokasi_pengerjaan'].'</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="13%">Jenis Pekerjaan</td>
                                                            <td width="1%">:</td>
                                                            <td width="86%">'.$row['jenis_pekerjaan'].'</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="13%">Nama Material</td>
                                                            <td width="1%">:</td>
                                                            <td width="86%">'.$row['nama_material'].'</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="13%">Pekerjaan</td>
                                                            <td width="1%">:</td>
                                                            <td width="86%">'.$row['pekerjaan'].'</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="13%">Lama Kerja</td>
                                                            <td width="1%">:</td>
                                                            <td width="86%">'.$row['lama_kerja'].'</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="13%">Catatan</td>
                                                            <td width="1%">:</td>
                                                            <td width="86%">'.$row['catatan'].'</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="13%">Verifikator</td>
                                                            <td width="1%">:</td>
                                                            <td width="86%">'.$row['verifikator'].'</td>
                                                        </tr>
                                                        <tr>
            				                    <td width="13%">Tgl.Verifikator</td>
            				                    <td width="1%">:</td>
            				                   <td width="86%">'.date('d M Y', strtotime($row['tgl_verifikator'])).'</td>
            				                </tr>
            				            </tbody>
            				   		</table>
        				        </div>
                                <div class="card-action">
        		                     <a href="?page=tsm&act=lpt&id_surat='.$row['id_surat'].'&sub=del&submit=yes&id_lpt='.$row['id_lpt'].'" class="btn-large deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
        		                    <a href="?page=tsm&act=lpt&id_surat='.$row['id_surat'].'" class="btn-large blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row form END -->';

                	if(isset($_REQUEST['submit'])){
                		$id_lpt = $_REQUEST['id_lpt'];

                		$query = mysqli_query($config, "DELETE FROM tbl_lpt WHERE id_lpt='$id_lpt'");

                		if($query == true){
                            $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus ';
                            echo '<script language="javascript">
                                    window.location.href="./admin.php?page=tsm&act=lpt&id_surat='.$row['id_surat'].'";
                                  </script>';
                		} else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">
                                    window.location.href="./admin.php?page=tsm&act=lpt&id_surat='.$row['id_surat'].'&sub=del&id_lpt='.$row['id_lpt'].'";
                                  </script>';
                		}
                	}
    		    }
    	    }
        }
?>
