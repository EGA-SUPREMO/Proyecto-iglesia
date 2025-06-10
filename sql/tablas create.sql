-- CREATE USER 'test'@'localhost' IDENTIFIED BY '1234';
-- GRANT ALL PRIVILEGES ON *.* TO 'test'@'localhost' WITH GRANT OPTION;
-- FLUSH PRIVILEGES;


CREATE DATABASE registro_pagos;
USE registro_pagos;

CREATE TABLE feligreses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    cedula INT UNSIGNED UNIQUE
);
CREATE TABLE servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT
);
CREATE TABLE metodos_pago (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50)
);
CREATE TABLE peticiones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    feligres_id INT,
    servicio_id INT,
    descripcion TEXT,
    fecha_registro DATE,       -- Fecha en que se guarda la petición
    fecha_inicio DATE,         -- Fecha de inicio del servicio
    fecha_fin DATE,            -- Fecha de fin del servicio (si es un solo día, será igual a fecha_inicio)
    FOREIGN KEY (feligres_id) REFERENCES feligreses(id),
    FOREIGN KEY (servicio_id) REFERENCES servicios(id)
);
CREATE TABLE pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    peticion_id INT,
    feligres_id INT,
    metodo_pago_id INT,
    monto_usd DECIMAL(10,2),
    referencia_pago VARCHAR(100),
    fecha_pago DATE,
    FOREIGN KEY (peticion_id) REFERENCES peticiones(id),
    FOREIGN KEY (feligres_id) REFERENCES feligreses(id),
    FOREIGN KEY (metodo_pago_id) REFERENCES metodos_pago(id)
);


-- ----------------------------------------------------------------------------------------------
-- DATOS DE PRUEBA
-- Insertar 15 feligreses
INSERT INTO feligreses (nombre, cedula) VALUES
('Ana Pérez', 12345678),
('Carlos Rodríguez', 23456789),
('María Gómez', 34567890),
('José Martínez', 45678901),
('Luisa Fernández', 56789012),
('Pedro Suárez', 67890123),
('Andrea Ramírez', 78901234),
('Miguel Torres', 89012345),
('Carmen Díaz', 90123456),
('Luis Romero', 11223344),
('Paola Mendoza', 22334455),
('Jorge Silva', 33445566),
('Claudia Rivas', 44556677),
('Santiago Herrera', 55667788),
('Isabel Moreno', 66778899);

INSERT INTO metodos_pago (nombre) VALUES
('Pago móvil'),
('Punto de venta'),
('Efectivo USD'),
('Efectivo BS');

INSERT INTO servicios (nombre, descripcion) VALUES
('Misas', 'Celebración eucarística ofrecida por diferentes intenciones.'),
('Bautizos', 'Sacramento de iniciación cristiana para niños o adultos.'),
('Matrimonio', 'Celebración del sacramento del matrimonio católico.'),
('Exp. Matrimonial', 'Expediente matrimonial: proceso previo a la boda que incluye entrevistas, presentación de documentos y comprobación de libertad para casarse.'),
('Exequias', 'Ritos funerarios: misa y oraciones ofrecidas por un difunto.'),
('Documentos Parroquiales', 'Tramitación de constancias, partidas o certificados emitidos por la parroquia.');

-- Insertar 30 peticiones
INSERT INTO peticiones (feligres_id, servicio_id, descripcion, fecha_registro, fecha_inicio, fecha_fin) VALUES
(1, 1, 'Misa por salud', '2025-05-01', '2025-05-10', '2025-05-10'),
(2, 2, 'Bautizo de hijo', '2025-05-02', '2025-05-15', '2025-05-15'),
(3, 3, 'Matrimonio de pareja', '2025-05-03', '2025-06-01', '2025-06-01'),
(4, 4, 'Expediente matrimonial para boda', '2025-05-04', '2025-05-20', '2025-05-25'),
(5, 5, 'Exequias para familiar', '2025-05-05', '2025-05-06', '2025-05-06'),
(6, 6, 'Solicitud de partida de bautismo', '2025-05-06', '2025-05-06', '2025-05-06'),
(7, 1, 'Misa por acción de gracias', '2025-05-07', '2025-05-12', '2025-05-12'),
(8, 2, 'Bautizo de sobrino', '2025-05-08', '2025-05-18', '2025-05-18'),
(9, 3, 'Preparación para matrimonio', '2025-05-09', '2025-06-10', '2025-06-10'),
(10, 4, 'Documentación previa al matrimonio', '2025-05-10', '2025-05-21', '2025-05-26'),
(11, 5, 'Misa funeral', '2025-05-11', '2025-05-13', '2025-05-13'),
(12, 6, 'Solicitud de constancia', '2025-05-12', '2025-05-12', '2025-05-12'),
(13, 1, 'Misa dominical', '2025-05-13', '2025-05-17', '2025-05-17'),
(14, 2, 'Bautizo de niña', '2025-05-14', '2025-05-22', '2025-05-22'),
(15, 3, 'Matrimonio civil-religioso', '2025-05-15', '2025-06-15', '2025-06-15'),
(1, 4, 'Entrevista prematrimonial', '2025-05-16', '2025-05-23', '2025-05-27'),
(2, 5, 'Oración por difunto', '2025-05-17', '2025-05-19', '2025-05-19'),
(3, 6, 'Certificación de confirmación', '2025-05-18', '2025-05-18', '2025-05-18'),
(4, 1, 'Misa por cumpleaños', '2025-05-19', '2025-05-24', '2025-05-24'),
(5, 2, 'Bautizo en familia', '2025-05-20', '2025-05-29', '2025-05-29'),
(6, 3, 'Celebración matrimonial', '2025-05-21', '2025-06-05', '2025-06-05'),
(7, 4, 'Exp. Matrimonial para boda civil', '2025-05-22', '2025-05-28', '2025-05-30'),
(8, 5, 'Funeral de tía', '2025-05-23', '2025-05-25', '2025-05-25'),
(9, 6, 'Documento parroquial requerido', '2025-05-24', '2025-05-24', '2025-05-24'),
(10, 1, 'Misa por intención personal', '2025-05-25', '2025-05-31', '2025-05-31'),
(11, 2, 'Bautizo múltiple', '2025-05-26', '2025-06-03', '2025-06-03'),
(12, 3, 'Boda planificada', '2025-05-27', '2025-06-12', '2025-06-12'),
(13, 4, 'Exp. Matrimonial requerido', '2025-05-28', '2025-06-01', '2025-06-03'),
(14, 5, 'Servicio funerario', '2025-05-29', '2025-06-04', '2025-06-04'),
(15, 6, 'Partida de matrimonio', '2025-05-30', '2025-05-30', '2025-05-30');

