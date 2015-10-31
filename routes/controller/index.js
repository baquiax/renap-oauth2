var mysql = require('mysql');
var conn = mysql.createConnection({
	host: "localhost",
	user: "baquiax",
	password: "admin",
	database: "renap"
});

var model = module.exports;

model.getAccessToken = function(bearerToken, callback) {
	var query = "SELECT * FROM oauth_access_tokens WHERE access_token = ?";
	conn.query(query, bearerToken, function(err, clients, done) {
		
	});
};