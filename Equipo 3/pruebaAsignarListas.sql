USE bbdd;

DROP TABLE IF EXISTS Prod_Comprador;

DROP TABLE IF EXISTS Prod_Tienda;

DROP TABLE IF EXISTS Compradores;

DROP TABLE IF EXISTS Tiendas;

DROP TABLE IF EXISTS Productos;

DROP TABLE IF EXISTS Mensajes;

DROP TABLE IF EXISTS MCIs;

DROP TABLE IF EXISTS Variables_Globales;


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
    active int not null,
    PRIMARY KEY (id)
);


CREATE TABLE Compradores (
    id INT UNSIGNED NOT NULL,
    nombre VARCHAR(50),
    ip VARCHAR(15) NOT NULL,
    tienda1 INT UNSIGNED,
    tienda2 INT UNSIGNED,
    active int not null,
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

INSERT INTO Tiendas VALUES (2,'t1','192.0.2.2',1);# 1 row affected.

INSERT INTO Tiendas VALUES (5,'t2','192.0.2.5',1);# 1 row affected.

INSERT INTO Compradores(id, nombre, ip, active) VALUES (1,'c1','192.0.2.1',1);# 1 row affected.

INSERT INTO Compradores(id, nombre, ip, active) VALUES (3,'c2','192.0.2.3', 1);# 1 row affected.

INSERT INTO Compradores(id, nombre, ip, active) VALUES (4,'c3','192.0.2.4', 1);# 1 row affected.

INSERT INTO Mensajes VALUES ('192.0.2.1',0,1,'comprador','192.0.2.10',0,'monitor','alta','MSI','');# 1 row affected.

INSERT INTO Mensajes VALUES ('192.0.2.2',0,2,'tienda','192.0.2.10',0,'monitor','alta','MSI','');# 1 row affected.

INSERT INTO Mensajes VALUES ('192.0.2.3',0,3,'comprador','192.0.2.10',0,'monitor','alta','MSI','');# 1 row affected.

INSERT INTO Mensajes VALUES ('192.0.2.4',0,4,'comprador','192.0.2.10',0,'monitor','alta','MSI','');# 1 row affected.

INSERT INTO Mensajes VALUES ('192.0.2.5',0,5,'tienda','192.0.2.10',0,'monitor','alta','MSI','');# 1 row affected.
INSERT INTO Variables_Globales VALUES (1,0,0,0);