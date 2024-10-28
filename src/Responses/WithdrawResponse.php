<?php

namespace Blackoin\ApiSdk\Responses;

/**
 * Classe WithdrawResponse
 *
 * Representa a resposta de uma solicitação de saque, contendo o identificador da transação.
 *
 * @author Jefferson Ataa
 */
class WithdrawResponse
{
    /**
     * Identificador da transação de saque.
     *
     * @var string
     */
    private string $identifier;

    /**
     * Obtém o identificador da transação de saque.
     *
     * @return string Identificador da transação
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Define o identificador da transação de saque.
     *
     * @param string $identifier Identificador da transação
     * @return void
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }
}
