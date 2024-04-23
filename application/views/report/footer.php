<?php
$reqPegawaiPenandaTanganId= $this->input->get("reqPegawaiPenandaTanganId");
?>
<!DOCTYPE html>
<base href="<?=base_url();?>">
<style type="text/css">
	table.footerkop {
		/*border: 2px solid #ccc;*/
		width: 100% !important;
		font-size:12px !important;
	}

	td
	{
		/*border: 1px solid red;*/
	}

	td.footerkotak
	{
		border: 1px solid black;
		width: 8%; text-align: center;
	}
</style>
<table class="footerkop">
	<tr>
		<td style="width:20%">
			<img src="images/footer_surat_new.png" style="width: 100%" />
		</td>
		<td style="vertical-align: middle; padding-top: 15px; padding-left: 10px">
			<i>Dokumen ini telah ditandatangani secara elektronik yang diterbitkan oleh Balai Sertifikasi Elektronik (BSrE), BSSN</i>
		</td>
		<td></td>
	</tr>
	<?php
	// bkd
	if($reqPegawaiPenandaTanganId == "130106"){}
	else
	{
	?>
	<tr>
		<td colspan="2"></td>
		<td class="footerkotak">
			415.10
		</td>
	</tr>
	<?
	}
	?>
</table>