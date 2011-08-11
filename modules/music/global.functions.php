<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung (phantandung92@gmail.com)
 * @copyright 2011
 * @createdate 26/01/2011 09:17 AM
 */
if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

// lay url
function get_URL( )
{
	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
	$protocol = substr( strtolower( $_SERVER["SERVER_PROTOCOL"] ), 0, strpos( strtolower( $_SERVER["SERVER_PROTOCOL"] ), "/" ) ) .  $s;
	$port = ( $_SERVER["SERVER_PORT"] == "80" ) ? "" : ( ":" . $_SERVER["SERVER_PORT"] );
	return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
}

global $mainURL, $main_header_URL;
$mainURL = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . '&amp;' . NV_OP_VARIABLE ;
$main_header_URL = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . '&' . NV_OP_VARIABLE ;


// lay thong tin the loai
function get_category()
{
	global $module_data, $db ;
	
	$category = array() ;
	
	$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_category";
	
    $result = nv_db_cache( $sql, 'id' );
    
    if ( ! empty( $result ) )
    {
        foreach ( $result as $row )
		{
			$category[ $row['id'] ] = $row[ 'title' ] ;
		}
	}
	return $category ;
}
// lay thong tin the loai video
function get_videocategory()
{
	global $module_data, $db ;
	
	$category = array() ;
	
	$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_video_category";
    $result = nv_db_cache( $sql, 'id' );
    
    if ( ! empty( $result ) )
    {
        foreach ( $result as $row )
		{
			$category[$row['id']] = $row['title'] ;
		}
	}
	
	return $category ;
}

// cau hinh module
function setting_music()
{
	global $module_data, $db;
	
	$setting = array();
	
	$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_setting";
	$result = nv_db_cache( $sql, 'id' );
	 
    if ( ! empty( $result ) )
    {
        foreach ( $result as $row )
		{
			if( $row['key'] == "root_contain" )
			{
				$setting[$row['key']] = $row['char'] ;
			}
			else
			{
				$setting[$row['key']] = $row['value'] ;
			}
		}
	}

	return $setting ;
}

// lay album tu id
function getalbumbyID( $id )
{
	global $module_data, $db ;

	$album = array() ;
	$result = $db->sql_query( " SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_album WHERE id = " . $id );
	$album = $db->sql_fetchrow($result);

	return $album ;
}

// lay video tu id
function getvideobyID( $id )
{
	global $module_data, $db ;

	$video = array() ;
	$result = $db->sql_query( " SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_video WHERE id = " . $id );
	$video = $db->sql_fetchrow($result);

	return $video ;
}

