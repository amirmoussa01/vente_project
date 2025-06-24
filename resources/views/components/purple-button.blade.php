<div>
    <!-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh -->
    <button {{ $attributes->merge([
        'class' => $outline
            ? 'border border-purple-700 text-purple-700 hover:bg-purple-100'
            : 'bg-purple-700 hover:bg-purple-800 text-white'
    ]) }}>
        {{ $slot }}
    </button>
</div>