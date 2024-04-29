<?php
    include_once "connection.php";
    include_once "compatibility/fetch.php";

    // Find the total
    $sql = "select * from VIDEO_GAMES";
    $result = $connection->query($sql);
    $total = mysqli_num_rows($result);

    // Set the limit and find the end
    $limit = 10;
    $amount = ceil($total / $limit);

    // Next/previous functionality
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
    $end = ($page - 1) * $limit;

    $sql = "select * from VIDEO_GAMES limit ?, ?";
    $statement = $connection->prepare($sql);
    $statement->bind_param("ss", $end, $limit);
    $statement->execute();
    $statement->store_result();

    $games = get($statement);

    ob_start();
    include_once "get_game.php";
    $html = ob_get_contents();
    ob_end_clean();

    echo json_encode(
        array(
            "html" => $html
        )
    );
?>
