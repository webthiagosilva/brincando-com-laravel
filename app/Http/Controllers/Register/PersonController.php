<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use App\Http\Requests\Person\PersonCreateRequest;
use App\Http\Requests\Person\PersonUpdateRequest;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('register.person.index', [
            'people' => Person::customPaginate(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Person\PersonCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonCreateRequest $request)
    {
        $person = new Person();

        $person->nome = $request->input('name');
        $person->cpf = $request->input('cpf');
        $person->endereco = $request->input('address');

        $person->save();

        return redirect()->route('person.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        return view('register.person.index', [
            'person' => $person,
            'people' => Person::customPaginate(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Person\PersonUpdateRequest  $request
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(PersonUpdateRequest $request, Person $person)
    {
        Person::query()
            ->where('id', $person->getKey())
            ->update([
                'nome' => $request->input('name', $person->nome),
                'cpf' => preg_replace('/\D/', '', $request->input('cpf', $person->cpf)),
                'endereco' => $request->input('address', $person->endereco)
            ]);

        return redirect()->route('person.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        Person::query()
            ->where('id', $person->getKey())
            ->delete();

        return redirect()->route('person.index');
    }
}
