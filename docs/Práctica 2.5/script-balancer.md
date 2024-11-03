```bash

#!/bin/bash

#Script para configurar  y crear el balanceador de carga

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

#Habilitamos los módulos proxy en el servidor de balanceo de carga, reiniciamos el servicio, verificamos todos los módulos proxy
sudo a2enmod proxy
sudo a2enmod proxy_http
sudo a2enmod proxy_balancer
sudo a2enmod lbmethod_byrequests
sudo systemctl restart apache2.service
sudo apachectl -M | grep proxy

# Se crea un archivo de configuración de Apache para el balanceo de carga
#Deshabilitamos el sitio por defecto de Apache para evitar conflictos
cd /etc/apache2/sites-available || exit
sudo a2dissite 000-default.conf
sudo systemctl reload apache2.service

#Creamos un archivo de configuración de Apache para el balanceo de carga
nomconf=$(dialog --title "Fichero de configuración de Apache" \
  --stdout \
  --inputbox "Nombre (sin .conf)" 0 0)
#Llamo a la funcion:
acabar

#Introducimos el nombre del dominio para el balanceador
servername=$(dialog --title "ServerName" \
  --stdout \
  --inputbox "Nombre (ejem.pepe.aeo25.com)" 0 40)
#Llamo a la funcion:
acabar

#agregamos las configuraciones
echo "<VirtualHost *:80>
    ServerName $servername
    <Proxy balancer://webserver>" | sudo tee /etc/apache2/sites-available/"$nomconf".conf

#introducimos el número de servidores backend que vamos a utilizar
control=0
while [ "$control" -ne 10 ]; do
  numkbackend=$(dialog --title "Backend-cantidad" \
    --stdout \
    --inputbox "Cuantos vamos a utilizar" 0 40)
  #Llamo a la funcion:
  acabar

  #Comprobamos el mínimo
  if [ "$numkbackend" -lt 1 ]; then
    for i in $(seq 0 20 100); do
      sleep 1
      echo "$i" | dialog --gauge "Cantidad de backend errónea, volvemos a intentarlo" 0 0 0
    done
  else
    control=10
  fi
done
for ((i = 1; i <= "$numkbackend"; i++)); do

  #Introducimos el nombre del dominio para el backend X
  servername=$(dialog --title "ServerName para el backend $i " \
    --stdout \
    --inputbox "Nombre (ejem.pepe.aeo25.com)" 0 40)
  #Llamo a la funcion:
  acabar

  echo "        # servidor $i
        BalancerMember http://$servername
        #BalancerMember http://IP_HTTP_SERVER_1:80

        " | sudo tee -a /etc/apache2/sites-available/"$nomconf".conf

  #Introducimos la IP del backend
  ipbackend=$(dialog --title "Dirección backend $i " \
    --stdout \
    --inputbox "IP" 0 0)
  #Llamo a la funcion:
  acabar

  #En el balanceador, agregaremos las IP y los nombres de todos los servidores backend en el archivo /etc/hosts
  sudo sed -i "3i $ipbackend       $servername" /etc/hosts

done

echo "        ProxySet stickysession=ROUTEID
    </Proxy>
    ProxyPreserveHost On
    ProxyPass / balancer://webserver/
    ProxyPassReverse / balancer://webserver/
</VirtualHost>" | sudo tee -a /etc/apache2/sites-available/"$nomconf".conf

#Habilitamos y recargamos
sudo a2ensite "$nomconf".conf
sudo systemctl reload apache2.service

#Activamos el módulo proxy_balancer
sudo a2enmod proxy_balancer

#Para activar este método de balanceo tenemos que activar el módulo lbmethod_byrequests
sudo a2enmod lbmethod_byrequests

#Reiniciamos el servicio
sudo systemctl restart apache2.service

#Pondremos en el navegador la IP del servidor balanceador para verificar el Balanceo de carga con Apache
dialog --title "Pondremos en el navegador la IP del servidor balanceador" \
  --backtitle "Previamente configuraremos en el fichero /etc/hosts del navegador la IP y nombre de dominio del servidor balanceador" \
  --msgbox "Para verificar el Balanceo de carga con Apache" 0 0

clear
exit 0
```
