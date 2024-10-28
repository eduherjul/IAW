---
title: Práctica 1.3 - Construir el sitio estático y desplegar en Git Pages
marp: true
paginate: true
---
<div style="text-align: center;">
     <h1>Práctica 1.3</h1>
</div>

---



# Construir el Sitio Estático

Ejecutamos el siguiente comando para construir todos los archivos necesarios para tu sitio web estático, que se guardarán en la carpeta site:

`mkdocs build`

Este comando genera una versión estática de tu sitio, lista para ser desplegada en GitHub Pages u otro servidor web.

## Desplegar en GitHub Pages

Para desplegar los archivos estáticos en GitHub Pages desde un repositorio de GitHub, seguiremos estos pasos:

* **Configurar GitHub Pages**

Nos aseguraremos de que GitHub Pages esté configurado para usar la rama gh-pages. Esta configuración es necesaria para que tu sitio web esté disponible en una URL pública. Para ello:

* **Navega a la pestaña Settings (Configuración).**
* **En el menú de la izquierda, selecciona Pages.**
* **En Source (Fuente), selecciona gh-pages como la rama y la carpeta docs.**
* **Guarda los cambios.**

![Imagen Github-Pages](img/GitHub-Pages)

Desplegar los en GitHub Pages
Usamos el siguiente comando para desplegar tu sitio:

`mkdocs gh-deploy`

Este comando construirá tu sitio y lo subirá a la rama gh-pages de tu repositorio de GitHub, haciendo que tu documentación esté disponible en <https://tu-usuario.github.io/user-guid>

Con estos pasos, tu documentación estará desplegada y accesible en GitHub Pages.

Cada vez que deseemos actualizar tu sitio en GitHub Pages con nuevos cambios, deberemos ejecutar mkdocs gh-deploy* manualmente. Esto asegura que los cambios en nuestra documentación local se reflejen en el sitio web desplegado