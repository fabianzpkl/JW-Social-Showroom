<?php
class Mailrelay {
	private $curl_url = 'http://tptbcol.ip-zone.com/ccm/admin/api/version/2/&type=json';

	public function func_name() {
		echo "soy func_name de Mailrelay";
	}

    function mailrelay_send($email,$name,$subject,$content,$attachments){
    	$apikey = $this->mailrelay_doAuthentication();
		// $curl = curl_init('http://cctdirect.ip-zone.com/ccm/admin/api/version/2/&type=json');
		$curl = curl_init($this->curl_url);

		// Create rcpt array to send emails to 2 rcpts
		$rcpt = array(
		    array(
		        'name' => $name,
		        'email' => $email
		    )
		);

		/*if (!$attachments) {
			$attachments = array();
		}*/

		$postData = array(
		    'function' => 'sendMail',
		    'apiKey' => $apikey,
		    'subject' => $subject,
		    'html' => $content,
		    'mailboxFromId' => 1,
		    'mailboxReplyId' => 1,
		    'mailboxReportId' => 1,
		    'packageId' => 6,
		    'emails' => $rcpt,
		    'attachments' => $attachments
		);

		$post = http_build_query($postData);

		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		$json = curl_exec($curl);
		$result = json_decode($json);
		//var_dump($result);

		/*if ($result->status == 0) {
		    throw new Exception('Bad status returned. Something went wrong.');
		}

		var_dump($result->data);	*/
	}

    private function mailrelay_doAuthentication(){
		$curl = curl_init('http://tptbcol.ip-zone.com/ccm/admin/api/version/2/&type=json');
		
		$postData = array(
		    'function' => 'doAuthentication',
		    //'username' => 'cctdirect',
		    //'password' => '01a60169'
		    'username' => 'tptbcol',
		    'password' => '24e156c0'
		);

		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		$json = curl_exec($curl);
		$result = json_decode($json);
		//var_dump($result);

		if ($result->status == 0) {
		    throw new Exception('Bad status returned. Something went wrong.');
		}

		//var_dump($result->data);

		return $result->data;
	}


	function mailrelay_getPackages(){
		$apikey = $this->mailrelay_doAuthentication();
		$curl = curl_init('http://tptbcol.ip-zone.com/ccm/admin/api/version/2/&type=json');

		$postData = array(
		    'function' => 'getPackages',
		    'apiKey' => $apikey,
		);

		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		$json = curl_exec($curl);
		$result = json_decode($json);
		//var_dump($result);
		//if ($result->status == 0) {
		//    throw new Exception('Bad status returned. Something went wrong.');
		//}

		var_dump($result->data);
	}

	public function test(){
		print_r('hola mailrelay');
	}

}
?>