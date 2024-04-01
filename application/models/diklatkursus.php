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
  
  class DiklatKursus extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function DiklatKursus()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("DIKLAT_KURSUS_ID", $this->getNextId("DIKLAT_KURSUS_ID","DIKLAT_KURSUS")); 

		$str = "
		INSERT INTO DIKLAT_KURSUS
		(
            DIKLAT_KURSUS_ID, PEGAWAI_ID, TIPE_KURSUS_ID
            , NAMA, NO_SERTIFIKAT, TANGGAL_SERTIFIKAT, TANGGAL_MULAI, TANGGAL_SELESAI
            , TAHUN, JUMLAH_JAM, ANGKATAN, TEMPAT,PENYELENGGARA,REF_JENIS_KURSUS_ID, RUMPUN_ID
            , STATUS_LULUS, REF_INSTANSI_ID, REF_INSTANSI_NAMA, NILAI_REKAM_JEJAK
            , BIDANG_TERKAIT_ID
            , USER_LOGIN_ID, USER_LOGIN_PEGAWAI_ID, LAST_CREATE_USER, LAST_CREATE_DATE
		) 
		VALUES 
		(
			".$this->getField("DIKLAT_KURSUS_ID")."
			, ".$this->getField("PEGAWAI_ID")."
			, ".$this->getField("TIPE_KURSUS_ID")."
			, '".$this->getField("NAMA")."'
			, '".$this->getField("NO_SERTIFIKAT")."'
			, ".$this->getField("TANGGAL_SERTIFIKAT")."
			, ".$this->getField("TANGGAL_MULAI")."
			, ".$this->getField("TANGGAL_SELESAI")."
			, ".$this->getField("TAHUN")."
			, ".$this->getField("JUMLAH_JAM")."
			, '".$this->getField("ANGKATAN")."'
			, '".$this->getField("TEMPAT")."'
			, '".$this->getField("PENYELENGGARA")."'
			, ".$this->getField("REF_JENIS_KURSUS_ID")."
			, ".$this->getField("RUMPUN_ID")."
			, '".$this->getField("STATUS_LULUS")."'
			, ".$this->getField("REF_INSTANSI_ID")."
			, '".$this->getField("REF_INSTANSI_NAMA")."'
			, ".$this->getField("NILAI_REKAM_JEJAK")."
			, ".$this->getField("BIDANG_TERKAIT_ID")."
			, ".$this->getField("USER_LOGIN_ID")."
			, ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
			, ".$this->getField("LAST_CREATE_USER")."
			, NOW()
		)
		"; 	
		// echo "xxx-".$str;exit;

		$this->id = $this->getField("DIKLAT_KURSUS_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "		
		UPDATE DIKLAT_KURSUS
		SET    
		 	TIPE_KURSUS_ID= ".$this->getField("TIPE_KURSUS_ID")."
		 	, NAMA= '".$this->getField("NAMA")."'
		 	, NO_SERTIFIKAT= '".$this->getField("NO_SERTIFIKAT")."'
		 	, TANGGAL_SERTIFIKAT= ".$this->getField("TANGGAL_SERTIFIKAT")."
		 	, TANGGAL_MULAI= ".$this->getField("TANGGAL_MULAI")."
		 	, TANGGAL_SELESAI= ".$this->getField("TANGGAL_SELESAI")."
		 	, TAHUN= ".$this->getField("TAHUN")."
		 	, JUMLAH_JAM= ".$this->getField("JUMLAH_JAM")."
		 	, ANGKATAN= '".$this->getField("ANGKATAN")."'
		 	, TEMPAT= '".$this->getField("TEMPAT")."'
		 	, STATUS_LULUS= '".$this->getField("STATUS_LULUS")."'
		 	, REF_INSTANSI_ID= ".$this->getField("REF_INSTANSI_ID")."
		 	, REF_INSTANSI_NAMA= '".$this->getField("REF_INSTANSI_NAMA")."'
		 	, PENYELENGGARA= '".$this->getField("PENYELENGGARA")."'
		 	, NILAI_REKAM_JEJAK= ".$this->getField("NILAI_REKAM_JEJAK")."
		 	, BIDANG_TERKAIT_ID= ".$this->getField("BIDANG_TERKAIT_ID")."
		 	, RUMPUN_ID= ".$this->getField("RUMPUN_ID")."
		 	, REF_JENIS_KURSUS_ID= ".$this->getField("REF_JENIS_KURSUS_ID")."
		 	, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
		 	, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
		 	, LAST_USER= '".$this->getField("LAST_USER")."'
		 	, LAST_DATE= NOW()
		WHERE  DIKLAT_KURSUS_ID = ".$this->getField("DIKLAT_KURSUS_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);
    }

    function insertDataBkn()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("DIKLAT_KURSUS_ID", $this->getNextId("DIKLAT_KURSUS_ID","DIKLAT_KURSUS")); 

		$str = "
		INSERT INTO DIKLAT_KURSUS
		(
            DIKLAT_KURSUS_ID,TIPE_KURSUS_ID,PEGAWAI_ID,NAMA,REF_JENIS_KURSUS_ID,TAHUN,NO_SERTIFIKAT,TANGGAL_SELESAI,TANGGAL_MULAI,TANGGAL_SERTIFIKAT,REF_INSTANSI_NAMA,JUMLAH_JAM,LAST_DATE
		) 
		VALUES 
		(
			".$this->getField("DIKLAT_KURSUS_ID")."
			, ".$this->getField("TIPE_KURSUS_ID")."
			, '".$this->getField("PEGAWAI_ID")."'
			, '".$this->getField("NAMA")."'
			, ".$this->getField("REF_JENIS_KURSUS_ID")."
			, ".$this->getField("TAHUN")."
			, '".$this->getField("NO_SERTIFIKAT")."'
			, ".$this->getField("TANGGAL_SELESAI")."
			, ".$this->getField("TANGGAL_MULAI")."
			, ".$this->getField("TANGGAL_SERTIFIKAT")."
			, '".$this->getField("REF_INSTANSI_NAMA")."'
			, ".$this->getField("JUMLAH_JAM")."
			, NOW()
		)
		"; 	
		// echo "xxx-".$str;exit;

		$this->id = $this->getField("DIKLAT_KURSUS_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function updateDataBkn()
    {
		$str = "		
		UPDATE DIKLAT_KURSUS
		SET
			PEGAWAI_ID= '".$this->getField("PEGAWAI_ID")."'
			, TIPE_KURSUS_ID= ".$this->getField("TIPE_KURSUS_ID")."
			, NAMA= '".$this->getField("NAMA")."'
			, REF_JENIS_KURSUS_ID= ".$this->getField("REF_JENIS_KURSUS_ID")."
			, TAHUN= '".$this->getField("TAHUN")."'
			, NO_SERTIFIKAT= '".$this->getField("NO_SERTIFIKAT")."'
			, TANGGAL_SELESAI= ".$this->getField("TANGGAL_SELESAI")."
			, TANGGAL_MULAI= ".$this->getField("TANGGAL_MULAI")."
			, TANGGAL_SERTIFIKAT= ".$this->getField("TANGGAL_SERTIFIKAT")."
			, REF_INSTANSI_NAMA= '".$this->getField("REF_INSTANSI_NAMA")."'
			, JUMLAH_JAM= ".$this->getField("JUMLAH_JAM")."
			, LAST_DATE= NOW()
		WHERE  DIKLAT_KURSUS_ID = ".$this->getField("DIKLAT_KURSUS_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);
    }

    function updateIdSapk()
	{
		$str = "		
		UPDATE DIKLAT_KURSUS
		SET
		ID_SAPK= '".$this->getField("ID_SAPK")."'
		WHERE  DIKLAT_KURSUS_ID = ".$this->getField("DIKLAT_KURSUS_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);
    }

    function updateStatusSync()
	{
		$str = "		
		UPDATE DIKLAT_KURSUS
		SET
			SYNC_ID= '".$this->getField("SYNC_ID")."'
			, SYNC_NAMA= '".$this->getField("SYNC_NAMA")."'
			, SYNC_WAKTU= NOW()
			, SYNC_STATUS= '".$this->getField("SYNC_STATUS")."'
		WHERE DIKLAT_KURSUS_ID = ".$this->getField("DIKLAT_KURSUS_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);
    }

    function updateStatus()
	{
		$str = "		
				UPDATE DIKLAT_KURSUS
				SET    
					   STATUS   	= ".$this->getField("STATUS").",
					   LAST_USER	= '".$this->getField("LAST_USER")."',
					   LAST_LEVEL	= ".$this->getField("LAST_LEVEL").",
					   LAST_DATE	= ".$this->getField("LAST_DATE").",
					   USER_LOGIN_ID	= ".$this->getField("USER_LOGIN_ID").",
					   USER_LOGIN_PEGAWAI_ID	= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
				WHERE  DIKLAT_KURSUS_ID    	= ".$this->getField("DIKLAT_KURSUS_ID")."
				"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "
				UPDATE DIKLAT_KURSUS SET
					STATUS = '1',
					LAST_USER= '".$this->getField("LAST_USER")."',
					LAST_DATE= ".$this->getField("LAST_DATE").",
					USER_LOGIN_ID  = ".$this->getField("USER_LOGIN_ID").",
					USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
				WHERE DIKLAT_KURSUS_ID = ".$this->getField("DIKLAT_KURSUS_ID")."
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
    function selecttipekursus($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.TIPE_KURSUS_ID ASC')
	{
		$str = "
		SELECT 
			A.*
		FROM tipe_kursus A
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

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.DIKLAT_KURSUS_ID ASC')
	{
		$str = "
		SELECT 
			B.NAMA JENIS_KURSUS_NAMA, R.KETERANGAN RUMPUN_NAMA, TK.NAMA TIPE_DIKLAT_NAMA
			, CASE WHEN A.REF_INSTANSI_ID IS NULL THEN A.REF_INSTANSI_NAMA ELSE C.NAMA END REF_INSTANSI_INFO
			, C.NAMA REF_JENIS_KURSUS_DATA, CC.PEGAWAI_ID_SAPK
			, A.*
		FROM diklat_kursus A
		LEFT JOIN sapk.ref_jenis_kursus B ON A.REF_JENIS_KURSUS_ID = B.REF_JENIS_KURSUS_ID
		LEFT JOIN sapk.ref_instansi C ON A.REF_INSTANSI_ID = C.REF_INSTANSI_ID
		LEFT JOIN talent.rumpun R ON A.RUMPUN_ID = R.RUMPUN_ID
		LEFT JOIN tipe_kursus TK ON A.TIPE_KURSUS_ID = TK.TIPE_KURSUS_ID
		LEFT JOIN pegawai CC ON CC.PEGAWAI_ID = A.PEGAWAI_ID
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
				SELECT COUNT(A.DIKLAT_KURSUS_ID) AS ROWCOUNT 
				FROM DIKLAT_KURSUS A
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