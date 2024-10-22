<?php
include 'db_connect.php';

$sql = "SELECT productID, productname, unit, price FROM products";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <!-- Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
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

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #333;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #c82333;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background-color: #800000; /* Maroon */
            color: white;
            border-bottom: none;
            padding: 15px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .modal-title {
            font-size: 18px;
        }

        .close {
            color: #fff;
            opacity: 0.8;
        }

        .close:hover {
            color: #f8f9fa;
            opacity: 1;
        }

        .modal-footer button {
            border-radius: 4px;
        }

        .form-control {
            border-radius: 4px;
            padding: 10px;
            font-size: 14px;
        }

        /* Add Product Button */
        button[data-target="#addProductModal"] {
            background-color: #800000;
            border-color: #800000;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        button[data-target="#addProductModal"]:hover {
            background-color: #a83232;
            border-color: #a83232;
        }

    </style>
</head>
<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Product List</h2>
        <a href="index.php" class="btn btn-secondary back-button">Back to Home</a>
    </div>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addProductModal">Add New Product</button>
    <table id="productTable" class="table table-striped">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Unit</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['productID']; ?></td>
                <td><?php echo $row['productname']; ?></td>
                <td><?php echo $row['unit']; ?></td>
                <td>₱<?php echo number_format($row['price'], 2); ?></td>
                <td>
                  <div class="btn-group">
                  <button class="btn btn-warning btn-sm editBtn" data-id="<?php echo $row['productID']; ?>">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-sm deleteBtn" data-id="<?php echo $row['productID']; ?>">
                        <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</div>
<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="addProductForm" action="add_product.php" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5>Add New Product</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <!-- Form Fields -->
          <div class="form-group">
            <label>Product Name</label>
            <input type="text" class="form-control" name="productname" required>
          </div>
          <div class="form-group">
            <label>Unit</label>
            <input type="text" class="form-control" name="unit" required>
          </div>
          <div class="form-group">
            <label>Price</label>
            <input type="number" class="form-control" name="price" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Product</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editProductForm" action="edit_product.php" method="post">
      <input type="hidden" name="productID" id="editProductID">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editProductName" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="editProductName" name="productname" required>
          </div>
          <div class="mb-3">
            <label for="editUnit" class="form-label">Unit</label>
            <input type="text" class="form-control" id="editUnit" name="unit" required>
          </div>
          <div class="mb-3">
            <label for="editPrice" class="form-label">Price</label>
            <input type="number" class="form-control" id="editPrice" name="price" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update Product</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- jQuery, Popper.js, Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap JS for modals -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function() {
    $('#productTable').DataTable();

    // Function to refresh product table dynamically
    function refreshProductTable() {
        $.ajax({
            url: 'fetch_products.php', // This should point to a PHP script that returns the updated product table rows
            type: 'GET',
            success: function(data) {
                $('#productTable').DataTable().clear().destroy(); // Destroy previous DataTable instance
                $('tbody').html(data); // Replace tbody with new data
                $('#productTable').DataTable(); // Reinitialize DataTable
            }
        });
    }

    // Edit button functionality
    $(document).on('click', '.editBtn', function() {
        var productID = $(this).data('id');
        // Fetch product data using AJAX
        $.ajax({
            url: 'get_product.php',
            type: 'POST',
            data: { productID: productID },
            dataType: 'json',
            success: function(response) {
                $('#editProductID').val(response.productID);
                $('#editProductName').val(response.productname);
                $('#editUnit').val(response.unit);
                $('#editPrice').val(response.price);
                $('#editProductModal').modal('show');
            }
        });
    });

    // Delete button functionality
    $(document).on('click', '.deleteBtn', function() {
        var productID = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete_product.php',
                    type: 'POST',
                    data: { productID: productID },
                    success: function(response) {
                        Swal.fire('Deleted!', 'Your product has been deleted.', 'success');
                        refreshProductTable(); // Refresh table without reloading
                    }
                });
            }
        });
    });

    // Add Product Confirmation
    $('#addProductForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Product Added',
                    text: 'The product has been added successfully!'
                }).then(() => {
                    $('#addProductModal').modal('hide'); // Hide modal
                    refreshProductTable(); // Refresh table without reloading
                });
            }
        });
    });

    // Edit Product Confirmation
    $('#editProductForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Product Updated',
                    text: 'The product has been updated successfully!'
                }).then(() => {
                    $('#editProductModal').modal('hide'); // Hide modal
                    refreshProductTable(); // Refresh table without reloading
                });
            }
        });
    });
});

</script>



</body>
</html>
