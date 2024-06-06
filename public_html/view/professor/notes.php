<?php

use app\core\controller\ProfessorController;
use app\core\entity\Grade;
use app\core\model\SingleModel;
use app\core\model\SubjectModel;
use app\core\model\UserModel;

$params['nav_item_active'] = "Notes";

include_once("header.php");

echo '<h3 style="text-align: center;">Gestion des notes des étudiants</h3>';

function getGradesAsOptions(array $grades): string {
    $result = "";
    foreach ($grades as $grade) {
        $result .= '<option value="' . $grade->value . '">' . $grade->toText() . '</option>';
    }
    return $result;
}

function getSubjectsAsOptions(string $user_name, Grade|null $grade): string {
    if ($grade == null) return "";

    $subjects = (new SubjectModel)->getSubjects($user_name, $grade);
    $result = "";
    foreach ($subjects as $subject) {
        $result .= '<option value="' . $subject->getId() . '">' . $subject->getName() . '</option>';
    }
    return $result;
}

$user_name = ProfessorController::getUserName();
$user = (new UserModel)->getByUserName($user_name);
$grades = (new SubjectModel)->getGrades($user_name);

echo '<div class="row">'
    . '<div class="col-lg-4 mb-3">'
    . '<select class="form-select" name="grade" id="grade" onchange="gradeChange()">'
    . getGradesAsOptions($grades)
    . '</select>'
    . '</div>'
    . '<div class="col-lg-4 mb-3">'
    . '<select class="form-select" name="subject" id="subject" onchange="subjectChange()">'
    . getSubjectsAsOptions($user_name, $grades[0])
    . '</select>'
    . '</div>'
    . '<div class="col-lg-4 mb-3">'
    . '<select class="form-select" name="session" id="session" onchange="sessionChange()">'
    . (new SingleModel)->setTable("sessions")->getAllAsOptions()
    . '</select>'
    . '</div>'
    . '</div>'
    . '<span class="error-msg" id="details"></span>'
    . '<div id="student-notes"></div>';
?>

<script>
    var section = <?= $user->getSection()->value ?>;
    var grade = document.getElementById("grade");
    var subject = document.getElementById('subject');
    var session = document.getElementById("session");
    var details = document.getElementById("details");
    var table = null;

    function gradeChange() {
        details.innerHTML = "";
        
        let formData = new FormData();
        formData.append("grade", grade.value);

        setData(formData, "get_sujects", subject, updateTable);
    }

    function subjectChange() {
        updateTable();
    }

    function sessionChange() {
        updateTable();
    }

    window.onload = () => {
        updateTable();
    }

    function updateTable() {
        details.innerHTML = "";
        
        table = new Tabulator("#student-notes", {
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

            ajaxURL: "get_notes_as_table",
            placeholder: "Aucune entrée",
            ajaxParams: {
                section_id: section,
                grade_id: grade.value,
                subject_id: subject.value,
                session_id: session.value
            },
            ajaxConfig: "POST",

            printAsHtml: true,
            printHeader: "<h1>Liste des notes<h1>",
            printFooter: "<h2> <?= APP_NAME ?> <h2>",

            columns: [{
                    title: "Identifiant",
                    field: "user_name",
                    sorter: "string",
                    headerFilter: "input"
                },
                {
                    title: "Prénom",
                    field: "first_name",
                    sorter: "string",
                    headerFilter: "input"
                },
                {
                    title: "Nom",
                    field: "last_name",
                    sorter: "string",
                    headerFilter: "input"
                },
                {
                    title: "Note",
                    field: "note",
                    sorter: "number",
                    headerFilter: "input",
                    editor: "input",
                    validator: "required"
                },
                {
                    title: "Actions",
                    field: "id",
                    formatter: function(cell, formatterParams, onRendered) {
                        return '<a href="" role="button" onclick="return update_note(' + cell.getValue() + ');">Modifier</a>';
                    }
                }
            ]
        });
    }

    function update_note(id) {
        details.innerHTML = "";
        
        let formData = new FormData();
        formData.append("grade_id", grade.value);
        formData.append("subject_id", subject.value);
        formData.append("session_id", session.value);

        var row = table.getRow(id); // Gets the row at index 3
        var rowData = row.getData(); // Get the data of the row
        console.log(rowData);

        for (let row in rowData) {
            formData.append(row, rowData[row]);
        }

        saveData(formData, "update_note", "POST", details, null, updateTable, true);

        return false;
    }
</script>


<?php
include_once("footer.php");
?>