<?php

use app\core\entity\Gender;
use app\core\entity\Message;
use app\core\model\NoteModel;
use app\core\model\UserModel;

function computeAverage(array $transcripts=[]) : float {
    $sumNotes = 0;
    $sumWeights = 0;
    foreach($transcripts as $transcript) {
        $sumNotes += $transcript['note']*$transcript['coef'];
        $sumWeights += $transcript['coef'];
    }

    if($sumWeights == 0) return 0.0;

    return $sumNotes / $sumWeights;
}

$response = [
    "success" => false,
    "msg" => Message::getMessage(Message::ACCESS_DENIED_MSG),
    "content" => ""
];

if ($_POST) {
    try {
        // notes info
        $success_note = 5;
        $average_max = 10;
        
        // student information
        $id = $_POST['id'];
        $user = (new UserModel)->getById($id);

        $user_name = $_POST['user_name'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $full_name = $user->getFullName();
        $gender = $user->getGender();
        $gender_name = $gender == Gender::MALE ? "Monsieur" : "Madame";
        $gender_pronoun = $gender == Gender::MALE ? "Il" : "Elle";
        $grade = $user->getGrade()->toText();
        $year = "2024 - 2025";
        //$programme = $user->getGrade()->toText();
        $text_size = 9;

        
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $title = 'Relevé de notes';
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('ENS UEH');
        $pdf->SetTitle($title);
        $pdf->SetKeywords('TCPDF, PDF, ENS, UEH, Relevé de notes');

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);        

        // add a page
        $pdf->AddPage();

        // centered logo image
        $logo = PUBLIC_DIR . 'img/transcript/logo.jpeg';
        $pdf->Image($logo, 75, 15, 60, 0, 'JPG', '', 'C', false, 300, '', false, false, 0, false, false, false);

        // set font for title
        $pdf->SetFont('dejavusans', 'B', 16);

        // title
        $pdf->Ln(40); // move below the logo
        $pdf->Cell(0, 10, $title, 0, 1, 'C');
        $pdf->Ln(5);

        // set font for student info
        $pdf->SetFont('dejavusans', '', 12);

        $pdf->Cell(0, $text_size, "La direction de l'Ecole Normale Supérieure (ENS) atteste et certifie par la présente que", 0, 1);
        $pdf->Cell(0, $text_size, $gender_name . " " . $full_name . " a complété le cycle de cours prévu au programme du " . $grade . ".", 0, 1);
        $pdf->Cell(0, $text_size, $gender_pronoun . " a obtenu les notes suivantes :", 0, 1);

        $pdf->Ln(5);

        $pdf->Cell(190, $text_size, "Année académique: " . $year, 0, 1, "C");

        // transcript table header
        $pdf->SetFont('dejavusans', 'B', 12);
        $pdf->Cell(80, $text_size, 'Matières', 1);
        $pdf->Cell(55, $text_size, 'Notes sur ' . $average_max, 1);
        $pdf->Cell(55, $text_size, 'Coefficients', 1);
        $pdf->Ln();

        // transcript table content
        $pdf->SetFont('dejavusans', '', 12);

        $noteModel = new NoteModel;
        $transcripts = $noteModel->getUserAllNotes($user_name, $success_note, $average_max);
        error_log(json_encode($transcripts));

        $notes = $transcripts['notes'];        
        foreach($notes as $row) {
            $pdf->Cell(80, $text_size, $row['name'], 1);
            $pdf->Cell(55, $text_size, $row['note'], 1);
            $pdf->Cell(55, $text_size, $row['coef'], 1);
            $pdf->Ln();
        }

        $pdf->Ln();

        $average = round(computeAverage($notes), 1);
        // get student place
        $place = $noteModel->getPlace($user->getGrade(), $user_name);
        $place_position = $place['position'];
        $place_total = $place['total'];

        $pdf->Cell(100, $text_size, "Moyenne : " . $average . "/" . $average_max);
        $pdf->Ln();
        $pdf->Cell(100, $text_size, "Classement : ". $place_position ."/". $place_total ."");
        $pdf->Ln();
        $pdf->Cell(100, $text_size, "La moyenne de passage est de ". $success_note ."/". $average_max .".");
        $pdf->Ln();
        $pdf->Cell(100, $text_size, "Certifié conforme à l'original des Registres de l'Ecole Normale Supérieure.");

        // signature image
        $signature = PUBLIC_DIR . 'img/transcript/signature.jpg';
        $pdf->Image($signature, 125, 240, 60, 0, 'JPG', '', 'C', false, 300, '', false, false, 0, false, false, false);

        // output the PDF
        $transcript_path = 'uploads/transcripts/' . $user_name . "-" . $grade . '.pdf';
        $pdf->Output(PUBLIC_DIR . $transcript_path, 'F');

        $response['msg'] = "Relevé de notes de " . $full_name . " généré avec succès.";
        $response['content'] = APP_DOMAIN . $transcript_path;
    } catch (Exception $e) {
        $response['msg'] = $e->getMessage();
    }
}

header('Content-Type: application/json');
echo json_encode($response);