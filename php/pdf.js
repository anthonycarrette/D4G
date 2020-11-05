
function telecharger(){
    var doc = new jsPDF();
    var specialElementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };
    
    doc.fromHTML($('#content').html(), 15, 15, {
        'width': 170,
        'elementHandlers': specialElementHandlers
     });
    doc.save('sample-file.pdf');
}

/*
function telecharger(){
    var w = document.getElementById("content").offsetWidth;
    var h = document.getElementById("content").offsetHeight;
    html2canvas(document.getElementById("content"), {
      dpi: 300, // Set to 300 DPI
      scale: 3, // Adjusts your resolution
      onrendered: function(canvas) {
        var img = canvas.toDataURL("image/jpeg", 1);
        var doc = new jsPDF('L', 'px', [w, h]);
        doc.addImage(img, 'JPEG', 0, 0, w, h);
        doc.save('sample-file.pdf');
      }
    });
}
*/ 