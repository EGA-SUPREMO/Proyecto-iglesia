-- COMANDO A EJECUTAR: cat gestion_parroquial_db.sql dummy_data_otros.sql dummy_data_feligres.sql dummy_data_objetos_peticion.sql | mysql
 
USE gestion_parroquial_db;

INSERT INTO `feligreses` (`id`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `fecha_nacimiento`, `cedula`) VALUES
(1, 'Maria', 'Josefa', 'Garcia', 'Perez', '1980-03-15', 12345678),
(2, 'Juan', 'Carlos', 'Rodriguez', 'Lopez', '1975-11-20', 98765432),
(3, 'Ana', NULL, 'Martinez', 'Sanchez', '1992-07-01', 11223344),
(4, 'Pedro', 'Antonio', 'Fernandez', NULL, '1968-01-25', 22334455),
(5, 'Sofia', 'Isabel', 'Gomez', 'Diaz', '2005-09-10', 33445566),
(6, 'Luis', 'Alberto', 'Ramirez', 'Vargas', '1999-04-30', 44556677),
(7, 'Elena', NULL, 'Morales', 'Reyes', '2010-06-05', 55667788),
(8, 'Carlos', 'Andres', 'Acosta', 'Soto', '1972-12-12', 66778899);

INSERT INTO `feligreses` (`id`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `fecha_nacimiento`, `cedula`) VALUES
(9, 'Ricardo', 'Daniel', 'Silva', 'Castro', '1985-02-28', 77889900),
(10, 'Julia', 'Marina', 'Ortega', 'Guerrero', '1995-12-03', 88990011),
(11, 'Pablo', NULL, 'Gimenez', 'Molina', '2001-08-14', 99001122),
(12, 'Patricia', 'Andrea', 'Herrera', 'Fuentes', '1979-05-22', 10112233),
(13, 'Jorge', 'Sebastian', 'Perez', NULL, '1965-09-07', 20223344),
(14, 'Isabel', 'Lucia', 'Ramos', 'Navarro', '2008-01-19', 30334455),
(15, 'Andres', NULL, 'Diaz', 'Soto', '1990-03-25', 40445566),
(16, 'Juliana', 'Marina', 'Ortega', 'Guerrero', '1995-12-03', 8899001),
(17, 'Pablo', NULL, 'Gimenez', 'Molina', '2001-08-14', 9001122),
(18, 'Patricia', 'Andrea', 'Herrera', 'Fuentes', '1979-05-22', 112233),
(19, 'Jorge', 'Sebastian', 'Perez', NULL, '1965-09-07', 223344),
(20, 'Isabel', 'Lucia', 'Ramos', 'Navarro', '2008-01-19', 334455),
(21, 'Andres', NULL, 'Diaz', 'Soto', '1990-03-25', 445566),
(22, 'Laura', 'Sofia', 'Vega', 'Muñoz', '1982-10-10', 556677);

--
## Dummy Data for `parentescos`

INSERT INTO `parentescos` (`id_padre`, `id_hijo`) VALUES
(1, 5),
(2, 5),
(4, 3),
(8, 6),
(1, 7);

INSERT INTO `objetos_de_peticion` (`id`, `nombre`) VALUES
(1, 'San Pedro'),
(2, 'Santa María'),
(3, 'San José'),
(4, 'San Pablo'),
(5, 'San Francisco de Asís'),
(6, 'Santa Teresa de Calcuta'),
(7, 'San Juan Pablo II'),
(8, 'Santa Clara de Asís'),
(9, 'San Agustín de Hipona'),
(10, 'San Antonio de Padua');

INSERT INTO `sacerdotes` (`id`, `nombre`, `vivo`) VALUES
(1, 'Juan Pérez', TRUE),
(2, 'José García', TRUE),
(3, 'Miguel Torres', TRUE),
(4, 'Francisco Gómez', FALSE),
(5, 'Carlos López', TRUE),
(6, 'Luis Fernández', FALSE),
(7, 'Javier Ruiz', TRUE),
(8, 'Antonio Martín', TRUE),
(9, 'David Herrera', TRUE),
(10, 'Ricardo Castillo', TRUE),
(11, 'Máximo Tovar', TRUE);



INSERT INTO `constancia_de_fe_de_bautizo` (`id`, `fecha_bautizo`, `feligres_bautizado_id`, `padre_id`, `madre_id`, `padrino_nombre`, `madrina_nombre`, `observaciones`, `ministro_id`, `ministro_certifica_id`, `numero_libro`, `numero_pagina`, `numero_marginal`) VALUES
(1, '2023-01-15', 1, 4, 5, "Jose", "Josefina", 'Bautizado en la parroquia principal.', 1, 1, 1, 10, 5),
(2, '2022-05-20', 2, 8, 9, "padrino", "madriana", NULL, 2, 8, 2, 15, 8),
(3, '2024-03-10', 3, 4, 10, "Mariano", "Mariana", NULL, 3, 5, 3, 20, 12);

