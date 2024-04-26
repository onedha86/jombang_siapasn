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
  
  class Penghargaan extends Entity{ 

	 var $query;
  	var $id;
    /**
    * Class constructor.
    **/
    function Penghargaan()
	{
      $this->Entity(); 
    }

	function insert()
	{
		$this->setField("PENGHARGAAN_ID", $this->getNextId("PENGHARGAAN_ID","PENGHARGAAN"));
		// , NAMA
		// , '".$this->getField("NAMA")."'
     	$str = "
     	INSERT INTO PENGHARGAAN
     	(
     		PENGHARGAAN_ID, PEGAWAI_ID, PEJABAT_PENETAP_ID, PEJABAT_PENETAP, NO_SK, TANGGAL_SK, TAHUN
     		, REF_PENGHARGAAN_ID, NAMA_DETIL, JENJANG_PERINGKAT_ID, PENGHARGAAN_PREDIKAT_ID
     		, LAST_USER, LAST_DATE, LAST_LEVEL, USER_LOGIN_ID, USER_LOGIN_PEGAWAI_ID
     	) 
     	VALUES
     	(
	     	".$this->getField("PENGHARGAAN_ID")."
	     	, ".$this->getField("PEGAWAI_ID")."
	     	, ".$this->getField("PEJABAT_PENETAP_ID")."
	     	, '".$this->getField("PEJABAT_PENETAP")."'
	     	, '".$this->getField("NO_SK")."'
	     	, ".$this->getField("TANGGAL_SK")."
	     	, ".$this->getField("TAHUN")."
	     	, ".$this->getField("REF_PENGHARGAAN_ID")."
	     	, '".$this->getField("NAMA_DETIL")."'
	     	, ".$this->getField("JENJANG_PERINGKAT_ID")."
	     	, ".$this->getField("PENGHARGAAN_PREDIKAT_ID")."
	     	, '".$this->getField("LAST_USER")."'
	     	, ".$this->getField("LAST_DATE")."
	     	, ".$this->getField("LAST_LEVEL")."
	     	, ".$this->getField("USER_LOGIN_ID")."
	     	, ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
     	)
		"; 	
		$this->id = $this->getField("PENGHARGAAN_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }


    function update()
	{
		// , NAMA= '".$this->getField("NAMA")."'
		$str = "		
		UPDATE PENGHARGAAN
		SET    
			PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
			, PEJABAT_PENETAP_ID= ".$this->getField("PEJABAT_PENETAP_ID")."
			, PEJABAT_PENETAP= '".$this->getField("PEJABAT_PENETAP")."'
			, NO_SK= '".$this->getField("NO_SK")."'
			, TANGGAL_SK= ".$this->getField("TANGGAL_SK")."
			, TAHUN= ".$this->getField("TAHUN")."
			, REF_PENGHARGAAN_ID= ".$this->getField("REF_PENGHARGAAN_ID")."
			, NAMA_DETIL= '".$this->getField("NAMA_DETIL")."'
	     	, JENJANG_PERINGKAT_ID= ".$this->getField("JENJANG_PERINGKAT_ID")."
	     	, PENGHARGAAN_PREDIKAT_ID= ".$this->getField("PENGHARGAAN_PREDIKAT_ID")."
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_DATE= ".$this->getField("LAST_DATE")."
			, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
			, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
			, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
		WHERE PENGHARGAAN_ID = ".$this->getField("PENGHARGAAN_ID")."
		";
		$this->query = $str;
		//echo $str;exit;
		//echo $this->errorMsg;exit;
		return $this->execQuery($str);
    }

    function insertDataBkn()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PENGHARGAAN_ID", $this->getNextId("PENGHARGAAN_ID","PENGHARGAAN")); 

		$str = "
		INSERT INTO PENGHARGAAN
     	(
     		PENGHARGAAN_ID, PEGAWAI_ID, NO_SK, TANGGAL_SK, TAHUN, REF_PENGHARGAAN_ID, LAST_DATE
     	) 
     	VALUES
     	(
	     	".$this->getField("PENGHARGAAN_ID")."
	     	, ".$this->getField("PEGAWAI_ID")."
	     	, '".$this->getField("NO_SK")."'
	     	, ".$this->getField("TANGGAL_SK")."
	     	, ".$this->getField("TAHUN")."
	     	, ".$this->getField("REF_PENGHARGAAN_ID")."
	     	, NOW()
     	)
		";
		// echo "xxx-".$str;exit;

		$this->id = $this->getField("PENGHARGAAN_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function updateDataBkn()
    {
		$str = "		
		UPDATE PENGHARGAAN
		SET
			PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
			, NO_SK= '".$this->getField("NO_SK")."'
			, TANGGAL_SK= ".$this->getField("TANGGAL_SK")."
			, TAHUN= ".$this->getField("TAHUN")."
			, REF_PENGHARGAAN_ID= ".$this->getField("REF_PENGHARGAAN_ID")."
			, LAST_DATE= NOW()
		WHERE PENGHARGAAN_ID= ".$this->getField("PENGHARGAAN_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);
    }

    function updateIdSapk()
	{
		$str = "		
		UPDATE PENGHARGAAN
		SET
		ID_SAPK= '".$this->getField("ID_SAPK")."'
		WHERE PENGHARGAAN_ID= ".$this->getField("PENGHARGAAN_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);
    }

    function updateStatusSync()
	{
		$str = "		
		UPDATE PENGHARGAAN
		SET
			SYNC_ID= '".$this->getField("SYNC_ID")."'
			, SYNC_NAMA= '".$this->getField("SYNC_NAMA")."'
			, SYNC_WAKTU= NOW()
			, SYNC_STATUS= '".$this->getField("SYNC_STATUS")."'
		WHERE PENGHARGAAN_ID = ".$this->getField("PENGHARGAAN_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);
    }

    function updateStatus()
	{
		$str = "		
		UPDATE PENGHARGAAN
		SET    
			STATUS= ".$this->getField("STATUS")."
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
			, LAST_DATE= ".$this->getField("LAST_DATE")."
		WHERE PENGHARGAAN_ID= ".$this->getField("PENGHARGAAN_ID")."
		"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "
        UPDATE PENGHARGAAN SET
	        STATUS = '1',
	        LAST_USER= '".$this->getField("LAST_USER")."',
	        USER_LOGIN_ID= '".$this->getField("USER_LOGIN_ID")."',
	        USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID").",
	        LAST_DATE= ".$this->getField("LAST_DATE")."
        WHERE PENGHARGAAN_ID = ".$this->getField("PENGHARGAAN_ID")."
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.PENGHARGAAN_ID ASC')
	{
		// , CASE A.NAMA WHEN '1' THEN 'Satya Lencana Karya Satya X (Perunggu)'
		// WHEN '2' THEN 'Satya Lencana Karya Satya XX (Perak)' WHEN '3' THEN 'Satya Lencana Karya Satya XXX (Emas)' ELSE 'Belum di tentukan' END NAMA_NAMA
		$str = "
		SELECT
		RP.INFO_DETIL, RP.NAMA NAMA_NAMA, B.NAMA PEJABAT_PENETAP_NAMA, RP.REF_PENGHARGAAN_ID_SAPK, CC.PEGAWAI_ID_SAPK
		, A.*
		FROM penghargaan A
		LEFT JOIN pejabat_penetap B ON A.PEJABAT_PENETAP_ID = B.PEJABAT_PENETAP_ID
		LEFT JOIN sapk.ref_penghargaan RP ON A.REF_PENGHARGAAN_ID = RP.REF_PENGHARGAAN_ID
		LEFT JOIN pegawai CC ON CC.PEGAWAI_ID = A.PEGAWAI_ID
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

    function getCountByParams($paramsArray=array(), $statement='')
	{
		$str = "
		SELECT COUNT(A.PENGHARGAAN_ID) AS ROWCOUNT 
		FROM PENGHARGAAN A
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

    function selectpredikat($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.PENGHARGAAN_PREDIKAT_ID ASC')
	{
		$str = "
		SELECT
		A.*
		FROM penghargaan_predikat A
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

  } 
?>