<?php
include 'db_connect.php';

$sql = "SELECT c.* FROM customers c INNER JOIN orders o ON c.customerID = o.customerID INNER JOIN orderdetails od ON o.orderID = od.orderID INNER JOIN products p ON od.productID = p.productID GROUP BY c.customerID ORDER BY c.customerID, o.orderdate, o.orderID, od.orderdetailID;
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
       /* General Body Styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa;
    color: #333;
}

/* Container and Heading */
.container {
    background-color: #ffffff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    max-width: 900px; /* Reduced width for smaller container */
    margin: 0 auto; /* Center align */
}

h2 {
    font-size: 24px;
    font-weight: bold;
    color: #800000; /* Maroon */
    margin-bottom: 20px;
}

/* Back Button Styling */
.back-button {
    font-size: 14px;
    background-color: #8c3419;
    color: #ffffff;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.3s;
    float: right; /* Align button to the right */
    margin-bottom: 15px; /* Space below the button */
}

.back-button:hover {
    background-color: #612a19;
}

/* Table Styling */
.table-striped {
    width: 100%;
    border-collapse: collapse;
}

.table-striped thead th {
    background-color: #800000; /* Maroon */
    color: #ffffff;
    padding: 10px;
    text-align: left;
    font-size: 14px;
}

.table-striped tbody td {
    padding: 8px;
    border-bottom: 1px solid #ddd;
}

.table-striped tbody tr:hover {
    background-color: #f2f2f2;
}

/* Button Styling */
.btn-primary, .btn-warning, .btn-danger {
    border-radius: 4px;
    font-size: 12px;
}

.btn-primary {
    background-color: #800000; /* Maroon */
    border-color: #800000;
}

.btn-primary:hover {
    background-color: #a83232;
    border-color: #a83232;
}

/* Modal Styling */
.modal-content {
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    border: none;
}

.modal-header {
    background-color: #800000; /* Maroon */
    color: white;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    padding: 15px;
}

.modal-title {
    font-size: 18px;
    font-weight: bold;
}

.close {
    color: white;
    font-size: 24px;
    opacity: 0.8;
}

.close:hover {
    opacity: 1;
}

.modal-body {
    padding: 20px;
    background-color: #f5f5f5; /* Light beige */
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}

#orderTable thead th {
    background-color: #800000; /* Maroon */
    color: white;
    padding: 8px;
    text-align: left;
    font-size: 14px;
}

#orderTable tbody td {
    padding: 8px;
    border: 1px solid #ddd;
    font-size: 13px;
}

.modal-footer {
    background-color: #f5f5f5; /* Light beige */
    border-top: none;
    padding: 15px;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}

.btn-secondary {
    background-color: #8c3419;
    border: none;
    color: white;
    transition: background-color 0.3s;
}

.btn-secondary:hover {
    background-color: #a83232;
}

/* No Orders Warning */
.no-orders {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    border-radius: 8px;
    margin-top: 20px;
    color: #721c24;
}

.no-orders-icon {
    font-size: 36px;
    margin-bottom: 10px;
}

/* Modal Footer Button */
.modal-footer button {
    border-radius: 4px;
}

/* Form Control */
.form-control {
    border-radius: 4px;
    padding: 10px;
    font-size: 14px;
}
    </style>
</head>

<body>

    
<div class="container py-2">
<div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Customer List</h2>
        <a href="index.php" class="btn btn-secondary back-button">Back to Home</a>
    </div>    <table id="customerTable" class="table table-striped">
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>Customer Name</th>
                <th>Contact Name</th>
                <th>City</th>
                <th>Country</th>
                <th>Actions</th> 
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['customerID']; ?></td>
                <td><?php echo $row['customername']; ?></td>
                <td><?php echo $row['contactname']; ?></td>
                <td><?php echo $row['city']; ?></td>
                <td><?php echo $row['country']; ?></td>
                <td>
                    <button class="btn btn-outlinr-primary btn-sm view-orders-btn" data-id="<?php echo $row['customerID']; ?>" data-name="<?php echo htmlspecialchars($row['customername']); ?>">
                        <i class="fas fa-shopping-cart"></i> 
                    </button>
                </td> 
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Order Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderModalLabel"><span id="customerName"></span>'s Orders</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Orders Table -->
        <table id="orderTable" class="table table-bordered">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Order Date</th>
              <th>Product Name</th>
              <th>Quantity</th>
              <th>Unit Price</th>
              <th>Total Price</th>
            </tr>
          </thead>
          <tbody>
            <!-- Dynamic Content -->
          </tbody>
        </table>
        <!-- Totals -->
        <div class="mt-3">
          <p><strong>Total Quantity:</strong> <span id="totalQuantity">0</span></p>
          <p><strong>Total Price:</strong> ₱<span id="totalPrice">0.00</span></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery and DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    var table = $('#customerTable').DataTable();

    // Handle "View Orders" button click
    $('#customerTable tbody').on('click', '.view-orders-btn', function() {
        var customerId = $(this).data('id');
        var customerName = $(this).data('name');
        $('#customerName').text(customerName);

        // Fetch and display orders in the modal
        fetchCustomerOrders(customerId);
    });

    // Function to fetch customer orders
    function fetchCustomerOrders(customerId) {
        $.ajax({
            url: 'fetch_orders.php',
            type: 'POST',
            data: { customerID: customerId },
            dataType: 'json',
            beforeSend: function() {
                // Optional: Show a loading spinner or disable the button
                $('#orderTable tbody').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');
                $('#totalQuantity').text('0');
                $('#totalPrice').text('0.00');
            },
            success: function(response) {
                var totalQuantity = 0;
                var totalPrice = 0;
                var tbody = $('#orderTable tbody');
                tbody.empty(); // Clear previous data

                if(response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error,
                    });
                    return;
                }

                if(response.message) {
                    tbody.append('<tr><td colspan="6" class="text-center">' + response.message + '</td></tr>');
                } else if(Array.isArray(response) && response.length > 0) {
                    response.forEach(function(order) {
                        var quantity = parseInt(order.quantity);
                        var price = parseFloat(order.price);
                        var total = quantity * price;

                        totalQuantity += quantity;
                        totalPrice += total;

                        var row = `<tr>
                            <td>${order.orderID}</td>
                            <td>${order.orderdate}</td>
                            <td>${order.productname}</td>
                            <td>${quantity}</td>
                            <td>Php${price.toFixed(2)}</td>
                            <td>Php ${total.toFixed(2)}</td>
                        </tr>`;
                        tbody.append(row);
                    });

                    // Update totals
                    $('#totalQuantity').text(totalQuantity);
                    $('#totalPrice').text(totalPrice.toFixed(2));
                } else {
                    tbody.append('<tr><td colspan="6" class="text-center">No orders found for this customer.</td></tr>');
                }

                // Update totals
                $('#totalQuantity').text(totalQuantity);
                $('#totalPrice').text(totalPrice.toFixed(2));

                // Show the modal
                $('#orderModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching orders:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred while fetching orders. Please try again.',
                });
                // Optionally, clear the loading message
                $('#orderTable tbody').empty();
            },
            complete: function() {
                // Optional: Hide loading spinner or enable the button
            }
        });
    }
});
</script>

</body>
</html>
