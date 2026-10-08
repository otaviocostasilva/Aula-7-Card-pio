
<?php

// SOLICITA A CONEXÃO COM O BANCO DE DADOS
require 'conexao.php';

$consulta = $conexao->query(
    'SELECT id_lanche, nome, preco_cliente, imagem_url 
    from produto where ativo = 1 
    and preco_cliente IS NOT NULL
    and preco_cliente >= 0
    order by nome'
);
$produtos = $consulta->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanchonete do 1IDSA SRPQ</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
<main class="container">
    <p class="chamada"> CARDÁPIO FEITO NA AULA DE PBE1 </p>
    <h1>Lanchonete do 1 IDSA SRPQ</h1>
    <h2>Cardápio</h2>

    <div class="cardapio">
        <?php foreach ($produtos as $produto){ ?>
        <?php 
        $imagem = trim($produto['imagem_url'] ?? '');
        $imagemValida = filter_var($imagem, FILTER_VALIDATE_URL)
        && in_array(strtolower(parse_url($imagem, PHP_URL_SCHEME) ?? ''),
        ['http', 'https']);
        ?>

        <!-- continuação do código -->

        <article class="produto">
            <div class="foto">
                <span>Imagem indisponível</span>
                <?php if ($imagemValida) { ?>
                <img src="<?=  htmlspecialchars($imagem, ENT_QUOTES, 'UTF-8') ?>
        " alt="<?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?>">
        loading="lazy" onerror="this.remove()">
        <?php } ?>
        </div>
        <div class="detalhes">
            <span class="codigo">Código <?= $produto['id_lanche'] ?></span>
            <h3><?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?></h3>
            <p class="preco">R$ <?= number_format($produto['preco_cliente'], 2, ',', '.') ?></p>
        </div>
        </article>
        <?php } ?>

</div>
<h2>Calcular pedido</h2>
<form action="pedido.php" method="post">
<label for="id lanche"> codigo do produto:</label>
<input type="number" name="id_lanche" id="id_lanche" required>
<label form="quantidade"> Quantidade:</label>
<input type="number" name="quantidade" id="quantidade" 
min="1" max="100" required>
<button type="submit"> Calcular </button>
</form>
</main> 

</body>
</html>

