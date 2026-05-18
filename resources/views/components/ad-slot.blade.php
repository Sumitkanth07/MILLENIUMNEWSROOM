@props(['ads' => collect(), 'placement' => '', 'label' => 'Advertisement'])
@php($ad = $ads[$placement] ?? null)
<div class="portal-ad portal-ad-{{ $placement }}" aria-label="{{ $label }}">
    @if($ad?->code)
        {!! $ad->code !!}
    @else
        <span>{{ $label }}</span>
    @endif
</div>
