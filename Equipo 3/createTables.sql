USE bbdd
CREATE TABLE Mensajes (
    -- emisor
    ipE varchar(15) NOT NULL,
    cont integer NOT NULL, -- contador
    idE int UNSIGNED,
    tipoE varchar,
    -- receptor
    ipR varchar(15) NOT NULL,
    idR int UNSIGNED NOT NULL,
    tipoR varchar,

    protocolo varchar,
    tipoM varchar, -- tipo de mensaje
    detalles varchar,
    PRIMARY KEY (ipE, cont)
);

CREATE TABLE Productos (
    idP int UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre varchar,
    -- precio base del producto (precio minimo)
    precio float NOT NULL,
    PRIMARY KEY (idP)
);

CREATE TABLE Tiendas (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre varchar,
    ip varchar(15) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE Compradores (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre varchar,
    ip varchar(15) NOT NULL,
    tienda1 int UNSIGNED NOT NULL,
    tienda2 int UNSIGNED,
    PRIMARY KEY (id)
);

CREATE TABLE Prod_Tienda (
    idP int UNSIGNED NOT NULL,
    idT int UNSIGNED NOT NULL,
    cant int UNSIGNED NOT NULL,
    -- precio de la tienda para este producto (por unidad)
    -- precio float NOT NULL,
    PRIMARY KEY (idP, idT),
    FOREIGN KEY (idP) REFERENCES Productos(idP),
    FOREIGN KEY (idT) REFERENCES Tiendas(idT)
);

CREATE TABLE Prod_Comprador (
    idP int UNSIGNED NOT NULL,
    idC int UNSIGNED NOT NULL,
    cant int UNSIGNED NOT NULL,
    PRIMARY KEY (idP, idC),
    FOREIGN KEY (idC) REFERENCES Compradores(idC)
);