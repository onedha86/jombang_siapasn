<?
include_once("functions/default.func.php");
include_once("functions/date.func.php");

$this->load->library("kauth");
$this->load->model("Menu");

if($this->USER_LOGIN_ID == "")
	redirect('app');

$reqMode= $this->input->get("reqMode");
$reqId= $this->input->get("reqId");
$reqRowId= $this->input->get("reqRowId");
$reqTipe= $this->input->get("reqTipe");
$reqJenis= $this->input->get("reqJenis");
$reqBulan= $this->input->get("reqBulan");
$reqTahun= $this->input->get("reqTahun");
$reqData = $this->input->get("reqData");
			
$tempStatusKelompokPegawaiUsul= $this->STATUS_KELOMPOK_PEGAWAI_USUL;
//echo $tempLoginLevel;exit;
//setting d user $tempStatusKelompokPegawaiUsul
if($reqJenis == "5")
    $mode= "surat_keluar_kgb";
else if($reqJenis == "14")
    $mode= "surat_keluar_pppk_kgb";
else
{
	if($tempStatusKelompokPegawaiUsul == "1" || $tempLoginLevel == 99 || $tempLoginLevel == "")
	{
		$mode= "surat_keluar";
	}
	else
	$mode= "surat_keluar_lihat";
}

$index_set=0;
$arrMenu= setmenusuratbkpp($reqJenis, $mode);
$jumlah_menu= count($arrMenu);
//echo $jumlah_menu;exit;
//print_r($arrMenu);exit;
?>
<!DOCTYPE html>
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

    <!-- CORE CSS-->    
    <link href="lib/materializetemplate/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="lib/materializetemplate/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- CSS style Horizontal Nav-->    
    <link href="lib/materializetemplate/css/layouts/style-horizontal.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- Custome CSS-->    
    <link href="lib/materializetemplate/css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <script type="text/javascript">
        function executeOnClick(varItem){
            $("a").removeClass("aktif");
            if(varItem == ''){}
                <?
            for($index_loop=0; $index_loop < $jumlah_menu; $index_loop++)
            {
                $tempMenuId= $arrMenu[$index_loop]["MENU_ID"];
                $arrMenu[$index_loop]["MENU_PARENT_ID"];
                $tempNama= $arrMenu[$index_loop]["NAMA"];
                $tempLinkFile= $arrMenu[$index_loop]["LINK_FILE"];
                $tempLinkDetilFile= $arrMenu[$index_loop]["LINK_DETIL_FILE"];
                ?>
                else if(varItem == '<?=$tempMenuId?>'){
                    $("#<?=$tempMenuId?>").addClass("aktif");
                    $('#<?=$tempMenuId?>').css({'background-position': '0 -27px'});

                    <?
                    if($tempLinkDetilFile == "")
                    {
                    ?>
                        mainFrame.location.href='app/loadUrl/persuratan/<?=$tempLinkFile?>/?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>&reqJenis=<?=$reqJenis?>';
						iframeLoaded();
                        //mainFrameDetil.location.href='';
                        //document.getElementById('trdetil').style.display = 'none';	
                    <?
                    }
                    else
                    {
                    ?>
                        mainFrame.location.href='app/loadUrl/persuratan/<?=$tempLinkFile?>/?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>&reqJenis=<?=$reqJenis?>';
						iframeLoaded();
                        //mainFrameDetil.location.href='app/loadUrl/persuratan/<?=$tempLinkDetilFile?>/?reqId=<?=$reqId?>';
                        //document.getElementById('trdetil').style.display = '';	
                    <?
                    }
                    ?>
                }
                <?
            }
            ?>
            return true;
        }

        function setload(linkfile)
        {
            mainFrame.location.href='app/loadUrl/persuratan/'+linkfile;
        }

        // function openPopup(page) {
        //     eModal.iframe(page, 'SIMPEG KABUPATEN JOMBANG')
        // }

    </script>

    <style type="text/css">
        #profile-dropdown{
            padding: 10px;
            position: relative !important; 
            top: 20px !important; 
            left: 0 !important;
        }

        .profile-image{
            width: 130px;
        }

        .menu-utama{
            font-size:10pt
        }

        .d-down{
            line-height: 20px;
        }

        .content-wrap{
            padding: 10px;
        }

        .profil-photo-wrap{
            background-image: url("images/profpic-bg.jpg");
            background-size: 100%;
            background-repeat: no-repeat;
            padding: 15px;
        }

        @media only screen and (max-width: 1200px) {
            .menu-utama{
                font-size:7pt
            }
        }
    </style>

