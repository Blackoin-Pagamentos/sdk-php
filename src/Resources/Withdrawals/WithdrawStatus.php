<?php

namespace Blackoin\ApiSdk\Resources\Withdrawals;

use Blackoin\ApiSdk\Exceptions\GetWithdrawStatusException;
use Blackoin\ApiSdk\Http\HttpMethod;
use Blackoin\ApiSdk\Request\ClientRequest;
use JsonException;
use stdClass;

/**
 * Classe que representa o status de um saque.
 */
class WithdrawStatus
{
    /**
     * @var string Identificador da transação do saque.
     */
    private string $txid;

    /**
     * @var int Valor do saque.
     */
    private int $amount;

    /**
     * @var string Status do saque.
     */
    private string $status;

    /**
     * @var string|null Data de aprovação do saque (pode ser nula se não aprovado).
     */
    private ?string $approvedDate;

    /**
     * Obtém o identificador da transação do saque.
     *
     * @return string
     */
    public function getTxid(): string
    {
        return $this->txid;
    }

    /**
     * Obtém o valor do saque.
     *
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * Obtém o status do saque.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Obtém a data de aprovação do saque.
     *
     * @return string|null
     */
    public function getApprovedDate(): ?string
    {
        return $this->approvedDate;
    }

    /**
     * Define o identificador da transação do saque.
     *
     * @param string $txid Identificador da transação do saque.
     * @return self
     */
    public function setTxid(string $txid): self
    {
        $this->txid = $txid;
        return $this;
    }

    /**
     * Define o valor do saque.
     *
     * @param int $amount Valor do saque.
     * @return self
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Define o status do saque.
     *
     * @param string $status Status do saque.
     * @return self
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Define a data de aprovação do saque.
     *
     * @param string|null $approvedDate Data de aprovação do saque (pode ser nula se não aprovado).
     * @return self
     */
    public function setApprovedDate(?string $approvedDate): self
    {
        $this->approvedDate = $approvedDate;
        return $this;
    }

    /**
     * Obtém o status do saque a partir do identificador da transação.
     *
     * @param string $txid Identificador da transação do saque.
     * @return WithdrawStatus
     * @throws GetWithdrawStatusException|JsonException Se a requisição falhar ou o servidor retornar um erro.
     */
    public static function get(string $txid): WithdrawStatus
    {
        $response = self::request($txid);

        $withdrawStatus = new WithdrawStatus();
        $withdrawStatus
            ->setTxid($response->reference_code)
            ->setAmount($response->amount)
            ->setStatus($response->status)
            ->setApprovedDate($response->approved_date);

        return $withdrawStatus;
    }

    /**
     * Faz a requisição para obter o status do saque.
     *
     * @param string $txid Identificador da transação do saque.
     * @return stdClass
     * @throws GetWithdrawStatusException|JsonException Se a requisição falhar ou o servidor retornar um erro.
     */
    private static function request(string $txid): stdClass
    {
        $request = new ClientRequest();
        $request->send("withdraw/status", HttpMethod::POST, [
            'reference_code' => $txid
        ]);

        if (!$request->isSuccessful()) {
            throw new GetWithdrawStatusException("A requisição para capturar o status do saque falhou.", $request->getError(), $request->getStatusCode());
        }

        $responsePayload = $request->getResponsePayload();

        if (!$responsePayload->success) {
            throw new GetWithdrawStatusException("O servidor da blackoin retornou um erro durante o saque.", $request->getError(), $request->getStatusCode());
        }

        return $responsePayload->data;
    }
}