// lay song tu id
function getsongbyID( $id )
{
	global $module_data, $db ;

	$song = array() ;
	$result = $db->sql_query( " SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . " WHERE id = " . $id );
	$song = $db->sql_fetchrow($result);

	return $song ;
}

// lay album tu ten
function getalbumbyNAME( $name )
{
	global $module_data, $db ;

	$album = array() ;
	$result = $db->sql_query( " SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_album WHERE name =\"" . $name ."\"");
	$album = $db->sql_fetchrow($result);

	return $album ;
}

// lay tat ca ca si
function getallsinger()
{
	global $module_data, $db, $lang_module ;

	$allsinger = array() ;
	$allsinger['ns'] = $lang_module['unknow'];
	
	$sql = "SELECT `ten`, `tenthat` FROM " . NV_PREFIXLANG . "_" . $module_data . "_singer ORDER BY ten ASC";
	$result = nv_db_cache( $sql, 'ten' );
	 
    if ( ! empty( $result ) )
    {
        foreach ( $result as $row )
		{
			$allsinger[$row['ten']] = $row['tenthat'];
		}
	}

	return $allsinger ;
}
// lay tat ca nhac si
function getallauthor()
{
	global $module_data, $db, $lang_module ;

	$allsinger = array() ;
	$allsinger['na'] = $lang_module['unknow'];
	$sql = "SELECT `ten`, `tenthat` FROM " . NV_PREFIXLANG . "_" . $module_data . "_author ORDER BY ten ASC";
	$result = nv_db_cache( $sql, 'ten' );
	 
    if ( ! empty( $result ) )
    {
        foreach ( $result as $row )
		{
			$allsinger[$row['ten']] = $row['tenthat'];
		}
	}

	return $allsinger ;
}
// lay ca si tu id
function getsingerbyID( $id )
{
	global $module_data, $db;

	$singer = array() ;
	$result = $db->sql_query( " SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_singer WHERE id=" . $id);
	$singer = $db->sql_fetchrow($result);

	return $singer ;
}

// lay tat ca album
function getallalbum( )
{
	global $module_data, $lang_module, $db ;

	$allalbum = array() ;
	$allalbum['na'] = $lang_module['unknow'];
	
	$sql = "SELECT `name`, `tname` FROM " . NV_PREFIXLANG . "_" . $module_data . "_album ORDER BY name ASC";
	$result = nv_db_cache( $sql, 'name' );
	 
    if ( ! empty( $result ) )
    {
        foreach ( $result as $row )
		{
			$allalbum[$row['name']] = $row['tname'];
		}
	}

	return $allalbum ;
}

// Them moi mot ca si
function newsinger( $name, $tname )
{
	$error = '';
	global $module_data, $lang_module, $db, $module_name ;	
	$query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_singer` ( `id`, `ten`, `tenthat`, `thumb`, `introduction`, `numsong`, `numalbum`) VALUES ( NULL, " . $db->dbescape( $name ) . ", " . $db->dbescape( $tname ) . ", '', '', 0, 0 )"; 
	if ( $db->sql_query_insert_id( $query ) ) 
	{ 
		$db->sql_freeresult();
	} 
	else 
	{ 
		$error = $lang_module['singer_new_added']; 
	}
	
	nv_del_moduleCache( $module_name );
	
	return $error;
}

// Them moi mot nhac si
function newauthor( $name, $tname )
{
	$error = '';
	global $module_data, $lang_module, $db, $module_name ;	
	$query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_author` ( `id`, `ten`, `tenthat`, `thumb`, `introduction`, `numsong`, `numvideo`) VALUES ( NULL, " . $db->dbescape( $name ) . ", " . $db->dbescape( $tname ) . ", '', '', 0, 0 )"; 
	if ( $db->sql_query_insert_id( $query ) ) 
	{ 
		$db->sql_freeresult();
	}
	
	nv_del_moduleCache( $module_name );
	
	return;
}

// cap nhat ca si
function updatesinger( $name, $what, $action )
{
	global $module_data, $db ;	
	$result = $db->sql_query( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_singer` SET " . $what . " = " . $what . $action . " WHERE `ten` = '" . $name . "'" );
	return ;
}

// cap nhat nhac si
function updateauthor( $name, $what, $action )
{
	global $module_data, $db ;	
	$result = $db->sql_query( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_author` SET " . $what . " = " . $what . $action . " WHERE `ten` = '" . $name . "'" );
	return ;
}

// cap nhat album
function updatealbum( $name, $action )
{
	global $module_data, $db ;	
	$result = $db->sql_query( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_album` SET numsong = numsong" . $action . " WHERE `name` = '" . $name . "'" );
	return ;
}

// xoa cac binh luan
function delcomment( $delwwhat, $where )
{
	global $module_data, $db ;	
	$sql = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_comment_" . $delwwhat ."` WHERE `what`=" . $where;
    $result = $db->sql_query( $sql );
	return ;
}

// xoa cac loi bai hat
function dellyric( $songid )
{
	global $module_data, $db ;	
	$sql = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_lyric` WHERE `songid`=" . $songid;
    $result = $db->sql_query( $sql );
	return ;
}

// xoa cac bao loi
function delerror( $where, $key )
{
	global $module_data, $db ;	
	$sql = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_error` WHERE `where`= '" . $where . "' AND `key` = " . $key;
    $result = $db->sql_query( $sql );
	return ;
}

// xoa cac qua tang am nhac
function delgift( $songid )
{
	global $module_data, $db ;	
	$sql = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_gift` WHERE `songid` =" . $songid;
    $result = $db->sql_query( $sql );
	return ;
}
// Lay thong tin ftp cua host nhac
function getFTP()
{
	global $module_data, $db, $lang_module ;
	$ftpdata = array();
	$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_ftp` ORDER BY id ASC";
	$result = nv_db_cache( $sql, 'id' );
	 
    if ( ! empty( $result ) )
    {
        foreach ( $result as $row )
		{		
			$ftpdata[$row['id']] = array(
				"id" => $row['id'],
				"host" => $row['host'],
				"user" => $row['user'],
				"pass" => $row['pass'],
				"fulladdress" => $row['fulladdress'],
				"subpart" => $row['subpart'],
				"ftppart" => $row['ftppart'],
				"active" => ( $row['active'] == 1 )? $lang_module['active_yes'] : $lang_module['active_no']
			);
		}
	}
	return $ftpdata;
}
// tao duong dan tu mot chuoi
function creatURL ( $inputurl )
{
	global $module_name, $setting;
	//$setting = setting_music();
	$songdata = array();
	if ( preg_match( '/^(ht|f)tp:\/\//', $inputurl ) ) 
	{
		$ftpdata = getFTP();
		$str_inurl = str_split( $inputurl );
		$no_ftp = true;
		foreach ( $ftpdata as $id => $data )
		{
			$this_host = $data['fulladdress'] . $data['subpart'];
			$str_check = str_split( $this_host );
			$check_ok = false;
			foreach ( $str_check as $stt => $char )
			{
				if ( $char != $str_inurl[$stt] ) 
				{
					$check_ok = false;
					break;
				}
				$check_ok = true;
			}
			if ( $check_ok )
			{
				$lu = strlen( $this_host );
				$songdata['duongdan'] = substr( $inputurl, $lu );
				$songdata['server'] = $id;
				$no_ftp = false;
				break;
			}
		}
		if ( $no_ftp )
		{
			$songdata['duongdan'] = $inputurl;
			$songdata['server'] = 0;
		}
	}
	else
	{
		$lu = strlen( NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $setting['root_contain'] . "/" );
		$songdata['duongdan'] = substr( $inputurl, $lu );
		$songdata['server'] = 1;
	}
	return $songdata;
}

// xuat duong dan day du
function outputURL ( $server, $inputurl )
{
	global $module_name, $setting;
	$output = "";
	if( $server == 0 )
	{
		$output = $inputurl;
	}
	elseif( $server == 1 )
	{
		$output = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $setting['root_contain'] . "/" . $inputurl;
	}
	else
	{
		$ftpdata = getFTP();
		foreach ( $ftpdata as $id => $data )
		{
			if ( $id == $server )
			{
				if ( $data['host'] == "nhaccuatui" )
				{
					$cache_file = NV_LANG_DATA . "_" . $module_name . "_" . md5( $server . $inputurl ) . "_" . NV_CACHE_PREFIX . ".cache";
					
					if ( file_exists ( NV_ROOTDIR . "/" . NV_CACHEDIR . "/" . $cache_file ) )
					{
						if ( ( ( NV_CURRENTTIME - filemtime ( NV_ROOTDIR . "/" . NV_CACHEDIR . "/" . $cache_file ) ) > $setting['del_cache_time_out'] ) and $setting['del_cache_time_out'] != 0 )
						{
							nv_deletefile( NV_ROOTDIR . "/" . NV_CACHEDIR . "/" . $cache_file, true );
						}
					}
					
					if ( ( $cache = nv_get_cache( $cache_file ) ) != false )
					{
						$output = unserialize( $cache );
					}
					else
					{
						$output = $data['fulladdress'] . $data['subpart'] . $inputurl;
						$output = nv_get_URL_content( $output );
						$output = explode ( 'flashvars="autostart=true&amp;file=', $output );
						$output = explode ( '"', $output[1] );
						$output =  nv_get_URL_content ( $output[0] );
						$output = explode ( "<location><![CDATA[", $output );
						$output = explode ( "]]></location>", $output[1] );
						$output =  $output[0];
						
						$cache = serialize( $output );
						nv_set_cache( $cache_file, $cache );
					}
				}
				elseif ( $data['host'] == "zing" )
				{
					$cache_file = NV_LANG_DATA . "_" . $module_name . "_" . md5( $server . $inputurl ) . "_" . NV_CACHE_PREFIX . ".cache";
					
					if ( file_exists ( NV_ROOTDIR . "/" . NV_CACHEDIR . "/" . $cache_file ) )
					{
						if ( ( ( NV_CURRENTTIME - filemtime ( NV_ROOTDIR . "/" . NV_CACHEDIR . "/" . $cache_file ) ) > $setting['del_cache_time_out'] ) and $setting['del_cache_time_out'] != 0 )
						{
							nv_deletefile( NV_ROOTDIR . "/" . NV_CACHEDIR . "/" . $cache_file, true );
						}
					}
					
					if ( ( $cache = nv_get_cache( $cache_file ) ) != false )
					{
						$output = unserialize( $cache );
					}
					else
					{
						$output = $data['fulladdress'] . $data['subpart'] . $inputurl;
						$output = nv_get_URL_content( $output );
						$output = explode ( '<input type="hidden" id="_strNoAuto" value="', $output );
						$output = explode ( '"', $output[1] );
						$output =  nv_get_URL_content ( $output[0] );
						$output = explode ( "<urlSource>", $output );
						$output = explode ( "</urlSource>", $output[1] );
						$output =  nv_unhtmlspecialchars ( $output[0] );
						
						$cache = serialize( $output );
						nv_set_cache( $cache_file, $cache );
					}
				}
				elseif ( $data['host'] == "nhacvui" )
				{
					$cache_file = NV_LANG_DATA . "_" . $module_name . "_" . md5( $server . $inputurl ) . "_" . NV_CACHE_PREFIX . ".cache";
					
					if ( file_exists ( NV_ROOTDIR . "/" . NV_CACHEDIR . "/" . $cache_file ) )
					{
						if ( ( ( NV_CURRENTTIME - filemtime ( NV_ROOTDIR . "/" . NV_CACHEDIR . "/" . $cache_file ) ) > $setting['del_cache_time_out'] ) and $setting['del_cache_time_out'] != 0 )
						{
							nv_deletefile( NV_ROOTDIR . "/" . NV_CACHEDIR . "/" . $cache_file, true );
						}
					}
					
					if ( ( $cache = nv_get_cache( $cache_file ) ) != false )
					{
						$output = unserialize( $cache );
					}
					else
					{
						$output = $data['fulladdress'] . $data['subpart'] . $inputurl;
						$output = nv_get_URL_content( $output );
						$output = explode ( '[FLASH]', $output );
						$output = explode ( 'playlistfile=', $output[1] );
						$output = explode ( '[/FLASH]"', $output[1] );
						$output =  rawurldecode ( $output[0] );
						$output =  nv_get_URL_content ( $output );
						$output = explode ( "<location><![CDATA[", $output );
						$output = explode ( "]]></location>", $output[1] );
						$output =  $output[0];
						
						$cache = serialize( $output );
						nv_set_cache( $cache_file, $cache );
					}
				}
				else
				{
					$output = $data['fulladdress'] . $data['subpart'] . $inputurl;
					break;
				}
			}
		}
	}
	return $output;
}

function unlinkSV ( $server, $url )
{
	global $module_name, $setting;
	if ( $server == 1 )
	{
		@unlink( NV_DOCUMENT_ROOT . NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $setting['root_contain'] . "/" . $url );
	}
	elseif ( $server != 0 )
	{
		$ftpdata = getFTP();
		require_once ( NV_ROOTDIR . "/modules/" . $module_name . "/class/ftp.class.php" );
		$ftp = new FTP();
		if ( $ftp->connect( $ftpdata[$server]['host'] ) ) 
		{
			if ( $ftp->login( $ftpdata[$server]['user'], $ftpdata[$server]['pass'] ) ) 
			{
				$ftp->delete( $ftpdata[$server]['ftppart']  . $ftpdata[$server]['subpart'] . $url );
			} 
			$ftp->disconnect();
		} 
	}
	return;
}

/**
 * nv_get_URL_content()
 * 
 * @param mixed $target_url
 * @return
 */
function nv_get_URL_content( $target_url )
{	
	$error = 0;
		
	$content = @file( $target_url );
	
	if( $content === false )
	{
		$error = 1;
	}
	
	//	Phuong phap thu 2
	if( $error == 1 )
	{
		if( function_exists('curl_init') )
		{
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $target_url );
			curl_setopt( $ch, CURLOPT_HEADER, 0 );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0' );
			$content = curl_exec( $ch );
			$errormsg = curl_error( $ch );
			curl_close( $ch );
			
			if ( $errormsg != "" )
			{
				return false;
			}
		}
	}
	
	if( ! is_array( $content ) )
	{
		$content = explode( "\n", $content );
	}
	
	return implode ( "", $content );
}

?>