INSERT INTO `constancia_de_comunion` (`id`, `feligres_id`, `fecha_comunion`) VALUES
(1, 1, '2024-05-01'),
(2, 2, '2023-06-15'),
(3, 3, '2024-07-22');


INSERT INTO `constancia_de_confirmacion` (`id`, `fecha_confirmacion`, `feligres_confirmado_id`, `padre_1_id`, `padre_2_id`, `padrino_nombre`, `ministro_id`, `numero_libro`, `numero_pagina`, `numero_marginal`) VALUES
(1, '2024-08-12', 1, 4, 5, 'padrianado', 3, 4, 25, 1),
(2, '2023-09-05', 2, 8, 9, 'padrianado', 7, 5, 30, 2),
(3, '2024-10-15', 3, 4, 10, 'padrianado', 9, 6, 35, 3);

INSERT INTO `constancia_de_matrimonio` (`id`, `contrayente_1_id`, `contrayente_2_id`, `fecha_matrimonio`, `testigo_1_nombre`, `testigo_2_nombre`, `ministro_id`, `numero_libro`, `numero_pagina`, `numero_marginal`) VALUES
(1, 1, 2, '2023-11-20', 3, '4', 1, 1, 15, 5),
(2, 5, 8, '2024-02-10', 9, '10', 5, 2, 20, 8),
(3, 11, 3, '2024-06-05', 1, '2', 3, 3, 25, 12);


INSERT INTO `peticiones` (`id`, `objeto_de_peticion_id`, `realizado_por_id`, `tipo_de_intencion_id`, `servicio_id`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 2, 1, 1, 1, '2024-07-15 10:00:00', '2024-07-15 11:00:00'),
(2, 1, 1, 2, 1, '2024-08-01 18:00:00', '2024-08-01 19:00:00'),
(3, 5, 1, 3, 1, '2024-09-05 09:30:00', '2024-09-05 10:30:00'),
(4, 7, 1, 1, 1, '2024-10-10 12:00:00', '2024-10-10 13:00:00'),
(5, 9, 1, 4, 1, '2024-11-20 17:00:00', '2024-11-20 18:00:00'),
(6, 1, 1, 2, 1, '2024-12-25 10:00:00', '2024-12-25 11:00:00'),
(7, 3, 1, 4, 1, '2025-01-07 08:00:00', '2025-01-07 09:00:00'),
(8, 4, 1, 3, 1, '2025-02-14 11:00:00', '2025-02-14 12:00:00'),
(9, 8, 1, 1, 1, '2025-03-22 16:00:00', '2025-03-22 17:00:00'),
(10, 10, 1, 4, 1, '2025-04-30 09:00:00', '2025-04-30 10:00:00');

-- Inserts para peticiones sin tipo_de_intencion (servicio_id != 1)
-- Se asume que existen IDs válidos en feligreses (ej. 1-20) y administrador (1).
INSERT INTO `peticiones` (`id`, `objeto_de_peticion_id`, `realizado_por_id`, `tipo_de_intencion_id`, `servicio_id`, `fecha_inicio`, `fecha_fin`, `constancia_de_fe_de_bautizo_id`, `constancia_de_confirmacion_id`, `constancia_de_comunion_id`, `constancia_de_matrimonio_id`) VALUES
(11, NULL, 1, NULL, 2, '2024-08-01 18:00:00', '2024-08-01 19:00:00', 1, NULL, NULL, NULL),
(12, NULL, 1, NULL, 3, '2024-09-05 09:30:00', '2024-09-05 10:30:00', NULL, NULL, 2, NULL),
(13, NULL, 1, NULL, 4, '2024-10-10 12:00:00', '2024-10-10 13:00:00', NULL, 3, NULL, NULL),
(14, NULL, 1, NULL, 5, '2024-11-20 17:00:00', '2024-11-20 18:00:00', NULL, NULL, NULL, 1),
(15, NULL, 1, NULL, 2, '2025-01-07 08:00:00', '2025-01-07 09:00:00', 2, NULL, NULL, NULL),
(16, NULL, 1, NULL, 3, '2025-02-14 11:00:00', '2025-02-14 12:00:00', NULL, NULL, 3, NULL),
(17, NULL, 1, NULL, 4, '2025-03-22 16:00:00', '2025-03-22 17:00:00', NULL, 1, NULL, NULL),
(18, NULL, 1, NULL, 5, '2025-04-30 09:00:00', '2025-04-30 10:00:00', NULL, NULL, NULL, 2);
