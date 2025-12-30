import { PDFDocument } from 'https://cdn.skypack.dev/pdf-lib';
import { registerFont } from 'https://cdn.skypack.dev/chart.js';
import { ChartJSNodeCanvas } from 'https://cdn.skypack.dev/chartjs-node-canvas';
const { CanvasRenderService } = ChartJSNodeCanvas;

import { saveAs } from 'https://cdn.skypack.dev/file-saver';

// Example data
const data = {
  label: 'My Pie Chart',
  values: [25, 30, 45],
  labels: ['Label 1', 'Label 2', 'Label 3'],
};

// Function to generate PDF with a pie chart
export async function generatePDF(data) {
  // Create a new PDF document
  const pdfDoc = await PDFDocument.create();
  const page = pdfDoc.addPage();

  // Initialize chart.js
  const canvasRenderService = new CanvasRenderService(600, 400);
  registerFont('defaultFont', { family: 'Arial', src: 'path/to/arial.ttf' }); // Provide the path to your font file

  // Create a canvas and render the pie chart
  const imageBuffer = await canvasRenderService.renderToBuffer({
    type: 'image/png',
    data: {
      type: 'pie',
      data: {
        labels: data.labels,
        datasets: [
          {
            data: data.values,
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'], // Customize the colors
          },
        ],
      },
    },
    options: {
      title: {
        display: true,
        text: data.label,
        fontColor: 'black',
        fontSize: 16,
      },
    },
  });

  // Add the rendered chart as an image to the PDF
  const image = await pdfDoc.embedPng(imageBuffer);
  const { width, height } = image.scale(0.5); // Adjust the scale factor as needed
  page.drawImage(image, {
    x: 50,
    y: 250 - height,
    width,
    height,
  });

  // Save the PDF to a file
  const pdfBytes = await pdfDoc.save();
  const blob = new Blob([pdfBytes], { type: 'application/pdf' });
  saveAs(blob, 'output.pdf');
}

// Generate the PDF with the provided data
