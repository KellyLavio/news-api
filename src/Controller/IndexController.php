<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class IndexController {
    public function hello() {
        return new Response(
            '<html><body>Hello world!</body></html>'
        );
    }
    
}