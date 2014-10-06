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
}