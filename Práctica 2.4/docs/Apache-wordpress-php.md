```bash


#!/bin/bash

#Script para instalar y configurar Wordpress con Apache y PHP

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
sudo apt install ghostscript -y

#Instalación de PHP
echo "Instalando PHP.."
sudo apt install libapache2-mod-php \
  php \
  php-bcmath \
  php-curl \
  php-imagick \
  php-intl \
  php-json \
  php-mbstring \
  php-mysql \
  php-xml \
  php-zip -y

#Instalación Wordpress
cd /tmp || exit
wget https://wordpress.org/latest.tar.gz
tar -xzf latest.tar.gz
sudo mv wordpress /var/www/html/

#Reinicio del servicio apache y comprobación del estado
echo "Reiniciando apache.."
sudo systemctl restart apache2.service
sudo systemctl --no-pager status apache2.service
sudo ufw enable
sudo ufw allow in "Apache Full"
sudo ufw allow 22
sudo ufw allow 3306
sudo ufw status

#Cambiamos la propiedad y permisos de los archivos
sudo chown -R www-data:www-data /var/www/html/wordpress
sudo chmod -R 755 /var/www/html/wordpress

#Configurar WordPress para conectarse a la base de datos
cd /var/www/html/wordpress || exit

#copiamos el archivo de configuración
cp wp-config-sample.php wp-config.php

#Introducimos el nombre del usuario de la BBDD
nomuser=$(dialog --title "Usuario de la BBDD" \
  --stdout \
  --inputbox "Nombre" 0 0)
#Llamo a la funcion:
acabar

#Introducimos el password
passwd=$(dialog --title "Contraseña de acceso a la BBDD" \
  --stdout \
  --inputbox "Password" 0 0)
#Llamo a la funcion:
acabar

#Introducimos la IP del sevidor mysql de la BBDD
ipmysql=$(dialog --title "Servidor mysql de la BBDD " \
  --stdout \
  --inputbox "IP" 0 0)
#Llamo a la funcion:
acabar

#Establecemos las credenciales de la BBDDE en el archivo de configuración wp-config.php:
sudo -u www-data sed -i "23s/.*/DEFINE( 'DB_NAME', 'wordpress_db' )/" /var/www/html/wordpress/wp-config.php
sudo -u www-data sed -i "26s/.*/DEFINE( 'DB_USER', '$nomuser' )/" /var/www/html/wordpress/wp-config.php
sudo -u www-data sed -i "29s/.*/DEFINE( 'DB_PASSWORD', '$passwd' )/" /var/www/html/wordpress/wp-config.php
sudo -u www-data sed -i "32s/.*/DEFINE( 'DB_HOST', '$ipmysql' )/" /var/www/html/wordpress/wp-config.php

#creamos un archivo de configuración para el sitio de Wordpress en Apache
echo "<VirtualHost *:80>
        ServerAdmin admin@edu.com
        DocumentRoot /var/www/html/wordpress
        ServerName edu.com
        <Directory /var/www/html/wordpress>
            Options Indexes FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>" | sudo tee /etc/apache2/sites-available/wordpress.conf

#Habilitamos el nuevo sitio de WordPress y el módulo de reescritura de Apache:
sudo a2ensite wordpress.conf
sudo a2enmod rewrite

#Deshabilitamos el sitio predeterminado “It Works” con:
sudo a2dissite 000-default

#Reiniciamos Apache para aplicar los cambios:
sudo systemctl restart apache2.service

#Comprobamos el estado
sudo systemctl status apache2

exit 0

```