import os
import shutil
import subprocess
import sys

import ctypes
import sys

def is_admin():
    try:
        return ctypes.windll.shell32.IsUserAnAdmin()
    except:
        return False

if not is_admin():
    ctypes.windll.shell32.ShellExecuteW(None, "runas", sys.executable, " ".join(sys.argv), None, 1)
    sys.exit()

# Rutas
script_dir = os.path.dirname(os.path.abspath(__file__))

# Construimos la ruta absoluta a "../codigo" desde la ubicación del script
path_codigo = os.path.abspath(os.path.join(script_dir, "../../codigo"))
path_destino = "C:/xampp/htdocs/prohive"

# 1. Crear el directorio de destino si no existe
os.makedirs(path_destino, exist_ok=True)

# 2. Copiar los archivos
for item in os.listdir(path_codigo):
    src_path = os.path.join(path_codigo, item)
    dest_path = os.path.join(path_destino, item)
    if os.path.isdir(src_path):
        shutil.copytree(src_path, dest_path, dirs_exist_ok=True)
    else:
        shutil.copy2(src_path, dest_path)

# 3. Añadir dominio local a /etc/hosts
contenidoHosts = "127.0.0.1 proyecto.local\n"
with open(r"C:\Windows\System32\drivers\etc\hosts","r+") as f:
    content = f.read()
    if "proyecto.local" not in content:
        f.seek(0, 2)
        f.write(contenidoHosts)

# 4. Añadir VirtualHost si no existe
archivoVhosts = "C:/xampp/apache/conf/extra/httpd-vhosts.conf"
vhost_block = '''<VirtualHost *:80>
\tDocumentRoot "C:/xampp/htdocs/prohive"
\tServerName proyecto.local
\t<Directory "C:/xampp/htdocs/prohive">
\t    AllowOverride All
\t    Require all granted
\t</Directory>
</VirtualHost>\n'''

with open(archivoVhosts, "r+") as f:
    content = f.read()
    if "ServerName proyecto.local" not in content:
        f.seek(0, 2)
        f.write(vhost_block)

# 5. Incluir archivo de vhosts en httpd.conf
httpd_conf = "C:/xampp/apache/conf/httpd.conf"
include_line = "Include C:/xampp/apache/conf/extra/httpd-vhosts.conf\n"

with open(httpd_conf, "r+") as f:
    content = f.read()
    if include_line.strip() not in content:
        f.seek(0, 2)
        f.write("\n" + include_line)

print("Instalación completada. Por favor, reinicia XAMPP para aplicar los cambios.")

