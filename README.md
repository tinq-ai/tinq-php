# Tinq.ai PHP Library

![Tinq.ai logo](https://res.cloudinary.com/tinq-ai/image/upload/v1642011382/website/tinq-logo-with-bee_tkaj18.svg)

A PHP wrapper for the Tinq.ai API - an easy-to-use text analysis and natural language processing toolkit.

## Documentation

Find the full API documentation [here](https://developers.tinq.ai/)

## Requirements

- PHP 8.0 or Higher

## Installation

Install the package with:

```sh
composer require tinq-ai/tinq-php
```

To use the bindings, load it via Autoload:

```php
require_once('vendor/autoload.php');
```

## Usage

### Table of Contents

- [Authentication](#authentication)
- [Rewriter](#rewriter)
- [Summarizer](#summarizer)
- [Classifier](#classifier)
- [Article Extractor](#article-extractor)
- [Sentiment Analysis](#sentiment-analysis)
- [Plagiarism Checker](#plagiarism-checker)

> Please note that all methods return associative arrays. Responses can be found in the developer documentation [here](https://developers.tinq.ai/).

### Authentication

Get the API key for your project in Tinq.ai and then instantiate a new client.

```php
$tinq = new Tinq\TinqClient("your_api_key");
```

Alternatively, set the API key and your username in an environment variable named `TINQ_API_KEY` and `TINQ_USERNAME`, respectively.

```php
$tinq = new Tinq\TinqClient();
```

### Rewriter

Rewrites or paraphrases a given text.

- `$text` - The content to rewrite.
- `$params` (optional) - A list of accepted parameters is available [here](https://developers.tinq.ai/reference/rewriter).

```php
$text = "The process of learning a new piece of music is fantastic...";
$rewritten = $tinq->rewrite($text, $params = []);
```

### Summarizer

Summarizes a given text.

- `$text` - The content to summarize.
- `$params` (optional) - A list of accepted parameters is available [here](https://developers.tinq.ai/reference/summarizer).

```php
$text = "Bernal’s case study is Tullis Mason, a chap who sports...";
$summary = $tinq->summarize($text, $params = []);
```

### Classifier

Classifies a given text according to a specified classifier.

- `$text` - The content to classify.
- `$classifier` - The classifier ID.
- `$params` (optional) - A list of accepted parameters is available [here](https://developers.tinq.ai/reference/classifier).

```php
$text = "Hi, I need help with my website.";
$classifier = "fjew833"; // Your classifier ID on Tinq.ai
$classification = $tinq->classify($text, $classifier, $params = []);
```

### Article Extractor

Extracts clean text from an article given its URL.

- `$url` - The URL to extract an article from.
- `$params` (optional) - A list of accepted parameters is available [here](https://developers.tinq.ai/reference/article-extractor).

```php
$url = "https://longreads.com/2021/08/19/bringing-species-back-from-the-brink/";
$article = $tinq->extractArticle($url, $params = []);
```

### Sentiment Analysis

Performs sentiment analysis on a given text.

- `$text` - The content to analyze.
- `$params` (optional) - A list of accepted parameters is available [here](https://developers.tinq.ai/reference/sentiment-analysis).

```php
$text = "I really like you.";
$sentimentAnalysis = $tinq->sentiments($text, $params = []);
```

### Plagiarism Checker

Checks for plagiarism and finds online sources for given content.

- `$text` - The content to check for plagiarism.
- `$params` (optional) - A list of accepted parameters is available [here](https://developers.tinq.ai/reference/plagiarism-checker).

```php
$text = "Bernal’s case study is Tullis Mason, a chap who sports...";
$plagiarismCheck = $tinq->checkPlagiarism($text, $params = []);
```

## Contributing

Bug reports and pull requests are welcome on GitHub at [https://github.com/tinq-ai/tinq-php](https://github.com/tinq-ai/tinq-php).

## License

The package is available as open source under the terms of the [MIT License](https://opensource.org/licenses/MIT).
