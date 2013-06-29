<?php

/* 
#****************************************************************************
#*   Update.php                                                             *
#*   Gets client's ip and updates a dns record if auth key matches          *
#*                                                                          *
#*   Copyright (C) 2013 by Jeremy Falling except where noted.               *
#*                                                                          *
#*   This program is free software: you can redistribute it and/or modify   *
#*   it under the terms of the GNU General Public License as published by   *
#*   the Free Software Foundation, either version 3 of the License, or      *
#*   (at your option) any later version.                                    *
#*                                                                          *
#*   This program is distributed in the hope that it will be useful,        *
#*   but WITHOUT ANY WARRANTY; without even the implied warranty of         *
#*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          *
#*   GNU General Public License for more details.                           *
#*                                                                          *
#*   You should have received a copy of the GNU General Public License      *
#*   along with this program.  If not, see <http://www.gnu.org/licenses/>.  *
#****************************************************************************
*/

//**************************************************
//You must change the key below to match the client.
//**************************************************

$key = $_POST['key'];
$ip_addy = $_SERVER["HTTP_X_FORWARDED_FOR"];
//counter file is just for stats
$counter_file = "/var/www/ip_info/.counter";

#do a check to see if the xforwared for header is used, if not use the remote address header
if ( empty($ip_addy) ) {
        $ip_addy = $_SERVER["REMOTE_ADDR"];

}

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
