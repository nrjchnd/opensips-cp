<?php
/*
* $Id: dialog.php 79 2009-07-10 09:37:43Z iulia_bublea $
* Copyright (C) 2008 Voice Sistem SRL
*
* This file is part of opensips-cp, a free Web Control Panel Application for
* OpenSIPS SIP server.
*
* opensips-cp is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* opensips-cp is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

require("template/header.php");
require("lib/".$page_id.".main.js");
require ("../../../common/mi_comm.php");

$current_page="current_page_dialog";

if (isset($_POST['action'])) $action=$_POST['action'];
else if (isset($_GET['action'])) $action=$_GET['action'];
else $action="";
if (isset($_GET['page'])) $_SESSION[$current_page]=$_GET['page'];
else if (!isset($_SESSION[$current_page])) $_SESSION[$current_page]=1;
################
# start show #
################
if ($action=="refresh") {
$mi_connectors=get_proxys_by_assoc_id($talk_to_this_assoc_id);
for ($i=0;$i<count($mi_connectors);$i++){

                $comm_type=params($mi_connectors[$i]);
                $message=mi_command('dlg_list',$errors,$status);
                print_r($errors);
                $status = trim($status);
        }
}

##############
# end show#
##############


################
# start delete #
################

if ($action=="delete")
{
	if(!$_SESSION['read_only']){

		$h_entry=$_GET['h_entry'];
		$h_id=$_GET['h_id'];
	        $mi_connectors=get_proxys_by_assoc_id($talk_to_this_assoc_id);
        	for ($i=0;$i<count($mi_connectors);$i++){

                	$comm_type=params($mi_connectors[$i]);
	                mi_command("dlg_end_dlg ".$h_entry." ".$h_id,$errors,$status);
        	        print_r($errors);
                	$status = trim($status);
		}
	}else{

		$errors= "User with Read-Only Rights";
	}
}
##############
# end delete #
##############


################
# start search #
################
if ($action=="dp_act")
{
$query="";
	$_SESSION['dlg_from_uri']  = $_POST['dlg_from_uri'];
	$_SESSION['dlg_to_uri']= $_POST['dlg_to_uri'];
	$_SESSION['dlg_state']= $_POST['dlg_state'];

	$_SESSION[$current_page]=1;
	extract($_POST);
	if ($show_all=="Show All") {
		$_SESSION['dlg_from_uri']="";
		$_SESSION['dlg_to_uri']="";
		$_SESSION['dlg_state']="";
	} else if($search=="Search"){
		$_SESSION['dlg_from_uri'] =$_POST['dlg_from_uri'];
		$_SESSION['dlg_to_uri'] =$_POST['dlg_to_uri'];
		$_SESSION['dlg_state'] =$_POST['dlg_state'];
	} else if($_SESSION['read_only']){

		$errors= "User with Read-Only Rights";

	}
}
##############
# end search #
##############

##############
# start main #
##############

require("template/".$page_id.".main.php");
if($errors)
echo('!!! ');echo($errors);
require("template/footer.php");
exit();

##############
# end main   #
##############
?>