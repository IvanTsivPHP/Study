<main class="form-signin">
    <form action="/login" method="post">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        <h1 class="h3 mb-3 fw-normal"><?=$this->props['error']?></h1>
        <label for="inputEmail" class="visually-hidden">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus
               value="<?=isset($this->props['post'])?$this->props['post']['email']:''?>">
        <label for="inputPassword" class="visually-hidden">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        <a href="/signup">Sign Up</a>
    </form>
</main>