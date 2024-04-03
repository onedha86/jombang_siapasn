<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$CI =& get_instance();
$CI->checkUserLogin();

$this->load->model("base-cuti/CutiUsulan");
$this->load->model("base-cuti/CutiUrutan");
$this->load->model("base-cuti/CutiUsulanTurunStatus");
$this->load->model("base-cuti/CutiUsulanTmsTolak");
$this->load->model('KualitasFile');
$this->load->library('globalfilepegawai');
$this->load->model("base-cuti/PendidikanRiwayat");
$this->load->model('TekenLog');

$query = $this->db->query("SELECT * FROM JENIS_CUTI");
$arrDataJenis = $query->result_array();

$query = $this->db->query("SELECT * FROM JENIS_CUTI_DETAIL");
$arrDataJenisDetail = $query->result_array();

$query = $this->db->query("SELECT * FROM JENIS_CUTI_DURASI");
$arrDataJenisDurasi = $query->result_array();

$arrDataLamaDurasi = array();
foreach($arrDataJenisDurasi as $value){
  $arrDataLamaDurasi[$value['jenis_cuti_durasi_id']]['BATAS_AWAL']=$value['batas_awal'];
  $arrDataLamaDurasi[$value['jenis_cuti_durasi_id']]['BATAS_AKHIR']=$value['batas_akhir'];
}

$reqId= $this->input->get("reqId");
$reqRowId= $this->input->get("reqRowId");
$m= $this->input->get("m");
$cekquery= $this->input->get("c");

if(empty($reqRowId))
{
  if(empty($reqId))
  {
    /*$reqNipBaru= "197107041993031005";
    $reqNipAtasan= "196710031992012001";
    $reqNipKepala= "196606291993021001";*/
  }
  else
  {
    if(!empty($reqId))
    {
      $CI->checkpegawai($reqId);

      $statementdetil= " AND A.PEGAWAI_ID = ".$reqId;
      $setdetil= new PendidikanRiwayat();
      $setdetil->selectByParamsPegawai(array(), -1, -1, $statementdetil);
      $setdetil->firstRow();
      // echo $setdetil->query;exit;

      $reqId= $setdetil->getField("PEGAWAI_ID");
      $reqJabatanRiwayatId= $setdetil->getField("JABATAN_RIWAYAT_ID");
      $reqPangkatRiwayatId= $setdetil->getField("PANGKAT_RIWAYAT_ID");
      $reqNipBaru= $setdetil->getField("NIP_BARU");
      $reqNamaPegawai= $setdetil->getField("NAMA_LENGKAP");
      $reqJabatanNama= $setdetil->getField("JABATAN_NAMA");
      $reqMasaKerjaTahun= $setdetil->getField("MASA_KERJA_TAHUN");
      $reqMasaKerjaBulan= $setdetil->getField("MASA_KERJA_BULAN");
      $reqPangkatRiwayatAkhir= $setdetil->getField("PANGKAT_KODE");
      $reqSatuanKerjaId= $setdetil->getField("SATUAN_KERJA_ID");
      $reqSatuanKerjaNama= $setdetil->getField("SATUAN_KERJA_NAMA");
      $reqTmtCpns= dateToPageCheck($setdetil->getField("TMT_CPNS"));
      $reqTmtPns= dateToPageCheck($setdetil->getField("TMT_PNS"));
    }

    /*$reqNipAtasan= "196710031992012001";
    $reqNipKepala= "196606291993021001";*/
  }
}
else
{
  $statement= " AND A.CUTI_USULAN_ID = ".$reqRowId;
  $set= new CutiUsulan();
  $set->selectByParams(array(), -1,-1, $statement);
  $set->firstRow();

  $reqId= $set->getField("PEGAWAI_ID");
  $reqJabatanRiwayatId= $set->getField("JABATAN_RIWAYAT_ID");
  $reqPangkatRiwayatId= $set->getField("PANGKAT_RIWAYAT_ID");
  $reqNipBaru= $set->getField("NIP_BARU");
  $reqNamaPegawai= $set->getField("NAMA_LENGKAP");
  $reqJabatanNama= $set->getField("JABATAN_NAMA");
  $reqMasaKerjaTahun= $set->getField("MASA_KERJA_TAHUN");
  $reqMasaKerjaBulan= $set->getField("MASA_KERJA_BULAN");
  $reqPangkatRiwayatAkhir= $set->getField("PANGKAT_KODE");
  $reqSatuanKerjaNama= $set->getField("SATUAN_KERJA_NAMA");
  $reqTmtCpns= dateToPageCheck($set->getField("TMT_CPNS"));
  $reqTmtPns= dateToPageCheck($set->getField("TMT_PNS"));

  $reqJenis= $set->getField("JENIS_CUTI_ID");
  $reqAlasanJenis= $set->getField("JENIS_CUTI_DETAIL_ID");
  $reqJenisDurasi= $set->getField("JENIS_CUTI_DURASI_ID");
  $reqLamaDurasi= $set->getField("LAMA_HARI");
  $reqKeteranganDetil= $set->getField("KETERANGAN_DETIL");

  $reqPegawaiAtasanId= $set->getField("PEGAWAI_ATASAN_ID");
  $reqNipAtasan= $set->getField("NIP_ATASAN");
  $reqNamaAtasan= $set->getField("NAMA_ATASAN");

  $reqPegawaiKepalaId= $set->getField("PEGAWAI_KEPALA_ID");
  $reqNipKepala= $set->getField("NIP_KEPALA");
  $reqNamaKepala= $set->getField("NAMA_KEPALA");
  $reqStatusBerkas= $set->getField("STATUS_BERKAS");
  $reqStatusTms= $set->getField("STATUS_TMS");
  $reqPosisiMenuId= $set->getField("POSISI_MENU_ID");

  $reqH2= $set->getField("LAMA_CUTI_N2");
  $reqSisaH2= $set->getField("SISA_CUTI_N2");
  $reqH1= $set->getField("LAMA_CUTI_N1");
  $reqSisaH1= $set->getField("SISA_CUTI_N1");
  $reqH= $set->getField("LAMA_CUTI_N");
  $reqSisaH= $set->getField("SISA_CUTI_N");

  $reqTglMulai= dateToPageCheck($set->getField("TANGGAL_MULAI"));
  $reqTglSelesai= dateToPageCheck($set->getField("TANGGAL_SELESAI"));

  $reqPegawaiPenandaTanganId= $set->getField("MENU_PENANDA_TANGAN_ID");
  $reqNomor= $set->getField("NOMOR");
  $reqValidTte= $set->getField("VALID_TTE");
  $reqTanggalKirim= dateToPageCheck($set->getField("TANGGAL_KIRIM"));
  /*
  $reqStatusCutiBesar= $this->input->post('reqStatusCutiBesar');
  */
}

$arrkualitasfile= $arrlistpilihfilefield= $reqDokumenPilih= $arrlistriwayatfilepegawai= $arrsetriwayatfield= [];
if(!empty($reqId))
{
  // untuk kondisi file
  $vfpeg= new globalfilepegawai();
  $arrpilihfiledokumen= $vfpeg->pilihfiledokumen();
  // print_r($arrpilihfiledokumen);exit;

  $riwayattable= "CUTI_USULAN";
  $reqDokumenKategoriFileId= "66"; // ambil dari table KATEGORI_FILE, cek sesuai mode
  $arrsetriwayatfield= $vfpeg->setriwayatfield($riwayattable);
  // print_r($arrsetriwayatfield);exit;

  if(empty($reqRowId))
    $arrlistriwayatfilepegawai= $vfpeg->listpilihfilepegawai($reqId, $riwayattable, "baru");
  else
    $arrlistriwayatfilepegawai= $vfpeg->listpilihfilepegawai($reqId, $riwayattable, $reqRowId);

  $arrlistpilihfile= $arrlistriwayatfilepegawai["pilihfile"];
  // print_r($arrlistpilihfile);exit;
  $arrlistriwayat= $arrlistriwayatfilepegawai["riwayat"];

  // $keymode= $riwayattable.";".$reqRowId.";foto";
  foreach ($arrsetriwayatfield as $key => $value)
  {
    $keymode= $value["riwayatfield"];
    $arrlistpilihfilefield[$keymode]= [];

    if(!empty($arrlistpilihfile))
    {
      $arrlistpilihfilefield[$keymode]= $vfpeg->ambilfilemode($arrlistpilihfile, $keymode);

      $reqDokumenPilih[$keymode]= "";
      $infocari= "selected";
      $arraycari= in_array_column($infocari, "selected", $arrlistpilihfilefield[$keymode]);
      // print_r($arraycari);exit;
      if(!empty($arraycari))
      {
        // print_r($arraycari);exit;
        $reqDokumenPilih[$keymode]= 2;
      }
    }
  }
  // print_r($reqDokumenPilih);exit;
  // print_r($arrlistpilihfilefield);exit;

  $set= new KualitasFile();
  $set->selectByParams(array());
  // echo $set->query;exit;
  while($set->nextRow())
  {
    $arrdata= [];
    $arrdata["ID"]= $set->getField("KUALITAS_FILE_ID");
    $arrdata["TEXT"]= $set->getField("NAMA");
    array_push($arrkualitasfile, $arrdata);
  }
}

