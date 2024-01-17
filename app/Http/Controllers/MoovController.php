<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;


use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SimpleXMLElement;

class MoovController extends Controller
{
    public function moovCollection(Request $request)
    {
       //return $request->all();

        $validator = Validator::make($request->all(), [
            "amount" => 'required|integer',
            "phone_no" => "required|string",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'BAD REQUEST', "errors" => $validator->errors()], 400);
        }
        $fee = 0;
        $url = "https://apimarchand.moov-africa.bj/com.tlc.merchant.api/UssdPush";
        $headers = array(
            'Content-Type: application/xml'
        );
        $xml_data = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
                <S:Envelope xmlns:S="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
                    <SOAP-ENV:Header/>
                    <S:Body>
                        <ns2:Push xmlns:ns2="http://api.merchant.tlc.com/">
                            <token>84DPBHjpSS7QcV/grK+uZG1VusFkpzWgMzhebN+e0M8=</token>
                            <msisdn>phone_no_value</msisdn> 
                            <amount>amount_value</amount>
                            <externaldata1>TEST</externaldata1>
                            <fee>fee_value</fee>
                        </ns2:Push>
                    </S:Body>
                </S:Envelope>';
        $xml_data = str_replace(
            ['<msisdn>phone_no_value</msisdn>', '<amount>amount_value</amount>', '<fee>fee_value</fee>'],
            ['<msisdn>' . $request->phone_no . '</msisdn>', '<amount>' . $request->amount . '</amount>', '<fee>' . $fee . '</fee>'],
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
            return $response; 
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
        $url = "https://apimarchand.moov-africa.bj/com.tlc.merchant.api/getTransactionStatus";
        $headers = array(
            'Content-Type: application/xml'
        );
        $xml_data = '<?xml version="1.0" encoding="utf-16"?>
                        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.checktransaction.tlc.com/">
                            <soapenv:Header/>
                            <soapenv:Body>
                                <api:getTransactionStatus>
                                    <token>84DPBHjpSS7QcV/grK+uZG1VusFkpzWgMzhebN+e0M8=</token>
                                    <request>
                                        <transid>transaction_id</transid>
                                    </request>
                                </api:getTransactionStatus>
                            </soapenv:Body>
                        </soapenv:Envelope>';
        $xml_data = str_replace(
            ['<transid>transaction_id</transid>'],
            ['<transid>' . $request->reference_id . '</transid>'],
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

    public function moovTransfer(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "phone_no" => "required|string|min:8|max:8",
                "amount" => "required",
                "wallet_id" => "required|string",
                "remarks" => "required|string",
            ]
        );
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'BAD REQUEST', "errors" => $validator->errors()], 400);
        }
        $reference_id = Str::uuid();
        $url = "https://apimarchand.moov-africa.bj/com.tlc.merchant.api/transferFlooz";
        $headers = array(
            'Content-Type: application/xml'
        );
        $xml_data = '<?xml version="1.0" encoding="utf-16"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.checktransaction.tlc.com/">
            <soapenv:Header/>
            <soapenv:Body>
                <api:transferFlooz>
                    <token>84DPBHjpSS7QcV/grK+uZG1VusFkpzWgMzhebN+e0M8=</token>
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
        $xml_data = str_replace(
            ['<destination>phone_no</destination>', '<amount>amount</amount>', '<referenceid>reference_id</referenceid>', '<walletid>wallet_id</walletid>', '<extendeddata>remarks</extendeddata>'],
            ['<destination>' . $request->phone_no . '</destination>', '<amount>' . $request->amount . '</amount>', '<referenceid>' . $reference_id . '</referenceid>', '<walletid>' . $request->wallet_id . '</walletid>', '<extendeddata>' . $request->remarks . '</extendeddata>'],
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
            $ns2 = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children('http://api.merchant.tlc.com/')->transferFloozResponse->return;
            $transactionId = (string) $ns2->transactionid;
            $status = (string) $ns2->status;
            $message = (string) $ns2->message;
            $referenceId = (string) $ns2->referenceid;
            $senderBalanceBefore = (string) $ns2->senderbalancebefore;
            $senderBalanceAfter = (string) $ns2->senderbalanceafter;
            if ($status == "0" && isset($message) && isset($referenceId) && $transactionId == $reference_id) {
                $data = [
                    "status" => $status,
                    "message" => $message,
                    "external_reference_id" => $referenceId,
                    "transaction_id" => $reference_id, // notre reference_id genere
                    "sender_balance_before" => $senderBalanceBefore,
                    "sender_balance_after" => $senderBalanceAfter
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

    public function moovGetMobileStatus(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "phone_no" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'BAD REQUEST', "errors" => $validator->errors()], 400);
        }

        $url = "https://apimarchand.moov-africa.bj/com.tlc.merchant.api/getMobileAccountStatus";
        $headers = array(
            'Content-Type: application/xml'
        );
        $xml_data = '<?xml version="1.0" encoding="utf-16"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.checktransaction.tlc.com/">
            <soapenv:Header/>
            <soapenv:Body>
                <api:getMobileAccountStatus>
                    <token>84DPBHjpSS7QcV/grK+uZG1VusFkpzWgMzhebN+e0M8=</token>
                    <request>
                        <msisdn>phone_no</msisdn>
                    </request>
                </api:getMobileAccountStatus>
            </soapenv:Body>
        </soapenv:Envelope>';
        $xml_data = str_replace(
            ['<msisdn>phone_no</msisdn>'],
            ['<msisdn>' . $request->phone_no . '</msisdn>'],
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
        $url = "https://apimarchand.moov-africa.bj/com.tlc.merchant.api/cashintrans";
        $headers = array(
            'Content-Type: application/xml'
        );
        $xml_data = '<?xml version="1.0" encoding="utf-16"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.checktransaction.tlc.com/">
            <soapenv:Header/>
            <soapenv:Body>
                <api:cashintrans>
                    <token>token</token>
                    <request>
                        <amount>amount</amount>
                        <destination>destination</destination>
                        <referenceid>reference</referenceid>
                        <remarks>remarks</remarks>
                    </request>
                </api:cashintrans>
            </soapenv:Body>
        </soapenv:Envelope>';
        $xml_data = str_replace(
            ['<amount>amount</amount>', '<destination>destination</destination>', '<referenceid>reference</referenceid>', '<remarks>remarks</remarks>'],
            ['<amount>' . $request->amount . '</amount>', '<destination>' . $request->amount . '</destination>', '<referenceid>' . $reference_id . '</referenceid>', '<remarks>' . $request->remarks . '</remarks>'],
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


        $url = "https://apimarchand.moov-africa.bj/com.tlc.merchant.api/airtimetrans";
        $headers = array(
            'Content-Type: application/xml'
        );
        $xml_data = '<?xml version="1.0" encoding="utf-16"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.checktransaction.tlc.com/">
            <soapenv:Header/>
            <soapenv:Body>
                <api:airtimetrans>
                    <token>lBQPnQ7raTMkrIVTgYASmrL5gd+keN6dZMLJzV/siaY=</token>
                    <request>
                        <amount>amount</amount>
                        <destination>destination</destination>
                        <referenceid>reference</referenceid>
                        <remarks>remarks</remarks>
                    </request>
                </api:airtimetrans>
            </soapenv:Body>
        </soapenv:Envelope>';
        $xml_data = str_replace(
            ['<amount>amount</amount>', '<destination>destination</destination>', '<referenceid>reference</referenceid>', '<remarks>remarks</remarks>'],
            ['<amount>' . $request->amount . '</amount>', '<destination>' . $request->amount . '</destination>', '<referenceid>' . $reference_id . '</referenceid>', '<remarks>' . $request->remarks . '</remarks>'],
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

    public function moovGetBalance(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "phone_no" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'BAD REQUEST', "errors" => $validator->errors()], 400);
        }


        $url = "https://apimarchand.moov-africa.bj/com.tlc.merchant.api/getBalance";
        $headers = array(
            'Content-Type: application/xml'
        );
        $xml_data = '<?xml version="1.0" encoding="utf-16"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.checktransaction.tlc.com/">
            <soapenv:Header/>
            <soapenv:Body>
                <api:getBalance>
                    <token>lBQPnQ7raTMkrIVTgYASmrL5gd+keN6dZMLJzV/siaY=</token>
                    <request>
                        <msisdn>phone_no</msisdn>
                    </request>
                </api:getBalance>
            </soapenv:Body>
        </soapenv:Envelope>';
        $xml_data = str_replace(
            ['<msisdn>phone_no</msisdn>'],
            ['<msisdn>' . $request->phone_no . '</msisdn>'],
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
            $balance = (string) $ns2->balance;
            $message = (string) $ns2->message;
            $status = (int) $ns2->status;
            if ($status == "0" && isset($message) && $message == "SUCCESS") {
                $data = [
                    "balance" => $balance,
                    "message" => $message,
                    "status" => $status
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

    public function moovPushWithPending(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "phone_no" => "required",
            "message" => "required",
            "amount" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'BAD REQUEST', "errors" => $validator->errors()], 400);
        }



        $url = "https://apimarchand.moov-africa.bj/com.tlc.merchant.api/PushWithPending";
        $headers = array(
            'Content-Type: application/xml'
        );
        $fee = 0;
        /** vtx
         * <externaldata1>pi_NyM_1642619082990</externaldata1>
         *<externaldata2>pi_NyM_1642619082990</externaldata2>
         */
        $xml_data = '<?xml version="1.0" encoding="utf-8"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.merchant.tlc.com/">
            <soapenv:Header/>
            <soapenv:Body>
                <api:PushWithPending>
                    <token>84DPBHjpSS7QcV/grK+uZG1VusFkpzWgMzhebN+e0M8=</token>
                    <msisdn>phone_no</msisdn>
                    <message>message</message>
                    <amount>amount</amount> 
                    <fee>fee</fee>
                </api:PushWithPending>
            </soapenv:Body>
        </soapenv:Envelope>';
        $xml_data = str_replace(
            ['<msisdn>phone_no</msisdn>', '<message>message</message>', '<amount>amount</amount>', '<fee>fee</fee>'],
            ['<msisdn>' . $request->phone_no . '</msisdn>', '<message>' . $request->message . '</message>', '<amount>' . $request->amount . '</amount>', '<fee>' . $fee . '</fee>'],
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
            $ns2 = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children('http://api.merchant.tlc.com/')->PushWithPendingResponse->result;
            $description = (string) $ns2->description;
            $referenceId = (string) $ns2->referenceid;
            $status = (int) $ns2->status;
            $transactionId = (string) $ns2->transid;


            if ($status == "0" && isset($description) && $description == "SUCCESS") {
                $data = [
                    "description" => $description,
                    "reference_id" => $referenceId,
                    "status" => $status,
                    "transaction_id" => $transactionId
                ];
                //PROCESS 
                return response()->json(['status' => true, 'data' => $data]);
            }
            if ($status == "100" && isset($description) && $description == "IN PENDING STATE") {
                $data = [
                    "description" => $description,
                    "reference_id" => $referenceId,
                    "status" => $status,
                    "transaction_id" => $transactionId
                ];
                // IN PENDING PROCESS
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
