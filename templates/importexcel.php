<div class="container">
    <div class="modal fade" id="importexcelrmmodal" tabindex="-1" aria-labelledby="importexcelrmmodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="formm" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="importexcelrmmodalLabel">Importar CSV</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="archivo_csv" id="archivo_csv">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" id="buttonimportexcelrm" name="buttonimportexcelrm" class="btn btn-primary">Importar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <?php
    echo "<h1 class='wp-heading-inline title'>" . get_admin_page_title() . "</h1>";
    echo '<button type="button" class="button button-secondary" onclick="openModalCreate(\'importexcelrmmodal\')">Importar Excel</button>';

    if (isset($_POST["buttonimportexcelrm"])) {
        if (isset($_FILES["archivo_csv"])) {
            $file = $_FILES["archivo_csv"];
            $fileType = pathinfo($file["name"], PATHINFO_EXTENSION);
            if ($fileType == "csv") {
                $csvData = array_map('str_getcsv', file($file["tmp_name"]));
                global $wpdb;
                $table = $wpdb->prefix . 'yoast_indexable';
                if (!empty($csvData)) {
                    foreach ($csvData as $row) {
                        $permalink = $row[0];
                        $buscar1 = $row[1];
                        $sustituir1 = $row[2];
                        $buscar2 = $row[3];
                        $sustituir2 = $row[4];
                        $buscar3 = $row[5];
                        $sustituir3 = $row[6];
                        
                        $query = $wpdb->prepare("SELECT object_id FROM $table WHERE permalink = %s", $permalink);
                        $object_id = $wpdb->get_var($query);

                        if ($object_id) {
                            $wpdb->query(
                                $wpdb->prepare(
                                    "UPDATE {$wpdb->prefix}posts
                                    SET post_content = REPLACE(
                                        REPLACE(
                                            REGEXP_REPLACE(post_content, '</?(s|em|mark|sup|sub|strong)[^>]*>', ''),
                                            '&nbsp;',
                                            ''
                                        ),
                                        %s,
                                        %s
                                    )
                                    WHERE REPLACE(
                                        REGEXP_REPLACE(post_content, '</?(s|em|mark|sup|sub|strong)[^>]*>', ''),
                                        '&nbsp;',
                                        ''
                                    ) LIKE %s AND ID = %d",
                                    $buscar1,
                                    $sustituir1,
                                    '%' . $buscar1 . '%',
                                    $object_id
                                )
                            );
                            $wpdb->query(
                                $wpdb->prepare(
                                    "UPDATE {$wpdb->prefix}posts
                                    SET post_content = REPLACE(
                                        REPLACE(
                                            REGEXP_REPLACE(post_content, '</?(s|em|mark|sup|sub|strong)[^>]*>', ''),
                                            '&nbsp;',
                                            ''
                                        ),
                                        %s,
                                        %s
                                    )
                                    WHERE REPLACE(
                                        REGEXP_REPLACE(post_content, '</?(s|em|mark|sup|sub|strong)[^>]*>', ''),
                                        '&nbsp;',
                                        ''
                                    ) LIKE %s AND ID = %d",
                                    $buscar2,
                                    $sustituir2,
                                    '%' . $buscar2 . '%',
                                    $object_id
                                )
                            );
                            $wpdb->query(
                                $wpdb->prepare(
                                    "UPDATE {$wpdb->prefix}posts
                                    SET post_content = REPLACE(
                                        REPLACE(
                                            REGEXP_REPLACE(post_content, '</?(s|em|mark|sup|sub|strong)[^>]*>', ''),
                                            '&nbsp;',
                                            ''
                                        ),
                                        %s,
                                        %s
                                    )
                                    WHERE REPLACE(
                                        REGEXP_REPLACE(post_content, '</?(s|em|mark|sup|sub|strong)[^>]*>', ''),
                                        '&nbsp;',
                                        ''
                                    ) LIKE %s AND ID = %d",
                                    $buscar3,
                                    $sustituir3,
                                    '%' . $buscar3 . '%',
                                    $object_id
                                )
                            );
                        }
                    }

                    echo '</br>';
                    echo 'Búsqueda y reemplazo completados.';
                    echo '</br>';
                } else {
                    echo '</br>';
                    echo 'El archivo CSV está vacío.';
                    echo '</br>';
                }
            } else {
                echo '</br>';
                echo "El archivo debe ser un CSV.";
                echo '</br>';
            }
        } else {
            echo '</br>';
            echo "No se seleccionó ningún archivo.";
            echo '</br>';
        }
    }
    ?>
</div>