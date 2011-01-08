<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES., JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES ., JSC. All rights reserved
 * @Createdate Dec 3, 2010  11:32:04 AM 
 */

if ( ! defined( 'NV_IS_MOD_MUSIC' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$xtpl = new XTemplate( "allplaylist.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
    
// xu li
$type = isset( $array_op[1] ) ?  $array_op[1]  : 'view';
$now_page = isset( $array_op[3] ) ?  intval( $array_op[3] ) : 1;
$key = isset( $array_op[2] ) ?  $array_op[2]  : '-';

$link = $mainURL . "=allplaylist/". $type ."/" . $key ;
$xtpl->assign( 'hot', $mainURL . "=allplaylist/view/" . $key );
$xtpl->assign( 'new', $mainURL . "=allplaylist/id/" . $key );

// active span
if ( $type == 'id' )
{
	$xtpl->assign( 'active_1', 'class="active"' );
	$xtpl->assign( 'active_2', '' );
}
else
{
	$xtpl->assign( 'active_1', '' );
	$xtpl->assign( 'active_2', 'class="active"' );
}

$data = '';
if ( $key != '' )
	$data = "WHERE keyname LIKE '%". $key ."%' AND `active` = 1";
else
	$data = "WHERE `active` = 1";
	
// xu li du lieu
if ( $now_page == 1) 
{
	$first_page = 0 ;
}
else 
{
	$first_page = ($now_page -1)*20;
}	

$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlist ".$data." ORDER BY " . $type . " DESC LIMIT ".$first_page.",20";
$sqlnum = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlist ".$data." ";

// tinh so trang
$num = mysql_query($sqlnum);
$output = mysql_num_rows($num);
$ts = 1;
while ( $ts * 20 < $output ) {$ts ++ ;}

// ket qua
$result = mysql_query( $sql );
$xtpl->assign( 'num', $output);

while($rs = $db->sql_fetchrow($result))
{
	$xtpl->assign( 'num', $output);
	$xtpl->assign( 'name', $rs['name']);
	
	$img = rand( 1, 10);
	$xtpl->assign( 'thumb', NV_BASE_SITEURL ."modules/" . $module_data . "/data/img(" . $img . ").jpg");
	
	$xtpl->assign( 'singer', $rs['singer']);
	$xtpl->assign( 'upload', $rs['username']);
	$xtpl->assign( 'view', $rs['view']);
	
	$xtpl->assign( 'url_listen', $mainURL . "=listenuserlist/".$rs['id'] . "/" . $rs['keyname'] );
	$xtpl->assign( 'url_search_upload', $mainURL . "=search/upload/" . $rs['username']);
	
	$xtpl->parse( 'main.loop' );
}
$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );
$contents .= new_page( $ts, $now_page, $link);

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>