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
  
  class Pak extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Pak()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PAK_ID", $this->getNextId("PAK_ID","PAK")); 

		$str = "
			INSERT INTO PAK 
			(
				PAK_ID, PEGAWAI_ID, NO_SK, TANGGAL_SK, TANGGAL_MULAI, TANGGAL_SELESAI
				, PERIODE_AWAL, PERIODE_AKHIR,BULAN_MULAI,TAHUN_MULAI,BULAN_SELESAI, TAHUN_SELESAI, PAK_AWAL
				, PAK_INTERGRASI,PAK_KONVERSI, JABATAN_FT_ID, KREDIT_UTAMA, KREDIT_PENUNJANG, TOTAL_KREDIT
				, LAST_USER, LAST_DATE, LAST_LEVEL, USER_LOGIN_ID, USER_LOGIN_PEGAWAI_ID
			) 
			VALUES 
			(
				".$this->getField("PAK_ID")."
				, ".$this->getField("PEGAWAI_ID")."
				, '".$this->getField("NO_SK")."'
				, ".$this->getField("TANGGAL_SK")."
				, ".$this->getField("TANGGAL_MULAI")."
				, ".$this->getField("TANGGAL_SELESAI")."
				, ".$this->getField("PERIODE_AWAL")."
				, ".$this->getField("PERIODE_AKHIR")."
				, ".$this->getField("BULAN_MULAI")."
				, ".$this->getField("TAHUN_MULAI")."
				, ".$this->getField("BULAN_SELESAI")."
				, ".$this->getField("TAHUN_SELESAI")."
				, '".$this->getField("PAK_AWAL")."'
				, '".$this->getField("PAK_INTERGRASI")."'
				, '".$this->getField("PAK_KONVERSI")."'
				, ".$this->getField("JABATAN_FT_ID")."
				, ".$this->getField("KREDIT_UTAMA")."
				, ".$this->getField("KREDIT_PENUNJANG")."
				, ".$this->getField("TOTAL_KREDIT")."
				, '".$this->getField("LAST_USER")."'
				, ".$this->getField("LAST_DATE")."
				, ".$this->getField("LAST_LEVEL")."
				, ".$this->getField("USER_LOGIN_ID")."
				, ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
			)
		"; 	
		$this->id = $this->getField("PAK_ID");
		$this->query = $str;
		// echo $this->$query;exit;
		return $this->execQuery($str);
    }


    function update()
	{
		$str = "		
		UPDATE PAK
		SET    
		PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
		, NO_SK= '".$this->getField("NO_SK")."'
		, TANGGAL_SK= ".$this->getField("TANGGAL_SK")."
		, TANGGAL_MULAI= ".$this->getField("TANGGAL_MULAI")."
		, TANGGAL_SELESAI= ".$this->getField("TANGGAL_SELESAI")."
		, PERIODE_AWAL= ".$this->getField("PERIODE_AWAL")."
		, PERIODE_AKHIR= ".$this->getField("PERIODE_AKHIR")."
		, PAK_AWAL= '".$this->getField("PAK_AWAL")."'
		, PAK_INTERGRASI= '".$this->getField("PAK_INTERGRASI")."'
		, PAK_KONVERSI= '".$this->getField("PAK_KONVERSI")."'
		, BULAN_MULAI= ".$this->getField("BULAN_MULAI")."
		, TAHUN_MULAI= ".$this->getField("TAHUN_MULAI")."
		, BULAN_SELESAI= ".$this->getField("BULAN_SELESAI")."
		, TAHUN_SELESAI= ".$this->getField("TAHUN_SELESAI")."
		, JABATAN_FT_ID= ".$this->getField("JABATAN_FT_ID")."
		, KREDIT_UTAMA= ".$this->getField("KREDIT_UTAMA")."
		, KREDIT_PENUNJANG= ".$this->getField("KREDIT_PENUNJANG")."
		, TOTAL_KREDIT= ".$this->getField("TOTAL_KREDIT")."
		, LAST_USER= '".$this->getField("LAST_USER")."'
		, LAST_DATE= ".$this->getField("LAST_DATE")."
		, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
		, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
		, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
		WHERE PAK_ID= ".$this->getField("PAK_ID")."
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function insertDataBkn()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PAK_ID", $this->getNextId("PAK_ID","PAK")); 

		$str = "
			INSERT INTO PAK 
			(
				PAK_ID, PEGAWAI_ID, NO_SK, TANGGAL_SK, TANGGAL_MULAI, TANGGAL_SELESAI, KREDIT_UTAMA, KREDIT_PENUNJANG
				, TOTAL_KREDIT, PAK_AWAL, JABATAN_FT_ID, PAK_INTERGRASI, PAK_KONVERSI, BULAN_MULAI, TAHUN_MULAI 
				, BULAN_SELESAI, TAHUN_SELESAI
			) 
			VALUES 
			(
				".$this->getField("PAK_ID")."
				, ".$this->getField("PEGAWAI_ID")."
				, '".$this->getField("NO_SK")."'
				, ".$this->getField("TANGGAL_SK")."
				, ".$this->getField("TANGGAL_MULAI")."
				, ".$this->getField("TANGGAL_SELESAI")."
				, ".$this->getField("KREDIT_UTAMA")."
				, ".$this->getField("KREDIT_PENUNJANG")."
				, ".$this->getField("TOTAL_KREDIT")."
				, ".$this->getField("PAK_AWAL")."
				, ".$this->getField("JABATAN_FT_ID")."
				, ".$this->getField("PAK_INTERGRASI")."
				, ".$this->getField("PAK_KONVERSI")."
				, ".$this->getField("BULAN_MULAI")."
				, ".$this->getField("TAHUN_MULAI")."
				, ".$this->getField("BULAN_SELESAI")."
				, ".$this->getField("TAHUN_SELESAI")."
			)
		"; 	
		$this->id = $this->getField("PAK_ID");
		// echo $str;exit;
		$this->query = $str;
		// echo $this->$query;exit;
		return $this->execQuery($str);
    }

    function updateBknData()
    {
		$str = "		
		UPDATE PAK
		SET
			PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
			, NO_SK= '".$this->getField("NO_SK")."'
			, TANGGAL_SK= ".$this->getField("TANGGAL_SK")."
			, KREDIT_UTAMA= ".$this->getField("KREDIT_UTAMA")."
			, KREDIT_PENUNJANG= ".$this->getField("KREDIT_PENUNJANG")."
			, TOTAL_KREDIT= ".$this->getField("TOTAL_KREDIT")."
			, JABATAN_FT_ID= ".$this->getField("JABATAN_FT_ID")."
			, PAK_AWAL= ".$this->getField("PAK_AWAL")."
			, TANGGAL_MULAI= ".$this->getField("TANGGAL_MULAI")."
			, TANGGAL_SELESAI= ".$this->getField("TANGGAL_SELESAI")."
			, PAK_INTERGRASI= ".$this->getField("PAK_INTERGRASI")."
			, PAK_KONVERSI= ".$this->getField("PAK_KONVERSI")."
			, BULAN_MULAI= ".$this->getField("BULAN_MULAI")."
			, TAHUN_MULAI= ".$this->getField("TAHUN_MULAI")."
			, BULAN_SELESAI= ".$this->getField("BULAN_SELESAI")."
			, TAHUN_SELESAI= ".$this->getField("TAHUN_SELESAI")."
		WHERE PAK_ID = ".$this->getField("PAK_ID")."
		";
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);
    }

    function updateIdSapk()
    {
		$str = "		
		UPDATE PAK
		SET
			ID_SAPK= '".$this->getField("ID_SAPK")."'
		WHERE PAK_ID = ".$this->getField("PAK_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);
    }

    function updateStatusSync()
	{
		$str = "		
		UPDATE PENILAIAN_SKP
		SET
			SYNC_ID= '".$this->getField("SYNC_ID")."'
			, SYNC_NAMA= '".$this->getField("SYNC_NAMA")."'
			, SYNC_WAKTU= NOW()
			, SYNC_STATUS= '".$this->getField("SYNC_STATUS")."'
		WHERE PENILAIAN_SKP_ID = ".$this->getField("PENILAIAN_SKP_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);
    }

    function updateStatus()
	{
		$str = "		
		UPDATE PAK
		SET    
		STATUS= ".$this->getField("STATUS")."
		, LAST_USER= '".$this->getField("LAST_USER")."'
		, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
		, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
		, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
		, LAST_DATE= ".$this->getField("LAST_DATE")."
		WHERE PAK_ID= ".$this->getField("PAK_ID")."
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "
				UPDATE PAK SET
					STATUS = '1',
					LAST_USER= '".$this->getField("LAST_USER")."',
					USER_LOGIN_ID= '".$this->getField("USER_LOGIN_ID")."',
					USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID").",
					LAST_DATE= ".$this->getField("LAST_DATE")."
				WHERE PAK_ID = ".$this->getField("PAK_ID")."
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.PAK_ID ASC')
	{
		$str = "
				SELECT 
					A.PAK_ID, A.PEGAWAI_ID, A.NO_SK, A.TANGGAL_SK, A.TANGGAL_MULAI, A.TANGGAL_SELESAI, 
				   	A.PERIODE_AWAL, A.PERIODE_AKHIR, A.PAK_AWAL, A.JABATAN_FT_ID, A.KREDIT_UTAMA, 
				   	A.KREDIT_PENUNJANG, A.TOTAL_KREDIT, A.LAST_USER, A.LAST_DATE, A.LAST_LEVEL, A.STATUS,A.ID_SAPK,
				   	B.NAMA JABATAN,A.PAK_INTERGRASI,A.PAK_KONVERSI,	
						CASE WHEN A.BULAN_MULAI='' OR A.BULAN_MULAI IS NULL  THEN TO_CHAR(A.TANGGAL_MULAI, 'MM') ELSE A.BULAN_MULAI END BULAN_MULAI,
						CASE WHEN A.BULAN_SELESAI='' OR A.BULAN_SELESAI IS NULL  THEN TO_CHAR(A.TANGGAL_SELESAI, 'MM') ELSE A.BULAN_SELESAI END BULAN_SELESAI,
						CASE WHEN A.TAHUN_MULAI='' OR A.TAHUN_MULAI IS NULL  THEN TO_CHAR(A.TANGGAL_MULAI, 'YYYY') ELSE A.TAHUN_MULAI END TAHUN_MULAI,
						CASE WHEN A.TAHUN_SELESAI='' OR A.TAHUN_SELESAI IS NULL  THEN TO_CHAR(A.TANGGAL_SELESAI, 'YYYY') ELSE A.TAHUN_SELESAI END TAHUN_SELESAI,
				   	C.PEGAWAI_ID_SAPK,B.ID_DATA ID_DATA_FT
				FROM PAK A
				LEFT JOIN JABATAN_FT B ON A.JABATAN_FT_ID = B.JABATAN_FT_ID
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
				SELECT COUNT(A.PAK_ID) AS ROWCOUNT 
				FROM PAK A
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