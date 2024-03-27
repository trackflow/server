<?php

declare(strict_types=1);

namespace App\Debug\Module\Smtp;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

final readonly class SmtpPreviewHandler
{
    public function __construct(private SmtpRepository $store)
    {
    }

    public function __invoke(ServerRequestInterface $request): Response
    {
        $smtp = $this->store->get((int) $request->getAttribute('id'));
        $body = $smtp['contentTransferEncoding'] === 'quoted-printable' ? quoted_printable_decode($smtp['body']) : $smtp['body'];

        return Response::html($body);
    }
}
