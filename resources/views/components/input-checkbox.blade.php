@props([
    'checked' => false,
    'disabled' => false,
    'color' => 'blue'
])

<input 
    type="checkbox"
    @checked($checked)

    {{ $attributes->merge([
        'class' => "h-4 w-4 accent-$color checked:bg-$color checked:focus:bg-$color checked:hover:bg-$color checked:border-$color-600 checked:outline-$color checked:border-$color"
]) }}
/>