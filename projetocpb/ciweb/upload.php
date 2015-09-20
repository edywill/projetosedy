<?php 
foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
    echo $tmp_name."<br>";
}
?>