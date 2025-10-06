<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CrmVerificationService
{
    protected $client;
    protected $token;
    protected $apiUrl;

    public function __construct()
    {
        // Prepara o cliente Guzzle para fazer as requisições HTTP
        $this->client = new Client([
            'timeout' => 30.0, // Tempo máximo de espera pela resposta
            'verify' => false, 
            'force_ip_resolve' => 'v4',// Forçar via IPV4, pois via IPV6 dava Timeout
    ]);
    
        
        // Pega o token de forma segura do arquivo .env
        $this->token = config('app.infosimples_token');

        // URL da API
        $this->apiUrl = 'https://api.infosimples.com/api/v2/consultas/cfm/cadastro';
    }

    /**
     * Verifica o status de um CRM na API da InfoSimples.
     *
     * @param string $crm
     * @param string $uf
     * @return string|null 'regular' se o CRM estiver ativo, 'irregular' para outros casos, ou null se houver erro.
     */
    public function verify(string $crm, string $uf ): ?string
    {
        try {
            $response = $this->client->post($this->apiUrl, [
                'form_params' => [
                    'token'     => $this->token,
                    'inscricao' => $crm,
                    'uf'        => $uf,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            // Verifica se a resposta foi bem-sucedida e se há dados
            if ($data['code'] === 200 && !empty($data['data'])) {
                $situacao = $data['data'][0]['situacao'];
                
                // Log para depuração
                Log::info('Consulta de CRM bem-sucedida', ['crm' => $crm, 'uf' => $uf, 'situacao' => $situacao]);

                // Retorna 'regular' apenas se a situação for exatamente essa.
                return strtolower($situacao) === 'regular' ? 'regular' : 'irregular';
            }

            // Log em caso de resposta da API com código de erro
            Log::error('Erro na API InfoSimples', ['crm' => $crm, 'uf' => $uf, 'response' => $data]);
            return 'irregular';

        } catch (\Exception $e) {
            // Log em caso de falha na comunicação com a API
            Log::error('Falha na comunicação com a API InfoSimples', ['crm' => $crm, 'uf' => $uf, 'error' => $e->getMessage()]);
            return null; // Retorna nulo para indicar que a verificação falhou
        }
    }
}
