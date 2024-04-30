<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  // include_once('Entity.php');
  include_once(APPPATH.'/models/Entity.php');
  
  class KenaikanGajiPppkBerkala extends Entity{ 

	var $query;
  	var $id;
    /**
    * Class constructor.
    **/
    function KenaikanGajiPppkBerkala()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			INSERT INTO KENAIKAN_GAJI_BERKALA
			(
				PERIODE, PEGAWAI_ID, PEGAWAI_STATUS_ID, JABATAN_RIWAYAT_ID, PANGKAT_RIWAYAT_LAMA_ID, STATUS_HITUNG_ULANG,
				GAJI_RIWAYAT_LAMA_ID, PANGKAT_RIWAYAT_BARU_ID, HUKUMAN_RIWAYAT_ID, SURAT_KELUAR_BKD_ID, NOMOR_URUT, KETERANGAN_TEKNIS, TANGGAL_BARU, TMT_BARU, MASA_KERJA_TAHUN_BARU, MASA_KERJA_BULAN_BARU, GAJI_POKOK_DETIL_ID, GAJI_BARU, SATUAN_KERJA_ID, STATUS_KGB, STATUS, LAST_USER, LAST_DATE, LAST_LEVEL, USER_LOGIN_ID, USER_LOGIN_PEGAWAI_ID
			)
			VALUES (
				'".$this->getField("PERIODE")."',
				".$this->getField("PEGAWAI_ID").",
				".$this->getField("PEGAWAI_STATUS_ID").",
				".$this->getField("JABATAN_RIWAYAT_ID").",
				".$this->getField("PANGKAT_RIWAYAT_LAMA_ID").",
				".$this->getField("STATUS_HITUNG_ULANG").",
				".$this->getField("GAJI_RIWAYAT_LAMA_ID").",
				".$this->getField("PANGKAT_RIWAYAT_BARU_ID").",
				".$this->getField("GAJI_RIWAYAT_BARU_ID").",
				".$this->getField("SURAT_KELUAR_BKD_ID").",
				".$this->getField("HUKUMAN_RIWAYAT_ID").",
				".$this->getField("SURAT_KELUAR_BKD_ID").",
				".$this->getField("NOMOR_URUT").",
				".$this->getField("KETERANGAN_TEKNIS").",
				".$this->getField("TANGGAL_BARU").",
				".$this->getField("TMT_BARU").",
				".$this->getField("MASA_KERJA_TAHUN_BARU").",
				".$this->getField("MASA_KERJA_BULAN_BARU").",
				".$this->getField("GAJI_POKOK_DETIL_ID").",
				".$this->getField("GAJI_BARU").",
				".$this->getField("SATUAN_KERJA_ID").",
				".$this->getField("STATUS_KGB").",
				".$this->getField("STATUS").",
				'".$this->getField("LAST_USER")."',
				".$this->getField("LAST_DATE").",
				".$this->getField("LAST_LEVEL").",
				".$this->getField("USER_LOGIN_ID").",
				".$this->getField("USER_LOGIN_PEGAWAI_ID")."
			)
		"; 	
		//$this->id = $this->getField("AGAMA_ID");
		//echo $str;exit;
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	/** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","MASTER_KATEGORI_METODE_EVALUASI_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
	function prosesKgb()
	{
        $str = "
		SELECT PROSESKENAIKANBERKALA('".$this->getField("PERIODE")."', ".$this->getField("SATKERID").", '".$this->getField("LAST_USER")."', ".$this->getField("LAST_LEVEL").")
		"; 
		$this->query = $str;
		// echo $str;exit();
        return $this->execQuery($str);
    }
	
	function prosesPersonalKgb()
	{
        $str = "
		SELECT PROSESKENAIKANBERKALAPEGAWAI('".$this->getField("PERIODE")."', ".$this->getField("PEGAWAI_ID").", '".$this->getField("LAST_USER")."', ".$this->getField("LAST_LEVEL").")
		"; 
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
	
	function updateStatusHitung()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "		
				UPDATE KENAIKAN_GAJI_BERKALA
				SET 	
				   STATUS_HITUNG_ULANG= 1,
			       LAST_USER= '".$this->getField("LAST_USER")."',
			       LAST_DATE= ".$this->getField("LAST_DATE").",
			       USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID").",
			       USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
				WHERE PERIODE= '".$this->getField("PERIODE")."' AND PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
				"; 
		$this->query = $str;
		//echo $str;exit;
		return $this->execQuery($str);
    }
	
	function updateResetStatusHitung()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "		
				UPDATE KENAIKAN_GAJI_BERKALA
				SET 	
				   STATUS_HITUNG_ULANG= NULL,
			       LAST_USER= '".$this->getField("LAST_USER")."',
			       LAST_DATE= ".$this->getField("LAST_DATE").",
			       USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID").",
			       USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
				WHERE PERIODE= '".$this->getField("PERIODE")."' AND PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
				"; 
		$this->query = $str;
		//echo $str;exit;
		return $this->execQuery($str);
    }
	
	function update()
	{
		$str = "		
				UPDATE KENAIKAN_GAJI_BERKALA
				SET 	
				   GAJI_RIWAYAT_LAMA_ID= ".$this->getField("GAJI_RIWAYAT_LAMA_ID").",
				   SURAT_KELUAR_BKD_ID= ".$this->getField("SURAT_KELUAR_BKD_ID").",
				   NOMOR_URUT= ".$this->getField("NOMOR_URUT").",
				   KETERANGAN_TEKNIS= '".$this->getField("KETERANGAN_TEKNIS")."',
				   TANGGAL_BARU= ".$this->getField("TANGGAL_BARU").",
				   TMT_BARU= ".$this->getField("TMT_BARU").",
				   MASA_KERJA_TAHUN_BARU= ".$this->getField("MASA_KERJA_TAHUN_BARU").",
				   MASA_KERJA_BULAN_BARU= ".$this->getField("MASA_KERJA_BULAN_BARU").",
				   GAJI_BARU= ".$this->getField("GAJI_BARU").",
				   SATUAN_KERJA_ID= ".$this->getField("SATUAN_KERJA_ID").",
			       STATUS_KGB= ".$this->getField("STATUS_KGB").",
			       LAST_USER= '".$this->getField("LAST_USER")."',
			       LAST_DATE= ".$this->getField("LAST_DATE").",
			       USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID").",
			       USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
				WHERE PERIODE= '".$this->getField("PERIODE")."' AND PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
				"; 
		$this->query = $str;
		//echo $str;exit;
		return $this->execQuery($str);
    }
	
	function updateSetNomor()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "		
				UPDATE KENAIKAN_GAJI_BERKALA
				SET 	
				   GAJI_RIWAYAT_LAMA_ID= ".$this->getField("GAJI_RIWAYAT_LAMA_ID").",
				   SURAT_KELUAR_BKD_ID= ".$this->getField("SURAT_KELUAR_BKD_ID").",
				   NOMOR_URUT= (SELECT COALESCE((SELECT MAX(COALESCE(NOMOR_URUT,0)) + 1 DATA_NOMOR FROM kenaikan_gaji_berkala A WHERE 1=1 AND A.SURAT_KELUAR_BKD_ID = ".$this->getField("SURAT_KELUAR_BKD_ID")."),1)),
				   KETERANGAN_TEKNIS= '".$this->getField("KETERANGAN_TEKNIS")."',
				   TANGGAL_BARU= ".$this->getField("TANGGAL_BARU").",
				   TMT_BARU= ".$this->getField("TMT_BARU").",
				   MASA_KERJA_TAHUN_BARU= ".$this->getField("MASA_KERJA_TAHUN_BARU").",
				   MASA_KERJA_BULAN_BARU= ".$this->getField("MASA_KERJA_BULAN_BARU").",
				   GAJI_BARU= ".$this->getField("GAJI_BARU").",
				   SATUAN_KERJA_ID= ".$this->getField("SATUAN_KERJA_ID").",
			       STATUS_KGB= ".$this->getField("STATUS_KGB").",
			       LAST_USER= '".$this->getField("LAST_USER")."',
			       LAST_DATE= ".$this->getField("LAST_DATE").",
			       USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID").",
			       USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
				WHERE PERIODE= '".$this->getField("PERIODE")."' AND PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
				"; 
		$this->query = $str;
		//echo $str;exit;
		return $this->execQuery($str);
    }
	
	function updateSelesai()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE KENAIKAN_GAJI_BERKALA
				SET 	
				   GAJI_RIWAYAT_LAMA_ID= ".$this->getField("GAJI_RIWAYAT_LAMA_ID").",
				   GAJI_RIWAYAT_BARU_ID= (SELECT MAX(COALESCE(GAJI_RIWAYAT_ID,0)) + 1 FROM GAJI_RIWAYAT A WHERE 1=1),
				   SURAT_KELUAR_BKD_ID= ".$this->getField("SURAT_KELUAR_BKD_ID").",
				   NOMOR_URUT= ".$this->getField("NOMOR_URUT").",
				   KETERANGAN_TEKNIS= '".$this->getField("KETERANGAN_TEKNIS")."',
				   TANGGAL_BARU= ".$this->getField("TANGGAL_BARU").",
				   TMT_BARU= ".$this->getField("TMT_BARU").",
				   MASA_KERJA_TAHUN_BARU= ".$this->getField("MASA_KERJA_TAHUN_BARU").",
				   MASA_KERJA_BULAN_BARU= ".$this->getField("MASA_KERJA_BULAN_BARU").",
				   GAJI_BARU= ".$this->getField("GAJI_BARU").",
				   SATUAN_KERJA_ID= ".$this->getField("SATUAN_KERJA_ID").",
			       STATUS_KGB= ".$this->getField("STATUS_KGB").",
			       LAST_USER= '".$this->getField("LAST_USER")."',
			       LAST_DATE= ".$this->getField("LAST_DATE").",
			       USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID").",
			       USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
				WHERE PERIODE= '".$this->getField("PERIODE")."' AND PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
				"; 
		$this->query = $str;
		//echo $str;exit;
		return $this->execQuery($str);
    }
	
	function updateStatus()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "		
				UPDATE KENAIKAN_GAJI_BERKALA
				SET 	
				   STATUS		= ".$this->getField("STATUS").",
			       STATUS_KGB	= ".$this->getField("STATUS_KGB").",
			       LAST_USER	= '".$this->getField("LAST_USER")."',
			       LAST_DATE	= ".$this->getField("LAST_DATE").",
			       USER_LOGIN_ID	= ".$this->getField("USER_LOGIN_ID").",
			       USER_LOGIN_PEGAWAI_ID	= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
				WHERE PERIODE	= '".$this->getField("PERIODE")."' AND PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
				"; 
		$this->query = $str;
		//echo $str;exit;
		return $this->execQuery($str);
    }
	
	function updateQrCode()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "		
				UPDATE KENAIKAN_GAJI_BERKALA
				SET 	
			       QR_CODE	= '".$this->getField("QR_CODE")."'
				WHERE PERIODE	= '".$this->getField("PERIODE")."' AND PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
				"; 
		$this->query = $str;
		//echo $str;exit;
		return $this->execQuery($str);
    }
	
	function updateBatal()
	{
		// echo "--";exit();
		/*Auto-generate primary key(s) by next max value (integer) */
		$str1= "
				UPDATE KENAIKAN_GAJI_BERKALA
				SET 	
				   STATUS_KGB= NULL
				WHERE PERIODE= '".$this->getField("PERIODE")."' AND PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
				"; 
		$this->query = $str1;
		//echo $str1;exit;
		$this->execQuery($str1);

		$str11= "
				UPDATE KENAIKAN_GAJI_BERKALA
				SET
				   STATUS_KGB= NULL
				WHERE GAJI_RIWAYAT_BARU_ID = (SELECT GAJI_RIWAYAT_BARU_ID FROM KENAIKAN_GAJI_BERKALA WHERE PERIODE= '".$this->getField("PERIODE")."' AND PEGAWAI_ID= ".$this->getField("PEGAWAI_ID").")
				";
		$this->query = $str11;
		//echo $str1;exit;
		$this->execQuery($str11);
		
		$str2= "		
				UPDATE GAJI_RIWAYAT
				SET    
					   STATUS   	= ".$this->getField("STATUS").",
					   LAST_USER	= '".$this->getField("LAST_USER")."',
					   LAST_LEVEL	= ".$this->getField("LAST_LEVEL").",
					   LAST_DATE	= ".$this->getField("LAST_DATE").",
					   USER_LOGIN_ID	= ".$this->getField("USER_LOGIN_ID").",
					   USER_LOGIN_PEGAWAI_ID	= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
				WHERE  GAJI_RIWAYAT_ID= (SELECT GAJI_RIWAYAT_BARU_ID FROM KENAIKAN_GAJI_BERKALA WHERE PERIODE= '".$this->getField("PERIODE")."' AND PEGAWAI_ID= ".$this->getField("PEGAWAI_ID").")
				"; 
		$this->query = $str2;
		// echo $str2;exit;
		$this->execQuery($str2);
		
		$str3= "
		SELECT PROSESKENAIKANBERKALAPEGAWAI('".$this->getField("PERIODE")."', ".$this->getField("PEGAWAI_ID").", '".$this->getField("LAST_USER")."', ".$this->getField("LAST_LEVEL").")
		"; 
		$this->query = $str3;
		//echo $str3;exit;
        return $this->execQuery($str3);
		//echo $str;exit;
    }
	
	function insertGajiRiwayat()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("GAJI_RIWAYAT_ID", $this->getNextId("GAJI_RIWAYAT_ID","GAJI_RIWAYAT"));
     	$str = "
			INSERT INTO GAJI_RIWAYAT (
				GAJI_RIWAYAT_ID, PEGAWAI_ID, PEJABAT_PENETAP_ID, PEJABAT_PENETAP, PANGKAT_ID, NO_SK,
				TANGGAL_SK, TMT_SK, MASA_KERJA_TAHUN, MASA_KERJA_BULAN, GAJI_POKOK, JENIS_KENAIKAN, LAST_USER
				, LAST_DATE, LAST_LEVEL, USER_LOGIN_ID, USER_LOGIN_PEGAWAI_ID
			) 
			VALUES (
				  (
				  SELECT 
				  A.GAJI_RIWAYAT_BARU_ID
				  FROM KENAIKAN_GAJI_BERKALA A
				  WHERE A.STATUS_KGB = '3' AND A.PERIODE= '".$this->getField("PERIODE")."' AND A.PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
				  ),
				  ".$this->getField("PEGAWAI_ID").",
				  ".$this->getField("PEJABAT_PENETAP_ID").",
				  '".$this->getField("PEJABAT_PENETAP")."',
				  ".$this->getField("PANGKAT_ID").",
				  (
				  SELECT 
				  CONCAT(SPLIT_PART(B.NOMOR, '/', 1), '/', SPLIT_PART(B.NOMOR, '/', 2), '.', CAST(A.NOMOR_URUT AS TEXT), '/', SPLIT_PART(B.NOMOR, '/', 3), '/', SPLIT_PART(B.NOMOR, '/', 4))
				  FROM KENAIKAN_GAJI_BERKALA A
				  INNER JOIN PERSURATAN.SURAT_KELUAR_BKD B ON A.SURAT_KELUAR_BKD_ID = B.SURAT_KELUAR_BKD_ID
				  WHERE A.STATUS_KGB = '3' AND A.PERIODE= '".$this->getField("PERIODE")."' AND A.PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
				  ),
				  ".$this->getField("TANGGAL_SK").",
				  ".$this->getField("TMT_SK").",
				  ".$this->getField("MASA_KERJA_TAHUN").",
				  ".$this->getField("MASA_KERJA_BULAN").",
				  ".$this->getField("GAJI_POKOK").",
				  ".$this->getField("JENIS_KENAIKAN").",
				  '".$this->getField("LAST_USER")."',
				  ".$this->getField("LAST_DATE").",
				  ".$this->getField("LAST_LEVEL").",
				  ".$this->getField("USER_LOGIN_ID").",
				  ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
			)
		";
		
		$this->id = $this->getField("GAJI_RIWAYAT_ID");
		$this->query = $str;
		//echo $str;exit;
		return $this->execQuery($str);
    }

    function updateGajiRiwayat()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "		
				UPDATE GAJI_RIWAYAT
				SET    
				  PEGAWAI_ID= ".$this->getField("PEGAWAI_ID").",
				  PEJABAT_PENETAP_ID= ".$this->getField("PEJABAT_PENETAP_ID").",
				  PEJABAT_PENETAP= '".$this->getField("PEJABAT_PENETAP")."',
				  PANGKAT_ID= ".$this->getField("PANGKAT_ID").",
				  NO_SK= (
				  SELECT 
				  CONCAT(SPLIT_PART(B.NOMOR, '/', 1), '/', SPLIT_PART(B.NOMOR, '/', 2), '.', CAST(A.NOMOR_URUT AS TEXT), '/', SPLIT_PART(B.NOMOR, '/', 3), '/', SPLIT_PART(B.NOMOR, '/', 4))
				  FROM KENAIKAN_GAJI_BERKALA A
				  INNER JOIN PERSURATAN.SURAT_KELUAR_BKD B ON A.SURAT_KELUAR_BKD_ID = B.SURAT_KELUAR_BKD_ID
				  WHERE A.STATUS_KGB = '3' AND A.PERIODE= '".$this->getField("PERIODE")."' AND A.PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
				  ),
				  TANGGAL_SK= ".$this->getField("TANGGAL_SK").",
				  TMT_SK= ".$this->getField("TMT_SK").",
				  MASA_KERJA_TAHUN= ".$this->getField("MASA_KERJA_TAHUN").",
				  MASA_KERJA_BULAN= ".$this->getField("MASA_KERJA_BULAN").",
				  GAJI_POKOK= ".$this->getField("GAJI_POKOK").",
				  JENIS_KENAIKAN= ".$this->getField("JENIS_KENAIKAN").",
				  LAST_USER= '".$this->getField("LAST_USER")."',
				  LAST_DATE= ".$this->getField("LAST_DATE").",
				  LAST_LEVEL= ".$this->getField("LAST_LEVEL").",
				  USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID").",
				  USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
				WHERE  GAJI_RIWAYAT_ID = ".$this->getField("GAJI_RIWAYAT_ID")."
				"; 
		$this->query = $str;
		//echo $str;exit;
		return $this->execQuery($str);
    }

    function updateStatusGajiRiwayat()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "		
				UPDATE GAJI_RIWAYAT
				SET    
					   STATUS   	= ".$this->getField("STATUS").",
					   LAST_USER	= '".$this->getField("LAST_USER")."',
					   LAST_LEVEL	= ".$this->getField("LAST_LEVEL").",
					   LAST_DATE	= ".$this->getField("LAST_DATE").",
					   USER_LOGIN_ID	= ".$this->getField("USER_LOGIN_ID").",
					   USER_LOGIN_PEGAWAI_ID	= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
				WHERE  GAJI_RIWAYAT_ID    	= ".$this->getField("GAJI_RIWAYAT_ID")."
				"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order='')
	{
		$str = "
		SELECT
			A.PERIODE, A.PEGAWAI_ID, A.PEGAWAI_STATUS_ID, A.JABATAN_RIWAYAT_ID, A.PANGKAT_RIWAYAT_LAMA_ID, 
			A.GAJI_RIWAYAT_LAMA_ID, A.PANGKAT_RIWAYAT_BARU_ID, A.GAJI_RIWAYAT_BARU_ID, 
			A.HUKUMAN_RIWAYAT_ID, A.SURAT_KELUAR_BKD_ID, A.NOMOR_URUT, A.KETERANGAN_TEKNIS, A.TANGGAL_BARU, A.TMT_BARU, A.MASA_KERJA_TAHUN_BARU, 
			A.MASA_KERJA_BULAN_BARU, A.GAJI_BARU, A.SATUAN_KERJA_ID, A.STATUS_KGB, 
			A.STATUS, A.LAST_USER, A.LAST_DATE, A.LAST_LEVEL
		FROM KENAIKAN_GAJI_BERKALA A
		WHERE 1 = 1
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsInfoTotal($periode="", $statement='')
	{
		$str = "
		SELECT
		(SELECT COUNT(1) FROM KENAIKAN_GAJI_BERKALA A WHERE 1=1 AND A.PERIODE = '".$periode."' ".$statement." ) JUMLAH_DATA_KGB
		, (SELECT COUNT(1) FROM KENAIKAN_GAJI_BERKALA A WHERE 1=1 AND A.STATUS_KGB = '2' AND A.PERIODE = '".$periode."' ".$statement." ) JUMLAH_DATA_KGB_PROSES
		, (SELECT COUNT(1) FROM KENAIKAN_GAJI_BERKALA A WHERE 1=1 AND A.STATUS_KGB = '3' AND A.PERIODE = '".$periode."' ".$statement." ) JUMLAH_DATA_KGB_SELESAI
		, (SELECT COUNT(1) FROM KENAIKAN_GAJI_BERKALA A WHERE 1=1 AND A.HUKUMAN_RIWAYAT_ID IS NOT NULL AND A.PERIODE = '".$periode."' ".$statement." ) JUMLAH_DATA_KGB_HUKUMAN
		"; 
		
		// $str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }
	
	function selectByParamsSuratKeluarData($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.SURAT_KELUAR_BKD_ID ASC')
	{
		$str = "
		SELECT
			A.SURAT_KELUAR_BKD_ID, A.JENIS_ID, A.SURAT_MASUK_BKD_ID, A.SURAT_MASUK_UPT_ID
			, A.SURAT_MASUK_PEGAWAI_ID, A.NOMOR
			, A.NOMOR_AWAL, A.NOMOR_URUT
			, A.TANGGAL, A.KEPADA, A.PERIHAL, A.IS_MANUAL, A.SATUAN_KERJA_TUJUAN_ID
			, A.SATUAN_KERJA_TUJUAN_NAMA, A.SATUAN_KERJA_TEKNIS_ID, A.SATUAN_KERJA_TERIMA_SURAT_ID
			, A.STATUS_TERIMA, A.STATUS_KIRIM_TEKNIS, A.TANDA_TANGAN_BKD_ID, A.PERIODE
			, CASE A.STATUS_TERIMA WHEN '1' THEN 'Di setujui' ELSE 'Belum di setujui' END STATUS_TERIMA_NAMA
		FROM persuratan.SURAT_KELUAR_BKD A
		WHERE 1=1
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;exit;
		return $this->selectLimit($str,$limit,$from); 
		
    }
	
	function selectByParamsHitungGajiRiwayat($statement='')
	{
		$str = "
		SELECT
			GAJI_RIWAYAT_ID, PEGAWAI_ID, TMT_PERIODE_KGB, MASA_KERJA_TAHUN_BARU, MASA_KERJA_BULAN_BARU
			, TAHUN_KGB, BULAN_KGB, JENIS_KENAIKAN, GAJI_BARU, CONCAT(BULAN_KGB, TAHUN_KGB) PERIODE
		FROM GAJI_TERAKHIR_ID_PERIODE A
		WHERE 1=1
		";
		$str .= $statement;
		//echo $str;exit;
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
	}
	
	function selectByParamsData($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ')
	{
		$str = "
		SELECT
			A.PEGAWAI_ID, A.PANGKAT_RIWAYAT_LAMA_ID, A.GAJI_RIWAYAT_LAMA_ID, A.PANGKAT_RIWAYAT_BARU_ID, A.GAJI_RIWAYAT_BARU_ID, A.JABATAN_RIWAYAT_ID
			, A.HUKUMAN_RIWAYAT_ID, A.PEGAWAI_STATUS_ID, A.PERIODE, P.NIP_BARU
			, AMBIL_SATKER_NAMA_DYNAMIC(A.SATUAN_KERJA_ID) SATUAN_KERJA_KGB
			, (CASE WHEN COALESCE(NULLIF(P.GELAR_DEPAN,'') , NULL ) IS NULL THEN '' ELSE P.GELAR_DEPAN || ' ' END) || P.NAMA || (CASE WHEN COALESCE(NULLIF(P.GELAR_BELAKANG,'') , NULL ) IS NULL THEN '' ELSE '' || P.GELAR_BELAKANG END) NAMA_LENGKAP
			, CONCAT(SPLIT_PART(SK.NOMOR, '/', 1), '/', SPLIT_PART(SK.NOMOR, '/', 2), '.', A.NOMOR_URUT, REPLACE(SK.NOMOR, CONCAT(SPLIT_PART(SK.NOMOR, '/', 1), '/', SPLIT_PART(SK.NOMOR, '/', 2)), '')) SK_NOMOR_BARU
			, PS.PEGAWAI_STATUS_NAMA, PS.PEGAWAI_KEDUDUKAN_NAMA
			, AMBIL_SATKER_NAMA_DETIL(P.SATUAN_KERJA_ID) PEGAWAI_SATUAN_KERJA_NAMA_DETIL
			, A.SATUAN_KERJA_ID, AMBIL_SATKER_NAMA_DETIL(A.SATUAN_KERJA_ID) SATUAN_KERJA_NAMA_DETIL
			, PR1.NO_SK NO_SK_LAMA, PR1.TANGGAL_SK, PR1.TMT_SK TMT_LAMA, PR1.JENIS_KENAIKAN_NAMA, PR1.PANGKAT_ID, PR1.PANGKAT_KODE
			, PR1.MASA_KERJA_TAHUN MASA_KERJA_TAHUN_LAMA, PR1.MASA_KERJA_BULAN MASA_KERJA_BULAN_LAMA, PR1.GAJI_POKOK GAJI_LAMA
			, PR1.PEJABAT_PENETAP_ID PEJABAT_PENETAP_ID_LAMA, PR1.PEJABAT_PENETAP_NAMA PEJABAT_PENETAP_LAMA
			, A.TMT_BARU, A.MASA_KERJA_TAHUN_BARU, A.MASA_KERJA_BULAN_BARU, A.GAJI_BARU
			, A.TANGGAL_BARU, SK.NOMOR_AWAL, SK.NOMOR NO_SK
			, A.SURAT_KELUAR_BKD_ID, A.NOMOR_URUT, A.KETERANGAN_TEKNIS, SK.PERIODE PERIODE_SK
			, HK.KETERANGAN_HUKUMAN_INFO, HK.TMT_BERIKUT_GAJI, HK.TANGGAL_SK HUKUMAN_TANGGAL_SK, HK.NO_SK HUKUMAN_NO_SK
			, '' JENIS_KGB, A.STATUS_KGB, CASE A.STATUS_KGB WHEN '2' THEN 'Dalam Proses' WHEN '3' THEN 'Selesai' WHEN '4' THEN 'Batal' ELSE '' END STATUS_KGB_NAMA
			, A.STATUS_HITUNG_ULANG
		FROM KENAIKAN_GAJI_BERKALA A
		INNER JOIN PEGAWAI P ON A.PEGAWAI_ID = P.PEGAWAI_ID
		INNER JOIN GAJI_RIWAYAT_DATA PR1 ON A.GAJI_RIWAYAT_LAMA_ID = PR1.GAJI_RIWAYAT_ID
		LEFT JOIN 
		(
			SELECT A.PEGAWAI_STATUS_ID, A.PEGAWAI_ID, A.STATUS_PEGAWAI_ID, B.NAMA PEGAWAI_STATUS_NAMA
			, A.TMT PEGAWAI_KEDUDUKAN_TMT, C.NAMA PEGAWAI_KEDUDUKAN_NAMA
			FROM PEGAWAI_STATUS A
			INNER JOIN STATUS_PEGAWAI B ON A.STATUS_PEGAWAI_ID = B.STATUS_PEGAWAI_ID
			INNER JOIN STATUS_PEGAWAI_KEDUDUKAN C ON A.STATUS_PEGAWAI_KEDUDUKAN_ID = C.STATUS_PEGAWAI_KEDUDUKAN_ID
		) PS ON A.PEGAWAI_STATUS_ID = PS.PEGAWAI_STATUS_ID
		LEFT JOIN PERSURATAN.SURAT_KELUAR_BKD SK ON A.SURAT_KELUAR_BKD_ID = SK.SURAT_KELUAR_BKD_ID
		LEFT JOIN
		(
			SELECT 	
				A.HUKUMAN_ID, A.PEGAWAI_ID, B.NAMA TINGKAT_HUKUMAN_NAMA, C.NAMA JENIS_HUKUMAN_NAMA
				, A.NO_SK, A.TANGGAL_SK, A.TMT_SK, A.TMT_BERIKUT_GAJI, A.JENIS_HUKUMAN_ID
				, CONCAT(B.NAMA, ' : ', C.NAMA) KETERANGAN_HUKUMAN_INFO
			FROM HUKUMAN A
			LEFT JOIN TINGKAT_HUKUMAN B ON B.TINGKAT_HUKUMAN_ID = A.TINGKAT_HUKUMAN_ID
			LEFT JOIN JENIS_HUKUMAN C ON C.JENIS_HUKUMAN_ID = A.JENIS_HUKUMAN_ID
		) HK ON A.HUKUMAN_RIWAYAT_ID = HK.HUKUMAN_ID
		WHERE 1 = 1
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		// echo $str;exit;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ')
	{
		$str = "
		SELECT
			A.PEGAWAI_ID, A.PERIODE, A.SURAT_KELUAR_BKD_ID,
			(CASE WHEN COALESCE(NULLIF(P.GELAR_DEPAN,'') , NULL ) IS NULL THEN '' ELSE P.GELAR_DEPAN || ' ' END) || P.NAMA || (CASE WHEN COALESCE(NULLIF(P.GELAR_BELAKANG,'') , NULL ) IS NULL THEN '' ELSE '' || P.GELAR_BELAKANG END) NAMA_LENGKAP
			, P.NIP_BARU, PR1.PANGKAT_KODE, PR1.TMT_SK TMT_LAMA
			, PR1.MASA_KERJA_TAHUN MASA_KERJA_TAHUN_LAMA, PR1.MASA_KERJA_BULAN MASA_KERJA_BULAN_LAMA, PR1.GAJI_POKOK GAJI_LAMA
			, A.TMT_BARU, A.MASA_KERJA_TAHUN_BARU, A.MASA_KERJA_BULAN_BARU, A.GAJI_BARU
			, CASE WHEN PR1.JENIS_KENAIKAN = 1 AND A.HUKUMAN_RIWAYAT_ID IS NULL THEN 'CPNS' WHEN HK.JENIS_HUKUMAN_ID = 4 THEN 'Penundaan' WHEN A.HUKUMAN_RIWAYAT_ID IS NOT NULL THEN 'Mundur' ELSE 'Normal' END
			JENIS_KGB, A.STATUS_KGB, CASE A.STATUS_KGB WHEN '2' THEN 'Dalam Proses' WHEN '3' THEN 'Selesai' WHEN '4' THEN 'Batal' ELSE '' END STATUS_KGB_NAMA
		FROM KENAIKAN_GAJI_BERKALA A
		INNER JOIN PEGAWAI P ON A.PEGAWAI_ID = P.PEGAWAI_ID
		INNER JOIN GAJI_RIWAYAT_DATA PR1 ON A.GAJI_RIWAYAT_LAMA_ID = PR1.GAJI_RIWAYAT_ID
		LEFT JOIN
		(
			SELECT A.PEGAWAI_ID, A.HUKUMAN_ID, A.JENIS_HUKUMAN_ID FROM HUKUMAN A
		) HK ON HK.HUKUMAN_ID = A.HUKUMAN_RIWAYAT_ID
		WHERE 1 = 1
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str;exit();
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function getCountByParams($paramsArray=array(), $statement='')
	{
		$str = "
				SELECT COUNT(1) AS ROWCOUNT 
				FROM DUK A
				WHERE 1 = 1 ".$statement; 
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0;  
    }
	
	function getCountByParamsMonitoring($paramsArray=array(), $statement='')
	{
		$str = "
				SELECT COUNT(1) AS ROWCOUNT 
				FROM KENAIKAN_GAJI_BERKALA A
				INNER JOIN PEGAWAI P ON A.PEGAWAI_ID = P.PEGAWAI_ID
				INNER JOIN GAJI_RIWAYAT_DATA PR1 ON A.GAJI_RIWAYAT_LAMA_ID = PR1.GAJI_RIWAYAT_ID
				WHERE 1 = 1 ".$statement; 
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0;  
    }

  } 
?>