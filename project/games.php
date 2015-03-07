<?php
$title = 'Juegos';
include_once('resources/templates/master.php');
head($title);
?>

<div id="panelJuego" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Nuevo juego</h3>
    </div>    
        <div class="panel-body">
                <div class="form">
				<form id="upload_form" enctype="multipart/form-data" method="post">
				<div class="col-md-6"><input type="file" name="file" id="file1" class="file" class="filestyle" data-buttonName="btn-primary"></div>
				  <input type="button" class="btn btn-primary" value="Subir Juego" onclick="uploadFile()">
				  <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
				  <h3 id="status"></h3>
				  <p id="loaded_n_total"></p>
				</div>
				  
  

				</form>
		</div>
</div>

<?php if ($_SESSION['admin_usuario']!=1){
		echo "<script type = \"text/javascript\">\n";
		echo "document.getElementById('panelJuego').style.display='none';\n";

		echo "</script>";

} ?>
                 
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Descripción</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                       include 'resources/database.php';
                       $pdo = Database::connect();
                       $sql = 'SELECT * FROM juego ORDER BY nombreJuego';
                       foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>'. utf8_encode($row['nombreJuego']) . '</td>';
                                echo '<td>'. utf8_encode($row['descJuego']) . '</td>';
                                echo '<td>';
								 echo ' ';
                                echo '<a class="btn btn-primary" href="gamePlay.php?id='.$row['idJuego'].'">Jugar</a>';
								echo ' ';
                                echo '<a class="btn btn-default" href="gameRead.php?id='.$row['idJuego'].'">Read</a>';
                                echo ' ';
                                echo '<a class="btn btn-success" href="gameUpdate.php?id='.$row['idJuego'].'">Update</a>';
                                echo ' ';
                                echo '<a class="btn btn-danger" href="gameDelete.php?id='.$row['idJuego'].'">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                       }
                       Database::disconnect();
                      ?>
                      </tbody>
                </table>


<?php
footer(); 
?>


<script type="text/javascript">
/* Script written by Adam Khoury @ DevelopPHP.com */
/* Video Tutorial: http://www.youtube.com/watch?v=EraNFJiY0Eg */
function _(el){
	return document.getElementById(el);
}
function uploadFile(){
	var file = _("file1").files[0];
	//alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("file1", file);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "gameCreate.php");
	ajax.send(formdata);
}
function progressHandler(event){
	_("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
	var percent = (event.loaded / event.total) * 100;
	_("progressBar").value = Math.round(percent);
	_("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
}
function completeHandler(event){
	_("status").innerHTML = event.target.responseText;
	_("progressBar").value = 0;
}
function errorHandler(event){
	_("status").innerHTML = "Upload Failed";
}
function abortHandler(event){
	_("status").innerHTML = "Upload Aborted";
}

$(":file").filestyle({buttonName: "btn-primary", buttonText: " Seleccionar archivo", buttonBefore: true});
</script>