<?php

use app\core\entity\Message;
use app\core\entity\Status;
use app\core\entity\WhoAmI;
use app\core\model\SingleModel;

include_once("header.php");

echo '<h3 style="text-align: center;">Gestion des ' . $params["whoami_title"] . '</h3>';

echo '<div>'
    . '<a href="signup?id='. $params['whoami'] .'" id="add-user" class="btn btn-danger m-3" target="_blank">Ajouter</a>'
    . '<a href="#" id="print-table" class="btn btn-success my-2">Imprimer</a>'
    . '</div>';


$messageContent = "";
if (isset($_GET["msg_id"]) && Message::get($_GET["msg_id"]) != Message::SUCCESS_MSG) {
    $messageContent = Message::getMessage(Message::get($_GET["msg_id"]));
}
echo '<span class="error-msg" id="details">' . $messageContent . '</span><br>';

function getFormatedList(string $table_name, array $filteredIds = []): string {
    return (new SingleModel)->setTable($table_name)->getAllAsJSON($filteredIds);
}

echo '<div id="user-data"></div>';
echo '<hr class="my-4">';

$transcriptAdded = $params['whoami'] == WhoAmI::STUDENT->value ? 1 : 0;
?>

<script>
    function view_transcript(transcriptAdded = true) {
        if (transcriptAdded) {
            return {
                title: "Relevé",
                field: "id",
                formatter: function(cell, formatterParams, onRendered) {
                    return '<a href="#" role="button" onclick="return download_transcript(' + cell.getValue() + ');">Télécharger</a>';
                }
            }
        }
    }

    const genderValues = <?php echo getFormatedList("genders"); ?>;
    const departmentValues = <?php echo getFormatedList("departments"); ?>;
    const whoamiValues = <?php echo getFormatedList("whoami", [$params['whoami']]); ?>;
    const sectionValues = <?php echo getFormatedList("sections"); ?>;
    const gradeValues = <?php echo getFormatedList("grades"); ?>;
    const statusValues = <?php echo getFormatedList("statuses", [
                                Status::ACTIVE->value,
                                Status::INACTIVE->value,
                                Status::ONLINE->value,
                                Status::OFFLINE->value
                            ]); ?>;

    var table = new Tabulator("#user-data", {
        pagination: true, //enable pagination
        paginationMode: "remote", //enable remote pagination
        paginationSize: 15,
        paginationInitialPage: getSavedPage(),
        paginationSizeSelector: [10, 15, 25, 50, 100],
        movableColumns: true,
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

        ajaxURL: "get_users_as_table",
        placeholder: "Aucune entrée",
        ajaxParams: {
            whoami_id: <?= $params['whoami'] ?>
        },
        ajaxConfig: "POST",

        printAsHtml: true,
        printHeader: "<h1>Liste des <?= $params['whoami_title'] ?><h1>",
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
                title: "Accès",
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
            },
            view_transcript(<?= $transcriptAdded ?>)
        ]
    });

    // Function to save the current page number to local storage
    function saveCurrentPage() {
        var currentPage = table.getPage();
        createCookie("<?= $params['current_page_cookie'] ?>", currentPage, <?= COOKIE_DURATION ?>);
    }

    // Retrieve the saved page number from local storage
    function getSavedPage() {
        return <?php echo isset($_COOKIE[$params['current_page_cookie']]) ? $_COOKIE[$params['current_page_cookie']] : 1 ?>;
    }

    let details = document.getElementById("details");
    //update a user's info
    function update_user(id) {
        saveCurrentPage();

        var row = table.getRow(id);
        var rowData = row.getData();

        let formData = new FormData();
        for (let row in rowData) {
            formData.append(row, rowData[row]);
        }
        formData.append("return_page", "<?= $params['return_page'] ?>");
        sendForm(formData, "user_update", details);

        return false;
    }

    function download_transcript(id) {
        try {
            details.innerHTML = "";
            var row = table.getRow(id);
            var rowData = row.getData();

            let transcript_path = "../uploads/transcripts/" + rowData['user_name'] + "-" + rowData['grade'] + '.pdf';
            fileExists(transcript_path)
                .then(exists => {
                    if (exists) {
                        window.open(transcript_path, "_blank");
                    } else {
                        details.innerHTML = "Le relevé de notes n'est pas encore disponible.";
                    }
                }
            )
        } catch (e) {

        }
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