// untuk setting hak akses sesuai menu
$arrpenandatangan= [];
$disabledmenu= "";
$jumlah_akses= 0;
if(!empty($m))
{
  $vquery= "SELECT COUNT(1) rowcount
  FROM user_login A
  INNER JOIN user_group A1 ON A.USER_GROUP_ID = A1.USER_GROUP_ID
  INNER JOIN akses_app_simpeg_menu A2 ON A1.AKSES_APP_SIMPEG_ID = A2.AKSES_APP_SIMPEG_ID
  WHERE A.USER_LOGIN_ID = ".$this->USER_LOGIN_ID."
  AND A2.AKSES = UPPER('A') AND A2.MENU_ID = '".$m."'
  ";
  $jumlah_akses= $this->db->query($vquery)->row()->rowcount;

  $arrmenulewati= array('130106', '130107', '130108');
  if(!in_array($m, $arrmenulewati))
  {

    $set= new CutiUrutan();
    $set->selectByParams(array(), -1,-1, " AND A.MENU_ID IN ('130106', '130107', '130108')");
    // echo $set->query;exit;
    while($set->nextRow())
    {
      $vdetilnama= $set->getField("NAMA");
      $arrdata= [];
      $arrdata["ID"]= $set->getField("MENU_ID");
      $arrdata["NAMA"]= str_replace("Teken ", "", $vdetilnama);
      array_push($arrpenandatangan, $arrdata);
    }
  }
}
// echo $jumlah_akses;exit;
// print_r($arrpenandatangan);exit;

if($jumlah_akses > 0)
{
  $disabledmenu= "disabled";
}

$disabledpenandatangan= $disabledmenu;

$aksiverifikator= "";
if($reqStatusBerkas == 1 && $m == "130104" && $jumlah_akses > 0)
{
  // echo "1";
  $disabledpenandatangan= "";
  $aksiverifikator= "1";
}

$aksiapproval= "";
if($reqStatusBerkas == 2 && $m == "130105" && $jumlah_akses > 0)
{
  // echo "2";
  $disabledpenandatangan= "";
  $aksiapproval= "1";
}

$aksiteken= "";
if($reqStatusBerkas == 3 && in_array($m, $arrmenulewati) && $jumlah_akses > 0)
{
  // echo "3";
  $aksiteken= "1";
}

$aksisimpan= "";
if((int)$reqStatusBerkas < 1 && empty($m))
{
  // echo "4";
  $aksisimpan= "1";
}

$aksikirim= "";
if(!empty($reqRowId) && $reqStatusBerkas == 0 && empty($m))
{
  // echo "5";
  $aksikirim= "1";
}

$aksibatalkirim= "";
if(!empty($reqRowId) && $reqStatusBerkas == 1 && empty($m))
{
  // echo "6";
  $disabledmenu= "disabled";
  $aksibatalkirim= "1";
}

if(!empty($reqRowId) && $reqStatusBerkas == 2 && $m =="130104")
{
  // echo "7";
  $aksibatalkirim= "1";
}

if(!empty($reqRowId) && $reqStatusBerkas == 3 && $m =="130105")
{
  // echo "7";
  $aksibatalkirim= "1";
}

// kalau tms button off dl
if(!empty($reqStatusTms))
{
  // echo "8";
  if($reqPosisiMenuId == $m)
  {
    $aksisimpan= $aksikirim= $aksibatalkirim= $aksiverifikator= $aksiapproval= $aksiteken= "";
    $disabledpenandatangan= $disabledmenu= "disabled";
  }

  if(empty($m))
  {
    $reqStatusTms= "";
  }
}

$lihatfilett= "";
if(!empty($reqRowId))
{
  $filelokasi= "uploads/cuti/".$reqRowId."/";
  $filehasiltt= $filelokasi.'draft_tt.pdf';

  if(file_exists($filehasiltt) && !empty($reqValidTte))
  {
    $aksisimpan= $aksikirim= $aksibatalkirim= $aksiverifikator= $aksiapproval= $aksiteken= "";
    $disabledpenandatangan= $disabledmenu= "disabled";
    $lihatfilett= "1";
  }
}

if(!empty($reqRowId) && $reqStatusBerkas > 1 && empty($m))
{
  // echo "9";
  $disabledmenu= "disabled";
}
// exit;

$arrLog= $arrTmsTolak= $arrTokenLog= [];
if(!empty($reqRowId))
{
  $set= new CutiUsulanTmsTolak();
  $statement= " AND A.CUTI_USULAN_ID = ".$reqRowId;
  $set->selectByParams(array(), -1, -1, $statement);
  // echo $set->query;exit;
  while($set->nextRow())
  {
    $arrdata= [];
    $arrdata["KETERANGAN"]= $set->getField("KETERANGAN");
    $arrdata["JENIS"]= $set->getField("JENIS");
    $arrdata["LAST_USER"]= $set->getField("LAST_USER");
    $arrdata["LAST_DATE"]= $set->getField("LAST_DATE");
    array_push($arrTmsTolak, $arrdata);
  }
  // print_r($arrTmsTolak);exit;

  $set= new TekenLog();
  $statement= " AND A.JENIS = 'cuti-".$reqRowId."'";
  $set->selectByParams(array(), -1, -1, $statement);
  // echo $set->query;exit;
  while($set->nextRow())
  {
    $arrdata= [];
    $arrdata["IP_ADDRESS"]= $set->getField("IP_ADDRESS");
    $arrdata["USER_AGENT"]= $set->getField("USER_AGENT");
    $arrdata["KETERANGAN"]= $set->getField("KETERANGAN");
    $arrdata["LAST_USER"]= $set->getField("LAST_USER");
    $arrdata["LAST_DATE"]= $set->getField("LAST_DATE");
    array_push($arrTokenLog, $arrdata);
  }

}
// print_r($arrLog);exit;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="msapplication-tap-highlight" content="no">
<meta name="description" content="Simpeg Jombang">
<meta name="keywords" content="Simpeg Jombang">
<title>Simpeg Jombang</title>
<base href="<?=base_url()?>" />


<!-- untuk format date baru -->
<script type="text/javascript" src='lib/datepickernew/jquery-1.8.3.min.js'></script>
<script type="text/javascript" src='lib/datepickernew/bootstrap.min.js'></script>
<link rel="stylesheet" href='lib/datepickernew/bootstrap.min.css' media="screen" />
<link rel="stylesheet" href="lib/datepickernew/bootstrap-datepicker.css" type="text/css" />
<script src="lib/datepickernew/bootstrap-datepicker.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="lib/easyui/themes/default/easyui.css">

  <!-- untuk format date baru -->

<link rel="stylesheet" type="text/css" href="lib/easyui/themes/default/easyui.css">
<!-- <script type="text/javascript" src="lib/easyui/jquery-1.8.0.min.js"></script> -->
<script type="text/javascript" src="lib/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="lib/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="lib/easyui/globalfunction.js"></script>

<!-- AUTO KOMPLIT -->
<link rel="stylesheet" href="lib/autokomplit/jquery-ui.css">
<script src="lib/autokomplit/jquery-ui.js"></script>

<!-- CORE CSS-->
<link href="lib/materializetemplate/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="lib/materializetemplate/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<!-- CSS style Horizontal Nav-->    
<link href="lib/materializetemplate/css/layouts/style-horizontal.css" type="text/css" rel="stylesheet" media="screen,projection">
<!-- Custome CSS-->    
<link href="lib/materializetemplate/css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

<?
if(!empty($aksiteken))
{
?>
<style type="text/css">
  .mbox-wrapper hr {
    display: none;
  } 
</style>
<?
}
?>
</head>

