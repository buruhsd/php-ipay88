# IPay88

Ipay88 payment gateway module.

## Installation

Dokumentasi lengkap bisa di lihat di [IPAY88](https://docs.ipay88.co.id/)

```bash
$ composer require aljawad/php-ipay88 dev-master
```

## Example Controller

```php
<?php

class Payment {

	protected $_merchantCode;
	protected $_merchantKey;

	public function __construct()
	{
		parent::__construct();
		$this->_merchantCode = 'xxxxxx'; //MerchantCode confidential
		$this->_merchantKey = 'xxxxxxxxx'; //MerchantKey confidential
	}

	public function index()
	{
		$request = new \IPay88\Payment\Request($this->_merchantKey);
		$this->_data = array(
			'merchantCode' => $request->setMerchantCode($this->_merchantCode),
			// 'paymentId' =>  $request->setPaymentId(0),
			'refNo' => $request->setRefNo('EXAMPLE0001'),
			'amount' => $request->setAmount('1000'),
			'currency' => $request->setCurrency('IDR'),
			'prodDesc' => $request->setProdDesc('Testing'),
			'userName' => $request->setUserName('Your name'),
			'userEmail' => $request->setUserEmail('email@example.com'),
			'userContact' => $request->setUserContact('0123456789'),
			'remark' => $request->setRemark('Some remarks here..'),
			'lang' => $request->setLang('UTF-8'),
			'signature' => $request->getSignature(),
			'responseUrl' => $request->setResponseUrl('http://ipay88.test/response'),
			'backendUrl' => $request->setBackendUrl('http://ipay88.test/backend'),
			'xfield1' => $request->setXfield1('||IPP:3||'),
			);

		\IPay88\Payment\Request::make($this->_merchantKey, $this->_data);
	}
	
	public function response()
	{	
		$response = (new \IPay88\Payment\Response)->init($this->_merchantCode);
		echo "<pre>";
		print_r($response);
	}
}
```
REFERENSI

https://github.com/karyamedia/ipay88.
<br>
https://docs.ipay88.co.id/

