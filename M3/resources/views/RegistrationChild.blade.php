@extends('pages.Registration')

@section('roleControl')
    @parent
    @switch($role)
        @case("Studenten")
            <fieldset>
                <h4>Ihr Fachbereich:</h4>
                <label> Welchem Fachbereich gehoeren Sie an?
                    <select name="field" class="form-control" required>
                        @foreach($fields as $field)
                            <option value="{{ $field['ID'] }}">{{ $field['Name'] }}</option>
                        @endforeach
                    </select>
                </label>
                <h4 class="mt-3">Ihre Studentendaten: </h4>
                <div class="form-group">
                    <label> Matrikelnummer:
                        <input class="form-control" type="number" min="10000000" max="999999999" placeholder="Matrikelnummer" name="matrikel" value="{{$matrikel or ''}}" required>
                    </label>
                </div>
                <div class="form-group">
                    <label> Studiengang:
                        <select name="studies" class="form-control" required>
                            <option value="INF" @if($studies == "INF") selected @endif>Informatik</option>
                            <option value="ET" @if($studies == "ET") selected @endif>Elektrotechnik</option>
                            <option value="WI" @if($studies == "WI") selected @endif>Wirtschaftsinformatik</option>
                            <option value="MCD" @if($studies == "MCD") selected @endif>MCD</option>
                            <option value="ISE" @if($studies == "ISE") selected @endif>Information System Engineer</option>
                        </select>
                    </label>
                </div>
            </fieldset>
            <input type="hidden" name="registered" value="true">
        @break
        @case("Mitarbeiter")
            <div class="form-group">
                <label> Raum:
                    <input class="form-control" type="text" placeholder="Raum" name="room" value="{{$room or ''}}" required>
                </label>
            </div>
            <div class="form-group">
                <label> Telefon:
                    <input class="form-control" type="text" placeholder="Telefon" name="phone" value="{{$phone or ''}}" required>
                </label>
            </div>
            <input type="hidden" name="registered" value="true">
        @break
        @case("Gaeste")
            <div class="form-group">
                <label> Grund:
                    <input placeholder="Grund des Aufenthaltes..." name="reason" value="{{$reason or ''}}" required >
                </label>
            </div>
            <div class="form-group">
                <label> Grund:
                    <input name="endDate" type="date" value="{{$endDate or ''}}" required >
                </label>
            </div>
            <input type="hidden" name="registered" value="true">
    @endswitch
@stop
