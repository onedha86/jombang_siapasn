<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$CI =& get_instance();
$CI->checkUserLogin();

$this->load->model('KenaikanGajiPppkBerkala');
$this->load->model('GajiPppkRiwayat');

$sesloginlevel= $this->LOGIN_LEVEL;

$reqPegawaiId= $this->input->get("reqPegawaiId");
$reqBulan= $this->input->get("reqBulan");
$reqTahun= $this->input->get("reqTahun");
$reqBulan= $this->input->get("reqBulan");
$reqRevisi= $this->input->get("reqRevisi");
$reqPeriodeLama= $reqPeriode= $reqBulan.$reqTahun;

$statement= " AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.PERIODE = '".$reqPeriode."'";
$set= new KenaikanGajiPppkBerkala();
$set->selectByParamsData(array(), -1, -1, $statement);
$set->firstRow();
// echo $set->query;exit;
$reqStatusHitungUlang= $set->getField('STATUS_HITUNG_ULANG');
$reqPegawaiNip= $set->getField('NIP_BARU');
$reqPegawaiNama= $set->getField('NAMA_LENGKAP');
$reqPegawaiSatuanKerja= $set->getField('PEGAWAI_SATUAN_KERJA_NAMA_DETIL');
$reqPegawaiStatusNama= $set->getField('PEGAWAI_STATUS_NAMA');
$reqPegawaiKedudukan= $set->getField('PEGAWAI_KEDUDUKAN_NAMA');
$reqKeteranganTeknis= $set->getField('KETERANGAN_TEKNIS');

/*A.PEGAWAI_ID, A.PERIODE, 	
			, PR1.NO_SK, PR1.TANGGAL_SK, PR1.TMT_PANGKAT , PR1., PR1.PANGKAT_ID
			, PR1.PEJABAT_PENETAP_ID PEJABAT_PENETAP_ID_LAMA
	*/		
$reqPangkatRiwayatLamaId= $set->getField('PANGKAT_RIWAYAT_LAMA_ID');
$reqGajiRiwayatLamaId= $set->getField('GAJI_RIWAYAT_LAMA_ID');
//echo $reqGajiRiwayatLamaId;exit;
$reqGajiRiwayatLamaNama= $set->getField('NO_SK_LAMA');
$reqPangkatRiwayatBaruId= $set->getField('PANGKAT_RIWAYAT_BARU_ID');
$reqGajiRiwayatBaruId= $set->getField('GAJI_RIWAYAT_BARU_ID');
$reqHukumanRiwayatId= $set->getField('HUKUMAN_RIWAYAT_ID');
$reqPegawaiStatusId= $set->getField('PEGAWAI_STATUS_ID');
$reqJabatanRiwayatId= $set->getField('JABATAN_RIWAYAT_ID');

$reqSatuanKerjaId= $set->getField('SATUAN_KERJA_ID');
$reqSatuanKerjaNama= $set->getField('SATUAN_KERJA_NAMA_DETIL');

$reqRiwayatGajiLamaJenisRiwayat= $set->getField('JENIS_KENAIKAN_NAMA');
$reqRiwayatGajiLamaGolId= $set->getField('PANGKAT_ID');
$reqRiwayatGajiLamaGolKode= $set->getField('PANGKAT_KODE');
$reqRiwayatGajiLamaTanggal= dateToPageCheck($set->getField('TANGGAL_SK'));
//$reqRiwayatGajiLamaTanggal= "03-07-2018";
$reqRiwayatGajiLamaTmt= dateToPageCheck($set->getField('TMT_LAMA'));
$reqRiwayatGajiLamaMasaKerjaTahun= $set->getField('MASA_KERJA_TAHUN_LAMA');
$reqRiwayatGajiLamaMasaKerjaBulan= $set->getField('MASA_KERJA_BULAN_LAMA');
$reqRiwayatGajiLamaGaji= numberToIna($set->getField('GAJI_LAMA'));
$reqRiwayatGajiLamaPejabatPenetap= $set->getField('PEJABAT_PENETAP_LAMA');

$reqRiwayatGajiBaruTmt= dateToPageCheck($set->getField('TMT_BARU'));
$reqRiwayatGajiBaruMasaKerjaTahun= $set->getField('MASA_KERJA_TAHUN_BARU');
$reqRiwayatGajiBaruMasaKerjaBulan= $set->getField('MASA_KERJA_BULAN_BARU');
$reqRiwayatGajiBaruGaji= numberToIna($set->getField('GAJI_BARU'));
$reqRiwayatGajiBaruTanggalBaru= dateToPageCheck($set->getField('TANGGAL_BARU'));

$reqSuratKeluarBkdId= $set->getField('SURAT_KELUAR_BKD_ID');
$reqNomorAwal= $set->getField('NOMOR_AWAL');
$reqNomorUrut= $set->getField('NOMOR_URUT');
$reqPeriode= $set->getField('PERIODE');
//echo $reqPeriode;exit;
$reqRiwayatHukumanNoSk= $set->getField('HUKUMAN_NO_SK');
$reqRiwayatHukumanTglSk= dateToPageCheck($set->getField('HUKUMAN_TANGGAL_SK'));
$reqRiwayatHukumanKenaikanGajiBerikutnya= dateToPageCheck($set->getField('TMT_BERIKUT_GAJI'));
$reqRiwayatHukumanKeterangan= $set->getField('KETERANGAN_HUKUMAN_INFO');
$reqStatusKgb= $set->getField('STATUS_KGB');
unset($set);
//echo $reqStatusHitungUlang;exit;
if($reqStatusHitungUlang == "1")
{
	$statement= " AND A.GAJI_RIWAYAT_ID = ".$reqGajiRiwayatLamaId;
	$set= new KenaikanGajiPppkBerkala();
	$set->selectByParamsHitungGajiPppkRiwayat($statement);
	$set->firstRow();
	//echo $set->query;exit;
	$reqPeriode= $set->getField('PERIODE');
	$reqRiwayatGajiBaruTmt= dateTimeToPageCheck($set->getField('TMT_PERIODE_KGB'));
	$reqRiwayatGajiBaruMasaKerjaTahun= $set->getField('MASA_KERJA_TAHUN_BARU');
	$reqRiwayatGajiBaruMasaKerjaBulan= $set->getField('MASA_KERJA_BULAN_BARU');
	$reqRiwayatGajiBaruGaji= numberToIna($set->getField('GAJI_BARU'));
}

