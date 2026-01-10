Tarea UX/UI: Notificación de No Disponibilidad de Misas

Contexto: El método de backend consultarOCrearMisas filtra las misas disponibles, excluyendo aquellas que ya tienen una intención registrada (según el objeto_de_peticion_nombre o peticion_id). Actualmente, las misas ocupadas simplemente no se muestran, lo que crea "huecos" sin explicación en la interfaz de usuario.

Objetivo: Mejorar la UX/UI para informar al usuario de por qué faltan ciertas misas o rangos horarios.

🎯 Tarea de Desarrollo

Implementar una función que, al consultar la disponibilidad de misas por rango de fechas:

Muestre todas las misas programadas en ese rango (incluyendo las ocupadas).

Para cada misa, si el misa_id no está presente en la lista de misas disponibles (el array $respuesta que devuelve el backend):

La opción (checkbox/radio) en el frontend debe aparecer deshabilitada.

Se debe agregar un tooltip o texto informativo que diga: "No disponible: Ya se ha registrado una intención para este tipo de petición a esta hora." 
