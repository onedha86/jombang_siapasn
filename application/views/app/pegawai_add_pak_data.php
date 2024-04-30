<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$CI =& get_instance();
$CI->checkUserLogin();

$this->load->model('Pak');
$this->load->model('KualitasFile');
$this->load->library('globalfilepegawai');

$reqId= $this->input->get("reqId");
$reqRowId= $this->input->get("reqRowId");
$reqMode= $this->input->get("reqMode");
$CI->checkpegawai($reqId);
$tempUserLoginId= $this->USER_LOGIN_ID;
$tempMenuId= "010702";
$tempAksesMenu= $CI->checkmenupegawai($tempUserLoginId, $tempMenuId);

$pelayananid= $this->input->get("pelayananid");
$pelayananjenis= $this->input->get("pelayananjenis");
$pelayananrowid= $this->input->get("pelayananrowid");
$pelayanankembali= $this->input->get("pelayanankembali");

if($reqRowId=="")
{
  $reqMode = 'insert';
}
else
{
  $reqMode = 'update';
  $statement= " AND A.PAK_ID = ".$reqRowId." AND A.PEGAWAI_ID = ".$reqId;
  $set= new Pak();
  $set->selectByParams(array(), -1, -1, $statement);
  $set->firstRow();

  $reqJabatanFtId= $set->getField('JABATAN_FT_ID');
  $reqCheckPakAwal = $set->getField('PAK_AWAL');
  $reqJabatanFt= $set->getField('JABATAN');
  $reqNoSK= $set->getField('NO_SK');
  $reqTglMulai= dateToPageCheck($set->getField('TANGGAL_MULAI'));
  $reqTglSelesai= dateToPageCheck($set->getField('TANGGAL_SELESAI'));
  $reqTglSK= dateToPageCheck($set->getField('TANGGAL_SK'));
  $reqKreditUtama= dotToComma($set->getField('KREDIT_UTAMA'));
  $reqKreditPenunjang= dotToComma($set->getField('KREDIT_PENUNJANG'));
  $reqTotalKredit= dotToComma($set->getField('TOTAL_KREDIT'));
  $vidsapk= $set->getField("ID_SAPK");
  $reqCheckPakIntegrasi = $set->getField('PAK_INTERGRASI');
  $reqCheckPakKonversi = $set->getField('PAK_KONVERSI');

  $reqTglMulaiBulan = $set->getField('BULAN_MULAI');
  $reqTglMulaiTahun = $set->getField('TAHUN_MULAI');
  $reqTglSelesaiBulan = $set->getField('BULAN_SELESAI');
  $reqTglSelesaiTahun= $set->getField('TAHUN_SELESAI');
}

// untuk kondisi file
$vfpeg= new globalfilepegawai();
$arrpilihfiledokumen= $vfpeg->pilihfiledokumen();
// print_r($arrpilihfiledokumen);exit;

$riwayattable= "PAK";
$reqDokumenKategoriFileId= "10"; // ambil dari table KATEGORI_FILE, cek sesuai mode
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

$arrlistpilihfilefield= [];
$reqDokumenPilih= [];
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
$arrkualitasfile=[];
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["ID"]= $set->getField("KUALITAS_FILE_ID");
  $arrdata["TEXT"]= $set->getField("NAMA");
  array_push($arrkualitasfile, $arrdata);
}

// kondisi untuk menu
$this->load->library('globalmenusapk');
$vmenusapk= new globalmenusapk();
$arrmenusapk= $vmenusapk->setmenusapk($tempMenuId);
// print_r($arrmenusapk);exit;
$lihatsapk= $arrmenusapk["lihat"];
$kirimsapk= $arrmenusapk["kirim"];
$tariksapk= $arrmenusapk["tarik"];

$queryJabatan = 'Select * from jabatan_riwayat where jabatan_ft_id is not null and  id_sapk is not null and status is null and pegawai_id='.ValToNullDB($reqId);
$arrDataJabatanFt = $this->db->query($queryJabatan)->result_array();

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
<script type="text/javascript" src="lib/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="lib/easyui/globalfunction.js"></script>

