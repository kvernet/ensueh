<?php

use app\core\entity\Single;
use app\core\model\SingleModel;
use app\core\model\SubjectModel;

$params['nav_item_active'] = "Notes";

include_once("header.php");

echo '<h3 style="text-align: center;">Gestion des notes des étudiants</h3>';

function getSinglesAsOptions(array $singles): string {
    $result = "";
    foreach ($singles as $single) {
        $result .= '<option value="' . $single->getId() . '">' . $single->getContent() . '</option>';
    }
    return $result;
}

function getSubjectsAsOptions(Single $section, Single $grade): string {
    if ($grade == null) return "";

    $subjects = (new SubjectModel)->getSubjectsBySectionGrade($section->getId(), $grade->getId());
    $result = "";
    foreach ($subjects as $subject) {
        $result .= '<option value="' . $subject->getId() . '">' . $subject->getName() . '</option>';
    }
    return $result;
}

$sections = (new SingleModel)->setTable("sections")->getAll();
$grades = (new SingleModel)->setTable("grades")->getAll();
error_log(json_encode($grades));

echo '<div class="row">'
    . '<div class="col-lg-3 col-md-6 mb-3">'
    . '<select class="form-select" name="section" id="section" onchange="sectionChange()">'
    . getSinglesAsOptions($sections)
    . '</select>'
    . '</div>'

    . '<div class="col-lg-3 col-md-6 mb-3">'
    . '<select class="form-select" name="grade" id="grade" onchange="gradeChange()">'
    . getSinglesAsOptions($grades)
    . '</select>'
    . '</div>'

    . '<div class="col-lg-3 col-md-6 mb-3">'
    . '<select class="form-select" name="subject" id="subject" onchange="subjectChange()">'
    . getSubjectsAsOptions($sections[0], $grades[0])
    . '</select>'
    . '</div>'

    . '<div class="col-lg-3 col-md-6 mb-3">'
    . '<select class="form-select" name="session" id="session" onchange="sessionChange()">'
    . (new SingleModel)->setTable("sessions")->getAllAsOptions()
    . '</select>'
    . '</div>'

    . '</div>'
    . '<span class="error-msg" id="details"></span>'
    . '<div id="student-notes"></div>';
?>

<script>
    var section = document.getElementById("section");
    var grade = document.getElementById("grade");
    var subject = document.getElementById('subject');
    var session = document.getElementById("session");
    var details = document.getElementById("details");
    var table = null;

    function sectionChange() {
        setSubjects();
    }

    function gradeChange() {
        setSubjects();
    }

    function setSubjects() {
        details.innerHTML = "";
        let formData = new FormData();
        formData.append("section_id", section.value);
        formData.append("grade_id", grade.value);

        setData(formData, "get_subjects", subject, updateTable);
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
                section_id: section.value,
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
                    headerFilter: "input"
                },
                {
                    title: "Actions",
                    field: "id",
                    formatter: function(cell, formatterParams, onRendered) {
                        return '<a href="" role="button" onclick="return confirm_note(' + cell.getValue() + ');">Confirmer</a>';
                    }
                },
                {
                    field: "id",
                    formatter: function(cell, formatterParams, onRendered) {
                        return '<a href="" role="button" onclick="return undo_note(' + cell.getValue() + ');">Défaire</a>';
                    }
                }
            ]
        });
    }

    function confirm_note(id) {
        details.innerHTML = "";
        let formData = new FormData();
        formData.append("grade_id", grade.value);
        formData.append("subject_id", subject.value);
        formData.append("session_id", session.value);

        var row = table.getRow(id);
        var rowData = row.getData();

        for (let row in rowData) {
            formData.append(row, rowData[row]);
        }

        saveData(formData, "confirm_note", "POST", details, null, updateTable, true);
        return false;
    }

    function undo_note(id) {
        details.innerHTML = "";
        let formData = new FormData();

        var row = table.getRow(id)
        var rowData = row.getData();
        formData.append("id", rowData["id"]);

        saveData(formData, "undo_note", "POST", details, null, updateTable, true);
        return false;
    }
</script>


<?php
include_once("footer.php");
?>