if($reqSuratKeluarBkdId == "")
{
	$sOrder= "ORDER BY COALESCE(A.NOMOR_AWAL,-1) ASC";
	$statement= " AND A.STATUS_TERIMA = '1' AND A.JENIS_ID = 14 AND A.NOMOR_AWAL IS NOT NULL AND A.PERIODE = '".$reqPeriodeLama."'";
	$set= new KenaikanGajiPppkBerkala();
	$set->selectByParamsSuratKeluarData(array(), -1, -1, $statement, $sOrder);
	$set->firstRow();
	// echo $set->query;exit;
	$reqSuratKeluarBkdId= $set->getField("SURAT_KELUAR_BKD_ID");
	$reqRiwayatGajiBaruTanggalBaru= dateToPageCheck($set->getField('TANGGAL'));
	$reqNomorAwal= $set->getField('NOMOR_AWAL');
	$reqPeriode= $set->getField('PERIODE');
	//echo $reqNomorAwal;exit;
}

$arrPangkatRiwayat= [];
$index_data= 0;

$sOrder= "ORDER BY A.TMT_SK DESC";
$statement= " AND (COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL OR A.STATUS = '2') AND A.PEGAWAI_ID = ".$reqPegawaiId;
$statement.= " AND TO_DATE(TO_CHAR(A.TMT_SK, 'YYYY-MM-DD'), 'YYYY-MM-DD') < TO_DATE('".dateToPageCheck($reqRiwayatGajiBaruTmt)."','YYYY/MM/DD')";
//AND TO_DATE(TO_CHAR(A.TANGGAL_SK, 'YYYY-MM-DD'), 'YYYY-MM-DD') < TO_DATE('".dateToPageCheck($reqRiwayatGajiBaruTanggalBaru)."','YYYY/MM/DD')
$set= new GajiPppkRiwayat();
$set->selectByParams(array(), 2,0, $statement, $sOrder);
//echo $set->query;exit;
while($set->nextRow())
{
	$arrPangkatRiwayat[$index_data]["GAJI_RIWAYAT_ID"] = $set->getField("GAJI_RIWAYAT_ID");
	$arrPangkatRiwayat[$index_data]["NO_SK"] = $set->getField("NO_SK");
	$index_data++;
}
//print_r($arrPangkatRiwayat);exit;
$jumlah_gaji_riwayat= $index_data;
// echo $sesloginlevel."--".$reqStatusKgb;exit;
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


  <link rel="stylesheet" type="text/css" href="css/gaya.css">

  <link rel="stylesheet" type="text/css" href="lib/easyui/themes/default/easyui.css">
  <script type="text/javascript" src="lib/easyui/jquery-1.8.0.min.js"></script>
  <script type="text/javascript" src="lib/easyui/jquery.easyui.min.js"></script>
  
  <!-- AUTO KOMPLIT -->
  <link rel="stylesheet" href="lib/autokomplit/jquery-ui.css">
  <script src="lib/autokomplit/jquery-ui.js"></script>
  <script type="text/javascript">
  	function sethitungulangkgbbaru()
	{
		var reqGajiRiwayatLamaId= "";
		reqGajiRiwayatLamaId= $("#reqGajiRiwayatLamaId").val();
		$.ajax({'url': "gaji_riwayat_json/getinfohitungulang/?reqId="+reqGajiRiwayatLamaId,'success': function(dataJson) {
			var data= JSON.parse(dataJson);
			reqPeriode= data.reqPeriode;
			reqRiwayatGajiBaruTmt= data.reqRiwayatGajiBaruTmt;
			reqRiwayatGajiBaruMasaKerjaTahun= data.reqRiwayatGajiBaruMasaKerjaTahun;
			reqRiwayatGajiBaruMasaKerjaBulan= data.reqRiwayatGajiBaruMasaKerjaBulan;
			reqRiwayatGajiBaruGaji= data.reqRiwayatGajiBaruGaji;

			$("#reqPeriode").val(reqPeriode);
			$("#reqRiwayatGajiBaruTmt").val(reqRiwayatGajiBaruTmt);
			$("#reqRiwayatGajiBaruMasaKerjaTahun").val(reqRiwayatGajiBaruMasaKerjaTahun);
			$("#reqRiwayatGajiBaruMasaKerjaBulan").val(reqRiwayatGajiBaruMasaKerjaBulan);
			$("#reqRiwayatGajiBaruGaji").val(reqRiwayatGajiBaruGaji);
		}});
	}
	
  	function setdatasurat(id)
	{
		reqRiwayatGajiLamaGolId= $("#reqRiwayatGajiLamaGolId").val();
		reqRiwayatGajiLamaTmt= $("#reqRiwayatGajiLamaTmt").val();
		reqRiwayatGajiLamaMasaKerjaTahun= $("#reqRiwayatGajiLamaMasaKerjaTahun").val();
		reqRiwayatGajiLamaMasaKerjaBulan= $("#reqRiwayatGajiLamaMasaKerjaBulan").val();
		//alert(reqRiwayatGajiLamaTmt);return false;
		$.ajax({'url': "surat/surat_keluar_bkd_json/getinfo/?reqId="+id+"&reqPangkatId="+reqRiwayatGajiLamaGolId+"&reqMasaKerjaBulan="+reqRiwayatGajiLamaMasaKerjaBulan+"&reqMasaKerjaTahun="+reqRiwayatGajiLamaMasaKerjaTahun+"&reqTmtLama="+reqRiwayatGajiLamaTmt,'success': function(dataJson) {
			var data= JSON.parse(dataJson);
			reqNomorAwal= data.reqNomorAwal;
			reqNomorUrut= data.reqNomorUrut;
			reqRiwayatGajiBaruTanggalBaru= data.reqRiwayatGajiBaruTanggalBaru;
			reqRiwayatGajiBaruTmt= data.reqRiwayatGajiBaruTmt;
			reqPeriode= data.reqPeriode;
			reqSuratKeluarBkdId= data.reqSuratKeluarBkdId;
			
			reqRiwayatGajiBaruGaji= data.reqRiwayatGajiBaruGaji;
			reqRiwayatGajiBaruMasaKerjaBulan= data.reqRiwayatGajiBaruMasaKerjaBulan;
			reqRiwayatGajiBaruMasaKerjaTahun= data.reqRiwayatGajiBaruMasaKerjaTahun;
			
			reqPeriodeLama= $("#reqPeriodeLama").val();

			$("#reqNomorAwal").val(reqNomorAwal);
			//alert(reqNomorUrut);
			$(function(){
				$("#reqNomorUrutLabel").show();
				if(reqNomorUrut == "" || reqNomorUrut == null)
				{
					//alert('s');
					$("#reqNomorUrutLabel").hide();
				}
			});
			
			$("#reqNomorUrut").val(reqNomorUrut);
			$("#reqRiwayatGajiBaruTanggalBaru").val(reqRiwayatGajiBaruTanggalBaru);
			$("#reqRiwayatGajiBaruGaji").val(reqRiwayatGajiBaruGaji);
			$("#reqRiwayatGajiBaruMasaKerjaBulan").val(reqRiwayatGajiBaruMasaKerjaBulan);
			$("#reqRiwayatGajiBaruMasaKerjaTahun").val(reqRiwayatGajiBaruMasaKerjaTahun);
			$("#reqPeriode").val(reqPeriode);
			$("#reqRiwayatGajiBaruTmt").val(reqRiwayatGajiBaruTmt);
			$("#reqSuratKeluarBkdId").val(id);
			
		}});
	}
	
	function monthDiff(d1, d2)
	{
		var months;
		months = (d2.getFullYear() - d1.getFullYear()) * 12;   //calculates months between two years
		months -= d1.getMonth() + 1; 
		months += d2.getMonth();  //calculates number of complete months between two months
		day1 = 30-d1.getDate();  
		day2 = day1 + d2.getDate();
		months += parseInt(day2/30);  //calculates no of complete months lie between two dates
		return months;
		//return months <= 0 ? 0 : months;
	}

    $(function(){
    	<?
		if($reqStatusHitungUlang == "1")
		{
    	?>
    	parent.reloadparenttab();
    	<?
    	}
    	?>
    	
		$('#ff').form({
            url:'kenaikan_gaji_pppk_berkala_json/add',
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
				//infodata= data;
                //$.messager.alert('Info', infodata, 'info');
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
						//top.reloadparenttab();
						
						reqPeriode= $("#reqPeriode").val();
						reqPeriodeLama= $("#reqPeriodeLama").val();
						
   						var reqBulan = reqPeriode.substr(0, 2);
   						var reqTahun = reqPeriode.substr(2, 4);
						
						//if(reqPeriodeLama == reqPeriode)
						//{
							//document.location.href= "app/loadUrl/app/kenaikan_gaji_pppk_berkala_add_data?reqPegawaiId=<?=$reqPegawaiId?>&reqBulan=<?=$reqBulan?>&reqTahun=<?=$reqTahun?>";
						//}
						//else
						//{
							top.location.href= "app/loadUrl/app/kenaikan_gaji_pppk_berkala_add?reqPegawaiId=<?=$reqPegawaiId?>&reqBulan="+reqBulan+"&reqTahun="+reqTahun;
						//}
					}, 1000));
					$(".mbox > .right-align").css({"display": "none"});
				}

            }
        });
		
		$('input[id^="reqSatuanKerjaNama"]').each(function(){
			$(this).autocomplete({
			source:function(request, response){
			var id= this.element.attr('id');
			var replaceAnakId= replaceAnak= urlAjax= "";
			
			if (id.indexOf('reqSatuanKerjaNama') !== -1)
			{
			var element= id.split('reqSatuanKerjaNama');
			var indexId= "reqSatuanKerjaId"+element[1];
			urlAjax= "satuan_kerja_json/auto";
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
			if (id.indexOf('reqSatuanKerjaNama') !== -1)
			{
			var element= id.split('reqSatuanKerjaNama');
			var indexId= "reqSatuanKerjaId"+element[1];
			//$("#reqJabatanFuNama").val("").trigger('change');
			}
			
			$("#"+indexId).val(ui.item.id).trigger('change');
			},
			autoFocus: true
			})
			.autocomplete( "instance" )._renderItem = function( ul, item ) {
			//return
			return $( "<li>" )
			.append( "<a>" + item.desc  + "</a>" )
			.appendTo( ul );
			}
			;
		});

		$("#reqGajiRiwayatLamaId").change(function(){
			setinfodata();
			reqGajiRiwayatLamaId= $("#reqGajiRiwayatLamaId").val();
			$("#reqDataGajiPppkRiwayatId2").val(reqGajiRiwayatLamaId);
		});
		
	});
	
	function setinfodata()
	{
		var reqGajiRiwayatLamaId= "";
		reqGajiRiwayatLamaId= $("#reqGajiRiwayatLamaId").val();
		$.ajax({'url': "gaji_riwayat_json/getinfo/?reqId="+reqGajiRiwayatLamaId,'success': function(dataJson) {
			var data= JSON.parse(dataJson);
			reqRiwayatGajiLamaJenisRiwayat= data.reqRiwayatGajiLamaJenisRiwayat;
			reqRiwayatGajiLamaGolKode= data.reqRiwayatGajiLamaGolKode;
			reqRiwayatGajiLamaGolId= data.reqRiwayatGajiLamaGolId;
			reqRiwayatGajiLamaTanggal= data.reqRiwayatGajiLamaTanggal;
			reqRiwayatGajiLamaTmt= data.reqRiwayatGajiLamaTmt;
			reqRiwayatGajiLamaMasaKerjaTahun= data.reqRiwayatGajiLamaMasaKerjaTahun;
			reqRiwayatGajiLamaMasaKerjaBulan= data.reqRiwayatGajiLamaMasaKerjaBulan;
			reqRiwayatGajiLamaGaji= data.reqRiwayatGajiLamaGaji;
			reqRiwayatGajiLamaPejabatPenetap= data.reqRiwayatGajiLamaPejabatPenetap;

			$("#reqRiwayatGajiLamaJenisRiwayat").val(reqRiwayatGajiLamaJenisRiwayat);
			$("#reqRiwayatGajiLamaGolKode").val(reqRiwayatGajiLamaGolKode);
			$("#reqRiwayatGajiLamaGolId").val(reqRiwayatGajiLamaGolId);
			$("#reqRiwayatGajiLamaTanggal").val(reqRiwayatGajiLamaTanggal);
			$("#reqRiwayatGajiLamaTmt").val(reqRiwayatGajiLamaTmt);
			$("#reqRiwayatGajiLamaMasaKerjaTahun").val(reqRiwayatGajiLamaMasaKerjaTahun);
			$("#reqRiwayatGajiLamaMasaKerjaBulan").val(reqRiwayatGajiLamaMasaKerjaBulan);
			$("#reqRiwayatGajiLamaGaji").val(reqRiwayatGajiLamaGaji);
			$("#reqRiwayatGajiLamaPejabatPenetap").val(reqRiwayatGajiLamaPejabatPenetap);
			
			//hitung ulang kgb baru
			sethitungulangkgbbaru();
		}});
	}
	</script>
  <!-- SIMPLE TAB -->
  <script type="text/javascript" src="lib/simpletabs_v1.3/js/simpletabs_1.3.js"></script>
  <link href="lib/simpletabs_v1.3/css/simpletabs.css" type="text/css" rel="stylesheet">

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

  <style type="text/css">
    @media 
    only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px)  {
      table.tabel-responsif thead th{ display:none; }
      <?
      $arrData= array("NIP");

      for($i=0; $i < count($arrData); $i++)
      {
        $index= $i+1;
        ?>
        table.tabel-responsif td:nth-of-type(<?=$index?>):before { content: "<?=$arrData[$i]?>"; }
        <? 
      }  ?>
    }

    .round {
      border-radius: 50%;
      padding: 5px;
    }
  </style>
  
  <style>
  	td, th {
		padding: 5px 5px;
		display: table-cell;
		text-align: left;
		vertical-align: middle;
		border-radius: 2px;
	}
	
	.carousel .carousel-item{
		width:100%;
	}
	
	
	/* CSS for responsive iframe */
