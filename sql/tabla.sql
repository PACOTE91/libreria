drop table if exists libros;
drop table if exists autores;

CREATE TABLE autores(
    id int AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    apellidos VARCHAR (100) NOT NULL,
    pais VARCHAR(80) NOT NULL
    );

CREATE TABLE libros(
id int AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    sinopsis TEXT NOT NULL,
    isbn VARCHAR(13) UNIQUE NOT NULL,
    autor_id int,
    CONSTRAINT fl_libro_autor FOREIGN KEY(autor_id) REFERENCES autores(id)
    ON DELETE CASCADE ON UPDATE CASCADE
    
);