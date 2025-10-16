<x-layouts.main-layout pageTitle="Home">
<div class="w-100 p-4">

    <h3>Listagem de Aviões</h3>

    <hr>

    @if(count($avios) == 0)
        <div class="text-center">
            <p>Nenhum avião encontrado.</p>
            <a href="{{route('new')}}" class="btn btn-primary">Registar Novo Avião</a>
        </div>
    @else

<div class="div container">
    <div class="mb-3">
        <a href="{{route('new')}}" class="btn btn-primary">Registar Novo Avião</a>
    </div>

    <table class="table table-hover w-70" id="table">
        <thead class="table-dark">
            <th>Imaguem</th>
            <th>Nome</th>
            <th>Modelo</th>
            <th>Compania</th>
            <td>Capacidade</td>
            <td>Criado Por</td>
             <td>Data Criação/Atualização</td>
            <th></th>
        </thead>
        <tbody>
            @foreach ($avios as $aviao)
            <tr>

<td class="text-center align-middle">
    <img src=""
         {{-- alt="Imagem do avião" --}}
         class="rounded-circle border shadow-sm"
         style="width: 50px; height: 50px;"/></td>
                <td>{{$aviao['nome']}}</td>
                <td>{{$aviao['model']}}</td>
                <td>{{$aviao['airline']}}</td>
                <td>{{$aviao['capacity']}}</td>
                <td>User1</td>
                 @if($aviao['created_at'] != $aviao['updated_at'])
                <td>{{date('Y-m-d H:i:s', strtotime($aviao['updated_at']))}}</td>
                @else
                <td>{{date('Y-m-d H:i:s', strtotime($aviao['created_at']))}}</td>
                 @endif
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <a href="{{ route('edit', ['id' => Crypt::encrypt($aviao['id'])])}}" class="btn btn-sm btn-secondary"><i class="fa-regular fa-pen-to-square me-2"></i>Edit</a>
                        <a href="{{ route('delete', ['id' => Crypt::encrypt($aviao['id'])])}}" class="btn btn-sm btn-secondary"><i class="fa-regular fa-trash-can me-2"></i>Delete</a>
                    </div>
                </td>
            </tr>
         @endforeach
        </tbody>
    </table>
    </div>
    @endif
</div>
</x-layouts.main-layout>

