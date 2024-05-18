<?php

use app\core\entity\User;
use app\core\entity\WhoIam;
use app\core\model\UserModel;

function getUsersAsTable(WhoIam $whoiam, $user_name_like, $color_index=0) : void {
    
    $class_colors = [
        "table-primary",
        "table-secondary",
        "table-success",
        "table-danger",
        "table-info",
        "table-warning",
        "table-active"
    ];

    echo '<table class="table table-striped">'
    .'<tr>'
    .'<th class="xxsm-hidden">Prénom</th>'
    .'<th class="xxxxxsm-hidden">Nom</th>'
    .'<th class="md-hidden">Sexe</th>'
    .'<th class="xsm-hidden">Email</th>'
    .'<th class="sm-hidden">Téléphone</th>'
    .'<th class="md-hidden">Département</th>'
    .'<th class="xxxxsm-hidden">Section</th>'
    .'<th class="xxxsm-hidden">Grade</th>'
    .'<th>Identifiant</th>'
    .'<th class="sm-hidden">Date</th>'
    .'</tr>';
    
    $users = (new UserModel)->searchUsersByUserNameLike($whoiam, $user_name_like);
    
    $index = $color_index;
    foreach($users as $user) {
        if($index >= count($class_colors)) {
            $index = 0;
        }
    
        $id = $user->getId();
        
        $dummy = '<tr class="'. $class_colors[$index] .'">'
        .'<td class="xxsm-hidden">' . $user->getFirstName() . '</td>'
        .'<td class="xxxxxsm-hidden">' . $user->getLastName() . '</td>'
        .'<td class="md-hidden">' . $user->getGender()->toText() . '</td>'
        .'<td class="xsm-hidden">' . $user->getEmail() . '</td>'
        .'<td class="sm-hidden">' . $user->getPhone() . '</td>'
        .'<td class="md-hidden">' . $user->getDepartment()->toText() . '</td>'
        .'<td class="xxxxsm-hidden">' . $user->getSection()->toText() . '</td>'
        .'<td class="xxxsm-hidden">' . $user->getGrade()->toText() . '</td>'
        .'<td>' . $user->getUserName() . '</td>'
        .'<td class="sm-hidden">' . $user->getDateIns()->format('d/m/Y') . '</td>';
        
        $dummy .= '<td>' . User::getModal($id) . '</td>';
        $dummy .= '</tr>';
    
        echo $dummy;
    
        $index++;
    }
    echo '</table>';
}

if($_POST) {
    $whoiam_id = $_POST['whoami_id'];
    $user_name_like = $_POST['user_name_like'];
    $color_index = $_POST['color_index'];

    getUsersAsTable(WhoIam::get($whoiam_id), $user_name_like, $color_index);
}