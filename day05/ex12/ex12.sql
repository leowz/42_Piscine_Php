SELECT last_name, first_name
	FROM user_card
	WHERE last_name LIKE "%-%"
	OR first_name LIKe "%-%"
	ORDER BY last_name ASC, first_name ASC;
