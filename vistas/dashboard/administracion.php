<body>
<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div id="error-message-container" style="display:none;"></div>
            <section class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">
                    <h2 class="card-title text-center text-primary fw-bold mb-4">Opciones del Panel</h2>
                    <div class="row g-3">
                          <div class="col-sm-6">
                            <a href="?c=panel&a=index&t=administrador" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0"> Gestionar <br> Administradores</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=panel&a=index&t=sacerdote" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Gestionar Sacerdotes</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=panel&a=index&t=feligres" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Gestionar Feligreses</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=panel&a=index&t=objeto_de_peticion" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Gestionar Objetos de petición</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=panel&a=index&t=misa" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Gestionar Misas</h5>
                                </div>
                            </a>
                        </div>
                    <div class="col-sm-6">
                            <a href="test_diagnostico.php" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Abrir Diagnóstico</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php 
                    // Get the absolute path
                    $baseDir = __DIR__ . '/../../public/plantillas/';
                    $absolutePath = realpath($baseDir); 

                    // Debug: If realpath fails, just use the raw path so it's not empty
                    if (!$absolutePath) {
                        $absolutePath = $baseDir; 
                    }
                ?>
                <div class="col-sm-6">
                    <div class="card h-100 shadow-sm border-0"> <div class="card-body text-center d-flex flex-column justify-content-center">
                            <h5 class="card-title mb-3">📂 Plantillas</h5>
                            
                            <div class="d-grid gap-2 col-10 mx-auto">
                                <a href="public/plantillas/" class="btn btn-primary">
                                    Abrir Carpeta
                                </a>

                                <button 
                                    class="btn btn-outline-secondary" 
                                    id="copyPathBtn" 
                                    data-path="<?php echo htmlspecialchars($absolutePath); ?>"
                                    onclick="copyLocalPath()">
                                    📋 Copiar Ruta
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
<script src="public/js/bootstrap.bundle.min.js"></script>
<script src="public/js/sweetalert2.all.min.js"></script>
<script src="public/js/mostrarError.js"></script>
<script>
    function copyLocalPath() {
        const btn = document.getElementById('copyPathBtn');
        const path = btn.getAttribute('data-path');

        console.log("Path detected:", path); // Check your F12 console for this!

        if (!path || path === "") {
            console.error("The path is empty. Check if the folder exists.");
            return;
        }

        navigator.clipboard.writeText(path).then(() => {
            // Visual Feedback
            const originalText = btn.innerText;
            btn.innerText = "¡Copiado!";
            btn.classList.replace('btn-outline-secondary', 'btn-success');
            
            setTimeout(() => {
                btn.innerText = originalText;
                btn.classList.replace('btn-success', 'btn-outline-secondary');
            }, 2000);
        }).catch(err => {
            console.error("Clipboard Error: ", err);
            // Fallback for older browsers or non-https
            alert("Error al copiar. Revisa la consola.");
        });
    }
</script>
</body>
</html>
