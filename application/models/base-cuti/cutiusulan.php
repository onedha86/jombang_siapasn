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
  
  class CutiUsulan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function CutiUsulan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("CUTI_USULAN_ID", $this->getNextId("CUTI_USULAN_ID","cuti_usulan"));

		$str = "
		INSERT INTO cuti_usulan
		(
            CUTI_USULAN_ID, PEGAWAI_ID, JENIS_CUTI_ID, SATUAN_KERJA_ID, JABATAN_RIWAYAT_ID, PANGKAT_RIWAYAT_ID
            , JENIS_CUTI_DETAIL_ID, JENIS_CUTI_DURASI_ID, KETERANGAN_DETIL, TANGGAL_MULAI, TANGGAL_SELESAI
            , LAMA_HARI, LAMA, PEGAWAI_ATASAN_ID, NIP_ATASAN, NAMA_ATASAN, PEGAWAI_KEPALA_ID, NIP_KEPALA
            , NAMA_KEPALA, SATUAN_KERJA_ASAL_ID, STATUS_BERKAS
            , LAMA_CUTI_N2, SISA_CUTI_N2, LAMA_CUTI_N1, SISA_CUTI_N1, LAMA_CUTI_N, SISA_CUTI_N
            , LAST_USER, LAST_DATE, LAST_LEVEL, USER_LOGIN_ID, USER_LOGIN_PEGAWAI_ID
		) 
		VALUES 
		(
			".$this->getField("CUTI_USULAN_ID")."
			, ".$this->getField("PEGAWAI_ID")."
			, ".$this->getField("JENIS_CUTI_ID")."
			, ".$this->getField("SATUAN_KERJA_ID")."
			, ".$this->getField("JABATAN_RIWAYAT_ID")."
			, ".$this->getField("PANGKAT_RIWAYAT_ID")."
			, ".$this->getField("JENIS_CUTI_DETAIL_ID")."
			, ".$this->getField("JENIS_CUTI_DURASI_ID")."
			, '".$this->getField("KETERANGAN_DETIL")."'
			, ".$this->getField("TANGGAL_MULAI")."
			, ".$this->getField("TANGGAL_SELESAI")."
			, ".$this->getField("LAMA_HARI")."
			, ".$this->getField("LAMA")."
			, ".$this->getField("PEGAWAI_ATASAN_ID")."
			, '".$this->getField("NIP_ATASAN")."'
			, '".$this->getField("NAMA_ATASAN")."'
			, ".$this->getField("PEGAWAI_KEPALA_ID")."
			, '".$this->getField("NIP_KEPALA")."'
			, '".$this->getField("NAMA_KEPALA")."'
			, ".$this->getField("SATUAN_KERJA_ASAL_ID")."
			, ".$this->getField("STATUS_BERKAS")."
			, ".$this->getField("LAMA_CUTI_N2")."
			, ".$this->getField("SISA_CUTI_N2")."
			, ".$this->getField("LAMA_CUTI_N1")."
			, ".$this->getField("SISA_CUTI_N1")."
			, ".$this->getField("LAMA_CUTI_N")."
			, ".$this->getField("SISA_CUTI_N")."
			, '".$this->getField("LAST_USER")."'
			, ".$this->getField("LAST_DATE")."
			, ".$this->getField("LAST_LEVEL")."
			, ".$this->getField("USER_LOGIN_ID")."
			, ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
		)
		"; 	
		// echo "xxx-".$str;exit;

		$this->id = $this->getField("CUTI_USULAN_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "		
		UPDATE cuti_usulan
		SET    
		 	JENIS_CUTI_ID= ".$this->getField("JENIS_CUTI_ID")."
		 	, JENIS_CUTI_DETAIL_ID= ".$this->getField("JENIS_CUTI_DETAIL_ID")."
		 	, JENIS_CUTI_DURASI_ID= ".$this->getField("JENIS_CUTI_DURASI_ID")."
		 	, KETERANGAN_DETIL= '".$this->getField("KETERANGAN_DETIL")."'
		 	, TANGGAL_MULAI= ".$this->getField("TANGGAL_MULAI")."
		 	, TANGGAL_SELESAI= ".$this->getField("TANGGAL_SELESAI")."
		 	, LAMA_HARI= ".$this->getField("LAMA_HARI")."
		 	, LAMA= ".$this->getField("LAMA")."
		 	, PEGAWAI_ATASAN_ID= ".$this->getField("PEGAWAI_ATASAN_ID")."
		 	, NIP_ATASAN= '".$this->getField("NIP_ATASAN")."'
		 	, NAMA_ATASAN= '".$this->getField("NAMA_ATASAN")."'
		 	, PEGAWAI_KEPALA_ID= ".$this->getField("PEGAWAI_KEPALA_ID")."
		 	, NIP_KEPALA= '".$this->getField("NIP_KEPALA")."'
		 	, NAMA_KEPALA= '".$this->getField("NAMA_KEPALA")."'
		 	, SATUAN_KERJA_ASAL_ID= ".$this->getField("SATUAN_KERJA_ASAL_ID")."
		 	, STATUS_BERKAS= ".$this->getField("STATUS_BERKAS")."
		 	, LAMA_CUTI_N2= ".$this->getField("LAMA_CUTI_N2")."
			, SISA_CUTI_N2= ".$this->getField("SISA_CUTI_N2")."
			, LAMA_CUTI_N1= ".$this->getField("LAMA_CUTI_N1")."
			, SISA_CUTI_N1= ".$this->getField("SISA_CUTI_N1")."
			, LAMA_CUTI_N= ".$this->getField("LAMA_CUTI_N")."
			, SISA_CUTI_N= ".$this->getField("SISA_CUTI_N")."
		 	, LAST_USER= '".$this->getField("LAST_USER")."'
		 	, LAST_DATE= ".$this->getField("LAST_DATE")."
		 	, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
		 	, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
		 	, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
		WHERE CUTI_USULAN_ID = ".$this->getField("CUTI_USULAN_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);
    }

    function updateverifikatorapproval()
	{
		$str = "		
		UPDATE cuti_usulan
		SET    
		 	STATUS_BERKAS= ".$this->getField("STATUS_BERKAS")."
		 	, MENU_PENANDA_TANGAN_ID= '".$this->getField("MENU_PENANDA_TANGAN_ID")."'
		 	, LAST_USER= '".$this->getField("LAST_USER")."'
		 	, LAST_DATE= ".$this->getField("LAST_DATE")."
		 	, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
		 	, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
		 	, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
		WHERE CUTI_USULAN_ID = ".$this->getField("CUTI_USULAN_ID")."
		"; 
		$this->query = $str;
	 	// echo $str;exit;
		return $this->execQuery($str);
    }

    function updatestatus()
	{
		$str = "		
		UPDATE cuti_usulan
		SET    
		 	STATUS_BERKAS= ".$this->getField("STATUS_BERKAS")."
		 	, LAST_USER= '".$this->getField("LAST_USER")."'
		 	, LAST_DATE= ".$this->getField("LAST_DATE")."
		 	, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
		 	, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
		 	, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
		WHERE CUTI_USULAN_ID = ".$this->getField("CUTI_USULAN_ID")."
		"; 
		$this->query = $str;
	 	// echo $str;exit;
		return $this->execQuery($str);
    }

    function statustolak()
	{
		$str = "		
		UPDATE cuti_usulan
		SET    
		 	STATUS_BERKAS= 99
		 	, LAST_USER= '".$this->getField("LAST_USER")."'
		 	, LAST_DATE= ".$this->getField("LAST_DATE")."
		 	, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
		 	, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
		 	, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
		WHERE CUTI_USULAN_ID = ".$this->getField("CUTI_USULAN_ID")."
		"; 
		$this->query = $str;
	 	// echo $str;exit;
		return $this->execQuery($str);
    }

    function validcutinomor()
	{
        $str = "
		SELECT pcutinomorvalid(".$this->getField("VID").")
		"; 
		$this->query = $str;
		// echo $str;exit();
        return $this->execQuery($str);
    }

	function delete()
	{
        $str = "
		DELETE FROM cuti_usulan
		WHERE CUTI_USULAN_ID = ".$this->getField("CUTI_USULAN_ID")."
		";
		$this->query = $str;
		return $this->execQuery($str);
    }

    function selectdata($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.CUTI_USULAN_ID ASC')
	{
		$str = "
		SELECT
			A.*
		FROM cuti_usulan A
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

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.CUTI_USULAN_ID ASC')
	{
		$str = "
		SELECT
			P.NAMA_LENGKAP, P.NIP_BARU, P.SATUAN_KERJA_NAMA, JR.NAMA JABATAN_NAMA
			, PR.PANGKAT_KODE, PR.MASA_KERJA_TAHUN, PR.MASA_KERJA_BULAN
			, CPNS_RIW.TMT_CPNS, PNS_RIW.TMT_PNS
			, A.*
		FROM cuti_usulan A
		INNER JOIN 
		( 
			SELECT 
				A.NIP_BARU, A.PEGAWAI_ID, A.INFO_SATUAN_KERJA_DETIL SATUAN_KERJA_NAMA
				, (CASE WHEN COALESCE(NULLIF(A.GELAR_DEPAN,'') , NULL ) IS NULL THEN '' ELSE A.GELAR_DEPAN || ' ' END) || A.NAMA || (CASE WHEN COALESCE(NULLIF(A.GELAR_BELAKANG,'') , NULL ) IS NULL THEN '' ELSE '' || A.GELAR_BELAKANG END) NAMA_LENGKAP
			FROM pegawai A
		) P ON A.PEGAWAI_ID = P.PEGAWAI_ID
		INNER JOIN PANGKAT_RIWAYAT_DATA PR ON PR.PANGKAT_RIWAYAT_ID = A.PANGKAT_RIWAYAT_ID
		INNER JOIN JABATAN_RIWAYAT JR ON JR.JABATAN_RIWAYAT_ID = A.JABATAN_RIWAYAT_ID
		LEFT JOIN 
		(
			SELECT
				A.PEGAWAI_ID, B.KODE, A.TMT_CPNS, A.PANGKAT_ID, A.MASA_KERJA_TAHUN, A.MASA_KERJA_BULAN 
			FROM SK_CPNS A
			LEFT JOIN PANGKAT B ON A.PANGKAT_ID = B.PANGKAT_ID
		) CPNS_RIW ON A.PEGAWAI_ID = CPNS_RIW.PEGAWAI_ID
		LEFT JOIN 
		(
			SELECT
				A.PEGAWAI_ID, B.KODE, A.TMT_PNS, A.PANGKAT_ID, A.MASA_KERJA_TAHUN, A.MASA_KERJA_BULAN 
			FROM SK_PNS A
			LEFT JOIN PANGKAT B ON A.PANGKAT_ID = B.PANGKAT_ID 
		) PNS_RIW ON A.PEGAWAI_ID = PNS_RIW.PEGAWAI_ID
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
		SELECT COUNT(1) AS ROWCOUNT 
		FROM cuti_usulan A
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

    function selectmonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.CUTI_USULAN_ID ASC')
	{
		$str = "
		SELECT
			P.NAMA_LENGKAP, P.NIP_BARU, P.SATUAN_KERJA_NAMA, A1.NAMA JENIS_CUTI_NAMA, A2.NAMA JENIS_CUTI_DETAIL_NAMA
			,
			CASE WHEN COALESCE(NULLIF(A.VALID_NOMOR,'') , NULL ) IS NULL THEN '' ELSE 'Sudah ' END ||
			CASE WHEN A.STATUS_TMS = 1 OR A.STATUS_BERKAS = 99 THEN LG.INFO_PROSES ELSE MN.NAMA END POSISI_MENU_INFO
			, LG.INFO_PROSES
			, A.*
		FROM cuti_usulan A
		LEFT JOIN menu MN ON POSISI_MENU_ID = MN.MENU_ID
		INNER JOIN 
		( 
			SELECT 
			A.NIP_BARU, A.PEGAWAI_ID, A.INFO_SATUAN_KERJA_DETIL SATUAN_KERJA_NAMA
			, (CASE WHEN COALESCE(NULLIF(A.GELAR_DEPAN,'') , NULL ) IS NULL THEN '' ELSE A.GELAR_DEPAN || ' ' END) || A.NAMA || (CASE WHEN COALESCE(NULLIF(A.GELAR_BELAKANG,'') , NULL ) IS NULL THEN '' ELSE '' || A.GELAR_BELAKANG END) NAMA_LENGKAP
			FROM pegawai A
		) P ON A.PEGAWAI_ID = P.PEGAWAI_ID
		INNER JOIN jenis_cuti A1 ON A.JENIS_CUTI_ID = A1.JENIS_CUTI_ID
		INNER JOIN jenis_cuti_detail A2 ON A.JENIS_CUTI_DETAIL_ID = A2.JENIS_CUTI_DETAIL_ID
		LEFT JOIN
		(
			SELECT
			A.CUTI_USULAN_ID
			, A.MENU_ID, A.LAST_USER, A.LAST_DATE
			, A.INFO_LOG INFO_PROSES
			FROM cuti_usulan_log A
			INNER JOIN
			(
				SELECT CUTI_USULAN_ID, MAX(LAST_DATE) LAST_DATE
				FROM cuti_usulan_log
				GROUP BY CUTI_USULAN_ID
			) B ON A.CUTI_USULAN_ID = B.CUTI_USULAN_ID AND A.LAST_DATE = B.LAST_DATE
			GROUP BY A.CUTI_USULAN_ID, A.MENU_ID, A.LAST_USER, A.LAST_DATE, A.INFO_LOG
		) LG ON A.CUTI_USULAN_ID = LG.CUTI_USULAN_ID
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

    function getcountmonitoring($paramsArray=array(), $statement='')
	{
		$str = "
		SELECT COUNT(1) AS ROWCOUNT 
		FROM cuti_usulan A
		INNER JOIN 
		( 
			SELECT 
			A.NIP_BARU, A.PEGAWAI_ID, A.INFO_SATUAN_KERJA_DETIL SATUAN_KERJA_NAMA
			, (CASE WHEN COALESCE(NULLIF(A.GELAR_DEPAN,'') , NULL ) IS NULL THEN '' ELSE A.GELAR_DEPAN || ' ' END) || A.NAMA || (CASE WHEN COALESCE(NULLIF(A.GELAR_BELAKANG,'') , NULL ) IS NULL THEN '' ELSE '' || A.GELAR_BELAKANG END) NAMA_LENGKAP
			FROM pegawai A
		) P ON A.PEGAWAI_ID = P.PEGAWAI_ID
		INNER JOIN jenis_cuti A1 ON A.JENIS_CUTI_ID = A1.JENIS_CUTI_ID
		INNER JOIN jenis_cuti_detail A2 ON A.JENIS_CUTI_DETAIL_ID = A2.JENIS_CUTI_DETAIL_ID
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

    function selectcetak($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.CUTI_USULAN_ID ASC')
	{
		$str = "
		SELECT
			P.NAMA_LENGKAP, P.NIP_BARU, P.SATUAN_KERJA_NAMA, JR.NAMA JABATAN_NAMA
			, PR.PANGKAT_NAMA, PR.PANGKAT_KODE, PR.MASA_KERJA_TAHUN, PR.MASA_KERJA_BULAN, KP.JABATAN_KEPALA
			, A.*
		FROM cuti_usulan A
		INNER JOIN 
		( 
			SELECT 
				A.NIP_BARU, A.PEGAWAI_ID, A.INFO_SATUAN_KERJA_DETIL SATUAN_KERJA_NAMA
				, (CASE WHEN COALESCE(NULLIF(A.GELAR_DEPAN,'') , NULL ) IS NULL THEN '' ELSE A.GELAR_DEPAN || ' ' END) || A.NAMA || (CASE WHEN COALESCE(NULLIF(A.GELAR_BELAKANG,'') , NULL ) IS NULL THEN '' ELSE '' || A.GELAR_BELAKANG END) NAMA_LENGKAP
			FROM pegawai A
		) P ON A.PEGAWAI_ID = P.PEGAWAI_ID
		INNER JOIN PANGKAT_RIWAYAT_DATA PR ON PR.PANGKAT_RIWAYAT_ID = A.PANGKAT_RIWAYAT_ID
		INNER JOIN JABATAN_RIWAYAT JR ON JR.JABATAN_RIWAYAT_ID = A.JABATAN_RIWAYAT_ID
		LEFT JOIN
		(
			SELECT
			A.PEGAWAI_ID, A.JABATAN_RIWAYAT_ID, JR.NAMA JABATAN_KEPALA
			FROM PEGAWAI A
			INNER JOIN JABATAN_RIWAYAT JR ON JR.JABATAN_RIWAYAT_ID = A.JABATAN_RIWAYAT_ID
		) KP ON A.PEGAWAI_KEPALA_ID = KP.PEGAWAI_ID
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