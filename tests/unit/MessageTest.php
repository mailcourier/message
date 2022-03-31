<?php

declare(strict_types=1);

namespace Tests\Postboy\Message;

use Postboy\Contract\Message\Recipient\Recipient;
use Postboy\Email\Email;
use Postboy\Message\Message;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Staff\Postboy\Message\Generator\Factory\GeneratorFactory;

class MessageTest extends TestCase
{
    public function testCreate()
    {
        $body = GeneratorFactory::bodyPart()->make();
        $subj = GeneratorFactory::randomString()->make();
        $message = new Message($body, $subj);
        Assert::assertTrue($message->hasHeader('Subject'));
        Assert::assertSame($body, $message->getBody());
        Assert::assertSame($subj, $message->getHeader('Subject'));
    }

    public function testHeaders()
    {
        $header = GeneratorFactory::randomString()->withLength(rand(8, 32))->make();
        $value = GeneratorFactory::randomString()->make();
        $message = new Message(GeneratorFactory::bodyPart()->make());
        Assert::assertFalse($message->hasHeader('Subject'));
        $message->setHeader($header, $value);
        Assert::assertSame($value, $message->getHeader($header));
        Assert::assertSame($value, $message->getHeader(strtolower($header)));
        Assert::assertSame($value, $message->getHeader(strtoupper($header)));
    }

    public function testBody()
    {
        $randomizer = GeneratorFactory::randomString();
        $text1 = $randomizer->withoutSpecial()->withoutDecimals()->withoutLowerLetters()->withUpperLetters()->make();
        $text2 = $randomizer->withoutSpecial()->withoutDecimals()->withLowerLetters()->withoutUpperLetters()->make();
        $stream1 = GeneratorFactory::stream()->withContents($text1)->make();
        $stream2 = GeneratorFactory::stream()->withContents($text2)->make();

        $body1 = GeneratorFactory::bodyPart()->withStream($stream1)->make();
        $body2 = GeneratorFactory::bodyPart()->withStream($stream2)->make();

        $message = new Message($body1, GeneratorFactory::randomString()->make());
        Assert::assertSame($body1, $message->getBody());

        $message->setBody($body2);
        Assert::assertSame($body2, $message->getBody());
    }

    public function testAddRecipient()
    {
        $email1 = new Email('test01@phpunit.de');
        $email2 = new Email('test02@phpunit.de', 'Unit Test 2');
        $email3 = new Email('test03@phpunit.de', 'Unit Test 3');
        $email4 = new Email('test04@phpunit.de', 'Unit Test 4');
        $email5 = new Email('test05@phpunit.de', 'Unit Test 5');
        $message = new Message(GeneratorFactory::bodyPart()->make());
        $message->addRecipient(Recipient::to($email1));
        $message->addRecipient(Recipient::to($email2));
        $message->addRecipient(Recipient::cc($email3));
        $message->addRecipient(Recipient::cc($email4));
        $message->addRecipient(Recipient::bcc($email5));

        $recipients = $message->getRecipients();
        $recipients->rewind();

        $recipient = $recipients->current();
        Assert::assertSame('To', $recipient->getType());
        Assert::assertSame('test01@phpunit.de', $recipient->getEmail()->getAddress());
        $recipients->next();
        $recipient = $recipients->current();
        Assert::assertSame('To', $recipient->getType());
        Assert::assertSame('test02@phpunit.de', $recipient->getEmail()->getAddress());
        $recipients->next();
        $recipient = $recipients->current();
        Assert::assertSame('Cc', $recipient->getType());
        Assert::assertSame('test03@phpunit.de', $recipient->getEmail()->getAddress());
        $recipients->next();
        $recipient = $recipients->current();
        Assert::assertSame('Cc', $recipient->getType());
        Assert::assertSame('test04@phpunit.de', $recipient->getEmail()->getAddress());
        $recipients->next();
        $recipient = $recipients->current();
        Assert::assertSame('Bcc', $recipient->getType());
        Assert::assertSame('test05@phpunit.de', $recipient->getEmail()->getAddress());
        $recipients->next();
        Assert::assertFalse($recipients->valid());
    }

    public function testUpdatingHeaderAfterAddRecipient()
    {
        $email1 = new Email('test01@phpunit.de');
        $email2 = new Email('test02@phpunit.de', 'Unit Test 2');
        $email3 = new Email('test03@phpunit.de');
        $email4 = new Email('test04@phpunit.de', 'Unit Test 4');
        $email5 = new Email('test05@phpunit.de', 'Unit Test 5');
        $message = new Message(GeneratorFactory::bodyPart()->make());
        $message->addRecipient(Recipient::to($email1));
        $message->addRecipient(Recipient::to($email2));
        $message->addRecipient(Recipient::cc($email3));
        $message->addRecipient(Recipient::cc($email4));
        $message->addRecipient(Recipient::bcc($email5));

        Assert::assertSame('<test01@phpunit.de>, "Unit Test 2" <test02@phpunit.de>', $message->getHeader('to'));
        Assert::assertSame('<test03@phpunit.de>, "Unit Test 4" <test04@phpunit.de>', $message->getHeader('cc'));
        Assert::assertSame('"Unit Test 5" <test05@phpunit.de>', $message->getHeader('bcc'));
    }

    public function testUpdatingRecipientsAfterSettingHeader()
    {
        $message = new Message(GeneratorFactory::bodyPart()->make());
        $message->setHeader('to', '<test01@phpunit.de>, "Unit Test 2" <test02@phpunit.de>');
        $message->setHeader('cc', '<test03@phpunit.de>, "Unit Test 4" <test04@phpunit.de>');
        $message->setHeader('bcc', '"Unit Test 5" <test05@phpunit.de>');
        $recipients = $message->getRecipients();
        $recipients->rewind();

        $recipient = $recipients->current();
        Assert::assertSame('To', $recipient->getType());
        Assert::assertSame('test01@phpunit.de', $recipient->getEmail()->getAddress());
        $recipients->next();
        $recipient = $recipients->current();
        Assert::assertSame('To', $recipient->getType());
        Assert::assertSame('test02@phpunit.de', $recipient->getEmail()->getAddress());
        $recipients->next();
        $recipient = $recipients->current();
        Assert::assertSame('Cc', $recipient->getType());
        Assert::assertSame('test03@phpunit.de', $recipient->getEmail()->getAddress());
        $recipients->next();
        $recipient = $recipients->current();
        Assert::assertSame('Cc', $recipient->getType());
        Assert::assertSame('test04@phpunit.de', $recipient->getEmail()->getAddress());
        $recipients->next();
        $recipient = $recipients->current();
        Assert::assertSame('Bcc', $recipient->getType());
        Assert::assertSame('test05@phpunit.de', $recipient->getEmail()->getAddress());
        $recipients->next();
        Assert::assertFalse($recipients->valid());
    }
}
