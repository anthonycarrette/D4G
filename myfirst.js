var http = require('http');
var path = require('path');

http.createServer(function(req, res) {
    res.writeHead(200, { 'Content-Type': 'text/html' });
    //res.end('Hello World!');
    res.sendFile(path.join(__dirname + '/index.html'));
}).listen(8080);

/*
var http = require('http'); //On créé un serveur web
var express = require('express'); //On va récupèrer la page qui sera demandée
 
var server=express();
server.listen(8000);
 
server.get('/LOGIN', function(request, response) {
    response.sendFile( __dirname  + '/LOGIN.js');
});
*/