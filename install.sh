#!/bin/bash

cat <<EOS
Welcome to the installation of the CakePHP version of the project site for the FUxCon 2013 workshop.

This software and documentation is released under the GNU General Public License 
(version 3). Please review the license in LICENSE.txt.

This script will setup some directory links and the database. 
It assumes that you have created a MySQL database "fuxcon2013_cakephp" 
and a database user "fuxcon" with password "fuxcon" for it. 

If you still need to do this, please press ^C now 
and restart the installation once you are ready.

EOS

read -p "Ready to proceed? [y]/n " reply
if [ "x$reply" != "x" -a "x$reply" != "xy" ]
then
  echo "Please type \"y\" or simply press ENTER to proceed the installation"
  exit
fi

echo "Proceeding ..."

  