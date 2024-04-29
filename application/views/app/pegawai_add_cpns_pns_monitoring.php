<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$CI =& get_instance();
$CI->checkUserLogin();

$this->load->model('SkPns');
$this->load->model('SkCpns');
$this->load->model('PegawaiFile');

$reqId= $this->input->get("reqId");
$reqPeriode= $this->input->get("reqPeriode");
$CI->checkpegawai($reqId);

$skcpns = new SkCpns();
$skpns = new SkPns();

$skcpns->selectByParams(array("PEGAWAI_ID" => $reqId), -1,-1,'');
$skcpns->firstRow();
//echo $skcpns->query;exit;
$reqPegawaiCpnsId= $skcpns->getField('PEGAWAI_ID');
$reqPangkat= $skcpns->getField('PANGKAT_KODE');
$reqTmt= dateToPageCheck($skcpns->getField('TMT_CPNS'));
$reqMasaKerjaTh= $skcpns->getField('MASA_KERJA_TAHUN');
$reqMasaKerjaBl= $skcpns->getField('MASA_KERJA_BULAN');
$reqTkPendidikan= $skcpns->getField('PENDIDIKAN_NAMA');
$reqJurusan= $skcpns->getField('PENDIDIKAN_JURUSAN_NAMA');
// $reqFormasi     = $skcpns->getField('');
$statement= " AND A.PEGAWAI_ID = ".$reqId." AND A.RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' AND A.RIWAYAT_FIELD = 'skcpns'";
$pegawai_file= new PegawaiFile();
$pegawai_file->selectByParamsLastRiwayatTable(array(), -1,-1,$statement);
$pegawai_file->firstRow();
// echo $pegawai_file->query;exit();
$tempPathSkCpns= $pegawai_file->getField("PATH");

$skpns->selectByParams(array("PEGAWAI_ID" => $reqId), -1,-1,'');
$skpns->firstRow();
//echo $skpns->query;exit;
$reqPangkatPns= $skpns->getField('PANGKAT_KODE');
$reqTmtPns= dateToPageCheck($skpns->getField('TMT_PNS'));
$reqMasaKerjaThPns= $skpns->getField('MASA_KERJA_TAHUN');
$reqMasaKerjaBlPns= $skpns->getField('MASA_KERJA_BULAN');
$reqNamaPenetapPns= $skpns->getField('NAMA_PENETAP');
$reqPejabatPenetapPns= $skpns->getField('PEJABAT_PENETAP_NAMA');
// $reqFormasiPns     = $skpns->getField('');
$statement= " AND A.PEGAWAI_ID = ".$reqId." AND A.RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' AND A.RIWAYAT_FIELD = 'skpns'";
$pegawai_file= new PegawaiFile();
$pegawai_file->selectByParamsLastRiwayatTable(array(), -1,-1,$statement);
$pegawai_file->firstRow();
$tempPathSkPns= $pegawai_file->getField("PATH");

$tempMenuId= "0102";
// kondisi untuk menu
$this->load->library('globalmenusapk');
$vmenusapk= new globalmenusapk();
$arrmenusapk= $vmenusapk->setmenusapk($tempMenuId);
// print_r($arrmenusapk);exit;
$lihatsapk= $arrmenusapk["lihat"];
$kirimsapk= $arrmenusapk["kirim"];
$tariksapk= $arrmenusapk["tarik"];
$syncsapk= $arrmenusapk["sync"];

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
  
  <!-- CORE CSS-->    
  <link href="lib/materializetemplate/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="lib/materializetemplate/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <!-- CSS style Horizontal Nav-->    
  <link href="lib/materializetemplate/css/layouts/style-horizontal.css" type="text/css" rel="stylesheet" media="screen,projection">
  <!-- Custome CSS-->    
  <link href="lib/materializetemplate/css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  
  <style type="text/css">
    .sm-text {
      font-size: 8pt;
    }
    .pad{
      padding: 1vw;
    }
  </style>
</head>

