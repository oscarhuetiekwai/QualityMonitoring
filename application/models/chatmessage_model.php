<?php
class Chatmessage_model extends MY_Model {

	protected $_table = 'webim_db.chatmessage';
	protected $primary_key = 'messageid';

	function get_user($record_id)
	{
		$this->db->join('qm.recordings', 'chatmessage.threadid = qm.recordings.unique_id');

		//$this->db->where('chatmessage.agentId', $userid);
		$this->db->where('qm.recordings.record_id', $record_id);
		return $this;
	}

}
?>