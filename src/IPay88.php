<?php 
use IPay88\RequestForm;

class IPay88
{
	private $merchantKey = null;
	public $merchantCode = null;
	public $responseUrl = null;
	public $backendResponseUrl = null;

	public function __construct($merchantKey, $merchantCode, $responseUrl, $backendResponseUrl)
	{
		$this->merchantKey = $merchantKey;
		$this->merchantCode= $merchantCode;
		$this->responseUrl = $responseUrl;
		$this->backendResponseUrl = $backendResponseUrl;
	}
	
	/**
     * Generate signature to be used for transaction.
     *
     * You may verify your signature with online tool provided by iPay88
     * http://www.mobile88.com/epayment/testing/TestSignature.asp
     *
     * @access public
     * @param string $merchantKey ProvidedbyiPay88OPSGandsharebetweeniPay88and merchant only
     * @param string $merchantCode Merchant Code provided by iPay88 and use to uniquely identify the Merchant.
     * @param string $refNo Unique merchant transaction id
     * @param int $amount Payment amount
     * @param string $currency Payment currency
     */
    public function generateSignature($refNo, $amount, $currency)
    {
        $stringToHash = $this->merchantKey.$this->merchantCode.$refNo.$amount.$currency;
        return base64_encode(self::_hex2bin(sha1($stringToHash)));
    }

    /**
    *
    * equivalent of php 5.4 hex2bin
    *
    * @access private
    * @param string $source The string to be converted
    */
    private function _hex2bin($source)
    {
    	$bin = null;
    	for ($i=0; $i < strlen($source); $i=$i+2) { 
    		$bin .= chr(hexdec(substr($source, $i, 2)));
    	}
    	return $bin;
    }

    /**
    * @access public
    * @param boolean $multiCurrency Set to true to get payments optinos for multi currency gateway
    */
    public static function getPaymentOptions($multiCurrency = false)
    {
        $myrOnly = array(
            52 => array('BCA','IDR'),
            35 => array('BRI','IDR'),
            42 => array('CIMB','IDR'),
            56 => array('CIMB Authorization','IDR'),
            34 => array('CIMB IPG','IDR'),
            45 => array('Danamon','IDR'),
            53 => array('Mandiri','IDR'),
            43 => array('Maybank', 'IDR'),
            54 => array('UnionPay','IDR'),
            46 => array('UOB','IDR'),
            
            4 => array('Mandiri Clickpay','IDR'),
            11 => array('CIMB Clicks','IDR'),
            14 => array('Muamalat IB','IDR'),
            23 => array('Danamon Online Banking','IDR'),

            63 => array('OVO','IDR'),
        );

        $nonMyr = array(
            25=> array('Credit Card','USD'),
            35=> array('Credit Card','GBP'),
            36=> array('Credit Card','THB'),
            37=> array('Credit Card','CAD'),
            38=> array('Credit Card','SGD'),
            39=> array('Credit Card','AUD'),
            40=> array('Credit Card','MYR'),
            41=> array('Credit Card','EUR'),
            42=> array('Credit Card','HKD'),
        );

        return $multiCurrency ? $multiCurrency : $myrOnly;
    }

    /**
    * @access public
    * @param 
    */
    public function makeRequestForm($args)
    {
    	$args['merchantCode'] = $this->merchantCode;
    	$args['signature'] = $this->generateSignature(
    		$args['refNo'],
    		(int) $args['amount'],
    		$args['currency']
    		);
    	$args['responseUrl'] = $this->responseUrl;
    	$args['backendUrl'] = $this->backendResponseUrl;

        return new IPay88\RequestForm($args);
    }
}
