
//A URL para acesso ao servidor
var serverURL = "https://demo-project-c9-danielschmitz.c9.io/php/livro-slim/api/";


//Código executado quando o jquery/pagina estiverem carregados (start)
$( document ).ready(function() {
      listarProdutos();
});

//Código para adicionar um observador ao link de editar Produtos
$("#editar").live("click", function() {

    //Pego o id da linha clicada
    var id = $(this).attr("data-id");
    
    alert("id");

});


// FUNCOES



/**
 * Exibe alert de erro
 */ 
function showError(data){
    var errorMessage = data.responseJSON.error.text;
    alert("Error: " + errorMessage);
}


/**
 * Obtem os produtos da api, limpa a tabela e
 * insere novos dados na mesma.
 */ 
function listarProdutos(){
    
    //remove todos os TRs da table
    $("#produtos").find("tbody tr").remove();
    
    //Adiciona uma mensagem que a tabela está carregando
    $("#produtos").find("tbody").append('<tr><td colspan=10><div class="alert alert-success">Carregando...</div></td></tr>');

    //Realizando o Ajax chamando a API
     $.ajax({
        type: "get", //Aqui entra o método: get,post,put,delete
        url: serverURL + "produto/listar", //a url
        dataType: "json", //o tipo de dados que será trafegado
        success: function(data) { //a funcao que será executada caso de tudo certo
            
            //remover o carregando
            $("#produtos").find("tbody tr").remove();
            
            //pegando os dados que vieram do servidor 
            // Os dados vieram em JSON, e o jQuery já o transforma em Array
            // Perceba que data.result é o {result:....} que veio do servidor
            data.result.forEach(function(produto) {

                var row = "<tr>"
                        + "<td>" + produto.id
                        + "</td><td><a id='editar' href='#' data-id='" + produto.id + "'>" + produto.nome + "</a>"
                        
                        + "</td></tr>";
                $("#produtos > tbody:last").append(row);
            });
            
        },
        error: function(data){
            showError(data);
        }
    });

    
}