<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$CI =& get_instance();
$CI->checkUserLogin();

$this->load->model('DiklatKursus');
$tempLoginLevel= $this->LOGIN_LEVEL;
$infologinid= $this->LOGIN_ID;

$reqId= $this->input->get("reqId");
$CI->checkpegawai($reqId);
$tempUserLoginId= $this->USER_LOGIN_ID;
$tempMenuId= "010604";
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
  redirect("app/loadUrl/app/pegawai_add_diklat_kursus_monitoring?reqId=".$reqId);
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
$arrkunciInfo= [];
$arrdatariwayat= [];
$set= new DiklatKursus();
$set->selectByParams(array(), -1, -1, $statementLevel." AND A.PEGAWAI_ID = ".$reqId);
 // echo $set->query;exit;
while($set->nextRow())
{
  $infokunci= dateToPageCheck($set->getField("TANGGAL_MULAI"));
  $infokunciSelesai= dateToPageCheck($set->getField("TANGGAL_SELESAI"));
  // $infokunci = str_replace("-","", $infokunci).str_replace("-","", $infokunciSelesai);
  $infokunci = $infokunci."&".$infokunciSelesai;
  $arrdata= [];
  // kunci untuk kondisi
  $arrdata["key"]= $infokunci;
  $arrdata["keySelesai"]= $infokunciSelesai;
  $arrdata["BKN_ID"]= $set->getField("BKN_ID");

 

  // data sesuai riwayat
  $arrdata["DIKLAT_KURSUS_ID"]= $set->getField("DIKLAT_KURSUS_ID");
  $arrdata["TIPE_KURSUS_ID"]= $set->getField("TIPE_KURSUS_ID");
  $arrdata["NAMA"]= $set->getField("NAMA");
  // $arrdata["JENIS_KURSUS_NAMA"]= $set->getField("JENIS_KURSUS_NAMA");
  $arrdata["JENIS_KURSUS_NAMA"]= $set->getField("TIPE_DIKLAT_NAMA");
  $arrdata["PENYELENGGARA"]= $set->getField("PENYELENGGARA");
  $arrdata["TAHUN"]= $set->getField("TAHUN");
  $arrdata["NO_SERTIFIKAT"]= $set->getField("NO_SERTIFIKAT");
  $arrdata["TANGGAL_SERTIFIKAT"]= dateToPageCheck($set->getField("TANGGAL_SERTIFIKAT"));
  $arrdata["TANGGAL_MULAI"]= dateToPageCheck($set->getField("TANGGAL_MULAI"));
  $arrdata["TANGGAL_SELESAI"]= dateToPageCheck($set->getField("TANGGAL_SELESAI"));
  $arrdata["JUMLAH_JAM"]= $set->getField("JUMLAH_JAM");
  $arrdata["ID_SAPK"]= $set->getField("ID_SAPK");
  array_push($arrdatariwayat, $arrdata);

  // kalau tidak ada maka masukkan
  if(!in_array($infokunci, $arrkunci) && !empty($infokunci))
  {
    array_push($arrkunci, $infokunci);
      $arrkunciInfo[$infokunci]='Tanggal Mulai Siapsn';
  }
  // if(!in_array($infokunciSelesai, $arrkunci) && !empty($infokunciSelesai))
  // {
  //   array_push($arrkunci, $infokunciSelesai);
  //   $arrkunciInfo[$infokunciSelesai]='Tanggal Selesai Siapsn';
  // }

}
// print_r($arrdatariwayat);exit;

$arrdatabkn= [];
$arrparam= ["nip"=>$infonipbaru, "vurl"=>"Data_rw_kursus_json"];
$set= new DataCombo();
$set->selectdata($arrparam, "");
while($set->nextRow())
{
  $infokunci= $set->getField("tanggalKursus");
  $infokunci2= $set->getField("tanggalSelesaiKursus");
  // $infokunci = str_replace("-","", $infokunci).str_replace("-","", $infokunci2);
   $infokunci = $infokunci."&".$infokunci2;
  $info = $infokunci2?'Tanggal Selesai':'Tanggal Mulai';

  
  $arrdata= [];
  // kunci untuk kondisi

  $arrdata["key"]= $infokunci;
   $arrdata["keySelesai"]= $infokunci2;
   $arrdata["info"]=  $info;

  // data sesuai api bkn
  $arrdata["id"]= $set->getField("id");
  $arrdata["idPns"]= $set->getField("idPns");
  $arrdata["nipBaru"]= $set->getField("nipBaru");
  $arrdata["nipLama"]= $set->getField("nipLama");
  $arrdata["jenisKursusNama"]= $set->getField("jenisKursusNama");
  $arrdata["jenisKursusSertifikat"]= $set->getField("jenisKursusSertifikat");
  $arrdata["institusiPenyelenggara"]= $set->getField("institusiPenyelenggara");
  $arrdata["jenisKursusId"]= $set->getField("jenisKursusId");
  $arrdata["jumlahJam"]= $set->getField("jumlahJam");
  $arrdata["namaKursus"]= $set->getField("namaKursus");
  $arrdata["noSertipikat"]= $set->getField("noSertipikat");
  $arrdata["tahunKursus"]= $set->getField("tahunKursus");
  $arrdata["tanggalKursus"]= $set->getField("tanggalKursus");
  $arrdata["tanggalSelesaiKursus"]= $set->getField("tanggalSelesaiKursus");
  $arrdata["jenisDiklatId"]= $set->getField("jenisDiklatId");
  $arrdata["id"]= $set->getField("id");
  array_push($arrdatabkn, $arrdata);

  // kalau tidak ada maka masukkan
  if(!in_array($infokunci, $arrkunci) && !empty($infokunci))
  {
    array_push($arrkunci, $infokunci);
     $arrkunciInfo[$infokunci]='Tanggal Mulai Bkn';
     
  }
  // if(!in_array($infokunci2, $arrkunci) && !empty($infokunci2) )
  // {
  //   array_push($arrkunci, $infokunci2);
  //   $arrkunciInfo[$infokunci2]='Tanggal Selesai Bkn';
  // }
}
// print_r($arrdatabkn);exit;

