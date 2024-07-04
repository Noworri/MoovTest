<?php

namespace App\Http\Controllers;
 
use Exception;
use Illuminate\Http\Request;
use SimpleXMLElement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Log;

class MoovMoneyController extends Controller
{
    //

    /**
     * JUSTE POUR L'INTERNE DE FLOW
     *  
     */

     protected $USER2_TOKEN = '';
     protected $USER3_TOKEN = '';
     protected $USER4_TOKEN = '';
     public function __construct()
    {
        //$this->BASE_URL = 'https://orchard-api.anmgw.com';
        $this->USER2_TOKEN = '';
        $this->USER3_TOKEN = '';
        $this->USER4_TOKEN = '';
        // 
    }


    public function moovCollection(Request $request){

        $validator = Validator::make($request->all(), [
            "amount" => 'required',
            "phone_number" => "required|string",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'BAD REQUEST', "errors" => $validator->errors()], 400);
        } 
        $uuid = Str::uuid();
        $fee = 0;
        $url = "https://testapimarchand2.moov-africa.bj:2010/com.tlc.merchant.api/UssdPush";
        $headers = array(
            'Content-Type: application/xml'
        );
        $xml_data = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.merchant.tlc.com/">
        <soapenv:Header/>
           <soapenv:Body>
              <api:Push>
                 <!--Optional:-->
                 <token>user2_token</token>
                 <!--Optional:-->
                 <msisdn>phone_no_value</msisdn>
                 <!--Optional:-->
                 <message>Paiement NOWORRI, veuillez entrer votre code pin</message>
                 <!--Optional:-->
                 <amount>amount_value</amount>
                 <!--Optional:-->
                 <externaldata1>externaldata</externaldata1> 
                 <!--Optional:-->
                 <externaldata2>TEST</externaldata2>
                 <!--Optional:-->
                 <fee>fee_value</fee>
              </api:Push>
           </soapenv:Body>
        </soapenv:Envelope>'; 
        $xml_data = str_replace(
            ['<token>user2_token</token>',                          '<msisdn>phone_no_value</msisdn>', '<amount>amount_value</amount>', '<fee>fee_value</fee>', '<externaldata1>externaldata</externaldata1>'],
            ['<token>'.(string)$this->USER2_TOKEN .'</token>',      '<msisdn>' . (string)$request->phone_number . '</msisdn>', '<amount>' . (string)$request->amount . '</amount>', '<fee>' . $fee . '</fee>', '<externaldata1>'.$uuid.'</externaldata1>'],
            $xml_data
        );  
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        try {
            $response = curl_exec($ch); 
            if ($response === false) {
                throw new Exception('Erreur cURL : ' . curl_error($ch));
            }   
            $xml = new SimpleXMLElement($response);
            $soap = $xml->children('http://schemas.xmlsoap.org/soap/envelope/');
            $ns2 = $soap->Body->children('http://api.merchant.tlc.com/');  
            $status = (string) $ns2->result->status; 
            if ($status == "0" ) { 
                $description = (string) $ns2->result->description;  
                $reference_id = (string) $ns2->result->referenceid; 
                $data = [
                    //"status" => $status,
                    "message" => $description,
                    "reference_id" => $reference_id,
                    "uuid"=>$uuid
                ];  
                return response()->json(['status' => true, 'data' => $data]);
            }else{
                //AU CAS OU CE N'EST PAS SUCESSFULLY
                $data = [
                   // "status" => $status,
                    "message" => $this->showStatusCodeError($status),
                    //"reference_id" => $reference_id
                ];  
                return response()->json(['status' => false, 'data' => $data]);
            }
            //return $response;  
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        } finally {
            curl_close($ch);
        }



    } 
    public function floozTransfer(Request $request){
        
        $validator = Validator::make(
            $request->all(),
            [
                "phone_no" => "required|string",
                "amount" => "required",
                "remarks" => "required|string",
            ]
        );
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'BAD REQUEST', "errors" => $validator->errors()], 400);
        } 
        $url = "https://testapimarchand2.moov-africa.bj:2010/com.tlc.merchant.api/UssdPush";
        $headers = array(
            'Content-Type: application/xml'
        ); 
        $xml_data = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.merchant.tlc.com/">
                <soapenv:Header/>
                    <soapenv:Body>
                    <api:transferFlooz>
                    <token>user2_token</token>
                    <request>
                        <destination>phone_no</destination>
                        <amount>amount</amount>
                        <referenceid>reference_id</referenceid>
                        <walletid>wallet_id</walletid>
                        <extendeddata>remarks</extendeddata>
                    </request>
                </api:transferFlooz>
                </soapenv:Body>
        </soapenv:Envelope>';  
        $wallet_id = 0;
        $reference_id = Str::uuid();
        $xml_data = str_replace(
            ['<token>user2_token</token>',   '<destination>phone_no</destination>', '<amount>amount</amount>', '<referenceid>reference_id</referenceid>', '<walletid>wallet_id</walletid>', '<extendeddata>remarks</extendeddata>'],
            ['<token>'.(string)$this->USER2_TOKEN .'</token>', '<destination>' . $request->phone_no . '</destination>', '<amount>' . $request->amount . '</amount>', '<referenceid>' . $reference_id . '</referenceid>', '<walletid>' . $wallet_id . '</walletid>', '<extendeddata>' . $request->remarks . '</extendeddata>'],
            $xml_data
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        try {
            $response = curl_exec($ch);
            if ($response === false) {
                throw new Exception('Erreur cURL : ' . curl_error($ch));
            } 
            $xml = new SimpleXMLElement($response);
            $soap = $xml->children('http://schemas.xmlsoap.org/soap/envelope/');
            $ns2 = $soap->Body->children('http://api.merchant.tlc.com/'); 
            $status = (string) $ns2->return->status;
 
            if ($status == "0" ) { 
                $message = (string) $ns2->return->message;
                $transactionId = (string) $ns2->return->transactionid;
                $referenceId = (string) $ns2->return->referenceid;
                $senderBalanceBefore = (float) $ns2->return->senderbalancebefore;
                $senderBalanceAfter = (float) $ns2->return->senderbalanceafter; 
                $data = [
                    //"status" => $status,
                    "message" => $message,
                    "reference_id" => $referenceId,
                    "uuid"=>$transactionId,
                    "sender_balance_bafore"=>$senderBalanceBefore,
                    "sender_balance_after"=>$senderBalanceAfter
                ];  
                Log::info("RETOUR TRANSFER FLOOZ VENANT DE MOOV");
                Log::info($response);
                return response()->json(['status' => true, 'data' => $data]);
            }else{
                //AU CAS OU CE N'EST PAS SUCESSFULLY
                $data = [ 
                    "message" => $this->showStatusCodeError($status), 
                ];  
                return response()->json(['status' => false, 'data' => $data]);
            }
              

        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        } finally {
            curl_close($ch);
        } 
    } 
    private function showStatusCodeError($status)
    {

        switch ($status) {
            case 0:
                $message = "Success Transaction Completed";
                break;
            case 1:
                $message = "Not allowed on the method transaction";
                break;
            case 2:
                $message = "Not allowed on the transaction";
                break;
            case 3:
                $message = "Number is not valid";
                break;
            case 6:
                $message = "Destination is not allowed to receive a transfer";
                break;
            case 7:
                $message = "Destination is locked";
                break;
            case 9:
                $message = "Destination is inactive";
                break;
            case 10:
                $message = "Balance is insufficient Funds";
                break;
            case 11:
                $message = "Cannot send on the above amount";
                break;
            case 12:
                $message = "Cannot send on the below amount";
                break;
            case 13:
                $message = "Already reach the maximum amount per day";
                break;
            case 14:
                $message = "Already reach the maximum amount per month";
                break;
            case 15:
                $message = "Already reach the maximum daily transactions";
                break;
            case 16:
                $message = "Already reach the maximum monthly transactions";
                break;
            case 17:
                $message = "Destination cannot receive on the below amount";
                break;
            case 18:
                $message = "Destination cannot receive reach the maximum balance";
                break;
            case 19:
                $message = "Sender reach the maximum daily transaction";
                break;
            case 20:
                $message = "Sender reach the maximum monthly transaction";
                break;
            case 92:
                $message = "Exception on USSD PUSH Timeout in USSD PUSH/ Cancel in USSD PUSH";
                break;
            case 94:
                $message = "Transaction not exists";
                break;
            case 95:
                $message = "Transaction Failed Transactions was failed due to <error>";
                break;
            case 91:
                $message = "Parameters Incomplete";
                break;
            case 98:
                $message = "Invalid Token Invalid Credentials";
                break;
            case 99:
            case -1:
                $message = "System Busy Interface Internal error Database connection error";
                break;
            case 555:
                $message = "Not Registered Destination Subscriber is not registered on Moov Money";
                break;
            default:
                $message = "Code de statut non géré";
                break;
        }

        return $message;

    } 
    public function moovPushWithPending(Request $request)
    {
       //return $request->all();

        $validator = Validator::make($request->all(), [
            "amount" => 'required',
            "phone_no" => "required|string",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'BAD REQUEST', "errors" => $validator->errors()], 400);
        }
        $uuid = Str::uuid();
        $fee = 0;
        $url = "https://testapimarchand2.moov-africa.bj:2010/com.tlc.merchant.api/UssdPush";
        $headers = array(
            'Content-Type: application/xml'
        );
        $xml_data = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.merchant.tlc.com/">
        <soapenv:Header/>
           <soapenv:Body>
              <api:PushWithPending>
                 <!--Optional:-->
                 <token>user2_token</token>
                 <!--Optional:-->
                 <msisdn>phone_no_value</msisdn>
                 <!--Optional:-->
                 <message>Paiement NOWORRI, veuillez entrer votre code pin</message>
                 <!--Optional:-->
                 <amount>amount_value</amount>
                 <!--Optional:-->
                 <externaldata1>externaldata</externaldata1> 
                 <!--Optional:-->
                 <externaldata2>TEST</externaldata2>
                 <!--Optional:-->
                 <fee>fee_value</fee>
              </api:PushWithPending>
           </soapenv:Body>
        </soapenv:Envelope>'; 
        $xml_data = str_replace(
            ['<token>user2_token</token>', '<msisdn>phone_no_value</msisdn>', '<amount>amount_value</amount>', '<fee>fee_value</fee>', '<externaldata1>externaldata</externaldata1>' ],
            ['<token>'.(string)$this->USER2_TOKEN .'</token>', '<msisdn>' . (string)$request->phone_no . '</msisdn>', '<amount>' . (string)$request->amount . '</amount>', '<fee>' . $fee . '</fee>', '<externaldata1>'.$uuid.'</externaldata1>'],
            $xml_data
        ); 
         
         
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        try {
            $response = curl_exec($ch);
             

            if ($response === false) {
                throw new Exception('Erreur cURL : ' . curl_error($ch));
            }
            //echo 'Requête envoyée avec succès!';
            
            $xml = new SimpleXMLElement($response);
            $soap = $xml->children('http://schemas.xmlsoap.org/soap/envelope/');
            $ns2 = $soap->Body->children('http://tlc.com.ph/');
            $status = (string) $ns2->return->status;
            $message = (string) $ns2->return->message;
            $reference_id = (string) $ns2->return->referenceid;

            if ($status == "0" && $message == "SUCCESS") {

                $data = [
                    "status" => $status,
                    "message" => $message,
                    "reference_id" => $reference_id
                ];
                //PROCESS  
                return response()->json(['status' => true, 'data' => $data]);
            }
            return $response; 
            return response()->json(['status' => false, 'message' => "Something went wrong"]);
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        } finally {
            curl_close($ch);
        }


    }
    public function callBack(Request $request){

        //return "HELLo";
        Log::info("CALL BACK MOOV");
        Log::info($request);

    }
    public function moovCashInTransaction(Request $request)
    {

       
        $validator = Validator::make($request->all(), [
            "amount" => "required",
            "destination" => "required",
            "remarks" => "string",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'BAD REQUEST', "errors" => $validator->errors()], 400);
        }
        $reference_id = Str::uuid();
        $url = "https://testapimarchand2.moov-africa.bj:2010/com.tlc.merchant.api/UssdPush";
        $headers = array(
            'Content-Type: application/xml'
        );
        $xml_data = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.merchant.tlc.com/">
            <soapenv:Header/>
                <soapenv:Body>
                <api:cashintrans> 
                <token>user4_token</token>
                <request>
                    <destination>phone_no</destination>
                    <amount>amount</amount>
                    <referenceid>reference_id</referenceid>
                    <extendeddata>remarks</extendeddata>
                </request>
            </api:cashintrans>
            </soapenv:Body>
        </soapenv:Envelope>';

        $xml_data = str_replace(
            ['<token>user4_token</token>','<amount>amount</amount>', '<destination>phone_no</destination>', '<referenceid>reference_id</referenceid>', '<remarks>remarks</remarks>'],
            ['<token>' . $this->USER4_TOKEN . '</token>','<amount>' . $request->amount . '</amount>', '<destination>' . $request->destination . '</destination>', '<referenceid>' . $reference_id . '</referenceid>', '<remarks>' . $request->remarks . '</remarks>'],
            $xml_data
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        try {
            $response = curl_exec($ch);
            if ($response === false) {
                throw new Exception('Erreur cURL : ' . curl_error($ch));
            }
            return $response;
            $xml = new SimpleXMLElement($response);
            $ns2 = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children('http://api.merchant.tlc.com/')->cashintransResponse->return;
            $message = (string) $ns2->message;
            $referenceId = (string) $ns2->referenceid;
            $status = (int) $ns2->status;
            $transactionId = (string) $ns2->transid;
            if ($status == "0" && isset($message)) {
                $data = [
                    "status" => $status,
                    "message" => $message,
                    "reference_id" => $referenceId, // notre reference id genere
                    "transaction_id" => $transactionId
                ];
                //PROCESS 
                return response()->json(['status' => true, 'data' => $data]);
            }
            return response()->json(['status' => false, 'message' => "Something went wrong"]);
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        } finally {
            curl_close($ch);
        }
    }
    public function moovAirTimeTransaction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "amount" => "required",
            "destination" => "required",
            "remarks" => "string",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'BAD REQUEST', "errors" => $validator->errors()], 400);
        }
        $reference_id = Str::uuid(); 
        $url = "https://testapimarchand2.moov-africa.bj:2010/com.tlc.merchant.api/UssdPush";
        $headers = array(
            'Content-Type: application/xml'
        ); 
        $xml_data = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.merchant.tlc.com/">
            <soapenv:Header/>
                <soapenv:Body>
                <api:airtimetrans> 
                <token>user4_token</token>
                <request>
                    <destination>phone_no</destination>
                    <amount>amount</amount>
                    <referenceid>reference_id</referenceid>
                    <extendeddata>remarks</extendeddata>
                </request>
            </api:airtimetrans>
            </soapenv:Body>
        </soapenv:Envelope>';

        $xml_data = str_replace(
            ['<token>user4_token</token>','<amount>amount</amount>', '<destination>phone_no</destination>', '<referenceid>reference_id</referenceid>', '<remarks>remarks</remarks>'],
            ['<token>' . $this->USER4_TOKEN . '</token>','<amount>' . $request->amount . '</amount>', '<destination>' . $request->destination . '</destination>', '<referenceid>' . $reference_id . '</referenceid>', '<remarks>' . $request->remarks . '</remarks>'],
            $xml_data
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        try {
            $response = curl_exec($ch);
            if ($response === false) {
                throw new Exception('Erreur cURL : ' . curl_error($ch));
            }
            return $response;


            $xml = new SimpleXMLElement($response); 
            $ns2 = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children('http://api.merchant.tlc.com/')->airtimetransResponse->return;
            $message = (string) $ns2->message;
            $referenceId = (string) $ns2->referenceid;
            $status = (int) $ns2->status;
            $transactionId = (string) $ns2->transid;
            if ($status == "0" && isset($message)) {
                $data = [
                    "message" => $message,
                    "reference_id" => $referenceId,
                    "status" => $status,
                    "transaction_id" => $transactionId
                ];
                //PROCESS 
                return response()->json(['status' => true, 'data' => $data]);
            }
            return response()->json(['status' => false, 'message' => "Something went wrong"]);
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        } finally {
            curl_close($ch);
        }
    }
    public function getMoovCollectionStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "reference_id" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'BAD REQUEST', "errors" => $validator->errors()], 400);
        }
        $url = "https://testapimarchand2.moov-africa.bj:2010/com.tlc.merchant.api/UssdPush";
        $headers = array(
            'Content-Type: application/xml'
        );
        $xml_data = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.merchant.tlc.com/">
                <soapenv:Header/>
                    <soapenv:Body>
                           <api:getTransactionStatus>
                           <token>user2_token</token>
                           <request>
                               <transid>transaction_id</transid>
                           </request>
                       </api:getTransactionStatus>
                           </soapenv:Body>
                        </soapenv:Envelope>'; 
        $xml_data = str_replace(
            ['<token>user2_token</token>','<transid>transaction_id</transid>'],
            ['<token>'.(string)$this->USER2_TOKEN .'</token>', '<transid>' . $request->reference_id . '</transid>'],
            $xml_data
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        try {
            $response = curl_exec($ch);
            
            if ($response === false) {
                throw new Exception('Erreur cURL : ' . curl_error($ch));
            }
            return $response;
            $xml = new SimpleXMLElement($response);
            $soap = $xml->children('http://schemas.xmlsoap.org/soap/envelope/');
            $ns2 = $soap->Body->children('http://api.merchant.tlc.com/');
            $response = $ns2->getTransactionStatusResponse->response;
            $description = (string) $response->description;
            $referenceId = (string) $response->referenceid;
            $status = (string) $response->status;
            if ($status == "0" && $description = "SUCCESS" && $referenceId == (string)$request->reference_id) {
                $data = [
                    "status" => $status,
                    "description" => $description,
                    "reference_id" => $referenceId
                ];
                //PROCESS 
                return response()->json(['status' => true, 'data' => $data]);
            }
            return response()->json(['status' => false, 'message' => "Something went wrong"]);
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        } finally {
            curl_close($ch);
        }
    }
    public function moovGetBalance(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "phone_no" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'BAD REQUEST', "errors" => $validator->errors()], 400);
        }


        $url = "https://testapimarchand2.moov-africa.bj:2010/com.tlc.merchant.api/UssdPush";
        $headers = array(
            'Content-Type: application/xml'
        ); 
        $xml_data = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.merchant.tlc.com/">
        <soapenv:Header/>
           <soapenv:Body>
              <api:getBalance>
                 <!--Optional:--> 
                 <token>user3_token</token>
                 <request>
                 <msisdn>phone_no</msisdn>
             </request>
              </api:getBalance>
           </soapenv:Body>
        </soapenv:Envelope>'; 

       
        $xml_data = str_replace(
            ['<token>user3_token</token>','<msisdn>phone_no</msisdn>'],
            ['<token>' . $this->USER3_TOKEN . '</token>','<msisdn>' . $request->phone_no . '</msisdn>'],
            $xml_data
        ); 


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        try {
            $response = curl_exec($ch);
            if ($response === false) {
                throw new Exception('Erreur cURL : ' . curl_error($ch));
            } 
            $xml = new SimpleXMLElement($response);
            $ns2 = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children('http://api.merchant.tlc.com/')->getBalanceResponse->return;
            $status = (int) $ns2->status;
            if ($status == "0") {
                $balance = (string) $ns2->balance;
                $message = (string) $ns2->message;
                $data = [
                    "balance" => $balance,
                    "message" => $message,
                    //"status" => $status
                ]; 
                return response()->json(['status' => true, 'data' => $data]);
            }
            return response()->json(['status' => false, 'message' => "Something went wrong"]);
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        } finally {
            curl_close($ch);
        }
    }
    public function moovGetMobileStatus(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "phone_no" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'BAD REQUEST', "errors" => $validator->errors()], 400);
        }

        $url = "https://testapimarchand2.moov-africa.bj:2010/com.tlc.merchant.api/UssdPush";
        $headers = array(
            'Content-Type: application/xml'
        ); 
        $xml_data = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.merchant.tlc.com/">
        <soapenv:Header/>
           <soapenv:Body>
              <api:getMobileAccountStatus>
                 <!--Optional:--> 
                 <token>user4_token</token>
                 <request>
                        <msisdn>phone_no</msisdn>
                    </request>
              </api:getMobileAccountStatus>
           </soapenv:Body>
        </soapenv:Envelope>'; 


        $xml_data = str_replace(
            ['<token>user4_token</token>', '<msisdn>phone_no</msisdn>'],
            ['<token>' . $this->USER4_TOKEN . '</token>','<msisdn>' . $request->phone_no . '</msisdn>'],
            $xml_data
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        try {
            $response = curl_exec($ch);
            if ($response === false) {
                throw new Exception('Erreur cURL : ' . curl_error($ch));
            }
            return $response;
            $xml = new SimpleXMLElement($response);
            $ns2 = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children('http://api.merchant.tlc.com/')->getMobileAccountStatusResponse->return;
            $accountType = (string) $ns2->accounttype;
            $allowedTransfer = (int) $ns2->allowedtransfer;
            $city = (string) $ns2->city;
            $dateOfBirth = (string) $ns2->dateofbirth;
            $firstName = (string) $ns2->firstname;
            $lastName = (string) $ns2->lastname;
            $message = (string) $ns2->message;
            $msisdn = (string) $ns2->msisdn;
            $region = (string) $ns2->region;
            $secondName = (string) $ns2->secondname;
            $status = (int) $ns2->status;
            $street = (string) $ns2->street;
            $subscriberStatus = (string) $ns2->subscriberstatus;
            if ($status == "0" && isset($message)  && $message == "SUCCESS") {
                $data = [
                    "status" => $status,
                    "message" => $message,
                    "account_type" => $accountType,
                    "allowed_transfer" => $allowedTransfer,
                    "city" => $city,
                    "date_of_birth" => $dateOfBirth,
                    "first_name" => $firstName,
                    "last_name" => $lastName,
                    "msisdn" => $msisdn,
                    "region" => $region,
                    "second_name" => $secondName,
                    "street" => $street,
                    "subscriber_status" => $subscriberStatus
                ];
                //PROCESS 
                return response()->json(['status' => true, 'data' => $data]);
            }
            return response()->json(['status' => false, 'message' => "Something went wrong"]);
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        } finally {
            curl_close($ch);
        }
    }



 

}
