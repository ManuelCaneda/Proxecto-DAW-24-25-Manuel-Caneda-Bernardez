import os
import shutil
import subprocess
import sys

# Reintentar con sudo si no se ejecuta como root
if os.geteuid() != 0:
    print("Este script requiere privilegios de superusuario. Reintentando con sudo...")
    os.execvp("sudo", ["sudo"] + [sys.executable] + sys.argv)

# Rutas
script_dir = os.path.dirname(os.path.abspath(__file__))

# Construimos la ruta absoluta a "../codigo" desde la ubicación del script
path_codigo = os.path.abspath(os.path.join(script_dir, "../../codigo"))
path_destino = "/opt/lampp/htdocs/prohive"

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
with open("/etc/hosts", "r+") as f:
    content = f.read()
    if "proyecto.local" not in content:
        f.write(contenidoHosts)

# 4. Añadir VirtualHost si no existe
archivoVhosts = "/opt/lampp/etc/extra/httpd-vhosts.conf"
vhost_block = '''<VirtualHost *:80>
\tDocumentRoot "/opt/lampp/htdocs/prohive"
\tServerName proyecto.local
\t<Directory "/opt/lampp/htdocs/prohive">
\t    AllowOverride All
\t    Require all granted
\t</Directory>
</VirtualHost>\n'''

with open(archivoVhosts, "r+") as f:
    if "ServerName proyecto.local" not in f.read():
        f.write(vhost_block)

# 5. Incluir archivo de vhosts en httpd.conf
httpd_conf = "/opt/lampp/etc/httpd.conf"
include_line = "Include etc/extra/httpd-vhosts.conf\n"

with open(httpd_conf, "r+") as f:
    if "Include etc/extra/httpd-vhosts.conf" not in f.read():
        f.write("\n" + include_line)

# 6. Reiniciar XAMPP
subprocess.run(["/opt/lampp/lampp", "restart"])
