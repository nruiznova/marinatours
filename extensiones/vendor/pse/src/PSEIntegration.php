<?php

namespace PSEIntegration;

use \PSEIntegration\Services\ApigeeServices;
use \PSEIntegration\Models\GetBankListRequest;
use \PSEIntegration\Models\CreateTransactionPaymentRequest;
use \PSEIntegration\Models\CreateTransactionPaymentResponse;
use \PSEIntegration\Models\FinalizeTransactionPaymentRequest;
use \PSEIntegration\Models\FinalizeTransactionPaymentResponse;
use \PSEIntegration\Models\TransactionInformationRequest;
use \PSEIntegration\Models\TransactionInformationResponse;

class PSEIntegration
{
    private $services;

    public function __construct()
    {
        $this->services = new ApigeeServices(
            'AwwmP5xNvSjxTXygW2in58dKPHpfRZjM', //clientId 
            '1Bhw7eHBDY4zA7bM', //clientSecret
            'https://apiprd.pse.com.co', //organizationProdUrl 
            '4ZE5GXR2RJWLQOTB', //encryptIV
            'RFN9K73FL1DRNEAHU08MJRRMQF99N3B4', //encryptKey
            'v2', // apigeeDirectoryUrl
        );
    }

    public function setTimeout(int $timeout)
    {
        $this->services->apigeeDefaultTimeout = $timeout;
    }
    
    public function setCertificateIgnoreInvalid(bool $certificateIgnoreInvalid)
    {
        $this->services->certificateIgnoreInvalid = $certificateIgnoreInvalid;
    }

    public function setMutualTLSCertificate(string $certificateFile, string $certificatePassword)
    {
        $this->services->certificateFile = $certificateFile;
        $this->services->certificatePassword = $certificatePassword;
    }

    public function getBankList(GetBankListRequest $request, string $access_token)
    {
        return $this->services->getBankList($request, $access_token);
    }

    public function createTransactionPayment(CreateTransactionPaymentRequest $request, string $access_token)
    {
        return $this->services->createTransactionPayment($request, $access_token);
    }

    public function finalizeTransactionPayment(FinalizeTransactionPaymentRequest $request, string $access_token)
    {
        return $this->services->finalizeTransactionPayment($request, $access_token);
    }

    public function getTransactionInformation(TransactionInformationRequest $request, string $access_token)
    {
        return $this->services->getTransactionInformation($request, $access_token);
    }
}
