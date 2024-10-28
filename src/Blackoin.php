<?php

namespace Blackoin\ApiSdk;

use InvalidArgumentException;
use RuntimeException;

/**
 * Classe Blackoin
 *
 * Esta classe implementa o padrão Singleton para gerenciar a instância
 * da aplicação Blackoin, fornecendo métodos para definir credenciais,
 * modo de depuração e obter a URL da API apropriada.
 *
 * @author Jefferson Ataa
 */
class Blackoin implements GatewayInterface
{
    private static Blackoin $instance;

    private bool $isDebugMode;

    private string $clientId, $clientSecret;
    private ?string $bearerToken = null;

    public function __construct(bool $isSelf = false)
    {
        if (!$isSelf)
            throw new RuntimeException("Você precisa chamar Blackoin::getInstance() e não new Blackoin()!");
    }

    /**
     * Obtém a instância única da classe Blackoin.
     *
     * Este método implementa o padrão Singleton, garantindo que
     * apenas uma instância da classe seja criada e utilizada.
     *
     * @return Blackoin A instância da classe Blackoin.
     */
    public static function getInstance(): Blackoin
    {
        if(!isset(self::$instance)){
            self::$instance = new Blackoin(true);
        }

        return self::$instance;
    }

    /**
     * Define o modo de depuração da aplicação.
     *
     * @param bool $isDebug Indica se o modo de depuração deve ser ativado (true) ou desativado (false).
     * @return self Retorna a instância atual para encadeamento de métodos.
     */
    public function setIsDebug(bool $isDebug): self
    {
        $this->isDebugMode = $isDebug;
        return $this;
    }

    /**
     * Define as credenciais do cliente.
     *
     * @param string $clientId O ID do cliente.
     * @param string $clientSecret O segredo do cliente.
     * @return self Retorna a instância atual para encadeamento de métodos.
     */
    public function setCredentials(string $clientId, string $clientSecret): self
    {
        if (empty($clientId) || empty($clientSecret)) {
            throw new InvalidArgumentException("Os credenciais `clientId` e `clientSecret` não podem ser vazios.");
        }

        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        return $this;
    }

    /**
     * Define o token de autenticação Bearer.
     *
     * @param string $bearerToken O token de autenticação Bearer a ser definido.
     *
     * @return void
     */
    public function setBearerToken(string $bearerToken): void
    {
        $this->bearerToken = $bearerToken;
    }

    /**
     * Obtém a URL da API com base no modo de depuração.
     *
     * @return string A URL da API que deve ser utilizada para as requisições.
     */
    public function getUrl(): string
    {
        return !$this->isDebugMode ? "https://app.blackoin.com/api/" : "https://staging.blackoin.com/api/";
    }

    /**
     * Obtém as credenciais do cliente.
     *
     * Este método retorna um array contendo o ID do cliente e o segredo do cliente.
     *
     * @return array Um array com duas posições: [0] → `clientId`, [1] → `clientSecret`.
     */
    public function getCredentials(): array
    {
        if (!$this->clientId || !$this->clientSecret) {
            throw new InvalidArgumentException("Você precisa definir os credenciais `clientId` e `clientSecret` da Blackoin.");
        }

        return [$this->clientId, $this->clientSecret];
    }

    /**
     * Verifica se o modo de depuração está ativado.
     *
     * Este método retorna um valor boolean que indica se o modo de depuração
     * está ativado (true) ou desativado (false).
     *
     * @return bool Retorna true se o modo de depuração estiver ativado; caso contrário, retorna false.
     */
    public function isDebugMode(): bool
    {
        return $this->isDebugMode;
    }

    /**
     * Obtém o token de autenticação Bearer.
     *
     * @return ?string O token de autenticação Bearer.
     */
    public function getBearerToken(): ?string
    {
        return $this->bearerToken;
    }
}
