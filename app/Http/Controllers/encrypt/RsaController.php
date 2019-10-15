<?php
namespace App\Http\Controllers\encrypt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RsaController extends Controller {

	public function rsa_encrypt(Request $request) {
		$app_path = base_path();
		$public_key = file_get_contents($app_path.'/config/encrypt/rsa_public_key.pem');
		$data = 'zhangyangyang';//要加密的数据
		$result = '';
		openssl_public_encrypt($data,$result,$public_key);
		return $result;
		print_r($result);

	}

	public function rsa_decrypt(Request $request) {
	/*
	-----BEGIN RSA PRIVATE KEY-----
MIICXgIBAAKBgQDHcIXY5219jDkWfVCcFhuk2oGjXw/ka958GsdQ6eGXxlKax6Ux
8+UQmJ418jPhkjkULpHQ5GHgB1ag2knwULrUWGZfVaUD9zBjendh80ytHaCeptgy
aLtrXbPbHlLw2ydMcE8b+gfM0Txq54QfUiRwI3wT532nXnX1N45lWszphwIDAQAB
AoGAH+hTsakM7lohxARWgjJTR+Ohe/a4fy320Voja0GP0w1qp9KrDjvb+PTB0xWl
0T/om977ezUep43lASULUURJL2kTxFZoowrk7msCHpVRaUrrTIVI+Lxc1W71SvmT
fsGF6hZp12Vk1EvtiUwIGKB8HQqKOlGOpaJAUE54V1s9ogECQQD9PPBWzEjJFEyt
IQ/AvbzFrHVP5SZm7ti6CQa2RYZunBljGlOiHZe/WxYlYAVXzb+2ITzCEW/Yx9/M
4dNr64CHAkEAyZ1fzfd77h3Qoemn++p1eZvWs8QxQeaz5hXFzxmj0z6qUJ66P+7a
lzgZdn29hn3pnhUQPFNbXfss3HXiALqPAQJBALzzr1DUdKq0ntG/jYV/DU9hctb+
YD0FkmidO4jdL4Vwq/CqQCUCd6usR0Xz84ikWJuJCVC0ugPCf1bcWWh4/BkCQQCJ
umpSJ7iPh+qYUSgiXZ52vtDC6UnE/Tbz/PeubJOPoYVzoZsWRbMqDnbGjUtFbwqC
pVz7+O23m/ifeiAz4z4BAkEAzn4SOQVhIP3MZs3b0j9SRFBLIBokCWCLQgO6Jww+
lvh4oDuFqpYKRVzb4R1RPe9BvRRyCNZp05pD/eSF8cETLQ==
-----END RSA PRIVATE KEY-----
	 */
		$encrypt_data = $this->rsa_decrypt();
		$descrypt_msg = '';
		$private_key = file_get_contents('config/encrypt/rsa_private_key.pem');
		openssl_private_decrypt($encrypt_data,$descrypt_msg,$private_key);
		echo $descrypt_msg.PHP_EOL;

	}

}



?>
