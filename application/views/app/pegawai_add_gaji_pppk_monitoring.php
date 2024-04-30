<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$CI =& get_instance();
$CI->checkUserLogin();

$this->load->model('GajiPppkRiwayat');
$tempLoginLevel= $this->LOGIN_LEVEL;

$reqId= $this->input->get("reqId");
$reqPeriode= $this->input->get("reqPeriode");
$CI->checkpegawai($reqId);
$tempUserLoginId= $this->USER_LOGIN_ID;
$tempMenuId= "010203";
$tempAksesMenu= $CI->checkmenupegawai($tempUserLoginId, $tempMenuId);

// $reqRowId= httpFilterRequest("reqRowId");

$sessionLoginLevel= $this->LOGIN_LEVEL;

$statementLevel= "";
if($tempLoginLevel == "99"){}
else
$statementLevel= " AND (COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL OR A.STATUS = '2')";

$set= new GajiPppkRiwayat();
$sOrder= "ORDER BY A.TMT_SK, A.TANGGAL_SK";
$set->selectByParams(array(), -1, -1, $statementLevel." AND A.PEGAWAI_ID = ".$reqId, $sOrder);
// echo $set->query;exit();
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="description" content="Simpeg Jombang">
  <meta name="keywords" content="Simpeg Jombang">
  <title>Simpeg Jombang</title>
  <base href="<?=base_url()?>" />
  
  <!-- <link rel="stylesheet" type="text/css" href="css/gaya.css"> -->

  <link rel="stylesheet" type="text/css" href="lib/easyui/themes/default/easyui.css">
  <script type="text/javascript" src="lib/easyui/jquery-1.8.0.min.js"></script>
  <script type="text/javascript" src="lib/easyui/jquery.easyui.min.js"></script>

  <!-- CORE CSS-->    
  <link href="lib/materializetemplate/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="lib/materializetemplate/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <!-- CSS style Horizontal Nav-->    
  <link href="lib/materializetemplate/css/layouts/style-horizontal.css" type="text/css" rel="stylesheet" media="screen,projection">
  <!-- Custome CSS-->    
  <link href="lib/materializetemplate/css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

  <style type="text/css">
    @media 
    only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px)  {
      table.tabel-responsif thead th{ display:none; }
      /*
      Label the data
      */
      <?

      $arrData= array("Jenis", "No. SK", "Tmt riwayat", "Gol/Pangkat", "Last create/update", "Last user access", "Status", "Aksi");
      
      for($i=0; $i < count($arrData); $i++)
      {
        $index= $i+1;
        ?>
        table.tabel-responsif td:nth-of-type(<?=$index?>):before { content: "<?=$arrData[$i]?>"; }
        <?
      }
      ?>
    }

    .round {
      border-radius: 50%;
      padding: 5px;
    }
  </style>

  <script type="text/javascript">
    function hapusdata(id, statusaktif, pegawai_id)
    {
      $.messager.defaults.ok = 'Ya';
      $.messager.defaults.cancel = 'Tidak';
      reqmode= "gaji_riwayat_1";
      infoMode= "Apakah anda yakin mengaktifkan data terpilih"
      if(statusaktif == "")
      {
        reqmode= "gaji_riwayat_0";
        infoMode= "Apakah anda yakin menonaktifkan data terpilih"
      }

      $.messager.confirm('Konfirmasi', infoMode+" ?",function(r){
       if (r){
        var s_url= "gaji_riwayat_json/delete/?reqMode="+reqmode+"&reqId="+id+"&reqPeriode=<?=$reqPeriode?>&reqPegawaiId=<?=$reqId?>";
        //var request = $.get(s_url);
        $.ajax({'url': s_url,'success': function(msg){
          if(msg == ''){}
            else
            {
              // alert(msg);return false;
              $.messager.alert('Info', msg, 'info');
              document.location.href= "app/loadUrl/app/pegawai_add_gaji_pppk_monitoring/?reqId="+pegawai_id+"&reqPeriode=<?=$reqPeriode?>";
            }
          }});
      }
    });  
    }

  // parent.iframeLoaded();
  </script>
</head>

