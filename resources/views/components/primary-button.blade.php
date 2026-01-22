@props(['disabled' => false])

<button {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center justify-center rounded-xl bg-brand-primary px-4 py-2.5 text-sm font-semibold text-white shadow-sm
                hover:bg-brand-primary/90 transition
                focus:outline-none focus:ring-2 focus:ring-brand-primary/30 focus:ring-offset-2
                disabled:opacity-60 disabled:cursor-not-allowed'
]) !!}>
    {{ $slot }}
</button>
