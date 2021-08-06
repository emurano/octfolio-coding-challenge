<?php

namespace EricMurano\Core\Http;

/**
 * Stores a HTTP response then sends it when it's ready
 */
class HttpResponse
{
    private string $content;
    private array $headers = [];

    public function __construct()
    {
        $this->headers = [
            'Content-Type' => 'text/html'
        ];

        $this->content = '';
    }

    /**
     * Appends the given content to the end of the response's content
     * @param string $newContent
     * @return $this
     */
    public function appendContent(string $newContent): self
    {
        $this->content .= $newContent;
        return $this;
    }

    public function setContentType(string $contentType): self
    {
        return $this->setHeader('Content-Type', $contentType);
    }

    public function setHeader(string $header, string $value): self
    {
        $this->headers[$header] = $value;
        return $this;
    }

    public function sendToClient(): void
    {
        foreach ($this->headers as $header => $headerValue) {
            header($header, $headerValue);
        }

        echo $this->content;
    }
}