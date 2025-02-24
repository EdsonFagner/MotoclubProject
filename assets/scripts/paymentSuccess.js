//Função para esperar um tempo pré-definido
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

//Criando função para redirecionar para a página de pagamento mensal
async function countRedir (){
    for (var x = 5; x > 0; x--){
        document.querySelector('.contador').innerHTML = x;
        await new Promise(r => setTimeout(r, 1000));
    }
    document.location = 'monthly.php';
    
}

//Chamando função de redirecionamento
countRedir();