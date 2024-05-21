<?php

use app\core\controller\ProfessorController;
use app\core\entity\Course;
use app\core\entity\Grade;
use app\core\entity\Section;
use app\core\model\CourseModel;

function getCoursesAsTable(string $user_name, Section $section, Grade $grade,
$title_like, string $return_page, $color_index=0) : void {
    
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
    .'<th class="">Titre</th>'
    .'<th class="md-hidden">Description</th>'
    .'<th class="sm-hidden">Date</th>'
    .'</tr>';

    $courses = (new CourseModel)->searchCoursesByTitleLike(
        $user_name, $section, $grade, $title_like
    );
    
    $index = $color_index;
    foreach($courses as $course) {
        if($index >= count($class_colors)) {
            $index = 0;
        }
    
        $id = $course->getId();
        
        $dummy = '<tr class="'. $class_colors[$index] .'">'
        .'<td class="">' . $course->getTitle() . '</td>'
        .'<td class="md-hidden">' . $course->getDescription() . '</td>'
        .'<td class="sm-hidden">' . $course->getDate()->format('d/m/Y') . '</td>';
        
        $dummy .= '<td>' . Course::getUpdateModal($id, $return_page) . '</td>';
        $dummy .= '<td>' . Course::getDisplayModal($id) . '</td>';
        $dummy .= '</tr>';
    
        echo $dummy;
    
        $index++;
    }
    echo '</table>';
}

if($_POST) {
    $user_name = ProfessorController::getUserName();
    $section_id = $_POST['section_id'];
    $grade_id = $_POST['grade_id'];
    $title_like = $_POST['title_like'];
    $return_page = $_POST['return_page'];
    $color_index = $_POST['color_index'];

    getCoursesAsTable($user_name, Section::get($section_id), Grade::get($grade_id),
        $title_like, $return_page, $color_index);
}