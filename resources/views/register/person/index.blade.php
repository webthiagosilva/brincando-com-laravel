@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('person.person') }}</div>

                    <div class="card-body">
                        @if (empty($person))
                            <form method="POST" action="{{ route('person.store') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">{{ __('person.name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" name="name" type="text" maxlength="200"
                                            class="form-control" value="{{ old('name') }}" oninput="capitalize(this);"
                                            required autofocus>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="cpf"
                                        class="col-md-4 col-form-label text-md-right">{{ __('CPF') }}</label>

                                    <div class="col-md-6">
                                        <input id="cpf" name="cpf" type="text" maxlength="14"
                                            class="form-control" onkeypress="applyCpfMask(event);" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address"
                                        class="col-md-4 col-form-label text-md-right">{{ __('person.address') }}</label>

                                    <div class="col-md-6">
                                        <input id="address" type="text" class="form-control" name="address" required>
                                    </div>
                                </div>

                                {{-- alligin this for to center --}}

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('person.register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <form method="POST" action="{{ route('person.update', $person->id) }}">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">{{ __('person.name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" name="name" type="text" maxlength="200"
                                            class="form-control" value="{{ $person->nome }}" oninput="capitalize(this);"
                                            required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="cpf"
                                        class="col-md-4 col-form-label text-md-right">{{ __('CPF') }}</label>

                                    <div class="col-md-6">
                                        <input id="cpf" name="cpf" type="text" maxlength="14"
                                            class="form-control" value="{{ $person->getCpfAttribute() }}"
                                            onkeypress="applyCpfMask(event);" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address"
                                        class="col-md-4 col-form-label text-md-right">{{ __('person.address') }}</label>

                                    <div class="col-md-6">
                                        <input id="address" type="text" class="form-control" name="address"
                                            value="{{ $person->endereco }}" required>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('person.register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif

                        <!-- separator -->
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>

                        <!-- grid to show the list of people -->
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('person.name') }}</th>
                                            <th scope="col">{{ __('CPF') }}</th>
                                            <th scope="col">{{ __('person.address') }}</th>
                                            <th scope="col">{{ __('person.edit') }}</th>
                                            <th scope="col">{{ __('person.remove') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($people as $person)
                                            <tr>
                                                <td>{{ $person->nome }}</td>
                                                <td>{{ $person->getCpfAttribute() }}</td>
                                                <td>{{ $person->endereco }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('person.show', $person->id) }}">
                                                        @csrf
                                                        <div class="form-check form-check-inline">
                                                            <input type="hidden" name="_method" value="GET">
                                                            <input id="update" name="update" type="radio"
                                                                class="form-check-input" onclick="this.form.submit()">
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form method="POST"
                                                        action="{{ route('person.delete', $person->id) }}">
                                                        @csrf
                                                        <div class="form-check form-check-inline">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="radio" class="form-check-input" name="delete"
                                                                id="delete" data-toggle="modal"
                                                                onclick="if(!confirm('Tem certeza que deseja excluir esta pessoa ?')){return false;} this.form.submit();">
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <nav aria-label="page navigation">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item {{ $people->currentPage() == 1 ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $people->previousPageUrl() }}"
                                                tabindex="-1">{{__('pagination.previous')}}</a>
                                        </li>
                                        @for ($i = 1; $i <= $people->lastPage(); $i++)
                                            <li class="page-item {{ $people->currentPage() == $i ? 'active' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $people->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor
                                        <li class="page-item {{ $people->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $people->nextPageUrl() }}">{{__('pagination.next')}}</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
