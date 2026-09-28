<?php
	include("inc/conexao.php");
	include("configs/config.ini.php");
	@$textoBotao="Cadastrar";
	@$smarty->assign("textoBotao",$textoBotao);
	@$acao=$_REQUEST["acao"];
	@$categoria=$_POST["categoria"];
	@$linkcateg=$_POST["linkcateg"];
	// AÇÃO CADASTRAR CATEGORIA
	if($acao=="Cadastrar"){
		$queryCat = "INSERT INTO tbcategorias (categoria, linkcateg) VALUES (?,?)";
		$PDO->prepare($queryCat)->execute([$categoria, $linkcateg]);
		echo "<script>alert('Categoria Cadastrada');document.location='cad-categorias.php';</script>;";
	}
	//	AÇÃO LISTAR CATEGORIAS
	$queryGeral = $PDO->prepare("SELECT * FROM tbcategorias") or die("Erro ao Consultar Categorias");
	$queryGeral->execute();
	$respQueryGeral=$queryGeral->fetchAll(PDO::FETCH_ASSOC);
	$smarty->assign("minhasCategorias",$respQueryGeral);

	// EDITAR DADOS
	$idcat=@$_REQUEST["idcat"];
	$smarty->assign("idcat","");
	$smarty->assign("categoria","");
	$smarty->assign("linkcateg","");
	if($acao=="editar"){
		@$queryEditar = $PDO->prepare("SELECT * FROM tbcategorias WHERE idcat='$idcat'") OR DIE("Erro ao Consultar Categoria Selecionada");
		@$queryEditar->execute();
		@$respQueryEditar=$queryEditar->fetch(PDO::FETCH_OBJ);
		@$categoria=$respQueryEditar->categoria;
		@$linkcateg=$respQueryEditar->linkcateg;
		@$smarty->assign("idcat",$idcat);
		@$smarty->assign("categoria",$categoria);
		@$smarty->assign("linkcateg",$linkcateg);
		@$smarty->assign('textoBotao','Atualizar');
	}
	//ATUALIZAR DADOS
	if($acao=="Atualizar"){
		$queryUPdate=$PDO->prepare("UPDATE tbcategorais SET categoria = ?, linkcateg = ? WHERE icat = ?");
		$queryUpdate->bindParam(1,$categoria);
		$queryUpdate->bindParam(2,$linkcateg);
		$queryUPdate->bindParam(3,$idcat);
		$queryUpdate->execute();
		echo "<script>
		alert('Dados alterados');
		document.location.href='cad-categorias.php';
		</script>
		";
	}


	$smarty->display("cad-categorias.html");


?>