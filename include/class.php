<?php
class DataBaseHandler
{
    private $config;
    public function __construct($config)
    {
        $this->config = $config;
    }
    public function get($select = '*', $tbl, $where = '', $order = 'id DESC')
    {

        $whereClause = !empty($where) ? "WHERE $where" : '';
        $query = "SELECT $select FROM $tbl $whereClause ORDER BY $order";
        $result = mysqli_query($this->config, $query);

        if (mysqli_num_rows($result) > 0) {
            // Inisialisasi array untuk menyimpan data acara
            $response = array();

            // Loop untuk membaca hasil query
            while ($rowData = mysqli_fetch_assoc($result)) {
                $response[] = $rowData;
            }

            return $response;
        } else {
            return null;
        }
    }

    public function insert($tbl, $data, $values)
    {
        // Logika untuk menyisipkan data ke dalam tabel

        if (is_array($data) || is_array($values)) {
            // Membuat string kolom
            $valuesString = implode(', ', array_fill(0, count($data), '?'));
            $columnNames = implode(', ', $data);
            $query = "INSERT INTO $tbl ($columnNames) VALUES ($valuesString)";
        } else {

            $query = "INSERT INTO $tbl ($data) VALUES ($values)";
        }
        if (isset($query)) {
            $stmt = mysqli_prepare($this->config, $query);
            // Bind parameter untuk parameterized query
            mysqli_stmt_bind_param($stmt, str_repeat('s', count($data)), ...$values);
            if (mysqli_stmt_execute($stmt)) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
                $response['error'] = mysqli_error($this->config);
            }
        }
        return $response;
    }
    public function update($table, $column, $values, $where = 'id', $id)
    {
        // Logika untuk memperbarui data dalam tabel

        if (is_array($column) || is_array($values)) {
            // Mengonversi kunci array menjadi nama kolom
            $columnNames = implode(' = ?, ', $column) . ' = ?';

            $query = "UPDATE $table SET $columnNames WHERE $where = ?";
            $params = array_merge($values, array($id));
        } else {
            $query = "UPDATE $table SET $column = ? WHERE $where = ?";
            $stmt = mysqli_prepare($this->config, $query);
            // Bind parameter untuk parameterized query
            $params = [$values, $id];
            $column = [1];
        }
        if (isset($query)) {
            $stmt = mysqli_prepare($this->config, $query);
            // Bind parameter untuk parameterized query
            mysqli_stmt_bind_param($stmt, str_repeat('s', count($column)) . 's', ...$params);
            if (mysqli_stmt_execute($stmt)) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
                $response['error'] = mysqli_error($this->config);
            }
        }
        return $response;
    }


    public function del($table, $column = 'id', $conditions)
    {
        // Logika untuk menghapus data dari tabel
        if (is_array($table)) {
            // Jika $tbl adalah array, lakukan looping untuk menghapus tabel
            foreach ($table as $index => $tables) {
                // Membuat klausa WHERE untuk setiap tabel
                $kolom = $column[$index];
                $values = $conditions[$index];

                $query = "DELETE FROM $tables WHERE $kolom = '$values'";
                $res = mysqli_query($this->config, $query);
            }
        } else {

            $query = "DELETE FROM $table WHERE $column = '$conditions'";
            $res = mysqli_query($this->config, $query);

        }
        // Mengirim respons kembali ke klien
        if ($res == TRUE) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['error'] = mysqli_error($this->config);
        }
        return $response;
    }
}
class CRUD
{
    public $id,
    $id_name,
    $pg_name,
    $file,
    $dir,
    $config,
    $tbl_name,
    $limit,
    $pg,
    $judul,
    $icon_judul,
    $status;

