taskkill /im php-cgi.exe /F

START "Ending Nginx" /B nginx -s stop

START "STOPPING DATABASE" MariaDB\bin\mysqladmin -u root -p shutdown

taskkill /im minime.exe /F