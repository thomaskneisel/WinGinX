@echo off
::::::::::::::::::::::::::::::::::::
::  UPDATE PEAR  ::
::::::::::::::::::::::::::::::::::::


echo.
echo [XAMPP]: Try to update and upgrade PEAR ...

set "CURRENT_DIR=%cd%"
%CURRENT_DIR%\pear update-channels && %CURRENT_DIR%\pear upgrade-all