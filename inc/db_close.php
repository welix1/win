<?php
if (isset($result) && $result) {
    mysqli_free_result($result);
}
if (isset($conn)) {
    mysqli_close($conn);
}