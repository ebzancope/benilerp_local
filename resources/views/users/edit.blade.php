@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row row-sm row-timeline pd-5">
        <div class="col-lg-8 offset-lg-2">
            <div class="card pd-15" style="border-radius: 10px">
                <div class="timeline-group">
                    <div class="row row-sm row-timeline">
                        <div class="col-lg-12"
                            style="border-radius: 2%;background-color: #f6faf4; color: rgb(90, 86, 86); padding: 15px">
                            <div class="row mb-4">
                                <div class="col-md-12 section-title fst-italic" style="color: #30a300; ">
                                    <h2><i class="fas fa-user-edit"></i> Editar Usuário</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-body">
                            <form action="{{ route('users.update', $user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- Upload de Foto -->
                                        <div class="form-group text-center">
                                            <div class="avatar-upload mb-4">
                                                <div class="avatar-preview mb-3">
                                                    <div id="imagePreview"
                                                        style="width: 150px; height: 150px; border-radius: 50%; margin: 0 auto; background-color: #f0f0f0; background-image: url('{{ $user->photo ? asset('../storage/app/public/' . $user->photo) : '' }}'); background-size: cover; background-position: center; background-repeat: no-repeat; display: flex; align-items: center; justify-content: center; font-size: 48px; color: #666;">
                                                        @if(!$user->photo)
                                                        <i class="fas fa-user"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="avatar-edit">
                                                    <input type="file" id="photo" name="photo"
                                                        accept=".png, .jpg, .jpeg, .gif" class="d-none">
                                                    <label for="photo" class="btn btn-primary rounded-pill">
                                                        <i class="fas fa-camera"></i> Alterar Foto
                                                    </label>
                                                    @if($user->photo)
                                                    <button type="button" class="btn btn-danger rounded-pill mt-2"
                                                        id="removePhoto">
                                                        <i class="fas fa-trash"></i> Remover
                                                    </button>
                                                    @endif
                                                </div>
                                                @error('photo')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <!-- Dados do Usuário -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Nome Completo *</label>
                                                    <input type="text"
                                                        class="form-control rounded-pill @error('name') is-invalid @enderror"
                                                        id="name" name="name" value="{{ old('name', $user->name) }}"
                                                        required>
                                                    @error('name')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="email">Email *</label>
                                                    <input type="email"
                                                        class="form-control rounded-pill @error('email') is-invalid @enderror"
                                                        id="email" name="email" value="{{ old('email', $user->email) }}"
                                                        required>
                                                    @error('email')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="access_level">Nível de Acesso *</label>
                                                    <select
                                                        class="form-control rounded-pill @error('access_level') is-invalid @enderror"
                                                        id="access_level" name="access_level" required>
                                                        <option value="">Selecione...</option>
                                                        @foreach($accessLevels as $key => $level)
                                                        <option value="{{ $key }}" {{ old('access_level', $user->
                                                            access_level) == $key ? 'selected' : '' }}>
                                                            {{ $level }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('access_level')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="approved">Status de Aprovação</label>
                                                    <select class="form-control rounded-pill" id="approved"
                                                        name="approved">
                                                        <option value="1" {{ old('approved', $user->approved) == 1 ?
                                                            'selected' : '' }}>Aprovado</option>
                                                        <option value="0" {{ old('approved', $user->approved) == 0 ?
                                                            'selected' : '' }}>Aguardando Aprovação</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <div class="card">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0">Alterar Senha</h6>
                                                        <small class="text-muted">Deixe em branco para manter a senha
                                                            atual</small>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="password">Nova Senha</label>
                                                                    <input type="password"
                                                                        class="form-control rounded-pill @error('password') is-invalid @enderror"
                                                                        id="password" name="password">
                                                                    @error('password')
                                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="password_confirmation">Confirmar Nova
                                                                        Senha</label>
                                                                    <input type="password"
                                                                        class="form-control rounded-pill"
                                                                        id="password_confirmation"
                                                                        name="password_confirmation">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Estatísticas do Usuário -->
                                            <div class="col-md-12 mt-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="card bg-light">
                                                            <div class="card-body">
                                                                <h6><i class="fas fa-calendar-check"></i> Cadastrado em
                                                                </h6>
                                                                <p class="mb-0">{{ $user->created_at->format('d/m/Y
                                                                    H:i') }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card bg-light">
                                                            <div class="card-body">
                                                                <h6><i class="fas fa-sign-in-alt"></i> Último Acesso
                                                                </h6>
                                                                <p class="mb-0">
                                                                    @if($user->last_login)
                                                                    {{
                                                                    \Carbon\Carbon::parse($user->last_login)->format('d/m/Y
                                                                    H:i') }}
                                                                    <br>
                                                                    <small>Total de acessos: {{ $user->login_count ?? 0
                                                                        }}</small>
                                                                    @else
                                                                    Nunca acessou
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12 text-right">
                                        <a href="{{ route('users.index') }}"
                                            class="btn btn-secondary rounded-pill mr-2">
                                            <i class="fas fa-times"></i> Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-success rounded-pill">
                                            <i class="fas fa-save"></i> Atualizar Usuário
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- timeline-group -->
            </div><!-- card -->
        </div><!-- col-lg-8 -->
    </div><!-- row -->
</div><!-- container-fluid -->

<style>
    .avatar-upload {
        position: relative;
    }

    .avatar-preview {
        border: 2px dashed #ddd;
        border-radius: 50%;
        padding: 10px;
        width: 150px;
        height: 150px;
        margin: 0 auto;
    }

    #imagePreview {
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preview da imagem
        const photoInput = document.getElementById('photo');
        const imagePreview = document.getElementById('imagePreview');

        photoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.style.backgroundImage = `url(${e.target.result})`;
                    imagePreview.innerHTML = '';
                }
                reader.readAsDataURL(file);
            }
        });

        // Remover foto
        const removePhotoBtn = document.getElementById('removePhoto');
        if (removePhotoBtn) {
            removePhotoBtn.addEventListener('click', function() {
                imagePreview.style.backgroundImage = '';
                imagePreview.innerHTML = '<i class="fas fa-user"></i>';
                // Adicionar campo hidden para remover foto
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'remove_photo';
                hiddenInput.value = '1';
                document.querySelector('form').appendChild(hiddenInput);
            });
        }

        // Validação de email
        const emailInput = document.getElementById('email');
        emailInput.addEventListener('blur', function() {
            const email = this.value;
            if (email && !validateEmail(email)) {
                this.classList.add('is-invalid');
                let errorSpan = this.nextElementSibling;
                if (!errorSpan || !errorSpan.classList.contains('invalid-feedback')) {
                    errorSpan = document.createElement('span');
                    errorSpan.className = 'invalid-feedback';
                    errorSpan.innerHTML = 'Email inválido';
                    this.parentNode.appendChild(errorSpan);
                }
            }
        });

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    });
</script>
@endsection