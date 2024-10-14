#!/bin/bash

#Script para automatizar la instalación y configuración de PhpMyAdmin.

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

#Actualizamos la memoria caché del sistema
sudo apt update -y

#Instalamos estos paquetes
sudo apt install phpmyadmin php-mbstring php-zip php-gd php-json php-curl -y

#Cambiamos la contraseña del usuario root de mysql-server
passwdmysqlroot=$(dialog --title "Contraseña para root en mysql" \
    --stdout \
    --inputbox "Password (8 carac.mayus-minus-núm-signo)" 0 50)
  #Llamo a la funcion:
  acabar

sqlcomandos="alter user 'root'@'localhost' identified with caching_sha2_password by '$passwdmysqlroot';
flush privileges;"

#Ejecutamos los comandos SQL en mysql
sudo mysql -u root -e "$sqlcomandos"

#Habilitar la extensión PHP mbstring
echo "Activando extensiones de PHP..."
sudo phpenmod mbstring

#Reiniciamos Apache
sudo systemctl restart apache2

#Generamos un nuevo usuario y una contraseña en mysql-server para phpmyadmin
usuariophp=$(dialog --title "Nuevo usuario para mysql" \
    --stdout \
    --inputbox "Nombre" 0 0)
  #Llamo a la funcion:
  acabar

passwdmysqlphp=$(dialog --title "Contraseña para el nuevo usuario" \
    --stdout \
    --inputbox "Password (8 carac.mayus-minus-núm-signo)" 0 50)
  #Llamo a la funcion:
  acabar

#Ahora creamos un nuevo usuario para el acceso a phpmyadmin
sqlcomandosphp="create user '$usuariophp'@'localhost' identified with caching_sha2_password by '$passwdmysqlphp';
GRANT ALL PRIVILEGES ON *.* TO '$usuariophp'@'localhost';
flush privileges;"

#Ejecutamos los comandos SQL en mysql
sudo mysql -u root -p"$passwdmysqlroot" -e "$sqlcomandosphp"

#Habilitamos el uso de anulaciones del archivo .htaccess
#Agregamos la directiva "AllowOverride All" dentro de la sección "<Directory /usr/share/phpmyadmin>"​​​ del archivo de configuración.
sudo sed -i '7a\    AllowOverride All' /etc/apache2/conf-available/phpmyadmin.conf

#Habilitamos y reiniciamos apache
sudo a2enconf phpmyadmin
sudo systemctl restart apache2.service

#Habilitado el uso de .htaccess para la aplicación, debemos crear uno para implementar seguridad.
#El archivo lo crearemos dentro del directorio de la aplicación.
echo "AuthType Basic
AuthName \"Restricted Files\"
AuthUserFile /etc/phpmyadmin/.htpasswd
Require valid-user" | sudo tee /usr/share/phpmyadmin/.htaccess

#La ubicación que hemos seleccionado para el archivo de contraseña es /etc/phpmyadmin/.htpasswd. 
#Ahora podemos crear este archivo y pasarle un usuario inicial con la utilidad htpasswd:
usuario=$(dialog --title "Datos para el archivo .htpasswd" \
    --stdout \
    --inputbox "Nombre del usuario" 0 0)
  #Llamo a la funcion:
  acabar

#Aseguramos la instancia de phpMyAdmin y reiniciamos
sudo htpasswd -c /etc/phpmyadmin/.htpasswd "$usuario"
sudo systemctl restart apache2.service

#Accedemos a la interfaz web  (navegador):
#Visitando la dirección IP pública de nuestro servidor, con /phpmyadmin agregado al final.
ip=$(hostname -I)
dialog --title "Usuario de la cuenta y la contraseña adicional que hemos configurado" \
  --backtitle "En el acceso a phpMyAdmin, nos solicitará:"\
  --msgbox "En nuestro navegador pondremos todo seguido: $ip/phphmyadmin" 0 50
clear
exit 0