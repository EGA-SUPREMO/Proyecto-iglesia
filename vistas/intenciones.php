<body class="d-flex flex-column min-vh-100 bg-light">
    <main class="container-fluid my-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-xl-12">
                <section class="card shadow-lg rounded-4">
                    <div class="card-body p-4 p-md-5" id="contenedor-tabla">
                        <section>
                            <h1>Intenciones de Misa</h1>
                            <form action="?c=intenciones&a=generarPDF&t=intencion" method="POST" autocomplete="off">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h4 class="mb-2">Fecha de la misa:</h4>
                                        <input type="date" name="fecha-misa" id="fecha-misa" class="form-control" value="2025-10-05" required>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="mb-2">Selecciona la misa:</h4>
                                        <select name="misa-id" id="misa-id" class="form-control" required>
                                            <option value="1">3:30 pm</option>
                                        </select>
                                    </div>
                                </div>
                            <h2 class="subtitulo-intenciones">Acción de Gracias</h2>
<ul class="lista-compacta">
    <li data-id="101">Familia Guzmán <a href="editar.php?id=101" class="btn-accion">✎</a> <a href="borrar.php?id=101" class="btn-accion">🗑️</a></li>
    <li data-id="102">Marta Elena Soto <a href="editar.php?id=102" class="btn-accion">✎</a> <a href="borrar.php?id=102" class="btn-accion">🗑️</a></li>
    <li data-id="103">Padre Miguel Ángel <a href="editar.php?id=103" class="btn-accion">✎</a> <a href="borrar.php?id=103" class="btn-accion">🗑️</a></li>
    <li data-id="115">Voluntarios Cáritas <a href="editar.php?id=115" class="btn-accion">✎</a> <a href="borrar.php?id=115" class="btn-accion">🗑️</a></li>
    <li data-id="116">Benjamín Eduardo Mena <a href="editar.php?id=116" class="btn-accion">✎</a> <a href="borrar.php?id=116" class="btn-accion">🗑️</a></li>
    <li data-id="117">Isidora Paz Sánchez <a href="editar.php?id=117" class="btn-accion">✎</a> <a href="borrar.php?id=117" class="btn-accion">🗑️</a></li>
    <li data-id="118">La Hermana Superiora <a href="editar.php?id=118" class="btn-accion">✎</a> <a href="borrar.php?id=118" class="btn-accion">🗑️</a></li>
    <li data-id="119">Mateo Vicente Cruz <a href="editar.php?id=119" class="btn-accion">✎</a> <a href="borrar.php?id=119" class="btn-accion">🗑️</a></li>
    <li data-id="120">Nuestra Comunidad <a href="editar.php?id=120" class="btn-accion">✎</a> <a href="borrar.php?id=120" class="btn-accion">🗑️</a></li>
</ul>
                            <h2 class="subtitulo-intenciones">Salud</h2>
<ul class="lista-compacta">
    <li data-id="214">Catalina Paz Bravo <a href="editar.php?id=214" class="btn-accion">✎</a> <a href="borrar.php?id=214" class="btn-accion">🗑️</a></li>
    <li data-id="215">José Antonio López <a href="editar.php?id=215" class="btn-accion">✎</a> <a href="borrar.php?id=215" class="btn-accion">🗑️</a></li>
    <li data-id="216">Teresa de Jesús Moya <a href="editar.php?id=216" class="btn-accion">✎</a> <a href="borrar.php?id=216" class="btn-accion">🗑️</a></li>
    <li data-id="217">Doctora Ana Flores <a href="editar.php?id=217" class="btn-accion">✎</a> <a href="borrar.php?id=217" class="btn-accion">🗑️</a></li>
    <li data-id="218">Todos los que sufren <a href="editar.php?id=218" class="btn-accion">✎</a> <a href="borrar.php?id=218" class="btn-accion">🗑️</a></li>
    <li data-id="219">Guillermo Elías Ponce <a href="editar.php?id=219" class="btn-accion">✎</a> <a href="borrar.php?id=219" class="btn-accion">🗑️</a></li>
    <li data-id="220">Elena Cecilia Vidal <a href="editar.php?id=220" class="btn-accion">✎</a> <a href="borrar.php?id=220" class="btn-accion">🗑️</a></li>
</ul>
                            <h2 class="subtitulo-intenciones">Aniversario</h2>
<ul class="lista-compacta">
    <li data-id="310">Matrimonio de los Padrinos <a href="editar.php?id=310" class="btn-accion">✎</a> <a href="borrar.php?id=310" class="btn-accion">🗑️</a></li>
    <li data-id="311">Primera Comunión de Elena <a href="editar.php?id=311" class="btn-accion">✎</a> <a href="borrar.php?id=311" class="btn-accion">🗑️</a></li>
    <li data-id="312">Aniv. de la Parroquia <a href="editar.php?id=312" class="btn-accion">✎</a> <a href="borrar.php?id=312" class="btn-accion">🗑️</a></li>
    <li data-id="313">Matrimonio Gómez-Bravo <a href="editar.php?id=313" class="btn-accion">✎</a> <a href="borrar.php?id=313" class="btn-accion">🗑️</a></li>
    <li data-id="314">Cumpleaños de Don Julio <a href="editar.php?id=314" class="btn-accion">✎</a> <a href="borrar.php?id=314" class="btn-accion">🗑️</a></li>
    <li data-id="315">Aniv. del Coro Juvenil <a href="editar.php?id=315" class="btn-accion">✎</a> <a href="borrar.php?id=315" class="btn-accion">🗑️</a></li>
    <li data-id="316">Matrimonio de los Abuelos <a href="editar.php?id=316" class="btn-accion">✎</a> <a href="borrar.php?id=316" class="btn-accion">🗑️</a></li>
    <li data-id="317">Cumpleaños de María Paz <a href="editar.php?id=317" class="btn-accion">✎</a> <a href="borrar.php?id=317" class="btn-accion">🗑️</a></li>
    <li data-id="318">Aniv. de la Misión <a href="editar.php?id=318" class="btn-accion">✎</a> <a href="borrar.php?id=318" class="btn-accion">🗑️</a></li>
    <li data-id="319">Matrimonio Flores-Reyes <a href="editar.php?id=319" class="btn-accion">✎</a> <a href="borrar.php?id=319" class="btn-accion">🗑️</a></li>
    <li data-id="320">Cumpleaños del Sacristán <a href="editar.php?id=320" class="btn-accion">✎</a> <a href="borrar.php?id=320" class="btn-accion">🗑️</a></li>
