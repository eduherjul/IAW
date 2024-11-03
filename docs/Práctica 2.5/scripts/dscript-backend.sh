#!/bin/bash

#Script para configurar un backends en un sistema de balanceador de carga

#Instalación de dialog
sudo apt install dialog -y

#Función para capturar el código de retorno del diálogo
function acabar() {
  exit_status=$?
  # Verificar si se seleccionó "Cancelar"
  if [ $exit_status -ne 0 ]; then
    clear
    echo "Operación cancelada"
    exit 1
  fi
}

#Actualizamos el sistema
dialog --title "Actualización del sistema update-upgrade" \
  --yesno "¿Actualizamos?" 0 0
sino=$?
if [ $sino -eq 0 ]; then
  clear
  sudo apt update -y && sudo apt dist-upgrade -y && sudo apt autoremove -y
fi

clear
#Instalación de Apache
sudo apt install apache2 -y

#configuramos el firewall
sudo ufw enable
sudo ufw allow 22
sudo ufw allow 80

#Eliminamos la pagina por defecto (DocumentRoot) index.html
cd /var/www/html || exit
sudo rm -rf index.html

#Introducimos el nombre del fichero .html para la página de muestra
nompag=$(dialog --title "Página HTML de muestra" \
  --stdout \
  --inputbox "Nombre del fichero .html (sin poner .html)" 0 0)
#Llamo a la funcion:
acabar

#Introducimos el nombre del dominio para el backend
servername=$(dialog --title "ServerName" \
  --stdout \
  --inputbox "Nombre (ejem.pepe.aeo25.com)" 0 0)
#Llamo a la funcion:
acabar

#Introducimos el número que le asignamos al backend 1,2 3..
numkbackend=$(dialog --title "Backend" \
  --stdout \
  --inputbox "Número que le asignamos" 0 0)
#Llamo a la funcion:
acabar

clear

#Creamos páginas página HTML de muestra
echo "<html>
    <head><title>Backend $numkbackend</title></head>
    <body>
        <h1>Este es el servidor Backend $numkbackend</h1>
    </body>
</html>" | sudo tee /var/www/html/"$nompag".html

#Deshabilitamos el sitio por defecto de Apache para evitar conflictos
cd /etc/apache2/sites-available || exit
sudo a2dissite 000-default.conf
sudo systemctl reload apache2.service

#Creamos el archivo de configuración del host virtual
echo "<VirtualHost *:80>
    ServerName $servername
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html
    DirectoryIndex $nompag.html
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>" | sudo tee /etc/apache2/sites-available/"$nompag".conf

#Habilitamos y recargamos
sudo a2ensite "$nompag".conf | sudo systemctl reload apache2.service

exit 0