<body>
  <div id="basic-form" class="section">
    <div class="row">
      <div id='main' class="col s12 m12" style="padding-left: 15px;">
        
        <ul class="collection card">
          <li class="collection-item ubah-color-warna">Usulan Pelayanan Ijin Cuti</li>
          <li class="collection-item">
            <div class="row">
              <form id="ff" method="post" enctype="multipart/form-data">
                  <div class="row">
                    <div class="input-field col s4">
                        <label >NIP</label>
                        <?
                        if(empty($reqRowId))
                        {
                        ?>
                        <input placeholder="" required id="reqNipBaru" class="easyui-validatebox" type="text" value="<?=$reqNipBaru?>" />
                        
                        <?
                        }
                        else
                        {
                        ?>
                          <input id="reqNipBaru" type="hidden" value="<?=$reqNipBaru?>" />
                          <input placeholder="" required type="text" value="<?=$reqNipBaru?>" disabled />
                        <?
                         }
                        ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s6">
                      <label >Nama</label>
                      <input id="reqNamaPegawai" placeholder="" type="text" value="<?=$reqNamaPegawai?>" disabled />
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s4">
                      <label >Jabatan</label>
                      <input placeholder="" type="text" id="reqJabatanNama" value="<?=$reqJabatanNama?>" disabled/>
                    </div>
                    <div class="input-field col s1">
                      <label >Masa Kerja Tahun</label>
                      <input placeholder="" type="text" id="reqMasaKerjaTahun" value="<?=$reqMasaKerjaTahun?>" disabled />
                    </div>
                    <div class="input-field col s1">
                      <label >Masa Kerja Bulan</label>
                      <input placeholder="" type="text" id="reqMasaKerjaBulan" value="<?=$reqMasaKerjaBulan?>" disabled/>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s2">
                      <label >Pangkat / Gol</label>
                      <input placeholder="" id="reqPangkatRiwayatAkhir" type="text" value="<?=$reqPangkatRiwayatAkhir?>" disabled />
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <label >Unit Kerja</label>
                      <input placeholder="" id="reqSatuanKerjaNama" type="text" value="<?=$reqSatuanKerjaNama?>" disabled/>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s4">
                      <label >TMT CPNS</label>
                      <input placeholder="" class="easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTmtCpns" id="reqTmtCpns" value="<?=$reqTmtCpns?>" maxlength="10" onKeyDown="return format_date(event,'reqTmtCpns');" disabled />
                    </div>
                    <div class="input-field col s4">
                      <label >TMT PNS</label>
                      <input placeholder="" class="easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTmtPns" id="reqTmtPns" value="<?=$reqTmtPns?>" maxlength="10" onKeyDown="return format_date(event,'reqTmtPns');" disabled/>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s4">
                        <select <?=$disabledmenu?> name="reqJenis" id="reqJenis">
                        <option value=""></option>
                        <?
                        foreach ($arrDataJenis as $key => $value)
                        {
                          $optionid= $value["jenis_cuti_id"];
                          $optiontext= $value["nama"];

                          $optionselected= "";
                          if($reqJenis == $optionid)
                            $optionselected= "selected";
                        ?>
                         <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                        <?
                        }
                        ?>
                        </select>
                        <label for="reqJenis" >Jenis Cuti</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s6">
                      <select <?=$disabledmenu?> name="reqAlasanJenis" id="reqAlasanJenis">
                        <option value=""></option>
                      </select>
                      <label >Alasan</label>
                    </div>
                  </div>

                  <div class="row" id="divketerangandetil">
                    <div class="input-field col s10">
                      <label for="reqKeteranganDetil" id="labelketerangandetil"></label>
                      <input placeholder="" type="text" class="easyui-validatebox" name="reqKeteranganDetil" id="reqKeteranganDetil" value="<?=$reqKeteranganDetil?>" <?=$disabledmenu?> />
                    </div>
                  </div>

                  <div class="row">
                    <div class="input-field col s4">
                      <label >Tanggal Mulai</label>
                      <input <?=$disabledmenu?> placeholder="" maxlength="10" required class="easyui-validatebox formattanggalnew" data-options="validType:'dateValidPicker'" type="text" name="reqTglMulai" id="reqTglMulai" value="<?=$reqTglMulai?>" maxlength="10" onKeyDown="return format_date(event,'reqTglMulai');" onchange="checkValidasiTanggalTahunCuti();" />
                    </div>
                    <div class="input-field col s4">
                      <label >Tanggal Selesai</label>
                      <input <?=$disabledmenu?> placeholder="" maxlength="10" required class="easyui-validatebox formattanggalnew" data-options="validType:'dateValidPicker'" type="text" name="reqTglSelesai" id="reqTglSelesai" value="<?=$reqTglSelesai?>" maxlength="10" onKeyDown="return format_date(event,'reqTglSelesai');" onchange="checkValidasiTanggalTahunCuti();"/>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s4">
                      <label >Status Cuti Besar</label>
                      <input <?=$disabledmenu?> placeholder="" type="text" value="" id="reqStatusCutiBesar" />
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s4">
                         <label >Lama Cuti Tahunan N-2</label>
                         <input placeholder="" type="text" name="reqH2" id="reqH2" value="<?=$reqH2?>" class="colorreadonly" readonly />
                    </div>
                    <div class="input-field col s4">
                         <label >Sisa Cuti N-2</label>
                         <input placeholder="" type="text" name="reqSisaH2" id="reqSisaH2" value="<?=$reqSisaH2?>" class="colorreadonly" readonly />
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s4">
                      <label >Lama Cuti Tahunan N-1</label>
                      <input placeholder="" type="text" name="reqH1" id="reqH1" value="<?=$reqH1?>" class="colorreadonly" readonly />
                    </div>
                    <div class="input-field col s4">
                      <label >Sisa Cuti N-1</label>
                      <input placeholder="" type="text" name="reqSisaH1" id="reqSisaH1" value="<?=$reqSisaH1?>" class="colorreadonly" readonly />
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s4">
                         <label >Lama Cuti Tahunan N</label>
                         <input placeholder="" type="text" name="reqH" id="reqH" value="<?=$reqH?>" class="colorreadonly" readonly />
                    </div>
                    <div class="input-field col s4">
                         <label >Sisa Cuti N</label>
                         <input placeholder="" type="text" name="reqSisaH" id="reqSisaH" value="<?=$reqSisaH?>" class="colorreadonly" readonly />
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s10">
                        <label >Total Sisa Cuti N = (Sisa Cuti N + Sisa Cuti N-1) - Lama Cuti on Process</label>
                        <input placeholder="" type="text" id="reqTotalCutiSisa" class="colorreadonly" readonly />
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s4">
                          <select <?=$disabledmenu?> name="reqJenisDurasi" id="reqJenisDurasi">
                            <option value=""></option>
                          </select>
                          <label >Durasi</label>
                    </div>
                    <div class="input-field col s4">
                         <label >Lama</label>
                         <input <?=$disabledmenu?> class="vangka" placeholder="" type="text" id="reqLamaDurasi" name="reqLamaDurasi" value="<?=$reqLamaDurasi?>" />
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s4">
                         <label >NIP Atasan Langsung</label>
                         <input <?=$disabledmenu?> placeholder="" required id="reqNipAtasan" name="reqNipAtasan" class="easyui-validatebox" type="text" value="<?=$reqNipAtasan?>" />
                         <input type="hidden" name="reqPegawaiAtasanId" id="reqPegawaiAtasanId" value="<?=$reqPegawaiAtasanId?>" />
                   </div>
                   <div class="input-field col s4">
                         <label >Nama Atasan Langsung</label>
                         <input class="colorreadonly" placeholder="" type="text" name="reqNamaAtasan" id="reqNamaAtasan" readonly value="<?=$reqNamaAtasan?>" />
                   </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s4">
                      <label >NIP Kepala OPD</label>
                      <input <?=$disabledmenu?> placeholder="" required type="text" class="easyui-validatebox" name="reqNipKepala" id="reqNipKepala" value="<?=$reqNipKepala?>"/>
                      <input type="hidden" name="reqPegawaiKepalaId" id="reqPegawaiKepalaId" value="<?=$reqPegawaiKepalaId?>" />
                    </div>
                    <div class="input-field col s4">
                      <label >Nama Kepala OPD</label>
                      <input class="colorreadonly" placeholder="" type="text" id="reqNamaKepala" name="reqNamaKepala" readonly value="<?=$reqNamaKepala?>" />
                    </div>
                  </div>

                  <?
                  if(!empty($reqNomor))
                  {
                  ?>
                  <div class="row">
                    <div class="input-field col s4">
                      <label >No Usul</label>
                      <input placeholder="" class="easyui-validatebox" type="text" value="<?=$reqNomor?>" disabled />
                    </div>
                    <div class="input-field col s4">
                      <label >Tanggal Kirim</label>
                      <input placeholder="" class="easyui-validatebox" type="text" value="<?=$reqTanggalKirim?>" disabled/>
                    </div>
                  </div>
                  <?
                  }
                  ?>

                  <?
                  if(!empty($arrpenandatangan))
                  {
                  ?>
                  <div class="row">
                    <div class="input-field col s4">
                        <select <?=$disabledpenandatangan?> name="reqPegawaiPenandaTanganId" id="reqPegawaiPenandaTanganId">
                        <option value=""></option>
                        <?
                        foreach ($arrpenandatangan as $key => $value)
                        {
                          $optionid= $value["ID"];
                          $optiontext= $value["NAMA"];

                          $optionselected= "";
                          if($reqPegawaiPenandaTanganId == $optionid)
                            $optionselected= "selected";
                        ?>
                         <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                        <?
                        }
                        ?>
                        </select>
                        <label for="reqPegawaiPenandaTanganId">
                          Pilih Penandatangan TTE Surat Cuti
                          <span style="color: red;"> *</span>
                        </label>
                    </div>
                  </div>
                  <?
                  }
                  ?>

                  <input type="hidden" name="reqLamaHari" id="lamaHari" />
                  <input type="hidden" name="reqId" id="reqId" value="<?=$reqId?>" />
                  <input type="hidden" name="reqSatuanKerjaId" id="reqSatuanKerjaId" value="<?=$reqSatuanKerjaId?>" />
                  <input type="hidden" name="reqJabatanRiwayatId" id="reqJabatanRiwayatId" value="<?=$reqJabatanRiwayatId?>" />
                  <input type="hidden" name="reqPangkatRiwayatId" id="reqPangkatRiwayatId" value="<?=$reqPangkatRiwayatId?>" />
                  <input type="hidden" name="reqRowId" value="<?=$reqRowId?>" />
                  <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                  <input type="hidden" name="reqStatusBerkas" id="reqStatusBerkas" />
                  <input type="hidden" name="reqStatusSebelumBerkas" id="reqStatusSebelumBerkas" value="<?=$reqStatusBerkas?>" />
                  <input type="hidden" name="cekquery" value="<?=$cekquery?>" />
                  
                  <div class="row">
                    <div class="input-field col s12 m12">
                      <button type="submit" style="display:none" id="reqSubmit"></button>
                      <?
                      if(!empty($aksisimpan))
                      {
                      ?>
                      <button class="btn waves-effect waves-light green reqsimpan" style="font-size:9pt" type="button">
                        Simpan
                        <i class="mdi-content-save left hide-on-small-only"></i>
                      </button>
                      <?
                      }

                      if(!empty($aksikirim))
                      {
                      ?>
                      <button class="btn red waves-effect waves-light reqkirim" style="font-size:9pt" type="button" >Kirim
                          <i class="mdi-content-forward left hide-on-small-only"></i>
                      </button>
                      <?
                      }

                      if(!empty($aksibatalkirim))
                      {
                        $vdetilbatal= "ke Verifikator";
                        if($reqStatusBerkas == 2)
                        {
                          $vdetilbatal= "ke Approval";
                        }
                        else if($reqStatusBerkas == 3)
                        {
                          $vdetilbatal= "ke TTE";
                        }
                      ?>
                        <button class="btn red waves-effect waves-light reqbatalkirim" style="font-size:9pt" type="button">Batal Kirim <?=$vdetilbatal?>
                          <i class="mdi-content-save left hide-on-small-only"></i>
                        </button>

                        <?
                        if($reqStatusBerkas > 0)
                        {
                        ?>
                          <button class="btn blue waves-effect waves-light reqdraft" style="font-size:9pt" type="button">Cek Draft
                            <i class="mdi-editor-attach-file left hide-on-small-only"></i>
                          </button>
                        <?
                        }
                      }
                      ?>

                      <?
                      if(!empty($aksiverifikator))
                      {
                      ?>
                      <button class="btn waves-effect waves-light green reqsimpan" style="font-size:9pt" type="button">
                        Simpan
                        <i class="mdi-content-save left hide-on-small-only"></i>
                      </button>
                      <button class="btn purple waves-effect waves-light reqturunstatus" style="font-size:9pt" type="button">Turun Status
                        <i class="mdi-content-inbox left hide-on-small-only"></i>
                      </button>
                      <input type="hidden" id="reqStatusTms" value="1" />
                      <button class="btn pink waves-effect waves-light reqtms" style="font-size:9pt" type="button">TMS
                        <i class="mdi-content-inbox left hide-on-small-only"></i>
                      </button>
                      <button class="btn green waves-effect waves-light reqkirimapproval" style="font-size:9pt" type="button">Kirim Approval
                        <i class="mdi-content-inbox left hide-on-small-only"></i>
                      </button>
                      <button class="btn blue waves-effect waves-light reqdraft" style="font-size:9pt" type="button">Cek Draft
                        <i class="mdi-editor-attach-file left hide-on-small-only"></i>
                      </button>
                      <?
                      }
                      ?>

                      <?
                      if(!empty($aksiapproval))
                      {
                      ?>
                      <button class="btn waves-effect waves-light green reqsimpan" style="font-size:9pt" type="button">
                        Simpan
                        <i class="mdi-content-save left hide-on-small-only"></i>
                      </button>
                      <button class="btn purple waves-effect waves-light reqturunstatus" style="font-size:9pt" type="button">Turun Status
                        <i class="mdi-content-inbox left hide-on-small-only"></i>
                      </button>
                      <input type="hidden" id="reqStatusTms" value="1" />
                      <button class="btn pink waves-effect waves-light reqtms" style="font-size:9pt" type="button">TMS
                        <i class="mdi-content-inbox left hide-on-small-only"></i>
                      </button>
                      <button class="btn green waves-effect waves-light reqkirimteken" style="font-size:9pt" type="button">Kirim TTE Surat Cuti
                        <i class="mdi-content-inbox left hide-on-small-only"></i>
                      </button>
                      <button class="btn blue waves-effect waves-light reqdraft" style="font-size:9pt" type="button">Cek Draft
                        <i class="mdi-editor-attach-file left hide-on-small-only"></i>
                      </button>
                      <?
                      }
                      ?>

                      <?
                      if(!empty($aksiteken))
                      {
                      ?>
                      <button class="btn green waves-effect waves-light reqtekensurat" style="font-size:9pt" type="button">Teken Surat Cuti
                        <i class="mdi-content-inbox left hide-on-small-only"></i>
                      </button>
                      <button class="btn pink waves-effect waves-light reqtolak" style="font-size:9pt" type="button">Tolak
                        <i class="mdi-content-inbox left hide-on-small-only"></i>
                      </button>
                      <button class="btn blue waves-effect waves-light reqdraft" style="font-size:9pt" type="button">Cek Draft
                        <i class="mdi-editor-attach-file left hide-on-small-only"></i>
                      </button>
                      <?
                      }
                      ?>

                      <?
                      if(!empty($reqStatusTms))
                      {
                      ?>
                      <input type="hidden" id="reqStatusTms" value="" />
                      <button class="btn pink waves-effect waves-light reqbataltms" style="font-size:9pt" type="button">BATAL TMS
                        <i class="mdi-content-inbox left hide-on-small-only"></i>
                      </button>
                      <?
                      }
                      ?>

                      <?
                      if(!empty($lihatfilett))
                      {
                      ?>
                      <button class="btn blue waves-effect waves-light reqttfile" style="font-size:9pt" type="button">Lihat File TT
                        <i class="mdi-editor-attach-file left hide-on-small-only"></i>
                      </button>
                      <?
                      }
                      ?>

                      <button class="btn red waves-effect waves-light" style="font-size:9pt" type="button" id="tambah" onClick="parent.closeparenttab()">Close
                        <i class="mdi-navigation-close left hide-on-small-only"></i>
                      </button>
                    </div>
                  </div>

                  <div class="row">
                    <div class="input-field col s12 m12">
                    <?
                    // area untuk upload file
                    foreach ($arrsetriwayatfield as $key => $value)
                    {
                      $riwayatfield= $value["riwayatfield"];
                      $riwayatfieldtipe= $value["riwayatfieldtipe"];
                      $riwayatfieldinfo= $value["riwayatfieldinfo"];
                      $riwayatfieldstyle= $value["riwayatfieldstyle"];
                      // echo $riwayatfieldstyle;exit;
                    ?>
                      <button class="btn blue waves-effect waves-light" style="font-size:9pt;<?=$riwayatfieldstyle?>" type="button" id='buttonframepdf<?=$riwayatfield?>'>
                        <input type="hidden" id="labelvpdf<?=$riwayatfield?>" value="<?=$riwayatfieldinfo?>" />
                        <span id="labelframepdf<?=$riwayatfield?>"><?=$riwayatfieldinfo?></span>
                      </button>
                    <?
                    }
                    ?>
                    </div>
                  </div>

                  <div class="row"><div class="col s12 m12"><br/></div></div>

                  <?
                  // area untuk upload file
                  foreach ($arrsetriwayatfield as $key => $value)
                  {
                    $riwayatfield= $value["riwayatfield"];
                    $riwayatfieldtipe= $value["riwayatfieldtipe"];
                    $vriwayatfieldinfo= $value["riwayatfieldinfo"];
                    $riwayatfieldinfo= " - ".$vriwayatfieldinfo;
                    $riwayatfieldrequired= $value["riwayatfieldrequired"];
                    $riwayatfieldrequiredinfo= $value["riwayatfieldrequiredinfo"];
                    $vriwayattable= $value["vriwayattable"];
                    $vriwayatid= "";
                    $vpegawairowfile= $reqDokumenKategoriFileId."-".$vriwayattable."-".$riwayatfield."-".$vriwayatid;
                  ?>
                  <div class="row">
                    <div class="input-field col s12 m4">
                      <input type="hidden" id="reqDokumenRequired<?=$riwayatfield?>" name="reqDokumenRequired[]" value="<?=$riwayatfieldrequired?>" />
                      <input type="hidden" id="reqDokumenRequiredNama<?=$riwayatfield?>" name="reqDokumenRequiredNama[]" value="<?=$vriwayatfieldinfo?>" />
                      <input type="hidden" id="reqDokumenRequiredTable<?=$riwayatfield?>" name="reqDokumenRequiredTable[]" value="<?=$vriwayattable?>" />
                      <input type="hidden" id="reqDokumenRequiredTableRow<?=$riwayatfield?>" name="reqDokumenRequiredTableRow[]" value="<?=$vpegawairowfile?>" />
                      <input type="hidden" id="reqDokumenFileId<?=$riwayatfield?>" name="reqDokumenFileId[]" />
                      <input type="hidden" id="reqDokumenKategoriFileId<?=$riwayatfield?>" name="reqDokumenKategoriFileId[]" value="<?=$reqDokumenKategoriFileId?>" />
                      <input type="hidden" id="reqDokumenKategoriField<?=$riwayatfield?>" name="reqDokumenKategoriField[]" value="<?=$riwayatfield?>" />
                      <input type="hidden" id="reqDokumenPath<?=$riwayatfield?>" name="reqDokumenPath[]" value="" />
                      <input type="hidden" id="reqDokumenTipe<?=$riwayatfield?>" name="reqDokumenTipe[]" value="<?=$riwayatfieldtipe?>" />

                      <select id="reqDokumenPilih<?=$riwayatfield?>" name="reqDokumenPilih[]" <?=$disabledmenu?>>
                        <?
                        foreach ($arrpilihfiledokumen as $key => $value)
                        {
                          $optionid= $value["id"];
                          $optiontext= $value["nama"];
                        ?>
                          <option value="<?=$optionid?>" <? if($reqDokumenPilih[$riwayatfield] == $optionid) echo "selected";?>><?=$optiontext?></option>
                        <?
                        }
                        ?>
                      </select>
                      <label for="reqDokumenPilih<?=$riwayatfield?>">
                        File Dokumen<?=$riwayatfieldinfo?>
                        <span id="riwayatfieldrequiredinfo<?=$riwayatfield?>" style="color: red;"><?=$riwayatfieldrequiredinfo?></span>
                      </label>
                    </div>

                    <div class="input-field col s12 m4">
                      <select <?=$disabledmenu?> name="reqDokumenFileKualitasId[]" id="reqDokumenFileKualitasId<?=$riwayatfield?>">
                        <option value=""></option>
                        <?
                        foreach ($arrkualitasfile as $key => $value)
                        {
                          $optionid= $value["ID"];
                          $optiontext= $value["TEXT"];
                          $optionselected= "";
                          if($reqDokumenFileKualitasId == $optionid)
                            $optionselected= "selected";

                          $arrkecualitipe= [];
                          $arrkecualitipe= $vfpeg->kondisikategori($riwayatfieldtipe);
                          if(!in_array($optionid, $arrkecualitipe))
                            continue;
                        ?>
                          <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                        <?
                        }
                        ?>
                      </select>
                      <label for="reqDokumenFileKualitasId<?=$riwayatfield?>">Kualitas Dokumen<?=$riwayatfieldinfo?></label>
                    </div>

                    <div id="labeldokumenfileupload<?=$riwayatfield?>" class="input-field col s12 m4" style="margin-top: -25px; margin-bottom: 10px;">
                      <div class="file_input_div">
                        <div class="file_input input-field col s12 m4">
                          <label class="labelupload">
                            <i class="mdi-file-file-upload" style="font-family: "Roboto",sans-serif,Material-Design-Icons !important; font-size: 14px !important;">Upload</i>
                            <input id="file_input_file" name="reqLinkFile[]" class="none" type="file" />
                          </label>
                        </div>
                        <div id="file_input_text_div" class=" input-field col s12 m8">
                          <input class="file_input_text" type="text" disabled readonly id="file_input_text" />
                          <label for="file_input_text"></label>
                        </div>
                      </div>
                    </div>

                    <div id="labeldokumendarifileupload<?=$riwayatfield?>" class="input-field col s12 m4">
                      <select id="reqDokumenIndexId<?=$riwayatfield?>" name="reqDokumenIndexId[]" <?=$disabledmenu?>>
                        <option value="" selected></option>
                        <?
                        $arrlistpilihfilepegawai= $arrlistpilihfilefield[$riwayatfield];
                        foreach ($arrlistpilihfilepegawai as $key => $value)
                        {
                          $optionid= $value["index"];
                          $optiontext= $value["nama"];
                          $optionselected= $value["selected"];
                        ?>
                          <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                        <?
                        }
                        ?>
                      </select>
                      <label for="reqDokumenIndexId<?=$riwayatfield?>">Nama e-File<?=$riwayatfieldinfo?></label>
                    </div>

                  </div>
                  <?
                  }
                  // area untuk upload file
                  ?>

                  <?
                  for($i=0; $i<4;$i++)
                  {
                  ?>
                  <br/>
                  <?
                  }
                  ?>
      
                  <?
                  if(!empty($arrTmsTolak))
                  {
                    $infocari= "tms";
                    $arrcari= in_array_column($infocari, "JENIS", $arrTmsTolak);
                    if(!empty($arrcari))
                    {
                  ?>
                      <table class="bordered striped md-text table_list tabel-responsif" style="margin-top:20px">
                        <tr class="ubah-color-warna">
                          <th colspan="2" class="white-text material-font">Log Keterangan TMS</th>
                        </tr>
                        <?
                        foreach ($arrcari as $vindex)
                        {
                          $infologketerangan= $arrTmsTolak[$vindex]["KETERANGAN"];
                          $infologtanggal= datetimeToPage($arrTmsTolak[$vindex]["LAST_DATE"], "datetime");
                        ?>
                        <tr>
                          <td class="material-font" style="width:20%"><?=$infologtanggal?></td>
                          <td class="material-font"><?=$infologketerangan?></td>
                        </tr>
                        <?
                        }
                        ?>
                      </table>
                  <?
                    }

                    $infocari= "tolak";
                    $arrcari= in_array_column($infocari, "JENIS", $arrTmsTolak);
                    if(!empty($arrcari))
                    {
                  ?>
                      <table class="bordered striped md-text table_list tabel-responsif" style="margin-top:20px">
                        <tr class="ubah-color-warna">
                          <th colspan="2" class="white-text material-font">Log Keterangan Tolak</th>
                        </tr>
                        <?
                        foreach ($arrcari as $vindex)
                        {
                          $infologketerangan= $arrTmsTolak[$vindex]["KETERANGAN"];
                          $infologtanggal= datetimeToPage($arrTmsTolak[$vindex]["LAST_DATE"], "datetime");
                        ?>
                        <tr>
                          <td class="material-font" style="width:20%"><?=$infologtanggal?></td>
                          <td class="material-font"><?=$infologketerangan?></td>
                        </tr>
                        <?
                        }
                        ?>
                      </table>
                  <?
                    }
                  }
                  ?>

                  <?
                  if(!empty($arrLog))
                  {
                  ?>
                  <table class="bordered striped md-text table_list tabel-responsif" style="margin-top:20px">
                    <tr class="ubah-color-warna">
                      <th colspan="2" class="white-text material-font">Log Keterangan Turun Status</th>
                    </tr>
                    <?
                    foreach ($arrLog as $key => $value)
                    {
                      $infologketerangan= $value["KETERANGAN"];
                      $infologtanggal= datetimeToPage($value["LAST_DATE"], "datetime");
                    ?>
                    <tr>
                      <td class="material-font" style="width:20%"><?=$infologtanggal?></td>
                      <td class="material-font"><?=$infologketerangan?></td>
                    </tr>
                    <?
                    }
                    ?>
                  </table>
                  <?
                  }
                  ?>

                  <?
                  if(!empty($arrTokenLog))
                  {
                  ?>
                  <table class="bordered striped md-text table_list tabel-responsif" style="margin-top:20px">
                    <tr class="ubah-color-warna">
                      <th colspan="2" class="white-text material-font">Log Keterangan Teken</th>
                    </tr>
                    <?
                    foreach ($arrTokenLog as $key => $value)
                    {
                      $infologketerangan= $value["KETERANGAN"]."<br/>".$value["USER_AGENT"];
                      $infologtanggal= datetimeToPage($value["LAST_DATE"], "datetime");
                    ?>
                    <tr>
                      <td class="material-font" style="width:20%"><?=$infologtanggal?></td>
                      <td class="material-font"><?=$infologketerangan?></td>
                    </tr>
                    <?
                    }
                    ?>
                  </table>
                  <?
                  }
                  ?>

              </form>
            </div>
          </li>
        </ul>

      </div>

      <div id='divframepdf' class="col s12 m6" style="padding-top: 10px;">
        <input type="hidden" id="vnewframe" value="">
        <span id="labelriwayatframepdf"></span>
        <img id="infonewimage" style="width:inherit; width: 100%; height: 100%" />
        <iframe id="infonewframe" style="width: 100%; height: 160%" src=""></iframe>
      </div>

    </div>
  </div>