// untuk urut tanggal desc
// usort($arrkunci, "sortdatefunctiondesc");
array_unique($arrkunci);
rsort($arrkunci);
usort($arrkunci, "sortdatefunctiondescCostum");

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
      Monitoring Riwayat Diklat Kursus
      
      <a style="cursor:pointer; float: right; color: white" onClick="parent.setload('pegawai_add_diklat_kursus_monitoring?reqId=<?=$reqId?>')"> <i class="mdi-navigation-arrow-back"> <span class=" material-font">Kembali</span></i></a>
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
      foreach ($arrkunci as $key => $value)
      {
        $infocarikey= $value;

        // untuk ambil data riwayat
        $vdatariwayat= in_array_column($infocarikey, "key", $arrdatariwayat);
        // if(empty($vdatariwayat)){
        //    $vdatariwayat= in_array_column($infocarikey, "keySelesai", $arrdatariwayat);
        // }
        $vurldetil= $infoidsapkriwayat= $infoidriwayat= "";
        $infonamariwayat= $infojenisriwayat= $infonosertifikatriwayat= $infotanggalmulairiwayat= $infotanggalselesairiwayat= $infojumlahjamriwayat= "";
        if(!empty($vdatariwayat))
        {
          $indexdata= $vdatariwayat[0];
          $infoidriwayat= $arrdatariwayat[$indexdata]["DIKLAT_KURSUS_ID"];
          $infoidsapkriwayat= $arrdatariwayat[$indexdata]["ID_SAPK"];
          $infonamariwayat= $arrdatariwayat[$indexdata]["NAMA"];
          $infojenisriwayat= $arrdatariwayat[$indexdata]["JENIS_KURSUS_NAMA"];
          $infonosertifikatriwayat= $arrdatariwayat[$indexdata]["NO_SERTIFIKAT"];
          $infotanggalmulairiwayat= $arrdatariwayat[$indexdata]["TANGGAL_MULAI"];
          $infotanggalselesairiwayat= $arrdatariwayat[$indexdata]["TANGGAL_SELESAI"];
          $infojumlahjamriwayat= $arrdatariwayat[$indexdata]["JUMLAH_JAM"];
          $vurldetil= "pegawai_add_diklat_kursus_data";
        }

        // untuk ambil data bkn
        $infoidbkn= "";
        $vdatabkn= in_array_column($infocarikey, "key", $arrdatabkn);
        // if(empty($vdatabkn)){
        //    $vdatabkn= in_array_column($infocarikey, "keySelesai", $arrdatabkn);
        // }
        $infonamabkn= $infojenisbkn= $infonosertifikatbkn= $infotanggalmulaibkn= $infotanggalselesaibkn= $infojumlahjambkn= "";
        if(!empty($vdatabkn))
        {
          $indexdata= $vdatabkn[0];
          $infoidbkn= $arrdatabkn[$indexdata]["id"];
          $infonamabkn= $arrdatabkn[$indexdata]["namaKursus"];
          $infojenisbkn= $arrdatabkn[$indexdata]["jenisKursusSertifikat"];
          $infonosertifikatbkn= $arrdatabkn[$indexdata]["noSertipikat"];
          $infotanggalmulaibkn= $arrdatabkn[$indexdata]["tanggalKursus"];
          $infotanggalselesaibkn= $arrdatabkn[$indexdata]["tanggalSelesaiKursus"];
          $infojumlahjambkn= $arrdatabkn[$indexdata]["jumlahJam"];
        }
      ?>
      <div class="item">
        <div class="tanggal">
        <!--   <?=$arrkunciInfo[$value]?><br> -->
          <?
          $arrTgl = explode("&",$value);
          ?>
          <span><img src="images/icon-tanggal.png"></span> <?=getFormattedDate(dateToPageCheck($arrTgl[0]))?> <br>
          <span><img src="images/icon-tanggal.png"></span> <?=getFormattedDate(dateToPageCheck($arrTgl[1]))?>
          

        </div>

        <div class="data">

          <div class="baris atas">
            <div class="title"></div>
            <div class="data-siapasn"></div>
            <div class="data-bkn"></div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title">Nama Diklat/Kursus</div>
            <div class="data-siapasn">
              <?
              if(empty($infonamariwayat))
              {
              ?>
              <span class="tidak-ada-data"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Belum ada data</span>
              <?
              }
              ?>
              <?=$infonamariwayat?>
            </div>
            <div class="data-bkn">
              <?
              if(empty($infonamabkn))
              {
              ?>
              <span class="tidak-ada-data"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Belum ada data</span>
              <?
              }
              ?>
              <?=$infonamabkn?>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title">Tipe Diklat/Kursus </div>
            <div class="data-siapasn"><?=$infojenisriwayat?$infojenisriwayat:'-'?></div>
            <div class="data-bkn"><?=$infojenisbkn?$infojenisbkn:'-';?></div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title">No Sertifikat</div>
            <div class="data-siapasn"><?=$infonosertifikatriwayat?$infonosertifikatriwayat:'-';?></div>
            <div class="data-bkn"><?=$infonosertifikatbkn?$infonosertifikatbkn:'-';?></div>
            <div class="clearfix"></div>
          </div>

          <?
          $infotanggalriwayat= "-";
          if(!empty($infotanggalmulairiwayat) || !empty($infotanggalselesairiwayat))
            $infotanggalriwayat= coalesce($infotanggalmulairiwayat, '-')." s/d ".coalesce($infotanggalselesairiwayat, '');

          $infotanggalbkn= "-";
          if(!empty($infotanggalmulaibkn) || !empty($infotanggalselesaibkn))
            $infotanggalbkn= coalesce($infotanggalmulaibkn, '-')." s/d ".coalesce($infotanggalselesaibkn, '');
          ?>
          <div class="baris">
            <div class="title">Tanggal Mulai</div>
            <div class="data-siapasn"><?=$infotanggalmulairiwayat?$infotanggalmulairiwayat:'-';?></div>
            <div class="data-bkn"><?=$infotanggalmulaibkn?$infotanggalmulaibkn:'-';?></div>
            <div class="clearfix"></div>
          </div>
          <div class="baris">
            <div class="title">Tanggal Selesai</div>
            <div class="data-siapasn"><?=$infotanggalselesairiwayat?$infotanggalselesairiwayat:'-';?></div>
            <div class="data-bkn"><?=$infotanggalselesaibkn?$infotanggalselesaibkn:'-';?></div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title">Jumlah Jam</div>
            <div class="data-siapasn"><?=$infojumlahjamriwayat?$infojumlahjamriwayat:'-';?></div>
            <div class="data-bkn"><?=$infojumlahjambkn?$infojumlahjambkn:'-';?></div>
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
            <a class="<?=$infoidsinkronbknsiapasndisabled?>" href="javascript:void(0)" id="<?=$infoidsinkronbknsiapasn.$infoidbkn?>" title="update data BKN ke SIAPASN"><img src="images/icon-left.png"></a>
            <input type="hidden" id="<?=$infoidbkn?>" value="<?=$infoidriwayat?>">

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

              var s_url='bkn/kursus_json/reset_siapasn?reqRiwayatId='+vinfoid;
              $.ajax({'url': s_url, type: "get",'success': function(data){
                // console.log(data);return false;
                mbox.alert('Proses Data', {open_speed: 500}, interval = window.setInterval(function() 
                {
                  clearInterval(interval);
                  document.location.href= "app/loadUrl/app/pegawai_add_diklat_kursus_monitoring_bkn/?reqId=<?=$reqId?>";
                  // window.location.reload();
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

              var s_url='bkn/kursus_json/siapasn_bkn?reqRiwayatId='+vinfoid+"&reqBknId="+vinfoidbkn;
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
                     document.location.href= "app/loadUrl/app/pegawai_add_diklat_kursus_monitoring_bkn/?reqId=<?=$reqId?>";
                    // window.location.reload();
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

              var s_url='bkn/kursus_json/bkn_siapasn?reqBknId='+vinfoid+"&reqRiwayatId="+vinfoidriwayat;
              $.ajax({'url': s_url, type: "get",'success': function(data){
                // console.log(data);return false;
                mbox.alert('Proses Data', {open_speed: 500}, interval = window.setInterval(function() 
                {
                  clearInterval(interval);
                   document.location.href= "app/loadUrl/app/pegawai_add_diklat_kursus_monitoring_bkn/?reqId=<?=$reqId?>";
                  // window.location.reload();
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