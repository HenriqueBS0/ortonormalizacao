<?php

class Ortonormalizacao {
    
    private $aVetorU;
    private $aVetorV;
    private $aVetorW;
    
    public function __construct($aVetorU, $aVetorV, $aVetorW) {
        $this->aVetorU = $aVetorU;
        $this->aVetorV = $aVetorV;
        $this->aVetorW = $aVetorW;
    }

    public function apresentaProdutosEscalares() {
        return implode(PHP_EOL, [
            self::getMensagemProdutoEscalar('u', $this->aVetorU, 'v', $this->aVetorV),
            self::getMensagemProdutoEscalar('v', $this->aVetorV, 'w', $this->aVetorW),
            self::getMensagemProdutoEscalar('u', $this->aVetorU, 'w', $this->aVetorW),
        ]);
    }

    private static function getMensagemProdutoEscalar($sNomePrimeiroVetor, $aPrimeiroVetor, $sNomeSegundoVetor, $aSegundoVetor) {

        $fProdutoEscalar = self::produtoEscalar($aPrimeiroVetor, $aSegundoVetor);
        $sIsOrtogonal = self::isOrtogonal($aPrimeiroVetor, $aSegundoVetor) ? 'Sim' : 'Não';

        return "Produto Escalar de {$sNomePrimeiroVetor} por {$sNomeSegundoVetor}: {$fProdutoEscalar} | É ortogonal: {$sIsOrtogonal}";
    }

    public function apresentaNormas() {
        return implode(PHP_EOL, [
            self::getMensagemNorma('u', $this->aVetorU),
            self::getMensagemNorma('v', $this->aVetorV),
            self::getMensagemNorma('w', $this->aVetorW),
        ]);
    }

    private static function getMensagemNorma($sNomeVetor, $aVetor) {
        $fNormaVetor = self::normaVetor($aVetor);
        $sIsUnitario = self::isUnitario($aVetor) ? 'Sim' : 'Não';

        return "Norma de {$sNomeVetor}: {$fNormaVetor} | É unitário: {$sIsUnitario}";
    }

    public function apresentaProjecoes() {
        return implode(PHP_EOL, [
            self::getMensagemProjecao('v', $this->aVetorV, 'u', $this->aVetorU),
            self::getMensagemProjecao('v', $this->aVetorV, 'w', $this->aVetorW),
            self::getMensagemProjecao('u', $this->aVetorU, 'v', $this->aVetorV),
        ]);
    }

    private function getMensagemProjecao($sNomeVetorProjetado, $aVetorProjetado, $sNomeVetorParalelo, $aVetorParalelo) {
        $aVetorProjecao = self::projecao($aVetorProjetado, $aVetorParalelo);
        return "A projeção de {$sNomeVetorProjetado} em {$sNomeVetorParalelo} é o vetor ({$aVetorProjecao[0]}, {$aVetorProjecao[1]}, {$aVetorProjecao[2]}) ";
    }

    public function apresentaBaseOrtonormal() {
        if($this->isBaseOrtonormal()) {
            return implode(PHP_EOL, [
                "A Base é Ortonormal",
                implode('', [
                    '{',
                    "({$this->aVetorU[0]}, {$this->aVetorU[1]}, {$this->aVetorU[2]}),",
                    "({$this->aVetorV[0]}, {$this->aVetorV[1]}, {$this->aVetorV[2]}),",
                    "({$this->aVetorW[0]}, {$this->aVetorW[1]}, {$this->aVetorW[2]})",
                    '}'
                ])
            ]);
        }

        $aBaseOrtonormal = $this->getBaseOrtonormal();

        return implode('', [
            '{',
            "({$aBaseOrtonormal[0][0]}, {$aBaseOrtonormal[0][1]}, {$aBaseOrtonormal[0][2]}),",
            "({$aBaseOrtonormal[1][0]}, {$aBaseOrtonormal[1][1]}, {$aBaseOrtonormal[1][2]}),",
            "({$aBaseOrtonormal[2][0]}, {$aBaseOrtonormal[2][1]}, {$aBaseOrtonormal[2][2]})",
            '}'
        ]);
    }


    private static function projecao($aVetorProjetado, $aVetorParalelo) {
        $aVetorProjecao = [];

        foreach ($aVetorParalelo as $fElemento) {
            $aVetorProjecao[] = (self::produtoEscalar($aVetorProjetado, $aVetorParalelo) / self::produtoEscalar($aVetorParalelo, $aVetorParalelo)) * $fElemento;
        }

        return $aVetorProjecao;
    }

    private static function isUnitario($aVetor) {
        return self::normaVetor($aVetor) == 1;
    }

    private static function normaVetor($aVetor) {
        return sqrt(self::produtoEscalar($aVetor, $aVetor));
    }

    private static function isOrtogonal($aPrimeiroVetor, $aSegundoVetor) {
        return self::produtoEscalar($aPrimeiroVetor, $aSegundoVetor) == 0;
    }

    private static function produtoEscalar($aPrimeiroVetor, $aSegundoVetor) {
        $fProdutoEscalar = 0;

        for ($iIndice=0; $iIndice < 3; $iIndice++) { 
            $fProdutoEscalar += $aPrimeiroVetor[$iIndice] * $aSegundoVetor[$iIndice];
        }

        return $fProdutoEscalar;
    }

    private function isBaseOrtonormal() {
        return 
            self::isOrtogonal($this->aVetorU, $this->aVetorV) &&
            self::isOrtogonal($this->aVetorU, $this->aVetorW) &&
            self::isOrtogonal($this->aVetorW, $this->aVetorV) &&
            self::isUnitario($this->aVetorU) &&
            self::isUnitario($this->aVetorV) &&
            self::isUnitario($this->aVetorW); 
    }

    private function getBaseOrtonormal() {
        $aBaseOrtogonal = $this->getBaseOrtogonal();

        return [
            self::divideVetorPorConstante($aBaseOrtogonal[0], self::normaVetor($aBaseOrtogonal[0])),
            self::divideVetorPorConstante($aBaseOrtogonal[1], self::normaVetor($aBaseOrtogonal[1])),
            self::divideVetorPorConstante($aBaseOrtogonal[2], self::normaVetor($aBaseOrtogonal[2])),
        ];
    }

    private function getBaseOrtogonal() {
        $aVetorX1 = $this->aVetorU;
        $aVetorX2 = self::subtraiVetores([$this->aVetorV, self::projecao($this->aVetorV, $aVetorX1)]);
        $aVetorX3 = self::subtraiVetores([$this->aVetorW, self::projecao($this->aVetorW, $aVetorX1), self::projecao($this->aVetorW, $aVetorX2)]);

        return [
            $aVetorX1,
            $aVetorX2,
            $aVetorX3,
        ];
    }

    public function subtraiVetores($aVetores) {

        $aVetorResultante = $aVetores[0];

        for ($iIndiceVeotrSubtracao = 1; $iIndiceVeotrSubtracao < count($aVetores) ; $iIndiceVeotrSubtracao++) { 
            
            for ($iIndiceElementoVetor = 0; $iIndiceElementoVetor < 3; $iIndiceElementoVetor++) { 
                $aVetorResultante[$iIndiceElementoVetor] = $aVetorResultante[$iIndiceElementoVetor] - $aVetores[$iIndiceVeotrSubtracao][$iIndiceElementoVetor];
            }

        }

        return $aVetorResultante;
    }

    public function divideVetorPorConstante($aVetor, $fCoonstante) {
        return [$aVetor[0] / $fCoonstante, $aVetor[1] / $fCoonstante, $aVetor[2] / $fCoonstante];
    }
}