<div class="form-group row">
    <div class="col-md-6">
        <label for="escola" class="col-form-label">{{ __('* Escola') }}</label>

        <input id="escola" type="text" class="form-control @error('escola') is-invalid @enderror" name="escola" value="{{ old('escola', $escola->escola ?? '') }}" autocomplete="escola" autofocus required maxlength="254">

        @error('escola')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="prefeitura" class="col-form-label">{{ __('* Prefeitura') }}</label>

        <input id="prefeitura" type="text" class="form-control @error('prefeitura') is-invalid @enderror" name="prefeitura" value="{{ old('prefeitura', $escola->prefeitura ?? '' ) }}" autocomplete="prefeitura" required maxlength="254">

        @error('prefeitura')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-6">
        <label for="secretaria" class="col-form-label">{{ __('* Secretaria') }}</label>

        <input id="secretaria" type="text" class="form-control @error('secretaria') is-invalid @enderror" name="secretaria" value="{{ old('secretaria', $escola->secretaria ?? '') }}" required autocomplete="secretaria" maxlength="254">

        @error('secretaria')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="email" class="col-form-label text-md-right">{{ __('E-Mail') }}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $escola->email ?? '') }}" autocomplete="email">

        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-3">
        <label for="telefone" class="col-form-label">{{ __('Telefone') }}</label>
        <input id="telefone" type="text" class="mask_telefone form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ old('telefone', $escola->telefone ?? '') }}" autocomplete="telefone">

        @error('telefone')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>