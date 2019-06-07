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
	// Aqui  coloquei aqui que o próprio exercício Passou
	$categorias = [
		'Roupas',
		'Calçados',
		'Acessórios',
	];

	//  a que  chamei aqui para persistência que lá dentro tem as duas funções Uma que pega da sessão e grava no arquivo e outra que pega do arquivo e joga para sessão
	include 'persistencia.php';
	jsonToSession();

	// Aqui estou perguntando se existe um parâmetro get  ["apagar"] esse na sessão dentro da posição ["produtos"] existe um produto com o número que veio do parâmetro ["apagar"] 
	if(isset($_GET['apagar']) && isset($_SESSION['produtos'][$_GET['apagar']])) {
		// Se existe esse produto na sessão então remove essa posição do array
		unset($_SESSION['produtos'][$_GET['apagar']]);
		// Depois grava a sessão no json que é o arquivo
		sessionToJson();
	}

	// Aqui a gente faz uma pergunta se existe a posição ["nome"] vinda do post e se existe a posição ["foto"] vida do files
	if(!empty($_POST['Nome']) && !empty($_FILES['Foto'])) {

		// Criei aqui um array com todas as informações necessárias do produto
		$produto = [
			'Nome' => $_POST['Nome'],
			'Descrição' => $_POST['Descrição'],
			'Categoria' => $_POST['Categoria'],
			'Quantidade' => $_POST['Quantidade'],
			'Preço' => $_POST['Preço']
		];

		// Crei uma variável para armazenar o nome de um arquivo estamos utilizando a função time do PHP que vai ser importante para a gente evitar o problema de ter mais de um arquivo com o mesmo nome
		$novoNomeDoArquivo = time() . ".jpg";

		// Aqui a Gente Tá confirmando se existe a posição ["foto"] do $_FILES e depois a gente está confirmando que a pessoa realmente fez o upload de um arquivo
		if(isset($_FILES['Foto']) && !empty($_FILES['Foto']['tmp_name'])) {
			// Se a pessoa realmente fez o pelo do arquivo a gente move ele da pasta temporária padrão do PHP para essa pasta atual com o nome do arquivo que estava na variável que a gente criou logo ali em cima
			move_uploaded_file($_FILES['Foto']['tmp_name'], $novoNomeDoArquivo);
			// Por fim a gente armazena o nome do arquivo na posição ["Foto"] desse vetor produto
			$produto['Foto'] = $novoNomeDoArquivo;
		}
		// Se a pessoa não enviou nenhum arquivo a gente pergunta se ela está editando o produto,  isso é necessário para que a gente não perca o nome do arquivo que já existia nesse produto
		else if( isset($_GET['editar']) ) {
			$produto['Foto'] = $_SESSION['produtos'][$_GET['editar']]['Foto'];
		}

		// Aqui a gente pergunta se a pessoa está editando esse produto já existia
		if(isset($_GET['editar']) && isset($_SESSION['produtos'][$_GET['editar']])) {
			$_SESSION['produtos'][$_GET['editar']] = $produto;
		} else {
			// Se não existia ele é armazena numa posição nova do vetor
			$_SESSION['produtos'][] = $produto;
		}

 		// Por fim salva a sessão no arquivo 
		sessionToJson();
	}
	?>

	<div class="container">

		<div class="mb-5"></div>

		<div class="row">
			
			<div class="col-7">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Código</th>
							<th>Nome</th>
							<th>Categoria</th>
							<th>Preço</th>
							<th>Ações</th>
						</tr>
					</thead>
					<tbody>
						<?php if (isset($_SESSION['produtos'])): ?>
							<?php foreach ($_SESSION['produtos'] as $key => $produto): ?>
								<tr>
									<td><?php echo $key ?></td>
									<td><a href="produto.php?produto=<?php echo $key ?>"><?php echo $produto['Nome'] ?></a></td>
									<td><?php echo $produto['Categoria'] ?></td>
									<td><?php echo $produto['Preço'] ?></td>
									<td>
										<a href="./?editar=<?php echo $key ?>">Editar</a>
										<a href="./?apagar=<?php echo $key ?>">Apagar</a>
									</td>
								</tr>
							<?php endforeach ?>
						<?php endif ?>
					</tbody>
				</table>

			</div>
			<div class="col-5">
				<div class="jumbotron">
					<h4 class="">
						<?php if (isset($_GET['editar'])): ?>
							Editar produto
							<?php else: ?>
								Cadastrar produto
							<?php endif ?>
						</h4>
						<div class="mb-4"></div>
						<form method="post" action="" enctype="multipart/form-data">
							<!-- Aqui a gente faz uma pergunta se existe o parâmetro editar no $_GET isso é importante pois o input index só deve existir se a pessoa estiver editando -->
							<?php if (isset($_GET['editar'])): ?>
								<div class="form-group row">
									<label for="Index" class="form-control-label col-12"><b>Código</b></label>
									<div class="col-12">
										<input type="text" class="form-control" name="Index" value="<?php echo $_GET['editar'] ?>" id="Index" placeholder="Posição do produto no array" readonly>
									</div>
								</div>
							<?php endif ?>
							<div class="form-group row">
								<label for="Nome" class="form-control-label col-12"><b>Nome</b></label>
								<div class="col-12">
									<input type="text" class="form-control" name="Nome" id="Nome" placeholder="Nome">
								</div>
							</div>
							<div class="form-group row">
								<label for="Categoria" class="form-control-label col-12"><b>Categoria</b></label>
								<div class="col-12">
									<select value="<?php echo $_SESSION['produtos'][$_GET['editar']]['Categoria'] ?>" name="Categoria" id="Categoria" class="form-control">
										<?php foreach ($categorias as $key => $categoria): ?>
											<option value="<?php echo $categoria ?>"><?php echo $categoria ?></option>
										<?php endforeach ?>
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

		<?php if (isset($_GET['editar'])): ?>
			<!-- Antes de executar esse código JavaScript abaixo a gente precisa perguntar se existe o parâmetro ["editar"] no GET para só então montar essas linhas que vão colocar os valores iniciais nos campos do formulário de um produto que já existia -->
			<script>
				$("#Nome").val('<?php echo $_SESSION['produtos'][$_GET['editar']]['Nome'] ?>');
				$("#Categoria").val('<?php echo $_SESSION['produtos'][$_GET['editar']]['Categoria'] ?>');
				$("#Quantidade").val('<?php echo $_SESSION['produtos'][$_GET['editar']]['Quantidade'] ?>');
				$("#Descrição").val('<?php echo $_SESSION['produtos'][$_GET['editar']]['Descrição'] ?>');
				$("#Preço").val('<?php echo $_SESSION['produtos'][$_GET['editar']]['Preço'] ?>');
			</script>
		<?php endif ?>
	</body>
	</html>