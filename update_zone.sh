#!/usr/bin/env bash
PATH=/sbin:/bin:/usr/sbin:/usr/bin:/usr/local/sbin:/usr/local/bin

#****************************************************************************
#*   update_zone.sh                                                         *
#*   Updates a bind zone file                                               *
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


#############################################################################

# ** You must update the location of the zone file you are updating 
#    as well as the hostname you are updating below. **

#look for ###edit_marker and note the line number +1
pre_num=$(sed -ne /###record_marker/= /etc/namedb/mobile.example.com)
serial_line=$(sed -ne /###serial_marker/= /etc/namedb/mobile.example.com)


#get ip addrss passed to this script
ip_address=$1


#prepare a few things
line_num=$((pre_num+1))
serial_line=$((serial_line+1))
serial_line_sed=""$serial_line"p"
serial_num=`sed -n "$serial_line_sed" /etc/namedb/mobile.example.com`
new_serial_num=$((serial_num+1))
new_serial_num_sed="c\\"$new_serial_num""


#ensure files exist
touch /tmp/dns_tmp_file
touch /tmp/dns_tmp_file1


#write to temp files
sudo sed "$line_num c\mobile.example.com.    IN      AAAA    $ip_address" /etc/namedb/mobile.example.com > /tmp/dns_tmp_file
sudo sed "$serial_line $new_serial_num_sed" /tmp/dns_tmp_file > /tmp/dns_tmp_file1


#move temp file to dns dir
sudo cp /tmp/dns_tmp_file1 /etc/namedb/mobile.example.com


#reload bind to refresh zone
sudo rndc reload


exit 0