    // Edit dan Hapus
    function crud()
    {
        ?>
        <a class="btn small blue darken-1  waves-effect waves-light tooltipped" data-position="left" data-tooltip="Edit"
            href="?page=<?= $this->pg_name ?>&act=edit&id_<?= $this->id_name ?>=<?= $this->id ?>">
            <i class="material-icons">edit</i></a>
        <a class="btn small deep-orange waves-effect waves-light tooltipped" data-position="left" data-tooltip="Hapus"
            href="?page=<?= $this->pg_name ?>&act=del&id_<?= $this->id_name ?>=<?= $this->id ?>">
            <i class="material-icons">delete</i></a>
        <?php
    }

    // Tidak ada data
    function nodata()
    {
        ?>
        <tr>
            <td colspan="12">
                <center>
                    <p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=<?= $this->pg_name ?>&act=add">Tambah
                                data baru</a></u></p>
                </center>
            </td>
        </tr>
        <?php
    }

    // file
    function tampilFile()
    { ?>
        <td>
            <?= (!empty($this->file)) ? "<img class='materialboxed' src='" . $this->dir . "' width=50px>" : "<em>Tidak ada file yang di upload</em>"; ?>
        </td>
        <?php
    }

    // Jumlah Hal
    function hal($config)
    {
        ?>
        <div id="modal_function" class="modal">
            <div class="modal-content white">
                <p>Jumlah data yang ditampilkan per halaman</p>
                <?php
                $query = mysqli_query($config, "SELECT id_sett,$this->tbl_name FROM tbl_sett");
                list($id_sett) = mysqli_fetch_array($query);
                ?>
                <div class="row">
                    <form method="post" action="?page=<?= $this->pg_name ?>">
                        <div class="input-field col s12">
                            <input type="hidden" value="<?= $id_sett ?>" name="id_sett">
                            <div class="input-field col s1" style="float: left;">
                                <i class="material-icons prefix md-prefix">looks_one</i>
                            </div>
                            <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                <select class="browser-default validate" name="hal_s" required>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="modal-footer white">
                                <button type="submit" class="modal-action waves-effect waves-green btn-flat"
                                    name="simpan">Simpan</button>
                                <?php
                                if (isset($_REQUEST['simpan'])) {
                                    $id_sett = "1";
                                    $x = $_REQUEST['hal_s'];

                                    $query = mysqli_query($config, "UPDATE tbl_sett SET $this->tbl_name='$x' WHERE id_sett='$id_sett'");
                                    if ($query == true) {
                                        header("Location: ./admin.php?page=$this->pg_name");
                                    }
                                }
                                ?>
                                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    // paggination
    function pagging($conn, $limit, $pg)
    {

        $query = mysqli_query($conn, "SELECT * FROM $this->tbl_name");
        $cdata = mysqli_num_rows($query);
        $cpg = ceil($cdata / $limit);

        ?><br /><!-- Pagination START -->
        <ul class="pagination">
            <?php
            if ($cdata > $limit) {

                //first and previous pagging
                if ($pg > 1) {
                    $prev = $pg - 1;
                    ?>
                    <li><a href="?page=<?= $this->pg_name ?>&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                    <li><a href="?page=<?= $this->pg_name ?>&pg=<?= $prev ?>"><i class="material-icons md-48">chevron_left</i></a></li>
                    <?php
                } else {
                    ?>
                    <li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                    <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>
                    <?php
                }

                //perulangan pagging
                for ($i = 1; $i <= $cpg; $i++) {
                    if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                        if ($i == $pg) {
                            ?>
                            <li class="active waves-effect waves-dark"><a href="?page=<?= $this->pg_name ?>&pg=<?= $i ?>">
                                    <?= $i ?>
                                </a></li>
                            <?php
                        } else {
                            ?>
                            <li class="waves-effect waves-dark"><a href="?page=<?= $this->pg_name ?>&pg=<?= $i ?>">
                                    <?= $i ?>
                                </a></li>
                            <?php
                        }
                    }
                }
                //last and next pagging
                if ($pg < $cpg) {
                    $next = $pg + 1;
                    ?>
                    <li><a href="?page=<?= $this->pg_name ?>&pg=<?= $next ?>"><i class="material-icons md-48">chevron_right</i></a></li>
                    <li><a href="?page=<?= $this->pg_name ?>&pg=<?= $cpg ?>"><i class="material-icons md-48">last_page</i></a></li>
                    <?php
                } else {
                    ?>
                    <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_right</i></a></li>
                    <li class="disabled"><a href="#"><i class="material-icons md-48">last_page</i></a></li>
                    <?php
                }
                ?>
            </ul>
            <?php
            } else {
                echo '';
            }
    }

