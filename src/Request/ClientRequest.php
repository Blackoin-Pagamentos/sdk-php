<?php

namespace Blackoin\ApiSdk\Request;

use Blackoin\ApiSdk\Blackoin;
use Blackoin\ApiSdk\Http\CurlHttpRequest;
use Blackoin\ApiSdk\Http\HttpMethod;
use InvalidArgumentException;
use JsonException;

/**
 * Classe ClientRequest
 *
 * Responsável por gerenciar as requisições para a API da Blackoin, utilizando
 * a classe CurlHttpRequest para configurar e enviar requisições HTTP.
 *
 * @author Jefferson Ataa
 */
class ClientRequest
{
    /**
     * Instância da classe Blackoin que gerencia a URL e o modo de depuração.
     *
     * @var Blackoin
     */
    private Blackoin $blackoin;

    /**
     * Instância de CurlHttpRequest para gerenciar a requisição HTTP.
     *
     * @var CurlHttpRequest
     */
    private CurlHttpRequest $httpRequest;

    /**
     * URL final da requisição.
     *
     * @var string
     */
    private string $uri;

    /**
     * Indica se a requisição foi bem-sucedida.
     *
     * @var bool Valor booleano que representa o sucesso da requisição.
     */
    private bool $isSuccessful;

    /**
     * Contém informações sobre a resposta da requisição HTTP.
     *
     * @var array Um array associativo que inclui detalhes como código HTTP, tempo total da requisição, URL efetiva,
     *            tamanho do conteúdo, tempos de lookup, conexão e transferência, tamanho do cabeçalho e contagem de redirecionamentos.
     */
    private array $responseInfo;

    /**
     * Contém o payload da resposta da requisição.
     *
     * @var string O corpo da resposta da requisição HTTP.
     */
    private string $responsePayload;

    /**
     * Construtor da classe ClientRequest.
     */
    public function __construct()
    {
        $this->blackoin = Blackoin::getInstance();
        $this->httpRequest = new CurlHttpRequest();
    }

    /**
     * Envia uma requisição para a API com o caminho, método HTTP e corpo especificados.
     *
     * @param string $path Caminho para a requisição.
     * @param string $method Método HTTP a ser utilizado.
     * @param array $body Corpo da requisição em formato de array.
     *
     * @return void
     * @throws JsonException Caso o conteúdo não possa ser transformado em json
     */
    public function send(string $path, string $method, array $body): void
    {
        if (!HttpMethod::isValidHttpMethod($method))
            throw new InvalidArgumentException("O método http $method não é suportado pela sdk.");

        // Define o URL da requisição
        $this->setUri($path);

        // Configura cabeçalhos da requisição
        $headers = $this->buildRequestHeaders();
        $this->httpRequest->setHeaders($headers);

        // Define o corpo da requisição
        $this->httpRequest->setPayload($body);

        // Configura as opções da requisição
        $options = $this->buildRequestOptions($method);
        $this->httpRequest->setOptions($options);

        $this->execute();
    }

    /**
     * Executa a requisição
     *
     * @return void
     */
    private function execute(): void
    {
        // Executa a requisição e guarda o payload
        $this->responsePayload = $this->httpRequest->execute();

        // Guarda informações da resposta da requisição
        $this->responseInfo = $this->getResponseInfo();

        // Define se a requisição foi bem-sucedida
        $this->isSuccessful = $this->responseInfo['http_code'] === 200;
    }

    /**
     * Obtém as informações da resposta da requisição.
     * @return array Informações da resposta.
     */
    private function getResponseInfo(): array
    {
        $curlHandle = $this->httpRequest->getHandle();

        return [
            "http_code" => curl_getinfo($curlHandle, CURLINFO_HTTP_CODE),
            "total_time" => curl_getinfo($curlHandle, CURLINFO_TOTAL_TIME),
            "effective_url" => curl_getinfo($curlHandle, CURLINFO_EFFECTIVE_URL),
            "content_length" => curl_getinfo($curlHandle, CURLINFO_CONTENT_LENGTH_DOWNLOAD),
            "namelookup_time" => curl_getinfo($curlHandle, CURLINFO_NAMELOOKUP_TIME),
            "connect_time" => curl_getinfo($curlHandle, CURLINFO_CONNECT_TIME),
            "starttransfer_time" => curl_getinfo($curlHandle, CURLINFO_STARTTRANSFER_TIME),
            "header_size" => curl_getinfo($curlHandle, CURLINFO_HEADER_SIZE),
            "redirect_count" => curl_getinfo($curlHandle, CURLINFO_REDIRECT_COUNT),
            "redirect_url" => curl_getinfo($curlHandle, CURLINFO_REDIRECT_URL),
        ];
    }

