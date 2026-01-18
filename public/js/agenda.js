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

// Variable global para el ID de la Misa (asumiendo que $selectMisaId.val() lo contiene)
// Si no la tienes, debes obtenerla de alguna manera (p. ej., leer el valor del select).
const $selectMisaId = $('#misa-id');

function configurarListenerBorrado() {
    $('.js-borrar').off('click').on('click', function(e) {
        e.preventDefault();
        const idIntencion = $(this).data('intencion-id');
        preguntarBorrado(idIntencion);
    });
}

function preguntarBorrado(idIntencion) {
    Swal.fire({
        title: 'Seleccione el alcance del borrado',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Borrar para TODAS las misas',
        cancelButtonText: 'Borrar SOLO para esta misa',
        showDenyButton: true,
        denyButtonText: 'Cancelar',
        focusCancel: true,
        customClass: {
            confirmButton: 'swal2-confirm',
            denyButton: 'swal2-deny',
            cancelButton: 'swal2-cancel'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: '¿Confirmas la eliminación global?',
                text: 'Esta intención se eliminará de forma permanente de TODAS las misas futuras y pasadas.',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, borrar globalmente',
                cancelButtonText: 'No, cancelar'
            }).then((resultConfirm) => {
                if (resultConfirm.isConfirmed) {
                    enviarFormularioBorrado(idIntencion, 'global');
                }
            });

        } else if (result.dismiss === Swal.DismissReason.cancel) {
            enviarFormularioBorrado(idIntencion, 'local');
            
        } else if (result.isDenied) {
            Swal.fire('Cancelado', 'La intención no ha sido modificada.', 'info');
        }
    });
}

/**
 * Crea un formulario dinámico y lo envía para realizar la acción DELETE.
 * @param {string|number} idIntencion - El ID de la intención a borrar.
 * @param {string} alcance - 'local' (solo esta misa) o 'global' (todas las misas).
 */
function enviarFormularioBorrado(idIntencion, alcance) {
    const misaId = $selectMisaId.val();

    const $form = $('<form>', {
        action: '?c=intenciones&a=eliminar&t=intencion',
        method: 'POST',
        style: 'display:none;'
    });
    
    $form.append($('<input>', { type: 'hidden', name: 'id', value: idIntencion }));
    $form.append($('<input>', { type: 'hidden', name: '_method', value: 'DELETE' }));
    $form.append($('<input>', { type: 'hidden', name: 'alcance_borrado', value: alcance }));
    if (alcance === 'local') {
        $form.append($('<input>', { type: 'hidden', name: 'misa_id', value: misaId }));
    }

    $('body').append($form);
    $form.submit();
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
                <button class="btn-accion btn btn-sm zoom-out rounded-pill shadow-sm me-1" href="?c=intenciones&a=mostrar&t=intencion&id=${idIntencion}"> ✎ </button>
                <button class="btn-accion js-borrar btn btn-sm btn-danger zoom-out rounded-pill shadow-sm ms-1" data-intencion-id="${idIntencion}">🗑️</button>
            </li>
        `;
        let $header = $('.subtitulo-intenciones').filter(function() {
            return $(this).text().trim() === categoria; 
        });
        
        $header.next('.lista-compacta').append(itemHtml);
    });
    configurarListenerBorrado();
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
