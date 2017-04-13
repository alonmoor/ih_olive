<?PHP
	// Stick your DBOjbect subclasses in here (to help keep things tidy).

	class User extends DBObject3
	{
		function __construct($id = '')
		{
			parent::__construct('users', 'userID', array('username', 'password', 'level', 'email'), $id);
		}
	}