<!-- AUTO KOMPLIT -->
<link rel="stylesheet" href="lib/autokomplit/jquery-ui.css">
<script src="lib/autokomplit/jquery-ui.js"></script>

<script type="text/javascript"> 
$(function(){
  $('#ff').form({
    url:'pak_json/add',
    onSubmit:function(){
      if($(this).form('validate')){}
      else
      {
        $.messager.alert('Info', "Lengkapi data terlebih dahulu", 'info');
        return false;
      }
    },
    success:function(data){
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
           if(!empty($pelayananid))
           {
           ?>
           vkembali= "app/loadUrl/app/pegawai_add_pak_data?reqId=<?=$reqId?>&reqRowId="+rowid+"&pelayananid=<?=$pelayananid?>&pelayananjenis=<?=$pelayananjenis?>&pelayananrowid=<?=$pelayananrowid?>&pelayanankembali=<?=$pelayanankembali?>";
           <?
           }
           else
           {
           ?>
           vkembali= "app/loadUrl/app/pegawai_add_pak_data?reqId=<?=$reqId?>&reqRowId="+rowid;
           <?
           }
           ?>
           document.location.href= vkembali;
        }, 1000));
        $(".mbox > .right-align").css({"display": "none"});
      }
    }
  });

  $("#reqKreditUtama, #reqKreditPenunjang").keyup(function(){
    var reqKreditUtama= reqKreditPenunjang= "";
    reqKreditUtama= $("#reqKreditUtama").val();
    reqKreditUtama= String(reqKreditUtama);
    reqKreditUtama= reqKreditUtama.replace(",", ".");

    reqKreditPenunjang= $("#reqKreditPenunjang").val();
    reqKreditPenunjang= String(reqKreditPenunjang);
    reqKreditPenunjang= reqKreditPenunjang.replace(",", ".");

    reqTotalKredit= parseFloat(reqKreditUtama) + parseFloat(reqKreditPenunjang);
    reqTotalKredit= reqTotalKredit.toFixed(3);
    reqTotalKredit= String(reqTotalKredit);
    reqTotalKredit= reqTotalKredit.replace(".", ",");
    $("#reqTotalKredit").val(reqTotalKredit);
  });
  
  $('input[id^="reqJabatanFt"]').autocomplete({
    source:function(request, response){
      var id= this.element.attr('id');
      var replaceAnakId= replaceAnak= urlAjax= "";
  
      if (id.indexOf('reqJabatanFt') !== -1)
      {
        var element= id.split('reqJabatanFt');
        var indexId= "reqJabatanFtId"+element[1];
        urlAjax= "jabatan_ft_json/namajabatan";
      }

      $.ajax({
        url: urlAjax,
        type: "GET",
        dataType: "json",
        data: { term: request.term },
        success: function(responseData){
          if(responseData == null)
          {
            response(null);
          }
          else
          {
            var array = responseData.map(function(element) {
              return {desc: element['desc'], id: element['id'], label: element['label'], satuan_kerja: element['satuan_kerja']};
            });
            response(array);
          }
        }
      })
    },
    focus: function (event, ui) 
    { 
      var id= $(this).attr('id');
      if (id.indexOf('reqJabatanFt') !== -1)
      {
        var element= id.split('reqJabatanFt');
        var indexId= "reqJabatanFtId"+element[1];
      }

      var statusht= "";
          //statusht= ui.item.statusht;
          $("#"+indexId).val(ui.item.id).trigger('change');
        },
        //minLength:3,
        autoFocus: true
      }).autocomplete( "instance" )._renderItem = function( ul, item ) {
      //return
      return $( "<li>" )
      .append( "<a>" + item.desc + "</a>" )
      .appendTo( ul );
  };

  $('#reqTglMulai').keyup(function() {
    vtanggalakhir= $('#reqTglMulai').val();
    vtahun= vtanggalakhir.substring(6,10);
    vBulan= vtanggalakhir.substring(3,5);
    $("#reqTglMulaiBulan").focus();
    $("#reqTglMulaiBulan").val(vBulan);
    $("#reqTglMulaiTahun").focus();
    $("#reqTglMulaiTahun").val(vtahun);

  });

  $('#reqTglSelesai').keyup(function() {
    vtanggalakhir= $('#reqTglSelesai').val();
    vtahun= vtanggalakhir.substring(6,10);
    vBulan= vtanggalakhir.substring(3,5);
    $("#reqTglSelesaiBulan").focus();
    $("#reqTglSelesaiBulan").val(vBulan);
    $("#reqTglSelesaiTahun").focus();
    $("#reqTglSelesaiTahun").val(vtahun);
  });

});