    /**
     * Retorna a URL completa da requisição.
     *
     * @return string URL completa da requisição.
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Define a URL completa da requisição com base no caminho fornecido.
     *
     * @param string $path Caminho adicional para compor a URL final.
     *
     * @return void
     */
    public function setUri(string $path): void
    {
        $api = $this->blackoin->getUrl();
        $this->uri = $api . $path;
    }

    /**
     * Verifica se a requisição foi bem-sucedida.
     *
     * @return bool Retorna verdadeiro se a requisição foi bem-sucedida, caso contrário, retorna falso.
     */
    public function isSuccessful(): bool
    {
        return $this->isSuccessful;
    }

    /**
     * Obtém o payload da resposta da requisição decodificado como um objeto.
     *
     * @return object Retorna o payload da resposta como um objeto.
     *                Se o payload não for um JSON válido, pode retornar null.
     */
    public function getResponsePayload(): object
    {
        return json_decode($this->responsePayload);
    }

    /**
     * Obtém a mensagem de erro da resposta.
     *
     * Este método verifica se há um campo 'error' no payload da resposta
     * e retorna sua mensagem. Se o campo não estiver presente, uma
     * mensagem padrão é retornada, indicando que o erro não foi mapeado.
     *
     * @return string A mensagem de erro, ou uma mensagem padrão caso não haja erro mapeado.
     */
    public function getError(): string
    {
        $payload = $this->getResponsePayload();

        if (isset($payload->error)) {
            return $payload->error;
        }

        if (isset($payload->message)) {
            return $payload->message;
        }

        return "Erro não mapeado, contate o suporte da Blackoin!";
    }

    /**
     * Obtém o código de status HTTP da resposta.
     *
     * Este método retorna o código de status HTTP recebido
     * na resposta da requisição. O código pode ser utilizado para
     * verificar se a requisição foi bem-sucedida ou se ocorreu um
     * erro, conforme os padrões de códigos de status HTTP.
     *
     * @return int O código de status HTTP da resposta.
     */
    public function getStatusCode(): int
    {
        return $this->responseInfo['http_code'];
    }

    /**
     * Monta os cabeçalhos padrão para a requisição.
     *
     * @return array Array com os cabeçalhos da requisição.
     */
    private function buildRequestHeaders(): array
    {
        $headers = [
            "Content-Type: application/json",
            "Accept: application/json"
        ];

        $bearerToken = $this->blackoin->getBearerToken();

        if (!empty($bearerToken)) {
           $headers[] = "Authorization: Bearer $bearerToken";
        }

        return $headers;
    }

    /**
     * Configura as opções da requisição CURL com base no método HTTP e modo de depuração.
     *
     * @param string $method Método HTTP a ser configurado (GET, POST, PUT, DELETE).
     *
     * @return array Array de opções configuradas para a requisição CURL.
     */
    private function buildRequestOptions(string $method): array
    {
        $options = array(
            CURLOPT_URL => $this->getUri(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTPHEADER => $this->httpRequest->getHeaders(),
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_USERAGENT => "BlackoinApiSdk/1.0"
        );

        if (in_array($method, [HttpMethod::POST, HttpMethod::PUT])) {
            $options += [CURLOPT_POSTFIELDS => $this->httpRequest->getPayload()];
        }

        if ($this->blackoin->isDebugMode()) {
            $options += [CURLOPT_SSL_VERIFYPEER => false];
            $options += [CURLOPT_SSL_VERIFYHOST => false];
        }
        return $options;
    }
}
