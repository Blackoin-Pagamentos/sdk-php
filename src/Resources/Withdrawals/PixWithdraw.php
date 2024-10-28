<?php

namespace Blackoin\ApiSdk\Resources\Withdrawals;

use Blackoin\ApiSdk\Exceptions\CreateWithdrawException;
use Blackoin\ApiSdk\Http\HttpMethod;
use Blackoin\ApiSdk\Request\ClientRequest;
use Blackoin\ApiSdk\Responses\WithdrawResponse;
use JsonException;
use stdClass;

/**
 * Classe PixWithdraw
 *
 * Representa uma operação de saque via Pix, utilizando uma chave Pix e um valor associado.
 *
 * @author Jefferson Ataa
 */
class PixWithdraw extends Withdraw
{
    /**
     * Chave Pix utilizada para o saque.
     *
     * @var string
     */
    private string $key;

    /**
     * Valor associado à chave Pix.
     *
     * @var string
     */
    private string $value;

    /**
     * Construtor da classe PixWithdraw.
     *
     * @param string $key Chave Pix para o saque
     * @param string $value Valor associado à chave Pix
     */
    public function __construct(string $key, string $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * Obtém a chave Pix utilizada para o saque.
     *
     * @return string Chave Pix
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Obtém o valor associado à chave Pix.
     *
     * @return string Valor da chave Pix
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Cria uma nova transação de saque via Pix.
     *
     * @return WithdrawResponse Objeto contendo o identificador da transação de saque
     * @throws CreateWithdrawException|JsonException Se a criação do saque falhar
     */
    public function create(): WithdrawResponse
    {
        $response = $this->request();

        $withdrawResponse = new WithdrawResponse();
        $withdrawResponse->setIdentifier($response->identifier);

        return $withdrawResponse;
    }

    /**
     * Envia uma solicitação para realizar o saque via Pix.
     *
     * @return stdClass Objeto contendo a resposta da requisição de saque
     * @throws CreateWithdrawException|JsonException Se a solicitação para criação do saque falhar ou se o servidor retornar erro
     */
    protected function request(): stdClass
    {
        $request = new ClientRequest();

        $client = $this->getClient();
        $receiver = $this->getReceiver();

        $request->send("withdraw", HttpMethod::POST, [
            'amount' => $this->getAmount(),
            'hash' => $this->getPaymentMethodHash(),
            'receiver' => [
                'identifier' => $client->getIdentifier(),
                'document' => $client->getDocument(),
                'name' => $client->getName(),
                'email' => $client->getEmail(),
                'document_type' => $receiver->getDocumentType(),
                'document_number' => $receiver->getDocumentNumber(),
            ],
            'dict' => [
                'key' => $this->getKey(),
                'value' => $this->getValue(),
            ]
        ]);

        if (!$request->isSuccessful()) {
            throw new CreateWithdrawException("Falha ao realizar a solicitação para criação do saque em pix.", $request->getError(), $request->getStatusCode());
        }

        $payloadResponse = $request->getResponsePayload();

        if (!$payloadResponse->success) {
            throw new CreateWithdrawException("O servidor da Blackoin retornou uma falha ao processar a informação do saque em pix.", $request->getError(), $request->getStatusCode());
        }

        return $payloadResponse->data;
    }
}
