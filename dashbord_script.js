$(document).ready(function() {
    function fetchData(filter = 'today') {
        $.ajax({
            url: 'data.php',
            data: { filter },
            dataType: 'json',
            success: function(data) {
                renderCounterSales(data.counters_sales);
                renderPersonSales(data.person_sales);
                renderSalesGraph(data.sales_graph);
                renderOverallSales(data.overall_sales);
            }
        });
    }

    function renderCounterSales(counter) {
        $('#countersSales').empty();
        counter.forEach(counter => {
            $('#countersSales').append(`
                <div class="sales-item">
                    <h3>Counter ${counter.counter_number}</h3>
                    <p>$${parseFloat(counter.total_sales).toFixed(2)}</p>
                </div>
            `);
        });
    }

    function renderPersonSales(persons) {
        $('#personSales').empty();
        persons.forEach(person => {
            $('#personSales').append(`
                <div class="sales-item">
                    <h3>${person.name}</h3>
                    <p>$${parseFloat(person.total_sales).toFixed(2)}</p>
                </div>
            `);
        });
    }

    function renderSalesGraph(sales) {
        const ctx = document.getElementById('salesGraph').getContext('2d');
        const labels = sales.map(s => s.name);
        const data = sales.map(s => parseFloat(s.total_sales));

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Sales by Person',
                    data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    hoverBackgroundColor: 'rgba(54, 162, 235, 0.8)',
                    hoverBorderColor: 'rgba(54, 162, 235, 1)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) { return '$' + value; }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += '$' + context.raw.toFixed(2);
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }

    function renderOverallSales(sales) {
        const ctx = document.getElementById('overallSales').getContext('2d');
        const labels = sales.map(s => s.sale_date);
        const data = sales.map(s => parseFloat(s.total_sales));

        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Overall Sales',
                    data,
                    fill: false,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    tension: 0.1,
                    pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                    pointHoverBackgroundColor: 'rgba(75, 192, 192, 1)',
                    pointHoverRadius: 5
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) { return '$' + value; }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += '$' + context.raw.toFixed(2);
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }

    $('#filter').on('change', function() {
        fetchData(this.value);
    });

    fetchData();
});
