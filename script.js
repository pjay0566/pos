function setupAutocomplete(o) { //inputField, apiUrl) {
    // inputField.addEventListener('keyup', function() {
    let productName = o.value;
    apiUrl = 'get_product.php';
    // Fetch product suggestions
    fetch(`${apiUrl}?query=${productName}`)
        .then(response => response.json())
        .then(data => {
            let list = $(o).next('.product_autocomplete_list');
            let strLI = data.map(p => `<li onclick="setProduct(this)" data-product='${JSON.stringify(p)}'>${p.product_name}</li>`).join('');
            list.html(strLI);
            list.show();
        });
    // });
}

function setProduct(o) {
    let product = $(o).data('product');
    let tr = $(o).parents('tr');
    let product_name = tr.find('.product_name');
    product_name.val(product.product_name);
    product_name.data('iproduct_identity', product.iproduct_identity);
    tr.find('.price').val(product.price);
    // tr.find('.iproduct_identity').val(product.iproduct_identity);
    calculateProductTotal(o);
    // let qty = tr.find('.qty').val();
    // let totalprice = product.price * qty;
    // tr.find('.totalprice').val(totalprice);
    $(o).parent().hide();
}

function calculateProductTotal(o) {
    let tr = $(o).parents('tr');
    let qty = tr.find('.qty').val();
    let price = tr.find('.price').val();
    let totalprice = price * qty;
    tr.find('.totalprice').val(totalprice);
    calculateTotal();
}

function calculateTotal() {
    let invoiceTable = document.getElementById('invoice_table').getElementsByTagName('tbody')[0];
    let rows = invoiceTable.rows;
    let subtotal = 0;

    for (let i = 0; i < rows.length; i++) {
        let qty = parseInt(rows[i].querySelector('.qty').value) || 0;
        let price = parseFloat(rows[i].querySelector('.price').value) || 0;
        subtotal += qty * price;
    }

    let tax = subtotal * 0.18; // Assuming 18% GST
    let total = subtotal + tax;

    document.getElementById('subtotal').value = subtotal.toFixed(2);
    document.getElementById('tax').value = tax.toFixed(2);
    document.getElementById('total').value = total.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    let invoiceTable = document.getElementById('invoice_table').getElementsByTagName('tbody')[0];
    let addRowButton = document.getElementById('add_row');
    let saveButton = document.getElementById('save');
    let printButton = document.getElementById('print');

    function attachRowEvents(row) {
        let deleteButton = row.querySelector('.delete');
        // let productNameInput = row.querySelector('.product_name');
        let qtyInput = row.querySelector('.qty');
        // let productList = row.querySelector('datalist');

        deleteButton.addEventListener('click', function() {
            row.remove();
            updateRowNumbers();
            calculateTotal();
        });

        qtyInput.addEventListener('keyup', calculateTotal);
    }

    function AddRow() {
        let rowCount = invoiceTable.rows.length + 1;
        let newRow = invoiceTable.insertRow();

        // <datalist id="product_list_${rowCount}"></datalist>
        // <input type="hidden" class="iproduct_identity" />
        newRow.innerHTML = `
            <td style="text-align: center">
                ${rowCount} 
            </td>
            <td class="product_autocomplete">
                <input type="text" class="product_name" name="product_name[]"
                    onkeyup="setupAutocomplete(this)">
                <ul class="product_autocomplete_list"></ul>
            </td>
            <td><input type="number" class="qty" onkeyup="calculateProductTotal(this)" name="qty[]"
                    min="1" value="1"></td>
            <td><input type="number" class="price" onkeyup="calculateProductTotal(this)" name="price[]">
            </td>
            <td><input type="number" class="totalprice" name="totalprice[]" readonly></td>
            <td class="align-center">
                <button class="delete btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
            </td>  
        `;

        attachRowEvents(newRow);
    }

    addRowButton.addEventListener('click', AddRow);

    function updateRowNumbers() {
        let rows = invoiceTable.rows;
        for (let i = 0; i < rows.length; i++) {
            rows[i].cells[0].innerText = i + 1;
        }
    }

    saveButton.addEventListener('click', function() {
        let dt = new Date();
        let invoiceData = {
            //invoice_no: document.getElementById('invoice_no').value,
            subtotal: document.getElementById('subtotal').value,
            total: document.getElementById('total').value,
            tax: document.getElementById('tax').value,
            date: dt,
            // customer_name: document.getElementById('customer_name').value,
            counter_no: 1,
            payment_method: document.getElementById('payment_method').value,
            details: []
        };

        let rows = invoiceTable.rows;
        for (let i = 0; i < rows.length; i++) {
            let row = rows[i];
            let tr = $(rows[i]);
            // tr.find('.product_name').val();
            // tr.find('.price').val();
            // tr.find('.iproduct_identity').val();
            let detail = {
                sr_no: row.cells[0].innerText,
                iproduct_identity: tr.find('.product_name').data('iproduct_identity'),
                product_name: row.querySelector('.product_name').value,
                qty: row.querySelector('.qty').value,
                price: row.querySelector('.price').value
            };
            invoiceData.details.push(detail);
        }

        // console.log(invoiceData)

        fetch('save_invoice.php', {
            method: 'POST',
            headers: {  
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(invoiceData)
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        });
    });

    printButton.addEventListener('click', function() {
        window.print();
    });

    // Attach events to the initial row
    // attachRowEvents(invoiceTable.rows[0]);

    // (() => {
    //     [1,2,3,4].forEach(a => {
    //         AddRow();
    //     })
    // })();
});
