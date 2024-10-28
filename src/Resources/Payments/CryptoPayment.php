<?php

namespace Blackoin\ApiSdk\Resources\Payments;

use Blackoin\ApiSdk\Exceptions\CreatePaymentException;
use Blackoin\ApiSdk\Http\HttpMethod;
use Blackoin\ApiSdk\Request\ClientRequest;
use Blackoin\ApiSdk\Resources\Client;
use Blackoin\ApiSdk\Responses\CryptoPaymentResponse;
use JsonException;
use stdClass;

/**
 * Classe que representa um pagamento em criptomoeda.
 *
 * Esta classe é responsável por criar um pagamento em criptomoeda,
 * enviar a solicitação e processar a resposta do servidor.
 *
 * @author Jefferson Ataa
 */
class CryptoPayment extends Payment
{
    /**
     * Construtor da classe CryptoPayment.
     *
     * @param Client $client Instância do cliente que realiza o pagamento.
     */
    public function __construct(Client $client)
    {
        $this->setClient($client);
    }

    /**
     * Cria um novo pagamento em criptomoeda.
     *
     * Este método envia uma solicitação para criar um pagamento e retorna
     * a resposta do servidor como uma instância de CryptoPaymentResponse.
     *
     * @return CryptoPaymentResponse Retorna a resposta do pagamento criado.
     * @throws CreatePaymentException|JsonException Lançada se a solicitação falhar ou o servidor retornar um erro.
     */
    public function create(): CryptoPaymentResponse
    {
        $request = new ClientRequest();

        $payload = $this->mountRequestPayload();
        $request->send("transaction", HttpMethod::POST, $payload);

        if (!$request->isSuccessful()) {
            throw new CreatePaymentException("A solicitação para criar o pagamento falhou.", $request->getError(), $request->getStatusCode());
        }

        $responsePayload = $request->getResponsePayload();

        if (!$responsePayload->success) {
            throw new CreatePaymentException("O Servidor da Blackoin retornou uma falha ao processar a informação!", $responsePayload->message);
        }

        $data = $responsePayload->data;
        return $this->mountPaymentResponse($data);
    }

    /**
     * Monta e retorna a resposta do pagamento em criptomoeda.
     *
     * Este método cria uma nova instância de CryptoPaymentResponse e define os valores
     * do txid, endereço, URL do QR Code e status com base nos dados fornecidos.
     *
     * @param stdClass $data Dados da resposta do pagamento em criptomoeda.
     * @return CryptoPaymentResponse Retorna uma instância de CryptoPaymentResponse
     *                                com os dados preenchidos.
     */
    protected function mountPaymentResponse(stdClass $data): CryptoPaymentResponse
    {
        $cryptoPaymentResponse = new CryptoPaymentResponse();

        $cryptoPaymentResponse
            ->setTxid($data->txid)
            ->setAddress($data->address)
            ->setQrcodeUrl($data->qrcode_url)
            ->setStatus($data->status);

        return $cryptoPaymentResponse;
    }

    /**
     * Monta o payload da solicitação para criar um pagamento.
     *
     * Este método cria um array com os dados necessários para enviar a
     * solicitação de criação de pagamento, incluindo informações do cliente.
     *
     * @return array Retorna um array com os dados do pagamento e do cliente.
     */
    protected function mountRequestPayload(): array
    {
        $payload = [
            'amount' => $this->getAmount(),
            'payment_method' => $this->getPaymentMethod()
        ];

        $client = $this->getClient();
        $payload['client'] = [
            'identifier' => $client->getIdentifier(),
            'name' => $client->getName(),
            'email' => $client->getEmail(),
            'document' => $client->getDocument(),
        ];

        return $payload;
    }
}
