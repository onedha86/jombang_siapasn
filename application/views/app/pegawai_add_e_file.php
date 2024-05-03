<?
$this->load->model('JenisDokumen');
$this->load->model('KualitasFile');
$this->load->model('PegawaiFile');
$this->load->library('globalfilepegawai');

$CI =& get_instance();
$CI->checkUserLogin();

$tempUserLoginLevel= $this->LOGIN_LEVEL;

$arrData= array("No", "Nama File", "Jenis/Judul Dokumen", "Status", "Aksi");
$ck = $this->input->get("ck");
$reqId = $this->input->get("reqId");
$reqKategoriFileId= $this->input->get("reqKategoriFileId");
$reqKualitasFileId= $this->input->get("reqKualitasFileId");
$reqRiwayatTable= $this->input->get("reqRiwayatTable");
$reqRiwayatId= $this->input->get("reqRiwayatId");
$reqRiwayatField= $this->input->get("reqRiwayatField");
$reqJenisDokumen= $this->input->get("reqJenisDokumen");
$CI->checkpegawai($reqId);
$tempUserLoginId= $this->USER_LOGIN_ID;
$tempMenuId= "0112";
$tempAksesMenu= $CI->checkmenupegawai($tempUserLoginId, $tempMenuId);

if($reqJenisDokumen == "-1"){}
else
$reqJenisDokumen= $reqRiwayatTable.";".$reqRiwayatId.";".$reqRiwayatField;

$lokasi_link_file= "uploads/".$reqId."/";
$ambil_data_file= lihatfiledirektori($lokasi_link_file);
// print_r($ambil_data_file);exit;

// $needle= "KARPEG_196808052001121003_lama.pdf";
// echo setfiledeleteinfolder($lokasi_link_file, $needle);exit();

//print_r($ambil_data_file);exit;
//echo pathinfo($ambil_data_file[0], PATHINFO_BASENAME);exit;

$arrPegawaiDokumen= [];
$index_data= 0;

if($reqKategoriFileId == ""){}
else
{
	$statement.= " AND A.KATEGORI_FILE_ID = ".$reqKategoriFileId;
}

if($tempUserLoginLevel == "99"){}
else
$statement.= " AND COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL";

// untuk kondisi file
$vfpeg= new globalfilepegawai();
$arrgetinfofile= $vfpeg->getinfofile($reqId, $statementriwayattable);
if($ck == "infofile")
{
	print_r($arrgetinfofile);exit;
}

