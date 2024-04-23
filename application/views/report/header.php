<?php
$reqPegawaiPenandaTanganId= $this->input->get("reqPegawaiPenandaTanganId");
?>
<!DOCTYPE html>
<style type="text/css">
	<?php
	// bkd
	if($reqPegawaiPenandaTanganId == "130106")
	{
	?>
	table.headerkop {
		/*border: 2px solid #ccc;*/
		width: 100% !important;
		padding-left: 6% !important;
	}

	hr.garisheaderkop {
	  border: 1px solid black;
	  width: 90% !important;
	}
	<?php
	}
	// sekda
	else if($reqPegawaiPenandaTanganId == "130107")
	{
	?>
	table.headerkop {
		/*border: 2px solid #ccc;*/
		width: 100% !important;
		padding-left: 6% !important;
	}

	hr.garisheaderkop {
	  border: 1px solid black;
	  width: 90% !important;
	}
	<?php
	}
	// bupati
	else if($reqPegawaiPenandaTanganId == "130108")
	{
	?>
	table.headerkop {
		/*border: 2px solid #ccc;*/
		width: 100% !important;
		padding-left: 6% !important;
		margin-top: -15px !important;
	}

	hr.garisheaderkop {
	  border: 1px solid black;
	  width: 90% !important;
	}
	<?php
	}
	?>

	td
	{
		/*border: 1px solid red;*/
	}
</style>
<base href="<?=base_url();?>">
<table class="headerkop">
	<?php
	// bkd
	if($reqPegawaiPenandaTanganId == "130106")
	{
	?>
	<tr>
		<td style="width: 10%;">
			<img src="images/kop_jombang.png">
		</td>
		<td style="text-align: center !important;">
			<label style="font-size: 12pt !important; font-weight: bold;">PEMERINTAH KABUPATEN JOMBANG</label>
			<label style="font-size: 16pt !important; font-weight: bold;"><br/>BADAN KEPEGAWAIAN DAN PENGEMBANGAN</br>SUMBER DAYA MANUSIA</label>
			<label style="font-size: 12pt !important;">
				<br/>Jl. K.H. Wahid Hasyim No. 137 Jombang 61411<br/>
				Telp. (0321) 862086, e-mail: bkpsdm@jombangkab.go.id Website: http://bkpsdm.jombangkab.go.id
			</label>
		</td>
		<td style="width: 10%;"></td>
	</tr>
	<?
	}
	// sekda
	else if($reqPegawaiPenandaTanganId == "130107")
	{
	?>
	<tr>
		<td style="width: 20%;">
			<img src="images/kop_jombang.png">
		</td>
		<td style="text-align: center !important;">
			<label style="font-size: 12pt !important; font-weight: bold;">PEMERINTAH KABUPATEN JOMBANG</label>
			<label style="font-size: 16pt !important; font-weight: bold;"><br/>SEKRETARIAT DAERAH</label>
			<label style="font-size: 12pt !important;">
				<br/>Jl. K.H. Wahid Hasyim No. 137 Jombang 61411<br/>
				Telp. (0321) 861292, Fax. -,  e-mail: setda@jombangkab.go.id
			</label>
		</td>
		<td style="width: 25%;"></td>
	</tr>
	<?
	}
	// bupati
	else if($reqPegawaiPenandaTanganId == "130108")
	{
	?>
	<tr>
		<td style="width: 20%;"></td>
		<td style="text-align: center !important;">
			<img src="images/kop_garuda.png"><br/>
			<label style="font-size: 12pt !important; font-weight: bold;">BUPATI JOMBANG<br/>PROVINSI JAWA TIMUR</label>
		</td>
		<td style="width: 25%;"></td>
	</tr>
	<?
	}
	?>
</table>

<hr class="garisheaderkop">