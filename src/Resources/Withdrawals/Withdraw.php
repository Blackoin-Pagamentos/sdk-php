<?php

namespace Blackoin\ApiSdk\Resources\Withdrawals;

use Blackoin\ApiSdk\Exceptions\WithdrawException;
use Blackoin\ApiSdk\Resources\Client;
use Blackoin\ApiSdk\Resources\Receiver;
use Blackoin\ApiSdk\Responses\WithdrawResponse;

/**
 * Classe Withdraw
 *
 * Representa uma operação de saque, incluindo o valor do saque, o cliente e o destinatário.
 */
class Withdraw
{
    /**
     * Valor do saque em centavos.
     *
     * @var int
     */
    private int $amount;

    /**
     * Cliente que está realizando o saque.
     *
     * @var Client
     */
    private Client $client;

    /**
     * Destinatário do saque.
     *
     * @var Receiver
     */
    private Receiver $receiver;

    /**
     * Método de pagamento utilizado para o saque. (Hash)
     *
     * @var string
     */
    private string $paymentMethodHash;

    /**
     * Obtém o valor do saque em centavos.
     *
     * @return int Valor do saque
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * Define o valor do saque em centavos.
     *
     * @param int $amount Valor do saque
     * @return self
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Obtém o cliente que está realizando o saque.
     *
     * @return Client Cliente que realiza o saque
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Define o cliente que realizará o saque.
     *
     * @param Client $client Cliente que realiza o saque
     * @return self
     */
    public function setClient(Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Obtém o destinatário do saque.
     *
     * @return Receiver Destinatário do saque
     */
    public function getReceiver(): Receiver
    {
        return $this->receiver;
    }

    /**
     * Define o destinatário do saque.
     *
     * @param Receiver $receiver Destinatário do saque
     * @return self
     */
    public function setReceiver(Receiver $receiver): self
    {
        $this->receiver = $receiver;
        return $this;
    }

    /**
     * Obtém o hash do método de pagamento.
     *
     * @return string Hash do método de pagamento
     */
    public function getPaymentMethodHash(): string
    {
        return $this->paymentMethodHash;
    }

    /**
     * Define o hash do método de pagamento.
     *
     * @param string $paymentMethodHash Hash do método de pagamento
     * @return self
     */
    public function setPaymentMethodHash(string $paymentMethodHash): self
    {
        $this->paymentMethodHash = $paymentMethodHash;
        return $this;
    }

    /**
     * Cria uma nova transação de saque.
     *
     * @return WithdrawResponse Resposta contendo o identificador da transação de saque
     * @throws WithdrawException Se a lógica de criação de saque não estiver implementada
     */
    public function create(): WithdrawResponse
    {
        throw new WithdrawException("A lógica para realizar o saque ainda não foi implementada.");
    }

    /**
     * Envia uma solicitação para realizar o saque.
     *
     * @return \stdClass Objeto contendo a resposta da requisição de saque
     * @throws WithdrawException Se a lógica de requisição de saque não estiver implementada
     */
    protected function request(): \stdClass
    {
        throw new WithdrawException("A lógica para processar a requisição de saque ainda não foi implementada.");
    }
}
