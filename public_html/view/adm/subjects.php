<?php

use app\core\entity\Message;
use app\core\entity\Subject;
use app\core\entity\WhoAmI;
use app\core\model\SingleModel;
use app\core\model\UserModel;

$params['nav_item_active'] = "Cours";

include_once("header.php");

echo '<h3 style="text-align: center;">Gestion des cours des professeurs</h3>';

function getDetailDiv() : string {
    if(isset($_GET["msg_id"]) && Message::get($_GET["msg_id"]) != Message::SUCCESS_MSG) {
        return '<span class="error-msg" id="details">'. Message::getMessage(Message::get($_GET["msg_id"])) .'</span>';
    } else {
        return '<span class="error-msg" id="details"></span>';
    }
}

function getFormatedList(string $table_name, array $filteredIds = []): string {
    return (new SingleModel)->setTable($table_name)->getAllAsJSON($filteredIds);
}

echo '<div class="row">'
    . '<div class="col-lg-3 col-md-6 mb-3">'
    . '<select class="form-select" name="user_name" id="user_name" onchange="userNameChange()">'
    . ( new UserModel)->getUsersAsOptions(WhoAmI::PROFESSOR)
    . '</select>'
    . '</div>'

    . '<div class="col-lg-3 col-md-6 mb-3" id="div_add_subject">'
    . Subject::addModal()
    . '</div>'
    . '</div>'

    . getDetailDiv()
    . '<div id="professor-subjects"></div>';

?>



<script>
    var user_name = document.getElementById("user_name");
    var details = document.getElementById("details");
    const sectionValues = <?php echo getFormatedList("sections"); ?>;
    const gradeValues = <?php echo getFormatedList("grades"); ?>;
    var table = null;

    function userNameChange() {
        updateTable();
    }

    window.onload = () => {
        updateTable();
    }

    function updateTable() {
        details.innerHTML = "";
        table = new Tabulator("#professor-subjects", {
            pagination: true, //enable pagination
            paginationMode: "remote", //enable remote pagination
            paginationSize: 15,
            //paginationInitialPage: getSavedPage(),
            paginationSizeSelector: [10, 15, 25, 50, 100],
            //movableColumns: true,
            paginationCounter: "rows",
            paginationDataSent: { // Customize the parameter names sent to the server
                "page": "page",
                "size": "size",
            },
            paginationDataReceived: { // Customize the parameter names received from the server
                "last_page": "last_page",
                "data": "data",
            },

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

            ajaxURL: "get_subjects_as_table",
            placeholder: "Aucune entrée",
            ajaxParams: {
                user_name: user_name.value
            },
            ajaxConfig: "POST",

            printAsHtml: true,
            printHeader: "<h1>Liste des cours<h1>",
            printFooter: "<h2> <?= APP_NAME ?> <h2>",

            columns: [
                {
                    title: "Cours",
                    field: "name",
                    sorter: "string",
                    headerFilter: "input",
                    editor: "input",
                    validator: "required"
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
                    title: "Niveau d'étude",
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
                    title: "Note max",
                    field: "max_note",
                    sorter: "number",
                    headerFilter: "input",
                    editor: "input",
                    validator: "required"
                },
                {
                    title: "Coef",
                    field: "coef",
                    sorter: "number",
                    headerFilter: "input",
                    editor: "input",
                    validator: "required"
                },
                {
                    title: "Actions",
                    field: "id",
                    formatter: function(cell, formatterParams, onRendered) {
                        return '<a href="" role="button" onclick="return update_subject(' + cell.getValue() + ');">Modifier</a>';
                    }
                }
            ]
        });
    }

    function update_subject(id) {
        details.innerHTML = "";
        
        let formData = new FormData();
        formData.append("user_name", user_name.value);

        var row = table.getRow(id);
        var rowData = row.getData();

        for (let row in rowData) {
            formData.append(row, rowData[row]);
        }

        saveData(formData, "update_subject", "POST", details, null, updateTable, true);

        return false;
    }
</script>


<?php
include_once("footer.php");
?>