<body>    
  <!--Basic Form-->
  <div id="basic-form" class="section">
    <div class="row">

      <div class="col s12 m4 offset-m2 ">
       <form id="ff" class="pad" method="post" enctype="multipart/form-data">

        <ul class="collection card">
         <li class="collection-item ubah-color-warna">
          SK CPNS
          <?
          if(!empty($lihatsapk))
          {
          ?>
            <a style="cursor:pointer; margin-left: 20px; color: white !important" onClick="parent.setload('pegawai_add_cpns_pns_bkn?reqId=<?=$reqId?>')"> <i class="mdi-action-view-list"> <span class=" material-font">BKN</span></i></a>
          <?
          }
          ?>
         </li>
         <li class="collection-item">

           <div class="row">
            <div class="input-field col s12 m12 l6">
              <label for="reqPangkat">Golongan</label>
              <input type="text" name="reqPangkat" value="<?=$reqPangkat?>"  id="reqPangkat" disabled />
            </div>

            <div class="input-field col s12 m12 l6">
              <label for="reqTmt">TMT</label>
              <input type="text" name="reqTmt" value="<?=$reqTmt?>"  id="reqTmt" disabled />
            </div>
            <!-- </div>    -->

            <!-- <div class="row"> -->
            <div class="input-field col s12 m12 l6">
              <label for="reqMasaKerjaTh">Masa Kerja Tahun</label>
              <input type="text" name="reqMasaKerjaTh" value="<?=$reqMasaKerjaTh?>"  id="reqMasaKerjaTh" disabled />
            </div>
            <div class="input-field col s12 m12 l6">
              <label for="reqMasaKerjaBl">Masa Kerja Bulan</label>
              <input type="text" name="reqMasaKerjaBl" value="<?=$reqMasaKerjaBl?>"  id="reqMasaKerjaBl" disabled />
            </div>
            <!-- </div>    -->

            <!-- <div class="row"> -->
            <div class="input-field col s12 m12 l6">
              <label for="reqTkPendidikan">TK Pendidikan</label>
              <input type="text" name="reqTkPendidikan" value="<?=$reqTkPendidikan?>"  id="reqTkPendidikan" disabled />
            </div>
            <div class="input-field col s12 m12 l6">
              <label for="reqJurusan">Jurusan</label>
              <input type="text" name="reqJurusan" value="<?=$reqJurusan?>"  id="reqJurusan" disabled />
            </div>
            <!-- </div>    -->

            <!-- <div class="row"> -->
          </div>
          <div class="row">
            <div class="col s12 m12 l6">

              <div class="row">
                <?
                // $reqPegawaiCpnsId= "";
                if($reqPegawaiCpnsId == "")
                {
                ?>
                <button class="btn green waves-effect waves-light sm-text col s12" type="button" onClick="parent.setload('pegawai_add_sk_cpns?reqId=<?=$reqId?>&reqPeriode=<?=$reqPeriode?>')" name="action">Edit
                    <i class="mdi-social-person-outline left"></i>
                  </button>
                <?
                }
                else
                {
                ?>
                <div class="col s6 m6 16">
                  <button class="btn green waves-effect waves-light sm-text col" type="button" onClick="parent.setload('pegawai_add_sk_cpns?reqId=<?=$reqId?>&reqPeriode=<?=$reqPeriode?>')" name="action">Edit
                    <i class="mdi-social-person-outline left"></i>
                  </button>
                </div>

                <div class="col s6 m6">
                  <button class="btn pink waves-effect waves-light sm-text col" style="font-size:9pt" type="button" id="reqhapus">Hapus
                    <i class="mdi-content-inbox left hide-on-small-only"></i>
                  </button>
                </div>
                <?
                }
                ?>

              </div>

            </div>
            <div class="col s12 m12 l6">
              <?
              if($tempPathSkCpns == ""){}
              else
              {
              ?>
              <button class="btn green waves-effect waves-light sm-text col s12" type="button" onClick="window.open('<?=base_url().$tempPathSkCpns?>')" name="action">Lihat Berkas
                <i class="mdi-social-person-outline left"></i>
              </button>
              <?
              }
              ?>
            </div>
          </div>
        </li>
      </ul>

    </form>
  </div>

  <div class="col s12 m4 ">
    <form id="ff" class="pad" method="post" enctype="multipart/form-data">

      <ul class="collection card">
       <li class="collection-item active ubah-color-warna<?php /*?>light-green<?php */?>">SK PNS</li>
       <li class="collection-item">

         <div class="row">
          <div class="input-field col s12 m12 l6">
            <label for="reqPangkatPns">Golongan</label>
            <input type="text" name="reqPangkatPns" value="<?=$reqPangkatPns?>"  id="reqPangkatPns" disabled />
          </div>

          <div class="input-field col s12 m12 l6">
            <label for="reqTmtPns">TMT</label>
            <input type="text" name="reqTmtPns" value="<?=$reqTmtPns?>"  id="reqTmtPns" disabled />
          </div>
          <!-- </div>    -->

          <!-- <div class="row"> -->
          <div class="input-field col s12 m12 l6">
            <label for="reqMasaKerjaThPns">Masa Kerja Tahun</label>
            <input type="text" name="reqMasaKerjaThPns" value="<?=$reqMasaKerjaThPns?>"  id="reqMasaKerjaThPns" disabled />
          </div>
          <div class="input-field col s12 m12 l6">
            <label for="reqMasaKerjaBlPns">Masa Kerja Bulan</label>
            <input type="text" name="reqMasaKerjaBlPns" value="<?=$reqMasaKerjaBlPns?>"  id="reqMasaKerjaBlPns" disabled />
          </div>
          <!-- </div>    -->

          <!-- <div class="row"> -->
          <div class="input-field col s12 m12 l6">
            <label for="reqNamaPenetapPns">Nama Penetap</label>
            <input type="text" name="reqNamaPenetapPns" value="<?=$reqNamaPenetapPns?>"  id="reqNamaPenetapPns" disabled />
          </div>
          <div class="input-field col s12 m12 l6">
            <label for="reqPejabatPenetapPns">Pejabat Penetap</label>
            <input type="text" name="reqPejabatPenetapPns" value="<?=$reqPejabatPenetapPns?>"  id="reqPejabatPenetapPns" disabled />
          </div>
          <!-- </div>    -->

          <!-- <div class="row"> -->
        </div>
        <div class="row">
          <div class="col s12 m12 l6">
            <button class="btn light-green waves-effect waves-light sm-text col s12" type="button" onClick="parent.setload('pegawai_add_sk_pns?reqId=<?=$reqId?>&reqPeriode=<?=$reqPeriode?>')" name="action">Edit
              <i class="mdi-social-person-outline left"></i>
            </button>
          </div>
          <div class="col s12 m12 l6">
            
            <?
            if($tempPathSkPns == ""){}
            else
            {
            ?>  
            <button class="btn light-green waves-effect waves-light sm-text col s12" type="button" onClick="window.open('<?=base_url().$tempPathSkPns?>')" name="action">Lihat Berkas
              <i class="mdi-social-person-outline left"></i>
            </button>
            <?
            }
            ?>

          </div>
        </div>
      </li>
    </ul>

  </form>
