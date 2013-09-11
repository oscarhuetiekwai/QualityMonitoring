<?php
class Voicetag_model extends MY_Model {

	protected $_table = 'qm.voice_tag';
	protected $primary_key = 'voice_tag_id';


	function get_voice_tag($record_id)
	{
		$this->db->where('qm.voice_tag.record_id', $record_id);
		return $this;
	}
}
?>