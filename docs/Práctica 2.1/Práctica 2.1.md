---
title: Práctica 2.1 - Implantación de una web estática con Apache en markdown
marp: true
paginate: true
---
<div style="text-align: center;">
     <h1>Práctica 2.1</h1>
</div>

---

<div style="text-align: center;">
    <h2>Implantación de una web estática con Apache</h2>
</div>

---

Vamos construir en nuestro servidor web apache dos sitios web con las siguientes características:

* El nombre de dominio del primero será `www.iaw2425.org`, su directorio base será /`home/yo/Documentos/iaw2424` y contendrá una página llamada `index.html`, donde sólo se verá una bienvenida a la página del módulo IAW.
Este sitio lo configuraremos para acceder a el desde el `puerto 3380`
* En el segundo sitio vamos a crear una página donde se pondrá la documentación del módulo, el nombre de este sitio será `www.docu-iaw2425.org`, y su directorio base será `/home/yo/Música/docu-iaw2425/site/`. En esta página se pondrá la documentación del módulo IAW generada con mkdocs.
Copiaremos sólo el contenido del directorio site de la documentación generada, ya que es contenido estático..
Este sitio lo configuraremos para acceder a él desde el `puerto 4480`

---

### 1.- Creamos los dos directorios de los sitios

![Crear dos directorios](img/1.png)

### 2.- Copiamos el fichero por defecto 000-default.conf para dos sitios virtuales

![Copiar los ficheros por defecto](img/2.png)

---

### 3.- Configuramos el sitio apache para el primer lugar

![Config.primer sitio](img/3.png)

### 4.- Verificamos la sintaxis

![Verificamos sintaxis](img/4.png)

### 5.- Creamos el contenido de la página de bienvenida del primer sitio

![Creamos index.html](img/6.png)

![Contenido index.html](img/5.png)

### Configuramos apache para escuchar por los puertos `3380` para el primer sitio y `4480` para el segundo sitio

![Configuramos puertos](img/7.png)

### 7.- Habilitamos y recargamos el primer sitio apache

![Habilitar y recargar](img/8.png)

### 8.- Creamos el contenido de la página de bienvenida del segundo sitio

`Copiamos la carpeta site desde la ubicación donde la tenemos a ~/Música/docu-iaw2425`

![Copiamos site](img/9.png)

![Comprobamos](img/10.png)

---

### 9.- Configuramos el sitio apache para el segundo lugar

![Config.segundo sitio](img/11.png)

### 10.- Verificamos la sintaxis

![Verificamos sintaxis](img/12.png)

### 11.- Habilitamos y recargamos el segundo sitio apache

![Habilitamos y recargamos](img/13.png)

### 12.- Agregamos estas líneas en el archivo /etc/hosts para las pruebas

![/etc/hosts](img/14.png)

### 13.- Asignar los permisos correctos para el usuario www-data

![Permisos www-data](img/15.png)

### 14.- Permisos adicionales

Al estar fuera del directorio `/var/www` en mi caso debo ajustar los permisos para que apache pueda acceder a ellos, por lo que daré además permisos a los directorios que apache necesita atravesar, por que sino me da error de permisos:

![Permisos atravesar](img/16.png)

### 15.- Abrimos el navegador y verificamos que los sitios funcionen

---

Para el primer sitio: <http://www.iaw2425.org:3380>

![Navegador-primer-sitio](img/17.png)

---

---

Para el segundo sitio: <http://www.docu-iaw2425.org:4480>

![Navegador-primer-sitio](img/18.png)

---
