<form class="form-signin text-center" method="post" id="signInForm">
    <i class="fas fa-hiking" style="font-size: 80px;"></i>
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <h5 class=" mb-3 font-weight-normal">To explore and manage your trips!</h5>
    <div class="alert alert-danger" role="alert" id="loginError"></div>
    <input type="email" id="inputEmail" class="form-control mb-3" placeholder="Email address" required="" autofocus="">
    <div class="alert alert-danger" role="alert" id="emailError"></div>
    <input type="password" id="inputPassword" class="form-control mb-3" placeholder="Password" required="">
    <div class="alert alert-danger" role="alert" id="passwordError"></div>

    <div id="spinner"></div>
    <button class="btn btn-lg btn-primary btn-block w-100" type="submit" id="signInBtn">Sign in</button>
</form>
