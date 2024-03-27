<?php

declare(strict_types=1);

namespace App\Debug\Module\Smtp;

use App\Debug\Websocket\PublisherInterface;
use React\Socket\ConnectionInterface;

final readonly class SmtpCatcherHandler
{
    public function __construct(
        private SmtpRepository $repository,
        private PublisherInterface $publisher
    ) {
    }

    public function __invoke(ConnectionInterface $connection): void
    {
        $connection->write("220 localhost ESMTP\r\n");
        $buffer = '';
        $email = ['body' => ''];
        $connection->on('data', function($data) use ($connection, &$buffer, &$email) {
            $buffer .= $data;

            // Process the incoming data line by line
            while (false !== $pos = strpos($buffer, "\r\n")) {
                $line = substr($buffer, 0, $pos);
                $buffer = substr($buffer, $pos + 2); // +2 for "\r\n"
                $line = trim($line);
                echo "Received: $line\n";

                // Handle the command
                try {
                    $this->parseLine($line, $email);
                    if (preg_match('/^QUIT/i', $line)) {
                        $connection->end("221 Bye\r\n");
                        $connection->close();
                    } elseif (preg_match('/^EHLO/i', $line) || preg_match('/^HELO/i', $line)) {
                        $connection->write("250 localhost\r\n");
                    } elseif (preg_match('/^MAIL FROM/i', $line)) {
                        $connection->write("250 OK\r\n");
                    } elseif (preg_match('/^RCPT TO/i', $line)) {
                        $connection->write("250 OK\r\n");
                    } elseif (preg_match('/^DATA/i', $line)) {
                        $connection->write("354 End data with <CR><LF>.<CR><LF>\r\n");
                    } elseif (preg_match('/^\./', $line)) {
                        $connection->write("250 OK\r\n");
                    }
                } catch (\Exception $e) {
                    $connection->write("451 Error: {$e->getMessage()}\r\n");
                }
            }
        });

//        $connection->on('error', function($e) {
//            echo "Error: $e\n";
//        });
    }

    private function parseLine(string $line, array &$email): void
    {
        if (str_contains($line, 'To:')) {
            $email['to'] = str_replace('To: ', '', $line);
        }

        if (str_contains($line, 'From:')) {
            $email['from'] = str_replace('From: ', '', $line);
        }

        if (str_contains($line, 'Subject:')) {
            $email['subject'] = str_replace('Subject: ', '', $line);
        }

        if (str_contains($line, 'Message-ID:')) {
            $email['messageId'] = str_replace('Message-ID: ', '', $line);
        }

        if (str_contains($line, 'MIME-Version:')) {
            $email['mimeVersion'] = str_replace('MIME-Version: ', '', $line);
        }

        if (str_contains($line, 'Date:')) {
            $email['date'] = str_replace('Date: ', '', $line);
        }

        if (str_contains($line, 'Content-Type:')) {
            $email['contentType'] = str_replace('Content-Type: ', '', $line);
        }

        if (str_contains($line, 'Content-Transfer-Encoding:')) {
            $email['contentTransferEncoding'] = str_replace('Content-Transfer-Encoding: ', '', $line);
        }

        if (isset($email['contentTransferEncoding']) && !str_contains($line, 'Content-Transfer-Encoding:') && $line !== ".") {
            $email['body'] .= $line.PHP_EOL;
        }

        if ($line === '.') {
            $emailInsert = $this->repository->save($email);
            $this->publisher->send($emailInsert, 'smtp');
            $email = ['body' => ''];
        }
    }
}
