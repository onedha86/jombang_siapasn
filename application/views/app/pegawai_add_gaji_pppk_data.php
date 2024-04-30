<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$CI =& get_instance();
$CI->checkUserLogin();

$this->load->model('PangkatRiwayat');
$this->load->model('GajiPppkRiwayat');
$this->load->model('GolonganPppk');
$this->load->model('KualitasFile');
$this->load->library('globalfilepegawai');

$pangkat= new GolonganPppk();
$pangkat->selectByParams(array());

$sessionLoginLevel= $this->LOGIN_LEVEL;
$reqId= $this->input->get("reqId");
$reqRowId= $this->input->get("reqRowId");
$reqMode= $this->input->get("reqMode");
$reqPeriode= $this->input->get("reqPeriode");
$CI->checkpegawai($reqId);
$tempUserLoginId= $this->USER_LOGIN_ID;
$tempMenuId= "010203";
$tempAksesMenu= $CI->checkmenupegawai($tempUserLoginId, $tempMenuId);

if($reqRowId=="")
{
  $reqMode = 'insert';
  $reqJenis= "1";
}
else
{
  $reqMode = 'update';
  $statement= " AND A.GAJI_RIWAYAT_ID = ".$reqRowId." AND A.PEGAWAI_ID = ".$reqId;
  $set= new GajiPppkRiwayat();
  $set->selectByParams(array(), -1, -1, $statement);
  // echo $set->query;exit;
  $set->firstRow();
  $reqRowId = $set->getField('GAJI_RIWAYAT_ID');

  $reqPejabatPenetapId= $set->getField('PEJABAT_PENETAP_ID');
  $reqPejabatPenetap= $set->getField('PEJABAT_PENETAP_NAMA');
  $reqNoSk = $set->getField('NO_SK');
  $reqGolRuang= $set->getField('PANGKAT_ID');
  $reqTanggalSk= dateToPageCheck($set->getField('TANGGAL_SK'));
  $reqTmtSk= dateToPageCheck($set->getField('TMT_SK'));
  $reqGajiPokok = $set->getField('GAJI_POKOK');
  // echo $reqGajiPokok;exit();
  $reqTh= $set->getField('MASA_KERJA_TAHUN');
  $reqBl= $set->getField('MASA_KERJA_BULAN');
  $reqJenis= $set->getField('JENIS_KENAIKAN');
  $reqJenisNama= $set->getField('JENIS_KENAIKAN_NAMA');
  $reqLastProsesUser= $set->getField('LAST_PROSES_USER');

  $LastLevel= $set->getField('LAST_LEVEL');
}

$tempAksiProses= "";
if($sessionLoginLevel < $LastLevel)
$tempAksiProses= "1";

// untuk kondisi file
$vfpeg= new globalfilepegawai();
$arrpilihfiledokumen= $vfpeg->pilihfiledokumen();
// print_r($arrpilihfiledokumen);exit;

if(empty($reqRowId))
  $arrlistriwayatfilepegawai= $vfpeg->listpilihfilepegawai($reqId, $riwayattable, "baru");
else
  $arrlistriwayatfilepegawai= $vfpeg->listpilihfilepegawai($reqId, $riwayattable, $reqRowId);

$vRowId= $reqRowId;

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

