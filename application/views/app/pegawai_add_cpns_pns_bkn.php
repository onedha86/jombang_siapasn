<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$CI =& get_instance();
$CI->checkUserLogin();

$this->load->model('SkCpnsPnsBkn');
$tempLoginLevel= $this->LOGIN_LEVEL;
$infologinid= $this->LOGIN_ID;

$reqId= $this->input->get("reqId");
$CI->checkpegawai($reqId);
$tempUserLoginId= $this->USER_LOGIN_ID;
$tempMenuId= "0102";
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
  redirect("app/loadUrl/app/pegawai_add_cpns_pns_monitoring?reqId=".$reqId);
  exit;
}

// untuk tambahan kode
$this->load->model('base-api/DataCombo');

$arrkunci= [];
$arrdatariwayat= [];
$set= new SkCpnsPnsBkn();
$set->selectByParams(array(), -1, -1, " AND A.PEGAWAI_ID = ".$reqId);
$set->firstRow();
// echo $set->query;exit;

// ambil data siapasn
$arrdata= [];
// kunci untuk kondisi
$infonipbaru= $set->getField("NIP_BARU");
// $infonipbaru= '198305022011011001';
$arrdata["ID_ROW"]= $set->getField("ID_ROW");
$arrdata["PEGAWAI_ID_SAPK"]= $set->getField("PEGAWAI_ID_SAPK");
$arrdata["ID_SAPK"]= $set->getField("ID_SAPK");
$arrdata["KARTU_PEGAWAI"]= $set->getField("KARTU_PEGAWAI");
$arrdata["NOMOR_SK_CPNS"]= $set->getField("NOMOR_SK_CPNS");
$arrdata["TGL_SK_CPNS"]= dateToPageCheck($set->getField("TGL_SK_CPNS"));
$arrdata["NAMA_JABATAN_ANGKAT_CPNS"]= $set->getField("NAMA_JABATAN_ANGKAT_CPNS");
$arrdata["NOMOR_DOKTER_PNS"]= $set->getField("NOMOR_DOKTER_PNS");
$arrdata["NOMOR_SK_PNS"]= $set->getField("NOMOR_SK_PNS");
$arrdata["NOMOR_SPMT"]= $set->getField("NOMOR_SPMT");
$arrdata["NOMOR_STTPL"]= $set->getField("NOMOR_STTPL");
$arrdata["STATUS_CPNS_PNS"]= $set->getField("STATUS_CPNS_PNS");
$arrdata["TANGGAL_DOKTER_PNS"]= dateToPageCheck($set->getField("TANGGAL_DOKTER_PNS"));
$arrdata["TGL_SK_PNS"]= dateToPageCheck($set->getField("TGL_SK_PNS"));
$arrdata["TGL_STTPL"]= dateToPageCheck($set->getField("TGL_STTPL"));
$arrdata["TMT_PNS"]= dateToPageCheck($set->getField("TMT_PNS"));
array_push($arrdatariwayat, $arrdata);
// print_r($arrdatariwayat);exit;

$arrdatabkn= [];
$arrparam= ["nip"=>$infonipbaru, "vurl"=>"Data_pegawai_json"];
$set= new DataCombo(); 
$set->selectdata($arrparam, "", "firstrow");
$arrDataPegawai= $set->rowResult[0];
// print_r($arrDataPegawai);exit;

$arrdata= [];
// kunci untuk kondisi
if(!empty($arrDataPegawai))
{
  $arrdata["id"]= $arrDataPegawai["nipbaru"];
  $arrdata["PEGAWAI_ID_SAPK"]= $arrDataPegawai["id"];
  $arrdata["KARTU_PEGAWAI"]= $arrDataPegawai[""];
  $arrdata["NOMOR_SK_CPNS"]= $arrDataPegawai["nomorskcpns"];
  $arrdata["TGL_SK_CPNS"]= $arrDataPegawai["tglskcpns"];
  $arrdata["NAMA_JABATAN_ANGKAT_CPNS"]= $arrDataPegawai[""];
  $arrdata["NOMOR_DOKTER_PNS"]= $arrDataPegawai[""];
  $arrdata["NOMOR_SK_PNS"]= $arrDataPegawai["nomorskpns"];
  $arrdata["NOMOR_SPMT"]= $arrDataPegawai["nospmt"];
  $arrdata["NOMOR_STTPL"]= $arrDataPegawai["nomorsttpl"];
  $arrdata["STATUS_CPNS_PNS"]= $arrDataPegawai["statuspegawai"];
  $arrdata["TANGGAL_DOKTER_PNS"]= $arrDataPegawai[""];
  $arrdata["TGL_SK_PNS"]= $arrDataPegawai["tglskpns"];
  $arrdata["TGL_STTPL"]= $arrDataPegawai["tglsttpl"];
  $arrdata["TMT_PNS"]= $arrDataPegawai["tmtpns"];
}
array_push($arrdatabkn, $arrdata);
// print_r($arrdatabkn);exit;
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

  <style type="text/css">
    .area-monitoring-riwayat .item .data {
      width: calc(98% - 80px) !important;
    }

    .area-monitoring-riwayat .item {
      margin-right: 10px !important;
    }

    .area-monitoring-riwayat .item .tanggal {
      width: calc(2% + 0px) !important;
    }

    .area-monitoring-riwayat .item .tanggal::before {
      background: none !important;
    }
  </style>