<div style="z-index: 99999;" class="preloader-wrapper big active loader">
  <div class="spinner-layer spinner-blue-only">
    <div class="circle-clipper left">
      <div class="circle"></div>
    </div><div class="gap-patch">
      <div class="circle"></div>
    </div><div class="circle-clipper right">
      <div class="circle"></div>
    </div>
  </div>
</div>

<script type="text/javascript" src="lib/materializetemplate/js/my-materialize.min.js"></script>
<script type="text/javascript">
  let getarrJenisDetail =JSON.parse('<?=JSON_encode($arrDataJenisDetail)?>');
  let getarrJenisDurasi =JSON.parse('<?=JSON_encode($arrDataJenisDurasi)?>');
  let getarrLamaDurasi =JSON.parse('<?=JSON_encode($arrDataLamaDurasi)?>');
</script>

<style type="text/css">
input.colorreadonly{
  color: rgba(0, 0, 0, 0.26);
  border-bottom: 1px dotted rgba(0, 0, 0, 0.26);
}
</style>

<script type="text/javascript">
function checkValidasiTanggalTahunCuti()
{
  var reqTglMulai =$("#reqTglMulai").val();
  var reqTglSelesai = $("#reqTglSelesai").val();
  var arrTahunMulai  = reqTglMulai.split('-');
  var arrTahunSelesai  = reqTglSelesai.split('-');
  var tahunMulai = arrTahunMulai[2];
  var tahunSelesai = arrTahunSelesai[2];

  if(tahunMulai > tahunSelesai && ( tahunMulai !='' && tahunSelesai !='') && ( tahunMulai.length==4 && tahunSelesai.length =='4')){
    mbox.alert(' Tahun cuti tidak sesuai', {open_speed: 0});
  }

  var paramTahun = tahunMulai;
  if(paramTahun !=undefined && paramTahun.length==4 ){
    checkSisaCuti(tahunMulai);
  }
  check_lama_durasi();
}

