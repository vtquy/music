<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES., JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES ., JSC. All rights reserved
 * @Createdate Dec 3, 2010  12:57:52 PM 
 */

if ( ! defined( 'NV_IS_MOD_MUSIC' ) ) die( 'Stop!!!' );
global $lang_module, $module_data, $module_file, $module_info, $mainURL, $db;
$xtpl = new XTemplate( "block_video_same_singer.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );

// lay id video
$videoid = get_URL() ;
$videoidarray = explode( '/', $videoid );
$num_url = count( $videoidarray ) - 3 ;

$videoid = $videoidarray[$num_url] ;
if ( $num_url <= 3 ) 
{ 
	$num_url = count( $videoidarray ) - 2 ;
	$videoid = $videoidarray[$num_url] ;
}
$source = $db->sql_query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_video WHERE `id` =" . $videoid );
$data = $db->sql_fetchrow($source);
$casi = $data['casi'];

$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_video WHERE casi =\"".$casi."\" ORDER BY id DESC LIMIT 0,6";
$query = $db->sql_query( $sql );
while( $video =  $db->sql_fetchrow( $query ) )
{
	$xtpl->assign( 'url_view', $mainURL . "=viewvideo/" .$video['id']. "/" . $video['name'] );
	$xtpl->assign( 'video_name', $video['tname'] );
	$xtpl->assign( 'thumb', $video['thumb'] );
	$xtpl->assign( 'view', $video['view'] );
	$xtpl->parse( 'main.loop' );
}

$xtpl->parse( 'main' );
$content = $xtpl->text( 'main' );

?>