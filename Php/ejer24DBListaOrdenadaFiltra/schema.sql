-- Renglones de órdenes de compra (tablas según tablasACrear.pdf)
-- Ejecutar en phpMyAdmin sobre la base u525388577_PROAR_Rlozano
-- ATENCIÓN: borra las tablas anteriores del ejercicio (y sus datos) antes de recrearlas.

DROP TABLE IF EXISTS renglones_orden_compra; -- primero la que tiene la FK
DROP TABLE IF EXISTS unidades_medida;

-- Tabla auxiliar: puebla el desplegable de unidad de medida
CREATE TABLE unidades_medida (
    cod_unidad  VARCHAR(5)  NOT NULL PRIMARY KEY,
    descripcion VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO unidades_medida (cod_unidad, descripcion) VALUES
    ('KG',  'Kilogramo'),
    ('UNI', 'Unidad'),
    ('LAT', 'Lata'),
    ('CAJ', 'Caja'),
    ('LT',  'Litro');

-- Tabla principal: renglones de órdenes de compra
CREATE TABLE renglones_orden_compra (
    id               INT AUTO_INCREMENT PRIMARY KEY,   -- a) clave primaria autonumérica
    nro_orden        VARCHAR(20)  NOT NULL,            -- b) identificador de registro
    codigo_producto  VARCHAR(20)  NOT NULL,
    descripcion      VARCHAR(100) NOT NULL,            -- c) campo descriptivo
    cod_unidad       VARCHAR(5)   NOT NULL,            -- d) desplegable (clave foránea)
    cantidad         DOUBLE       NOT NULL,            -- e) reales para operar
    precio_unitario  DOUBLE       NOT NULL,
    importe_renglon  DOUBLE GENERATED ALWAYS AS (cantidad * precio_unitario) STORED,
    fecha_orden      DATE         NOT NULL,            -- f) fecha
    pdf_comprobante  LONGBLOB     NULL,                -- g) binario: pdf o imagen de la orden
    CONSTRAINT fk_renglon_unidad FOREIGN KEY (cod_unidad)
        REFERENCES unidades_medida (cod_unidad)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Datos de prueba (pdf_comprobante queda NULL: el binario se carga desde el ABM, ejercicio 26)
INSERT INTO renglones_orden_compra
    (nro_orden, codigo_producto, descripcion, cantidad, cod_unidad, precio_unitario, fecha_orden) VALUES
    ('OC-1001', 'P-001', 'Harina 000',            50, 'KG',  1200.00, '2026-03-10'),
    ('OC-1001', 'P-002', 'Aceite de girasol',     20, 'LT',  2500.00, '2026-03-10'),
    ('OC-1002', 'P-010', 'Atún al natural',      120, 'LAT', 1800.50, '2026-04-02'),
    ('OC-1002', 'P-011', 'Tomate triturado',      60, 'LAT',  950.00, '2026-04-02'),
    ('OC-1003', 'P-020', 'Galletitas surtidas',   40, 'CAJ', 7500.00, '2026-05-15'),
    ('OC-1003', 'P-021', 'Servilletas de papel', 100, 'UNI',  300.00, '2026-05-15'),
    ('OC-1004', 'P-030', 'Azúcar',                80, 'KG',  1100.00, '2026-06-20');

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    idUsuario         INT AUTO_INCREMENT PRIMARY KEY,
    login             VARCHAR(50) NOT NULL UNIQUE,
    apellido          VARCHAR(50) NOT NULL,
    nombres           VARCHAR(50) NOT NULL,
    password          VARCHAR(64) NOT NULL,            -- SHA-256 en hexadecimal = 64 caracteres
    contador_sesiones INT         NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Usuario de prueba (el hash debe coincidir con el que genere el PHP: hash('sha256', ...))
INSERT INTO usuarios (login, apellido, nombres, password)
VALUES ('rlozano', 'Lozano', 'Ricardo', SHA2('cambiame', 256));