</head>
<body>

  <div class="area-konten area-monitoring-riwayat">
    <div class="judul-konten">
      Data CPNS - PNS
      
      <a style="cursor:pointer; float: right; color: white" onClick="parent.setload('pegawai_add_cpns_pns_monitoring?reqId=<?=$reqId?>')"> <i class="mdi-navigation-arrow-back"> <span class=" material-font">Kembali</span></i></a>
    </div>

    <div class="inner">
      <div class="judul-instansi">
        <div class="tanggal"></div>
        <div class="data">
          <div class="title"></div>
          <div class="data-siapasn" style="paddixng-left: 80px !important;">Data SIAPASN</div>
          <div class="data-bkn" style="paddixng-left: 179px !important;">Data BKN</div>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>

      <?
      $indexdata= 0;
      $vurldetil= $infoidsapkriwayat= $infoidriwayat= "";
      $infostatuspegawairiwayat= $infonomorskcpnsriwayat= $infotglskcpnsriwayat= $infonomorspmtriwayat= $infotmtpnsriwayat= $infonomorskpnsriwayat= $infotglskpnsriwayat= $infonomorsksttplriwayat= $infotglsksttplriwayat= "";
      if(!empty($arrdatariwayat))
      {
        $infoidriwayat= $arrdatariwayat[$indexdata]["ID_ROW"];
        $infostatuspegawairiwayat= $arrdatariwayat[$indexdata]["STATUS_CPNS_PNS"];
        $infonomorskcpnsriwayat= $arrdatariwayat[$indexdata]["NOMOR_SK_CPNS"];
        $infotglskcpnsriwayat= $arrdatariwayat[$indexdata]["TGL_SK_CPNS"];
        $infoidsapkriwayat= $arrdatariwayat[$indexdata]["ID_SAPK"];
        $infonomorspmtriwayat= $arrdatariwayat[$indexdata]["NOMOR_SPMT"];
        $infotmtpnsriwayat= $arrdatariwayat[$indexdata]["TMT_PNS"];
        $infonomorskpnsriwayat= $arrdatariwayat[$indexdata]["NOMOR_SK_PNS"];
        $infotglskpnsriwayat= $arrdatariwayat[$indexdata]["TGL_SK_PNS"];
        $infonomorsksttplriwayat= $arrdatariwayat[$indexdata]["NOMOR_STTPL"];
        $infotglsksttplriwayat= $arrdatariwayat[$indexdata]["TGL_STTPL"];
        $vurldetil= "pegawai_add_cpns_pns_monitoring";
      }

      // untuk ambil data bkn
      $infoidbkn= "";
      $infostatuspegawaibkn= $infonomorskcpnsbkn= $infotglskcpnsbkn= $infonomorspmtbkn= $infotmtpnsbkn= $infonomorskpnsbkn= $infotglskpnsbkn= $infonomorskpnsbkn= $infotglskpnsbkn= $infonomorsksttplbkn= $infotglsksttplbkn= "";
      if(!empty($arrdatabkn))
      {
        $infoidbkn= $arrdatabkn[$indexdata]["id"];
        $infostatuspegawaibkn= $arrdatabkn[$indexdata]["STATUS_CPNS_PNS"];
        $infonomorskcpnsbkn= $arrdatabkn[$indexdata]["NOMOR_SK_CPNS"];
        $infotglskcpnsbkn= $arrdatabkn[$indexdata]["TGL_SK_CPNS"];
        $infonomorspmtbkn= $arrdatabkn[$indexdata]["NOMOR_SPMT"];
        $infotmtpnsbkn= $arrdatabkn[$indexdata]["TMT_PNS"];
        $infonomorskpnsbkn= $arrdatabkn[$indexdata]["NOMOR_SK_PNS"];
        $infotglskpnsbkn= $arrdatabkn[$indexdata]["TGL_SK_PNS"];
        $infonomorsksttplbkn= $arrdatabkn[$indexdata]["NOMOR_STTPL"];
        $infotglsksttplbkn= $arrdatabkn[$indexdata]["TGL_STTPL"];
      }
      ?>

      <div class="item">
        <div class="tanggal"></div>
        
        <div class="data">

          <div class="baris atas">
            <div class="title"></div>
            <div class="data-siapasn"></div>
            <div class="data-bkn"></div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title">Status Pegawai</div>
            <div class="data-siapasn">
              <?
              if(empty($infostatuspegawairiwayat))
              {
              ?>
              <span class="tidak-ada-data"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Belum ada data</span>
              <?
              }
              ?>
              <?=$infostatuspegawairiwayat?>
            </div>
            <div class="data-bkn">
              <?
              if(empty($infostatuspegawaibkn))
              {
              ?>
              <span class="tidak-ada-data"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Belum ada data</span>
              <?
              }
              ?>
              <?=$infostatuspegawaibkn?>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title">Nomor Sk CPNS</div>
            <div class="data-siapasn"><?=$infonomorskcpnsriwayat?$infonomorskcpnsriwayat:'-';?></div>
            <div class="data-bkn"><?=$infonomorskcpnsbkn?$infonomorskcpnsbkn:'-';?></div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title">Tanggal SK CPNS</div>
            <div class="data-siapasn"><?=$infotglskcpnsriwayat?$infotglskcpnsriwayat:'-';?></div>
            <div class="data-bkn"><?=$infotglskcpnsbkn?$infotglskcpnsbkn:'-';?></div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title">No. SPMT</div>
            <div class="data-siapasn"><?=$infonomorspmtriwayat?$infonomorspmtriwayat:'-'?></div>
            <div class="data-bkn"><?=$infonomorspmtbkn?$infonomorspmtbkn:'-';?></div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title">TMT PNS</div>
            <div class="data-siapasn"><?=$infotmtpnsriwayat?$infotmtpnsriwayat:'-';?></div>
            <div class="data-bkn"><?=$infotmtpnsbkn?$infotmtpnsbkn:'-';?></div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title">Nomor Sk PNS</div>
            <div class="data-siapasn"><?=$infonomorskpnsriwayat?$infonomorskpnsriwayat:'-';?></div>
            <div class="data-bkn"><?=$infonomorskpnsbkn?$infonomorskpnsbkn:'-';?></div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title">Tanggal SK PNS</div>
            <div class="data-siapasn"><?=$infotglskpnsriwayat?$infotglskpnsriwayat:'-';?></div>
            <div class="data-bkn"><?=$infotglskpnsbkn?$infotglskpnsbkn:'-';?></div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title">Nomor STTPL</div>
            <div class="data-siapasn"><?=$infonomorskpnsriwayat?$infonomorsksttplriwayat:'-';?></div>
            <div class="data-bkn"><?=$infonomorsksttplbkn?$infonomorsksttplbkn:'-';?></div>
            <div class="clearfix"></div>
          </div>

          <div class="baris">
            <div class="title">Tanggal STTPL</div>
            <div class="data-siapasn"><?=$infotglsksttplriwayat?$infotglsksttplriwayat:'-';?></div>
            <div class="data-bkn"><?=$infotglsksttplbkn?$infotglsksttplbkn:'-';?></div>
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
            <a class="<?=$infolinkdisabled?>" href="app/loadUrl/app/<?=$vurldetil?>?reqId=<?=$reqId?>" title="ubah data"><img src="images/icon-pen.png"></a>
          </div>
        </div>
        <div class="clearfix"></div>

      </div>

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

              var s_url='bkn/cpns_pns_json/reset_siapasn?reqRiwayatId='+vinfoid;
              $.ajax({'url': s_url, type: "get",'success': function(data){
                // console.log(data);return false;
                mbox.alert('Proses Data', {open_speed: 500}, interval = window.setInterval(function() 
                {
                  clearInterval(interval);
                  document.location.href= "app/loadUrl/app/pegawai_add_cpns_pns_bkn/?reqId=<?=$reqId?>";
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

              var s_url='bkn/cpns_pns_json/siapasn_bkn?reqRiwayatId='+vinfoid+"&reqBknId="+vinfoidbkn;
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
                     document.location.href= "app/loadUrl/app/pegawai_add_cpns_pns_bkn/?reqId=<?=$reqId?>";
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

              var s_url='bkn/cpns_pns_json/bkn_siapasn?reqBknId='+vinfoid+"&reqRiwayatId="+vinfoidriwayat;
              $.ajax({'url': s_url, type: "get",'success': function(data){
                // console.log(data);return false;
                mbox.alert('Proses Data', {open_speed: 500}, interval = window.setInterval(function() 
                {
                  clearInterval(interval);
                   document.location.href= "app/loadUrl/app/pegawai_add_cpns_pns_bkn/?reqId=<?=$reqId?>";
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