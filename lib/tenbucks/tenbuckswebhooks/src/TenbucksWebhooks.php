<?php

/*
 * Copyright 2016 tenbucks.©
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
 * Manage Webhooks and synchronize data with tenbucks.
 *
 * @author Gary PEGEOT <gary@webincolor.fr>
 */
class TenbucksWebhooks
{
    /**
     * API url.
     */
    const URL = 'https://lezfd2kfmf.execute-api.eu-west-1.amazonaws.com/prod/webhooks';

    /**
     * Connection timeout.
     */
    const TIMEOUT_PERIOD = 15;

    /**
     * Query required fields.
     * 
     * @var array
     */
    private $requiredFields = array(
        'shop_url', // Complete Url -> http://www.example.org
        'model', // Model name, in lowercase -> product | order
        'external_id', // Model ID in the shop -> 1
    );

    /**
     * Send webhooks data.
     * 
     * @param array $query Request details
     * 
     * @return bool Operation success
     *
     * @throws Exception Bad request | network error
     */
    public function send(array $query)
    {
        foreach ($this->requiredFields as $key) {
            if (empty($query[$key])) {
                throw new Exception("Missing {$key} parameter in query.");
            }
        }

        $headers = array(
            'POST '.self::URL.' HTTP/1.1',
            'Content-Type: application/json',
            'Accept: application/json',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($query));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::TIMEOUT_PERIOD);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::TIMEOUT_PERIOD);
        $result = curl_exec($ch);

        if (empty($result)) {
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            throw new Exception("Error {$http_code}: {$error}.");
        }

        curl_close($ch);
        $data = json_decode($result, true);

        return !empty($data) && isset($data['status']) && $data['status'] === 'success';
    }
}
