/**
 * Created by alon on 16/04/17.
 */
//
// Disable workers to avoid yet another cross-origin issue (workers need the URL of
// the script to be loaded, and dynamically loading a cross-origin script does
// not work)
//
PDFJS.disableWorker = true;

//
// Asynchronous download PDF as an ArrayBuffer
//
var pdf = document.getElementById('pdf');
pdf.onchange = function(ev) {
        if (file = document.getElementById('pdf').files[0]) {
            fileReader = new FileReader();
            fileReader.onload = function(ev) {
                console.log(ev);
                PDFJS.getDocument(fileReader.result).then(function getPdfHelloWorld(pdf) {
                    //
                    // Fetch the first page
                    //
                    console.log(pdf)
                    pdf.getPage(1).then(function getPageHelloWorld(page) {
                        var scale = 1.5;
                        var viewport = page.getViewport(scale);

                        //
                        // Prepare canvas using PDF page dimensions
                        //
                        var canvas = document.getElementById('the-canvas');
                        var context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        //
                        // Render PDF page into canvas context
                        //
                        var task = page.render({canvasContext: context, viewport: viewport})
                        task.promise.then(function(){
                            console.log(canvas.toDataURL('image/jpeg'));
                        });
                    });
                }, function(error){
                    console.log(error);
                });
            };
            fileReader.readAsArrayBuffer(file);
        }
    }



