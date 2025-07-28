<?php

require_once ROOTPATH.'src/templates/header.php';?>

<?php if ($error){ ?>
<div class="alert alert-danger">
    <?=$error; ?>
</div>
<?php } ?>

<?php
require_once ROOTPATH.'/src/templates/footer.php';?>
