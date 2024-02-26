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
  include_once(APPPATH.'/models/Entity.php');
  
  class Pegawai extends Entity{ 

	 var $query;
  	var $id;
    /**
    * Class constructor.
    **/
    function Pegawai()
	{
      $this->Entity(); 
    }

    function selectByParamsMonitoringPegawai($paramsArray=array(),$limit=-1,$from=-1, $statement='', $statementdetil="", $order=' ORDER BY A.PEGAWAI_ID ASC')
	{
		$str = "
		SELECT 
		V.*, A.*
		, A.INFO_SATUAN_KERJA_NAMA SATUAN_KERJA_NAMA
		, A.INFO_SATUAN_KERJA_INDUK SATUAN_KERJA_INDUK
		--, AMBIL_SATKER_NAMA_DYNAMIC(A.SATUAN_KERJA_ID) SATUAN_KERJA_NAMA
		--, AMBIL_SATKER_INDUK(A.SATUAN_KERJA_ID) SATUAN_KERJA_INDUK
		FROM
		(
		SELECT 
			A.PEGAWAI_ID, A.NIP_LAMA, A.NIP_BARU
			, (CASE WHEN COALESCE(NULLIF(A.GELAR_DEPAN,'') , NULL ) IS NULL THEN '' ELSE A.GELAR_DEPAN || ' ' END) || A.NAMA || (CASE WHEN COALESCE(NULLIF(A.GELAR_BELAKANG,'') , NULL ) IS NULL THEN '' ELSE '' || A.GELAR_BELAKANG END) NAMA_LENGKAP
			, PANG_RIW.KODE PANGKAT_RIWAYAT_KODE, PANG_RIW.TMT_PANGKAT PANGKAT_RIWAYAT_TMT
			, JAB_RIW.JABATAN_NAMA JABATAN_RIWAYAT_NAMA, JAB_RIW.ESELON_NAMA JABATAN_RIWAYAT_ESELON, JAB_RIW.TMT_JABATAN JABATAN_RIWAYAT_TMT
			, JAB_RIW.ESELON_ID, PANG_RIW.PANGKAT_ID, PANG_RIW.TMT_PANGKAT, A.SATUAN_KERJA_ID
			, CASE
			WHEN CURRENT_DATE <= G.TANGGAL_AKHIR AND CURRENT_DATE >= G.TANGGAL_MULAI
			THEN 1
			WHEN G.PEGAWAI_ID IS NOT NULL THEN 2
			ELSE 0
			END STATUS_BERLAKU
			, A.INFO_SATUAN_KERJA_NAMA, A.INFO_SATUAN_KERJA_INDUK
		FROM PEGAWAI A
		LEFT JOIN
		(
			SELECT A.PANGKAT_RIWAYAT_ID, B.KODE, A.TMT_PANGKAT, A.PANGKAT_ID
			FROM PANGKAT_RIWAYAT A
			LEFT JOIN PANGKAT B ON A.PANGKAT_ID = B.PANGKAT_ID
		) PANG_RIW ON A.PANGKAT_RIWAYAT_ID = PANG_RIW.PANGKAT_RIWAYAT_ID
		LEFT JOIN
		(
			SELECT A.JABATAN_RIWAYAT_ID, COALESCE(A.ESELON_ID,99) ESELON_ID, B.NAMA ESELON_NAMA, A.TMT_JABATAN, A.NAMA JABATAN_NAMA
			FROM JABATAN_RIWAYAT A
			LEFT JOIN ESELON B ON A.ESELON_ID = B.ESELON_ID
		) JAB_RIW ON A.JABATAN_RIWAYAT_ID = JAB_RIW.JABATAN_RIWAYAT_ID
		LEFT JOIN SATUAN_KERJA SK ON SK.SATUAN_KERJA_ID = A.SATUAN_KERJA_ID
		LEFT JOIN (SELECT PEGAWAI_ID, TANGGAL_MULAI, TANGGAL_AKHIR FROM HUKUMAN_TERAKHIR X) G ON A.PEGAWAI_ID = G.PEGAWAI_ID
		WHERE 1 = 1
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
		) A
		INNER JOIN validasi.validasi_perubahandatavalidasi('') V ON A.PEGAWAI_ID = V.PEGAWAI_ID
		WHERE 1=1 ".$statementdetil.$order;
		$this->query = $str;
		// echo $str;exit;
		return $this->selectLimit($str,$limit,$from); 
    }

    function getCountByParamsMonitoring($paramsArray=array(), $statement='', $statementdetil="")
	{
		$str = "
		SELECT COUNT(1) AS ROWCOUNT
		FROM
		(
			SELECT A.PEGAWAI_ID
			FROM PEGAWAI A
			LEFT JOIN
			(
				SELECT A.PANGKAT_RIWAYAT_ID, B.KODE, A.TMT_PANGKAT
				FROM PANGKAT_RIWAYAT A
				LEFT JOIN PANGKAT B ON A.PANGKAT_ID = B.PANGKAT_ID
			) PANG_RIW ON A.PANGKAT_RIWAYAT_ID = PANG_RIW.PANGKAT_RIWAYAT_ID
			LEFT JOIN SATUAN_KERJA SK ON SK.SATUAN_KERJA_ID = A.SATUAN_KERJA_ID
			LEFT JOIN (SELECT PEGAWAI_ID, TANGGAL_MULAI, TANGGAL_AKHIR FROM HUKUMAN_TERAKHIR X) G ON A.PEGAWAI_ID = G.PEGAWAI_ID
			WHERE 1 = 1 ";
			foreach ($paramsArray as $key => $val)
			{
				$str .= " AND $key = '$val' ";
			}
			$str .= $statement." 
		) A
		INNER JOIN validasi.validasi_perubahandatavalidasi('') V ON A.PEGAWAI_ID = V.PEGAWAI_ID
		WHERE 1=1 ".$statementdetil;

		$this->query = $str;
		// echo $str;exit();
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0;  
    }

    function selectriwayat($paramsArray=array(),$limit=-1,$from=-1, $statement='', $statementdetil="and info_validasi is null", $order=' order by a.info_riwayat')
    {
        $str = "
        select *
		from
		(
			select distinct info_riwayat || ' - ' || info_jenis info_riwayat, info_table
			from validasi.validasi_perubahandatavalidasi('')
			where 1=1 ".$statementdetil."
		) a
		where 1=1
        ";

        foreach ($paramsArray as $key => $val)
        {
            $str .= " AND $key = '$val' ";
        }
        $this->query = $str;
            
        $str .= $statement." ".$order;
        return $this->selectLimit($str,$limit,$from); 
    }

  } 
?>