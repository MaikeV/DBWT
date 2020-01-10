@extends('pages.master')
@section('content')
    <main>
        <div class="container-fluid mb-xl-5">
            <div class="row mb-3 text-left ml-5 text-warning">
                <div class="col-3"></div>
                <div class="col-9">
                    @if($cat != "")
                        <h1>Verfuegbare Speisen ({{ $heading['Bezeichnung'] }})</h1>
                    @else
                        <h1>Verfuegbare Speisen (Bestseller)</h1>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <fieldset class="border border-primary p-5">
                        <legend class="text-warning text-center w-auto"> Speisenliste filtern </legend>
                        <form class="align-content-center justify-content-center p-5" method="get" target="_self">
                            <div class="row">
                                <select class="form-control" name="cat">
                                    <optgroup label="Generell">
                                        <option value="">Alle Anzeigen</option>
                                    </optgroup>
                                    @foreach($categories as $category)
                                        @if($category['general'] == null)
                                            <optgroup label="{{$category['Bezeichnung']}}"></optgroup>
                                            @foreach($categories as $special )
                                                @if($special['general'] != null && $special['general'] == $category['ID'])
                                                    @if($special['ID'] == $cat)
                                                        <option value="{{ $special['ID'] }}" selected>{{$special['Bezeichnung']}}</option>
                                                    @else
                                                        <option value="{{ $special['ID'] }}">{{$special['Bezeichnung']}}</option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-8">
                                    <div class="form-check text-warning mt-5 mx-auto align-content-center justify-content-center text-left">
                                        <input class="form-check-input" type="checkbox" id="avail" value="1" @if ($avail == 1) checked="checked" @endif name="avail">
                                        <label for="avail">nur verfuegbare</label>
                                        <br>
                                        <input class="form-check-input" type="checkbox" id="veggie" value="1" @if ($veggie == 1) checked="checked" @endif name="veggie">
                                        <label for="veggie">nur vegetarische</label>
                                        <br>
                                        <input class="form-check-input" type="checkbox" id="vegan" value="1" @if ($vegan == 1) checked="checked" @endif name="vegan">
                                        <label for="vegan">nur vegane</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5 justify-content-center">
                                <div class="col-8">
                                    <button class="btn btn-primary">Speisen filtern</button>
                                </div>
                            </div>
                        </form>
                    </fieldset>
                </div>
                <div class="col-9 text-warning text-center justify-content-center">
                    <div class="row mb-3">
                        @foreach($meals as $meal)
                            @if ($meal['Verfuegbar'] == true)
                                <div class="col-3 ">
                                <img src="data:image/jpeg;base64,{{$meal['Binaerdaten']}}" class="rounded imgPreview" alt="{{ $meal['Alt-Text'] }}"><br>
                                <a>{{ $meal['Name'] }}</a><br>
                                <a href="details/{{ $meal['ID'] }}"  class="details">Details</a></div>
                            @else
                                <div class="col-3 soldOut">
                                <img src="data:image/jpeg;base64,{{ $meal['Binaerdaten'] }}" class="rounded border border-danger imgPreview" alt="{{ $meal['Alt-Text'] }}"><br>
                                <a>{{ $meal['Name'] }}</a><br>
                                <a class="details">vergriffen</a></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
