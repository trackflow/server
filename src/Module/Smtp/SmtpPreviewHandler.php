<?php

declare(strict_types=1);

namespace App\Debug\Module\Smtp;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use SleekDB\Store;

final readonly class SmtpPreviewHandler
{
    public function __construct(private Store $store)
    {
    }

    public function __invoke(ServerRequestInterface $request): Response
    {
        $smtp = $this->store->findById($request->getAttribute('id'));
        $body = $smtp['contentTransferEncoding'] === 'quoted-printable' ? quoted_printable_decode($smtp['body']) : $smtp['body'];

        return Response::html($body);
    }
}
