/**
 * Identifiants MySQL
 */

// Dépendances aux paquets externes
var express    = require('express');        
var mysql      = require('mysql');
var bodyParser = require('body-parser');
 
var app        = express(); 
var connection      = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "root",
    database: "D4G"
});

 
/**
 * Configuration du bodyParser pour pouvoir traiter 
 * les requêtes en POST
 */
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());
 
/**
 * Définition des routes
 */
var router = express.Router();         
 
// Route par défaut
router.get('/', function(req, res) {
    res.json({ 
        message: 'Bienvenue sur l\'API des stations radios. Voici la documentation :',
        url: 'http://xxx.app/station-radio/documentation'
    });   
});
 
// Route : station la plus proche
router.route('/nearest')
    .post(function(req, res) {
        var station = req.body.station;
        var lattitude = req.body.lattitude;
        var longitude = req.body.longitude;
 
        // Contrôle des erreurs ...
 
        connection.connect();
        connection.query("select freqProche(?, ?, ?);", [station, lattitude, longitude], function (err, rows) {
            if (err) throw err;
            res.json(rows);
        });
        connection.end();
    });
 
 
app.use('/api', router);
 


// Démarrage du serveur
app.listen(port);
 
console.log('Serveur en écoute sur le port ' + port);