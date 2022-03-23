@extends('layouts.app')

@section('title', 'Contact Nou')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card pb-3">
                <div class="card-header">Contact Nou</div>

                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-primary alert-dismissible fade show mesaj" role="alert">
                            {!! session()->get('message') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    {{-- form --}}
                    <form action="{{ route('contacts.store') }}" method="POST">
                        @csrf

                        {{-- nume --}}
                        <div class="form-group mt-2">
                            <label for="nume">Nume <span style="color: red">*</span></label>
                            <input type="text" id="nume" class="form-control @error('nume') is-invalid @enderror" name="nume" autocomplete="off" placeholder="ex. Popescu" value="{{old('nume')}}">
                            @error('nume')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- prenume --}}
                        <div class="form-group mt-2">
                            <label for="prenume">Prenume <span style="color: red">*</span></label>
                            <input type="text" id="prenume" class="form-control @error('prenume') is-invalid @enderror" name="prenume" autocomplete="off" placeholder="ex. Ion" value="{{old('prenume')}}">
                            @error('prenume')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- email --}}
                        <div class="form-group mt-2">
                            <label for="email">Adresa de e-mail <span style="color: red">*</span></label>
                            <input type="text" id="email" class="form-control @error('email') is-invalid @enderror" name="email" autocomplete="off" placeholder="ex .popescu.ion@gmail.com" value="{{old('email')}}">
                            @error('email')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- sex --}}
                        <div class="form-group mt-2">
                            <label for="sex">Sexul <span style="color: red">*</span></label>
                            <select name="sex" id="sex" class="form-select form-control @error('sex') is-invalid @enderror">
                                <option selected disabled>Alege sexul</option>
                                <option value="M" @if( old('sex') == 'M') selected @endif>Masculin</option>
                                <option value="F" @if( old('sex') == 'F') selected @endif>Feminim</option>
                            </select>
                            @error('sex')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- cnp --}}
                        <div class="form-group">
                            <label for="cnp">CNP</label>
                            <input type="text" id="cnp" class="form-control @error('cnp') is-invalid @enderror" name="cnp" autocomplete="off" placeholder="Codul Numeric Personal" value="{{old('cnp')}}" maxlength="13">
                            @error('cnp')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        
                        {{-- data_nastere --}}
                        <div class="form-group">
                            <label for="data_nastere">Data nasterii</label>
                            <input type="text" id="data_nastere" class="form-control datepicker @error('data_nastere') is-invalid @enderror" name="data_nastere" autocomplete="off" placeholder="AAAA-LL-ZZ" value="{{old('data_nastere')}}" readonly>
                            @error('data_nastere')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- nr telefon --}}                        
                        @if(old('telefon') != '')

                            <div class="mt-3">
                                <label for="telefon">Nr. de telefon (<span id="countTelefon">{{ count(old('telefon')) }}</span>) </label>
                            </div>

                            <div id="telefon_box" class="form-group">
                                @foreach(old('telefon') as $key => $value)

                                    <div class="telefon_item" data-id="{{($key == 0) ? $key+1 : $key}}">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control form-control-sm @error('telefon.'.$key) is-invalid @enderror" name="telefon[{{$key}}]" value="{{ old('telefon.'.$key) }}" autocomplete="off" placeholder="07XXXXXXXX" maxlength="10">
                                            <button class="btn btn-sm btn-danger minus" type="button"><i class="bi bi-trash"></i></button>

                                            @error('telefon.'.$key)
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>  
                                    </div>
                            
                                @endforeach
                            </div>


                        @else

                            <div class="mt-3">
                                <label for="telefon">Nr. de telefon (<span id="countTelefon">1</span>) </label>
                            </div>

                            <div id="telefon_box" class="form-group">

                                <div class="telefon_item" data-id="1">

                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control form-control-sm" name="telefon[1]" autocomplete="off" placeholder="07XXXXXXXX" maxlength="10">
                                        <button class="btn btn-sm btn-danger minus" type="button"><i class="bi bi-trash"></i></button>
                                    </div>

                                </div>

                            </div>
                            
                        @endif
 
                        <button class="btn btn-sm btn-light plus" type="button"><i class="bi bi-telephone-plus-fill"></i> Adauga nr. de telefon</button>

                        <div class="form-group d-flex justify-content-between mt-4">
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('index') }}">&laquo; inapoi</a>
                            <button type="submit" class="btn btn-sm btn-success" id="submit">Salveaza</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('body_js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.ro.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.datepicker').datepicker({
            endDate: new Date(),
            startView: 2,
            autoclose: true,
            format: 'yyyy-mm-dd',  
            language: 'ro',
            orientation: 'bottom'
        });

        countTelefonItems();
                
    });

    function countTelefonItems() {
        var count = $(".telefon_item").length;
        
        $("#countTelefon").html(count);
    }

    $(document).on('click', '.plus', function() { 
        var i =  $('#telefon_box .telefon_item:last').data('id');
        i = i+1;
        
        $('#telefon_box').append(
            '<div class="telefon_item" data-id="'+ i +'">\
                <div class="input-group mb-2">\
                    <input type="text" class="form-control form-control-sm" name="telefon['+ i +']" autocomplete="off" placeholder="07XXXXXXXX" maxlength="10">\
                    <button class="btn btn-sm btn-danger minus" type="button"><i class="bi bi-trash"></i></button>\
                </div>\
            </div>'
        );

        setTimeout(countTelefonItems(), 300);
    });

    $(document).on('click', '.minus', function() {

        $(this).closest('.telefon_item').remove();

        setTimeout(countTelefonItems(), 300);
    });



</script>
@endsection