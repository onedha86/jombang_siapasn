<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-cuti/CutiUsulan");

$reqId= $this->input->get("reqId");

if(empty($reqId)) $reqId= -1;

$statement= " AND A.CUTI_USULAN_ID = ".$reqId;
$set= new CutiUsulan();
$set->selectcetak(array(), -1,-1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqNipBaru= $set->getField("NIP_BARU");
$reqNamaPegawai= $set->getField("NAMA_LENGKAP");
$reqJabatanNama= $set->getField("JABATAN_NAMA");
$reqPangkatNama= $set->getField("PANGKAT_NAMA")." (".$set->getField("PANGKAT_KODE").")";
$reqSatuanKerjaNama= $set->getField("SATUAN_KERJA_NAMA");
$reqTglMulai= dateToPageCheck($set->getField("TANGGAL_MULAI"));
$reqTglSelesai= dateToPageCheck($set->getField("TANGGAL_SELESAI"));
$reqLamaDurasi= $set->getField("LAMA_HARI");

$reqNomor= $set->getField("NOMOR");
$reqTanggalKirim= dateToPageCheck($set->getField("TANGGAL_KIRIM"));
$reqTanggalTte= getFormattedDateTimeCheck($set->getField("LAST_DATE"), false);

$infobaseurl= base_url();
$fileqrname= "uploads/cuti/".$reqId.'/qr.png';
?>
<link href="<?=$infobaseurl?>css/gaya-surat.css" rel="stylesheet" type="text/css">
<style>
  body{
      background-image:url('<?=$infobaseurl?>images/bg_cetak.jpg')  ;
      background-image-resize:6;
      background-size: cover;
  }
</style>
<body>


<div  class="kop-surat" >
  <center><u style="text-transform:uppercase;font-size: 16px;">SURAT IZIN CUTI ALASAN PENTING</u></center>
  <div class="nomor-naskah" style=" text-align: center;font-size: 14px;">Nomor : <?=$reqNomor?></div>
</div>

<div class="isi-naskah" style="left:8%; width: 84% !important">
  <p style="font-size: 14px;">Diberikan Cuti Karena Alasan Penting untuk Tahun 2023 kepada Pegawai Negeri Sipil :<br></p>

  <p>
    <table width="100%" style="font-size: 14px;">
      <tr>
        <td width="15%">Nama</td>
        <td width="1%">:</td>
        <td width="59%"><?=$reqNamaPegawai?></td>
      </tr>
      <tr>
        <td width="15%">Nomor Induk Pegawai</td>
        <td width="1%">:</td>
        <td width="59%"><?=$reqNipBaru?></td>
      </tr>
      <tr>
        <td width="15%">Pangkat/Gol. Ruang</td>
        <td width="1%">:</td>
        <td width="59%"><?=$reqPangkatNama?></td>
      </tr>
      <tr>
        <td width="15%">Jabatan</td>
        <td width="1%">:</td>
        <td width="59%"><?=$reqJabatanNama?></td>
      </tr>
      <tr>
        <td width="15%">Unit Kerja</td>
        <td width="1%">:</td>
        <td width="59%"><?=$reqSatuanKerjaNama?></td>
      </tr>
    </table>
  </p>

  <p style="font-size: 14px;">
    Selama LAMA_CUTI, terhitung mulai tanggal <?=$reqTglMulai?> sampai dengan tanggal <?=$reqTglSelesai?>, karena ALASAN, izin Cuti diberikan dengan ketentuan sebagai berikut :
  </p>

  <p>
    <table width="100%" style="font-size: 14px;">
      <tr>
        <td width="1%">a.</td>
        <td>Sebelum menjalankan Cuti Karena Alasan Penting wajib menyerahkan pekerjaannya kepada atasan langsungnya.</td>
      </tr>
      <tr>
        <td width="1%">b.</td>
        <td>Setelah selesai menjalankan Cuti Karena Alasan Penting wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali sebagaimana biasa.</td>
      </tr>
    </table>
  </p>

  <p style="font-size: 14px;">
    Demikian Surat Izin Cuti Karena Alasan Penting dibuat untuk dapat dipergunakan  sebagaimana mestinya.
  </p>

</div> 

<!-- End Isi Naskah -->

<!-- Start Tanda Tangan -->
<div class="tanda-tangan-kanan">
  <table width="100%" style="font-size: 14px;">
    <tr>
      <td width="20%">Ditetapkan di</td>
      <td width="1%">:</td>
      <td width="59%"> Jombang</td>
    </tr>
    <tr class="border-bottom">
      <td>Pada tanggal</td>
      <td>:</td>
      <td>
        <?
        if(file_exists($fileqrname))
        {
          echo $reqTanggalTte;
        }
        ?>
      </td>
    </tr>

    <tr>
      <td colspan="3"><br>JABATAN_PENGIRIM</td>
    </tr>
    <tr>
      <td colspan="3">
        <?
        if(file_exists($fileqrname))
        {
        ?>
        <img src="<?=$infobaseurl.$fileqrname?>" height="100px">
        <br>
        <?
        }
        ?>
      </td>
    </tr>
    <tr>
      <td colspan="3">NAMA_PENGIRIM</td>
    </tr>
    <tr>
      <td colspan="3">NIP. NIP_PENGIRIM</td>
    </tr>
  </table>
  <br>&nbsp;
   
  <br>



</div>
<!-- End Isi Naskah -->

</body>