<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
	public function __construct($config = [])
	{
		parent::__construct($config);
	}

	/**
	 * Is Unique
	 *
	 * Check if the input value doesn't already exist
	 * in the specified database field.
	 *
	 * @param	string	$str
	 * @param	string	$field
	 * @return	bool
	 */
	public function is_unique($str, $field)
	{
		// sscanf($field, '%[^.].%[^.]', $table, $field);
		sscanf($field, '%[^.].%[^.].%[^.]', $schema, $table, $field);
		return isset($this->CI->db)
			? ($this->CI->db->limit(1)->get_where($schema . '.' . $table, array($field => $str))->num_rows() === 0)
			: FALSE;
	}

	function error_array()
	{
		if (count($this->_error_array) === 0)
			return FALSE;
		else
			return $this->_error_array;
	}
	// --------------------------------------------------------------------
}
