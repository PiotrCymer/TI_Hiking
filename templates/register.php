<form class="form-signin text-center" method="post" id="signInForm">
    <i class="fas fa-hiking" style="font-size: 80px;"></i>
    <h1 class="h3 mb-3 font-weight-normal">Rejestracja</h1>
    <h5 class=" mb-3 font-weight-normal">Dołącz do nas!</h5>
    <div class="alert alert-danger" role="alert" id="registerError"></div>
    <div class="alert alert-success" role="alert" id="registerSuccess"></div>

    <input type="email" id="inputEmail" class="form-control mb-3" placeholder="Adres email" required="" autofocus="">
    <div class="alert alert-danger" role="alert" id="newEmailError"></div>

    <input type="text" id="inputNewName" class="form-control mb-3" placeholder="Imię" required="" autofocus="">
    <div class="alert alert-danger" role="alert" id="newNameError"></div>

    <input type="text" id="inputNewSurname" class="form-control mb-3" placeholder="Nazwisko" required="" autofocus="">
    <div class="alert alert-danger" role="alert" id="newSurnameError"></div>

    <input type="password" id="inputNewPassword" class="form-control mb-3" placeholder="Hasło" required="">
    <div class="alert alert-danger" role="alert" id="newPasswordError"></div>

    <input type="password" id="inputNewPasswordRepeat" class="form-control mb-3" placeholder="Powtórz hasło" required="">
    <div class="alert alert-danger" role="alert" id="newPasswordRepeatError"></div>


    <div id="spinner"></div>
    <button class="btn btn-lg btn-primary btn-block w-100 registerBtn" type="submit" id="signInBtn">Zarejestruj się</button>
</form>
