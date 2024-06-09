<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice Page Design</title>
  <style>
    body {
      font-family: "Hanken Grotesk", sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }
    .container {
      width: 90%;
      margin: auto;
      overflow: hidden;
      padding: 20px;
      background: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      margin-top: 50px;
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 20px;
    }
    .header .title {
      flex: 1;
    }
    .header .actions {
      display: flex;
      gap: 10px;
    }
    .header .actions button {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .save-btn {
      background-color: #28a745;
      color: white;
    }
    .print-btn {
      background-color: #17a2b8;
      color: white;
    }
    .header .fields {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 20px;
      width: 100%;
    }
    .header .field-group {
      display: flex;
      align-items: center;
      gap: 10px;
      flex: 1;
    }
    .header input, .header select {
      padding: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
      flex: 1;
    }
    .invoice-details {
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 10px;
      text-align: left;
    }
    .actions button {
      background-color: #6121ad;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      cursor: pointer;
      margin-right: 5px;
    }
    .actions button:hover {
      background-color: #0056b3;
    }
    .add-product-btn {
      background-color: #6c757d;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 5px;
      cursor: pointer;
    }
    .add-product-btn:hover {
      background-color: #5a6268;
    }
    .summary {
      text-align: right;
      margin-top: 20px;
    }
    .summary div {
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="title">
        <h2>Invoice</h2>
      </div>
      <div class="actions">
        <button class="save-btn">Save</button>
        <button class="print-btn">Print</button>
      </div>
      <div class="fields">
        <div class="field-group">
          <label for="invoice-no">Invoice No:</label>
          <select id="invoice-no">
            <option value="INV-001">INV-001</option>
            <option value="INV-002">INV-002</option>
          </select>
        </div>
        <div class="field-group">
          <label for="date">Date:</label>
          <input type="date" id="date">
        </div>
        <div class="field-group">
          <label for="customer-name">Customer Name:</label>
          <input type="text" id="customer-name">
        </div>
        <div class="field-group">
          <label for="counter-no">Counter No:</label>
          <select id="counter-no">
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </div>
      </div>
    </div>
    
    <div class="invoice-details">
      <table>
        <thead>
          <tr>
            <th>Sr. No.</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td contenteditable="true">Product 1</td>
            <td contenteditable="true">10</td>
            <td contenteditable="true">$100</td>
            <td class="actions">
              <button>Edit</button>
              <button>Delete</button>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td contenteditable="true">Product 2</td>
            <td contenteditable="true">5</td>
            <td contenteditable="true">$50</td>
            <td class="actions">
              <button>Edit</button>
              <button>Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
      <button class="add-product-btn">Add Product</button>
    </div>
    
    <div class="summary">
      <div>
        <label for="subtotal">Subtotal:</label>
        <span id="subtotal">$150</span>
      </div>
      <div>
        <label for="gst">GST (Tax):</label>
        <span id="gst">$15</span>
      </div>
      <div>
        <label for="total">Total:</label>
        <span id="total">$165</span>
      </div>
    </div>
  </div>
</body>
</html>