</ul>
                            <h2 class="subtitulo-intenciones">Difunto</h2>
<ul class="lista-compacta">
    <li data-id="401">Alma de Don Francisco Herrera <a href="editar.php?id=401" class="btn-accion">✎</a> <a href="borrar.php?id=401" class="btn-accion">🗑️</a></li>
    <li data-id="402">María Isabel Castro (Q.E.P.D.) <a href="editar.php?id=402" class="btn-accion">✎</a> <a href="borrar.php?id=402" class="btn-accion">🗑️</a></li>
    <li data-id="403">Familiares Difuntos Pérez <a href="editar.php?id=403" class="btn-accion">✎</a> <a href="borrar.php?id=403" class="btn-accion">🗑️</a></li>
    <li data-id="404">Abuela Emilia Soto <a href="editar.php?id=404" class="btn-accion">✎</a> <a href="borrar.php?id=404" class="btn-accion">🗑️</a></li>
    <li data-id="405">Tío Roberto Ramírez <a href="editar.php?id=405" class="btn-accion">✎</a> <a href="borrar.php?id=405" class="btn-accion">🗑️</a></li>
    <li data-id="406">José Manuel Vargas <a href="editar.php?id=406" class="btn-accion">✎</a> <a href="borrar.php?id=406" class="btn-accion">🗑️</a></li>
    <li data-id="407">Elena Sofía Méndez <a href="editar.php?id=407" class="btn-accion">✎</a> <a href="borrar.php?id=407" class="btn-accion">🗑️</a></li>
    <li data-id="408">Ricardo Jesús Palma <a href="editar.php?id=408" class="btn-accion">✎</a> <a href="borrar.php?id=408" class="btn-accion">🗑️</a></li>
    <li data-id="409">Ana Cecilia Ruiz <a href="editar.php?id=409" class="btn-accion">✎</a> <a href="borrar.php?id=409" class="btn-accion">🗑️</a></li>
    <li data-id="410">Todos los Fieles Difuntos <a href="editar.php?id=410" class="btn-accion">✎</a> <a href="borrar.php?id=410" class="btn-accion">🗑️</a></li>
    <li data-id="411">Luis Fernando Núñez <a href="editar.php?id=411" class="btn-accion">✎</a> <a href="borrar.php?id=411" class="btn-accion">🗑️</a></li>
    <li data-id="412">Margarita Paz Cruz <a href="editar.php?id=412" class="btn-accion">✎</a> <a href="borrar.php?id=412" class="btn-accion">🗑️</a></li>
    <li data-id="413">Carlos Andrés Gil <a href="editar.php?id=413" class="btn-accion">✎</a> <a href="borrar.php?id=413" class="btn-accion">🗑️</a></li>
    <li data-id="414">Catalina Ignacia Leal <a href="editar.php?id=414" class="btn-accion">✎</a> <a href="borrar.php?id=414" class="btn-accion">🗑️</a></li>
    <li data-id="415">Abuelo Juan Pablo <a href="editar.php?id=415" class="btn-accion">✎</a> <a href="borrar.php?id=415" class="btn-accion">🗑️</a></li>
    <li data-id="416">María Consuelo Vera <a href="editar.php?id=416" class="btn-accion">✎</a> <a href="borrar.php?id=416" class="btn-accion">🗑️</a></li>
    <li data-id="417">Hermanos de la Iglesia <a href="editar.php?id=417" class="btn-accion">✎</a> <a href="borrar.php?id=417" class="btn-accion">🗑️</a></li>
    <li data-id="418">Padres de la Párroca <a href="editar.php?id=418" class="btn-accion">✎</a> <a href="borrar.php?id=418" class="btn-accion">🗑️</a></li>
    <li data-id="419">Sebastián Alonso Díaz <a href="editar.php?id=419" class="btn-accion">✎</a> <a href="borrar.php?id=419" class="btn-accion">🗑️</a></li>
    <li data-id="420">La tía Elena Flores <a href="editar.php?id=420" class="btn-accion">✎</a> <a href="borrar.php?id=420" class="btn-accion">🗑️</a></li>
</ul>
                                <div class="btn-group">
                                    <a href="?c=intenciones&a=mostrar&t=intencion" class="btn btn-primary">
                                        + Agregar Nueva Intención
                                    </a>
                                    <button type="submit" class="btn btn-secondary">
                                        Generar PDF 📄
                                    </button>
                                </div>
                            </form>
                        </section>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <script src="public/js/jquery-1.12.4.min.js"></script>
    <script src="public/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/sweetalert2.all.min.js"></script>
    <script src="public/js/validador.js"></script>
    <script src="public/js/generadorFormulario.js"></script>
    <script src="public/js/agenda.js"></script>
    <script src="public/js/mostrarError.js"></script>
</body>

</html>