<fieldset>
    <p>NOTA:En esta tengo que pedir que poner en cada texto</p>
    <label for="titulo">Título del Documento:</label>
    <input type="text" id="titulo" name="titulo" required>
    <br>
    <label for="nombre">Nombre Completo:</label>
    <input type="text" id="nombre" name="nombre" required>
    <br>
    <label for="fecha">Fecha:</label>
    <input type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
    <br>
    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion" rows="5" required></textarea>
</fieldset>
