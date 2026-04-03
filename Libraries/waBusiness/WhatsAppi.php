<?php
  Class WhatsAppApi {
    public $strToken;
    public $strVersion;
    public $intInstanceId;
    public $intTo;
    public $strFileName;
    public $strCaption;
    public $strDocument;
    public $strMessage;

    function __construct(string $version, string $token, int $instanceid){
      $this->strVersion = $version;
      $this->strToken = $token; 
      $this->intInstanceId = preg_replace('/[^0-9]/', '',$instanceid);
    }

    public function sendDocumentMessage(int $to, string $filename, string $caption, string $document){
      $this->intTo = preg_replace('/[^0-9]/', '',$to);
      $this->strFileName = $filename;
      $this->strCaption = $caption;
      $this->strDocument = $document;

      $curl = curl_init();

      curl_setopt_array($curl, [
        CURLOPT_URL => "https://waapi.app/api/v1/instances/87864/client/action/send-media",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
          'chatId' => $this->intTo.'@c.us',
          'mediaUrl' => $this->strDocument,
          'mediaCaption' => $this->strCaption,
          'mediaName' => $this->strFileName
        ]),
        CURLOPT_HTTPHEADER => [
          "accept: application/json",
          "authorization: Bearer l9cARU4uH6CMjEKVB4wfbhs9sIxVZEV6Xuagt0eI785033d4",
          "content-type: application/json"
        ],
      ]);

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        return $response;
        //echo $response;
      }
    }


    public function sendTextMessage(int $to, string $txtmessage){
       $this->intTo = preg_replace('/[^0-9]/', '',$to);
       $this->strMessage = $txtmessage;

      $curl = curl_init();

      curl_setopt_array($curl, [
        CURLOPT_URL => "https://waapi.app/api/v1/instances/19466/client/action/send-message",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        
        // 🔧 TIEMPOS AUMENTADOS
        CURLOPT_CONNECTTIMEOUT => 20,  // tiempo máximo para conectarse
        CURLOPT_TIMEOUT => 90,         // tiempo total máximo para toda la operación
        
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
          'message' => $this->strMessage,
          'chatId' => $this->intTo.'@c.us'
        ]),
        CURLOPT_HTTPHEADER => [
          "accept: application/json",
          "authorization: Bearer 2c2mnL25ekKByEqFJzt6Y1QMSXcQ5UTQ900hsp9jdbaa17b8",
          "content-type: application/json"
        ],
      ]);

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        return $response;
      }
    }


  } //End class WhastAppApi