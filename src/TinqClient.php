<?php

namespace Tinq;

class TinqClient
{
    /** @var string */
    private $apiKey;

    /** @var string */
    private $username;

    /** @var string */
    protected static $apiBase = 'https://tinq.ai/api/v1';

    public function __construct(?string $apiKey, ?string $username = null)
    {
        $this->apiKey = $apiKey ? $apiKey : (string)getenv('TINQ_API_KEY');
        $this->username = $username ? $username : (string)getenv('TINQ_USERNAME');

        $headers = ['Content-Type: application/json', 'Authorization: Bearer ' . $this->apiKey];
    }

    public function factory()
    {
        $headers = ['Content-Type: application/json', 'Authorization: Bearer ' . $this->apiKey];

        $client = new Api(self::$apiBase, $headers);
        return $client;
    }
    

    /**
     * Rewriter wrapper for the Tinq.ai API.
     * @param array<string,mixed> $params
     * @link https://developers.tinq.ai/reference/rewriter
     */
    public function rewrite(string $text, array $params = [])
    {
        $params['text'] = $text;
        return $this->factory()->post('/rewrite', $params);
    }


    /**
     * Summarizer wrapper for the Tinq.ai API.
     * @param array<string,mixed> $params
     * @link https://developers.tinq.ai/reference/summarizer
     */
    public function summarize(string $text, array $params = [])
    {
        $params['text'] = $text;
        return $this->factory()->post('/summarize', $params);
    }
    

    /**
     * Classifier wrapper for the Tinq.ai API.
     * @param array<string,mixed> $params
     * @link https://developers.tinq.ai/reference/classifier
     */
    public function classify(string $text, string $classifier, array $params = [])
    {
        $params['text'] = $text;
        $params['classifier'] = $classifier;
        return $this->factory()->post('/classify', $params);
    }



    /**
     * Article extractor wrapper for the Tinq.ai API.
     * @param array<string,mixed> $params
     * @link https://developers.tinq.ai/reference/article-extractor
     */
    public function extractArticle(string $url, array $params = [])
    {
        $params['extract_url'] = $url;
        return $this->factory()->post('/extract-article', $params);
    }

        

    /**
     * Sentiment analysis wrapper for the Tinq.ai API.
     * @param array<string,mixed> $params
     * @link https://developers.tinq.ai/reference/sentiment-analysis
     */
    public function sentiments(string $text, array $params = [])
    {
        $params['text'] = $text;
        return $this->factory()->post('/sentiment-analysis', $params);
    }


    /**
     * Plagiarism checker wrapper for the Tinq.ai API.
     * @param array<string,mixed> $params
     * @link https://developers.tinq.ai/reference/plagiarism-checker
     */
    public function checkPlagiarism(string $text, array $params = [])
    {
        $params['text'] = $text;
        return $this->factory()->post('/check-plagiarism', $params);
    }

}


class Api
{
    /** @var \CurlHandle */
    private $client;
    /** @var string */
    protected $url;

    /**
     * @param array<int,string> $headers
     */
    public function __construct(string $url, array $headers = [])
    {
        $curlClient = curl_init();
        curl_setopt_array($curlClient, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_FAILONERROR => true,
        ]);
        $this->client = $curlClient;
        $this->url = $url;
        return $this;
    }

    private function getUrl(string $url)
    {
        return $this->url . $url;
    }

    /**
     * @param array<string,mixed> $params
     */
    public function post(string $url, array $params)
    {
        $params = array_merge($params);
        
        curl_setopt($this->client, CURLOPT_URL, $this->getUrl($url));
        curl_setopt($this->client, CURLOPT_POST, true);
        curl_setopt($this->client, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($this->client, CURLOPT_FAILONERROR, false); 
        /** @var string $res */
        $response = curl_exec($this->client);

        if (curl_errno($this->client)) {
            $error_msg = curl_error($this->client);
            $status = curl_getinfo($this->client, CURLINFO_RESPONSE_CODE);
        }

        curl_close($this->client);

        if (isset($error_msg)) {
            throw new \Exception('Tinq.ai Error Status: ' . $status . '. Message: ' . $error_msg);
        }

        return json_decode($response, true);
    }
}
