<?php

namespace Blackoin\ApiSdk\Resources\Auth;

use Blackoin\ApiSdk\Blackoin;
use Blackoin\ApiSdk\Exceptions\GetBearerTokenException;
use Blackoin\ApiSdk\Http\HttpMethod;
use Blackoin\ApiSdk\Request\ClientRequest;
use Blackoin\ApiSdk\Responses\BearerTokenResponse;
use JsonException;
use stdClass;

/**
 * Classe BlackoinBearerToken
 *
 * Responsável por gerenciar a obtenção do token Bearer da API da Blackoin.
 * Esta classe utiliza a classe ClientRequest para enviar uma requisição
 * à API e retornar a resposta formatada em um objeto BearerTokenResponse.
 *
 * @package Blackoin\ApiSdk\Resources\Auth
 * @author Jefferson Ataa
 */
class BlackoinBearerToken
{
    /**
     * Obtém um token Bearer da API da Blackoin.
     *
     * Este método estático envia uma requisição para a API e
     * retorna um objeto BearerTokenResponse contendo o token,
     * tipo de token e tempo de expiração.
     *
     * @return BearerTokenResponse O objeto BearerTokenResponse com as informações do token.
     * @throws GetBearerTokenException|JsonException Caso ocorra um erro ao obter o token.
     */
    public static function get(): BearerTokenResponse
    {
        $response = self::request();

        $bearerTokenResponse = new BearerTokenResponse();
        $bearerTokenResponse
            ->setToken($response->token)
            ->setTokenType($response->token_type)
            ->setExpiresIn($response->expires_in);

        return $bearerTokenResponse;
    }

    /**
     * Realiza a requisição para obter o token Bearer.
     *
     * Este método estático envia uma requisição à API da Blackoin
     * com as credenciais do cliente e retorna a resposta em formato
     * de objeto stdClass.
     *
     * @return stdClass O objeto contendo a resposta da API.
     * @throws GetBearerTokenException|JsonException Caso a requisição não seja bem-sucedida.
     */
    private static function request(): stdClass
    {
        [$blackoinClientId, $blackoinClientSecret] = Blackoin::getInstance()->getCredentials();

        $request = new ClientRequest();
        $request->send("token", HttpMethod::POST, ['client_id' => $blackoinClientId, 'client_secret' => $blackoinClientSecret]);

        if (!$request->isSuccessful())
            throw new GetBearerTokenException("Não foi possível obter token, a requisição falhou!", $request->getError(), $request->getStatusCode());

        return $request->getResponsePayload();
    }
}

