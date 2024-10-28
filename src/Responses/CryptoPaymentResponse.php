<?php

namespace Blackoin\ApiSdk\Responses;

/**
 * Classe que representa a resposta de um pagamento em criptomoeda.
 *
 * Esta classe armazena as informações da resposta de um pagamento em criptomoeda,
 * como endereço de pagamento, URL do QR Code e ID da transação (txid).
 */
class CryptoPaymentResponse
{
    /**
     * @var string Endereço de pagamento da criptomoeda.
     */
    private string $address;

    /**
     * @var string URL do QR Code para pagamento.
     */
    private string $qrcodeUrl;

    /**
     * @var string ID da transação (txid) da criptomoeda.
     */
    private string $txid;

    /**
     * @var string Status do pagamento em criptomoeda.
     */
    private string $status;

    /**
     * Obtém o endereço de pagamento.
     *
     * @return string Endereço de pagamento da criptomoeda.
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Obtém a URL do QR Code para pagamento.
     *
     * @return string URL do QR Code para o pagamento.
     */
    public function getQrcodeUrl(): string
    {
        return $this->qrcodeUrl;
    }

    /**
     * Obtém o ID da transação (txid).
     *
     * @return string ID da transação da criptomoeda.
     */
    public function getTxid(): string
    {
        return $this->txid;
    }

    /**
     * Obtém o status do pagamento.
     *
     * @return string Status do pagamento em criptomoeda.
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Define o endereço de pagamento.
     *
     * @param string $address Endereço de pagamento da criptomoeda.
     * @return self Retorna a própria instância para encadeamento.
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Define a URL do QR Code para pagamento.
     *
     * @param string $qrcodeUrl URL do QR Code para o pagamento.
     * @return self Retorna a própria instância para encadeamento.
     */
    public function setQrcodeUrl(string $qrcodeUrl): self
    {
        $this->qrcodeUrl = $qrcodeUrl;
        return $this;
    }

    /**
     * Define o ID da transação (txid).
     *
     * @param string $txid ID da transação da criptomoeda.
     * @return self Retorna a própria instância para encadeamento.
     */
    public function setTxid(string $txid): self
    {
        $this->txid = $txid;
        return $this;
    }

    /**
     * Define o status do pagamento.
     *
     * @param string $status Status do pagamento em criptomoeda.
     * @return self Retorna a própria instância para encadeamento.
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }
}