function check_lama_durasi()
{
  var reqLamaDurasi= $("#reqJenisDurasi").val();
  var reqTglMulai =$("#reqTglMulai").val();
  var reqTglSelesai = $("#reqTglSelesai").val();

  if(reqTglMulai!='' && reqTglSelesai !='' && reqLamaDurasi !='')
  {
    let arrTglMulai = reqTglMulai.split('-');
    let arrTglSelesai = reqTglSelesai.split('-');

    var tanggal1 = new Date(arrTglMulai[2],arrTglMulai[1],arrTglMulai[0]); 
    var tanggal2 = new Date(arrTglSelesai[2],arrTglSelesai[1],arrTglSelesai[0]);
    var selisih = Math.abs(tanggal1 - tanggal2);
    var hariDalamMillisecond = 1000 * 60 * 60 * 24;
    var selisihTanggal = Math.round(selisih / hariDalamMillisecond);

    var batas_awal= getarrLamaDurasi[reqLamaDurasi]['BATAS_AWAL'];
    var batas_akhir= getarrLamaDurasi[reqLamaDurasi]['BATAS_AKHIR'];

    // var reqSisaH= $("#reqSisaH").val();
    var reqSisaH= $("#reqTotalCutiSisa").val();
    var reqJenis= $("#reqJenis").val();
     
    if(reqJenis=='1'){
      batas_akhir= reqSisaH;
    }
      
    selisihTanggal= selisihTanggal+1;

    if (selisihTanggal >= batas_awal && selisihTanggal <= batas_akhir) 
    {
      $("#lamaHari").val(selisihTanggal);
    }
    else
    {
      mbox.alert('  Lama cuti yang di ajukan tidak sesuai dengan yang di tentukan. Lama cuti yang diajukan '+ selisihTanggal + ' Hari batas minimal '+batas_awal + ' batas maksimal '+batas_akhir +' Hari', {open_speed: 0});
      $("#reqTglSelesai").val("");
    }
  }
  
}

