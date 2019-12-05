<main>
    @if($registered == true) {
        @if(register($username, $email, $password, $firstName, $lastName, $birthday, $role, $remoteConnection)) {
            <p class="text-warning">Sie haben sich erfolgreich registriert. Weiter zur <a href="Start.blade.php">Startseite</a></p>
        @else
            $_POST['registered'] = false;
            <p class="text-warning">Registrierung Fehlgeschlagen. <a href="Registration.php">Versuchen Sie es erneut</a></p>
        @endif
    @else
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <fieldset class="border border-primary p-5 w-100">
                    <legend class="text-warning text-center w-auto"> Registrieren </legend>
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-6">
                            <form method="post" target="_self" class="text-warning align-content-center justify-content-center">
                                <div class="form-group w-100">
                                    <label> Vorname:
                                        <input class="form-control" type="text" placeholder="Vorname" name="firstName" value="{{$firstName or ''}}" required>
                                    </label>
                                </div>
                                <div class="form-group w-100">
                                    <label> Nachname:
                                        <input class="form-control" type="text" placeholder="Nachname" name="lastName" value="{{$lastName or ''}}" required>
                                    </label>
                                </div>
                                <div class="form-group w-100">
                                    <label> Geburtstag:
                                        <input class="form-control" type="date" placeholder="Nachname" name="birthday" value="{{$birthday or ''}}" required>
                                    </label>
                                </div>
                                <div class="form-group w-100">
                                    <label> E-Mail:
                                        <input class="form-control" type="email" placeholder="E-Mail" name="email" value="{{$email or ''}}" required>
                                    </label>
                                </div>
                                <div class="form-group w-100">
                                    <label> Benutzername:
                                        <input type="text" class="form-control" placeholder="Benutzername" name="username" value="{{$username or ''}}" required>
                                    </label>
                                </div>
                                <div class="form-group w-100">
                                    <label> Passwort:
                                        <input type="password" class="form-control" placeholder="Passwort" name="password" value="{{$password or ''}}" required>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="student" value="Studenten" checked>
                                    <label class="form-check-label" for="student">Student</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="employee" value="Mitarbeiter">
                                    <label class="form-check-label" for="employee">Mitarbeiter</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="guest" value="Gaeste">
                                    <label class="form-check-label" for="guest">Gast</label>
                                </div>
                                @yield('registrationStudents')
                                @switch($role)
                                    @case("Studenten")
                                        @yield('registrationStudents')
                                    @break
                                    @case("Mitarbeiter")
                                        @yield('registrationEmployees')
                                    @break
                                    @case("Gaeste")
                                        @yield('registrationGuest')
                                @endswitch
                                <input type="hidden" name="roleSelection" value="true">
                                <button class="btn btn-primary mt-3" type="submit" id="btnRegister"> @if($role == '') Registrierung fortsetzen @else Registrieren @endif</button>
                            </form>
                        </div>
                        <div class="col-3"></div>
                    </div>
                </fieldset>
            </div>
            <div class="col-4"></div>
        </div>
    @endif
</main>