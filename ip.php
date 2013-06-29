<?php

//script to display ip and hostname of a client

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

echo "<html><head><title>Ip Info</title></head><body><center>";

$ip_addy = $_SERVER["HTTP_X_FORWARDED_FOR"];

#do a check to see if the xforwared for header is used, if not use the remote address header
if ( empty($ip_addy) ) {
        $ip_addy = $_SERVER["REMOTE_ADDR"];

}

echo "Well, hello there! ";
echo "Your ip address is: $ip_addy";
echo "    (hostname by address is: ";
echo gethostbyaddr($ip_addy);
echo " )";
echo "<br /><br />";
echo "Bye bye";

echo "</center></body></html>";

?>