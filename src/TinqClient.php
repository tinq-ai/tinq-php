<?php

/**
 * Client for interacting with the Tinq.ai API.
 */

namespace Tinq;

/**
 *
 */
class TinqClient
{
    /** @var string */
    private string $apiKey;

    /** @var string */
    protected static $apiBase = 'https://tinq.ai/api/v2';

    public function __construct(?string $apiKey = null)
    {
        $this->apiKey = $apiKey ?: (string)getenv('TINQ_API_KEY');
    }

    private function getHeaders()
    {
        return [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ];
    }

    public function factory()
    {
        $client = new Api(self::$apiBase, $this->getHeaders());
        return $client;
    }


    /**
     * Summarizer wrapper for the Tinq.ai API.
     * @param array<string,mixed> $params
     * @link https://developers.tinq.ai/reference/summarizer
     */
    public function summarize(string $text, array $params = [])
    {
        $language = $params['lang'] ?? 'english';
        $tone = $params['tone'] ?? 'neutral';
        $tool = 'summarizer';
        $number = 1;
        $params['text'] = $text;
        $params['format'] = $params['format'] ?? 'paragraphs';
        $params['number'] = $params['number'] ?? '4';
        $details = $params['details'] ?? '';
        return $this->assistant($language, $tone, $tool, $number, $details, $params);
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
     * Plagiarism checker wrapper for the Tinq.ai API.
     * @param array<string,mixed> $params
     * @link https://developers.tinq.ai/reference/plagiarism-checker
     */
    public function checkPlagiarism(string $text, array $params = [])
    {
        $params['text'] = $text;
        return $this->factory()->post('/check-plagiarism', $params);
    }


    /**
     * Assistant wrapper for the Tinq.ai API.
     * @param array<string,mixed> $params
     * @link https://developers.tinq.ai/reference/assistant
     */
    public function assistant(string $language, string $tone, string $tool, int $number, string $details, array $params = [])
    {
        $params['lang'] = $language;
        $params['tone'] = $tone;
        $params['tool'] = $tool;
        $params['number'] = $number;
        $params['details'] = $details;
        return $this->factory()->post('/assistant', $params);
    }


    /**
     * Rewriter wrapper for the Tinq.ai API.
     * @param array<string,mixed> $params
     * @link https://docs.tinq.ai/v2/reference/assistant
     */

    public function rewrite(string $text, array $params = [])
    {
        $language = $params['lang'] ?? 'english';
        $tone = $params['tone'] ?? 'neutral';
        $tool = 'rewriter';
        $number = 1;
        $params['text'] = $text;
        $details = $params['details'] ?? '';
        return $this->assistant($language, $tone, $tool, $number, $details, $params);
    }
}


/**
 * Class Api
 *
 * This class provides methods to interact with the Tinq.ai API.
 * It supports GET and POST requests.
 */
class Api
{
    private $client;
    protected $url;

    public function __construct(string $url, array $headers = [])
    {
        $this->client = curl_init();
        curl_setopt_array($this->client, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_FAILONERROR => false,
        ]);
        $this->url = $url;
    }

    private function getUrl(string $url)
    {
        return $this->url . $url;
    }

    public function get(string $url, array $params = [])
    {
        $fullUrl = $this->getUrl($url) . '?' . http_build_query($params);
        curl_setopt($this->client, CURLOPT_URL, $fullUrl);
        curl_setopt($this->client, CURLOPT_HTTPGET, true);
        return $this->execute();
    }

    public function post(string $url, array $params)
    {
        curl_setopt($this->client, CURLOPT_URL, $this->getUrl($url));
        curl_setopt($this->client, CURLOPT_POST, true);
        curl_setopt($this->client, CURLOPT_POSTFIELDS, json_encode($params));
        return $this->execute();
    }

    private function execute()
    {
        $response = curl_exec($this->client);
        $status = curl_getinfo($this->client, CURLINFO_RESPONSE_CODE);

        if (curl_errno($this->client)) {
            $error_msg = curl_error($this->client);
            throw new \Exception('Tinq.ai Error Status: ' . $status . '. Message: ' . $error_msg);
        }

        curl_close($this->client);

        return json_decode($response, true);
    }
}
