@echo off
taskkill /im php-cgi.exe /F

START "Ending Nginx" /B nginx -s stop