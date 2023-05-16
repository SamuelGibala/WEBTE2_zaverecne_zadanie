const { jsPDF } = window.jspdf;

document.getElementById('export_pdf_btn').addEventListener('click', function () {
    var resultText = document.getElementById('infoModalTitle').innerText + '\n';
    resultText += document.getElementById('infoModalBody').innerText;
    var pdf = new jsPDF();

    resultText = pdf.splitTextToSize(resultText, 180);
    pdf.text(resultText, 10, 10);
    pdf.save('web-info.pdf');
});
