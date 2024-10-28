<?php

namespace Blackoin\ApiSdk\Http;

use Blackoin\ApiSdk\Http\Interfaces\HttpRequestInterface;
use JsonException;
use RuntimeException;

class HttpRequest implements HttpRequestInterface
{
    private array $headers = [];

    private array $options = [];

    private string $payload;


    /**
     * Adiciona uma opção à requisição.
     *
     * @param string $optionName O nome da opção a ser adicionada.
     * @param string $optionValue O valor da opção a ser adicionada.
     * @return self Retorna a instância atual para encadeamento de métodos.
     */
    public function addOption(string $optionName, string $optionValue): HttpRequestInterface
    {
        $this->options[$optionName] = $optionValue;
        return $this;
    }

    /**
     * Adiciona um cabeçalho à requisição.
     *
     * @param string $headerName O nome do cabeçalho a ser adicionado.
     * @param string $headerValue O valor do cabeçalho a ser adicionado.
     * @return self Retorna a instância atual para encadeamento de métodos.
     */
    public function addHeader(string $headerName, string $headerValue): HttpRequestInterface
    {
        $this->headers[$headerName] = $headerValue;
        return $this;
    }

    /**
     * Define múltiplos cabeçalhos para a requisição.
     *
     * @param array $headers Um array associativo de cabeçalhos onde a chave é o nome do cabeçalho e o valor é o valor do cabeçalho.
     * @return self Retorna a instância atual para encadeamento de métodos.
     */
    public function setHeaders(array $headers): HttpRequestInterface
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Define múltiplas opções para a requisição.
     *
     * @param array $options Um array associativo de opções onde a chave é o nome da opção e o valor é o valor da opção.
     * @return self Retorna a instância atual para encadeamento de métodos.
     */
    public function setOptions(array $options): HttpRequestInterface
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Define o payload da requisição.
     *
     * Aceita tanto uma string quanto dados de tipos variados. Se o payload fornecido
     * não for uma string, ele é convertido para JSON. Caso a conversão falhe, uma
     * exceção é lançada.
     *
     * @param mixed $payload Os dados a serem definidos como payload da requisição.
     * @throws JsonException Caso o payload não seja uma string e a conversão para JSON falhe.
     * @return HttpRequestInterface Retorna a instância atual para encadeamento de métodos.
     */
    public function setPayload(mixed $payload): HttpRequestInterface
    {
        if (!is_string($payload)) {
            $jsonPayload = json_encode($payload);

            if ($jsonPayload === false)
                throw new JsonException("Não foi possível converter o payload da requisição para JSON.");

            $this->payload = $jsonPayload;
            return $this;
        }

        $this->payload = $payload;
        return $this;
    }

    /**
     * Obtém os cabeçalhos definidos para a requisição.
     *
     * @return array Um array associativo de cabeçalhos definidos, onde a chave é o nome do cabeçalho e o valor é o valor do cabeçalho.
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Obtém as opções definidas para a requisição.
     *
     * @return array Um array associativo de opções definidas, onde a chave é o nome da opção e o valor é o valor da opção.
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Obtém o payload como uma string JSON.
     *
     * Este método retorna o payload atual no formato de string JSON,
     * representando os dados que serão enviados na requisição.
     *
     * @return string A string JSON do payload.
     */
    public function getPayload(): string
    {
        return $this->payload;
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
        throw new RuntimeException("Método para executar a requisição não foi implementado.");
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
        throw new RuntimeException("Método para fechar a requisição não foi implementado.");
    }
}
