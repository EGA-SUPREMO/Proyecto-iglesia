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
    $selectMisaId.on('change', function() {
        cargarIntenciones($(this).val());
    });
});

function cargarIntenciones(misaId) {
    if (!misaId) return;

    let datos = {
        'misa_id': misaId,
        'metodo': 'obtenerIntencionesDeMisaId',
    };

    pedirDatos(JSON.stringify(datos), (resultado) => {
        mostrarIntenciones(resultado);
    }, "modelo/intenciones.php");
}

function mostrarIntenciones(resultado) {
    let intenciones = (typeof resultado === 'string') ? JSON.parse(resultado) : resultado;

    $('.lista-compacta').empty();

    $.each(intenciones, function(i, item) {
        let textoIntencion = item.lista_nombres; 
        let categoria = item.tipo_intencion;
        let idIntencion = item.id || 0; 
        let itemHtml = `
            <li data-id="${idIntencion}">
                ${textoIntencion} 
                <a href="?c=intenciones&a=mostrar&t=intencion&id=${idIntencion}" class="btn-accion">✎</a> 
                <a href="borrar.php?id=${idIntencion}" class="btn-accion">🗑️</a>
                <form action="?c=panel&a=intenciones&t=intencion" method="POST" onsubmit="return confirm('¿Seguro de eliminar?');">
                    <input type="hidden" name="id" value="${idIntencion}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit">
                        🗑️
                    </button>
                </form>
            </li>
        `;
        let $header = $('.subtitulo-intenciones').filter(function() {
            return $(this).text().trim() === categoria; 
        });
        
        $header.next('.lista-compacta').append(itemHtml);
    });
}

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
        let idSeleccionado = $selectMisaId.val();
        cargarIntenciones(idSeleccionado);
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
