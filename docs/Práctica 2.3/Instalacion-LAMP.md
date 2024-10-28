```bash


#!/bin/bash

#############################################
echo "Script para automatizar la instalación de LAMP para Debian/Ubuntu o derivados"
echo "Apache"
echo "MySQL"
echo "PHP"

#############################################
#Actualización de sistema####################

echo "Actualizando el sistema.."
sudo apt update -y && sudo apt dist-upgrade -y && sudo apt autoremove -y
#Instalación de Apache#######################

echo "Instalando apache.."
sudo apt install apache2 -y
#Instalación de PHP##########################

echo "Instalando PHP.."
sudo apt install php libapache2-mod-php php-mysql -y
sudo apt install php-cli php-cgi php-mysql php-pgsql -y

#Instalación MySQL###########################

echo "Instalando MySQL-server.."
sudo apt install mysql-server -y

#Reinicio del servicio apache y comprobación del estado##############

echo "Reiniciando apache.."
sudo systemctl restart apache2.service
sudo systemctl --no-pager status apache2.service
sudo ufw enable
sudo ufw allow in "Apache Full"
sudo ufw allow 22
sudo ufw status

echo "--------------AUTOR  EDU-----------------"
exit 0

```