<?php

use app\core\entity\Status;
use app\core\entity\User;
use app\core\entity\WhoIam;
use app\core\model\UserModel;

include_once("header.php");

echo '<h3 style="text-align: center;">Gestion des étudiants</h3>';

$users = (new UserModel)->getUsers(WhoIam::STUDENT);

echo '<table class="table table-striped">';

echo '<tr>'
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
.'<th>Action(s)</th>'
.'</tr>';

$class_colors = [
    "table-primary",
    "table-secondary",
    "table-success",
    "table-danger",
    "table-info",
    "table-warning",
    "table-active"
];

$index = 3;
foreach($users as $user) {
    if($index >= count($class_colors)) {
        $index = 0;
    }

    $id = $user->getId();
    
    $dummy = '<tr class="'. $class_colors[$index] .'">'
    //$dummy = '<tr>'
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

    if($user->getStatus() == Status::REQUESTED) {
        $dummy .= '<td>' . '<a href="user_validate?id='. $id .'&method=student">Valider</a>' . '</td>';
    }
    if($user->getStatus() != Status::SUSPENDED) {
        $dummy .= '<td>' . '<a href="user_suspend?id='. $id .'&method=student">Suspendre</a>' . '</td>';
    }
    
    $dummy .= '<td>' . User::getModal($id) . '</td>';
    $dummy .= '</tr>';

    echo $dummy;

    $index++;
}

echo '</table>';

include_once("footer.php");