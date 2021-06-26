<div class="@if($type === 'hidden') hidden @else mt-4 @endif">
    <label class="block">
        <x-form-label :label="$label" />
        {{ $attributes->get('required') ? '*' : '' }}

        <input {!! $attributes->merge([
            'class' => 'block w-full ' . ($label ? 'mt-1' : '') . ' ' . $fieldClass
        ]) !!}
            @if($isWired())
                wire:model{!! $wireModifier() !!}="{{ $name }}"
            @else
                name="{{ $name }}"
                value="{{ $value }}"
            @endif

            type="{{ $type }}" />
    </label>

    @if($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>