</script>

<!-- CORE CSS-->    
<link href="lib/materializetemplate/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="lib/materializetemplate/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<!-- CSS style Horizontal Nav-->    
<link href="lib/materializetemplate/css/layouts/style-horizontal.css" type="text/css" rel="stylesheet" media="screen,projection">
<!-- Custome CSS-->    
<link href="lib/materializetemplate/css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

<link href="lib/mbox/mbox.css" rel="stylesheet">
<script src="lib/mbox/mbox.js"></script>
<link href="lib/mbox/mbox-modif.css" rel="stylesheet">
</head>

<body>    
  <div id="basic-form" class="section">
    <div class="row">
     <div id='main' class="col s12 m12" style="padding-left: 15px;">

       <ul class="collection card">
         <li class="collection-item ubah-color-warna">EDIT PAK</li>
         <li class="collection-item">

            <form id="ff" method="post" enctype="multipart/form-data">
              
              <div class="row">
                <div class="input-field col s12 m3">
                  <label for="reqNoSK">No. SK</label>
                  <input type="text" class="easyui-validatebox" required name="reqNoSK" id="reqNoSK" <?=$read?> value="<?=$reqNoSK?>" />
                </div>
                <div class="input-field col s12 m3">
                  <label for="reqTglSK">Tgl. SK</label>
                  <input required class="easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTglSK" id="reqTglSK"  value="<?=$reqTglSK?>" maxlength="10" onKeyDown="return format_date(event,'reqTglSK');"/>
                </div>

                <div class="input-field col s12 m1">
                    <input type="radio" id="reqCheckPakAwal" name="reqCheckPakAwal" value="1" <? if($reqCheckPakAwal == 1) echo 'checked'?>/>
                    <label for="reqCheckPakAwal">Pertama</label>
                </div>
                  <div class="input-field col s12 m1">
                    <input type="radio" id="reqCheckPakIntegrasi" name="reqCheckPakAwal" value="2" <? if($reqCheckPakIntegrasi == 1) echo 'checked'?>/>
                    <label for="reqCheckPakIntegrasi">Integrasi</label>
                </div>
                 <div class="input-field col s12 m1">
                    <input type="radio" id="reqCheckPakKonversi" name="reqCheckPakAwal" value="3" <? if($reqCheckPakKonversi == 1) echo 'checked'?>/>
                    <label for="reqCheckPakKonversi">Konversi</label>
                </div>
              </div>

              <div class="row">
                <div class="input-field col s12 m3">
                  <label for="reqTglMulai">Tgl. Mulai Penilaian</label>
                  <input required class="easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTglMulai" id="reqTglMulai"  value="<?=$reqTglMulai?>" maxlength="10" onKeyDown="return format_date(event,'reqTglMulai');"/>
                </div>
                 <div class="input-field col s12 m2">
                  <label for="reqTglMulai">Bulan Mulai Penilaian</label>
                  <input  class="easyui-validatebox" type="text"  id="reqTglMulaiBulan"  value="<?=$reqTglMulaiBulan?>" disabled readonly/>
                </div>
                 <div class="input-field col s12 m2">
                  <label for="reqTglMulai">Tahun Mulai Penilaian</label>
                  <input  class="easyui-validatebox" type="text"  id="reqTglMulaiTahun"  value="<?=$reqTglMulaiTahun?>" disabled readonly/>
                </div>
               
              </div>
               <div class="row">
                 <div class="input-field col s12 m3">
                  <label for="reqTglSelesai">Tgl Selesai Penilaian</label>
                  <input required class="easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTglSelesai" id="reqTglSelesai"  value="<?=$reqTglSelesai?>" maxlength="10" onKeyDown="return format_date(event,'reqTglSelesai');"/>
                </div>
                 <div class="input-field col s12 m2">
                  <label for="reqTglMulai">Bulan Selesai Penilaian</label>
                  <input  class="easyui-validatebox" type="text"  id="reqTglSelesaiBulan"  value="<?=$reqTglSelesaiBulan?>" disabled readonly/>
                </div>
                 <div class="input-field col s12 m2">
                  <label for="reqTglMulai">Tahun Selesai Penilaian</label>
                  <input  class="easyui-validatebox" type="text"  id="reqTglSelesaiTahun"  value="<?=$reqTglSelesaiTahun?>" disabled readonly/>
                </div>
               </div>

               <div class="row">
                <div class="input-field col s12 m3">
                  <label for="reqKredit">Kredit Utama</label>
                  <input type="text" id="reqKreditUtama" name="reqKreditUtama" <?=$read?>  value="<?=$reqKreditUtama?>" onkeypress='kreditvalidate(event, this)' />
                </div>
                <div class="input-field col s12 m3">
                  <label for="reqKreditPenunjang">Kredit Penunjang</label>
                  <input type="text" id="reqKreditPenunjang" name="reqKreditPenunjang" <?=$read?>  value="<?=$reqKreditPenunjang?>" onkeypress='kreditvalidate(event, this)' />
                </div>

                <div class="input-field col s12 m3">
                  <label for="reqKredit">Total Kredit</label>
                  <input type="text" placeholder id="reqTotalKredit" name="reqTotalKredit" <?=$read?>  value="<?=$reqTotalKredit?>" onkeypress='kreditvalidate(event, this)' />
                </div>

              </div>

              <div class="row" style="display: none;">
                <div class="input-field col s12 m12">
                  <label for="reqJabatanFt">Nama Jabatan Fungsional Yang Diusulkan</label>
                  <input type="hidden" name="reqJabatanFtId22" id="reqJabatanFtId2" value="<?=$reqJabatanFtId?>" /> 
                  <input type="text" id="reqJabatanFt2" name="reqJabatanFt2" <?=$read?> value="<?=$reqJabatanFt?>" class="easyui-validatebox"  />
                </div>
              </div>

               <div class="row">
                <div class="input-field col s12 m12">
                   
                    <select id="reqSkDasarJabatan" name="reqJabatanFtId" >
                      <option value=""></option>
                      <?
                      foreach($arrDataJabatanFt as $value){
                      ?>
                        <option value="<?=$value['jabatan_ft_id']?>"
                          <?if($value['jabatan_ft_id']==$reqJabatanFtId){echo 'selected';}?>
                          ><?=$value['nama']?></option>
                      <?
                      }
                      ?>
                    </select>
                     <label for="reqJabatanFt">Jabatan Fungsional Ketika Mendapatkan Angka Kredit</label>
                </div>
              </div>

              <div class="row">
                <div class="input-field col s12">
                  <button class="btn orange waves-effect waves-light" style="font-size:9pt" type="button" id="kembali">Kembali
                    <i class="mdi-navigation-arrow-back left hide-on-small-only"></i>
                  </button>

                  <script type="text/javascript">
                    $("#kembali").click(function() { 
                      <?
                      if(!empty($pelayananid))
                      {
                      ?>
                      vkembali= "app/loadUrl/app/pegawai_add_pak_monitoring?reqId=<?=$reqId?>&pelayananid=<?=$pelayananid?>&pelayananjenis=<?=$pelayananjenis?>&pelayananrowid=<?=$pelayananrowid?>&pelayanankembali=<?=$pelayanankembali?>";
                      <?
                      }
                      else
                      {
                      ?>
                      vkembali= "app/loadUrl/app/pegawai_add_pak_monitoring?reqId=<?=$reqId?>";
                      <?
                      }
                      ?>
                      document.location.href = vkembali;
                    });
                  </script>

                  <input type="hidden" name="reqRowId" value="<?=$reqRowId?>" />
                  <input type="hidden" name="reqId" value="<?=$reqId?>" />
                  <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                  <?
                  // A;R;D
                  if($tempAksesMenu == "A")
                  {
                  ?>
                  <button class="btn waves-effect waves-light green" style="font-size:9pt" type="submit" name="action">Simpan
                    <i class="mdi-content-save left hide-on-small-only"></i>
                  </button>
                  <?
                  }
                  ?>
                  <?
                  if(!empty($reqRowId) && !empty($kirimsapk)  && $reqRowId !=-1)
                  {
                    ?>
                    <button class="btn  waves-effect waves-light" style="font-size:9pt;background: #9C28B0;" type="button" id='buttonbtn'>
                      <input type="hidden" id="reqIdField" value="<?=$reqRowId?>" />
                      <input type="hidden" id="reqIdBkn" value="<?=$vidsapk?>" />
                      <input type="hidden" id="reqUrlBkn" value="angkakredit_json" />
                      <i class="mdi-content-save left hide-on-small-only"></i> <span > UPDATE KE SIASN BKN</span>
                    </button>
                    <?
                  }
                  ?>

                  <?
                  if(!empty($vidsapk) && !empty($lihatsapk))
                  {
                    $vdetilsapk= $vidsapk."___pegawai_add_angka_kredit_sapk_data";
                    $vdetillabelsapk= "Data SAPK BKN";
                    ?>
                    <button class="btn blue waves-effect waves-light" style="font-size:9pt" type="button" id='buttondatasapk<?=$vdetilsapk?>'>
                      <input type="hidden" id="labelvsapk<?=$vdetilsapk?>" value="<?=$vdetillabelsapk?>" />
                      <input type="hidden" id="<?=$vidsapk?>" value="<?=$reqId?>" />
                      <span id="labelframesapk<?=$vdetilsapk?>">Cek <?=$vdetillabelsapk?></span>
                    </button>
                    <?
                  }
                  ?>
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

                  <select id="reqDokumenPilih<?=$riwayatfield?>" name="reqDokumenPilih[]">
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
                  <select <?=$disabled?> name="reqDokumenFileKualitasId[]" id="reqDokumenFileKualitasId<?=$riwayatfield?>">
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
                  <select id="reqDokumenIndexId<?=$riwayatfield?>" name="reqDokumenIndexId[]">
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

            <br/><br/><br/><br/>
            </form>
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
<!-- jQuery Library -->
<!-- <script type="text/javascript" src="lib/materializetemplate/js/plugins/jquery-1.11.2.min.js"></script> -->

<!--materialize js-->
<script type="text/javascript" src="lib/materializetemplate/js/my-materialize.min.js"></script>

<style type="text/css">
  .select-dropdown {
    max-height:250px !important; overflow:auto !important;
  }
</style>

<script type="text/javascript">
  $(document).ready(function() {
    $('select').material_select();
  });

  $('.materialize-textarea').trigger('autoresize');

  // untuk area untuk upload file
  vbase_url= "<?=base_url()?>";
  getarrlistpilihfilefield= JSON.parse('<?=JSON_encode($arrlistpilihfilefield)?>');
  // console.log(getarrlistpilihfilefield);

  // apabila butuh kualitas dokumen di ubah
  vselectmaterial= "1";
  // untuk area untuk upload file

</script>

<script type="text/javascript" src="lib/easyui/pelayanan-efile.js"></script>
<script type="text/javascript" src="lib/easyui/pelayanan-bkndetil.js"></script>
<link rel="stylesheet" href="lib/AdminLTE-2.4.0-rc/dist/css/skins/ubah-skin.css">
<script src="lib/AdminLTE-2.4.0-rc/dist/js/ubah-skin.js"></script>

</body>
</html>