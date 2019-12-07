<main>
    <div class="row">
        <div class="col-1"></div>
        <div class="col-5 text-warning">
            <h1>Zutatenliste ({{ $count['count'] }})</h1>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <form action="http://www.google.de/search" method="get" target="_blank">
                <table class="text-warning table table-dark">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">Nr.</th>
                            <th scope="col">Name</th>
                            <th scope="col">Bio</th>
                            <th scope="col">Vegetarisch</th>
                            <th scope="col">Vegan</th>
                            <th scope="col">Glutenfrei</th>
                        </tr>
                    </thead>
                    <tbody class="align-content-center text-center align-self-center">
                        @foreach($allIngredients as $ingredient)
                            <tr>
                                <td>{{ $ingredient['ID'] }}</td>
                                <td>
                                    <button type="submit" name="q" class="btn btn-link text-warning" value="{{ $ingredient['Name'] }}"
                                            data-toggle="tooltip" data-placement="right" title="Suchen Sie nach {{$ingredient['Name']}} im Web">
                                            {{ $ingredient['Name'] }}
                                    </button>
                                </td>
                                @if($ingredient['Bio'] == 1 )
                                    <td><img src="../img/fontawesome-free-5.11.2-desktop/svgs/solid/check.svg" class="imgIngIcons" alt="Icon"></td>
                                @else
                                    <td><img src="../img/fontawesome-free-5.11.2-desktop/svgs/solid/times.svg" class="imgIngIcons" alt="Icon"></td>
                                @endif
                                @if($ingredient['Vegetarisch'] == 1 )
                                    <td><img src="../img/fontawesome-free-5.11.2-desktop/svgs/solid/check.svg" class="imgIngIcons" alt="Icon"></td>
                                @else
                                    <td><img src="../img/fontawesome-free-5.11.2-desktop/svgs/solid/times.svg" class="imgIngIcons" alt="Icon"></td>
                                @endif
                                @if($ingredient['Vegan'] == 1 )
                                    <td><img src="../img/fontawesome-free-5.11.2-desktop/svgs/solid/check.svg" class="imgIngIcons" alt="Icon"></td>
                                @else
                                    <td><img src="../img/fontawesome-free-5.11.2-desktop/svgs/solid/times.svg" class="imgIngIcons" alt="Icon"></td>
                                @endif
                                @if($ingredient['Glutenfrei'] == 1 )
                                    <td><img src="../img/fontawesome-free-5.11.2-desktop/svgs/solid/check.svg" class="imgIngIcons" alt="Icon"></td>
                                @else
                                    <td><img src="../img/fontawesome-free-5.11.2-desktop/svgs/solid/times.svg" class="imgIngIcons" alt="Icon"></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
        <div class="col-1"></div>
    </div>
</main>
