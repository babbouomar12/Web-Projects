
<?php
function autoload($className)
{
  include_once"classes/$className.php";
}
spl_autoload_register('autoload');