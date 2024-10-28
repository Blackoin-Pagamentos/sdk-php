<?php

namespace Blackoin\ApiSdk\Resources;

/**
 * Classe Receiver
 *
 * Representa o destinatário com informações de tipo de documento e número de documento.
 *
 * @author Jefferson Ataa
 */
class Receiver
{
    /**
     * Tipo de documento do destinatário.
     *
     * @var string
     */
    private string $documentType;

    /**
     * Número do documento do destinatário.
     *
     * @var string
     */
    private string $documentNumber;

    /**
     * Obtém o tipo de documento do destinatário.
     *
     * @return string Tipo de documento
     */
    public function getDocumentType(): string
    {
        return $this->documentType;
    }

    /**
     * Obtém o número do documento do destinatário.
     *
     * @return string Número do documento
     */
    public function getDocumentNumber(): string
    {
        return $this->documentNumber;
    }

    /**
     * Define o tipo de documento do destinatário.
     *
     * @param string $documentType Tipo de documento
     * @return self
     */
    public function setDocumentType(string $documentType): self
    {
        $this->documentType = $documentType;
        return $this;
    }

    /**
     * Define o número do documento do destinatário.
     *
     * @param string $documentNumber Número do documento
     * @return self
     */
    public function setDocumentNumber(string $documentNumber): self
    {
        $this->documentNumber = $documentNumber;
        return $this;
    }
}
