<div class="form-group mx-sm-3 mb-2">
    <div class="input-group mb-2">
        <div class="input-group-prepend">
            <div class="input-group-text"><i class="far fa-calendar-alt"></i> </div>
        </div>

        <select id="ano" type="text" class="form-control @error('ano') is-invalid @enderror" name="ano" autocomplete="ano">
            <option selected disabled>-- Selecione --</option>

            @foreach($_anos as $_ano)
            <option value="{{ __($_ano) }}" @if ( old('ano', $filtro['ano'] ?? '' )==$_ano ) {{ 'selected' }} @endif>{{ __($_ano) }}</option>
            @endforeach

        </select>
    </div>
    @error('ano')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<button type="submit" class="btn btn-dark mb-3">
    <i class="fas fa-search"></i>
    {{ __('Definir Ano') }}
</button>