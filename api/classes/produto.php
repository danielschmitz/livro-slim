<?php
class Produto{

	public function get_teste(){
		return true;
	}

	public function get_teste_error(){
		throw new Exception("Erro de teste");
	}

}