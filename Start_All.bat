@ECHO Packaged By Emad Ramlawi !!!

START "NGINX" /B "C:\WnMp\nginx.exe"

START "PHP Fast-cgi" /B "C:\WnMp\php-cgi.exe.lnk"

START "MariahDB" /B "C:\WnMp\MariaDB\bin\mysqld.exe" "--defaults-file=C:\WnMp\MariaDB\data\my.ini"

Start "Minimize to Tray" /B minime.exe

@ECHO Please press CTRL + SHIFT + Z to minimize to tray.