<?php

use app\core\entity\Publication;
use app\core\model\PublicationModel;

if($_FILES) {
    $user_name = $_POST['user_name'];
    
    $tmp_name = $_FILES['publications']['tmp_name'];

    $stream = fopen($tmp_name, "r");

    while(!feof($stream)) {
        $citeAs = fgets($stream);
        $doi = fgets($stream);
        $year = fgets($stream);

        if($citeAs != null && $doi != null && $year != null) {
            (new PublicationModel)->add(
                new Publication(
                    0, $user_name, $citeAs, $doi, $year, new DateTime(), false
                )
                );
            
            echo "Cite as : " . $citeAs . "<br>";
            echo "DOI : " . $doi . "<br>";    
            echo "Year : " . $year . "<br>";
        }
        
    }

    fclose($stream);
}