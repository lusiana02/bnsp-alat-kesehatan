<h2 style="color: black; text-align: center;">DATA PELANGGAN</h2>

<br>
<table class='table table-bordered'>
	<thead>
		<tr>
			<th><center>No</center></th>
			<th><center>Nama</center></th>
			<th><center>email</center></th>
			<th><center>password</center></th>
			<th><center>telepon</center></th>
			<th><center>aksi</center></th>
		</tr>
	</thead>
	<tbody align="center">
		<?php $nomor=1 ?>
		<?php $ambil=$koneksi->query('SELECT * FROM pelanggan'); ?>
		<?php while($pecah=$ambil->fetch_assoc()){ ?>
		<tr>
			<td><?php echo $nomor ; ?></td>
			<td><?php echo $pecah['nama_pelanggan'] ; ?></td>
			<td><?php echo $pecah['email_pelanggan'] ; ?></td>
			<td><?php echo $pecah['password_pelanggan'] ?></td>
			<td><?php echo $pecah['telepon_pelanggan'] ; ?></td>
			<td>
				<a href="index.php?halaman=hapus_pelanggan&id=<?php echo $pecah['id_pelanggan']; ?>" class='btn btn-danger'>Hapus</a>
			</td>
		</tr>
		<?php $nomor++ ?>
		<?php } ?>
	</tbody>
</table>