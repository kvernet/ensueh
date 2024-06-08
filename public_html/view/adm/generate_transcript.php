<?php

use app\core\entity\Gender;
use app\core\entity\Message;
use app\core\model\UserModel;

//require_once(PUBLIC_DIR . "tcpdf/tcpdf.php");

function computeAverage(array $transcripts=[]) : float {
    $sumNotes = 0;
    $sumWeights = 0;
    foreach($transcripts as $row) {
        $sumNotes += $row[1]*$row[2];
        $sumWeights += $row[2];
    }

    if($sumWeights == 0) return 0.0;

    return $sumNotes / $sumWeights;
}

function getPlace() : int {
    return 1;
}

$response = [
    "success" => false,
    "msg" => Message::getMessage(Message::ACCESS_DENIED_MSG),
    "content" => ""
];

if ($_POST) {
    try {
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
        $year = "2024 - 2025";
        $programme = $user->getGrade()->toText();
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
        $pdf->Cell(0, $text_size, $gender_name . " " . $full_name . " a complété le cycle de cours prévu au programme du " . $programme . ".", 0, 1);
        $pdf->Cell(0, $text_size, $gender_pronoun . " a obtenu les notes suivantes :", 0, 1);

        $pdf->Ln(5);

        $pdf->Cell(190, $text_size, "Année : " . $year, 0, 1, "C");

        // transcript table header
        $pdf->SetFont('dejavusans', 'B', 12);
        $pdf->Cell(80, $text_size, 'Matières', 1);
        $pdf->Cell(55, $text_size, 'Notes sur 20', 1);
        $pdf->Cell(55, $text_size, 'Coefficients', 1);
        $pdf->Ln();

        // transcript table content
        $pdf->SetFont('dejavusans', '', 12);
        $transcript = [
            ['Mécanique Quantique', 16, 10],
            ['Physique Atomique', 13, 9],
            ['Physique Statistique', 14, 10],
            ['Optique & Laser', 14, 9],
            ['Physique Nucléaire', 14.5, 8],
            ['Programmation', 18.7, 4],
            ['Chimie de l\'Environnement', 19.5, 6],
            ['Micro-Projet', 14, 4],
        ];

        foreach ($transcript as $row) {
            $pdf->Cell(80, $text_size, $row[0], 1);
            $pdf->Cell(55, $text_size, $row[1], 1);
            $pdf->Cell(55, $text_size, $row[2], 1);
            $pdf->Ln();
        }

        $pdf->Ln();

        $average = round(computeAverage($transcript), 1);

        $pdf->Cell(100, $text_size, "Moyenne : " . $average . "/20");
        $pdf->Ln();
        $pdf->Cell(100, $text_size, "Classement : 1/30");
        $pdf->Ln();
        $pdf->Cell(100, $text_size, "La moyenne de passage est de 10/20.");
        $pdf->Ln();
        $pdf->Cell(100, $text_size, "Certifié conforme à l'original des Registres de l'Ecole Normale Supérieure.");

        // signature image
        $signature = PUBLIC_DIR . 'img/transcript/signature.jpg';
        $pdf->Image($signature, 125, 240, 60, 0, 'JPG', '', 'C', false, 300, '', false, false, 0, false, false, false);

        // output the PDF
        $transcript_path = 'uploads/transcripts/' . $user_name . '.pdf';
        $pdf->Output(PUBLIC_DIR . $transcript_path, 'F');

        $response['msg'] = "Relevé de notes de " . $full_name . " généré avec succès.";
        $response['content'] = APP_DOMAIN . $transcript_path;
    } catch (Exception $e) {
        $response['msg'] = $e->getMessage();
    }
}

header('Content-Type: application/json');
echo json_encode($response);