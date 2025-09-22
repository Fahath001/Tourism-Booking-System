<?php
header('Content-Type: application/json'); // Ensures JSON response

$db = new mysqli('localhost', 'root', '', 'travel', 3306);

if ($db->connect_error) {
    echo json_encode(["error" => "Database connection failed."]);
    exit();
}

if (isset($_POST['query'])) {
    $search = "%" . $_POST['query'] . "%"; // Allow partial matches
    $stmt = $db->prepare("SELECT pname FROM information WHERE pname LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    $output = [];
    while ($row = $result->fetch_assoc()) {
        $output[] = $row['pname'];
    }

    echo json_encode($output);
    exit();
}
?>
