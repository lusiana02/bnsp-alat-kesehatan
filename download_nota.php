<?php
// Memulai session
session_start();

// Memasukkan koneksi ke database
include "koneksi.php";

// Memasukkan pustaka mPDF
require_once __DIR__ . '/vendor/autoload.php'; // jika pakai Composer, sesuaikan jika tidak pakai Composer

// Mendapatkan detail pembelian
$id_pembelian = $_GET['id'];
$ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan
    ON pembelian.id_pelanggan = pelanggan.id_pelanggan
    WHERE pembelian.id_pembelian = '$id_pembelian'");
$detail = $ambil->fetch_assoc();

// Cek apakah pelanggan yang membeli sesuai dengan yang login
$idpelangganyangbeli = $detail["id_pelanggan"];
$idpelangganyanglogin = $_SESSION["pelanggan"]["id_pelanggan"];
if ($idpelangganyangbeli !== $idpelangganyanglogin) {
    echo "<script>alert('Jangan nakal!');</script>";
    echo "<script>location='riwayat.php';</script>";
    exit();
}

// Membuat konten HTML untuk diubah menjadi PDF
$html = "
    <h2 align='center'><strong>NOTA PEMBELIAN</strong></h2>
    <table border='1' cellspacing='0' cellpadding='10'>
        <tr>
            <td><strong>No. Pembelian</strong></td>
            <td>{$detail['id_pembelian']}</td>
        </tr>
        <tr>
            <td><strong>Tanggal</strong></td>
            <td>" . date("d F Y", strtotime($detail['tanggal_pembelian'])) . "</td>
        </tr>
        <tr>
            <td><strong>Total Pembelian</strong></td>
            <td>Rp. " . number_format($detail['total_pembelian']) . "</td>
        </tr>
        <tr>
            <td><strong>Nama Pelanggan</strong></td>
            <td>{$detail['nama_pelanggan']}</td>
        </tr>
        <tr>
            <td><strong>No. Telp</strong></td>
            <td>{$detail['telepon_pelanggan']}</td>
        </tr>
        <tr>
            <td><strong>Email</strong></td>
            <td>{$detail['email_pelanggan']}</td>
        </tr>
        <tr>
            <td><strong>Alamat Pengiriman</strong></td>
            <td>{$detail['alamat_pengiriman']}</td>
        </tr>
    </table>
    <br>
    <table border='1' cellspacing='0' cellpadding='10'>
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA PRODUK</th>
                <th>HARGA</th>
                <th>JUMLAH</th>
                <th>SUBTOTAL</th>
            </tr>
        </thead>
        <tbody>";

// Ambil produk yang dibeli
$nomor = 1;
$ambilProduk = $koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembelian = '$id_pembelian'");
while ($produk = $ambilProduk->fetch_assoc()) {
    $html .= "
        <tr>
            <td>{$nomor}</td>
            <td>{$produk['nama']}</td>
            <td>Rp. " . number_format($produk['harga']) . "</td>
            <td>{$produk['jumlah']}</td>
            <td>Rp. " . number_format($produk['subharga']) . "</td>
        </tr>";
    $nomor++;
}

$html .= "
        </tbody>
    </table>";

// Inisialisasi mPDF
$mpdf = new \Mpdf\Mpdf();

// Menambahkan HTML ke PDF
$mpdf->WriteHTML($html);

// Output file PDF
$mpdf->Output("nota_pembelian_" . $id_pembelian . ".pdf", \Mpdf\Output\Destination::INLINE);


