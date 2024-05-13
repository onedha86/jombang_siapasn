<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$CI =& get_instance();
$CI->checkUserLogin();

$this->load->model('JabatanRiwayat');
$tempLoginLevel= $this->LOGIN_LEVEL;
$infologinid= $this->LOGIN_ID;

$reqId= $this->input->get("reqId");
$CI->checkpegawai($reqId);
$tempUserLoginId= $this->USER_LOGIN_ID;
$tempMenuId= "010401";
$tempAksesMenu= $CI->checkmenupegawai($tempUserLoginId, $tempMenuId);

// kondisi untuk menu
$this->load->library('globalmenusapk');
$vmenusapk= new globalmenusapk();
$arrmenusapk= $vmenusapk->setmenusapk($tempMenuId);
// print_r($arrmenusapk);exit;
$lihatsapk= $arrmenusapk["lihat"];
$kirimsapk= $arrmenusapk["kirim"];
$tariksapk= $arrmenusapk["tarik"];
$syncsapk= $arrmenusapk["sync"];

if(empty($lihatsapk))
{
  redirect("app/loadUrl/app/pegawai_add_jabatan_monitoring?reqId=".$reqId);
  exit;
}

// untuk tambahan kode
$this->load->model('base-api/InfoData');
$this->load->model('base-api/DataCombo');

$set= new InfoData();
$infonipbaru= $set->getnip($reqId);
// echo $infonipbaru;exit;

$statementLevel= " AND (COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL OR A.STATUS = '2')";
$arrkunci= [];
$arrdatariwayat= [];
$set= new JabatanRiwayat();
$set->selectByParams(array(), -1, -1, $statementLevel." AND A.PEGAWAI_ID = ".$reqId);
// echo $set->query;exit;
while($set->nextRow())
{
  $date= new DateTime($set->getField("TMT_JABATAN"));
  $tmtFormat = $date->format('Y-m-d');


  $infokunci= dateToPageCheck($tmtFormat);
  $arrdata= [];
  // kunci untuk kondisi
  $arrdata["key"]= $infokunci;
  $arrdata["BKN_ID"]= $set->getField("BKN_ID");

  // data sesuai riwayat
  $arrdata["JABATAN_RIWAYAT_ID"]= $set->getField("JABATAN_RIWAYAT_ID");
  $arrdata["NAMA"]= $set->getField("NAMA");
  $arrdata["SATKER_NAMA"]= $set->getField("SATKER_NAMA");
  $arrdata["JENIS_JABATAN_ID"]= $set->getField("JENIS_JABATAN_ID");
 
  $arrdata["TAHUN"]= $set->getField("TAHUN");
  $arrdata["NO_SK"]= $set->getField("NO_SK");
  $arrdata["JENIS_JABATAN_NAMA"]= $set->getField("JENIS_JABATAN_NAMA");
  $arrdata["SATUAN_KERJA_NAMA_DETIL"]= $set->getField("SATUAN_KERJA_NAMA_DETIL");
  $arrdata["SATUAN_KERJA_NAMA"]= $set->getField("SATUAN_KERJA_NAMA");
  $arrdata["ID_SAPK"]= $set->getField("ID_SAPK");
   
  $arrdata["TMT_JABATAN"]= $infokunci;
 
  array_push($arrdatariwayat, $arrdata);

  // kalau tidak ada maka masukkan
  if(!in_array($infokunci, $arrkunci))
  {
    array_push($arrkunci, $infokunci);
  }
}

// $arrkunci = array();
// print_r($arrdatariwayat);exit;

