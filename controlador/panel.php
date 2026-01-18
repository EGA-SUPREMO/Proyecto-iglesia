<script>
    // Configuración de paginación
    const ITEMS_POR_PAGINA = 500;
    let paginaActual = 1;
    let totalPaginas = 1;
    let datosGlobales = []; // Para guardar todos los datos
    let camposGlobales = []; // Para guardar los nombres de campos
    let nombreTablaGlobal = ''; // Para guardar el nombre de la tabla

    function generarTabla(nombreTabla, datosPHP) {
        camposGlobales = datosPHP.campos;
        const campos_formateados = datosPHP.campos_formateados;
        datosGlobales = datosPHP.datos || [];
        nombreTablaGlobal = nombreTabla;

        // Validar si hay datos
        if (datosGlobales.length > 0) {
            $('#sin-registros').hide();
            $('#con-registros').show();
            
            const $cabezaTabla = $('#cabeza-tabla');
            $cabezaTabla.empty();
            const $filaEncabezado = $('<tr>');
            campos_formateados.forEach(campo => {
                $filaEncabezado.append(`<th scope="col" class="py-3 px-4">${campo}</th>`);
            });
            $filaEncabezado.append('<th scope="col" class="py-3 px-4">Acciones</th>');
            $cabezaTabla.append($filaEncabezado);

            totalPaginas = Math.ceil(datosGlobales.length / ITEMS_POR_PAGINA);
            
            if (datosGlobales.length > ITEMS_POR_PAGINA) {
                agregarControlesPaginacion();
            }

            mostrarPagina(1);

        } else {
            $('#sin-registros').show();
            $('#con-registros').hide();
            $('#paginacion-container').hide(); // Ocultar paginación si no hay datos
            $('#sugerencia-sin-registro').html(`¡Haz clic en 'Agregar ${datosPHP.nombre_tabla_formateado}' para empezar!`);
        }
    }

    function agregarControlesPaginacion() {
        // Evitar duplicados si se vuelve a llamar
        $('#paginacion-container').remove(); 

        const htmlPaginacion = `
            <div id="paginacion-container" class="d-flex justify-content-between align-items-center mt-3 p-3 bg-white rounded shadow-sm">
                <button id="btn-anterior" class="btn btn-outline-primary rounded-pill">
                    <i class="bi bi-chevron-left"></i> Anterior
                </button>
                
                <span class="fw-bold text-secondary" id="info-paginacion">
                    Página 1 de ${totalPaginas}
                </span>

                <button id="btn-siguiente" class="btn btn-outline-primary rounded-pill">
                    Siguiente <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        `;
        
        // Insertar después de la tabla responsiva
        $('.table-responsive').after(htmlPaginacion);

        // Eventos de los botones
        $('#btn-anterior').click(() => {
            if (paginaActual > 1) mostrarPagina(paginaActual - 1);
        });

        $('#btn-siguiente').click(() => {
            if (paginaActual < totalPaginas) mostrarPagina(paginaActual + 1);
        });
    }

    // Función principal que renderiza las filas
    function mostrarPagina(numeroPagina) {
        paginaActual = numeroPagina;
        const $cuerpoTabla = $('#cuerpo-tabla');
        $cuerpoTabla.empty();

        // Calcular índices de inicio y fin (slice)
        const inicio = (paginaActual - 1) * ITEMS_POR_PAGINA;
        const fin = inicio + ITEMS_POR_PAGINA;
        
        // Obtener solo el segmento de datos necesario
        const datosPagina = datosGlobales.slice(inicio, fin);

        // Renderizar filas
        datosPagina.forEach(dato => {
            const $filaDatos = $('<tr>');
            camposGlobales.forEach(campo => {
                $filaDatos.append(`<td class="py-3 px-4">${dato[campo]}</td>`);
            });
            
            $filaDatos.append(`
                <td class="text-center px-3">
                    <a href="index.php?c=formulario&a=mostrar&t=${nombreTablaGlobal}&id=${dato.id}" class="btn btn-sm btn-warning me-2 rounded-pill shadow-sm">
                        Editar
                    </a>
                    <form action="?c=panel&a=eliminar&t=${nombreTablaGlobal}" method="POST" onsubmit="return confirm('¿Seguro de eliminar?');" style="display:inline;">
                        <input type="hidden" name="id" value="${dato.id}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger zoom-out rounded-pill shadow-sm">
                            Eliminar
                        </button>
                    </form>
                </td>
            `);
            $cuerpoTabla.append($filaDatos);
        });

        // Actualizar estado de los botones
        actualizarEstadoBotones();
    }

    function actualizarEstadoBotones() {
        $('#info-paginacion').text(`Página ${paginaActual} de ${totalPaginas} (Total: ${datosGlobales.length} registros)`);
        
        // Deshabilitar/Habilitar Anterior
        $('#btn-anterior').prop('disabled', paginaActual === 1);
        
        // Deshabilitar/Habilitar Siguiente
        $('#btn-siguiente').prop('disabled', paginaActual === totalPaginas);
    }

    $(document).ready(function() {
        const datosPHP = <?php echo $datos_tabla; ?>;

        const urlParams = new URLSearchParams(window.location.search);
        const nombreTabla = urlParams.get('t');

        const $agregarBtn = $('#agregar-btn');
        $agregarBtn.html('Agregar ' + datosPHP.nombre_tabla_formateado);
        $agregarBtn.attr('href', 'index.php?c=formulario&a=mostrar&t=' + nombreTabla);
        
        const $subtitulo = $('#subtitulo-tabla');
        $subtitulo.html('Listado de ' + datosPHP.nombre_tabla_formateado);

        generarTabla(nombreTabla, datosPHP);
    });
</script>