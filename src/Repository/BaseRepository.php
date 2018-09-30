<?php

namespace App\Repository;

/**
 * Class BaseRepository
 * @package App\Repository
 */
abstract class BaseRepository
{
    /**
     * @param $url
     * @param $type
     * @param array $parameters
     * @param array $headers
     * @return array
     */
    protected function query(string $url, string $type = 'GET', array $parameters = array(), array $headers = array())
    {
        $api_url = getenv("API_URL");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 45);
        curl_setopt($ch, CURLOPT_TIMEOUT, 200);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);

        switch ($type) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
            //no break
            case 'PATCH':
            case 'PUT':
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getJsonParameters($parameters));
                curl_setopt($ch, CURLOPT_URL, $api_url . $url);
                break;
            default:
                curl_setopt($ch, CURLOPT_URL,
                    $api_url . $url . '?' . $this->getUrlParameters($parameters));
                break;
        }

        $response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        curl_close($ch);

        //catch error from oauth
        $header = $this->parseHeadersFromCurlResponse($header);

        if (false !== strpos($header['content-type'], 'json')) {
            $body = json_decode($body);
        }

        return compact('header','body');

    }

    /**
     * @param array $parameters
     * @return string
     */
    private function getJsonParameters(array $parameters = array()) : string
    {
        $params = (!empty($parameters) ? json_encode($parameters) : '');
        return $params;
    }

    /**
     * @param array $parameters
     * @return string
     */
    private function getUrlParameters(array $parameters = array()) : string
    {
        $params = (!empty($parameters) ? http_build_query($parameters) : '');
        return $params;
    }

    /**
     * @param $header
     * @return array
     */
    private function parseHeadersFromCurlResponse(string $header) : array
    {
        $headers = array();
        foreach (explode("\r\n", $header) as $i => $line) {
            if (strrpos($line, 'HTTP') !== false) {
                $headers['http-code'] = $line;
                list(, $code, $status) = explode(' ', $line);
                $headers['code'] = $code;
            } else {
                if (!empty($line)) {
                    list ($key, $value) = explode(': ', $line);

                    $headers[strtolower($key)] = $value;
                }
            }
        }
        return $headers;
    }


}