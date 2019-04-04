<?php

class FeedModel extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function gets($limit, $for = 0)
	{
		return $this->db->limit($limit)
			-> order_by('date', 'DESC')
			-> where('for', $for)
			-> get('feed')
			-> result();
	}

	public function insert ($info, $for = 0)
	{
		$info['date'] = time();
		$info['for'] = $for;
		$this->db->insert('feed', $info);
	}
}