<?php

namespace Blackoin\ApiSdk\Http;

/**
 * Classe que define os métodos HTTP utilizados na API.
 */
class HttpMethod
{
    /**
     * Método HTTP para requisições GET.
     *
     * @var string
     */
    public const GET = "GET";

    /**
     * Método HTTP para requisições POST.
     *
     * @var string
     */
    public const POST = "POST";

    /**
     * Método HTTP para requisições PUT.
     *
     * @var string
     */
    public const PUT = "PUT";

    /**
     * Método HTTP para requisições DELETE.
     *
     * @var string
     */
    public const DELETE = "DELETE";

    /**
     * Verifica se o método HTTP fornecido é válido.
     *
     * Este método valida se o método HTTP fornecido está entre os métodos suportados:
     * GET, POST, PUT ou DELETE.
     *
     * @param string $httpMethod O método HTTP a ser validado.
     * @return bool Retorna true se o método é válido, false caso contrário.
     */
    public static function isValidHttpMethod(string $httpMethod): bool
    {
        return in_array($httpMethod, [self::GET, self::POST, self::PUT, self::DELETE]);
    }
}
