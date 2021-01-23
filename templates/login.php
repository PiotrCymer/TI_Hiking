<form class="form-signin text-center" method="post" id="signInForm">
    <i class="fas fa-hiking" style="font-size: 80px;"></i>
    <h1 class="h3 mb-3 font-weight-normal">Zaloguj się</h1>
    <h5 class=" mb-3 font-weight-normal">Aby dodawać i przeglądać swoje wędrówki!</h5>
    <div class="alert alert-danger" role="alert" id="loginError"></div>
    <input type="email" id="inputEmail" class="form-control mb-3" placeholder="Adres e-mail" required="" autofocus="">
    <div class="alert alert-danger" role="alert" id="emailError"></div>
    <input type="password" id="inputPassword" class="form-control mb-3" placeholder="Hasło" required="">
    <div class="alert alert-danger" role="alert" id="passwordError"></div>

    <div id="spinner"></div>
    <button class="btn btn-lg btn-primary btn-block w-100" type="submit" id="signInBtn">Zaloguj się</button>
    <h6 class="mt-2 registerInfo">Jeżeli nie posiadasz konta <a href="/rejestracja">Kliknij tutaj</a> aby się zarejestrować!</h6>
</form>
