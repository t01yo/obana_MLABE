<?php
include 'db_connect.php';

$sql = "SELECT customerID, customername, contactname, city, country FROM customers";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customers</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <!-- Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Include your CSS file here -->
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
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
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
<div class="container mt-5">
    <!-- Back Button -->
    <a href="index.php" class="btn btn-secondary mb-4 back-button">Back to Home</a>
    
    <h2 class="mb-4">Customer List</h2>
    <table id="customerTable" class="display table table-striped">
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
                    <button class="btn btn-primary btn-sm view-orders-btn" data-id="<?php echo $row['customerID']; ?>" data-name="<?php echo htmlspecialchars($row['customername']); ?>">View Orders</button>
                </td> 
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Order Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="customerName"></span>'s Orders</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="orderContent">
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
        <div id="noOrdersWarning" class="no-orders" style="display: none;">
          <div class="no-orders-icon">&#9888;</div> <!-- Warning icon -->
          <p>No orders found for this customer.</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap JS for modals -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
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
            success: function(response) {
                if (response.length > 0) {
                    var totalQuantity = 0;
                    var totalPrice = 0;
                    var tbody = $('#orderTable tbody');
                    tbody.empty(); // Clear previous data

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
                            <td>₱${price.toFixed(2)}</td>
                            <td>₱${total.toFixed(2)}</td>
                        </tr>`;
                        tbody.append(row);
                    });

                    // Update totals
                    $('#totalQuantity').text(totalQuantity);
                    $('#totalPrice').text(totalPrice.toFixed(2));

                    // Show the modal
                    $('#orderModal').modal('show');
                } else {
                    // No orders found; display an alert
                    alert('No orders found for ' + $('#customerName').text() + '.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching orders:', error);
                alert('An error occurred while fetching orders. Please try again.');
            }
        });
    }
});
</script>

</body>
</html>
