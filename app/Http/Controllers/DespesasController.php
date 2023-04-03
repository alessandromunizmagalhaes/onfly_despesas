<?php

namespace App\Http\Controllers;

use App\Models\Despesas;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class DespesasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        return Inertia::render('Despesas/Index', [
            'despesas' => Despesas::with('user:id,name')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {        
        // valida dados da requisição
        $validated = $request->validate([
            'descricao' => 'required|string|max:255',
            'date' => 'required|date',
            'valor' => 'required|numeric',
        ]);

        // insere na tabela despesas e cria relacionamento com usuarios.
        $request->user()->despesas()->create([
            'desp_descricao' => $validated['descricao'], 
            'desp_data' => Carbon::createFromFormat('Y-m-d', $validated['date']), 
            'desp_valor' => $validated['valor'] 
        ]);
 
        return redirect(route('despesas.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Despesas  $despesas
     * @return \Illuminate\Http\Response
     */
    public function show(Despesas $despesas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Despesas  $despesas
     * @return \Illuminate\Http\Response
     */
    public function edit(Despesas $despesas)
    {
        //
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Despesas  $despesas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Despesas $despesa): RedirectResponse
    { 
        // valida dados da requisição
        $validated = $request->validate([
            'descricao' => 'required|string|max:255',
            'date' => 'required|date',
            'valor' => 'required|numeric',
        ]);

        // atualiza dados validados
        $despesa->update([
            'desp_descricao' => $validated['descricao'], 
            'desp_data' => Carbon::createFromFormat('Y-m-d', $validated['date']), 
            'desp_valor' => $validated['valor'] 
        ]);
 
        return redirect(route('despesas.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Despesas  $despesas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Despesas $despesa): RedirectResponse
    { 
        $despesa->delete();
 
        return redirect(route('despesas.index'));
    }
}
