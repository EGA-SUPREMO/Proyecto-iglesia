    <fieldset>
        <legend>Información de los Ciudadanos</legend>

        <label for="ciudadano_1">Ciudadano 1 (Nombre completo):</label><br>
        <input type="text" id="ciudadano_1" name="ciudadano_1" required><br><br>

        <label for="ciudadano_1_ci">Cédula de Identidad del Ciudadano 1:</label><br>
        <input type="text" id="ciudadano_1_ci" name="ciudadano_1_ci" pattern="\d{4,10}" maxlength="10" required><br><br>

        <label for="ciudadano_2">Ciudadano 2 (Nombre completo):</label><br>
        <input type="text" id="ciudadano_2" name="ciudadano_2" required><br><br>

        <label for="ciudadano_2_ci">Cédula de Identidad del Ciudadano 2:</label><br>
        <input type="text" id="ciudadano_2_ci" name="ciudadano_2_ci" pattern="\d{4,10}" maxlength="10" required><br><br>
    </fieldset>

    <fieldset>
        <legend>Información de los Niños</legend>

        <label for="nino_1">Niño 1 (Nombre completo):</label><br>
        <input type="text" id="nino_1" name="nino_1" required><br><br>

        <label for="nino_2">Niño 2 (Nombre completo, opcional):</label><br>
        <input type="text" id="nino_2" name="nino_2"><br><br>
    </fieldset>

    <fieldset>
        <legend>Información Adicional</legend>

        <label for="nombre_iglesia">Nombre de la Iglesia:</label><br>
        <input type="text" id="nombre_iglesia" name="nombre_iglesia" required><br><br>

        <label for="fecha_constancia">Fecha de la Constancia:</label><br>
        <input type="date" id="fecha_constancia" name="fecha_constancia" value="<?php echo date('Y-m-d'); ?>" required><br><br>
    </fieldset>