</div>


</div>
</div>
<!-- jQuery Library -->
<script type="text/javascript" src="lib/materializetemplate/js/plugins/jquery-1.11.2.min.js"></script>

<!--materialize js-->
<script type="text/javascript" src="lib/materializetemplate/js/materialize.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('select').material_select();

    $("#reqhapus").click(function() { 

      mbox.custom({
        message: "Apakah Anda Yakin, Hapus data terpilih ?",
        options: {close_speed: 100},
        buttons: [
        {
          label: 'Ya',
          color: 'green darken-2',
          callback: function() {
            $.getJSON("sk_cpns_json/hapus/?reqId=<?=$reqId?>",
              function(data){
                mbox.alert(data.PESAN, {open_speed: 500}, interval = window.setInterval(function() 
                {
                  clearInterval(interval);
                  document.location.href= "app/loadUrl/app/pegawai_add_cpns_pns_monitoring/?reqId=<?=$reqId?>";
                }, 1000));
                $(".mbox > .right-align").css({"display": "none"});
              });
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

  });

  $('.materialize-textarea').trigger('autoresize');

</script>

<link rel="stylesheet" href="lib/AdminLTE-2.4.0-rc/dist/css/skins/ubah-skin.css">
<script src="lib/AdminLTE-2.4.0-rc/dist/js/ubah-skin.js"></script>

<link href="lib/mbox/mbox.css" rel="stylesheet">
<script src="lib/mbox/mbox.js"></script>
<link href="lib/mbox/mbox-modif.css" rel="stylesheet">
  
</body>