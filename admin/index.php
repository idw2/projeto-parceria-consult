<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="pdf" >
<button type="submit">enviar</button>
</form> 
<?php

echo '<pre>';
print_r($_FILES);
$pdf = $_FILES['pdf'];

move_uploaded_file($pdf['tmp_name'], './' . $pdf['name']);