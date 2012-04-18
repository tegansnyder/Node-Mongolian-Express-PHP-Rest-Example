var express = require('express')
  , http = require('http')
  , Mongolian = require("mongolian")
  , ObjectId = require('mongolian').ObjectId
  , Timestamp = require('mongolian').Timestamp;

var app = express();
var server = new Mongolian;
var db = server.db("nodetest");

app.configure(function(){
  app.use(express.logger('dev'));
  app.use(express.bodyParser());
  app.use(express.methodOverride());
});

app.configure('development', function(){
  app.use(express.errorHandler());
});

app.post('/address', function(req, res){
  
	var locations = db.collection("locations");

	locations.insert({
		address: req.body.address,
		city: req.body.city,
		state: req.body.state
	});

	
	res.end();
  
});

app.get('/address/:id', function(req, res){

	var locations = db.collection("locations");

	locations.findOne({ _id: new ObjectId(req.params.id) }, function(err, post) {

		post._id = post._id.toString();
		
		res.send(JSON.stringify(post));

	});

  
});

app.get('/addresses', function(req, res){

	var locations = db.collection("locations");

	locations.find().toArray(function (err, data) {
	
		var output = [];
	
		for(var i=0;i<data.length;i++){
		
			data[i]._id = data[i]._id.toString();

			output.push(data[i]);
		}
		
		res.send(JSON.stringify(output));

	});
  
});

http.createServer(app).listen(3000);

console.log("Express server listening on port 3000");