$set_detil= new PegawaiFile();
$set_detil->selectByParamsFile(array(), -1,-1, $statement, $reqId, "ORDER BY A.PATH_ASLI");
if($ck == "qfile")
{
	echo $set_detil->query;exit;
}
while($set_detil->nextRow())
{
	//NO_URUT, PEGAWAI_ID, RIWAYAT_TABLE, RIWAYAT_FIELD, RIWAYAT_ID, INFO_DATA
	//$arrPegawaiDokumen[$index_data]["ROWID"] = $set_detil->getField("RIWAYAT_TABLE").";".$set_detil->getField("RIWAYAT_ID").";".$set_detil->getField("RIWAYAT_FIELD");

	$infopath= $set_detil->getField("PATH");

	$arrPegawaiDokumen[$index_data]["PEGAWAI_FILE_ID"] = $set_detil->getField("PEGAWAI_FILE_ID");
	$arrPegawaiDokumen[$index_data]["ROWID"] = $infopath;
	$arrPegawaiDokumen[$index_data]["JENIS_DOKUMEN"] = $set_detil->getField("RIWAYAT_TABLE").";".$set_detil->getField("RIWAYAT_ID").";".$set_detil->getField("RIWAYAT_FIELD");
	$arrPegawaiDokumen[$index_data]["FILE_KUALITAS_ID"] = $set_detil->getField("FILE_KUALITAS_ID");
	$arrPegawaiDokumen[$index_data]["FILE_KUALITAS_NAMA"] = $set_detil->getField("FILE_KUALITAS_NAMA");
	$arrPegawaiDokumen[$index_data]["PEGAWAI_ID"] = $set_detil->getField("PEGAWAI_ID");
	$arrPegawaiDokumen[$index_data]["RIWAYAT_TABLE"] = $set_detil->getField("RIWAYAT_TABLE");
	$arrPegawaiDokumen[$index_data]["RIWAYAT_FIELD"] = $set_detil->getField("RIWAYAT_FIELD");
	$arrPegawaiDokumen[$index_data]["RIWAYAT_ID"] = $set_detil->getField("RIWAYAT_ID");
	$arrPegawaiDokumen[$index_data]["INFO_DATA"] = $set_detil->getField("INFO_DATA");
	$arrPegawaiDokumen[$index_data]["KATEGORI_FILE_ID"] = $set_detil->getField("KATEGORI_FILE_ID");
	$arrPegawaiDokumen[$index_data]["STATUS"] = $set_detil->getField("STATUS");
	$arrPegawaiDokumen[$index_data]["TEMP_VALIDASI_BELUM_ID"] = $set_detil->getField("TEMP_VALIDASI_BELUM_ID");

	$vinfogroupdata= "";
	$vpidrow= $set_detil->getField("P_ID_ROW");
	$arrcheckgetinfofile= in_array_column($vpidrow, "ID_ROW", $arrgetinfofile);
	// print_r($arrcheckgetinfofile);exit;
	if(!empty($arrcheckgetinfofile))
	{
		$indexcheckgetinfofile= $arrcheckgetinfofile[0];
		$vinfogroupdata= $arrgetinfofile[$indexcheckgetinfofile]["NAMA_ROW"];
		// $vinfogroupdata
	}
	// $arrPegawaiDokumen[$index_data]["INFO_GROUP_DATA"] = $set_detil->getField("INFO_GROUP_DATA");
	$arrPegawaiDokumen[$index_data]["INFO_GROUP_DATA"] = $vinfogroupdata;

	$infopathasli= $set_detil->getField("PATH_ASLI");
	if(empty($infopathasli))
	{
		$infopathasli= str_replace($lokasi_link_file, "", $infopath);
	}
	$arrPegawaiDokumen[$index_data]["PATH_ASLI"]= $infopathasli;

	$arrPegawaiDokumen[$index_data]["EXT"] = $set_detil->getField("EXT");

	// $infopath= "uploads/8300/46hs7V4zec.jpg";
	$sortindexcari= array_search($infopath,$ambil_data_file,true);
	// echo $sortindexcari;exit;
	if($sortindexcari > 0)
	{
		$sortindexdata= $ambil_data_file[$index_data];
		$ambil_data_file[$index_data]= $infopath;
		$ambil_data_file[$sortindexcari]= $sortindexdata;
	}

	$index_data++;
}
unset($set_detil);
$jumlah_pegawai_dokumen= $index_data;
// print_r($arrPegawaiDokumen);exit;
// print_r($ambil_data_file);exit;

$arrKategoriDokumen= [];
$index_data= 0;
$set_detil= new PegawaiFile();
$set_detil->selectByParamsKategoriDokumen();
//echo $set_detil->query;exit;
while($set_detil->nextRow())
{
	$arrKategoriDokumen[$index_data]["KATEGORI_FILE_ID"] = $set_detil->getField("KATEGORI_FILE_ID");
	$arrKategoriDokumen[$index_data]["NAMA"] = $set_detil->getField("NAMA");
	$index_data++;
}
unset($set_detil);
$jumlah_kategori_dokumen= $index_data;

