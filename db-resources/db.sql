USE renap_users;

CREATE TABLE oauth_clients (
	client_id VARCHAR(80) NOT NULL, 
	client_secret VARCHAR(80), 
	redirect_uri VARCHAR(2000) NOT NULL, 
	grant_types VARCHAR(80), 
	scope VARCHAR(100), 
	user_id VARCHAR(80), 
	PRIMARY KEY (client_id)
);

CREATE TABLE oauth_access_tokens (
	access_token VARCHAR(40) NOT NULL, 
	client_id VARCHAR(80) NOT NULL, 
	user_id VARCHAR(255), 
	expires TIMESTAMP NOT NULL, 
	scope VARCHAR(2000), 
	PRIMARY KEY (access_token)
);

CREATE TABLE oauth_authorization_codes (
	authorization_code VARCHAR(40) NOT NULL, 
	client_id VARCHAR(80) NOT NULL, 
	user_id VARCHAR(255), 
	redirect_uri VARCHAR(2000), 
	expires TIMESTAMP NOT NULL, 
	scope VARCHAR(2000), 
	PRIMARY KEY (authorization_code)
);

CREATE TABLE oauth_refresh_tokens (
	refresh_token VARCHAR(40) NOT NULL, 
	client_id VARCHAR(80) NOT NULL, 
	user_id VARCHAR(255), 
	expires TIMESTAMP NOT NULL, 
	scope VARCHAR(2000), 
	PRIMARY KEY (refresh_token)
);

CREATE TABLE oauth_users (
	username VARCHAR(255) NOT NULL, 
	password VARCHAR(2000), 
	first_name VARCHAR(255), 
	last_name VARCHAR(255), 
	PRIMARY KEY (username)
);

CREATE TABLE oauth_scopes (
	scope TEXT, 
	is_default BOOLEAN
);

CREATE TABLE oauth_jwt (
	client_id VARCHAR(80) NOT NULL, 
	subject VARCHAR(80), 
	public_key VARCHAR(2000), 
	PRIMARY KEY (client_id)
);

INSERT INTO oauth_clients (client_id, client_secret, redirect_uri) VALUES ("testclient", "testpass", "http://localhost/response");