/* ========================= */

/* outer wrapper: set max-width & max-height; max-height greater than padding-bottom % will be ineffective and height will = padding-bottom % of max-width */
#Iframe-Master-CC-and-Rs {
  *max-width: 512px;
  max-height: 100%; 
  overflow: hidden;
}

/* inner wrapper: make responsive */
.responsive-wrapper {
  position: relative;
  height: 0;    /* gets height from padding-bottom */
  
  /* put following styles (necessary for overflow and scrolling handling on mobile devices) inline in .responsive-wrapper around iframe because not stable in CSS:
    -webkit-overflow-scrolling: touch; overflow: auto; */
  
}
 
.responsive-wrapper iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  
  margin: 0;
  padding: 0;
  border: none;
}

/* padding-bottom = h/w as % -- sets aspect ratio */
/* YouTube video aspect ratio */
.responsive-wrapper-wxh-572x612 {
  padding-bottom: 107%;
}

/* general styles */
/* ============== */
.set-border {
  border: 5px inset #4f4f4f;
}
.set-box-shadow { 
  -webkit-box-shadow: 4px 4px 14px #4f4f4f;
  -moz-box-shadow: 4px 4px 14px #4f4f4f;
  box-shadow: 4px 4px 14px #4f4f4f;
}
.set-padding {
  padding: 40px;
}
.set-margin {
  margin: 30px;
}
.center-block-horiz {
  margin-left: auto !important;
  margin-right: auto !important;
}

