[new_user]

INSERT INTO
	ka_user
SET
	 register_date = "%s"
	,email         = "%s"
	,dob           = "%s"
	,_pwd_hash     = "%s"
	,_salt         = "%s"
	,_auth_hash    = "%s"
	
[remove_user]

DELETE FROM
	ka_user
WHERE
	id = %u
	
[update_user_1]

UPDATE
	ka_user
SET
	_salt = 'r9gsb'
WHERE
	id = %u
	
