@props(['status'])

@if ($status)
    <div {{ $attributes->merge([
        'class' => 'mb-4 rounded-xl border border-brand-neutral bg-brand-soft/10 px-4 py-3 text-sm font-semibold text-brand-primary'
    ]) }}>
        {{ $status }}
    </div>
@endif
