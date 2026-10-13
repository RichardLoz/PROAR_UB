-- Ejercicio 17: Renglones de órdenes de compra
-- Ejecutar en phpMyAdmin sobre la base u525388577_PROAR_Rlozano

CREATE TABLE IF NOT EXISTS unidades_medida (
    cod_unidad  VARCHAR(5)  NOT NULL PRIMARY KEY,
    descripcion VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO unidades_medida (cod_unidad, descripcion) VALUES
    ('KG',  'Kilogramo'),
    ('UNI', 'Unidad'),
    ('LAT', 'Lata'),
    ('CAJ', 'Caja'),
    ('LT',  'Litro');

CREATE TABLE IF NOT EXISTS renglones_orden_compra (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    nro_orden        INT           NOT NULL,
    codigo_producto  VARCHAR(20)   NOT NULL,
    descripcion      VARCHAR(100)  NOT NULL,
    cantidad         DECIMAL(10,2) NOT NULL,
    cod_unidad       VARCHAR(5)    NOT NULL,
    precio_unitario  DECIMAL(10,2) NOT NULL,
    importe_renglon  DECIMAL(12,2) GENERATED ALWAYS AS (cantidad * precio_unitario) STORED,
    pdf_imagen       VARCHAR(255)  NULL,
    FOREIGN KEY (cod_unidad) REFERENCES unidades_medida (cod_unidad)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO renglones_orden_compra
    (nro_orden, codigo_producto, descripcion, cantidad, cod_unidad, precio_unitario, pdf_imagen) VALUES
    (1001, 'P-001', 'Harina 000',            50, 'KG',  1200.00, 'img/P-001.jpg'),
    (1001, 'P-002', 'Aceite de girasol',     20, 'LT',  2500.00, 'img/P-002.jpg'),
    (1002, 'P-010', 'Atún al natural',      120, 'LAT', 1800.50, 'img/P-010.jpg'),
    (1002, 'P-011', 'Tomate triturado',      60, 'LAT',  950.00, 'img/P-011.jpg'),
    (1003, 'P-020', 'Galletitas surtidas',   40, 'CAJ', 7500.00, 'img/P-020.jpg'),
    (1003, 'P-021', 'Servilletas de papel', 100, 'UNI',  300.00, 'img/P-021.jpg'),
    (1004, 'P-030', 'Azúcar',                80, 'KG',  1100.00, NULL);
