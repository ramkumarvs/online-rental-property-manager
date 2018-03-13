<?php
// This script and data application were generated by AppGini 5.62
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/references.php");
	include("$currDir/references_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('references');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "references";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`references`.`id`" => "id",
		"IF(    CHAR_LENGTH(`applicants_and_tenants1`.`first_name`) || CHAR_LENGTH(`applicants_and_tenants1`.`last_name`), CONCAT_WS('',   `applicants_and_tenants1`.`first_name`, ' ', `applicants_and_tenants1`.`last_name`), '') /* Tenant */" => "tenant",
		"`references`.`reference_name`" => "reference_name",
		"CONCAT_WS('-', LEFT(`references`.`phone`,3), MID(`references`.`phone`,4,3), RIGHT(`references`.`phone`,4))" => "phone"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`references`.`id`',
		2 => 2,
		3 => 3,
		4 => 4
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`references`.`id`" => "id",
		"IF(    CHAR_LENGTH(`applicants_and_tenants1`.`first_name`) || CHAR_LENGTH(`applicants_and_tenants1`.`last_name`), CONCAT_WS('',   `applicants_and_tenants1`.`first_name`, ' ', `applicants_and_tenants1`.`last_name`), '') /* Tenant */" => "tenant",
		"`references`.`reference_name`" => "reference_name",
		"CONCAT_WS('-', LEFT(`references`.`phone`,3), MID(`references`.`phone`,4,3), RIGHT(`references`.`phone`,4))" => "phone"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`references`.`id`" => "ID",
		"IF(    CHAR_LENGTH(`applicants_and_tenants1`.`first_name`) || CHAR_LENGTH(`applicants_and_tenants1`.`last_name`), CONCAT_WS('',   `applicants_and_tenants1`.`first_name`, ' ', `applicants_and_tenants1`.`last_name`), '') /* Tenant */" => "Tenant",
		"`references`.`reference_name`" => "Reference name",
		"`references`.`phone`" => "Reference phone"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`references`.`id`" => "id",
		"IF(    CHAR_LENGTH(`applicants_and_tenants1`.`first_name`) || CHAR_LENGTH(`applicants_and_tenants1`.`last_name`), CONCAT_WS('',   `applicants_and_tenants1`.`first_name`, ' ', `applicants_and_tenants1`.`last_name`), '') /* Tenant */" => "tenant",
		"`references`.`reference_name`" => "reference_name",
		"CONCAT_WS('-', LEFT(`references`.`phone`,3), MID(`references`.`phone`,4,3), RIGHT(`references`.`phone`,4))" => "phone"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'tenant' => 'Tenant');

	$x->QueryFrom = "`references` LEFT JOIN `applicants_and_tenants` as applicants_and_tenants1 ON `applicants_and_tenants1`.`id`=`references`.`tenant` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowMassDelete = false;
	$x->AllowInsert = $perm[1];
	$x->AllowUpdate = $perm[3];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = 0;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 10;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "references_view.php";
	$x->RedirectAfterInsert = "references_view.php?SelectedID=#ID#";
	$x->TableTitle = "References";
	$x->TableIcon = "resources/table_icons/application_from_storage.png";
	$x->PrimaryKey = "`references`.`id`";

	$x->ColWidth   = array(  160, 160);
	$x->ColCaption = array("Reference name", "Reference phone");
	$x->ColFieldName = array('reference_name', 'phone');
	$x->ColNumber  = array(3, 4);

	// template paths below are based on the app main directory
	$x->Template = 'templates/references_templateTV.html';
	$x->SelectedTemplate = 'templates/references_templateTVS.html';
	$x->TemplateDV = 'templates/references_templateDV.html';
	$x->TemplateDVP = 'templates/references_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->ShowRecordSlots = 0;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `references`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='references' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `references`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='references' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`references`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: references_init
	$render=TRUE;
	if(function_exists('references_init')){
		$args=array();
		$render=references_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: references_header
	$headerCode='';
	if(function_exists('references_header')){
		$args=array();
		$headerCode=references_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: references_footer
	$footerCode='';
	if(function_exists('references_footer')){
		$args=array();
		$footerCode=references_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>