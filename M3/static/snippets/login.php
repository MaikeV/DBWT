<fieldset class="border border-primary p-5">
    <legend class="text-warning text-center w-auto"> Login </legend>
    <p id="loginMessage" class="text-warning hide">

    </p>
    <?php
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
            echo '<p>Hallo '.$_SESSION['username'].' Sie sind angemeldet als</p>';
        }
    ?>
    <form target="_self" action="auth.php" method="post">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Benutzer" required>
        </div>
        <div class="form-group mt-3">
            <input type="password" class="form-control" placeholder="******" required>
        </div>
        <button type="submit" class="btn btn-link">Anmelden</button>
    </form>
</fieldset>