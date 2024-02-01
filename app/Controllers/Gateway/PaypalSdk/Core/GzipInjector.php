<?php

namespace Viserlab\Controllers\Gateway\PaypalSdk\Core;


use Viserlab\Controllers\Gateway\PaypalSdk\PayPalHttp\Injector;

class GzipInjector implements Injector
{
    public function inject($httpRequest)
    {
        $httpRequest->headers["Accept-Encoding"] = "gzip";
    }
}