-- Insertar 45 pagos (3 por cada 2 feligreses/peticiones aprox)
INSERT INTO pagos (peticion_id, feligres_id, metodo_pago_id, monto_usd, referencia_pago, fecha_pago) VALUES
(1, 1, 1, 10.00, 'PMV001', '2025-05-02'),
(2, 2, 2, 20.00, 'PTV001', '2025-05-03'),
(3, 3, 3, 30.00, 'USD001', '2025-05-04'),
(4, 4, 4, 40.00, 'BS001', '2025-05-05'),
(5, 5, 1, 25.00, 'PMV002', '2025-05-06'),
(6, 6, 2, 15.00, 'PTV002', '2025-05-07'),
(7, 7, 3, 35.00, 'USD002', '2025-05-08'),
(8, 8, 4, 10.00, 'BS002', '2025-05-09'),
(9, 9, 1, 12.00, 'PMV003', '2025-05-10'),
(10, 10, 2, 22.00, 'PTV003', '2025-05-11'),
(11, 11, 3, 32.00, 'USD003', '2025-05-12'),
(12, 12, 4, 42.00, 'BS003', '2025-05-13'),
(13, 13, 1, 18.00, 'PMV004', '2025-05-14'),
(14, 14, 2, 28.00, 'PTV004', '2025-05-15'),
(15, 15, 3, 38.00, 'USD004', '2025-05-16'),
(16, 1, 4, 48.00, 'BS004', '2025-05-17'),
(17, 2, 1, 20.00, 'PMV005', '2025-05-18'),
(18, 3, 2, 30.00, 'PTV005', '2025-05-19'),
(19, 4, 3, 40.00, 'USD005', '2025-05-20'),
(20, 5, 4, 50.00, 'BS005', '2025-05-21'),
(21, 6, 1, 60.00, 'PMV006', '2025-05-22'),
(22, 7, 2, 70.00, 'PTV006', '2025-05-23'),
(23, 8, 3, 80.00, 'USD006', '2025-05-24'),
(24, 9, 4, 90.00, 'BS006', '2025-05-25'),
(25, 10, 1, 12.50, 'PMV007', '2025-05-26'),
(26, 11, 2, 17.75, 'PTV007', '2025-05-27'),
(27, 12, 3, 22.00, 'USD007', '2025-05-28'),
(28, 13, 4, 33.33, 'BS007', '2025-05-29'),
(29, 14, 1, 11.11, 'PMV008', '2025-05-30'),
(30, 15, 2, 19.99, 'PTV008', '2025-05-31'),
(16, 1, 3, 23.45, 'USD008', '2025-06-01'),
(17, 2, 4, 34.56, 'BS008', '2025-06-02'),
(18, 3, 1, 45.67, 'PMV009', '2025-06-03'),
(19, 4, 2, 56.78, 'PTV009', '2025-06-04'),
(20, 5, 3, 67.89, 'USD009', '2025-06-05'),
(21, 6, 4, 78.90, 'BS009', '2025-06-06'),
(22, 7, 1, 20.00, 'PMV010', '2025-06-07'),
(23, 8, 2, 25.00, 'PTV010', '2025-06-08'),
(24, 9, 3, 30.00, 'USD010', '2025-06-09'),
(25, 10, 4, 35.00, 'BS010', '2025-06-10'),
(26, 11, 1, 40.00, 'PMV011', '2025-06-11'),
(27, 12, 2, 45.00, 'PTV011', '2025-06-12'),
(28, 13, 3, 50.00, 'USD011', '2025-06-13'),
(29, 14, 4, 55.00, 'BS011', '2025-06-14'),
(30, 15, 1, 60.00, 'PMV012', '2025-06-15');
