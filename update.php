<?php

/* 
# ***************************************************************************
# *   Copyright (C) 2011 by Jeremy Falling except where noted.              *
# *                                                                         *
# *   This program is free software; you can redistribute it and/or modify  *
# *   it under the terms of the GNU General Public License as published by  *
# *   the Free Software Foundation; either version 2 of the License, or     *
# *   (at your option) any later version.                                   *
# *                                                                         *
# *   This program is distributed in the hope that it will be useful,       *
# *   but WITHOUT ANY WARRANTY; without even the implied warranty of        *
# *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         *
# *   GNU General Public License for more details.                          *
# *                                                                         *
# *   You should have received a copy of the GNU General Public License     *
# *   along with this program; if not, write to the                         *
# *   Free Software Foundation, Inc.,                                       *
# *   59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.             *
# ***************************************************************************
*/

//**************************************************
//You must change the key below to match the client.
//**************************************************

$key = $_POST['key'];
$ip_addy = $_SERVER["REMOTE_ADDR"];
//counter file is just for stats
$counter_file = "/var/www/ip_info/.counter";

//Check to see if the client is authorized by checking to see if a key was sent.

//*******************************************************
//Change this key to macth the client. PLEASE CHANGE THIS
//*******************************************************

if ($key == "fadf8Mu59vDJGasfdajs5646dsf48bysvGbsdfgvsvgDdsxcd")
{
        //inciment counter file
        $fh = fopen($counter_file, 'r');
        $count = fread($fh, 50);
        fclose($fh);
        $count = $count + 1;
        $fh = fopen($counter_file, 'w');
        fwrite($fh, $count);
        fclose($fh);

        //update dns file

        $update_command = "update_zone.sh $ip_addy";
        echo "$update_command";
        shell_exec("$update_command");
        echo "dns_updated with $ip_addy";
}

//If not authorized redirect somewhere else
else
{
        header("Location: http://google.com");
}

?>