*html,body{height:100%;}
.carousel{
    height: 100%;
	height: 100vh !important;
    margin-bottom: 60px !important;
}

/*.carousel {
    *height: 150vh !important;
	height: 115% !important;
    width: 100%;
	*overflow:auto;
    overflow:hidden;
}*/
.carousel .carousel-inner {
    height:100% !important;
}

    .responsive-iframe {
	  display: block;
      *position: relative;
      *padding-bottom: 56.25%;
	  padding-bottom: 86.25%;
      *padding-top: 35px;
      height: 0;
	  *height: 150vh !important;
      overflow: hidden;
    }
     
    .responsive-iframe iframe {
      position: absolute;
      top:0;
      left: 0;
      width: 100%;
      height: 100%;
    }
	
	th, td
	{
		padding: 3px 8px !important;
	}
  </style>
</head>

<body>
 <div id="basic-form" class="section">
  <div class="row">
    <div class="col s12 m10 offset-m1 ">
      <ul class="collection card">
        <li class="collection-item ubah-color-warna white-text">Kenaikan Gaji Berkala</li>
        <li class="collection-item">
          <div class="row">
          <form id="ff" method="post"  novalidate enctype="multipart/form-data">
          <table class="bordered striped md-text "> <!-- table_list tabel-responsif -->
          	<thead> 
            	<tr>
                	<th class="green-text material-font" style="width:20%">NIP</th>
                    <th class="green-text material-font" style="width:1%">:</th>
                    <td colspan="4" class="green-text material-font"><?=$reqPegawaiNip?></td>
                </tr>
                <tr>
                	<th class="green-text material-font">Nama</th>
                    <th class="green-text material-font">:</th>
                    <th colspan="4" class="green-text material-font"><?=$reqPegawaiNama?></th>
                </tr>
                <tr>
                	<th class="green-text material-font" style="vertical-align:top">Unit Kerja</th>
                    <th class="green-text material-font" style="vertical-align:top">:</th>
                    <th colspan="4" class="green-text material-font"><?=$reqPegawaiSatuanKerja?></th>
                </tr>
                <tr>
                	<th class="green-text material-font">Status</th>
                    <th class="green-text material-font">:</th>
                    <th class="green-text material-font" style="width:28%"><?=$reqPegawaiStatusNama?></th>
                    <th class="green-text material-font hide-on-small-only" style="width:10%">Kedudukan</th> <!-- hilang pas mode mobile -->
                    <th class="green-text material-font hide-on-small-only" style="width:1%">:</th> <!-- hilang pas mode mobile -->
                    <th class="green-text material-font hide-on-small-only"><?=$reqPegawaiKedudukan?></th> <!-- hilang pas mode mobile -->
                </tr>
                <tr class="hide-on-med-and-up"> <!-- cuma muncul pas mode mobile -->
                  <th class="green-text material-font" style="width:10%">Kedudukan</th>
                  <th class="green-text material-font" style="width:1%">:</th>
                  <th class="green-text material-font"><?=$reqPegawaiKedudukan?></th>
                </tr>
               <tr>
                	<th class="green-text material-font">Keterangan Petugas Teknis</th>
                    <th class="green-text material-font">:</th>
                    <th colspan="4" class="green-text material-font">
                    <input type="text" class="easyui-validatebox" id="reqKeteranganTeknis" name="reqKeteranganTeknis" <?=$read?> value="<?=$reqKeteranganTeknis?>" />
                    </th>
                </tr>
                
            </thead>
          </table>
          
          <table class="bordered md-text table_list" id="link-table" style="margin-bottom:10px;">
                <thead> 
                    <tr class="ubah-color-warna">
                    	<th class="white-text material-font">Data KGB</th>
                    </tr>
                </thead>
                <tbody>
                	<tr>
                    	<td>
                            <div class="row">
                                <div class="input-field col s12 m6">
                                	<?
									if($reqStatusKgb == "" || $reqRevisi == "")
									{
                                    ?>
                                    <label for="reqGajiRiwayatLamaNama">Nomor Surat Dasar KGB</label>
                                    <input type="hidden" id="reqGajiRiwayatLamaId" name="reqGajiRiwayatLamaId" value="<?=$reqGajiRiwayatLamaId?>" />
                                    <input type="text" id="reqGajiRiwayatLamaNama" value="<?=$reqGajiRiwayatLamaNama?>" disabled />
                                    <?
									}
									else
									{
                                    ?>
                                    <select id="reqGajiRiwayatLamaId" name="reqGajiRiwayatLamaId" >
                                    <?
                                    for($index=0; $index < $jumlah_gaji_riwayat; $index++)
                                    {
										$tempGajiPppkRiwayatId= $arrPangkatRiwayat[$index]["GAJI_RIWAYAT_ID"];
										$tempNoSk= $arrPangkatRiwayat[$index]["NO_SK"];
									?>
                                    	<option value="<?=$tempGajiPppkRiwayatId?>" <? if($tempGajiPppkRiwayatId == $reqGajiRiwayatLamaId) echo "selected"?>><?=$tempNoSk?></option>
                                    <?
									}
                                    ?>
                                    </select>
                                    <label for="reqGajiRiwayatLamaId">Nomor Surat Dasar KGB</label>
                                    <?
									}
                                    ?>
                                    <input type="hidden" name="reqDataGajiPppkRiwayatId1" id="reqDataGajiPppkRiwayatId1" value="<?=$tempGajiPppkRiwayatId?>" />
                                    <input type="hidden" name="reqDataGajiPppkRiwayatId2" id="reqDataGajiPppkRiwayatId2" value="<?=$tempGajiPppkRiwayatId?>" />
                                </div>
                                <div class="input-field col s12 m3">
                                    <label for="reqRiwayatGajiLamaTanggal">Tanggal Dasar KGB</label>
                                    <input type="text" id="reqRiwayatGajiLamaTanggal" value="<?=$reqRiwayatGajiLamaTanggal?>" disabled />
                                </div>
                                <div class="input-field col s12 m3">
                                    <label for="reqRiwayatGajiLamaJenisRiwayat">Jenis Riwayat</label>
                                    <input type="text" id="reqRiwayatGajiLamaJenisRiwayat" value="<?=$reqRiwayatGajiLamaJenisRiwayat?>" disabled />
                                </div>
                            </div>
                            <div class="row">
                            	<div class="input-field col s12 m2">
                                    <label for="reqRiwayatGajiLamaGolKode">Gol</label>
                                    <input type="hidden" id="reqRiwayatGajiLamaGolId" name="reqRiwayatGajiLamaGolId" value="<?=$reqRiwayatGajiLamaGolId?>" />
                                    <input type="text" id="reqRiwayatGajiLamaGolKode" value="<?=$reqRiwayatGajiLamaGolKode?>" disabled />
                                </div>
                                <div class="input-field col s12 m2">
                                    <label for="reqRiwayatGajiLamaTmt">TMT Lama</label>
                                    <input type="text" id="reqRiwayatGajiLamaTmt" value="<?=$reqRiwayatGajiLamaTmt?>" disabled />
                                </div>
                                <div class="input-field col s12 m2">
                                    <label for="reqRiwayatGajiLamaMasaKerjaTahun">MK Tahun Lama</label>
                                    <input type="text" id="reqRiwayatGajiLamaMasaKerjaTahun" value="<?=$reqRiwayatGajiLamaMasaKerjaTahun?>" disabled />
                                </div>
                                <div class="input-field col s12 m2">
                                    <label for="reqRiwayatGajiLamaMasaKerjaBulan">MK Bulan Lama</label>
                                    <input type="text" id="reqRiwayatGajiLamaMasaKerjaBulan" value="<?=$reqRiwayatGajiLamaMasaKerjaBulan?>" disabled />
                                </div>
                                <div class="input-field col s12 m4">
                                    <label for="reqRiwayatGajiLamaGaji">Gapok Lama</label>
                                    <input type="text" id="reqRiwayatGajiLamaGaji" value="<?=$reqRiwayatGajiLamaGaji?>" disabled />
                                </div>
                            </div>
                            <div class="row">
            					<div class="input-field col s12 m8">
            						<label for="reqSatuanKerjaNama">Satuan Kerja</label>
                                    <?
									if($reqStatusKgb == "" || $reqRevisi == "")
									{
                                    ?>
                                    <input type="text" id="reqSatuanKerjaNama"  value="<?=$reqSatuanKerjaNama?>" class="easyui-validatebox" disabled />
                                    <?
									}
									else
									{
                                    ?>
            						<input type="text" id="reqSatuanKerjaNama"  name="reqSatuanKerjaNama" <?=$read?> value="<?=$reqSatuanKerjaNama?>" class="easyui-validatebox" required />
                                    <?
									}
                                    ?>
            						<input type="hidden" name="reqSatuanKerjaId" id="reqSatuanKerjaId" value="<?=$reqSatuanKerjaId?>" />
            					</div>
                                <div class="input-field col s12 m4">
                                    <label for="reqRiwayatGajiLamaPejabatPenetap">Pejabat Penetap</label>
                                    <input type="text" id="reqRiwayatGajiLamaPejabatPenetap" value="<?=$reqRiwayatGajiLamaPejabatPenetap?>" disabled />
                                </div>
            				</div>
                            <div class="row">&nbsp;</div>
                            <div class="row">
                            	<div class="input-field col s12 m2">
                                    <label for="reqRiwayatGajiBaruTmt">TMT KGB Baru</label>
                                    <input type="text" class="color-disb" id="reqRiwayatGajiBaruTmt" name="reqRiwayatGajiBaruTmt" value="<?=$reqRiwayatGajiBaruTmt?>" readonly />
                                </div>
                                <div class="input-field col s12 m2">
                                    <label for="reqRiwayatGajiBaruMasaKerjaTahun">MK Tahun</label>
                                    <input type="text" class="color-disb" id="reqRiwayatGajiBaruMasaKerjaTahun" name="reqRiwayatGajiBaruMasaKerjaTahun" value="<?=$reqRiwayatGajiBaruMasaKerjaTahun?>" readonly />
                                </div>
                                <div class="input-field col s12 m2">
                                    <label for="reqRiwayatGajiBaruMasaKerjaBulan">MK Bulan</label>
                                    <input type="text" class="color-disb" id="reqRiwayatGajiBaruMasaKerjaBulan" name="reqRiwayatGajiBaruMasaKerjaBulan" value="<?=$reqRiwayatGajiBaruMasaKerjaBulan?>" readonly />
                                </div>
                                <div class="input-field col s12 m6">
                                    <label for="reqRiwayatGajiBaruGaji">Gapok Pokok</label>
                                    <input type="text" class="color-disb" id="reqRiwayatGajiBaruGaji" name="reqRiwayatGajiBaruGaji" value="<?=$reqRiwayatGajiBaruGaji?>" readonly />
                                </div>
                            </div>
                            <?
							if($reqHukumanRiwayatId == ""){}
							else
							{
                            ?>
                            <div class="row">
                            	<div class="input-field col s12 m4">
                                    <label for="reqRiwayatHukumanNoSk">No SK Hukdis</label>
                                    <input type="text" id="reqRiwayatHukumanNoSk" value="<?=$reqRiwayatHukumanNoSk?>" disabled />
                                </div>
                                <div class="input-field col s12 m2">
                                    <label for="reqRiwayatHukumanTglSk">Tgl SK</label>
                                    <input type="text" id="reqRiwayatHukumanTglSk" value="<?=$reqRiwayatHukumanTglSk?>" disabled />
                                </div>
                            </div>
                            <div class="row">
                            	<div class="input-field col s12 m8">
                                    <label for="reqRiwayatHukumanKeterangan">Keterangan Hukdis</label>
                                    <input type="text" id="reqRiwayatHukumanKeterangan" value="<?=$reqRiwayatHukumanKeterangan?>" disabled />
                                </div>
                                <div class="input-field col s12 m4">
                                    <label for="reqRiwayatHukumanKenaikanGajiBerikutnya">TMT Dibayar Berikutnya</label>
                                    <input type="text" id="reqRiwayatHukumanKenaikanGajiBerikutnya" value="<?=$reqRiwayatHukumanKenaikanGajiBerikutnya?>" disabled />
                                </div>
                            </div>
                            <?
							}
                            ?>
                            <div class="row">&nbsp;</div>
                            <div class="row">
                            	<div class="input-field col s12 m3">
                                    <label for="reqRiwayatGajiBaruTanggalBaru">Tgl Surat KGB Baru</label>
                                    <input class="color-disb" type="text" id="reqRiwayatGajiBaruTanggalBaru" name="reqRiwayatGajiBaruTanggalBaru" value="<?=$reqRiwayatGajiBaruTanggalBaru?>" readonly />
                                </div>
                                <?
                                if($reqStatusKgb == "" || $reqRevisi == "1")
								{
								?>
                                <div class="input-field col s12 m3">
                                <button class="btn waves-effect waves-light green" style="font-size:9pt" type="button" id="reqcek"
                                onClick="parent.openModal('app/loadUrl/persuratan/surat_keluar_kgb_informasi?reqBulanData=<?=$reqBulan?>&reqTahunData=<?=$reqTahun?>&reqBulan=<?=$reqBulan?>&reqTahun=<?=$reqTahun?>&reqStatusPilih=1&reqJenis=5&reqBreadCrum=Data Surat Keluar')" >
                                Cek
                                <i class="mdi-content-save left hide-on-small-only"></i>
                                </button>
                                </div>
                                <?
								}
                                ?>
                            </div>
                            <div class="row">
                            	<div class="input-field col s12 m3">
                                    <label for="reqNomorAwal">No Agenda Surat Keluar</label>
                                    <input placeholder type="text" id="reqNomorAwal" value="<?=$reqNomorAwal?>" disabled />
                                </div>
                                <?
								if($reqStatusKgb == ""){}
								else
								{
                                ?>
                                <div class="input-field col s12 m2" id="reqNomorUrutLabel">
                                    <label for="reqNomorUrut">Nomor Urut</label>
                                    <?php /*?><?
									if($reqRevisi == "1")
									{
                                    ?>
                                    <input placeholder type="text" id="reqNomorUrut" name="reqNomorUrut" value="<?=$reqNomorUrut?>" class="easyui-validatebox" required />
                                    <?
									}
									else
									{
                                    ?><?php */?>
            						<input placeholder type="text" id="reqNomorUrut" name="reqNomorUrut" value="<?=$reqNomorUrut?>" class="easyui-validatebox color-disb" readonly />
                                    <?php /*?><?
									}
                                    ?><?php */?>
                                </div>
                                <?
								}
                                ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
          </table>
          	<?
			if($reqStatusKgb=="")
			{
				if($reqNomorAwal == "" && $reqStatusHitungUlang != "1"){}
				else
				{
					if($reqPegawaiNip == ""){}
					else
					{
            ?>
          	<button class="btn waves-effect waves-light yellow" style="font-size:9pt" type="button" id="reqproses">
            	Proses
                <i class="mdi-content-inbox left hide-on-small-only"></i>
            </button>
            <?
            		}
				}
			}
			elseif($reqRevisi == "1")
			{
			?>
			<button class="btn waves-effect waves-light pink" style="font-size:9pt" type="button" id="reqproses">
            	Simpan Revisi
                <i class="mdi-content-inbox left hide-on-small-only"></i>
            </button>
            <button class="btn waves-effect waves-light pink" style="font-size:9pt" type="button" id="reqrevisibatal">
            	Close
                <i class="mdi-content-inbox left hide-on-small-only"></i>
            </button>
			<?
			}
            elseif($reqStatusKgb == "2")
			{
			?>
            <?
			if($reqStatusHitungUlang == "1"){}
			else
			{
            ?>
            <button class="btn waves-effect waves-light green" style="font-size:9pt" type="button" id="reqselesai">
            	Selesai
                <i class="mdi-content-inbox left hide-on-small-only"></i>
            </button>
            <?
			}
            ?>
            
            <?
			if($reqStatusHitungUlang == "1"){}
			else
			{
            ?>
            <button class="btn waves-effect waves-light blue" style="font-size:9pt" type="button" id="reqcetak">
            	Cetak
                <i class="mdi-content-inbox left hide-on-small-only"></i>
            </button>
            <?
			}
            ?>
            
            <?
			if($reqStatusHitungUlang == "1")
			{
            ?>
          	<button class="btn waves-effect waves-light pink" style="font-size:9pt" type="button" id="reqrevisi">
            	Revisi
                <i class="mdi-content-inbox left hide-on-small-only"></i>
            </button>
            <?
			}
            ?>

            <?
            if($reqStatusKgb == "3"){}
            else
            {
            ?>
            <button class="btn waves-effect waves-light red" style="font-size:9pt" type="button" id="reqbatal">
            	Batal
                <i class="mdi-content-inbox left hide-on-small-only"></i>
            </button>
            <?
        	}
            ?>

            <?
			}
			elseif($reqStatusKgb == "3")
			{
				if($sesloginlevel == "30")
            	{
			?>
				<button class="btn waves-effect waves-light red" style="font-size:9pt" type="button" id="reqbatal">
	            	Batal
	            	<i class="mdi-content-inbox left hide-on-small-only"></i>
	            </button>
			<?
				}
			?>
          	<button class="btn waves-effect waves-light pink" style="font-size:9pt" type="button" id="reqrevisi">
            	Revisi
                <i class="mdi-content-inbox left hide-on-small-only"></i>
            </button>
            
            <?
			if($reqStatusHitungUlang == "1"){}
			else
			{
            ?>
            <button class="btn waves-effect waves-light blue" style="font-size:9pt" type="button" id="reqcetak">
            	Cetak
                <i class="mdi-content-inbox left hide-on-small-only"></i>
            </button>
            <?
			}
            ?>
            
            <?
            if($reqStatusKgb == "3"){}
            else
            {
            ?>
            <button class="btn waves-effect waves-light red" style="font-size:9pt" type="button" id="reqbatal">
            	Batal
                <i class="mdi-content-inbox left hide-on-small-only"></i>
            </button>
            <?
        	}
            ?>

            <?
			}
            ?>
			<?php /*?><button class="btn pink waves-effect waves-light" style="font-size:9pt" type="button" id="reqcetaksuratkeluar">Cetak Ijin Belajar
                <i class="mdi-content-inbox left hide-on-small-only"></i>
            </button>
            <button class="btn blue waves-effect waves-light" style="font-size:9pt" type="button" id="reqbatalusulnomor">BTL Usul No IB
                <i class="mdi-content-save left hide-on-small-only"></i>
            </button><?php */?>
            
            <?
			if($reqRevisi == "1"){}
			else
			{
            ?>
            <button class="btn red waves-effect waves-light" style="font-size:9pt" type="button" id="tambah" onClick="parent.closeparenttab()">Close
               <i class="mdi-navigation-close left hide-on-small-only"></i>
            </button>
            <?
			}
            ?>
            <input type="hidden" name="reqMode" id="reqMode" />
            <input type="hidden" name="reqStatusKgb" id="reqStatusKgb" />
            <input type="hidden" name="reqStatusHitungUlang" id="reqStatusHitungUlang" value="<?=$reqStatusHitungUlang?>" />
            <input type="hidden" name="reqSuratKeluarBkdLamaId" id="reqSuratKeluarBkdLamaId" value="<?=$reqSuratKeluarBkdId?>" />
            <input type="hidden" name="reqSuratKeluarBkdId" id="reqSuratKeluarBkdId" value="<?=$reqSuratKeluarBkdId?>" />
            <input type="hidden" name="reqPeriodeLama" id="reqPeriodeLama" value="<?=$reqPeriodeLama?>" />
            <input type="hidden" name="reqJabatanRiwayatId" id="reqJabatanRiwayatId" value="<?=$reqJabatanRiwayatId?>" />
            <input type="hidden" name="reqHukumanRiwayatId" id="reqHukumanRiwayatId" value="<?=$reqHukumanRiwayatId?>" />
            <input type="hidden" name="reqGajiRiwayatBaruId" id="reqGajiRiwayatBaruId" value="<?=$reqGajiRiwayatBaruId?>" />
            <input type="hidden" name="reqPegawaiStatusId" id="reqPegawaiStatusId" value="<?=$reqPegawaiStatusId?>" />
            <input type="hidden" name="reqPeriode" id="reqPeriode" value="<?=$reqPeriode?>" />
            <input type="hidden" name="reqPegawaiId" value="<?=$reqPegawaiId?>" />
          </form>
          
        </div>    
       </li>
     </ul>
   </div>
 </div>
