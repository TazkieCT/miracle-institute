<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CertificateGenerated
{
    use Dispatchable, SerializesModels;

    public string $certificateId;

    public function __construct(string $certificateId)
    {
        $this->certificateId = $certificateId;
    }
}