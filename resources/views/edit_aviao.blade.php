<x-layouts.main-layout pageTitle="Editar Avião">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="row">
                    <div class="col">
                        <p class="display-6 mb-0">Editar Avião</p>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('home') }}" class="btn btn-outline-danger">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </div>
                </div>
                <form action="{{ route('editAviaoSubmit') }}" method="post">
                    @csrf
                    <input type="hidden" name="avion_id" value="{{Crypt::encrypt($aviao->id)}}">
                    {{-- Upload centralizado (círculo/retângulo) --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome do Avião</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{old('name', $aviao->nome)}}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="model" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="model" name="model" value="{{old('model', $aviao->model)}}">
                        @error('model')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="airline" class="form-label">Companhia Aérea</label>
                        <input type="text" class="form-control" id="airline" name="airline" value="{{old('airline', $aviao->airline)}}">
                        @error('airline')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Capacidade</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" value="{{old('capacity', $aviao->capacity)}}">
                        @error('capacity')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="d-flex justify-content-center my-3">
                                <label class="upload-dropzone" data-role="dropzone" aria-label="Selecionar imagem">
                                    <img alt="" />
                                    <div class="placeholder">
                                        <i class="fa-solid fa-camera fa-2x mb-2"></i>
                                        <div>Clique ou arraste uma imagem</div>
                                        <small class="text-muted">PNG/JPG até 2 MB</small>
                                    </div>
                                </label>
                                <input type="file" id="image" name="image" class="d-none" accept="image/*">
                            </div>
                            @error('image')
                                <div class="text-danger text-center">{{ $message }}</div>
                            @enderror --}}

                    <div class="row mt-4">
                        <div class="col text-end">
                            <a href="{{ route('home') }}" class="btn btn-primary px-5"><i
                                    class="fa-solid fa-ban me-2"></i>Cancel</a>
                            <button type="submit" class="btn btn-secondary px-5">Update</button>
                        </div>
                    </div>

                </form>
                @if (@session('server_error'))
                    <div class="alert alert-danger text-center mt-3">
                        {{ session('server_error') }}
                    </div>
                @endif
                @if (@session('success'))
                    <div class="alert alert-success text-center mt-3">
                        {{ session('success') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-layouts.main-layout>
