<?php
namespace App\Helpers\MtnMomo;

class Mtn_Momo
{
    protected $_sand_base_url = "https://sandbox.momodeveloper.mtn.com/v1_0";
    protected $_live_base_url = "https://proxy.momoapi.mtn.com";

    protected $_sand_colPrimKey;
    protected $_sand_colSecdKey;
    protected $_sand_colXRefId;
    protected $_sand_colApiUser;
    protected $_sand_colApiKey;
    
    protected $_colApiUser;
    protected $_colApiKey;

    public function __construct()
    {
        // _colXRefId === _colApiUser

        
        //Live
        


    }

    public function apiUser($xRefID)
    {
        
        
    }

    public function apiUserKey($xRefID)
    {
         
    }

    public function apiUserDetails($xRefID)
    {
        
    }

}
