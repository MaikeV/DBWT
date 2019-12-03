<fieldset class="border border-primary p-5">
    <legend class="text-warning text-center w-auto"> Login </legend>
    <form target="_self" method="post">
        <?php
            if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true && isset($_SESSION['visited']) && $_SESSION['visited'] == true) {
                echo '<p class="text-warning">Hallo '.$_SESSION['username'].' Sie sind angemeldet als '.$_SESSION['role'].'</p>
                        <div class="form-group mt-3">
                        <input type="hidden" class="form-control" name="function" value="logout">
                      </div>
                      <button class="btn btn-primary" type="submit" name="logout" value="true">Logout</button>';
            } else if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == false && isset($_SESSION['visited']) && $_SESSION['visited'] == true){
                echo '<p class="text-danger">Das hat leider nicht geklappt, bitte versuchen Sie es nochmal.</p>
                        <div class="form-group">
                            <input type="text" class="form-control border border-danger" placeholder="Benutzer" name="username" required>
                        </div>
                        <div class="form-group mt-3">
                            <input type="password" class="form-control border border-danger" placeholder="******" name="password" required>
                        </div>
                        <div class="form-group mt-3">
                            <input type="hidden" class="form-control" name="function" value="login">
                        </div>
                        <button type="submit" class="btn btn-link">Anmelden</button>';
            } else {
                echo '<div class="form-group">
                            <input type="text" class="form-control" placeholder="Benutzer" name="username" required>
                        </div>
                        <div class="form-group mt-3">
                            <input type="password" class="form-control" placeholder="******" name="password" required>
                        </div>
                        <div class="form-group mt-3">
                            <input type="hidden" class="form-control" name="function" value="login">
                        </div>
                        <button type="submit" class="btn btn-link">Anmelden</button>';
            }
        ?>
    </form>
</fieldset>