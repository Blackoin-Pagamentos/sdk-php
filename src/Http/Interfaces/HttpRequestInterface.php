<?php

namespace Blackoin\ApiSdk\Http\Interfaces;

/**
 * Interface HttpRequestInterface
 *
 * Esta interface define os métodos necessários para manipular
 * requisições HTTP, incluindo a adição de opções e cabeçalhos.
 */
interface HttpRequestInterface
{
    /**
     * Adiciona uma opção à requisição.
     *
     * @param string $optionName  O nome da opção a ser adicionada.
     * @param string $optionValue O valor da opção a ser adicionada.
     * @return self Retorna a instância atual para encadeamento de métodos.
     */
    public function addOption(string $optionName, string $optionValue): self;

    /**
     * Adiciona um cabeçalho à requisição.
     *
     * @param string $headerName  O nome do cabeçalho a ser adicionado.
     * @param string $headerValue O valor do cabeçalho a ser adicionado.
     * @return self Retorna a instância atual para encadeamento de métodos.
     */
    public function addHeader(string $headerName, string $headerValue): self;

    /**
     * Define múltiplos cabeçalhos para a requisição.
     *
     * @param array $headers Um array associativo de cabeçalhos onde a chave é o nome do cabeçalho e o valor é o valor do cabeçalho.
     * @return self Retorna a instância atual para encadeamento de métodos.
     */
    public function setHeaders(array $headers): self;

    /**
     * Define múltiplas opções para a requisição.
     *
     * @param array $options Um array associativo de opções onde a chave é o nome da opção e o valor é o valor da opção.
     * @return self Retorna a instância atual para encadeamento de métodos.
     */
    public function setOptions(array $options): self;

    /**
     * Define o payload para a requisição.
     *
     * Este método aceita um payload de qualquer tipo (`mixed`),
     * permitindo a configuração de dados a serem enviados na
     * requisição. Retorna a instância atual para possibilitar o
     * encadeamento de métodos.
     *
     * @param mixed $payload Os dados a serem enviados na requisição.
     * @return self Retorna a instância atual para encadeamento de métodos.
     */
    public function setPayload(mixed $payload): self;

    /**
     * Obtém os cabeçalhos definidos para a requisição.
     *
     * @return array Um array associativo de cabeçalhos definidos, onde a chave é o nome do cabeçalho e o valor é o valor do cabeçalho.
     */
    public function getHeaders(): array;

    /**
     * Obtém as opções definidas para a requisição.
     *
     * @return array Um array associativo de opções definidas, onde a chave é o nome da opção e o valor é o valor da opção.
     */
    public function getOptions(): array;

    /**
     * Obtém o payload como uma string JSON.
     *
     * Este método retorna o payload atual no formato de string JSON,
     * representando os dados que serão enviados na requisição.
     *
     * @return string A string JSON do payload.
     */
    public function getPayload(): string;

    /**
     * Executa a requisição HTTP.
     *
     * Este método deve ser implementado para enviar a requisição e retornar
     * a resposta recebida do servidor.
     *
     * @return bool|string A resposta do servidor, cujo tipo pode variar dependendo da implementação.
     */
    public function execute(): bool|string;

    /**
     * Fecha a conexão da requisição.
     *
     * Este método deve ser implementado para liberar recursos ou fechar
     * conexões abertas relacionadas à requisição.
     *
     * @return void
     */
    public function close(): void;
}
