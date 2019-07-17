<?php

// Exposes ACF fields for current block
$fields = get_fields();
echo json_encode($fields);

?>