<x-layouts.main-layout pageTitle="Home">
<div class="w-100 p-4">

    <h3>Listagem de Aviões</h3>

    <hr>

    @if(count($avios) == 0)
        <div class="text-center">
            <p>Nenhum avião encontrado.</p>
            <a href="#" class="btn btn-primary">Registar Novo Avião</a>
        </div>
    @else

<div class="div container">
    <div class="mb-3">
        <a href="#" class="btn btn-primary">Registar Novo Avião</a>
    </div>
    <table class="table w-70" id="table">
        <thead class="table-dark">
            <th>Imaguem</th>
            <th>Modelo</th>
            <th>Compania</th>
            <td>Capacidade</td>
            <td>Data Criação</td>
            <td>Criado Por</td>
            <th></th>
        </thead>
        <tbody>
            <tr>
                <td>Imagem</td>
                <td>Modelo</td>
                <td>Compania</td>
                <td>Capacidade</td>
                <td>Data Criação</td>
                <td>Criado Por</td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <a href="#" class="btn btn-sm btn-outline-dark"><i class="fa-regular fa-pen-to-square me-2"></i>Edit</a>
                        <a href="#" class="btn btn-sm btn-outline-dark"><i class="fa-regular fa-trash-can me-2"></i>Delete</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Imagem</td>
                <td>Modelo</td>
                <td>Compania</td>
                <td>Capacidade</td>
                <td>Data Criação</td>
                <td>Criado Por</td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <a href="#" class="btn btn-sm btn-outline-dark"><i class="fa-regular fa-pen-to-square me-2"></i>Edit</a>
                        <a href="#" class="btn btn-sm btn-outline-dark"><i class="fa-regular fa-trash-can me-2"></i>Delete</a>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
    @endif
</div>
</x-layouts.main-layout>