</head>
<body id="layouts-horizontal">
    <!-- START HEADER -->
    <header id="header" class="page-topbar">
        <!-- start header nav-->
            <!-- HORIZONTL NAV START-->
            <nav id="horizontal-menu-nav" class="white hide-on-med-and-down">
                <div class="nav-wrapper-center">
                    <ul id="ul-horizontal-menu-nav" class="left hide-on-med-and-down">
                        <?
                        $arrayKey= '';
                        $arrayKey= in_array_column("0", "MENU_PARENT_ID", $arrMenu);
					       //print_r($arrayKey);exit;
                        if($arrayKey == ''){
                        } 
                        else
                        {
                            for($index_detil=0; $index_detil < count($arrayKey); $index_detil++)
                            {
                                $index_row= $arrayKey[$index_detil];
                                $tempMenuId= $arrMenu[$index_row]["MENU_ID"];
                                $arrMenu[$index_row]["MENU_PARENT_ID"];
                                $tempNama= $arrMenu[$index_row]["NAMA"];
                                $arrMenu[$index_row]["LINK_FILE"];
                                $arrMenu[$index_row]["LINK_DETIL_FILE"];
                                $arrMenu[$index_row]["AKSES"];
                                $tempJumlahMenu= $arrMenu[$index_row]["JUMLAH_MENU"];
                                $tempJumlahDisable= $arrMenu[$index_row]["JUMLAH_DISABLE"];
                                $tempIcon= $arrMenu[$index_row]["ICON"];

                                $arrayKeyChild= '';
                                $arrayKeyChild= in_array_column($tempMenuId, "MENU_PARENT_ID", $arrMenu);
							     //print_r($arrayKey);exit;
                                if($arrayKeyChild == '')
                                {
                                    ?>
                                    <li>
                                        <a class="dropdown-menu ubah-color-warna text-darken-1 menu-utama waves-effect waves-cyan" onClick="executeOnClick('<?=$tempMenuId?>');">
                                            <!-- <i class="mdi-action-invert-colors"></i> -->
                                            <?=$tempIcon?>
                                            <span><?=$tempNama?></span>
                                        </a>
                                    </li>
                                    <?
                                }
                                else
                                {
                                    ?>
                                    <li>
                                        <a class="dropdown-menu ubah-color-warna text-darken-1 menu-utama" data-activates="<?=$tempMenuId?>">
                                            <!-- <i class="mdi-action-invert-colors"></i> -->
                                            <?=$tempIcon?>
                                            <span><?=$tempNama?><i class="mdi-navigation-arrow-drop-down right"></i></span>
                                        </a>
                                    </li>
                                    <?
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </nav>

            <?
            $arrayKey= '';
            $arrayKey= in_array_column("0", "MENU_PARENT_ID", $arrMenu);
				//print_r($arrayKey);exit;
            if($arrayKey == ''){}
                else
                {
                    for($index_detil=0; $index_detil < count($arrayKey); $index_detil++)
                    {
                        $index_row= $arrayKey[$index_detil];
                        $tempMenuId= $arrMenu[$index_row]["MENU_ID"];
                        getMenuByParent($tempMenuId, $arrMenu);
                    }
                }

                function getMenuByParent($id_induk, $arrMenu)
                {
                    $arrayKey= '';
                    $arrayKey= in_array_column($id_induk, "MENU_PARENT_ID", $arrMenu);
					//print_r($arrayKey);exit;
                    if($arrayKey == ''){}
                        else
                        {
                            ?>
                            <!-- CSSdropdown -->
                            <ul id="<?=$id_induk?>" class="dropdown-content dropdown-horizontal-list">
                                <?
                                for($index_detil=0; $index_detil < count($arrayKey); $index_detil++)
                                {
                                  $index_row= $arrayKey[$index_detil];
                                  $tempMenuId= $arrMenu[$index_row]["MENU_ID"];
                                  $arrMenu[$index_row]["MENU_PARENT_ID"];
                                  $tempNama= $arrMenu[$index_row]["NAMA"];
                                  $tempLinkFile= $arrMenu[$index_row]["LINK_FILE"];
                                  $arrMenu[$index_row]["AKSES"];
                                  $tempJumlahMenu= $arrMenu[$index_row]["JUMLAH_MENU"];
                                  $tempJumlahDisable= $arrMenu[$index_row]["JUMLAH_DISABLE"];
                                  ?>
                                  <li><a class="ubah-color-warna text-darken-1 waves-effect waves-cyan" onClick="executeOnClick('<?=$tempMenuId?>');"><?=$tempNama?></a></li>
                                  <?
                              }
                          }
                      }
                      ?>
                  </ul>
                  <!-- HORIZONTL NAV END-->



              </div>
              <!-- end header nav-->
          </header>
          <!-- END HEADER -->

          <!-- //////////////////////////////////////////////////////////////////////////// -->

          <!-- START MAIN -->
          <div id="main">
            <!-- START WRAPPER -->
            <div class="wrapper">

                <!-- START LEFT SIDEBAR NAV-->
                <aside id="left-sidebar-nav hide-on-large-only">
                    <ul id="slide-out" class="side-nav leftside-navigation ">

                        <?
                        $arrayKey= '';
                        $arrayKey= in_array_column("01", "MENU_PARENT_ID", $arrMenu);
                           //print_r($arrayKey);exit;
                        if($arrayKey == ''){
                        } 
                        else
                        {
                            for($index_detil=0; $index_detil < count($arrayKey); $index_detil++)
                            {
                                $index_row= $arrayKey[$index_detil];
                                $tempMenuId= $arrMenu[$index_row]["MENU_ID"];
                                $tempMenuParent= $arrMenu[$index_row]["MENU_PARENT_ID"];
                                $tempNama= $arrMenu[$index_row]["NAMA"];
                                $arrMenu[$index_row]["LINK_FILE"];
                                $arrMenu[$index_row]["LINK_DETIL_FILE"];
                                $arrMenu[$index_row]["AKSES"];
                                $tempJumlahMenu= $arrMenu[$index_row]["JUMLAH_MENU"];
                                $tempJumlahDisable= $arrMenu[$index_row]["JUMLAH_DISABLE"];
                                $tempIcon= $arrMenu[$index_row]["ICON"];

                                $arrayKeyChild= '';
                                $arrayKeyChild= in_array_column($tempMenuId, "MENU_PARENT_ID", $arrMenu);
                                 //print_r($arrayKey);exit;
                                if($arrayKeyChild == '')
                                {
                                    ?>
                                    <li>
                                        <a class="dropdown-menu ubah-color-warna text-darken-1 menu-utama waves-effect waves-cyan" onClick="executeOnClick('<?=$tempMenuId?>');">
                                            <!-- <i class="mdi-action-invert-colors"></i> -->
                                            <?=$tempIcon?>
                                            <span><?=$tempNama?></span>
                                        </a>
                                    </li>
                                    <?
                                }
                                else
                                {
                                    ?>
                                    <ul class="collapsible collapsible-accordion">
                                        <li class="bold">
                                            <a class="collapsible-header green-text waves-effect waves-cyan">
                                                <?=$tempIcon?>
                                                <span><?=$tempNama?></span>
                                            </a>
                                            <div class="collapsible-body">
                                                <ul>
                                                    <?
                                                    for ($i=0; $i < count($arrMenu); $i++) { 
                                                        if ($arrMenu[$i]['MENU_PARENT_ID'] == $tempMenuId){ 
                                                            $childNama = $arrMenu[$i]['NAMA'];
                                                            $childMenuId = $arrMenu[$i]['MENU_ID'];
                                                            ?>
                                                            <li><a onClick="executeOnClick('<?=$childMenuId?>');" class="green-text waves-effect waves-cyan"><?=$childNama?></a></li>                                        
                                                            <?
                                                        }
                                                    }
                                                    ?>

                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <?
                                }
                            }
                        }
                        ?>

                    </ul>
                    <a href="#" data-activates="slide-out" style="position: fixed;" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only light-green darken-2"><i class="mdi-navigation-menu"></i></a>
                </aside>


                <!-- END LEFT SIDEBAR NAV-->

                <!-- //////////////////////////////////////////////////////////////////////////// -->

                <!-- START CONTENT -->
                <section id="content-noheader">

                    <!--breadcrumbs start-->
                <?php /*?><div id="breadcrumbs-wrapper">
                  <div class="container">
                    <div class="row">
                      <div class="col s12 m12 l12">
                        <ol class="breadcrumbs">
                          <li><a href="index.html">Dashboard</a></li>
                          <li><a href="#">Forms</a></li>
                          <li class="active">Forms Layouts</li>
                        </ol>
                      </div>
                    </div>
                  </div>
              </div><?php */?>
              <!--breadcrumbs end-->


              <!--start container-->
              <div class="container">
                <iframe src="app/loadUrl/persuratan/<?=$arrMenu[0]["LINK_FILE"]?>/?reqId=<?=$reqId?>&reqTipe=<?=$reqTipe?>&reqBulan=<?=$reqBulan?>&reqTahun=<?=$reqTahun?>" name="mainFrame" id="mainFrame" onload="iframeLoaded()" style="border: none; width:100%" scrolling="no"></iframe>
              </div>
              <!--end container-->
          </section>
          <!-- END CONTENT -->

      </div>
      <!-- END WRAPPER -->

  </div>
  <!-- END MAIN -->



  <!-- jQuery Library -->
  <script type="text/javascript" src="lib/materializetemplate/js/plugins/jquery-1.11.2.min.js"></script>

  <!-- RESIZE IFRAME HEIGHT ONLOAD -->
  <script type="text/javascript">
  	function closeparenttab()
    {
		if (window.opener && window.opener.document)
        {
            if (typeof window.opener.setCariInfo === 'function')
            {
                window.opener.setCariInfo();
            }
        }
        window.close();
    }

    function reloadparenttab()
    {
		if (window.opener && window.opener.document)
        {
			if (typeof window.opener.setCariInfo === 'function')
			{
				window.opener.setCariInfo();
			}
		}
    }
	
    function iframeLoaded() {
        var iFrameID = document.getElementById('mainFrame');
        if(iFrameID) {
				// here you can make the height, I delete it first, then I make it again
				iFrameID.height = "";
				iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
            }   
        }
    </script>
    <!---->
    
    <!--materialize js-->
    <script type="text/javascript" src="lib/materializetemplate/js/my-materialize.min.js"></script>
    
    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="lib/materializetemplate/js/plugins.min.js"></script>
    
    <?php /*?><!-- eModal -->
	<script src="lib/startbootstrap-sb-admin-2-1.0.7/dist/js/eModal-admin.min.js"></script>
    <script type="text/javascript">
	$(function () {
		$('.modal').modal();
	});
	
	function openPopup(page) {
		eModal.iframe(page, 'SIMPEG KABUPATEN JOMBANG')
	} </script><?php */?>


    <!-- ---------------------------------------------MODAL MATERIAL DESIGN-------------------------------------------------- -->
    
    <style type="text/css">
        #my-modal{
            height: 100%;
        }

        .modal-content{
            height: 88%;
        }

        #judul-modal{
            font-size: 14pt;
        }

        .judul{
            padding: 15px;
        }
		
		.modal
		{
			<?
			if($reqJenis == "5")
			{
			?>
			width:70% !important
			<?
			}
			else
			{
			?>
			width:90% !important
			<?
			}
			?>
		}
    </style>
    <script type="text/javascript">
        function openModal(url){
            $('.modal-place').html('<div id="my-modal" class="modal"><div class="judul"><span id="judul-modal">SIMPEG KABUPATEN JOMBANG</span><a class="modal-action modal-close grey-text right" title="Keluar"><i class="mdi-navigation-close"></i></a></div><div class="modal-content"><iframe src="'+url+'" id="m-iframe" width="100%" height="100%" frameBorder="1"></iframe></div></div>')
            $('#my-modal').openModal();
        }
		
		function setCariInfo()
		{
			$("iframe#mainFrame")[0].contentWindow.setCariInfo();
		}
    </script>
    <div class="modal-place"></div>
    <!-- -------------------------------------------------------------------------------------------------------------------- -->

<link rel="stylesheet" href="lib/AdminLTE-2.4.0-rc/dist/css/skins/ubah-skin.css">
<script src="lib/AdminLTE-2.4.0-rc/dist/js/ubah-skin.js"></script>

</body>