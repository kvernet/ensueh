<?php

use app\core\controller\StudentController;
use app\core\entity\Grade;
use app\core\model\UserModel;

function getTranscriptsAsTable(string $user_name, array $class_colors=[], int $color_index=0) : void {
    
    echo '<table class="table table-striped">'
    .'<tr>'
    .'<th class="">Niveau</th>'
    .'<th class="">Document PDF</th>'
    .'</tr>';

    $user = (new UserModel)->getByUserName($user_name);

    $index = $color_index;
    for($i = $user->getGrade()->value; $i >= Grade::L0->value ; $i--) {
        $grade = Grade::get($i)->toText();

        $dummy = '<tr class="'. $class_colors[$index] .'">'
        .'<td class="">' . $grade . '</td>'
        .'<td class=""><a href="#" onclick="return download_transcript(\''. $grade .'\');">Télécharger</a></td>';

        $dummy .= '</tr>';
    
        echo $dummy;
    
        $index++;
    }

    echo '</table>';
}

if($_POST) {
    $user_name = StudentController::getUserName();
    $color_index = $_POST['color_index'];

    $class_colors = [
        "table-primary",
        "table-secondary",
        "table-success",
        "table-danger",
        "table-info",
        "table-warning",
        "table-active"
    ];

    getTranscriptsAsTable($user_name, $class_colors, $color_index);
}