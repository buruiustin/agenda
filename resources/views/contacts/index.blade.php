@extends('layouts.app')

@section('title', 'Acasa')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12">
            <div class="card pb-3">
                <div class="card-header d-flex justify-content-between">
                    <div>Toate Contactele</div>
                    <a href="{{ route('contacts.create') }}" class="btn btn-sm btn-success"><i class="bi bi-person-plus-fill"></i> Adauga Contact Nou</a>
                </div>

                <div class="card-body">
                    
                    @if(session()->has('message'))
                        <div class="alert alert-primary alert-dismissible fade show mesaj" role="alert">
                            {!! session()->get('message') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table id="table" class="table table-striped table-bordered" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nume</th>
                                    <th>Prenume</th>
                                    <th>Adresa de e-mail</th>
                                    <th>Sexul</th>
                                    <th>CNP</th>
                                    <th>Data nasterii</th>
                                    <th>Nr de telefon</th>
                                    <th>TS</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            @foreach ($contacts as $k => $contact)
                                <tr>
                                    <td>{{++$k}}</td>
                                    <td>{{ $contact->nume }}</td>
                                    <td>{{ $contact->prenume }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>
                                        @switch($contact->sex)
                                            @case('M')
                                                Masculin
                                                @break
                                            @case('F')
                                                Feminim
                                                @break
                                        @endswitch
                                    </td>
                                    <td>{{ $contact->cnp }}</td>
                                    <td>{{ $contact->data_nastere }}</td>
                                    <td>
                                        @forelse ($contact->phones as $phone)
                                            0{{$phone->number}}<br />
                                        @empty
                                            -
                                        @endforelse
                                    </td>
                                    <td>{{ $contact->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-between" style="width: 130px;">
                                            <a href="{{ route('contacts.edit', $contact->id)}}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pen"></i> Edit</a>

                                            <form class="d-inline"  method="POST" action="{{ route('contacts.destroy', $contact->id) }}">
                                                @csrf @method('delete')
                                                <button type="submit" class="btn btn-sm btn-outline-danger delete"><i class="bi bi-trash"></i> Sterge</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            

                        </table>
                    </div>
    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('body_js')
<script>
    $(document).ready(function() {
		$('.delete').on('click', function(e) {
			e.preventDefault();
			if (confirm('Confirma stergerea!')) {
				// Save it!
				$(this).parent('form').submit();
			}
		});

        $('#table').DataTable({
            paging: true,
            pagingType: "numbers",
            aoColumnDefs: [
                { "bSortable": false, "aTargets": [8] },
                { "bSearchable": false, "aTargets": [8] }
            ],
            info : false,
            responsive: true,
            language: {
                "emptyTable":     "Nu sunt date de afisat!",
                "lengthMenu":     "_MENU_",
                "search":         "Cauta:",
                "zeroRecords":    "Nici un rezultat!",
            }
        });

        
	});
</script>
@endsection
