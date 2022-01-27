<?php
  function registra_conexion($url, $data) {
      $miskeys_z = json_decode(file_get_contents("tokens.json"), true);
      // echo "Token token=" . $miskeys_z["SandBox"]["KeyPrivada"] . "<br>";
      $client = new HTTPRequester();
      $entorno_z = $miskeys_z["entorno"];
      $options = ['headers' => [
        'Authorization' => "Token token=" . $miskeys_z[$entorno_z]["KeyPrivada"], //{EMPRESA_API_KEY_PRIVADA}",
        'Accept'        => 'application/json',
        'Content-Type'  => 'application/json',
        'Access-Control-Allow-Origin' => '*'      
      ],'body' => json_encode($data)];
      
      $response = $client->HTTPPost($url, $options);
      //$response = $client->request('POST', $uri, $options);
      //$stream = Psr7\stream_for($response->getBody());
      //-> echo $response;
      return json_decode($response, true);

  }
  
  function getPostResponse($uri, $data) {
      $miskeys_z = json_decode(file_get_contents("tokens.json"), true);
      $client = new GuzzleHttp\Client(['base_uri' => $uri]);
      $options = ['headers' => [
        'Authorization' => "Token token=" . $miskeys_z["SandBox"]["KeyPrivada"], #{EMPRESA_API_KEY_PRIVADA}",
        'Accept'        => 'application/json',
        'Content-Type'  => 'application/json',
        'Access-Control-Allow-Origin' => '*'      
      ],'body' => json_encode($data)];
      
      $response = $client->request('POST', $uri, $options);
      $stream = Psr7\stream_for($response->getBody());
      return json_decode($stream, true);
    }

class HTTPRequester {
    /**
     * @description Make HTTP-GET call
     * @param       $url
     * @param       array $params
     * @return      HTTP-Response body or an empty string if the request fails or is empty
     */
    public static function HTTPGet($url, array $params) {
        $query = http_build_query($params["body"] ); 
        $ch    = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:' . $params["headers"]["Authorization"],    
            'Accept:' . $params["headers"]["Accept"],    
            'Content-Type:' . $params["headers"]["Content-Type"],    
            'Access-Control-Allow-Origin:' . $params["headers"]["Access-Control-Allow-Origin"],
            'Content-Length: ' . strlen($query) ,    
            ));
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $query);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    /**
     * @description Make HTTP-POST call
     * @param       $url
     * @param       array $params
     * @return      HTTP-Response body or an empty string if the request fails or is empty
     */
    public static function HTTPPost($url, array $params) {
        // $query = http_build_query($params["body"] ); 
        $query = $params["body"]; 
        //->echo $query;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:' . $params["headers"]["Authorization"],    
            'Accept:' . $params["headers"]["Accept"],    
            'Content-Type:' . $params["headers"]["Content-Type"],    
            'Access-Control-Allow-Origin:' . $params["headers"]["Access-Control-Allow-Origin"]));
          curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    /**
     * @description Make HTTP-PUT call
     * @param       $url
     * @param       array $params
     * @return      HTTP-Response body or an empty string if the request fails or is empty
     */
    public static function HTTPPut($url, array $params) {
        $query = \http_build_query($params);
        $ch    = \curl_init();
        \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($ch, \CURLOPT_HEADER, false);
        \curl_setopt($ch, \CURLOPT_URL, $url);
        \curl_setopt($ch, \CURLOPT_CUSTOMREQUEST, 'PUT');
        \curl_setopt($ch, \CURLOPT_POSTFIELDS, $query);
        $response = \curl_exec($ch);
        \curl_close($ch);
        return $response;
    }
    /**
     * @category Make HTTP-DELETE call
     * @param    $url
     * @param    array $params
     * @return   HTTP-Response body or an empty string if the request fails or is empty
     */
    public static function HTTPDelete($url, array $params) {
        $query = \http_build_query($params);
        $ch    = \curl_init();
        \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($ch, \CURLOPT_HEADER, false);
        \curl_setopt($ch, \CURLOPT_URL, $url);
        \curl_setopt($ch, \CURLOPT_CUSTOMREQUEST, 'DELETE');
        \curl_setopt($ch, \CURLOPT_POSTFIELDS, $query);
        $response = \curl_exec($ch);
        \curl_close($ch);
        return $response;
    }
}

?>
