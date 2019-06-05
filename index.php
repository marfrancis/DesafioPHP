<?php @session_start(); ?><!DOCTYPE html>
<html lang="pt">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Loja</title>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>

	<?php

	if(!isset($_SESSION['produtos'])) $_SESSION['produtos'] = [];

	if(!empty($_POST['Nome']) && !empty($_FILES['Foto'])) {

		$novoNomeDoArquivo = time() . ".jpg";

		if(isset($_FILES['Foto']) && isset($_FILES['Foto']['tmp_name'])) {
			move_uploaded_file($_FILES['Foto']['tmp_name'], $novoNomeDoArquivo);
		}

		$_SESSION['produtos'][] = [
			'Nome' => $_POST['Nome'],
			'Descrição' => $_POST['Descrição'],
			'Categoria' => $_POST['Categoria'],
			'Quantidade' => $_POST['Quantidade'],
			'Preço' => $_POST['Preço'],
			'Foto' => $novoNomeDoArquivo
		];

	}
	?>

	<div class="container">

		<div class="mb-5"></div>

		<div class="row">
			
			<div class="col-7">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Nome</th>
							<th>Categoria</th>
							<th>Preço</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php if (isset($_SESSION['produtos'])): ?>
								<?php foreach ($_SESSION['produtos'] as $key => $produto): ?>
									<td><a href="produto.php?produto=<?php echo $key ?>"><?php echo $produto['Nome'] ?></a></td>
									<td><?php echo $produto['Categoria'] ?></td>
									<td><?php echo $produto['Preço'] ?></td>
								<?php endforeach ?>
							<?php endif ?>
						</tr>
					</tbody>
				</table>

			</div>
			<div class="col-5">
				<div class="jumbotron">
					<h4 class="">Cadastrar produto</h4>
					<div class="mb-4"></div>
					<form method="post" action="" enctype="multipart/form-data">
						<div class="form-group row">
							<label for="Nome" class="form-control-label col-12"><b>Nome</b></label>
							<div class="col-12">
								<input type="text" class="form-control" name="Nome" id="Nome" placeholder="Nome">
							</div>
						</div>
						<div class="form-group row">
							<label for="Categoria" class="form-control-label col-12"><b>Categoria</b></label>
							<div class="col-12">
								<select name="Categoria" id="Categoria" class="form-control">
									<option>Roupas</option>
									<option>Calçados</option>
									<option>Acessórios</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="Descrição" class="form-control-label col-12"><b>Descrição</b></label>
							<div class="col-12">
								<textarea class="form-control" name="Descrição" id="Descrição" placeholder="Descrição"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label for="Quantidade" class="form-control-label col-12"><b>Quantidade</b></label>
							<div class="col-12">
								<input type="text" class="form-control" name="Quantidade" id="Quantidade" placeholder="Quantidade">
							</div>
						</div>
						<div class="form-group row">
							<label for="Preço" class="form-control-label col-12"><b>Preço</b></label>
							<div class="col-12">
								<input type="text" class="form-control" name="Preço" id="Preço" placeholder="Preço">
							</div>
						</div>
						<div class="form-group row">
							<label for="Foto" class="form-control-label col-12">Foto do <b>produto</b></label>
							<div class="col-12">
								<input type="file" class="form-control" name="Foto" id="Foto" placeholder="Foto">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-offset-2 col-12 text-right">
								<button type="submit" class="btn btn-primary">Enviar</button>
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>
</html>