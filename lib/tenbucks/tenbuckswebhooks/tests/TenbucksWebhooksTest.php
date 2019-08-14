<?php

/*
 * Copyright 2016 tenbucks.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Test of TenbucksKeysClient class.
 *
 * @author Gary PEGEOT <gary@webincolor.fr>
 */
class TenbucksWebhooksTest extends PHPUnit_Framework_TestCase
{
    public function testSend()
    {
        $client = new TenbucksWebhooks();
        $query = array(
            'shop_url' => 'http://www.example.org',
            'model' => 'product',
            'external_id' => 1,
        );

        $this->assertTrue($client->send($query));
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Missing shop_url parameter in query.
     */
    public function testBadRequest()
    {
        $client = new TenbucksWebhooks();
        $query = array(
            'model' => 'product',
            'external_id' => 1,
        );

        $client->send($query);
    }
}
