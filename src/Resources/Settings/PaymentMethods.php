<?php

namespace Blackoin\ApiSdk\Resources\Settings;

use Blackoin\ApiSdk\Exceptions\GetPaymentMethodsException;
use Blackoin\ApiSdk\Http\HttpMethod;
use Blackoin\ApiSdk\Request\ClientRequest;
use JsonException;
use RuntimeException;
use stdClass;

class PaymentMethods
{
    /**
     * Obtém os métodos de pagamento disponíveis.
     *
     * @return stdClass Dados dos métodos de pagamento.
     * @throws RuntimeException Se houver falha de autenticação ou erro na resposta da API.
     * @throws JsonException Se o payload de resposta não estiver em um formato JSON válido.
     * @throws GetPaymentMethodsException Se a resposta da requisição não retornar com status 200.
     */
    public static function get(): stdClass
    {
        $response = self::request();
        self::handleErrors($response);

        return $response->data ?? new stdClass(); // Garante um retorno padrão.
    }

    /**
     * Realiza a requisição dos métodos de pagamento.
     *
     * @return stdClass Resposta da requisição.
     * @throws JsonException Caso o payload não esteja em um formatado válido para JSON
     * @throws GetPaymentMethodsException Dispara caso a resposta da requisição não seja 200
     */
    private static function request(): stdClass
    {
        $request = new ClientRequest();
        $request->send("settings/payment-methods", HttpMethod::GET, []);

        if (!$request->isSuccessful())
            throw new GetPaymentMethodsException("Não foi possível obter os métodos de pagamento, a requisição falhou!", $request->getError(), $request->getStatusCode());

        return $request->getResponsePayload();
    }

    /**
     * Trata erros potenciais na resposta da API.
     *
     * @param stdClass $response Resposta da API.
     * @throws RuntimeException Em caso de erros na resposta.
     */
    private static function handleErrors(stdClass $response): void
    {
        if (isset($response->message) && $response->message === "Unauthenticated.") {
            throw new RuntimeException("Não foi definido um bearer ou o informado está expirado.");
        }

        if (isset($response->success) && $response->success !== true) {
            $errorMsg = $response->message ?? "Ocorreu uma falha ao pegar os métodos de pagamento, entre em contato com o suporte!";
            throw new RuntimeException($errorMsg);
        }
    }
}
