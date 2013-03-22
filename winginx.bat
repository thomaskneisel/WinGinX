@ECHO off

if "%1"=="start" GOTO START
if "%1"=="stop" GOTO STOP
if "%1"=="restart" GOTO RESTART

GOTO CMDNOTFOUND

:RESTART
call :STOP
call :START
GOTO ENDE

:STOP
taskkill /im php-cgi.exe /F
START "Ending Nginx" /B nginx -s stop
taskkill /im nginx.exe /F
@echo WinGinX stoped ...
GOTO ENDE

:START
START "NGINX" /B "nginx"
START "PHP Fast-cgi" /B ".\php\php-cgi.exe" -b localhost:9000
@ECHO Let's Rock!
GOTO ENDE

:CMDNOTFOUND
@echo Command not found!
@echo Syntax: 
@echo "winginx.bat start|stop|restart"

:ENDE