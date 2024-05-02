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
  
  class GajiPppkRiwayat extends Entity{ 

	var $query;
  	var $id;
    /**
    * Class constructor.
    **/
    function GajiPppkRiwayat()
	{
      $this->Entity(); 
    }

	function insert()
	{
		$this->setField("GAJI_PPPK_RIWAYAT_ID", $this->getNextId("GAJI_PPPK_RIWAYAT_ID","gaji_pppk_riwayat"));
     	$str = "
		INSERT INTO gaji_pppk_riwayat 
		(
			GAJI_PPPK_RIWAYAT_ID, PEGAWAI_ID, PEJABAT_PENETAP_ID, PEJABAT_PENETAP, PANGKAT_ID, NO_SK, TANGGAL_SK
			, TMT_SK, MASA_KERJA_TAHUN, MASA_KERJA_BULAN, GAJI_POKOK, JENIS_KENAIKAN
			, LAST_USER, LAST_DATE, LAST_LEVEL, USER_LOGIN_ID, USER_LOGIN_PEGAWAI_ID
		) 
		VALUES
		(
			".$this->getField("GAJI_PPPK_RIWAYAT_ID")."
			, ".$this->getField("PEGAWAI_ID")."
			, ".$this->getField("PEJABAT_PENETAP_ID")."
			, '".$this->getField("PEJABAT_PENETAP")."'
			, ".$this->getField("PANGKAT_ID")."
			, '".$this->getField("NO_SK")."'
			, ".$this->getField("TANGGAL_SK")."
			, ".$this->getField("TMT_SK")."
			, ".$this->getField("MASA_KERJA_TAHUN")."
			, ".$this->getField("MASA_KERJA_BULAN")."
			, ".$this->getField("GAJI_POKOK")."
			, ".$this->getField("JENIS_KENAIKAN")."
			, '".$this->getField("LAST_USER")."'
			, ".$this->getField("LAST_DATE")."
			, ".$this->getField("LAST_LEVEL")."
			, ".$this->getField("USER_LOGIN_ID")."
			, ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
		)
		"; 	
  
		$this->id = $this->getField("GAJI_PPPK_RIWAYAT_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "		
		UPDATE gaji_pppk_riwayat
		SET    
			STATUS= NULL
			, PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
			, PEJABAT_PENETAP_ID= ".$this->getField("PEJABAT_PENETAP_ID")."
			, PEJABAT_PENETAP= '".$this->getField("PEJABAT_PENETAP")."'
			, PANGKAT_ID= ".$this->getField("PANGKAT_ID")."
			, NO_SK= '".$this->getField("NO_SK")."'
			, TANGGAL_SK= ".$this->getField("TANGGAL_SK")."
			, TMT_SK= ".$this->getField("TMT_SK")."
			, MASA_KERJA_TAHUN= ".$this->getField("MASA_KERJA_TAHUN")."
			, MASA_KERJA_BULAN= ".$this->getField("MASA_KERJA_BULAN")."
			, GAJI_POKOK= ".$this->getField("GAJI_POKOK")."
			, JENIS_KENAIKAN= ".$this->getField("JENIS_KENAIKAN")."
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_DATE= ".$this->getField("LAST_DATE")."
			, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
			, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
			, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
		WHERE GAJI_PPPK_RIWAYAT_ID = ".$this->getField("GAJI_PPPK_RIWAYAT_ID")."
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function updateHukuman()
	{
		$str = "		
		UPDATE gaji_pppk_riwayat
		SET    
			PEJABAT_PENETAP_ID= ".$this->getField("PEJABAT_PENETAP_ID")."
			, PEJABAT_PENETAP= '".$this->getField("PEJABAT_PENETAP")."'
			, PANGKAT_ID= ".$this->getField("PANGKAT_ID")."
			, NO_SK= '".$this->getField("NO_SK")."'
			, TANGGAL_SK= ".$this->getField("TANGGAL_SK")."
			, TMT_SK= ".$this->getField("TMT_PANGKAT")."
			, JENIS_KENAIKAN= ".$this->getField("JENIS_RIWAYAT")."
			, MASA_KERJA_TAHUN= ".$this->getField("MASA_KERJA_TAHUN")."
			, MASA_KERJA_BULAN= ".$this->getField("MASA_KERJA_BULAN")."
			, GAJI_POKOK= ".$this->getField("GAJI_POKOK")."
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_DATE= ".$this->getField("LAST_DATE")."
			, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
			, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
			, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
		WHERE GAJI_PPPK_RIWAYAT_ID = ".$this->getField("GAJI_PPPK_RIWAYAT_ID")."
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function updateStatus()
	{
		$str = "		
		UPDATE gaji_pppk_riwayat
		SET    
			STATUS= ".$this->getField("STATUS")."
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
			, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
			, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
			, LAST_DATE= ".$this->getField("LAST_DATE")."
		WHERE GAJI_PPPK_RIWAYAT_ID= ".$this->getField("GAJI_PPPK_RIWAYAT_ID")."
		";
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "
        UPDATE gaji_pppk_riwayat SET
	        STATUS = '1'
	        , LAST_USER= '".$this->getField("LAST_USER")."'
	        , LAST_DATE= ".$this->getField("LAST_DATE")."
	        , USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
	        , USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
        WHERE GAJI_PPPK_RIWAYAT_ID = ".$this->getField("GAJI_PPPK_RIWAYAT_ID")."
        ";
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function deleteData()
	{
		$strLog= "
		DELETE FROM gaji_pppk_riwayat_LOG
		WHERE GAJI_PPPK_RIWAYAT_ID = ".$this->getField("GAJI_PPPK_RIWAYAT_ID")."
		";
		$this->query = $strLog;
		$this->execQuery($strLog);
		
       $str = "
				DELETE FROM gaji_pppk_riwayat
				WHERE GAJI_PPPK_RIWAYAT_ID = ".$this->getField("GAJI_PPPK_RIWAYAT_ID")."
				";
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.GAJI_PPPK_RIWAYAT_ID ASC')
	{
		$str = "
		SELECT 	
			A.GAJI_PPPK_RIWAYAT_ID, A.PEGAWAI_ID, A.PEJABAT_PENETAP_ID, COALESCE(A.PEJABAT_PENETAP, PP.NAMA) PEJABAT_PENETAP, A.PANGKAT_ID, A.NO_SK, A.TANGGAL_SK,
			A.TMT_SK, A.MASA_KERJA_TAHUN, A.MASA_KERJA_BULAN, A.GAJI_POKOK, A.JENIS_KENAIKAN, A.STATUS, A.LAST_USER, A.LAST_DATE, A.LAST_LEVEL
			, B.KODE PANGKAT_KODE, B.NAMA PANGKAT_NAMA
			, CASE A.JENIS_KENAIKAN WHEN 0 THEN 'SK PPPK' WHEN 1 THEN 'Gaji Berkala' ELSE '-' END JENIS_KENAIKAN_NAMA
			, PP.NAMA PEJABAT_PENETAP_NAMA
		FROM gaji_pppk_riwayat A
		LEFT JOIN golongan_pppk B ON A.PANGKAT_ID = B.GOLONGAN_PPPK_ID
		LEFT JOIN pejabat_penetap PP ON A.PEJABAT_PENETAP_ID = PP.PEJABAT_PENETAP_ID
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

    function getCountByParams($paramsArray=array(), $statement='')
	{
		$str = "
		SELECT COUNT(A.GAJI_PPPK_RIWAYAT_ID) AS ROWCOUNT 
		FROM gaji_pppk_riwayat A
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