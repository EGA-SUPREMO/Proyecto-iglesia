-- Buscar todas las peticiones de un feligrés específico (por cédula)
SELECT 
    p.id,
    s.nombre AS servicio,
    p.descripcion,
    p.fecha_inicio,
    p.fecha_fin
FROM peticiones p
JOIN servicios s ON p.servicio_id = s.id
JOIN feligreses f ON p.feligres_id = f.id
WHERE f.cedula = 12345678;

-- Ver todos los pagos de un feligrés específico (por cédula)
SELECT 
    p.id,
    s.nombre AS servicio,
    p.descripcion,
    p.fecha_inicio,
    p.fecha_fin
FROM peticiones p
JOIN servicios s ON p.servicio_id = s.id
JOIN feligreses f ON p.feligres_id = f.id
WHERE f.cedula = 12345678;

-- Ver todos los pagos a una peticion específica (por id de peticion)
SELECT 
    pagos.id AS pago_id,
    feligreses.nombre AS feligres,
    servicios.nombre AS servicio,
    metodos_pago.nombre AS metodo_pago,
    pagos.monto_usd,
    pagos.referencia_pago,
    pagos.fecha_pago
FROM pagos
JOIN feligreses ON pagos.feligres_id = feligreses.id
JOIN peticiones ON pagos.peticion_id = peticiones.id
JOIN servicios ON peticiones.servicio_id = servicios.id
JOIN metodos_pago ON pagos.metodo_pago_id = metodos_pago.id
WHERE pagos.peticion_id = 16
ORDER BY pagos.fecha_pago;

-- Pagos realizados en un rango de fechas
SELECT 
    pagos.id,
    feligreses.nombre AS feligres,
    pagos.monto_usd,
    pagos.fecha_pago
FROM pagos
JOIN feligreses ON pagos.feligres_id = feligreses.id
WHERE pagos.fecha_pago BETWEEN '2025-05-01' AND '2025-05-31'
ORDER BY pagos.fecha_pago;

-- Peticiones activas (servicios que aún no han finalizado)
SELECT 
    p.id,
    f.nombre AS feligres,
    s.nombre AS servicio,
    p.fecha_inicio,
    p.fecha_fin
FROM peticiones p
JOIN feligreses f ON p.feligres_id = f.id
JOIN servicios s ON p.servicio_id = s.id
WHERE p.fecha_fin >= CURDATE()
ORDER BY p.fecha_inicio;