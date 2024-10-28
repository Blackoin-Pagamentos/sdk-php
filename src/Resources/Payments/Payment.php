<?php

namespace Blackoin\ApiSdk\Resources\Payments;

use Blackoin\ApiSdk\Exceptions\PaymentException;
use Blackoin\ApiSdk\Resources\Client;

/**
 * Class Payment
 *
 * Representa um pagamento com informações sobre o valor, método de pagamento e cliente associado.
 *
 * @package Blackoin\ApiSdk\Resources\Payments
 * @author Jefferson Ataa
 */
class Payment
{
    /**
     * @var int O valor do pagamento em centavos.
     */
    private int $amount;

    /**
     * @var string O método de pagamento utilizado (ex: "PIX", "Cartão de Crédito").
     */
    private string $paymentMethod;

    /**
     * @var Client O cliente que deve fazer o pagamento.
     */
    private Client $client;

    /**
     * Obtém o valor do pagamento.
     *
     * @return int O valor do pagamento em centavos.
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * Obtém o método de pagamento.
     *
     * @return string O método de pagamento utilizado.
     */
    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    /**
     * Obtém o cliente associado ao pagamento.
     *
     * @return Client O cliente que deve fazer o pagamento.
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Define o valor do pagamento.
     *
     * @param int $amount O valor a ser definido em centavos.
     *
     * @throws PaymentException Se o valor do pagamento for zero ou negativo.
     * @return self A instância atual para encadeamento de métodos.
     */
    public function setAmount(int $amount): self
    {
        if ($amount <= 0) {
            throw new PaymentException("O valor do pagamento não pode ser zero ou negativo.");
        }

        $this->amount = $amount;
        return $this;
    }

    /**
     * Define o método de pagamento.
     *
     * @param string $paymentMethod O método de pagamento a ser definido (Hash retornado na rota de consultar métodos de pagamento).
     * @return self A instância atual para encadeamento de métodos.
     */
    public function setPaymentMethod(string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    /**
     * Define o cliente associado ao pagamento.
     *
     * @param Client $client O cliente a ser associado ao pagamento.
     * @return self A instância atual para encadeamento de métodos.
     */
    public function setClient(Client $client): self
    {
        $this->client = $client;
        return $this;
    }
}
