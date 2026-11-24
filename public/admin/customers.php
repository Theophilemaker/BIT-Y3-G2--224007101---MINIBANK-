<?php require_once '../../app/Views/layouts/admin_header.php'; 

$db = Database::getInstance();
$customers = $db->query("
    SELECT u.id, u.email, u.status, c.first_name, c.last_name, c.customer_number, c.phone, c.address 
    FROM users u 
    JOIN customers c ON u.id = c.user_id 
    WHERE u.role = 'customer'
    ORDER BY u.created_at DESC
")->fetchAll();
?>

<!-- Custom Modal Styles -->
<style>
    .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
    .modal-content { background: white; padding: 30px; border-radius: 10px; width: 90%; max-width: 500px; position: relative; }
    .close-btn { position: absolute; top: 15px; right: 20px; font-size: 1.5rem; cursor: pointer; color: #666; }
</style>

<div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
    
    <!-- Header & Add Button -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="color: var(--primary-navy); margin: 0;">Manage Customers</h3>
        <button onclick="document.getElementById('addModal').style.display='flex'" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Customer
        </button>
    </div>
    
    <!-- Table -->
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 2px solid #eee; background: #f9f9f9;">
                <th style="padding: 12px; color: #555;">Customer #</th>
                <th style="padding: 12px; color: #555;">Name</th>
                <th style="padding: 12px; color: #555;">Email</th>
                <th style="padding: 12px; color: #555;">Phone</th>
                <th style="padding: 12px; color: #555;">Status</th>
                <th style="padding: 12px; color: #555; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($customers)): ?>
                <tr><td colspan="6" style="text-align: center; padding: 20px; color: #888;">No customers found.</td></tr>
            <?php else: ?>
                <?php foreach($customers as $c): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px; font-weight: 600; color: var(--primary-blue);"><?= htmlspecialchars($c['customer_number']) ?></td>
                    <td style="padding: 12px;"><?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?></td>
                    <td style="padding: 12px;"><?= htmlspecialchars($c['email']) ?></td>
                    <td style="padding: 12px;"><?= htmlspecialchars($c['phone'] ?? 'N/A') ?></td>
                    <td style="padding: 12px;">
                        <span style="background: <?= $c['status'] == 'active' ? '#d4edda' : '#f8d7da' ?>; color: <?= $c['status'] == 'active' ? '#155724' : '#721c24' ?>; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                            <?= ucfirst($c['status']) ?>
                        </span>
                    </td>
                    <td style="padding: 12px; text-align: right;">
                        <!-- Edit Button passes data to the modal -->
                        <button onclick='openEditModal(<?= json_encode($c) ?>)' style="background: none; border: none; color: #ffc107; cursor: pointer; margin-right: 10px;" title="Edit">
                            <i class="fas fa-edit fa-lg"></i>
                        </button>
                        
                        <!-- Delete Button passes data to the modal -->
                        <button onclick='openDeleteModal(<?= $c['id'] ?>, "<?= htmlspecialchars($c['first_name']) ?>")' style="background: none; border: none; color: #dc3545; cursor: pointer;" title="Delete">
                            <i class="fas fa-trash fa-lg"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add Customer Modal -->
<div id="addModal" class="modal-overlay">
    <div class="modal-content">
        <span class="close-btn" onclick="document.getElementById('addModal').style.display='none'">&times;</span>
        <h3 style="color: var(--primary-navy); margin-top: 0;">Add New Customer</h3>
        <form action="../../routes/web.php?action=add_customer" method="POST">
            <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <input type="text" name="first_name" placeholder="First Name" class="form-control" required>
                <input type="text" name="last_name" placeholder="Last Name" class="form-control" required>
            </div>
            <input type="email" name="email" placeholder="Email Address" class="form-control" style="width:100%; margin-bottom: 15px;" required>
            <input type="text" name="phone" placeholder="Phone Number" class="form-control" style="width:100%; margin-bottom: 15px;">
            <input type="text" name="address" placeholder="Address" class="form-control" style="width:100%; margin-bottom: 15px;">
            <input type="password" name="password" placeholder="Temporary Password" class="form-control" style="width:100%; margin-bottom: 20px;" required>
            <button type="submit" class="btn btn-primary w-100">Create Customer</button>
        </form>
    </div>
</div>

<!-- Edit Customer Modal -->
<div id="editModal" class="modal-overlay">
    <div class="modal-content">
        <span class="close-btn" onclick="document.getElementById('editModal').style.display='none'">&times;</span>
        <h3 style="color: var(--primary-navy); margin-top: 0;">Edit Customer</h3>
        <form action="../../routes/web.php?action=edit_customer" method="POST">
            <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
            <input type="hidden" name="user_id" id="edit_user_id">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <input type="text" name="first_name" id="edit_first_name" placeholder="First Name" class="form-control" required>
                <input type="text" name="last_name" id="edit_last_name" placeholder="Last Name" class="form-control" required>
            </div>
            <input type="text" name="phone" id="edit_phone" placeholder="Phone Number" class="form-control" style="width:100%; margin-bottom: 15px;">
            <input type="text" name="address" id="edit_address" placeholder="Address" class="form-control" style="width:100%; margin-bottom: 15px;">
            
            <select name="status" id="edit_status" class="form-control" style="width:100%; margin-bottom: 20px;">
                <option value="active">Active</option>
                <option value="suspended">Suspended</option>
            </select>
            
            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
        </form>
    </div>
</div>

<!-- Delete Customer Modal -->
<div id="deleteModal" class="modal-overlay">
    <div class="modal-content" style="text-align: center;">
        <i class="fas fa-exclamation-triangle fa-3x" style="color: #dc3545; margin-bottom: 15px;"></i>
        <h3 style="color: var(--primary-navy); margin-top: 0;">Delete Customer?</h3>
        <p style="color: #666; margin-bottom: 20px;">Are you sure you want to delete <strong id="delete_name"></strong>? This will remove all their accounts and data permanently.</p>
        
        <form action="../../routes/web.php?action=delete_customer" method="POST">
            <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
            <input type="hidden" name="user_id" id="delete_user_id">
            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="document.getElementById('deleteModal').style.display='none'" class="btn" style="flex: 1; background: #eee; color: #333;">Cancel</button>
                <button type="submit" class="btn" style="flex: 1; background: #dc3545; color: white;">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(data) {
        document.getElementById('edit_user_id').value = data.id;
        document.getElementById('edit_first_name').value = data.first_name;
        document.getElementById('edit_last_name').value = data.last_name;
        document.getElementById('edit_phone').value = data.phone;
        document.getElementById('edit_address').value = data.address;
        document.getElementById('edit_status').value = data.status;
        document.getElementById('editModal').style.display = 'flex';
    }

    function openDeleteModal(id, name) {
        document.getElementById('delete_user_id').value = id;
        document.getElementById('delete_name').innerText = name;
        document.getElementById('deleteModal').style.display = 'flex';
    }
</script>

<?php require_once '../../app/Views/layouts/footer.php'; ?>