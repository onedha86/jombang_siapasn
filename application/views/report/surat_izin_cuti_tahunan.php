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
$ttdjabatan= $set->getField("JABATAN_KEPALA");
$ttdnip= $set->getField("NIP_KEPALA");
$ttdnama= $set->getField("NAMA_KEPALA");

$reqNomor= $set->getField("VALID_NOMOR");
$reqTanggalKirim= dateToPageCheck($set->getField("TANGGAL_KIRIM"));

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
  <center><u style="text-transform:uppercase;font-size: 16px;">SURAT IZIN CUTI TAHUNAN</u></center>
  <div class="nomor-naskah" style=" text-align: center;font-size: 14px;">Nomor : <?=$reqNomor?></div>
</div>

<div class="isi-naskah">
  <p style="font-size: 14px;">Diberikan Cuti Tahunan kepada Pegawai Negeri Sipil :<br></p>

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
    Selama <?=$reqLamaDurasi?> hari kerja, terhitung mulai tanggal <?=$reqTglMulai?> sampai dengan tanggal <?=$reqTglSelesai?>, dengan ketentuan sebagai berikut :
  </p>

  <p>
    <table width="100%" style="font-size: 14px;">
      <tr>
        <td width="1%">a.</td>
        <td>Sebelum menjalankan Cuti Tahunan wajib menyerahkan pekerjaannya kepada atasan langsungnya.</td>
      </tr>
      <tr>
        <td width="1%">b.</td>
        <td>Setelah selesai menjalankan Cuti Tahunan wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali sebagaimana biasa.</td>
      </tr>
    </table>
  </p>

  <p style="font-size: 14px;">
    Demikian Surat Izin Cuti ini diberikan untuk dapat dipergunakan sebagaimana mestinya..
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
        
      </td>
    </tr>
    <tr>
      <td colspan="3"><br><?=$ttdjabatan?></td>
    </tr>
    <tr>
      <td colspan="3" style="color:darkgrey;">Ditandatangani secara elektronik</td>
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
      <td colspan="3"><?=$ttdnama?></td>
    </tr>
    <tr>
      <td colspan="3">NIP. <?=$ttdnip?></td>
    </tr>
  </table>
  <br>&nbsp;
   
  <br>



</div>
<!-- End Isi Naskah -->


<!-- Start Tembusan -->
<?
if ($suratmasukinfo->TEMBUSAN == "") {
} else {
?>
  <!-- <div class="tembusan" style="font-size:14px"> -->
  <div class="tembusan" style="font-size: 9px;font-family: 'FrutigerCnd-Normal'">

    <b style="font-size:14px" ><u>Tembusan Yth. :</u></b>
    <br>
    <?
    $arrTembusan = explode(",", $suratmasukinfo->TEMBUSAN);
    ?>
    <ol type="1">
      <?
      for ($i = 0; $i < count($arrTembusan); $i++) {
      ?>
        <li><?= $arrTembusan[$i] ?></li>
      <?
      }
      ?>
    </ol>
  </div>
<?
}
?>

<?
if($jumlahkepada > 4)
{
?>
<pagebreak />
<div class="isi-naskah">
  <table width="100%">
    <tr>
      <td style="width: 150px;"><b>Lampiran No</b></td>
      <td width="5%">:</td>
      <td width="65%" align="justify"><?=$suratmasukinfo->NOMOR?></td>
    </tr>
    <tr>
      <td><b>Tanggal</b></td>
      <td>:</td>
       <!--  <td align="justify"><?=$suratmasukinfo->TANGGAL?></td> -->
      <td align="justify"><?=getFormattedDate2($suratmasukinfo->TANGGAL, false)?></td>
    </tr>
    <tr>
      <td><b>Tentang</b></td>
      <td>:</td>
      <td align="justify"><?=$suratmasukinfo->PERIHAL?></td>
    </tr>
    <tr>
      <td style="padding-top: 50px"><b>Kepada Yth. </b></td>
      <td style="padding-top: 50px">:</td>
      <td style="padding-top: 50px" align="justify">
        <ol>
          <?
          foreach ($infokepada as $itemKepada) 
          {
          ?>
          <li><?= $itemKepada ?></li>
          <?
          }
          ?>
        </ol>
      </td>
    </tr>
  </table>
</div>
<?
}
?>

</body>