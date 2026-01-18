/**
 * Renderiza la tabla de sacramentos dentro del formulario de edición.
 * @param {Object} info - Objeto con los IDs y fechas (vatios desde el PHP).
 * @param {number} idFeligres - El ID del feligrés actual.
 */
function inyectarSeccionSacramentos(info, idFeligres) {
    const contenedorPrincipal = document.getElementById('formulario');
    const contenedor = document.createElement('div');
    contenedor.id = 'contenedor-sacramentos';
    contenedor.classList.add('card-body');
    contenedorPrincipal.appendChild(contenedor);

    const sacramentos = [
        { nombre: 'Bautizo', tabla: 'constancia_de_fe_de_bautizo', id: info.bautizo_id, fecha: info.fecha_bautizo },
        { nombre: 'Comunión', tabla: 'constancia_de_comunion', id: info.comunion_id, fecha: info.fecha_comunion },
        { nombre: 'Confirmación', tabla: 'constancia_de_confirmacion', id: info.confirmacion_id, fecha: info.fecha_confirmacion },
        { nombre: 'Matrimonio', tabla: 'constancia_de_matrimonio', id: info.matrimonio_id, fecha: info.fecha_matrimonio }
    ];

    let html = `
        <div class="sacramentos-section mt-4">
            <h4 style="color: #2e7d32; border-bottom: 2px solid #2e7d32; padding-bottom: 5px;">Estatus Sacramental</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Sacramento</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>`;

    sacramentos.forEach(s => {
        const tieneRegistro = s.id !== null;
        const estadoTexto = tieneRegistro ? 'Registrado' : 'Sin registros';
        const fechaTexto = s.fecha ? s.fecha : '---';
        
        // El ID de la constancia (si existe) o vacío (si es nueva)
        const idConstancia = tieneRegistro ? s.id : '';
        const url = `?c=constancia&a=mostrar&t=${s.tabla}&id=${idConstancia}`;

        html += `
            <tr>
                <td><strong>${s.nombre}</strong></td>
                <td>${estadoTexto}</span></td>
                <td>${fechaTexto}</td>
                <td>
                    <a href="${url}" class="btn btn-sm ${tieneRegistro ? 'btn-outline-primary' : 'btn-outline-success'}">
                        ${tieneRegistro ? 'Editar' : 'Registrar'}
                    </a>
                </td>
            </tr>`;
    });

    html += `</tbody></table></div></div>`;
    
    contenedor.innerHTML = html;
} 
