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
  
  class SkCpnsPnsBkn extends Entity{ 

	var $query;
  	var $id;
    /**
    * Class constructor.
    **/
    function SkCpnsPnsBkn()
	{
      $this->Entity(); 
    }

    function insertCpnsDataBkn()
	{
		$this->setField("SK_CPNS_ID", $this->getNextId("SK_CPNS_ID", "sk_cpns"));

		$str = "
		INSERT INTO sk_cpns
     	(
     		SK_CPNS_ID, PEGAWAI_ID, NO_SK, TANGGAL_SK, SPMT_NOMOR
     	) 
     	VALUES
     	(
	     	".$this->getField("SK_CPNS_ID")."
	     	, ".$this->getField("PEGAWAI_ID")."
	     	, '".$this->getField("NO_SK")."'
	     	, ".$this->getField("TANGGAL_SK")."
	     	, '".$this->getField("SPMT_NOMOR")."'
     	)
		";
		// echo $str;exit;

		$this->id = $this->getField("SK_CPNS_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function updateCpnsDataBkn()
    {
		$str = "		
		UPDATE sk_cpns
		SET
			NO_SK= '".$this->getField("NO_SK")."'
			, TANGGAL_SK= ".$this->getField("TANGGAL_SK")."
			, SPMT_NOMOR= '".$this->getField("SPMT_NOMOR")."'
		WHERE SK_CPNS_ID= ".$this->getField("SK_CPNS_ID")."
		"; 
		$this->query = $str;
	 	// echo $str;exit;
		return $this->execQuery($str);
    }

    function insertPnsDataBkn()
	{
		$this->setField("SK_PNS_ID", $this->getNextId("SK_PNS_ID", "sk_pns"));

		$str = "
		INSERT INTO sk_pns
     	(
     		SK_PNS_ID, PEGAWAI_ID, NO_SK, TANGGAL_SK, TMT_PNS, NO_PRAJAB, TANGGAL_PRAJAB
     	) 
     	VALUES
     	(
	     	".$this->getField("SK_PNS_ID")."
	     	, ".$this->getField("PEGAWAI_ID")."
	     	, '".$this->getField("NO_SK")."'
	     	, ".$this->getField("TANGGAL_SK")."
	     	, ".$this->getField("TMT_PNS")."
	     	, '".$this->getField("NO_PRAJAB")."'
	     	, ".$this->getField("TANGGAL_PRAJAB")."
     	)
		";
		// echo $str;exit;

		$this->id = $this->getField("SK_PNS_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function updatePnsDataBkn()
    {
		$str = "		
		UPDATE sk_pns
		SET
			NO_SK= '".$this->getField("NO_SK")."'
			, TANGGAL_SK= ".$this->getField("TANGGAL_SK")."
			, TMT_PNS= ".$this->getField("TMT_PNS")."
			, NO_PRAJAB= '".$this->getField("NO_PRAJAB")."'
	     	, TANGGAL_PRAJAB= ".$this->getField("TANGGAL_PRAJAB")."
		WHERE SK_PNS_ID= ".$this->getField("SK_PNS_ID")."
		"; 
		$this->query = $str;
	 	// echo $str;exit;
		return $this->execQuery($str);
    }

    function updateIdSapk()
	{
		$str = "
		UPDATE sk_cpns
		SET
		ID_SAPK= '".$this->getField("ID_SAPK")."'
		WHERE PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		$this->execQuery($str);

		$str = "
		UPDATE sk_pns
		SET
		ID_SAPK= '".$this->getField("ID_SAPK")."'
		WHERE PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		$this->execQuery($str);

		return true;
    }

    function updateStatusSync()
	{
		$str = "
		UPDATE sk_pns
		SET
			SYNC_ID= '".$this->getField("SYNC_ID")."'
			, SYNC_NAMA= '".$this->getField("SYNC_NAMA")."'
			, SYNC_WAKTU= NOW()
			, SYNC_STATUS= '".$this->getField("SYNC_STATUS")."'
		WHERE PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		$this->execQuery($str);

		$str = "
		UPDATE sk_cpns
		SET
			SYNC_ID= '".$this->getField("SYNC_ID")."'
			, SYNC_NAMA= '".$this->getField("SYNC_NAMA")."'
			, SYNC_WAKTU= NOW()
			, SYNC_STATUS= '".$this->getField("SYNC_STATUS")."'
		WHERE PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);

		return true;
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","MASTER_KATEGORI_METODE_EVALUASI_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order='')
	{
		$str = "
		SELECT
			A.PEGAWAI_ID_SAPK, A.NIP_BARU, A.KARTU_PEGAWAI
			, A1.NO_SK NOMOR_SK_CPNS, A1.TANGGAL_SK TGL_SK_CPNS, A1.PEJABAT_PENETAP NAMA_JABATAN_ANGKAT_CPNS
			, A2.NO_UJI_KESEHATAN NOMOR_DOKTER_PNS, A2.NO_SK NOMOR_SK_PNS, A1.SPMT_NOMOR NOMOR_SPMT
			, A2.NO_PRAJAB NOMOR_STTPL, PS.PEGAWAI_STATUS_NAMA STATUS_CPNS_PNS, A2.TANGGAL_UJI_KESEHATAN TANGGAL_DOKTER_PNS
			, A2.TANGGAL_SK TGL_SK_PNS, A2.TANGGAL_PRAJAB TGL_STTPL, A2.TMT_PNS
			, CASE WHEN COALESCE(NULLIF(A1.ID_SAPK, ''), NULL) IS NOT NULL THEN A1.ID_SAPK
			WHEN COALESCE(NULLIF(A2.ID_SAPK, ''), NULL) IS NOT NULL THEN A2.ID_SAPK ELSE '' END ID_SAPK
			, CASE WHEN A1.PEGAWAI_ID IS NOT NULL THEN A.PEGAWAI_ID
			WHEN A2.PEGAWAI_ID IS NOT NULL THEN A.PEGAWAI_ID END ID_ROW
		FROM pegawai A
		LEFT JOIN sk_cpns A1 ON A.PEGAWAI_ID = A1.PEGAWAI_ID
		LEFT JOIN sk_pns A2 ON A.PEGAWAI_ID = A2.PEGAWAI_ID
		LEFT JOIN
		(
			SELECT A.PEGAWAI_STATUS_ID, A.PEGAWAI_ID, A.STATUS_PEGAWAI_ID, B.NAMA PEGAWAI_STATUS_NAMA
			, A.TMT PEGAWAI_KEDUDUKAN_TMT, C.NAMA PEGAWAI_KEDUDUKAN_NAMA
			FROM pegawai_status A
			INNER JOIN status_pegawai B ON A.STATUS_PEGAWAI_ID = B.STATUS_PEGAWAI_ID
			INNER JOIN status_pegawai_kedudukan C ON A.STATUS_PEGAWAI_KEDUDUKAN_ID = C.STATUS_PEGAWAI_KEDUDUKAN_ID
		) PS ON A.PEGAWAI_STATUS_ID = PS.PEGAWAI_STATUS_ID
		WHERE 1=1
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

    function selectcpns($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order='')
	{
		$str = "
		SELECT
			A.*
		FROM sk_cpns A
		WHERE 1=1
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

    function selectpns($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order='')
	{
		$str = "
		SELECT
			A.*
		FROM sk_pns A
		WHERE 1=1
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