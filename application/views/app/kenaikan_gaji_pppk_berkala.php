<?php
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

$CI =& get_instance();
$CI->checkUserLogin();

$this->load->model('Pangkat');

$reqAkses= $this->input->get("reqAkses");
$reqBreadCrum= $this->input->get("reqBreadCrum");

$reqTahun= date("Y");
$reqBulan= date("m");
// $reqBulan= "03";

$pangkat= new Pangkat();
$pangkat->selectByParams();

$tinggi = 156;
$reqSatuanKerjaNama= "Semua Satuan Kerja"
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
	<title>Diklat</title>
	<base href="<?=base_url()?>" />
	<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
    
    <link rel="stylesheet" href="lib/AdminLTE-2.4.0-rc/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="lib/AdminLTE-2.4.0-rc/dist/css/AdminLTE.min.css">
    <!--<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">-->

	<style type="text/css" media="screen">
		@import "lib/media/css/site_jui.css";
		@import "lib/media/css/demo_table_jui.css";
		@import "lib/media/css/themes/base/jquery-ui.css";
	</style>

	<link rel="stylesheet" type="text/css" href="lib/DataTables-1.10.7/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="lib/DataTables-1.10.7/extensions/Responsive/css/dataTables.responsive.css">
	<link rel="stylesheet" type="text/css" href="lib/DataTables-1.10.7/examples/resources/syntax/shCore.css">
	<link rel="stylesheet" type="text/css" href="lib/DataTables-1.10.7/examples/resources/demo.css">
	<style type="text/css" class="init">

		div.container { max-width: 100%;}
		
		.select-wrapper{width:8vw !important}
		
		.proseswarna { background-color:#feff03; }
		.selesaiwarna { background-color:#adff34; }
	</style>
	<script type="text/javascript" language="javascript" src="lib/DataTables-1.10.7/media/js/jquery.js"></script>

    <?php /*?><link rel="stylesheet" type="text/css" href="lib/easyui/themes/default/easyui.css">
	<script type="text/javascript" src="lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="lib/easyui/kalender-easyui.js"></script><?php */?>

	<link rel="stylesheet" type="text/css" href="lib/easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="lib/easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="lib/easyui/demo/demo.css">

	<script type="text/javascript" src="lib/easyui/jquery-easyui-1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="lib/easyui/jquery-easyui-1.4.2/jquery.easyui.min.js"></script>

	<script type="text/javascript" language="javascript" src="lib/DataTables-1.10.7/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="lib/DataTables-1.10.7/extensions/Responsive/js/dataTables.responsive.js"></script>
	<script type="text/javascript" language="javascript" src="lib/DataTables-1.10.7/examples/resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="lib/DataTables-1.10.7/examples/resources/demo.js"></script>
    
    <script type="text/javascript" src="lib/easyui/breadcrum.js"></script>
	<script type="text/javascript" charset="utf-8">
		var oTable;
		var tempindextab=0;
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

        var id = -1;//simulation of id
        $(window).resize(function() {
        	console.log($(window).height());
        	$('.dataTables_scrollBody').css('height', ($(window).height() - <?=$tinggi?>));
        });
        oTable = $('#example').dataTable({ bJQueryUI: true,"iDisplayLength": 25,
        	/* UNTUK MENGHIDE KOLOM ID */
        	"aoColumns": [ 		
			 null,
			 null,
			 null,
			 null,
			 null,
			 null,
			 null,
			 null
        	],
        	"lengthMenu": [[10, 25, 500, -1], [10, 25, 500, "All"]],
        	"bSort":false,
        	"bFilter": false,
        	"bLengthChange": false,
        	"bProcessing": true,
        	"bServerSide": true,
        	"sAjaxSource": "kenaikan_gaji_pppk_berkala_json/json?reqAkses=<?=$reqAkses?>&reqMode=proses&reqBulan=<?=$reqBulan?>&reqTahun=<?=$reqTahun?>",
        	"sScrollX": "100%",								  
        	"sScrollXInner": "100%",
        	"sPaginationType": "full_numbers",
			"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
				var valueStyle= loopIndex= "";
				valueStyle= nRow % 2;
				//proseswarna;selesaiwarna
				//alert(nRow+"--"+iDisplayIndex);
				
				if( aData[8] == '2')
				{
					$($(nRow).children()).attr('class', 'proseswarna');
				}
				else if( aData[8] == '3')
				{
					$($(nRow).children()).attr('class', 'selesaiwarna');
				}
				//return nRow;
			},
			"fnDrawCallback": function( oSettings ) {
				setInfoTotal();
			}
        });
        /* Click event handler */

        /* RIGHT CLICK EVENT */
        var anSelectedData = '';
        var anSelectedId = anSelectedStatusId= '';
        var anSelectedDownload = '';
        var anSelectedPosition = '';	

        function fnGetSelected( oTableLocal )
        {
        	var aReturn = new Array();
        	var aTrs = oTableLocal.fnGetNodes();
        	for ( var i=0 ; i<aTrs.length ; i++ )
        	{
        		if ( $(aTrs[i]).hasClass('row_selected') )
        		{
        			aReturn.push( aTrs[i] );
        			anSelectedPosition = i;
        		}
        	}
        	return aReturn;
        }

        $("#example tbody").click(function(event) {
        	$(oTable.fnSettings().aoData).each(function (){
        		$(this.nTr).removeClass('row_selected');
        	});
        	$(event.target.parentNode).addClass('row_selected');
					  //
					  var anSelected = fnGetSelected(oTable);													
					  anSelectedData = String(oTable.fnGetData(anSelected[0]));
					  var element = anSelectedData.split(','); 
					  anSelectedId = element[element.length-1];
					  anSelectedStatusId = element[element.length-3];
					});
		
		$('#example tbody').on( 'dblclick', 'tr', function () {
			$("#btnEdit").click();	
		});
		
		$('#btnAdd').on('click', function () {
			var reqBulan= reqTahun= "";
			reqBulan= $("#reqBulan").val();
			reqTahun= $("#reqTahun").val();
			
			newWindow = window.open("app/loadUrl/persuratan/surat_keluar_teknis_add?reqTipe=1&reqJenis=14&reqBulan="+reqBulan+"&reqTahun="+reqTahun, 'Cetak'+Math.floor(Math.random()*999999));
			newWindow.focus();
			tempindextab= parseInt(tempindextab) + 1;
			//window.parent.createWindowMaxFull("app/loadUrl/app/pegawai_add");
			
			// tutup flex dropdown => untuk versi mobile
			$('div.flexmenumobile').hide()
			$('div.flexoverlay').css('display', 'none')
		
		});
		
		$('#btnEdit').on('click', function () {
			if(anSelectedData == "")
        		return false;
			aksi(anSelectedId);
		});
		
        $('#btnProses').on('click', function () {
        	setCariInfo();
		 //    var reqJenisKgb= reqSatuanKerjaId= reqCariFilter= reqStatusKgb= reqPangkatId= reqBulan= reqTahun= "";
			// reqSatuanKerjaId= $("#reqSatuanKerjaId").val();
			// reqCariFilter= $("#reqCariFilter").val();
			// reqStatusKgb= $("#reqStatusKgb").val();
			// reqJenisKgb= $("#reqJenisKgb").val();
			// //reqPangkatId= $("#reqPangkatId").val();
			// reqBulan= $("#reqBulan").val();
			// reqTahun= $("#reqTahun").val();
		  
		 //  oTable.fnReloadAjax("kenaikan_gaji_pppk_berkala_json/json?reqMode=proses&reqSatuanKerjaId="+reqSatuanKerjaId+"&reqStatusKgb="+reqStatusKgb+"&reqPangkatId="+reqPangkatId+"&reqBulan="+reqBulan+"&reqTahun="+reqTahun+"&sSearch="+reqCariFilter);

		  // tutup flex dropdown => untuk versi mobile
		  //$('div.flexmenumobile').hide()
		  //$('div.flexoverlay').css('display', 'none')
		});

		$("#btnCari").on("click", function () {
			var reqJenisKgb= reqSatuanKerjaId= reqCariFilter= reqStatusKgb= reqPangkatId= reqBulan= reqTahun= "";
			reqSatuanKerjaId= $("#reqSatuanKerjaId").val();
			reqCariFilter= $("#reqCariFilter").val();
			reqStatusKgb= $("#reqStatusKgb").val();
			reqJenisKgb= $("#reqJenisKgb").val();
			//reqPangkatId= $("#reqPangkatId").val();
			reqBulan= $("#reqBulan").val();
			reqTahun= $("#reqTahun").val();
			
			oTable.fnReloadAjax("kenaikan_gaji_pppk_berkala_json/json?reqAkses=<?=$reqAkses?>&reqMode=proses&reqSatuanKerjaId="+reqSatuanKerjaId+"&reqStatusKgb="+reqStatusKgb+"&reqJenisKgb="+reqJenisKgb+"&reqPangkatId="+reqPangkatId+"&reqBulan="+reqBulan+"&reqTahun="+reqTahun+"&sSearch="+reqCariFilter);
		});
		  
		$('#btnKgbLengkapRowPersonal').on('click', function () {
			  reqJenisKgb= $("#reqJenisKgb").val();
			  reqBulan= $("#reqBulan").val();
			  reqTahun= $("#reqTahun").val();

			  var url= 'template?reqJenis=1&reqBulan='+reqBulan+'&reqTahun='+reqTahun+'&reqJenisKgb='+reqJenisKgb+'&reqPegawaiId='+anSelectedId+'&reqLink=kenaikan_gaji_pppk_berkala_cetak_sk_pdf';

			  newWindow = window.open("app/loadUrl/report/"+url, 'Cetak');
			  newWindow.focus();
		});

		$('#btnKgbLengkapRowKolektif').on('click', function () {
			  reqSatuanKerjaId= $("#reqSatuanKerjaId").val();
			  reqJenisKgb= $("#reqJenisKgb").val();
			  reqBulan= $("#reqBulan").val();
			  reqTahun= $("#reqTahun").val();

			  var url= "template?reqSatuanKerjaId="+reqSatuanKerjaId+"&reqJenis=1&reqBulan="+ reqBulan + '&reqTahun=' + reqTahun+'&reqJenisKgb='+reqJenisKgb+'&reqLink=kenaikan_gaji_pppk_berkala_cetak_sk_pdf';		

			  newWindow = window.open("app/loadUrl/report/"+url, 'Cetak');
			  newWindow.focus();	
		});

		$('#btnKgbTandaTerima').on('click', function () {	
			  reqSatuanKerjaId= $("#reqSatuanKerjaId").val();
			  reqJenisKgb= $("#reqJenisKgb").val();
			  reqBulan= $("#reqBulan").val();
			  reqTahun= $("#reqTahun").val();	

			  var url= "kenaikan_gaji_pppk_berkala_cetak_tanda_terima?reqSatuanKerjaId="+reqSatuanKerjaId+"&reqBulan="+reqBulan+'&reqTahun=' + reqTahun+'&reqJenisKgb='+reqJenisKgb;	

			  newWindow = window.open("app/loadUrl/app/"+url, 'Cetak');
			  newWindow.focus();	
		});
		
		$("#reqStatusKgb,#reqJenisKgb").change(function() { 
			var reqJenisKgb= reqSatuanKerjaId= reqCariFilter= reqStatusKgb= reqPangkatId= reqBulan= reqTahun= "";
			reqSatuanKerjaId= $("#reqSatuanKerjaId").val();
			reqCariFilter= $("#reqCariFilter").val();
			reqStatusKgb= $("#reqStatusKgb").val();
			reqJenisKgb= $("#reqJenisKgb").val();
			//reqPangkatId= $("#reqPangkatId").val();
			reqBulan= $("#reqBulan").val();
			reqTahun= $("#reqTahun").val();
			
			oTable.fnReloadAjax("kenaikan_gaji_pppk_berkala_json/json?reqAkses=<?=$reqAkses?>&reqMode=&reqSatuanKerjaId="+reqSatuanKerjaId+"&reqStatusKgb="+reqStatusKgb+"&reqJenisKgb="+reqJenisKgb+"&reqPangkatId="+reqPangkatId+"&reqBulan="+reqBulan+"&reqTahun="+reqTahun+"&sSearch="+reqCariFilter);
		});
		
		$("#reqBulan,#reqTahun").change(function() { 
			setCariInfo();
		});
		  
		$("#reqCariFilter").keyup(function(e) {
			var code = e.which;
			if(code==13)
			{
				setCariInfo();
			}
		});
		
		$('#btnDelete').on('click', function () {
        	if(anSelectedData == "")
        		return false;	
        	$.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        		if (r){
        			$.getJSON("pegawai_json/delete/?reqId="+anSelectedId,
        				function(data){
        					$.messager.alert('Info', data.PESAN, 'info');
        					oTable.fnReloadAjax("pegawai_json/json");
        				});

        		}
        	});	
        });

        $('#btnLog').on('click', function () {
        	window.parent.openPopup("app/loadUrl/app/pegawai_log");

        	// tutup flex dropdown => untuk versi mobile
        	$('div.flexmenumobile').hide()
        	$('div.flexoverlay').css('display', 'none')
        });

    });

