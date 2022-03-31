<?php

declare(strict_types=1);

namespace Postboy\Message;

use Postboy\Contract\Message\Body\BodyInterface;
use Postboy\Contract\Message\MessageInterface;
use Postboy\Contract\Message\Recipient\ArrayRecipientCollection;
use Postboy\Contract\Message\Recipient\Recipient;
use Postboy\Contract\Message\Recipient\RecipientCollection;
use Postboy\Email\Email;

class Message implements MessageInterface
{
    /**
     * @var string[]
     */
    private array $headers = [];
    private BodyInterface $body;
    private ArrayRecipientCollection $recipients;

    final public function __construct(BodyInterface $body, ?string $subject = null)
    {
        $this->recipients = new ArrayRecipientCollection();
        $this->body = $body;
        if (!is_null($subject)) {
            $this->setHeader('Subject', $subject);
        }
    }

    final public function hasHeader(string $header): bool
    {
        $header = $this->normalizeHeaderName($header);
        return array_key_exists($header, $this->headers);
    }

    final public function getHeader(string $header): ?string
    {
        if (!$this->hasHeader($header)) {
            return null;
        }
        $header = $this->normalizeHeaderName($header);
        return $this->headers[$header];
    }

    /**
     * @return string[]
     */
    final public function getHeaders(): iterable
    {
        return $this->headers;
    }

    /**
     * @param string $header
     * @param string $value
     */
    final public function setHeader(string $header, string $value): void
    {
        $header = $this->normalizeHeaderName($header);
        $value = trim($value);
        if ($value === '') {
            $this->removeHeader($header);
            return;
        }
        if (in_array($header, ['To', 'Cc', 'Bcc'])) {
            $this->updateRecipients($header, $value);
        }
        $this->headers[$header] = $value;
    }

    /**
     * @param string $header
     */
    final public function removeHeader(string $header): void
    {
        $header = $this->normalizeHeaderName($header);
        if (!array_key_exists($header, $this->headers)) {
            return;
        }
        if (in_array($header, ['To', 'Cc', 'Bcc'])) {
            $this->updateRecipients($header, '');
        }
        unset($this->headers[$header]);
    }

    final public function getRecipients(): RecipientCollection
    {
        return $this->recipients;
    }

    final public function addRecipient(Recipient $recipient): void
    {
        $this->recipients->add($recipient);
        $this->updateRecipientHeader($recipient->getType());
    }

    final public function removeRecipient(Recipient $recipient): void
    {
        $this->recipients->remove($recipient);
        $this->updateRecipientHeader($recipient->getType());
    }

    final public function getBody(): BodyInterface
    {
        return $this->body;
    }

    final public function setBody(BodyInterface $body): void
    {
        $this->body = $body;
    }

    private function normalizeHeaderName(string $header): string
    {
        $header = strtolower($header);
        if ($header === 'mime-version') {
            return 'MIME-Version';
        }
        if ($header === 'message-id') {
            return 'Message-ID';
        }
        $fn = function ($match) {
            return strtoupper($match[0]);
        };
        return preg_replace_callback('/(^|-)[a-z]/ui', $fn, $header);
    }

    private function updateRecipients(string $header, string $value): void
    {
        $header = strtolower($header);
        $value = trim($value);
        foreach ($this->recipients as $recipient) {
            if (strtolower($recipient->getType()) === $header) {
                $this->recipients->remove($recipient);
            }
        }
        if (empty($value)) {
            return;
        }
        $values = explode(',', $value);
        foreach ($values as $value) {
            $email = Email::createFromString($value);
            $recipient = null;
            switch ($header) {
                case 'to':
                    $recipient = Recipient::to($email);
                    break;
                case 'cc':
                    $recipient = Recipient::cc($email);
                    break;
                case 'bcc':
                    $recipient = Recipient::bcc($email);
                    break;
            }
            if (!is_null($recipient)) {
                $this->recipients->add($recipient);
            }
        }
    }

    private function updateRecipientHeader(string $header): void
    {
        $header = strtolower($header);
        $values = [];
        foreach ($this->recipients as $recipient) {
            if (strtolower($recipient->getType()) !== $header) {
                continue;
            }
            $values[] = (string)$recipient->getEmail();
        }
        $this->headers[$this->normalizeHeaderName($header)] = implode(', ', $values);
    }
}
