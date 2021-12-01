USE bbdd;
CREATE TABLE Mensajes (
    -- emisor
    ipE VARCHAR(15) NOT NULL,
    cont INT NOT NULL, -- contador
    idE INT UNSIGNED NOT NULL,
    tipoE ENUM('monitor','comprador','tienda'),
    -- receptor
    ipR VARCHAR(15) NOT NULL,
    idR INT UNSIGNED NOT NULL,
    tipoR ENUM('monitor','comprador','tienda'),

    protocolo ENUM('alta','inicioActividad','entradaTienda','compra','solicitarTiendas','salidaTienda','finalizacion'),
    tipoM ENUM('MSI','MCI','MEI','MAE','MSET','MSIP','MIP','MCP','MVP','MSIT','MIT','MSST','MFO','ACK','ERROR'), -- tipo de mensaje
    detalles TEXT,
    PRIMARY KEY (ipE, cont)
);

CREATE TABLE Productos (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50),
    -- precio base del producto (precio minimo)
    precio float NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE Tiendas (
    id INT UNSIGNED NOT NULL,
    nombre VARCHAR(50),
    ip VARCHAR(15) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE Compradores (
    id INT UNSIGNED NOT NULL,
    nombre VARCHAR(50),
    ip VARCHAR(15) NOT NULL,
    tienda1 INT UNSIGNED,
    tienda2 INT UNSIGNED,
    PRIMARY KEY (id)
);

CREATE TABLE Prod_Tienda (
    idP INT UNSIGNED NOT NULL,
    idT INT UNSIGNED NOT NULL,
    cant INT UNSIGNED NOT NULL,
    -- precio de la tienda para este producto (por unidad)
    -- precio float NOT NULL,
    PRIMARY KEY (idP, idT),
    FOREIGN KEY (idP) REFERENCES Productos(id),
    FOREIGN KEY (idT) REFERENCES Tiendas(id)
);

CREATE TABLE Prod_Comprador (
    idP INT UNSIGNED NOT NULL,
    idC INT UNSIGNED NOT NULL,
    cant INT UNSIGNED NOT NULL,
    PRIMARY KEY (idP, idC),
    FOREIGN KEY (idP) REFERENCES Productos(id),
    FOREIGN KEY (idC) REFERENCES Compradores(id)
);

CREATE TABLE MCIs (
    id INT UNSIGNED NOT NULL,
    mci TEXT,
    PRIMARY KEY (id)
);

CREATE TABLE Variables_Globales (
    NumeroFila INT,
    n_mensajes INT UNSIGNED,
    contT INT UNSIGNED,
    contC INT UNSIGNED,
    primary key (NumeroFila),
    check       (NumeroFila = 1)
);

INSERT INTO Variables_Globales VALUES (1,0,0,0);