function selesai(pegawaiid)
{
	var reqBulan= reqTahun= "";
	reqBulan= $("#reqBulan").val();
	reqTahun= $("#reqTahun").val();
			
	$.ajax({'url': "kenaikan_gaji_pppk_berkala_json/getstatushitungulang/?reqPegawaiId="+pegawaiid+"&reqBulan="+reqBulan+"&reqTahun="+reqTahun,'success': function(dataJson) {
		var data= JSON.parse(dataJson);
		reqStatusHitungUlang= data.reqStatusHitungUlang;
		
		if(reqStatusHitungUlang == "1")
		{
			mbox.alert("ada revisi pada dasar KGB, klik form Detil untuk proses lebih lanjut", {open_speed: 0});
		}
		else
		{
			info= "Apakah yakin untuk menyimpan data, jadi selesai ?";
			mbox.custom({
			   message: info,
			   options: {close_speed: 100},
			   buttons: [
				   {
					   label: 'Ya',
					   color: 'green darken-2',
					   callback: function() {
						    $.ajax({'url': "kenaikan_gaji_pppk_berkala_json/addshortcut/?reqMode=updateselesai&reqStatusKgb=3&reqPegawaiId="+pegawaiid+"&reqBulan="+reqBulan+"&reqTahun="+reqTahun,'success': function(dataJson) {
								//var data= JSON.parse(dataJson);
								mbox.alert(dataJson, {open_speed: 0});
								setCariInfo();
								mbox.close();
							}});
					   }
				   },
				   {
					   label: 'Tidak',
					   color: 'grey darken-2',
					   callback: function() {
						   //console.log('do action for no answer');
						   mbox.close();
					   }
				   }
			   ]
			});
			
		}
	}});
	
}

