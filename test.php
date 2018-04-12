<?php
if(isset($_POST)) {
  var_dump($_POST);
}
?>
<form action="" method="POST">
  <input type="text" name="test[]">
  <input type="text" name="test[]">
  <input type="text" name="test[]" style="display: none;">
  <input type="submit" name="cmd" value="OK">
</form>