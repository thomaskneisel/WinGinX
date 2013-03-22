@ECHO off
cls
@ECHO Packaged for reBuy.de By Thomas Kneisel

if "%1" == "" (
	set WWW_FOLDER=c:\coden\data\www
) else (
	set WWW_FOLDER=%1
)

if "%2" == "" (
	set PHP_VERSION=php5.3.21
) else (
	set PHP_VERSION=php%2
)

if "%3" == "" (
	set NGINX_VERSION=1.2.7
) else (
	set NGINX_VERSION=%3
)

if "%1" == "" (
	@echo Verwende default werte!
)

@echo Richte Nginx (%NGINX_VERSION%) mit %PHP_VERSION% für webfolder html auf %WWW_FOLDER% ein.

call winginx.bat stop

rmdir php
rmdir html

if exist nginx.exe (
	del nginx.exe
)

mklink /D php %PHP_VERSION%
setx PHPBIN %~dp0/php/php-cgi.exe

mklink /D html %WWW_FOLDER%
copy ".\nginx\nginx%NGINX_VERSION%.exe" nginx.exe

@ECHO Ready to go
goto ENDE

:FEHLER
@echo Es ist ein Fehler aufgetreten!
goto ENDE

:ENDE
