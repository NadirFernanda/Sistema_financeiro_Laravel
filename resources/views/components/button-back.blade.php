@props(['href' => url()->previous(), 'label' => 'Voltar'])
<a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn btn-back']) }}>
    <i class="bi bi-arrow-left" style="margin-right:6px;"></i> {{ $label }}
</a>
<style>
.btn-back{ display:inline-flex; align-items:center; gap:6px; padding:8px 12px; border-radius:6px; background:var(--btn-bg, #fff); color:var(--btn-color, #333); box-shadow:var(--btn-shadow, 0 1px 4px rgba(0,0,0,0.06)); border:1px solid rgba(0,0,0,0.06); text-decoration:none; }
.btn-back:hover{ transform:translateY(-1px); }
</style>