<?php

namespace Blackoin\ApiSdk\Resources;

/**
 * Class Client
 *
 * Representa um cliente com suas informações básicas.
 *
 * @package Blackoin\ApiSdk\Resources
 * @author Jefferson Ataa
 */
class Client
{
    /**
     * @var string|null O identificador do cliente.
     */
    private ?string $identifier;

    /**
     * @var string|null O nome do cliente.
     */
    private ?string $name;

    /**
     * @var string|null O e-mail do cliente.
     */
    private ?string $email;

    /**
     * @var string|null O documento do cliente.
     */
    private ?string $document;

    /**
     * Obtém o identificador do cliente.
     *
     * @return string|null O identificador do cliente, ou null se não estiver definido.
     */
    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    /**
     * Obtém o nome do cliente.
     *
     * @return string|null O nome do cliente, ou null se não estiver definido.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Obtém o e-mail do cliente.
     *
     * @return string|null O e-mail do cliente, ou null se não estiver definido.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Obtém o documento do cliente.
     *
     * @return string|null O documento do cliente, ou null se não estiver definido.
     */
    public function getDocument(): ?string
    {
        return $this->document;
    }

    /**
     * Define o identificador do cliente.
     *
     * @param string $identifier O identificador a ser definido.
     *
     * @return Client A instância atual do cliente.
     */
    public function setIdentifier(string $identifier): Client
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * Define o nome do cliente.
     *
     * @param string $name O nome a ser definido.
     *
     * @return Client A instância atual do cliente.
     */
    public function setName(string $name): Client
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Define o e-mail do cliente.
     *
     * @param string $email O e-mail a ser definido.
     *
     * @return Client A instância atual do cliente.
     */
    public function setEmail(string $email): Client
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Define o documento do cliente.
     *
     * @param string $document O documento a ser definido.
     *
     * @return Client A instância atual do cliente.
     */
    public function setDocument(string $document): Client
    {
        $this->document = $document;
        return $this;
    }
}
