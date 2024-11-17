#!/bin/bash

#Script para configurar una BBDD de mysql para Wordpress en un servidor aparte (nivel 2)

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
#Instalación MySQL
sudo apt install mysql-server -y

clear

#Cambiamos la contraseña del usuario root de mysql-server
passwdmysqlroot=$(dialog --title "Contraseña inicial para root en mysql" \
  --stdout \
  --inputbox "Password (8 carac.mayus-minus-núm-signo)" 0 50)
#Llamo a la funcion:
acabar

sqlcomandos="alter user 'root'@'localhost' identified with caching_sha2_password by '$passwdmysqlroot';
flush privileges;"

#Ejecutamos los comandos SQL en mysql
sudo mysql -u root -e "$sqlcomandos"

#Creamos una BBDD para Wordpress y un nuevo usuario con contraseña en mysql-server tambien para Wordpress
nombase=$(dialog --title "Creamos BBDD para Wordpress" \
  --stdout \
  --inputbox "Nombre" 0 0)
#Llamo a la funcion:
acabar

nomuser=$(dialog --title "Creamos el usuario" \
  --stdout \
  --inputbox "Nombre" 0 0)
#Llamo a la funcion:
acabarEdu

passuser=$(dialog --title "Contraseña para el nuevo usuario de Wordpress" \
  --stdout \
  --inputbox "Password (8 carac.mayus-minus-núm-signo)" 0 50)
#Llamo a la funcion:
acabar
clear

#Ahora creamos una BBDD y un nuevo usuario para Wordpress
sqlcomandosphp="create database $nombase; 
create user '$nomuser'@'%' identified with caching_sha2_password by '$passuser';
GRANT ALL PRIVILEGES ON *.* TO '$nomuser'@'%';
flush privileges;"

#Ejecutamos los comandos SQL en mysql
sudo mysql -u root -p "$passwdmysqlroot" -e "$sqlcomandosphp"

#Permitir conexiones remotas habilitando el acceso a Mysql
sudo sed -i "31s/.*/bind-address            = 0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf
sudo systemctl restart mysql.service

#abrir el puerto de Mysql (3306) en el firewallwpedu
sudo ufw enable
sudo ufw allow 3306
sudo ufw status

exit 0