</div>

<link href="lib/materializetemplate/css/materializeslide.css" rel="stylesheet" />
<script src="lib/materializetemplate/js/materializeslide.min.js"></script>

<script>
function setRevisiButton(mode)
{
	if(mode == 1)
	{
		$("#reqSatuanKerjaNama,#reqGajiRiwayatLamaId").prop("readonly", false);
	}
	//color-disb;reqGajiRiwayatLamaId;reqSatuanKerjaNama
}

$(document).ready( function () {
	$('select').material_select();
	
	$("#reqcetak").click(function() { 
	  var requrl= requrllist= "";
	  requrl= "format_berkala_hukdis";

	  // var url= 'kenaikan_gaji_berkala_cetak_sk_rpt?reqJenis=1&reqBulan=<?=$reqBulan?>&reqTahun=<?=$reqTahun?>&reqPegawaiId=<?=$reqPegawaiId?>';
	  // newWindow = window.open("app/loadUrl/app/"+url, 'Cetak');
	  var url= 'template?reqJenis=1&reqBulan=<?=$reqBulan?>&reqTahun=<?=$reqTahun?>&reqPegawaiId=<?=$reqPegawaiId?>&reqLink=kenaikan_gaji_berkala_cetak_sk_pdf';
	  newWindow = window.open("app/loadUrl/report/"+url, 'Cetak');
	  newWindow.focus();

	  // newWindow = window.open("app/loadUrl/persuratan/cetak_pdf?reqCss=format_export&reqUrl="+requrl+"&reqUrlList="+requrllist+"&reqPegawaiId=<?=$reqPegawaiId?>&reqPeriode=<?=$reqPeriodeLama?>", 'Cetak');
	  // newWindow.focus();
	});
	
	$("#reqbatal").click(function() {
		info= "Apakah yakin untuk batal ?";
		   mbox.custom({
		   message: info,
		   options: {close_speed: 100},
		   buttons: [
			   {
				   label: 'Ya',
				   color: 'green darken-2',
				   callback: function() {
					var reqBulan= reqTahun= "";
					reqBulan= "<?=$reqBulan?>";
					reqTahun= "<?=$reqTahun?>";
					
					$.ajax({'url': "kenaikan_gaji_pppk_berkala_json/batal/?reqPegawaiId=<?=$reqPegawaiId?>&reqBulan="+reqBulan+"&reqTahun="+reqTahun,'success': function(datahtml) {
						mbox.close();
					    top.closeparenttab();
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
		
	});
	
	$("#reqrevisi,#reqrevisibatal").click(function() {
		var id= $(this).attr('id');
		if(id == "reqrevisi")
		document.location.href= "app/loadUrl/app/kenaikan_gaji_pppk_berkala_add_data?reqPegawaiId=<?=$reqPegawaiId?>&reqBulan=<?=$reqBulan?>&reqTahun=<?=$reqTahun?>&reqRevisi=1";
		else
		document.location.href= "app/loadUrl/app/kenaikan_gaji_pppk_berkala_add_data?reqPegawaiId=<?=$reqPegawaiId?>&reqBulan=<?=$reqBulan?>&reqTahun=<?=$reqTahun?>";
	});
	
	$("#reqproses,#reqselesai").click(function() {
	var id= $(this).attr('id');
	reqSuratKeluarBkdId= $("#reqSuratKeluarBkdId").val();
	reqSuratKeluarBkdLamaId= $("#reqSuratKeluarBkdLamaId").val();
	reqPeriode= $("#reqPeriode").val();
	reqPeriodeLama= $("#reqPeriodeLama").val();
	
	reqStatusHitungUlang= "<?=$reqStatusHitungUlang?>";
	 
	//var element= id.split('reqlogcetaksuratkeluar');
	//var reqrowid= element[1];
	//alert(id);return false;
	//var s_url= "surat/surat_masuk_pegawai_json/btl_surat?reqPegawaiId=<?=$reqRowId?>";
	//$.ajax({'url': s_url,'success': function(dataajax){
		if(reqSuratKeluarBkdId == '' && reqStatusHitungUlang != "1")
		{
			mbox.alert('Pilih Nomor Agenda Surat terlebih dahulu', {open_speed: 0});
			return false;
		}
		else
		{
			reqRiwayatGajiLamaTanggal= $("#reqRiwayatGajiLamaTanggal").val();
			reqRiwayatGajiBaruTanggalBaru= $("#reqRiwayatGajiBaruTanggalBaru").val();
			
			var dt1= parseInt(reqRiwayatGajiLamaTanggal.substring(0,2),10); 
			var mon1= parseInt(reqRiwayatGajiLamaTanggal.substring(3,5),10) - 1;
			var yr1= parseInt(reqRiwayatGajiLamaTanggal.substring(6,10),10); 
			var dt2= parseInt(reqRiwayatGajiBaruTanggalBaru.substring(0,2),10); 
			var mon2= parseInt(reqRiwayatGajiBaruTanggalBaru.substring(3,5),10) - 1; 
			var yr2= parseInt(reqRiwayatGajiBaruTanggalBaru.substring(6,10),10);
			
			var dateMulai= new Date(yr1, mon1, dt1);
			var dateAkhir= new Date(yr2, mon2, dt2);
			if(dateMulai > dateAkhir)
			{
				mbox.alert('Ubah dulu tanggal surat KGB baru, karena tanggal dasar KGB tidak boleh lebih besar dari tanggal surat KGB baru', {open_speed: 0});
				return false;
			}
			//return false;
			
			mode= "update";
			if(id == "reqselesai")
			{
				info= "Apakah yakin untuk menyimpan data, jadi selesai ?";
				mode= "updateselesai";
			}
			else
			info= "Apakah yakin untuk proses data ?";
			
			// alert(reqPeriodeLama+" == "+reqPeriode); return false;

			if(reqPeriodeLama == reqPeriode){}
			else
			{
				mode= "insert";
				//info= "Apakah yakin untuk menyimpan data, ubah periode ?";
				info= "TMT KGB berubah, Apakah anda yakin Proses KGB dibatalkan dan dihapus?";
				
				mbox.custom({
				   message: info,
				   options: {close_speed: 100},
				   buttons: [
					   {
						   label: 'Ya',
						   color: 'green darken-2',
						   callback: function() {
							    var reqBulan= reqTahun= "";
								reqBulan= "<?=$reqBulan?>";
								reqTahun= "<?=$reqTahun?>";
								
								$.ajax({'url': "kenaikan_gaji_pppk_berkala_json/batal/?reqPegawaiId=<?=$reqPegawaiId?>&reqBulan="+reqBulan+"&reqTahun="+reqTahun,'success': function(datahtml) {
									mbox.close();
									top.closeparenttab();
								}});
								return false;
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
				
				return false;
			}
			//+reqPeriodeLama+" == "+reqPeriode
			$("#reqMode").val(mode);

			// alert($("#reqMode").val()); return false;

			
			reqStatusKgb= "";
			if(id == "reqproses")
			{
			<?
			if($reqStatusKgb == "3")
			{
			?>
			reqStatusKgb= "3";
			//mode= "updateselesai";
			//$("#reqMode").val(mode);
			<?
			}
			else
			{
			?>
			reqStatusKgb= "2";
			<?
			}
			?>
			}
			else if(id == "reqselesai")
			reqStatusKgb= "3";
			
			$("#reqStatusKgb").val(reqStatusKgb);
			mbox.custom({
			   message: info,
			   options: {close_speed: 100},
			   buttons: [
				   {
					   label: 'Ya',
					   color: 'green darken-2',
					   callback: function() {
						   $("#ff").submit();
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
	//}});
	
	});
	
	$("#kembali").click(function() { 
	  document.location.href = "app/loadUrl/app/surat_masuk_teknis_add_pegawai?reqPegawaiId=<?=$reqPegawaiId?>&reqJenis=<?=$reqJenis?>";
	});
	
});

function iframeLoaded() {
	var iFrameID= document.getElementById('mainFrame');
	if(iFrameID) {
			// here you can make the height, I delete it first, then I make it again
			iFrameID.height = "";
			iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
	}
}
</script>

<link rel="stylesheet" href="lib/AdminLTE-2.4.0-rc/dist/css/skins/ubah-skin.css">
<script src="lib/AdminLTE-2.4.0-rc/dist/js/ubah-skin.js"></script>

</body>
</html>