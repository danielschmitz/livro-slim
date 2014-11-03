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

	public function post_inserir($produto){

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

	public function get_listar($id){

		$sql = "SELECT id,nome FROM Produtos";

		if ($id!=null)
		{
			$sql .= " WHERE id=:id";
		}

		$stmt = DB::prepare($sql);

		if ($id!=null)
		{
			$stmt->bindValue("id", $id);
		}

		$stmt->execute();

		return $stmt->fetchAll();
	}

	public function put_editar($produto){

		if(empty($produto->id))
			throw new Exception("Identificador do produto não encontrado");
		
		//Verificação simpĺes para verificar se o id existe
		$sql = "SELECT * FROM Produtos WHERE id=:id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam("id", $produto->id);
		$stmt->execute();
		$produtoEncontrado = $stmt->fetchAll();
		if ($produtoEncontrado==null)
		{
			throw new Exception("Produto não cadastrado");
		}
		

		//Verificação simpĺes para o nome do produto nao ser o mesmo
		$sql = "SELECT id,nome FROM Produtos WHERE nome=:nome";
		$stmt = DB::prepare($sql);
		$stmt->bindParam("nome", $produto->nome);
		$stmt->execute();
		$produtoEncontrado = $stmt->fetchAll();
		if ($produtoEncontrado)
		{
			throw new Exception("Produto existente");
		}

		// Editando o produto
		$sql = "UPDATE Produtos SET nome=:nome WHERE id=:id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam("nome", $produto->nome);
		$stmt->bindParam("id", $produto->id);
		$stmt->execute();

		return $produto;

	}
	
	public function delete_remover($produto){

		if(empty($produto->id))
			throw new Exception("Identificador do produto não encontrado");
		
		//Verificação simples para verificar se o id existe
		$sql = "SELECT * FROM Produtos WHERE id=:id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam("id", $produto->id);
		$stmt->execute();
		$produtoEncontrado = $stmt->fetchAll();
		if ($produtoEncontrado==null)
		{
			throw new Exception("Produto não cadastrado");
		}
		

		// Editando o produto
		$sql = "DELETE FROM Produtos WHERE id=:id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam("id", $produto->id);
		$stmt->execute();

		return true;

	}
	
	




}