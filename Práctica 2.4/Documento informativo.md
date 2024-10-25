# Práctica 4 Instalar y configurar Wordpress

## Configurar el Servidor 2 (Mysql)

### Actualizar el sistema e instalar Mysql

`sudo apt update && sudo apt upgrade -y`

### Instalar Mysql

`sudo apt install mysql-server`

### Acceder a Mysql como administrador `root`

`sudo mysql -u root`

### Crear la BBDD

`CREATE DATABASE wordpress_db;
   CREATE USER 'wp_user'@'%' IDENTIFIED BY 'tu_contraseña_segura';
   GRANT ALL PRIVILEGES ON wordpress_db.* TO 'wp_user'@'%';
   FLUSH PRIVILEGES;
   EXIT;`

### Permitiremos las conexiones remotas

`sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf`

Buscaremos la línea que contiene `bind-address` y la cambiaremos de `127.0.0.1` a `0.0.0.0` para permitir conexiones desde cualquier dirección IP.

### Reinciaremos Mysql

`sudo systemctl restart mysql`

### Abriremos el puerto Mysql (3306) en el firewall

`sudo ufw allow 3306`

