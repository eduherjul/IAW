```css
/* General */
body {
  font-family: "Arial", sans-serif;
  margin: 0;
  padding: 0;
  background-color: #e3f2fd; /* Fondo azul claro */
  color: #333;
}

/* Encabezado */
h1 {
  text-align: center;
  color: #0d47a1; /* Azul oscuro */
  margin-top: 20px;
  font-size: 2.5em;
}

/* Contenedor del formulario */
form {
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  background-color: #ffffff;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  border-radius: 8px;
  text-align: center;
}

/* Etiqueta del formulario */
form label {
  font-size: 1.2em;
  color: #555;
  display: block;
  margin-bottom: 10px;
  text-align: left;
}

/* Campo de entrada */
input[type="text"] {
  width: calc(100% - 20px);
  padding: 10px;
  font-size: 1em;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
}

/* Botón */
button {
  background-color: #0d47a1; /* Azul oscuro */
  color: #fff;
  border: none;
  padding: 10px 20px;
  font-size: 1em;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s, transform 0.2s;
}

button:hover {
  background-color: #1565c0; /* Azul más claro */
  transform: scale(1.05);
}

/* Ajustes responsivos */
@media (max-width: 600px) {
  h1 {
    font-size: 2em;
  }

  form {
    margin: 20px;
    padding: 15px;
  }

  input[type="text"] {
    font-size: 0.9em;
  }

  button {
    width: 100%;
  }
}
```
