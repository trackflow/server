<?php

declare(strict_types=1);

namespace  App\Debug\Tests\UseCase;

use App\Debug\Module\Smtp\SmtpCatcherHandler;
use App\Debug\Tests\InMemory\InMemoryPublisher;
use App\Debug\Tests\InMemory\InMemorySmtpRepository;
use App\Debug\Tests\TraitStubConnection;
use PHPUnit\Framework\TestCase;

final class SmtpCatcherHandlerTest extends TestCase
{
    use TraitStubConnection;
    public function test_persistant_and_publish_email(): void
    {
        $handler = new SmtpCatcherHandler(
            $repository = new InMemorySmtpRepository(),
            $publisher = new InMemoryPublisher()
        );

        $email = "
EHLO [127.0.0.1]\r\n
MAIL FROM:<from@example.org>\r\n
RCPT TO:<dev@tld.com>\r\n
DATA \r\n
To: contact@tld.com \r\n
From: from@example.org \r\n
Subject: Testing transport \r\n
Message-ID: <bde550f5fcc78e5a5b1c5608e8dd4886@example.org> \r\n
MIME-Version: 1.0 \r\n
Date: Wed, 27 Mar 2024 16:07:26 +0100 \r\n
Content-Type: text/plain; charset=utf-8\r\n
Content-Transfer-Encoding: quoted-printable\r\n

<html><body>
<h1>Titre</h1>
</body>
</html>\r\n
.\r\n
";

        $handler($this->getConnection(onData: $email));

        self::assertEquals(
            [
                [
                    'body' => '<html><body>
<h1>Titre</h1>
</body>
</html>
',
                    'to' => 'contact@tld.com',
                    'from' => 'from@example.org',
                    'subject' => 'Testing transport',
                    'messageId' => '<bde550f5fcc78e5a5b1c5608e8dd4886@example.org>',
                    'mimeVersion' => '1.0',
                    'date' => 'Wed, 27 Mar 2024 16:07:26 +0100',
                    'contentType' => 'text/plain; charset=utf-8',
                    'contentTransferEncoding' => 'quoted-printable',
                ]
            ],
            $repository->getMemory()
        );
        self::assertEquals(
            [
                'smtp' => [
                    [
                        'body' => '<html><body>
<h1>Titre</h1>
</body>
</html>
',
                        'to' => 'contact@tld.com',
                        'from' => 'from@example.org',
                        'subject' => 'Testing transport',
                        'messageId' =>  '<bde550f5fcc78e5a5b1c5608e8dd4886@example.org>',
                        'mimeVersion' => '1.0',
                        'date' => 'Wed, 27 Mar 2024 16:07:26 +0100',
                        'contentType' => 'text/plain; charset=utf-8',
                        'contentTransferEncoding' => 'quoted-printable',
                    ]
                ]
            ],
            $publisher->getMemory()
        );
    }
}
