<?php
class Produto{

	public function get_teste(){
		return true;
	}

	public function get_teste_error(){
		throw new Exception("Erro de teste");
	}

	public function post_teste($produto)
	{
		return $produto->nome;
	}

	public function post_novo($produto){

		//Verifica se nome do produto foi preenchido
		if (empty($produto->nome))
			throw new Exception("Nome do produto não pode ser vazio.");			

		//Verifica se o produto já existe
		$sqlVerificaProduto = "SELECT id,nome FROM Produtos WHERE (nome=:nome)";
		$stmtVerificaProduto = DB::prepare($sqlVerificaProduto);
		$stmtVerificaProduto->bindValue("nome", $produto->nome);
		$stmtVerificaProduto->execute();
		$produtoEncontrado = $stmtVerificaProduto->fetch();
		if ($produtoEncontrado)
            			throw new Exception("Este produto '{$produtoEncontrado->nome}' já existe.");

                	//Inserir produto
		$sql= "INSERT INTO Produtos (nome) VALUES (:nome)";
		$stmt = DB::prepare($sql);
		$stmt->bindParam("nome", $produto->nome);
		$stmt->execute();

		 $produto->id = DB::lastInsertId();
        		return $produto;

	}



}