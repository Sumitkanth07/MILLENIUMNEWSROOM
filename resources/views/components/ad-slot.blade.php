@props(['ads' => collect(), 'placement' => '', 'label' => 'Advertisement'])
@php($ad = $ads[$placement] ?? null)
<div class="portal-ad portal-ad-{{ $placement }}">
    @if($ad?->code)
        {!! $ad->code !!}
    @else
        <span>{{ $label }}</span>
    @endif
</div>