if($reqKategoriFileId == ""){}
else
{
	$arrJenisDokumen= [];
	$index_data= 0;
	$statement= " AND A.PEGAWAI_ID = ".$reqId." AND NO_URUT = ".$reqKategoriFileId;
	$set_detil= new PegawaiFile();
	$set_detil->selectByParamsJenisDokumen(array(), -1,-1, $statement);
	//echo $set_detil->query;exit;
	while($set_detil->nextRow())
	{
		//NO_URUT, PEGAWAI_ID, RIWAYAT_TABLE, RIWAYAT_FIELD, RIWAYAT_ID, INFO_DATA
		$arrJenisDokumen[$index_data]["NO_URUT"] = $set_detil->getField("NO_URUT");
		$arrJenisDokumen[$index_data]["PEGAWAI_ID"] = $set_detil->getField("PEGAWAI_ID");
		$arrJenisDokumen[$index_data]["RIWAYAT_TABLE"] = $set_detil->getField("RIWAYAT_TABLE");
		$arrJenisDokumen[$index_data]["RIWAYAT_FIELD"] = $set_detil->getField("RIWAYAT_FIELD");
		$arrJenisDokumen[$index_data]["RIWAYAT_ID"] = $set_detil->getField("RIWAYAT_ID");
		$arrJenisDokumen[$index_data]["INFO_DATA"] = $set_detil->getField("INFO_DATA");
		$arrJenisDokumen[$index_data]["INFO_GROUP_DATA"] = $set_detil->getField("INFO_GROUP_DATA");
		$index_data++;
	}
	unset($set_detil);
	$jumlah_jenis_dokumen= $index_data;
}

$kualitas= new KualitasFile();
$kualitas->selectByParams(array());
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

	<!-- <link rel="stylesheet" type="text/css" href="css/gaya.css"> -->

	<link rel="stylesheet" type="text/css" href="lib/easyui/themes/default/easyui.css">
	<script type="text/javascript" src="lib/easyui/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="lib/easyui/jquery.easyui.min.js"></script>

	<!-- CORE CSS-->    
	<link href="lib/materializetemplate/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
	<link href="lib/materializetemplate/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
	<!-- CSS style Horizontal Nav-->    
	<link href="lib/materializetemplate/css/layouts/style-horizontal.css" type="text/css" rel="stylesheet" media="screen,projection">
	<!-- Custome CSS-->    
	<link href="lib/materializetemplate/css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

	<link rel="stylesheet" type="text/css" href="lib/dropzone/dropzone.css">
	<link rel="stylesheet" type="text/css" href="lib/dropzone/basic.css">
	<script src="lib/dropzone/dropzone.js"></script>

	<style type="text/css">
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			table.tabel-responsif thead th{ display:none; }
      /*
      Label the data
      */
      <?
	  $arrData= array("No", "Nama File", "Jenis", "Kualitas", "Status", "Aksi");

      for($i=0; $i < count($arrData); $i++)
      {
      	$index= $i+1;
      	?>
      	table.tabel-responsif td:nth-of-type(<?=$index?>):before { content: "<?=$arrData[$i]?>"; }
      	<?
      }
      ?>
  }

  .round {
  	border-radius: 50%;
  	padding: 5px;
  }
</style>

