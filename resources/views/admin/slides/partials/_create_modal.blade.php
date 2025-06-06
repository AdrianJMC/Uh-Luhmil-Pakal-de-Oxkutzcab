{{-- Modal de creación de slide con estilo personalizado --}}
<div class="modal fade" id="modalCrearSlide" tabindex="-1" aria-labelledby="modalCrearSlideLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content slide-form-card">
            {{-- Header con color personalizado y botón cerrar --}}
            <div class="slide-form-card-header d-flex justify-content-between align-items-center">
                <h2 class="modal-title m-0" id="modalCrearSlideLabel">Crear nuevo slide</h2>
                <button type="button" class="btn-close-custom" data-dismiss="modal" aria-label="Cerrar">&times;</button>
            </div>

            <div class="slide-form-card-body">
                <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row gx-3 gy-2">
                        <div class="col-md-6">
                            <label for="titulo" class="slide-form-label">Título</label>
                            <input type="text" name="titulo" id="titulo"
                                class="slide-form-input form-control @error('titulo') is-invalid @enderror"
                                value="{{ old('titulo') }}" required>
                            @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="orden" class="slide-form-label">Orden</label>
                            <input type="number" name="orden" id="orden"
                                class="slide-form-input form-control @error('orden') is-invalid @enderror"
                                value="{{ old('orden', 0) }}" required>
                            @error('orden')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="descripcion" class="slide-form-label">Descripción</label>
                            <textarea name="descripcion" id="descripcion" rows="2"
                                class="slide-form-input form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion') }}</textarea>
                            @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="imagen" class="slide-form-label">Imagen <small class="text-muted">(obligatoria)</small></label>
                            <input type="file" name="imagen" id="imagen"
                                class="slide-form-file form-control @error('imagen') is-invalid @enderror"
                                required accept="image/*">
                            @error('imagen')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-success me-2">Crear Slide</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
