<?php

namespace Blackoin\ApiSdk\Resources\Withdrawals;

use Blackoin\ApiSdk\Exceptions\CreateWithdrawException;
use Blackoin\ApiSdk\Http\HttpMethod;
use Blackoin\ApiSdk\Request\ClientRequest;
use Blackoin\ApiSdk\Responses\WithdrawResponse;
use JsonException;
use stdClass;

/**
 * Classe responsável pela criação de saques em criptomoeda.
 *
 * @author Jefferson Ataa
 */
class CryptoWithdraw extends Withdraw
{
    /**
     * Endereço da carteira para o saque em criptomoeda.
     *
     * @var string
     */
    private string $walletAddress;

    /**
     * Código abreviado da moeda (ex: BTC, ETH).
     *
     * @var string
     */
    private string $currencyShort;

    /**
     * Construtor da classe CryptoWithdraw.
     *
     * @param string $walletAddress Endereço da carteira de criptomoeda.
     * @param string $currencyShort Código abreviado da moeda.
     */
    public function __construct(string $walletAddress, string $currencyShort)
    {
        $this->walletAddress = $walletAddress;
        $this->currencyShort = $currencyShort;
    }

    /**
     * Obtém o endereço da carteira de criptomoeda.
     *
     * @return string
     */
    public function getWalletAddress(): string
    {
        return $this->walletAddress;
    }

    /**
     * Obtém o código abreviado da moeda.
     *
     * @return string
     */
    public function getCurrencyShort(): string
    {
        return $this->currencyShort;
    }

    /**
     * Cria o saque em criptomoeda e retorna a resposta.
     *
     * @return WithdrawResponse Resposta do saque.
     * @throws CreateWithdrawException|JsonException Se houver uma falha na criação do saque.
     */
    public function create(): WithdrawResponse
    {
        $response = $this->request();

        $withdrawResponse = new WithdrawResponse();
        $withdrawResponse->setIdentifier($response->identifier);

        return $withdrawResponse;
    }

    /**
     * Realiza a requisição para criação do saque.
     *
     * @return stdClass Dados da resposta da API.
     * @throws CreateWithdrawException|JsonException Se a requisição falhar.
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
            'crypto' => [
                'wallet_address' => $this->getWalletAddress(),
                'currency' => $this->getCurrencyShort(),
            ]
        ]);

        if (!$request->isSuccessful()) {
            throw new CreateWithdrawException("Falha ao realizar a solicitação para criação do saque em criptomoeda.", $request->getError(), $request->getStatusCode());
        }

        $payloadResponse = $request->getResponsePayload();

        if (!$payloadResponse->success) {
            throw new CreateWithdrawException("O servidor da Blackoin retornou uma falha ao processar a informação do saque em criptomoeda.", $request->getError(), $request->getStatusCode());
        }

        return $payloadResponse->data;
    }
}
