<?php

namespace Blackoin\ApiSdk\Responses;

/**
 * Classe que representa a resposta de um pagamento via Pix.
 */
class PixPaymentResponse
{
    /**
     * @var string Identificador da transação (TXID).
     */
    private string $txid;

    /**
     * @var string Status do pagamento.
     */
    private string $status;

    /**
     * @var string Código Pix para cópia e cola.
     */
    private string $pixCopiaECola;

    /**
     * Obtém o identificador da transação (TXID).
     *
     * @return string
     */
    public function getTxid(): string
    {
        return $this->txid;
    }

    /**
     * Define o identificador da transação (TXID).
     *
     * @param string $txid Identificador da transação.
     * @return self
     */
    public function setTxid(string $txid): self
    {
        $this->txid = $txid;
        return $this;
    }

    /**
     * Obtém o status do pagamento.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Define o status do pagamento.
     *
     * @param string $status Status do pagamento.
     * @return self
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Obtém o código Pix para cópia e cola.
     *
     * @return string
     */
    public function getPixCopiaECola(): string
    {
        return $this->pixCopiaECola;
    }

    /**
     * Define o código Pix para cópia e cola.
     *
     * @param string $pixCopiaECola Código Pix para cópia e cola.
     * @return self
     */
    public function setPixCopiaECola(string $pixCopiaECola): self
    {
        $this->pixCopiaECola = $pixCopiaECola;
        return $this;
    }
}
