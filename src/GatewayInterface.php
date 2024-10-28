<?php

namespace Blackoin\ApiSdk;

interface GatewayInterface
{
    /**
     * Define o modo de depuração da aplicação.
     *
     * @param bool $isDebug Indica se o modo de depuração deve ser ativado (true) ou desativado (false).
     * @return self Retorna a instância atual para encadeamento de métodos.
     */
    public function setIsDebug(bool $isDebug): self;

    /**
     * Define as credenciais do cliente.
     *
     * @param string $clientId O ID do cliente.
     * @param string $clientSecret O segredo do cliente.
     * @return self Retorna a instância atual para encadeamento de métodos.
     */
    public function setCredentials(string $clientId, string $clientSecret): self;

    /**
     * Obtém a URL da API com base no modo de depuração.
     *
     * @return string A URL da API que deve ser utilizada para as requisições.
     */
    public function getUrl(): string;

    /**
     * Obtém as credenciais do cliente.
     *
     * Este método retorna um array contendo o ID do cliente e o segredo do cliente.
     *
     * @return array Um array com duas posições: [0] → `clientId`, [1] → `clientSecret`.
     */
    public function getCredentials(): array;

    /**
     * Verifica se o modo de depuração está ativado.
     *
     * Este método retorna um valor boolean que indica se o modo de depuração
     * está ativado (true) ou desativado (false).
     *
     * @return bool Retorna true se o modo de depuração estiver ativado; caso contrário, retorna false.
     */
    public function isDebugMode(): bool;
}
