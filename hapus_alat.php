<?php

//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_SESSION['errQ'])) {
        $errQ = $_SESSION['errQ'];
        echo '<div id="alert-message" class="row jarak-card">
                    <div class="col m12">
                        <div class="card red lighten-5">
                            <div class="card-content notif">
                                <span class="card-title red-text"><i class="material-icons md-36">clear</i> ' . $errQ . '</span>
                            </div>
                        </div>
                    </div>
                </div>';
        unset($_SESSION['errQ']);
    }

    $id_alat = mysqli_real_escape_string($config, $_REQUEST['id_alat']);

    $query = mysqli_query($config, "SELECT * FROM tbl_alat WHERE id_alat='$id_alat'");

    if (mysqli_num_rows($query) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_array($query)) {

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
            				                    <td width="13%">No.Alat</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">' . $row['no_alat'] . '</td>
            				                </tr>
            				                <tr>
            				                    <td width="13%">Nama Alat</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">' . $row['nama_alat'] . '</td>
            				                </tr>
            				                <tr>
            				                    <td width="13%">Jumlah</td>
            				                    <td width="1%">:</td>
            				                   <td width="86%">' . $row['jumlah'] . '</td>
            				                </tr>
            				                <tr>
            				                    <td width="13%">Kondisi</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">' . $row['kondisi'] . '</td>
            				                </tr>
                                                        <tr>
                                                            <td width="13%">Status Alat</td>
                                                            <td width="1%">:</td>
                                                            <td width="86%">' . $row['status_alat'] . '</td>
                                                        </tr>
                                                        <tr>
    			                    <td width="13%">File</td>
    			                    <td width="1%">:</td>
    			                    <td width="86%">';
            if (!empty($row['file'])) {
                echo ' <a class="blue-text" href="?page=galeri_alat&act=file_alat&id_alat=' . $row['id_alat'] . '">' . $row['file'] . '</a>';
            } else {
                echo ' Tidak ada file yang diupload';
            } echo '</td>
    			                </tr>
            				            </tbody>
            				   		</table>
        				        </div>
                                <div class="card-action">
        	                <a href="?page=master_alat&act=del&submit=yes&id_alat='.$row['id_alat'].'" class="btn-large deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
        	                <a href="?page=master_alat" class="btn-large blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
    	                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row form END -->';

            	if(isset($_REQUEST['submit'])){
            		$id_alat = $_REQUEST['id_alat'];

                    //jika ada file akan mengekseskusi script dibawah ini
                    if(!empty($row['file'])){
                        unlink("upload/master_alat/".$row['file']);
                        $query = mysqli_query($config, "DELETE FROM tbl_alat WHERE id_alat='$id_alat'");

                		if($query == true){
                            $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
                            header("Location: ./admin.php?page=master_alat");
                            die();
                		} else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">
                                    window.location.href="./admin.php?page=master_alat&act=del&id_alat='.$id_alat.'";
                                  </script>';
                		}
                	} else {

                        //jika tidak ada file akan mengekseskusi script dibawah ini
                        $query = mysqli_query($config, "DELETE FROM tbl_alat WHERE id_alat='$id_alat'");

                        if($query == true){
                            $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
                            header("Location: ./admin.php?page=master_alat");
                            die();
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">
                                    window.location.href="./admin.php?page=master_alat&act=del&id_alat='.$id_alat.'";
                                  </script>';
                        }
                    }
    	    }
        }
    }
}
?>
