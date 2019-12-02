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
                                <input class="form-control" type="text" placeholder="Vorname" name="firstName" required>
                            </label>
                        </div>
                        <div class="form-group w-100">
                            <label> Nachname:
                                <input class="form-control" type="text" placeholder="Nachname" name="lastName" required>
                            </label>
                        </div>
                        <div class="form-group w-100">
                            <label> Geburtstag:
                                <input class="form-control" type="date" placeholder="Nachname" name="birthday" required>
                            </label>
                        </div>
                        <div class="form-group w-100">
                            <label> E-Mail:
                                <input class="form-control" type="email" placeholder="E-Mail" name="email" required>
                            </label>
                        </div>
                        <div class="form-group w-100">
                            <label> Rolle:
                                <select name="role" class="form-control">
                                    <option value="Studenten">Student</option>
                                    <option value="Mitarbeiter">Mitarbeiter</option>
                                    <option value="Gaeste">Gast</option>
                                </select>
                            </label>
                        </div>
                        <div class="form-group w-100">
                            <label> Benutzername:
                                <input type="text" class="form-control" placeholder="Benutzername" name="username" required>
                            </label>
                        </div>
                        <div class="form-group w-100">
                            <label> Passwort:
                                <input type="password" class="form-control" placeholder="Passwort" name="password" required>
                            </label>
                        </div>
                        <input type="hidden" name="registered" value="true">
                        <button class="btn btn-primary" type="submit" id="btnRegister">Registrieren</button>
                    </form>
                </div>
                <div class="col-3"></div>
            </div>
        </fieldset>
    </div>
    <div class="col-4"></div>
</div>
