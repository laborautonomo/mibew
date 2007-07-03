<?php
/*
 * This file is part of Web Instant Messenger project.
 *
 * Copyright (c) 2005-2007 Internet Services Ltd.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.eclipse.org/legal/epl-v10.html
 *
 * Contributors:
 *    Evgeny Gryaznov - initial API and implementation
 */

require('libs/common.php');
require('libs/chat.php');

$act = verifyparam( "act", "/^(refresh|post|rename|close|ping)$/");
$token = verifyparam( "token", "/^\d{1,9}$/");
$threadid = verifyparam( "thread", "/^\d{1,9}$/");
$isuser = verifyparam( "user", "/^true$/", "false") == 'true';
$outformat = (verifyparam( "html", "/^on$/", "off") == 'on') ? "html" : "xml";

$thread = thread_by_id($threadid);
if( !$thread || !isset($thread['ltoken']) || $token != $thread['ltoken'] ) {
	die("wrong thread");
}

if( $act == "refresh" ) {
	$lastid = verifyparam( "lastid", "/^\d{1,9}$/", -1);
	ping_thread($thread, $isuser);
	print_thread_mesages($threadid, $token, $lastid, $isuser,$outformat);
	exit;

} else if( $act == "post" ) {
	$lastid = verifyparam( "lastid", "/^\d{1,9}$/", -1);
	$message = getrawparam('message');

	$kind = $isuser ? $kind_user : $kind_agent;
	$from = $isuser ? $thread['userName'] : $thread['agentName'];

	post_message($threadid,$kind,$message,$from);
	ping_thread($thread, $isuser);
	print_thread_mesages($threadid, $token, $lastid, $isuser, $outformat);
	exit;

} else if( $act == "rename" ) {
	$newname = getrawparam('name');

	ping_thread($thread, $isuser);
	rename_user($thread, $newname);
	setcookie($namecookie, $newname, time()+60*60*24*365); 
	start_xml_output();
	echo "<changedname></changedname>";
	exit;

} else if( $act == "ping" ) {

	ping_thread($thread, $isuser);
	start_xml_output();
	echo "<ping></ping>";
	exit;

} else if( $act == "close" ) {

	ping_thread($thread, $isuser);
	close_thread($thread, $isuser);
	start_xml_output();
	echo "<closed></closed>";
	exit;

}

?>