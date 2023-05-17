const { jsPDF } = window.jspdf;

document.getElementById('export_pdf_btn').addEventListener('click', function () {
    var rawTitle = document.getElementById('infoModalTitle').innerText + '\n';
    var rawBody = document.getElementById('infoModalBody').innerText;
    var pdf = new jsPDF();

    pdf.setFont("SourceSansPro-Regular", "normal");
    pdf.setFontSize(18);
    var title = pdf.splitTextToSize(rawTitle, 180);
    pdf.text(title, 10, 10);

    pdf.setFontSize(12);
    var body = pdf.splitTextToSize(rawBody, 190);
    pdf.text(body, 10, 20);

    pdf.save('web-info.pdf');
});