function batal(pegawaiid)
{
	info= "Apakah anda yakin batal?";
	mbox.custom({
	   message: info,
	   options: {close_speed: 100},
	   buttons: [
		   {
			   label: 'Ya',
			   color: 'green darken-2',
			   callback: function() {
					var reqBulan= reqTahun= "";
					reqBulan= $("#reqBulan").val();
					reqTahun= $("#reqTahun").val();
					
					$.ajax({'url': "kenaikan_gaji_pppk_berkala_json/batal/?reqPegawaiId="+pegawaiid+"&reqBulan="+reqBulan+"&reqTahun="+reqTahun,'success': function(datahtml) {
						mbox.close();
						setCariInfo();
					}});
			   }
		   },
		   {
			   label: 'Tidak',
			   color: 'grey darken-2',
			   callback: function() {
				   //console.log('do action for no answer');
				   mbox.close();
			   }
		   }
	   ]
	});
	
}
					   
function aksi(pegawaiid)
{
	var reqBulan= reqTahun= "";
	reqBulan= $("#reqBulan").val();
	reqTahun= $("#reqTahun").val();
	
	newWindow = window.open("app/loadUrl/app/kenaikan_gaji_pppk_berkala_add?reqPegawaiId="+pegawaiid+"&reqBulan="+reqBulan+"&reqTahun="+reqTahun, 'Cetak'+Math.floor(Math.random()*999999));
	newWindow.focus();
	tempindextab= parseInt(tempindextab) + 1;
	//window.parent.createWindowMaxFull("app/loadUrl/app/pegawai_add");
}

