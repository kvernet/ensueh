<?php

use app\core\entity\Message;
use app\core\entity\Status;
use app\core\entity\WhoAmI;
use app\core\model\SingleModel;

$params['nav_item_active'] = "Professeurs";

include_once("header.php");

echo '<h3 style="text-align: center;">Gestion des professeurs</h3>';

echo '<div>'
    . '<a href="#" id="print-table" class="btn btn-success my-2">Imprimer tableau</a>'
    . '</div>';


$messageContent = "";
if(isset($_GET["msg_id"]) && Message::get($_GET["msg_id"]) != Message::SUCCESS_MSG) {
    $messageContent = Message::getMessage(Message::get($_GET["msg_id"]));
}
echo '<span class="error-msg" id="details">'. $messageContent .'</span><br>';

function getFormatedList(string $table_name, array $filteredIds = []): string {
    return (new SingleModel)->setTable($table_name)->getAllAsJSON($filteredIds);
}

echo '<div id="user-data-tr"></div>';
echo '<hr class="my-4">';
?>

<script>
    const genderValues = <?php echo getFormatedList("genders"); ?>;
    const departmentValues = <?php echo getFormatedList("departments"); ?>;
    const whoamiValues = <?php echo getFormatedList("whoami", [WhoAmI::ADM->value]); ?>;
    const sectionValues = <?php echo getFormatedList("sections"); ?>;
    const gradeValues = <?php echo getFormatedList("grades"); ?>;
    const statusValues = <?php echo getFormatedList("statuses", [
                                Status::ACTIVE->value,
                                Status::INACTIVE->value,
                                Status::ONLINE->value,
                                Status::OFFLINE->value
                            ]); ?>;


    var table = new Tabulator("#user-data-tr", {
        pagination: true, //enable pagination
        paginationMode: "remote", //enable remote pagination
        paginationSize: 10,
        paginationInitialPage: 2,
        paginationSizeSelector: [10, 25, 50, 100],
        paginationAddRow: "table",

        layout: "fitDataFill",
        responsiveLayout: "collapse",
        rowHeader: {
            formatter: "responsiveCollapse",
            width: 70,
            minWidth: 70,
            hozAlign: "center",
            resizable: false,
            headerSort: false
        },

        ajaxURL: "get_users_as_table",
        progressiveLoad: "scroll",
        placeholder: "Aucune entrée",
        ajaxParams: {
            whoami_id: <?= WhoAmI::PROFESSOR->value ?>
        },
        ajaxConfig: "POST",

        printAsHtml: true,
        printHeader: "<h1>Liste des professeurs<h1>",
        printFooter: "<h2> <?= APP_NAME ?> <h2>",

        columns: [{
                title: "Identifiant",
                field: "user_name",
                sorter: "string",
                headerFilter: "input"
            },
            {
                title: "Email",
                field: "email",
                sorter: "string",
                headerFilter: "input",
                editor: "input",
                validator: "required"
            },
            {
                title: "Téléphone",
                field: "phone",
                sorter: "string",
                headerFilter: "input",
                editor: "input",
                validator: "required"
            },
            {
                title: "Prénom",
                field: "first_name",
                sorter: "string",
                headerFilter: "input",
                editor: "input",
                validator: "required"
            },
            {
                title: "Nom",
                field: "last_name",
                sorter: "string",
                headerFilter: "input",
                editor: "input",
                validator: "required"
            },
            {
                title: "Sexe",
                field: "gender",
                sorter: "string",
                headerFilter: "list",
                headerFilterParams: {
                    values: genderValues
                },
                editor: "list",
                editorParams: {
                    values: genderValues
                }
            },
            {
                title: "Département",
                field: "department",
                sorter: "string",
                headerFilter: "list",
                headerFilterParams: {
                    values: departmentValues
                },
                editor: "list",
                editorParams: {
                    values: departmentValues
                }
            },
            {
                title: "Statut",
                field: "whoami",
                sorter: "string",
                headerFilter: "list",
                headerFilterParams: {
                    values: whoamiValues
                },
                editor: "list",
                editorParams: {
                    values: whoamiValues
                }
            },
            {
                title: "Section",
                field: "section",
                sorter: "string",
                headerFilter: "list",
                headerFilterParams: {
                    values: sectionValues
                },
                editor: "list",
                editorParams: {
                    values: sectionValues
                }
            },
            {
                title: "N'iveau d'étude",
                field: "grade",
                sorter: "string",
                headerFilter: "list",
                headerFilterParams: {
                    values: gradeValues
                },
                editor: "list",
                editorParams: {
                    values: gradeValues
                }
            },
            {
                title: "Etat d'accès",
                field: "status",
                sorter: "string",
                headerFilter: "list",
                headerFilterParams: {
                    values: statusValues
                },
                editor: "list",
                editorParams: {
                    values: statusValues
                }
            },
            {
                title: "Actions",
                field: "id",
                formatter: function(cell, formatterParams, onRendered) {
                    return '<a href="" role="button" onclick="return update_user(' + cell.getValue() + ');">Mettre à jour</a>';
                }
            }
        ]
    });

    let details = document.getElementById("details");
    //update a user's info
    function update_user(id) {
        var row = table.getRow(id);
        var rowData = row.getData();
        console.log(rowData);

        let formData = new FormData();
        for (let row in rowData) {
            formData.append(row, rowData[row]);
        }
        formData.append("return_page", "professors");
        sendForm(formData, "user_update", details);

        return false;
    }

    //print button
    document.getElementById("print-table").addEventListener("click", function() {
        table.print(false, true);
    });
</script>

<?php
include_once("footer.php");
?>