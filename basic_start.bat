@ECHO off
@ECHO Packaged for reBuy.de By Thomas Kneisel !!!

START "NGINX" /B "nginx"

START "PHP Fast-cgi" /B ".\php\php-cgi.exe" -b localhost:9000

@ECHO Let's Rock!