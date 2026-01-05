$(document).ready(function() {
    const $inputFechaMisa = $('#fecha-misa');
    const $selectMisaId = $('#misa-id');

    const hoy = obtenerFechaActualFormatoISO();
    $inputFechaMisa.val(hoy);

    // 1.3. Cargar las misas para la fecha de hoy al iniciar
    cargarMisas($inputFechaMisa.val(), $selectMisaId);

    // 1.4. Agregar un listener para recargar las misas si la fecha cambia
    $inputFechaMisa.on('change', function() {
        cargarMisas($(this).val(), $selectMisaId);
    });
});

function obtenerFechaActualFormatoISO() {
    const ahora = new Date();
    const anio = ahora.getFullYear();
    const mes = String(ahora.getMonth() + 1).padStart(2, '0');
    const dia = String(ahora.getDate()).padStart(2, '0');
    
    return `${anio}-${mes}-${dia}`;
}

// --- 2. FUNCIÓN DE CARGA DE DATOS ---

/**
 * Prepara los datos y llama a la función pedirDatos para obtener las misas.
 * @param {string} fecha La fecha seleccionada (YYYY-MM-DD).
 * @param {object} $selectMisaId Objeto jQuery del select para misas.
 */
function cargarMisas(fecha, $selectMisaId) {
    $selectMisaId.empty().append('<option value="">Cargando misas...</option>').prop('disabled', true);

    let datos = {
        'fecha_inicio': fecha,
        'fecha_fin': fecha, 
        'metodo': 'consultarOCrearMisas',
    };
    
    pedirDatos(JSON.stringify(datos), (resultado) => {
        manejarRespuestaMisasAgenda(resultado, $selectMisaId);
    }, "modelo/intenciones.php");
}

/**
 * Procesa la respuesta del servidor y rellena el dropdown (select) de misas.
 * @param {object} respuesta Objeto de respuesta JSON del servidor.
 * @param {object} $selectMisaId Objeto jQuery del select para misas.
 */
function manejarRespuestaMisasAgenda(respuesta, $selectMisaId) {
    $selectMisaId.empty().prop('disabled', false); 

    if (respuesta && respuesta.length > 0) {
        respuesta.forEach(misa => {
            $selectMisaId.append(
                $('<option>', {
                    value: misa.id,
                    text: misa.hora_formato
                })
            );
        });

    } else {
        $selectMisaId.append(
            $('<option>', {
                value: '',
                text: 'No hay misas disponibles para esta fecha'
            })
        ).prop('disabled', true);
    }
} 
