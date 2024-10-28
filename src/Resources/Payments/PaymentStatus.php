<?php

namespace Blackoin\ApiSdk\Resources\Payments;

use Blackoin\ApiSdk\Exceptions\GetPaymentStatusException;
use Blackoin\ApiSdk\Http\HttpMethod;
use Blackoin\ApiSdk\Request\ClientRequest;
use JsonException;
use stdClass;

/**
 * Classe que representa o status de um pagamento.
 *
 * @author Jefferson Ataa
 */
class PaymentStatus
{
    /**
     * @var string Identificador da transação.
     */
    private string $txid;

    /**
     * @var int Valor do pagamento.
     */
    private int $amount;

    /**
     * @var string Status do pagamento.
     */
    private string $status;

    /**
     * @var ?string Data do pagamento.
     */
    private ?string $paymentDate;

    /**
     * Obtém o identificador da transação.
     *
     * @return string
     */
    public function getTxid(): string
    {
        return $this->txid;
    }

    /**
     * Obtém o valor do pagamento.
     *
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
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
     * Obtém a data do pagamento.
     *
     * @return string
     */
    public function getPaymentDate(): string
    {
        return $this->paymentDate;
    }

    /**
     * Define o identificador da transação.
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
     * Define o valor do pagamento.
     *
     * @param int $amount Valor do pagamento.
     * @return self
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
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
     * Define a data do pagamento.
     *
     * @param ?string $paymentDate Data do pagamento.
     * @return self
     */
    public function setPaymentDate(?string $paymentDate): self
    {
        $this->paymentDate = $paymentDate;
        return $this;
    }

    /**
     * Obtém o status do pagamento a partir do identificador da transação.
     *
     * @param string $txid Identificador da transação.
     * @return PaymentStatus
     * @throws GetPaymentStatusException|JsonException Se a requisição falhar ou o servidor retornar um erro.
     */
    public static function get(string $txid): PaymentStatus
    {
        $response = self::request($txid);

        $paymentStatus = new PaymentStatus();
        $paymentStatus
            ->setTxid($response->reference_code)
            ->setAmount($response->amount)
            ->setStatus($response->status)
            ->setPaymentDate($response->payment_date);

        return $paymentStatus;
    }

    /**
     * Faz a requisição para obter o status do pagamento.
     *
     * @param string $txid Identificador da transação.
     * @return stdClass
     * @throws GetPaymentStatusException|JsonException Se a requisição falhar ou o servidor retornar um erro.
     */
    private static function request(string $txid): stdClass
    {
        $request = new ClientRequest();
        $request->send("transaction/status", HttpMethod::POST, [
            'reference_code' => $txid
        ]);

        if (!$request->isSuccessful()) {
            throw new GetPaymentStatusException("A requisição para capturar o status do pagamento falhou.", $request->getError(), $request->getStatusCode());
        }

        $responsePayload = $request->getResponsePayload();

        if (!$responsePayload->success) {
            throw new GetPaymentStatusException("O servidor da blackoin retornou um erro durante o deposito.", $request->getError(), $request->getStatusCode());
        }

        return $responsePayload->data;
    }
}