$disabledfile= "";
if(!empty($hanyalihatfile))
{
  $disabledfile= "disabled";
}
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
  function setGaji()
  {
    var reqTglSk= reqPangkatId= reqMasaKerja= "";
    reqTglSk= $("#reqTanggalSk").val();
    reqPangkatId= $("#reqGolRuang").val();
    reqMasaKerja= $("#reqTh").val();

    urlAjax= "golongan_pppk_gaji_json/gajipokok?reqGolonganPppkId="+reqPangkatId+"&reqMasaKerja="+reqMasaKerja+"&reqTglSk="+reqTglSk;
    $.ajax({'url': urlAjax,'success': function(data){
      tempValueGaji= parseFloat(data);
      $("#reqGajiPokok").val(FormatCurrency(tempValueGaji));
    }});
  }
  
  $(function(){
    <?
    if($reqGajiPokok == "")
    {
    ?>
    setGaji();
    <?
    }
    ?>
    
    $("#reqGolRuang").change(function(){
      setGaji();
    });

    $("#reqTanggalSk, #reqTh").keyup(function(){
      setGaji();
    });

    $("#reqsimpan").click(function() { 
      if($("#ff").form('validate') == false){
        return false;
      }

      var reqTanggal= "";
      reqTanggal= $("#reqTmtSk").val();
      var s_url= "hari_libur_json/hakentrigaji?reqMode=gaji&reqTanggal="+reqTanggal;
      $.ajax({'url': s_url,'success': function(dataajax){
        // return false;
        dataajax= dataajax.split(";");
        rowid= parseInt(dataajax[0]);
        infodata= dataajax[1];
        if(rowid == 1)
        {
          mbox.alert('Anda tidak berhak menambah data di atas tmt sk ' + infodata, {open_speed: 0});
          return false;
        }
        else
          $("#reqSubmit").click();
      }});

    });
    
    $('#ff').form({
      url:'gaji_pppk_riwayat_json/add',
      onSubmit:function(){

        var reqGolRuang= "";
        reqGolRuang= $("#reqGolRuang").val();

        if(reqGolRuang == "")
        {
          $.messager.alert('Info', "Lengkapi data golongan ruang terlebih dahulu", 'info');
          return false;
        }

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
          document.location.href= "app/loadUrl/app/pegawai_add_gaji_pppk_data/?reqId=<?=$reqId?>&reqPeriode=<?=$reqPeriode?>&reqRowId="+rowid;
          }, 1000));
          $(".mbox > .right-align").css({"display": "none"});
        }
      }
    });

    $('input[id^="reqPejabatPenetap"]').autocomplete({
      source:function(request, response){
        var id= this.element.attr('id');
        var replaceAnakId= replaceAnak= urlAjax= "";

        if (id.indexOf('reqPejabatPenetap') !== -1)
        {
          var element= id.split('reqPejabatPenetap');
          var indexId= "reqPejabatPenetapId"+element[1];
          urlAjax= "pejabat_penetap_json/combo";
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
                return {desc: element['desc'], id: element['id'], label: element['label'], statusht: element['statusht']};
              });
              response(array);
            }
          }
        })
      },
      focus: function (event, ui) 
      { 
        var id= $(this).attr('id');
        if (id.indexOf('reqPejabatPenetap') !== -1)
        {
          var element= id.split('reqPejabatPenetap');
          var indexId= "reqPejabatPenetapId"+element[1];
        }

        var statusht= "";
          $("#"+indexId).val(ui.item.id).trigger('change');
        },
        autoFocus: true
      }).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
      .append( "<a>" + item.desc + "</a>" )
      .appendTo( ul );
    };

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
          <li class="collection-item ubah-color-warna">EDIT Gaji PPPK</li>
          <li class="collection-item">

            <div class="row">
              <form id="ff" method="post" enctype="multipart/form-data">

                <div class="row">
                  <div class="input-field col s12 m6">
                    <label for="reqNoSk">No. SK</label>
                    <input type="text" class="easyui-validatebox" required id="reqNoSk" name="reqNoSk" <?=$read?> value="<?=$reqNoSk?>" />
                  </div>
                  <div class="input-field col s12 m6">
                    <label for="reqTanggalSk">Tgl. SK</label>
                    <input required class="easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTanggalSk" id="reqTanggalSk"  value="<?=$reqTanggalSk?>" maxlength="10" onKeyDown="return format_date(event,'reqTanggalSk');"/>
                  </div>
                </div>    

                <div class="row">
                  <div class="input-field col s12 m6">
                    <select name="reqGolRuang" id="reqGolRuang">
                      <option value=""></option>
                      <? 
                      while($pangkat->nextRow())
                      {
                      ?>
                        <option value="<?=$pangkat->getField('PANGKAT_ID')?>" <? if($reqGolRuang == $pangkat->getField('PANGKAT_ID')) echo 'selected';?>><?=$pangkat->getField('KODE')?></option>
                      <? 
                      }
                      ?>
                    </select>
                    <label for="reqGolRuang">Gol/Ruang</label>
                  </div>
                  <div class="input-field col s12 m6">
                    <label for="reqTmtSk">TMT SK</label>
                    <input required class="easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTmtSk" id="reqTmtSk"  value="<?=$reqTmtSk?>" maxlength="10" onKeyDown="return format_date(event,'reqTmtSk');"/>
                  </div>
                </div>    

                <div class="row">
                  <div class="input-field col s12 m6">
                    <label for="reqPejabatPenetap">Pejabat Penetapan</label>
                    <input type="hidden" name="reqPejabatPenetapId" id="reqPejabatPenetapId" value="<?=$reqPejabatPenetapId?>" /> 
                    <input type="text" id="reqPejabatPenetap"  name="reqPejabatPenetap" <?=$read?> value="<?=$reqPejabatPenetap?>" class="easyui-validatebox" required />
                  </div>
                </div>    

                <div class="row">
                  <div class="input-field col s6 m3">
                    <label for="reqTh">Masa Kerja Tahun</label>
                    <input type="hidden" name="reqTempTh" value="<?=$reqTh?>" />
                    <input type="text" class="easyui-validatebox" required name="reqTh" <?=$read?> value="<?=$reqTh?>" id="reqTh" title="Masa kerja tahun harus diisi" />
                  </div>

                  <div class="input-field col s6 m3">
                    <label for="reqBl">Masa Kerja Bulan</label>
                    <input type="hidden" name="reqTempBl" value="<?=$reqBl?>" />
                    <input type="text" class="easyui-validatebox" required name="reqBl" <?=$read?> value="<?=$reqBl?>" id="reqBl" title="Masa kerja bulan diisi" />
                  </div>
                  
                  <div class="input-field col s12 m6">
                    <label for="reqGajiPokok">Gaji Pokok</label>
                    <input type="text" placeholder class="easyui-validatebox" required id="reqGajiPokok" name="reqGajiPokok" OnFocus="FormatAngka('reqGajiPokok')" OnKeyUp="FormatUang('reqGajiPokok')" OnBlur="FormatUang('reqGajiPokok')" value="<?=numberToIna($reqGajiPokok)?>" />
                  </div>
                </div>

                <div class="row">
                  <div class="input-field col s12 m6">
                    <?
                    if($reqJenis == "3")
                    {
                      ?>
                      <label for="reqJenisNama">Jenis</label>
                      <input type="hidden" id="reqJenis" name="reqJenis" value="3" />
                      <input type="text" id="reqJenisNama" value="Gaji Berkala" disabled />
                    <?
                    }
                    else
                    {
                    ?>
                      <label for="reqJenisNama">Jenis</label>
                      <input type="hidden" id="reqJenis" name="reqJenis" value="<?=$reqJenis?>" />
                      <input type="text" id="reqJenisNama" value="<?=$reqJenisNama?>" disabled />
                      <?
                    }
                    ?>
                  </div>
                </div>

                <div class="row">
                  <div class="input-field col s12">
                    <button class="btn orange waves-effect waves-light" style="font-size:9pt" type="button" id="kembali">Kembali
                      <i class="mdi-navigation-arrow-back left hide-on-small-only"></i>
                    </button>

                    <script type="text/javascript">
                      $("#kembali").click(function() { 
                        document.location.href = "app/loadUrl/app/pegawai_add_gaji_pppk_monitoring?reqId=<?=$reqId?>&reqPeriode=<?=$reqPeriode?>";
                      });
                    </script>

                    <?
                    if($reqJenis == "3")
                    {
                      if($tempAksiProses == "1"){}
                      else
                      {
                    ?>
                      <input type="hidden" name="reqPeriode" value="<?=$reqPeriode?>" />
                      <input type="hidden" name="reqRowId" value="<?=$reqRowId?>" />
                      <input type="hidden" name="vRowId" value="<?=$vRowId?>" />
                      <input type="hidden" name="reqId" value="<?=$reqId?>" />
                      <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <?
                        if($tempAksesMenu == "A")
                        {
                    ?>
                        <button type="submit" style="display:none" id="reqSubmit"></button>
                        <button class="btn waves-effect waves-light green" style="font-size:9pt" type="button" id="reqsimpan">Simpan
                          <i class="mdi-content-save left hide-on-small-only"></i>
                        </button>
                    <?
                        }
                      }
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

                    <select <?=$disabledfile?> id="reqDokumenPilih<?=$riwayatfield?>" name="reqDokumenPilih[]">
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
                    <select <?=$disabledfile?> name="reqDokumenFileKualitasId[]" id="reqDokumenFileKualitasId<?=$riwayatfield?>">
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
                    <select <?=$disabledfile?> id="reqDokumenIndexId<?=$riwayatfield?>" name="reqDokumenIndexId[]">
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

              </form>

              <br/><br/><br/><br/>

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
<!-- jQuery Library -->
<!--<script type="text/javascript" src="lib/materializetemplate/js/plugins/jquery-1.11.2.min.js"></script>-->

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

  $('#reqTh,#reqBl').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  // untuk area untuk upload file
  vbase_url= "<?=base_url()?>";
  getarrlistpilihfilefield= JSON.parse('<?=JSON_encode($arrlistpilihfilefield)?>');
  // console.log(getarrlistpilihfilefield);

  // apabila butuh kualitas dokumen di ubah
  vselectmaterial= "1";
  // untuk area untuk upload file

</script>

<script type="text/javascript" src="lib/easyui/pelayanan-efile.js"></script>

<link rel="stylesheet" href="lib/AdminLTE-2.4.0-rc/dist/css/skins/ubah-skin.css">
<script src="lib/AdminLTE-2.4.0-rc/dist/js/ubah-skin.js"></script>

</body>