<body>
 <div id="basic-form" class="section">
  <div class="row">
    <div class="col s12 m10 offset-m1 ">
      <ul class="collection card">
        <li class="collection-item ubah-color-warna">RIWAYAT GAJI</li>
        <li class="collection-item">
          <div class="row">
            <?
            // A;R;D
            if($tempAksesMenu == "A")
            {
            ?>
            <a style="cursor:pointer" onClick="parent.setload('pegawai_add_gaji_pppk_data?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>&reqPeriode=<?=$reqPeriode?>')"> <i class="mdi-content-add-circle-outline"> <span class=" material-font">Tambah</span></i></a>
            <?
            }
            ?>
          </div>
          <table class="bordered striped md-text table_list tabel-responsif responsive-table" id="link-table">
            <thead> 
              <tr>
                <th class="green-text material-font">Jenis</th>
                <th class="green-text material-font">No. SK</th>
                <th class="green-text material-font">Tmt riwayat</th>
                <th class="green-text material-font">Gol/Pangkat</th>
                <th class="green-text material-font">Last create / update</th>
                <th class="green-text material-font">Last user Access</th> 
                <th class="green-text material-font">Status</th> 
                <th class="green-text material-font">Aksi</th> 
              </tr>
            </thead>
            <? 
            while($set->nextRow())
            {
        $LastLevel= $set->getField('LAST_LEVEL');
        
        $tempAksiProses= "";
        if($sessionLoginLevel < $LastLevel)
        $tempAksiProses= "1";
        
              ?>
              <tr>
                <td><?=$set->getField('JENIS_KENAIKAN_NAMA')?></td>
                <td><?=$set->getField('NO_SK')?></td>
                <td><?=dateToPageCheck($set->getField('TMT_SK'))?></td>
                <td><?=$set->getField('PANGKAT_KODE')?></td>
                <td><?=getFormattedDateTime($set->getField('LAST_DATE'))?></td>
                <td><?=$set->getField('LAST_USER')?></td>
                <td>
                  <?
                  if($set->getField('STATUS') == 1) 
          {
                    echo '<i class="mdi-av-not-interested red-text"></i>';
                  }
          else if($set->getField('LAST_LEVEL') == 99)
          {
                    echo '<i class="mdi-action-done green-text"></i>';
                  }
          else
          {
                    echo '<i class="mdi-alert-warning orange-text"></i>';
                  }
                  ?>
                </td>
                <td width="90px">
                  <?
                  $reqRowId = $set->getField('GAJI_RIWAYAT_ID');
                  $reqId = $set->getField('PEGAWAI_ID');
                  ?>
                  <span>
                    <?
          if($tempAksiProses == "1"){}
            else
            {
                    if($set->getField('STATUS')==1 && $set->getField('JENIS_KENAIKAN') == 3)
          {
            if($set->getField('DATA_HUKUMAN') == 0)
            {
          ?>
                    
                    <?
                    // A;R;D
                    if($tempAksesMenu == "A")
                    {
                    ?>
                    <a href="javascript:void(0)" class="round waves-effect waves-light green white-text" title="Aktifkan" onClick="hapusdata('<?=$reqRowId?>','1','<?=$reqId?>')">
                      <i class="mdi-action-autorenew"></i>
                    </a>
                    <?
                    }
                    ?>

                    <?
            }
          }
                    else
          {
            //if($set->getField('JENIS_KENAIKAN') == 1 || $set->getField('JENIS_KENAIKAN') == 2){}
            //else
            if($set->getField('JENIS_KENAIKAN') == 3)
            {
              if($set->getField('DATA_HUKUMAN') == 0)
                {
          ?>
                    
                    <?
                    // A;R;D
                    if($tempAksesMenu == "A")
                    {
                    ?>
                    <a href="javascript:void(0)" class="round waves-effect waves-light red white-text" title="Hapus" onClick="hapusdata('<?=$reqRowId?>','','<?=$reqId?>')">
                      <i class="mdi-action-delete"></i>
                    </a>
                    <?
                    }
                    ?>

                    <?
              }
            }
          }
            }
                    ?>
                  </span>
                  <span>
                  <a href="javascript:void(0)" class="round waves-effect waves-light purple white-text" title="Log"  onclick="parent.openModal('app/loadUrl/app/informasi_data_log?reqjson=gaji_riwayat_json/log/<?=$reqRowId?>&reqjudul=Data Gaji Riwayat Log')">
                      <i class="mdi-action-query-builder"></i>
                    </a>
                  </span>
                  <span>
                    <?if($set->getField('STATUS')!=1):?>
                    <a href="javascript:void(0)" class="round waves-effect waves-light blue white-text" title="Ubah" onClick="parent.setload('pegawai_add_gaji_pppk_data?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>&reqPeriode=<?=$reqPeriode?>')">
                      <i class="mdi-editor-mode-edit"></i>
                    </a>
                    <!-- <a href="javascript:void(0)" class="rounded material-bold blue white-text" onClick="parent.setload('pegawai_add_pangkat_data?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>')">UBAH</a> -->
                    <?endif?>
                  </span>
                  <span>

                   <!-- <span>
                    <a href="javascript:void(0)" class="rounded material-bold blue white-text" onClick="parent.setload('pegawai_add_gaji_pppk_data?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>')">UBAH</a>
                  </span>
                  <span>
                   <?if($set->getField('STATUS')==1):?>
                   <a href="javascript:void(0)" class="rounded material-bold green white-text" onClick="hapusdata('<?=$reqRowId?>','1','<?=$reqId?>')">AKTIFKAN</a>
                   <?else:?>
                   <a href="javascript:void(0)" class="rounded material-bold red white-text" onClick="hapusdata('<?=$reqRowId?>','','<?=$reqId?>')">HAPUS</a>
                   <?endif?>-->
                 </span> 
               </td>
             </tr>
             <? 
           }
           ?>
         </table>
       </li>
     </ul>
   </div>
 </div>
</div>

<!-- jQuery Library -->
<!-- <script type="text/javascript" src="lib/materializetemplate/js/plugins/jquery-1.11.2.min.js"></script> -->

<!--materialize js-->
<script type="text/javascript" src="lib/materializetemplate/js/my-materialize.min.js"></script>
<!-- <script type="text/javascript" src="lib/materializetemplate/js/materialize.min.js"></script> -->

<link rel="stylesheet" href="lib/AdminLTE-2.4.0-rc/dist/css/skins/ubah-skin.css">
<script src="lib/AdminLTE-2.4.0-rc/dist/js/ubah-skin.js"></script>

</body>
</html>