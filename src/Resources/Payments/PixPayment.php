<?php

namespace Blackoin\ApiSdk\Resources\Payments;

use Blackoin\ApiSdk\Exceptions\CreatePaymentException;
use Blackoin\ApiSdk\Http\HttpMethod;
use Blackoin\ApiSdk\Request\ClientRequest;
use Blackoin\ApiSdk\Resources\Client;
use Blackoin\ApiSdk\Responses\PixPaymentResponse;
use JsonException;
use stdClass;

/**
 * PixPayment
 *
 * Classe que representa um pagamento via Pix.
 *
 * @package Blackoin\ApiSdk\Resources\Payments
 * @author Jefferson Ataa
 */
class PixPayment extends Payment
{
    /**
     * Construtor da classe PixPayment.
     *
     * @param Client $client Instância do cliente para associar ao pagamento.
     */
    public function __construct(Client $client)
    {
        $this->setClient($client);
    }

    /**
     * Cria um novo pagamento via Pix.
     *
     * @return PixPaymentResponse Retorna uma instância de resposta contendo os dados do pagamento Pix.
     * @throws CreatePaymentException|JsonException Caso ocorra uma falha na requisição ou no processamento do pagamento.
     */
    public function create(): PixPaymentResponse
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
     * Monta e retorna a resposta do pagamento PIX.
     *
     * Este método cria uma nova instância de PixPaymentResponse e define os valores
     * do txid, status e do código Pix Copia e Cola com base nos dados fornecidos.
     *
     * @param stdClass $data Dados da resposta do pagamento PIX contendo o txid, status
     *                       e o código para Copia e Cola do Pix.
     * @return PixPaymentResponse Retorna uma instância de PixPaymentResponse com os dados preenchidos.
     */
    protected function mountPaymentResponse(stdClass $data): PixPaymentResponse
    {
        $pixPaymentResponse = new PixPaymentResponse();

        $pixPaymentResponse
            ->setTxid($data->txid)
            ->setStatus($data->status)
            ->setPixCopiaECola($data->pixCopiaECola);

        return $pixPaymentResponse;
    }

    /**
     * Monta o payload de requisição para criar o pagamento via Pix.
     *
     * @return array Array contendo os dados necessários para o pagamento.
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

