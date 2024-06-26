<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

/* CHECK USER LOGIN 
$CI =& get_instance();
$CI->checkUserLogin();*/

$this->load->model('JenisPegawai');

$set= new JenisPegawai();

$reqId = $this->input->get("reqId");

if($reqId == ""){
	$reqMode = "insert";
}
else
{
	$reqMode = "update";	
	$set->selectByParams(array("JENIS_PEGAWAI_ID"=>$reqId));
	$set->firstRow();
	$reqNama= $set->getField("NAMA");
	// $reqStatus= $set->getField("STATUS_NAMA");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Untitled Document</title>
	<base href="<?=base_url()?>" />

	<link rel="stylesheet" type="text/css" href="css/gaya.css">

	<link rel="stylesheet" type="text/css" href="lib/easyui/themes/default/easyui.css">
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="lib/easyui/kalender-easyui.js"></script>
	<script type="text/javascript" src="lib/easyui/globalfunction.js"></script>
	<script type="text/javascript">	
		$(function(){
			$('#ff').form({
				url:'jenis_pegawai_json/add',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');

					<?
					if($reqMode == "update")
					{
						?>
						// document.location.reload();
						<?	
					}
					else
					{
						?>
						$('#rst_form').click();
						<?
					}
					?>
					top.frames['mainFrame'].location.reload();
				}
			});

		});
	</script>


	<!-- UPLOAD CORE -->
	<script src="lib/multifile-master/jquery.MultiFile.js"></script>
	<script>
	// wait for document to load
	$(function(){
		// invoke plugin
		$('#reqLinkFile').MultiFile({
			onFileChange: function(){
				console.log(this, arguments);
			}
		});

	});

	$(function(){
		$("#reqLinkFile").prop('required',true);
	});
</script>

<!-- BOOTSTRAP CORE -->
<link href="lib/startbootstrap-sb-admin-2-1.0.7/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="lib/startbootstrap-sb-admin-2-1.0.7/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</head>

<body class="bg-kanan-full">
	<div id="judul-popup">Tambah Jenis Pegawai</div>
	<div id="konten">
		<div id="popup-tabel2">
			<form id="ff" method="post"  novalidate enctype="multipart/form-data">
				<table class="table">
					<thead>
						<tr>           
							<td>Nama</td>
							<td>:</td>
							<td>
								<input name="reqNama" class="easyui-validatebox" style="width:170px" type="text" value="<?=$reqNama?>" />
							</td>			
						</tr>  
						
					</table>
				</thead>
				<input type="hidden" name="reqId" value="<?=$reqId?>" />
				<input type="hidden" name="reqMode" value="<?=$reqMode?>" />
				<input type="submit" name="reqSubmit"  class="btn btn-primary" value="Submit" />
				<input type="reset" id="rst_form"  class="btn btn-primary" value="Reset" />

			</form>
		</div>
	</div>
</div>
</body>
</html>