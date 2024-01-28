<div>
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
