<?php
$db = new mysqli('localhost', 'root', '', 'travel', 3306);

if ($db->connect_error) {
    die(json_encode(["error" => "Database connection failed."]));
}

if (isset($_POST['query'])) {
    $search = "%" . $_POST['query'] . "%"; // Partial match
    $stmt = $db->prepare("SELECT pname FROM information WHERE pname LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    $output = [];
    while ($row = $result->fetch_assoc()) {
        $output[] = $row['pname'];
    }

    echo json_encode($output);
}
?>
