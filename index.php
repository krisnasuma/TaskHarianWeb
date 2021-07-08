<?php
//include file koneksi database agar bisa berkomunikasi ke page ini
include 'dbconnect.php';
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>To Do List</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1 class="text-center">ToDoList-App</h1>
			</div>
			
			<div class="col-md-6">
				<div class="card shadow-lg border-0">
					<div class="card-body">

						<!--judul header-->
						<h3><center>Form Tambah Tugas</center></h3>

                        <!--Pastikan menambahkan method post sebagai aksi menambahkan data ke database-->
						<form method="post">
							<!--div bagian input-->
							<div class="form-group">
                                <!--tag "name" berguna untuk mendefinisikan variable dll, pastikan sesuai dengan nama "kolom" pada tabel data-->
                                <!--tag required untuk mengisikan form bahwa data tidak boleh kosong(harus diisi)-->
								<input type="text" class="form-control" name="task_name" placeholder="Masukkan Daftar Tugas Anda" required>
							</div>

							<!--div bagian form tambah tugas-->
							<div class="form-group">
                                <!--pastikan menggunakan name add_post sebagai respon method dari form nya-->
								<button type="submit" name="add_post" class="btn btn-primary btn-block">Tambah Tugas</button>
							</div>
                        </form>

                        <!--php untuk membuat navigasi/tombol form submit bekerja-->
                        <?php
                            //gunakan fungsi isset pada php
                            if (isset($_POST['add_post'])) {
                                //fungsi mysqli_real_escape_string untuk menjaga secure ketika mengisi form
                                $task_name = mysqli_real_escape_string($connection,$_POST['task_name']);
                                //fungsi mysqli query untuk mengadakan interaksi php ke database
                                //lakukan juga sintaks mysql untuk input data ke database
                                $query = mysqli_query($connection,"INSERT INTO tasks (task_name,task_status,task_date)
                                                                               VALUES ('$task_name','pending',now()) ");
                                //untuk Value task date kita gunakan fungsi "now()" sehingga waktu sekarang akan terisi.
                                
                                //setelah data tersimpan lakukan aksi pada page dengan mengembalikan ke page tujuan
                                
                                //---------------------Panel Notifikasi------------------------//
                                if ($query)
                                //jika sudah sukses akan muncul pop up "data tersimpan"
                                {
                                    ?>
                                        <script type="text/javascript">
                                            alert("Data Berhasil Tersimpan");
                                            document.location.href="index.php"; //kembalikan ke tampilan tujuan
                                        </script>
                                    <?php
                                }

                                //jika salah maka muncul pop up "tidak tersimpan"
                                else {
                                    ?>
                                        <script type="text/javascript">
                                            alert("Data Tidak Berhasil Tersimpan");
                                            document.location.href="index.php"; //kembalikan ke tampilan tujuan
                                        </script>
                                    <?php
                                }
                                //-----------------------Panel Notifikasi----------------------//

                            }
                        ?>
                        <!--php untuk membuat navigasi/tombol form submit bekerja-->

						<!--judul header-->
						<h3><center>Daftar Pending Tugas</center></h3>						

						<!--kerangka list-->
						<ul class="list-group">
                            <!------------------------php untuk menampilkan------------------------------>

                            <!--Sehingga sistem akan mengulang (looping dan menampilkan pada daerah baris ini)-->
                            <?php
                            //fungsi mysqli query untuk mengadakan interaksi php ke database
                            //Isikan juga sintaks mysql untuk request ubah/update ('status' (dari pending -> selesai)) ke database
                            $query = mysqli_query($connection,"SELECT * FROM tasks WHERE task_status='pending' ");
                            while ($row = mysqli_fetch_array($query)) {
                                $task_id=$row['task_id'];
                                $task_name=$row['task_name'];
                                $task_date=$row['task_date'];
                            //}
                            ?>

							<!--List Tampil Tugas-->
							<li class="list-group-item">
                                
                                <?php
                                    echo '<b>',$task_name,'</b>';
                                    echo '<br>';
                                    echo 'Mulai dari ',$task_date;
                                ?>

								<!--buat button mencolok ke kanan menggunakan div-->
								<div class="float-right">
									<!--Button-->
									<a href="index.php?edit=<?php echo $task_id; ?>" class="btn btn-info">
										Selesai
									</a>
									<a href="index.php?delete=<?php echo $task_id; ?>" class="btn btn-danger">
										Hapus
									</a>
								</div>

                            </li>

                            <?php } ?>

                            <!------------------------php untuk menampilkan------------------------------>

                            <!--php untuk membuat navigasi/tombol form Edit dan Delete bekerja-->
                            <?php
                                if(isset($_GET['edit'])) {
                                    $task_id = $_GET['edit'];
                                    //fungsi mysqli query untuk mengadakan interaksi php ke database
                                    //Isikan juga sintaks mysql untuk request ubah/update ('status' (dari pending -> selesai)) ke database
                                    $query = mysqli_query($connection,"UPDATE tasks SET task_status='selesai' WHERE task_id='$task_id' ");

                                    //---------------------Panel Notifikasi------------------------//
                                    if ($query)
                                    //jika sudah sukses akan muncul pop up "data diubah"
                                    {
                                        ?>
                                            <script type="text/javascript">
                                                alert("Data Diubah");                                                
                                                document.location.href="index.php"; //kembalikan ke tampilan tujuan
                                            </script>
                                        <?php
                                    }

                                    //jika salah maka mucul pop up "gagal diubah"
                                    else {
                                        ?>
                                            <script type="text/javascript">
                                                alert("Gagal Diubah");                                                
                                                document.location.href="index.php"; //kembalikan ke tampilan tujuan
                                            </script>
                                        <?php
                                    }
                                    //-----------------------Panel Notifikasi----------------------//

                                }

                                if (isset($_GET['delete'])) {
                                    $task_id = $_GET['delete'];
                                    //fungsi mysqli query untuk mengadakan interaksi php ke database
                                    //Isikan juga sintaks mysql untuk hapus isi yang sudah tertera di database
                                    $query = mysqli_query($connection,"DELETE FROM tasks WHERE task_id='$task_id' ");

                                    //---------------------Panel Notifikasi------------------------//
                                    if ($query)
                                    //jika sudah sukses akan muncul pop up "data dihapus"
                                    {
                                        ?>
                                            <script type="text/javascript">
                                                alert("Data Dihapus");                                                
                                                document.location.href="index.php"; //kembalikan ke tampilan tujuan
                                            </script>
                                        <?php
                                    }

                                    //jika salah maka mucul pop up "gagal dihapus"
                                    else {
                                        ?>
                                            <script type="text/javascript">
                                                alert("Gagal Dihapus");                                                
                                                document.location.href="index.php"; //kembalikan ke tampilan tujuan
                                            </script>
                                        <?php
                                    }
                                    //-----------------------Panel Notifikasi----------------------//

                                }
                            ?>
                            <!--php untuk membuat navigasi/tombol form Edit dan Delete bekerja-->
                            

						</ul>

					</div>
				</div>
            </div>

			<div class="col-md-6">
				<div class="card shadow-lg border-0">
					<div class="card-body">
						<h3><center>Tugas Selesai</center></h3>

						<!--kerangka list-->
						<ul class="list-group">

                        <?php
                            //fungsi mysqli query untuk mengadakan interaksi php ke database
                            //Isikan juga sintaks mysql untuk request ubah/update ('status' (dari pending -> selesai)) ke database
                            //sehingga hasil selesai akan ditampilkan pada bagian ini
                            $query = mysqli_query($connection,"SELECT * FROM tasks WHERE task_status='selesai' ");

                            while ($row = mysqli_fetch_array($query)) {
                                #
                            //}
                        ?>

							<!--List Tampil-->
							<li class="list-group-item">
                                
                            <?php
                            //panggil/tampilkan loop array langsung disini (alternatif)
                            echo $row['task_name'];
                            ?>

								<!--buat button mencolok ke kanan menggunakan div-->
								<div class="float-right">
                                    
									<!--Tampil Berupa Status-->
									<span class="badge btn-success">
                                        <?php
                                            //panggil/tampilkan loop array langsung disini (alternatif)
                                            echo $row['task_status'];
                                        ?>
									</span>

								</div>

                            </li>

                     <?php } ?>

						</ul>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="assets/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- DataTables -->
	<script src="assets/plugins/datatables/jquery.dataTables.js"></script>
	<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
	<!-- AdminLTE App -->
    <script src="assets/dist/js/adminlte.min.js"></script>
    
</body>
</html>