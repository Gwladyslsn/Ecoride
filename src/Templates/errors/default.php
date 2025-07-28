<?php

require_once ROOTHPATH.'src/templates/header.php';?>

<?php if ($error){ ?>
<div class="alert alert-danger">
    <?=$error; ?>
</div>
<?php } ?>

<?php
require_once ROOTHPATH.'/src/templates/footer.php';?>
