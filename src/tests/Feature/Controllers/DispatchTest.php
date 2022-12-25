<?php

namespace Tests\Unit;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

;

class DispatchTest extends TestCase
{
    public function testExecute()
    {
        $response = $this->get('/');
        $response->assertViewIs('index');

        $documentResponse = $this->get('/Document');
        $documentResponse->assertViewIs('document.index');
    }

    public function testAjaxExecute()
    {
        $response = $this->withHeaders(['HTTP_X-Requested-With'=>'XMLHttpRequest'])->get('/');
        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll([
                'notifications.raw',
                'notifications.formatted',
                'body',
                'location'
            ]);
        });

    }
}
