let tmr;
function setupAutocomplete(o) {
    let productName = o.value.trim();
    if (productName !== '') {
        clearTimeout(tmr);
        tmr = setTimeout(() => {
            clearTimeout(tmr);

            apiUrl = 'get_product.php';
            fetch(`${apiUrl}?query=${productName}`)
                .then(response => response.json())
                .then(data => {
                    let list = $(o).next('.product_autocomplete_list');
                    let strLI = data.map(p => `<li onclick="setProduct(this)" data-product='${JSON.stringify(p)}'>${p.product_name}</li>`).join('');
                    list.html(strLI);
                    list.show();
                });
        }, 500);
    }
}

function setProductOnBlur(o) {
    let productName = o.value.trim();
    if (productName !== '') {
        apiUrl = 'get_product_exact.php';
        fetch(`${apiUrl}?query=${productName}`)
            .then(response => response.json())
            .then(data => {
                if (data && data[0]) {
                    data = data[0];
                    let tr = $(o).parents('tr');
                    $(o).data('iproduct_identity', data.iproduct_identity);
                    tr.find('.price').val(data.price);
                    calculateProductTotal(o);
                    setTimeout(() => {
                        let list = $(o).next('.product_autocomplete_list');
                        list.hide();
                    }, 700);
                }
            });
    }
}

function setProduct(o) {
    let product = $(o).data('product');
    let tr = $(o).parents('tr');
    let product_name = tr.find('.product_name');
    product_name.val(product.product_name);
    product_name.data('iproduct_identity', product.iproduct_identity);
    tr.find('.price').val(product.price);
    calculateProductTotal(o);
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

function generateBarcodes(o, productName) {
    let noOfLabels = $(o).prev('input').val();
    let content = '<div class="flex flex-left">';
    for (let i = 0; i < noOfLabels; i++) {
        content += `<div class="margin-20 bar-code">${productName}</div>`;
    };

    let child = window.open('', '_blank', 'popup');
    child.document.write(`<link rel="stylesheet" href="style_list.css">
    ${content}
    <script>window.print();</script>`);
}

function openInvoice(i) {
    window.open(`invoice_main.php?iinvoice_no=${i}`,'Open Invoice');
}

document.addEventListener('DOMContentLoaded', function () {
    let saveButton = document.getElementById('save');
    let printButton = document.getElementById('print');
    let saveNPrintButton = document.getElementById('savenprint');
    let backButton = document.getElementById('back');
    let holdButton = document.getElementById('hold');

    if (document.getElementById('invoice_table')) {

        let invoiceTable = document.getElementById('invoice_table').getElementsByTagName('tbody')[0];
        let addRowButton = document.getElementById('add_row');


        function attachRowEvents(row) {
            let deleteButton = row.querySelector('.delete');
            // let productNameInput = row.querySelector('.product_name');s
            let qtyInput = row.querySelector('.qty');
            // let productList = row.querySelector('datalist');

            deleteButton.addEventListener('click', function () {
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
                <input type="text" class="product_name" name="product_name[]" autocomplete="off"
                    onkeyup="setupAutocomplete(this)" onblur="setProductOnBlur(this)">
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
    }
    function updateRowNumbers() {
        let rows = invoiceTable.rows;
        for (let i = 0; i < rows.length; i++) {
            rows[i].cells[0].innerText = i + 1;
        }
    }

    async function SaveInvoice() {
        let dt = new Date();
        let invoiceData = {
            ret: document.getElementById('stand').value,
            subtotal: document.getElementById('subtotal').value,
            total: document.getElementById('total').value,
            tax: document.getElementById('tax').value,
            date: dt,
            counter_no: 1,
            payment_method: document.getElementById('payment_method').value,
            details: []
        };

        let rows = invoiceTable.rows;
        for (let i = 0; i < rows.length; i++) {
            let row = rows[i];
            let tr = $(rows[i]);
            let detail = {
                sr_no: row.cells[0].innerText,
                iproduct_identity: tr.find('.product_name').data('iproduct_identity'),
                product_name: row.querySelector('.product_name').value,
                qty: row.querySelector('.qty').value,
                price: row.querySelector('.price').value,
                totalprice: row.querySelector('.totalprice').value

            };
            invoiceData.details.push(detail);
        }

        let response = await fetch('save_invoice.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(invoiceData)
        });

        let iinvoice_no = await response.json();
        alert('Invoice saved successfully');
        return iinvoice_no;
    }

    function PrintInvoice(iinvoice_no) {
        let q = window.location.search.replace('?iinvoice_no=', '');
        let i = iinvoice_no || q;
        window.open(`print.php?invoice_id=${i}`, 'targetWindow', `toolbar=no,
        location=no,
        status=no,
        menubar=no,
        scrollbars=yes,
        resizable=yes,
        width=320,
        height=320`);
    }

    async function HoldInvoice() {
        let dt = new Date();
        let invoiceData = {
            subtotal: document.getElementById('subtotal').value,
            total: document.getElementById('total').value,
            tax: document.getElementById('tax').value,
            date: dt,
            counter_no: 1,
            payment_method: document.getElementById('payment_method').value,
            details: []
        };

        let rows = invoiceTable.rows;
        for (let i = 0; i < rows.length; i++) {
            let row = rows[i];
            let tr = $(rows[i]);
            let detail = {
                sr_no: row.cells[0].innerText,
                iproduct_identity: tr.find('.product_name').data('iproduct_identity'),
                product_name: row.querySelector('.product_name').value,
                qty: row.querySelector('.qty').value,
                price: row.querySelector('.price').value,
                totalprice: row.querySelector('.totalprice').value
            };

            invoiceData.details.push(detail);
        }

        let response = await fetch('save_back.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(invoiceData)
        });

        let iinvoice_no = await response.json();
        alert('Invoice saved successfully');
        return iinvoice_no;
    }

    if (saveButton) {
        saveButton.addEventListener('click', async function () {
            let i = await SaveInvoice();
            window.location = `/pos project/invoice_main.php?iinvoice_no=${i}`;
        });

        holdButton.addEventListener('click', async function () {
            await HoldInvoice();
            window.location = `/pos project/invoice_main.php`;
        });

        printButton.addEventListener('click', function () {
            PrintInvoice();
        });

        saveNPrintButton.addEventListener('click', async function () {
            let i = await SaveInvoice();
            PrintInvoice(i);
            window.location = `/pos project/invoice_main.php?iinvoice_no=${i}`;
        });

        backButton.addEventListener('click', function () {
            window.location = `/pos project/invoice_list.php`;
        });
    }
});
