<?php
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

$CI =& get_instance();
$CI->checkUserLogin();

$infouserloginid= $this->USER_LOGIN_ID;
$infomenid= "3405";
$infoaksesmenu= $CI->checkmenupegawai($infouserloginid, $infomenid);
// echo $infoaksesmenu;exit;

$this->load->library('globalrekappegawai');
$vfpeg= new globalrekappegawai();

$getperumpunan= $vfpeg->getperumpunan();
$getperumpunan= $vfpeg->getglobalperumpunan("nilai_akhir");
$inforumpun= $vfpeg->inforumpun();

$reqBreadCrum= $this->input->get("reqBreadCrum");

$arrtabledata= array(
   array("label"=>"NIP", "field"=> "NIP_BARU", "display"=>"",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
  , array("label"=>"Nama", "field"=> "NAMA_LENGKAP", "display"=>"",  "width"=>"200", "colspan"=>"", "rowspan"=>"")
  , array("label"=>"Jabatan<br/>TMT<br/>Eselon", "field"=> "JABATAN_TMT_ESELON", "display"=>"",  "width"=>"400", "colspan"=>"", "rowspan"=>"")
  , array("label"=>"Gol. Ruang", "field"=> "PANGKAT_RIWAYAT_KODE", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
);

if($infoaksesmenu == "A")
{
  array_push($arrtabledata
    , array("label"=>"NILAI AKHIR", "field"=> "NILAI_AKHIR", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>$getperumpunan[0]["rumpunketerangan"]." (".$getperumpunan[0]["rumpunnilai"]."%)", "field"=> "KOMPETENSI_TOTAL", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>$getperumpunan[1]["rumpunketerangan"]." (".$getperumpunan[1]["rumpunnilai"]."%)", "field"=> "KINERJA_TOTAL", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>$getperumpunan[2]["rumpunketerangan"]." (".$getperumpunan[2]["rumpunnilai"]."%)", "field"=> "NILAI_RUMPUN_TOTAL", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
  );
}

if($infoaksesmenu == "A" || $infoaksesmenu == "R")
{
  $infoheadwidth= "";
  if($infoaksesmenu == "R")
    $infoheadwidth= "280";
  
  array_push($arrtabledata
    , array("label"=>$getperumpunan[3]["rumpunketerangan"]." (".$getperumpunan[3]["rumpunnilai"]."%)", "field"=> "FAKTOR_KOREKSI_TOTAL", "display"=>"",  "width"=>$infoheadwidth, "colspan"=>"", "rowspan"=>"")
  );
}

array_push($arrtabledata
  // untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
  , array("label"=>"sorderdefault", "field"=> "SORDERDEFAULT", "display"=>"1", "width"=>"")
  , array("label"=>"fieldid", "field"=> "PEGAWAI_ID", "display"=>"1", "width"=>"")
);
// print_r($arrtabledata);exit;

$arrstatus= $vfpeg->pilihstatus();
$arrtipepegawai= $vfpeg->pilihtipepegawai();
$arreselon= $vfpeg->piliheselon();

$tinggi = 156;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
	<title>Diklat</title>
	<base href="<?=base_url()?>" />
    <link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
    <!--<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">-->
    <link href="css/admin.css" rel="stylesheet" type="text/css">

    <style type="text/css" media="screen">
      @import "lib/media/css/site_jui.css";
      @import "lib/media/css/demo_table_jui.css";
      @import "lib/media/css/themes/base/jquery-ui.css";
  </style>

  <link rel="stylesheet" type="text/css" href="lib/DataTables-1.10.7/media/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="lib/DataTables-1.10.7/extensions/Responsive/css/dataTables.responsive.css">
  <link rel="stylesheet" type="text/css" href="lib/DataTables-1.10.7/examples/resources/syntax/shCore.css">
  <link rel="stylesheet" type="text/css" href="lib/DataTables-1.10.7/examples/resources/demo.css">

  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> -->

  <style type="text/css" class="init">

    /*td.details-control {
        background: url('lib/DataTables-1.10.7/examples/resources/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.details td.details-control {
        background: url('lib/DataTables-1.10.7/examples/resources/resources/details_close.png') no-repeat center center;
    }*/

    div.container { max-width: 100%;}

    .option-vw8 {
      width: 50% !important;
    }

    .labelkhusus
    {
      top: -20px !important;
    }
    
  </style>
<script type="text/javascript" language="javascript" src="lib/DataTables-1.10.7/media/js/jquery.js"></script>

<link rel="stylesheet" type="text/css" href="lib/easyui/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="lib/easyui/themes/icon.css">
<link rel="stylesheet" type="text/css" href="lib/easyui/demo/demo.css">

<script type="text/javascript" src="lib/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="lib/easyui/kalender-easyui.js"></script>

<script type="text/javascript" language="javascript" src="lib/DataTables-1.10.7/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="lib/DataTables-1.10.7/extensions/Responsive/js/dataTables.responsive.js"></script>
<script type="text/javascript" language="javascript" src="lib/DataTables-1.10.7/examples/resources/syntax/shCore.js"></script>
<script type="text/javascript" language="javascript" src="lib/DataTables-1.10.7/examples/resources/demo.js"></script>

<script src="lib/js/valsix-serverside.js"></script>

<!-- ============================ -->
<script type="text/javascript" src="lib/easyui/breadcrum.js"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready( function () {
    <?
    if($reqBreadCrum == ""){}
    else
    {
    ?>
    setinfobreacrum("<?=$reqBreadCrum?>", "setBreacrum");
    <?
    }
    ?>

    // $("#clicktoggle").hide();
});

</script>

<link href="css/bluetabs.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/dropdowntabs.js"></script>

<!-- CORE CSS-->    
<link href="lib/materializetemplate/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="lib/materializetemplate/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<!-- CSS style Horizontal Nav-->    
<link href="lib/materializetemplate/css/layouts/style-horizontal.css" type="text/css" rel="stylesheet" media="screen,projection">
<!-- Custome CSS-->    
<link href="lib/materializetemplate/css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

<link rel="stylesheet" type="text/css" href="lib/DataTables-1.10.7/media/css/dataTables.materialize.css">
<?php /*?><link rel="stylesheet" type="text/css" href="lib/DataTables-1.10.7/media/css/dataTables.material.min.css"><?php */?>

<!-- =========================================== -->
<link rel="stylesheet" type="text/css" href="css/gaya-monitoring.css">

<link href="lib/treeTable2/doc/stylesheets/master.css" rel="stylesheet" type="text/css" />
<link href="lib/treeTable2/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />

<link href="lib/mbox/mbox.css" rel="stylesheet">
<script src="lib/mbox/mbox.js"></script>
<link href="lib/mbox/mbox-modif.css" rel="stylesheet">

</head>
<body>

    <div id="main">
        <!-- START WRAPPER -->
        <div class="wrapper">
            <!-- START CONTENT -->
            <section id="content-full">

                <!--breadcrumbs start-->
                <div id="breadcrumbs-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <!-- =========================================== -->
                                <ol class="breadcrumb right" id="setBreacrum"></ol>

                                <h5 class="breadcrumbs-title">Faktor Pengoreksi</h5>
                                <ol class="breadcrumbs">
                                  <li class="active">
                                    <input type="hidden" id="reqSatuanKerjaId" value="<?=$reqSatuanKerjaId?>" />
                                    <label id="reqLabelSatuanKerjaNama"><?=$reqSatuanKerjaNama?></label>
                                  </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!--breadcrumbs end-->

                <div id="bluemenu" class="bluetabs">
                    <ul>
                        <li>
                            <a id="btncetak" title="Cetak"><img src="images/icon-excel.png" /> Cetak</a>
                        </li>
                    </ul>
                </div>

                <div class="area-parameter">
                	<div class="kiri">
                	</div>

                	<div class="kanan">
                		<a href="#" id="btnCari" style="display:none" title="Cari">Cari</a>
                		<span>Cari :</span> <!---->
                		<input type="text" id="reqCariFilter" />
                		<button id="clicktoggle">Filter ▾</button>
                	</div>
                </div>

		        <div class="area-parameter no-marginbottom">

		          <div id="settoggle">
		            <div class="row">
		              <div class="col s3 m1">Status</div>
		              <div class="col s2 m1 select-semicolon">:</div>
		              <div class="col s3 m2">
		                <select class="option-vw9" id="reqStatusPegawaiId">
		                  <?
		                  for($i=0; $i < count($arrstatus); $i++)
		                  {
		                    $infoid= $arrstatus[$i]["value"];
		                    $infotext= $arrstatus[$i]["info"];
		                  ?>
		                    <option value="<?=$infoid?>" <? if($infoid == $reqStatusPegawaiId) echo "selected";?> ><?=$infotext?></option>
		                  <?
		                  }
		                  ?>
		                </select>
		              </div>

		              <input type="hidden" id="reqTahun" value="<?=$reqTahun?>" />
		              <div class="col s3 m2">Tipe Pegawai</div>
		              <div class="col s2 m1 select-semicolon">:</div>
		              <div class="col s3 m2">
		                <select class="option-vw9" id="reqTipePegawaiId">
		                  <?
		                  for($i=0; $i < count($arrtipepegawai); $i++)
		                  {
		                    $infoid= $arrtipepegawai[$i]["value"];
		                    $infotext= $arrtipepegawai[$i]["info"];
		                  ?>
		                    <option value="<?=$infoid?>" <? if($infoid == $reqTipePegawaiId) echo "selected";?> ><?=$infotext?></option>
		                  <?
		                  }
		                  ?>
		                </select>
		              </div>

		              <div class="col s3 m1">Eselon</div>
		              <div class="col s2 m1 select-semicolon">:</div>
		              <div class="col s3 m3">
		                <select class="option-vw3" id="reqEselonGroupId">
		                  <?
		                  for($i=0; $i < count($arreselon); $i++)
		                  {
		                    $infoid= $arreselon[$i]["value"];
		                    $infotext= $arreselon[$i]["info"];
		                  ?>
		                    <option value="<?=$infoid?>" <? if($infoid == $reqEselonGroupId) echo "selected";?> ><?=$infotext?></option>
		                  <?
		                  }
		                  ?>
		                </select>
		              </div>

		              <div class="col s12">
		                <table id="tt" class="easyui-treegrid" style="width:100%; height:250px">
		                  <thead>
		                    <tr>
		                      <th field="NAMA" width="90%">Nama</th>
		                    </tr>
		                  </thead>
		                </table>
		              </div>
		            </div>
		          </div>

		        </div>

                <!--start container-->
                <div class="container" style="clear:both;">
                    <div class="section" style="margin-top: -100px !important;">
                        <table id="example" class="display mdl-data-table dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <?php
                                    foreach($arrtabledata as $valkey => $valitem) 
                                    {
                                        echo "<th style='width:".$valitem["width"]."px; border:1px solid #d0d0d0'>".$valitem["label"]."</th>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--end container-->
            </section>
            <!-- END CONTENT -->
        </div>
        <!-- END WRAPPER -->

    </div>
    <!-- END MAIN -->

    <!-- kalau multicheck -->
    <input type="hidden" id="reqGlobalValidasiCheck" name="reqGlobalValidasiCheck" />
    <a href="#" id="btnCari" style="display:none" title="btnCari">triggercari</a>
    <a href="#" id="triggercari" style="display:none" title="triggercari">triggercari</a>

<!--materialize js-->
<script type="text/javascript" src="lib/materializetemplate/js/materialize.min.js"></script>

<style type="text/css">
	table.dataTable.display tbody td {
		vertical-align: top;
	}
</style>

<script type="text/javascript">
    getinforumpun= JSON.parse('<?=JSON_encode($inforumpun)?>');
    // console.log(getinforumpun);

    $(document).ready(function() {
      $('select').material_select();
    });

    function calltreeid(id, nama)
    {
      $("#reqLabelSatuanKerjaNama").text(nama);
      $("#reqSatuanKerjaId").val(id);
      setCariInfo();
    }

    $(function(){
      var tt = $('#tt').treegrid({
        url: 'satuan_kerja_json/treepilih',
        rownumbers: false,
        pagination: false,
        idField: 'ID',
        treeField: 'NAMA',
        onBeforeLoad: function(row,param){
          if (!row) {
            param.id = 0;
          }
        }
      });
    });

    var outer = document.getElementById('settoggle');
    document.getElementById('clicktoggle').addEventListener('click', function(evnt) {
    if (outer.style.maxHeight){
        outer.style.maxHeight = null;
        outer.classList.add('settoggle-closed');
      }
      else {
        outer.style.maxHeight = outer.scrollHeight + 'px';
        outer.classList.remove('settoggle-closed');
      }
    });

    outer.style.maxHeight = outer.scrollHeight + 'px';
    $('#clicktoggle').trigger('click');


    $('.materialize-textarea').trigger('autoresize');

    var datanewtable;
    var infotableid= "example";
    var carijenis= "";
    var arrdata= <?php echo json_encode($arrtabledata); ?>;
    var indexfieldid= arrdata.length - 1;
    var valinfoid= valinforowid='';
    var datainforesponsive= datainfofilter= datainfolengthchange=  "1";
    //
    var datainfoscrollx= 100;
    
    var datapagelength= 10;
    datalengthmenu= [[10, 25, 50, -1],[10, 25, 50, 'All'],];

    // kalau untuk detil row
    // var ajaxrowdetil= "1";
    // var vurlrowdetil= "json/talenta_json/jsondetil?reqMode=jabatanriwayat";

    // console.log(arrdata);
    // datainfostatesave= "1";
    // datastateduration= 60 * 2;

    // infobold= arrdata.length - 4;
    // infocolor= arrdata.length - 3;

    // kalau multicheck
    var infoglobalarrid= [];
    var arrChecked = [];
    reqUrutkan= reqUrutkanVal= "";

    infoscrolly= 50;

    $("#btncetak").on("click", function () {
      var reqGlobalValidasiCheck= reqCariFilter= reqSatuanKerjaId= reqStatusPegawaiId= reqStatusPegawaiId= reqStatusPegawaiId= "";
      // reqPencarian= $('#example_filter input').val();
      reqSatuanKerjaId= $("#reqSatuanKerjaId").val();
      reqCariFilter= $("#reqCariFilter").val();
      reqStatusPegawaiId= $("#reqStatusPegawaiId").val();
      reqTipePegawaiId= $("#reqTipePegawaiId").val();
      reqEselonGroupId= $("#reqEselonGroupId").val();

      newWindow = window.open("app/loadUrl/app/talenta_nilai_akhir_excel?reqBulan=<?=date('m')?>&reqTahun=<?=date('Y')?>&reqPencarian="+reqCariFilter+"&reqSatuanKerjaId="+reqSatuanKerjaId+"&reqStatusPegawaiId="+reqStatusPegawaiId+"&reqTipePegawaiId="+reqTipePegawaiId+"&reqEselonGroupId="+reqEselonGroupId, 'Cetak');
      newWindow.focus();
    });

    $("#btnEdit").on("click", function () {
      btnid= $(this).attr('id');
      reqGlobalValidasiCheck= $("#reqGlobalValidasiCheck").val();

      if(reqGlobalValidasiCheck == "" && btnid == "btnEdit")
      {
        $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
        return false;
      }

      window.parent.openPopup("app/loadUrl/app/nilai_rumpun_diklat_kursus_add/?reqId="+reqGlobalValidasiCheck);
    });

    $('#btnCari').on('click', function () {
      var reqGlobalValidasiCheck= reqCariFilter= reqSatuanKerjaId= reqStatusPegawaiId= reqStatusPegawaiId= reqStatusPegawaiId= "";
      // reqPencarian= $('#example_filter input').val();
      reqSatuanKerjaId= $("#reqSatuanKerjaId").val();
      reqCariFilter= $("#reqCariFilter").val();
      reqStatusPegawaiId= $("#reqStatusPegawaiId").val();
      reqTipePegawaiId= $("#reqTipePegawaiId").val();
      reqEselonGroupId= $("#reqEselonGroupId").val();

      jsonurl= "json/talenta_json/jsonnilaiakhir?reqPencarian="+reqCariFilter+"&reqSatuanKerjaId="+reqSatuanKerjaId+"&reqStatusPegawaiId="+reqStatusPegawaiId+"&reqTipePegawaiId="+reqTipePegawaiId+"&reqEselonGroupId="+reqEselonGroupId+"&reqGlobalValidasiCheck="+reqGlobalValidasiCheck;
      datanewtable.DataTable().ajax.url(jsonurl).load();
    });

    $("#reqStatusPegawaiId,#reqTipePegawaiId,#reqEselonGroupId").change(function() {
        setCariInfo();
        reloadglobalklikcheck();
    });

    $("#reqCariFilter").keyup(function(e) {
      var code = e.which
      if(code==13)
      {
        setCariInfo();
        reloadglobalklikcheck();
      }
    });

    $("#triggercari").on("click", function () {
        if(carijenis == "1")
        {
            // pencarian= $('#'+infotableid+'_filter input').val();
            pencarian= $("#reqCariFilter").val();
            // console.log(pencarian);
            datanewtable.DataTable().search( pencarian ).draw();
        }
        else
        {
            
        }
    });

    jQuery(document).ready(function() {
      var jsonurl= "json/talenta_json/jsonnilaiakhir";
        ajaxserverselectsingle.init(infotableid, jsonurl, arrdata);
    });

    function calltriggercari()
    {
        $(document).ready( function () {
          $("#triggercari").click();      
        });
    }

    function setCariInfo()
    {
      $(document).ready( function () {
        $("#btnCari").click();
      });
    }

    $(document).ready(function() {
        var table = $('#example').DataTable();

        $('#example tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                $(".rumpunklik").click(function(){
                  btnid= $(this).attr('id');
                  btnid= btnid.replace("rumpunklikid", "");
                  // console.log(btnid);

                  idcari= btnid;
                  vgetinforumpun= getinforumpun.filter(item => item.id === idcari);
                  // console.log(vgetinforumpun[0]["keterangan"]);

                  mbox.custom({
                    message: 'Apakah anda yakin mengurutkan rumpun '+vgetinforumpun[0]["keterangan"]+'?',
                    options: {}, // see Options below for options and defaults
                    buttons: [
                        {
                            label: 'Nilai tertinggi',
                            color: 'orange darken-2',
                            callback: function() {
                              mbox.close();

                              reqUrutkan= btnid;
                              reqUrutkanVal= "desc";
                              jsonurl= "json/talenta_json/jsonnilaiakhir?reqUrutkan="+reqUrutkan+"&reqUrutkanVal="+reqUrutkanVal;
                              datanewtable.DataTable().ajax.url(jsonurl).load();

                              // infodata= "Mengurutkan Nilai tertinggi.";
                              // mbox.alert(infodata, {open_speed: 500}, interval = window.setInterval(function() 
                              // {
                              //    clearInterval(interval);
                              //    mbox.close();
                              //    document.location.href= "app/loadUrl/app/pegawai_add_suami_istri_data/?reqId=<?=$reqId?>&reqRowId="+rowid;
                              // }, 1000));
                                // mbox.alert('Pumpkin is your favorite')
                            }
                        },
                        {
                            label: 'Nilai ter-rendah',
                            color: 'red darken-2',
                            callback: function() {
                              mbox.close();

                              reqUrutkan= btnid;
                              reqUrutkanVal= "asc";
                              jsonurl= "json/talenta_json/jsonnilaiakhir?reqUrutkan="+reqUrutkan+"&reqUrutkanVal="+reqUrutkanVal;
                              datanewtable.DataTable().ajax.url(jsonurl).load();
                                // mbox.alert('Apple is your favorite')
                            }
                        }
                    ]
                  })

                });

                var dataselected= datanewtable.DataTable().row(this).data();
                // console.log(dataselected);
                // console.log(Object.keys(dataselected).length);

                fieldinfoid= arrdata[indexfieldid]["field"];
                fieldinforowid= arrdata[parseFloat(indexfieldid) - 1]["field"];
                valinfoid= dataselected[fieldinfoid];
                valinforowid= dataselected[fieldinforowid];
                // console.log(valinfoid+"-"+valinforowid);
            }
        } );

        $('#'+infotableid+' tbody').on( 'dblclick', 'tr', function () {
            $("#btnEdit").click();
        });

        $('#button').click( function () {
            table.row('.selected').remove().draw( false );
        } );
    } );
</script>

</body>
</html>