$arrdatabkn= [];
$arrparam= ["nip"=>$infonipbaru, "vurl"=>"Data_rw_jabatan_json"];
$set= new DataCombo();
$set->selectdata($arrparam, "");
// var_dump($set);exit;
while($set->nextRow())
{

  $date      = new DateTime($set->getField("tmtJabatan"));
  $tmtFormat = $date->format('Y-m-d');


  $infokunci= dateToPageCheck($tmtFormat);

 
  $arrdata= [];
  // kunci untuk kondisi
  $arrdata["key"]= $infokunci;

  // data sesuai api bkn
  $arrdata["id"]= $set->getField("id");
  $arrdata["idPns"]= $set->getField("idPns");
  $arrdata["nipBaru"]= $set->getField("nipBaru");
  $arrdata["nipLama"]= $set->getField("nipLama");
  $arrdata["jenisJabatan"]= $set->getField("jenisJabatan");
  $arrdata["instansiKerjaId"]= $set->getField("instansiKerjaId");
  $arrdata["instansiKerjaNama"]= $set->getField("instansiKerjaNama");
  $arrdata["satuanKerjaId"]= $set->getField("satuanKerjaId");
  $arrdata["satuanKerjaNama"]= $set->getField("satuanKerjaNama");
  $arrdata["unorId"]= $set->getField("unorId");
  $arrdata["unorNama"]= $set->getField("unorNama");
  $arrdata["unorIndukId"]= $set->getField("unorIndukId");
  $arrdata["tmtJabatan"]= $set->getField("tmtJabatan");
  $arrdata["unorIndukId"]= $set->getField("unorIndukId");
  $arrdata["eselon"]= $set->getField("eselon");
  $arrdata["eselonId"]= $set->getField("eselonId");
  $arrdata["jabatanFungsionalId"]= $set->getField("jabatanFungsionalId");
  $arrdata["jabatanFungsionalNama"]= $set->getField("jabatanFungsionalNama");
  $arrdata["jabatanFungsionalUmumId"]= $set->getField("jabatanFungsionalUmumId");
  $arrdata["jabatanFungsionalUmumNama"]= $set->getField("jabatanFungsionalUmumNama");
  $arrdata["nomorSk"]= $set->getField("nomorSk");
  $arrdata["tanggalSk"]= $set->getField("tanggalSk");
  $arrdata["namaUnor"]= $set->getField("namaUnor");
  $arrdata["namaJabatan"]= $set->getField("namaJabatan");
  $arrdata["unorIndukNama"]= $set->getField("unorIndukNama");

  $infonamajabatan= 1;
  if(!empty($arrdata["jabatanFungsionalId"]))
    $infonamajabatan= 3;
  else if(!empty($arrdata["jabatanFungsionalUmumId"]))
    $infonamajabatan= 2;

  $arrNamaJabatan = array();
  $arrNamaJabatan[1]='Jabatan Struktural';
  $arrNamaJabatan[2]='Jabatan Fungsional Umum';
  $arrNamaJabatan[3]='Jabatan Fungsional Tertentu';
  $arrdata["jenisJabatanNama"]= $arrNamaJabatan[$infonamajabatan];

  $arrdata["tmtPelantikan"]= $set->getField("tmtPelantikan");
  $arrdata["path"]= $set->getField("path");
  $arrdata["id"]= $set->getField("id");
  array_push($arrdatabkn, $arrdata);

  // kalau tidak ada maka masukkan
  if(!in_array($infokunci, $arrkunci))
  {
    array_push($arrkunci, $infokunci);
  }
}
// print_r($arrdatabkn);exit;

// untuk urut tanggal desc
usort($arrkunci, "sortdatefunctiondesc");
// untuk urut tanggal asc
// usort($arrkunci, "sortdatefunctionasc");
// print_r($arrkunci);exit;
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
  
  <link rel="stylesheet" type="text/css" href="lib/easyui/themes/default/easyui.css">
  <script type="text/javascript" src="lib/easyui/jquery-1.8.0.min.js"></script>
  <script type="text/javascript" src="lib/easyui/jquery.easyui.min.js"></script>

  <link href="lib/materializetemplate/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="lib/materializetemplate/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="lib/materializetemplate/css/layouts/style-horizontal.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="lib/materializetemplate/css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

  <link rel="stylesheet" type="text/css" href="css/gaya-baru.css">
