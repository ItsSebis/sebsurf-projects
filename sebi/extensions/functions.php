<?php

function throws() {
    $qry = "SELECT * FROM wurfel ORDER BY `time` ASC;";
    $con = con();
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $qry)) {
        header("location: ../index.php?error=1");
        exit();
    }
    mysqli_stmt_execute($stmt);
    $rs = mysqli_stmt_get_result($stmt);

    $array = array();

    while ($row = $rs->fetch_assoc()) {
        $array[] = $row;
    }
    // in_array($needle, $array) for isTeamerOfTeam
    return $array;
}