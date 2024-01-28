<div>
    <!-- Display message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div id="message" class="alert <?php echo strpos($_SESSION['message'], 'error') !== false ? 'alert-danger' : 'alert-success' ?> text-center">
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
                ?>
                </div>
    <?php endif; ?>
    
    <h4>Login</h4>
    <!-- Login form -->
    <form method="POST" action="/users/authenticate">
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
    <div>
        <a href="/users/register">Not a member? Create Account</a>
    </div>
</div>