    // SECONDARY NAV 
    function judul()
    {
        ?>
        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <div class="z-depth-1">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue darken-2">
                            <div class="col m7">
                                <ul class="left">
                                    <li class="waves-effect waves-light hide-on-small-only"><a
                                            href="?page=<?= $this->pg_name ?>" class="judul"><i class="material-icons md-3">
                                                <?= $this->icon_judul ?>
                                            </i>
                                            <?= $this->judul ?>
                                        </a></li>
                                    <li class="waves-effect waves-light">
                                        <a href="?page=<?= $this->pg_name ?>&act=add" class="judul"><i
                                                class="material-icons md-30">add_circle</i> Data</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col s4 show-on-med-and-down search right">
                                <form method="post" action="?page=<?= $this->pg_name ?>">
                                    <div class="input-field round-in-box">
                                        <input id="search" type="search" name="cari" placeholder="Searching" required>
                                        <label for="search"><i class="material-icons md-dark">search</i></label>
                                        <input type="submit" name="submit" class="hidden">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Secondary Nav END -->
        </div>
        <!-- Row END -->
        <?php
    }

    function judul_s()
    {
        ?>
        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <div class="z-depth-1">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue darken-2">
                            <div class="col m7">
                                <ul class="left">
                                    <li class="waves-effect waves-light hide-on-small-only"><a
                                            href="?page=<?= $this->pg_name ?>" class="judul"><i class="material-icons md-3">
                                                <?= $this->icon_judul ?>
                                            </i>
                                            <?= $this->judul ?>
                                        </a></li>
                                    <li class="waves-effect waves-light">
                                        <a href="?page=<?= $this->pg_name ?>&act=add" class="judul"><i
                                                class="material-icons md-30">add_circle</i> Data</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Secondary Nav END -->
        </div>
        <!-- Row END -->
        <div class="z-depth-1">
            <nav class="secondary-nav yellow darken-3">
                <form method="post" action="?page=<?= $this->pg_name ?>">
                    <center>
                        <div class="input-field round-in-box">
                            <input id="search" type="search" name="cari" placeholder="Searching" required>
                            <label for="search"><i class="material-icons md-dark">search</i></label>
                            <input type="submit" name="submit" class="hidden">
                        </div>
                    </center>
                </form>
            </nav>
        </div>
        <?php
    }

    // modal approve 
    function modalApp()
    {
        ?>
        <div id="modal2<?= $this->id ?>" class="modal">
            <div class="modal-content white">
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue darken-2">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i
                                                class="material-icons">description</i>Approve</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <!-- Secondary Nav END -->
                </div>

                <div class="row jarak-form">
                    <form class="col s12" method="post" action="">
                        <div class="input-field col s12" style="display: flex; flex-direction:column;">
                            <i class="material-icons prefix md-prefix">low_priority</i>
                            <label for="<?= $this->status ?>">Status</label>
                            <input type="hidden" name="id_<?= $this->id_name ?>" id="id_<?= $this->id_name ?>"
                                value="<?= $this->id ?>">
                            <br>
                            <div class="input-field col s11">
                                <select name="<?= $this->status ?>" class="browser-default validate" id="<?= $this->status ?>"
                                    required>
                                    <option value="" disabled selected>Pilih Status</option>
                                    <option value="Diterima">Diterima</option>
                                    <option value="Ditolak">Ditolak</option>
                                    <option value="Batal">Batal</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <button type="submit" name="submita" class="btn small blue waves-effect waves-light"
                            style="margin-top: 10px;">SIMPAN <i class="material-icons">done</i></button>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
}
