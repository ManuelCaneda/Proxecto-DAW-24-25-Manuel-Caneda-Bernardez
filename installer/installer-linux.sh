# Comprobar si python3 está instalado
if ! command -v python3 &> /dev/null
then
    echo "Python3 no está instalado. Instalando..."
    sudo apt-get update
    sudo apt-get install -y python3
fi

# Ejecutar el script con sudo
sudo python3 scripts/installer-linux.py