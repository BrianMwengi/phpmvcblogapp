<div>
    <h4>Register</h4>
    <!-- Registration form -->
    <form method="POST" action="/users/store">
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <button type="submit">Register</button>
        </div>
    </form>
    <div>
        <a href="/users/login">Already have an account? Login</a>
    </div>
</div>
