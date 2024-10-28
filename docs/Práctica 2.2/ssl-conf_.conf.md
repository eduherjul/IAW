```bash

#!/bin/bash

#Script para configurar un nuevo archivo en /etc/apache2/sites-available/xxx-ssl.conf
#Script para configurar un nuevo archivo en /etc/apache2/sites-available/xxx.conf

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

#Configurar ssl.conf
dialog --title "SSL/TSL" \
  --yesno "¿Quieres crear un archivo de configuración HTTPS?" 0 0
sino=$?

if [ "$sino" -eq 0 ]; then

  #Introducimos el nombre del fichero ssl.conf
  nomssl=$(dialog --title "Configuramos un nuevo /etc/apache2/sites-available/xxx-ssl.conf" \
    --stdout \
    --inputbox "Nombre del archivo" 0 0)
  #Llamo a la función:
  acabar

  #configuramos un nuevo ssl.conf
  echo "<IfModule mod_ssl.c>
        <VirtualHost *:443>
                #ServerName practica-https.local
                DocumentRoot /var/www/html
                DirectoryIndex index.php index.html
                ErrorLog ${APACHE_LOG_DIR}/error.log
                CustomLog ${APACHE_LOG_DIR}/access.log combined
                SSLEngine on
                SSLCertificateFile /etc/ssl/certs/apache-selfsigned.crt
                SSLCertificateKeyFile /etc/ssl/private/apache-selfsigned.key
        </VirtualHost>
</IfModule>" | sudo tee /etc/apache2/sites-available/"$nomssl"-ssl.conf

  #Habilitamos el virtual host que acabamos de configurar.
  sudo a2ensite "$nomssl"-ssl.conf

  #Habilitamos el módulo SSL en Apache.
  sudo a2enmod ssl

fi

#Configurar .conf
dialog --title "HTTP" \
  --yesno "¿Quieres crear un archivo de configuración HTTP?" 0 0
sino=$?

if [ "$sino" -eq 0 ]; then

  #Introducimos el nombre del fichero ssl.conf
  nomhttp=$(dialog --title "Configuramos un nuevo /etc/apache2/sites-available/xxx.conf" \
    --stdout \
    --inputbox "Nombre del archivo" 0 0)
  #Llamo a la función:
  acabar

  #configuramos un nuevo .conf
  echo "<VirtualHost *:80>
    #ServerName practica-https.local
    DocumentRoot /var/www/html
    #Redirige al puerto 443 (HTTPS)
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
    RewriteEngineOn
    RewriteCond%{HTTPS} off
    RewriteRule^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</VirtualHost>" | sudo tee /etc/apache2/sites-available/"$nomhttp".conf

  #Para que servidor web Apache pueda hacer redirección de HTTP a HTTPS habilitamos módulo rewrite (Apache).
  sudo a2enmod rewrite

  #Reiniciamos el servicio de Apache
  sudo systemctl restart apache2.service

  #Comprobamos:
  clear
  sudo systemctl status apache2.service
  read -p "ENTER para continuar"

fi

#Comprobar que el puerto 443 está abierto en las reglas del firewall para permitir el tráfico HTTPS.
dialog --title "En las reglas de Firewall (sudo ufw status)" \
  --msgbox "Comprobar que el puerto 443 está abierto para tráfico HTTPS" 5 60

clear
exit 0

```
