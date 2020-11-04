var mysql = require('mysql');

var con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "root",
    database: "D4G"
});

con.connect(function(err) {
    if (err) throw err;
    con.query("SELECT CDR.CP FROM InfoCom, CDR, InfoCom_CDR WHERE InfoCom.CodeIris = InfoCom_CDR.CodeIris AND InfoCom_CDR.INSEE = CDR.INSEE AND CDR.NomCom like 'VEROSVRES';",
        function(err, result, fields) {
            if (err) throw err;
            console.log(result);
        });
});