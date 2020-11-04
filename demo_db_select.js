var mysql = require('mysql');

var con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "root",
    database: "D4G"
});

con.connect(function(err) {
    if (err) throw err;
    con.query("SELECT CDR.CP, CDR.NomCom, InfoCom.Population, InfoCom.ScoreGlobalCom, InfoCom.AccesInterfaceNum, InfoCom.AccesInformation, InfoCom.CompAdministrative, InfoCom.CompNumerique, InfoCom.GlobalAcces, InfoCom.GlobalCompetences, CDR.NomDep, CDR.NomRegion, InfoCom.ScoreGlobalRegion FROM InfoCom, CDR, InfoCom_CDR WHERE InfoCom.CodeIris = InfoCom_CDR.CodeIris AND InfoCom_CDR.INSEE = CDR.INSEE AND CDR.CP = 49750;",
        function(err, result, fields) {
            if (err) throw err;
            console.log(result);
        });
});

//mysql.escape()  échaper les saisies utilisateurs

//var adr = 'Mountain 21';
//var sql = 'SELECT * FROM customers WHERE address = ?';
//con.query(sql, [adr], function (err, result) {
//  if (err) throw err;
//  console.log(result);
//});