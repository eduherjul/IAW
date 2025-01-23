```css
/* General */
body {
  font-family: "Arial", sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f4f4f9;
  color: #333;
}

/* Encabezado */
h1 {
  text-align: center;
  color: #4caf50;
  margin-top: 20px;
  font-size: 2.5em;
}

/* Contenedor del formulario */
form {
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  background-color: #fff;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  border-radius: 8px;
  text-align: center;
}

/* Texto dentro del formulario */
form p {
  font-size: 1.2em;
  color: #555;
  margin-bottom: 20px;
}

/* Botón */
button {
  background-color: #4caf50;
  color: #fff;
  border: none;
  padding: 10px 20px;
  font-size: 1em;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

button:hover {
  background-color: #45a049;
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

  button {
    width: 100%;
  }
}
```
