<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2010 Freeware
 * @Createdate 9-8-2010 14:43
 */

if( ! defined( 'NV_IS_MUSIC_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['list_gift'];

// Call jquery datepicker + shadowbox
$my_head .= "<link type=\"text/css\" href=\"" . NV_BASE_SITEURL . "js/ui/jquery.ui.core.css\" rel=\"stylesheet\" />\n";
$my_head .= "<link type=\"text/css\" href=\"" . NV_BASE_SITEURL . "js/ui/jquery.ui.theme.css\" rel=\"stylesheet\" />\n";
$my_head .= "<link type=\"text/css\" href=\"" . NV_BASE_SITEURL . "js/ui/jquery.ui.datepicker.css\" rel=\"stylesheet\" />\n";

$my_head .= "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/ui/jquery.ui.core.min.js\"></script>\n";
$my_head .= "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/ui/jquery.ui.datepicker.min.js\"></script>\n";
$my_head .= "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/language/jquery.ui.datepicker-" . NV_LANG_INTERFACE . ".js\"></script>\n";

$now_page = $nv_Request->get_int( 'now_page', 'get', 0 );

if( ! $now_page )
{
	$now_page = 1;
	$first_page = 0;
}
else
{
	$first_page = ( $now_page - 1 ) * 50;
}

$sql = "FROM `" . NV_PREFIXLANG . "_" . $module_data . "_gift` AS a INNER JOIN `" . NV_PREFIXLANG . "_" . $module_data . "` AS b ON a.songid=b.id WHERE a.id!=0";
$link = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op;

// Search data
$data_search = array(
	"q" => filter_text_input( 'q', 'get', $lang_module['filter_enterkey'], 1, 100 ), //
	"from" => filter_text_input( 'from', 'get', '', 1, 100 ), //
	"to" => filter_text_input( 'to', 'get', '', 1, 100 ), //
	"disabled" => " disabled=\"disabled\"" //
);

// Enable cancel filter data
if( ( $data_search['q'] != $lang_module['filter_enterkey'] and ! empty( $data_search['q'] ) ) or ! empty( $data_search['from'] ) or ! empty( $data_search['to'] ) )
{
	$data_search['disabled'] = "";
}

if( ! empty( $data_search['q'] ) and $data_search['q'] != $lang_module['filter_enterkey'] )
{
	$link .= "&amp;q=" . $data_search['q'];
	$sql .= " AND ( a.body LIKE '%" . $db->dblikeescape( $data_search['q'] ) . "%' OR b.tenthat LIKE '%" . $db->dblikeescape( $data_search['q'] ) . "%' )";
}

if( ! empty( $data_search['from'] ) )
{
	unset( $match );
	if( preg_match( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $data_search['from'], $match ) )
	{
		$from = mktime( 0, 0, 0, $match[2], $match[1], $match[3] );
		$sql .= " AND a.time >= " . $from;
		$link .= "&amp;from=" . $data_search['from'];
	}
}

if( ! empty( $data_search['to'] ) )
{
	unset( $match );
	if( preg_match( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $data_search['to'], $match ) )
	{
		$to = mktime( 0, 0, 0, $match[2], $match[1], $match[3] );
		$sql .= " AND a.time <= " . $to;
		$link .= "&amp;to=" . $data_search['to'];
	}
}

$sql .= " ORDER BY a.id DESC";

// Get num row
$sql1 = "SELECT COUNT(*) " . $sql;
$result1 = $db->sql_query( $sql1 );
list( $output ) = $db->sql_fetchrow( $result1 );
$ts = ceil( $output / 50 );

$xtpl = new XTemplate( "gift.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_name );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'URL_DEL_BACK', str_replace( "&amp;", "&", $link ) );
$xtpl->assign( 'URL_ACTIVE_LIST', "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=listactive&where=_gift" );
$xtpl->assign( 'URL_DEL', "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=delall&where=_gift" );

$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );

$xtpl->assign( 'DATA_SEARCH', $data_search );
$xtpl->assign( 'URL_CANCEL', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op );

$link_del = "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=del";
$link_active = "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=active&where=_gift&id=";
$link_edit = "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=editgift";

$sql = "SELECT a.*, b.tenthat " . $sql . " LIMIT " . $first_page . ", 50";
$result = $db->sql_query( $sql );

while( $row = $db->sql_fetchrow( $result ) )
{
	$xtpl->assign( 'id', $row['id'] );
	$xtpl->assign( 'body', nv_clean60( strip_tags( $row['body'] ), 200 ) );
	$xtpl->assign( 'name', $row['who_send'] );
	$xtpl->assign( 'song', $row['tenthat'] );

	$class = ( $i % 2 ) ? " class=\"second\"" : "";
	$xtpl->assign( 'class', $class );
	$xtpl->assign( 'URL_DEL_ONE', $link_del . "&where=_gift&id=" . $row['id'] );
	$xtpl->assign( 'URL_EDIT', $link_edit . "&id=" . $row['id'] );

	$str_ac = ( $row['active'] == 1 ) ? $lang_module['active_yes'] : $lang_module['active_no'];
	$xtpl->assign( 'active', $str_ac );
	$xtpl->assign( 'URL_ACTIVE', $link_active . $row['id'] );

	$xtpl->parse( 'main.row' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );
$contents .= "<div align=\"center\" style=\"width:300px;margin:0px auto 0px auto;\">\n ";
$contents .= new_page_admin( $ts, $now_page, $link );
$contents .= "</div>\n";

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>