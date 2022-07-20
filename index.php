<?php

require_once('Ortonormalizacao.php');

/**
 * 1 [1 ponto] - Seu programa deverá receber três vetores de R3
 */

/**
 * Exemplo utilizando uma base ortonormal: 
 */ 
//$oOrtonormalizacao = new Ortonormalizacao([1, 0, 0],[0, 1, 0], [0, 0, 1]);


$oOrtonormalizacao = new Ortonormalizacao([12, 6, -4], [-51, 167, 24], [4, -68, -41]);


/**
 * 2. [2 pontos] Você deverá criar um método que retorna o produto escalar. Então, deverá exibir:
 */

echo PHP_EOL . '======{Exercício 2}========' . PHP_EOL;
echo $oOrtonormalizacao->apresentaProdutosEscalares();

/**
 * 3. [2 pontos] Você deverá criar um método que retorna a norma. Então, deverá exibir:
 */

echo PHP_EOL . '======{Exercício 3}========' . PHP_EOL;
echo $oOrtonormalizacao->apresentaNormas();

/**
 * 4. [2 pontos] Você deve criar um método que retorna a projeção. Então, deverá exibir:
 */

echo PHP_EOL . '======{Exercício 4}========' . PHP_EOL;
echo $oOrtonormalizacao->apresentaProjecoes();

/**
 * 5. [3 pontos] Você deve criar um método que realiza a ortonormalização de Gram-Schmidt.
 */

echo PHP_EOL . '======{Exercício 5}========' . PHP_EOL;
echo $oOrtonormalizacao->apresentaBaseOrtonormal();