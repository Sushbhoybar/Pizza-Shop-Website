<?php
session_start();
$user_name = $_SESSION['full_name'] ?? 'Guest';
$user_role = $_SESSION['role'] ?? '';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand" href="<?php echo ($user_role == 'admin') ? 'admin_index.html' : 'index.html'; ?>">🍕 Pizza Shop</a>
        
        <div class="d-flex">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="profile.html" class="btn btn-light me-2"><?php echo $user_name; ?></a>
                <button class="btn btn-warning" onclick="logout()">Logout</button>
            <?php else: ?>
                <a href="login.html" class="btn btn-light">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
function logout() {
    fetch("php/logout.php").then(() => {
        window.location.href = "login.html";
    });
}
</script>
