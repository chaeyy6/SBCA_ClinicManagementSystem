<?php
// process_dental_records.php
require 'db_connect.php';  // expects $conn = new PDO(...);

// Turn on exceptions for errors
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Gather inputs (no manual escaping)
$recordId         = !empty($_POST['record_id']) ? intval($_POST['record_id']) : null;
$name             = $_POST['name']             ?? '';
$age              = intval($_POST['age']      ?? 0);
$sex              = $_POST['sex']              ?? '';
$dob              = $_POST['dob']              ?? '';
$contact          = $_POST['contact']          ?? '';
$emergencyPerson  = $_POST['emergency_person'] ?? '';
$relationship     = $_POST['relationship']     ?? '';
$emergencyContact = $_POST['emergency_contact']?? '';
$examDate         = $_POST['date']             ?? '';
$level            = $_POST['level']            ?? '';
$lastVisit        = $_POST['last_visit']       ?? '';
$procedures       = $_POST['procedures']       ?? '';
$remarks          = $_POST['remarks']          ?? '';
$studentDentist   = $_POST['student_dentist']  ?? '';
$hygiene          = $_POST['hygiene']          ?? '';
$ortho            = $_POST['ortho']            ?? '';
$prophy           = $_POST['prophy']           ?? '';
$restorations     = isset($_POST['restorations']) ? 1 : 0;
$extractions      = isset($_POST['extractions'])  ? 1 : 0;

// Build tooth_chart JSON
$toothChart = [];
foreach ($_POST as $k => $v) {
    if (strpos($k, 'tooth_') === 0) {
        $toothChart[str_replace('tooth_', '', $k)] = $v;
    }
}
$toothChartJson = json_encode($toothChart);

if ($recordId) {
    // —— UPDATE existing record ——
    $sql = "
      UPDATE dental_records SET
        name             = :name,
        age              = :age,
        sex              = :sex,
        dob              = :dob,
        contact          = :contact,
        emergency_person = :emergencyPerson,
        relationship     = :relationship,
        emergency_contact= :emergencyContact,
        date             = :examDate,
        level            = :level,
        last_visit       = :lastVisit,
        procedures       = :procedures,
        hygiene          = :hygiene,
        ortho            = :ortho,
        prophy           = :prophy,
        restorations     = :restorations,
        extractions      = :extractions,
        tooth_chart      = :toothChart,
        remarks          = :remarks,
        student_dentist  = :studentDentist
      WHERE id = :id
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
      ':name'             => $name,
      ':age'              => $age,
      ':sex'              => $sex,
      ':dob'              => $dob,
      ':contact'          => $contact,
      ':emergencyPerson'  => $emergencyPerson,
      ':relationship'     => $relationship,
      ':emergencyContact' => $emergencyContact,
      ':examDate'         => $examDate,
      ':level'            => $level,
      ':lastVisit'        => $lastVisit,
      ':procedures'       => $procedures,
      ':hygiene'          => $hygiene,
      ':ortho'            => $ortho,
      ':prophy'           => $prophy,
      ':restorations'     => $restorations,
      ':extractions'      => $extractions,
      ':toothChart'       => $toothChartJson,
      ':remarks'          => $remarks,
      ':studentDentist'   => $studentDentist,
      ':id'               => $recordId
    ]);
    
    header("Location: dental_records.php?msg=updated");
    exit;

} else {
    // —— INSERT new record ——
    $sql = "
      INSERT INTO dental_records (
        name, age, sex, dob, contact,
        emergency_person, relationship, emergency_contact,
        date, level, last_visit, procedures,
        hygiene, ortho, prophy, restorations, extractions,
        tooth_chart, remarks, student_dentist
      ) VALUES (
        :name, :age, :sex, :dob, :contact,
        :emergencyPerson, :relationship, :emergencyContact,
        :examDate, :level, :lastVisit, :procedures,
        :hygiene, :ortho, :prophy, :restorations, :extractions,
        :toothChart, :remarks, :studentDentist
      )
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
      ':name'             => $name,
      ':age'              => $age,
      ':sex'              => $sex,
      ':dob'              => $dob,
      ':contact'          => $contact,
      ':emergencyPerson'  => $emergencyPerson,
      ':relationship'     => $relationship,
      ':emergencyContact' => $emergencyContact,
      ':examDate'         => $examDate,
      ':level'            => $level,
      ':lastVisit'        => $lastVisit,
      ':procedures'       => $procedures,
      ':hygiene'          => $hygiene,
      ':ortho'            => $ortho,
      ':prophy'           => $prophy,
      ':restorations'     => $restorations,
      ':extractions'      => $extractions,
      ':toothChart'       => $toothChartJson,
      ':remarks'          => $remarks,
      ':studentDentist'   => $studentDentist
    ]);

    header("Location: dental_records.php?msg=updated");
    exit;
}
