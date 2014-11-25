<?php
/*
**	This class will contain common methods for validating form entries
*/
class Validate
{
	//	this function can be used for checking that the field is not empty
	public function checkRequired($field)
	{
		if (!$field) {
			return false;
		}
		return true;
	}
	//	this function can be used for validating name fields
	public function checkName($name)
	{
		if(!preg_match('/^[[:alpha:][:blank:]\']+$/',$name)){
			return false;
		}
		return true;
	}

	public function checkUsername($username) {

		// If the username violates the pattern
		if( !preg_match('/^[a-zA-Z0-9\-_]{5,15}$/', $username) ) {
			return false;
		}

		return true;

	}

	// checking for a valid email
	public function checkEmail($email)
	{ 
        if(!preg_match('/^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-\.]+\.[a-zA-Z0-9_\-]+$/',$email)){
			return false;	
        }
		return true;
   }
	//	check that a field is a number
	public function checkNumeric($field)
	{
		if (!is_numeric($field)) {
			// Failed
			return false;
		}
		return true;
	}
 
 //	this function checks if date passed as argument is valid
   public function checkDateField($month, $day, $year)
   {
		$month++;
		if (!is_numeric($month) || !is_numeric($day) || !is_numeric($year) || !checkdate($month, $day, $year)) {
			$msg = '*Invalid Date';
		}	
		return $msg;
   }
   //	this function validates a select field ($field) 
   //		against the valid options ($options)
   //		and an optional feature ($key, optional parameter)
   //		if we want the validation to be against the key rather than the value
   public function checkSelectField($field, $options, $key='')
   {
	//	check if $key exists and if it does use function array_key_exists
	//		which will return true if $field is found 
	//		as a key on the array
		if ($key) {	//	$key is set, use key for comparison
			if (!array_key_exists($field, $options)) {
				$msg = '*Invalid option';
				return $msg;	//	$field is not a key in array $options
			}	
		}
		//	when $key is not set, use the value for comparison
		if (!$key) {
			if (!in_array($field, $options)) {
				$msg = '*Invalid option';
				return msg;	//	$field not found in array $options
			}
		}
   }
    
   //	this function checks if there is at least one error message stored in the
   //		array of messages
	public function checkErrorMessages($result)
	{
		foreach($result as $errorMsg) {
			//	if at least one error message exists in the array,
			//		it will exit out of the function 
			//		(i.e. abnormal termination of the loop and the function)
			if (strlen($errorMsg) > 0) {
				return false;
			}
		}
		//	if the loop finishes normally, that means it did not find
		//		any error message in the array
		return true;
	}
   

}

?>