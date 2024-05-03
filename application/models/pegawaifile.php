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
  
  class PegawaiFile extends Entity{ 

	 var $query;
  	var $id;
    /**
    * Class constructor.
    **/
    function PegawaiFile()
	{
      $this->Entity(); 
    }

	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_FILE_ID", $this->getNextId("PEGAWAI_FILE_ID","PEGAWAI_FILE")); 

     	$str = "
		INSERT INTO PEGAWAI_FILE 
		(
			PEGAWAI_FILE_ID, PEGAWAI_ID, RIWAYAT_TABLE, RIWAYAT_FIELD, RIWAYAT_ID, FILE_KUALITAS_ID, KATEGORI_FILE_ID
			, PATH, KETERANGAN
			, LAST_USER, LAST_DATE, LAST_LEVEL, USER_LOGIN_ID
			, USER_LOGIN_PEGAWAI_ID, IPCLIENT, MACADDRESS, NAMACLIENT, PATH_ASLI, EXT, CREATE_USER, PRIORITAS
		) 
		VALUES 
		(
			".$this->getField("PEGAWAI_FILE_ID")."
			, ".$this->getField("PEGAWAI_ID")."
			, '".$this->getField("RIWAYAT_TABLE")."'
			, '".$this->getField("RIWAYAT_FIELD")."'
			, ".$this->getField("RIWAYAT_ID")."
			, ".$this->getField("FILE_KUALITAS_ID")."
			, ".$this->getField("KATEGORI_FILE_ID")."
			, '".$this->getField("PATH")."'
			, '".$this->getField("KETERANGAN")."'
			, '".$this->getField("LAST_USER")."'
			, ".$this->getField("LAST_DATE")."
			, ".$this->getField("LAST_LEVEL")."
			, ".$this->getField("USER_LOGIN_ID")."
			, ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
			, '".$this->getField("IPCLIENT")."'
			, '".$this->getField("MACADDRESS")."'
			, '".$this->getField("NAMACLIENT")."'
			, '".$this->getField("PATH_ASLI")."'
			, '".$this->getField("EXT")."'
			, '".$this->getField("CREATE_USER")."'
			, '".$this->getField("PRIORITAS")."'
		)
		"; 	
		$this->id = $this->getField("PEGAWAI_FILE_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

	function insertFile()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_FILE_ID", $this->getNextId("PEGAWAI_FILE_ID","PEGAWAI_FILE")); 

     	$str = "
			INSERT INTO PEGAWAI_FILE (
				PEGAWAI_FILE_ID, PEGAWAI_ID, PATH
			) 
			VALUES (
				 ".$this->getField("PEGAWAI_FILE_ID").",
			     ".$this->getField("PEGAWAI_ID").",
			     '".$this->getField("PATH")."'
			)
		"; 	
		$this->id = $this->getField("PEGAWAI_FILE_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "		
		UPDATE PEGAWAI_FILE
		SET    
			PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
			, RIWAYAT_TABLE= '".$this->getField("RIWAYAT_TABLE")."'
			, RIWAYAT_FIELD= '".$this->getField("RIWAYAT_FIELD")."'
			, RIWAYAT_ID= ".$this->getField("RIWAYAT_ID")."
			, FILE_KUALITAS_ID= ".$this->getField("FILE_KUALITAS_ID")."
			, KATEGORI_FILE_ID= ".$this->getField("KATEGORI_FILE_ID")."
			, PATH= '".$this->getField("PATH")."'
			, KETERANGAN= '".$this->getField("KETERANGAN")."'
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_DATE= ".$this->getField("LAST_DATE")."
			, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
			, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
			, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
			, IPCLIENT= '".$this->getField("IPCLIENT")."'
			, MACADDRESS= '".$this->getField("MACADDRESS")."'
			, NAMACLIENT= '".$this->getField("NAMACLIENT")."'
			, PRIORITAS= '".$this->getField("PRIORITAS")."'
			, PATH_ASLI= '".$this->getField("PATH_ASLI")."'
		WHERE PEGAWAI_FILE_ID = ".$this->getField("PEGAWAI_FILE_ID")."
		"; 
		$this->query = $str;
		// echo $str;exit();
		return $this->execQuery($str);
    }

    function resetefile()
	{
		$str = "		
		UPDATE PEGAWAI_FILE
		SET    
			RIWAYAT_TABLE= NULL
			, RIWAYAT_FIELD= NULL
			, RIWAYAT_ID= NULL
			, FILE_KUALITAS_ID= NULL
			, KATEGORI_FILE_ID= NULL
			, KETERANGAN= NULL
			, PRIORITAS= NULL
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_DATE= ".$this->getField("LAST_DATE")."
			, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
			, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
			, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
			, IPCLIENT= '".$this->getField("IPCLIENT")."'
			, MACADDRESS= '".$this->getField("MACADDRESS")."'
			, NAMACLIENT= '".$this->getField("NAMACLIENT")."'
		WHERE PEGAWAI_FILE_ID = ".$this->getField("PEGAWAI_FILE_ID")."
		"; 
		$this->query = $str;
		// echo $str;exit();
		return $this->execQuery($str);
    }

    function noketinsert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_FILE_ID", $this->getNextId("PEGAWAI_FILE_ID","PEGAWAI_FILE")); 

     	$str = "
		INSERT INTO PEGAWAI_FILE 
		(
			PEGAWAI_FILE_ID, PEGAWAI_ID, RIWAYAT_TABLE, RIWAYAT_FIELD, RIWAYAT_ID, FILE_KUALITAS_ID, KATEGORI_FILE_ID
			, PATH
			, LAST_USER, LAST_DATE, LAST_LEVEL, USER_LOGIN_ID
			, USER_LOGIN_PEGAWAI_ID, IPCLIENT, MACADDRESS, NAMACLIENT, PATH_ASLI, EXT, CREATE_USER, PRIORITAS
		) 
		VALUES 
		(
			".$this->getField("PEGAWAI_FILE_ID")."
			, ".$this->getField("PEGAWAI_ID")."
			, '".$this->getField("RIWAYAT_TABLE")."'
			, '".$this->getField("RIWAYAT_FIELD")."'
			, ".$this->getField("RIWAYAT_ID")."
			, ".$this->getField("FILE_KUALITAS_ID")."
			, ".$this->getField("KATEGORI_FILE_ID")."
			, '".$this->getField("PATH")."'
			, '".$this->getField("LAST_USER")."'
			, ".$this->getField("LAST_DATE")."
			, ".$this->getField("LAST_LEVEL")."
			, ".$this->getField("USER_LOGIN_ID")."
			, ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
			, '".$this->getField("IPCLIENT")."'
			, '".$this->getField("MACADDRESS")."'
			, '".$this->getField("NAMACLIENT")."'
			, '".$this->getField("PATH_ASLI")."'
			, '".$this->getField("EXT")."'
			, '".$this->getField("CREATE_USER")."'
			, '".$this->getField("PRIORITAS")."'
		)
		"; 	
		$this->id = $this->getField("PEGAWAI_FILE_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function noketupdate()
	{
		$str = "		
		UPDATE PEGAWAI_FILE
		SET    
			PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
			, RIWAYAT_TABLE= '".$this->getField("RIWAYAT_TABLE")."'
			, RIWAYAT_FIELD= '".$this->getField("RIWAYAT_FIELD")."'
			, RIWAYAT_ID= ".$this->getField("RIWAYAT_ID")."
			, FILE_KUALITAS_ID= ".$this->getField("FILE_KUALITAS_ID")."
			, KATEGORI_FILE_ID= ".$this->getField("KATEGORI_FILE_ID")."
			, PATH= '".$this->getField("PATH")."'
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_DATE= ".$this->getField("LAST_DATE")."
			, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
			, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
			, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
			, IPCLIENT= '".$this->getField("IPCLIENT")."'
			, MACADDRESS= '".$this->getField("MACADDRESS")."'
			, NAMACLIENT= '".$this->getField("NAMACLIENT")."'
			, PRIORITAS= '".$this->getField("PRIORITAS")."'
			, PATH_ASLI= '".$this->getField("PATH_ASLI")."'
		WHERE PEGAWAI_FILE_ID = ".$this->getField("PEGAWAI_FILE_ID")."
		"; 
		$this->query = $str;
		// echo $str;exit();
		return $this->execQuery($str);
    }

    function updateprioritas()
	{
		$str = "		
		UPDATE PEGAWAI_FILE
		SET    
			PRIORITAS= ''
		WHERE PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")."
		AND KATEGORI_FILE_ID = ".$this->getField("KATEGORI_FILE_ID")."
		AND RIWAYAT_ID = ".$this->getField("RIWAYAT_ID")."
		AND RIWAYAT_FIELD = '".$this->getField("RIWAYAT_FIELD")."'
		AND PEGAWAI_FILE_ID != ".$this->getField("PEGAWAI_FILE_ID")."
		AND PRIORITAS = '".$this->getField("PRIORITAS")."'
		";
		$this->query = $str;
		// echo $str;exit();
		return $this->execQuery($str);
    }
	
	function updateStatus()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "		
				UPDATE PEGAWAI_FILE
				SET    
					   STATUS   	= ".$this->getField("STATUS").",
					   LAST_USER	= '".$this->getField("LAST_USER")."',
					   LAST_DATE	= ".$this->getField("LAST_DATE")."
				WHERE  PEGAWAI_FILE_ID    = ".$this->getField("PEGAWAI_FILE_ID")."
				"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete1()
	{
        $str = "
				UPDATE PEGAWAI_FILE SET
					STATUS = '1',
					LAST_USER = '".$this->getField("LAST_USER")."',
					USER_LOGIN_ID = '".$this->getField("USER_LOGIN_ID")."',
					USER_LOGIN_PEGAWAI_ID = ".$this->getField("USER_LOGIN_PEGAWAI_ID").",
					LAST_DATE = ".$this->getField("LAST_DATE")."
				WHERE PEGAWAI_FILE_ID = ".$this->getField("PEGAWAI_FILE_ID")."
				";
		$this->query = $str;
		return $this->execQuery($str);
    }

    function deletelog()
	{
        $str = "
				DELETE FROM PEGAWAI_FILE_LOG
				WHERE PEGAWAI_FILE_ID = ".$this->getField("PEGAWAI_FILE_ID")."
				";
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function delete()
	{
        $str = "
				DELETE FROM PEGAWAI_FILE
				WHERE PEGAWAI_FILE_ID = ".$this->getField("PEGAWAI_FILE_ID")."
				";
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function renamelokasi()
	{
        $str = "
				UPDATE PEGAWAI_FILE SET
				STATUS = '1'
				, PATH= '".$this->getField("PATH")."'
				, LAST_USER = '".$this->getField("LAST_USER")."'
				, USER_LOGIN_ID = '".$this->getField("USER_LOGIN_ID")."'
				, USER_LOGIN_PEGAWAI_ID = ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
				, LAST_DATE = ".$this->getField("LAST_DATE")."
				, IPCLIENT= '".$this->getField("IPCLIENT")."'
				, MACADDRESS= '".$this->getField("MACADDRESS")."'
				, NAMACLIENT= '".$this->getField("NAMACLIENT")."'
				WHERE PEGAWAI_FILE_ID = ".$this->getField("PEGAWAI_FILE_ID")."
				";
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function deleteNew()
	{
        $str = "
				UPDATE PEGAWAI_FILE SET
					STATUS = '1',
					LAST_USER = '".$this->getField("LAST_USER")."',
					USER_LOGIN_ID = '".$this->getField("USER_LOGIN_ID")."',
					USER_LOGIN_PEGAWAI_ID = ".$this->getField("USER_LOGIN_PEGAWAI_ID").",
					LAST_DATE = ".$this->getField("LAST_DATE").",
					FILE_KUALITAS_ID = NULL,
					KATEGORI_FILE_ID = NULL
				WHERE PEGAWAI_FILE_ID = ".$this->getField("PEGAWAI_FILE_ID")."
				";
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","MASTER_KATEGORI_METODE_EVALUASI_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParamsLastRiwayatTable($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ')
	{
		$str = "
		SELECT
		A.PEGAWAI_FILE_ID, A.PEGAWAI_ID, A.RIWAYAT_TABLE, A.RIWAYAT_FIELD, A.RIWAYAT_ID, 
		A.FILE_KUALITAS_ID, A.PATH, A.STATUS_VERIFIKASI, A.KETERANGAN, A.STATUS, 
		A.KATEGORI_FILE_ID, A.LAST_USER, A.LAST_DATE, A.LAST_LEVEL
		, SPLIT_PART(A.PATH, '/', 3) PATH_NAMA
		FROM PEGAWAI_FILE A
		INNER JOIN
		(
			SELECT
			PEGAWAI_ID, RIWAYAT_TABLE, RIWAYAT_ID
			FROM PEGAWAI_FILE A
			WHERE 1=1
			GROUP BY PEGAWAI_ID, RIWAYAT_TABLE, RIWAYAT_ID
		) B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND A.RIWAYAT_TABLE = B.RIWAYAT_TABLE AND A.RIWAYAT_ID = B.RIWAYAT_ID
		WHERE 1=1
		"; 
		// , MAX(LAST_DATE) LAST_DATE
		 // AND A.LAST_DATE = B.LAST_DATE
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;exit;
		return $this->selectLimit($str,$limit,$from); 
		
    }
	
	function selectByParamsKategoriDokumen($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY URUT')
	{
		$str = "
		SELECT A.KATEGORI_FILE_ID, A.NAMA
		FROM KATEGORI_FILE A
		WHERE 1 = 1
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
	
	function selectByParamsJenisDokumen($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.PEGAWAI_ID ASC, NO_URUT')
	{
		$str = "
		SELECT NO_URUT, PEGAWAI_ID, RIWAYAT_TABLE, RIWAYAT_FIELD, RIWAYAT_ID, INFO_DATA
		, CASE WHEN RIWAYAT_TABLE  = 'SK_CPNS' THEN 'SK CPNS' WHEN RIWAYAT_TABLE = 'SK_PNS' THEN 'SK PNS' WHEN RIWAYAT_TABLE  = 'JABATAN_RIWAYAT' THEN 'Jabatan' 
		WHEN RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' AND (NO_URUT = 1 OR NO_URUT = 2)  THEN '' 
		WHEN RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' THEN 'Kenaikan Pangkat' 
		WHEN RIWAYAT_TABLE = 'PENDIDIKAN_RIWAYAT' THEN 'Ijazah'
		WHEN RIWAYAT_TABLE = 'PENILAIAN_SKP' THEN 'SKP'
		END INFO_GROUP_DATABAK
		, CONCAT(B.NAMA, ' - ', INFO_DATA) INFO_GROUP_DATA
		FROM RIWAYAT_FILE A
		LEFT JOIN KATEGORI_FILE B ON A.NO_URUT = B.KATEGORI_FILE_ID
		WHERE 1 = 1
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str;exit;
		return $this->selectLimit($str,$limit,$from); 
		
    }
	
	function selectByParamsJenisDokumenBAK1($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.PEGAWAI_ID ASC, NO_URUT')
	{
		$str = "
		SELECT NO_URUT, PEGAWAI_ID, RIWAYAT_TABLE, RIWAYAT_FIELD, RIWAYAT_ID, INFO_DATA
		, CASE WHEN RIWAYAT_TABLE  = 'SK_CPNS' THEN 'SK CPNS' WHEN RIWAYAT_TABLE = 'SK_PNS' THEN 'SK PNS' WHEN RIWAYAT_TABLE  = 'JABATAN_RIWAYAT' THEN 'Jabatan' 
		WHEN RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' AND (NO_URUT = 1 OR NO_URUT = 2)  THEN '' 
		WHEN RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' THEN 'Kenaikan Pangkat' 
		WHEN RIWAYAT_TABLE = 'PENDIDIKAN_RIWAYAT' THEN 'Ijazah'
		WHEN RIWAYAT_TABLE = 'PENILAIAN_SKP' THEN 'SKP'
		END INFO_GROUP_DATABAK
		, CONCAT(B.NAMA, ' - ', INFO_DATA) INFO_GROUP_DATA
		FROM
		(
			SELECT 1 NO_URUT, A.PEGAWAI_ID, 'PANGKAT_RIWAYAT' RIWAYAT_TABLE, NULL RIWAYAT_FIELD, CAST(A.PANGKAT_RIWAYAT_ID AS TEXT) RIWAYAT_ID
			, 'SK CPNS' INFO_DATA
			FROM
			(
				SELECT 	
					A.PANGKAT_RIWAYAT_ID, A.PEGAWAI_ID, A.PANGKAT_ID, A.NO_SK, GETFORMATTEDDATE(CAST(A.TANGGAL_SK AS TEXT)) TANGGAL_SK, GETFORMATTEDDATE(CAST(A.TMT_PANGKAT AS TEXT)) TMT_PANGKAT, A.MASA_KERJA_TAHUN, A.MASA_KERJA_BULAN
					, B.KODE PANGKAT_KODE, B.NAMA PANGKAT_NAMA
				FROM PANGKAT_RIWAYAT A
				LEFT JOIN PANGKAT B ON A.PANGKAT_ID = B.PANGKAT_ID
				WHERE 1=1 AND A.JENIS_RIWAYAT = 1
			) A
			UNION ALL
			SELECT 2 NO_URUT, A.PEGAWAI_ID, 'PANGKAT_RIWAYAT' RIWAYAT_TABLE, NULL RIWAYAT_FIELD, CAST(A.PANGKAT_RIWAYAT_ID AS TEXT) RIWAYAT_ID
			, 'SK PNS' INFO_DATA
			FROM
			(
				SELECT 	
					A.PANGKAT_RIWAYAT_ID, A.PEGAWAI_ID, A.PANGKAT_ID, A.NO_SK, GETFORMATTEDDATE(CAST(A.TANGGAL_SK AS TEXT)) TANGGAL_SK, GETFORMATTEDDATE(CAST(A.TMT_PANGKAT AS TEXT)) TMT_PANGKAT, A.MASA_KERJA_TAHUN, A.MASA_KERJA_BULAN
					, B.KODE PANGKAT_KODE, B.NAMA PANGKAT_NAMA
				FROM PANGKAT_RIWAYAT A
				LEFT JOIN PANGKAT B ON A.PANGKAT_ID = B.PANGKAT_ID
				WHERE 1=1 AND A.JENIS_RIWAYAT = 2
			) A
			UNION ALL
			SELECT 3 NO_URUT, A.PEGAWAI_ID, 'JABATAN_RIWAYAT' RIWAYAT_TABLE, NULL RIWAYAT_FIELD, CAST(A.JABATAN_RIWAYAT_ID AS TEXT) RIWAYAT_ID
			, CONCAT(NAMA, ' - ', TMT_JABATAN) INFO_DATA
			FROM
			(
				SELECT A.JABATAN_RIWAYAT_ID, A.PEGAWAI_ID, A.NO_SK, GETFORMATTEDDATE(CAST(TO_CHAR(A.TANGGAL_SK, 'YYYY-MM-DD') AS TEXT)) TANGGAL_SK
				, GETFORMATTEDDATE(CAST(TO_CHAR(A.TMT_JABATAN, 'YYYY-MM-DD') AS TEXT)) TMT_JABATAN, A.NAMA
				FROM JABATAN_RIWAYAT A
				LEFT JOIN ESELON B ON A.ESELON_ID = B.ESELON_ID
				WHERE 1 = 1
			) A
			UNION ALL
			SELECT 4 NO_URUT, A.PEGAWAI_ID, 'PANGKAT_RIWAYAT' RIWAYAT_TABLE, NULL RIWAYAT_FIELD, CAST(A.PANGKAT_RIWAYAT_ID AS TEXT) RIWAYAT_ID
			, CONCAT(PANGKAT_KODE, ' - ', TMT_PANGKAT) INFO_DATA
			FROM
			(
				SELECT 	
					A.PANGKAT_RIWAYAT_ID, A.PEGAWAI_ID, A.PANGKAT_ID, A.NO_SK, GETFORMATTEDDATE(CAST(A.TANGGAL_SK AS TEXT)) TANGGAL_SK, GETFORMATTEDDATE(CAST(A.TMT_PANGKAT AS TEXT)) TMT_PANGKAT, A.MASA_KERJA_TAHUN, A.MASA_KERJA_BULAN
					, B.KODE PANGKAT_KODE, B.NAMA PANGKAT_NAMA
				FROM PANGKAT_RIWAYAT A
				LEFT JOIN PANGKAT B ON A.PANGKAT_ID = B.PANGKAT_ID
				WHERE 1=1 AND A.JENIS_RIWAYAT NOT IN (1,2)
			) A
			UNION ALL
			SELECT 6 NO_URUT, A.PEGAWAI_ID, 'PENDIDIKAN_RIWAYAT' RIWAYAT_TABLE, NULL RIWAYAT_FIELD, CAST(A.PENDIDIKAN_RIWAYAT_ID AS TEXT) RIWAYAT_ID
			, PENDIDIKAN_NAMA_STATUS INFO_DATA
			FROM
			(
				SELECT 	
					A.PENDIDIKAN_RIWAYAT_ID, A.PEGAWAI_ID, CONCAT(C.NAMA,
					' - ' , CASE A.STATUS_PENDIDIKAN
					WHEN '1' THEN 'Pendidikan CPNS'
					WHEN '2' THEN 'Diakui'
					WHEN '3' THEN 'Belum Diakui'
					WHEN '4' THEN 'Riwayat'
					WHEN '5' THEN 'Ijin belajar'
					WHEN '6' THEN 'Tugas Belajar'
					ELSE '-' END) PENDIDIKAN_NAMA_STATUS
				FROM PENDIDIKAN_RIWAYAT A
				LEFT JOIN PENDIDIKAN C ON A.PENDIDIKAN_ID = C.PENDIDIKAN_ID
				WHERE 1 = 1
				AND A.STATUS IS NULL
			) A
			UNION ALL
			SELECT 7 NO_URUT, A.PEGAWAI_ID, 'PENILAIAN_SKP' RIWAYAT_TABLE, NULL RIWAYAT_FIELD, CAST(A.PENILAIAN_SKP_ID AS TEXT) RIWAYAT_ID
			, A.TAHUN INFO_DATA
			FROM
			(
				SELECT 	
					A.PENILAIAN_SKP_ID, A.PEGAWAI_ID, CAST(A.TAHUN AS TEXT) TAHUN
				FROM PENILAIAN_SKP A
				WHERE 1=1
			) A
		) A
		LEFT JOIN KATEGORI_FILE B ON A.NO_URUT = B.KATEGORI_FILE_ID
		WHERE 1 = 1
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
	
	function selectByParamsJenisDokumenBak($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.PEGAWAI_ID ASC, NO_URUT')
	{
		$str = "
		SELECT NO_URUT, PEGAWAI_ID, RIWAYAT_TABLE, RIWAYAT_FIELD, RIWAYAT_ID, INFO_DATA
		, CASE RIWAYAT_TABLE WHEN 'SK_CPNS' THEN 'SK CPNS' WHEN 'SK_PNS' THEN 'SK PNS' WHEN 'JABATAN_RIWAYAT' THEN 'Jabatan' WHEN 'PANGKAT_RIWAYAT' THEN 'Kenaikan Pangkat' WHEN 'PENDIDIKAN_RIWAYAT' THEN 'Ijazah' END INFO_GROUP_DATA
		FROM
		(
			SELECT 1 NO_URUT, A.PEGAWAI_ID, 'SK_CPNS' RIWAYAT_TABLE, NULL RIWAYAT_FIELD, NULL RIWAYAT_ID, 'SK CPNS' INFO_DATA
			FROM
			(
				SELECT 	
					A.PEGAWAI_ID
				FROM SK_CPNS A
				WHERE 1=1
			) A
			UNION ALL
			SELECT 2 NO_URUT, A.PEGAWAI_ID, 'SK_PNS' RIWAYAT_TABLE, NULL RIWAYAT_FIELD, NULL RIWAYAT_ID, 'SK PNS' INFO_DATA
			FROM
			(
				SELECT 	
					A.PEGAWAI_ID
				FROM SK_PNS A
				WHERE 1=1
			) A
			UNION ALL
			SELECT 3 NO_URUT, A.PEGAWAI_ID, 'JABATAN_RIWAYAT' RIWAYAT_TABLE, NULL RIWAYAT_FIELD, CAST(A.JABATAN_RIWAYAT_ID AS TEXT) RIWAYAT_ID
			, CONCAT(NAMA, ' - ', TMT_JABATAN) INFO_DATA
			FROM
			(
				SELECT A.JABATAN_RIWAYAT_ID, A.PEGAWAI_ID, A.NO_SK, GETFORMATTEDDATE(CAST(TO_CHAR(A.TANGGAL_SK, 'YYYY-MM-DD') AS TEXT)) TANGGAL_SK
				, GETFORMATTEDDATE(CAST(TO_CHAR(A.TMT_JABATAN, 'YYYY-MM-DD') AS TEXT)) TMT_JABATAN, A.NAMA
				FROM JABATAN_RIWAYAT A
				LEFT JOIN ESELON B ON A.ESELON_ID = B.ESELON_ID
				WHERE 1 = 1
			) A
			UNION ALL
			SELECT 4 NO_URUT, A.PEGAWAI_ID, 'PANGKAT_RIWAYAT' RIWAYAT_TABLE, NULL RIWAYAT_FIELD, CAST(A.PANGKAT_RIWAYAT_ID AS TEXT) RIWAYAT_ID
			, TMT_PANGKAT INFO_DATA
			FROM
			(
				SELECT 	
					A.PANGKAT_RIWAYAT_ID, A.PEGAWAI_ID, A.PANGKAT_ID, A.NO_SK, GETFORMATTEDDATE(CAST(A.TANGGAL_SK AS TEXT)) TANGGAL_SK, GETFORMATTEDDATE(CAST(A.TMT_PANGKAT AS TEXT)) TMT_PANGKAT, A.MASA_KERJA_TAHUN, A.MASA_KERJA_BULAN
					, B.KODE PANGKAT_KODE, B.NAMA PANGKAT_NAMA
				FROM PANGKAT_RIWAYAT A
				LEFT JOIN PANGKAT B ON A.PANGKAT_ID = B.PANGKAT_ID
				WHERE 1=1
			) A
			UNION ALL
			SELECT 5 NO_URUT, A.PEGAWAI_ID, 'PENDIDIKAN_RIWAYAT' RIWAYAT_TABLE, NULL RIWAYAT_FIELD, CAST(A.PENDIDIKAN_RIWAYAT_ID AS TEXT) RIWAYAT_ID
			, PENDIDIKAN_NAMA_STATUS INFO_DATA
			FROM
			(
				SELECT 	
					A.PENDIDIKAN_RIWAYAT_ID, A.PEGAWAI_ID, CONCAT(C.NAMA,
					' - ' , CASE A.STATUS_PENDIDIKAN
					WHEN '1' THEN 'Pendidikan CPNS'
					WHEN '2' THEN 'Diakui'
					WHEN '3' THEN 'Belum Diakui'
					WHEN '4' THEN 'Riwayat'
					WHEN '5' THEN 'Ijin belajar'
					WHEN '6' THEN 'Tugas Belajar'
					ELSE '-' END) PENDIDIKAN_NAMA_STATUS
				FROM PENDIDIKAN_RIWAYAT A
				LEFT JOIN PENDIDIKAN C ON A.PENDIDIKAN_ID = C.PENDIDIKAN_ID
				WHERE 1 = 1
			) A
		) A
		WHERE 1 = 1
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
	
	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.PEGAWAI_FILE_ID ASC')
	{
		$str = "
				SELECT A.PEGAWAI_FILE_ID, A.PEGAWAI_ID, A.RIWAYAT_TABLE, A.RIWAYAT_FIELD, A.RIWAYAT_ID, A.FILE_KUALITAS_ID, B.NAMA FILE_KUALITAS_NAMA, A.PATH, 
				A.STATUS_VERIFIKASI, A.KETERANGAN, A.STATUS,
				CASE A.STATUS WHEN '1' THEN 'Tidak Aktif' ELSE 'Aktif' END STATUS_NAMA
				, CASE RIWAYAT_TABLE WHEN 'SK_CPNS' THEN 'SK CPNS' WHEN 'SK_PNS' THEN 'SK PNS' WHEN 'JABATAN_RIWAYAT' THEN 'Jabatan' WHEN 'PANGKAT_RIWAYAT' THEN 'Kenaikan Pangkat' WHEN 'PENDIDIKAN_RIWAYAT' THEN 'Ijazah' END INFO_GROUP_DATAbak
				, 
				CASE WHEN RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' AND A.KATEGORI_FILE_ID = 1 THEN 'SK CPNS' WHEN RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' AND A.KATEGORI_FILE_ID = 2 THEN 'SK PNS' WHEN RIWAYAT_TABLE  = 'JABATAN_RIWAYAT' THEN 'Jabatan'
				WHEN RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' THEN 'Kenaikan Pangkat' 
				WHEN RIWAYAT_TABLE = 'PENDIDIKAN_RIWAYAT' THEN 'Ijazah' END INFO_GROUP_DATAbak1
				, XX.NAMA_ROW INFO_GROUP_DATA
				, A.KATEGORI_FILE_ID
				FROM PEGAWAI_FILE A
				LEFT JOIN KUALITAS_FILE B ON A.FILE_KUALITAS_ID = B.KUALITAS_FILE_ID
				LEFT JOIN
				(
					SELECT CONCAT(CAST(A.NO_URUT AS TEXT),'-',CAST(A.PEGAWAI_ID AS TEXT),'-',CAST(A.RIWAYAT_TABLE AS TEXT),'-',CAST(A.RIWAYAT_ID AS TEXT)) ID_ROW,
					CASE WHEN B.URUT = 2 OR B.URUT = 3 THEN B.NAMA ELSE CONCAT(B.NAMA,'-',A.INFO_DATA) END NAMA_ROW
					FROM RIWAYAT_FILE A
					INNER JOIN KATEGORI_FILE B ON A.NO_URUT = B.KATEGORI_FILE_ID
				) XX ON CONCAT(CAST(A.KATEGORI_FILE_ID AS TEXT),'-',CAST(A.PEGAWAI_ID AS TEXT),'-',CAST(A.RIWAYAT_TABLE AS TEXT),'-',CAST(A.RIWAYAT_ID AS TEXT)) = XX.ID_ROW
				WHERE 1 = 1
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

    function selectByParamsFileInfo($paramsArray=array(),$limit=-1,$from=-1, $statement='', $pegawaiid="", $order='', $riwayattable= "")
	{
		$str = "
		SELECT
		CONCAT(CAST(A.NO_URUT AS TEXT),'-',CAST(A.PEGAWAI_ID AS TEXT),'-',CAST(A.RIWAYAT_TABLE AS TEXT),'-',CAST(A.RIWAYAT_FIELD AS TEXT),'-',CAST(A.RIWAYAT_ID AS TEXT)) ID_ROW
		, CONCAT(B.NAMA,'-',A.INFO_DATA) NAMA_ROW
		FROM RIWAYAT_FILE A
		INNER JOIN KATEGORI_FILE B ON A.NO_URUT = B.KATEGORI_FILE_ID
		WHERE 1=1 AND A.PEGAWAI_ID = ".$pegawaiid.$riwayattable."
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		// echo $str;exit;
		return $this->selectLimit($str,$limit,$from); 
		
    }
    
    function selectByParamsFile($paramsArray=array(),$limit=-1,$from=-1, $statement='', $pegawaiid="", $order=' ORDER BY A.PEGAWAI_FILE_ID ASC', $riwayattable= "")
	{
		$str = "
		SELECT
			CASE WHEN A.RIWAYAT_TABLE = 'PERSURATAN.SURAT_MASUK_PEGAWAI' THEN
			CONCAT(CAST(A.KATEGORI_FILE_ID AS TEXT),'-',CAST(A.PEGAWAI_ID AS TEXT),'-',CAST(A.RIWAYAT_TABLE AS TEXT),'-','','-',CAST(A.RIWAYAT_ID AS TEXT))
			ELSE
			CONCAT(CAST(A.KATEGORI_FILE_ID AS TEXT),'-',CAST(A.PEGAWAI_ID AS TEXT),'-',CAST(A.RIWAYAT_TABLE AS TEXT),'-',CAST(A.RIWAYAT_FIELD AS TEXT),'-',CAST(A.RIWAYAT_ID AS TEXT)) 
			END P_ID_ROW
			, A.PEGAWAI_FILE_ID, A.PEGAWAI_ID, A.RIWAYAT_TABLE, A.RIWAYAT_FIELD, A.RIWAYAT_ID, A.FILE_KUALITAS_ID, B.NAMA FILE_KUALITAS_NAMA, A.PATH, 
			A.STATUS_VERIFIKASI, A.KETERANGAN, A.STATUS
			, CASE A.STATUS WHEN '1' THEN 'Tidak Aktif' ELSE 'Aktif' END STATUS_NAMA
			, CASE RIWAYAT_TABLE WHEN 'SK_CPNS' THEN 'SK CPNS' WHEN 'SK_PNS' THEN 'SK PNS' WHEN 'JABATAN_RIWAYAT' THEN 'Jabatan' WHEN 'PANGKAT_RIWAYAT' THEN 'Kenaikan Pangkat' WHEN 'PENDIDIKAN_RIWAYAT' THEN 'Ijazah' END INFO_GROUP_DATAbak
			, CASE WHEN RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' AND A.KATEGORI_FILE_ID = 1 THEN 'SK CPNS' WHEN RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' AND A.KATEGORI_FILE_ID = 2 THEN 'SK PNS' WHEN RIWAYAT_TABLE  = 'JABATAN_RIWAYAT' THEN 'Jabatan'
			WHEN RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' THEN 'Kenaikan Pangkat' 
			WHEN RIWAYAT_TABLE = 'PENDIDIKAN_RIWAYAT' THEN 'Ijazah' END INFO_GROUP_DATAbak1
			, A.KATEGORI_FILE_ID, A.PATH_ASLI, A.EXT, A.PRIORITAS, A.TEMP_VALIDASI_BELUM_ID
		FROM PEGAWAI_FILE A
		LEFT JOIN KUALITAS_FILE B ON A.FILE_KUALITAS_ID = B.KUALITAS_FILE_ID
		WHERE 1=1 AND A.PEGAWAI_ID = ".$pegawaiid."
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str;exit;
		return $this->selectLimit($str,$limit,$from); 
		
    }

    function selectByParamsFileBak($paramsArray=array(),$limit=-1,$from=-1, $statement='', $pegawaiid="", $order=' ORDER BY A.PEGAWAI_FILE_ID ASC', $riwayattable= "")
	{
		$str = "
		SELECT
			CASE WHEN A.RIWAYAT_TABLE = 'PERSURATAN.SURAT_MASUK_PEGAWAI' THEN
			CONCAT(CAST(A.KATEGORI_FILE_ID AS TEXT),'-',CAST(A.PEGAWAI_ID AS TEXT),'-',CAST(A.RIWAYAT_TABLE AS TEXT),'-','','-',CAST(A.RIWAYAT_ID AS TEXT))
			ELSE
			CONCAT(CAST(A.KATEGORI_FILE_ID AS TEXT),'-',CAST(A.PEGAWAI_ID AS TEXT),'-',CAST(A.RIWAYAT_TABLE AS TEXT),'-',CAST(A.RIWAYAT_FIELD AS TEXT),'-',CAST(A.RIWAYAT_ID AS TEXT)) 
			END P_ID_ROW
			, A.PEGAWAI_FILE_ID, A.PEGAWAI_ID, A.RIWAYAT_TABLE, A.RIWAYAT_FIELD, A.RIWAYAT_ID, A.FILE_KUALITAS_ID, B.NAMA FILE_KUALITAS_NAMA, A.PATH, 
			A.STATUS_VERIFIKASI, A.KETERANGAN, A.STATUS
			, CASE A.STATUS WHEN '1' THEN 'Tidak Aktif' ELSE 'Aktif' END STATUS_NAMA
			, CASE RIWAYAT_TABLE WHEN 'SK_CPNS' THEN 'SK CPNS' WHEN 'SK_PNS' THEN 'SK PNS' WHEN 'JABATAN_RIWAYAT' THEN 'Jabatan' WHEN 'PANGKAT_RIWAYAT' THEN 'Kenaikan Pangkat' WHEN 'PENDIDIKAN_RIWAYAT' THEN 'Ijazah' END INFO_GROUP_DATAbak
			, CASE WHEN RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' AND A.KATEGORI_FILE_ID = 1 THEN 'SK CPNS' WHEN RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' AND A.KATEGORI_FILE_ID = 2 THEN 'SK PNS' WHEN RIWAYAT_TABLE  = 'JABATAN_RIWAYAT' THEN 'Jabatan'
			WHEN RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' THEN 'Kenaikan Pangkat' 
			WHEN RIWAYAT_TABLE = 'PENDIDIKAN_RIWAYAT' THEN 'Ijazah' END INFO_GROUP_DATAbak1
			, XX.NAMA_ROW INFO_GROUP_DATA
			, A.KATEGORI_FILE_ID, A.PATH_ASLI, A.EXT, A.PRIORITAS
		FROM PEGAWAI_FILE A
		LEFT JOIN KUALITAS_FILE B ON A.FILE_KUALITAS_ID = B.KUALITAS_FILE_ID
		LEFT JOIN
		(
			SELECT CONCAT(CAST(A.NO_URUT AS TEXT),'-',CAST(A.PEGAWAI_ID AS TEXT),'-',CAST(A.RIWAYAT_TABLE AS TEXT),'-',CAST(A.RIWAYAT_FIELD AS TEXT),'-',CAST(A.RIWAYAT_ID AS TEXT)) ID_ROW
			--, CASE WHEN B.URUT = 2 OR B.URUT = 3 THEN B.NAMA ELSE CONCAT(B.NAMA,'-',A.INFO_DATA) END NAMA_ROW
			, CONCAT(B.NAMA,'-',A.INFO_DATA) NAMA_ROW
			FROM RIWAYAT_FILE A
			INNER JOIN KATEGORI_FILE B ON A.NO_URUT = B.KATEGORI_FILE_ID
			WHERE 1=1 AND A.PEGAWAI_ID = ".$pegawaiid.$riwayattable."
		) XX ON
		CASE WHEN A.RIWAYAT_TABLE = 'PERSURATAN.SURAT_MASUK_PEGAWAI' THEN
		CONCAT(CAST(A.KATEGORI_FILE_ID AS TEXT),'-',CAST(A.PEGAWAI_ID AS TEXT),'-',CAST(A.RIWAYAT_TABLE AS TEXT),'-','','-',CAST(A.RIWAYAT_ID AS TEXT))
		ELSE
		CONCAT(CAST(A.KATEGORI_FILE_ID AS TEXT),'-',CAST(A.PEGAWAI_ID AS TEXT),'-',CAST(A.RIWAYAT_TABLE AS TEXT),'-',CAST(A.RIWAYAT_FIELD AS TEXT),'-',CAST(A.RIWAYAT_ID AS TEXT)) 
		END
		= XX.ID_ROW
		WHERE 1=1 AND A.PEGAWAI_ID = ".$pegawaiid."
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str;exit;
		return $this->selectLimit($str,$limit,$from); 
		
    }

	function selectByParamsBAK1($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.PEGAWAI_FILE_ID ASC')
	{
		$str = "
				SELECT A.PEGAWAI_FILE_ID, A.PEGAWAI_ID, A.RIWAYAT_TABLE, A.RIWAYAT_FIELD, A.RIWAYAT_ID, A.FILE_KUALITAS_ID, B.NAMA FILE_KUALITAS_NAMA, A.PATH, 
				A.STATUS_VERIFIKASI, A.KETERANGAN, A.STATUS,
				CASE A.STATUS WHEN '1' THEN 'Tidak Aktif' ELSE 'Aktif' END STATUS_NAMA
				, CASE RIWAYAT_TABLE WHEN 'SK_CPNS' THEN 'SK CPNS' WHEN 'SK_PNS' THEN 'SK PNS' WHEN 'JABATAN_RIWAYAT' THEN 'Jabatan' WHEN 'PANGKAT_RIWAYAT' THEN 'Kenaikan Pangkat' WHEN 'PENDIDIKAN_RIWAYAT' THEN 'Ijazah' END INFO_GROUP_DATAbak
				, 
				CASE WHEN RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' AND A.KATEGORI_FILE_ID = 1 THEN 'SK CPNS' WHEN RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' AND A.KATEGORI_FILE_ID = 2 THEN 'SK PNS' WHEN RIWAYAT_TABLE  = 'JABATAN_RIWAYAT' THEN 'Jabatan'
				WHEN RIWAYAT_TABLE = 'PANGKAT_RIWAYAT' THEN 'Kenaikan Pangkat' 
				WHEN RIWAYAT_TABLE = 'PENDIDIKAN_RIWAYAT' THEN 'Ijazah' END INFO_GROUP_DATA
				, A.KATEGORI_FILE_ID
				FROM PEGAWAI_FILE A
				LEFT JOIN KUALITAS_FILE B ON A.FILE_KUALITAS_ID = B.KUALITAS_FILE_ID
				WHERE 1 = 1
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
	
    function getCountByParams($paramsArray=array(), $statement='')
	{
		$str = "
				SELECT COUNT(A.PEGAWAI_FILE_ID) AS ROWCOUNT 
				FROM PEGAWAI_FILE A
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

    function selectbyriwayatfieldcpnsfile($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order='')
    {
    	$str = "
    	SELECT 
    	*
    	FROM riwayat_pegawai_cpns_file A
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

    function selectbyriwayatfieldpnsfile($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order='')
    {
    	$str = "
    	SELECT 
    	*
    	FROM riwayat_pegawai_pns_file A
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

    function selectbyriwayatfieldanakfile($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order='')
    {
    	$str = "
    	SELECT 
    	*
    	FROM riwayat_pegawai_anak_file A
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

    function selectbyriwayatfieldsuamiistrifile($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order='')
    {
    	$str = "
    	SELECT 
    	*
    	FROM riwayat_pegawai_suami_istri_file A
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

    function selectbyriwayatfieldorangtuafile($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order='')
    {
    	$str = "
    	SELECT 
		CASE WHEN A.RIWAYAT_FIELD ~~ 'L%'::TEXT THEN 'L' ELSE 'P' END JENIS_KELAMIN
		, A.*
		FROM riwayat_pegawai_orangtua_file A
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

    function selectbyriwayatfieldskpppkfile($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order='')
    {
    	$str = "
    	SELECT 
    	*
    	FROM riwayat_pegawai_skp_ppk_file A
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

    function selectbyriwayatfieldpendidikanfile($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order='')
    {
    	$str = "
    	SELECT 
    	*
    	FROM riwayat_pegawai_pendidikan_file A
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

    function selectbyriwayatfieldpendidikantupelfile($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order='')
    {
    	$str = "
    	SELECT 
    	*
    	FROM riwayat_pegawai_pendidikan_tupel_file A
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

  } 
?>