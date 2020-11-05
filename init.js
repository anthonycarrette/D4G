var express = require('express');
var mysql = require('mysql');
var app = express();

/*
app.get('/', function(req, resp){
    resp.sendFile( __dirname + '/index.html');
});
*/

var connection = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "root",
    database: "D4G"
});

connection.connect(function(error) {
    if (!!error)  {
        console.log('Error');
    } else {
        console.log('Connected');
    }
});

var CodePostal = 49750;
var sql = "SELECT CDR.CP, CDR.NomCom, InfoCom.Population, InfoCom.ScoreGlobalCom, InfoCom.AccesInterfaceNum, InfoCom.AccesInformation, InfoCom.CompAdministrative, InfoCom.CompNumerique, InfoCom.GlobalAcces, InfoCom.GlobalCompetences, CDR.NomDep, CDR.NomRegion, InfoCom.ScoreGlobalRegion FROM InfoCom, CDR, InfoCom_CDR WHERE InfoCom.CodeIris = InfoCom_CDR.CodeIris AND InfoCom_CDR.INSEE = CDR.INSEE AND CDR.CP = ?";
app.get('/', function(req, resp) {
    connection.query(sql, [CodePostal], function(error, rows, fields) {
        if (!!error)  {
            console.log('Error in the query');
        } else {
            console.log('Successfull query');
            console.log(rows[0].CP);
            resp.send(rows[0].CP);
/*            resp.send('<table>');
            resp.send('<tr><th rowspan="2">Code Postal</th><th colspan="2">Commune</th><th colspan="2">Accès</th><th colspan="2">Compétences</th><th rowspan="2">Score Global</th></tr>');
            resp.send('<tr><td>Nom</td><td>Population</td><td>Accès aux interfaces numériques</td><td>Accès à l\'information</td><td>Compétences administratives</td><td>Compétences numériques/scolaires</td></tr>');
            resp.send('<tr><td>');
            resp.send(rows[0].CP);
            resp.send('</td><td>');
            resp.send(rows[0].NomCom);
            resp.send('</td><td>');
            resp.send(rows[0].Population)
            resp.send('</td><td>');
            resp.send(rows[0].AccesInterfaceNum);
            resp.send('</td><td>');
            resp.send(rows[0].AccesInformation);
            resp.send('</td><td>');
            resp.send(rows[0].CompAdministrative);
            resp.send('</td><td>');
            resp.send(rows[0].CompNumerique);
            resp.send('</td><td>');
            resp.send(rows[0].ScoreGlobalCom);
            resp.send('</td><td>');
            resp.send('</table>');
            resp.send('<p>Score de la région : </p>');
            resp.send(rows[0].ScoreGlobalRegion);
            resp.end();
*/        }
    });
});

app.listen(8080);
