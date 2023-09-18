<div class="container">
    <div class="modal fade" id="creatermmodal" tabindex="-1" aria-labelledby="creatermmodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="formm" method="post">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="creatermmodalLabel">Crear RM</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="url" class="form-label">Url de la entrada:</label>
                            <input type="text" class="form-control" name="url" id="url" value="" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="buscar1" class="form-label">Palabra a buscar 1:</label>
                            <input type="text" class="form-control" name="buscar1" id="buscar1" value="" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="sustituir1" class="form-label">Palabra a sustituir 1:</label>
                            <input type="text" class="form-control" name="sustituir1" id="sustituir1" value="" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="buscar2" class="form-label">Palabra a buscar 2:</label>
                            <input type="text" class="form-control" name="buscar2" id="buscar2" value="" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="sustituir2" class="form-label">Palabra a sustituir 2:</label>
                            <input type="text" class="form-control" name="sustituir2" id="sustituir2" value="" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="buscar3" class="form-label">Palabra a buscar 3:</label>
                            <input type="text" class="form-control" name="buscar3" id="buscar3" value="" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="sustituir3" class="form-label">Palabra a sustituir 3:</label>
                            <input type="text" class="form-control" name="sustituir3" id="sustituir3" value="" placeholder="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" id="buttoncreaterm" name="buttoncreaterm" class="btn btn-primary">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <?php
    echo "<h1 class='wp-heading-inline title'>" . get_admin_page_title() . "</h1>";
    echo '<button type="button" class="button button-secondary" onclick="openModalCreate(\'creatermmodal\')">Añadir Nuevo RM</button>';

    global $wpdb;
    $table = $wpdb->prefix . 'yoast_indexable';

    if (isset($_POST['buttoncreaterm'])) {

        $permalink = $_POST['url'];
        $query = $wpdb->prepare("SELECT object_id FROM $table WHERE permalink = %s", $permalink);
        $object_id = $wpdb->get_var($query);

        if ($object_id) {
            $buscar1 = $_POST['buscar1'];
            $sustituir1 = $_POST['sustituir1'];
            $buscar2 = $_POST['buscar2'];
            $sustituir2 = $_POST['sustituir2'];
            $buscar3 = $_POST['buscar3'];
            $sustituir3 = $_POST['sustituir3'];
            $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$wpdb->prefix}posts
                    SET post_content = REPLACE(
                        REPLACE(
                            REPLACE(post_content, %s, %s),
                            %s, %s
                        ),
                        %s, %s
                    )
                    WHERE ID = %d",
                    $buscar1,
                    $sustituir1,
                    $buscar2,
                    $sustituir2,
                    $buscar3,
                    $sustituir3,
                    $object_id
                )
            );
        } else {
            echo "El link no fue encontrado en la tabla.";
        }

        echo '</br>';
        echo 'Búsqueda y reemplazo completados.';
        echo '</br>';
    }
    ?>
</div>

<script>
    function openModalCreate(modalId) {
        var modal = document.getElementById(modalId);
        var bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }
</script>