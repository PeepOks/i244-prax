<?php
    $file = "count.txt";
    $current = file_get_contents($file);
    $current++;
    file_put_contents($file, $current);
?>