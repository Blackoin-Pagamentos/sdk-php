<?php

namespace Blackoin\ApiSdk\Responses;

/**
 * Classe BearerTokenResponse
 *
 * Representa a resposta de um token Bearer obtido da API.
 * Contém informações sobre o token, seu tipo e o tempo de expiração.
 */
class BearerTokenResponse
{
    /**
     * O token Bearer.
     *
     * @var string
     */
    private string $token;

    /**
     * O tipo do token.
     *
     * @var string
     */
    private string $token_type;

    /**
     * O tempo em segundos até que o token expire.
     *
     * @var int
     */
    private int $expires_in;

    /**
     * Obtém o token Bearer.
     *
     * @return string O token Bearer.
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Obtém o tipo do token.
     *
     * @return string O tipo do token.
     */
    public function getTokenType(): string
    {
        return $this->token_type;
    }

    /**
     * Obtém o tempo até a expiração do token.
     *
     * @return int O tempo em segundos até que o token expire.
     */
    public function getExpiresIn(): int
    {
        return $this->expires_in;
    }

    /**
     * Define o token Bearer.
     *
     * @param string $value O valor do token Bearer.
     * @return self Retorna a instância atual para encadeamento de métodos.
     */
    public function setToken(string $value): self
    {
        $this->token = $value;
        return $this;
    }

    /**
     * Define o tipo do token.
     *
     * @param string $value O valor do tipo do token.
     * @return self Retorna a instância atual para encadeamento de métodos.
     */
    public function setTokenType(string $value): self
    {
        $this->token_type = $value;
        return $this;
    }

    /**
     * Define o tempo até a expiração do token.
     *
     * @param int $value O tempo em segundos até que o token expire.
     * @return self Retorna a instância atual para encadeamento de métodos.
     */
    public function setExpiresIn(int $value): self
    {
        $this->expires_in = $value;
        return $this;
    }
}
