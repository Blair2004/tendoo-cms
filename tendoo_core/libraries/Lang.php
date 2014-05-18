<?php
Class Lang
{
	private $current;
	public function __construct()
	{
	}
	public function load($mixed_library)
	{
		switch($mixed_library)
		{
			case 'form_validation':
				$this->current	=	'form_val';
			break;
			case 'date':
				$this->current	=	'date';
			break;
			case 'db':
				$this->current	=	'db';
			break;
						
			default:
			return $mixed_library;
			break;
		}
	}
	public function line($type)
	{
		if($this->current == 'form_val')
		{
			$lang['required']			= "The %s field is required.";
			$lang['isset']				= "The %s field must have a value.";
			$lang['valid_email']		= "The %s field must contain a valid email address.";
			$lang['valid_emails']		= "The %s field must contain all valid email addresses.";
			$lang['valid_url']			= "The %s field must contain a valid URL.";
			$lang['valid_ip']			= "The %s field must contain a valid IP.";
			$lang['min_length']			= "The %s field must be at least %s characters in length.";
			$lang['max_length']			= "The %s field can not exceed %s characters in length.";
			$lang['exact_length']		= "The %s field must be exactly %s characters in length.";
			$lang['alpha']				= "The %s field may only contain alphabetical characters.";
			$lang['alpha_numeric']		= "The %s field may only contain alpha-numeric characters.";
			$lang['alpha_dash']			= "The %s field may only contain alpha-numeric characters, underscores, and dashes.";
			$lang['numeric']			= "The %s field must contain only numbers.";
			$lang['is_numeric']			= "The %s field must contain only numeric characters.";
			$lang['integer']			= "The %s field must contain an integer.";
			$lang['regex_match']		= "The %s field is not in the correct format.";
			$lang['matches']			= "The %s field does not match the %s field.";
			$lang['is_unique'] 			= "The %s field must contain a unique value.";
			$lang['is_natural']			= "The %s field must contain only positive numbers.";
			$lang['is_natural_no_zero']	= "The %s field must contain a number greater than zero.";
			$lang['decimal']			= "The %s field must contain a decimal number.";
			$lang['less_than']			= "The %s field must contain a number less than %s.";
			$lang['greater_than']		= "The %s field must contain a number greater than %s.";
			if(array_key_exists($type,$lang))
			{
				return $lang[$type];
			}
		}
		else if($this->current	==	'db')
		{
			$lang['db_invalid_connection_str'] = 'Unable to determine the database settings based on the connection string you submitted.';
			$lang['db_unable_to_connect'] = 'Unable to connect to your database server using the provided settings.';
			$lang['db_unable_to_select'] = 'Unable to select the specified database: %s';
			$lang['db_unable_to_create'] = 'Unable to create the specified database: %s';
			$lang['db_invalid_query'] = 'The query you submitted is not valid.';
			$lang['db_must_set_table'] = 'You must set the database table to be used with your query.';
			$lang['db_must_use_set'] = 'You must use the "set" method to update an entry.';
			$lang['db_must_use_index'] = 'You must specify an index to match on for batch updates.';
			$lang['db_batch_missing_index'] = 'One or more rows submitted for batch updating is missing the specified index.';
			$lang['db_must_use_where'] = 'Updates are not allowed unless they contain a "where" clause.';
			$lang['db_del_must_use_where'] = 'Deletes are not allowed unless they contain a "where" or "like" clause.';
			$lang['db_field_param_missing'] = 'To fetch fields requires the name of the table as a parameter.';
			$lang['db_unsupported_function'] = 'This feature is not available for the database you are using.';
			$lang['db_transaction_failure'] = 'Transaction failure: Rollback performed.';
			$lang['db_unable_to_drop'] = 'Unable to drop the specified database.';
			$lang['db_unsuported_feature'] = 'Unsupported feature of the database platform you are using.';
			$lang['db_unsuported_compression'] = 'The file compression format you chose is not supported by your server.';
			$lang['db_filepath_error'] = 'Unable to write data to the file path you have submitted.';
			$lang['db_invalid_cache_path'] = 'The cache path you submitted is not valid or writable.';
			$lang['db_table_name_required'] = 'A table name is required for that operation.';
			$lang['db_column_name_required'] = 'A column name is required for that operation.';
			$lang['db_column_definition_required'] = 'A column definition is required for that operation.';
			$lang['db_unable_to_set_charset'] = 'Unable to set client connection character set: %s';
			$lang['db_error_heading'] = 'A Database Error Occurred';
			if(array_key_exists($type,$lang))
			{
				return $lang[$type];
			}
		}
		return 'Erreur inconnue';		
	}
}