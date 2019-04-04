<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class IPN extends CI_Controller {



	public function blockchain()
	{
		$invoice_id = $this->input->get('invoice_id');
		$transaction_hash = $this->input->get('transaction_hash');
		$value_in_btc = $this->input->get('value') / 100000000;
		$secret = $this->config->item('blockchain_secret');
		$user = $this->input->get('user');
		//$price = $this->input->get('price');

		if ($_GET['secret'] != $secret
				&& $user && is_numeric($user)
				//&& $price && is_numeric($price)
				) {
			return;
		}

		//$price = get_file_contents("https://blockchain.info/tobtc?currency=USD&value=1");
		$ticker = json_decode(file_get_contents("https://blockchain.info/ticker"));
		$one = file_get_contents("https://blockchain.info/tobtc?currency=USD&value=1");
		$price = round($value_in_btc / $one, 2);
		/*$currency = 'USD';
		//get json response
		$return = file_get_contents('http://data.mtgox.com/api/1/BTC'.$currency.'/ticker_fast');
		//decode it (into an array rather than object [using 'true' parameter])
		$info = json_decode($return, true);
		//access the dollar value
		$price = $info['return']['last_local']['value'];

		$price = get_file_contents("https://blockchain.info/tobtc?currency=USD&value=".$priceOfYourItemUSD);*/
		$this->db->where('id', $user);
		$this->db->set('balance', 'balance+' . $price, FALSE);
		$this->db->update('user');

		
		$this->db->insert('user_sale', array(
			'date' => time(),
			'user' => $user,
			'spent' => $price

		));
		echo "*ok*";
	}


	public function btc()

	{

		$data = json_decode(file_get_contents("php://input"), TRUE);

		$custom = json_decode($data['order']['custom']);

		

		$this->db->where('id', $custom->user);

		$this->db->set('balance', 'balance+' . $custom->bal, FALSE);

		$this->db->update('user');

		

		$this->db->insert('user_sale', array(

			'date' => time(),

			'user' => $custom->user,

			'spent' => $custom->bal

		));

	}

}