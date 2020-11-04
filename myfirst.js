var http = require('http');

http.createServer(function(req, res) {
    res.writeHead(200, { 'Content-Type': 'text/html' });
    //res.end('Hello World!');
    res.sendFile('index.html');
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