INSERT INTO ft_table (login, groupe, creation_date)
	SELECT last_name AS login, 'other' AS groupe, birthdate AS creation_date
	FROM user_card
	WHERE last_name LIKE '%a%' AND LENGTH(last_name) < 9
	ORDER BY last_name ASC
	LIMIT 0, 10;
