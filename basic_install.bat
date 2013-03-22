@ECHO off
cls
@ECHO Packaged for reBuy.de By Thomas Kneisel !!!

if "%1" == "" (
	set PHP_VERSION=php5.3.8
) else (
	set PHP_VERSION=php%1
)

if "%2" == "" (
	set WWW_FOLDER=c:\coden\data\www
) else (
	set WWW_FOLDER=%2
)

if "%3" == "" (
	set NGINX_VERSION=1.2.4
) else (
	set NGINX_VERSION=%3
)

@echo Richte Nginx (%NGINX_VERSION%) mit %PHP_VERSION% für webfolder html auf %WWW_FOLDER% ein.

rmdir php
rmdir html
del nginx.exe

mklink /D php %PHP_VERSION%
mklink /D html %WWW_FOLDER%
cp "nginx/nginx%NGINX_VERSION%.exe" nginx.exe

@ECHO Ready to go