@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-brand-neutral bg-white text-gray-900 placeholder:text-gray-400 rounded-xl shadow-sm
                focus:border-brand-primary focus:ring-brand-primary/30
                disabled:opacity-60 disabled:cursor-not-allowed'
]) !!}>
