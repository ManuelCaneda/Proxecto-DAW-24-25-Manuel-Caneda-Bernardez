@echo off
:: Obtener la carpeta donde está este archivo
set "SCRIPT_DIR=%~dp0"

:: Comprobar si Python está instalado
where python >nul 2>&1
if errorlevel 1 (
    echo Python no está instalado o no está en el PATH.
    echo Por favor, instala Python desde https://www.python.org/downloads/
    pause
    exit /b 1
)

:: Comprobar si el script se está ejecutando como administrador
net session >nul 2>&1
if %errorLevel% neq 0 (
    echo Elevando privilegios...
    powershell -Command "Start-Process -Verb runAs -FilePath '%~f0' -WorkingDirectory '%CD%'"
    exit /b
)

:: Ejecutar el script Pythons
python "%SCRIPT_DIR%scripts\installer-windows.py"

pause
