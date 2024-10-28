<?php

namespace Blackoin\ApiSdk\Http;

use CurlHandle;

class CurlHttpRequest extends HttpRequest
{
    private CurlHandle $curlHandle;

    public function __construct()
    {
        $this->curlHandle = curl_init();
    }

    /**
     * Executa a requisição HTTP.
     *
     * Este método deve ser implementado para enviar a requisição e retornar
     * a resposta recebida do servidor.
     *
     * @return bool|string A resposta do servidor, cujo tipo pode variar dependendo da implementação.
     */
    public function execute(): bool|string
    {
        curl_setopt_array($this->curlHandle, $this->getOptions());
        return curl_exec($this->curlHandle);
    }

    /**
     * Retorna o identificador do recurso CURL utilizado na requisição.
     *
     * @return CurlHandle Identificador do recurso CURL.
     */
    public function getHandle(): CurlHandle
    {
        return $this->curlHandle;
    }

    /**
     * Fecha a conexão da requisição.
     *
     * Este método deve ser implementado para liberar recursos ou fechar
     * conexões abertas relacionadas à requisição.
     *
     * @return void
     */
    public function close(): void
    {
        curl_close($this->curlHandle);
    }
}