function setInfoTotal()
{
	var reqJenisKgb= reqSatuanKerjaId= reqCariFilter= reqStatusKgb= reqPangkatId= reqBulan= reqTahun= "";
	reqSatuanKerjaId= $("#reqSatuanKerjaId").val();
	reqCariFilter= $("#reqCariFilter").val();
	reqStatusKgb= $("#reqStatusKgb").val();
	reqJenisKgb= $("#reqJenisKgb").val();
	//reqPangkatId= $("#reqPangkatId").val();
	reqBulan= $("#reqBulan").val();
	reqTahun= $("#reqTahun").val();
			// reqJenisKgb
	$.ajax({'url': "kenaikan_gaji_pppk_berkala_json/getinfototal/?reqSatuanKerjaId="+reqSatuanKerjaId+"&reqBulan="+reqBulan+"&reqTahun="+reqTahun,'success': function(dataJson) {
		var data= JSON.parse(dataJson);
		jumlah_data_kgb= data.jumlah_data_kgb;
		jumlah_data_kgb_proses= data.jumlah_data_kgb_proses;
		jumlah_data_kgb_selesai= data.jumlah_data_kgb_selesai;
		jumlah_data_kgb_hukuman= data.jumlah_data_kgb_hukuman;
		
		$("#jumlah_data_kgb").text(jumlah_data_kgb);
		$("#jumlah_data_kgb_proses").text(jumlah_data_kgb_proses);
		$("#jumlah_data_kgb_selesai").text(jumlah_data_kgb_selesai);
		$("#jumlah_data_kgb_hukuman").text(jumlah_data_kgb_hukuman);
	}});
}