function checkSisaCuti(tahun)
{
  var reqJenis = $("#reqJenis").val();
  var reqId = $("#reqId").val();
    
  $.get("cuti_baru_json/check_sisa_cuti?reqTahun="+tahun+"&reqJenis="+reqJenis+"&reqId="+reqId )
  .done(function( data ) {
     var  datas = JSON.parse(data);
     <?
     // hitung saat masih draft
     if($reqStatusBerkas < 1)
     {
     ?>
     $("#reqH").val(datas['H']['LAMA_CUTI']);
     $("#reqSisaH").val(datas['H']['SISA_CUTI']);
     $("#reqH1").val(datas['H1']['LAMA_CUTI']);
     $("#reqSisaH1").val(datas['H1']['SISA_CUTI']);
     $("#reqH2").val(datas['H2']['LAMA_CUTI']);
     $("#reqSisaH2").val(datas['H2']['SISA_CUTI']);
     <?
     }
     ?>
     databelumproses= parseFloat(datas['CUTI_BELUM_PROSES']);
     reqSisaH= parseFloat($("#reqSisaH").val());
     reqSisaH1= parseFloat($("#reqSisaH1").val());
     reqSisaH2= parseFloat($("#reqSisaH2").val());
     // console.log(databelumproses);
     // console.log(reqSisaH);
     // console.log(reqSisaH1);

     reqTotalCutiSisa= (reqSisaH + reqSisaH1 + reqSisaH2) - databelumproses;
     $("#reqTotalCutiSisa").val(reqTotalCutiSisa);
     $("#reqStatusCutiBesar").val(datas['CUTI_BESAR']);
  });
  
}

function selectalasanjenis(mode)
{
  reqAlasanJenis= "";
  // kalau kosong maka load data
  if(mode == "")
  {
    reqAlasanJenis= "<?=$reqAlasanJenis?>";
  }

  vinfoid= "reqAlasanJenis";
  $("#"+vinfoid+" option").remove();
  $("#"+vinfoid).material_select();

  var items = "<option value=''></option>";
  infoid= $("#reqJenis").val();

  $("#divketerangandetil").hide();
  // khusus cuti sakit atau cuti alasan penting
  if(infoid == 3 || infoid == 5)
  {
    $("#divketerangandetil").show();
    if(infoid == 3)
    {
      labelketerangandetil= "Pemberi Surat Keterangan Sehat";
    }
    else if(infoid == 5)
    {
      labelketerangandetil= "Keterangan Alasan";
      
    }

    $("#labelketerangandetil").text(labelketerangandetil);
    $("#reqKeteranganDetil").validatebox({required: true});
  }
  else
  {
    $("#reqKeteranganDetil").validatebox({required: false});
    $("#reqKeteranganDetil").removeClass('validatebox-invalid');
    $("#reqKeteranganDetil").val("");
  }

  var varrgetdata= getarrJenisDetail.filter(item => item.jenis_cuti_id === infoid);
  if(Array.isArray(varrgetdata) && varrgetdata.length)
  {

    $.each(varrgetdata, function( index, value ) {
      vselectedid= value.jenis_cuti_detail_id;
      vselectednama= value.nama;
      vselected= "";
      if(vselectedid == reqAlasanJenis) vselected= "selected";

      items += "<option value='" + vselectedid + "' "+vselected+">" + vselectednama + "</option>";
    });
  }
  $("#"+vinfoid).html(items);
  $("#"+vinfoid).material_select();
  $("#"+vinfoid).trigger('change');
}

function selectjenisdurasi(mode)
{
  reqJenisDurasi= "";
  // kalau kosong maka load data
  if(mode == "")
  {
    reqJenisDurasi= "<?=$reqJenisDurasi?>";
  }

  vinfoid= "reqJenisDurasi";
  $("#"+vinfoid+" option").remove();
  $("#"+vinfoid).material_select();

  var items = "<option value=''></option>";
  infoid= $("#reqAlasanJenis").val();
  var varrgetdata= getarrJenisDurasi.filter(item => item.jenis_cuti_detail_id === infoid);
  if(Array.isArray(varrgetdata) && varrgetdata.length)
  {
    $.each(varrgetdata, function( index, value ) {
      vselectedid= value.jenis_cuti_durasi_id;
      vselectednama= value.durasi;
      vselected= "";
      if(vselectedid == reqJenisDurasi) vselected= "selected";

      items += "<option value='" + vselectedid + "' "+vselected+">" + vselectednama + "</option>";
    });
  }
  $("#"+vinfoid).html(items);
  $("#"+vinfoid).material_select();
  $("#"+vinfoid).trigger('change');
}

$(document).ready(function() {
  $('select').material_select();
  $('.formattanggalnew').datepicker({
  format: "dd-mm-yyyy"
  });

  selectalasanjenis("");
  $("#reqJenis").change(function() { 
    selectalasanjenis("change");
  });

  selectjenisdurasi("");
  $("#reqAlasanJenis").change(function() { 
    selectjenisdurasi("change");
  });

  $("#reqJenisDurasi").change(function() { 
    vinfoid= "reqLamaDurasi";
    infoid= $(this).val();

    var varrgetdata= getarrJenisDurasi.filter(item => item.jenis_cuti_durasi_id === infoid);
    var text='';

    if(infoid !='')
    {
      text = varrgetdata[0].durasi_ket;
    }

    if(text==undefined || infoid =='')
    {
      text='';
    }

    check_lama_durasi();
  });

});

