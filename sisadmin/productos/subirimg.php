
<div>
<?php if ((isset($_POST["enviado"])) && ($_POST["enviado"] == "form1")) {
$nombre_archivo = $_FILES['userfile']['name'];
move_uploaded_file($_FILES['userfile']['tmp_name'],"productos/".$nombre_archivo);?>
<script>
document.getElementById('foto').value="<?php echo $nombre_archivo; ?>";
//sself.close();
 </script>
<?php 
}
else
{?>

<form action="subirimg.php" method="post" enctype="multipart/form-data" id="form1" width="400" >
  <p>
  
    <input name="userfile" type="file" />
    
</p>
  <p>
 
      <input type="submit" name="button" id="button" value="subir imagen"  />

</p>
<input type="hidden" name="enviado" value="form1"/>

</form>
</div>
<?php }?>
</div>

