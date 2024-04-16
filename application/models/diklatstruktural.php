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
  
  class DiklatStruktural extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function DiklatStruktural()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("DIKLAT_STRUKTURAL_ID", $this->getNextId("DIKLAT_STRUKTURAL_ID","DIKLAT_STRUKTURAL")); 

		$str = "
		INSERT INTO DIKLAT_STRUKTURAL 
		(
			DIKLAT_STRUKTURAL_ID, DIKLAT_ID, PEGAWAI_ID, TEMPAT, PENYELENGGARA, ANGKATAN, TAHUN
			, TANGGAL_MULAI, TANGGAL_SELESAI, NO_STTPP, TANGGAL_STTPP, JUMLAH_JAM
			, DS_JABATAN_RIWAYAT_ID, NILAI_REKAM_JEJAK, RUMPUN_ID
			, LAST_USER, LAST_DATE, LAST_LEVEL, USER_LOGIN_ID, USER_LOGIN_PEGAWAI_ID
		) 
		VALUES
		(
			".$this->getField("DIKLAT_STRUKTURAL_ID")."
			, ".$this->getField("DIKLAT_ID")."
			, ".$this->getField("PEGAWAI_ID")."
			, '".$this->getField("TEMPAT")."'
			, '".$this->getField("PENYELENGGARA")."'
			, '".$this->getField("ANGKATAN")."'
			, ".$this->getField("TAHUN")."
			, ".$this->getField("TANGGAL_MULAI")."
			, ".$this->getField("TANGGAL_SELESAI")."
			, '".$this->getField("NO_STTPP")."'
			, ".$this->getField("TANGGAL_STTPP")."
			, ".$this->getField("JUMLAH_JAM")."
			, ".$this->getField("DS_JABATAN_RIWAYAT_ID")."
			, ".$this->getField("NILAI_REKAM_JEJAK")."
			, ".$this->getField("RUMPUN_ID")."
			, '".$this->getField("LAST_USER")."'
			, ".$this->getField("LAST_DATE")."
			, ".$this->getField("LAST_LEVEL")."
			, ".$this->getField("USER_LOGIN_ID")."
			, ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
		)
		"; 	
		$this->id = $this->getField("DIKLAT_STRUKTURAL_ID");
		$this->query = $str;
		// echo $this->$query;exit;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "		
		UPDATE DIKLAT_STRUKTURAL
		SET    
			DIKLAT_ID= ".$this->getField("DIKLAT_ID")."
			, PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
			, TEMPAT= '".$this->getField("TEMPAT")."'
			, PENYELENGGARA= '".$this->getField("PENYELENGGARA")."'
			, ANGKATAN= '".$this->getField("ANGKATAN")."'
			, TAHUN= ".$this->getField("TAHUN")."
			, TANGGAL_MULAI= ".$this->getField("TANGGAL_MULAI")."
			, TANGGAL_SELESAI= ".$this->getField("TANGGAL_SELESAI")."
			, NO_STTPP= '".$this->getField("NO_STTPP")."'
			, TANGGAL_STTPP= ".$this->getField("TANGGAL_STTPP")."
			, JUMLAH_JAM= ".$this->getField("JUMLAH_JAM")."
			, DS_JABATAN_RIWAYAT_ID= ".$this->getField("DS_JABATAN_RIWAYAT_ID")."
			, NILAI_REKAM_JEJAK= ".$this->getField("NILAI_REKAM_JEJAK")."
			, RUMPUN_ID= ".$this->getField("RUMPUN_ID")."
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_DATE= ".$this->getField("LAST_DATE")."
			, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
			, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
			, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
		WHERE DIKLAT_STRUKTURAL_ID= ".$this->getField("DIKLAT_STRUKTURAL_ID")."
		";
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function updateIdSapk()
    {
		$str = "		
		UPDATE DIKLAT_STRUKTURAL
		SET    
		
		 	 ID_SAPK= '".$this->getField("ID_SAPK")."'
	
		WHERE  DIKLAT_STRUKTURAL_ID = ".$this->getField("DIKLAT_STRUKTURAL_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);
    }

    function insertDataBkn()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("DIKLAT_STRUKTURAL_ID", $this->getNextId("DIKLAT_STRUKTURAL_ID","DIKLAT_STRUKTURAL")); 

		$str = "
		INSERT INTO DIKLAT_STRUKTURAL 
		(
			DIKLAT_STRUKTURAL_ID, DIKLAT_ID,  PENYELENGGARA, NO_STTPP, PEGAWAI_ID, TAHUN
			, TANGGAL_MULAI, TANGGAL_SELESAI
		) 
		VALUES
		(
		".$this->getField("DIKLAT_STRUKTURAL_ID")."
		, ".$this->getField("DIKLAT_ID")."
		
		, '".$this->getField("PENYELENGGARA")."'
		, '".$this->getField("NO_STTPP")."'
		, ".$this->getField("PEGAWAI_ID")."
		, '".$this->getField("TAHUN")."'
		, ".$this->getField("TANGGAL_MULAI")."
		, ".$this->getField("TANGGAL_SELESAI")."
		)
		"; 	
		$this->id = $this->getField("DIKLAT_STRUKTURAL_ID");
		$this->query = $str;
		 // echo $str;exit;
		return $this->execQuery($str);
    }

    function updateBknData()
	{
		$str = "		
		UPDATE DIKLAT_STRUKTURAL
		SET    
			DIKLAT_ID= ".$this->getField("DIKLAT_ID")."
			, PENYELENGGARA= '".$this->getField("PENYELENGGARA")."'
			, NO_STTPP= '".$this->getField("NO_STTPP")."'
			, PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
			, TAHUN= '".$this->getField("TAHUN")."'
			, TANGGAL_MULAI= ".$this->getField("TANGGAL_MULAI")."
			, TANGGAL_SELESAI= ".$this->getField("TANGGAL_SELESAI")."
		WHERE DIKLAT_STRUKTURAL_ID= ".$this->getField("DIKLAT_STRUKTURAL_ID")."
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function updateStatusSync()
	{
		$str = "		
		UPDATE DIKLAT_STRUKTURAL
		SET
			SYNC_ID= '".$this->getField("SYNC_ID")."'
			, SYNC_NAMA= '".$this->getField("SYNC_NAMA")."'
			, SYNC_WAKTU= NOW()
			, SYNC_STATUS= '".$this->getField("SYNC_STATUS")."'
		WHERE DIKLAT_STRUKTURAL_ID = ".$this->getField("DIKLAT_STRUKTURAL_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);
    }
    
    function updateStatus()
	{
		$str = "		
		UPDATE DIKLAT_STRUKTURAL
		SET    
			STATUS= ".$this->getField("STATUS")."
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
			, LAST_DATE= ".$this->getField("LAST_DATE")."
			, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
			, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
		WHERE DIKLAT_STRUKTURAL_ID= ".$this->getField("DIKLAT_STRUKTURAL_ID")."
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }
	
	function delete()
	{
		$str = "
		UPDATE DIKLAT_STRUKTURAL SET
			STATUS = '1'
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_DATE= ".$this->getField("LAST_DATE")."
			, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
			, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
		WHERE DIKLAT_STRUKTURAL_ID = ".$this->getField("DIKLAT_STRUKTURAL_ID")."
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.DIKLAT_STRUKTURAL_ID ASC')
	{
		$str = "
		SELECT
			B.NAMA, R.KETERANGAN RUMPUN_NAMA, JR.*, A.*,C.PEGAWAI_ID_SAPK
		FROM diklat_struktural A
		INNER JOIN diklat B ON A.DIKLAT_ID = B.DIKLAT_ID
		LEFT JOIN
		(
			SELECT
			A.JABATAN_RIWAYAT_ID, A.NAMA JABATAN_RIWAYAT_NAMA, B.NAMA JABATAN_RIWAYAT_ESELON, A.SATKER_NAMA JABATAN_RIWAYAT_SATKER
			FROM jabatan_riwayat A
			INNER JOIN eselon B ON A.ESELON_ID = B.ESELON_ID
		) JR ON DS_JABATAN_RIWAYAT_ID = JABATAN_RIWAYAT_ID
		LEFT JOIN talent.rumpun R ON A.RUMPUN_ID = R.RUMPUN_ID
		LEFT JOIN PEGAWAI C ON C.PEGAWAI_ID = A.PEGAWAI_ID
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
				SELECT COUNT(A.DIKLAT_STRUKTURAL_ID) AS ROWCOUNT 
				FROM DIKLAT_STRUKTURAL A
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