</head>
<body>
  <div class="area-konten area-monitoring-riwayat">
    <div class="judul-konten">
      Monitoring Riwayat Jabatan
      <a style="cursor:pointer; float: right; color: white" onClick="parent.setload('pegawai_add_jabatan_monitoring?reqId=<?=$reqId?>')"> <i class="mdi-navigation-arrow-back"> <span class=" material-font">Kembali</span></i></a>
    </div>
    <div class="inner">
      <div class="judul-instansi">
        <div class="tanggal"></div>
        <div class="data">
          <div class="title"></div>
          <div class="data-siapasn">Data SIAPASN</div>
          <div class="data-bkn">Data BKN</div>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>

      <?
      // var_dump($arrkunci);exit;
      $i=0;
      foreach ($arrkunci as $key => $value)
      {
        $vkeycari= $value;
        // echo $value;exit;

        $infocarikey= $vkeycari;

        // untuk ambil data riwayat
        $vdatariwayat= in_array_column($infocarikey, "key", $arrdatariwayat);
        $vurldetil= $infoidsapkriwayat= $infoidriwayat= "";
        $infonamainstansiriwayat= $infojenisjabatanriwayat= $infonamasatuankerjariwayat= $infonoskriwayat= $infotanggalsertifikatriwayat= $infosatuankerjanamariwayat= $infosatuankerjanamadetilriwayat= "";
        if(!empty($vdatariwayat))
        {
          $indexdata= $vdatariwayat[0];
          $infobknid= $arrdatariwayat[$indexdata]["BKN_ID"];
          $infoidriwayat= $arrdatariwayat[$indexdata]["JABATAN_RIWAYAT_ID"];
          // $infoidriwayat22= $arrdatariwayat[$indexdata]["JABATAN_RIWAYAT_ID"];
          $infonamainstansiriwayat= $arrdatariwayat[$indexdata]["NAMA"];
          $infonamasatuankerjariwayat= $arrdatariwayat[$indexdata]["SATKER_NAMA"];
          $infonoskriwayat= $arrdatariwayat[$indexdata]["NO_SK"];
          $infotanggalsertifikatriwayat= $arrdatariwayat[$indexdata]["TMT_JABATAN"];
          $infojumlahjamriwayat= $arrdatariwayat[$indexdata]["JUMLAH_JAM"];
          $infosatuankerjanamadetilriwayat= $arrdatariwayat[$indexdata]["SATUAN_KERJA_NAMA_DETIL"];
          $infoidsapkriwayat= $arrdatariwayat[$indexdata]["ID_SAPK"];

          $infojenisjabatanriwayat= $arrdatariwayat[$indexdata]["JENIS_JABATAN_NAMA"];
          $infosatuankerjanamariwayat= $arrdatariwayat[$indexdata]["SATUAN_KERJA_NAMA"];

          $infojenisjabatanidriwayat= $arrdatariwayat[$indexdata]["JENIS_JABATAN_ID"];
          if($infojenisjabatanidriwayat == "1")
            $vurldetil= "pegawai_add_jabatan_struktural_data";
          else if($infojenisjabatanidriwayat == "2")
            $vurldetil= "pegawai_add_jabatan_fungsional_data";
          else 
            $vurldetil= "pegawai_add_jabatan_tertentu_data";
        }

        // untuk ambil data bkn
        $infoidbkn= "";
        $vdatabkn= in_array_column($infocarikey, "key", $arrdatabkn);
        $infonamainstansibkn= $infojenisjabatanbkn= $infonamasatuankerjabkn= $infonoskbkn= $infotanggalsertifikatbkn= $infosatuankerjanamabkn= $infosatuankerjanamadetilbkn= "";
        if(!empty($vdatabkn))
        {
          $indexdata= $vdatabkn[0];
          $infoidbkn= $arrdatabkn[$indexdata]["id"];
          $infonamasatuankerjabkn= $arrdatabkn[$indexdata]["instansiKerjaNama"];
          $infonamainstansibkn= $arrdatabkn[$indexdata]["namaJabatan"];

          $infojenisjabatanbkn = $arrdatabkn[$indexdata]["jenisJabatanNama"];

          $jabatanFungsionalId= $arrdatabkn[$indexdata]["jabatanFungsionalId"];
          $jabatanFungsionalNama= $arrdatabkn[$indexdata]["jabatanFungsionalNama"];

          $jabatanFungsionalUmumId= $arrdatabkn[$indexdata]["jabatanFungsionalUmumId"];
          $jabatanFungsionalUmumNama= $arrdatabkn[$indexdata]["jabatanFungsionalUmumNama"];

          $infonamainstansibkn = $jabatanFungsionalId?$jabatanFungsionalNama:$infonamainstansibkn;
          $infonamainstansibkn = $jabatanFungsionalUmumId?$jabatanFungsionalUmumNama:$infonamainstansibkn;

          $infonoskbkn= $arrdatabkn[$indexdata]["nomorSk"];
          $infotanggalsertifikatbkn= $arrdatabkn[$indexdata]["tmtJabatan"];
          $infojumlahjambkn= $arrdatabkn[$indexdata]["jumlahJam"];

          $infosatuankerjanamabkn= $arrdatabkn[$indexdata]["unorNama"];
          $infosatuankerjanamadetilbkn= $arrdatabkn[$indexdata]["unorIndukNama"];
        }
      ?>
      <div class="item">
        <div class="tanggal"><span><img src="images/icon-tanggal.png"></span> <?=getFormattedDate(dateToPageCheck($value))?></div>
        <div class="data">

          <div class="baris atas">
            <div class="title"></div>
            <div class="data-siapasn"></div>
            <div class="data-bkn"></div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title">Jenis Jabatan</div>
            <div class="data-siapasn">
              <?
              if(empty($infojenisjabatanriwayat))
              {
              ?>
              <span class="tidak-ada-data"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Belum ada data</span>
              <?
              }
              ?>
              <?=$infojenisjabatanriwayat?>
            </div>
            <div class="data-bkn">
              <?
              if(empty($infonamainstansibkn))
              {
              ?>
              <span class="tidak-ada-data"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Belum ada data</span>
              <?
              }
              ?>
             <?=$infojenisjabatanbkn?> 
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title"> Nama Jabatan</div>
            <div class="data-siapasn"><?=$infonamainstansiriwayat?$infonamainstansiriwayat:'-';?></div>
            <div class="data-bkn"><?=$infonamainstansibkn?$infonamainstansibkn:'-'?> </div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title">No SK</div>
            <div class="data-siapasn"><?=$infonoskriwayat?$infonoskriwayat:'-';?></div>
            <div class="data-bkn"><?=$infonoskbkn?$infonoskbkn:'-';?> </div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title">Tmt Jabatan</div>
            <div class="data-siapasn"><?=$infotanggalsertifikatriwayat?$infotanggalsertifikatriwayat:'-';?></div>
            <div class="data-bkn"><?=$infotanggalsertifikatbkn?$infotanggalsertifikatbkn:'-';?> </div>
            <div class="clearfix"></div>
          </div>

           <div class="baris">
            <div class="title">Nama Unor</div>
            <div class="data-siapasn"><?=$infosatuankerjanamariwayat?$infosatuankerjanamariwayat:'-';?></div>
            <div class="data-bkn"><?=$infosatuankerjanamabkn?$infosatuankerjanamabkn:'-';?> </div>
            <div class="clearfix"></div>
          </div>

           <div class="baris">
            <div class="title">OPD Induk</div>
            <div class="data-siapasn"><?=$infosatuankerjanamadetilriwayat?$infosatuankerjanamadetilriwayat:'-';?></div>
            <div class="data-bkn"><?=$infosatuankerjanamadetilbkn?$infosatuankerjanamadetilbkn:'-';?> </div>
            <div class="clearfix"></div>
          </div>
       

          <div class="baris bawah">
            <div class="title"></div>
            <div class="data-siapasn"></div>
            <div class="data-bkn"></div>
            <div class="clearfix"></div>
          </div>

        </div>

        <div class="aksi">
          <?
          if(empty($infoidsapkriwayat))
          {
          ?>
          <div class="info-sinkron belum">
            <span class="ikon"><img src="images/icon-belum-sinkron.png"></span>
            <span class="teks">Belum Sinkron</span>
          </div>
          <?
          }
          else
          {
          ?>
          <div class="info-sinkron sudah">
            <span class="ikon"><img src="images/icon-sudah-sinkron.png"></span>
            <span class="teks">Sudah Sinkron</span>
          </div>
          <?
          }
          ?>

          <div class="aksi-tombol">
            <?
            $infoidsinkronsiapasnbkndisabled= $infoidsinkronsiapasnbkn= "";
            // apabila kalau ada id riwayat dan id bkn kosong maka button integrasi siapasn ke bkn akan muncul
            // atau ada id riwayat dan ada id bkn maka button integrasi siapasn ke bkn akan muncul
            if( (!empty($infoidriwayat) && empty($infoidbkn) || !empty($infoidriwayat) && !empty($infoidbkn)) && !empty($kirimsapk) )
            {
              $infoidsinkronsiapasnbkn= "infoidsinkronsiapasnbkn";
            }
            else
            {
              $infoidsinkronsiapasnbkndisabled= "disabled";
            }
            ?>
            <a class="<?=$infoidsinkronsiapasnbkndisabled?>" id="<?=$infoidsinkronsiapasnbkn.$infoidriwayat?>" href="javascript:void(0)" title="update data SIAPASN ke BKN"><img src="images/icon-right.png"></a>
            <input type="hidden" id="<?=$infoidriwayat?>" value="<?=$infoidbkn?>">

            <?
            $infoidsinkronbknsiapasndisabled= $infoidsinkronbknsiapasn= "";
            if(empty($infoidbkn) || empty($tariksapk))
            {
              $infoidsinkronbknsiapasndisabled= "disabled";
            }
            else
            {
              $infoidsinkronbknsiapasn= "infoidsinkronbknsiapasn";
            }
            ?>
            <a class="<?=$infoidsinkronbknsiapasndisabled?>" href="javascript:void(0)" id="<?=$infoidsinkronbknsiapasn.$infoidbkn?>" title="update data BKN ke SIAPASN<?=$infoidbkn?>"><img src="images/icon-left.png"></a>
            <input type="hidden" id="<?=$infoidbkn?>" value="<?=$infoidriwayat?>">

            <?
            $infoidhapusbkndisabled= "disabled";
            if(!empty($infoidbkn) || !empty($infoidriwayat))
            {
              $infoidhapusbkndisabled= "";
              $infoidhapusbkn= "infoidhapusbkn";
            }
            ?>
            <a href="javascript:void(0)" id="<?=$infoidhapusbkn.$infoidriwayat?>" class="<?=$infoidhapusbkndisabled?>" title="hapus data" ><img src="images/icon-seru.png"></a>

            <?
            $inforesetidsapk= "";
            $inforesetidsapkdisabled= "disabled";
            if(!empty($infoidsapkriwayat) && !empty($syncsapk))
            {
              $inforesetidsapk= "resetsinkron";
              $inforesetidsapkdisabled= "";
            }
            ?>
            <a href="javascript:void(0)" id="<?=$inforesetidsapk.$infoidriwayat?>" class="<?=$inforesetidsapkdisabled?>" title="hapus sinkron data" ><img src="images/icon-del.png"></a>

            <?
            $infolinkdisabled= "disabled";
            if(!empty($vurldetil))
            {
              $infolinkdisabled= "";
            }
            ?>
            <a class="<?=$infolinkdisabled?>" href="app/loadUrl/app/<?=$vurldetil?>?reqId=<?=$reqId?>&reqRowId=<?=$infoidriwayat?>" title="ubah data"><img src="images/icon-pen.png"></a>
          </div>
        </div>
        <div class="clearfix"></div>

      </div>
      <?
        $i++;
      }
    
      ?>

    </div>
  </div>

  <script type="text/javascript" src="lib/materializetemplate/js/materialize.min.js"></script>
  <link rel="stylesheet" href="lib/AdminLTE-2.4.0-rc/dist/css/skins/ubah-skin.css">
  <script src="lib/AdminLTE-2.4.0-rc/dist/js/ubah-skin.js"></script>

  <link href="lib/mbox/mbox.css" rel="stylesheet">
  <script src="lib/mbox/mbox.js"></script>
  <link href="lib/mbox/mbox-modif.css" rel="stylesheet">

  <script type="text/javascript">
    $('[id^="infoidhapusbkn"]').click(function() {
      vinfoid= $(this).attr('id');
      vinfoid= vinfoid.replace("infoidhapusbkn", "");
      var vinfoidbkn= $("#"+vinfoid).val();
      info= "Apakah Anda Yakin, menghapus data?";
      mbox.custom({
          message: info,
          options: {close_speed: 100},
          buttons: [
          {
            label: 'Ya',
            color: 'green darken-2',
            callback: function() {

              var s_url='bkn/jabatan_json/delete_bkn?reqRiwayatId='+vinfoid+"&reqBknId="+vinfoidbkn;
              $.ajax({'url': s_url, type: "get",'success': function(data){
                // console.log(data);return false;
                mbox.alert('Proses Data', {open_speed: 500}, interval = window.setInterval(function() 
                {
                  clearInterval(interval);
                  document.location.href= "app/loadUrl/app/pegawai_add_jabatan_monitoring_bkn/?reqId=<?=$reqId?>";
                }, 1000));
                $(".mbox > .right-align").css({"display": "none"});
                
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

    $('[id^="resetsinkron"]').click(function() {
      vinfoid= $(this).attr('id');
      vinfoid= vinfoid.replace("resetsinkron", "");
      
      info= "Apakah Anda Yakin, reset sinkron data terpilih ?";
      mbox.custom({
          message: info,
          options: {close_speed: 100},
          buttons: [
          {
            label: 'Ya',
            color: 'green darken-2',
            callback: function() {

              var s_url='bkn/jabatan_json/reset_siapasn?reqRiwayatId='+vinfoid;
              $.ajax({'url': s_url, type: "get",'success': function(data){
                // console.log(data);return false;
                mbox.alert('Proses Data', {open_speed: 500}, interval = window.setInterval(function() 
                {
                  clearInterval(interval);
                  document.location.href= "app/loadUrl/app/pegawai_add_jabatan_monitoring_bkn/?reqId=<?=$reqId?>";
                }, 1000));
                $(".mbox > .right-align").css({"display": "none"});
                
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

    $('[id^="infoidsinkronsiapasnbkn"]').click(function() {
      vinfoid= $(this).attr('id');
      vinfoid= vinfoid.replace("infoidsinkronsiapasnbkn", "");
      var vinfoidbkn= $("#"+vinfoid).val();
      
      info= "Apakah Anda Yakin, update data terpilih SIAPASN ke BKN ?";
      mbox.custom({
          message: info,
          options: {close_speed: 100},
          buttons: [
          {
            label: 'Ya',
            color: 'green darken-2',
            callback: function() {

              var s_url='bkn/jabatan_json/siapasn_bkn?reqRiwayatId='+vinfoid+"&reqBknId="+vinfoidbkn;
              $.ajax({'url': s_url, type: "get",'success': function(data){
                data= JSON.parse(data);
                // console.log(data.code);return false;
                if(data.code == 400)
                {
                  mbox.alert(data.PESAN);
                }
                else
                {
                  mbox.alert('Proses Data', {open_speed: 500}, interval = window.setInterval(function() 
                  {
                    clearInterval(interval);
                    document.location.href= "app/loadUrl/app/pegawai_add_jabatan_monitoring_bkn/?reqId=<?=$reqId?>";
                  }, 1000));
                  $(".mbox > .right-align").css({"display": "none"});
                }
                
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

    $('[id^="infoidsinkronbknsiapasn"]').click(function() {
      vinfoid= $(this).attr('id');
      vinfoid= vinfoid.replace("infoidsinkronbknsiapasn", "");
      var vinfoidriwayat= $("#"+vinfoid).val();

      info= "Apakah Anda Yakin, update data terpilih BKN ke SIAPASN ?";
      mbox.custom({
          message: info,
          options: {close_speed: 100},
          buttons: [
          {
            label: 'Ya',
            color: 'green darken-2',
            callback: function() {

              var s_url='bkn/jabatan_json/bkn_siapasn?reqBknId='+vinfoid+"&reqRiwayatId="+vinfoidriwayat;
              $.ajax({'url': s_url, type: "get",'success': function(data){
                // console.log(data);return false;
                mbox.alert('Proses Data', {open_speed: 500}, interval = window.setInterval(function() 
                {
                  clearInterval(interval);
                  document.location.href= "app/loadUrl/app/pegawai_add_jabatan_monitoring_bkn/?reqId=<?=$reqId?>";
                }, 1000));
                $(".mbox > .right-align").css({"display": "none"});
                
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
  </script>

</body>
</html>