$(function(){
  <?
  if(empty($disabledmenu))
  {
  ?>
  $('#reqNipBaru, #reqNipAtasan, #reqNipKepala').each(function(){
    $(this).autocomplete({
      source:function(request, response){
        // var win = $.messager.progress({title:'Proses Pencarian Data', msg:'Proses Pencarian Data...'});

        var id= this.element.attr('id');
        var replaceAnakId= replaceAnak= urlAjax= "";

        urlAjax= "cuti_baru_json/cari_pegawai_karpeg?reqId=<?=$reqId?>&reqJenis=<?=$reqJenis?>&reqMode=1";
        if(id=='reqNipAtasan' ||id=='reqNipAtasan' ){
           urlAjax= "cuti_baru_json/cari_pegawai_global?reqId=<?=$reqId?>&reqJenis=<?=$reqJenis?>&reqMode=1";
        }
        // cegah 10 karakter baru bisa cari
        valcari= request.term;
        panjangcari= valcari.length;
        if(panjangcari < 10) return false;

        $(".preloader-wrapper").show();

        $.ajax({
          url: urlAjax,
          type: "GET",
          dataType: "json",
          data: { term: request.term },
          success: function(responseData){
            $(".preloader-wrapper").hide();
            
            if(responseData == null)
            {
              response(null);
            }
            else
            {
              var array = responseData.map(function(element) {
                return {desc: element['desc'], id: element['id'], label: element['label'], namapegawai: element['namapegawai']
                , satuankerjaid: element['satuankerjaid'], satuankerjanama: element['satuankerjanama']
                , jabatanriwayatid: element['jabatanriwayatid'], pendidikanriwayatid: element['pendidikanriwayatid']
                , gajiriwayatid: element['gajiriwayatid'], pangkatriwayatid: element['pangkatriwayatid']
                , pangkatkode: element['pangkatkode'], jabatannama: element['jabatannama'], kartupegawailama: element['kartupegawailama'],tmtcpns: element['tmtcpns'],tmtpns: element['tmtpns'],masakerjatahun: element['masakerjatahun'],masakerjabulan: element['masakerjabulan']};
              });
              response(array);
            }
          }
        })
      },
      select: function (event, ui) 
      { 
        var id= $(this).attr('id');
        if (id=='reqNipBaru')
        {
          var indexId= "reqId";
          var reqId=namapegawai= pangkatkode= satuankerjaid= jabatanriwayatid= jabatannama= pendidikanriwayatid= gajiriwayatid= pangkatriwayatid= satuankerjanama= kartupegawailama= tmtcpns= tmtpns= masakerjabulan= masakerjatahun= "";
          namapegawai= ui.item.namapegawai;
          pangkatkode= ui.item.pangkatkode;
          satuankerjaid= ui.item.satuankerjaid;
          jabatanriwayatid= ui.item.jabatanriwayatid;
          jabatannama= ui.item.jabatannama;
          pendidikanriwayatid= ui.item.pendidikanriwayatid;
          gajiriwayatid= ui.item.gajiriwayatid;
          pangkatriwayatid= ui.item.pangkatriwayatid;
          satuankerjanama= ui.item.satuankerjanama;
          kartupegawailama= ui.item.kartupegawailama;
          tmtcpns= ui.item.tmtcpns;
          tmtpns= ui.item.tmtpns;
          masakerjatahun= ui.item.masakerjatahun;
          masakerjabulan= ui.item.masakerjabulan;
          reqId =ui.reqPegawaiId;

          $("#reqId").val(reqId);
          $("#reqNamaPegawai").val(namapegawai);
          $("#reqJabatanRiwayatAkhirId").val(jabatanriwayatid);
          // $("#reqSatuanKerjaPegawaiUsulanId").val(satuankerjaid);
          // $("#reqPendidikanRiwayatAkhirId").val(pendidikanriwayatid);
          // $("#reqGajiRiwayatAkhirId").val(gajiriwayatid);
          // $("#reqPangkatRiwayatAkhirId").val(pangkatriwayatid);
          $("#reqPangkatRiwayatAkhir").val(pangkatkode);
          $("#reqSatuanKerjaNama").val(satuankerjanama);
          $("#reqJabatanNama").val(jabatannama);
          $("#reqTmtCpns").val(tmtcpns);
          $("#reqTmtPns").val(tmtpns);
          $("#reqMasaKerjaTahun").val(masakerjatahun);
          $("#reqMasaKerjaBulan").val(masakerjabulan);
          $("#reqKartuPegawaiLama").val(kartupegawailama);

          document.location.href= "app/loadUrl/persuratan/surat_masuk_bkd_cuti_add_data?reqRowId=&reqId="+ui.item.id;
          // $("#"+indexId).val(ui.item.id).trigger('change');
        }

        if (id=='reqNipAtasan')
        {
          $("#reqPegawaiAtasanId").val(ui.item.id);
          $("#reqNamaAtasan").val( ui.item.namapegawai);
        }

        if (id=='reqNipKepala')
        {
          $("#reqPegawaiKepalaId").val(ui.item.id);
          $("#reqNamaKepala").val( ui.item.namapegawai);
        }
      
      },
      autoFocus: true
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
    //
    return $( "<li>" )
    .append( "<a>" + item.desc + " </a>" )
    .appendTo( ul );
    };
  });
  <?
  }
  ?>

});

$(function(){
  $(".preloader-wrapper").hide();
  <?
  if(!empty($aksisimpan))
  {
  ?>
  $(".reqsimpan").click(function() { 
    if($("#ff").form('validate') == false){
      return false;
    }
    $("#reqStatusBerkas").val(0);
    $("#reqSubmit").click();
  });
  <?
  }
  ?>

  <?
  if(!empty($aksiverifikator))
  {
  ?>
  $(".reqsimpan").click(function() { 
    if($("#ff").form('validate') == false){
      return false;
    }
    $("#reqStatusBerkas").val(<?=$reqStatusBerkas?>);
    $("#reqSubmit").click();
  });

  $(".reqkirimapproval").click(function() { 
    if($("#ff").form('validate') == false){
      return false;
    }

    mbox.custom({
      message: "Apakah Anda Yakin, Kirim Approval. Pastikan usulan data sudah sesuai ?",
      options: {close_speed: 100},
      buttons: [
      {
        label: 'Ya',
        color: 'green darken-2',
        callback: function() {
          $("#reqStatusBerkas").val(2);
          $("#reqSubmit").click();
          mbox.close();
        }
      },
      {
        label: 'Tidak',
        color: 'grey darken-2',
        callback: function() {
        mbox.close();
       }
      }
      ]
    });
  });
  <?
  }
  ?>

  <?
  if(!empty($aksiapproval))
  {
  ?>
  $(".reqsimpan").click(function() { 
    if($("#ff").form('validate') == false){
      return false;
    }
    $("#reqStatusBerkas").val(<?=$reqStatusBerkas?>);
    $("#reqSubmit").click();
  });

  $(".reqkirimteken").click(function() { 
    if($("#ff").form('validate') == false){
      return false;
    }

    mbox.custom({
      message: "Apakah Anda Yakin, Kirim TTE Surat Cuti. Pastikan usulan data sudah sesuai ?",
      options: {close_speed: 100},
      buttons: [
      {
        label: 'Ya',
        color: 'green darken-2',
        callback: function() {
          $("#reqStatusBerkas").val(3);
          $("#reqSubmit").click();
          mbox.close();
        }
      },
      {
        label: 'Tidak',
        color: 'grey darken-2',
        callback: function() {
        mbox.close();
       }
      }
      ]
    });
  });
  <?
  }
  ?>

  <?
  if(!empty($aksikirim))
  {
  ?>
  $(".reqkirim").click(function() { 
    if($("#ff").form('validate') == false){
      return false;
    }

    mbox.custom({
      message: "Apakah Anda Yakin, Kirim Verifikator. Pastikan usulan pegawai sudah sesuai ?",
      options: {close_speed: 100},
      buttons: [
      {
        label: 'Ya',
        color: 'green darken-2',
        callback: function() {
          $("#reqStatusBerkas").val(1);
          $("#reqSubmit").click();
          mbox.close();
        }
      },
      {
        label: 'Tidak',
        color: 'grey darken-2',
        callback: function() {
        mbox.close();
       }
      }
      ]
    });
  });
  <?
  }
  ?>

  <?
  if(!empty($aksibatalkirim))
  {
  ?>
  $(".reqbatalkirim").click(function() { 
    if($("#ff").form('validate') == false){
      return false;
    }

    reqStatusSebelumBerkas= $("#reqStatusSebelumBerkas").val();

    vberkas= 0;
    vpesan= "Apakah Anda Yakin, Batal Kirim ke Verifikator ?";
    if(reqStatusSebelumBerkas == 2)
    {
      vberkas= 1;
      vpesan= "Apakah Anda Yakin, Batal Kirim ke Approval ?";
    }
    else if(reqStatusSebelumBerkas == 3)
    {
      vberkas= 2;
      vpesan= "Apakah Anda Yakin, Batal Kirim ke TTE ?";
    }

    mbox.custom({
      message: vpesan,
      options: {close_speed: 100},
      buttons: [
      {
        label: 'Ya',
        color: 'green darken-2',
        callback: function() {
          $("#reqStatusBerkas").val(vberkas);
          $("#reqSubmit").click();
          mbox.close();
        }
      },
      {
        label: 'Tidak',
        color: 'grey darken-2',
        callback: function() {
        mbox.close();
       }
      }
      ]
    });
  });
  <?
  }
  ?>

  <?
  if(!empty($aksisimpan) || !empty($aksikirim))
  {
  ?>
  $('#ff').form({
    url:'cuti_baru_json/add',
    onSubmit:function(){

      reqId= $("#reqId").val();
      if(reqId == "")
      {
        mbox.alert("Isikan terlebih dahulu NIP", {open_speed: 0});
        return false;
      }

      reqJenis= $("#reqJenis").val();
      if(reqJenis == "")
      {
        mbox.alert("Isikan terlebih dahulu Jenis Cuti", {open_speed: 0});
        return false;
      }

      reqAlasanJenis= $("#reqAlasanJenis").val();
      if(reqAlasanJenis == "")
      {
        mbox.alert("Isikan terlebih dahulu Alasan", {open_speed: 0});
        return false;
      }

      reqJenisDurasi= $("#reqJenisDurasi").val();
      if(reqJenisDurasi == "")
      {
        mbox.alert("Isikan terlebih dahulu Durasi", {open_speed: 0});
        return false;
      }

      reqLamaDurasi= $("#reqLamaDurasi").val();
      if(reqLamaDurasi == "")
      {
        mbox.alert("Isikan terlebih dahulu Lama", {open_speed: 0});
        return false;
      }

      reqPegawaiAtasanId= $("#reqPegawaiAtasanId").val();
      if(reqPegawaiAtasanId == "")
      {
        mbox.alert("Isikan terlebih dahulu NIP Atasan Langsung", {open_speed: 0});
        return false;
      }

      reqPegawaiKepalaId= $("#reqPegawaiKepalaId").val();
      if(reqPegawaiKepalaId == "")
      {
        mbox.alert("Isikan terlebih dahulu NIP Kepala", {open_speed: 0});
        return false;
      }

      if($(this).form('validate')){}
      else
      {
        mbox.alert("Lengkapi data terlebih dahulu", {open_speed: 0});
        return false;
      }

      $(".preloader-wrapper").show();
    },
    success:function(data){
      $(".preloader-wrapper").hide();
      <?
      if(!empty($cekquery))
      {
      ?>
      console.log(data);return false;
      <?
      }
      ?>
      data = data.split("-");
      rowid= data[0];
      infodata= data[1];

      if(rowid == "xxx")
      {
        mbox.alert(infodata, {open_speed: 0});
      }
      else
      {
        mbox.alert(infodata, {open_speed: 500}, interval = window.setInterval(function() 
        {
          clearInterval(interval);
          mbox.close();
          
          <?
          if(empty($m))
          {
          ?>
          vkembali= "app/loadUrl/persuratan/surat_masuk_bkd_cuti_add?reqRowId="+rowid;
          <?
          }
          else
          {
          ?>
          vkembali= "app/loadUrl/persuratan/surat_masuk_bkd_cuti_add?m=<?=$m?>&reqRowId="+rowid;
          <?
          }
          ?>
          top.location.href= vkembali;
          // vkembali= "app/loadUrl/persuratan/surat_masuk_bkd_cuti_add_data?reqRowId="+rowid;
          // document.location.href= vkembali;

        }, 1000));
        $(".mbox > .right-align").css({"display": "none"});
      }
    }
  });
  <?
  }

  if(!empty($aksiverifikator) || !empty($aksiapproval) || !empty($aksiverifikator))
  {
  ?>
  $('#ff').form({
    url:'cuti_baru_json/addpilihpenandatangan',
    onSubmit:function(){

      reqPegawaiPenandaTanganId= $("#reqPegawaiPenandaTanganId").val();
      if(reqPegawaiPenandaTanganId == "")
      {
        mbox.alert("Isikan terlebih dahulu Penandatangan TTE Surat Cuti", {open_speed: 0});
        return false;
      }

      if($(this).form('validate')){}
      else
      {
        mbox.alert("Lengkapi data terlebih dahulu", {open_speed: 0});
        return false;
      }

      $(".preloader-wrapper").show();
    },
    success:function(data){
      $(".preloader-wrapper").hide();
      // console.log(data);return false;
      data = data.split("-");
      rowid= data[0];
      infodata= data[1];

      if(rowid == "xxx")
      {
        mbox.alert(infodata, {open_speed: 0});
      }
      else
      {
        mbox.alert(infodata, {open_speed: 500}, interval = window.setInterval(function() 
        {
          clearInterval(interval);
          mbox.close();
          
          <?
          if(empty($m))
          {
          ?>
          vkembali= "app/loadUrl/persuratan/surat_masuk_bkd_cuti_add?reqRowId="+rowid;
          <?
          }
          else
          {
          ?>
          vkembali= "app/loadUrl/persuratan/surat_masuk_bkd_cuti_add?m=<?=$m?>&reqRowId="+rowid;
          <?
          }
          ?>
          top.location.href= vkembali;
          // vkembali= "app/loadUrl/persuratan/surat_masuk_bkd_cuti_add_data?reqRowId="+rowid;
          // document.location.href= vkembali;

        }, 1000));
        $(".mbox > .right-align").css({"display": "none"});
      }
    }
  });
  <?
  }

  if(!empty($aksibatalkirim))
  {
  ?>
  $('#ff').form({
    url:'cuti_baru_json/addbatal',
    onSubmit:function(){

      if($(this).form('validate')){}
      else
      {
        mbox.alert("Lengkapi data terlebih dahulu", {open_speed: 0});
        return false;
      }

      $(".preloader-wrapper").show();
    },
    success:function(data){
      $(".preloader-wrapper").hide();
      // console.log(data);return false;
      data = data.split("-");
      rowid= data[0];
      infodata= data[1];

      if(rowid == "xxx")
      {
        mbox.alert(infodata, {open_speed: 0});
      }
      else
      {
        mbox.alert(infodata, {open_speed: 500}, interval = window.setInterval(function() 
        {
          clearInterval(interval);
          mbox.close();
          
          <?
          if(empty($m))
          {
          ?>
          vkembali= "app/loadUrl/persuratan/surat_masuk_bkd_cuti_add?reqRowId="+rowid;
          <?
          }
          else
          {
          ?>
          vkembali= "app/loadUrl/persuratan/surat_masuk_bkd_cuti_add?m=<?=$m?>&reqRowId="+rowid;
          <?
          }
          ?>
          top.location.href= vkembali;
          // vkembali= "app/loadUrl/persuratan/surat_masuk_bkd_cuti_add_data?reqRowId="+rowid;
          // document.location.href= vkembali;

        }, 1000));
        $(".mbox > .right-align").css({"display": "none"});
      }
    }
  });
  <?
  }
  ?>

  $(".reqbataltms").click(function() { 
    var reqStatusTms= info= "";
    reqStatusTms= $("#reqStatusTms").val();

    info= "Apakah yakin untuk batal TMS an. <?=$reqNamaPegawai?>";
    if(reqStatusTms == 1)
      info= "Apakah yakin untuk proses TMS an. <?=$reqNamaPegawai?>";
    
    mbox.custom({
      message: info,
      options: {close_speed: 100},
      buttons: [
      {
        label: 'Ya',
        color: 'green darken-2',
        callback: function() {
          $.ajax({'url': "cuti_baru_json/status_tms/?reqRowId=<?=$reqRowId?>&reqStatusTms="+reqStatusTms,'success': function(datahtml) {
            vkembali= "app/loadUrl/persuratan/surat_masuk_bkd_cuti_add?m=<?=$m?>&reqRowId=<?=$reqRowId?>";
            top.location.href= vkembali;
          }});
          mbox.close();
        }
      },
      {
        label: 'Tidak',
        color: 'grey darken-2',
        callback: function() {
          mbox.close();
        }
      }
      ]
    });
    
  });

  $(".reqtekensurat").click(function() {
    // $(".mbox-wrapper hr").hide();
    info= "Masukkan Passphrase, untuk Teken surat !!!";
    info+= '<input placeholder="" type="text" autocomplete="off" id="reqalasan" class="easyui-validatebox" readonly onfocus=\'this.removeAttribute("readonly");\' />';

    setTimeout(function() {
      vid= '#reqalasan';
      var elem_position= $(vid).offset().top;
      var window_height= $(window).height();
      var y = elem_position - window_height / 4;

      window.top.scrollTo(0,y);
      $(vid).focus();
    }, 100);

    mbox.custom({
      message: info,
      options: {close_speed: 100},
      buttons: [
      {
        label: 'Konfirmasi',
        color: 'green darken-2',
        callback: function() {
          reqalasan= $("#reqalasan").val();
          // console.log(reqalasan+"+"+reqalasan.length);
          // if(reqalasan.length == 0)
          if(!reqalasan)
          {
            mbox.custom({
              message: "Masukkan Passphrase, untuk Teken surat terlebih dahulu",
              options: {}, // see Options below for options and defaults
              buttons: [
                {
                    label: 'OK',
                    color: 'orange darken-2',
                    callback: function() {
                      mbox.close();
                      $(".reqtekensurat").click();
                    }
                }
              ]
            })
          }
          else
          {
            // kl ada isi maka set token
            var s_url= "cuti_baru_json/token_tte?reqId=<?=$reqRowId?>&reqPassphrase="+encodeURIComponent(reqalasan);
            // console.log(s_url);return false;
            $.ajax({'url': s_url, beforeSend: function () { $(".preloader-wrapper").show(); }, 'success': function(dataajax){
              $(".preloader-wrapper").hide();
              // console.log(dataajax);return false;
              dataajax= String(dataajax);
              dataajax= dataajax.split('###'); 

              rowid= dataajax[0];
              info= dataajax[1];
              // console.log(rowid);return false;

              if(rowid == "xxx")
              {
                mbox.alert(info, {open_speed: 0});
              }
              else
              { 
                mbox.alert(info, {open_speed: 500}, interval = window.setInterval(function() 
                {
                  clearInterval(interval);
                  mbox.close();

                  vkembali= "app/loadUrl/persuratan/surat_masuk_bkd_cuti_add?m=<?=$m?>&reqRowId=<?=$reqRowId?>";
                  top.location.href= vkembali;

                }, 1000));
                $(".mbox > .right-align").css({"display": "none"});
              }

              // mbox.close();
            }});
          }
        }
      },
      {
        label: 'Batal',
        color: 'grey darken-2',
        callback: function() {
          mbox.close();
        }
      }
      ]
    });

    $('#reqalasan').keyup(function () {
      val= $(this).val();
      length= $(this).length;

      var vdocid = document.getElementById("reqalasan");
      if(val == "")
      {
        vdocid.type = "text";
      }
      else
      {
        vdocid.type = "password";
      }
    });

    $('#reqalasan').focus(function (e) {


      // console.log($(this).attr('type'))

      // $(this).attr('type','text');
      // $(this).attr('type','password');

      /*var uniqueAutocompleteID = + new Date();
      $(this).attr("autocomplete", uniqueAutocompleteID);
      // $(this).attr("id", uniqueAutocompleteID);
      console.log(uniqueAutocompleteID);*/

      /*var isChromium = window.chrome;
      var winNav = window.navigator;
      var vendorName = winNav.vendor;
      var isOpera = typeof window.opr !== "undefined";
      var isIEedge = winNav.userAgent.indexOf("Edge") > -1;
      var isIOSChrome = winNav.userAgent.match("CriOS");

      // Autocomplete default value
      var autocomplete = "chrome-off";
      if (isIOSChrome) {
        // is Google Chrome on IOS
      } else if (
        isChromium !== null &&
        typeof isChromium !== "undefined" &&
        vendorName === "Google Inc." &&
        isOpera === false &&
        isIEedge === false
      ) {
        // Is google chrome
      } else {
        // Is firefox
        autocomplete = "off";
      }
      // console.log(autocomplete);

      $(this).attr('autocomplete', autocomplete);
      $("#reqalasan").attr({
       autocomplete: "none",
      });*/

    });

  });

  $(".reqtms").click(function() { 
    parent.openModal('app/loadUrl/persuratan/surat_masuk_bkd_cuti_add_tms_tolak?j=tms&reqRowId=<?=$reqRowId?>&m=<?=$m?>&kembali=surat_masuk_bkd_cuti_add');
  });

  $(".reqtolak").click(function() { 
    parent.openModal('app/loadUrl/persuratan/surat_masuk_bkd_cuti_add_tms_tolak?j=tolak&reqRowId=<?=$reqRowId?>&m=<?=$m?>&kembali=surat_masuk_bkd_cuti_add');
    /*info= "Apakah yakin untuk Tolak Cuti an. <?=$reqNamaPegawai?>";

    mbox.custom({
      message: info,
      options: {close_speed: 100},
      buttons: [
      {
        label: 'Ya',
        color: 'green darken-2',
        callback: function() {
          $.ajax({'url': "cuti_baru_json/status_tolak/?reqRowId=<?=$reqRowId?>",'success': function(datahtml) {
            vkembali= "app/loadUrl/persuratan/surat_masuk_bkd_cuti_add?m=<?=$m?>&reqRowId=<?=$reqRowId?>";
            top.location.href= vkembali;
          }});
          mbox.close();
        }
      },
      {
        label: 'Tidak',
        color: 'grey darken-2',
        callback: function() {
          mbox.close();
        }
      }
      ]
    });*/

  });

  // ;aksiteken

  <?
  if(!empty($lihatfilett))
  {
  ?>
  $(".reqttfile").click(function() { 
    parent.openModal('<?=$filehasiltt?>')
  });
  <?
  }
  ?>

  $(".reqdraft").click(function() { 
    parent.openModal('report/loadUrl/report/templatecuti?reqId=<?=$reqRowId?>')
  });

  $(".reqturunstatus").click(function() {
    parent.openModal('app/loadUrl/persuratan/surat_masuk_bkd_cuti_add_turun_status?reqRowId=<?=$reqRowId?>&m=<?=$m?>&kembali=surat_masuk_bkd_cuti_add');
  });

  $(".vangka").bind('keyup paste', function(){
    // this.value = this.value.replace(/[^0-9]/g, '');
    this.value = this.value.replace(/[^0-9\.]/g, '');
  });

});

<?
if(!empty($arrlistpilihfilefield))
{
?>
  // untuk area untuk upload file
  vbase_url= "<?=base_url()?>";
  getarrlistpilihfilefield= JSON.parse('<?=JSON_encode($arrlistpilihfilefield)?>');
  // console.log(getarrlistpilihfilefield);

  // apabila butuh kualitas dokumen di ubah
  vselectmaterial= "1";
  // untuk area untuk upload file
<?
}
?>
</script>

<script type="text/javascript" src="lib/easyui/pelayanan-efile.js"></script>

<link href="lib/mbox/mbox.css" rel="stylesheet">
<script src="lib/mbox/mbox.js"></script>
<link href="lib/mbox/mbox-modif.css" rel="stylesheet">
<link rel="stylesheet" href="lib/AdminLTE-2.4.0-rc/dist/css/skins/ubah-skin.css">
<script src="lib/AdminLTE-2.4.0-rc/dist/js/ubah-skin.js"></script>

</body>
</html>