var tempinfodetilpencarian="0";
function showIconCari()
{	
	if(tempinfodetilpencarian == "0")
	{
		$("#tabpencarian").show();
		tempinfodetilpencarian= 1;
	}
	else
	{
		$("#tabpencarian").hide();
		tempinfodetilpencarian= 0;
	}
}

function setCariInfo()
{
	$(document).ready( function () {
		$("#btnCari").click();			
	});
}
	
function calltreeid(id, nama)
{
	$("#reqLabelSatuanKerjaNama").text(nama);
	$("#reqSatuanKerjaId").val(id);
	setCariInfo();
}
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

<link rel="stylesheet" type="text/css" href="css/gaya-monitoring.css">

<link href="lib/treeTable2/doc/stylesheets/master.css" rel="stylesheet" type="text/css" />
<link href="lib/treeTable2/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />

<link href="lib/mbox/mbox.css" rel="stylesheet">
<script src="lib/mbox/mbox.js"></script>
<link href="lib/mbox/mbox-modif.css" rel="stylesheet">

  
<!--<link href="css/normalize.css" rel="stylesheet" type="text/css" />-->
</head>
<body>
	<!-- START MAIN -->
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
                            
                            <ol class="breadcrumb right" id="setBreacrum"></ol>
                            
							<h5 class="breadcrumbs-title">Kenaikan Gaji Berkala</h5>
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
                
                <div class="container">
                    <div class="row">
                        <div class="col s12 m3">
                          <div class="info-box">
                            <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
                            <div class="info-box-content">
                              <span class="info-box-text">Jumlah KGB</span>
                              <span class="info-box-number"><label id="jumlah_data_kgb"></label></span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                        
                        <div class="col s12 m3">
                          <div class="info-box">
                            <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
                            <div class="info-box-content">
                              <span class="info-box-text">Proses</span>
                              <span class="info-box-number"><label id="jumlah_data_kgb_proses"></label></span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
            
                        <div class="col s12 m3">
                          <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>
                            <div class="info-box-content">
                              <span class="info-box-text">Selesai</span>
                              <span class="info-box-number"><label id="jumlah_data_kgb_selesai"></label></span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                        
                        <div class="col s12 m3">
                          <div class="info-box">
                            <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>
                
                            <div class="info-box-content">
                              <span class="info-box-text">Hukuman Disiplin</span>
                              <span class="info-box-number"><label id="jumlah_data_kgb_hukuman"></label></span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                      </div>
                </div>
                
                <div id="bluemenu" class="bluetabs">
                    <ul>
                        <li>
                            <a href="#" id="btnCari" style="display:none" title="Cari">Cari</a>
                            <?
                            if($reqAkses == "R"){}
                            else
                            {
                            ?>
                            <a href="#" id="btnEdit" style="display:none" title="Edit">Edit</a>
                            <a id="btnAdd" title="Atur Nomor dan Tanggal KGB"><img src="images/icon-edit.png" /> Atur Nomor dan Tanggal KGB</a>
                            <a title="Cetak" rel="dropmenu2_b"><img src="images/icon-cetak.png" /> Cetak</a>
                            <?
                        	}
                            ?>
                        </li>
                    </ul>
		            <div id="dropmenu2_b" class="dropmenudiv_b" style="width: 250px; margin-top: -15px; margin-left: -25px">
					    <a title="Cetak SK KGB Personal" id="btnKgbLengkapRowPersonal">Cetak SK KGB Personal</a>
					    <a title="Cetak SK KGB Kolektif" id="btnKgbLengkapRowKolektif">Cetak SK KGB Kolektif</a>
					    <a title="Cetak Tanda Terima" id="btnKgbTandaTerima">Cetak Tanda Terima</a>
		            </div>

					<script type="text/javascript">
						tabdropdown.init("bluemenu")
					</script>
                </div>

				<div class="area-parameter">
                	<div class="kiri">
                       <span style="padding-left:5px">Status</span>
                       <select id='reqStatusKgb'>
                       		<option value=''>Semua</option>
                            <option value='2'>Dalam Proses</option>
                            <option value='3'>Selesai</option>
                            <option value='99'>Belum Diproses</option>
                       </select>
                       <span style="padding-left:5px">Periode</span>
                       <select id='reqBulan'>
                            <option value='01' <? if($reqBulan == "01") echo 'selected';?>>Januari</option>
                            <option value='02' <? if($reqBulan == "02") echo 'selected';?>>Februari</option>
                            <option value='03' <? if($reqBulan == "03") echo 'selected';?>>Maret</option>
                            <option value='04' <? if($reqBulan == "04") echo 'selected';?>>April</option>
                            <option value='05' <? if($reqBulan == "05") echo 'selected';?>>Mei</option>
                            <option value='06' <? if($reqBulan == "06") echo 'selected';?>>Juni</option>
                            <option value='07' <? if($reqBulan == "07") echo 'selected';?>>Juli</option>
                            <option value='08' <? if($reqBulan == "08") echo 'selected';?>>Agustus</option>
                            <option value='09' <? if($reqBulan == "09") echo 'selected';?>>September</option>
                            <option value='10' <? if($reqBulan == "10") echo 'selected';?>>Oktober</option>
                            <option value='11' <? if($reqBulan == "11") echo 'selected';?>>November</option>
                            <option value='12' <? if($reqBulan == "12") echo 'selected';?>>Desember</option>
                       </select> 
                       <select id='reqTahun'>
                            <?
                                for($i=date("Y")-8; $i<=date("Y")+2; $i++)
                                {
                            ?>
                                <option value="<?=$i?>" <? if($reqTahun == $i) echo 'selected';?>><?=$i?></option>
                            <?
                                }
                            ?>
                       </select>
                       <span style="padding-left:5px">Jenis Kgb</span>
                       <select id='reqJenisKgb'>
                       		<option value=''>Semua</option>
                            <option value='1'>Normal</option>
                            <!-- <option value='2'>CPNS</option> -->
                            <option value='3'>Mundur</option>
                            <option value='4'>Penundaan</option>
                       </select>
   
                    </div>
					<div class="kanan">
						<span>Search :</span>
						<input type="text" id="reqCariFilter" />
						<button id="clicktoggle">Filter ▾</button>
					</div>
				</div>

				<div class="area-parameter no-marginbottom">

					<div id="settoggle">
						<div class="row">
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
					<div class="section">
						<table id="example" class="display mdl-data-table dt-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
                                	<th>NIP</th>
                                    <th>Nama</th>
                                    <th>Gol</th>
                                    <th>TMT Lama<br/>MK Lama<br/>Gapok Lama</th>
                                    <th>TMT Baru<br/>MK Baru<br/>Gapok Baru</th>
                                    <th>Jenis KGB</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
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

	<script src="lib/AdminLTE-2.4.0-rc/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!--materialize js-->
    <script type="text/javascript" src="lib/materializetemplate/js/my-materialize.min.js"></script>

    <style type="text/css">
        #my-modal{
            height: 100%;
        }

        .modal-content{
            height: 88%;
        }

        #judul-modal{
            font-size: 14pt;
        }

        .judul{
            padding: 15px;
        }

    </style>

	<script type="text/javascript">
		function openModal(url){
            $('.modal-place').html('<div id="my-modal" class="modal"><div class="judul"><span id="judul-modal">SIMPEG KABUPATEN JOMBANG</span><a class="modal-action modal-close grey-text right" title="Keluar"><i class="mdi-navigation-close"></i></a></div><div class="modal-content"><iframe src="'+url+'" id="m-iframe" width="100%" height="100%" frameBorder="1"></iframe></div></div>')
            $('#my-modal').openModal();
        }

        function closeModal(){
            $('#my-modal').closeModal();
        }

        function cetakpengantartipejabatan(id, idttd, jenisid, tipeid, jabatanpilihan, jabatanmanual)
        {
        	reqJenis= "";
        	if(jenisid == "kgb1")
        	{
        		reqJenis= "1";
        	}

            reqJabatanManual= "";
            if(jabatanmanual == ""){}
            else
            {
                if(tipeid == "3"){}
                else
                {
                    tipeid= 2;
                    reqJabatanManual= jabatanmanual;
                }
            }
            
            var url= 'template?reqJenis='+reqJenis+'&reqBulan='+$("#reqBulan").val()+'&reqTahun='+$("#reqTahun").val()+'&reqPegawaiId='+id+'&reqPegawaiPilihKepalaId='+idttd+"&reqTipeId="+tipeid+"&reqJabatanPilihan="+jabatanpilihan+"&reqJabatanManual="+reqJabatanManual+'&reqLink=kenaikan_gaji_pppk_berkala_cetak_sk_pdf';
            newWindow = window.open("app/loadUrl/report/"+url, 'Cetak');
            newWindow.focus();
        }

		$(document).ready(function() {
			$('select').material_select();
		});

		$('.materialize-textarea').trigger('autoresize');
		
		$(function(){
			var tt = $('#tt').treegrid({
				url: 'satuan_kerja_json/treepilih',
				rownumbers: false,
				pagination: false,
				idField: 'ID',
				treeField: 'NAMA',
				onBeforeLoad: function(row,param){
					if (!row) { // load top level rows
					param.id = 0; // set id=0, indicate to load new page rows
					}
				}
			});
		});
		
		var outer = document.getElementById('settoggle');
		document.getElementById('clicktoggle').addEventListener('click', function(evnt) {
		if (outer.style.maxHeight){
				//alert('a');
				outer.style.maxHeight = null;
				outer.classList.add('settoggle-closed');
			} 
			else {
				//alert('b');
				outer.style.maxHeight = outer.scrollHeight + 'px';
				outer.classList.remove('settoggle-closed');  
			}
		});

		outer.style.maxHeight = outer.scrollHeight + 'px';
		$('#clicktoggle').trigger('click');
	</script>

	<div class="modal-place"></div>
    
    <link rel="stylesheet" href="lib/AdminLTE-2.4.0-rc/bower_components/bootstrap/dist/css/bootstrap_menu.css">
</body>
</html>