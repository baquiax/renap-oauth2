USE renap_users;

DROP TABLE IF EXISTS oauth_access_tokens;
DROP TABLE IF EXISTS oauth_clients;
DROP TABLE  IF EXISTS oauth_refresh_tokens;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
	username varchar(50) not null,
	passwd varchar(150) not null,
	primary key (username)
);


CREATE TABLE oauth_access_tokens (
	access_token varchar(200) not null,
	client_id varchar(10) not null,
	username varchar(50) not null,
	expires timestamp not null,
	primary key(access_token),
	foreign key(username) references users(username) 
);

CREATE TABLE oauth_clients(
	client_id int auto_increment,
	client_secret varchar(100) not null,
	redirect_uri text not null,
	primary key(client_id)
);

CREATE TABLE oauth_refresh_tokens(
	refresh_token varchar(100) not null,
	client_id int not null,
	username varchar(50) not null,
	expires timestamp not null,
	primary key(refresh_token),
	foreign key(username) references users(username),
	foreign key(client_id) references oauth_clients(client_id)
);
	
CREATE INDEX users_u_p ON users(username, passwd) USING BTREE;
