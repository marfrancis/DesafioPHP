<?php
@session_start();
$posicaoDoArrayDoProduto = $_GET['produto'];
$produto = $_SESSION['produtos'][$posicaoDoArrayDoProduto]; ?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Detalhes do produto</title>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
	<div class="mb-5"></div>

	<div class="container">
		<div class="jumbotron">
			<div class="row">
				<div class="col-12">
					<button onclick="window.location='index.php'" class="btn btn-info">👈 Voltar pra lista de produtos</button>
				</div>
			</div>
			<div class="mb-4"></div>
			<div class="row">
				<div class="col-5">
					<img class="img-fluid" src="<?php echo $produto['Foto'] ?>" />
				</div>
				<div class="col-7">
					<h1><?php echo $produto['Nome'] ?></h1>
					<div class="col-7">
					<p>Categoria</p>
					<h5><?php echo $produto['Categoria'] ?></h5>
				</div>
				<div class="col-7">
					<p>Descrição</p>
					<h5><?php echo $produto['Descrição'] ?></h5>
				</div>
				<div class="col-7">
					<p>Preço</p>
					<h5><?php echo $produto['Preço'] ?></h5>
				</div>
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