<?php

use app\core\controller\StudentController;
use app\core\entity\Course;
use app\core\entity\Grade;
use app\core\entity\Section;
use app\core\model\CourseModel;
use app\core\model\UserModel;

function getCoursesAsTable(Section $section, Grade $grade,
$title_like, array $class_colors=[], $color_index=0) : void {
    
    echo '<table class="table table-striped">'
    .'<tr>'
    .'<th class="">Titre</th>'
    .'<th class="md-hidden">Description</th>'
    .'<th class="sm-hidden">Date</th>'
    .'</tr>';

    $courses = (new CourseModel)->searchCoursesByTitleLike(
        $section, $grade, $title_like
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
        
        $dummy .= '<td>' . Course::getDisplayModal($id) . '</td>';
        $dummy .= '</tr>';
    
        echo $dummy;
    
        $index++;
    }
    echo '</table>';
}

if($_POST) {
    $user_name = StudentController::getUserName();
    $user = (new UserModel)->getByUserName($user_name);
    $section_id = $_POST['section_id'];
    $grade_id = $user->getGrade()->value;
    $title_like = $_POST['title_like'];
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

    getCoursesAsTable(Section::get($section_id), Grade::get($grade_id),
        $title_like, $class_colors, $color_index);
}