@extends('pages.Registration')

@section('registrationStudents')

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
        <input type="hidden" name="registered" value="true">

@endsection

@section('registrationEmployees')
    <fieldset>
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
    </fieldset>
@endsection

@section('registrationGuest')
    <fieldset>
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
    </fieldset>
@endsection