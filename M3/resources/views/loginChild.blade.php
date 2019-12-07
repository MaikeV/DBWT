@if(basename($_SERVER['PHP_SELF']) == 'Login.php')
    @extends('pages.Login')
@elseif(basename($_SERVER['PHP_SELF']) == 'Details.php')
    @extends('pages.Details')
@endif

@section('login')
    @parent

    <fieldset class="border border-primary p-5">
        <legend class="text-warning text-center w-auto"> Login </legend>
        <form target="_self" method="post">
            @if ($loggedIn == "true" && $visited == "true")
                <p class="text-warning">Hallo {{ $username }} Sie sind angemeldet als {{ $role }} </p>
                <div class="form-group mt-3">
                    <input type="hidden" class="form-control" name="function" value="logout">
                </div>
                <button class="btn btn-primary" type="submit">Logout</button>
            @elseif ($loggedIn == "false" && $visited == "true")
                <p class="text-danger">Das hat leider nicht geklappt, bitte versuchen Sie es nochmal.</p>
                <div class="form-group">
                    <input type="text" class="form-control border border-danger" placeholder="Benutzer" name="username" required>
                </div>
                <div class="form-group mt-3">
                    <input type="password" class="form-control border border-danger" placeholder="******" name="password" required>
                </div>
                <div class="form-group mt-3">
                    <input type="hidden" class="form-control" name="function" value="login">
                </div>
                <button type="submit" class="btn btn-primary">Anmelden</button>
            @else
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Benutzer" name="username" required>
                </div>
                <div class="form-group mt-3">
                    <input type="password" class="form-control" placeholder="******" name="password" required>
                </div>
                <div class="form-group mt-3">
                    <input type="hidden" class="form-control" name="function" value="login">
                </div>
                <button type="submit" class="btn btn-primary">Anmelden</button>
            @endif
        </form>
    </fieldset>
@endsection