<script type="text/javascript">
	$(function(){
		$("#reqKategoriFileId, #reqJenisDokumen, #reqKualitasFileId").change(function(){
			setreloaddokumen();
		});
	});
	
	function setreloaddokumen()
	{
		var reqKategoriFileId= reqKualitasFileId= reqJenisDokumen= reqRiwayatTable= reqRiwayatField= reqRiwayatId= "";
		reqKategoriFileId= $("#reqKategoriFileId").val();
		reqKualitasFileId= $("#reqKualitasFileId").val();
		reqJenisDokumen= $("#reqJenisDokumen").val();
		//alert(reqJenisDokumen);//return false;
		
		if(reqKategoriFileId == ""){}
		else
		{
			if(reqJenisDokumen == "-1")
			reqJenisDokumen= "";
			
			//alert(reqJenisDokumen);return false;
			reqJenisDokumen= String(reqJenisDokumen);
			reqJenisDokumen= reqJenisDokumen.split(';'); 
			//$tempRiwayatTable.";".$tempRiwayatId.";".$tempRiwayatField.";".$tempRiwayatId;
			reqRiwayatTable= reqJenisDokumen[0];
			if(typeof reqRiwayatTable == "undefined") reqRiwayatTable= "";
			reqRiwayatId= reqJenisDokumen[1];
			if(typeof reqRiwayatId == "undefined") reqRiwayatId= "";
			reqRiwayatField= reqJenisDokumen[2];
			if(typeof reqRiwayatField == "undefined") reqRiwayatField= "";
		}
		
		document.location.href= "app/loadUrl/app/pegawai_add_e_file/?reqId=<?=$reqId?>&reqKategoriFileId="+reqKategoriFileId+"&reqKualitasFileId="+reqKualitasFileId+"&reqJenisDokumen="+reqJenisDokumen+"&reqRiwayatTable="+reqRiwayatTable+"&reqRiwayatId="+reqRiwayatId+"&reqRiwayatField="+reqRiwayatField;
	}

	function resetdata(id)
	{
		infoMode= "Apakah anda yakin reset kategori dokumen, jenis dokumen, kualitas dokumen, prioritas ?";
		mbox.custom({
	      message: infoMode,
	      options: {close_speed: 100},
	      buttons: [
	      {
	        label: 'Ya',
	        color: 'green darken-2',
	        callback: function() {

	        	var s_url= "pegawai_file_json/resetefile/?reqId="+id;
				$.ajax({'url': s_url,'success': function(msg){
					// console.log(msg);return false;
					if(msg == ''){}
					else
					{
						mbox.alert(msg, {open_speed: 0});
					  	setreloaddokumen();
					}
				}});
				mbox.close();
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
	
	function hapusdata(id, statusaktif, pegawai_id, furl)
	{
		$.messager.defaults.ok = 'Ya';
		$.messager.defaults.cancel = 'Tidak';
		reqmode= "pegawai_file_1";
		infoMode= "Apakah anda yakin mengaktifkan data terpilih ?";
		if(statusaktif == "")
		{
			reqmode= "pegawai_file_0";
			infoMode= "Apakah anda yakin hapus data terpilih ?";
		}

		mbox.custom({
	      message: infoMode,
	      options: {close_speed: 100},
	      buttons: [
	      {
	        label: 'Ya',
	        color: 'green darken-2',
	        callback: function() {

	        	var s_url= "pegawai_file_json/delete/?reqMode="+reqmode+"&reqId="+id+"&reqPegawaiId="+pegawai_id+"&reqUrl="+furl;
				$.ajax({'url': s_url,'success': function(msg){
					// console.log(msg);return false;
					if(msg == ''){}
					else
					{
						mbox.alert(msg, {open_speed: 0});
					  	setreloaddokumen();
					}
				}});
				mbox.close();
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

		/*$.messager.confirm('Konfirmasi', infoMode+" ?",function(r){
			if (r){
				var s_url= "pegawai_file_json/delete/?reqMode="+reqmode+"&reqId="+id+"&reqPegawaiId="+pegawai_id+"&reqUrl="+furl;
				//var request = $.get(s_url);
				$.ajax({'url': s_url,'success': function(msg){
					// console.log(msg);return false;
					if(msg == ''){}
					else
					{
					  // alert(msg);return false;
					  $.messager.alert('Info', msg, 'info');
					  setreloaddokumen();
					}
				}});
			}
		});  */
	}

</script>

<style>
	td, th {
    	padding: 2px 4px !important;
	}
	
	.dropzone 
	{
		min-height: 50px !important;
		padding: 5px 5px !important;
	}
	
	.dropdown-content
	{
		max-height: 200px !important;
	}

	.dropdown-content li
	{
		min-height: 15px !important;
		line-height: 0.1rem !important;
	}
	.dropdown-content li > span
	{
		font-size: 14px;
		line-height: 12px !important;
	}
</style>

<style type="text/css">
	table tr td:nth-child(2) {
		/*border: 2px solid red;*/

		white-space: pre-wrap;      /* CSS3 */   
		white-space: -moz-pre-wrap; /* Firefox */    
		white-space: -pre-wrap;     /* Opera <7 */   
		white-space: -o-pre-wrap;   /* Opera 7 */    
		word-wrap: break-word;      /* IE */

		width: 20vw !important;

		display: block;
        /*border: 2px solid #000;*/
        /*width: 60px;*/
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;

	}
</style>

<link href="lib/mbox/mbox.css" rel="stylesheet">
<script src="lib/mbox/mbox.js"></script>
<link href="lib/mbox/mbox-modif.css" rel="stylesheet">

</head>

<body>
	<div id="basic-form" class="section">
		<div class="row">
			<div class="col s12 m10 offset-m1">
				<ul class="collection card">
					<li class="collection-item ubah-color-warna">UPLOAD FILE</li>
					<li class="collection-item">
						<?php /*?><div class="row center">
							<button class="btn waves-effect waves-light indigo" style="font-size:9pt" type="button" id="upload">Upload
								<i class="mdi-file-file-upload left hide-on-small-only"></i>
							</button>
						</div><?php */?>
						<div class="row">
							<?
                        	// A;R;D
                        	if($tempAksesMenu == "A")
                        	{
                        	?>
							<div class="col s12">
								<form action="pegawai_file_json/upload/?reqId=<?=$reqId?>" class="dropzone" id="mydropzone"  method="post" enctype="multipart/form-data">
									<?php /*?><div class="fallback">
										<input type="file" name="file" />
										<input type="hidden" name="reqId" value="<?=$reqId?>" />
										<!-- <input type="submit" name="submit" value="submit" /> -->
									</div><?php */?>
								</form>
							</div>

							<script type="text/javascript">
								Dropzone.options.mydropzone = {
									dictDefaultMessage:"Klik Saya Untuk Upload File",
									maxfiles: 5,
									maxFilesize: 2, // in mb
									acceptedMimeTypes: "application/pdf,image/jpeg",
									init: function () {
										// this.on("success", function (data) {
										this.on("success", function(file, responseText) {
											// console.log(responseText);return false;
											if(responseText == "")
											{
												mbox.alert("Data gagal upload, check nama file yang anda upload sudah ada di e-file.", {open_speed: 0});
											}
											else
											{
												if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
													mbox.alert('Data Berhasil di upload', {open_speed: 500}, interval = window.setInterval(function() 
													//mbox.alert('Data Berhasil di upload', {open_speed: 500}, window.setInterval(function() 
													//mbox.alert('Data Berhasil di upload', {open_speed: 500}, function() 
													{
														clearInterval(interval);
														setreloaddokumen();
														mbox.close();
														//setreloaddokumen();
														//document.location.href= "app/loadUrl/app/pegawai_add_e_file/?reqId=<?=$reqId?>";
														//document.location.reload(); 
													}, 1000));
													$(".mbox > .right-align").css({"display": "none"});
													//});
													
												}
											}
										});
									}
								};
							</script>
							<?
                        	}
                            ?>
						</div>
						<?php /*?><div class="row center">
							<button class="btn waves-effect waves-light green" style="font-size:9pt" type="submit" name="action">Simpan
								<i class="mdi-content-save left hide-on-small-only"></i>
							</button>
						</div><?php */?>
						<div class="row">
							<div class="col s12">
                            	<div class="row">
              						<div class="input-field col s12 m4">
                                    <label for="reqKategoriFileId" class="active">Kategori Dokumen</label>
                                    <select id="reqKategoriFileId">
                                        <option value="">Semua Data</option>
                                        <?
                                        for($index_loop=0; $index_loop < $jumlah_kategori_dokumen; $index_loop++)
                                        {
                                        	$tempValId= $arrKategoriDokumen[$index_loop]["KATEGORI_FILE_ID"];
											$tempNama= $arrKategoriDokumen[$index_loop]["NAMA"];
										?>
                                        <option value="<?=$tempValId?>" <? if($reqKategoriFileId == $tempValId) echo "selected"?>><?=$tempNama?></option>
                                        <?
										}
                                        ?>
                                    </select>
                                    </div>
                                    <div class="input-field col s12 m4">
                                    <label for="reqJenisDokumen" class="active">Jenis Dokumen</label>
                                    <select id="reqJenisDokumen">
                                        <option value="">Semua Data</option>
                                        <?
										if($reqKategoriFileId == "")
										{
                                        ?>
                                        <option value="-1" <? if($reqJenisDokumen == "-1") echo "selected"?>>Belum di tentukan</option>
                                        <?
										}
                                        ?>
                                        <?
										for($index_loop=0; $index_loop < $jumlah_jenis_dokumen; $index_loop++)
										{
											$arrJenisDokumen[$index_loop]["NO_URUT"];
											$arrJenisDokumen[$index_loop]["PEGAWAI_ID"];
											$tempRiwayatTable= $arrJenisDokumen[$index_loop]["RIWAYAT_TABLE"];
											$tempRiwayatTableNext= $arrJenisDokumen[$index_loop+1]["RIWAYAT_TABLE"];
											$tempRiwayatField= $arrJenisDokumen[$index_loop]["RIWAYAT_FIELD"];
											$tempRiwayatId= $arrJenisDokumen[$index_loop]["RIWAYAT_ID"];
											$tempInfoData= $arrJenisDokumen[$index_loop]["INFO_DATA"];
											$tempInfoGroupData= $arrJenisDokumen[$index_loop]["INFO_GROUP_DATA"];
											$tempValue= $tempRiwayatTable.";".$tempRiwayatId.";".$tempRiwayatField;
											//$tempValue= $tempRiwayatTable;
										?>
											<option value="<?=$tempValue?>" <? if($reqJenisDokumen == $tempValue) echo "selected"?>><?=$tempInfoData?></option>
										<?
										}
										?>
                                    </select>
                                    </div>
                                    <div class="input-field col s12 m4">
                                    <label for="reqKualitasFileId" class="active">Kualitas Dokumen</label>
                                    <select id="reqKualitasFileId">
                                        <option value="">Semua data</option>
                                        <?
										while($kualitas->nextRow())
										{
										?>
											<option value="<?=$kualitas->getField('KUALITAS_FILE_ID')?>" <? if($reqKualitasFileId == $kualitas->getField('KUALITAS_FILE_ID')) echo "selected"?>><?=$kualitas->getField('NAMA')?></option>
										<? 
										}
										?>
                                    </select>
                                    </div>
                                </div>
                                
                                <div class="row">
              						<div class="input-field col s12 m12">
                                        <table class="bordered highlight md-text table_list tabel-responsif responsive-table" id="link-table">
                                            <thead class="teal white-text"> 
                                                <tr>
                                                    <th width="20">No</th>
                                                    <th>Nama File</th>
                                                    <th>Jenis Dokumen</th>
                                                    <th>Kualitas Dokumen</th>
                                                    <th>Status</th>
                                                    <th style="text-align:center" width="70">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
												if($ambil_data_file == "")
												{
												?>
                                                <tr class="md-text">
                                                    <td colspan="6" style="text-align:center">Data tidak ada</td>
                                                </tr>
                                                <?
												}
												else
												{
												$nomor= 1;
                                                for($index_file=0; $index_file < count($ambil_data_file); $index_file++)
                                                {
													$reqRowId= $tempKategoriFileId= $tempRiwayatTable= $tempFileKualitasId= $tempFileKualitasNama= $infotable= $infostatus= "";
                                                    $tempUrlFile= $ambil_data_file[$index_file];
                                                    $lihaturlfile= urlencode($tempUrlFile);
                                                    // $lihaturlfile= $tempUrlFile;
                                                    $tempNamaUrlFile= pathinfo($tempUrlFile, PATHINFO_BASENAME);
													$tempRiwayatTable= $tempInfoGroupData= $tempFileKualitasNama= $tempFileKualitasId= "";
													
													$arrayKey= [];
													$arrayKey= in_array_column($tempUrlFile, "ROWID", $arrPegawaiDokumen);
													// var_dump($tempUrlFile);
													if(empty($arrayKey)){}
													else
													{
														$index_row= $arrayKey[0];
														$reqRowId= $arrPegawaiDokumen[$index_row]["PEGAWAI_FILE_ID"];
														$tempInfoGroupData= $arrPegawaiDokumen[$index_row]["INFO_GROUP_DATA"];
														$tempKategoriFileId= $arrPegawaiDokumen[$index_row]["KATEGORI_FILE_ID"];
														$tempRiwayatTable= $arrPegawaiDokumen[$index_row]["JENIS_DOKUMEN"];
														$tempFileKualitasId= $arrPegawaiDokumen[$index_row]["FILE_KUALITAS_ID"];
														$tempFileKualitasNama= $arrPegawaiDokumen[$index_row]["FILE_KUALITAS_NAMA"];
														$infostatus= $arrPegawaiDokumen[$index_row]["STATUS"];

														// kalau ada data maka lewati, karena belum valid
														$dtempvalidasibelumid= $arrPegawaiDokumen[$index_row]["TEMP_VALIDASI_BELUM_ID"];
														if(!empty($dtempvalidasibelumid))
														{
															continue;
														}

														$tempNamaUrlFileDB= $arrPegawaiDokumen[$index_row]["PATH_ASLI"];
														$tempNamaUrlFileLama= $arrPegawaiDokumen[$index_row]["ROWID"];
														$extlama = substr($tempNamaUrlFileLama, -3);
														$ext= $arrPegawaiDokumen[$index_row]["EXT"];
														if(empty($ext))
														{
															$tempNamaUrlFileAsli=$tempNamaUrlFileDB.".".$extlama;
														}
														else
														{
															$tempNamaUrlFileAsli=$tempNamaUrlFileDB.".".$ext;
														}
														$infotable= $arrPegawaiDokumen[$index_row]["RIWAYAT_TABLE"];
													}
													
													if($reqKategoriFileId == ""){}
													else
													{
														if($tempKategoriFileId == $reqKategoriFileId){}
														else
														continue;
													}
													
													
													if($reqKualitasFileId == ""){}
													else
													{
														if($tempFileKualitasId == $reqKualitasFileId){}
														else
														continue;
													}
													
													if($reqRiwayatTable == ""){}
													else
													{
														$tempCheck= $reqRiwayatTable.";".$reqRiwayatId.";".$reqRiwayatField;
														if($tempRiwayatTable == $tempCheck){}
														else
														continue;
													}
													
													if($reqJenisDokumen == "-1")
													{
														if($reqKategoriFileId == "")
														{
															if($tempInfoGroupData == ""){}
															else
															continue;
														}
														else
														{
															if($tempInfoGroupData == "")
															continue;
														}
													}

													$tempFileDelete= "";
													if($tempUserLoginLevel == "99"){}
													else
													{
														if(empty($arrayKey))
														{
															$tempFileDelete= likeMatch("%_delete_%", $tempNamaUrlFile);
														}
														else
														{
															$tempFileDelete= likeMatch("%_delete_%", $tempNamaUrlFileAsli);
														}
													}
													// var_dump($tempUserLoginLevel);

													if($tempFileDelete == 1)
														continue;

													$infoakseshukumanmenu= $tempAksesMenu;
                                                	$infourldetil= "reqId=".$reqId."&reqRowId=".$reqRowId."&reqUrlFile=".$lihaturlfile;
                                                	if($infotable == "HUKUMAN")
                                            		{
                                            			$infohukumanmenuid= "0111";
                                            			$infoakseshukumanmenu= $CI->checkmenupegawai($tempUserLoginId, $infohukumanmenuid);

                                            			if($infoakseshukumanmenu == "R")
                                            			{
                                            				$infourldetil= "reqId=".$reqId."&reqRowId=".$reqRowId;
                                            			}

                                            			if($infoakseshukumanmenu == "D")
                                            			{
                                            				continue;
                                            			}

                                            		}

                                            		// kalau lihaturlfile kosong dan reqRowId kosong maka lewati
                                            		if(empty($lihaturlfile) && empty($reqRowId))
                                            		{
                                            			continue;
                                            		}
                                                ?>
                                                <tr class="md-text">
                                                    <td><?=$nomor?></td>
                                                    <?
                                                    if(empty($arrayKey))
                                                    {
                                                    ?>
                                                     <td><?=$tempNamaUrlFile?></td>
                                                    <?
                                                    }
													else
													{
                                                    ?>
                                                    <td><?=$tempNamaUrlFileAsli?></td>
                                                    <?
                                                	}
                                                    ?>
                                                    <td><?=$tempInfoGroupData?></td>
                                                    <td><?=$tempFileKualitasNama?></td>
                                                    <td>
                                                        <i class="mdi-alert-warning orange-text"></i>
                                                    </td>
                                                    <td style="text-align:center">
                                                    	<?
                                                    	$tempFileDelete= "";
                                                    	if(empty($arrayKey))
														{
															$tempFileDelete= likeMatch("%_delete_%", $tempNamaUrlFile);
														}
														else
														{
															$tempFileDelete= likeMatch("%_delete_%", $tempNamaUrlFileAsli);					
														}

														if($tempUserLoginLevel == "99")
														{
															/*if($infoakseshukumanmenu == "A")
															{
																$infoakseshukumanmenu= "";
															}

															if($infostatus == "1")
															{
																$infostatus= "";
															}

															$tempFileDelete= "";*/
														}

                                                    	if
                                                    	(
                                                    		$tempUserLoginLevel !== "99" &&
                                                    		($tempFileDelete == "1" || $infostatus == "1")
                                                    	){}
                                                    	else
                                                    	{
                                                    	?>

                                                    	<?
                                                    	if($infoakseshukumanmenu == "A")
                                                    	{
                                                    		if($tempFileDelete == "1" || $infostatus == "1"){}
                                                    		else
                                                    		{
                                                    	?>
                                                        <span>
                                                        	<a href="javascript:void(0)" class="round waves-effect waves-light green white-text" title="Reset" onClick="resetdata('<?=$reqRowId?>')">
                                                                <i class="mdi-editor-border-clear"></i>
                                                            </a>
                                                            <a href="javascript:void(0)" class="round waves-effect waves-light red white-text" title="Hapus" onClick="hapusdata('<?=$reqRowId?>','','<?=$reqId?>', '<?=$tempNamaUrlFile?>')">
                                                                <i class="mdi-action-delete"></i>
                                                            </a>
                                                        </span>
                                                        <?
                                                        	}
                                                    	}
                                                        ?>
                                                        <span>
                                                            <a href="javascript:void(0)" class="round waves-effect waves-light blue white-text" title="Ubah" onClick="parent.setload('pegawai_add_e_file_data?<?=$infourldetil?>')">
                                                                <i class="mdi-editor-mode-edit"></i>
                                                            </a>
                                                        </span>
                                                        <?
                                                    	}
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?
												$nomor++;
                                                }
												}
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
								</div>	
                            </div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
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
  
</script>

<link rel="stylesheet" href="lib/AdminLTE-2.4.0-rc/dist/css/skins/ubah-skin.css">
<script src="lib/AdminLTE-2.4.0-rc/dist/js/ubah-skin.js"></script>

</body>
</html>